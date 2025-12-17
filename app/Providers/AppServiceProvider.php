<?php

namespace App\Providers;

use App\Listeners\LogMailListener;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
        $listener = new LogMailListener();
        
        \Illuminate\Support\Facades\Event::listen(
            MessageSending::class,
            [$listener, 'handleMessageSending']
        );
    }
}
