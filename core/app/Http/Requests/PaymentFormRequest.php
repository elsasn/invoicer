<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PaymentFormRequest extends Request {

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
            'invoice_id' => 'required',
            'payment_date' => 'required',
            'method' => 'required',
            'amount' => 'required|numeric'
        ];
        if($id = $this->payment){
            $rules['invoice_id'] = '';
        }
		return $rules;
	}

}
