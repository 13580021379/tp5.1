<?php

namespace app\Admin\controller;

use app\loginRegister\model\Admin;
use QL\QueryList;
use think\console\input\Option;
use think\Request;
use QL\Ext\PhantomJs;
//require  'gradulation_project/tp5.1/vendor/autoload.php';
class Test {


    public function test(){
        $url="https://www.toutiao.com/ch/news_hot/";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($curl, CURLOPT_URL,$url);
        $re=curl_exec($curl);
        var_dump($re) ;
//如果出现中文乱码使用下面代码`
//$getcontent = iconv("gb2312", "utf-8",$html);
//        echo"<textarea style='width:800px;height:600px;'>".$html."</textarea>";
//        $urls = QueryList::run('Request',[
//            'target' => 'https://news.sina.com.cn/roll/#pageid=153&lid=2509&k=&num=50&page=1',
//            'referrer'=>'https://news.sina.com.cn/roll/',
//            'method' => 'GET',
//            'params' => ['var1' => 'testvalue', 'var2' => 'somevalue'],
//            'user_agent'=>'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0',
//            'cookiePath' => './cookie.txt',
//            'timeout' =>'30'
//       ]);
//        $rules=array(
////             爬取当日时间
//            'time'=>array('#pL_Title','text',''),
//        //爬取标题
//            'title'=>array('.d_tit','text'),
//        );
//        $data = $urls->setQuery($rules,'')->data;
//        print_r($data);
//->setQuery(['link' => ['.c_tit','href','',function($content){
//            //利用回调函数补全相对链接
//            $baseUrl = 'https://news.sina.com.cn';
//            return $baseUrl.$content;
//        }]],'')->getData(function($item){
////            print_r($item['link']);
//          echo "sk";
////            return $item['link'];
//        });

//        $rules=array(
//            // 爬取当日时间
////            'time'=>array('#pL_Title','text','')
//        //爬取标题
//            'title'=>array('#pL_Title','html')
//        );
//            $data=$urls->setQuery($rules)->data;
//            print_r($data);
//        //获取时间标题
//        $rules=array(
//            // 爬取当日时间
////            'time'=>array('#pL_Title','text','')
//        //爬取标题
//            'title'=>array('#pL_Title','html')
//        );
//        $html = $gethtml->getHtml('https://news.sina.com.cn/roll/#pageid=153&lid=2509&k=&num=50&page=1');
//        print_r($html);
//        $data = QueryList::Query($html,$rules)->data;
//        $data= QueryList::Query('https://news.sina.com.cn/roll/#pageid=153&lid=2509&k=&num=50&page=1',$rules)->data;
//        print_r($data);
        //循环获取前10条新闻的标题及其href
//        for($i=0;$i<10;$i++){
//
//                // 设置采集规则
//                $rules=([
//                    // 爬取图片地址
//                    "src"=>array(".board-wrapper dd img.board-img","data-src"),
//                    // 爬取电影名
//                    "name"=>array(".board-wrapper dd .movie-item-info .name","html"),
//                    // 爬取电影主演信息
//                    "star"=>array(".board-wrapper dd .movie-item-info .star","html"),
//                    // 爬取上映时间
//                    "releasetime"=>array(".board-wrapper dd .movie-item-info .releasetime","html"),
//                ]);
//            $data = QueryList::Query('https://news.sina.com.cn/roll/#pageid=153&lid=2509&k=&num=50&page=1',$rules);
////                ->_query()->getData();
////            $excel_array=$data->all();
//            var_dump($data);
//
//
//        }


//        $rules = [
//            // 文章标题
//            'title' => ['.main-nav','text'],
//            // 发布日期
//            'date' => ['.meta>span:eq(0)','text'],
//            // 文章内容
//            'content' => ['#artibody','html']
//        ];
//        $rules = array(
//            //采集id为one这个元素里面的纯文本内容
//            'text' => array('.y-left index-content','text'),
////            //采集class为two下面的超链接的链接
////            'link' => array('.two>a','href'),
////            //采集class为two下面的第二张图片的链接
////            'img' => array('.two>img:eq(1)','src'),
////            //采集span标签中的HTML内容
//           'other' => array('.y-left index-content','html')
//        );

//        $data = QueryList::Query('https://news.sina.com.cn/',$rules)->data;

//        print_r($data);
    }

}


?>