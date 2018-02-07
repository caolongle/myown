<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:92:"E:\phpstudy\PHPTutorial\WWW\crm_gk\public/../application/scxfx_gk\view\user\depart_list.html";i:1517219570;s:47:"../application/scxfx_gk/view/common/header.html";i:1517382407;s:45:"../application/scxfx_gk/view/common/body.html";i:1517383856;s:49:"../application/scxfx_gk/view/common/resource.html";i:1517194925;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	    <meta charset="utf-8" />
    <title>四川新方向CRM-控制台</title>
    <meta name="keywords" content="四川新方向CRM" />
    <meta name="description" content="四川新方向CRM" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="/static/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/static/css/common.css" rel="stylesheet" />
    <link rel="stylesheet" href="/static/assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/static/css/toastr.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/static/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->

    <!-- ace styles -->

    <link rel="stylesheet" href="/static/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/static/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/static/assets/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/static/assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="/static/assets/js/html5shiv.js"></script>
    <script src="/static/assets/js/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        /*#gritter-notice-wrapper {
            top: 46px !important;
            width: 390px !important;
        }
        .gritter-title {
            font-size: 21px !important;
        }
        .gritter-item p {
            font-size: 18px;
        }
       */
		#toast-container {
		    margin-top: 47px;
		}
		#toast-container.toast-bottom-full-width > div, #toast-container.toast-top-full-width > div {
    		height: 60px;
		}
		.toast-message{
			margin-top: 5px;
			font-size:16px;
			text-align: center;
		}
    </style>
</head>
<style type="text/css">
	#sample-table-1>tbody>tr.selected>td {
		background-color: #dff0d8;
	}
	#sample-table-1>tbody>tr>td {
		text-align: center;
	}
	#sample-table-1>tbody>tr.selected:hover>td {
		background-color: #d0e9c6;
	}
	.pagination{
		margin:0;
	}
</style>
<body>
<style type="text/css">
    .font_big{
        font-size: 15px !important;
        height: 24px;
    }
    .show_remark{
    	color:lightcoral;
    }
    .remark_width{
    	min-width: 260px;;
    }
    .remark_width_my{
    	min-width: 180px;;
    }
    th,.timer,.contact_user,.customer_level,.customer_type,.pull-in{
        white-space: nowrap;
    }
    .pagination{
    	margin:0 !important
    }
    .name_line_highseas{
    	width:230px;
    	overflow: hidden;
    	text-overflow:ellipsis;
    	white-space: nowrap;
    }
    .company_name{
    	width:230px;
    }
</style>
<div class="bg_div"></div>
<div class="import_div">
    <div class="spinnergd">
        <div class="spinner-containergd container1gd">
            <div class="circle1gd"></div>
            <div class="circle2gd"></div>
            <div class="circle3gd"></div>
            <div class="circle4gd"></div>
        </div>
        <div class="spinner-containergd container2gd">
            <div class="circle1gd"></div>
            <div class="circle2gd"></div>
            <div class="circle3gd"></div>
            <div class="circle4gd"></div>
        </div>
        <div class="spinner-containergd container3gd">
            <div class="circle1gd"></div>
            <div class="circle2gd"></div>
            <div class="circle3gd"></div>
            <div class="circle4gd"></div>
        </div>
    </div>
</div>
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <img src="/static/img/logo_min.png" style="width: 22px;"/>
                		新方向客户管理系统V1.0
                </small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->

        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">

                <li class="purple">
                    <?php if($waiting_count > 0): ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-bell-alt icon-animated-bell"></i>
                            <span class="badge badge-important"><?php echo $waiting_count; ?></span>
                        </a>
                    <?php endif; ?>
                    <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">

                        <li class="dropdown-header">
                            <i class="icon-warning-sign"></i>
                            <?php echo $waiting_count; ?>条通知
                        </li>

                        <li>
                            <a href="daiban">
                                <div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink icon-comment"></i>
												待办事项
											</span>
                                    <span class="pull-right badge badge-info">+<?php echo $waiting_count; ?></span>
                                </div>
                            </a>
                        </li>

                        <!--<li>-->
                            <!--<a href="#">-->
                                <!--<div class="clearfix">-->
											<!--<span class="pull-left">-->
												<!--<i class="btn btn-xs no-hover btn-success icon-shopping-cart"></i>-->
												<!--新订单-->
											<!--</span>-->
                                    <!--<span class="pull-right badge badge-success">+8</span>-->
                                <!--</div>-->
                            <!--</a>-->
                        <!--</li>-->

                        <!--<li>-->
                            <!--<a href="#">-->
                                <!--<div class="clearfix">-->
											<!--<span class="pull-left">-->
												<!--<i class="btn btn-xs no-hover btn-info icon-twitter"></i>-->
												<!--粉丝-->
											<!--</span>-->
                                    <!--<span class="pull-right badge badge-info">+11</span>-->
                                <!--</div>-->
                            <!--</a>-->
                        <!--</li>-->

                        <!--<li>-->
                            <!--<a href="#">-->
                                <!--查看所有通知-->
                                <!--<i class="icon-arrow-right"></i>-->
                            <!--</a>-->
                        <!--</li>-->
                    </ul>
                </li>

                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="/static/assets/avatars/user.jpg" />
                        <span class="user-info">
									<small>欢迎光临,</small>
                            <?php echo session('admin_name');?>
								</span>

                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

                        <li>
                            <a href="xinxi">
                                <i class="icon-user" data-rel="tooltip"></i>
                                个人资料
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="javascript:logout();">
                                <i class="icon-off"></i>
                                退出
                            </a>
                        </li>
                    </ul>
                </li>
            </ul><!-- /.ace-nav -->
        </div><!-- /.navbar-header -->
    </div><!-- /.container -->
