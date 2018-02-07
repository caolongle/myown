<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"E:\phpstudy\PHPTutorial\WWW\crm_gk\public/../application/scxfx_gk\view\user\add_team.html";i:1517206337;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>分组列表</title>
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
                    <form method="post" action='add_team_info' class="form-horizontal" onsubmit="return check()">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">分组名称：</label>
                            <div class="col-sm-10">
                                <input  type="text"  class="form-control team_name" name="team_name" placeholder="请输入分组名称" />
                                <span class="help-block m-b-none" style="color:red;display: none;">*角色名称不能为空</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属分部：</label>
                            <div class="col-sm-10">
                                <select name="father_team" class="form-control father_team">
                                    <option value="0">请选择</option>
                                    <option value="1">挂靠一部</option>
                                    <option value="2">挂靠二部</option>
                                </select>
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
    var success = '<?php echo $success; ?>';
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
    $('input[name=team_name]').blur(function(){
        var t_name = $.trim($(this).val());
        if(t_name != ''){
            $.post('check_tname',{t_name:t_name},function(data){
                if(data.state == 1){
                    layer.tips(data.info,'.team_name',{
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
        var t_name = $.trim($('input[name=team_name]').val());
        var father_team = $('.father_team').val();
        if(t_name == ''){
            layer.tips('请填写分组名称','.team_name',{
                        tips: [3, '#D15B47'],
                        time: 2500
                    });
            return false;
        }
        $.ajax({  
            type : "post",  
            url : "/scxfx_gk/user/check_tname",  
            data : {t_name:t_name},  
            async : false,  
            success : function(data){  
                if(data.state == 1){
                    tag = 1;
                }else{
                    tag = 0;
                }
            }  
        }); 
        if(tag == 1){
            layer.tips('该组名已存在','.team_name',{
                        tips: [3, '#D15B47'],
                        time: 2500
                    });
            return false;
        }
        if(father_team == 0){
            layer.tips('请选择所属分部','.father_team',{
                        tips: [3, '#D15B47'],
                        time: 2500
                    });
            return false;
        }
    }
</script>