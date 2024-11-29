<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ensureUserHasCompletedProfile
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
        $user = Auth::user();
        if ($user) {
            if ($user->status == 2) {
                return redirect()->route('awaiting.approval')->with('error', 'Ihr Konto wartet auf die Genehmigung.');
            }
        }

        return $next($request);
    }
}
