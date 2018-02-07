<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/9/13
 * Time: 15:50
 */
namespace app\scxfx_gk\controller;
use think\Controller;
use think\Db;
class User extends Controller{
    /*
     * 用户
     * */
    public function user_list(){
        check_session();
        $privilege = get_privilege();
        $this -> check_privilege($privilege);
        $uid = session('admin_id');
        $user_level = Db::name('user')->where('id',session('admin_id'))->field('team,sub_team')->find();
        $sub_team = array();
        $level = -1;
        if($user_level['team'] == 0){
            //运营总监级以上
            $where = '';
            $level = 1;
        }else if($user_level['team'] != 0 && $user_level['sub_team'] == 0){
            //销售总监
            $where = 'a.team = '.$user_level['team'];
            $level = 2;
            $sub_team = Db::name('team_name')->where('father_team',$user_level['team'])->select();
        }else{
            //团队经理
            $where = 'a.team ='.$user_level['team'].' and a.sub_team = '.$user_level['sub_team'];
        }
        $user = Db::name('user')->alias('a')
        ->join('gk_user_role b','a.id = b.uid','LEFT')
        ->join('gk_role c','c.id = b.rid','LEFT')
        ->where($where)
        ->field('a.*,group_concat(c.r_name) as r_name')
        ->group('a.id')
        ->order('a.last_time desc')
        ->paginate(25);
        if(isset($_GET['page']) && $_GET['page'] != NULL){
            $lead_number = ($_GET['page'] - 1) * 30;
        }else{
            $lead_number = 0;
        }
        if($user){
            $uArr = array();
            foreach ($user as $val){
                $lead_number ++;
                $val['lead_number'] = $lead_number;
                $uArr [] = $val;
                unset($val);
            }
            $this->assign('user',$uArr);
            $page = $user->render();
            $this->assign('page', $page);
        }
        $this->assign('privilege',$privilege);
        $this->assign('c_name',$this->request->controller());
        $this->assign('a_name',$this->request->action());
        $this->assign('sub_team',$sub_team);
        $this->assign('gender','-1');
        $this->assign('count','-1');
        $this->assign('level',$level);
        $this->assign('waiting_count',0);
        return $this->fetch();
    }

    public function add_user(){
        check_session();
        if(request() ->has('s')){
            $s = request() ->param('s');
            $this->assign('s',$s);
        }else{
            $this->assign('s',0);
        }
        //获取部门员工number
        $this->get_number();
        //获取下属角色
        $roles = $this->get_use_role();
        $this->assign('role',$roles);
        return $this->fetch();
    }

    public function edit_user(){
        check_session();
        if(request() -> isGet()){
            if(request() ->has('s')){
                $s = request() ->param('s');
                $this->assign('s',$s);
            }else{
                $this->assign('s',0);
            }
            $id = request() -> param('id');
            $user = Db::name('user')->alias('a')
                ->join('gk_team_name b','b.id = a.sub_team','LEFT')
                ->where(array('a.id' => $id))
                ->field('a.*,b.name as d_name')
                ->find();
            if($user){
                $rid = Db::name('user_role')->alias('a')
                    ->join('gk_role b','b.id = a.rid','LEFT')
                    ->where(array('a.uid' => $id))
                    ->field('a.rid,b.r_name,b.parent_id')
                    ->select();
                $idArr = array();
                if($rid){
                    $role_have = array();
                    foreach ($rid as $val){
                        $user_role['id'] = $val['rid'];
                        $user_role['r_name'] = $val['r_name'];
                        $user_role['parent_id'] = $val['parent_id'];
                        $role_have [] = $user_role;
                        $idArr [] = $val['rid'];
                        unset($val);
                    }
                }
            }
            //获取下属角色
            $role = $this->get_use_role();
            if($id == session('admin_id')){
                 foreach ($role_have as $val){
                     $role [] = $val;
                     unset($val);
                 }
                 foreach ($role as $ro){
                     $ro = join(',',$ro); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
                     $temp [] = $ro;
                     unset($ro);
                 }
                 $temp = array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
                 foreach ($temp as $k => $v){
                     $array = explode(',',$v); //再将拆开的数组重新组装
                     //下面的索引根据自己的情况进行修改即可
                     $temp2[$k]['id'] = $array[0];
                     $temp2[$k]['r_name'] = $array[1];
                     $temp2[$k]['parent_id'] = $array[2];
                 };
                 $role = $temp2;
            }
            $sub_team = Db::name('team_name')->where('father_team',$user['team'])->select();
            $this->assign('user',$user);
            $this->assign('rid',$idArr);
            $this->assign('role',$role);
            $this->assign('sub_team',$sub_team);
            return $this->fetch();
        }
    }

