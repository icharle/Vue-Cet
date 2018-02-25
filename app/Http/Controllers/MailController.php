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
        $reserves = Reserve::all();
        foreach ($reserves as $reserve) {
            if ($reserve->ticket != 'undefined'){
                $data['xm'] = $reserve->username;
                $email = $reserve->email;
                $data['zkz'] = $reserve->ticket;
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
                SendScore::dispatch($email, $res)->onQueue('SendCode');
            }
        }
    }
}
