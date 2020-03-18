<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/17
 * Time: 9:58
 */

namespace app\Admin\model;

use think\console\Table;
use think\Db;
class File
{
public function publish_file($type,$file_name,$file_title,$time){
$file=[
    'type'=>$type,
    'file_name'=>$file_name,
    'file_title'=>$file_title,
    'time'=>$time,
];
$insert=Db::table('file')->insert($file);
return $insert;
}

}