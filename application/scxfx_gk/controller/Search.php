<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/9/25
 * Time: 9:42
 */
namespace app\scxfx_gk\controller;
use think\Controller;
use think\Db;
class Search extends Controller {
    public function __construct(){
        parent::__construct();
        check_session();
    }
    public function search_user(){
        if(isset($_GET) && $_GET != NULL){
            $map = array();
            $where = array();
            $gender = '-1';
            $sql = '';
            if(isset($_GET['team']) && $_GET['team'] != -1){
                $depart = $_GET['team'];
                $map['team'] = $depart;
                $pageParam['query']['team'] = $depart;
            }
            if(isset($_GET['sub_team']) && $_GET['sub_team'] != -1){
                $sub_depart = $_GET['sub_team'];
                $map['sub_team'] = $sub_depart;
                $pageParam['query']['sub_team'] = $sub_depart;
            }
            $user_level = Db::name('user')->where('id',session('admin_id'))->field('team,sub_team')->find();
            $sub_team = array();
            $level = $_GET['level'];
            $pageParam['query']['level'] = $level;
            if($level == 2){//销售总监
                $sub_team = Db::name('team_name')->where('father_team',$user_level['team'])->select();
                $map['team'] = $user_level['team'];
            }else if($level == -1){//团队经理
                $map['team'] = $user_level['team'];
                $map['sub_team'] = $user_level['sub_team'];
            }
             if(isset($_GET['gender']) && $_GET['gender'] != -1){
                 $gender = $_GET['gender'];
                 $map['gender'] = $gender;
                 $pageParam['query']['gender'] = $gender;
             }
             if(isset($_GET['user_info']) && $_GET['user_info'] != ""){
                 $user_info = $_GET['user_info'];
                 $sql = "name like '%".$user_info."%' or tel like '%".$user_info."%'";
                 $pageParam['query']['user_info'] = $user_info;
             }
             if(isset($_GET['page']) && $_GET['page'] != NULL){
                 $lead_number = ($_GET['page'] - 1) * 20;
             }else{
                 $lead_number = 0;
             }
            $result = Db::name('user')->alias('a')
                ->where($map)
                ->where($sql)
                ->join('gk_user_role b','a.id = b.uid','LEFT')
                ->join('gk_role c','c.id = b.rid','LEFT')
                ->field('a.*,group_concat(c.r_name) as r_name')
                ->group('a.id')
                ->order('last_time desc')
                ->paginate(25,false,$pageParam);
             if($result){
                 $uArr = array();
                 foreach ($result as $val){
                     $lead_number ++;
                     $val['lead_number'] = $lead_number;
                     $uArr [] = $val;
                     unset($val);
                 }
                 $this->assign('user',$uArr);
                 $page = $result->render();
                 $this->assign('page', $page);
                 $privilege = get_privilege();
                 $this->assign('privilege',$privilege);
                 $this->assign('c_name','User');
                 $this->assign('a_name','user_list');
                 $this->assign('count',count($result));
                 $this->assign('gender',$gender);
                 $this->assign('level',$level);
                 $this->assign('waiting_count',0);
                 $this->assign('sub_team',$sub_team);
                 return $this->fetch('user/user_list');
             }
        }
    }

    //公海客户搜索
    public function search_customer(){
        if(isset($_GET) && $_GET != NULL){
            $code = -1;
            $level = -1;
            $depart_id = session('depart_id');
            //针对渠道部
            $useful_depart = $depart_id;
            if($depart_id == 7){
                $useful_depart = 1;
            }
            
            $where = array();
            $map = array();
            $cids = Db::name('user_customer')->where(array('depart_id' => $depart_id))->field('cid')->select();
            $idArr = array();
            if($cids){
                foreach ($cids as $val){
                    $idArr [] = $val['cid'];
                }
            }
            if(isset($_GET['province']) && $_GET['province'] != -1){
                $code = $_GET['province'];
                $map['province'] = $code;
                $pageParam['query']['province'] = $code;
            }else{
                $pageParam['query']['province'] = $code;
            }
            if(isset($_GET['level']) && $_GET['level'] != -1){
                $level = $_GET['level'];
                $where['level'] = $level;
                $pageParam['query']['level'] = $level;
            }else{
                $pageParam['query']['level'] = $level;
            }
            if(isset($_GET['customer_name']) && $_GET['customer_name'] != NULL){
                $customer_name = $_GET['customer_name'];
                $map['a.name'] = ['like','%'.$customer_name.'%'];
                $pageParam['query']['customer_name'] = $customer_name;
            }
//            $where['d.depart_id'] = $depart_id;
            $result = Db::name('customer')->alias('a')
                ->join('xfx_customer_btype d','d.cid = a.id','LEFT')
                ->join('xfx_province b','b.code = a.province','LEFT')
                ->join('xfx_city c','c.code = a.city','LEFT')
                ->where('a.id','not in',$idArr)
                ->where($map)
                ->where($where)
                ->where(array('a.is_deal' => 0,'a.is_repeat' => 1,'d.depart_id' => $useful_depart))
                ->field('a.name,a.source,a.id,a.throw_reason,a.out_time')
                ->order('a.throw_num asc')
                ->group('a.id')
                ->paginate(30,false,$pageParam);
            if($result){
                $this->assign('customer',$result);
                $page = $result->render();
                $this->assign('page', $page);
                $province = Db::name('province')->select();
                if($province){
                    $this->assign('province',$province);
                }
                $privilege = get_privilege();
                $actionArr = array();
                foreach ($privilege as $pri){
                    $actionArr [] = $pri['a_name'];
                    unset($pri);
                }
                $this->assign('privilege',$privilege);
                $this->assign('actionArr',$actionArr);
                $this->assign('c_name','Highseas');
                $this->assign('a_name','customer_list');
                $this->assign('code',$code);
                $this->assign('level',$level);
                $this->assign('count',count($result));
                $this->assign('is_add','add_customer');
                $this->assign('is_import','import_customer');
                $this->assign('waiting_count',get_waiting_count());
                return $this->fetch('highseas/customer_list');
            }
        }
    }

