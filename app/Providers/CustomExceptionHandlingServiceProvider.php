<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException;
use Illuminate\Support\Facades\Redirect;

class CustomExceptionHandlingServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Define the exception handler using the 'render' method
        $this->app->bind(TenantCouldNotBeIdentifiedOnDomainException::class, function ($exception, $request) {
            // Handle the exception by redirecting to a specific URL
            return Redirect::to('https://my-central-domain.com/');
        });
    }
}
