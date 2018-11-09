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
							
							<div class="col-sm-3">
								<label>GROUPAREA</label>
								<select class="form-control select2" id="ID_GROUPAREA" NAME="ID_GROUPAREA" >
									<?php  foreach($this->list_grouparea as $grouparea): ?>
									<option value="<?php echo $grouparea->ID_GROUPAREA ?>" <?php echo ($this->ID_GROUPAREA == $grouparea->ID_GROUPAREA)?"SELECTED":""; ?> ><?php echo $grouparea->NM_GROUPAREA ?></option>
									<?php endforeach; ?>
								</select>							
							</div>
							
							<div class="col-sm-3">
								<label>PRODUCT</label>
								<select class="form-control select2" id="ID_PRODUCT" NAME="ID_PRODUCT" >
									<?php  foreach($this->list_product as $product): ?>
									<option value="<?php echo $product->ID_PRODUCT ?>" <?php echo ($this->ID_PRODUCT == $product->ID_PRODUCT)?"SELECTED":""; ?> ><?php echo $product->KD_PRODUCT ?></option>
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
                
                <button type="button" class="btn btn-danger" onclick="document.location.href='<?php echo site_url("qaf_range") ?>';" >Cancel</button>
                
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
		$("#ID_GROUPAREA").change();
	});

	$("#ID_GROUPAREA").change(function(){
		if(this.value == "") return;
		$("#div_table").html($("#loader").html());
		if(this.value == 4) { // clinker tidak pakai produk jenis
			$("#ID_PRODUCT").empty();
			$("#ID_PRODUCT").change();
		}
		else{
			var url = "<?php echo site_url("qaf_range/async_list_product") ?>/"+$("#ID_COMPANY").val()+"/"+this.value;
			$.get(url,function(data){
				$("#ID_PRODUCT").empty();
				data.forEach(function(r){
					$("#ID_PRODUCT").append("<option value='"+r.ID_PRODUCT+"' "+((r.ID_PRODUCT==<?php echo ($this->ID_PRODUCT)?$this->ID_PRODUCT:0; ?>)?"SELECTED":"")+" >"+r.KD_PRODUCT+"</option>");
				});
				$("#ID_PRODUCT").change();
			},'json');
		}
	});
	
	$("#ID_PRODUCT").change(function(){
		var url = "<?php echo site_url("qaf_range/async_configuration/") ?>"+$("#ID_COMPANY").val()+"/"+$("#ID_GROUPAREA").val()+"/"+this.value;
		$.getJSON(url,function(data){
			$("#body_conf").empty();
			
			$.each(data,function(key,r){
				$("#body_conf").append("<tr><td WIDTH=150>"+r.KD_COMPONENT+"</td><td WIDTH=150>MIN: <input type=text name='RANGE["+r.ID_COMPONENT+"][V_MIN]' value='"+((r.V_MIN==null)?"":r.V_MIN)+"' size=5/></td><td WIDTH=150>MAX: <input name='RANGE["+r.ID_COMPONENT+"][V_MAX]' type=text value='"+((r.V_MAX==null)?"":r.V_MAX)+"' size=5/></td></tr>");
			});
		});
	});
	
	$("#ID_COMPANY").change(); 
	$("#ID_PLANT").change();
	$("#ID_GROUPAREA").change();
	$("#ID_PRODUCT").change();
	
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
