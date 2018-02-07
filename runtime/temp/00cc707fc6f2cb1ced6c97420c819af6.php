<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"E:\phpstudy\PHPTutorial\WWW\crm_gk\public/../application/scxfx_gk\view\user\edit_user.html";i:1517217709;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户列表</title>
    <link rel="shortcut icon" href="favicon.ico"> <link href="/static/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/static/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/static/layui/css/layui.css" rel="stylesheet">
</head>
<style type="text/css">
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    }
    input[type="number"]{
    -moz-appearance: textfield;
    }
    .layui-form-switch {
        width:58px;
        height:24px;
    }
</style>
<body>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                        <form class="layui-form layui-form-pane" action="/scxfx_gk/user/edit_user_info" method="post">

                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">用户名称</label>
                                    <div class="layui-input-inline">
                                    <input type="text" name="username" autocomplete="off" value="<?php echo $user['name']; ?>" class="layui-input layui-form-danger username">
                                    </div>
                                </div>

                                <div class="layui-inline">
                                    <label class="layui-form-label">联系电话</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="tel"  value="<?php echo $user['tel']; ?>" autocomplete="off" class="layui-input layui-form-danger tel">
                                    </div>
                                </div>

                                <div class="layui-inline">
                                    <label class="layui-form-label">入职时间</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="create_time" id="create_time" autocomplete="off" class="layui-input" value="<?php echo date('Y-m-d',$user['create_time']); ?>">
                                    </div>
                                </div>
                            </div>
                        
                            <div class="layui-form-item">
                                <label class="layui-form-label">所在分部</label>
                                <div class="layui-input-block">
                                    <select name="team" lay-filter="team">
                                        <option value="0" <?php if($user['team'] == 0): ?>selected="selected"<?php endif; ?>>部门总监，统领所有分部</option>
                                        <option value="1" <?php if($user['team'] == 1): ?>selected="selected"<?php endif; ?>>挂靠一部</option>
                                        <option value="2" <?php if($user['team'] == 2): ?>selected="selected"<?php endif; ?>>挂靠二部</option>
                                    </select>
                                </div>                           
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">所在小组</label>
                                <div class="layui-input-block">
                                    <select name="sub_team" class="sub_team" >
                                        <option value="0" <?php if($user['sub_team'] == 0): ?>selected="selected"<?php endif; ?>>部门总监，不在小组行列</option>
                                        <?php if(is_array($sub_team) || $sub_team instanceof \think\Collection || $sub_team instanceof \think\Paginator): $i = 0; $__LIST__ = $sub_team;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                                            <option value="<?php echo $val['id']; ?>" <?php if($val['id'] == $user['sub_team']): ?>selected="selected"<?php endif; ?>><?php echo $val['name']; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">员工编号</label>
                                <div class="layui-input-block">
                                    <input type="text"  value="<?php echo $user['number']; ?>" autocomplete="off" class="layui-input layui-form-danger" readonly>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">所在角色</label>
                                <div class="layui-input-block">
                                    <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                                        <input type="checkbox" class="chose_role" name="role_id[]" value="<?php echo $val['id']; ?>" title="<?php echo $val['r_name']; ?>" <?php if(in_array($val['id'],$rid)):?>checked<?php endif;?>>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </div>

                            <div class="layui-form-item" pane>
                                <label class="layui-form-label">状态</label>
                                <div class="layui-input-block on_position" >
                                    <?php if($user['is_quit'] == 0): ?>
                                        <input type="checkbox" checked lay-skin="switch" lay-text="在职|离职" name="is_quit" value="0" lay-filter="is_quit" >
                                        <?php else: ?>
                                        <input type="checkbox" lay-skin="switch" name="is_quit" value="-1" lay-text="在职|离职" lay-filter="is_quit">
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="layui-form-item">
                                <label class="layui-form-label">重置密码</label>
                                <div class="layui-input-inline" style="width:90px;">
                                    <input type="checkbox" name="is_quit" lay-skin="switch" lay-text="ON|OFF" lay-filter="reset">
                                </div>
                                <div class="layui-inline layui-hide show_pwd">
                                    <label class="layui-form-label">输入密码</label>
                                    <div class="layui-input-inline">
                                        <input type="password" name="pwd" autocomplete="off" class="layui-input pwd layui-form-danger">
                                    </div>
                                </div>
                                <div class="layui-inline layui-hide show_pwd">
                                    <label class="layui-form-label">确认密码</label>
                                    <div class="layui-input-inline">
                                        <input type="password" autocomplete="off" class="layui-input s_pwd layui-form-danger">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="layui-form-item" pane>
                                <label class="layui-form-label">性别</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="gender" value="0" title="男" <?php if($user['gender'] == 0): ?>checked<?php endif; ?>>
                                    <input type="radio" name="gender" value="1" title="女" <?php if($user['gender'] == 1): ?>checked<?php endif; ?>>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">座机号码</label>
                                <div class="layui-input-block">
                                    <input type="text" name="landline"  value="<?php echo $user['landline']; ?>" autocomplete="off" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">身份证号码</label>
                                <div class="layui-input-block">
                                    <input type="text" name="id_card"  value="<?php echo $user['id_card']; ?>" autocomplete="off" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">联系地址</label>
                                <div class="layui-input-block">
                                    <textarea class="layui-textarea" name="addr"><?php echo $user['addr']; ?></textarea>
                                </div>
                            </div>

                            <div class="layui-form-item" style="text-align:center">
                                <button class="layui-btn" lay-submit lay-filter="save_user">保存内容</button>
                                <button type="button" class="layui-btn layui-btn-primary" id="close">取消</button>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    </form>                
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/assets/js/bootstrap.min.js"></script>
<script src="/static/js/content.min.js"></script>
<script src="/static/layui/layui.js"></script>
<script type="text/javascript">
    var tag = 0;
    $('.tel').blur(function(){
        var tel = $.trim($(this).val());
        var id = '<?php echo $user['id']; ?>';
        if(tel != ''){
            $.post('/scxfx_gk/user/check_edit_tel',{tel:tel,id:id},function(data){
                if(data.state == 1){
                    layer.tips(data.info,'.tel',{
                        tips: [3, '#D15B47'],
                        time: 2500
                    });
                    tag = 1;
                }else{
                    tag = 0;
                }
            })
        }
    });
    var sign = 0;
    $('.pwd').blur(function(){
        var pwd = $.trim($(this).val());
        var id = '<?php echo $user['id']; ?>';
        if(pwd != ''){
            $.post('/scxfx_gk/user/check_edit_pwd',{pwd:pwd,id:id},function(data){
                if(data.state == 1){
                    layer.tips(data.info,'.pwd',{
                        tips: [3, '#D15B47'],
                        time: 2500
                    });
                    sign = 1;
                }else{
                    sign = 0;
                }
            });
        }
    });
    $('.s_pwd').blur(function(){
        var s_pwd = $.trim($(this).val());
        var pwd = $.trim($('.pwd').val());
        if(pwd != s_pwd){
            layer.tips('两次密码输入不一致','.s_pwd',{
                tips: [3, '#D15B47'],
                time: 2500
            });
        }
    });
   layui.use(['form', 'layedit', 'laydate'], function(){
    var form = layui.form
    ,layer = layui.layer
    ,layedit = layui.layedit
    ,laydate = layui.laydate;

    var index = parent.layer.getFrameIndex(window.name);
    //日期
    var now = new Date();
    var year = now.getFullYear();       //年
    var month = now.getMonth() + 1;     //月
    var day = now.getDate();            //日
    laydate.render({
        elem: '#create_time',
        event:"focus",
        format: 'yyyy-MM-dd',
        max: year+"-" + month + "-" + day,
        theme: 'grid'
    });   
    
    //监听指定开关
    form.on('switch(is_quit)', function(data){
        $('.on_position').find('.quit_info').remove();
        if(this.checked){
            $('.on_position').append('<input type="hidden" value="0" name="is_quit" class="quit_info">');
        }else{
            $('.on_position').append('<input type="hidden" value="-1" name="is_quit" class="quit_info">');
        }
    });

    var is_reset = 0;
    form.on('switch(reset)', function(data){
        if(this.checked){
            is_reset = 1;
            $('.show_pwd').removeClass('layui-hide');
        }else{
            is_reset = 0;
            $('.show_pwd').addClass('layui-hide');
        }
    });

    //监听选择框
    form.on('select(team)', function(data){
        var team = data.value;
        $('.sub_team').empty();
        var str = '<option value="0">分部总监</option>';
        if(team == 0){
            $('.sub_team').append(str);
        }else{
            $.ajax({
                url : '/scxfx_gk/user/get_sub_team',
                data : {team:team},
                type : "post",  
                async : false,  
                success : function(data){  
                    if(data.state == 1){
                        for(var i = 0; i< data.info.length; i ++){
                            str += '<option value="'+data.info[i].id+'">'+data.info[i].name+'</option>';                       
                        }
                        $('.sub_team').append(str);
                    }
                }  
            });
        }
    form.render('select');
    }); 


    //监听提交
    form.on('submit(save_user)', function(data){
        var username = $.trim($('.username').val());
        var tel = $.trim($('input[name=tel]').val());
        var create_time = $.trim($('input[name=create_time]').val());
        var pwd = $.trim($('.pwd').val());
        var s_pwd = $.trim($('.s_pwd').val());
        var ids = [];
        $('.chose_role:checked').each(function(){
            ids.push($(this).val());
        });
        if(username == ''){
            layer.msg('请输入用户名称', {
                icon: 0,
                time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                anim: 6
            });
            return false;
        }
        if(tel == ''){
            layer.msg('请输入联系电话', {
                icon: 0,
                time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                anim: 6
            });
            return false;
        }
        if(tag == 1){
            layer.msg('电话号码已存在或格式不正确，请重新输入', {
                icon: 0,
                time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                anim: 6
            });
            return false;
        }
        if(create_time == ''){
            layer.msg('请选择入职时间', {
                icon: 0,
                time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                anim: 6
            });
            return false;
        }
        if(ids == ''){
            layer.msg('请选择用户角色', {
                icon: 0,
                time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                anim: 6
            });
            return false;
        }
        if(is_reset == 1){
            if(pwd == ''){
                layer.msg('请输入密码', {
                    icon: 0,
                    time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                    anim: 6
                });
                return false;
            }
            if(s_pwd == ''){
                layer.msg('请再次输入密码', {
                    icon: 0,
                    time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                    anim: 6
                });
                return false;
            }
            if(pwd != s_pwd){
                layer.msg('两次输入密码不一致，请重新输入', {
                    icon: 0,
                    time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                    anim: 6
                });
                return false;
            }
            if(sign == 1){
                layer.msg('重置密码有误，请重新操作', {
                    icon: 0,
                    time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                    anim: 6
                });
                return false;
            }
        }
    });
    
    $('#close').click(function(){
        parent.layer.close(index);
    });

    var success = "<?php echo $s; ?>";
    if (success == '1') {
        layer.msg('编辑成功', {
            icon: 1,
            time: 2000 //2秒关闭（如果不配置，默认是3秒）
        }, function(){
            parent.layer.close(index);
        });
        setTimeout(function(){
            parent.location.reload();
        },500);
    }
  });

</script>