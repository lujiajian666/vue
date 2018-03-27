<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;


class Department extends Base
{
   private $tableDepartment='department';
   private $tableJobTitle="job_title";

   public function addDepartment(){
       $this->authorityVerify();
       $post=$this->request->post();
       $db=Db::name($this->tableDepartment);
       $old=$db->where("name='$post[name]'")->count();
       if($old>0){
           return json(["status"=>0,"txt"=>"已有相同部门名"]);
       }
       $data=array(
         "name"=>$post["name"]
       );
       $db=Db::name($this->tableDepartment);
       $res=$db->insert($data);
       if($res){
           return json(["status"=>1]);
       }else{
           return json(["status"=>0,"txt"=>"网络错误"]);
       }
   }
   public function editDepartment(){
       $this->authorityVerify();
       $post=$this->request->post();
       $db=Db::name($this->tableDepartment);
       $old=$db->where("name='$post[name]'")->count();
       if($old>0){
           return json(["status"=>0,"txt"=>"已有相同部门名"]);
       }
       $data=array(
           "name"=>$post["name"]
       );
       
       $res=Db::name($this->tableDepartment)->where(["id"=>$post["id"]])->update($data);
       if($res!==false){
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
       $old=$db->where("title='$post[title]' and department_id=$post[department_id]")->count();
       if($old>0){
           return json(["status"=>0,"txt"=>"该部门下已有相同职务"]);
       }
       $data=array(
           "salary"=>$post["salary"],
           "title"=>$post["title"],
           "department_id"=>$post["department_id"]
       );
       $res=Db::name($this->tableJobTitle)->insert($data);
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
       $old=$db->where("title='$post[title]' and department_id=$post[department_id]")->count();
       if($old>0){
           return json(["status"=>0,"txt"=>"该部门下已有相同职务"]);
       }
       $data=array(
           "title"=>$post["title"],
           "salary"=>$post["salary"]
       );
       $res=Db::name($this->tableJobTitle)->where(["id"=>$post["id"]])->update($data);
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
