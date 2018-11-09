<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
  echo doctype('html5');

  ## Head Start
  echo "<html><head>\n";

  ## Meta Tag
  echo meta('X-UA-Compatible', 'IE=edge; charset=utf-8', 'equiv');
  echo meta('viewport','width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no');

  ## Title
  echo title_tag("QM Online | Blank Page");

  ## Assets
  echo link_tag("frameworks/bootstrap/css/bootstrap.min.css");
  echo link_tag("frameworks/font-awesome/css/font-awesome.min.css");
  echo link_tag("frameworks/ionicons/css/ionicons.min.css");
  echo link_tag("frameworks/adminlte/css/AdminLTE.min.css");
  echo link_tag("frameworks/adminlte/css/skins/skin-red-light.min.css");

  echo "<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->\n";
  echo "<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->\n";
  echo "<!--[if lt IE 9]>\n";
  echo script_tag("frameworks/adminlte/js/html5shiv.min.js");
  echo script_tag("frameworks/adminlte/js/respond.min.js");
  echo "<![endif]-->\n";

  ## Head End
  echo "</head>\n";
?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
