<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:93:"E:\phpstudy\PHPTutorial\WWW\crm_gk\public/../application/scxfx_gk\view\center\my_company.html";i:1517982362;s:47:"../application/scxfx_gk/view/common/header.html";i:1517382407;s:45:"../application/scxfx_gk/view/common/body.html";i:1517383856;s:49:"../application/scxfx_gk/view/common/resource.html";i:1517194925;}*/ ?>
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
	<link rel="stylesheet" href="/static/assets/css/font-awesome.css" />
	<link rel="stylesheet" href="/static/assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
	<script src="/static/assets/js/ace-extra.js"></script>
</head>
<style type="text/css">
	#sample-table-1>tbody>tr.selected>td {
		background-color: #dff0d8;
	}
	#sample-table-1>tbody>tr.selected:hover>td {
		background-color: #d0e9c6;
	}
	#push_tree{
		position:fixed;
		z-index: 21;
		left:40%;
		display: none;
	}
	.push_content{
		min-width: 500px;
	}
	.widget-body{
		max-height: 550px;
		min-height:180px;
		overflow-y: scroll;
		overflow-x: hidden;
	}
	.sidebar:before {
		content: "";
		display: block;
		width: 190px;
		position: fixed;
		bottom: 0;
		top: 0;
		z-index: -1;
		background-color: #f2f2f2;
		border: 1px solid #ccc;
		border-width: 0 1px 0 0;
	}
	.nav-list>li.open>a {
		background-color: #fafafa;
		color: #1963aa;
	}
	.nav-list>li>a {
		display: block;
		height: 38px;
		line-height: 36px;
		padding: 0 16px 0 7px;
		background-color: #f9f9f9;
		color: #585858;
		text-shadow: none!important;
		font-size: 13px;
		text-decoration: none;
	}
	.nav-list>li .submenu {
		display: none;
		list-style: none;
		margin: 0;
		padding: 0;
		position: relative;
		background-color: #fff;
		border-top: 1px solid #e5e5e5;
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
			<div id="push_tree">
				<div class="push_content">
					<div class="widget-box widget-color-blue2">
						<div class="widget-header">
							<h4 class="widget-title lighter smaller">推荐/移交客户</h4>
							<button class="btn btn-sm" style="float: right;padding: 6px 9px" id="close_push">关&nbsp;闭&nbsp;X</button>
							<button class="btn btn-sm btn-success" id="sure_push" style="float: right;padding: 6px 9px">确&nbsp;&nbsp;定</button>
						</div>
						<div class="widget-body">
							<div class="widget-main padding-8">
								<ul id="tree1"></ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12">
				<!-- PAGE CONTENT BEGINS -->
				<div class="row">
					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->

						<div class="tabbable">
							<ul class="nav nav-tabs padding-18 tab-size-bigger" id="myTab">
								<li class="active">
									<a data-toggle="tab" href="#faq-tab-1">
										<i class="blue icon-question-sign bigger-120"></i>
										未联系&nbsp;&nbsp;&nbsp;<span style="color: #478fca;font-size: 18px;"><?php echo $wCount; ?>/100</span>
									</a>
								</li>

								<li>
									<a href="gengjin">
										<i class="green icon-user bigger-120"></i>
										跟进中&nbsp;&nbsp;&nbsp;<span style="color: #69aa46;font-size: 18px;"><?php echo $gCount; ?></span>
									</a>
								</li>

								<li>
									<a href="qianyue">
										<i class="purple icon-credit-card bigger-120"></i>
										匹配中&nbsp;&nbsp;&nbsp;<span style="color: #a069c3;font-size: 18px;"><?php echo $qCount; ?></span>
									</a>
								</li>

								<li>
									<a href="qianyue">
										<i class="orange icon-warning-sign bigger-120"></i>
										未完成&nbsp;&nbsp;&nbsp;<span style="color: #ff892a;font-size: 18px;"><?php echo $qCount; ?></span>
									</a>
								</li>

								<li>
									<a href="wancheng">
										<i class="green icon-ok-sign bigger-120"></i>
										已完成&nbsp;&nbsp;&nbsp;<span style="color: #69aa46;font-size: 18px;"><?php echo $dCount; ?></span>
									</a>
								</li>

								<li>
									<a href="wancheng">
										<i class="red icon-ban-circle bigger-120"></i>
										退款&nbsp;&nbsp;&nbsp;<span style="color: red;font-size: 18px;"><?php echo $dCount; ?></span>
									</a>
								</li><!-- /.dropdown -->
							</ul>

							<div class="tab-content no-border padding-24">
								<div id="faq-tab-1" class="tab-pane fade in active">
									<h4 class="blue">
										<i class="icon-question-sign bigger-110"></i>
										未联系
									</h4>
									<form action="search_my" method="get" onsubmit="return search_before()">
										<div class="col-xs-12 pull-right">
											<div class="col-xs-3" style="line-height: 34px;">
												<b style="float: left">办理业务</b>
												<select style="width:65%;float: left;height:34px;margin-left: 10px;" class="type" name="type">
													<option value="-1">请选择</option>
													
												</select>
											</div>
											<div class="col-xs-3" style="line-height: 34px;">
												<b style="float: left"></b>
												<select style="width:65%;float: left;height:34px;margin-left: 10px;" class="category" name="category">
													<option value="-1">请选择</option>
												</select>
											</div>
											<div class="col-xs-3" style="line-height: 34px;">
												<b style="float: left">客户意向</b>
												<select style="width:65%;float: left;height:34px;margin-left: 10px" class="level" name="level">
													<option value="-1">请选择</option>
													
												</select>
											</div>
											<div class="col-xs-3">
												<div class="input-group">
													<input type="text" class="form-control" placeholder="请输入公司名称" name="customer_name"/>
													<span class="input-group-btn">
														<button type="submit" class="btn btn-info btn-sm">
															<span class="icon-search icon-on-right bigger-110"></span>
														</button>
													</span>
												</div>
											</div>
											<input type="hidden" name="progress" value="0"/>
										</div>
									</form>
									<hr style="margin-top: 65px;"/>
									<form action="search_my_tel" method="get" onsubmit="return search_tel_before()">
										<div class="col-xs-4 pull-right" style="line-height: 34px;">
											<b style="float: left">联系电话：</b>
											<input type="text" class="form-control search-query" placeholder="请输入联系电话" name="customer_tel" style="float: left;width:50%;margin-left: 10px;"/>
											<button type="submit" class="btn btn-info btn-sm" style="float: left">检索</button>
										</div>
										<input type="hidden" name="progress" value="0"/>
									</form>
									<div style="clear: both"></div>
									<div class="hr hr-18 dotted hr-double"></div>

									<div id="faq-list-1" class="row">
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
																<th style="width:230px;">
																	<i class="icon-building bigger-110 hidden-480"></i>
																	公司名称
																</th>
																<th>
																	<i class="icon-time bigger-110 hidden-480"></i>
																	剩余保护时间
																</th>
																<th>
																	<i class="icon-user bigger-110 hidden-480"></i>
																	联系人
																</th>
																<th class="hidden-480">
																	<i class="icon-star bigger-110 hidden-480"></i>
																	意向等级
																</th>
																<th>
																	<i class="icon-magnet bigger-110 hidden-480"></i>
																	办理业务
																</th>
																<th>
																	<i class="icon-phone bigger-110 hidden-480"></i>
																	跟进记录
																</th>
																<th class="hidden-480 remark_width_my">
																	<i class="icon-tag bigger-110 hidden-480"></i>
																	备注
																</th>
																<th class="hidden-480">
																	<i class="icon-pushpin bigger-110 hidden-480"></i>
																	来源
																</th>
																<th>
																	<i class="icon-wrench bigger-110 hidden-480"></i>
																	操作
																</th>
															</tr>
															</thead>
															<?php if($count == 0): ?><h2 class="pink" style="margin-top:0">没有搜索到相关客户</h2><?php endif; ?>
														<tbody>
														
															<tr>
																<td class="center">
																	<label>
																		<input type="checkbox" class="ace" value="<?php echo $val['id']; ?>"/>
																		<span class="lbl"></span>
																	</label>
																</td>
																<td><span class="label label-purple font_big" style="width:230px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;"></span></td>
																<td class="timer"></td>
																<td class="contact_user" style="font-size:16px"></td>
																<td class="hidden-480">
																	
																</td>
																<td class="customer_type"></td>
																<td>
																	<button class="btn btn-xs btn-danger do_contact" value="/scxfx_gk/personal/do_contact/id//progress/1" title="跟进录入">
																		<i class="icon-pencil align-top bigger-125"></i>
																		马上录入
																	</button>
																	&nbsp;
																</td>
																<td class="hidden-480" style="max-width: 350px;"></td>
																<td class="hidden-480"></td>
															<td>
																<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">

																	<a class="green iframe pull-in" value="/scxfx_gk/center/edit_company/id/" style="cursor: pointer" cate="1">
																		<i class="icon-edit bigger-130"></i>
																		编辑
																	</a>
																	&nbsp;
																	<a class="red del pull-in" style="cursor: pointer" onclick="do_throw()">
																		<i class="icon-share bigger-130"></i>
																		扔进公海
																	</a>
																	&nbsp;
																	<a class="blue recommend pull-in" style="cursor: pointer" onclick="do_push()">
																		<i class="icon-arrow-right bigger-130"></i>
																		推荐
																	</a>
																</div>

																<div class="visible-xs visible-sm hidden-md hidden-lg">
																	<div class="inline position-relative">
																		<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
																			<i class="icon-cog icon-only bigger-110"></i>
																		</button>

																		<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">

																			<li>
																				<a class="tooltip-success iframe" data-rel="tooltip" title="编辑" value="/scxfx_gk/center/edit_company/id/" cate="1">
																					<span class="green">
																						<i class="icon-edit bigger-120"></i>
																					</span>
																				</a>
																			</li>

																			<li>
																				<a class="tooltip-error del" data-rel="tooltip" title="扔进公海" onclick="do_throw()">
																					<span class="red">
																						<i class="icon-trash bigger-120"></i>
																					</span>
																				</a>
																			</li>

																			<li>
																				<a class="tooltip-error" data-rel="tooltip" title="推荐" onclick="do_push()">
																					<span class="blue">
																						<i class="icon-arrow-right bigger-120"></i>
																					</span>
																				</a>
																			</li>

																		</ul>
																	</div>
																</div>
															</td>
														</tr>
													
														</tbody>
													</table>
												</div><!-- /.table-responsive -->
											</div><!-- /span -->

												<div class="col-xs-11" style="position: relative">

													<div style="float: left">
														<button class="btn btn-sm btn-primary iframe" value="/scxfx_gk/center/add_company" cate="2">
															<i class="icon-plus align-top bigger-125"></i>
															新增
														</button>
														<?php if($depart_id == 3): ?>
															<form action="/scxfx_gk/excel/personal_upload_customer" method="post" id="do_form" style="display: inline-block" enctype="multipart/form-data">
																<label class="btn btn-sm btn-pink" for="do_import">
																	<i class="icon-file align-top bigger-125"></i>
																	导入
																</label>
																<input type="file" name="file" id="do_import" style="display: none" accept=".csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
	
																<button class="btn btn-sm btn-success" id="make_sure" style="display: none;margin-left: -30px;">
																	<i class="icon-check align-top bigger-125"></i>
																	确定
																</button>
															</form> 
														<?php endif; ?>
														<button class="btn btn-sm  throw_out">
															<i class="icon-external-link-sign align-top bigger-125"></i>
															扔进公海
														</button>
														<a onclick="window.location.reload();">
															<button class="btn btn-sm btn-success">
																<i class="icon-refresh align-top bigger-125"></i>
																刷新
															</button>
														</a>
													</div>

													<div class="pagination" style="float: right;">
														
													</div>
											</div><!-- /row -->

										</div><!-- /.col -->
										<div class="hr hr-18 dotted hr-double"></div>
									</div>

								</div>
							</div>
						</div>

						<!-- PAGE CONTENT ENDS -->
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
<div style="position: fixed;top:35%;left:45%;width:20%;border: 1px solid #DDD;z-index:100;background: white;display: none;" class="to_import">
	<div class="widget-header" style="min-height: 25px;line-height: 35px;">扔回原因</div>
		<div style="margin:15px 0;">
			<select name="throw_reason" id="form-field-select-1" class="form-control" style="width:80%;margin-left: 5%;">
				<option value="-1">请选择</option>
				<option value="暂无需求">暂无需求</option>
				<option value="无法接通">无法接通</option>
				<option value="疑是同行">疑是同行</option>
				<option value="号码无效">号码无效</option>
				<option value="不在业务范围类">不在业务范围类</option>
			</select>
			<div style="clear:both;"></div>
		</div>
		<div style="width:100%;background-color: #EFF3F8;">
			<button class="btn btn-xs btn-danger to_close" style="float: left;margin:10px 0 10px 15px;display: block">关闭</button>
			<button class="btn btn-xs btn-success to_confirm" style="float: right;margin:10px 15px 10px 0;">确定</button>
			<div style="clear:both;"></div>
		</div>
	</div>
</div>
<input type="hidden" id="get_cid"/>
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
<!-- page specific plugin scripts -->
<script src="/static/js/layer/layer.js"></script>
<script src="/static/assets/js/fuelux/fuelux.tree.js"></script>
<!-- ace scripts -->
<script src="/static/assets/js/ace/elements.treeview.js"></script>

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

                $('.iframe').click(function(){
                    var type = $(this).attr('cate');
                    if(type == 1){
                        var url = $(this).attr('value');
                        var title = '编辑用户';
                        $('.bg_div').fadeIn();
                        layer.open({
                            title: title,
                            type: 2,
                            area: ['65%', '85%'],
                            fix: true, //固定
                            maxmin: false,
//                          scrollbar: false,
//                          move: false,
                            shade: 0,
                            content: url,
                            end: function(){
                                $('.bg_div').fadeOut();
                            }
                        });
                    }else{
                       var url = $(this).val();
                       var title = '新增用户';
                        var wCount = '<?php echo $wCount; ?>';
                        if(wCount < 100){
                            $('.bg_div').fadeIn();
                            layer.open({
                                title: title,
                                type: 2,
                                area: ['65%', '85%'],
                                fix: true, //固定
                                maxmin: false,
//                              scrollbar: false,
//                              move: false,
                                shade: 0,
                                content: url,
                                end: function(){
                                    $('.bg_div').fadeOut();
                                }
                            });
                        }else{
                            layer.msg('未联系客户已上限，不能继续添加资源', {
                                icon: 2,
                                time: 3000, //2秒关闭（如果不配置，默认是3秒）
                                anim: 6
                            });
                        }
                    }
                });

		$('.to_close').click(function(){
			$('.to_import').fadeOut();
			$('.bg_div').hide();
		});


				$('.throw_out').click(function(){
                    var str = [];
                    $('#sample-table-1').find('tr > td:first-child input:checkbox').each(function(){
                        if($(this).prop('checked')){
                            str.push($(this).val());
                        }
                    });
                    if(str != ''){
                        layer.confirm('确定将选中客户扔进公海？', {icon: 3, title:'扔进公海'}, function(){
								$.post('/scxfx_gk/personal/throw_out_batch',{ids:str},function(data){
                                    if(data.state == 1){
                                        layer.msg(data.info, {
                                            icon: 1,
                                            time: 3000, //2秒关闭（如果不配置，默认是3秒）
                                            anim: 4
                                        });
                                        setTimeout(function(){
                                            window.location.reload();
                                        },500);
                                    }else{
                                        layer.msg(data.info, {
                                            icon: 2,
                                            time: 3000, //2秒关闭（如果不配置，默认是3秒）
                                            anim: 6
                                        });
                                        setTimeout(function(){
                                            window.location.reload();
                                        },500);
                                    }
								})
                        });
                    }
				});

				$('.do_contact').click(function(){
                    var url = $(this).val();
                    var title = $(this).attr('title');
                    $('.bg_div').fadeIn();
                    layer.open({
                        title: title,
                        type: 2,
                        area: ['45%', '70%'],
                        fix: true, //固定
                        maxmin: false,
//                      scrollbar: false,
//                      move: false,
                        shade: 0,
                        content: url,
                        end: function(){
                            $('.bg_div').fadeOut();
                        }
                    });
				});

                var times = $('.timer');
                for(let i = 0; i<times.length; i++ ){
                   let rest = parseInt($(times[i]).html());
                   if(typeof rest != "number"){
                       break;
				   }else{
                       let h=0;
                       let m=0;
                       let s=0;
                       setInterval(function(){
                           rest --;
                           if( rest > 0 ){
                               h = Math.floor( rest / 60 / 60 % 24 );
                               m = Math.floor( rest / 60 % 60 );
                               s = Math.floor( rest % 60 );
                               $(times[i]).html('<span style="color:deepskyblue;font-weight: bolder;">'+h+'</span> 小时 <span style="color: #c11ac3;font-weight: bolder;">'+m+'</span> 分钟 <span style="color: red;font-weight: bolder;">'+s+'</span> 秒');
                           }else{
                            //    window.location.reload();
                           }
                       },1000);
				   }
                }
			});
			function do_throw(id){
				$('.to_import').fadeIn();
				$('.bg_div').show();
				$('#get_cid').val(id);
			}
			$('.to_confirm').click(function(){
		        var	reason = $('#form-field-select-1').val();
		        var cid = $('#get_cid').val();
	        	if(reason != -1){
	        		$.post('/scxfx_gk/personal/throw_out',{reason:reason,cid:cid},function(data){
					    if(data.state == 1){
                            layer.msg(data.info, {
                                icon: 1,
                                time: 3000, //2秒关闭（如果不配置，默认是3秒）
                                anim: 4
                            });
                            setTimeout(function(){
                                window.location.reload();
                            },500);
						}else{
                            layer.msg(data.info, {
                                icon: 2,
                                time: 3000, //2秒关闭（如果不配置，默认是3秒）
                                anim: 6
                            });
                            setTimeout(function(){
                                window.location.reload();
                            },500);
						}
					})
	        	}
	        });
