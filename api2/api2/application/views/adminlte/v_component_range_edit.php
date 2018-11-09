<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Global Component Range Edit
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">
      
      <div class="box">
        <div class="box-header">
          
        </div>
        <!-- /.box-header -->
        <form id="myform" role="form" method="post" action="<?php echo site_url("component_range/create");?>">
          <input type="hidden" name="id_component" value="<?php echo $this->id_component;?>">
          <div class="box-body padding">
            <table  id="dt_tables"
              class="table table-striped table-bordered table-hover dt-responsive nowrap"
              cellspacing="0">
              <thead>
                <tr>
                  <th width="5%">COMPONENT</th>
                  <th width="25%">MIN VALUE | MAX VALUE</th>
                </tr>
              </thead>
              <?php foreach($this->list_component as $component): ?>
                <tr>
                  <td align="right"><?php echo $component->KD_COMPONENT;?></td>
                  <td>
                    <input class="in_param" type="hidden" name="id_component[]" value="<?php echo $component->ID_COMPONENT;?>">
                    <input required class="in_min" step='any' type="number" id="v_min_<?php echo $component->ID_COMPONENT;?>" name="v_min_<?php echo $component->ID_COMPONENT;?>" value="<?php echo $component->V_MIN;?>" placeholder="MIN VALUE" autofocus>
                    <input required class="in_max" step='any' type="number" id="v_max_<?php echo $component->ID_COMPONENT;?>"  name="v_max_<?php echo $component->ID_COMPONENT;?>" value="<?php echo $component->V_MAX;?>" placeholder="MAX VALUE">
                  </td>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger" onclick="document.location.href='<?php echo site_url("component_range");?>';">Cancel</button>
          </div>
          <!-- /.box-body -->
        </form>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
<a  id="a-notice-error"
  class="notice-error"
  style="display:none;"
  href="#"
  data-title="Something Error"
  data-text="Max Value must bigger than Min value"
></a>

<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script>
  $(document).ready(function() {
    $(".notice-error").confirm({
      confirm: function(button) { /* Nothing */ },
      confirmButton: "OK",
      cancelButton: "Cancel",
      confirmButtonClass: "btn-danger"
    });

    $('#myform').submit(function() {
      <?php foreach($this->list_component as $component): ?>
       if (parseInt($("#v_max_<?php echo $component->ID_COMPONENT;?>").val(), 10) < parseInt($("#v_min_<?php echo $component->ID_COMPONENT;?>").val(), 10)) {
          $("#a-notice-error").click();
          //alert('WARNING!\nMax Value must bigger than Min value');
          //console.log('MAX: ' + $("#v_max_<?php echo $component->ID_COMPONENT;?>").val() + ' - MIN: ' + $("#v_min_<?php echo $component->ID_COMPONENT;?>").val());
          return false;
        };
      <?php endforeach; ?>
    });

  });
</script>
