<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TaxSettingFormRequest extends Request {

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
        $rules =
            [ 'name'    => 'required|unique:tax_settings,name',
              'value'   => 'required|numeric',
            ];
        if($id = $this->tax)
        {
            $rules['name'] .= ','.$id.',uuid';
        }
        return $rules;
	}

}
