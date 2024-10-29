<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProfileCompleted
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
        $user = Auth::user();

        if ($user) {
            if (empty($user->city)) {
                return redirect('/register?r=1');
            }

            if (empty($user->charName)) {
                return redirect('/register?r=2');
            }
        }

        return $next($request);
    }
}
