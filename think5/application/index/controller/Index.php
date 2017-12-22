<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

header('content-type:application:json;charset=utf8');
header('Access-Control-Allow-Origin:*');   // 指定允许其他域名访问
header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置

class Index extends Controller
{
    private $tableName="member";
    public function index()
    {

       $post=$this->request->post();
////       dump($post);
       $db=Db::name($this->tableName);
       empty($post["username"])?$post["username"]=null:1;
       empty($post["password"])?$post["password"]=null:1;

       $data=$db->where("username",$post["username"])->
                  where("password",$post["password"])->find();



       if($data!=null){
           return json(["status"=>1,"username"=>$post["username"]]);
       }else{
           return json(["status"=>0]);
       }

    }
}
