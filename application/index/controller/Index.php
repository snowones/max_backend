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
     * 2020/4/27
     * 获取文章的全部评论通过文章id
     **/
    public function getArticleCommentById(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("SELECT a.*,b.`name`,b.`avatar_url` FROM `article_comment` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`) where a.`article_id` = '". $id."'");
        return json($res);
    }

    /**
     * zyx
     * 2020/4/28
     * 获取全部的帖子信息
     **/
    public function selectAllDiscuss(){ 
        $res =  Db::query('SELECT a.*,b.`name`,b.`avatar_url` FROM `discuss` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`)  ORDER BY `id` DESC');
        return json($res);
    }

    /**
     * zyx
     * 2020/4/27
     * 获取帖子信息通过id
     **/
    public function selectDiscussById(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("SELECT a.*,b.`name`,b.`avatar_url` FROM `discuss` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`) where a.`id` = '". $id."'");
        return json($res);
    }

    /**
     * zyx
     * 2020/4/27
     * 获取帖子的全部评论通过帖子id
     **/
    public function getDiscussCommentById(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("SELECT a.*,b.`name`,b.`avatar_url` FROM `discuss_comment` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`) where a.`discuss_id` = '". $id."'");
        return json($res);
    }


     /**
     * zyx
     * 2020/4/29
     * 获取全部的相册信息
     **/
    public function selectAllPicture(){ 
        $res =  Db::query('SELECT a.*,b.`avatar_url` FROM `picture` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`)  ORDER BY `id` DESC');
        return json($res);
    }

    /**
     * zyx
     * 2020/4/29
     * 获取相册信息通过id
     **/
    public function selectPictureById(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("SELECT a.*,b.`name`,b.`avatar_url` FROM `picture` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`) where a.`id` = '". $id."'");
        return json($res);
    }


    /**
     * zyx
     * 2020/5/5
     * 获取商品信息
     **/
    public function selectAllGoods(){ 
        $res =  Db::query('SELECT a.*,b.`avatar_url` FROM `goods` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`)  ORDER BY `id` DESC');
        return json($res);
    }

    /**
     * zyx
     * 2020/5/5
     * 获取商品信息通过id
     **/
    public function selectGoodsById(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("SELECT a.*,b.`name`,b.`avatar_url` FROM `goods` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`) where a.`id` = '". $id."'");
        return json($res);
    }

     /**
     * zyx
     * 2020/5/7
     * 获取全部用户信息
     **/
    public function selectAllUsers(){ 
        $res =  Db::query('SELECT * FROM `user`');
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


    
     /**
     * zyx
     * 2020/4/27
     * 插入帖子评论
     */
    public function insertDiscussComment(){
        $discuss_id = isset($_REQUEST['discuss_id']) ? $_REQUEST['discuss_id'] : ''; // 必传参数
        $user_openid = isset($_REQUEST['user_openid']) ? $_REQUEST['user_openid'] : ''; // 必传参数
        $content = isset($_REQUEST['content']) ? $_REQUEST['content'] : ''; // 必传参数
        $create_time = date('Y-m-d H:i:s');//数据创建日期

        if(empty($user_openid)){
            $result['code'] = '400';
            $result['msg'] = 'openid为空';
            return json($result);
        }
      
        $sql = "insert `discuss_comment`(`discuss_id`,`user_openid`,`content`,`create_time`) values('". $discuss_id."','".$user_openid."','".$content."','".$create_time."')";
        $res = Db::execute($sql);

        return $res;
    }


    
     /**
     * zyx
     * 2020/4/27
     * 插入帖子数据 创建帖子
     */
    public function saveDiscussInfo(){
        $openid = isset($_REQUEST['openid']) ? $_REQUEST['openid'] : ''; // 必传参数
        $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : ''; // 必传参数
        $content = isset($_REQUEST['content']) ? $_REQUEST['content'] : ''; // 必传参数
        $content_img = isset($_REQUEST['content_img']) ? $_REQUEST['content_img'] : ''; // 必传参数
        $create_time = date('Y-m-d H:i:s');//数据创建日期

        if(empty($openid)){
            $result['code'] = '400';
            $result['msg'] = 'openid为空';
            return json($result);
        }
      
        $sql = "insert `discuss`(`user_openid`,`title`,`content`,`content_img`,`create_time`) values('". $openid."','".$title."','".$content."','".$content_img."','".$create_time."')";
        $res = Db::execute($sql);

        return $res;
    }

    /**
     * zyx
     * 2020/4/29
     * 插入相册数据 创建相册
     */
    public function savePictureInfo(){
        $user_openid = isset($_REQUEST['user_openid']) ? $_REQUEST['user_openid'] : ''; // 必传参数
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : ''; // 必传参数
        $contents = isset($_REQUEST['contents']) ? $_REQUEST['contents'] : ''; // 必传参数
        $create_time = date('Y-m-d H:i:s');//数据创建日期

        if(empty($user_openid)){
            $result['code'] = '400';
            $result['msg'] = 'openid为空';
            return json($result);
        }
      
        $sql = "insert `picture`(`user_openid`,`name`,`contents`,`create_time`) values('". $user_openid."','".$name."','".$contents."','".$create_time."')";
        $res = Db::execute($sql);

        return $res;
    }

    
     /**
     * zyx
     * 2020/5/5
     * 插入商品数据
     */
    public function saveGoodsInfo(){
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : ''; // 必传参数
        $image = isset($_REQUEST['image']) ? $_REQUEST['image'] : ''; // 必传参数
        $user_openid = isset($_REQUEST['user_openid']) ? $_REQUEST['user_openid'] : ''; // 必传参数
        $detail = isset($_REQUEST['detail']) ? $_REQUEST['detail'] : ''; // 必传参数
        $remarks = isset($_REQUEST['remarks']) ? $_REQUEST['remarks'] : ''; // 必传参数
        $price = isset($_REQUEST['price']) ? $_REQUEST['price'] : ''; // 必传参数
        $discount = isset($_REQUEST['discount']) ? $_REQUEST['discount'] : ''; // 必传参数
        $contact = isset($_REQUEST['contact']) ? $_REQUEST['contact'] : ''; // 必传参数
        $create_time = date('Y-m-d H:i:s');//数据创建日期

        if(empty($user_openid)){
            $result['code'] = '400';
            $result['msg'] = 'openid为空';
            return json($result);
        }
      
        $sql = "insert `goods`(`name`,`image`,`user_openid`,`detail`,`remarks`,`price`,`discount`,`contact`,`create_time`) values('". $name."','".$image."','".$user_openid."','".$detail."','".$remarks."','".$price."','".$discount."','".$contact."','".$create_time."')";
        $res = Db::execute($sql);

        return $res;
    }


     /**
     * zyx
     * 2020/5/6
     * 获取全部的帖子信息通过openid
     **/
    public function selectUserDiscuss(){ 
        $openid = isset($_REQUEST['openid']) ? $_REQUEST['openid'] : ''; // 必传参数
        $res =  Db::query("SELECT a.*,b.`name`,b.`avatar_url` FROM `discuss` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`)  WHERE a.`user_openid` = '".$openid."' ORDER BY `id` DESC ");
        return json($res);
    }


     /**
     * zyx
     * 2020/5/6
     * 获取全部的文章信息通过openid
     **/
    public function selectUserArticle(){ 
        $openid = isset($_REQUEST['openid']) ? $_REQUEST['openid'] : ''; // 必传参数
        $res =  Db::query("SELECT a.*,b.`name`,b.`avatar_url` FROM `article` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`)  WHERE a.`user_openid` = '".$openid."' ORDER BY `id` DESC");
        return json($res);
    }

      /**
     * zyx
     * 2020/4/29
     * 获取全部的相册信息通过openid
     **/
    public function selectUserPicture(){ 
        $openid = isset($_REQUEST['openid']) ? $_REQUEST['openid'] : ''; // 必传参数
        $res =  Db::query("SELECT a.*,b.`avatar_url` FROM `picture` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`) WHERE a.`user_openid` = '".$openid."' ORDER BY `id` DESC");
        return json($res);
    }

     /**
     * zyx
     * 2020/5/5
     * 获取商品信息通过openid
     **/
    public function selectUserGoods(){ 
        $openid = isset($_REQUEST['openid']) ? $_REQUEST['openid'] : ''; // 必传参数
        $res =  Db::query("SELECT a.*,b.`avatar_url` FROM `goods` a LEFT JOIN `user` b ON (a.`user_openid` = b.`openid`) WHERE a.`user_openid` = '".$openid."' ORDER BY `id` DESC");
        return json($res);
    }


    /**
     * zyx
     * 2020/5/16
     * 商品删除
     **/
    public function deleteGoodById(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("DELETE FROM `goods` WHERE `id` = '". $id."'");
        return json($res);
    }

    /**
     * zyx
     * 2020/5/16
     * 商品帖子删除
     **/
    public function deleteDiscussById(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("DELETE FROM `discuss` WHERE `id` = '". $id."'");
        return json($res);
    }

    /**
     * zyx
     * 2020/5/16
     * 文章删除
     **/
    public function deleteArticleById(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("DELETE FROM `article` WHERE `id` = '". $id."'");
        return json($res);
    }

    /**
     * zyx
     * 2020/5/16
     * 相册删除
     **/
    public function deletePictureById(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("DELETE FROM `picture` WHERE `id` = '". $id."'");
        return json($res);
    }
  
    /**
     * zyx
     * 2020/5/19
     * 创建用户pp
     */
    public function newsCreateUser(){
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : ''; // 必传参数
        $account = isset($_REQUEST['account']) ? $_REQUEST['account'] : ''; // 必传参数
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : ''; // 必传参数
        $avatar = isset($_REQUEST['avatar']) ? $_REQUEST['avatar'] : ''; // 必传参数
        $create_time = date('Y-m-d H:i:s');


        $sqlSelect = "select * from `news_user` where `account` = '". $account."'";
        $resSelect =  Db::query($sqlSelect);
        //去查找数据有这个账号没   有了不用插入数据没有就插入这条数据
        if(!empty($resSelect)){
            $result['code'] = '400';
            $result['msg'] = '该用户已存在无需创建';
            return json($result);
        }else{
            $sql = "insert `news_user`(`name`,`account`,`password`,`avatar`,`create_time`) values('". $name."','". $account."','".$password."','".$avatar."','".$create_time."')";
            $res = Db::execute($sql);
            $result['code'] = '200';
            $result['msg'] = '成功';
            return json($result);
        }
        
    }

     /**
     * zyx
     * 2020/5/19
     * 用户登录pp
     */
    public function newsLogin(){
        $account = isset($_REQUEST['account']) ? $_REQUEST['account'] : ''; // 必传参数
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : ''; // 必传参数

        $sqlSelect = "select * from `news_user` where `account` = '". $account."'";
        $resSelect =  Db::query($sqlSelect);
        //去查找数据有这个账号没   有了不用插入数据没有就插入这条数据
        if(empty($resSelect)){
            $result['code'] = '401';
            $result['msg'] = '该账户不存在';
            return json($result);
        }else{
            //判断密码是否正确
            $right = $resSelect[0]["password"];
            if($password ==  $right){
                $result['code'] = '200';
                $result['msg'] = $resSelect;
                return json($result);
            }else{
                $result['code'] = '402';
                $result['msg'] = '密码错误';
                return json($result);
            }
        }
        
    }

     /**
     * zyx
     * 2020/5/23
     * 查找全部用户的数据
     */
    public function newsSelectAllUserInfo(){
        $sqlSelect = "select * from `news_user`";
        $resSelect =  Db::query($sqlSelect);
       
        return json($resSelect);
    }

    
     /**
     * zyx
     * 2020/5/19
     * 创建文章或是提欸子
     */
    public function newsInsertConent(){
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : ''; // 必传参数
        $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : ''; // 必传参数
        $subtitle = isset($_REQUEST['subtitle']) ? $_REQUEST['subtitle'] : ''; // 必传参数
        $content = isset($_REQUEST['content']) ? $_REQUEST['content'] : ''; // 必传参数
        $img = isset($_REQUEST['img']) ? $_REQUEST['img'] : ''; // 必传参数
        $wenzhangType = isset($_REQUEST['wenzhangType']) ? $_REQUEST['wenzhangType'] : ''; // 必传参数
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : ''; // 必传参数
        $create_time = date('Y-m-d H:i:s');

        $sql = "insert `news_content`(`user_id`,`title`,`subtitle`,`content`,`img`,`wenzhangType`,`type`,`create_time`) values('". $user_id."','". $title."','".$subtitle."','".$content."','".$img."','".$wenzhangType."','".$type."','".$create_time."')";
        $res = Db::execute($sql);
        $result['code'] = '200';
        $result['msg'] = '成功';
        return json($result);
        
    }


      /**
     * zyx
     * 2020/5/19
     *  查找数据 根据type
     */
    public function newsSelectContentByType(){
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : ''; // 必传参数
        $wenzhangType = isset($_REQUEST['wenzhangType']) ? $_REQUEST['wenzhangType'] : ''; // 必传参数
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数

        if($wenzhangType){
            $sqlSelect = "SELECT a.*,b.`name`,b.`avatar` FROM `news_content` a LEFT JOIN `news_user` b ON (a.`user_id` = b.`id`)  where a.`type` = '". $type."' AND a.`wenzhangType` ='". $wenzhangType."'";
            $resSelect =  Db::query($sqlSelect);
        }else if($id){
            $sqlSelect = "SELECT a.*,b.`name`,b.`avatar` FROM `news_content` a LEFT JOIN `news_user` b ON (a.`user_id` = b.`id`)  where a.`id` = '". $id."'";
            $resSelect =  Db::query($sqlSelect);
        }else{
            $sqlSelect = "SELECT a.*,b.`name`,b.`avatar` FROM `news_content` a LEFT JOIN `news_user` b ON (a.`user_id` = b.`id`)  where a.`type` = '". $type."'";
            $resSelect =  Db::query($sqlSelect);
        }

       
        return json($resSelect);
    }
    

    


    /**
     * zyx
     * 2020/5/19
     * 插入用户评论
     */
    public function newsInsertComment(){
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : ''; // 必传参数
        $pid = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : ''; // 必传参数
        $content = isset($_REQUEST['content']) ? $_REQUEST['content'] : ''; // 必传参数
        $create_time = date('Y-m-d H:i:s');

        $sql = "insert `news_comment`(`user_id`,`pid`,`content`,`create_time`) values('". $user_id."','". $pid."','".$content."','".$create_time."')";
        $res = Db::execute($sql);
        $result['code'] = '200';
        $result['msg'] = '成功';
        return json($result);
        
    }


    
      /**
     * zyx
     * 2020/5/19
     *  查找评论数据 根据type
     */
    public function newsSelectAllComment(){
        $pid = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : ''; // 必传参数
     
        $sqlSelect = "SELECT a.*,b.`name`,b.`avatar` FROM `news_comment` a LEFT JOIN `news_user` b ON (a.`user_id` = b.`id`)  where a.`pid` = '". $pid."'";
        $resSelect =  Db::query($sqlSelect);
       
        return json($resSelect);
    }

    /**
     * zyx
     * 2020/5/16
     * 删除文章或是帖子
     **/
    public function newsDeleteContent(){ 
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        $res =  Db::query("DELETE FROM `news_content` WHERE `id` = '". $id."'");
        return json($res);
    }

}          

