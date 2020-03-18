<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/7
 * Time: 22:46
 */

namespace app\Admin\model;


use app\Admin\controller\Admincontroller;
use think\console\Table;
use think\Db;
use think\response\Json;

class Message
{
public function mian_page(){
//    $main_page_inform=Db::table('message')->distinct(true)->field('msgId,title,text')->select();
    $count=Db::table('message')->field('msgId')->group('msgId')->count();
    $time=Db::table('message')->field('msgId')->distinct('msgId')->select();
    $title=Db::table('message')->field('msgId,title')->distinct('msgId')->select();

    $text=Db::table('message')->distinct(true)->field('text')->select();
    $main_page_inform=[
   'count'=>$count,
   'time'=> $time,
   'title'=>$title,
    'text'=> $text,
    ];
    return $main_page_inform;
}
public function put_msg(){
    $d=new Admincontroller();
    //获取通知的标题和内容
   $data=$d->get_a_to_u_text_and_title();

    //获取用户的ID好
    $stuNo= Db::table('student')->field('stuNo')->select();
    //用时间为信息ID；
$msgId=date('YmdHis',time());
//遍历$stuNo
    foreach ($stuNo as  $value){
       $insert_data=[
           'msgId'=>$msgId,
           'uId'=>$value['stuNo'],
           'type'=>'a-u',
           'title'=>$data['title'],
           'text'=>$data['text'],
           ];
       $a_status=[
         'a_status'=>'1'
       ];
       //插入uId
        $b= Db::table('message') ->insert($insert_data);
        //修改u_status状态，表示已读
        Db::table('message')->where('u_status','=','0')->update($a_status);
    }
return $b;

}
}