<?php

namespace App\Jobs;

use App\Http\Controllers\Controller;
use App\Reserve;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Mail;

class SendScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reserves = Reserve::all();
        $Controller = new Controller();
        foreach ($reserves as $reserve) {
            if ($reserve->ticket != 'undefined' && $reserve->issend == '0') {           //存在准考证并且没有发送过
                $data['xm'] = $reserve->username;
                $email = $reserve->email;
                $data['zkz'] = $reserve->ticket;
                $cetScores = $Controller->GetScore($data);      //重点
                if ($cetScores != false && isset($cetScores[16])) {                        //能够查询成功才执行发送邮件
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
                    Mail::to($email)->send(new \App\Mail\SendScore($res));
                    Reserve::where('username', $reserve->username)->update(['issend' => 1]);            //记录已经发送
                }
                sleep(10);
            }
        }
    }
}
