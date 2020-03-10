<?php namespace App\Http\Controllers\ClientArea;

use Illuminate\Support\Facades\Request;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\TaxSettingInterface as Tax;
use App\Invoicer\Repositories\Contracts\CurrencyInterface as Currency;
use App\Invoicer\Repositories\Contracts\InvoiceItemInterface as InvoiceItem;
use App\Invoicer\Repositories\Contracts\SettingInterface as Setting;
use App\Invoicer\Repositories\Contracts\NumberSettingInterface as Number;
use App\Invoicer\Repositories\Contracts\InvoiceSettingInterface as InvoiceSetting;
use App\Invoicer\Repositories\Contracts\TemplateInterface as Template;
use App\Invoicer\Repositories\Contracts\EmailSettingInterface as MailSetting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Yajra\Datatables\Facades\Datatables;

class InvoicesController extends Controller {
   protected $product,$client,$tax,$currency,$invoice,$items,$setting,$number,$invoiceSetting, $template, $mail_setting,$logged_user;
   public function __construct(Invoice $invoice, Product $product, Client $client,  Tax $tax, Currency $currency, InvoiceItem $items, Setting $setting, Number $number, InvoiceSetting $invoiceSetting, Template $template, MailSetting $mail_setting){
       $this->invoice   = $invoice;
       $this->product   = $product;
       $this->client    = $client;
       $this->tax       = $tax;
       $this->currency  = $currency;
       $this->items     = $items;
       $this->setting   = $setting;
       $this->number    = $number;
       $this->invoiceSetting = $invoiceSetting;
       $this->template  = $template;
       $this->mail_setting = $mail_setting;
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
        if (Request::ajax()) {
            $model = $this->invoice->model();
            $invoices = $model::with('client')->where('client_id',$this->logged_user)->select('client_id','number','status','due_date','uuid','currency')->ordered();
            return Datatables::of($invoices)
                ->editColumn('status', function($data){ return '<span class="label '.statuses()[$data->status]['class'].'">'.ucwords(statuses()[$data->status]['label']).'</span>'; })
                ->addColumn('grand_total', function($data){
                    $totals = $this->invoice->invoiceTotals($data->uuid);
                    return '<span style="display:inline-block">'.$data->currency.'</span> <span style="display:inline-block"> '.format_amount($totals['grandTotal']).'</span>';
                })->addColumn('paid', function($data){
                    $totals = $this->invoice->invoiceTotals($data->uuid);
                    return '<span style="display:inline-block">'.$data->currency.'</span> <span style="display:inline-block"> '.format_amount($totals['paid']).'</span>';
                })->addColumn('amountDue', function($data){
                    $totals = $this->invoice->invoiceTotals($data->uuid);
                    return '<span style="display:inline-block">'.$data->currency.'</span> <span style="display:inline-block"> '.format_amount($totals['amountDue']).'</span>';
                })->addColumn('action', function($data) {
                    $totals = $this->invoice->invoiceTotals($data->uuid);
                    $action_buttons = '<a href="'.route('invoicepdf',$data->uuid).'" data-rel="tooltip" data-placement="top" title="{{trans(\'application.download_invoice\')}}" class="btn btn-xs btn-primary"><i class="fa fa-download"></i></a> '.
                             show_btn('cinvoices.show', $data->uuid);
                    if($totals['amountDue'] > 0){
                        $action_buttons .= ' <a href="'.url('clientarea/payment_methods',$data->uuid).'" data-rel="tooltip" data-toggle="ajax-modal" data-placement="top" title="{{trans(\'application.add_payment\')}}" class="btn btn-xs btn-warning"><i class="fa fa-usd"></i> </a>';
                    }
                  return $action_buttons;
                })->make(true);
        }else {
            return view('clientarea.invoices.index');
        }
	}
    /**
     * Display the specified resource.
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
	public function show($uuid)
	{
        $invoice = $this->invoice->with('items')->getById($uuid);
        if ($invoice) {
            $settings = $this->setting->first();
            $invoiceSettings = $this->invoiceSetting->first();
            $invoice->totals = $this->invoice->invoiceTotals($uuid);
            return view('clientarea.invoices.show', compact('invoice', 'settings', 'invoiceSettings'));
        }
	}
    /**
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function invoicePdf($uuid){
        $invoice = $this->invoice->with('items')->getById($uuid);
        if($invoice){
            $settings = $this->setting->first();
            $invoiceSettings = $this->invoiceSetting->first();
            $invoice->totals = $this->invoice->invoiceTotals($uuid);
            $pdf = \PDF::loadView('clientarea.invoices.pdf', compact('settings', 'invoice', 'invoiceSettings'));
            return $pdf->download('invoice_'.$invoice->number.'_'.date('Y-m-d').'.pdf');
        }
        return Redirect::route('cinvoices');
    }
}
