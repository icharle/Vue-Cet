<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    /**
     * @param $url
     * @param $data
     * @param $referer
     * @return mixed
     * CURL通用方法
     */
    public function curl($url, $data, $referer)
    {
        //伪造Ip
        $ip = mt_rand(1, 255) . "." . mt_rand(1, 255) . "." . mt_rand(1, 255) . "." . mt_rand(1, 255) . "";

        //Curl处理
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("CLIENT-IP:" . $ip . "", "X_FORWARD_FOR:" . $ip . ""));
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36");
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_REFERER, $referer);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 查询准考证
     */
    public function Tickets()
    {
        $input = Input::all();
        if (!isset($input['xm']) || empty($input['xm']) || !isset($input['sfz']) || empty($input['sfz']) || !isset($input['jb']) || empty($input['jb'])) {
            return response()
                ->json([
                    'status' => 403,
                    'message' => '数据缺失,请完整输入个人信息！',
                ]);
        } else {
            $url = 'http://app.cet.edu.cn:7066/baas/app/setuser.do?method=UserVerify';
            $referers = 'http://app.cet.edu.cn:7066/baas/app/setuser.do?method=UserVerify';
            $data = array(
                'ks_xm' => $input['xm'],
                'ks_sfz' => $input['sfz'],
                'jb' => $input['jb']
            );
            $post = array(
                'action' => '',
                'params' => json_encode($data)
            );
            $result = $this->curl($url, $post, $referers);
            $res = json_decode($result, true);
            if (isset($res['ks_bh'])) {
                return response()
                    ->json([
                        'status' => 200,
                        'xm' => $input['xm'],
                        'zkz' => $res['ks_bh']
                    ]);
            } else {
                return response()
                    ->json([
                        'status' => 500,
                        'xm' => $input['xm'],
                        'zkz' => '未找到该考生准考证号码！'
                    ]);
            }
        }

    }
}
