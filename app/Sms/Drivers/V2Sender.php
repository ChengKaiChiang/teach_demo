<?php

namespace App\Sms\Drivers;

use App\Sms\SenderInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;

/**
 * 簡訊寄送器
 */
class V2Sender implements SenderInterface
{
    /**
     * 寄送簡訊
     */
    public function send(string $cellphone, View $view): void
    {
        $content = trim($view->render());

        // 公司 SMS2.0 寄簡訊 api
        Http::withHeader('X-SMS-Token', 'whatever-token')
            ->post(
                'https://sms2.104dc-dev.com/send-sms',
                [
                    'projectCode' => 'B0098',
                    'attribute' => 2,
                    'phoneNumber' => $cellphone,
                    'messageContent' => $content,
                    'priority' => 1,
                ],
            );
    }
}
