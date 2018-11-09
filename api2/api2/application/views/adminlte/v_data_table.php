<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Data Table
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
              <div class="form-group col-sm-12 col-sm-4">
                <label for="ID_COMPANY">DISPLAY</label>
                <select id="DISPLAY" name="DISPLAY" class="form-control select2">
					<option value="daily">DAILY</option>
					<option value="hourly">HOURLY</option>
                </select>
              </div>
              <div class="form-group col-sm-12 col-sm-4">
                <label for="ID_COMPANY">COMPANY</label>
                <?php if($this->USER->ID_COMPANY): ?>
                <INPUT TYPE="TEXT" VALUE="<?php echo $this->USER->NM_COMPANY; ?>" readonly class="form-control" />
                <INPUT TYPE="HIDDEN" ID="ID_COMPANY" name="ID_COMPANY" VALUE="<?php echo $this->USER->ID_COMPANY; ?>" readonly class="form-control" />
                <?php else: ?>
                <select id="ID_COMPANY" name="ID_COMPANY" class="form-control select2">
                  <?php  foreach($this->list_company as $company): ?>
                    <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                  <?php endforeach; ?>
                </select>
                <?PHP endif; ?>
              </div>
            
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_COMPANY">PLANT</label>
                <?php if($this->USER->ID_PLANT): ?>
                <INPUT TYPE="TEXT" VALUE="<?php echo $this->USER->NM_PLANT; ?>" readonly class="form-control" />
                <INPUT TYPE="HIDDEN" ID="ID_PLANT" name="ID_PLANT" VALUE="<?php echo $this->USER->ID_PLANT; ?>" readonly class="form-control" />
                <?php else: ?>
                <select id="ID_PLANT" name="ID_PLANT" class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>
              </div>

            <div class="form-group row">
			  <div class="form-group col-sm-12 col-sm-4">
                <label for="ID_COMPANY">GROUP AREA</label>
                <?php if($this->USER->ID_AREA): ?>
                <input type=text value="<?php echo $this->USER->NM_AREA ?>" class="form-control" readonly />
                <input type=hidden id="ID_AREA" NAME="ID_AREA" value="<?php echo $this->USER->ID_AREA ?>" class="form-control" readonly />
                <?php else: ?>
                <select id="ID_GROUPAREA" name="ID_GROUPAREA" class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_AREA">AREA</label>
                <?php if($this->USER->ID_AREA): ?>
                <INPUT TYPE="TEXT" VALUE="<?php echo $this->USER->NM_AREA; ?>" readonly class="form-control" />
                <INPUT TYPE="HIDDEN" ID="ID_AREA" VALUE="<?php echo $this->USER->ID_AREA; ?>" readonly class="form-control" />
                <?php else: ?>
                <select id="ID_AREA" name="ID_AREA" class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>

            </div>

            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-4 picker_hourly" id="" style="display: none">
                <label for="ID_COMPANY">DATE</label>
                <input name="TANGGAL" id="datepicker" type="text" class="form-control" value="<?php echo date("d/m/Y");?>">
              </div>
              <div class="form-group col-sm-3 col-sm-2 picker_daily" id="" style="display: none">
                <label for="ID_COMPANY">MONTH</label>
                <SELECT class="form-control select2" name="MONTH">
        					<option value="01" <?php echo ("01"==date("m")) ? "selected":"";?>>JANUARY</option>
        					<option value="02" <?php echo ("02"==date("m")) ? "selected":"";?>>FEBRUARY</option>
        					<option value="03" <?php echo ("03"==date("m")) ? "selected":"";?>>MARCH</option>
        					<option value="04" <?php echo ("04"==date("m")) ? "selected":"";?>>APRIL</option>
        					<option value="05" <?php echo ("05"==date("m")) ? "selected":"";?>>MAY</option>
        					<option value="06" <?php echo ("06"==date("m")) ? "selected":"";?>>JUNE</option>
        					<option value="07" <?php echo ("07"==date("m")) ? "selected":"";?>>JULY</option>
        					<option value="08" <?php echo ("08"==date("m")) ? "selected":"";?>>AUGUST</option>
        					<option value="09" <?php echo ("09"==date("m")) ? "selected":"";?>>SEPTEMBER</option>
        					<option value="10" <?php echo ("10"==date("m")) ? "selected":"";?>>NOVEMBER</option>
        					<option value="11" <?php echo ("11"==date("m")) ? "selected":"";?>>OCTOBER</option>
        					<option value="12" <?php echo ("12"==date("m")) ? "selected":"";?>>DECEMBER</option>
                </SELECT>
              </div>
              <div class="form-group col-sm-4 col-sm-2 picker_daily" style="display: none">
                <label for="ID_COMPANY">YEAR</label>
                <SELECT class="form-control select2" name="YEAR">
					<?PHP for($i=2017;$i<=2017;$i++): ?>
					<option value="<?php echo $i; ?>" <?php echo (date("Y")==$i) ? "selected":"";?>><?php echo $i; ?></option>
					<?php endfor; ?>
                </SELECT>
              </div>
              <div class="form-group col-sm-6 col-sm-4" id="fg-type" style="display:;">
                <label for="ID_PRODUCT">TYPE</label>
                <select id="ID_PRODUCT" name="ID_PRODUCT" class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-4">
                <button class="btn-primary" name="load" id="btLoad">VIEW DATA</button> &nbsp; 
                <button class="btn-success" id="btnExportXLS">EXPORT (XLS)</button>
              </div>
            </div>
            <hr/>
          </form>
          
          <div id="divTable" style="display:none;">
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
	
	$("#datepicker").datepicker({
		dateFormat: 'dd/mm/yy'
	});
	
	$("#DISPLAY").change(function(){

		if(this.value == "daily"){
			$(".picker_daily").attr("style","display:;");
			$(".picker_hourly").attr("style","display:none;");
		}
		else{
			$(".picker_daily").attr("style","display:none;");
			$(".picker_hourly").attr("style","display:;");
		}
	});
	$("#DISPLAY").change();

    $("#ID_COMPANY").change(function(){
      var company = $(this).val(), plant = $('#ID_PLANT');
      $.getJSON('<?php echo site_url("data_table/ajax_get_plant/");?>' + company, function (result) {
        var values = result;
        
        plant.find('option').remove();
        if (values != undefined && values.length > 0) {
          plant.css("display","");
          $(values).each(function(index, element) {
            plant.append($("<option></option>").attr("value", element.ID_PLANT).text(element.NM_PLANT));
          });
          
        }else{
          plant.find('option').remove();
          plant.append($("<option></option>").attr("value", '00').text("NO PLANT"));
        }
      $("#ID_PLANT").change();
      });
    });

    $("#ID_PLANT").change(function(){
      var plant = $(this).val(), grouparea = $('#ID_GROUPAREA');
      $.getJSON('<?php echo site_url("data_table/ajax_get_grouparea/");?>' + $("#ID_COMPANY").val() + '/' + plant, function (result) {
        var values = result;
        
        grouparea.find('option').remove();
        if (values != undefined && values.length > 0) {
          grouparea.css("display","");
          $(values).each(function(index, element) {
            if(!$("#ID_GROUPAREA option[value='"+element.ID_GROUPAREA+"']").length > 0){
              grouparea.append($("<option></option>").attr("value", element.ID_GROUPAREA).text(element.NM_GROUPAREA));
            }
          });
        }else{
          grouparea.find('option').remove();
          grouparea.append($("<option></option>").attr("value", '00').text("NO GROUP AREA"));
        }
        $("#ID_GROUPAREA").change();
      });
    });

    $("#ID_GROUPAREA").change(function(){
      var grouparea = $(this).val(), area = $('#ID_AREA');
      $.getJSON('<?php echo site_url("data_table/ajax_get_area/");?>' + $("#ID_COMPANY").val() + '/' + $("#ID_PLANT").val() + '/' + grouparea, function (result) {
        var values = result;
        
        area.find('option').remove();
        if (values != undefined && values.length > 0) {
          area.css("display","");
          $(values).each(function(index, element) {
            area.append($("<option></option>").attr("value", element.ID_AREA).text(element.NM_AREA));
          });
        }else{
          area.find('option').remove();
          area.append($("<option></option>").attr("value", '00').text("NO AREA"));
        }
        $("#ID_AREA").change();
      });
    });

    $("#ID_AREA").change(function(){
      var area = $(this).val(), product = $('#ID_PRODUCT');
      $.getJSON('<?php echo site_url("data_table/ajax_get_product/");?>' + $(this).val() + '/' + $("#ID_PLANT").val() + '/' + $("#ID_COMPANY").val(), function (result) {
        var values = result;
        
        product.find('option').remove();
        if (values != undefined && values.length > 0) {
          product.css("display","");
          product.append($("<option></option>").attr("value", 'ALL').text("ALL TYPE"));
          $(values).each(function(index, element) {
            product.append($("<option></option>").attr("value", element.ID_PRODUCT).text(element.KD_PRODUCT));
          });
        }else{
          product.find('option').remove();
          product.append($("<option></option>").attr("value", '00').text("NO TYPE"));
        }
      });
    });

    $("#btLoad").click(function(event){
      event.preventDefault();
      $("#handsonTable").html("");
      var formData = $("#formData").serializeArray();
	    var display = $("#DISPLAY").val();
      $("#saving").css('display','');
      $("#divTable").css("display","");
		
      //Set table columns | Update setting
      $.post('<?php echo site_url("data_table");?>/'+$("#DISPLAY").val(), formData, function (result) {
    		  console.log(result);
    		$("#saving").css('display','none');
    		var tab = '<div class="box-body table-responsive no-padding"><table class="table" border=1 id=tbldata>';
    		tab += '<tr>';
    		tab += '<th>Date</th>';
    		if($("#DISPLAY").val() == 'hourly'){
    			tab += '<th>Time</th>';
    		}
    		var jth = 1; 
    		result.header.colHeader.forEach(function(item,index){
    			tab += '<th>'+item.title+'</th>';
    			jth++;
    		}); 
    		tab += '</tr>';
    		jth += 7;
    		
    		var ltr = 0;
    		
    		$.each(result.data, function(i,item){ //console.log(i);
    			tab += "<tr>";
    			if($("#DISPLAY").val() == 'hourly'){
    				tab += "<td>"+$("#datepicker").val()+"</td>";
    			}
    			tab += "<td>"+(i+1)+"</td>";
    			
    			$.each(item, function(x,y){
    				tab += "<td>"+((y)?y:"&nbsp;")+"</td>";
    			});			
    			
    			tab += "</tr>";
    			ltr = 1;
    		});
    		
    		if(ltr == 0){
    			tab += "<tr><td colspan="+jth+"><i>(Empty Data)</i></td></tr>";
    		}
    		
    		tab += '</table></div>';
    		$("#handsonTable").html(tab);
		
      },"json");
    });
   
    
  $("#ID_COMPANY").change();
  
  <?php if($this->USER->ID_PLANT): ?>
  $("#ID_PLANT").change();
  <?php endif; ?>
  
  <?php if($this->USER->ID_GROUPAREA): ?>
  $("#ID_GROUPAREA").change();
  <?php endif; ?>
  
  <?php if($this->USER->ID_AREA): ?>
  $("#ID_AREA").change();
  <?php endif; ?>
  
  
});
  
</script>
