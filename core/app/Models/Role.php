<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class Role extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $fillable = ['name', 'description'];
    protected $primaryKey = 'uuid';

    public function permissions(){
        return $this->belongsToMany(Permission::class)->select(array('name'));
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'uuid');
    }

    public function assign($permissions){
        return $this->permissions()->sync($permissions);
    }
}
