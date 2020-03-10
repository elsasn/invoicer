<?php
namespace App\Http\Controllers\ClientArea;

class PaymentMethodsController extends Controller
{
    public function __construct(){}
    public function index($invoice_id)
    {
        $paypal_details = config('services.paypal');
        $stripe_details = config('services.stripe');
        return view('clientarea.payment_methods.index', compact('paypal_details','stripe_details','invoice_id'));
    }
}