    public function check_edit_name(){
        if(isset($_POST) && $_POST['id'] != NULL){
            $name = $_POST['name'];
            $id = $_POST['id'];
            $check_tel = Db::name('user')->where(array('name' => $name,'is_delete' => 0))->where('id','neq',$id)->find();
            if($check_tel){
                return json(array('state' => 1,'info' => '用户名已存在，请重新输入'));
            }
        }

    }

    public function check_edit_tel(){
        if(isset($_POST) && $_POST['id'] != NULL){
            $tel = $_POST['tel'];
            $id = $_POST['id'];
            $result = $this->validate(array('tel' => $tel),'Check.tel_check');
            if($result !== true){
                return json(array('state' => 1,'info' => $result));
            }else{
                $check_tel = Db::name('user')->where(array('tel' => $tel,'is_quit' => 0))->where('id','neq',$id)->find();
                if($check_tel){
                    return json(array('state' => 1,'info' => '联系电话已存在，请重新输入'));
                }
            }
        }
    }

    public function check_edit_pwd(){
        if(isset($_POST) && $_POST['pwd'] !=NULL){
            $pwd = $_POST['pwd'];
            $id = $_POST['id'];
            $is_exist = Db::name('user')->where(array('id' => $id,'pwd' => md5($pwd.Config('MD5_KEY'))))->find();
            if($is_exist){
                return json(array('state' => 1,'info' => '不能和原密码一样，请重新修改'));
            }else{
                $result = $this->validate(array('pwd' => $pwd),'Check.reset_pwd');
                if($result !== true){
                    return json(array('state' => 1,'info' => $result));
                }
            }
        }
    }
    public function check_pwd(){
        if(isset($_POST) && $_POST['pwd'] !=NULL){
            $pwd = $_POST['pwd'];
            $result = $this->validate(array('pwd' => $pwd),'Check.reset_pwd');
            if($result !== true){
                return json(array('state' => 1,'info' => $result));
            }
        }
    }

    public function check_tel(){
        if(isset($_POST) && $_POST['tel'] != NULL){
            $tel = $_POST['tel'];
            $result = $this->validate(array('tel' => $tel),'Check.tel_check');
            if($result !== true){
                return json(array('state' => 1,'info' => $result));
            }else{
                $user = Db::name('user')->where(array('is_quit' => 0,'tel' => $tel))->find();
                if($user){
                    return json(array('state' => 1,'info' => '联系电话已存在，请重新输入'));
                }
            }
        }
    }

    public function get_sub_team(){
        if(isset($_POST) && $_POST['team'] != NULL){
            $team = $_POST['team'];
            $sub_team = Db::name('team_name')->where('father_team',$team)->field('id,name')->select();
            if($sub_team){
                return json(array('state' => 1,'info' => $sub_team));
            }
        }
    }
    
    protected function get_number(){
        //获取部门员工number
        $number = Db::name('user')->order('id desc')->value('number');
        if($number == ''){
            $uNumber = '09001';
        }else{
            $letter = substr($number,0,2);
            $digit = intval(substr($number,2) + 1);
            $uNumber = $letter.str_pad($digit,3,"0",STR_PAD_LEFT);
        };
        $this->assign('number',$uNumber);
    }

