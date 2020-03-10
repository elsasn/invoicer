<?php namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodFromRequest;
use Illuminate\Http\Request;
use App\Invoicer\Repositories\Contracts\PaymentMethodInterface as Payment;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Config;


class PaymentMethodsController extends Controller{
    private $payment;
    public function __construct(Payment $payment){
        $this->payment = $payment;
        $this->middleware('permission:edit_setting');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $payment_methods = $this->payment->all();
        $paypal_details = config('services.paypal');
        $stripe_details = config('services.stripe');
        return view('settings.payment.index', compact('payment_methods','paypal_details','stripe_details'));
	}
    /**
     * Store a newly created resource in storage.
     * @param PaymentMethodFromRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PaymentMethodFromRequest $request)
	{
		$data = array('name' => $request->name);
        if($this->payment->create($data))
            Flash::success(trans('application.record_created'));
        else
            Flash::error(trans('application.create_failed'));

        return redirect('settings/payment');
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$payment = $this->payment->getById($id);
        return view('settings.payment.edit', compact('payment'));
	}
    /**
     * Update the specified resource in storage.
     * @param PaymentMethodFromRequest $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(PaymentMethodFromRequest $request, $id)
	{
		$data = array('name' => $request->name, 'selected' => $request->selected);

        if($request->selected)
            $this->payment->resetDefault();

        if($this->payment->updateById($id, $data)){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success' => true, 'msg' => 'payment method updated'), 200);
        }
        return Response::json(array('success' => false, 'msg' => 'update failed'), 422);
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if($this->payment->deleteById($id))
            Flash::success(trans('application.record_deleted'));
        else
            Flash::error(trans('application.delete_failed'));
        return redirect('settings/payment');
	}
    public function postPaypalDetails(Request $request){
	    if(!isset($request->id)){
            $this->payment->create(array('name' => 'Paypal'));
        }
	    Config::write('services.paypal', [
	        'client_id'=>$request->client_id,
	        'secret'=>$request->secret_key,
	        'status'=>$request->paypal_status,
	        'account'=>$request->paypal_account,
	        'mode'=>$request->paypal_mode,
        ]);
        Flash::success(trans('application.record_updated'));
        return redirect('settings/payment');
    }
    public function postStripeDetails(Request $request){
        if(!isset($request->id)){
            $this->payment->create(array('name' => 'Stripe'));
        }
        Config::write('services.stripe', [
            'secret'=>$request->stripe_secret,
            'status'=>$request->stripe_status,
            'key'=>$request->stripe_key,
        ]);
        Flash::success(trans('application.record_updated'));
        return redirect('settings/payment');
    }
}
