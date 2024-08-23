<?php

namespace App\Sms\Drivers;

use App\Sms\SenderInterface;
use Illuminate\Contracts\View\View;
use Psr\Log\LoggerInterface;

/**
 * 只 log 但不送出
 */
readonly class Noop implements SenderInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function send(string $cellphone, View $view): void
    {
        $this->logger->info('SMS Noop log for sent message.', [
            'cellphone' => $cellphone,
            'content' => trim($view->render()),
        ]);
    }
}
