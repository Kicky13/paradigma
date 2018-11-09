<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Input Area Daily
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
        <!-- /.box-header -->
        <div class="box-header">
          <form id="formData">
            <div class="form-group row">
              <div class="form-group col-sm-12 col-sm-4">
                <label for="ID_COMPANY">COMPANY</label>
                <?php if($this->USER->ID_COMPANY): ?>
                <input type=text value="<?php echo $this->USER->NM_COMPANY ?>" class="form-control" readonly />
                <input type=hidden id="ID_COMPANY" NAME="ID_COMPANY" value="<?php echo $this->USER->ID_COMPANY ?>" class="form-control" readonly />
                <?php else: ?>
                <select id="ID_COMPANY" name="ID_COMPANY" class="form-control select2">
                  <?php  foreach($this->list_company as $company): ?>
                    <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                  <?php endforeach; ?>
                </select>
                <?php endif; ?>
              </div>
            </div>

            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_COMPANY">PLANT</label>
                <?php if($this->USER->ID_PLANT): ?>
                <input type=text value="<?php echo $this->USER->NM_PLANT ?>" class="form-control" readonly />
                <input type=hidden id="ID_PLANT" NAME="ID_PLANT" value="<?php echo $this->USER->ID_PLANT ?>" class="form-control" readonly />
                <?php else: ?>
                <select id="ID_PLANT" name="ID_PLANT" class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_AREA">AREA</label>
                <?php if($this->USER->ID_AREA): ?>
                <input type=text value="<?php echo $this->USER->NM_AREA ?>" class="form-control" readonly />
                <input type=hidden id="ID_AREA" NAME="ID_AREA" value="<?php echo $this->USER->ID_AREA ?>" class="form-control" readonly />
                <?php else: ?>
                <select id="ID_AREA" name="ID_AREA" class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>

            </div>

            <div class="form-group row">
              <div class="form-group col-sm-12 col-sm-4">
                <label for="ID_COMPANY">GROUP AREA</label>
                <?php if($this->USER->ID_GROUPAREA): ?>
                <input type=text value="<?php echo $this->USER->NM_GROUPAREA ?>" class="form-control" readonly />
                <input type=hidden id="ID_GROUPAREA" NAME="ID_GROUPAREA" value="<?php echo $this->USER->ID_GROUPAREA ?>" class="form-control" readonly />
                <?php else: ?>
                <select id="ID_GROUPAREA" name="ID_GROUPAREA" class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_COMPANY">MONTH/YEAR</label>
                <input name="TANGGAL" id="datepicker" type="text" class="form-control" value="<?php echo date("m/Y");?>">
              </div>
            </div>
            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-4">
                <button class="btn-primary" name="load" id="btLoad">Load</button>
              </div>
            </div>
            <hr/>
          </form>
          
          <div id="divTable" style="display:none;">
            <div class="form-group row">
              <div class="col-sm-12">
                <span id="saving" style="display:none;">
                  <img src="<?php echo base_url("images/hourglass.gif");?>"> Please wait...
                </span>
                <div id="handsonTable"></div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-12">
                <button name="save" id="save">Save</button>
              </div>
            </div>
          </div>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

<!-- css -->
<style type="text/css">
  label { margin-bottom: 0px; }
  .form-group { margin-bottom: 5px; }
  hr { margin-top: 10px; }
</style>

<!-- HandsonTable CSS -->
<link href="<?php echo base_url("plugins/handsontable/handsontable.full.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/handsontable/pikaday/pikaday.css");?>" rel="stylesheet">

<!-- HandsonTable JS-->
<script src="<?php echo base_url("plugins/handsontable/moment/moment.js");?>"/></script>
<script src="<?php echo base_url("plugins/handsontable/pikaday/pikaday.js");?>"/></script>
<script src="<?php echo base_url("plugins/handsontable/zeroclipboard/ZeroClipboard.js");?>"/></script>
<script src="<?php echo base_url("plugins/handsontable/numbro/numbro.js");?>"/></script>
<script src="<?php echo base_url("plugins/handsontable/numbro/languages.js");?>"/></script>
<script src="<?php echo base_url("plugins/handsontable/handsontable.full.js");?>"/></script>

<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>

