<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\EstimateSettingInterface;

class EstimateSettingRepository extends BaseRepository implements EstimateSettingInterface{

    public function model() {
        return 'App\Models\EstimateSetting';
    }
}