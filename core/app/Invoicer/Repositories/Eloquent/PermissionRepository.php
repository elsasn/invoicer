<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\PermissionInterface;

class PermissionRepository extends BaseRepository implements PermissionInterface{

    public function model() {
        return 'App\Models\Permission';
    }
}