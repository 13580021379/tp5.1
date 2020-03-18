<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/28
 * Time: 22:00
 */

namespace app\Admin\model;

use Symfony\Component\DependencyInjection\Tests\Fixtures\Prototype\OtherDir\AnotherSub\DeeperBaz;
use think\Db;
class Student
{
public function student_page($offset,$search_text,$limit){
    $start=($offset-1)*$limit;//获得起始点
    //实现模糊查询的sql,后期可以加
    $where = [
        ['stuNo', 'like', "%".$search_text."%"],
    ];
    $where1 = [
        ['stuNo', 'like', "%".$search_text."%"],
        ['sex', '=', "男"],
    ];
    if($search_text==""){
        $rows=Db::table('student')->limit($start,$limit)->select();//limit()函数就是limit($offset, $length = null)
        $count=Db::table('student')->count();//表的总数量total
        //统计男女比例
        $man_num=Db::table('student')->where('sex','男')->count();
        $rate=number_format( $man_num/$count*100,1);
        $result= ['total'=>$count,'rows'=>$rows,'rate'=>$rate];
    }
    else{
        $rows=Db::table('student')->where($where)->limit($start,$limit)->select();//limit()函数就是limit($offset, $length = null)
        $count=Db::table('student')->where($where)->count();//表的总数量total
        //统计男女比例
        $man_num=Db::table('student')->where($where1)->count();
        $rate=number_format( $man_num/$count*100,1);
       $result= ['total'=>$count,'rows'=>$rows,'rate'=>$rate];
    }
    return $result;
}
}