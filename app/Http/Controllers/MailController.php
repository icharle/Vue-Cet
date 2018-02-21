<?php

namespace App\Http\Controllers;

use App\Jobs\SendScore;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function SendMail()
    {
        Mail::to('1006188966@qq.com')->send(new SendScore());
    }

    public function SendQueue()
    {
        for ($i = 0; $i <= 100; $i++) {
            dispatch(new SendScore($i));
        }
    }
}
