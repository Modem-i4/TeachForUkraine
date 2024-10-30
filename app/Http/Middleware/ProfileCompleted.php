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
        $redirect = null;
        if (!$user) {
            $redirect = '/register';
        }
        if ($user) {
            if (empty($user->city)) {
                $redirect = '/register/student';
            }

            else if (empty($user->charName)) {
                $redirect = '/register/character';
            }
        }
        if($redirect && $redirect !== $request->getRequestUri())
            return redirect($redirect);
        return $next($request);
    }
}
