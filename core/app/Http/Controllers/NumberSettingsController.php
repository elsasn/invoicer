<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Invoicer\Repositories\Contracts\NumberSettingInterface as Setting;
use Laracasts\Flash\Flash;

class NumberSettingsController extends Controller {
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

		return view('settings.number', compact('setting'));
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data =  array(
            'invoice_number'  => \Input::get('invoice_number'),
            'client_number'   => \Input::get('client_number'),
            'estimate_number' => \Input::get('estimate_number'),
        );

        if($this->setting->create($data)){
            Flash::success(trans('application.record_updated'));
        }
        else{
            Flash::error(trans('application.update_failed'));
        }
        return redirect('settings/number');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $data =  array(
            'invoice_number'  => \Input::get('invoice_number'),
            'client_number'   => \Input::get('client_number'),
            'estimate_number' => \Input::get('estimate_number'),
        );

        if($this->setting->updateById($id, $data)){
            Flash::success(trans('application.record_updated'));
        }
        else{
            Flash::error(trans('application.update_failed'));
        }
        return redirect('settings/number');
	}


}
