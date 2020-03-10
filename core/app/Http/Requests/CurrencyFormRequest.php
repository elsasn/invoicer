<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CurrencyFormRequest extends Request {

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
        $rules =  [
            'active'      => 'required',
            'default_currency'     => 'required'
        ];
		return $rules;
	}

}
