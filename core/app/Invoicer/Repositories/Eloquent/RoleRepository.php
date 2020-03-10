<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\RoleInterface;

class RoleRepository extends BaseRepository implements RoleInterface{

    public function model() {
        return 'App\Models\Role';
    }
}