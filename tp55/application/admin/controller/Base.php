<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;


header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin:http://localhost:20000');   // 指定允许其他域名访问



class Base extends Controller
{
    public function __construct()
    {
        session_start();
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
            exit;
        }
        parent::__construct();
        //ljj 用户名认证
        $controller=strtolower($this->request->controller());
        $action=strtolower($this->request->action());
        if($controller=="background" && $action=="index"){
                ;
        }else{
//            dump($_SESSION["username"]);
            $user=isset($_SESSION["username"]) && !empty($_SESSION["username"]);
            if(!$user){
               die("no_login");
            }
        }
    }

    public function authorityVerify(){
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
            exit;
        }
        //ljj先找出所有有限制的权限项
        $db_authority_item=Db::name("authority_item");
        $authority_item_arr=$db_authority_item->select();
        $verify=[];
        foreach ($authority_item_arr as $value){
            if(empty($verify[$value["controller"]])){
                $verify[$value["controller"]]=[];
            }
            $verify[$value["controller"]][strtolower($value["action"])]=$value["name"];
        }
      //  dump($_COOKIE);
        $session_authority=unserialize($_SESSION["authority"]);
        //dump($session_authority);
        $controller=$this->request->controller();
        $action=$this->request->action();

        if(isset($verify[$controller][$action]) && !isset($session_authority[$controller][$action])){
            die("no_permit");
        }
    }
}
