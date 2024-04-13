<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use BezhanSalleh\FilamentLanguageSwitch\Enums\Placement;
use App\Models\Manager;
use App\Observers\Tenancy\cleanupTenancyObserver;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Manager::observe(cleanupTenancyObserver::class);
        $this->LanguageSwitcher();
        $this->PanelSwitcher();

    }


    protected function PanelSwitcher()
    {
       PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
            ->modalHeading('Available Applications');
                $panelSwitch->excludes([
                    'admin'
                ]);
        });

    }

    protected function LanguageSwitcher()
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
          $switch
              ->locales(['en', 'ar'])
              ->labels([
                  'en' => 'English',
                  'ar' => 'Arabic',
              ])
              ->flags([
                'en' => url('https://cdn.ipregistry.co/flags/emojitwo/gb.svg'),
                'ar' => url('https://cdn.ipregistry.co/flags/emojitwo/sa.svg'),
              ])
              ->excludes([
                  'admin'
              ])
              ->outsidePanelPlacement(Placement::TopCenter)
              ->visible(outsidePanels: true)
              ->circular();
      });
    }
}
