<?php

namespace Orchid\CMS\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Orchid\CMS\Events\Systems\SettingsEvent::class      => [
            \Orchid\CMS\Listeners\Systems\Settings\SettingInfoListener::class,
            \Orchid\CMS\Listeners\Systems\Settings\SettingBaseListener::class,
            \Orchid\CMS\Listeners\Systems\Settings\SettingPhpInfoListener::class,
        ],
        \Orchid\CMS\Events\Marketing\AdvertisingEvent::class => [
            \Orchid\CMS\Listeners\Marketing\Advertising\AdvertisingBaseListener::class,
            \Orchid\CMS\Listeners\Marketing\Advertising\AdvertisingCodeListener::class,
        ],
        \Orchid\CMS\Events\Tools\CategoryEvent::class        => [
            \Orchid\CMS\Listeners\Tools\Category\CategoryBaseLister::class,
            \Orchid\CMS\Listeners\Tools\Category\CategoryDescLister::class,
        ],
        \Orchid\CMS\Events\Marketing\CommentEvent::class     => [
            \Orchid\CMS\Listeners\Marketing\Comment\CommentBaseListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
