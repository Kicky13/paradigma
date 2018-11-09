<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Notification Dashboard
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">
      

      
      <div class="box">
        <!-- /.box-header -->
        <div class="box-header">
          <form id="formData" method="post" action="<?php echo site_url("incident/export_report") ?>" target="_blank">


            <div class="form-group row">
             
              <div class="form-group col-sm-12 col-sm-3">
                <label for="ID_COMPANY">START DATE</label>
                <INPUT TYPE="TEXT" id="STARTDATE" NAME="STARTDATE" VALUE="<?php echo date("01/m/Y") ?>" readonly class="form-control" />
         
              </div>

              <div class="form-group col-sm-6 col-sm-3">
                <label for="ID_COMPANY">END DATE</label>
                <INPUT TYPE="TEXT" id="ENDDATE" name="ENDDATE" VALUE="<?php echo date("t/m/Y") ?>" readonly class="form-control" />

              </div>

            </div>
            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-4">
                <button class="btn-primary" name="load" id="btLoad">VIEW DATA</button> &nbsp; 
                <span id="saving" style="display:none;">
                  <img src="<?php echo base_url("images/hourglass.gif");?>"> Please wait...
                </span>
              </div>
            </div>
            <hr/>
          </form>
          

		   <div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="info-box">
				<table border=0>
				<tr><td><img src="<?php echo base_url("images/gresik.png") ?>" id="image_logo"  />
				</td><td>
					<div id="box_notif">
						<p>MINOR 1</p>
						<h3 id="v_m1_10">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>MINOR 2</p>
						<h3 id="v_m2_10">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>MAYOR</p>
						<h3 id="v_my_10">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>EQR</p>
						<h3 id="v_eqr_10">0</h3>
						<p>(notification)</p>
					</div>
				</td></tr>
				</table>
				<!-- /.info-box-content -->
				</div>
			  <!-- /.info-box -->
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="info-box">
				<table border=0>
				<tr><td><img src="<?php echo base_url("images/padang.png") ?>" id="image_logo"  />
				</td><td>
					<div id="box_notif">
						<p>MINOR 1</p>
						<h3 id="v_m1_8">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>MINOR 2</p>
						<h3 id="v_m2_8">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>MAYOR</p>
						<h3 id="v_my_8">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>EQR</p>
						<h3 id="v_eqr_8">0</h3>
						<p>(notification)</p>
					</div>
				</td></tr>
				</table>
				<!-- /.info-box-content -->
				</div>
			  <!-- /.info-box -->
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="info-box">
				<table border=0>
				<tr><td><img src="<?php echo base_url("images/tonasa.png") ?>" id="image_logo"  />
				</td><td>
					<div id="box_notif">
						<p>MINOR 1</p>
						<h3 id="v_m1_9">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>MINOR 2</p>
						<h3 id="v_m2_9">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>MAYOR</p>
						<h3 id="v_my_9">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>EQR</p>
						<h3 id="v_eqr_9">0</h3>
						<p>(notification)</p>
					</div>
				</td></tr>
				</table>
				<!-- /.info-box-content -->
				</div>
			  <!-- /.info-box -->
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="info-box">
				<table border=0>
				<tr><td><img src="<?php echo base_url("images/tanglong.png") ?>" id="image_logo"  />
				</td><td>
					<div id="box_notif">
						<p>MINOR 1</p>
						<h3 id="v_m1_11">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>MINOR 2</p>
						<h3 id="v_m2_11">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>MAYOR</p>
						<h3 id="v_my_11">0</h3>
						<p>(notification)</p>
					</div>
					<div id="box_notif">
						<p>EQR</p>
						<h3 id="v_eqr_11">0</h3>
						<p>(notification)</p>
					</div>
				</td></tr>
				</table>
				<!-- /.info-box-content -->
				</div>
			  <!-- /.info-box -->
			</div>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

<!-- css -->
<style type="text/css">
  label { margin-bottom: 0px; }
  .form-group { margin-bottom: 5px; }
  hr { margin-top: 10px; }
  
  #image_logo {
	  width: 150px;
	  height: auto;
	  magin: 0;
	  padding: 0;
	  margin-top: 
  }
  
  #box_notif {
	  float: left;
	  border: 2px outset #ccc;
	  text-align: center;
	  padding: 5px;
	  margin: 10px;
  }
</style>


<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script src="<?php echo base_url("js/jquery-ui.js"); ?>" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery-ui.css"); ?>" />

<script>
  $(document).ready(function(){
	
	var list_id_company = [<?php foreach($this->list_company as $company){ echo $company->ID_COMPANY.","; } ?>];
	
	$("#STARTDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});
	
	$("#ENDDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});
	

    $("#btLoad").click(function(event){
      event.preventDefault();
      $("#saving").css('display','');
      
      $.each(list_id_company, function(i,vID_COMPANY){
		  //Set table columns | Update setting
		  $.post('<?php echo site_url("incident/get_dashboard_notifikasi");?>', { ID_COMPANY: vID_COMPANY, STARTDATE: $("#STARTDATE").val(), ENDDATE: $("#ENDDATE").val() }, function (result) {
				var td_m1 = "#v_m1_"+vID_COMPANY;
				var td_m2 = "#v_m2_"+vID_COMPANY;
				var td_my = "#v_my_"+vID_COMPANY;
				var td_eq = "#v_eqr_"+vID_COMPANY;
				$(td_m1).html(result.MINOR1);
				$(td_m2).html(result.MINOR2);
				$(td_my).html(result.MAYOR);
				$(td_eq).html(result.EQR);
				$("#saving").css('display','none');
		  },"json");
	  });
    });
    $("#btLoad").click();
});
  
</script>
