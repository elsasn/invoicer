<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class Invoice extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $fillable = ['client_id', 'number', 'invoice_date', 'due_date', 'status', 'discount', 'terms', 'notes', 'currency','discount_mode','recurring','recurring_cycle'];
    public function client(){
        return $this->belongsTo('App\Models\Client');
    }
    public function items(){
        return $this->hasMany('App\Models\InvoiceItem');
    }
    public function payments(){
        return $this->hasMany('App\Models\Payment');
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}
