<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\InvoiceSettingInterface;

class InvoiceSettingRepository extends BaseRepository implements InvoiceSettingInterface{

    public function model() {
        return 'App\Models\InvoiceSetting';
    }
}