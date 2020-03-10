<?php namespace app\http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
class PermissionMiddleware
{
    protected $auth;
    /**
     * Creates a new instance of the middleware.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = auth()->guard('admin');;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @param  $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {

        if ($this->auth->guest() || !$this->auth->user()->hasPermission($permissions) && !$this->auth->user()->HasRole('admin')) {
            return redirect('/');
        }
        return $next($request);
    }
}