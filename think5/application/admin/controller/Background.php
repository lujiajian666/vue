<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

header('content-type:application:json;charset=utf8');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin:http://127.0.0.1:20000');   // 指定允许其他域名访问
header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置

class Background extends Base
{

    private $tableMember = "employee";
    private $tableEmployee = "employee";
    private $tableDepartment = "department";
    private $tableJobTitle = "jobTitle";
    private $tableArticleType = 'article_type';

    public function index()
    {
        $post = $this->request->post();
        $db = Db::name($this->tableMember);
        empty($post["username"]) ? $post["username"] = null : 1;
        empty($post["password"]) ? $post["password"] = null : 1;
        $data = $db->where("username", $post["username"])->
        where("password", $post["password"])->find();
        if ($data != null) {
            //ljj 找出用户的权限,存入session
            $db_role_item=Db::name("role_item");
            $role_item_arr=$db_role_item->where("role_id = $data[role]")->select();
            $role_item=[];
            foreach ($role_item_arr as $value){
                $role_item[]=$value["authority_item_id"];
            };unset($value);
            $db_authority=Db::name("authority_item");
            $authority=$db_authority->where("id","in",$role_item)->select();
            $sesson_authority=[];
            foreach ($authority as $value){
                if(empty($sesson_authority[$value["controller"]])){
                    $sesson_authority[$value["controller"]]=[];
                }
                $sesson_authority[$value["controller"]][strtolower($value["action"])]=$value["name"];
            }
            setcookie("authority", serialize($sesson_authority),time()+3600);
            return json(["status" => 1, "username" => $post["username"]]);
        } else {
            return json(["status" => 0]);
        }
    }
    public function addEmployee()
    {
        $this->authorityVerify();
        $post = $this->request->post();
        $picRes = upload("head_img");
        $pic = ($picRes[1] == 1) ? $picRes[0] : "";
        $arr = array(
            "name" => $post["name"],
            "job_title_id" => $post["title"],
            "head_img" => $pic,
            "time" => time(),
            "department_id" => $post["department"],
            "username" => substr(time(), 5)
        );
        if (Db::name($this->tableEmployee)->insert($arr)) {
            return json(["status" => 1]);
        } else {
            return json(["status" => 0,
                "error" => Db::name($this->tableEmployee)->getLastSql()]);
        }

    }
    public function editEmployee(){
        $this->authorityVerify();
        $post = $this->request->post();
        //ljj先记录原来的信息
        $manData = Db::name($this->tableEmployee)->where("id=$post[id]")->find();

        $picRes = upload("head_img");
        $pic = ($picRes[1] == 1) ? $picRes[0] : "";

        $arr = array(
            "name" => $post["name"],
            "job_title_id" => $post["title"],
            "department_id" => $post["department"]
        );
        //ljj 如果有图片
        if ($pic != "") {
            $arr["head_img"] = $pic;
        }

        if (Db::name($this->tableEmployee)->where("id=$post[id]")->update($arr)) {
            //ljj 如果有图片，删除原来的图片
            if ($pic != "") {
                @unlink("." . $manData["head_img"]);
            }
            return json(["status" => 2]);
        } else {
            return json(["status" => 0,
                "error" => Db::name($this->tableEmployee)->getLastSql()]);
        }

    }
    public function getEmployee()
    {
        $this->authorityVerify();
        $post = $this->request->post();
        $employeeData = Db::name($this->tableEmployee)->alias("a")
            ->join("job_title b", "a.job_title_id = b.id")
            ->field("a.role,a.username,a.head_img as src,a.name,a.time,b.title as jobTitle,a.id,b.salary")
            ->where("a.department_id=$post[department]")->select();

        if ($employeeData != null) {
            return json(["status" => 1, "people" => $employeeData]);
        } else {
            return json(["status" => 0, "error" => Db::name($this->tableEmployee)->getLastSql()]);
        }
    }
    public function getEmployeeById()
    {
        $post = $this->request->post();

        $employeeData = Db::name($this->tableEmployee)->alias("a")
            ->join("job_title b", "a.job_title_id = b.id")
            ->join("department c", "a.department_id = c.id")
            ->field("a.job_title_id,a.head_img as src,a.name,a.time,
                            b.title as jobTitle,a.department_id,
                            a.id,b.salary,c.name as department")
            ->where("a.id = $post[id]")->find();

        if ($employeeData != null) {
            return json(["status" => 1, "man" => $employeeData]);
        } else {
            return json(["status" => 0, "error" => Db::name($this->tableEmployee)->getLastSql()]);
        }
    }
    public function deleteEmployeeById(){
        $this->authorityVerify();
        $post = $this->request->post();
        $employeeData = Db::name($this->tableEmployee)->where("id = $post[id]")->find();
        if ($employeeData["head_img"] != "") {
            @unlink("." . $employeeData["head_img"]);
        }

        if (Db::name($this->tableEmployee)->where("id = $post[id]")->delete()) {
            return json(["status" => 1]);
        } else {
            return json(["status" => 0, "error" => Db::name($this->tableEmployee)->getLastSql()]);
        }
    }
    public function selectJobTitle()
    {
        $data = Db::name($this->tableJobTitle)->order("department_id asc")->select();
        return json($data);
    }
    public function selectDepartment()
    {
        $data = Db::name($this->tableDepartment)->order("id asc")->select();
        return json($data);
    }
    public static function authority(){
        return array(
            array(
                "name"=>"人事管理-添加",
                "controller"=>"Background",
                "action"=>"addEmployee",

            ),
            array(
                "name"=>"人事管理-查看",
                "controller"=>"Background",
                "action"=>"getEmployee",

            ),
            array(
                "name"=>"人事管理-删除",
                "controller"=>"Background",
                "action"=>"deleteEmployeeById"
            ),
            array(
                "name"=>"人事管理-编辑",
                "controller"=>"Background",
                "action"=>"editEmployee"
            )
        );
    }
}
