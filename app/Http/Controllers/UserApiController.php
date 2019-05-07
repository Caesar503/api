<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
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

    //注册
    public function reg(Request $request)
    {
//        dump($request->all());
        $name = $request->name;
        $pass1 = $request->pass1;
        $pass2 = $request->pass2;
        $email = $request->email;
        $age = $request->age;
        //判断密码
        if($pass1!=$pass2){
            $respon = [
                'error'=>5001,
                "msg"=>"密码必须一致"
            ];
            die(json_encode($respon,JSON_UNESCAPED_UNICODE));
        }
        //判断邮箱存在不存在
        $res = User::where('email',$email)->first();
        if($res){
            $respon = [
                'error'=>5002,
                "msg"=>"邮箱已经存在"
            ];
            die(json_encode($respon,JSON_UNESCAPED_UNICODE));
        }
        //添加入库
        $pass = password_hash($pass1,PASSWORD_BCRYPT);
//        $2y$10$7PJgtasFy9p6.tsOtH6BBuvLSMamYFF.AsJ4P5XJNwKKYOP3XHXY6
        $data = [
            'username'=>$name,
            'pass'=>$pass,
            'email'=>$email,
            'age'=>$age
        ];
        $n = User::insertGetId($data);
        if($n){
            $respon = [
                'error'=>0,
                "msg"=>"注册成功"
            ];
            die(json_encode($respon,JSON_UNESCAPED_UNICODE));
        }else{
            $respon = [
                'error'=>5003,
                "msg"=>"注册存在"
            ];
            die(json_encode($respon,JSON_UNESCAPED_UNICODE));
        }
    }
    //登录
    public function login(Request $request)
    {
//       dd($request->all());
        $email = $request->email;
        $pass = $request->pass;
        //查询邮箱在不在
        $res = User::where('email',$email)->first();
        if($res){                         //该用户存在
            //TODO
//            echo $res['pass'];die;
            if(!password_verify($pass,$res->pass)){
                $respon=[
                    'error'=>5004,
                    'msg'=>"密码错误"
                ];
                die(json_encode($respon,JSON_UNESCAPED_UNICODE));
            }else{
                //生成用户token
                $token = $this->getUserToken($res->id);
                //存储redis
                $key="uid:".$res->id;
                Redis::set($key,$token);
                Redis::expire($key,7*3600*24);
                $respon=[
                    'error'=>0,
                    'msg'=>"登陆成功",
                    'token'=>$token,
                ];
                die(json_encode($respon,JSON_UNESCAPED_UNICODE));
            }
        }else{                          //该用户不存在
            //TODO
                $respon=[
                    'error'=>5004,
                    'msg'=>"该用户不存在"
                ];
                die(json_encode($respon,JSON_UNESCAPED_UNICODE));
        }
    }
    //生成用户token
    function getUserToken($id){
        return substr($id.time().Str::random(10),0,15);
    }

    //生成器
    public function aaa()
    {
        return view('aaa.aaa');
    }
    //闭包
    public function bbb()
    {
        return view('aaa.bbb');
    }
}