<script>
  $(document).ready(function(){
    var picker = new Pikaday({
      field: $('#datepicker')[0],
      format: 'MM/YYYY'
    });

    //Pika month change
    jQuery(document).on('change', '.pika-select-month', function() {
      picker.setDate(new Date((1900+picker.getDate().getYear()), this.value));
    });

    //pika year change
    jQuery(document).on('change', '.pika-select-year', function() {
      picker.setDate(new Date((this.value), picker.getDate().getMonth()));
    });

    var $container = $("#handsonTable");
    var $parent = $container.parent();
    var id_comp;
    var cols;

    $container.handsontable({
      height: 750,
      rowHeaders: true,
      colHeaders: true,
      minSpareRows: 0,
      contextMenu: true,
      onChange: function (change, source) {
        alert('asd');
        if (source === 'loadData') {
          return; //don't save this change
        }
      }
    });

    var handsontable = $container.data('handsontable');

    $('button[name=save]').click(function () {
      $("#saving").css('display','');
      var formData = $("#formData").serializeArray();
      var handsonData = handsontable.getData();

      $.ajax({
        url: "<?php echo site_url("input_area_daily/save_table");?>",
        data: {"data": handsonData, "formData": formData, "id_comp": id_comp}, //returns all cells' data
        dataType: 'json',
        type: 'POST',
        success: function (res) {
          if (res.result === 'ok') {
            console.log('Data saved');
          }
          else {
            console.log('Save error');
          }
          $("#saving").css('display','none');
        },
        error: function () {
          $("#saving").css('display','none');
          console.log('Save error');
        }
      });
      
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
          plant.find('option').remove();
          plant.append($("<option></option>").attr("value", '00').text("NO PLANT"));
        }
      $("#ID_PLANT").change();
      });
    });

    $("#ID_PLANT").change(function(){
      var plant = $(this).val(), grouparea = $('#ID_GROUPAREA');
      $.getJSON('<?php echo site_url("product_assignment/ajax_get_grouparea/");?>' + $("#ID_COMPANY").val() + '/' + plant, function (result) {
        var values = result;
        
        grouparea.find('option').remove();
        if (values != undefined && values.length > 0) {
          grouparea.css("display","");
          $(values).each(function(index, element) {
            if(!$("#ID_GROUPAREA option[value='"+element.ID_GROUPAREA+"']").length > 0){
              grouparea.append($("<option></option>").attr("value", element.ID_GROUPAREA).text(element.NM_GROUPAREA));
            }
          });
        }else{
          grouparea.find('option').remove();
          grouparea.append($("<option></option>").attr("value", '00').text("NO GROUP AREA"));
        }
        $("#ID_GROUPAREA").change();
      });
    });

    $("#ID_GROUPAREA").change(function(){
      var grouparea = $(this).val(), area = $('#ID_AREA');
      $.getJSON('<?php echo site_url("product_assignment/ajax_get_area/");?>' + $("#ID_COMPANY").val() + '/' + $("#ID_PLANT").val() + '/' + grouparea, function (result) {
        var values = result;
        
        area.find('option').remove();
        if (values != undefined && values.length > 0) {
          area.css("display","");
          $(values).each(function(index, element) {
            area.append($("<option></option>").attr("value", element.ID_AREA).text(element.NM_AREA));
          });
        }else{
          area.find('option').remove();
          area.append($("<option></option>").attr("value", '00').text("NO AREA"));
        }
      });
    });

    $("#btLoad").click(function(event){
      event.preventDefault();
      var blTh = $("#datepicker").val();
      blTh = blTh.split("/");
      var hari = getNumberOfDays((blTh[0]-1), (blTh[1]));
      var formData = $("#formData").serializeArray();

      $("#saving").css('display','');
      $("#divTable").css("display","");

      //Set table columns | Update setting
      $.getJSON('<?php echo site_url("input_area_daily/ajax_get_component/");?>' + $("#ID_PLANT").val() +"/"+$("#ID_GROUPAREA").val(), function (result) {
        cols = [];
        cols = JSON.stringify(result.colHeader);
        id_comp = result.id_comp;

        if(result.colHeader.length==3){
          id_comp = null;
          $.confirm({
            title: "WARNING!",
            text: "NO COMPONENT ON THIS GROUP AREA!<br/>PLEASE SELECT OTHER GROUP AREA",
            confirmButton: "OK",
            cancelButton: "Cancel",
            confirmButtonClass: "btn-danger"
          })
          $(".cancel").css("display","none");
          $('button[name=save]').prop('disabled', true);
        }else{
          $('button[name=save]').prop('disabled', false);
        }

        //Update Handsontable setting
        handsontable.clear();
        handsontable.updateSettings({
          minRows: hari,
          maxRows: hari,
          columns: result.colHeader
        });
        handsontable.deselectCell();
        $("#saving").css('display','none');
        //Load handsonData
        $.ajax({
          url: "<?php echo site_url("input_area_daily/load_table");?>",
          data: {"formData": formData},
          dataType: 'json',
          type: 'POST',
          success: function (res) {
            handsontable.loadData(res);
          },
          error: function () {
            $("#saving").css('display','none');
            console.log('Save error');
          }
        });

      });
      


    })

  $("#ID_COMPANY").change();

});
  
</script>
