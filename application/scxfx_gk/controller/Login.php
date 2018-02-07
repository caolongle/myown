<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/7/26
 * Time: 9:45
 */
namespace app\scxfx_gk\controller;
use think\Controller;
use think\Db;
class Login extends Controller{
    public function index(){
        return $this->fetch();
    }
    
    public function check_verify(){
        if(isset($_POST) && $_POST['code'] != NULL){
            $check_code = captcha_check($_POST['code']);
            if(!$check_code){
                return json(array('state' => -1,'info' => '错误'));
            }
        }
    }
    public function checkLogin(){
        $rq = $this->request;
        if($rq->has('account','post') && $rq->has('pwd','post')){
            $check_code = captcha_check($_POST['code']);
            if(!$check_code){
                $this -> error('验证码错误');
            }
            $number = $rq->post('account');
            $pwd = $rq->post('pwd');
            $data['number'] = $number;
            $data['pwd'] = $pwd;
            $result = $this->validate($data,'Check.login');
            if($result !== true){
                $this->error($result);
            }else{
                $user = Db::name('user')->where(['number'=> $number,'pwd' => md5($pwd.Config('MD5_KEY')),'is_quit' => 0])->find();
                if($user == NULL){
                    $this->error('账号或密码错误');
                }else{
                    //更新时间和IP
                    $upd = Db::name('user')->where(['id'=> $user['id']])->update(['last_time' => time(),'last_ip' => $rq -> ip()]);
                    if($upd == 0){
                        $this->error('更新登陆信息失败');
                    }else{
                        session('admin_id',$user['id']);
                        session('admin_name',$user['name']);
                        $this->success('登录成功','/','',1);
                    }
                }
            }
        }else{
            $this->error('请求方式错误');
        }
    }

    public function logout(){
        session('admin_name',null);
        session('admin_id',null);
        $this->redirect('Login/index');
    }

    public function _empty(){
        header( "HTTP/1.0  404  Not Found" );
        echo "<h1 style='margin:50px 100px;'>PAGE ERROR,ERROR CODE 404 !!!</h1>";
    }
}