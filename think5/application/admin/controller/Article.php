<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;


header('content-type:application:json;charset=utf8');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin:http://127.0.0.1:20000');   // 指定允许其他域名访问
header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置

class Article extends Base
{

    private $tableMember="member";
    private $tableEmployee="employee";
    private $tableDepartment="department";
    private $tableJobTitle="jobTitle";
    private $tableArticleType='article_type';
    private $tableArticle='article';
    public function getArticleType(){
        $article_type=Db::name($this->tableArticleType)->order("article_type_id ")->select();
        return json($article_type);
    }
    public function addArticle(){
        $this->authorityVerify();
        $article=Db::name($this->tableArticle);
        $post=$this->request->post();
        $data=array(
          "title"=>$post["title"],
          "sort"=>$post["sort"],
          "content"=>$post["content"],
          "type"=>$post["type"]
        );
        $res=$article->insert($data);
        if($res){
            return json(["status"=>1]);
        }else{
            return json(["status"=>0]);
        }
    }
    public function getArticle(){
        $this->authorityVerify();
        $post=$this->request->post();
        $arr=Db::name($this->tableArticle)->where("type=$post[type]")->order("sort desc")->select();
        return json($arr);
    }
    public function deleteArticle(){
        $this->authorityVerify();
        $post=$this->request->post();
        $arr=Db::name($this->tableArticle)->where("article_id=$post[article_id]")->delete();
        if($arr){
           return json(["status"=>1]);
        }else{
           return json(["status"=>0]);
        }

    }
    public function editArticle(){
        $this->authorityVerify();
        $article=Db::name($this->tableArticle);
        $post=$this->request->post();
        $data=array(
           "title"=>$post["title"],
           "sort"=>$post["sort"],
           "content"=>$post["content"],
           "type"=>$post["type"]
        );
        $res=$article->where("article_id=$post[article_id]")->update($data);
        if($res){
           return json(["status"=>1]);
        }else{
           return json(["status"=>0]);
        }
    }
    public static function authority(){
        return array(
            array(
                "name"=>"文章管理-查看",
                "controller"=>"Article",
                "action"=>"getArticle"
            ),
            array(
                "name"=>"文章管理-添加",
                "controller"=>"Article",
                "action"    =>"addArticle"
            ),
            array(
                "name"=>"文章管理-删除",
                "controller"=>"Article",
                "action"=>"deleteArticle"
            ),
            array(
                "name"=>"文章管理-编辑",
                "controller"=>"Article",
                "action"=>"editArticle"
            )
        );
    }
}
