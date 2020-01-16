<?php

namespace App\Http\Middleware;

use Closure;

class SwitchLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = auth()->user();

        if ($user) {
            app()->setLocale($user->preferred_lang);
        } else {
            app()->setLocale('tw');
        }

        return $next($request);
    }
}