    public function add_user_info(){
        if(isset($_POST)){
            $data['name'] = $_POST['username'];
            $data['team'] = $_POST['team'];
            $data['sub_team'] = $_POST['sub_team'];
            $data['tel'] = $_POST['tel'];
            $data['gender'] = $_POST['gender'];
            $data['pwd'] =  md5('scxfx2018'.Config('MD5_KEY'));
            $data['create_time'] = strtotime($_POST['create_time']);
            $data['number'] = $_POST['number'];
            if(isset($_POST['landline']) && $_POST['landline'] != NULL){
                $data['landline'] = $_POST['landline'];
            }
            if(isset($_POST['id_card']) && $_POST['id_card'] != NULL){
                $data['id_card'] = $_POST['id_card'];
            }
            if(isset($_POST['addr']) && $_POST['addr'] != NULL){
                $data['addr'] = $_POST['addr'];
            }
            //查询number是否已存在
            $is_exist = Db::name('user')->where('number',$_POST['number'])->find();
            if($is_exist){
                $this->error('员工编号已存在，请稍后重新添加');
            }else{
                //添加到user表
                $user = Db::name('user')->insertGetId($data);
                if($user){
                    //添加到user_role表
                    $ids = $_POST['role_id'];
                    $idArr = array();
                    foreach ($ids as $val){
                        $rArr['uid'] = $user;
                        $rArr['rid'] = $val;
                        $idArr [] = $rArr;
                        unset($val);
                    }
                    $user_role = Db::name('user_role')->insertAll($idArr);
                    if($user_role){
                        $this->redirect('add_user',['s' => 1]);
                    }else{
                        $this->error('新增用户角色失败');
                    }
                }else{
                    $this->error('新增用户失败');
                }
            }
        }
    }

    public function edit_user_info(){
        if(isset($_POST) && $_POST['id'] != NULL){
            $id = $_POST['id'];
            $data['name'] = $_POST['username'];
            $data['tel'] = $_POST['tel'];
            $data['create_time'] = strtotime($_POST['create_time']);
            $data['gender'] = $_POST['gender'];
            if(isset($_POST['team']) && $_POST['team'] != NULL){
                $data['team'] =  $_POST['team'];
            }
            if(isset($_POST['sub_team']) && $_POST['sub_team'] != NULL){
                $data['sub_team'] =  $_POST['sub_team'];
            }
            if(isset($_POST['landline']) && $_POST['landline'] != NULL){
                $data['landline'] = $_POST['landline'];
            }
            if(isset($_POST['id_card']) && $_POST['id_card'] != NULL){
                $data['id_card'] = $_POST['id_card'];
            }
            if(isset($_POST['addr']) && $_POST['addr'] != NULL){
                $data['addr'] = $_POST['addr'];
            }
            if(isset($_POST['pwd']) && $_POST['pwd'] != NULL){
                $data['pwd'] =  md5($_POST['pwd'].Config('MD5_KEY'));
            }
            //更新用户表
            Db::name('user')->where(array('id' => $id))->update($data);
            //删除用户角色表
            Db::name('user_role')->where(array('uid' => $id))->delete();
            //加入新的角色
            $ids = $_POST['role_id'];
            $idArr = array();
            foreach ($ids as $val){
                $rArr['uid'] = $id;
                $rArr['rid'] = $val;
                $idArr [] = $rArr;
                unset($val);
            }
            $add_user_role = Db::name('user_role')->insertAll($idArr);
            if($add_user_role){
                $is_quit = $_POST['is_quit'];
                if($is_quit == -1){
                    Db::name('customer')->where(array('uid' => $id))->setField('uid',0);
                    //离职操作
                    $user =  Db::name('user')->where('id',$id)->update(array('is_quit' => -1,'quit_time' => time()));
                    if($user != 0){
                        //删除该员工所有电话量
                        $tel_count = Db::name('tel_count')->where('uid',$id)->delete();
                        if($tel_count !== false){
                            $this->redirect('edit_user',['s' => 1,'id' => $id]);
                        }else{
                            return json(array('state' => 1,'info' => '操作失败'));
                        }
                    }else{
                        return json(array('state' => 1,'info' => '操作失败'));
                    }
                }else{
                    Db::name('user')->where('id',$id)->setField(array('is_quit' => 0));
                    $this->redirect('edit_user',['s' => 1,'id' => $id]);
                }
            }else{
                $this->error('修改用户角色失败');
            }
        }
    }

