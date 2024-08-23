<?php

namespace App\Providers;

use App\Sms\Drivers\V2Sender;
use App\Sms\SenderInterface;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // 當依賴 SenderInterface 介面的時候，會注入 V2Sender
        $this->app->singleton(SenderInterface::class, V2Sender::class);
    }
}
