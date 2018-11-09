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
              <h3 class="box-title"><?php echo $this->data_incident[0]->SUBJECT ?></h3>              
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
                <?php foreach($this->data_incident as $r): ?>
                <tr>
                  <td><?php echo $r->NM_COMPONENT ."(".$r->KD_COMPONENT.")" ?></td>
                  <td><?php echo $r->JAM_ANALISA ?></td>
                  <td><?php echo $r->ANALISA ?></td>
                  <td><?php echo $r->NILAI_STANDARD_MIN." - ".$r->NILAI_STANDARD_MAX ?></td>
                </tr>
                <?php endforeach; ?>
              </table>
            </div>
            </td></tr>
            <!-- /.box-body -->
         
          <tr><td>
          <div class="box-body">
			<!-- 
            <div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>ASSIGN </label>
                <select class="form-control select2" NAME="ID_TEKNISI" readonly disabled>
                  <?php  foreach($this->list_technician as $technician): ?>
                  <option value="<?php echo $technician->ID_TEKNISI ?>" <?php echo ($this->data_incident->ID_TEKNISI == $technician->ID_TEKNISI)?"SELECTED":""; ?> ><?php echo $technician->NM_TEKNISI." (".$technician->PIC_TEKNISI.")"; ?></option>
                  <?php endforeach; ?>
                </select>

              </div>
            </div>
            
			<div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>NOTE</label>
                <textarea type="text" class="form-control" name="ASSIGN_NOTE" readonly disabled><?php echo $this->data_incident->ASSIGN_NOTE ?></textarea>
              </div>
            </div>
		    -->
          </div>
          
          </td></tr>
          <tr><td>
          <form role="form" method="POST" action="<?php echo site_url("incident/solve/".$this->data_incident[0]->ID_INCIDENT) ?>" >
          <div class="box-body">
			<div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>REASON OF ABNORMALITY</label>
                <textarea type="text" class="form-control" name="MASALAH" PLACEHOLDER=""><?php echo $this->solution->MASALAH; ?></textarea>
              </div> 
            </div>
            <div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>SOLUTION </label>
				<input type="text" class="form-control" name="JUDUL_SOLUTION" placeholder="Solution Title" value="<?php echo $this->solution->JUDUL_SOLUTION ?>" >
              </div>
            </div>
			<div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>DESCRIPTION</label>
                <textarea type="text" class="form-control" name="DETAIL_SOLUTION" PLACEHOLDER="Solution Detail" ROWS=6 ><?php echo $this->solution->DETAIL_SOLUTION ?></textarea>
              </div>
            </div>
		
          </div>
          
          </td></tr>
          
          
          </table>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a type="button" class="btn btn-default" href="<?php echo site_url("incident");?>" >Back</a>
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
