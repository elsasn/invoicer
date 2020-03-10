<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
class Install {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
    public function handle($request, Closure $next)
    {
        $currentPath= Route::getFacadeRoot()->current()->getPrefix();
        if(\File::exists(base_path().'/config/invoicer.php')){
            if($currentPath == '/install'){
                return redirect('home');
            }
            return $next($request);
        }else{
            if($currentPath != '/install'){
                return redirect('install');
            }
        }
        return $next($request);
    }
}
