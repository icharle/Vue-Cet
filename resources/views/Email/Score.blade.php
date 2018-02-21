<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>四六级成绩推送</title>
</head>
<body>
<h1>成绩单</h1>
<div>{{$data['name']}}</div>


{{--name' => (string)$cetScores[3],      //姓名
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
                    ]--}}
</body>
</html>