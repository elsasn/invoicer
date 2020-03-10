<?php namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Requests\ClientFormRequest;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\NumberSettingInterface as Number;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;
class ClientsController extends Controller {
    private $client, $invoice, $estimate, $number;
    public function __construct(Client $client, Invoice $invoice, Estimate $estimate, Number $number){
        $this->client = $client;
        $this->invoice = $invoice;
        $this->estimate = $estimate;
        $this->number = $number;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index()
    {
        if (Request::ajax()) {
            $model = $this->client->model();
            $clients = $model::select('client_no','name','email','phone','country','photo','uuid')->ordered();
            return Datatables::of($clients)
                ->editColumn('photo', '<img src="{{ asset($photo != "" ? "assets/img/uploads/client_images/".$photo : "assets/img/uploads/no-image.jpg" ) }}" class="img-circle" width="36px"/>')
                ->addColumn('action', '
                     {!! show_btn(\'clients.show\', $uuid) !!} 
                     @if(hasPermission(\'edit_client\')) {!! edit_btn(\'clients.edit\', $uuid) !!}@endif
                     @if(hasPermission(\'delete_client\')) {!! delete_btn(\'clients.destroy\', $uuid) !!}@endif
                ')->make(true);
        }else {
            return view('clients.index');
        }
    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if(!hasPermission('add_client', true)) return redirect('clients');
        $client_num = $this->number->prefix('client_number', $this->client->generateClientNum());
        return view('clients.create', compact('client_num'));
	}
    /**
     * Store a newly created resource in storage.
     * @param ClientFormRequest $request
     * @return Response
     */
    public function store(ClientFormRequest $request)
	{
        $data = array('client_no' => $request->client_no,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'website' => $request->website,
            'notes' => $request->notes,
            'password' => bcrypt($request->password)
        );
        $client = $this->client->create($data);
        if($client){
            if($request->ajaxNonReload){
                return Response::json(array('value' => $client->uuid->string, 'text' => $client->name), 200);
            }else {
                Flash::success(trans('application.record_created'));
                return Response::json(array('success' => true, 'msg' => trans('application.record_created')), 200);
            }
        }
        return Response::json(array('success' => false, 'msg' => trans('application.record_creation_failed')), 422);
	}
    /**
     * Show the form for editing the specified resource.
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($uuid)
	{
        if(!hasPermission('edit_client', true)) return redirect('clients');
		$client = $this->client->getById($uuid);
        if($client)
            return view('clients.edit',  compact('client'));
        else
            return redirect('clients');
	}
    /**
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($uuid){
        $client = $this->client->with('invoices', 'estimates')->getById($uuid);
        if($client){
            foreach($client->invoices as $count => $invoice){
                $client->invoices[$count]['totals'] = $this->invoice->invoiceTotals($invoice->uuid);
            }
            foreach($client->estimates as $count => $estimate){
                $client->estimates[$count]['totals'] = $this->estimate->estimateTotals($estimate->uuid);
            }
            return view('clients.show', compact('client'));
        }
        return redirect('clients');
    }
    /**
     * Update the specified resource in storage.
     * @param ClientFormRequest $request
     * @param $uuid
     * @return Response
     *
     */
    public function update(ClientFormRequest $request, $uuid)
	{
        $data = array('client_no' => $request->client_no,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'website' => $request->website,
            'notes' => $request->notes
        );
        if($request->password != ''){
            $data['password'] = bcrypt($request->password);
        }
        if($this->client->updateById($uuid,$data)){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success' => true, 'msg' => trans('application.record_updated')), 200);
        }
        return Response::json(array('success' => false, 'msg' => trans('application.update_failed')), 422);
	}
    /**
     * Remove the specified resource from storage.
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($uuid)
	{
        if(!hasPermission('delete_client', true)) return redirect('clients');
		$this->client->deleteById($uuid);
        Flash::success(trans('application.record_deleted'));
        return redirect('clients');
	}
}
