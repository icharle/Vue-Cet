<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PHPUnit\Framework\Error\Notice;
use Whoops\Exception\ErrorException;

class IndexController extends Controller
{
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
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("CLIENT-IP:" . $ip . "", "X_FORWARD_FOR:" . $ip . ""));
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36");
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_REFERER, $referer);
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
                    'msg' => '数据缺失,请完整输入个人信息！',
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
            $result = $this->curl($url, 'post', $post, $referers);
            $res = json_decode($result, true);
            if (isset($res['ks_bh'])) {
                return response()
                    ->json([
                        'status' => 200,
                        'msg' => [
                            'xm' => $input['xm'],
                            'sfz' => $input['sfz'],
                            'zkz' => $res['ks_bh']
                        ]
                    ]);
            } else {
                return response()
                    ->json([
                        'status' => 404,
                        'msg' => '未找到该考生准考证号码！'
                    ]);
            }
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 分数查询
     */
    public function Score()
    {
        $input = Input::all();
        if (!isset($input['xm']) || empty($input['xm']) || !isset($input['zkz']) || empty($input['zkz'])) {
            return response()
                ->json([
                    'status' => 403,
                    'msg' => '数据缺失,请完整输入个人信息！',
                ]);
        } else {
            $url = 'http://www.chsi.com.cn/cet/query?zkzh=' . $input['zkz'] . '&xm=' . urlencode($input['xm']);
            $referers = 'http://www.chsi.com.cn/cet/';
            $result = $this->curl($url, 'get', '', $referers);
            preg_match_all('/<table[^>]+>(.*)<\/table>/isU', $result, $matches);
            if (isset($matches)){
                return response()
                    ->json([
                        'status' => 500,
                        'msg' => '服务暂不可用！'
                    ]);
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
            if (isset($cetScores[16])) {
                return response()
                    ->json([
                        'status' => 200,
                        'msg' => [
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
                            ]]
                    ]);
            } else {
                return response()
                    ->json([
                        'status' => 404,
                        'msg' => '未找到该考生成绩！'
                    ]);
            }
        }
    }
}