    //公海客户电话搜索
    public function search_tel_customer(){
        if(isset($_GET) && $_GET != NULL){
            $telArr = array();
            $is_deal = $_GET['is_deal'];
            $pageParam['query']['is_deal'] = $is_deal;
            $depart_id = session('depart_id');
            $cids = Db::name('user_customer')->where(array('depart_id' => $depart_id))->field('cid')->select();
            $idArr = array();
            if($cids){
                foreach ($cids as $val){
                    $idArr [] = $val['cid'];
                }
            }
            if(isset($_GET['customer_tel']) && $_GET['customer_tel'] != NULL){
                $customer_tel = $_GET['customer_tel'];
                $telResult = Db::name('customer_tel')->where('tel','like','%'.$customer_tel.'%')->group('cid')->field('cid')->select();
                if($telResult){
                    foreach ($telResult as $te){
                        $telArr [] = $te['cid'];
                        unset($te);
                    }
                }
                $pageParam['query']['customer_tel'] = $customer_tel;
            }
            $result = Db::name('customer')->alias('a')
                ->join('xfx_user_customer b','a.id = b.cid','LEFT')
                ->join('xfx_user c','c.id = b.uid','LEFT')
                ->where('a.id','in',$telArr)
                ->where(array('a.is_deal' => $is_deal,'a.is_repeat' => 1))
                ->field('a.name,a.id,a.source,c.name as user_name,c.number')
                ->order('a.throw_num asc')
                ->group('a.id')
                ->paginate(30,false,$pageParam);
            if($result){
//                 $customerRe = array();
//                 foreach ($result as $re){
//                     if(in_array($re['id'],$idArr)){
//                         $re['location'] = 1;
//                     }else{
//                         $re['location'] = -1;
//                     }
//                     $customerRe [] = $re;
//                     unset($re);
//                 }
                $this->assign('customer',$result);
                $page = $result->render();
                $this->assign('page', $page);
                $province = Db::name('province')->select();
                if($province){
                    $this->assign('province',$province);
                }
                $privilege = get_privilege();
                $actionArr = array();
                foreach ($privilege as $pri){
                    $actionArr [] = $pri['a_name'];
                    unset($pri);
                }
                $this->assign('privilege',$privilege);
                $this->assign('actionArr',$actionArr);
                $this->assign('c_name','Highseas');
                if($is_deal == 0){
                    $this->assign('a_name','customer_list');
                }else{
                    $this->assign('a_name','customer_deal');
                }
                $this->assign('count',count($result));
//                 $this->assign('is_add','add_customer');
//                 $this->assign('is_import','import_customer');
                $this->assign('is_deal',$is_deal);
                $this->assign('customer_tel',$customer_tel);
                $this->assign('waiting_count',get_waiting_count());
                return $this->fetch('highseas/search_result');
            }
        }
    }

    public function search_personal_customer(){
        if(isset($_GET)){
            $code = -1;
            $level = -1;
            $type = -1;
            $map = array();
            $where = array();
            $progress = $_GET['progress'];
            $pageParam['query']['progress'] = $progress;
            
            if(isset($_GET['type']) && $_GET['type'] != -1){
                $type = $_GET['type'];
                $where['type_id'] = $type;
                $pageParam['query']['type'] = $type;
            }else{
                $pageParam['query']['type'] = $type;
            }

            if(isset($_GET['category']) && $_GET['category'] != -1){
                $category = $_GET['category'];
                $where['category_id'] = $category;
                $pageParam['query']['category'] = $category;
            }else{
                $pageParam['query']['province'] = $code;
            }
            
            if(isset($_GET['level']) && $_GET['level'] != -1){
                $level = $_GET['level'];
                $where['level'] = $level;
                $pageParam['query']['level'] = $level;
            }else{
                $pageParam['query']['level'] = $level;
            }

            if(isset($_GET['customer_name']) && $_GET['customer_name'] != NULL){
                $customer_name = $_GET['customer_name'];
                $map['name'] = ['like','%'.$customer_name.'%'];
                $pageParam['query']['customer_name'] = $customer_name;
            }

            $result = Db::name('user_customer')->alias('a')
                ->join('xfx_customer b','b.id = a.cid')
                ->join('xfx_customer_btype c','c.cid = a.cid')
                ->where(array('a.progress' => $progress,'a.uid' => session('admin_id'),'c.depart_id' => session('depart_id')))
                ->where($map)
                ->where($where)
                ->field('b.id,b.name as c_name,c.level,c.type_id,c.category_id,c.remark,a.uid,b.source,a.create_time')
                ->order('a.update_time desc')
                ->group('b.id')
                ->paginate(30,false,$pageParam);
            if($result){
                
                $cusArr = array();
                foreach ($result as $val){
                    switch ($val['source']){
                        case '0';
                        $val['source'] = '新方向';
                        break;
                        case '1';
                        $val['source'] = '百度商桥';
                        break;
                        case '2';
                        $val['source'] = '今日头条';
                        break;
                        case '3';
                        $val['source'] = '热线电话';
                        break;
                        case '4';
                        $val['source'] = '腾讯广点通';
                        break;
                        case '5';
                        $val['source'] = '其他网络渠道';
                        break;
                        case '6';
                        $val['source'] = '广泛开发';
                        break;
                    }
                    $cusArr [] = $val;
                }
                
                $this->assign('customer',$cusArr);
                $page = $result->render();
                $this->assign('page', $page);
                $province = Db::name('province')->select();
                if($province){
                    $this->assign('province',$province);
                }
                $b_type = Db::name('business_type')->where(array('depart_id' => session('depart_id')))->select();
                $privilege = get_privilege();
                $this->assign('privilege',$privilege);
                $this->assign('c_name','Personal');
                $this->assign('a_name','my_customer');
                $this->assign('code',$code);
                $this->assign('level',$level);
                $this->assign('type',$type);
                $this->assign('b_type',$b_type);
                $this->assign('count',count($result));
                $this->assign('depart_id',session('depart_id'));
                $this->assign('waiting_count',get_waiting_count());
                $this->get_count();
                switch ($progress){
                    case 0;
                        return $this->fetch('personal/my_customer');
                        break;
                    case 1;
                        return $this->fetch('personal/my_customer_do');
                        break;
                    case 2;
                        return $this->fetch('personal/my_customer_deal');
                        break;
                }
            }
        }
    }

