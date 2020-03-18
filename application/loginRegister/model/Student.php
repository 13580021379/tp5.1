<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/14
 * Time: 21:37
 */

namespace app\loginRegister\model;
use think\Db;
use think\Model;

class Student extends Model
{
//客户端验证
    public function client_Login_Verify($name,$psw)
    {
        $re = $this->where("stuNo='$name' and pws='$psw'")->find();
        if ($re) {
            return $re;
        } else {
            return null;
        }

    }
    public function register_insert($data){
        $stuNo_num=Db::table('student')->where('stuNo',$data['stuNo'])->count();
        if($stuNo_num==1){
            return $stuNo_num;
        }
        else{
            Db::table('student')->insert($data);
            return  1;
        }

    }
}