//			function do_throw(id){
//              layer.confirm('确定将该客户扔进公海？', {icon: 3, title:'扔进公海'}, function(){
//						$.post('/scxfx_gk/personal/throw_out',{cid:id},function(data){
//						    if(data.state == 1){
//                              layer.msg(data.info, {
//                                  icon: 1,
//                                  time: 3000, //2秒关闭（如果不配置，默认是3秒）
//                                  anim: 4
//                              });
//                              setTimeout(function(){
//                                  window.location.reload();
//                              },500);
//							}else{
//                              layer.msg(data.info, {
//                                  icon: 2,
//                                  time: 3000, //2秒关闭（如果不配置，默认是3秒）
//                                  anim: 6
//                              });
//                              setTimeout(function(){
//                                  window.location.reload();
//                              },500);
//							}
//						})
//              });
//			}
	$('.type').change(function(){
		var type = $(this).val();
		$('.category').empty();
		if(type != -1){
			var str = '';
			$.post('/scxfx_gk/personal/get_category',{type:type},function(data){
				if(data.state == 1){
					str += "<option value='-1'>请选择</option>";
					for(var i = 0; i < data.info.length; i ++){
						str += '<option value="'+data.info[i].id+'">'+data.info[i].name+'</option>';
					}
					$('.category').append(str);
				}
			})
		}else{
			$('.category').append("<option value='-1'>请选择</option>");
		}
	});
	function search_before(){
		var category = $('.category').val();
		var type = $('.type').val();
		var level = $('.level').val();
		var customer_name = $.trim($('input[name=customer_name]').val());
		if(province == -1 && type == -1 && level == -1 && customer_name == ""){
			window.location.href = 'my';
			return false;
		}
	}
	function search_tel_before() {
		var customer_tel = $.trim($('input[name=customer_tel]').val());
		if(customer_tel == ""){
			return false;
		}
	}
