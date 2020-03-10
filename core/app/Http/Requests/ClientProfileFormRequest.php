<?php namespace App\Http\Requests;

class ClientProfileFormRequest extends Request {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('user')->check();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email|unique:clients,email,'.auth()->guard('user')->user()->uuid.',uuid',
            'name'     => 'required|unique:clients,name,'.auth()->guard('user')->user()->uuid.',uuid',
            'password' => 'min:6',
            'photo'    => 'image|image_size:<=300',
        ];
    }
}
