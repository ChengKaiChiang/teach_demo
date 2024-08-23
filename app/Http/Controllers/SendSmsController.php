<?php

namespace App\Http\Controllers;

use App\Sms\Drivers\V2Sender;
use App\Sms\SmsManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SendSmsController extends Controller
{
    public function __invoke(Request $request, SmsManager $manager): Response
    {
        $cellphone = $request->route('cellphone');

        /** @var V2Sender $sender */
        $sender = $manager->driver();
        $sender->send($cellphone, view('sms', ['cellphone' => $cellphone]));

        return response()->noContent();
    }
}
