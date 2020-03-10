<?php namespace App\Http\Controllers;
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
    protected $payment, $invoice,$paymentmethod;
    public function __construct(Payment $payment, PaymentMethod $paymentmethod, Invoice $invoice){
        $this->payment = $payment;
        $this->paymentmethod = $paymentmethod;
        $this->invoice = $invoice;
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
            $payments = $model::with(['invoice','payment_method'])->select('uuid','invoice_id','payment_date','amount','method')->ordered();
            return Datatables::of($payments)
                ->editColumn('number', function($data){ return '<a href="'.route('invoices.show', $data->invoice_id).'">'.$data->invoice->number.'</a>'; })
                ->editColumn('client', function($data){ return '<a href="'.route('clients.show', $data->invoice->client_id).'">'.$data->invoice->client->name.'</a>'; })
                ->editColumn('payment_method', function($data){ return $data->payment_method->name; })
                ->editColumn('amount', function($data){
                    return '<span style="display:inline-block">'.$data->invoice->currency.'</span> <span style="display:inline-block"> '.format_amount($data->amount).'</span>';
                })
                ->addColumn('action', '
                     @if(hasPermission(\'edit_payment\')){!! edit_btn(\'payments.edit\', $uuid) !!}@endif
                     @if(hasPermission(\'delete_payment\')){!! delete_btn(\'payments.destroy\', $uuid) !!}@endif
                ')->make(true);
        }else {
            return view('payments.index');
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



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if(!hasPermission('edit_payment', true)) return redirect('payments');
        $methods = $this->paymentmethod->paymentMethodSelect();
		$payment = $this->payment->with('invoice')->getById($id);
        return view('payments.edit', compact('payment','methods'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(PaymentFormRequest $request, $id)
	{
        $payment = [
            'payment_date' => date('Y-m-d', strtotime($request->get('payment_date'))),
            'amount' => $request->get('amount'),
            'method' => $request->get('method'),
            'notes' => $request->get('notes')
        ];
        if($request->get('invoice_id') != ''){
            $payment['invoice_id'] = $request->get('invoice_id');
        }

        if($this->payment->updateById($id, $payment)){
            $payment = $this->payment->getById($id);
            $this->invoice->changeStatus($payment->invoice_id);
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success' => true, 'msg' => trans('application.record_updated')), 200);
        }
        return Response::json(array('success' => false, 'msg' => trans('application.record_update_failed')), 400);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!hasPermission('delete_payment', true)) return redirect('payments');
        $payment = $this->payment->getById($id);
        if($this->payment->deleteById($id)){
            Flash::success(trans('application.record_deleted'));
            $this->invoice->changeStatus($payment->invoice_id);
        }
        else {
            Flash::error(trans('application.record_deletion_failed'));
        }
        return redirect('payments');
	}

}
