<?php namespace App\Http\Controllers\ClientArea;
use App\Http\Requests\PaymentFormRequest;
use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\PaymentMethodInterface as PaymentMethod;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;

class PaymentsController extends Controller {
    protected $payment, $invoice,$paymentmethod,$logged_user;
    public function __construct(Payment $payment, PaymentMethod $paymentmethod, Invoice $invoice){
        $this->payment = $payment;
        $this->paymentmethod = $paymentmethod;
        $this->invoice = $invoice;
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
        if (Request::ajax()){
            $model = $this->payment->model();
            $payments = $model::join('invoices', 'payments.invoice_id', '=', 'invoices.uuid')->where('invoices.client_id',$this->logged_user)->select('payments.uuid','invoices.client_id','invoice_id','payment_date','payments.notes','amount','method');
            return Datatables::of($payments)
                ->editColumn('number', function($data){ return '<a href="'.route('cinvoices.show', $data->invoice_id).'">'.$data->invoice->number.'</a>'; })
                ->editColumn('payment_method', function($data){ return $data->payment_method->name; })
                ->editColumn('amount', function($data){
                    return '<span style="display:inline-block">'.$data->invoice->currency.'</span> <span style="display:inline-block"> '.format_amount($data->amount).'</span>';
                })
                ->make(true);
        }else {
            return view('clientarea.payments.index');
        }
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if(!hasPermission('add_payment', true)) return redirect('payments');
        $invoice_id = Input::get('invoice_id');
        if($invoice_id){
            $invoice = $this->invoice->with('client')->getById($invoice_id);
            $invoice->totals = $this->invoice->invoiceTotals($invoice_id);
        }
        else
            $invoice = null;
        $methods = $this->paymentmethod->paymentMethodSelect();
		return view('payments.create', compact('methods','invoice'));
	}

    /**
     * Store a newly created resource in storage.
     * @param PaymentFormRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(PaymentFormRequest $request)
	{
		$payment = [
            'invoice_id' => $request->get('invoice_id'),
            'payment_date' => date('Y-m-d', strtotime($request->get('payment_date'))),
            'amount' => $request->get('amount'),
            'method' => $request->get('method'),
            'notes' => $request->get('notes')
        ];

        if($this->payment->create($payment)){
            $this->invoice->changeStatus($request->get('invoice_id'));
            Flash::success(trans('application.record_created'));
            return Response::json(array('success' => true, 'msg' => trans('application.record_created')), 200);
        }
        return Response::json(array('success' => false, 'msg' => trans('application.record_creation_failed')), 400);
	}
}
