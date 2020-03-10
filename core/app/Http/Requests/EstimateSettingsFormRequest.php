<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EstimateSettingsFormRequest extends Request {

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
			[   'start_number' 	=> 'integer|required',
				'logo'     		=> 'image|image_size:<=300',
			];
		return $rules;
	}

}
