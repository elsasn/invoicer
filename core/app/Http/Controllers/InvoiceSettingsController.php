<?php namespace App\Http\Controllers;

use App\Http\Requests\InvoiceSettingsFormRequest;
use App\Invoicer\Repositories\Contracts\InvoiceSettingInterface as Setting;
use Laracasts\Flash\Flash;

class InvoiceSettingsController extends Controller {

    private $setting;

    public function __construct(Setting $setting){
        $this->setting = $setting;
        $this->middleware('permission:edit_setting');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if($this->setting->count() > 0)
            $setting = $this->setting->first();
        else
            $setting = array();
		return view('settings.invoice', compact('setting'));
	}

    /**
     * Store a newly created resource in storage.
     * @param InvoiceSettingsFormRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(InvoiceSettingsFormRequest $request){
        $data =  array(
            'start_number'=>$request->start_number,
            'terms'     =>$request->terms,
            'due_days'   =>$request->due_days,
            'show_status'      =>$request->show_status,
        );

        if ($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
            $file->move('assets/img', $filename);
            \Image::make(sprintf('assets/img/%s', $filename))->resize(200,200)->save();
            $data['logo']= $filename;
        }

        if($this->setting->create($data)){
            Flash::success(trans('application.record_updated'));
        }
        else{
            Flash::error(trans('application.update_failed'));
        }
        return redirect('settings/invoice');
	}
    /**
     * Update the specified resource in storage.
     * @param InvoiceSettingsFormRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(InvoiceSettingsFormRequest $request, $id)
	{
        $setting = $this->setting->getById($id);
        $data =  array(
            'start_number'  =>$request->start_number,
            'terms'         =>$request->terms,
            'due_days'      =>$request->due_days,
            'show_status'      =>$request->show_status,
        );
        if ($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
            $file->move('assets/img', $filename);
            \Image::make(sprintf('assets/img/%s', $filename))->resize(200,200)->save();
            $data['logo']= $filename;
            \File::delete('assets/img/'.$setting->logo);
        }
        if($request->start_number < $setting->start_number){
                Flash::error('Error occurred, start number should be > '.$setting->start_number);
        }else{
            if($this->setting->updateById($id, $data)){
                Flash::success(trans('application.record_updated'));
            }
            else{
                Flash::error(trans('application.update_failed'));
            }
        }

        return redirect('settings/invoice');
	}
}
