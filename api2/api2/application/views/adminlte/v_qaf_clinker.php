<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Quality Assurance Factor of Clinker
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
          <form id="formData" method="post" action="<?php echo site_url("qaf_report/export_xls") ?>" target="_blank">


            <div class="form-group row">
			  
			    <?php if($this->USER->ID_COMPANY): ?>
				<input type=hidden id="ID_COMPANY" value="<?php echo $this->USER->ID_COMPANY; ?>" />
				<?php else: ?>
				<div class="form-group col-sm-12 col-sm-3">
					<label>COMPANY</label>
					<select class="form-control select2" id="ID_COMPANY" name="ID_COMPANY">
						<?php  foreach($this->list_company as $company): ?>
						<option value="<?php echo $company->ID_COMPANY ?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":""; ?> ><?php echo $company->NM_COMPANY ?></option>
						<?php endforeach; ?>
					</select>							
				</div>
				<?php endif; ?>
              
                <?php if($this->USER->ID_PLANT): ?>
				<input type=hidden id="ID_PLANT" value="<?php echo $this->USER->ID_PLANT; ?>" />
				<?php else: ?>
				<div class="form-group col-sm-12 col-sm-3">
					<label>PLANT</label>
					<select class="form-control select2" id="ID_PLANT" NAME="ID_PLANT" >
						<?php  foreach($this->list_plant as $plant): ?>
						<option value="<?php echo $plant->ID_PLANT ?>" <?php echo ($this->ID_PLANT == $plant->ID_PLANT)?"SELECTED":""; ?> ><?php echo $plant->NM_PLANT ?></option>
						<?php endforeach; ?>
					</select>							
				</div>
				<?php endif; ?>
				
				

			</div>
			<div class="form-group row">

              <div class="form-group col-sm-12 col-sm-3">
                <label for="ID_COMPANY">MONTH</label>
				<SELECT NAME="MONTH" ID="MONTH" class="form-control select2" >
					<?PHP
						for($i = 1 ; $i <= 12; $i++){
							$m = date("F",mktime(0,0,0,$i,1,date("Y")));
							echo "<option value='".str_pad($i,0,STR_PAD_LEFT)."' ".(($i == date("m"))?"selected":"")." >".strtoupper($m)."</option>\n";
						}
					?>
				</SELECT>
              </div>

              <div class="form-group col-sm-6 col-sm-3">
                <label for="ID_COMPANY">YEAR</label>
                <SELECT NAME="YEAR" ID="YEAR" class="form-control select2" >
					<?PHP
						for($i = 2017 ; $i <= date("Y"); $i++){
							echo "<option value='".$i."'>$i</option>\n";
						}
					?>
				</SELECT>
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
          

		   <div id="divTable" style="display:;">
            <div class="form-group row" id="row_qaf_area">
            </div>
            
            
            
            
            <div id="divTable">
          <div class="form-group row" id="row_qaf_produksi">
				
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
  
  canvas {
	-moz-user-select: none;
	-webkit-user-select: none;
	-ms-user-select: none;
  }
  
  #tbldata {
	  margin-bottom: 20px;
  }
  
  #tbldata td {
	  font-weight: normal;
	  color: #000;
  }
  
  #tbldata th {
	  background: #F5C9B3;
	  color: #150BD4;
	  font-weight: bold;
  }
  
  #tbldata th, #tbldata td {
	  border-color: #000;
	  text-align: center;
	  vertical-align: middle;
  }
  
  #tbldata #trstd th {
	  background: none;
  }
  
  #tbldata #trqaf td {
	  background: #C2E9FC;
	  font-weight: bold;
  }
  
  #tbldata #trtotal td {
	  background: #7CF7B5;
	  color: #150BD4;
	  font-weight: bold;
	  font-size: 1.2em;
  }

</style>



<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery-ui.css"); ?>" />
<script src="<?php echo base_url("js/jquery-ui.js"); ?>" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery-ui.css"); ?>" />
<script src="<?php echo base_url("js/chartjs/Chart.bundle.js") ?>"></script>
<script src="<?php echo base_url("js/chartjs/utils.js") ?>"></script>

<script>
  $(document).ready(function(){
	

	
	$("#ID_COMPANY").change(function(){
		$("#ID_PLANT").empty();
		var url = "<?php echo site_url("qaf_report/json_plant_list/") ?>"+this.value;
		$.getJSON(url,function(data){
			$("#ID_PLANT").empty();
			data.forEach(function(r){
				$("#ID_PLANT").append("<option value='"+r.ID_PLANT+"' "+((r.ID_PLANT==<?php echo ($this->ID_PLANT)?$this->ID_PLANT:0; ?>)?"SELECTED":"")+" >"+r.NM_PLANT+"</option>");
			});
			$("#ID_PLANT").change();
		});
	});
	
	function qaf_produksi(){ 
		$.post('<?php echo site_url("qaf_report/report_clinker");?>', { 
			MONTH: $("#MONTH").val(), 
			YEAR: $("#YEAR").val(), 
			ID_PRODUCT: $("#ID_PRODUCT").val(), 
			ID_PLANT: $("#ID_PLANT").val(),
			ID_GROUPAREA: 4
		}, function (nres) {
			$("#row_qaf_produksi").html(nres);
		});
	}
	
	function get_report(r,arr_gr,curr_ik){
		if(r == undefined){
			qaf_produksi();
			$("#saving").css('display','none');					
			return false;				
		}
		$.post('<?php echo site_url("qaf_report/generate_report/clinker");?>', { 
			MONTH: $("#MONTH").val(),
			YEAR: $("#YEAR").val(), 
			ID_AREA: r.ID_AREA,
			ID_PLANT: $("#ID_PLANT").val(),
			ID_GROUPAREA: 4,
			ID_PRODUCT: $("#ID_PRODUCT").val()
		}, function (nres) {
			$.post('<?php echo site_url("qaf_report/get_report_clinker");?>', { 
				MONTH: $("#MONTH").val(),
				YEAR: $("#YEAR").val(),
				ID_COMPANY: $("#ID_COMPANY").val(),
				ID_AREA: r.ID_AREA,						
				ID_PLANT: $("#ID_PLANT").val(),
				ID_GROUPAREA: 4,
				ID_PRODUCT: $("#ID_PRODUCT").val() 
			}, function (res) {
				//$("#saving").css('display','none');
				//$("#row_qaf_area").append(res);
				
				$("#row_qaf_area").append(res);
				
				console.log(curr_ik);
				console.log(arr_gr.length-1);
				
				
				curr_ik++;
				get_report(arr_gr[curr_ik],arr_gr,curr_ik);
				
				
			});
			$("#saving").css('display','');
		});
	}
	
    $("#btLoad").click(function(event){
      event.preventDefault();
      $("#saving").css('display','');
      $("#row_qaf_area").html("");
	
		//select area based on grouparea
		$.getJSON("<?php echo site_url("qaf_report/clinker/get_area") ?>/"+$("#ID_PLANT").val(),function(gr){
			var ik = 0;
			var arr_gr = new Array();
			console.log(gr);
			if(gr.length >= 1){
				$.each(gr,function(key,r){
					arr_gr[ik] = r;
					ik++;
				});
				
				var curr_ik = 0; console.log(curr_ik);
				get_report(arr_gr[curr_ik],arr_gr,curr_ik);
			}
			else{
				$("#saving").css('display','none');
			}
			console.log(gr);
		});
	  
    });
  //  $("#btLoad").click();
    
	$("#ID_COMPANY").change();
});
  
</script>
