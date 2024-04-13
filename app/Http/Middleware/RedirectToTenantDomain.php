<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToTenantDomain
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('manager')->check()) {
            $user = auth()->guard('manager')->user();
            $tenant = $user->tenant;
            return redirect()->to($tenant->domain . '/manager-web');
        }

        return $next($request);
    }
}