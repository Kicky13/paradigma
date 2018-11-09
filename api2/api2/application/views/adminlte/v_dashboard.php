<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Dashboard
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">
      
      <?php if($notice->error): ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        <?php echo $notice->error; ?>
      </div>
      <?php endif; ?>
      
      <?php if($notice->success): ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Done!</h4>
        <?php echo $notice->success; ?>
      </div>
      <?php endif; ?>
      
      <div class="box">
        <!-- /.box-header -->
        <div class="box-header">
          <form id="formData" method="post" action="<?php echo site_url("data_table/export") ?>" target="_blank">
            <div class="form-group row">
              <div class="form-group col-sm-12 col-sm-3">
                <label for="ID_COMPANY">DISPLAY</label>
                <select id="DISPLAY" name="DISPLAY" class="form-control select2">
					<option value="daily">DAILY</option>
					<option value="hourly">HOURLY</option>
                </select>
              </div>
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
				 
				 
				 <div class="form-group col-sm-12 col-sm-2">
					<label for="ID_COMPANY">GROUPAREA</label><br />
					<?php if($this->USER->ID_GROUPAREA): ?>
					<INPUT TYPE="TEXT" VALUE="<?php echo $this->USER->NM_GROUPAREA; ?>" readonly class="form-control" />
					<INPUT TYPE="checkbox" checked=checked style="display:none;" ID="ID_GROUPAREA" name="ID_GROUPAREA[]" VALUE="<?php echo $this->USER->ID_GROUPAREA; ?>" readonly class="form-control" />
					<?php else: ?>
					  <?php  foreach($this->list_grouparea as $grouparea): ?>
						<input class="ID_GROUPAREA" name="LIST_GROUPAREA[]"  type=checkbox value="<?php echo $grouparea->ID_GROUPAREA;?>" <?php echo ($this->ID_GROUPAREA == $grouparea->ID_GROUPAREA)?"SELECTED":"";?> ><?php echo $grouparea->NM_GROUPAREA;?><br />
					  <?php endforeach; ?>
					<?PHP endif; ?>
				  </div>
				  
				 <?php if($this->USER->ID_COMPANY): ?>
					<INPUT TYPE="checkbox"  style="display:none;" ID="ID_COMPANY" CLASS="ID_COMPANY" name="LIST_COMPANY[]" VALUE="<?php echo $this->USER->ID_COMPANY; ?>" readonly class="form-control" />
					<?php else: ?>
				 <div class="form-group col-sm-12 col-sm-2">
					<label for="ID_COMPANY">COMPANY</label><br />
					
					  <?php  foreach($this->list_company as $company): ?>
						<input class="ID_COMPANY" name="LIST_COMPANY[]" type=checkbox value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?><br />
					  <?php endforeach; ?>
					
				  </div>
				  <?PHP endif; ?>
				  
				  <span id="span_plant_list">

				  </span>
				  
            </div>

            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-4">
                <button class="btn-primary" name="load" id="btLoad">VIEW DATA</button> &nbsp; 
              </div>
            </div>
            <hr/>
          </form>
          
          <div id="divTable" style="display:;">
            <div class="form-group row">
              <div class="col-sm-12">
                <span id="saving" style="display:none;">
                  <img src="<?php echo base_url("images/hourglass.gif");?>"> Please wait...
                </span>
                <div id="handsonTable">
					
                </div>
              </div>
            </div>
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
</style>


<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script src="<?php echo base_url("js/jquery-ui.js"); ?>" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery-ui.css"); ?>" />

<script>
  $(document).ready(function(){
	
	HAS_COMPANY = 0;
	HAS_GROUPAREA = 0;
	CHECKED_COMPANY = [];
	
	
	$("#STARTDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});	
	
	$("#ENDDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});
	
	function get_plant(vID_COMPANY,CHECKED_COMPANY,curr_ik){
		if(vID_COMPANY == undefined){				
			return false;				
		}

		$.post('<?php echo site_url("dashboard/get_plant");?>', { 
			ID_COMPANY: vID_COMPANY
		}, function (res) {
			
			opt = "";
			nm  = "";					
			$.each(res, function(i,v){
				nm = v.NM_COMPANY;
				opt += '<input type=checkbox name=ID_PLANT['+vID_COMPANY+'][] value="'+v.ID_PLANT+'" /> '+v.NM_PLANT+'<br />';
			});
			$("#span_plant_list").append('<div id="plant_'+vID_COMPANY+'" class="form-group col-sm-12 col-sm-2">'+nm+'<br />'+opt+'</div>');
			
			//res.forEach(function(r){console.log(r)});
			curr_ik++;
			get_plant(CHECKED_COMPANY[curr_ik],CHECKED_COMPANY,curr_ik);
		},'json');
			
	}
	

    $(".ID_COMPANY").click(function(){
		LIST_COMPANY = $(".ID_COMPANY");
		for(i=0; i<LIST_COMPANY.length; i++){
			if(LIST_COMPANY[i].checked == true){
				HAS_COMPANY = 1;
				break;
			}
			HAS_COMPANY = 0;
		}
		
		if(HAS_COMPANY == 1){
			CHECKED_COMPANY = [];
			LIST_COMPANY = $(".ID_COMPANY");
			for(i=0; i<LIST_COMPANY.length; i++){
				if(LIST_COMPANY[i].checked == true){
					cekplant = "#plant_"+LIST_COMPANY[i].value;
					if($(cekplant).length == 0){
						CHECKED_COMPANY.push(LIST_COMPANY[i].value);
					}
				}
				else{
					cekplant = "#plant_"+LIST_COMPANY[i].value;
					if($(cekplant).length > 0){
						$(cekplant).remove();
					}
				}
			}
			console.log(CHECKED_COMPANY);
			var curr_ik = 0; 
			get_plant(CHECKED_COMPANY[curr_ik],CHECKED_COMPANY,curr_ik);
		}
		
    });
    
    $(".ID_GROUPAREA").click(function(){
		LIST_GROUPAREA = $(".ID_GROUPAREA");
		for(i=0; i<LIST_GROUPAREA.length; i++){
			if(LIST_GROUPAREA[i].checked == true){
				HAS_GROUPAREA = 1;
				break;
			}
			HAS_GROUPAREA = 0;
		}
		<?PHP if($this->USER->ID_COMPANY): ?>
		//load_plant();
		<?PHP endif; ?>
    });
    
    $("#btLoad").click(function(event){
      event.preventDefault();
      var formData = $("#formData").serializeArray();
	  var display = $("#DISPLAY").val();
      $("#saving").css('display','');
      $("#divTable").css("display","");
		
      //Set table columns | Update setting
      $.post('<?php echo site_url("dashboard");?>/'+$("#DISPLAY").val(), formData, function(result){
    		$("#saving").css('display','none');
    		$("#handsonTable").html(result);
		
      });
    });
   
    <?PHP if($this->USER->ID_COMPANY): ?>
		$(".ID_COMPANY").click();
	<?PHP endif; ?>

});
  
</script>
<style>
.trep th, .trep td {
	padding: 5px;
}
#divTable:overflow {
	auto;
}
</style>
