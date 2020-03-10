<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ExpenseFormRequest extends Request {

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
            'name'          => 'required',
            'expense_date'  => 'required|date',
            'amount'        => 'required|numeric',
        ];
		return $rules;
	}

}
