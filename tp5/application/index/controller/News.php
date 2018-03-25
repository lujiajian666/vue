<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class News extends Base
{
    private $tableArticle='article';

    public function getNews(){
        $db=Db::name($this->tableArticle);
        $post=$this->request->post();
        $res=$db->where(["article_id"=>$post["article_id"]])->find();
        $res["content"]=html_entity_decode($res["content"]);
        return json($res);
    }
}
