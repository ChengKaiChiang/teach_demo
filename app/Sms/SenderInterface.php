<?php

namespace App\Sms;

use Illuminate\Contracts\View\View;

interface SenderInterface
{
    public function send(string $cellphone, View $view): void;
}
