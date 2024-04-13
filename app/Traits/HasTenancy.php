<?php

namespace App\Traits;

use App\Services\TenancyService;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

trait HasTenancy
{
    public static function bootHasTenancy()
    {
        static::created(function ($model) {
            $model->registerTenancyOnSignup();
        });
    }

    protected function registerTenancyOnSignup()
    {
        try {
            $tenancyService = app(TenancyService::class);
            $tenant = $tenancyService->RegisterTenancy($this);

            $this->tenant_id = $tenant->id;
            $this->save();
        } catch (\Exception $exception) {
            $this->delete();
            throw $exception;
        }
    }
    
}