</div>
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>

        <div class="sidebar" id="sidebar">
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>

            <ul class="nav nav-list">

                <li <?php if($c_name == 'Index'): ?> class="active" <?php endif; ?>>
                <a href="/">
                    <i class="icon-dashboard"></i>
                    <span class="menu-text"> 控制台 </span>
                </a>
                </li>
                <?php foreach($privilege as $val):if($val['parent_id'] == 0):static $i=0;$i++;?>
                <li <?php if($c_name == $val['c_name']): ?> class="active open" <?php endif; ?>>
                <a <?php if($val['url'] == ''):?> href="#" class="dropdown-toggle" <?php else:?> href="<?php echo $val['url']; ?>" <?php endif;?>>
                <?php switch($i): case "1": ?><i class="icon-user"></i><?php break; case "2": ?><i class="icon-move"></i><?php break; case "3": ?><i class="icon-flag"></i><?php break; case "4": ?><i class="icon-list-alt"></i><?php break; case "5": ?><i class="icon-exclamation-sign"></i><?php break; case "6": ?><i class="icon-bar-chart"></i><?php break; default: ?><i class="icon-list"></i>
                <?php endswitch; ?>
                <span class="menu-text"> <?php echo $val['p_name']; ?> </span>
                <?php if($val['url'] == ''):?><b class="arrow icon-angle-down"></b><?php endif;?>
                </a>

                <ul class="submenu">
                    <?php foreach($privilege as $v):if($v['is_show'] == 0):if($val['id'] == $v['parent_id']):?>

                    <li <?php if($a_name == $v['a_name']): ?> class="active" <?php endif; ?>>
                        <a <?php if($v['url'] != ''):?> href="<?php echo $v['url']; ?>" <?php else:?> href="#" class="dropdown-toggle" <?php endif;?>>
                        <i class="icon-double-angle-right"></i>
                        <?php echo $v['p_name']; if($v['a_name'] == "work_waiting"):?><span class="badge badge-danger"><?php echo $waiting_count; ?></span><?php endif;if($v['url'] == ''):?><b class="arrow icon-angle-down"></b><?php endif;?>
                        </a>
                        <ul class="submenu">
                            <?php foreach($privilege as $vv):if($v['id'] == $vv['parent_id']):?>
                            <li>
                                <a href="<?php echo $vv['url']; ?>">
                                    <i class="menu-icon icon-leaf <?php if($vv['p_name'] == "人才库"):?>red<?php else:?>green<?php endif;?>"></i>
                                    <?php echo $vv['p_name']; ?>
                                </a>
                            </li>
                            <?php endif;endforeach;?>
                        </ul>
                    </li>

                    <?php endif;endif;endforeach;?>

                </ul>
                </li>

                <?php endif;endforeach;?>

            </ul><!-- /.nav-list -->

            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>

            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
            </script>
        </div>

        <div class="main-content">
            <div class="breadcrumbs" id="breadcrumbs">
                <script type="text/javascript">
                    try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                </script>

                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home home-icon"></i>
                        <a href="/">首页</a>
                    </li>
                    <li class="active"><?php if($c_name == 'Index'): ?>控制台<?php else: ?><?php echo get_pname($a_name); endif; ?></li>
                </ul><!-- .breadcrumb -->

            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        <?php if($c_name == 'Index'): ?>控制台<?php else: ?><?php echo get_pname($a_name); endif; ?>
                        <!--<small>-->
                        <!--<i class="icon-double-angle-right"></i>-->
                        <!--查看-->
                        <!--</small>-->
                    </h1>
                </div><!-- /.page-header -->

                <div class="ace-settings-container" id="ace-settings-container">
                    <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                        <i class="icon-cog bigger-150"></i>
                    </div>

                    <div class="ace-settings-box" id="ace-settings-box">
                        <div>
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-skin="default" value="#438EB9">#438EB9</option>
                                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                </select>
                            </div>
                            <span>&nbsp; 选择皮肤</span>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                            <label class="lbl" for="ace-settings-navbar"> 固定导航条</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                            <label class="lbl" for="ace-settings-sidebar"> 固定滑动条</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                            <label class="lbl" for="ace-settings-breadcrumbs">固定面包屑</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                            <label class="lbl" for="ace-settings-rtl">切换到左边</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                            <label class="lbl" for="ace-settings-add-container">
                                切换窄屏
                                <b></b>
                            </label>
                        </div>
                    </div>
                </div><!-- /#ace-settings-container -->
            </div><!-- /.main-container-inner -->
