<?php namespace App\Http\Controllers;

use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\ExpenseInterface as Expense;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\CurrencyInterface as Currency;
use App\Invoicer\Repositories\Contracts\ExpenseCategoryInterface as ExpenseCategory;
use Illuminate\Support\Facades\Input;


class ReportsController extends Controller {

    protected $invoices,$payments,$estimates,$expenses, $client,$currency,$expense_category;
    /**
     * @param Invoice $invoice
     * @param Payment $payment
     * @param Estimate $estimate
     * @param Expense $expense
     */
    public function __construct(Invoice $invoice, Payment $payment, Estimate $estimate,Expense $expense, Client $client, Currency $currency, ExpenseCategory $expense_category){
        $this->invoices = $invoice;
        $this->payments = $payment;
        $this->estimates = $estimate;
        $this->expenses = $expense;
        $this->client   = $client;
        $this->currency   = $currency;
        $this->expense_category   = $expense_category;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('reports.index', compact('yearly_income','yearly_expense','total_payments','total_outstanding'));
	}
    /*---------------------------------------------------------------------------------------------------------
    | Function to display general report
    |----------------------------------------------------------------------------------------------------------*/
    public function general_summary(){
        $total_payments                 = $this->payments->totalIncome();
        $total_outstanding              = $this->invoices->totalUnpaidAmount();
        $income                         = $this->payments->yearlyIncome();
        $expense                        = $this->expenses->totalExpenses();

        $payments = array();
        $payment_model = $this->payments->model();
        foreach($income as $payment){
            if($payment->payments_count > 0) {
                $client_payments = $payment_model::join('invoices', 'invoices.uuid', '=' , 'payments.invoice_id')->whereMonth('payment_date',$payment->month_num)->get();
                $month_payments_totals = 0;
                foreach($client_payments as $monthly_payment){
                    $month_payments_totals += format_amount(str_replace(',','',currency_convert(getCurrencyId($monthly_payment->currency),$monthly_payment->amount)));
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
        return view('reports.general_summary', compact('yearly_income','yearly_expense','total_payments','total_outstanding'))->render();
    }
    /*---------------------------------------------------------------------------------------------------------
    | Function to display payment summary report
    |----------------------------------------------------------------------------------------------------------*/
    public function payment_summary(){
        $client     = Input::get('client');
        $from_date  = Input::get('from_date');
        $to_date    = Input::get('to_date');

        $payments   = $this->payments->payment_summary($client, $from_date, $to_date);
        $clients    = $this->client->clientSelect();
        return view('reports.payments_summary', compact('client','payments','clients'))->render();
    }
    /*---------------------------------------------------------------------------------------------------------
    | Function to display client statement report
    |----------------------------------------------------------------------------------------------------------*/
    public function client_statement(){
        $client     = Input::get('client');
        $invoices   = $this->invoices->where('client_id', $client)->get();
        $counter = 0;
        $statement = array();
        foreach($invoices as $invoice){
            $invoice_totals = $this->invoices->invoiceTotals($invoice->uuid);
            $statement[$counter]['date']		=	$invoice->invoice_date;
            $statement[$counter]['activity']	=	'Invoice Generated (#'.$invoice->number.')';
            $statement[$counter]['amount']		=	$invoice_totals['grandTotalUnformatted'];
            $statement[$counter]['currency']	=	$invoice->currency;
            $statement[$counter]['transaction_type'] = 'invoice';
            $counter++;
            $payments = $this->payments->where('invoice_id', $invoice->uuid)->get();
            foreach($payments as $payment){
                $statement[$counter]['date']		=	$payment->payment_date;
                $statement[$counter]['activity']	=	'Payment Received (#'.$invoice->number.')';
                $statement[$counter]['amount']		=	$payment->amount;
                $statement[$counter]['currency']	=	$invoice->currency;
                $statement[$counter]['transaction_type'] = 'payment';
                $counter++;
            }
        }

        $statement = array_multi_subsort($statement, 'date');
        $clients    = $this->client->clientSelect();
        return view('reports.client_statement', compact('client','clients', 'statement'))->render();
    }
    /*---------------------------------------------------------------------------------------------------------
    | Function to display invoices report
    |----------------------------------------------------------------------------------------------------------*/
    public function invoices_report(){
        $client     = Input::get('client');
        $invoices   = $this->invoices->where('client_id', $client)->get();
        foreach($invoices as $count => $invoice){
            $invoices[$count]['totals'] = $this->invoices->invoiceTotals($invoice->uuid);
        }
        $clients    = $this->client->clientSelect();
        return view('reports.invoices_report', compact('client','clients', 'invoices'))->render();
    }
    /*---------------------------------------------------------------------------------------------------------
    | Function to display expenses report
    |----------------------------------------------------------------------------------------------------------*/
    public function expenses_report(){
        $from_date  = Input::get('from_date');
        $to_date    = Input::get('to_date');
        $category   = Input::get('category');

        $expenses   = $this->expenses->expenses_report($category, $from_date, $to_date);
        $clients    = $this->client->clientSelect();
        $categories = $this->expense_category->categorySelect();
        return view('reports.expenses_report', compact('category','clients','categories','expenses', 'invoices'))->render();
    }
}
