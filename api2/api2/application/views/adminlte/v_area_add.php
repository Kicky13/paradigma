<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Master Data Area
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
          <h3 class="box-title">Add Data Area</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo site_url("area/create") ?>" >
          <div class="box-body" style="background-color:#c5d5ea;">
            
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>COMPANY </label>
                <?php if($this->USER->ID_COMPANY): ?>
                <input type=text class="form-control" value="<?php echo $this->USER->NM_COMPANY ?>" readonly />
                <input type=hidden class="form-control" value="<?php echo $this->USER->ID_COMPANY ?>"  />
                <?php else: ?>
                <select class="form-control select2" onchange="document.location.href='<?php echo site_url("area/add/") ?>'+this.value;">
                  <?php  foreach($this->list_company as $company): ?>
                  <option value="<?php echo $company->ID_COMPANY ?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":""; ?> ><?php echo $company->NM_COMPANY ?></option>
                  <?php endforeach; ?>
                </select>
                <?php endif; ?>
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>PLANT </label>
                <?php if($this->USER->ID_PLANT): ?>
                <input type=text class="form-control" value="<?php echo $this->USER->NM_PLANT ?>" readonly />
                <input type=hidden class="form-control" value="<?php echo $this->USER->ID_PLANT ?>"  />
                <?php else: ?>
                <select class="form-control select2" NAME="ID_PLANT">
                  <?php  foreach($this->list_plant as $plant): ?>
                  <option value="<?php echo $plant->ID_PLANT ?>" <?php echo ($this->ID_PLANT == $plant->ID_PLANT)?"SELECTED":""; ?> ><?php echo $plant->NM_PLANT ?></option>
                  <?php endforeach; ?>
                </select>
                <?php endif; ?>
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>GROUP AREA</label>
				<select class="form-control select2" NAME="ID_GROUPAREA">
                  <?php  foreach($this->list_grouparea as $grouparea): ?>
                  <option value="<?php echo $grouparea->ID_GROUPAREA ?>" <?php echo ($this->ID_GROUPAREA == $grouparea->ID_GROUPAREA)?"SELECTED":""; ?> ><?php echo $grouparea->NM_GROUPAREA ?></option>
                  <?php endforeach; ?>
                </select>              
               </div>
            </div>
            
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>AREA CODE</label>
                <input type="text" class="form-control" name="KD_AREA" placeholder="Area Code"  REQUIRED >
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>AREA NAME</label>
                <input type="text" class="form-control" name="NM_AREA" placeholder="Area Name" REQUIRED >
              </div>
            </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a type="button" class="btn btn-danger" href="<?php echo site_url("area/by_plant/".$this->ID_PLANT);?>" >Cancel</a>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
