<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

header('content-type:application:json;charset=utf8');
header('Access-Control-Allow-Origin:*');   // 指定允许其他域名访问
header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置

class Vacation extends Controller
{
   private $tableVacation='vacation';
   private $tableWorkattendance="workattendance";
   public function addVacation(){
     $post=$this->request->post();
     $arr=array(
       "begin_time"=>$post["begin_time"],
       "end_time"=>$post["end_time"],
       "reason"=>$post["reason"],
       "time"=>time(),
       "username"=>$post["username"]
     );
     $vacation=Db::name($this->tableVacation);
     if($vacation->insert($arr)){
       return json(["status"=>1]);
     }else{
       return json(["status"=>0]);
     }
   }
   public function getVacation(){
       $vacation=Db::name($this->tableVacation);
       $post=$this->request->post();
       $data=$vacation->where("username='$post[username]'")->select();
       $allTime=0;
       foreach ($data as $key=>&$val){
           $allTime+=($val['end_time']-$val['begin_time']);
           $val["begin_time"]=date("y-m-d",$val["begin_time"]);
           $val["end_time"]=date("y-m-d",$val["end_time"]);
           $val["time"]=date("y-m-d",$val["time"]);
           switch ($val["status"]) {
               case 0:
                   $val["status"] = "未读";
                   break;
               case 1:
                   $val["status"] = "批准";
                   break;
               case 2:
                   $val["status"] = "驳回";
                   break;
           }
       }unset($key);unset($val);
       return json(['data'=>$data,'allTime'=>$allTime]);
   }
   public function addAttendance(){
       $table=Db::name($this->tableWorkattendance);
       $post=$this->request->post();
       $data=array(
           "today_time"=>strtotime(date("y-m-d"))
       );
       $res=$table->where(["username"=>$post["username"],"today_time"=>$data["today_time"]])
           ->count();
       if($res){
           $res=$table->where(["username"=>$post["username"],"today_time"=>$data["today_time"]])
               ->update(["end_work"=>time()]);
           if($res){
               return json(["status"=>1,"txt"=>"签退成功"]);
           }else{
               return json(["status"=>0,"txt"=>"签退失败"]);
           }
       }else{
           $data["begin_work"]=time();
           $data["username"]=$post["username"];
           if($table->insert($data)){
               return json(["status"=>1,"txt"=>"签到成功"]);
           }else{
               return json(["status"=>0,"txt"=>"签到失败"]);
           }
       }


   }
   public function getAttendance(){
       $Db=Db::name($this->tableWorkattendance);
       $post=$this->request->post();
       $data=$Db->where(["username"=>$post["username"]])->select();
       $newData=[];
       foreach ($data as $k=>$v){
           $arr=[];
           $arr["start"]=date("Y-m-d",$v["begin_work"]);
           $arr["end"]=date("Y-m-d",$v["end_work"]);
           $arr["title"]="";
           if($v["begin_work"]>strtotime($arr["start"]."+9hours")){
               $arr["title"]="迟到";
               array_push($newData,$arr);
           }
           if($v["end_work"]<strtotime($arr["end"]."+18hours")){
               $arr["title"]="早退";
               array_push($newData,$arr);
           }

       }
       return json(["data"=>$newData,"status"=>1]);
   }
}
