<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/26
 * Time: 23:26
 */

namespace app\Admin\controller;


class Curl
{
    public  function paqu($url)
    {
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "www.qq.com");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$html = curl_exec($ch);
curl_close($ch);
var_dump($html);

    }
}