    //离职操作
    public function user_quit(){
        if(isset($_POST) && $_POST['id'] != NULL){
            $id = $_POST['id'];
            //修改客户首次录入uid为0
            Db::name('customer')->where(array('uid' => $id))->setField('uid',0);
            //离职操作
            $user =  Db::name('user')->where('id',$id)->update(array('is_delete' => -1,'quit_time' => time()));
            if($user != 0){
                 //删除该员工所有电话量
                $tel_count = Db::name('tel_count')->where('uid',$id)->delete();
                return json(array('state' => 1,'info' => '操作成功'));
            }else{
                return json(array('state' => -1,'info' => '操作失败'));
            }
        }
    }

    //离职批量操作
    public function user_quit_batch(){
        if(isset($_POST) && $_POST['idArr'] != NULL){
            $idArr = $_POST['idArr'];
            //修改客户第一次录入uid为0
            Db::name('customer')->where('uid','in',$idArr)->setField('uid',0);
            //离职操作
            $user =  Db::name('user')->where('id','in',$idArr)->update(array('is_delete' => -1,'quit_time' => time()));
            if($user != 0){
                  //删除该员工所有电话量
                $tel_count = Db::name('tel_count')->where('uid','in',$idArr)->delete();
                if($tel_count != 0){
                    return json(array('state' => 1,'info' => '操作成功'));
                }else{
                    return json(array('state' => 1,'info' => '操作失败'));
                }
            }else{
                return json(array('state' => 1,'info' => '操作失败'));
            }
        }
    }

