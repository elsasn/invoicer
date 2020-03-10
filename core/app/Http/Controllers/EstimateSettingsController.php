<?php namespace App\Http\Controllers;

use App\Http\Requests\EstimateSettingsFormRequest;
use App\Invoicer\Repositories\Contracts\EstimateSettingInterface as Setting;
use Laracasts\Flash\Flash;


class EstimateSettingsController extends Controller {

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
		if($this->setting->count() > 0){
			$setting = $this->setting->first();
		}
		else{
			$setting = array();
		}
		return view('settings.estimate', compact('setting'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EstimateSettingsFormRequest $request)
	{
		$data =  array(
			'start_number'	=>$request->start_number,
			'terms'    	 	=>$request->terms,
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
		return redirect('settings/estimate');
	}

	/**
	 * Update the specified resource in storage.
	 * @param EstimateSettingsFormRequest $request
	 * @param $uuid
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(EstimateSettingsFormRequest $request, $uuid)
	{
		$setting = $this->setting->getById($uuid);
		$data =  array(
			'start_number'  =>$request->start_number,
			'terms'         =>$request->terms,
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
			if($this->setting->updateById($uuid, $data)){
				Flash::success(trans('application.record_updated'));
			}
			else{
				Flash::error(trans('application.update_failed'));
			}
		}
		return redirect('settings/estimate');
	}


}
