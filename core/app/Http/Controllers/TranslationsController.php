<?php namespace App\Http\Controllers;

use App\Http\Requests\TranslationFormRequest;
use App\Invoicer\Repositories\Contracts\TranslationInterface as Translation;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;

class TranslationsController extends Controller {
	protected $translation;
	/**
	 * Create a new controller instance.
	 */
	public function __construct(Translation $translation){
        $this->middleware('permission:edit_setting');
		$this->translation      = $translation;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		$locales = $this->translation->all();
		return view('translations.index', compact('locales'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		return view('translations.create');
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TranslationFormRequest $request)
	{
		$data =  array(
			'locale_name'    =>ucfirst($request->locale_name),
			'short_name'     =>$request->short_name,
			'status'   		 =>$request->status,
            'default'        => $request->default
		);
		if ($request->hasFile('flag')){
			$file = $request->file('flag');
			$filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
			$file->move('assets/img/flags/', $filename);
			\Image::make(sprintf('assets/img/flags/%s', $filename))->resize(16,11)->save();
			$data['flag']= $filename;
		}
        if($request->default){
            $this->translation->resetDefault();
        }
		if($this->translation->create($data)){
			$locale_path = base_path().'/resources/lang/'.$request->short_name;
			if(!\File::exists($locale_path)) {
				\File::makeDirectory($locale_path, 0775);
			}
			Flash::success(trans('record_created'));
			return Response::json(array('success' => true, 'msg' => trans('application.record_created')), 200);
		}

		return Response::json(array('success' => false, 'msg' => trans('application.record_failed')), 422);
	}
	/**
	 * Show the form for editing the specified resource.
	 * @param $uuid
	 * @return \Illuminate\View\View
	 */
	public function edit($uuid)
	{
		$locale = $this->translation->getById($uuid);
		return view('translations.edit', compact('locale'));
	}
	/**
	 * Update the specified resource in storage.
	 * @param TranslationFormRequest $request
	 * @param $uuid
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function update(TranslationFormRequest $request, $uuid)
	{
		$locale = $this->translation->getById($uuid);
		$data =  array(
			'locale_name'    =>ucfirst($request->locale_name),
			'status'   		 =>$request->status,
            'default'        =>$request->default
		);
		if($locale->short_name != 'en'){
            $data['short_name'] = $request->short_name;
        }
		if ($request->hasFile('flag')){
			$file = $request->file('flag');
			$filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
			$file->move('assets/img/flags/', $filename);
			\Image::make(sprintf('assets/img/flags/%s', $filename))->resize(16,11)->save();
			if(is_file('assets/img/flags/'.$locale->flag)){
				\File::delete('assets/img/flags/'.$locale->flag);
			}
			$data['flag']= $filename;
		}
        if($request->default){
            $this->translation->resetDefault();
        }
		if($this->translation->updateById($uuid,$data)){
            if($locale->short_name != $request->short_name && $locale->short_name != 'en') {
                $this->translation->updateLocaleKey($locale->short_name, $request->short_name);
            }
            if($locale->short_name != 'en') {
                $old_path = base_path() . '/resources/lang/' . $locale->short_name;
                $new_path = base_path() . '/resources/lang/' . $request->short_name;
                if (!\File::exists($new_path)) {
                    \File::move($old_path, $new_path);
                }
            }
			Flash::success(trans('application.record_updated'));
			return Response::json(array('success' => true, 'msg' => trans('application.record_updated')), 200);
		}
		return Response::json(array('success' => false, 'msg' => trans('application.update_failed')), 422);
	}
	/**
	 * Remove the specified resource from storage.
	 * @param $uuid
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function destroy($uuid)
	{
		$locale = $this->translation->getById($uuid);
		if($this->translation->deleteById($uuid)){
			if(is_file('assets/img/flags/'.$locale->flag)){
				\File::delete('assets/img/flags/'.$locale->flag);
			}
			Flash::success(trans('application.record_deleted'));
		}
		else {
            Flash::error(trans('application.delete_failed'));
        }
		return redirect('settings/translations');
	}
}
