<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

class InitializeTenancyForFilament
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Filament::serving(function () {
            InitializeTenancyByPath::initialize([
                'url_structure' => '/{id}',
            ]);
        });

        return $next($request);
    }
}