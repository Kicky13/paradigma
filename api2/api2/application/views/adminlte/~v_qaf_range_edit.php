   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Component Range Configuration for QAF
        <small></small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
	
       <div class="row">
        <div class="col-xs-12">
				
		<form class="form-horizontal" method="post"  >
		
          <div class="box">
            <div class="box-header with-border">
				
					<div class="box-body">
						<div class="form-group">
							<?php if($this->USER->ID_COMPANY): ?>
							<input type=hidden id="ID_COMPANY" value="<?php echo $this->USER->ID_COMPANY; ?>" />
							<?php else: ?>
							<div class="col-sm-2">
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
							<div class="col-sm-2">
								<label>PLANT</label>
								<select class="form-control select2" id="ID_PLANT" NAME="ID_PLANT" >
									<?php  foreach($this->list_plant as $plant): ?>
									<option value="<?php echo $plant->ID_PLANT ?>" <?php echo ($this->ID_PLANT == $plant->ID_PLANT)?"SELECTED":""; ?> ><?php echo $plant->NM_PLANT ?></option>
									<?php endforeach; ?>
								</select>							
							</div>
							<?php endif; ?>
							
							<div class="col-sm-3">
								<label>AREA</label>
								<select class="form-control select2" id="ID_AREA" NAME="ID_AREA" >
									<?php  foreach($this->list_area as $area): ?>
									<option value="<?php echo $area->ID_AREA ?>" <?php echo ($this->ID_AREA == $area->ID_AREA)?"SELECTED":""; ?> ><?php echo $area->NM_AREA ?></option>
									<?php endforeach; ?>
								</select>							
							</div>						
						</div>
						
					</div>
					
				
				
            </div>
            <!-- /.box-header -->
            <form id="form_config">
            <div class="box-body table-responsive padding">

				<table id="tconf">
					<thead>
					</thead>
					<tbody id="body_conf">
					
					</tbody>
				</table>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit_form_config">Submit</button>
                
                <button type="button" class="btn btn-normal" onclick="document.location.href='<?php echo site_url("component_assignment") ?>';" >Cancel</button>
                
             </div>
  
          </div>
          <!-- /.box -->
          </form>
        </div>
      </div>

    </section>
    <!-- /.content -->


<!-- msg confirm -->
<?php if($this->ERROR && $this->input->post("RANGE")): ?>
	<a  id="a-notice-error"
		class="notice-error"
		style="display:none";
		href="#"
		data-title="Something Error"
		data-text="<?php echo $this->ERROR; ?>"
	></a>

<?php ELSE: ?>

	  <a  id="a-notice-success"
		class="notice-success"
		style="display:none";
		href="#"
		data-title="Done!"
		data-text="Configuration Updated"
	></a>            
<?php endif; ?>
<!-- eof msg confirm -->


<script language="javascript" type="text/javascript" src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>

<script>

$(document).ready(function(){
	$(".delete").confirm({ 
		confirmButton: "Remove",
		cancelButton: "Cancel",
		confirmButtonClass: "btn-danger"
	});
	
	$("#ID_COMPANY").change(function(){
		$("#ID_PLANT").empty();
		var url = "<?php echo site_url("plant/json_plant_list/") ?>"+this.value;
		$.getJSON(url,function(data){
			$("#ID_PLANT").empty();
			data.forEach(function(r){
				$("#ID_PLANT").append("<option value='"+r.ID_PLANT+"' "+((r.ID_PLANT=<?php echo ($this->ID_PLANT)?$this->ID_PLANT:0; ?>)?"SELECTED":"")+" >"+r.NM_PLANT+"</option>");
			});
			$("#ID_PLANT").change();
		});
	});
	
	$("#ID_PLANT").change(function(){
		$("#div_table").html($("#loader").html());
		var url = "<?php echo site_url("range_qaf/async_list_area/") ?>"+this.value;
		$.getJSON(url,function(data){
			$("#ID_AREA").empty();
			data.forEach(function(r){
				$("#ID_AREA").append("<option value='"+r.ID_AREA+"' "+((r.ID_AREA=<?php echo ($this->ID_AREA)?$this->ID_AREA:0; ?>)?"SELECTED":"")+" >"+r.NM_AREA+"</option>");
			});
			$("#ID_AREA").change();
		});		
	});
	
	$("#ID_AREA").change(function(){
		var url = "<?php echo site_url("range_qaf/async_configuration/") ?>"+$("#ID_PLANT").val()+"/"+this.value;
		$.getJSON(url,function(data){
			$("#body_conf").empty();
			data.forEach(function(r){ console.log(r);
				$("#body_conf").append("<tr><td WIDTH=100>"+r.KD_COMPONENT+"</td><td WIDTH=100>MIN: <input type=text name='RANGE["+r.ID_COMPONENT+"][V_MIN]' value='"+((r.V_MIN==null)?"":r.V_MIN)+"' size=5/></td><td WIDTH=100>MAX: <input name='RANGE["+r.ID_COMPONENT+"][V_MAX]' type=text value='"+((r.V_MIN==null)?"":r.V_MIN)+"' size=5/></td></tr>");
			});
		});
	});
	
	// $("#ID_COMPANY").change();
	// $("#ID_PLANT").change();
	$("#ID_AREA").change();
	
	<?PHP IF($this->input->post("RANGE")): ?>
	<?php if($this->ERROR): ?>
	$("#a-notice-error").click();
	<?php ELSE: ?>
	
	$("#a-notice-success").click();
	<?php endif; ?>
	<?PHP ENDIF; ?>
});
</script>

<style>
#body_conf td {
	padding: 3px;
}
</style>
