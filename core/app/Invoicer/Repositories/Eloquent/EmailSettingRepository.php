<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\EmailSettingInterface;

class EmailSettingRepository extends BaseRepository implements EmailSettingInterface{

    public function model() {
        return 'App\Models\EmailSetting';
    }
}