<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

header('content-type:application:json;charset=utf8');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin:http://127.0.0.1:20000');   // 指定允许其他域名访问
header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置

class Message extends Base
{
   private $tableMessage='message';
   private $tableMessageEmployee="message_employee";

   public function getMessageCount(){
       $count=Db::name($this->tableMessage)->alias("a")
           ->join("message_employee b","a.id = b.message_id","LEFT")
           ->field("a.id as message_id,detail,deadline,status")// status： Null,1 未读，已读
           ->where("b.status!=''")
           ->count();

       return json(["count"=>$count]);
   }
   public function getMessage(){
       $data=Db::name($this->tableMessage)->alias("a")
           ->join("message_employee b","a.id = b.message_id","LEFT")
           ->field("a.id as message_id,title,detail,deadline,status")// status： Null,1 未读，已读
           ->where("b.status!='' ")
           ->select();

       return json($data);
   }
   public function addMessage(){
       $this->authorityVerify();
       $post=$this->request->post();
       $db=Db::name($this->tableDepartment);
       $data=array(
         "name"=>$post["name"]
       );
       $res=$db->insert($data);
       if($res){
           return json(["status"=>1]);
       }else{
           return json(["status"=>0]);
       }
   }
   public function editMessage(){
       $this->authorityVerify();
       $post=$this->request->post();
       $db=Db::name($this->tableDepartment);
       $data=array(
           "name"=>$post["name"]
       );
       $res=$db->where(["id"=>$post["id"]])->update($data);
       if($res){
           return json(["status"=>1]);
       }else{
           return json(["status"=>0]);
       }
   }
   public function deleteMessage(){
       $this->authorityVerify();
       $post=$this->request->post();
       $db=Db::name($this->tableDepartment);
       $res=$db->where(["id"=>$post["id"]])->delete();
       if($res){
           Db::name("job_title")->where(["department_id"=>$post["id"]])->delete();
           return json(["status"=>1]);
       }else{
           return json(["status"=>0]);
       }
   }



   public static function authority(){
       return array(
           array(
               "name"=>"添加部门",
               "controller"=>"Department",
               "action"    =>"addDepartment"
           ),
           array(
               "name"=>"修改部门",
               "controller"=>"Department",
               "action"    =>"editDepartment"
           ),
           array(
               "name"=>"删除部门",
               "controller"=>"Department",
               "action"    =>"deleteDepartment"
           ),
           array(
               "name"=>"添加职务",
               "controller"=>"Department",
               "action"    =>"addJobTitle"
           ),
           array(
               "name"=>"修改职务",
               "controller"=>"Department",
               "action"    =>"editJobTitle"
           ),
           array(
               "name"=>"删除职位",
               "controller"=>"Department",
               "action"    =>"deleteJobTitle"
           )
       );
    }
}
