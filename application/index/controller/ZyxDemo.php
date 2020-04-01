<?php
namespace app\index\controller;
header("Access-Control-Allow-Origin:*");

use think\Controller;
use think\Db;
class Index
{
    //获取全部用户数据
    public function index()
    {
        $data=Db::query('select * from `user`');
        return json($data);
    }
    //修改用户vip权限
    public function hello(){
        return 'hello';
        // $is_vip = isset($_REQUEST['is_vip']) ? $_REQUEST['is_vip'] : ''; // 必传参数
        // $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; // 必传参数
        // Db::table('user')->where('id', $id)->update(['is_vip' => $is_vip]);
        // return 1;
    }
}

