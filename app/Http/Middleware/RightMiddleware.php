<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 7/4/2016
 * Time: 10:08 AM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use App\Session;
use App\Core\Check;
use Illuminate\Support\Facades\Route;

class RightMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next, $guard = null)
    {

        if(Check::validSession()){
            $sessionObj = session('permissions');
            $uri = $request->path();
            $currentPath= $request->route()->getName();
            $currentAction = str_replace(".","/",$currentPath);
            if(Check::hasPermission($sessionObj,$currentAction)){
                 return $next($request);
            }
            else{
                return redirect('unauthorize');
            }

        }
        else{
            return redirect('backend/login');
        }

        return $next($request);
    }
}
