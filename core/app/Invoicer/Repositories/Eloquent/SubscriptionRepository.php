<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\SubscriptionInterface;

class SubscriptionRepository extends BaseRepository implements SubscriptionInterface{

    public function model() {
        return 'App\Models\Subscription';
    }
}