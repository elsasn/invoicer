<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Invoicer\Repositories\Contracts\TranslationInterface as Translation;
class LanguageController extends Controller {
    protected $translation;
    /**
     * Create a new controller instance.
     */
    public function __construct(Translation $translation){
        $this->translation      = $translation;
    }

    public function switchLang($lang){
        $language = $this->translation->where('short_name', $lang)->first();
        if ($language) {
            Session::set('applocale', $lang);
        }
        return Redirect::back();
    }
}