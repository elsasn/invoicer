<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\UserInterface;

class UserRepository extends BaseRepository implements UserInterface{

    public function model() {
        return 'App\Models\User';
    }
}