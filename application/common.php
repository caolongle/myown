<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Db;
function check_session(){
    if(!session('?admin_id')){
        echo "<h1 style='margin:20px 0;text-align:center'>登陆超时</h1><script>setInterval(function(){window.location.href = '/login.html';},1000)</script>";
        exit();
    }
}
function get_privilege(){
    $uid = session('admin_id');
    $pid = Db::name('user_role')->alias('a')
    ->join('gk_pri_role b','a.rid = b.rid','LEFT')
    ->where('a.uid',$uid)
    ->field('b.pid')
    ->group('b.pid')
    ->select();
    if($pid){
        $ids = array();
        foreach ($pid as $val){
            $ids [] = $val['pid'];
            unset($val);
        }
        $privilege = Db::name('privilege')->where('id','in',$ids)->select();
        if($privilege){
            return $privilege;
        }else{
            echo 'GET ERROR FOR PRIVILEGE';exit();
        }
    }
}
function get_pname($a_name){
    $p_name = Db::name('privilege')->where('a_name',$a_name)->value('p_name');
    if($p_name){
        return $p_name;
    }
}
//获取待办事项
function get_waiting_count(){
    $result = Db::name('tel_content')
    ->where(array('uid' => session('admin_id'),'is_show' => 0))
    ->where('next_time','between time',[time(),'7 days'])
    ->field('type')
    ->select();
    $person_count = 0;
    $company_count = 0;
    if($result){
        foreach ($result as $val){
            if($val['type'] == 1){
                $person_count ++;
            }else{
                $company_count ++;
            }
        }
    }
    return array($person_count,$company_count);
}