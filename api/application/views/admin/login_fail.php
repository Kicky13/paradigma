<title>ERROR</title>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css"/>
<script src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
<style>
    .blink_me {
        animation: blinker 1s linear infinite;
    }
    @keyframes blinker {  
        50% { opacity: 0; }
    }
</style>
<div>
    <div style="text-align: center;">
        <img src="<?php echo base_url();?>assets/img/logosmignew.png" alt="logo_SMIG" style="width: 150px; margin-top: 25px;">
    </div>    
    <div class="col-md-12 blink_me" style="text-align: center; color: red; font-size: 42px; margin: 10px;">
        <b>Apakah anda Administrator PAR4DIGMA?</b>
    </div>
    <div class="col-md-12" style="text-align: center; font-size: 22px; margin-top: 10px;">
        <button type="button" class="btn btn-primary" id="btn_login">LOGIN</button>
    </div>
</div>
<script>
    $(function () {
        $('#btn_login').click(function () {
            window.location.href = '<?php echo base_url(); ?>index.php/ldap_access';
        });

    });
</script>