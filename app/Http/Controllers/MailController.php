<?php

namespace App\Http\Controllers;

use App\Mail\SendScore;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function SendMail()
    {
        Mail::to('1006188966@qq.com')->send(new SendScore());
    }
}
