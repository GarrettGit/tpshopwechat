<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title>京西商城微信管理后台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="Novus Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
        setTimeout(hideURLbar, 0);
    }, false);
    function hideURLbar() {
        window.scrollTo(0, 1);
    } </script>
    <!-- Bootstrap Core CSS -->
    <link href="/Public/resources/wechat/css/bootstrap.css" rel='stylesheet' type='text/css'/>
    <!-- Custom CSS -->
    <link href="/Public/resources/wechat/css/style.css" rel='stylesheet' type='text/css'/>
    <!-- font CSS -->
    <!-- font-awesome icons -->
    <link href="/Public/resources/wechat/css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome icons -->
    <!-- js-->
    <script src="/Public/resources/wechat/js/jquery-1.11.1.min.js"></script>
    <script src="/Public/resources/wechat/js/modernizr.custom.js"></script>
    <!--webfonts-->
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <!--//webfonts-->
    <!--animate-->
    <link href="/Public/resources/wechat/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="/Public/resources/wechat/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <!--//end-animate-->
    <!-- Metis Menu -->
    <script src="/Public/resources/wechat/js/metisMenu.min.js"></script>
    <script src="/Public/resources/wechat/js/custom.js"></script>
    <link href="/Public/resources/wechat/css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->
</head>
<body class="cbp-spmenu-push">
<div class="main-content">
    <!--left-fixed -navigation-->
    <div class=" sidebar" role="navigation">
    <div class="navbar-collapse">
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <ul class="nav" id="side-menu">
                <!--<li>-->
                    <!--<a href="index.html"><i class="fa fa-home nav_icon"></i>Dashboard</a>-->
                <!--</li>-->
                
                <li>
                    <a href="#"><i class="fa fa-cogs nav_icon"></i>微信商品平台<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="/index.php/WeChat/WechatSeckill/showlist">每日秒杀</a>
                        </li>
                        <li>
                            <a href="/index.php/WeChat/WechatNewGoods/showlist">每日新增</a>
                        </li>
                            
                    </ul>
                    <!-- /nav-second-level -->
                </li>
            </ul>
            <div class="clearfix"> </div>
            <!-- //sidebar-collapse -->
        </nav>
    </div>
</div>
    <!--left-fixed -navigation-->
    <!-- header-starts -->
    <div class="sticky-header header-section ">
    <div class="header-left">
        <!--toggle button start-->
        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
        <!--toggle button end-->
        <!--logo -->
        <div class="logo">
            <a href="index.html">
                <h1>NOVUS</h1>
                <span>AdminPanel</span>
            </a>
        </div>
        <!--//logo-->
        <!--search-box-->
        <div class="search-box">
            <form class="input">
                <input class="sb-search-input input__field--madoka" placeholder="Search..." type="search" id="input-31" />
                <label class="input__label" for="input-31">
                    <svg class="graphic" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
                        <path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
                    </svg>
                </label>
            </form>
        </div><!--//end-search-box-->
        <div class="clearfix"> </div>
    </div>
    <div class="header-right">
        <div class="profile_details_left"><!--notifications of menu start -->
            <ul class="nofitications-dropdown">
                <li class="dropdown head-dpdn">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="notification_header">
                                <h3>后续开发</h3>
                            </div>
                        </li>
                        <li><a href="#">
                            <div class="user_img"><img src="<?php echo C('IMG_URL');?>1.png" alt=""></div>
                            <div class="notification_desc">
                                <p>Lorem ipsum dolor amet</p>
                                <p><span>1 hour ago</span></p>
                            </div>
                            <div class="clearfix"></div>
                        </a></li>
                        <li>
                            <div class="notification_bottom">
                                <a href="#">以后当作站内信模块</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown head-dpdn">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="notification_header">
                                <h3>后续开发</h3>
                            </div>
                        </li>
                        <li><a href="#">
                            <div class="user_img"><img src="<?php echo C('IMG_URL');?>2.png" alt=""></div>
                            <div class="notification_desc">
                                <p>Lorem ipsum dolor amet</p>
                                <p><span>1 hour ago</span></p>
                            </div>
                            <div class="clearfix"></div>
                        </a></li>

                        <li>
                            <div class="notification_bottom">
                                <a href="#">以后当作通知模块</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown head-dpdn">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="notification_header">
                                <h3>后续开发</h3>
                            </div>
                        </li>
                        <li><a href="#">
                            <div class="task-info">
                                <span class="task-desc">Database update</span><span class="percentage">40%</span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="progress progress-striped active">
                                <div class="bar yellow" style="width:40%;"></div>
                            </div>
                        </a></li>

                        <li>
                            <div class="notification_bottom">
                                <a href="#">做什么还没有想好</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="clearfix"> </div>
        </div>
        <!--notification menu end -->
        <div class="profile_details">
            <ul>
                <li class="dropdown profile_details_drop">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <div class="profile_img">
                            <span class="prfil-img"><img src="<?php echo C('IMG_URL');?>a.png" alt="" width="50" height="50"> </span>
                            <div class="user-name">
                                <p><?php echo (session('admin_name')); ?></p>
                                <span>Administrator</span>
                            </div>
                            <i class="fa fa-angle-down lnr"></i>
                            <i class="fa fa-angle-up lnr"></i>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu drp-mnu">
                        <li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li>
                        <li> <a href="<?php echo U('Manager/showinfo');?>"><i class="fa fa-user"></i> Profile</a> </li>
                        <li> <a href="<?php echo U('Manager/logout');?>"><i class="fa fa-sign-out"></i> Logout</a> </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="clearfix"> </div>
    </div>
    <div class="clearfix"> </div>
