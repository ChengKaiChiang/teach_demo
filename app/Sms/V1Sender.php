<?php

namespace App\Sms;

use Corp104\Common\Sms\Sms;
use Illuminate\Contracts\View\View;

/**
 * 簡訊寄送器
 */
class V1Sender implements SenderInterface
{
    public function __construct(private readonly Sms $sms)
    {
    }

    /**
     * 寄送簡訊
     */
    public function send(string $cellphone, View $view): void
    {
        $content = trim($view->render());

        // 公司舊版寄簡訊 lib
        // sendTo() 方法實際是打舊版寄簡訊 api
        $this->sms->sendTo($cellphone, $content);
    }
}
