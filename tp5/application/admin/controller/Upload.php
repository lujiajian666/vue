<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;


header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin:http://localhost:20000');   // 指定允许其他域名访问



class Upload extends Controller
{
    public function upload(){
        $picRes = upload("file");
        $pic = ($picRes[1] == 1) ? $picRes[0] : "";
        return json(["pic"=>$pic]);
    }
    public function removePic(){
        $post=$this->request->post();
        $picUrl=explode("/",$post["picUrl"]);
        $picName=array_pop($picUrl);
        $picDir=array_pop($picUrl);
        if ($post["picUrl"] != "") {
            if(unlink("./pic/" . $picDir. "/" .$picName)){
                return json(["status"=>1]);
            }else{
                return json(["status"=>0]);
            }
        }
    }
}
