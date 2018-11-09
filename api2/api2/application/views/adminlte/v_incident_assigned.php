   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        NCQR Incident
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
              <h3 class="box-title">ASSIGNED</h3>

              
            </div>
            </td></tr>
            <!-- /.box-header -->
            <tr><td>
            <div class="box-body table-responsive no-padding">
              <table class="table-fixed table-hover">
                <tr>
                  <th>No</th>
                  <th>Subject</th>
                  <th>Date</th>
                  <th>Technician</th>
                  <th></th>
                </tr>
                <?php $x=1; foreach($this->list_incident as $incident): ?>
                <tr>
                  <td><?php echo $x++; ?></td>
                  <td><?php echo $incident->SUBJECT ?></td>
                  <td><?php echo $incident->TANGGAL ?></td>
                  <td><?php echo $incident->NM_TEKNISI ?></td>

                  <td> 
						<a type="button" class="btn btn-success btn-xs" href="<?php echo site_url("incident/solve/".$incident->ID_INCIDENT) ?>">View or Solve</a>

					</td>

                 </td>
                </tr>
                <?php endforeach; ?>
                <?php if(!count($this->list_incident)): ?>
                <tr><td colspan=4><i>(No Incident)</i></td></tr>
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
