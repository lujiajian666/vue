<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Employee extends Base
{
    public function index()
    {
        $db=Db::name("department");
        $department=$db->select();
        $employeeArr=[];
        foreach($department as $item){
            $db=Db::name("employee")->alias("a")->join("job_title b","a.job_title_id=b.id");      
            $employeeArr[$item["id"]]=[];
            $employeeArr[$item["id"]]["data"]=$db->where(["a.department_id"=>$item["id"]])->field("a.id,a.head_img,b.title,a.name,a.time,b.salary")
                                             ->order("salary desc,time asc")->limit(5)->select();                                 
            $employeeArr[$item["id"]]["name"]=$item["name"]; 
            $employeeArr[$item["id"]]["total"]=count($employeeArr[$item["id"]]["data"]);
        }
        return json($employeeArr);
    }
}
