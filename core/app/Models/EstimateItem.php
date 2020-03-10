<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class EstimateItem extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected  $fillable = ['estimate_id','item_name','item_description','quantity', 'price','tax_id','item_order'];

    public function tax(){
        return $this->belongsTo('App\Models\TaxSetting');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    public function Estimate(){
        return $this->belongsTo('App\Models\Estimate');
    }
}