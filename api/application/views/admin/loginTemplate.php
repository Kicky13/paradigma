<html>
    <head>
        <title>Login</title>
        <base href="<?php echo base_url(); ?>" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/font-awesome.css" rel="stylesheet">

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/css/style.css">

        <script src="assets/js/jquery-1.11.3.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <!--<script src="assets/js/scripts.js"></script>-->
        <style>
            .blink_me {
                animation: blinker 1s linear infinite;
            }
            @keyframes blinker {  
                50% { opacity: 0; }
            }
        </style>
    </head>
    <body>
        <div class="top-content">

            <div class="inner-bg headerpadding">
                <div class="container">
                    <div class="row">                        

                        <div class="col-sm-8 col-sm-offset-2 text">
                            <img src="<?php echo base_url(); ?>assets/img/logosmignew.png" alt="logo" width="70px" >

                            <h3 style="color: red; font-weight: bolder; font-style: italic;">Manage PAR4DIGMA API, User Access & User Menu</h3><div class="description">
                                <h2 class="blink_me" style="color: black; font-weight: bold">PAR4DIGMA API Services</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3>Login with your Email Account</h3></div>
                                <div class="form-top-right">
                                    <i class="fa fa-key"></i>
                                </div>
                            </div>
                            <div class="form-bottom">                    
                                <form id="login" method="post" action="" class="login-form">
                                    <div class="form-group">
                                        <label class="sr-only" for="form-username">Username</label>
                                        <input type="text" name="username" placeholder="User Name" class="form-username form-control" id="form-username" style="text-transform: lowercase;">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Password</label>
                                        <input type="password" name="password" placeholder="Password" required="true" class="form-password form-control" id="form-password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        <span class="loading_x" style="display:none;" ><i  class="fa fa-cog fa-spin fa-1x" ></i></span> 
                                        Login
                                        <span class="loading_x" style="display:none;" ><i  class="fa fa-cog fa-spin fa-1x" ></i></span>
                                    </button>	
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 social-login">
                            <p class="copyright">Copyright 2016 All rights reserved. PT Semen Indonesia.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (!empty($error)) {
            echo $error;
        }
        ?>	
        <div id="GetPeringatan"></div>
        <script>
            $(function () {
                $('form#login').submit(function () {
                    $('.loading_x').show();
                });
            });
            function direct() {
                window.location.assign("<?php echo base_url(); ?>index.php/c_admin");
            }
        </script>
    </body>
</html>