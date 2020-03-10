<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class Locale extends Model {
    use UuidModel;
    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $fillable = ['locale_name', 'short_name', 'flag', 'status','default'];
}
