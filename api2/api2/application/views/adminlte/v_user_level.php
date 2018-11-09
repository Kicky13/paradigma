   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Level User
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
              <h3 class="box-title"></h3>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px; ">
                <a href="<?php echo site_url("user_level/add") ?>" type="button" class="btn btn-block btn-primary btn-sm">Create New</a>

                </div>
              </div>
              
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>No</th>
                  <th>Level User Name</th>
                  <th>
                  </th>
                </tr>
                <?php $x=1; foreach($this->list_user_level as $user_level): ?>
                <tr>
                  <td><?php echo $x++; ?></td>
                  <td><?php echo $user_level->NM_LEVEL_USER ?></td>
                  <td> 
						<a type="button" class="btn btn-warning btn-xs" href="<?php echo site_url("user_level/edit/".$user_level->ID_LEVEL_USER) ?>">Edit</a>
						<a 
							type="button" 
							class="btn btn-danger btn-xs delete" 
							href="<?php echo site_url("user_level/delete/".$user_level->ID_LEVEL_USER) ?>"
							data-title="Remove Level User"
							data-text="This user_level will be removed. Are you sure?"
						>Remove</a>

		</td>
                 </td>
                </tr>
                <?php endforeach; ?>
              </table>
            </div>
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
