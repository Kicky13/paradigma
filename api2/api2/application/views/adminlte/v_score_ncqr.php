<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Company Score
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">
      

      
      <div class="box">
		<table><tr><td>
        </td></tr>
            <!-- /.box-header -->
         <tr><td>
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
        </div>
		</div>
		   <div class="row">		
			 <div class="box-body table-responsive padding" id="mbox_score">
				
				<?php foreach($this->list_company as $company): ?>
				<div id="box_score">
					<h3><?php echo $company->NM_COMPANY ?></h3>
					<img src="<?php echo base_url("images/".$company->ID_COMPANY.".png") ?>" />
					<h3>SCORE AVERAGE: <span id="score_<?php echo $company->ID_COMPANY ?>"></span></h3>
				</div>
				<?php endforeach; ?>
				
            </div>
        </div>
        </td></tr></table>
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
  
  #box_score {
	float: left;  
	width: 400px;
	height: 300px;
	border: 2px outset #ccc;
	margin: 20px;
	padding: 20px;
	text-align: center;
	font-weigt: bold;
  }  
  #box_score img {
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
  
  #mbox_score {
	  margin: 10px auto auto auto;
	  display: relative;
	  float: left;
  }
</style>


<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script src="<?php echo base_url("js/jquery-ui.js"); ?>" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery-ui.css"); ?>" />

<script>
$(document).ready(function(){
	$("#STARTDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});	
	$("#ENDDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});
    $("#btLoad").click(function(event){
      event.preventDefault();
      $("#saving").css('display','');
	  $.post('<?php echo site_url("incident/get_score_company");?>', { STARTDATE: $("#STARTDATE").val(), ENDDATE: $("#ENDDATE").val() }, function (result) {			
		$.each(result,function(i,item){
			var span = "#score_"+item.ID_COMPANY;
			$(span).html( (item.AVG_SCORE == null)?0:item.AVG_SCORE );
		});
		$("#saving").css('display','none');
	  },"json");	  
    });
    $("#btLoad").click();
});
  
</script>
