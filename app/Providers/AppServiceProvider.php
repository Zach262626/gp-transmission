<?php

namespace App\Providers;

use App\Listeners\LogMailListener;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
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

        // Laravel only dispatches MessageSending / MessageSent — there is no
        // MessageFailed event. Send failures throw and are handled where the
        // send happens (e.g. CustomerInformationController's catch block).
        $listener = new LogMailListener;

        Event::listen(MessageSending::class, [$listener, 'handleMessageSending']);
        Event::listen(MessageSent::class, [$listener, 'handleMessageSent']);
    }
}
