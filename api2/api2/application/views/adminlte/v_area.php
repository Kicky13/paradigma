<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Master Data Area
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">
      

      
      <div class="box">
		<table><tr><td>
        <div class="box-header">
		<?php if(!$this->USER->ID_COMPANY): ?>
          <div class="col-md-3">			
            <select class="form-control select2" onchange="document.location.href='<?php echo site_url("area/by_company/") ?>'+this.value;">
              <option VALUE="">All Company</option>
              <?php  foreach($this->list_company as $company): ?>
              <option value="<?php echo $company->ID_COMPANY ?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":""; ?> ><?php echo $company->NM_COMPANY ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <?php endif; ?>
          <?php if($this->USER->ID_PLANT): ?>
          <h3>PLANT: <?php echo $this->USER->NM_PLANT ?></h3>
          <?php else: ?>
          <div class="col-md-3">
            <select class="form-control select2" onchange="document.location.href='<?php echo site_url("area/by_plant/") ?>'+this.value;">
              <option VALUE="">All Plant</option>
              <?php  foreach($this->list_plant as $plant): ?>
              <option value="<?php echo $plant->ID_PLANT ?>" <?php echo ($this->ID_PLANT == $plant->ID_PLANT)?"SELECTED":""; ?> ><?php echo $plant->NM_PLANT ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <?php endif; ?>
          <?php if($this->PERM_WRITE): ?>
          <div class="input-group input-group-sm" style="width: 150px; float: right ">
            <a href="<?php echo site_url("area/add/".$this->ID_COMPANY."/".$this->ID_PLANT) ?>" type="button" class="btn btn-block btn-primary btn-sm">Create New</a>
          </div>
          <?PHP ENDIF; ?>
        </div>
        </td></tr>
            <!-- /.box-header -->
            <tr><td>
        <div class="box-body table-responsive no-padding">
          <table class="table-fixed table-hover">
            <tr>
              <th>No</th>
              <th>Company</th>
              <th>Plant</th>
              <th>Code</th>
              <th>Area</th>
              <?php if($this->PERM_WRITE): ?><th></th><?php endif; ?>
            </tr>
            <?php $x=1; foreach($this->list_area as $area): ?>
            <tr>
              <td><?php echo $x++; ?></td>
              <td><?php echo $area->NM_COMPANY ?></td>
              <td><?php echo $area->NM_PLANT ?></td>
              <td><?php echo $area->KD_AREA ?></td>
              <td><?php echo $area->NM_AREA ?></td>
              <?php if($this->PERM_WRITE): ?>
              <td>
                <a type="button" class="btn btn-warning btn-xs" href="<?php echo site_url("area/edit/".$area->ID_AREA) ?>">Edit</a>
                <a
                  type="button"
                  class="btn btn-danger btn-xs delete"
                  href="<?php echo site_url("area/delete/".$area->ID_AREA); ?>"
                  data-title="Remove Area"
                  data-text="This area will be removed. Are you sure?"
                >Remove</a>
              </td>
              <?php endif; ?>
          </tr>
          <?php endforeach; ?>
          <?php if(!count($this->list_area)): ?>
          <tr><td colspan=5> <i>There is no area data in the selected company/plant.</i></td></tr>
          <?php endif; ?>
        </table>
      </div>
      </td></tr></table>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
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
	
});
</script>