    /*
     * 分组信息
     *   */
    public function depart_list(){
        check_session();
        $privilege = get_privilege();
        $team = Db::name('user')->where('id',session('admin_id'))->field('team,sub_team')->find();
        $level = -1;
        if($team['team'] == 0){
            $where = '';
            $level = 0;
        }else if($team['team'] == 1 && $team['sub_team'] == 0){
            $where = 'father_team = 1';
        }else if($team['team'] == 2 && $team['sub_team'] == 0){
            $where = 'father_team = 2';
        }else{
            $where = 'id = '.$team['sub_team'];
        }
        $team = Db::name('team_name')->where($where)->order('create_time desc')->paginate(20);
        $page = $team->render();
        $this->assign('page', $page);
        $this->assign('team',$team);
        $this->assign('waiting_count',0);
        $this->assign('level',$level);
        $this->assign('c_name',$this->request->controller());
        $this->assign('a_name',$this->request->action());
        $this->assign('privilege',$privilege);
        return $this->fetch();
    }
    //添加分组页面
    public function add_team(){
        $s = 0;
        if(isset($_GET)){
            $s = request() -> param('s');
        }
        $this->assign('success',$s);
        return $this -> fetch();
    }
    //检查分组命名
    public function check_tname(){
        if(isset($_POST) && $_POST['t_name'] != NULL){
            $t_name = $_POST['t_name'];
            $is_exist = Db::name('team_name')->where('name',$t_name)->find();
            if($is_exist){
                return json(array('state' => 1,'info' => '分组名已存在'));
            }
        }
    }
    //添加分组功能
    public function add_team_info(){
        if(isset($_POST) && $_POST['team_name'] != NULL){
            $data['name'] = $_POST['team_name'];
            $data['father_team'] = $_POST['father_team'];
            $data['create_time'] = time();
            $add_team = Db::name('team_name')->insert($data);
            if($add_team){
                $this->redirect('add_team',['s' => 1]);
            }else{
                $this -> error('添加分组失败');
            }
        }
    }
    //编辑分组页面
    public function edit_team(){
        check_session();
        if(isset($_GET)){
            $id = request() -> param('id');
            if(request() ->has('s')){
                $s = request() ->param('s');
                $this->assign('success',$s);
            }else{
                $this->assign('success',0);
            }
            $team = Db::name('team_name')->where('id' , $id)->find();
            if($team){
                $this->assign('team',$team);
            }else{
                echo '请求分组信息错误';
            }
        }else{
            echo '请求方式错误';
        }
        return $this -> fetch();
    }
    //检查编辑分组命名
    public function check_edit_tname(){
        if(isset($_POST) && $_POST['t_name'] != NULL){
            $t_name = $_POST['t_name'];
            $id = $_POST['id'];
            $is_exist = Db::name('team_name')->where('name',$t_name)->where('id','neq',$id)->find();
            if($is_exist){
                return json(array('state' => 1,'info' => '分组名已存在'));
            }
        }
    }
    //编辑分组功能
    public function edit_team_info(){
        if(isset($_POST) && $_POST['id'] != NULL){
            $data['name'] = $_POST['team_name'];
            $data['father_team'] = $_POST['father_team'];
            $id = $_POST['id'];
            $upd = Db::name('team_name')->where('id',$id)->update($data);
            if($upd !== FALSE){
                $this -> redirect('edit_team',['s' => 1,'id' => $id]);
            }else{
                $this -> error('服务器错误，请稍后重试');
            }
        }
    }
    //删除分组
    public function del_team(){
        if(isset($_POST) && $_POST['id'] != NULL){
            $id = $_POST['id'];
            $is_exist = Db::name('user')->where('sub_team',$id)->find();
            if($is_exist){
                return json(array('state' => -1,'info' => '操作失败，请先分配该组下的成员'));
            }else{
                //删除分组
                $del_team = Db::name('team_name')->where('id',$id)->delete();
                if($del_team){
                    return json(array('state' => 1,'info' => '删除成功'));
                }else{
                    return json(array('state' => -1,'info' => '删除失败'));
                }
            }
        }
    }
    /*
     * 角色
     * */
    public function role_list(){
        check_session();
        $privilege = get_privilege();
//         $this -> check_privilege($privilege);
        //查询角色相对应的权限
        $role = Db::name('role')->alias('a')
            ->join('gk_pri_role b','a.id = b.rid','LEFT')
            ->join('gk_privilege c','c.id = b.pid','LEFT')
            ->field('a.*,group_concat(c.p_name) as p_name')
            ->group('a.id')
            ->paginate(30);
        if($role){
            $this->assign('role',$role);
            $page = $role->render();
            $this->assign('page', $page);
        }
        
        $this->assign('privilege',$privilege);
        $this->assign('c_name',$this->request->controller());
        $this->assign('a_name',$this->request->action());
        $this->assign('waiting_count',0);
        return $this->fetch();
    }

    public function add_role(){
        check_session();
        if(request() ->has('s')){
            $s = request() ->param('s');
            $this->assign('s',$s);
        }else{
            $this->assign('s',0);
        }
        $role = Db::name('role')->select();
        $privilege = get_privilege();
        $data = $this->_reSort($privilege);
        $this->assign('privilege',$data);
        $this->assign('role',$role);
        return $this->fetch();
    }

    public function check_rname(){
        if(isset($_POST) && $_POST['r_name'] != NULL){
            $r_name = $_POST['r_name'];
            if(isset($_POST['id'])){
                $id = $_POST['id'];
                $role = Db::name('role')->where('id','<>',$id)->where('r_name',$r_name)->find();
            }else{
                $role = Db::name('role')->where(array('r_name' => $r_name))->find();
            }
            if($role){
                return json(array('state' => 1,'info' => '该角色已存在，请重新输入'));
            }
        }
    }

