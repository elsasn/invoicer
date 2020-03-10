<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\SettingInterface;

class SettingRepository extends BaseRepository implements SettingInterface{

    public function model() {
        return 'App\Models\Setting';
    }
}