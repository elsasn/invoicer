<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class InvoiceItem extends Model {
    use UuidModel;
    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected  $fillable = ['invoice_id','item_name','item_description','quantity','price','tax_id','item_order'];

    public function tax(){
        return $this->belongsTo('App\Models\TaxSetting');
    }

    public function invoice(){
        return $this->belongsTo('App\Models\Invoice');
    }
}