<form action="/scxfx_gk/search/search_user" method="get" onsubmit="return search_before()">
	<div class="col-xs-10 pull-left">
		
		<?php if($level == 0): ?>
			<div class="col-xs-8" style="line-height: 34px;">
				<b style="float:left">分部</b>
				<select style="width:20%;float: left;height:34px;margin-left: 15px;" id="sub_depart" name="sub_depart">
					<option value="-1">请选择</option>
					<option value="1">挂靠一部</option>
					<option value="2">挂靠二部</option>
				</select>
			</div>
		<?php endif; ?>
		
	</div>
</form>
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<div class="hr hr-18 dotted hr-double"></div>

		<div class="row">
			<div class="col-xs-12">
							<!-- PAGE CONTENT BEGINS -->
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive">
							<table id="sample-table-1" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="center">
											<label>
												<input type="checkbox" class="ace" />
												<span class="lbl"></span>
											</label>
										</th>
										<th>
											<i class="icon-list bigger-110 hidden-480"></i>
											编号
										</th>
										<th>
											<i class="icon-leaf bigger-110 hidden-480"></i>
											名称
										</th>
										<th>
											<i class="icon-user bigger-110 hidden-480"></i>
											所属分部
										</th>
										<th>
											<i class="icon-time bigger-110 hidden-480"></i>
											创建时间
										</th>
										<th>
											<i class="icon-gears bigger-110 hidden-480"></i>
											操作
										</th>
									</tr>
								</thead>
								<tbody>
									<?php if(is_array($team) || $team instanceof \think\Collection || $team instanceof \think\Paginator): $i = 0; $__LIST__ = $team;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
										<tr>
											<td class="center">
												<label>
													<input type="checkbox" class="ace" value="<?php echo $val['id']; ?>"/>
													<span class="lbl"></span>
												</label>
											</td>
											<td><?php echo $val['id']; ?></td>
											<td><span class="label label-success arrowed"><?php echo $val['name']; ?></span></td>
											<td>挂靠 <?php echo $val['father_team']; ?> 部</td>
											<td><?php echo date('Y-m-d H:i:s',$val['create_time']); ?></td>
											<td>
												<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">

													<a class="green iframe" value="/scxfx_gk/user/edit_team/id/<?php echo $val['id']; ?>" style="cursor: pointer" cate="1">
														<i class="icon-pencil bigger-130"></i>
														编辑
													</a>
													&nbsp;

													<a class="red del" style="cursor: pointer" onclick="del(<?php echo $val['id']; ?>)">
														<i class="icon-trash bigger-130"></i>
														删除
													</a>

												</div>

												<div class="visible-xs visible-sm hidden-md hidden-lg">
													<div class="inline position-relative">
														<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
															<i class="icon-cog icon-only bigger-110"></i>
														</button>

														<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">

															<li>
																<a class="tooltip-success iframe" data-rel="tooltip" title="编辑" value="/scxfx_gk/user/edit_team/id/<?php echo $val['id']; ?>" cate="1">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a>
															</li>

															<li>
																<a class="tooltip-error del" data-rel="tooltip" title="删除" onclick="del(<?php echo $val['id']; ?>)">
																	<span class="red">
																		<i class="icon-trash bigger-120"></i>
																	</span>
																</a>
															</li>

														</ul>
													</div>
												</div>
											</td>
										</tr>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</tbody>
							</table>
						</div><!-- /.table-responsive -->
					</div><!-- /span -->

					<div class="col-xs-11" style="position: relative">

						<div style="float: left">
							<button class="btn btn-sm btn-pink iframe" value="/scxfx_gk/user/add_team" cate="2">
								<i class="icon-plus align-top bigger-125"></i>
								新增
							</button>
							<!--<button class="btn btn-sm btn-purple quit">-->
								<!--<i class="icon-remove align-top bigger-125"></i>-->
								<!--离职-->
							<!--</button>-->
							<a onclick="window.location.reload();">
								<button class="btn btn-sm btn-success">
									<i class="icon-refresh align-top bigger-125"></i>
									刷新
								</button>
							</a>
						</div>
						<div class="pagination" style="float: right;margin:0">
							<?php echo $page; ?>
						</div>

					</div>
				</div><!-- /row -->

				<div class="hr hr-18 dotted hr-double"></div>

			</div><!-- /.col -->
			</div>
			</div><!-- /.col -->
			</div><!-- /.row -->

		</div><!-- /.page-content -->
	</div><!-- /.main-content -->