    public function add_role_info(){
        if(isset($_POST) && $_POST['role_name'] != NULL){
            $r_name = $_POST['role_name'];
            $parent_id = $_POST['parent_id'];
            $pri_id = $_POST['pri_id'];
            //加入角色表
            $role_add = Db::name('role')->insertGetId(array('r_name' => $r_name,'parent_id' => $parent_id));
            if($role_add){
                //加入角色权限表
                $data = array();
                foreach ($pri_id as $val){
                    $idArr['pid'] = $val;
                    $idArr['rid'] = $role_add;
                    $data [] = $idArr;
                    unset($val);
                }
                $pri_ro = Db::name('pri_role')->insertAll($data);
                if($pri_ro){
                    $this->redirect('add_role',['s' => 1]);
                }else{
                    $this->error('新增角色权限失败');
                }
            }else{
                $this->error('新增角色失败');
            }
        }
    }

    public function edit_role(){
        check_session();
        if(request() -> isGet()){
            if(request() -> param('s')){
                $s = request() -> param('s');
            }else{
                $s = 0;
            }
            $id = request() -> param('id');
            $role = Db::name('role')->where(array('id' => $id))->find();
            $roles = Db::name('role')->select();
            $pri = Db::name('pri_role')->where(array('rid' => $id))->field('pid')->select();
            $pri_ids = array();
            foreach($pri as $pr){
                $pri_ids [] = $pr['pid'];
            }
            $privilege = Db::name('privilege')->select();
            $data = $this->_reSort($privilege);
            $this->assign('privilege',$data);
            $this->assign('pids',$pri_ids);
            $this->assign('s',$s);
            $this->assign('role',$role);
            $this->assign('roles',$roles);
            return $this->fetch();
        }
    }

    public function edit_role_info(){
        if(isset($_POST) && $_POST['rid'] != NULL){
            $r_name = $_POST['role_name'];
            $parent_id = $_POST['parent_id'];
            $pri_id = $_POST['pri_id'];
            $rid = $_POST['rid'];
            //更新角色表
            Db::name('role')->where(array('id' => $rid))->setField(array('r_name' => $r_name,'parent_id' => $parent_id));

            //更新权限
            //删除原来role_id所有的权限
            $pri = Db::name('pri_role')->where(array('rid' => $rid))->delete();
            if($pri != 0){
                //添加新的权限
                $data = array();
                foreach($pri_id as $val){
                    $idArr['pid'] = $val;
                    $idArr['rid'] = $rid;
                    $data [] = $idArr;
                    unset($val);
                }
                $pri_ro = Db::name('pri_role')->insertAll($data);
                if($pri_ro){
                    $this->redirect('edit_role',['s' => 1]);
                }else{
                    $this->error('修改角色权限失败');
                }
            }else{
                $this->error('修改角色权限失败');
            }
        }
    }

    public function role_del(){
        if(isset($_POST) && $_POST['id'] != NULL){
            $id = $_POST['id'];
            //判断该角色是否在使用中
            $is_use = Db::name('user_role')->where('rid',$id)->find();
            if($is_use){
                return json(array('state' => -1,'info' => '删除失败，该角色正在使用中，请先重新分配员工角色'));
            }else{
                 //删除pri_role中的rid
                $pri = Db::name('pri_role')->where(array('rid' => $id))->delete();
                if($pri != 0){
                    //删除角色
                    $role =  Db::name('role')->where(array('id' => $id))->delete();
                    if($role != 0){
                        return json(array('state' => 1,'info' => '删除成功'));
                    }else{
                        return json(array('state' => 1,'info' => '删除角色失败'));
                    }
                }else{
                    return json(array('state' => 1,'info' => '删除角色权限失败'));
                }
            }
        }
    }

    public function role_del_batch(){
        if(isset($_POST) && $_POST['idArr'] != NULL){
            $idArr = $_POST['idArr'];
            //删除pri_role中的rid
            $pri = Db::name('pri_role')->where('rid','in',$idArr)->delete();
            //删除user_role中的rid
            Db::name('user_role')->where('rid','in',$idArr)->delete();
            if($pri != 0){
                //删除角色
                $role =  Db::name('role')->where('id','in',$idArr)->delete();
                if($role != 0){
                    return json(array('state' => 1,'info' => '删除成功'));
                }else{
                    return json(array('state' => 1,'info' => '删除角色失败'));
                }
            }else{
                return json(array('state' => 1,'info' => '删除角色权限失败'));
            }
        }
    }
   
