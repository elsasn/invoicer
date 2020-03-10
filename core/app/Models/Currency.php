<?php namespace App\Models;
use App\Traits\UuidModel;
use Illuminate\Database\Eloquent\Model;
class Currency extends Model {
    use UuidModel;
    public $incrementing = false;
    /**
     * Main table primary key
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * @var array
     */
    protected $fillable = ['name','code', 'symbol', 'format','exchange_rate','active','default_currency'];
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}