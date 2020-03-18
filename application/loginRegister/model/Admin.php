<?php
namespace  app\loginRegister\model;
use think\Model;

class Admin extends Model
{
    public function Admin_Login_Verify($name,$psw)
    {
        $re = $this->where("admNo='$name' and pws='$psw'")->find();
        if ($re) {
            return $re;
        } else {
            return null;
        }
    }

}
?>