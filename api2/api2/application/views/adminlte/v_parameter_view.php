   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Component Assignment
        <small></small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
	
       <div class="row">
        <div class="col-xs-12">

		
		<form class="form-horizontal" method="post" action="<?php echo site_url("component_assignment/create") ?>" >
		
          <div class="box">
            <div class="box-header with-border">
				
				
					<div class="box-body">
						<div class="form-group">
							<?php if($this->USER->ID_COMPANY): ?>
							<INPUT TYPE=HIDDEN ID=ID_COMPANY VALUE='<?PHP echo $this->USER->ID_COMPANY; ?>' />
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
							<INPUT TYPE=HIDDEN ID=ID_PLANT VALUE='<?PHP echo $this->USER->ID_PLANT; ?>' />
							<?php else: ?>
							<div id="dv_plant" class="col-sm-2">
								<label id="lb_plant">PLANT</label>
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
							<div class="col-sm-2">
								<label>DISPLAY</label>
								<select class="form-control select2" NAME="DISPLAY" id="DISPLAY" >
									<option value='D' <?PHP echo ($this->DISPLAY == 'D')?"SELECTED":""; ?> >DAILY</option>
									<option value='H' <?PHP echo ($this->DISPLAY == 'H')?"SELECTED":""; ?> >HOURLY</option>
								</select>							
							</div>							
						</div>
						
					</div>
					
				
				
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive padding">
              <table class="table table-hover">
                <tr>
                  <th>NO</th>
                  <th>COMPONENT CODE</th>
                  <th>COMPONENT NAME</th>
                </tr>
                <tbody id="div_table">
                <?php if(!count($this->list_grouparea)): ?>
                <tr><td colspan=5> <i>There is no area group in the selected company and plant.</i></td></tr>
                <?php endif; ?>
                </tbody>
              </table>
            </div>
            
            <div id="loader" style="display: none">
                <tr><td valign=middle colspan=3><img src="<?php echo base_url("images/ajax-loader-tr.gif") ?>" />  <i>Loading data...</i></td></tr>
            </div>
            
            <!-- /.box-body -->
            <div class="box-footer">
				<?php if($this->PERM_WRITE): ?>
                <button type="button" id="bt_assign" class="btn btn-primary">Assignment</button>
                <?php endif ?>
                <button type="button" class="btn btn-normal" onclick="document.location.href='<?php echo site_url("component_assignment") ?>';" >Back</button>
                
             </div>
  
          </div>
          <!-- /.box -->
          </form>
        </div>
      </div>

    </section>
    <!-- /.content -->
	
<script language="javascript" type="text/javascript" src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>

<script>

$(document).ready(function(){
	$(".delete").confirm({ 
		confirmButton: "Remove",
		cancelButton: "Cancel",
		confirmButtonClass: "btn-danger"
	});
	
	$("#bt_assign").click(function(){
		if ($("#ID_COMPANY").val()=='7') {
			document.location.href = "<?php echo site_url('component_assignment/edit');?>/SMIG/"+$('#ID_GROUPAREA').val()+"/"+$('#DISPLAY').val();
		}else{
			document.location.href = "<?php echo site_url('component_assignment/edit') ?>/" +$('#ID_PLANT').val()+"/"+$('#ID_GROUPAREA').val()+"/"+$('#DISPLAY').val();
		}
	})

	$("#ID_COMPANY").change(function(){
		$("#ID_PLANT").empty();

		if (this.value == '7') { /* SMIG */
			$("#ID_GROUPAREA").change();
		}else{
			
			var url = "<?php echo site_url("plant/json_plant_list/") ?>"+this.value;
			$.getJSON(url,function(data){
				$("#ID_PLANT").empty();
				data.forEach(function(r){
					$("#ID_PLANT").append("<option value='"+r.ID_PLANT+"'>"+r.NM_PLANT+"</option>");
				});
				$("#ID_PLANT").change();
			});			
		}

	});
	
	$("#ID_PLANT").change(function(){
		$("#div_table").html($("#loader").html());
		var url = "<?php echo site_url("component_assignment/async_list_grouparea/") ?>"+this.value;
		$.getJSON(url,function(data){
			$("#ID_GROUPAREA").empty();
			data.forEach(function(r){
				$("#ID_GROUPAREA").append("<option value='"+r.ID_GROUPAREA+"'>"+r.NM_GROUPAREA+"</option>");
			});
			$("#ID_GROUPAREA").change();
		});		
	});
	
	$("#ID_GROUPAREA").change(function(){
		if ($("#ID_COMPANY").val() == '7') {
			$("#dv_plant").css('display', 'none');
			var url = "<?php echo site_url("component_assignment/async_configuration/") ?>SMIG/"+this.value+"/"+$("#DISPLAY").val();
			$("#div_table").html($("#loader").html());
			$.getJSON(url,function(data){
				var arr_component = new Array();
				var x = 1;
				$("#div_table").empty();
				data.forEach(function(r){
					$("#div_table").append("<tr><td>"+(x++)+"</td><td>"+r.KD_COMPONENT+"</td><td>"+r.NM_COMPONENT+"</td></tr>");
				});
			});	
		}else{
			$("#dv_plant").css('display', '');
			var url = "<?php echo site_url("component_assignment/async_configuration/") ?>"+$("#ID_PLANT").val()+"/"+this.value+"/"+$("#DISPLAY").val();
			$("#div_table").html($("#loader").html());
			$.getJSON(url,function(data){
				var arr_component = new Array();
				var x = 1;
				$("#div_table").empty();
				data.forEach(function(r){
					$("#div_table").append("<tr><td>"+(x++)+"</td><td>"+r.KD_COMPONENT+"</td><td>"+r.NM_COMPONENT+"</td></tr>");
				});
			});			
		}

	});
	
	$("#DISPLAY").change(function(){
		$("#ID_GROUPAREA").change();
	});
	
	if ($("#ID_COMPANY").val() == '7') {
		$("#ID_GROUPAREA").change();
	}else{
		//$("#ID_COMPANY").change();
	}
	
});
</script>
