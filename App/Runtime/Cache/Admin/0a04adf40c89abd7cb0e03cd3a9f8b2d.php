<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>后台管理</title>

    <!-- Bootstrap Core CSS -->
    <link href="/Public/tipplug/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/Public/tipplug/bootstrap/sb-admin/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/Public/tipplug/bootstrap/sb-admin/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/Public/tipplug/bootstrap/sb-admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- jQuery -->
    <script src="/Public/tipplug/jquery/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="/Public/tipplug/bootstrap/js/bootstrap.min.js"></script>
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div id="wrapper">

        <!-- 菜单 -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo U('Index/index');?>">管理后台</a>
            </div>
            
            <!-- 顶部菜单 -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>留言实例</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i>留言时间</p>
                                        <p>留言内容</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">阅读所有留言</a>
                        </li>
                    </ul>
                </li>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">重大事件通知 <span class="label label-default">类型</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">查看所有</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo session('user')['username'] ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> 设置</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo U('Public/logout');?>" onclick="return confirm('确定退出当前用户？')"><i class="fa fa-fw fa-power-off"></i> 退 出</a>
                        </li>
                    </ul>
                </li>
            </ul>
             <!-- 顶部菜单结束 -->
            
            
            <!-- 左侧菜单栏 -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="<?php echo U('Index/index');?>"><i class="fa fa-fw fa-dashboard"></i> 仪表盘</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#webconfig"><i class="fa fa-fw fa-wrench"></i>网站管理<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="webconfig" class="collapse">
                            <li>
                                <a href="<?php echo U('System/index');?>">网站配置管理</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo U('Sections/index');?>"><i class="fa fa-fw fa-dashboard"></i> 栏目管理</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#nerzong"><i class="fa fa-fw fa-wrench"></i>内容管理<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="nerzong" class="collapse">
                        	<li>
                                <a href="<?php echo U('Content/index');?>">内容模型</a>
                            </li>
                            <?php if(is_array($ctmbase)): foreach($ctmbase as $key=>$ct): ?><li>
                                <a href="<?php echo U('Content/ctmdisplay',array('logic'=>$ct['logicname'],'action'=>'list'));?>"><?php echo ($ct["name"]); ?>管理</a>
                            </li><?php endforeach; endif; ?>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo U('Widget/index');?>"><i class="glyphicon glyphicon-briefcase"></i> 插件管理</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#user"><i class="fa fa-fw fa-wrench"></i>用户管理<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="user" class="collapse">
                            <li>
                                <a href="<?php echo U('User/index');?>">用户管理</a>
                            </li>
                            <li>
                                <a href="<?php echo U('User/grouplist');?>">用户分类管理</a>
                            </li>
                            <li>
                                <a href="<?php echo U('User/rulelist');?>">权限规则管理</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo U('Trash/index');?>"><i class="glyphicon glyphicon-trash"></i> 回收站</a>
                    </li>
                </ul>
            </div>
            <!-- 左侧菜单栏结束 -->
        </nav>
		<!-- 菜单栏结束 -->
		
		<!-- 内容页 -->
        <div id="page-wrapper">
   			
	<!-- Page Heading -->
	<div class="row">
	    <div class="col-lg-12">
			<ol class="breadcrumb">
			    <li>
			        <i class="fa fa-dashboard"></i>  <a href="<?php echo U('Index/index');?>">仪表盘</a>
			    </li>
			    <li>
			        <i class="fa fa-edit"></i> <a href="<?php echo U('User/index');?>">用户管理</a>
			    </li>
			</ol>
	    </div>
	</div>
	<!-- /.row -->
	<div class="row">
		<form role="form" action="<?php echo U('User/index');?>" method="post">
		 	<div class="form-inline col-xs-4">
		        <label>用户分类：</label>
		        <select class="form-control" name="type">
		            <option value="0">全 部 </option>
		            <?php if(is_array($typelist)): foreach($typelist as $key=>$tls): ?><option <?php if($tls['id'] == $type): ?>selected = "selected"<?php endif; ?> value="<?php echo ($tls["id"]); ?>"><?php echo ($tls["title"]); ?></option><?php endforeach; endif; ?>
		        </select>
		    </div>
		    <div class="form-inline col-xs-4">
	            <input class="form-control" name="keyword">
	        </div>
	        <div class="col-xs-2">
	         <button type="submit" class="btn btn-primary">查 询</button>
	        </div>
	    </form>
    </div>
    <div class="page-header"></div>
    
	<div class="row">
		  <div class="col-lg-12">
	        <ol class="breadcrumb">
	            <li>
	                <a href="<?php echo U('User/adduser');?>"><i class="glyphicon glyphicon-plus"></i>添 加 用 户</a>
	            </li>
	        </ol>
	      </div>
		  <div class="col-lg-12">
		      <h2><?php echo ($typename); ?></h2>
		      <div class="table-responsive">
		          <table class="table table-bordered table-hover table-striped">
		              <thead>
		                  <tr>
		                  	  <th>序号</th>
		                  	  <th>分类</th>
		                      <th>用户名</th>
		                      <th>手机</th>
		                      <th>邮箱</th>
		                      <th>是否可用</th>
		                      <th>最后登录时间</th>
		                      <th>操作</th>
		                  </tr>
		              </thead>
		              <tbody>
		                 <?php if(is_array($userlist)): foreach($userlist as $key=>$vo): ?><tr <?php if($vo['is_active'] != 1 ): ?>class="danger"<?php endif; ?>>
		                      <td><?php echo ($key + 1); ?></td>
		                      <td><?php echo ($vo["gid"]); ?></td>
		                      <td><?php echo ($vo["username"]); ?></td>
		                      <td><?php echo ($vo["phone"]); ?></td>
		                      <td><?php echo ($vo["email"]); ?></td>
		                      <td><?php if($vo['is_active'] == 1 ): ?>是
		                      		<?php else: ?> 否<?php endif; ?>
		                      </td>
		                      <td><?php echo ($vo["date_update"]); ?></td>
		                      <td>
		                      <a href="<?php echo U('User/edituser',array('id'=>$vo['id']));?>"><span>编辑</span></a> | 
		                      <span>删除 </span>
		                      </td>

		                  </tr><?php endforeach; endif; ?>
		              </tbody>
		          </table>
		      </div>
		  </div>
	</div>

        </div>
        <!-- 内容页结束 -->
        
    </div>
    <!-- /#wrapper -->
<script>
function delctm(logic,id) {
	if(confirm('是否删除该项？')) {
		$.ajax({
			type:"post",
			url:"<?php echo U('Trash/delctm');?>",
			dataType:"json",
			data:{'id':id,'logic':logic},
			success:function(data) {
				if(data.status == '1') {
					if(confirm('删除成功')) {
						window.location.reload();
					} else {
						window.location.reload();
					}
				} else {
					alert(data.info);
				}
			}
		})
	} else {
		return;
	}
}
</script>
    
</body>
</html>