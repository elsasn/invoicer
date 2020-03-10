<?php namespace App\Http\Controllers\ClientArea;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use Illuminate\Support\Facades\Input;
class ReportsController extends Controller {
    protected $invoices,$payments,$estimates, $client,$logged_user;
    /**
     * @param Invoice $invoice
     * @param Payment $payment
     * @param Estimate $estimate
     * @param Expense $expense
     */
    public function __construct(Invoice $invoice, Payment $payment, Estimate $estimate, Client $client){
        $this->invoices = $invoice;
        $this->payments = $payment;
        $this->estimates = $estimate;
        $this->client   = $client;
        $this->middleware(function ($request, $next) {
            $this->logged_user = auth()->guard('user')->user()->uuid;
            return $next($request);
        });
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('clientarea.reports.index', compact('yearly_income','yearly_expense','total_payments','total_outstanding'));
	}
    /*---------------------------------------------------------------------------------------------------------
    | Function to display general report
    |----------------------------------------------------------------------------------------------------------*/
    public function general_summary(){
        $total_payments                 = $this->payments->clientTotalPaid($this->logged_user);
        $total_outstanding              = $this->invoices->totalClientUnpaidAmount($this->logged_user,false);
        $income                         = $this->payments->clientYearlyIncome($this->logged_user);
        $invoices                       = $this->payments->clientYearlyInvoices($this->logged_user);
        $payments = array();
        $payment_model = $this->payments->model();
        foreach($income as $payment){
            if($payment->payments_count > 0) {
                $client_payments = $payment_model::join('invoices', 'invoices.uuid', '=' , 'payments.invoice_id')->whereMonth('payment_date',$payment->month_num)->where('invoices.client_id',$this->logged_user)->get();
                $month_payments_totals = 0;
                foreach($client_payments as $monthly_payment){
                    $month_payments_totals += str_replace(',','',currency_convert(getCurrencyId($monthly_payment->currency),$monthly_payment->amount));
                }
                array_push($payments, $month_payments_totals);
            }else{
                array_push($payments, 0);
            }
        }
        $bills = array();
        $invoice_model = $this->invoices->model();
        foreach($invoices as $invoice){
            if($invoice->invoice_count > 0){
                $monthly_invoices = $invoice_model::whereMonth('invoice_date',$invoice->month_num)->where('client_id',$this->logged_user)->get();
                $month_totals = 0;
                foreach($monthly_invoices as $monthly_invoice){
                    $invoice_totals =  $this->invoices->invoiceTotals($monthly_invoice->uuid);
                    $month_totals += str_replace(',','',currency_convert(getCurrencyId($monthly_invoice->currency),$invoice_totals['grandTotal']));
                }
                array_push($bills, $month_totals);
            }else{
                array_push($bills, 0);
            }
        }
        $yearly_income = json_encode($payments, JSON_HEX_QUOT | JSON_HEX_APOS);
        $yearly_invoices = json_encode($bills, JSON_HEX_QUOT | JSON_HEX_APOS);
        return view('clientarea.reports.general_summary', compact('yearly_income','yearly_invoices','total_payments','total_outstanding'))->render();
    }
    /*---------------------------------------------------------------------------------------------------------
    | Function to display payment summary report
    |----------------------------------------------------------------------------------------------------------*/
    public function payment_summary(){
        $client     = $this->logged_user;
        $from_date  = Input::get('from_date');
        $to_date    = Input::get('to_date');
        $payments = $this->payments->payment_summary($client, $from_date, $to_date);
        return view('clientarea.reports.payments_summary', compact('client','payments'))->render();
    }
    /*---------------------------------------------------------------------------------------------------------
    | Function to display client statement report
    |----------------------------------------------------------------------------------------------------------*/
    public function client_statement(){
        $client     = $this->logged_user;
        $invoices   = $this->invoices->where('client_id', $client)->get();
        $counter = 0;
        $statement = array();
        foreach($invoices as $invoice){
            $invoice_totals = $this->invoices->invoiceTotals($invoice->uuid);
            $statement[$counter]['date']		=	$invoice->invoice_date;
            $statement[$counter]['activity']	=	'Invoice Generated (#'.$invoice->number.')';
            $statement[$counter]['amount']		=	$invoice_totals['grandTotalUnformatted'];
            $statement[$counter]['transaction_type'] = 'invoice';
            $statement[$counter]['currency']	=	$invoice->currency;
            $counter++;
            $payments = $this->payments->where('invoice_id', $invoice->uuid)->get();
            foreach($payments as $payment){
                $statement[$counter]['date']		=	$payment->payment_date;
                $statement[$counter]['activity']	=	'Payment Received (#'.$invoice->number.')';
                $statement[$counter]['amount']		=	$payment->amount;
                $statement[$counter]['transaction_type'] = 'payment';
                $statement[$counter]['currency']	=	$invoice->currency;
                $counter++;
            }
        }
        $statement = array_multi_subsort($statement, 'date');
        return view('clientarea.reports.client_statement', compact('client', 'statement'))->render();
    }
    /*---------------------------------------------------------------------------------------------------------
    | Function to display invoices report
    |----------------------------------------------------------------------------------------------------------*/
    public function invoices_report(){
        $client     = $this->logged_user;
        $invoices   = $this->invoices->where('client_id', $client)->get();
        foreach($invoices as $count => $invoice){
            $invoices[$count]['totals'] = $this->invoices->invoiceTotals($invoice->uuid);
        }
        return view('clientarea.reports.invoices_report', compact('client','invoices'))->render();
    }
}