    //私海电话号码搜索
    public function search_tel_customer_personal(){
        if(isset($_GET)){
            $code = -1;
            $level = -1;
            $type = -1;
            $telArr = array();
            $progress = $_GET['progress'];
            if(isset($_GET['customer_tel']) && $_GET['customer_tel'] != NULL){
                $customer_tel = $_GET['customer_tel'];
                $telResult = Db::name('customer_tel')->where('tel','like','%'.$customer_tel.'%')->group('cid')->field('cid')->select();
                if($telResult){
                    foreach ($telResult as $te){
                        $telArr [] = $te['cid'];
                        unset($te);
                    }
                }
                $pageParam['query']['customer_tel'] = $customer_tel;
            }

            $result = Db::name('user_customer')->alias('a')
                ->join('xfx_customer b','b.id = a.cid')
                ->join('xfx_customer_btype c','c.cid = a.cid')
                ->where(array('a.progress' => $progress,'a.uid' => session('admin_id'),'c.depart_id' => session('depart_id')))
                ->where('a.cid','in',$telArr)
                ->field('b.id,b.name as c_name,c.level,c.type_id,c.category_id,c.remark,a.uid,b.source,a.create_time')
                ->order('a.create_time desc')
                ->group('b.id')
                ->paginate(30,false,$pageParam);
            if($result){
                
                $cusArr = array();
                foreach ($result as $val){
                    switch ($val['source']){
                        case '0';
                        $val['source'] = '新方向';
                        break;
                        case '1';
                        $val['source'] = '百度商桥';
                        break;
                        case '2';
                        $val['source'] = '今日头条';
                        break;
                        case '3';
                        $val['source'] = '热线电话';
                        break;
                        case '4';
                        $val['source'] = '腾讯广点通';
                        break;
                        case '5';
                        $val['source'] = '其他网络渠道';
                        break;
                        case '6';
                        $val['source'] = '广泛开发';
                        break;
                    }
                    $cusArr [] = $val;
                }
                
                $this->assign('customer',$cusArr);
                $page = $result->render();
                $this->assign('page', $page);
                $province = Db::name('province')->select();
                if($province){
                    $this->assign('province',$province);
                }
                $b_type = Db::name('business_type')->where(array('depart_id' => session('depart_id')))->select();
                $privilege = get_privilege();
                $this->assign('privilege',$privilege);
                $this->assign('c_name','Personal');
                $this->assign('a_name','my_customer');
                $this->assign('code',$code);
                $this->assign('level',$level);
                $this->assign('type',$type);
                $this->assign('b_type',$b_type);
                $this->assign('count',count($result));
                $this->assign('depart_id',session('depart_id'));
                $this->assign('waiting_count',get_waiting_count());
                $this->get_count();
                switch ($progress){
                    case 0;
                        return $this->fetch('personal/my_customer');
                        break;
                    case 1;
                        return $this->fetch('personal/my_customer_do');
                        break;
                    case 2;
                        return $this->fetch('personal/my_customer_deal');
                        break;
                }
            }
        }
    }

    //私海已成交搜索
    public function search_customer_done(){
        if(isset($_GET)){
            $code = -1;
            $level = -1;
            $type = -1;
            $map = array();
            $where = array();
            if(isset($_GET['province']) && $_GET['province'] != -1){
                $code = $_GET['province'];
                $map['province'] = $code;
                $pageParam['query']['province'] = $code;
            }else{
                $pageParam['query']['province'] = $code;
            }

            if(isset($_GET['type']) && $_GET['type'] != -1){
                $type = $_GET['type'];
                $where['type_id'] = $type;
                $pageParam['query']['type'] = $type;
            }else{
                $pageParam['query']['type'] = $type;
            }

            if(isset($_GET['level']) && $_GET['level'] != -1){
                $level = $_GET['level'];
                $where['level'] = $level;
                $pageParam['query']['level'] = $level;
            }else{
                $pageParam['query']['level'] = $level;
            }

            if(isset($_GET['customer_name']) && $_GET['customer_name'] != NULL){
                $customer_name = $_GET['customer_name'];
                $map['b.name'] = ['like','%'.$customer_name.'%'];
                $pageParam['query']['customer_name'] = $customer_name;
            }

            $result = Db::name('customer_deal')->alias('a')
                ->join('xfx_customer b','b.id = a.cid')
                ->join('xfx_business_type c','a.type_id = c.id','LEFT')
                ->where(array('a.uid' => session('admin_id'),'b.is_deal' => 1))
                ->where($map)
                ->where($where)
                ->field('a.*,b.name as c_name,c.name as type_name,b.uid as create_id')
                ->order('a.create_time desc')
                ->paginate(30,false,$pageParam);
            if($result){
                $this->assign('customer',$result);
                $page = $result->render();
                $this->assign('page', $page);
                $province = Db::name('province')->select();
                if($province){
                    $this->assign('province',$province);
                }
                $b_type = Db::name('business_type')->where(array('depart_id' => session('depart_id')))->select();
                $privilege = get_privilege();
                $this->get_count();
                $this->assign('privilege',$privilege);
                $this->assign('c_name','Personal');
                $this->assign('a_name','my_customer');
                $this->assign('code',$code);
                $this->assign('level',$level);
                $this->assign('type',$type);
                $this->assign('b_type',$b_type);
                $this->assign('count',count($result));
                $this->assign('waiting_count',get_waiting_count());
                return $this->fetch('personal/my_customer_done');
            }
        }
    }

    //私海成交电话搜索
    public function search_tel_customer_done(){
        if(isset($_GET)){
            $code = -1;
            $level = -1;
            $type = -1;
            $telArr = array();
            if(isset($_GET['customer_tel']) && $_GET['customer_tel'] != NULL){
                $customer_tel = $_GET['customer_tel'];
                $telResult = Db::name('customer_tel')->where('tel','like','%'.$customer_tel.'%')->group('cid')->field('cid')->select();
                if($telResult){
                    foreach ($telResult as $te){
                        $telArr [] = $te['cid'];
                        unset($te);
                    }
                }
                $pageParam['query']['customer_tel'] = $customer_tel;
            }

            $result = Db::name('customer_deal')->alias('a')
                ->join('xfx_customer b','b.id = a.cid')
                ->join('xfx_business_type c','a.type_id = c.id','LEFT')
                ->where('b.id','in',$telArr)
                ->where(array('a.uid' => session('admin_id'),'b.is_deal' => 1))
                ->field('a.*,b.name as c_name,c.name as type_name,b.uid as create_id')
                ->order('a.create_time desc')
                ->paginate(30,false,$pageParam);
            if($result){
                $this->assign('customer',$result);
                $page = $result->render();
                $this->assign('page', $page);
                $province = Db::name('province')->select();
                if($province){
                    $this->assign('province',$province);
                }
                $b_type = Db::name('business_type')->where(array('depart_id' => session('depart_id')))->select();
                $privilege = get_privilege();
                $this->get_count();
                $this->assign('privilege',$privilege);
                $this->assign('c_name','Personal');
                $this->assign('a_name','my_customer');
                $this->assign('code',$code);
                $this->assign('level',$level);
                $this->assign('type',$type);
                $this->assign('b_type',$b_type);
                $this->assign('count',count($result));
                $this->assign('waiting_count',get_waiting_count());
                return $this->fetch('personal/my_customer_done');
            }
        }
    }

