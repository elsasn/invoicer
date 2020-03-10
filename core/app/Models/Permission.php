<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;

class Permission extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $fillable = ['name', 'description'];

    protected $primaryKey = 'uuid';

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
