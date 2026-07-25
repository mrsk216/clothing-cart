<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use App\Http\View\Composers\HeaderComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        View::share('siteName', function () {
            return \App\Models\Setting::where('key', 'site_name')->value('value');
        });
        View::share('contactEmail', function () {
            return \App\Models\Setting::where('key', 'contact_email')->value('value');
        });
        View::share('contactPhone', function () {
            return \App\Models\Setting::where('key', 'contact_phone')->value('value');
        });
        View::share('contactAddress', function () {
            return \App\Models\Setting::where('key', 'address')->value('value');
        });

        // Share categories with header partial
        View::composer('partials.header', HeaderComposer::class);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