    //公海成交池搜索
    public function search_customer_deal(){
        if(isset($_GET)){
            $code = -1;
            $level = -1;
            $type = -1;
            $map = array();
            $where = array();
            if(isset($_GET['province']) && $_GET['province'] != -1){
                $code = $_GET['province'];
                $map['a.province'] = $code;
                $pageParam['query']['province'] = $code;
            }else{
                $pageParam['query']['province'] = $code;
            }

            if(isset($_GET['type']) && $_GET['type'] != -1){
                $type = $_GET['type'];
                $where['b.type_id'] = $type;
                $pageParam['query']['type'] = $type;
            }else{
                $pageParam['query']['type'] = $type;
            }

            if(isset($_GET['level']) && $_GET['level'] != -1){
                $level = $_GET['level'];
                $where['c.level'] = $level;
                $pageParam['query']['level'] = $level;
            }else{
                $pageParam['query']['level'] = $level;
            }

            if(isset($_GET['customer_name']) && $_GET['customer_name'] != NULL){
                $customer_name = $_GET['customer_name'];
                $map['a.name'] = ['like','%'.$customer_name.'%'];
                $pageParam['query']['customer_name'] = $customer_name;
            }

            //获取在私海里的已成交客户
            $ids = Db::name('user_customer')->alias('a')
                ->join('xfx_customer b','b.id = a.cid','LEFT')
                ->where(array('a.depart_id' => session('depart_id'),'b.is_deal' => 1))
                ->field('a.cid')
                ->select();
            $idArr = array();
            foreach ($ids as $val){
                $idArr [] = $val['cid'];
                unset($val);
            }

            $result = Db::name('customer')->alias('a')
                ->join('xfx_customer_deal b','b.cid = a.id','LEFT')
                ->join('xfx_customer_btype c','c.cid = a.id','LEFT')
                ->where('b.id','not in',$idArr)
                ->where(array('a.is_deal' => 1,'c.depart_id' => session('depart_id')))
                ->where($map)
                ->where($where)
                ->field('a.id,a.name')
                ->order('a.throw_num asc')
                ->group('a.id')
                ->paginate(30,false,$pageParam);

            if($result){
                $this->assign('customer',$result);
                $page = $result->render();
                $this->assign('page', $page);
                $province = Db::name('province')->select();
                if($province){
                    $this->assign('province',$province);
                }
                $b_type = Db::name('business_type')->where(array('depart_id' => session('depart_id')))->select();
                $privilege = get_privilege();
                $this->get_count();
                $this->assign('privilege',$privilege);
                $this->assign('c_name','Highseas');
                $this->assign('a_name','customer_deal');
                $this->assign('code',$code);
                $this->assign('level',$level);
                $this->assign('type',$type);
                $this->assign('btype',$b_type);
                $this->assign('count',count($result));
                $this->assign('waiting_count',get_waiting_count());
                return $this->fetch('highseas/customer_deal');
            }
        }
    }
    
