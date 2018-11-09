   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Product
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
              <h3 class="box-title">Add Data Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="<?php echo site_url("product/update/".$this->data_product->ID_PRODUCT) ?>" >
              <div class="box-body" style="background-color:#FFFAAE;"> 
                <div class="form-group">
                  <div class="col-sm-4 clearfix">
					<label>PRODUCT CODE </label>
					<input type="text" class="form-control" name="KD_PRODUCT" placeholder="Product Code" value="<?php echo $this->data_product->KD_PRODUCT ?>" required >
				  </div>
                </div>
                
                <div class="form-group">                  
				 <div class="col-sm-4 clearfix">
					<label>PRODUCT NAME</label>
					<input type="text" class="form-control" name="NM_PRODUCT" placeholder="Product Name" value="<?php echo $this->data_product->NM_PRODUCT ?>" required  >
				  </div>                
				</div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <a type="submit" class="btn btn-danger" href="<?php echo site_url("product") ?>" >Cancel</a>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
