   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        QAF Component Assignment
        <small></small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
	
       <div class="row">
        <div class="col-xs-12">
		
		<form class="form-horizontal" method="post" action="<?php echo site_url("qaf_component/create") ?>" >
		
          <div class="box">
            <div class="box-header with-border">
				
					<div class="box-body">
						<div class="form-group">						
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
                
                <button type="button" class="btn btn-normal" onclick="document.location.href='<?php echo site_url("qaf_component") ?>';" >Cancel</button>
                
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
	
	
	$("#ID_GROUPAREA").change(function(){
		var url = "<?php echo site_url("qaf_component/async_configuration/") ?>"+this.value;
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
	
	
	$("#ID_GROUPAREA").change();
	
});
</script>
