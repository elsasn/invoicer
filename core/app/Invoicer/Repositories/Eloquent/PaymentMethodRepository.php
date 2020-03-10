<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\PaymentMethodInterface;

class PaymentMethodRepository extends BaseRepository implements PaymentMethodInterface{

    public function model() {
        return 'App\Models\PaymentMethod';
    }

    public function resetDefault(){
    	$method  = new $this->model();
        $method->update(['selected' => 0]);
    }

    /**
     * @return array
     */
    public function paymentMethodSelect(){
        $model = $this->model();
        $methods = $model::orderBy('selected', 'desc')->get();
        $methodList = array();
        foreach($methods as $method)
        {
            $methodList[$method->uuid] = $method->name;
        }
        return $methodList;
    }
}