<?php
namespace App\Http\Controllers\ClientArea;
use App\Http\Requests\ClientAreaCheckoutRequest;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\InvoiceSettingInterface as InvoiceSetting;
use App\Invoicer\Repositories\Contracts\SettingInterface as Setting;
use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\PaymentMethodInterface as PaymentMethod;
use Flash;
use Redirect;
use Illuminate\Http\Request;
class CheckoutController extends Controller{
    protected $invoice,$invoiceSetting,$setting,$payment,$paymentMethod;
    public function __construct(Invoice $invoice, Setting $setting, InvoiceSetting $invoiceSetting,Payment $payment,PaymentMethod $paymentMethod){
        $this->invoiceSetting = $invoiceSetting;
        $this->payment = $payment;
        $this->paymentMethod = $paymentMethod;
        $this->invoice = $invoice;
        $this->setting   = $setting;
    }
    public function getCheckout(ClientAreaCheckoutRequest $request){
        if (auth()->guard('user')->user()){
            $invoice_id = $request->invoice_id;
            $invoice = $this->invoice->getById($invoice_id);
            $invoice_totals = $this->invoice->invoiceTotals($invoice_id);
            $selected_method = $request->selected_method;
            if($selected_method == 'paypal' && config('services.paypal.status') == 1){
                $paypal_id = config('services.paypal.account');
                $paypal_url = config('services.paypal.mode') == 'sandbox' ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
                return view('clientarea.payment_methods.paypal', compact('invoice','invoice_totals','paypal_id','paypal_url'));
            }else{
                return redirect()->route('stripecheckout',$invoice_id);
            }
        }
    }
    public function stripeCheckout($invoice_id){
        $invoice = $this->invoice->getById($invoice_id);
        $invoiceSettings = $this->invoiceSetting->first();
        $invoice->totals = $this->invoice->invoiceTotals($invoice_id);
        $stripe_key = config('services.stripe.key');
        $settings = $this->setting->first();
        return view('clientarea.payment_methods.stripe', compact('invoice','invoiceSettings','settings','stripe_key'));
    }
    public function stripeSuccess(Request $request){
        $payment_method_model = $this->paymentMethod->model();
        $payment_method = $payment_method_model::where('name','Stripe')->first();
        if(!$payment_method){
            $payment_method = $payment_method_model::create(['name'=>'Stripe']);
        }
        $payment_data = [
            'invoice_id' => $request->get('invoice_id'),
            'payment_date' => date('Y-m-d'),
            'amount' => $request->get('amount'),
            'method' => $payment_method->uuid,
            'notes' => 'Transaction Id : '.$request->get('stripeToken')
        ];
        if($this->payment->create($payment_data)) {
            $this->invoice->changeStatus($request->get('invoice_id'));
        }
        Flash::success(trans('application.payment_successful'));
        return redirect()->route('cinvoices.show', $request->invoice_id);
    }
    public function paypalNotify(Request $request){
        $txn_id = $request->txn_id;
        $invoice_id = $request->item_number;
        $payment_method_model = $this->paymentMethod->model();
        $payment_method = $payment_method_model::where('name','Paypal')->first();
        if(!$payment_method){
            $payment_method = $payment_method_model::create(['name'=>'Paypal']);
        }
        $payment_data = [
            'invoice_id' => $invoice_id,
            'payment_date' => date('Y-m-d'),
            'amount' => $request->payment_gross,
            'method' => $payment_method->uuid,
            'notes' => 'Transaction id : '.$txn_id
        ];
        if($this->payment->create($payment_data)) {
            $this->invoice->changeStatus($invoice_id);
        }
    }
    public function getDone(Request $request){
        if(isset($request->payment_status) && $request->payment_status == 'Completed'){
            $notes = 'Transaction id : '.$request->txn_id;
            $invoice_id = $request->item_number;
            $payment_model = $this->payment->model();
            $payment_record = $payment_model::where('notes',$notes)->where('invoice_id',$invoice_id)->first();
            if(!$payment_record){
                $payment_method_model = $this->paymentMethod->model();
                $payment_method = $payment_method_model::where('name','Paypal')->first();
                if(!$payment_method){
                    $payment_method = $payment_method_model::create(['name'=>'Paypal']);
                }
                $payment_data = [
                    'invoice_id' => $invoice_id,
                    'payment_date' => date('Y-m-d'),
                    'amount' => $request->payment_gross,
                    'method' => $payment_method->uuid,
                    'notes' => $notes
                ];
                if($this->payment->create($payment_data)) {
                    $this->invoice->changeStatus($invoice_id);
                }
            }
            Flash::success(trans('application.payment_successful'));
        }else{
            Flash::success(trans('application.payment_failed'));
        }
        return redirect()->route('cinvoices.show', $invoice_id);
    }
    public function getCancel($invoice_id){
        Flash::error(trans('application.payment_cancelled'));
        return redirect()->route('cinvoices.show', $invoice_id);
    }
}
