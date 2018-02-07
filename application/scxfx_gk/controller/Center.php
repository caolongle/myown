<?php
namespace app\scxfx_gk\controller;
use think\Controller;
use think\Db;
class Center extends Controller{
    public function __construct(){
        parent::__construct();
        check_session();
    }
    public function my_company(){
        //私海单位-未联系
        $progress = 0;
        $province = Db::name('province')->select();
        $this->get_count_company();
        $this->assign('province',$province);
        $this->assign('code',-1);
        $this->assign('level',-1);
        $this->assign('type',-1);
        $this->assign('count',-1);
        $this->get_company_list($progress);
        $privilege = get_privilege();
        $this->assign('privilege',$privilege);
        $this->assign('c_name',$this->request->controller());
        $this->assign('a_name',$this->request->action());
        $this->assign('waiting_count',0);
        $this->assign('depart_id',session('depart_id'));
        return $this -> fetch();
    }
    public function my_person(){
        return $this -> fetch();         
    }
    
    //获取私海客户
    protected function get_count_company(){
        $u_customer = Db::name('user_company')->where(array('uid' => session('admin_id')))->field('progress')->select();
        $wCount = 0;
        $gCount = 0;
        $qCount = 0;
        foreach ($u_customer as $uc){
            switch ($uc['progress']){
                case '0';
                $wCount ++;
                break;
                case '1';
                $gCount ++;
                break;
                case '2';
                $qCount ++;
                break;
                
            }
            unset($uc);
        }
        $dCount = 0;
        $this->assign('wCount',$wCount);
        $this->assign('gCount',$gCount);
        $this->assign('qCount',$qCount);
        $this->assign('dCount',$dCount);
    }
    
    protected function get_company_list(){
        
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