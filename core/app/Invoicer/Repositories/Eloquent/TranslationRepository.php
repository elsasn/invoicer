<?php namespace App\Invoicer\Repositories\Eloquent;
use App\Invoicer\Repositories\Contracts\TranslationInterface;
use Illuminate\Support\Facades\DB;

class TranslationRepository extends BaseRepository implements TranslationInterface{
    public function model() {
        return 'App\Models\Locale';
    }
    public function resetDefault(){
        $locale  = $this->model();
        $locale::where('default',1)->update(['default' => 0]);
    }
    public function updateLocaleKey($old_key, $new_key){
        $query = "UPDATE ltm_translations SET locale = '$new_key' WHERE locale = '$old_key'";
        DB::update($query);
    }
}