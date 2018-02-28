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

class ToTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $username;
    protected $idcard;
    protected $level;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($username, $idcard, $level)
    {
        $this->username = $username;
        $this->idcard = $idcard;
        $this->level = $level;
    }

    /**
     * Execute the job.
     *
     * @return void
     * 将所有身份证转成准考证
     */
    public function handle()
    {
        //采用接口方法
//        $res = array();
//        if (strlen($this->idcard) == 18) {                          //如果为身份证先转换成准考证  否则直接入库
//            $Controller = new Controller();
//            $data['xm'] = $this->username;
//            $data['sfz'] = $this->idcard;
//            $data['jb'] = $this->level;
//            $result = $Controller->GetTickets($data);
//            if (isset($result['ks_bh'])) {
//                $res['ticket'] = $result['ks_bh'];
//            } else {
//                $res['ticket'] = 'undefined';                       //查询不到准考证 返回undefined  方便后续查成绩
//            }
//        } else {
//            $res['ticket'] = $this->idcard;
//        }
//        Reserve::where('username', $this->username)->update($res);

        //采用暴力方法
        $res = array();
        if (strlen($this->idcard) == 6) {
            $Controller = new Controller();
            $data['xm'] = $this->username;
            $data['school'] = $this->idcard;
            $data['jb'] = $this->level;
            $result = $Controller->GetTicketPlus($data);
            if ($result != 0) {
                $res['ticket'] = $result;
            } else {
                $res['ticket'] = 'undefined';
            }
        } else if (strlen($this->idcard) == 15) {
            $res['ticket'] = $this->idcard;
        }
        Reserve::where('username', $this->username)->update($res);
    }
}
