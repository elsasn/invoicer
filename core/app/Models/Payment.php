<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class Payment extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $fillable = ['invoice_id','payment_date','amount','notes','method'];

    public function invoice(){
        return $this->belongsTo('App\Models\Invoice');
    }
    public function payment_method(){
        return $this->belongsTo('App\Models\PaymentMethod','method');
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}
