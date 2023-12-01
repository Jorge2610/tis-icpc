<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SymlinkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!file_exists(public_path('storage'))) {
            $target = storage_path('app/public');
            symlink($target, public_path('storage'));
        }
    }
}
