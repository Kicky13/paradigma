   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Incident Solving Score Configuration
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
              <h3 class="box-title">New Configuration</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="<?php echo site_url("incident_solving_score/update/".$this->data_score_penanganan->ID_SCORE_PENANGANAN) ?>" >
              <div class="box-body" style="background-color:#FFFAAE;">
	
		
                <div class="form-group">
                  <div class="col-sm-4 clearfix">
					<label>HOUR (MIN) </label>
					<input type="NUMBER" class="form-control" name="JAM_MIN" placeholder="" MIN="0" VALUE="<?php echo $this->data_score_penanganan->JAM_MIN ?>" required >
				  </div>
                </div>
                
                <div class="form-group">                  
				 <div class="col-sm-4 clearfix">
					<label>HOUR (MAX) </label>
					<input type="NUMBER" class="form-control" name="JAM_MAX" placeholder="" MIN="0" VALUE="<?php echo $this->data_score_penanganan->JAM_MAX ?>" required  >
				  </div>                
				</div>
				<div class="form-group">                  
				 <div class="col-sm-2 clearfix">
					<label>SCORE </label>
					<input type="number" class="form-control" name="SCORE" placeholder="" MIN="1" VALUE="<?php echo $this->data_score_penanganan->SCORE ?>" required  >
				  </div>                
				</div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
