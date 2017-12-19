<?php
namespace app\index\controller;
use think\Controller;

header('content-type:application:json;charset=utf8');
header('Access-Control-Allow-Origin:*');   // 指定允许其他域名访问
header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置

class Index extends Controller
{
    public function index()
    {
       $post=$this->request->post();
       return json(['url'=>url('index/index/index')]);
//       return $post["username"];
    }
}
