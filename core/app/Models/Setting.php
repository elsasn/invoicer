<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class Setting extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $fillable = ['name', 'email', 'phone', 'address1', 'address2', 'city', 'state', 'postal_code',
        'country', 'contact', 'vat', 'website', 'logo', 'favicon','date_format','thousand_separator','decimal_separator','decimals','purchase_code'];
}
