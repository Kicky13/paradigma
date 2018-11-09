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
            <div class="box-header">
				
				<form class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<?php if($this->USER->ID_COMPANY): ?>
							<input type=hidden id="ID_COMPANY" value="<?php echo $this->USER->ID_COMPANY; ?>" />
							<?php else: ?>
							<label for="inputEmail3" class="col-sm-1 control-label">COMPANY</label>
							<div class="col-sm-2">
								<select class="form-control select2" id="ID_COMPANY">
									<?php  foreach($this->list_company as $company): ?>
									<option value="<?php echo $company->ID_COMPANY ?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":""; ?> ><?php echo $company->NM_COMPANY ?></option>
									<?php endforeach; ?>
								</select>							
							</div>
							<?php endif; ?>
							<?php if($this->USER->ID_PLANT): ?>
							<input type=hidden id="ID_PLANT" value="<?php echo $this->USER->ID_PLANT ?>" />
							<?php else: ?>
							<label id="lb_plant" for="inputEmail3" class="col-sm-1 control-label">PLANT</label>
							<div class="col-sm-2">
								<select class="form-control select2" id="ID_PLANT">
									<option VALUE=""> </option>
								</select>							
							</div>
							<?php endif; ?>
						</div>
						
					</div>
				</form>
				
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive padding">
              <table class="table table-hover">
                <tr>
                  <th>Company</th>
                  <th id="th_plant">Plant</th>
                  <th>Area Group</th>
                  <th>&nbsp;</th>
                </tr>
                <tbody id="div_table">
                <?php if(!count($this->list_grouparea)): ?>
                <tr><td colspan=4> <i>There is no area group in the selected company and plant.</i></td></tr>
                <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            
            <div id="loader" style="display: none">
                <tr><td valign=middle><img src="<?php echo base_url("images/ajax-loader-tr.gif") ?>" />  <i>Loading data...</i></td></tr>
            </div>
          </div>
          <!-- /.box -->
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
	
	$("#ID_COMPANY").change(function(){
		$("#ID_PLANT").empty();

		if (this.value == '7') { /* SMIG */
			$("#th_plant").html('');
			$("#lb_plant").css('display', 'none');
			$("#ID_PLANT").css('display', 'none');
			$("#div_table").html($("#loader").html());
			var url = "<?php echo site_url("component_assignment/list_config_grouparea/SMIG") ?>";
			$.get(url,function(data){
				$("#div_table").empty();
				$("#div_table").html(data);
			});
		}else{
			$("#th_plant").html('Plant');
			$("#lb_plant").css('display', '');
			$("#ID_PLANT").css('display', '');
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
		var url = "<?php echo site_url("component_assignment/list_config_grouparea/") ?>"+this.value;
		$.get(url,function(data){
			$("#div_table").empty();
			$("#div_table").html(data);
		});
	});
	
	$("#ID_COMPANY").change();
});
</script>
