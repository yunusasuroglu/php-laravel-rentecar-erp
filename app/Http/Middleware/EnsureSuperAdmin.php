<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $superAdminRoleId = config('roles.super_admin_id'); // Config'den rol ID'sini alıyoruz.

        if ($user && $user->roles->contains('id', $superAdminRoleId)) {
            return $next($request);
        }

        abort(403, 'Sie haben keinen Zugriff');
    }
}
