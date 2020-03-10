<?php // app/Http/Middleware/Language.php

namespace App\Http\Middleware;

use Closure;
//use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class Language {
    public function handle($request, Closure $next)
    {
        if(File::exists(base_path().'/config/invoicer.php')){
            $languages = get_languages();
            $languages_array = array();
            foreach ($languages as $language) {
                array_push($languages_array, $language->short_name);
            }
            if (Session::has('applocale') AND in_array(Session::get('applocale'), $languages_array)) {
                App::setLocale(Session::get('applocale'));
            } else {
                App::setLocale(Config::get('app.fallback_locale'));
            }
        }
        return $next($request);
    }
}