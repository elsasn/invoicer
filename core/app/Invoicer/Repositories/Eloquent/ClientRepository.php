<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\ClientInterface;

class ClientRepository extends BaseRepository implements ClientInterface {

    /**
     * @return string
     */

    public function model() {
        return 'App\Models\Client';
    }
    /**
     * @return string
     */
    public function generateClientNum(){
        $client = $this->model();
        $last = $client::orderBy('increment_num', 'desc')->first();
        if($last){
            $next_id = $last->increment_num+1;
        }else{
            $next_id = 1;
        }

        return $next_id;
    }
    /**
     * @return array
     */
    public function clientSelect(){
        $clients = $this->all();
        $clientList = array();
        foreach($clients as $client)
        {
            $clientList[$client->uuid] = $client->name;
        }
        return $clientList;
    }
}