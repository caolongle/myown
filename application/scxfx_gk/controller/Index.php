<?php
namespace app\scxfx_gk\controller;
use think\Controller;
use think\Db;
class Index extends Controller{
    public function index(){
        if(!session('?admin_id')){
            header('Location:login.html');
            exit();
        }
        $privilege = get_privilege();
        $this->assign('privilege',$privilege);
        $this->assign('c_name',$this->request->controller());
        $this->assign('a_name',$this->request->action());
        $this->assign('waiting_count',0);
        return $this -> fetch();
    }
    public function _empty(){
        $privilege = get_privilege();
        $this->assign('privilege',$privilege);
        $this->assign('c_name',$this->request->controller());
        $this->assign('a_name',$this->request->action());
        $this->assign('waiting_count',get_waiting_count());
        header( "HTTP/1.0  404  Not Found" );
        return $this->fetch('common:404');
    }
    
}
