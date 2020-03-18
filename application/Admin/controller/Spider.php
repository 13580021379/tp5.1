<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/5
 * Time: 16:00
 */

namespace app\Admin\controller;
use QL\QueryList;
use QL\Ext\PhantomJs;
class Spider
{

public function spider_news(){

    $url = "www.sogou.com";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($ch, $str) use(&$setcookie) {
      // 第一个参数是curl资源，第二个参数是每一行独立的header!
      list ($name, $value) = array_map('trim', explode(':', $str, 2));
      $name = strtolower($name);
      if('set-cookie'==$name)
      {
        $setcookie[]=$value;
      }
      return strlen($str);
    });
    curl_exec($ch);
    curl_close($ch);
    $cookie = array();
    foreach($setcookie as $c)
    {
      $tmp = explode(";",$c);
      $cookie[] = $tmp[0];
    }
    $cookiestr = "Cookie:".implode(";", $cookie);
    echo $cookiestr;

//    $ql = QueryList::getInstance();
//    // 安装时需要设置PhantomJS二进制文件路径
//    $ql->use(PhantomJs::class,'E:/webs/gradulation_project/phantomjs-2.1.1-windows/bin/phantomjs');
//    //or Custom function name
//    $ql->use(PhantomJs::class,'E:/webs/gradulation_project/phantomjs-2.1.1-windows/bin/phantomjs','browser');
//    $ql->use(PhantomJs::class,'E:/webs/gradulation_project/phantomjs-2.1.1-windows/bin/phantomjs.exe');
//    $html = $ql->browser('https://m.toutiao.com')->getHtml();
//  print_r($html);
//    $url_array = parse_url($url);
//    if (isset($url_array['path'])) {
//        $path = rtrim($url_array['path'],'.html');
//        $path = trim($path, '/');
//        $article_array = explode('/',$path);
//        $article_id = end($article_array);
//        $article_id = substr($article_id, 0, 14);
//        $date = substr($article_id, 0, 8);
//    }
//    $url = 'https://new.qq.com/omn/'.$date.'/'.$article_id.'.html'; // 获取PC端文章链接
//
//    $ql = QueryList::getInstance();
//    // 安装时需要设置PhantomJS二进制文件路径
//    $ql->use(PhantomJs::class,'/gradulation_project/phantomjs-2.1.1-windows/bin/phantomjs');
//    //or Custom function name
//    $ql->use(PhantomJs::class,'/gradulation_project/phantomjs-2.1.1-windows/bin/phantomjs','browser');
//
//    // Windows下示例
//    // 注意：路径里面不能有空格中文之类的
//    $ql->use(PhantomJs::class,'E:/webs/gradulation_project/phantomjs-2.1.1-windows/bin/phantomjs.exe');
//
//    $rules = [
//        'title'     => ['.LEFT h1','text'],
//        'keywords'  => ['.LEFT h1','text'],
//        'content'   => ['.content-article', 'html', '-#Status', function($value){
//            $value = str_replace('src="//','src="http://',$value);
//            return $value;
//        }],
//        'image'     => ['.content-article img', 'src', '', function($value)
//        {
//            $baseUrl = 'https:';
//            return $baseUrl.$value;
//        }]
//    ];
//
//    $data = $ql->browser($url)->rules($rules)->query()->getData();
//    $data = $data->all()[0];
//    return $data;

}


}