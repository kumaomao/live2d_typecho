<?php
/**
 * Created by PhpStorm.
 * User: k
 * Date: 2019/4/3
 * Time: 17:02
 */

//一言数据处理
class Hitokoto
{
    //一言接口
    private static $hitokoto = [
        'lwl12'=>[
            'https://api.lwl12.com/hitokoto/v1?encode=realjson',
            '这句一言来自 <span style=\"color:#0099cc;\">『{source}』</span>"。'
        ],
        'fghrsh'=>[
            'https://api.fghrsh.net/hitokoto/rand/?encode=jsc&uid=3335',
            '这句一言出处是 <span style=\"color:#0099cc;\">『{source}』</span>'
        ],
        '_hitokoto'=>[
            'https://v1.hitokoto.cn',
            '这句一言来自 <span style=\"color:#0099cc;\">『{source}』</span>。'
        ]
    ];
    public static function get_hitokoto($hitokoto_key){
        if(isset(self::$hitokoto[$hitokoto_key])){
            $url = self::$hitokoto[$hitokoto_key][0];
            $json = file_get_contents($url);
            $result = self::$hitokoto_key($json);
            $_result = [
                'data'=>$result,
                'template'=>self::$hitokoto[$hitokoto_key][1]
            ];
            return json_encode($_result);
        }
    }

    public static function get_key($key = false){
        $arr = array_keys(self::$hitokoto);
        if($key !== false){
            return isset($arr[$key])?$arr[$key]:false;
        }
        return $arr;

    }

    private static function lwl12($json){
        $arr = json_decode($json, true);
         return $arr;
    }

    private static function fghrsh($json){
        //返回值有();
        $json = ltrim($json,'(');
        $json = rtrim($json,');');
        $arr = json_decode($json, true);
        $res = [
            'text'=>$arr['hitokoto'],
            'source'=>$arr['source']
        ];
        return $res;
    }

    private static function _hitokoto($json){
        $arr = json_decode($json, true);
        $res = [
            'text'=>$arr['hitokoto'],
            'source'=>$arr['from']
        ];
        return $res;
    }



}


if(!empty($_GET['key'])){
    $key = $_GET['key'];
    $key--;
    $key = Hitokoto::get_key($key);
    if($key){
        echo Hitokoto::get_hitokoto($key);
    }
}
