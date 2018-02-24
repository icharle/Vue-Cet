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
                // SendScore::dispatch($res['ks_bh']);
//                $data['zkz'] = $res['ks_bh'];
//                $res = $this->GetScore($data);
//                SendScore::dispatch($res[16]);
            } else {
                $data['xm'] = $reserve->username;
                $email = $reserve->email;
                $data['zkz'] = $reserve->idcard;
                $cetScores = $this->GetScore($data);
                $res = array(
                    'name' => (string)$cetScores[3],      //姓名
                    'school' => (string)$cetScores[7],     //学校
                    'type' => (string)$cetScores[9],       //四级or六级
                    'written' => [                                              //笔试部分
                        'number' => (string)$cetScores[12],    //准考证号码
                        'score' => (int)$cetScores[16],        //总分
                        'listening' => (int)$cetScores[20],     //听力
                        'reading' => (int)$cetScores[24],       //阅读
                        'translation' => (int)$cetScores[26]        //翻译
                    ],
                    'oral' => [                                                 //口语部分
                        'number' => (string)$cetScores[29],         //准考证号
                        'score' => (string)$cetScores[33]           //等 级
                    ]);
                //dd($res);
                SendScore::dispatch($res,$email);
            }
        }

    }

    public function SendMail()
    {
        Mail::to('1006188966@qq.com')->send(new \App\Mail\SendScore());
    }

    public function SendQueue()
    {
        for ($i = 0; $i <= 100; $i++) {
            SendScore::dispatch($i);
        }
    }
}
