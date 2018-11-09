   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Component
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
              <h3 class="box-title">Add Data Component</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="<?php echo site_url("component/update/".$this->data_component->ID_COMPONENT) ?>" >
              <div class="box-body" style="background-color:#FFFAAE;">
                <div class="form-group">
                  <div class="col-sm-4 clearfix">
          					<label>COMPONENT CODE </label>
          					<input type="text" class="form-control" name="KD_COMPONENT" placeholder="Component Code" value="<?php echo trim($this->data_component->KD_COMPONENT) ?>"  required >
          				  </div>
                          </div>
                          
                          <div class="form-group">                  
          				 <div class="col-sm-4 clearfix">
          					<label>COMPONENT NAME</label>
          					<input type="text" class="form-control" name="NM_COMPONENT" placeholder="Component Name" value="<?php echo $this->data_component->NM_COMPONENT ?>" required  >
          				  </div>                
          				</div>

                </div>
                <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <a type="submit" class="btn btn-danger" href="<?php echo site_url("component") ?>" >Cancel</a>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
