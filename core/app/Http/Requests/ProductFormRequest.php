<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductFormRequest extends Request {

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
            'name'    => 'required|unique:products,name',
            'code'    => 'required|unique:products,code',
            'price'   => 'required|numeric',
            'product_image'     => 'image|image_size:<=300',
        ];

        if($id = $this->product){
            $rules['name'] .= ','.$id.',uuid';
            $rules['code'] .= ','.$id.',uuid';
        }
		return $rules;
	}

}