</script>
<script type="text/javascript">
	var cid = 0;
    function do_push(id){
        cid = id;
        $(".widget-main").empty();
		$.post('/scxfx_gk/personal/get_users',function(data){
            var $userArr = data;

            var sampleData = function(options, callback){
                var $data = null;
                if(!("text" in options) && !("type" in options)){
                    $data = $userArr;//the root tree
                    callback({ data: $data });
                    return;
                }
                else if("type" in options && options.type == "folder") {
                    if("additionalParameters" in options && "children" in options.additionalParameters)
                        $data = options.additionalParameters.children;
                    else $data = {}//no data
                }

                if($data != null)//this setTimeout is only for mimicking some random delay
                    setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);

                //we have used static data here
                //but you can retrieve your data dynamically from a server using ajax call
                //checkout examples/treeview.html and examples/treeview.js for more info
            };

            $(".widget-main").append('<ul id="tree1"></ul>');
            $('#tree1').ace_tree({
                dataSource: sampleData,
                multiSelect: true,
                cacheItems: true,
                'open-icon' : 'ace-icon tree-minus',
                'close-icon' : 'ace-icon tree-plus',
                'selectable' : true,
                'selected-icon' : 'ace-icon fa fa-check',
                'unselected-icon' : 'ace-icon fa fa-times',
                loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'
            });
		});
        $("#tree1").find(".tree-folder-header").each(function(){
            if($(this).parent().css("display")=="block"){
                $(this).trigger("click");
            }
        });
        $('.bg_div').fadeIn();
        $('#push_tree').fadeIn();
    }
    jQuery(function($){
		$('#close_push').click(function(){
			$('#push_tree').fadeOut();
			$('.bg_div').fadeOut();
		});
		$('#sure_push').click(function(){
		    var count = 0;
		    var number = '';
            $('.tree-item').each(function(){
                if($(this).hasClass('tree-selected')){
					number = $(this).find('.tree-label').text();
                    count ++;
                }
            });
			if(count != 1){
                layer.tips("只能选一个人",'.widget-header',{
                    tips: [3, '#D15B47'],
                    time: 2500
                });
			}else{
				 layer.confirm('确定将该客户移交/推荐？', {icon: 3, title:'移交/推荐'}, function(){
				 	$.post('/scxfx_gk/personal/do_recommend',{number:number.substr(0,5),cid:cid},function(data){
					if(data.state == 1){
                        layer.msg(data.info, {
                            icon: 1,
                            time: 3000, //2秒关闭（如果不配置，默认是3秒）
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
					}
				})
			 })
			}
		});
    });
</script>
</body>
</html>