</div>
    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
        <div class="main-page">
            <div class="tables">
                <h3 class="title1">京西商城微信管理后台</h3>
                <div class="panel-body widget-shadow">
                    <h4>管理员列表:</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>账号</th>
                            <th>管理组</th>
                            <th>创建时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($mg_info)): foreach($mg_info as $k=>$v): ?><tr>
                                <th scope="row"><?php echo ($k+1); ?></th>
                                <td><?php echo ($v["mg_name"]); ?></td>
                                <td><?php echo ($v["role_name"]); ?></td>
                                <td><?php echo (date("y-m-d H:i:s",$v["mg_time"])); ?></td>
                            </tr><?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive bs-example widget-shadow">
                    <h4>注册用户(只显示最新10条数据):</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Table heading</th>
                            <th>Table heading</th>
                            <th>Table heading</th>
                            <th>Table heading</th>
                            <th>Table heading</th>
                            <th>Table heading</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Table cell</td>
                            <td>Table cell</td>
                            <td>Table cell</td>
                            <td>Table cell</td>
                            <td>Table cell</td>
                            <td>Table cell</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bs-example widget-shadow" data-example-id="bordered-table">
                    <h4>后续开发:</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                    <h4>后续开发:</h4>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bs-example widget-shadow" data-example-id="contextual-table">
                    <h4>后续开发:</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Column heading</th>
                            <th>Column heading</th>
                            <th>Column heading</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="active">
                            <th scope="row">1</th>
                            <td>Column content</td>
                            <td>Column content</td>
                            <td>Column content</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--footer-->
    
    <!--//footer-->
</div>
<!-- Classie -->
<script src="/Public/resources/wechat/js/classie.js"></script>
<script>
    var menuLeft = document.getElementById('cbp-spmenu-s1'),
        showLeftPush = document.getElementById('showLeftPush'),
        body = document.body;

    showLeftPush.onclick = function () {
        classie.toggle(this, 'active');
        classie.toggle(body, 'cbp-spmenu-push-toright');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        disableOther('showLeftPush');
    };

    function disableOther(button) {
        if (button !== 'showLeftPush') {
            classie.toggle(showLeftPush, 'disabled');
        }
    }
</script>
<!--scrolling js-->
<script src="/Public/resources/wechat/js/jquery.nicescroll.js"></script>
<script src="/Public/resources/wechat/js/scripts.js"></script>
<!--//scrolling js-->
<!-- Bootstrap Core JavaScript -->
<script src="/Public/resources/wechat/js/bootstrap.js"></script>
</body>
</html>