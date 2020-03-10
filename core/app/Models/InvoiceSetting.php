<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
class InvoiceSetting extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $fillable = ['start_number', 'terms', 'due_days', 'logo','show_status'];
}