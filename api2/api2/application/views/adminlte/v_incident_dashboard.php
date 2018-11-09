<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  NCQR Dashboard
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
				  <h3>SEMEN GRESIK</h3>
				  <TABLE border=0>
				  <tr><td width=200>New Incident </td><td id="td_new_10">: 0</td></tr>
				  <tr><td>Incident Solved </td><td id="td_solved_10">: 0</td></tr>
				  <tr><td>TOTAL INCIDENT </td><td id="td_total_10">: 0</td></tr>
				  </TABLE>
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
				  <h3>SEMEN PADANG</h3>
				  <TABLE border=0>
				  <tr><td width=200>New Incident </td><td id="td_new_8">: 0</td></tr>
				  <tr><td>Incident Solved </td><td id="td_solved_8">: 0</td></tr>
				  <tr><td>TOTAL INCIDENT </td><td id="td_total_8">: 0</td></tr>
				  </TABLE>
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
				  <h3>SEMEN TONASA</h3>
				  <TABLE border=0>
				  <tr><td width=200>New Incident </td><td id="td_new_9">: 0</td></tr>
				  <tr><td>Incident Solved </td><td id="td_solved_9">: 0</td></tr>
				  <tr><td>TOTAL INCIDENT </td><td id="td_total_9">: 0</td></tr>
				  </TABLE>
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
				  <h3>TANGLONG CEMENT COMPANY</h3>
				  <TABLE border=0>
				  <tr><td width=200>New Incident </td><td id="td_new_11">: 0</td></tr>
				  <tr><td>Incident Solved </td><td id="td_solved_11">: 0</td></tr>
				  <tr><td>TOTAL INCIDENT </td><td id="td_total_11">: 0</td></tr>
				  </TABLE>
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
		  $.post('<?php echo site_url("incident/get_dashboard");?>', { ID_COMPANY: vID_COMPANY, STARTDATE: $("#STARTDATE").val(), ENDDATE: $("#ENDDATE").val() }, function (result) {
				
				var td_new = "#td_new_"+vID_COMPANY;
				//var td_proc = "#td_proc_"+vID_COMPANY;
				var td_solved = "#td_solved_"+vID_COMPANY;
				var td_total = "#td_total_"+vID_COMPANY;
				$(td_new).html(": "+result.BARU);
				//$(td_proc).html(": "+result.PROSES);
				$(td_solved).html(": "+result.SOLVED);
				$(td_total).html(": "+result.TOTAL);
				$("#saving").css('display','none');
		  },"json");
	  });
    });
    $("#btLoad").click();
});
  
</script>
