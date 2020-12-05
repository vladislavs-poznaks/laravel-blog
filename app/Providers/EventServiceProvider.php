<?php

namespace App\Providers;

use App\Events\ArticleCreated;
use App\Listeners\ArticleCreatedNotification;
use App\Listeners\SendGeneratedPasswordNotification;
use App\Listeners\UpdateArticlesCount;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendGeneratedPasswordNotification::class,
        ],
        ArticleCreated::class => [
            UpdateArticlesCount::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
