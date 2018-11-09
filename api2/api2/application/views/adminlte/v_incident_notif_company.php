<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Company Notification
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
             
              <div class="form-group col-sm-12 col-sm-4">
                <label for="ID_COMPANY">COMPANY</label>
                <?php if($this->USER->ID_COMPANY): ?>
                <input type=text value="<?php echo $this->USER->NM_COMPANY ?>" class="form-control" readonly />
                <input type=hidden id="ID_COMPANY"  value="<?php echo $this->USER->ID_COMPANY ?>" class="form-control" readonly />
                <?php else: ?>
                <select id="ID_COMPANY" class="form-control select2">
                  <?php  foreach($this->list_company as $company): ?>
                    <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                  <?php endforeach; ?>
                </select>
                <?php endif; ?>
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
			 <div class="box-body table-responsive padding">
              <table class="table-fixed table-hover">
				<thead>
					<tr>
					  <th>PLANT</th>
					  <th>AREA</th>
					  <th>MINOR1</th>
					  <th>MINOR2</th>
					  <th>MAYOR</th>                  
					  <th>EQR</th>                  
					</tr>
				</thead>
				<tbody id="tcontent">
				</tbody>
              </table>
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
	$("#STARTDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});	
	$("#ENDDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});
    $("#btLoad").click(function(event){
      event.preventDefault();
      $("#saving").css('display','');          
	  $.post('<?php echo site_url("incident/get_notifikasi_company");?>', { ID_COMPANY: $("#ID_COMPANY").val(), STARTDATE: $("#STARTDATE").val(), ENDDATE: $("#ENDDATE").val() }, function (result) {			
			$("#tcontent").empty();
			var tr = "";
			$.each(result,function(i,item){
				tr = "";
				tr += "<tr>";
				tr += "<td>"+item.NM_PLANT+"</td>";
				tr += "<td>"+item.NM_AREA+"</td>";
				tr += "<td align=center>"+item.MINOR1+"</td>";
				tr += "<td align=center>"+item.MINOR2+"</td>";
				tr += "<td align=center>"+item.MAYOR+"</td>";
				tr += "<td align=center>"+item.EQR+"</td>";
				tr += "</tr>";
				$("#tcontent").append(tr);
			});
			
			$("#saving").css('display','none');
	  },"json");	  
    });
   // $("#btLoad").click();
});
  
</script>
