<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;


class Authority extends Base
{
   private $tableAuthorityItem="authority_item";
   private $tableRole="role";
   private $tableRoleItem="role_item";
   public function getAuthority(){
       $this->authorityVerify();
      if($this->request->post("type")=="role"){
          $Db=Db::name($this->tableAuthorityItem);
          $arr=$Db->select();
          return json($arr);
      } else{
          $ArticleA=Article::authority();
          $AuthorityA=Authority::authority();
          $BackgroundA=Background::authority();
          $VacationA=Vacation::authority();
          $Department=Department::authority();
          $Advice=Advice::authority();
          $arr=[];
          $arr=array_merge($arr,$ArticleA,$BackgroundA,$AuthorityA,$VacationA,$Department,$Advice);

          foreach ($arr as $k=>&$value){
              $value["id"]=$k;
          }unset($value);unset($key);
          $Db=Db::name($this->tableAuthorityItem);
          $arr2=$Db->field("id")->select();
          $arr3=[];
          foreach ($arr2 as $value){
              $arr3[]=$value["id"];
          }

          return json(["allData"=>$arr,"selectData"=>$arr3]);
      }

   }
   public function saveAuthority(){
       $this->authorityVerify();
      $post=$this->request->post();
      $arr=array();

      $post=json_decode($post["data"]);
      foreach ($post as $value){
          array_push($arr,array(
              "id"=>$value->id,
              "controller"=>$value->controller,
              "action"=>$value->action,
              "name"=>$value->name)
          );
      }
      $Db=Db::name($this->tableAuthorityItem);
      $Db->where("id!=-1")->delete();
      if($Db->insertAll($arr)!==false || count($arr)==0){
          return json(["status"=>1]);
      }else{
          return json(["status"=>0,"reason"=>$Db->getLastSql()]);
      }
   }
   public function getRole(){
       $this->authorityVerify();
       $db=Db::name($this->tableRole);
       return json($db->select());
   }
   public function addRole(){
       $this->authorityVerify();
       $post=$this->request->post();
       $db=Db::name($this->tableRole);
       $data=array(
           "name"=>$post["name"],
           "detail"=>$post["desc"]
       );
       if($db->insert($data)){
           return json(["status"=>1]);
       }else{
           return json(["status"=>0]);
       }
   }
   public function deleteRole(){
       $this->authorityVerify();
       $post=$this->request->post();
       $Db=Db::name($this->tableRole);
       if($Db->where("role_id = $post[role_id]")->delete()){
           return json(["status"=>1]);
       }else{
           return json(["status"=>0,"reason"=>$Db->getLastSql()]);
       }
   }
   public function editRole(){
       $this->authorityVerify();
       $post=$this->request->post();
       $db=Db::name($this->tableRoleItem);
       $res=$db->where("role_id = $post[role_id]")->select();
       if($res!==false){
           $arr=[];
           foreach ($res as $value){
               $arr[]=$value["authority_item_id"];
           }
           return json(["status"=>1,"value"=>$arr]);
       }else{
           return json(["status"=>0]);
       }

   }
   public function saveRoleItem(){
       $this->authorityVerify();
       $post=$this->request->post();
       $arr=array();
       $role_id=$post["role_id"];
       $post=json_decode($post["data"]);

       foreach ($post as $value){
           array_push($arr,array(
                   "role_id"=>$role_id,
                   "authority_item_id"=>$value->authority_item_id
           ));
       }
       $Db=Db::name($this->tableRoleItem);
       $Db->where("role_id=$role_id")->delete();
       if($Db->insertAll($arr)!==false || count($arr)==0){
           return json(["status"=>1]);
       }else{
           return json(["status"=>0,"reason"=>$Db->getLastSql()]);
       }
   }
   public function applyRole(){
       $post=$this->request->post();
       $db=Db::name("employee");
       if($post["type"]=="department"){
           $res=$db->where("department_id = $post[value]")->update(["role"=>$post["role_id"]]);
       }else{
           $res=$db->where("id","in",$post["value"])->update(["role"=>$post["role_id"]]);
       }
       if($res!==false){
           return json(["status"=>1]);
       }else{
           return json(["status"=>0,"reason"=>$db->getLastSql()]);
       }
   }
   public function search(){
       $post=$this->request->post();
       $db=Db::name("employee");
       $sql="name like '%".trim($post["name"])."%'";
       $res=$db->where($sql)->select();
       foreach ($res as &$v){
           $v["time"]=date("Y-m-d",$v["time"]);
       }
       return json(["data"=>$res,"sql"=>$db->getLastSql()]);
   }
   public static function authority(){
       return array(
           array(
               "name"=>"权限管理-基本权限查看",
               "controller"=>"Authority",
               "action"    =>"getAuthority"
           ),
           array(
               "name"=>"权限管理-基本权限修改",
               "controller"=>"Authority",
               "action"    =>"saveAuthority"
           ),
           array(
               "name"=>"权限管理-角色管理查看",
               "controller"=>"Authority",
               "action"=>"getRole"
           ),
           array(
               "name"=>"权限管理-角色管理添加",
               "controller"=>"Authority",
               "action"=>"addRole"
           ),
           array(
               "name"=>"权限管理-角色管理删除",
               "controller"=>"Authority",
               "action"=>"deleteRole"
           ),
           array(
               "name"=>"权限管理-角色管理配置",
               "controller"=>"Authority",
               "action"=>"editRole"
           )
       );
   }

}
