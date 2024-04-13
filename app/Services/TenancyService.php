<?php

namespace App\Services;

use App\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;

class TenancyService
{
    public function RegisterTenancy($model): Tenant
    {
        $tenant = Tenant::create();

        $subdomain = strtolower($model->name);
        $centralDomain = env('CENTRAL_DOMAIN', 'localhost');
        $domainName = "{$subdomain}.{$centralDomain}";

        $domain = new Domain(['domain' => $domainName]);
        $tenant->domains()->save($domain);

        tenancy()->initialize($tenant);

        return $tenant;
    }
}