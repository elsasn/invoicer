<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\NumberSettingInterface;

class NumberSettingRepository extends BaseRepository implements NumberSettingInterface{

    public function model() {
        return 'App\Models\NumberSetting';
    }

    public function prefix($type, $num){
        $prefix = $this->first();
        if($prefix){
            return $prefix->$type.$num;
        }
        return $num;
    }
}