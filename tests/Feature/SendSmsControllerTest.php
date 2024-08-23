<?php

namespace Feature;

use App\Http\Controllers\SendSmsController;
use App\Sms\Drivers\FakeSender;
use App\Sms\SmsManager;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(SendSmsController::class)]
class SendSmsControllerTest extends TestCase
{
    #[Test]
    public function successSendSms(): void
    {
        Config::set('sms.default', 'fake');

        /** @var FakeSender $sender */
        $sender = $this->app->make(SmsManager::class);
        $this->app->instance(SmsManager::class, $sender);

        $cellphone = '0912345678';

        $this->getJson(route('send_sms', ['cellphone' => $cellphone]))
            ->assertNoContent();
        $sender->assertSent($cellphone, function (string $content) use ($cellphone) {
            return "測試用簡訊內容，手機號碼為：{$cellphone}" === $content;
        });
    }
}