    //检查权限路由
    protected function check_privilege($privilege){
        $pri_url = $_SERVER['PATH_INFO'];
        $sign = substr($pri_url,0,1);
        if($sign != '/'){
            $pri_url = '/'.$pri_url;
        }
        $pArr = array();
        foreach ($privilege as $val){
            if($val['url'] != ''){
                $pArr [] = $val['url'];
            }
            unset($val);
        }
        if(!in_array($pri_url,$pArr)){
            echo '<h1 style="text-align:center;margin:20px 0">您没有该权限，<a href="/">点击返回首页</a></h1>';exit;
        }
    }
    /**
     * 获取下属角色
     * */
    protected function get_use_role(){
        //获取所有角色
        $all_role = Db::name('role')->select();
        //获取当前用户的角色
        $role = Db::name('user_role')->where(array('uid' => session('admin_id')))->field('rid')->select();      
        //获取当前角色所有下属角色
        $use_role = array();
        foreach ($role as $val){
            $sub_role = Db::name('role')->where(array('id' => $val['rid']))->find();
            if($sub_role['parent_id'] == 0){
//                return Db::name('role')->where('depart_id != -1')->field('r_name')->select();
                return $all_role;
                break;
            }else{
                //递归获取所有下属角色
                $use_role [] = $this -> get_role_sort($all_role,$sub_role['id']);
            }
            unset($val);
        }
        $temp = array();
        foreach($use_role as $ur){
            foreach ($ur as $v){
                $v = join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
                $temp [] = $v;
                unset($v);
            }
        }
        $temp = array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $array = explode(',',$v); //再将拆开的数组重新组装
            //下面的索引根据自己的情况进行修改即可
            $temp2[$k]['id'] = $array[0];
            $temp2[$k]['r_name'] = $array[1];
            $temp2[$k]['parent_id'] = $array[2];
        };
        return $temp2;
    }

    
    //获取当前用户权限等级
    private function get_user_role_level(){
        $role = Db::name('user_role')->where(array('uid' => session('admin_id')))->field('rid')->select();
        if($role){
            $lArr = array();
            foreach ($role as $ro){
                $lArr [] = $this->get_level($ro['rid']);
                unset($ro);
            }
            if(count($lArr) > 1){
                sort($lArr);
                $level = array_shift($lArr);
            }else{
                $level = implode(',',$lArr);
            }
            return $level;
        }
    }
     
    //递归获取等级级别
    private function get_level($rid,$isClear = true) {
        static $level = 0;
        if($isClear){
            $level = 0;
        }
        $roles = Db::name('role')->select();
        foreach ($roles as $ro){
            if($ro['id'] == $rid){
                $level ++;
                $this->get_level($ro['parent_id'],false);
            }
            unset($ro);
        }
        return $level;
    }
    
    /**
     * 角色递归
     * */
    private function get_role_sort($data, $id, $isClear = TRUE){
        static $ret = array();
        if ($isClear){
            $ret = array();
        }
        foreach ($data as $k => $v) {
            if ($v['parent_id'] == $id) {
                $ret[] = $v;
                $this->get_role_sort($data, $v['id'] , FALSE);
            }
            unset($v);
        }
        return $ret;
    }

    /**
     *权限递归
     **/
    private function _reSort($data, $parent_id = 0, $level = 0, $isClear = TRUE) {
        static $ret = array();
        if ($isClear){
            $ret = array();
        }
        foreach ($data as $k => $v) {
            if ($v['parent_id'] == $parent_id) {
                $v['level'] = $level;
                $ret[] = $v;
                $this->_reSort($data, $v['id'], $level + 1, FALSE);
            }
            unset($v);
        }
        return $ret;
    }

    public function _empty(){
        $privilege = get_privilege();
        $this->assign('privilege',$privilege);
        $this->assign('c_name',$this->request->controller());
        $this->assign('a_name',$this->request->action());
        $this->assign('waiting_count',0);
        header( "HTTP/1.0  404  Not Found" );
        return $this->fetch('common:404');
    }
}