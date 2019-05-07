<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class Gltenmin
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
//        echo date('Y-m-d H:i:s',time());
        $aa = $_SERVER['REMOTE_ADDR'];
        $key = "gltens:ip:".$aa."uid:".$request->uid."token:".$request->token;
        $num = Redis::get($key);
        if($num>10){
            $respon = [
                'error'=>40003,
                'msg'=>"请求超出限制"
            ];
            die(json_encode($respon,JSON_UNESCAPED_UNICODE));
        }
        Redis::incr($key);
        Redis::expire($key,10);
        return $next($request);
    }
}
