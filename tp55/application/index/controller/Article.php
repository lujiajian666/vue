<?php
namespace app\index\controller;
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

    public function getArticle(){
        $post=$this->request->post();
        $db=Db::name($this->tableArticle);
        $hotService=$db->where("type=1")->order("sort desc,time desc")->limit(20)->select();
        $db=Db::name($this->tableArticle);
        $todayFocus=$db->where("type=2")->order("sort desc,time desc")->limit(4)->select();
        $db=Db::name($this->tableArticle);
        $activityNews=$db->where("type=3")->order("sort desc,time desc")->limit(3)->select();
        $db=Db::name($this->tableArticle);
        $normalProblem=$db->where("type=4")->order("sort desc,time desc")->limit(1)->select();
        $db=Db::name($this->tableArticle);
        $newPlayerDirection=$db->where("type=5")->order("sort desc,time desc")->limit(1)->select();
        $db=Db::name($this->tableArticle);
        $webStatement=$db->where("type=6")->order("sort desc,time desc")->limit(1)->select();
        $db=Db::name($this->tableArticle);
        $aboutUs=$db->where("type=7")->order("sort desc,time desc")->limit(1)->select();
        $arr=array(
            "hotService"=>$hotService,
            "todayFocus"=>$todayFocus,
            "activityNews"=>$activityNews,
            "normalProblem"=>$normalProblem,
            "newPlayerDirection"=>$newPlayerDirection,
            "webStatement"=>$webStatement,
            "aboutUs"=>$aboutUs
        );
        return json($arr);
    }
}
