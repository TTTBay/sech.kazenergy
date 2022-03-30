<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Setlocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(empty(session('locale'))) {
            App::setLocale(session(['locale'=>'ru']));
        }
        App::setLocale(session('locale'));
        return $next($request);
    }
}
