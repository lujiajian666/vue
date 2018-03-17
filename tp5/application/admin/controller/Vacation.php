<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;


class Vacation extends Base
{
   private $tableVacation='vacation';
   private $tableWorkattendance="workattendance";
   private function getMonthTimeStamp($timestamp){
       $nowMonth=date("m",$timestamp);
       $nowYear=date("Y",$timestamp);
       $nextMonth=($nowMonth+1)>12?1:($nowMonth+1);
       $nextYear=$nextMonth==1?$nowYear+1:$nowYear;
       $startDate=strtotime(date("Y-m",$timestamp));
       $endDate =strtotime($nextYear."-".$nextMonth);
       $endDate =$endDate>strtotime(date("Y-m-d",time())."+1day")?strtotime(date("Y-m-d",time())."+1day"):$endDate;
       return array("start"=>$startDate,"end"=>$endDate);
   }
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
           $allTime=$val["status"]==1?$allTime+($val['end_time']-$val['begin_time']):$allTime+0;
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
       $table=Db::name($this->tableWorkattendance);
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
       $newData=[];
       //ljj 这个月的开始和结束
       $month=$this->getMonthTimeStamp($post["currentTime"]);
       $start=$month["start"];
       $end=$month["end"];
       //ljj 生成这个月的每日
       for($i=$start;$i<$end;$i+=86400){
           $arr=[];
           $arr["start"]=$arr["end"]=date("Y-m-d",$i);
           if(date("w",$i)!=0 && date("w",$i)!=6){
               $arr["title"]="旷工";
               $arr['cssClass']="absent";
               array_push($newData,$arr);
           }else{
               $arr["title"]="休息";
               $arr['cssClass']="normal";
               array_push($newData,$arr);
           }
       }
       $data=$Db->where(
           "username='$post[username]' and ".
                  "begin_work>=$start and begin_work<=$end"
                //  "begin_work<=$end"
       )->select();
       //ljj 正常，迟到，早退
       $add=[];
       foreach ($data as $k=>$v){
           $arr=[];
           $arr["start"]=$arr["end"]=date("Y-m-d",$v["today_time"]);
           if($v["end_work"]<strtotime($arr["end"]."+18hours") && $v["end_work"]!=""){
               for($i=$k;$i<count($newData);$i++){
                   if($newData[$i]["start"]==$arr["start"]){
                       $newData[$i]["title"]="早退";
                       $newData[$i]["cssClass"]="leaveEarly";
                       break;
                   }
               }
           }
           if($v["begin_work"]>strtotime($arr["start"]."+9hours") ){
               if($v["end_work"] != "" || $v["end_work"] == "" && time()<($v["today_time"]+3600*24)){
                   for($i=$k;$i<count($newData);$i++){
                   if($newData[$i]["start"]==$arr["start"]){
                       if($newData[$i]["title"]!="旷工"){
                           $arr["title"]="迟到";
                           $arr["cssClass"]="late";
                           array_push($add,$arr);
                       }else{
                           $newData[$i]["title"]="迟到";
                           $newData[$i]["cssClass"]="late";
                       }
                       break;
                   }
                   }
               }
               
           }
           if($v["begin_work"]<=strtotime($arr["start"]."+9hours")){
              
            if($v["end_work"]>strtotime($arr["end"]."+18hours") || $v["end_work"]<=strtotime($arr["end"]."+18hours") && time()<($v["today_time"]+3600*24)){
                for($i=$k;$i<count($newData);$i++){
                   if($newData[$i]["start"]==$arr["start"]){
                       $newData[$i]["title"]="正常";
                       $newData[$i]["cssClass"]="normal";
                       break;
                   }
               }
            }
           }
       }
       $newData=array_merge($newData,$add);
       return json(["data"=>$newData,"status"=>1]);
   }
   //ljj 休假审核显示数据
   public function applyVerify(){
       $this->authorityVerify();
       $Db=Db::name($this->tableVacation)->alias("a")->join('employee b','a.username=b.username');
       $data=$Db->where(["status"=>0])->field("a.begin_time,a.end_time,a.reason,a.status,b.name as username,a.id")
       ->order("a.time desc")->select();
       foreach ($data as &$v){
           $v["begin_time"]=date("Y-m-d",$v["begin_time"]);
           $v["end_time"]=date("Y-m-d",$v["end_time"]);
       }
       return json($data);
   }
   //ljj休假审核处理
   public function applyHandle(){
       $Db=Db::name($this->tableVacation);
       $post=$this->request->post();
       if($post["type"]=="ban"){
           $res=$Db->where(["id"=>$post["id"]])->update(["status"=>2]);
       }
       else{
           $res=$Db->where(["id"=>$post["id"]])->update(["status"=>1]);
       }

       if($res){
           return json(['status'=>1]);
       }else{
           return json(['status'=>0]);
       }

   }
   public static function authority(){
       return array(
           array(
               "name"=>"休假管理-休假申请审核",
               "controller"=>"Vacation",
               "action"    =>"applyVerify"
           )
       );
    }
}
