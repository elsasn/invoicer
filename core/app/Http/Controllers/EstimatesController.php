<?php namespace App\Http\Controllers;

use App\Http\Requests\EstimateFormRequest;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\EstimateItemInterface as EstimateItem;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\TaxSettingInterface as Tax;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\CurrencyInterface as Currency;
use App\Invoicer\Repositories\Contracts\SettingInterface as Setting;
use App\Invoicer\Repositories\Contracts\NumberSettingInterface as Number;
use App\Invoicer\Repositories\Contracts\TemplateInterface as Template;
use App\Invoicer\Repositories\Contracts\EstimateSettingInterface as EstimateSetting;
use App\Invoicer\Repositories\Contracts\EmailSettingInterface as MailSetting;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\InvoiceSettingInterface as InvoiceSetting;
use App\Invoicer\Repositories\Contracts\InvoiceItemInterface as InvoiceItem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;
use PDF;
use Mail;

class EstimatesController extends Controller {
    protected $product,$tax,$client,$currency,$estimate,$estimateItem,$setting, $number,$template,$estimateSetting,$mail_setting,$invoiceSetting,$invoiceItem,$invoice;
    public function __construct(Product $product,Tax $tax, Client $client, Currency $currency, Estimate $estimate, EstimateItem $estimateItem, Setting $setting, Number $number,Template $template, EstimateSetting $estimateSetting, MailSetting $mail_setting,InvoiceSetting $invoiceSetting,InvoiceItem $invoiceItem,Invoice $invoice ){
        $this->product = $product;
        $this->client = $client;
        $this->currency = $currency;
        $this->tax = $tax;
        $this->estimate = $estimate;
        $this->estimateItem = $estimateItem;
        $this->setting = $setting;
        $this->number = $number;
        $this->template = $template;
        $this->estimateSetting = $estimateSetting;
        $this->mail_setting = $mail_setting;
        $this->invoiceSetting = $invoiceSetting;
        $this->invoiceItem = $invoiceItem;
        $this->invoice = $invoice;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if (Request::ajax()) {
            $model = $this->estimate->model();
            $estimates = $model::with('client')->select('client_id','estimate_no','estimate_date','uuid','currency')->ordered();
            return Datatables::of($estimates)
                ->editColumn('name', function($data){ return '<a href="'.route('clients.show', $data->client_id).'">'.$data->client->name.'</a>'; })
                ->addColumn('amount', function($data){
                    $totals = $this->estimate->estimateTotals($data->uuid);
                    return '<span style="display:inline-block">'.$data->currency.'</span> <span style="display:inline-block"> '.format_amount($totals['grandTotal']).'</span>';
                })->addColumn('action', '
                     <a href="{{ url(\'estimates/pdf\',$uuid) }}" data-rel="tooltip" data-placement="top" title="{{trans(\'application.download_estimate\')}}" class="btn btn-xs btn-primary"><i class="fa fa-download"></i></a>
                     @if(hasPermission(\'view_estimate\'))
                       {!! show_btn(\'estimates.show\', $uuid) !!}
                     @endif
                     @if(hasPermission(\'edit_estimate\'))
                        <a href="{{ route(\'estimates.edit\',$uuid) }}" data-rel="tooltip" data-placement="top" title="{{trans(\'application.edit_estimate\')}}" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                     @endif
                     @if(hasPermission(\'delete_estimate\'))
                        {!! delete_btn(\'estimates.destroy\', $uuid) !!}
                     @endif')->make(true);
        }else {
            return view('estimates.index');
        }
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if(!hasPermission('add_estimate', true)) return redirect('estimates');
        $settings     = $this->estimateSetting->first();
        $start        = $settings ? $settings->start_number : 0;
        $estimate_num = $this->number->prefix('estimate_number', $this->estimate->generateEstimateNum($start));
        $products     = $this->product->productSelect();
        $clients      = $this->client->clientSelect();
        $taxes        = $this->tax->taxSelect();
        $currencies   = $this->currency->currencySelect();
		return view('estimates.create', compact('products', 'taxes', 'currencies', 'clients', 'estimate_num','settings'));
	}
    /**
     * Store a newly created resource in storage.
     * @param EstimateFormRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(EstimateFormRequest $request)
	{
        $estimateData = array(
            'client_id'     => $request->get('client'),
            'estimate_no'   => $request->get('estimate_no'),
            'estimate_date' => date('Y-m-d', strtotime($request->get('estimate_date'))),
            'notes'         => $request->get('notes'),
            'terms'         => $request->get('terms'),
            'currency'      => $request->get('currency')
        );
        $estimate = $this->estimate->create($estimateData);
        if($estimate){
            $items = json_decode($request->get('items'));
            foreach($items as $item_order=>$item){
                $itemsData = array(
                    'estimate_id'           => $estimate->uuid,
                    'item_name'             => $item->item_name,
                    'item_description'      => $item->item_description,
                    'quantity'              => $item->quantity,
                    'price'                 => $item->price,
                    'tax_id'                => $item->tax != '' ? $item->tax : null,
                    'item_order'            => $item_order+1
                );
                $this->estimateItem->create($itemsData);
            }

            $settings     = $this->estimateSetting->first();
            if($settings){
                $start = $settings->start_number+1;
                $this->estimateSetting->updateById($settings->uuid, array('start_number'=>$start));
            }
            return Response::json(array('success' => true,'redirectTo'=>route('estimates.show', $estimate->id), 'msg' => trans('application.record_created')), 200);
        }
        return Response::json(array('success' => false, 'msg' => trans('application.record_creation_failed')), 400);
	}
    /**
     * Display the specified resource.
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($uuid)
	{
        $estimate = $this->estimate->with('items')->getById($uuid);
        if($estimate){
            $settings = $this->setting->first();
            $estimate_settings = $this->estimateSetting->first();
            $estimate->totals = $this->estimate->estimateTotals($uuid);
            return view('estimates.show', compact('estimate', 'settings','estimate_settings'));
        }
        return Redirect::route('estimates');
	}
    /**
     * Show the form for editing the specified resource.
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
	public function edit($uuid)
	{
        if(!hasPermission('edit_estimate', true)) return redirect('estimates');
        $estimate = $this->estimate->with('items')->getById($uuid);
        if($estimate){
            $products = $this->product->productSelect();
            $clients = $this->client->clientSelect();
            $taxes = $this->tax->taxSelect();
            $currencies = $this->currency->currencySelect();
            $estimate->totals = $this->estimate->estimateTotals($uuid);
            return view('estimates.edit', compact('estimate','products', 'taxes', 'currencies', 'clients'));
        }
        return Redirect::route('estimates');
	}
    /**
     * Update the specified resource in storage.
     * @param EstimateFormRequest $request
     * @param $uuid
     * @return \Symfony\Component\HttpFoundation\Response
     */
	public function update(EstimateFormRequest $request, $uuid)
	{
        $estimateData = array(
            'client_id'     => $request->get('client'),
            'estimate_no'   => $request->get('estimate_no'),
            'estimate_date' => date('Y-m-d', strtotime($request->get('estimate_date'))),
            'notes'         => $request->get('notes'),
            'terms'         => $request->get('terms'),
            'currency'      => $request->get('currency')
        );
        $estimate = $this->estimate->updateById($uuid, $estimateData);
        if($estimate){
            $items = json_decode($request->get('items'));
            foreach($items as $item_order=>$item){
                $itemsData = array(
                    'estimate_id'       => $estimate->uuid,
                    'item_name'         => $item->item_name,
                    'item_description'  => $item->item_description,
                    'quantity'          => $item->quantity,
                    'price'             => $item->price,
                    'tax_id'            => $item->tax != '' ? $item->tax : null,
                    'item_order'        => $item_order+1
                );

                if(isset($item->itemId))
                    $this->estimateItem->updateById($item->itemId,$itemsData);
                else
                    $this->estimateItem->create($itemsData);
            }
            return Response::json(array('success' => true,'redirectTo'=>route('estimates.show', $estimate->uuid), 'msg' => trans('application.record_updated')), 200);
        }
        return Response::json(array('success' => false, 'msg' => trans('application.record_update_failed')), 400);
	}
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteItem(){
        $uuid = Input::get('id');
        if($this->estimateItem->deleteById($uuid))
            return Response::json(array('success' => true, 'msg' => trans('application.record_deleted')), 200);

        return Response::json(array('success' => false, 'msg' => trans('application.record_deletion_failed')), 400);
    }
    /**
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function estimatePdf($uuid){
        $estimate = $this->estimate->with('items')->getById($uuid);
        if($estimate){
            $settings = $this->setting->first();
            $estimate_settings = $this->estimateSetting->first();
            $estimate->totals = $this->estimate->estimateTotals($uuid);
            $pdf = PDF::loadView('estimates.pdf', compact('settings', 'estimate','estimate_settings'));
            return $pdf->download('estimate_'.$estimate->estimate_no.'_'.date('Y-m-d').'.pdf');
        }
        return Redirect::route('estimates');
    }
    public function send($uuid){
        if(!hasPermission('send_estimate', true)) return redirect('estimates');
        $estimate = $this->estimate->with('items','client')->getById($uuid);
        $mail_setting = $this->mail_setting->first();
        if($estimate){
            $settings = $this->setting->first();
            $estimate_settings = $this->estimateSetting->first();
            $estimate->totals = $this->estimate->estimateTotals($uuid);
            $pdf = PDF::loadView('estimates.pdf', compact('settings', 'estimate','estimate_settings'));

            $data['emailTitle'] = trans('application.estimate_generated');
            $data['emailBody'] = trans('application.estimate_generated');
            $template = $this->template->where('name','estimate')->first();
            if($template)
            {
                $data_object = new \stdClass();
                $data_object->settings  = $settings;
                $data_object->client    = $estimate->client;

                $data['emailBody'] = parse_template($data_object, $template->body);
                $data['emailTitle'] = $template->subject;
            }
            $data['logo'] =  $settings ? $settings->logo : '';
            if($mail_setting) {
                if($mail_setting->protocol == 'smtp'){
                    Config::set('mail.host', $mail_setting->smtp_host);
                    Config::set('mail.username', $mail_setting->smtp_username);
                    Config::set('mail.password', $mail_setting->smtp_password);
                    Config::set('mail.port', $mail_setting->smtp_port);
                }
                try {
                    Mail::send(['html' => 'emails.layout'], $data, function ($message) use ($pdf, $estimate, $settings,$mail_setting) {
                        $message->from($mail_setting->from_email, $mail_setting->from_name);
                        $message->sender($mail_setting->from_email, $mail_setting->from_name);
                        $message->to($estimate->client->email, $estimate->client->name);
                        $message->subject(trans('application.estimate_generated'));
                        $message->attachData($pdf->output(), 'estimate_' . $estimate->estimate_no . '_' . date('Y-m-d') . '.pdf');
                    });
                    Flash::success(trans('application.email_sent'));
                } catch (\Exception $e) {
                    Flash::error($e->getMessage());
                    return Redirect::route('estimates.show', $uuid);
                }
            }
        }
        return Redirect::route('estimates.show', $uuid);
    }
    public function makeInvoice(){
        $uuid = Input::get('id');
        $estimate = $this->estimate->getById($uuid);
        $settings     = $this->invoiceSetting->first();
        $start        = $settings ? $settings->start_number : 0;
        $invoice_num  = $this->number->prefix('invoice_number', $this->invoice->generateInvoiceNum($start));
        $invoiceData = array(
            'client_id'     => $estimate->client_id,
            'number'        => $invoice_num,
            'invoice_date'  => date('Y-m-d'),
            'notes'         => $estimate->notes,
            'terms'         => $estimate->terms,
            'currency'      => $estimate->currency,
            'status'        => '0',
            'discount'      => 0,
            'recurring'     => 0,
            'recurring_cycle' => 1,
            'due_date' => date('Y-m-d')
        );
        $invoice = $this->invoice->create($invoiceData);
        if($invoice) {
            $items = $estimate->items;
            foreach ($items as $item) {
                $itemsData = array(
                    'invoice_id' => $invoice->uuid,
                    'item_name' => $item->item_name,
                    'item_description' => $item->item_description,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'tax_id' => $item->tax != '' ? $item->tax : null,
                );
                $this->invoiceItem->create($itemsData);
            }
            $settings = $this->invoiceSetting->first();
            if ($settings) {
                $start = $settings->start_number + 1;
                $this->invoiceSetting->updateById($settings->uuid, array('start_number' => $start));
            }
            return Response::json(array('success' => true, 'redirectTo'=>route('invoices.show',$invoice->uuid), 'msg' => trans('application.record_created')), 200);
        }else{
            return Response::json(array('success' => false, 'msg' => trans('application.record_creation_failed')), 400);
        }
    }
	public function destroy($uuid)
	{
        if(!hasPermission('delete_estimate', true)) return redirect('estimates');
        if($this->estimate->deleteById($uuid)){
            Flash::success(trans('application.record_deleted'));
            return Redirect::route('estimates');
        }
        Flash::error(trans('application.record_deletion_failed'));
        return Redirect::route('estimates');
	}
}
