<?php namespace App\Http\Requests;
class ClientFormRequest extends Request {
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
            [   'client_no' => 'required|unique:clients,client_no',
                'name'    => 'required|unique:clients,name',
                'email'    => 'email|unique:clients,email',
                'password' => 'confirmed|min:6',
            ];

        if($id = $this->client)
        {
            $rules['client_no'] .= ','.$id.',uuid';
            $rules['name'] .= ','.$id.',uuid';
            $rules['email'] .= ','.$id.',uuid';
        }else{
            $rules['password'] .= '|required';
        }
        return $rules;
	}

}
