   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Technician
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
			<table><tr><td>
            <div class="box-header">
              <h3 class="box-title"></h3>
              <?php //if($this->PERM_WRITE): ?>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px; ">
                <a href="<?php echo site_url("technician/add") ?>" type="button" class="btn btn-block btn-primary btn-sm">Create New</a>

                </div>
              </div>
              <?PHP //ENDIF; ?>
              
            </div>
            </td></tr>
            <!-- /.box-header -->
            <tr><td>
            <div class="box-body table-responsive no-padding">
              <table class="table-fixed table-hover">
                <tr>
                  <th>No</th>
                  <th>Technician Name</th>
                  <th>Technician PIC</th>
                  <?php #if($this->PERM_WRITE): ?><th></th><?php #endif; ?>
                </tr>
                <?php $x=1; foreach($this->list_technician as $technician): ?>
                <tr>
                  <td><?php echo $x++; ?></td>
                  <td><?php echo $technician->NM_TEKNISI ?></td>
                   <td><?php echo $technician->PIC_TEKNISI ?></td>
                  <?php //if($this->PERM_WRITE): ?>
                  <td> 
						<a type="button" class="btn btn-warning btn-xs" href="<?php echo site_url("technician/edit/".$technician->ID_TEKNISI) ?>">Edit</a>
						<a 
							type="button" 
							class="btn btn-danger btn-xs delete" 
							href="<?php echo site_url("technician/delete/".$technician->ID_TEKNISI) ?>"
							data-title="Remove Technician"
							data-text="This technician will be removed. Are you sure?"
						>Remove</a>

					</td>
				   <?php //endif; ?>
                 </td>
                </tr>
                <?php endforeach; ?>
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
	
<script language="javascript" type="text/javascript" src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>

<script>

$(document).ready(function(){
	$(".delete").confirm({ 
		confirmButton: "Remove",
		cancelButton: "Cancel",
		confirmButtonClass: "btn-danger"
	});
			
});
</script>
