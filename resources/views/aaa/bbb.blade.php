<?php
$test = function($name){
  return sprintf('hellow '.$name);
};
 echo $test('赵恺');
echo "<hr>";



 //使用闭包 、具名函数 、 附加状态
//具名函数
function app1($name){
    //闭包
    return function($where) use ($name){
        return sprintf('%s,%s',$where,$name);
        //return sprintf($where.','.$name);
    };
};
$aaa = app1('赵恺');
echo $aaa('在北京的');

echo "<hr>";
class A{
    public static $num=0;
    public function __construct(){
        self::$num++; }
}
new A();
new A();
new A();
echo A::$num;