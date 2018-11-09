<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quality Management Online</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url("templates/adminlte/bootstrap/css/bootstrap.min.css"); ?>">
  
  <!-- Font Awesome -->
  <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"-->
  <link href="<?php echo base_url("css/font-awesome.min.css");?>" rel="stylesheet">

  <!-- Ionicons -->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url("templates/adminlte/dist/css/AdminLTE.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("templates/adminlte/dist/css/skins/skin-red-light.min.css") ?>">

</head>
<body class="hold-transition login-page skin-red-light s">
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>Quality Management</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><img src="<?php echo base_url("images/LogoSemenIndonesia.jpg") ?>" /></p>
	<?php if($notice->error): ?>
	<p class="login-error"><?php echo $notice->error; ?></p>
	<?php endif; ?>
    <form action="<?php echo site_url("login/verification") ?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" name="USERNAME">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="PASSWORD">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>

<style>
.login-box {
	width: 500px;
}
.login-error {
	display: block;
	padding: 10px;
	border: 1px solid red;
	color: red;
}
</style>
</body>
</html>
