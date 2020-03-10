<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ClientAreaCheckoutRequest extends FormRequest
{
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
        $rules = [
            'invoice_id' => 'required',
            'selected_method' => 'required'
        ];
        return $rules;

    }
}
