<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class ProductCategory extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $fillable = ['name'];
    protected $primaryKey = 'uuid';

    public function products(){
        return $this->hasMany('App\Models\Product');
    }
}
