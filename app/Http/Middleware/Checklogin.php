<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class Checklogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dd($_SERVER);
        $token = $request->token;
        $uid = $request->uid;
        //判断是否为空
        if(empty($token) || empty($uid)){
            $respon = [
                'error'=>50010,
                'msg'=>"缺少参数"
            ];
            die(json_encode($respon,JSON_UNESCAPED_UNICODE));
        }
        //判断用户的token
        $key="uid:".$uid;
        $l_token = Redis::get($key);
        if($l_token){
            if($l_token!=$token){
                $respon = [
                    'error'=>50012,
                    'msg'=>"该token无效！"
                ];
                die(json_encode($respon,JSON_UNESCAPED_UNICODE));
            }else{
                //TODO 写入日志
//                dd($_SERVER);
                $str = date('Y-m-d H:i:s',time())."\n"."用户id为:".$uid."的用户访问".$_SERVER['REQUEST_URI']."\n"."\n"."\n";
                file_put_contents('log/api.log',$str,FILE_APPEND);
            }
        }else{
            $respon = [
                'error'=>50011,
                'msg'=>"请先登录！"
            ];
            die(json_encode($respon,JSON_UNESCAPED_UNICODE));
        }
        return $next($request);
    }
}
