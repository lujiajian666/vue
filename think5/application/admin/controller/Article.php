<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

header('content-type:application:json;charset=utf8');
header('Access-Control-Allow-Origin:*');   // 指定允许其他域名访问
header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置

class Article extends Controller
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
        $post=$this->request->post();
        $arr=Db::name($this->tableArticle)->where("type=$post[type]")->order("sort desc")->select();
        return json($arr);
    }
    public function deleteArticle(){
        $post=$this->request->post();
        $arr=Db::name($this->tableArticle)->where("article_id=$post[article_id]")->delete();
        if($arr){
           return json(["status"=>1]);
        }else{
           return json(["status"=>0]);
        }

    }
    public function editArticle(){
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
}
