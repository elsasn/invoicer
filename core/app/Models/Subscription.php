<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class Subscription extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
	protected $fillable = ['invoice_id','billingcycle','nextduedate','status'];
    public function invoice(){
        return $this->belongsTo('App\Models\Invoice');
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}