    //日报表
    public function search_report(){
        if(isset($_GET)){
            $report_date = request() -> param('report_date');
            $start_time = strtotime($report_date);
            $end_time = intval($start_time + 86399);
            
            $depart_id = session('depart_id');
            //查询用户所在角色，向上递归查看等级
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
            }
           
            switch ($level){
                //1是最高级，parent_id = 0
                case '1';
                $report = Db::name('report')->alias('a')
                ->join('xfx_user b','b.id = a.uid','RIGHT')
                ->where('a.create_time','between',[$start_time,$end_time])
                ->field('a.*,b.name')
                ->order('a.create_time desc')
                ->paginate(30);
                break;
                //2是总监级
                case '2';
                $report = Db::name('report')->alias('a')
                ->join('(SELECT `name`,`id` as uuid FROM xfx_user WHERE depart_id = '.$depart_id.') b','b.uuid = a.uid','RIGHT')
                ->where('a.create_time','between',[$start_time,$end_time])
                ->order('a.create_time desc')
                ->paginate(30);
                break;
                //3是团队经理
                case '3';
                //获取当前对象的团队编号
                $team = Db::name('user')->where('id',session('admin_id'))->value('team');
                $report = Db::name('report')->alias('a')
                ->join('(SELECT `name`,`id` as uuid FROM xfx_user WHERE depart_id = '.$depart_id.' AND team = '.$team.') b','b.uuid = a.uid','RIGHT')
                ->where('a.create_time','between',[$start_time,$end_time])
                ->order('a.create_time desc')
                ->paginate(30);
                break;
            
            }
            $rArr = array();
            foreach ($report as $ra){
                if(mb_strlen($ra['content'],'utf-8') > 30){
                    $ra['content_simple'] = mb_substr($ra['content'],0,30,'utf-8')."...";
                }else{
                    $ra['content_simple'] = $ra['content'];
                }
                $rArr [] = $ra;
                unset($ra);
            }
            $count = count($report);
            $page = $report->render();
            $this->assign('page', $page);
            $privilege = get_privilege();
            $this->assign('privilege',$privilege);
            $this->assign('c_name','Report');
            $this->assign('a_name','daily_report');
            $this->assign('count',$count);
            $this->assign('waiting_count',get_waiting_count());
            $this->assign('report',$rArr);
            return $this->fetch('report/daily_report');
            
        }
    }

    //电话量统计
    public function tel_count_search(){
        if(isset($_POST) && $_POST['type'] != NULL){
            $depart_id = $_POST['depart_id'];
            $type = $_POST['type'];
            $team = $_POST['team'];
            $user_info = Db::name('user')->where(array('depart_id' => $depart_id,'team' => $team,'is_delete' => 0))->field('id,name,create_time,number')->select();
            $idArr = array();
            foreach ($user_info as $ui){
                $idArr [] = $ui['id'];
                unset($ui);
            }
            $time_info = $this -> get_time($type);
            $start_time = $time_info[0];
            $end_time = $time_info[1];
           
            $tel_info = Db::name('tel_count')
            ->where('uid','in',$idArr)
            ->where('add_time','between',[$start_time,$end_time])
            ->field('SUM(number) as tel_number,uid,add_time')
            ->group('uid')
            ->select();
            foreach ($user_info as $key => $val){
                $user_info[$key]['tel_count'] = 0;
                $user_info[$key]['create_time'] = date('Y-m-d',$val['create_time']);
                foreach ($tel_info as $tl){
                    if($val['id'] == $tl['uid']){
                        $user_info[$key]['tel_count'] = intval($tl['tel_number']);
                    }
                    unset($tl);
                }
                unset($val);
            }
            return json(array('state' => 1,'info' => $user_info));
        }
    }
    
    //意向客户统计
    public function need_count_search(){
        if(isset($_POST) && $_POST['type'] != NULL){
            $depart_id = $_POST['depart_id'];
            $type = $_POST['type'];
            $team = $_POST['team'];
    
            $time_info = $this -> get_time($type);
            $start_time = $time_info[0];
            $end_time = $time_info[1];
    
            $user_info = Db::name('user')->where(array('depart_id' => $depart_id,'team' => $team,'is_delete' => 0))->field('id,name,create_time,number')->select();
            $idArr = array();
            $member = array();
            foreach ($user_info as $ui){
                $member [] = $ui['number'];
                $idArr [] = $ui['id'];
                unset($ui);
            }
    
            $customer_info = Db::name('user')->alias('a')
           ->join('xfx_user_customer b','b.uid = a.id','LEFT')
           ->join('xfx_customer_btype c','c.cid = b.cid','LEFT')
           ->join('xfx_customer d','d.id = b.cid','LEFT')
           ->where(array('a.depart_id' => $depart_id,'a.team' => $team,'c.depart_id' => $depart_id,'a.is_delete' => 0))
           ->where('b.progress','neq',2)
           ->where('b.update_time','between',[$start_time,$end_time])
           ->field('a.name,a.number,a.create_time,c.level,a.id')
           ->select();
           $final_data = array();
           foreach($customer_info as $k => $v){
               if(!isset($final_data[$v['number']])){
                   $final_data[$v['number']] = $v;
                   $final_data[$v['number']]['level_info'][0] = 0;
                   $final_data[$v['number']]['level_info'][1] = 0;
                   $final_data[$v['number']]['level_info'][2] = 0;
                   $final_data[$v['number']]['level_info'][3] = 0;
                   $final_data[$v['number']]['level_info'][4] = 0;
                   $final_data[$v['number']]['level_info'][$v['level']] = 1;
               }else{
                   $final_data[$v['number']]['level_info'][$v['level']] += 1;
               }
               unset($v);
           }
           
           $fiArr = array();
           $show_member = array();
           foreach ($final_data as $val){
               $show_member [] = $val['number'];
               $fiArr [] = $val;
               unset($val);
           }
           $result = array_diff($member,$show_member);
           if($result){
               foreach ($result as $re){
                   $rest = Db::name('user')->where(array('number' => $re,'is_delete' => 0))->field('name,number,create_time,id')->find();
                   $rest['level'] = 0;
                   $rest['level_info'] = [0,0,0,0,0];
                   $fiArr [] = $rest;
                   unset($re);
               }
           }
           foreach ($fiArr as $k => $val){
               $fiArr[$k]['create_time'] = date('Y-m-d',$val['create_time']);
           }
           $p_arr = array();
           for($i = 0;$i < 5;$i ++){
               $t_data['name'] = '';
               $t_data['info'] = array();
               foreach ($fiArr as $val){
                   switch ($i){
                       case '0';
                       $t_data['name'] = '未评级';
                       $t_data['info'][] =['count' => $val['level_info'][0],'name' => $val['name']];
                       break;
                       case '1';
                       $t_data['name'] = 'A级';
                       $t_data['info'][] =['count' => $val['level_info'][1],'name' => $val['name']];
                       break;
                       case '2';
                       $t_data['name'] = 'B级';
                       $t_data['info'][] =['count' => $val['level_info'][2],'name' => $val['name']];
                       break;
                       case '3';
                       $t_data['name'] = 'C级';
                       $t_data['info'][] =['count' => $val['level_info'][3],'name' => $val['name']];
                       break;
                       case '4';
                       $t_data['name'] = 'D级';
                       $t_data['info'][] =['count' => $val['level_info'][4],'name' => $val['name']];
                       break;
                   }
                   unset($val);
               }
               $p_arr [] = $t_data;
           }
           
           return json(array('state' => 1,'info' => $p_arr,'table_data' => $fiArr));
        }
    }
    
    //签约客户统计
    public function sign_count_search(){
        if(isset($_POST) && $_POST['type'] != NULL){
            $depart_id = $_POST['depart_id'];
            $type = $_POST['type'];
            $team = $_POST['team'];
            
            $time_info = $this -> get_time($type);
            $start_time = $time_info[0];
            $end_time = $time_info[1];
            
            $user_info = Db::name('user')->where(array('depart_id' => $depart_id,'team' => $team,'is_delete' => 0))->field('id,name,create_time,number')->select();
            $idArr = array();
            $member = array();
            foreach ($user_info as $ui){
                $member [] = $ui['number'];
                $idArr [] = $ui['id'];
                unset($ui);
            }
            
            $sign_customer = Db::name('user_customer')->alias('a')
            ->join('xfx_user b','b.id = a.uid','LEFT')
            ->where(array('b.depart_id' => $depart_id,'b.team' => $team,'a.progress' => 2,'b.is_delete' => 0))
            ->where('a.update_time','between',[$start_time,$end_time])
            ->field('b.name,b.number,b.create_time,count(a.uid) as sign_number')
            ->group('a.uid')
            ->select();
            $sign_member = array();
            if($sign_customer){
               foreach ($sign_customer as $key => $de){
                   $sign_member [] = $de['number'];
                   $sign_customer[$key]['create_time'] = date('Y-m-d',$sign_customer[$key]['create_time']);
                   unset($de);
               }
            }
            $re = array_diff($member,$sign_member);
            if($re){
               foreach ($re as $val){
                   $un_deal = Db::name('user')->where(array('number' => $val,'is_delete' => 0))->field('name,number,create_time')->find();
                   $un_deal['sign_number'] = 0;
                   $un_deal['create_time'] = date('Y-m-d',$un_deal['create_time']);
                   $sign_customer [] = $un_deal;
                   unset($val);
               }
            }
            return json(array('state' => 1,'info' => $sign_customer));
        }
    }
    
    //成交客户统计
    public function deal_count_search(){
        if(isset($_POST) && $_POST['type'] != NULL){
            $depart_id = $_POST['depart_id'];
            $type = $_POST['type'];
            $team = $_POST['team'];
            
            $time_info = $this -> get_time($type);
            $start_time = $time_info[0];
            $end_time = $time_info[1];
            
            $user_info = Db::name('user')->where(array('depart_id' => $depart_id,'team' => $team,'is_delete' => 0))->field('id,name,create_time,number')->select();
            $idArr = array();
            $member = array();
            foreach ($user_info as $ui){
                $member [] = $ui['number'];
                $idArr [] = $ui['id'];
                unset($ui);
            }
           
            $deal_info = Db::name('customer_deal')->alias('a')
            ->join('xfx_user b','b.id = a.uid','LEFT')
            ->where(array('b.depart_id' => $depart_id,'b.team' => $team,'b.is_delete' => 0))
            ->where('a.create_time','between',[$start_time,$end_time])
            ->field('count(a.uid) as deal_number,b.name,b.number,b.create_time')
            ->group('a.uid')
            ->select();
            $deal_member = array();
            foreach ($deal_info as $key => $de){
                $deal_member [] = $de['number'];
                $deal_info[$key]['create_time'] = date('Y-m-d',$de['create_time']);
                unset($de);
            }
            
            $re = array_diff($member,$deal_member);
            if($re){
                foreach ($re as $val){
                    $un_deal = Db::name('user')->where(array('number' => $val,'is_delete' => 0))->field('name,number,create_time')->find();
                    $un_deal['create_time'] = date('Y-m-d',$un_deal['create_time']);
                    $un_deal['deal_number'] = 0;
                    $deal_info [] = $un_deal;
                    unset($val);
                }
            }
            return json(array('state' => 1,'info' => $deal_info));
        }
    }
    
    //各部电话量
    public function quality_search(){
        if(isset($_POST) && $_POST['type'] != NULL){
            $depart_id = $_POST['depart_id'];
            $type = $_POST['type'];
            
            $time_info = $this -> get_time($type);
            $start_time = $time_info[0];
            $end_time = $time_info[1];
            
            
            $quality = Db::name('user')->where(array('depart_id' => $depart_id,'is_delete' => 0))->field('name,id,number,create_time,team')->select();
            $q_one = array();
            $q_two = array();
            $q_three = array();
            $q_four = array();
            $q_five = array();
            $q_six = array();
            $all_tel = array();
            foreach ($quality as $qu){
                switch ($qu['team']){
                    case '1';
                    $q_one [] = $qu['id'];
                    break;
                    case '2';
                    $q_two [] = $qu['id'];
                    break;
                    case '3';
                    $q_three [] = $qu['id'];
                    break;
                    case '4';
                    $q_four [] = $qu['id'];
                    break;
                    case '5';
                    $q_five [] = $qu['id'];
                    break;
                    case '6';
                    $q_six [] = $qu['id'];
                    break;
                }
                unset($qu);
            }
            $sub_team = 1;
            //获取各部门分部数
            $max_team = Db::query("select max(team) from xfx_user where depart_id =". $depart_id);
            if($max_team){
                foreach ($max_team as $ma){
                    $sub_team = $ma['max(team)'];
                    unset($ma);
                }
            }
            for($i = 0;$i < $sub_team;$i ++){
                switch ($i){
                    case '0';
                    $idArr = $q_one;
                    $team = '一部';
                    $crew_number = count($q_one);
                    break;
                    case '1';
                    $idArr = $q_two;
                    $team = '二部';
                    $crew_number = count($q_two);
                    break;
                    case '2';
                    $idArr = $q_three;
                    $team = '三部';
                    $crew_number = count($q_three);
                    break;
                    case '3';
                    $idArr = $q_four;
                    $team = '四部';
                    $crew_number = count($q_four);
                    break;
                    case '4';
                    $idArr = $q_five;
                    $team = '五部';
                    $crew_number = count($q_five);
                    break;
                    case '5';
                    $idArr = $q_six;
                    $team = '六部';
                    $crew_number = count($q_six);
                    break;
                }
                $tel_info = Db::name('tel_count')
                ->where('uid','in',$idArr)
                ->where('add_time','between',[$start_time,$end_time])
                ->field('SUM(number) as tel_number')
                ->select();
                if($tel_info){
                    foreach ($tel_info as $val){
                        if($val['tel_number'] == NULL){
                            $val['tel_number'] = 0;
                        }
                        $val['team'] = $team;
                        $val['crew_number'] = $crew_number;
                        $all_tel [] = $val;
                        unset($val);
                    }
                     
                }
            }
            return json(array('state' => 1,'info' => $all_tel));
        }
    }
    
    //各部意向客户查询
    public function quality_need_search(){
        if(isset($_POST) && $_POST['type'] != NULL){
            $depart_id = $_POST['depart_id'];
            $type = $_POST['type'];
    
            $time_info = $this -> get_time($type);
            $start_time = $time_info[0];
            $end_time = $time_info[1];
    
            $quality = Db::name('user')->where(array('depart_id' => $depart_id,'is_delete' => 0))->field('name,id,number,create_time,team')->select();
            $q_one = array();
            $q_two = array();
            $q_three = array();
            $q_four = array();
            $q_five = array();
            $q_six = array();
            $all_tel = array();
            foreach ($quality as $qu){
                switch ($qu['team']){
                    case '1';
                    $q_one [] = $qu['id'];
                    break;
                    case '2';
                    $q_two [] = $qu['id'];
                    break;
                    case '3';
                    $q_three [] = $qu['id'];
                    break;
                    case '4';
                    $q_four [] = $qu['id'];
                    break;
                    case '5';
                    $q_five [] = $qu['id'];
                    break;
                    case '6';
                    $q_six [] = $qu['id'];
                    break;
                }
                unset($qu);
            }
            $sub_team = 1;
            //获取各部门分部数
            $max_team = Db::query("select max(team) from xfx_user where depart_id =". $depart_id);
            if($max_team){
                foreach ($max_team as $ma){
                    $sub_team = $ma['max(team)'];
                    unset($ma);
                }
            }
            for($j = 1;$j < ($sub_team + 1);$j ++){
                $all_customer = array();
                $finalArr = array();
                $customer_info = Db::name('user')->alias('a')
                ->join('xfx_user_customer b','b.uid = a.id','LEFT')
                ->join('xfx_customer_btype c','c.cid = b.cid','LEFT')
                ->join('xfx_customer d','d.id = b.cid','LEFT')
                ->where(array('a.depart_id' => $depart_id,'a.team' => $j,'c.depart_id' => $depart_id,'a.is_delete' => 0))
                ->where('b.progress','neq',2)
                ->where('b.update_time','between',[$start_time,$end_time])
                ->field('a.name,c.level')
                ->select();
                foreach ($customer_info as $val){
                    $count = 0;
                    switch ($val['level']){
                        case '0';
                        $count ++;
                        $v['level_name'] = '未评级';
                        $v['level_number'] = $count;
                        break;
                        case '1';
                        $count ++;
                        $v['level_name'] = 'A级';
                        $v['level_number'] = $count;
                        break;
                        case '2';
                        $count ++;
                        $v['level_name'] = 'B级';
                        $v['level_number'] = $count;
                        break;
                        case '3';
                        $count ++;
                        $v['level_name'] = 'C级';
                        $v['level_number'] = $count;
                        break;
                        case '4';
                        $count ++;
                        $v['level_name'] = 'D级';
                        $v['level_number'] = $count;
                        break;
                    }
                    $all_customer [] = $v;
                    unset($v);
                    unset($val);
                }
                $show_level = array();
                $testArr = array();
                foreach ($all_customer as $key => $al){
                    if(!isset($testArr[$al['level_name']])){
                        $testArr[$al['level_name']] = $al;
                        $show_level [] = $al['level_name'];
                    }else{
                        $testArr[$al['level_name']]['level_number'] += 1;
                    }
                    unset($al);
                }
                $complate = ['未评级','A级','B级','C级','D级'];
                $re = array_diff($complate,$show_level);
                foreach ($re as $val){
                    $v['level_name'] = $val;
                    $v['level_number'] = 0;
                    $testArr [] = $v;
                    unset($v);
                    unset($val);
                }
                foreach ($testArr as $ta){
                    $finalArr [] = $ta;
                    unset($ta);
                }
                $level_name = array();
                foreach ($finalArr as $fa) {
                    $level_name [] = $fa['level_name'];
                    unset($fa);
                }
                array_multisort($level_name, SORT_ASC, $finalArr);
                $endArr [] = $finalArr;
            }
            for($i = 0;$i < 5;$i ++){
                $t_data['name'] = '';
                $t_data['info'] = array();
                foreach ($endArr as $key => $val){
                    switch ($i){
                        case '0';
                        $t_data['name'] = 'A级';
                        $t_data['info'][] = $val[$i]['level_number'];
                        break;
                        case '1';
                        $t_data['name'] = 'B级';
                        $t_data['info'][] = $val[$i]['level_number'];
                        break;
                        case '2';
                        $t_data['name'] = 'C级';
                        $t_data['info'][] = $val[$i]['level_number'];
                        break;
                        case '3';
                        $t_data['name'] = 'D级';
                        $t_data['info'][] = $val[$i]['level_number'];
                        break;
                        case '4';
                        $t_data['name'] = '未评级';
                        $t_data['info'][] = $val[$i]['level_number'];
                        break;
                    }
                    unset($val);
                }
                $o [] = $t_data;
            }
            return json(array('state' => 1,'info' => $o,'table_data' => $endArr));
        }
    }
    
    
    //各部签约客户查询
    public function quality_sign_search(){
        if(isset($_POST) && $_POST['type'] != NULL){
            $depart_id = $_POST['depart_id'];
            $type = $_POST['type'];
    
            $time_info = $this -> get_time($type);
            $start_time = $time_info[0];
            $end_time = $time_info[1];
    
            $quality = Db::name('user')->where(array('depart_id' => $depart_id,'is_delete' => 0))->field('name,id,number,create_time,team')->select();
            $q_one = array();
            $q_two = array();
            $q_three = array();
            $q_four = array();
            $q_five = array();
            $q_six = array();
            $all_tel = array();
            foreach ($quality as $qu){
                switch ($qu['team']){
                    case '1';
                    $q_one [] = $qu['id'];
                    break;
                    case '2';
                    $q_two [] = $qu['id'];
                    break;
                    case '3';
                    $q_three [] = $qu['id'];
                    break;
                    case '4';
                    $q_four [] = $qu['id'];
                    break;
                    case '5';
                    $q_five [] = $qu['id'];
                    break;
                    case '6';
                    $q_six [] = $qu['id'];
                    break;
                }
                unset($qu);
            }
            $sub_team = 1;
            //获取各部门分部数
            $max_team = Db::query("select max(team) from xfx_user where depart_id =". $depart_id);
            if($max_team){
                foreach ($max_team as $ma){
                    $sub_team = $ma['max(team)'];
                    unset($ma);
                }
            }
            for($n = 1;$n < ($sub_team + 1);$n ++){
                $deal_info = Db::name('user_customer')->alias('a')
                ->join('xfx_user b','b.id = a.uid','LEFT')
                ->where(array('b.depart_id' => $depart_id,'b.team' => $n,'a.progress' => 2,'b.is_delete' => 0))
                ->where('a.update_time','between',[$start_time,$end_time])
                ->field('count(a.id) as sign_number')
                ->select();
                foreach ($deal_info as $di){
                    switch ($n){
                        case '1';
                        $team = '一部';
                        $team_number = count($q_one);
                        break;
                        case '2';
                        $team = '二部';
                        $team_number = count($q_two);
                        break;
                        case '3';
                        $team = '三部';
                        $team_number = count($q_three);
                        break;
                        case '4';
                        $team = '四部';
                        $team_number = count($q_four);
                        break;
                        case '5';
                        $team = '五部';
                        $team_number = count($q_five);
                        break;
                        case '6';
                        $team = '六部';
                        $team_number = count($q_six);
                        break;
                    }
                    $sign_customer [] = ['sign_count' => $di['sign_number'],'team' => $team,'team_number' => $team_number];
                    unset($di);
                }
            }
            return json(array('state' => 1,'info' => $sign_customer));
        }
    }
    
    //各部成交客户查询
    public function quality_deal_search(){
        if(isset($_POST) && $_POST['type'] != NULL){
            $depart_id = $_POST['depart_id'];
            $type = $_POST['type'];
            
            $time_info = $this -> get_time($type);
            $start_time = $time_info[0];
            $end_time = $time_info[1];
            
            $quality = Db::name('user')->where(array('depart_id' => $depart_id,'is_delete' => 0))->field('name,id,number,create_time,team')->select();
            $q_one = array();
            $q_two = array();
            $q_three = array();
            $q_four = array();
            $q_five = array();
            $q_six = array();
            $all_tel = array();
            foreach ($quality as $qu){
                switch ($qu['team']){
                    case '1';
                    $q_one [] = $qu['id'];
                    break;
                    case '2';
                    $q_two [] = $qu['id'];
                    break;
                    case '3';
                    $q_three [] = $qu['id'];
                    break;
                    case '4';
                    $q_four [] = $qu['id'];
                    break;
                    case '5';
                    $q_five [] = $qu['id'];
                    break;
                    case '6';
                    $q_six [] = $qu['id'];
                    break;
                }
                unset($qu);
            }
            $sub_team = 1;
            //获取各部门分部数
            $max_team = Db::query("select max(team) from xfx_user where depart_id =". $depart_id);
            if($max_team){
                foreach ($max_team as $ma){
                    $sub_team = $ma['max(team)'];
                    unset($ma);
                }
            }
            for($n = 1;$n < ($sub_team + 1);$n ++){
                $deal_info = Db::name('customer_deal')->alias('a')
                ->join('xfx_user b','b.id = a.uid','LEFT')
                ->where(array('b.depart_id' => $depart_id,'b.team' => $n,'b.is_delete' => 0))
                ->where('a.create_time','between',[$start_time,$end_time])
                ->field('count(a.id) as deal_number')
                ->select();
                foreach ($deal_info as $di){
                    switch ($n){
                        case '1';
                        $team = '一部';
                        $team_number = count($q_one);
                        break;
                        case '2';
                        $team = '二部';
                        $team_number = count($q_two);
                        break;
                        case '3';
                        $team = '三部';
                        $team_number = count($q_three);
                        break;
                        case '4';
                        $team = '四部';
                        $team_number = count($q_four);
                        break;
                        case '5';
                        $team = '五部';
                        $team_number = count($q_five);
                        break;
                        case '6';
                        $team = '六部';
                        $team_number = count($q_six);
                        break;
                    }
                    $deal_customer [] = ['deal_count' => $di['deal_number'],'team' => $team,'team_number' => $team_number];
                    unset($di);
                }
            }
            return json(array('state' => 1,'info' => $deal_customer));
        }
    }
    //获取开始和结束时间
    public function get_time($type){
        $end_time = time();
        switch ($type){
            case '1';//本日
                $start_time = strtotime(date('Y-m-d'),time());
            break;
            case '2';//本周
                $start_week = date('Y-m-d', strtotime('this week'));
                $start_time = strtotime($start_week);
                $end_week = date('Y-m-d',strtotime('this week +6 days'));
                if(time() > intval(strtotime($end_week) + 86399)){
                    $end_time = intval(strtotime($end_week) + 86399);
                }
            break;
            case '3';//本月
                $start_month = date('Y-m-01', strtotime(date("Y-m-d")));
                $start_time = strtotime($start_month);
                $end_month = date('Y-m-d', strtotime("$start_month +1 month -1 day"));
                if(time() > intval(strtotime($end_month) + 86399)){
                    $end_time = intval(strtotime($end_month) + 86399);
                }
            break;
            case '4';
                $range_date = $_POST['date'];
                $dateArr = explode('-',$range_date);
                $start_time = strtotime($dateArr[0]);
                $end_time = intval(strtotime($dateArr[1]) + 86399);
            break;
        }
        return array($start_time,$end_time);
    }
    //获取私海客户
    protected function get_count(){
        $u_customer = Db::name('user_customer')->where(array('uid' => session('admin_id')))->field('progress')->select();
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
        $dCount = Db::name('customer_deal')->where(array('uid' => session('admin_id')))->count();
        $this->assign('wCount',$wCount);
        $this->assign('gCount',$gCount);
        $this->assign('qCount',$qCount);
        $this->assign('dCount',$dCount);
    }
    
    /**
     * 获取下属分部
     * */
    protected function get_sub_depart($depart_id){
        switch ($depart_id){
            case '1';
            $sub_depart = array(
                array(
                    'id' => 1,
                    'value' => '资质一部'
                ),
                array(
                    'id' => 2,
                    'value' => '资质二部'
                ),
                array(
                    'id' => 3,
                    'value' => '资质三部'
                ),
                array(
                    'id' => 4,
                    'value' => '资质四部'
                ),
                array(
                    'id' => 5,
                    'value' => '资质五部'
                ),
                array(
                    'id' => 6,
                    'value' => '资质六部'
                ),
            );
            break;
            case '2';
            $sub_depart = array(
                array(
                    'id' => 1,
                    'value' => '工商一部'
                ),
                array(
                    'id' => 2,
                    'value' => '工商二部'
                ),
            );
            break;
            case '3';
            $sub_depart = array(
                array(
                    'id' => 1,
                    'value' => '转让一部'
                ),
                array(
                    'id' => 2,
                    'value' => '转让二部'
                ),
            );
            break;
            case '4';
            $sub_depart = array(
                array(
                    'id' => 1,
                    'value' => '网络一部'
                ),
            );
            break;
            case '5';
            $sub_depart = array(
                array(
                    'id' => 1,
                    'value' => '后勤一部'
                ),
            );
            break;
            case '6';
            $sub_depart = array(
                array(
                    'id' => 1,
                    'value' => '行政一部'
                ),
            );
            break;
            case '7';
            $sub_depart = array(
                array(
                    'id' => 1,
                    'value' => '渠道一部'
                ),
            );
            break;
            case '8';
            $sub_depart = array(
                array(
                    'id' => 1,
                    'value' => '财务一部'
                ),
            );
            break;
            default;
            $sub_depart = array(
                array(
                    'id' => 1,
                    'value' => '转让一部'
                ),
                array(
                    'id' => 2,
                    'value' => '转让二部'
                ),
            );
            break;
        }
        $this->assign('sub_depart',$sub_depart);
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
    
    //获取当前用户权限等级
    private function get_user_role_level(){
        $role = Db::name('user_role')->where(array('uid' => session('admin_id')))->field('rid')->select();
        if($role){
            $lArr = array();
            foreach ($role as $ro){
                $lArr [] = $this->get_role_level($ro['rid']);
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
    private function get_role_level($rid,$isClear = true) {
        static $level = 0;
        if($isClear){
            $level = 0;
        }
        $roles = Db::name('role')->select();
        foreach ($roles as $ro){
            if($ro['id'] == $rid){
                $level ++;
                $this->get_role_level($ro['parent_id'],false);
            }
            unset($ro);
        }
        return $level;
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