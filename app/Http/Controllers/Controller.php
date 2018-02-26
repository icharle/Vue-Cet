<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $url
     * @param $data
     * @param $referer
     * @return mixed
     * CURL通用方法
     */
    public function curl($url, $type = 'get', $data = '', $referer)
    {
        //伪造Ip
        $ip = mt_rand(1, 255) . "." . mt_rand(1, 255) . "." . mt_rand(1, 255) . "." . mt_rand(1, 255) . "";

        //Curl处理
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("CLIENT-IP:" . $ip . "", "X_FORWARD_FOR:" . $ip . ""));
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36");
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        if ($referer != '') {
            curl_setopt($curl, CURLOPT_REFERER, $referer);
        }
        if ($type = 'post') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * @param $input
     * @return mixed
     * 提取获取准考证的方法
     */
    public function GetTickets($input)
    {
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
        $result = $this->curl($url, 'post', $post, $referers);
        $res = json_decode($result, true);
        return $res;
    }


    /**
     * @param $input
     * @return array|bool
     * 提取获取成绩
     */
    public function GetScore($input)
    {
        $url = 'http://www.chsi.com.cn/cet/query?zkzh=' . $input['zkz'] . '&xm=' . urlencode($input['xm']);
        $referers = 'http://www.chsi.com.cn/cet/';
        $result = $this->curl($url, 'get', '', $referers);
        preg_match_all('/<table[^>]+>(.*)<\/table>/isU', $result, $matches);
        if (!isset($matches[0][1])) {
            return false;
        }
        preg_match_all('/(>)(.*?)(<)/s', $matches[0][1], $matches);
        $search = ['<', '>', '：', chr(13) . chr(10)];
        $replaceRes = str_replace($search, '', $matches[0]);
        foreach ($replaceRes as $value) {
            $arr[] = trim($value);
        }
        foreach (array_filter($arr) as $value) {
            $cetScores[] = $value;
        }
        return $cetScores;
    }
}
