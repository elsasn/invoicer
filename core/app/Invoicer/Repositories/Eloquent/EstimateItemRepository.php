<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\EstimateItemInterface;

class EstimateItemRepository extends BaseRepository implements EstimateItemInterface{

    public function model() {
        return 'App\Models\EstimateItem';
    }
}