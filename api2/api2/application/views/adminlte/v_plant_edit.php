   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Plant
        <small></small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
		
       <div class="row">
        <!-- left column -->
        <div class="col-md-12">
			
		<?php if($notice->error): ?>

			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-ban"></i> Error!</h4>
				<?php echo $notice->error; ?>
			</div>

		<?php endif; ?>
		
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Update Data Plant</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="<?php echo site_url("plant/update/".$this->data_plant->ID_PLANT) ?>" >
              <div class="box-body" style="background-color:#FFFAAE;">
				  
				<div class="form-group">
          <div class="col-sm-4 clearfix">
  					<?php if($this->USER->ID_COMPANY): ?>									
  					<input type=hidden name="ID_COMPANY" value="<?php echo $this->USER->ID_COMPANY ?>" />
  					<?php else: ?>
  					<label>COMPANY</label>
  					<select class="form-control select2" NAME="ID_COMPANY">
  					  <?php  foreach($this->list_company as $company): ?>
  					   <option value="<?php echo $company->ID_COMPANY ?>" <?php echo ($this->data_plant->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":""; ?> ><?php echo $company->NM_COMPANY ?></option>
  					  <?php endforeach; ?>
  					</select>
  					<?php endif; ?>
				  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-sm-4 clearfix">
					<label>PLANT CODE </label>
					<input type="text" class="form-control" name="KD_PLANT" placeholder="Plant Code" value="<?php echo $this->data_plant->KD_PLANT ?>" >
				  </div>
                </div>
                
                <div class="form-group">                  
				 <div class="col-sm-4 clearfix">
					<label>PLANT NAME</label>
					<input type="text" class="form-control" name="NM_PLANT" placeholder="Plant Name" value="<?php echo $this->data_plant->NM_PLANT ?>" >
				  </div>                
				</div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <a type="button" class="btn btn-danger" href="<?php echo site_url("plant/by_company/".$this->ID_COMPANY) ?>" >Cancel</a>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
