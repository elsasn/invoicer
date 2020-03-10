<?php namespace App\Http\Requests;

class ProfileFormRequest extends Request {
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
		return [
            'username' => 'required|unique:users,username,'.auth()->guard('admin')->user()->uuid.',uuid',
            'email'    => 'required|email|unique:users,email,'.auth()->guard('admin')->user()->uuid.',uuid',
            'name'     => 'required',
            'password' => 'min:6',
            'photo'    => 'image|image_size:<=300',
		];
	}
}
