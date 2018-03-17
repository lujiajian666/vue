<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;


class Advice extends Base
{
    private $tableAdvice='advice';
    public function addAdvice(){
        $db=Db::name($this->tableAdvice);
        $post=$this->request->post();
        $arr=array(
            "type"=>$post["type"],
            "title"=>$post["title"],
            "detail"=>$post["detail"],
            "time"=>time()
        );
        $res=$db->insert($arr);
        if($res!==false){
            return json(["status"=>1]);
        }else{
            return json(["status"=>0]);
        }
    }
    public function getAdvice(){
        $this->authorityVerify();
        $db=Db::name($this->tableAdvice);
        $post=$this->request->post();
        $page=$post["page"];
        $total=$db->where(["type"=>"advice"])->count();
        $db=Db::name($this->tableAdvice);
        $advice=$db->where(["type"=>"advice"])->limit(($page-1)*10,10)->select();
        foreach($advice as &$item){
            $item["time"]=date("Y-m-d H:m",$item["time"]);
        }
        return json(["total"=>ceil($total/10),"advice"=>$advice]);
    }
    public function delete(){
        $this->authorityVerify();
        $db=Db::name($this->tableAdvice);
        $post=$this->request->post();
        $res=$db->where(["id"=>$post["id"]])->delete();
        if($res!== false){
            return json(["status"=>1]);
        }else{
            return json(["status"=>0]);            
        }
    }
    public function getComplaint(){
        $db=Db::name($this->tableAdvice);
        $post=$this->request->post();
        $page=$post["page"];
        $total=$db->where(["type"=>"complaint"])->count();
        $db=Db::name($this->tableAdvice);
        $complaint=$db->where(["type"=>"complaint"])->limit(($page-1)*10,10)->select();
        foreach($complaint as &$item){
            $item["time"]=date("Y-m-d H:m",$item["time"]);
        }
        return json(["total"=>ceil($total/10),"complaint"=>$complaint]);
    }
    public static function authority(){
        return array(
            array(
                "name"=>"投诉建议-查看",
                "controller"=>"Advice",
                "action"=>"getAdvice"
            ),
            array(
                "name"=>"投诉建议-删除",
                "controller"=>"Advice",
                "action"=>"delete"
            )
        );
    }
}
