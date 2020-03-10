<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\TemplateInterface;

class TemplateRepository extends BaseRepository implements TemplateInterface{

    public function model() {
        return 'App\Models\Template';
    }

    public function getTemplate($name){
    	$template = $this->model();
    	return $template::where('name', $name)->first();
    }
}