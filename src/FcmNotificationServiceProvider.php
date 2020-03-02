<?php

namespace Benwilkins\FCM;

use GuzzleHttp\Client;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

/**
 * Class FcmNotificationServiceProvider.
 */
class FcmNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register.
     */
    public function register()
    {
        if (version_compare(app()::VERSION, '5.8.0', '>=')) {
            Notification::resolved(function (ChannelManager $service) {
                $service->extend('fcm', function () {
                    return new FcmChannel(app(Client::class), config('services.fcm.key'));
                });
            });
        } else {
            Notification::extend('fcm', function ($app) {
                return new FcmChannel(new Client(), config('services.fcm.key'));
            });
        }
    }
}
