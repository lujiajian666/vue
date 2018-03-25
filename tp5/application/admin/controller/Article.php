<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;


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
          "content"=>htmlspecialchars($post["content"]),
          "type"=>$post["type"],
          "src"=>$post["src"],
          "time"=>time()
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
        $count=ceil(Db::name($this->tableArticle)->where("type=$post[type]")->count()/5);
        $arr=Db::name($this->tableArticle)->where("type=$post[type]")->order("sort desc")->
             limit(($post["nowPage"]-1)*5,5)->select();
        foreach($arr as &$value){
            $value["content"]=htmlspecialchars_decode($value["content"]);
        }
        return json(["article"=>$arr,"allPage"=>$count]);
    }
    public function deleteArticle(){
        $this->authorityVerify();
        $db=Db::name($this->tableArticle);
        $post=$this->request->post();
        $articleData = $db->where("article_id = $post[article_id]")->find();
        if ($articleData["src"] != "") {
            @unlink("." . $articleData["src"]);
        }
        $res=$db->where("article_id=$post[article_id]")->delete();
        if($res){
           return json(["status"=>1]);
        }else{
           return json(["status"=>0]);
        }

    }
    public function editArticle(){
        $this->authorityVerify();
        $article=Db::name($this->tableArticle);
        $post=$this->request->post();

        $articleData=$article->where(["article_id"=>$post["article_id"]])->find();

        $data=array(
           "title"=>$post["title"],
           "sort"=>$post["sort"],
           "content"=>htmlspecialchars($post["content"]),
           "type"=>$post["type"],
           "src"=>$post["src"],     
           
           "article_id"=>$post["article_id"]
        );

        $res=$article->where("article_id=$post[article_id]")->update($data);
        if($res!==false){
            if ($post["src"] != "") {
                @unlink("." . $articleData["src"]);
            }
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
