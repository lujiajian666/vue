<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;


class Base extends Controller
{
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
        $session_authority=unserialize($_COOKIE["authority"]);
        //dump($session_authority);
        $controller=$this->request->controller();
        $action=$this->request->action();

        if(isset($verify[$controller][$action]) && !isset($session_authority[$controller][$action])){
            die("no_permit");
        }
    }
}
