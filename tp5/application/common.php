<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function upload($str){
   
    // 获取表单上传文件 例如上传了001.jpg
    $file = request()->file($str);
    
    // 移动到框架应用根目录/public/pic/ 目录下
    if($file){
        $path=PUBLIC_ENTER . '/pic';
        $info = $file->move($path);
        if($info){
            // 成功上传后 获取上传信息
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            return  ["/pic/".$info->getSaveName(),1];
        }else{
            // 上传失败获取错误信息
            return  [$file->getError(),0];
        }
    }
}