</div><!-- /.main-container-inner -->

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
	<i class="icon-double-angle-up icon-only bigger-110"></i>
</a>

</div><!-- /.main-container -->
	<!-- basic scripts -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='/static/assets/js/jquery-2.0.3.min.js'>"+"<"+"script>");
</script>


<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/static/assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");
</script>
<![endif]-->

<!--<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='/static/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
</script>-->
<script src="/static/assets/js/bootstrap.min.js"></script>
<script src="/static/assets/js/typeahead-bs2.min.js"></script>
<!-- ace scripts -->

<script src="/static/assets/js/ace-elements.min.js"></script>
<script src="/static/assets/js/ace.min.js"></script>
<script src="/static/assets/js/bootbox.min.js"></script>
<!--<script src="/static/assets/js/jquery.gritter.min.js"></script>-->
<script src="/static/js/toastr.min.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
    function logout(){
        bootbox.confirm("确定退出？", function(result) {
            if(result) {
                window.location.href = '/login.html';
            }
        });
    }
</script>
	<!-- page specific plugin scripts -->

<script src="/static/assets/js/jquery.dataTables.min.js"></script>
<script src="/static/assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="/static/js/layer/layer.js"></script>

<script type="text/javascript">
	jQuery(function($) {
		$('table th input:checkbox').on('click' , function(){
			var that = this;
			$(this).closest('table').find('tr > td:first-child input:checkbox').each(function(){
				this.checked = that.checked;
				if(this.checked){
					$(this).closest('tr').addClass('selected');
				}else{
					$(this).closest('tr').removeClass('selected');
				}
			});
		});

		$('#sample-table-1 tbody tr input:checkbox').on('click',function(){
			if($(this).closest('tr').hasClass('selected')){
				$(this).closest('tr').removeClass('selected').find('td:first-child input:checkbox').prop("checked",false);
			}else{
				$(this).closest('tr').addClass('selected').find('td:first-child input:checkbox').prop("checked",true);
			}
		});


		$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

		function tooltip_placement(context, source) {
			var $source = $(source);
			var $parent = $source.closest('table');
			var off1 = $parent.offset();
			var w1 = $parent.width();

			var off2 = $source.offset();
			var w2 = $source.width();

			if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
			return 'left';
		}

		$('.iframe').click(function(){
            var type = $(this).attr('cate');
            var url = '';
            var title = '';
            if(type == 1){
                url = $(this).attr('value');
                title = '编辑分组';
            }else{
                url = $(this).val();
                title = '新增分组';
            }
			$('.bg_div').show();
			layer.open({
				title: title,
				type: 2,
				area: ['50%', '40%'],
				fix: true, //固定
				maxmin: false,
//				scrollbar: false,
//				move: false,
				shade: 0,
				content: url,
				end: function(){
					$('.bg_div').hide();
				}
			});
		});
	
	});
    function del(id){
        layer.confirm('确定删除该分组?', {icon: 3, title:'删除'}, function(){
            $.post('/scxfx_gk/user/del_team',{id:id},function(data){
                if(data.state == 1){
					layer.msg(data.info, {
                        icon: 1,
                        time: 2000, //2秒关闭（如果不配置，默认是3秒）
                        anim: 4
                    });
                    setTimeout(function(){
                        window.location.reload();
                    },500);
                }else{
					layer.msg(data.info, {
						icon: 2,
						time: 4000, //2秒关闭（如果不配置，默认是3秒）
						anim: 6
					});
					setTimeout(function(){
						window.location.reload();
					},1500);
                }
            });
        });
    }
    
</script>
</body>
</html>
