<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/17
 * Time: 13:06
 */

namespace app\client\model;

use think\Db;
class File
{
    //文件列表
    public  function file_list(){
        $file_list=Db::table('file')->where('type','=','a-u')->select();
        $file_count=Db::table('file')->where('type','=','a-u')->count();
        $file=[
            'file_list'=>$file_list,
            'file_count'=>$file_count,
        ];
        return $file;
    }

    //客户端上传文件自定义方法数据插到数据库表
    public function up_file($type,$file_name,$file_title,$time){
        $file=[
            'type'=>$type,
            'file_name'=>$file_name,
            'file_title'=>$file_title,
            'time'=>$time,
        ];
        $insert=Db::table('file')->insert($file);
        return $insert;
    }
    public  function get_file_name($dowanloadId){
        $file_name=Db::table('file')->field('file_name')->where('file_id',$dowanloadId)->where('type','=','a-u')->select();

        $file_name=[
            'file_name'=>$file_name,
        ];
        return $file_name;
    }
}