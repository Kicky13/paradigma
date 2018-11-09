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
				
          <div class="box">
			<table><tr><td>
            <div class="box-header">
              <h3 class="box-title"><?php echo $this->data_incident->SUBJECT ?></h3>              
            </div>
            </td></tr>
            <!-- /.box-header -->
            <tr><td>
            <div class="box-body table-responsive no-padding">
              <table class="table-fixed ">
                <tr>
                  <th>Component</th>
                  <th>Time</th>
                  <th>Analize</th>
                  <th>Standard</th>
                </tr>
                <tr>
                  <td><?php echo $this->data_incident->NM_COMPONENT." (".$this->data_incident->KD_COMPONENT.")"; ?></td>
                  <td><?php echo $this->data_incident->TANGGAL ?></td>
                  <td><?php echo $this->data_incident->NILAI_ANALISA ?></td>
                  <td><?php echo $this->data_incident->NILAI_STANDARD_MIN." - ".$this->data_incident->NILAI_STANDARD_MAX ?></td>
                 </td>
                </tr>
              </table>
            </div>
            </td></tr>
            <!-- /.box-body -->
         
          <tr><td>
          <div class="box-body">

            <div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>TECHNICIAN </label>
				<input type="text" class="form-control" name="JUDUL_SOLUTION" placeholder="Solution Title" READONLY value="<?php echo $this->data_incident->NM_TEKNISI ?>" >
              </div>
            </div>
            <!-- 
			<div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>ASSIGNMENT NOTE</label>
                <textarea type="text" class="form-control" name="ASSIGN_NOTE" readonly disabled><?php echo $this->data_incident->ASSIGN_NOTE ?></textarea>
              </div>
            </div>
			-->
          </div>
          
          </td></tr>
          
          <tr><td>
          <form role="form" method="POST" action="<?php echo site_url("incident/solve/".$this->data_incident->ID_INCIDENT) ?>" >
          <div class="box-body">
			<div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>REASON OF ABNORMALITY</label>
                <textarea type="text" class="form-control" name="MASALAH" PLACEHOLDER="" value="" readonly ><?php echo $this->data_incident->MASALAH ?></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>SOLUTION </label>
				<input type="text" class="form-control" name="JUDUL_SOLUTION" placeholder="Solution Title" value="<?php echo $this->data_incident->JUDUL_SOLUTION ?>" READONLY >
              </div>
            </div>
			<div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>DESCRIPTION</label>
                <textarea type="text" class="form-control" name="DETAIL_SOLUTION" PLACEHOLDER="Solution Detail" ROWS=6 READONLY ><?php echo $this->data_incident->DETAIL_SOLUTION ?></textarea>
              </div>
            </div>
		
          </div>
          
          </td></tr>
          
          
          </table>
          <!-- /.box-body -->
          <div class="box-footer">
            <a type="button" class="btn btn-primary" href="<?php echo site_url("incident/solved");?>" >   BACK   </a>
          </div>
        </form>
        
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
