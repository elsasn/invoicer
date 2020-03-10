<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\ProfileInterface;

class ProfileRepository extends BaseRepository implements ProfileInterface{

    public function model() {
        return 'App\Models\User';
    }
}