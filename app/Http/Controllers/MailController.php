<?php

namespace App\Http\Controllers;

use App\Jobs\SendScore;
use App\Reserve;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    /**
     *手动触发的方式发送邮件
     */
    public function index()
    {
        SendScore::dispatch()->onQueue('SendCode');
    }

}
