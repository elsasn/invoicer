<?php namespace App\Http\Controllers;

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
        $clients = $this->client->count();
        $invoices = $this->invoice->count();
        $estimates = $this->estimate->count();
        $products = $this->product->count();
        $recentInvoices = $this->invoice->with('client')->limit(10)->get();
        foreach($recentInvoices as $count => $invoice){
            $recentInvoices[$count]['totals'] = $this->invoice->invoiceTotals($invoice->uuid);
        }
        $recentEstimates = $this->estimate->with('client')->limit(10)->get();
        foreach($recentEstimates as $count => $estimate){
            $recentEstimates[$count]['totals'] = $this->estimate->estimateTotals($estimate->uuid);
        }

        $invoice_stats['unpaid']        = $this->invoice->where('status', getStatus('status', 'unpaid'))->count();
        $invoice_stats['paid']          = $this->invoice->where('status', getStatus('status', 'paid'))->count();
        $invoice_stats['partiallyPaid'] = $this->invoice->where('status', getStatus('status', 'partially_paid'))->count();
        $invoice_stats['overdue']       = $this->invoice->where('status', getStatus('status', 'overdue'))->count();
        $total_payments                 = $this->payment->totalIncome();
        $total_outstanding              = $this->invoice->totalUnpaidAmount();
        $income                         = $this->payment->yearlyIncome();
        $expense                        = $this->expense->totalExpenses();

        $payments = array();
        $payment_model = $this->payment->model();
        foreach($income as $payment){
            if($payment->payments_count > 0) {
                $client_payments = $payment_model::join('invoices', 'invoices.uuid', '=' , 'payments.invoice_id')->whereMonth('payment_date',$payment->month_num)->get();
                $month_payments_totals = 0;
                foreach($client_payments as $monthly_payment){
                    $month_payments_totals += str_replace(',','',currency_convert(getCurrencyId($monthly_payment->currency),$monthly_payment->amount));
                }
                array_push($payments, $month_payments_totals);
            }else{
                array_push($payments, 0);
            }
        }
        $yearly_income = json_encode($payments, JSON_HEX_QUOT | JSON_HEX_APOS);
        $expenses = array();
        foreach($expense[0] as $month=>$expense) {
            array_push($expenses, $expense);
        }
        $yearly_expense = json_encode($expenses, JSON_HEX_QUOT | JSON_HEX_APOS);
        return view('home', compact('clients','invoices','products','estimates','recentInvoices','recentEstimates', 'invoice_stats','yearly_income','yearly_expense','total_payments','total_outstanding'));
    }
}
