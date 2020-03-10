<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class PaymentMethod extends Model{
    use UuidModel;
    public $incrementing = false;

    protected $primaryKey = 'uuid';
    protected  $fillable = ['name','selected'];
    public function payments(){
        return $this->hasMany('App\Models\Payment','method');
    }
}
