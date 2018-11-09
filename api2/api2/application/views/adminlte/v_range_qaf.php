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
							<label for="inputEmail3" class="col-sm-1 control-label">PLANT</label>
							<div class="col-sm-2">
								<select class="form-control select2" id="ID_PLANT">
									<option VALUE=""> </option>
								</select>							
							</div>
							<?php endif; ?>
							<?php if($this->USER->ID_GROUPAREA): ?>
							<input type=hidden id="ID_gROUPAREA" value="<?php echo $this->USER->ID_GROUPAREA ?>" />
							<?php else: ?>
							<label for="inputEmail3" class="col-sm-2 control-label">GROUP AREA</label>
							<div class="col-sm-2">
								<select class="form-control select2" id="ID_GROUPAREA">
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
                  <th>Plant</th>
                  <th>Area Group</th>
                  <th>Product</th>
                  <th></th>
                </tr>
                <tbody id="div_table">
                <?php if(!count($this->list_grouparea)): ?>
                <tr><td colspan=5> <i>Component range of product is not configured yet.</i></td></tr>
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
		var url = "<?php echo site_url("plant/json_plant_list/") ?>"+this.value;
		$.getJSON(url,function(data){
			$("#ID_PLANT").empty();
			data.forEach(function(r){
				$("#ID_PLANT").append("<option value='"+r.ID_PLANT+"'>"+r.NM_PLANT+"</option>");
			});
			$("#ID_PLANT").change();
		});
	});
	
	$("#ID_PLANT").change(function(){
		if(this.value == "") return;
		var url = "<?php echo site_url("qaf_range/async_list_grouparea/") ?>"+this.value;
		$.get(url,function(data){
			$("#ID_GROUPAREA").empty();
			data.forEach(function(r){
				$("#ID_GROUPAREA").append("<option value='"+r.ID_GROUPAREA+"' "+((r.ID_GROUPAREA=<?php echo ($this->ID_GROUPAREA)?$this->ID_GROUPAREA:0; ?>)?"SELECTED":"")+" >"+r.NM_GROUPAREA+"</option>");
			});
			$("#ID_GROUPAREA").change();
		},'json');
	});
	
	$("#ID_GROUPAREA").change(function(){
		if(this.value == "") return;
		$("#div_table").html($("#loader").html());
		var url = "<?php echo site_url("qaf_range/async_list_product") ?>/"+$("#ID_PLANT").val()+"/"+this.value;
		$.get(url,function(data){
			$("#div_table").empty();
			if(data.length >= 1){
			var tr = null;
				data.forEach(function(r){
					tr = null;
					tr += "<tr>";
					tr += "<td>"+r.NM_COMPANY+"</td>";
					tr += "<td>"+r.NM_PLANT+"</td>";
					tr += "<td>"+r.NM_GROUPAREA+"</td>";
					tr += "<td>"+r.KD_PRODUCT+"</td>";
					tr += "<td><a type=button class='btn btn-xs btn-success' href='<?php echo site_url("qaf_range/edit") ?>/"+$("#ID_PLANT").val()+"/"+$("#ID_GROUPAREA").val()+"/"+r.ID_PRODUCT+"' >CONFIGURATION</a></td>";
					tr += "</tr>";
					$("#div_table").append(tr);
				});
			}
			else{
				$("#div_table").append("<tr><td colspan=5><i>Component range of product is not configured yet.</i></td></tr>");
			}
		},'json');
	});
	
	$("#ID_COMPANY").change();
});
</script>
