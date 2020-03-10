<?php namespace App\Http\Controllers\ClientArea;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\ExpenseInterface as Expense;
class HomeController extends Controller {
    protected $invoice, $product, $client, $estimate, $payment, $expense;
    /**
     * Create a new controller instance.
     */
    public function __construct(Invoice $invoice, Product $product, Client $client, Estimate $estimate, Payment $payment, Expense $expense)
	{
        $this->invoice      = $invoice;
        $this->product      = $product;
        $this->client       = $client;
        $this->estimate     = $estimate;
        $this->payment      = $payment;
        $this->expense      = $expense;
	}
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
	    $logged_user = auth()->guard('user')->user()->uuid;
        $invoices = $this->invoice->where('client_id',$logged_user)->count();
        $estimates = $this->estimate->where('client_id',$logged_user)->count();
        $recentInvoices = $this->invoice->with('client')->where('client_id',$logged_user)->limit(10)->get();
        foreach($recentInvoices as $count => $invoice){
            $recentInvoices[$count]['totals'] = $this->invoice->invoiceTotals($invoice->uuid);
        }
        $recentEstimates = $this->estimate->with('client')->where('client_id',$logged_user)->limit(10)->get();
        foreach($recentEstimates as $count => $estimate){
            $recentEstimates[$count]['totals'] = $this->estimate->estimateTotals($estimate->uuid);
        }
        $invoice_stats['unpaid']        = $this->invoice->where('status', getStatus('status', 'unpaid'))->where('client_id',$logged_user)->count();
        $invoice_stats['paid']          = $this->invoice->where('status', getStatus('status', 'paid'))->where('client_id',$logged_user)->count();
        $invoice_stats['partiallyPaid'] = $this->invoice->where('status', getStatus('status', 'partially_paid'))->where('client_id',$logged_user)->count();
        $invoice_stats['overdue']       = $this->invoice->where('status', getStatus('status', 'overdue'))->where('client_id',$logged_user)->count();
        $total_outstanding              = $this->invoice->totalClientUnpaidAmount($logged_user);
        $invoices_payments = $this->invoice->with('payments')->where('client_id',$logged_user)->get();
        $total_payments = 0;
        foreach ($invoices_payments as $invoice){
            foreach ($invoice->payments as $payment){
                $total_payments += currency_convert(getCurrencyId($invoice->currency),$payment->amount);
            }
        }
        $total_payments = defaultCurrency(true).format_amount($total_payments);
		return view('clientarea.home', compact('invoices','estimates','recentInvoices','recentEstimates', 'invoice_stats','total_payments','total_outstanding'));
	}
}
