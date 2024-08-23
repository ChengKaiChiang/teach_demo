<?php

namespace App\Sms;

use App\Sms\Drivers\FakeSender;
use App\Sms\Drivers\Noop;
use App\Sms\Drivers\V1Sender;
use App\Sms\Drivers\V2Sender;
use Illuminate\Support\Manager;

class SmsManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->config->get('sms.default');
    }

    protected function createV2Driver(): SenderInterface
    {
        return $this->container->make(V2Sender::class);
    }

    protected function createV1Driver(): SenderInterface
    {
        return $this->container->make(V1Sender::class);
    }

    protected function createNoopDriver(): SenderInterface
    {
        return $this->container->make(Noop::class);
    }

    protected function createFakeDriver(): SenderInterface
    {
        return $this->container->make(FakeSender::class);
    }
}
