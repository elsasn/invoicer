<?php namespace App\Http\Controllers\ClientArea;

use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\EstimateItemInterface as EstimateItem;
use App\Invoicer\Repositories\Contracts\EstimateSettingInterface as EstimateSetting;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\TaxSettingInterface as Tax;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\CurrencyInterface as Currency;
use App\Invoicer\Repositories\Contracts\SettingInterface as Setting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Yajra\Datatables\Facades\Datatables;

class EstimatesController extends Controller {
    protected $product,$tax,$client,$currency,$estimate,$estimateItem,$setting,$logged_user,$estimateSetting;
    public function __construct(Product $product,Tax $tax, Client $client, Currency $currency, Estimate $estimate, EstimateItem $estimateItem, Setting $setting,EstimateSetting $estimateSetting){
        $this->product = $product;
        $this->client = $client;
        $this->currency = $currency;
        $this->tax = $tax;
        $this->estimate = $estimate;
        $this->estimateItem = $estimateItem;
        $this->setting = $setting;
        $this->estimateSetting = $estimateSetting;
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
            $model = $this->estimate->model();
            $estimates = $model::with('client')->where('client_id',$this->logged_user)->select('client_id','estimate_no','estimate_date','uuid','currency')->ordered();
            return Datatables::of($estimates)
                ->addColumn('amount', function($data){
                    $totals = $this->estimate->estimateTotals($data->uuid);
                    return '<span style="display:inline-block">'.$data->currency.'</span> <span style="display:inline-block"> '.format_amount($totals['grandTotal']).'</span>';
                })->addColumn('action', '
                     <a href="{{ route(\'estimatepdf\',$uuid) }}" data-rel="tooltip" data-placement="top" title="{{trans(\'application.download_estimate\')}}" class="btn btn-xs btn-primary"><i class="fa fa-download"></i></a>
                     {!! show_btn(\'cestimates.show\', $uuid) !!}
                     ')->make(true);
        }else {
            return view('clientarea.estimates.index');
        }
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
            $estimate->totals = $this->estimate->estimateTotals($uuid);
            return view('clientarea.estimates.show', compact('estimate', 'settings'));
        }
        return Redirect::route('cestimates');
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
            $pdf = \PDF::loadView('clientarea.estimates.pdf', compact('settings', 'estimate','estimate_settings'));
            return $pdf->download('estimate_'.$estimate->estimate_no.'_'.date('Y-m-d').'.pdf');
        }
        return Redirect::route('cestimates');
    }
}
