<?php namespace App\Invoicer\Repositories\Eloquent;
use App\Invoicer\Repositories\Contracts\CurrencyInterface;
class CurrencyRepository extends BaseRepository implements CurrencyInterface{
    public function model() {
        return 'App\Models\Currency';
    }
    public function resetDefault(){
    	$currency  = new $this->model();
        $currency::where('default_currency',1)->update(['default_currency' => 0]);
    }
    /**
     * @return array
     */
    public function currencySelect(){
        $currencies = $this->where('active',1)->get();
        $currencyList = array();
        foreach($currencies as $currency)
        {
            $currencyList[$currency->code.'('.$currency->symbol.')'] = $currency->name;
        }
        return $currencyList;
    }

    public function defaultCurrency(){
        $currency = $this->where('default_currency',1)->first();
        return $currency;
    }
}