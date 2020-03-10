<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class EmailSetting extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected  $fillable = ['protocol', 'smtp_host', 'smtp_username',  'smtp_password', 'smtp_port','from_email','mailgun_domain','mailgun_secret','mandrill_secret','from_name'];
}
