<?php
namespace app\index\controller;
header("Access-Control-Allow-Origin:*");


//引入osssdk
if (is_file(__DIR__ . '/../../../sdk/ali-oss/autoload.php')) {
    require_once __DIR__ . '/../../../sdk/ali-oss/autoload.php';
}
if (is_file(__DIR__ . '/../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
}

use OSS\OssClient;
use OSS\Core\OssException;

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
        $res =  Db::query('SELECT a.*,b.`name`,b.`avatar_url` FROM `article` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`)  ORDER BY `id` DESC');
        return json($res);
    }

    /**
     * zyx
     * 2020/4/27
     * 获取文章信息通过id
     **/
    public function selectArticleById(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("SELECT a.*,b.`name`,b.`avatar_url` FROM `article` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`) where a.`id` = '". $id."'");
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

    /**
     * zyx
     * 2020/4/25
     * 把图片转存入oss 然后返回oss链接
     */
    public function savaImgToOss(){
        //设置oss地址
        $accessKeyId = "LTAI4FqzoH3pBVs25Fb5Yoni";
        $accessKeySecret = "RwbcI10xMlpbjuo1jEvOhAEANmoS6i";
        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = "http://oss-cn-hangzhou.aliyuncs.com";
        // 存储空间名称
        $bucket= '1978246522-max';
        // 文件名称
        $object = "test1";
        $content = "Hi, OSS.";

        if(empty($_FILES["file"])){
            $result['code'] = 500;
            $result['msg'] = "请选择要上传的图片";
            return '图片为空';
        }
        if($_FILES["file"]["error"]){
            $result['code'] = 500;
            $result['msg'] = $_FILES["file"]["error"];
            return '错误';
        }
        else{
            //没有出错
            //加限制条件
            //判断上传文件类型为png或jpg且大小不超过1024000B
            if(($_FILES["file"]["type"]=="image/png"||$_FILES["file"]["type"]=="image/jpeg"||$_FILES["file"]["type"]=="image/jpg")&&$_FILES["file"]["size"]<4024000){
                // //防止文件名重复 这些方法都是在处理字符串
                // $md5 = md5(time().$_FILES["file"]["name"]);
                // $info2=explode(".",$_FILES["file"]["name"]);
                // $suffix = strtolower(end($info2));
                $name = time().$_FILES["file"]["name"];
                


                //定义临时上传文件目录 
                //APP_PATH 系统自带
                $filedir = APP_PATH.'uploadfiletemp/';
                $fileName = strtolower($filedir.$name);
                //转码，把utf-8转成gb2312,返回转换后的字符串， 或者在失败时返回 FALSE。
                $fileName =iconv("UTF-8","gb2312",$fileName);
                //检查文件或目录是否存在
                if(file_exists($fileName)){
                    $result['code'] = 500;
                    $result['msg'] = "该文件已存在";
                }
                else {
                    //保存文件,   move_uploaded_file 将上传的文件移动到新位置
                    $a = move_uploaded_file($_FILES["file"]["tmp_name"],$fileName);//将临时地址移动到指定地址

                    // bin
                    $app_img_file = $fileName; // 图片路径
                    $fp = fopen($app_img_file, "r");
                    $filesize = $_FILES["file"]["size"];
                    $content = fread($fp, $filesize);
                    //返回图片的base64
                    $file_content = chunk_split(base64_encode($content));
                    $result['base64'] = $file_content;


                    //上传到oss文件后的文件名称
                    if($_FILES["file"]["type"]=="image/png") {
                        $fileName1 = time().'.png';
                    }
                    if($_FILES["file"]["type"]=="image/jpeg") {
                        $fileName1 = time().'.jpeg';
                    }
                    if($_FILES["file"]["type"]=="image/jpg") {
                        $fileName1 = time().'.jpg';
                    }
                
                    try {
                        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                        $aa = $ossClient->uploadFile($bucket, $fileName1, $fileName);
                        $result['msg'] = $aa['info']['url'];
                        // $this->setJsonResponse($aa);
                    } catch (OssException $e) {
                        return  json($e->getMessage());
                    }

                    return  json($result);

                        
                }
            }
            else{
                $result['code'] = 500;
                $result['msg'] = "文件类型不对11";
                $result['imgtype'] = $_FILES["file"]["type"];
                return  json($result);

            }
        }

   
    }

     /**
     * zyx
     * 2020/4/27
     * 插入文章数据 创建文章
     */
    public function saveArticleInfo(){
        $openid = isset($_REQUEST['openid']) ? $_REQUEST['openid'] : ''; // 必传参数
        $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : ''; // 必传参数
        $theme = isset($_REQUEST['theme']) ? $_REQUEST['theme'] : ''; // 必传参数
        $bg = isset($_REQUEST['bg']) ? $_REQUEST['bg'] : ''; // 必传参数
        $sub_title = isset($_REQUEST['sub_title']) ? $_REQUEST['sub_title'] : ''; // 必传参数
        $content = isset($_REQUEST['content']) ? $_REQUEST['content'] : ''; // 必传参数
        $create_time = date('Y-m-d H:i:s');//数据创建日期

        if(empty($openid)){
            $result['code'] = '400';
            $result['msg'] = 'openid为空';
            return json($result);
        }
      
        $sql = "insert `article`(`user_openid`,`title`,`theme`,`bg`,`sub_title`,`content`,`create_time`) values('". $openid."','".$title."','".$theme."','".$bg."','".$sub_title."','".$content."','".$create_time."')";
        $res = Db::execute($sql);

        return $res;
    }

     /**
     * zyx
     * 2020/4/27
     * 插入文章评论
     */
    public function insertArticleComment(){
        $article_id = isset($_REQUEST['article_id']) ? $_REQUEST['article_id'] : ''; // 必传参数
        $user_openid = isset($_REQUEST['user_openid']) ? $_REQUEST['user_openid'] : ''; // 必传参数
        $content = isset($_REQUEST['content']) ? $_REQUEST['content'] : ''; // 必传参数
        $create_time = date('Y-m-d H:i:s');//数据创建日期

        if(empty($user_openid)){
            $result['code'] = '400';
            $result['msg'] = 'openid为空';
            return json($result);
        }
      
        $sql = "insert `article_comment`(`article_id`,`user_openid`,`content`,`create_time`) values('". $article_id."','".$user_openid."','".$content."','".$create_time."')";
        $res = Db::execute($sql);

        return $res;
    }


    
  


}          

