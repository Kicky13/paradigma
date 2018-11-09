   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        NCQR Component Assignment
        <small></small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
	
       <div class="row">
        <div class="col-xs-12">
		
		<form class="form-horizontal" method="post" action="<?php echo site_url("ncqr_component/create") ?>" >
		
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
								<label>GROUP&nbsp;AREA</label>
								<select class="form-control select2" id="ID_GROUPAREA" NAME="ID_GROUPAREA" >
									<?php  foreach($this->list_grouparea as $grouparea): ?>
									<option value="<?php echo $grouparea->ID_GROUPAREA ?>" <?php echo ($this->ID_GROUPAREA == $grouparea->ID_GROUPAREA)?"SELECTED":""; ?> ><?php echo $grouparea->NM_GROUPAREA ?></option>
									<?php endforeach; ?>
								</select>							
							</div>							
						</div>
						
					</div>
					
				
				
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive padding">

				<?php foreach($this->list_component as $component): ?>
				<div class="col-sm-2">
					<div class="form-group">
						<label>
						  <input type="checkbox"  NAME="OPT_COMPONENT[]" class="minimal opt_component" value="<?php echo $component->ID_COMPONENT ?>" >
						  <?php echo $component->KD_COMPONENT ?>
						</label>
					</div>						
				</div>
				<?php endforeach; ?>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                
                <button type="button" class="btn btn-normal" onclick="document.location.href='<?php echo site_url("ncqr_component") ?>';" >Cancel</button>
                
             </div>
  
          </div>
          <!-- /.box -->
          </form>
        </div>
      </div>

    </section>
    <!-- /.content -->
<!-- msg confirm -->
<?php if($notice->error): ?>
	<a  id="a-notice-error"
		class="notice-error"
		style="display:none";
		href="#"
		data-title="Something Error"
		data-text="<?php echo $notice->error; ?>"
	></a>

<?php endif; ?>

<?php if($notice->success): ?>
	  <a  id="a-notice-success"
		class="notice-success"
		style="display:none";
		href="#"
		data-title="Done!"
		data-text="<?php echo $notice->success; ?>"
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
	
	$(".notice-error").confirm({ 
    confirm: function(button) { /* Nothing */ },
		confirmButton: "OK",
		cancelButton: "Cancel",
		confirmButtonClass: "btn-danger"
	});
	
	$(".notice-success").confirm({ 
    confirm: function(button) { /* Nothing */ },
		confirmButton: "OK",
		cancelButton: "Cancel",
		confirmButtonClass: "btn-success"
	});
	
    <?php if($notice->error): ?>
	$("#a-notice-error").click();
	<?php endif; ?>
	
	<?php if($notice->success): ?>
	$("#a-notice-success").click();
	<?php endif; ?>
	
	$("#ID_COMPANY").change(function(){
		$("#ID_PLANT").empty();
		var url = "<?php echo site_url("plant/json_plant_list/") ?>"+this.value;
		$.getJSON(url,function(data){
			$("#ID_PLANT").empty();
			data.forEach(function(r){
				$("#ID_PLANT").append("<option value='"+r.ID_PLANT+"' "+((r.ID_PLANT == <?php echo ($this->ID_PLANT)?$this->ID_PLANT:0; ?>)?"selected":"")+" >"+r.NM_PLANT+"</option>");
			});
			$("#ID_PLANT").change();
		});
	});
	
	$("#ID_PLANT").change(function(){
		$("#div_table").html($("#loader").html());
		var url = "<?php echo site_url("ncqr_component/ncqr_grouparea/") ?>";
		$.getJSON(url,function(data){
			$("#ID_GROUPAREA").empty();
			data.forEach(function(r){
				$("#ID_GROUPAREA").append("<option value='"+r.ID_GROUPAREA+"' "+((r.ID_GROUPAREA == <?php echo ($this->ID_GROUPAREA)?$this->ID_GROUPAREA:0; ?>)?"selected":"")+"    >"+r.NM_GROUPAREA+"</option>");
			});
			$("#ID_GROUPAREA").change();
		});		
	});
	
	$("#ID_GROUPAREA").change(function(){
		var url = "<?php echo site_url("ncqr_component/async_configuration/") ?>"+$("#ID_PLANT").val()+"/"+this.value;
		console.log(url);
		$.getJSON(url,function(data){
			var arr_component = new Array();
			data.forEach(function(r){
				arr_component.push(r.ID_COMPONENT);
			});
			console.log(arr_component);
			var arr_opt = $(".opt_component");
			for (i = 0; i < arr_opt.length; i++) {
				var checked = ($.inArray($(arr_opt[i]).val(),arr_component)=="-1" )?false:true; 
				$(arr_opt[i]).prop('checked',checked);
			}
		});
	});
	
	$("#ID_COMPANY").change();
	
	$("#DISPLAY").change(function(){
		$("#ID_GROUPAREA").change();
	});
	
	$("#ID_GROUPAREA").change();
	
});
</script>
