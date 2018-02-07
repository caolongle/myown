<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"E:\phpstudy\PHPTutorial\WWW\crm_gk\public/../application/scxfx_gk\view\user\add_role.html";i:1516859349;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>角色列表</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/static/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/static/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/static/css/animate.min.css" rel="stylesheet">
    <link href="/static/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>
<style type="text/css">
    .role_pri input[type="checkbox"]{
        display: none;
    }
    .role_pri input[type="checkbox"]+label {
        display: inline-block;
        width: 40%;
        margin-top: 10px;
        margin-left: 5px;
        text-align: left;
        -webkit-box-sizing: border-box;
    }

    .role_pri label::before {
        content: "";
        display: inline-block;
        width: 20px;
        height: 20px;
        background: white;
        border:1px solid lightgrey;
        vertical-align: middle;
        /*-webkit-border-radius: 50%;*/
        margin-right: 5px;
        -webkit-box-sizing:border-box;
        -webkit-transition:background ease-in .5s
    }

    .role_pri input[type="checkbox"]:checked+label::before{
        background-color: rgb(53, 183, 111);
        border: 5px #EEE solid;
    }
    .role_pri label:hover::before {
       border:1px solid limegreen;
    }
</style>
<body>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form method="post" action='add_role_info' class="form-horizontal" onsubmit="return check()">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">角色名称：</label>
                            <div class="col-sm-10">
                                <input  type="text"  class="form-control role_name" name="role_name" placeholder="请输入角色名称" />
                                <span class="help-block m-b-none" style="color:red;display: none;">*角色名称不能为空</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属上级：</label>
                            <div class="col-sm-10">
                                <select name="parent_id" class="form-control">
                                    <option value="0">最高级</option>
                                    <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $val['id']; ?>"><?php echo $val['r_name']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">角色权限：</label>
                            <div class="col-sm-10 role_pri">
                                <?php foreach($privilege as $v):if($v['parent_id'] == 0):?><div class="hr-line-dashed"></div><?php endif;?>
                                <?php echo str_repeat('&nbsp', 6*$v['level']); ?>
                                    <input type="checkbox" value="<?php echo $v['id']; ?>" name="pri_id[]" class="pri" id="pri<?php echo $v['id']; ?>" level="<?php echo $v['level']?>" style="margin:5px;">
                                    <label for="pri<?php echo $v['id']; ?>" style="margin-left: 10px"><?php echo $v['p_name']; ?></label>
                                <br/>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary"  type="submit">保存内容</button>&nbsp;&nbsp;
                                <a class="btn btn-white" id="close">取消</a>
                            </div>
                        </div>
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
<script src="/static/js/layer/layer.js"></script>
<script src="/static/js/content.min.js"></script>
<script type="text/javascript">
    var index = parent.layer.getFrameIndex(window.name);
    $('#close').click(function(){
        parent.layer.close(index);
    });
    var success = "<?php echo $s; ?>";
    if (success == '1') {
        layer.msg('添加成功', {
            icon: 1,
            time: 2000 //2秒关闭（如果不配置，默认是3秒）
        }, function(){
            parent.layer.close(index);
        });
        setTimeout(function(){
            parent.location.reload();
        },500);
    }
    var tag = 0;
    $('input[name=role_name]').blur(function(){
        var r_name = $.trim($(this).val());
        if(r_name != ''){
            $.post('/scxfx_gk/user/check_rname',{r_name:r_name},function(data){
                if(data.state == 1){
                    layer.tips(data.info,'.role_name',{
                        tips: [3, '#D15B47'],
                        time: 2500
                    });
                    tag = 1;
                }else{
                    tag = 0;
                }
            });
        }
    });
    function check(){
        var p_name = $.trim($('input[name=role_name]').val());
        $.post('/scxfx_gk/user/check_rname',{r_name:r_name},function(data){
                if(data.state == 1){
                    tag = 1;
                }else{
                    tag = 0;
                }
            });
        if(p_name == ''){
            layer.msg('请填写角色名称', {
                icon: 0,
                time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                anim: 6
            });
            return false;
        }
        if(tag == 1){
            layer.msg('该角色已存在，请重新输入', {
                icon: 0,
                time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                anim: 6
            });
            return false;
        }
        var ids = new Array();
        $('.pri:checked').each(function(){
            ids.push($(this).val());
        });
        if(ids == ''){
            layer.msg('请选择角色权限', {
                icon: 0,
                time: 2000 ,//2秒关闭（如果不配置，默认是3秒）
                anim: 6
            });
            return false;
        }
    }
    $(":checkbox").click(function() {
        //获取当前选中复选框的level值
        var cur_level = $(this).attr('level');
        //区分选中和取消
        if ($(this).prop('checked')) {
            var tmp_level = cur_level;
            //获取当前复选框前面的所有复选框
            var allprev = $(this).prevAll();
            $(allprev).each(function(k, v) {
                //判断是否为其父级
                if ($(v).attr('level') < tmp_level) {
                    tmp_level--;//向上提一个级别
                    $(v).prop('checked', true);
                }
            });
            //选中父级其子级全部选中
            var allnext = $(this).nextAll();
            $(allnext).each(function(k, v) {
                //判断是否为其子级
                if ($(v).attr('level') > cur_level) {
                    $(v).prop('checked',true);
                } else if ($(v).attr('level') == cur_level) {
                    return false;//遇到级别相同的就停止
                }
            });
        } else {
            //获取当前复选框后面的所有复选框
            var allnext = $(this).nextAll();
            $(allnext).each(function(k, v) {
                //判断是否为其子级
                if ($(v).attr('level') > cur_level) {
                    $(v).prop('checked',false);
                } else if ($(v).attr('level') == cur_level) {
                    return false;//遇到级别相同的就停止
                }
            });
        }
    });
</script>