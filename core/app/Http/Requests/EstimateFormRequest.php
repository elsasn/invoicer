<?php namespace App\Http\Requests;

class EstimateFormRequest extends Request {

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
            'client'        => 'required',
            'currency'      => 'required',
            'estimate_date' => 'required',
            'estimate_no'   => 'required|unique:estimates,estimate_no',
        ];

        if($this->items){
            $items = json_decode($this->items);
            foreach($items as $item){
                if($item->item_name == ''){
                    $rules['product'] = 'required';
                }
                if($item->quantity == ''){
                    $rules['quantity'] = 'required|numeric';
                }
                if($item->price == ''){
                    $rules['price'] = 'required|numeric';
                }
            }
        }

        if($id =  $this->estimate){
            $rules['estimate_no']  .= ','.$id.',uuid';
        }
		return $rules;
	}

}
