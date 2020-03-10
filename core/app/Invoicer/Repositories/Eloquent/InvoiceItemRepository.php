<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\InvoiceItemInterface;

class InvoiceItemRepository extends BaseRepository implements InvoiceItemInterface{

    public function model() {
        return 'App\Models\InvoiceItem';
    }
}