<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserApiController extends Controller
{
    //get 传值
    public function userinfo(Request $request)
    {
        //调用接口

        $url  = "http://1809a.api_test.com/api/u?uid=".$request->uid;
        $ch = curl_init();    //创建一个新的curl 资源
        //设置url和相对应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); //将返回的结果不直接显示在页面上
        //抓取url并把它传给浏览器
        $res = curl_exec($ch);
        $code = curl_errno($ch);
        dump(json_decode(base64_decode($res),true));
        //关闭curl资源，并且释放系统资源
        curl_close($ch);
    }
    //post 传值
    public function user_post()
    {
        //调用接口
        $url  = "http://1809a.api_test.com/test/post";
        $ch = curl_init();//创建一个新的curl 资源
        //默认格式为application/x-www-form-urlencoded
        $str_post = "nickname=zhangsan&email=zhangsan@qq.com";
        $str_arr = [
            'name'=>"qqqq",
            'email'=>'qq@qq.com'
        ];
//        dd($str_arr);
        //设置url和相对应的资源
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);//将返回的结果不直接显示在页面上
        curl_setopt($ch,CURLOPT_POSTFIELDS,$str_post);
        //抓取url并把他传给浏览器
        $res = curl_exec($ch);
        $code =curl_errno($ch);
        //关闭curl资源，并且释放系统资源
        dump(json_decode(base64_decode($res),true));
        curl_close($ch);
    }
    //传值
    public function user_post_r()
    {
        //调用接口
        $url = "http://1809a.api_test.com/test/post_raw";
        $ch = curl_init();//建一个新的资源
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        $str_arr = [
            'name'=>"qqqq",
            'email'=>'qq@qq.com'
        ];
        $str_json = json_encode($str_arr);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //raw--------------------------------
        curl_setopt($ch,CURLOPT_POSTFIELDS,$str_json);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);

        //抓取url并把它传给浏览器
        $res = curl_exec($ch);
        $code = curl_errno($ch);
//        echo $code;
//        echo "<hr>";
        dump(json_decode(base64_decode($res),true));
        //关闭curl资源并且释放系统资源
        curl_close($ch);
    }
}
