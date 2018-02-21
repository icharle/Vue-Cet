<?php

namespace App\Http\Controllers;

use App\Jobs\SendScore;
use App\Reserve;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function index()
    {
        $reserves = Reserve::all();
        foreach ($reserves as $reserve) {
            if (strlen($reserve->idcard) == 18) {
                $data['xm'] = $reserve->username;
                $data['sfz'] = $reserve->idcard;
                $data['jb'] = $reserve->level;
                $res = $this->GetTickets($data);
                SendScore::dispatch($res['ks_bh']);
//                $data['zkz'] = $res['ks_bh'];
//                $res = $this->GetScore($data);
//                SendScore::dispatch($res[16]);
            }else{
                $data['xm'] = $reserve->username;
                $data['zkz'] = $reserve->idcard;
                $res = $this->GetScore($data);
                SendScore::dispatch($res[16]);
            }
        }

    }

    public function SendMail()
    {
        Mail::to('1006188966@qq.com')->send(new SendScore());
    }

    public function SendQueue()
    {
        for ($i = 0; $i <= 100; $i++) {
            SendScore::dispatch($i);
        }
    }
}
