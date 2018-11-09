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
                  <td><?php echo $this->data_incident->NM_COMPONENT ?></td>
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
          <form role="form" method="POST" action="<?php echo site_url("incident/assign/".$this->data_incident->ID_INCIDENT) ?>" >
          <div class="box-body">

            <div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>ASSIGN </label>
                <select class="form-control select2" NAME="ID_TEKNISI">
                  <?php  foreach($this->list_technician as $technician): ?>
                  <option value="<?php echo $technician->ID_TEKNISI ?>" <?php echo ($this->ID_TEKNISI == $technician->ID_TEKNISI)?"SELECTED":""; ?> ><?php echo $technician->NM_TEKNISI." (".$technician->PIC_TEKNISI.")"; ?></option>
                  <?php endforeach; ?>
                </select>

              </div>
            </div>
            <!-- 
			<div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>NOTE</label>
                <textarea type="text" class="form-control" name="ASSIGN_NOTE"></textarea>
              </div>
            </div>
			-->
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a type="button" class="btn btn-danger" href="<?php echo site_url("incident");?>" >Cancel</a>
          </div>
        </form>
        </td></tr></table>
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
