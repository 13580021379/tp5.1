<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/15
 * Time: 14:23
 */

namespace app\client\controller;
use app\client\model\File;
use app\client\model\Message;
use think\Controller;
use think\Request;
use think\Db;
use think\Controll;
use think\Response;

class Clientcontroller extends Controller
{
//
//    //实现文件下载
//    public function download()
//    {
//       $request= new Request();
//       $file=new File();
//        $downloadId=$request->param('downloadId');
//        $file_name=$file->get_file_name($downloadId);
////        $file_name=$request->param('file_name');
////        foreach ($file_name)
//        $file_dir = "../public/a_to_u_file/";
//
//        return download($file_dir.$file_name,$file_name,true);
//    }
//问题反馈
public  function client_to_up_problem(){


}

    //文件列表
    public function file_list(){
        $file=new File();
        $file_list=$file->file_list();
        return $file_list;
    }


    //上传文件
    public  function up_file(){
        $request=new Request();
        $file=$request->file('file');
        $mysqlId=date('YmdHis');
        //时间
        $time=date('Y-m-d  H-i-s');
        $info = $file->rule('uniqid')->move('../public/u_to_a_file/');
        $file_name = $info->getSaveName();
         $file_title=$_POST['file_title'];
//把文件名和创建时间放入数据库
        $file_obj=new File();
        if($info&&!empty($file_title)){
            $file_obj->up_file('u-a',$file_name,$file_title,$time);
         $this->success('上传成功！','client_home');

        }else{
            // 上传失败获取错误信息

            $this->success('上传失败，标题和文件不能为空！','client_home');
        }
    }
    public function getcookie(){
        return cookie('username');
    }

public function client_home(){

  return view('client_home');
}
public function response_to_client_main_page(){
    $request=new Request();
    $uId=$request->param('uId');
    $Msg=new Message();
    $main_page_inform=$Msg->mian_page($uId);
    return json($main_page_inform);
}
    public function inform_commment(){
        //点击的超链接即是文章的id
        $request=new Request();
        $list_id=$this->get_click_list_id();
        $num = Db::table('comment')->where("list_id",$list_id)->count(); //获取评论总数
        $this->assign('num',$num);
        $data=array();
        $data=$this->getCommlist("0",$list_id);//获取评论列表
        $this->assign("commlist",$data);

        return  $this->fetch('href_text');
    }
    /**
     *添加评论
     */
    public function addComment(){
        $data=array();
        $request=new Request();
        if((isset($_POST["comment"]))&&(!empty($_POST["comment"]))){
            $cm = $_POST["comment"];
            $cm['create_time']=date('Y-m-d H:i:s',time());
            Db::table('comment')->insert($cm);
            $cm['id']=Db::table('comment')->getLastInsID();
            $data = $cm;
            $num =  Db::table('comment')->where('list_id',$cm['list_id'])->count();//统计评论总数
            $data['num']= $num;

        }
        else{
            $data["error"] = "0";
        }
        echo json_encode($data);
    }
    /**
     *递归获取评论列表
     */
    protected function getCommlist($parent_id ,$list_id){
        $arr =  Db::table('comment')->where("parent_id = '".$parent_id."'")   ->where("list_id",$list_id)->order("create_time desc")->select();
        if(empty($arr)){
            return array();
        }
        foreach ($arr as $cm) {
            $cm["children"] = $this->getCommlist($cm["id"],$list_id);
            $result[] = $cm;
        }
        return $result;
    }
    //获取首页传过来的文章id
    public function get_click_list_id(){
        $request=new Request();
        $href_id=$request->param('href_id');
        return $href_id;
    }
    //返回超链接文本
    public function href_text(){
       $uId=$this->getcookie();
        $request=new Request();
        $href_id=$request->param('href_id');
        //点击后把状态修改
        $u_status=[
            'u_status'=>"1",
        ];
          Db::table('message')->where('msgId',$href_id)->where('uId',$uId)->update($u_status);
        $text=Db::table('message')->distinct(true)->where('msgId','=',$href_id)->field('title,text')->select();
        return json($text);
    }
}