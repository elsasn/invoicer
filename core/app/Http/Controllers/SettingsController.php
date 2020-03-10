<?php namespace App\Http\Controllers;

use App\Http\Requests\SettingsFormRequest;
use App\Invoicer\Repositories\Contracts\SettingInterface as Setting;
use Laracasts\Flash\Flash;

class SettingsController extends Controller {

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
		return view('settings.company', compact('setting'));
	}
    /**
     * Store a newly created resource in storage.
     * @param SettingsFormRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SettingsFormRequest $request)
	{
        $data =  array(
            'name'      =>$request->name,
            'email'     =>$request->email,
            'contact'   =>$request->contact,
            'phone'     => $request->phone,
            'address1'  => $request->address1,
            'address2'  => $request->address2,
            'city'      => $request->city,
            'state'     => $request->state,
            'country'   => $request->country,
            'postal_code'=> $request->postal_code,
            'vat'       => $request->vat,
            'website'   => $request->website,
            'date_format'=> $request->date_format,
            'thousand_separator'=> $request->thousand_separator,
            'decimal_separator'=> $request->decimal_separator,
            'decimals'=> $request->decimals,
        );

        if ($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
            $file->move('assets/img', $filename);
            \Image::make(sprintf('assets/img/%s', $filename))->resize(200,200)->save();
            $data['logo']= $filename;
        }
        if ($request->hasFile('favicon'))
        {
            $file = $request->file('favicon');
            $filename = 'favicon.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/assets/img', $filename);
            \Image::make(sprintf(public_path().'/assets/img/%s', $filename))->resize(16, 16)->save();
            $data['favicon']= $filename;
        }

        if($this->setting->create($data)){
            Flash::success(trans('application.settings_updated'));
        }
        else{
            Flash::error(trans('application.update_failed'));
        }
        return redirect('settings/company');
	}


    /**
     * Update the specified resource in storage.
     * @param SettingsFormRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SettingsFormRequest $request, $id)
	{
        $setting = $this->setting->getById($id);
        $data =  array(
            'name'      => $request->name,
            'email'     => $request->email,
            'contact'   => $request->contact,
            'phone'     => $request->phone,
            'address1'  => $request->address1,
            'address2'  => $request->address2,
            'city'      => $request->city,
            'state'     => $request->state,
            'country'   => $request->country,
            'postal_code'=> $request->postal_code,
            'vat'       => $request->vat,
            'website'   => $request->website,
            'date_format'=> $request->date_format,
            'thousand_separator'=> $request->thousand_separator,
            'decimal_separator'=> $request->decimal_separator,
            'decimals'=> $request->decimals,
        );
        if ($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
            $file->move('assets/img', $filename);
            \Image::make(sprintf('assets/img/%s', $filename))->resize(200,200)->save();
            \File::delete('assets/img/'.$setting->logo);
            $data['logo']= $filename;
        }
        if ($request->hasFile('favicon'))
        {
            $file = $request->file('favicon');
            $filename = 'favicon.'.$file->getClientOriginalExtension();
            $file->move('assets/img', $filename);
            \Image::make(sprintf('assets/img/%s', $filename))->resize(16, 16)->save();
            $data['favicon']= $filename;
        }
        if($this->setting->updateById($id, $data)){
            Flash::success(trans('application.settings_updated'));
        }
        else{
            Flash::error(trans('application.update_failed'));
        }
        return redirect('settings/company');
	}

}
