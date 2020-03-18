<?php
namespace app\loginRegister\controller;
use app\loginRegister\model\Admin;
use app\loginRegister\model\Student;
use think\captcha\Captcha;
use think\Controller;
use app\Admin\controller\Admincontroller;
use think\Cookie;
use think\Db;
use think\Request;


class Logincontroller extends Controller
{

    public function register_view()
    {
       return view("register");
    }

    public function register()
    {

        $request=new Request();
        $data=$request->post('formdata');

        $stuNo_num=Db::table('student')->where('stuNo',$data['stuNo'])->count();
        if($stuNo_num>=1){
            return json("0");
        }
        else{
            Db::table('student')->insert($data);
            return  json("1");

        }
}

    public function verify()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }

    public function login()
    {
        if (request()->isGet()) {
            return view('login');
        }
        else if (request()->isPost()){
            //验证码验证码

            $admin = new Admin();
            $client=new Student();
            $name = input('username'); //获取表单提交的姓名
            $psw = input('userpsw');//获取表单提交的密码
            $inputVaildata = input('code');//获取输入的验证码
            $role = input('role');
            $remember = input('remember_me');

            if ($role == 'admin') {
                if ($admin->Admin_Login_Verify($name, $psw)) {
                    if (captcha_check($inputVaildata)) {
                        if (isset($remember)) {
                            cookie('username', $name, '3600');

                        } else {
                            cookie('username', null);
                        }
                        return $this->redirect('Admin/Admincontroller/admin_home');
                    }
                    else {
                        $this->error('验证码不正确，返回登陆页面', 'login');
                    }
                }
                else {
                    $this->error('用户名或密码错误，返回登陆页面', 'login');

                }
            } else   if ($role == 'student'){
                if ($client->client_Login_Verify($name, $psw)) {
                    if (captcha_check($inputVaildata)) {
                        cookie('username', $name);
//                        if (isset($remember)) {
//                            cookie('username', $name);
//                        } else {
//                            cookie('username', null);
//                            cookie('userpsw', null);
//                        }
                        return $this->redirect('client/clientcontroller/client_home');
                    }
                    else {
                        $this->error('验证码不正确，返回登陆页面', 'login');
                    }
                }
                else {
                    $this->error('用户名或密码错误，返回登陆页面', 'login');

                }
            }
        }
    }
}
?>