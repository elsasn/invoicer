<?php namespace App\Http\Requests;

class TranslationFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        return auth()->guard('admin')->check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
				'locale_name'	=> 'required',
				'short_name' 	=> 'required',
				'status'    	=> 'required',
				'flag'          => 'image',
			];
		return $rules;
	}
}
