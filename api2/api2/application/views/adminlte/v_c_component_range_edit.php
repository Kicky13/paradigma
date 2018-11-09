<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Configuration of Component Range
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
          <form class="form-inline">
            <div class="form-group">
              <select id="ID_COMPANY" name="ID_COMPANY" class="form-control select2">
                <?php  foreach($this->list_company as $company): ?>
                <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->id_company == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <select id="ID_PLANT" name="ID_PLANT" class="form-control select2">
                <option value="">Please wait...</option>
              </select>
            </div>
            <div class="form-group">
              <select id="ID_GROUPAREA" name="ID_GROUPAREA" class="form-control select2">
                <option value="">Please wait...</option>
              </select>
            </div>
            <div class="form-group">
              <select id="DISPLAY" name="DISPLAY" class="form-control select2" readonly disabled>
                <option value="D" <?php echo ($this->input->post("DISPLAY") == "D")?"SELECTED":""; ?> >DAILY</option>
                <option value="H" <?php echo ($this->input->post("DISPLAY") == "H")?"READONLY DISABLED":""; ?> >HOURLY</option>
              </select>
            </div>
          </form>
        </div>
        <!-- /.box-header -->
        <form id="myform" role="form" method="post" action="<?php echo site_url("config_component_range/create");?>">
          <input type="hidden" name="plant" value="<?php echo $this->input->post('plant');?>">
          <input type="hidden" name="grouparea" value="<?php echo $this->input->post('grouparea');?>">
          <input type="hidden" name="display" value="<?php echo $this->input->post('display');?>">
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
                    <input class="in_param" type="hidden" name="id_param[]" value="<?php echo $component->ID_PARAMETER;?>">
                    <input required class="in_min" type="number" id="min_param_<?php echo $component->ID_PARAMETER;?>" name="min_param_<?php echo $component->ID_PARAMETER;?>" placeholder="MIN VALUE" autofocus>
                    <input required class="in_max" type="number" id="max_param_<?php echo $component->ID_PARAMETER;?>"  name="max_param_<?php echo $component->ID_PARAMETER;?>" placeholder="MAX VALUE">
                  </td>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger" onclick="document.location.href='<?php echo site_url("config_component_range");?>';">Cancel</button>
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
       if (parseInt($("#max_param_<?php echo $component->ID_PARAMETER;?>").val(), 10) < parseInt($("#min_param_<?php echo $component->ID_PARAMETER;?>").val(), 10)) {
          $("#a-notice-error").click();
          //alert('WARNING!\nMax Value must bigger than Min value');
          //console.log('MAX: ' + $("#max_param_<?php echo $component->ID_PARAMETER;?>").val() + ' - MIN: ' + $("#min_param_<?php echo $component->ID_PARAMETER;?>").val());
          return false;
        };
      <?php endforeach; ?>
    });

    $("#ID_COMPANY").change(function(){
      var company = $(this).val(), plant = $('#ID_PLANT');
      $.getJSON('<?php echo site_url("product_assignment/ajax_get_plant/");?>' + company, function (result) {
        var values = result;
        
        plant.find('option').remove();
        if (values != undefined && values.length > 0) {
          plant.css("display","");
          $('#ID_GROUPAREA').css("display","");
          $(values).each(function(index, element) {
            plant.append($("<option></option>").attr("value", element.ID_PLANT).text(element.NM_PLANT));
          });
          
        }else{
          plant.css("display","none");
          $('#ID_GROUPAREA').css("display","none");
        }
        $('#ID_PLANT option[value="<?php echo $this->id_plant;?>"]').attr('selected', 'selected');
        $("#ID_PLANT").change();
      });
    });

    $("#ID_PLANT").change(function(){
      var plant = $(this).val(), area = $('#ID_GROUPAREA');
      $.getJSON('<?php echo site_url("config_component_range/get_grouparea/");?>' + plant, function (result) {
        var values = result;
        
        area.find('option').remove();
        if (values != undefined && values.length > 0) {
          area.css("display","");
          $(values).each(function(index, element) {
            area.append($("<option></option>").attr("value", element.ID_GROUPAREA).text(element.NM_GROUPAREA));
          });
        }else{
          area.css("display","none");
        }

        $("#ID_GROUPAREA").val('<?php echo $this->id_grouparea;?>');
        $("#ID_GROUPAREA").change();
      });
    });

    $("#ID_GROUPAREA").change(function() {
      var id_grouparea = $(this).val();
      $("#HID_AREA").val();
      var url = '<?php echo site_url("config_component_range/get_parameter/");?>' + id_grouparea + '/' + $("#DISPLAY").val();

      $.getJSON(url, function(data) {
        var arr_param = new Array();
        var arr_min = new Array();
        var arr_max = new Array();

        data.forEach(function(r) {
          console.log(r.ID_PARAMETER + " - " + r.V_MIN + " + " + r.V_MAX);
          $("input[name=min_param_"+r.ID_PARAMETER+"]").val(r.V_MIN);
          $("input[name=max_param_"+r.ID_PARAMETER+"]").val(r.V_MAX);
        });

        

        $("#ID_COMPANY").prop("disabled","disabled");
        $("#ID_PLANT").prop("disabled","disabled");
        $("#ID_GROUPAREA").prop("disabled","disabled");
      });
    });

    $("#ID_COMPANY").change();

  });
</script>
