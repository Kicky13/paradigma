<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quality Management Online | PT. SEMEN INDONESIA</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url("templates/adminlte/bootstrap/css/bootstrap.min.css");?>">
  <!-- Font Awesome -->
  <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"-->
  <link href="<?php echo base_url("css/font-awesome.min.css");?>" rel="stylesheet">

  <!-- Ionicons -->
  <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"-->
  <link href="<?php echo base_url("css/ionicons.min.css");?>" rel="stylesheet">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url("templates/adminlte/dist/css/AdminLTE.css");?>">

  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?php echo base_url("templates/adminlte/dist/css/skins/skin-red-light.min.css");?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?php echo base_url('js/html5shiv/html5shiv.min.js');?>"></script>
  <script src="<?php echo base_url('js/respond/respond.min.js');?>"></script>
  <![endif]-->

  <script src="<?php echo base_url("templates/adminlte/plugins/jQuery/jquery-2.2.3.min.js");?>"></script>
  <script src="<?php echo base_url("templates/adminlte/bootstrap/js/bootstrap.min.js");?>" ></script>
  <script src="<?php echo base_url("js/function.js");?>" ></script>
  

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Quality Management</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
            <h4 style="color: #fff; padding-top: 3px; margin-right: 30px;">Welcome Back <?php echo $this->USER->FULLNAME ?></h4>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">


      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
       <!-- <li class="header">Quality Management</li> -->
        <!-- Optionally, you can add icons to the links -->
        <?php foreach($menulist as $mgroup => $menu): ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span><?php echo $mgroup ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<?php foreach($menu as $r): ?>
            <li><a href="<?php echo site_url($r->PATH) ?>"><i class="fa fa-circle-o"></i> <?php echo $r->MENU ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
		
        <?php endforeach; ?>

        <li class="header">--</li>
        <li><a href="<?php echo site_url("logout") ?>"><i class="fa fa-gear"></i> Sign Out</a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	<?PHP IF($this->AKTIF_MENU): ?>
	<ol class="breadcrumb">
        <li><i class="fa fa-directory"></i><a href="#"><?php echo $this->AKTIF_GROUPMENU ?></a></li>
        <li class="active"><a href="#"><?php echo $this->AKTIF_MENU ?></a></li>
        <?PHP IF($this->AKTIF_ACTION): ?>
        <li class="active"><a href="#"><?php echo $this->AKTIF_ACTION ?></a></li>
        <?php endif; ?>
    </ol>
    <?php endif; ?>
    <style>
		.breadcrumb {
			float: right;
		}
		
    </style>
