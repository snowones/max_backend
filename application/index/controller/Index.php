<?php
namespace app\index\controller;
header("Access-Control-Allow-Origin:*");

use think\Controller;
use think\Db;
class Index
{                                                                                                      
    //测试
    public function index(){
        return '测试通过';
    }

     /**
     * zyx  
     * 2020/4/3
     * 封装curl  但是我不知道咋用的-。-
     */
    public function getSslPage($url) {  
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
        curl_setopt($ch, CURLOPT_HEADER, false);  
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_REFERER, $url);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
        $result = curl_exec($ch);  
        curl_close($ch);  
        return $result;  
    }  
    
    /**
     * zyx
     * 2020/4/1
     * 获取全部的文章信息 
     **/
    public function selectAllArticle(){ 
        $res =  Db::query('select * from `article`');
        return json($res);
    }


    
    /**
     * zyx
     * 2020/4/2
     * 获取用户的openid
     * @param  string $code [微信分发给用户的]
     */
    public function getOpenid() {
        // $appid = 'wx919da7d945914699'; //微信小程序appid
        // $secret = '10247ed6024b32c8b799f694d6122447'; //微信小程序的secret
        // //这俩参数很重要 不能让别人知道
        $code = isset($_REQUEST['code']) ? $_REQUEST['code'] : ''; // 必传参数
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wx919da7d945914699&secret=10247ed6024b32c8b799f694d6122447&js_code=".$code."&grant_type=authorization_code";
       

        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
        curl_setopt($ch, CURLOPT_HEADER, false);  
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_REFERER, $url);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
        $result = curl_exec($ch);  
        curl_close($ch);  

        return $result;  
    }

    /**
     * zyx
     * 2020/4/2
     * 创建用户的数据 创建前先查看数据库是否存在这个用户 通过openid
     */
    public function saveUserInfo(){
        $openid = isset($_REQUEST['openid']) ? $_REQUEST['openid'] : ''; // 必传参数
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : ''; // 必传参数
        $avatar_url = isset($_REQUEST['avatar_url']) ? $_REQUEST['avatar_url'] : ''; // 必传参数
        $create_time = date('Y-m-d H:i:s');
        if(empty($openid)){
            $result['code'] = '400';
            $result['msg'] = 'openid为空';
            return json($result);
        }
        $sqlSelect = "select * from `user` where `openid` = '". $openid."'";
        $resSelect =  Db::query($sqlSelect);
        //去查找数据有这个openid没   有了不用插入数据没有就插入这条数据
        if(!empty($resSelect)){
            $result['code'] = '400';
            $result['msg'] = '该用户已存在无需创建';
            return json($result);
        }else{
            $sql = "insert `user`(`openid`,`name`,`avatar_url`,`create_time`) values('". $openid."','".$name."','".$avatar_url."','".$create_time."')";
            $res = Db::execute($sql);

            return $res;
        }
        
        
        
    }


   

  


}          

