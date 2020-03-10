<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class ExpenseCategory extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $fillable = ['name'];
    protected $primaryKey = 'uuid';

    public function expenses(){
        return $this->hasMany('App\Models\Expense');
    }
}
