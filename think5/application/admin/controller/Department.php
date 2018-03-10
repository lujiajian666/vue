<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

header('content-type:application:json;charset=utf8');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin:http://127.0.0.1:20000');   // 指定允许其他域名访问
header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置

class Department extends Base
{
   private $tableDepartment='department';
   private $tableJobTitle="job_title";

   public function addDepartment(){
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
   public function editDepartment(){
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
   public function deleteDepartment(){
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

   public function addJobTitle(){
       $this->authorityVerify();
       $post=$this->request->post();
       $db=Db::name($this->tableJobTitle);
       $data=array(
           "salary"=>$post["salary"],
           "title"=>$post["title"],
           "department_id"=>$post["department_id"]
       );
       $res=$db->insert($data);
       if($res){
           return json(["status"=>1]);
       }else{
           return json(["status"=>0]);
       }
   }
   public function editJobTitle(){
       $this->authorityVerify();
       $post=$this->request->post();
       $db=Db::name($this->tableJobTitle);
       $data=array(
           "title"=>$post["title"],
           "salary"=>$post["salary"]
       );
       $res=$db->where(["id"=>$post["id"]])->update($data);
       if($res){
           return json(["status"=>1]);
       }else{
           return json(["status"=>0]);
       }
   }
   public function deleteJobTitle(){
       $this->authorityVerify();
       $post=$this->request->post();
       $db=Db::name($this->tableJobTitle);
       $res=$db->where(["id"=>$post["id"]])->delete();
       if($res){
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
