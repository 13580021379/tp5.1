<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/23
 * Time: 19:28
 */
namespace app\Admin\controller;
 use Admin\view;
 use app\Admin\model\File;
 use app\Admin\model\Message;
 use app\Admin\model\Student;
 use app\Admin\model\Teacher;
 use think\db;
 use think\Controller;
 use think\Request;
 use think\response\Json;

 class Admincontroller extends Controller{

//实现文件下载
     public function download()
     {
         $file_dir = "../public/a_to_u_file/";
         $file_name = "5e6f90b1703cf.doc";
//         $file = fopen($file_dir.$file_name,'rb');
         return download($file_dir.$file_name, $file_name,true);
//         return download($file,'text.doc',true);
//         return download('f00d8d67af26200af6421454719e5e20.jpg');
     }
//    点击编辑框的附件
 public function publish_file(){
     $request=new Request();
     $file=$request->file('file');
     $mysqlId=date('YmdHis');
     //时间
     $time=date('Y-m-d  H-i-s');
     $info = $file->rule('uniqid')->move('../public/a_to_u_file/');
     $file_name = $info->getSaveName();
     $file_title=$_POST['file_title'];
     $file_obj=new File();
     if($info&&!empty($file_title)){
         $file_obj->publish_file('a-u',$file_name,$file_title,$time);
         $this->success('上传成功！','admin_home');
     }else{
         // 上传失败获取错误信息
         $this->success('上传失败，标题和文件不能为空！','admin_home');
     }
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
//public  function test(){
//    //查询评论
//    $ahuifu = $this->CommentList("20200906",0);
//    $this->assign("ahuifu",$ahuifu);
//      //渲染模板
//        return $this -> fetch('ahuifu');
//    }


//
////读取评论列表的递归,code为文章代号，pcode为父级代号
//     public function CommentList($listcode,$pcode){
//         $commentlist = array(); //存储评论数组
//         $list = Db::table("zy_huifu")
//             ->alias('a')
//             ->where("listcode",$listcode)
//             ->where("pcode",$pcode)
////             ->join("zy_user b","a.puser = b.uid")
//             ->select();
//         foreach($list as $v){
//             $commentlist[] = $v;
//             //查询子回复
//             $zi = $this->CommentList($listcode,$v["code"]);
//                 foreach($zi as $v1){
//                     $commentlist[] = $v1;
//                 }
//
//         }
//         return $commentlist;
//     }
//
//获取首页传过来的文章id
 public function get_click_list_id(){
     $request=new Request();
     $href_id=$request->param('href_id');
     return $href_id;
 }
     //返回超链接文本
     public function href_text(){

         $request=new Request();
         $href_id=$request->param('href_id');
         $text=Db::table('message')->distinct(true)->where('msgId','=',$href_id)->field('title,text')->select();
         return json($text);
     }
     //返回首页前端数据
     public function response_to_main_page(){
         $Msg=new Message();
         $main_page_inform=$Msg->mian_page();
         return json($main_page_inform);
     }
     //获取管理员发的通知的内容和标题
     public function get_a_to_u_text_and_title(){
          $request=new Request();
         if(!empty($request->param('title'))&&!empty($request->param('text'))){
             $data=[
                 'title'=>$request->param('title'),
                 'text'=>$request->param('text'),
             ];
             return $data;
         }
         else{
             return 0;
         }
     }

     //发布通知处理
 public  function admin_to_inform(){
  $is_empty=$this->get_a_to_u_text_and_title();
      if($is_empty!=0){
         $Msg=new Message();
         $re=$Msg->put_msg();
         if($re){
             return json("1");
             //这里后期加上跳转到首页
         }
         else{
             return json("2");
         }
     }
   else{
      return json("0");
   }
 }
//获取学生数据
     public  function student_data(){
         $request=new Request();
         $limit=  $request->param('limit');//获取每页数据数量
         $offset=  $request->param('offset');//当前页码
         $search_text=  $request->param('search_text');//获取搜索文本框数据
         $stu=new Student();
         $result=$stu->student_page($offset,$search_text,$limit);
         return json($result);
     }
//     获取老师数据
     public function teacher_data(){
         $request=new Request();
         $limit=  $request->param('limit');//获取每页数据数量
         $offset=  $request->param('offset');//当前页码
         $teacher_search_text=  $request->param('teacher_search_text');//获取搜索文本框数据
         $stu=new Teacher();
         $result=$stu->teacher_page($offset,$teacher_search_text,$limit);
         return json($result);
     }

     public  function  admin_home(){
   return view("admin_home");
     }
     public  function about(){
         return view("about");
     }
}
?>