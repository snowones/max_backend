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
        return '测试通过';                                                                                                     
    }                                                                                                                            
    /**
     * zyx
     * 2020/4/1
     * 获取全部的文章信息 
     **/                                                                                                       
    public function selectAllArticle(){    
        $res =  Db::query('select * from `article`' );                                                                                           
        return json($res);                                                                                                                
    } 


}          

