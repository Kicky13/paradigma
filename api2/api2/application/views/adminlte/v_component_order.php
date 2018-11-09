<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Component Order
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- /.box-header -->
        <div class="box-header">
          <form id="formData">
            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-3">
                <label for="ID_GROUPAREA">GROUP AREA</label>
                <select id="ID_GROUPAREA" name="ID_GROUPAREA" class="form-control select2">
                  <?php  foreach($this->list_grouparea as $grouparea): ?>
                    <option value="<?php echo $grouparea->ID_GROUPAREA;?>" ><?php echo $grouparea->NM_GROUPAREA;?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group col-sm-6 col-sm-3">
                <label for="DISPLAY">DISPLAY</label>
                <select id="DISPLAY" name="DISPLAY" class="form-control select2">
                  <option value="D">DAILY</option>
                  <option value="H">HOURLY</option>
                </select>
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

<!-- msg confirm -->
  <a  id="a-notice-error"
    class="notice-error"
    style="display:none";
    href="#"
    data-title="Something Error"
    data-text="Failed to save data! :("
  ></a>

    <a  id="a-notice-success"
    class="notice-success"
    style="display:none";
    href="#"
    data-title="Done!"
    data-text="Data saved successfully :)"
  ></a>           
<!-- eof msg confirm -->

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
    var $container = $("#handsonTable");
    var $parent = $container.parent();
    var id_comp;
    var cols;

    $container.handsontable({
      rowHeaders: true,
      colHeaders: true,
      minSpareRows: 0,
      contextMenu: true,
      onChange: function (change, source) {
        //alert('asd');
        if (source === 'loadData') {
          return; //don't save this change
        }
      }
    });

    var handsontable = $container.data('handsontable');

    $("#btLoad").click(function(event){
      event.preventDefault();
      var formData = $("#formData").serializeArray();
      var rows;

      $("#saving").css('display','');
      $("#divTable").css("display","");

      //Set table columns | Update setting
      $.getJSON('<?php echo site_url("component_order/ajax_get_component/");?>' + $("#ID_PLANT").val() +"/"+ $("#ID_GROUPAREA").val() +"/"+$("#DISPLAY").val(), function (result) {
        cols = [];
        cols = JSON.stringify(result.colHeader);
        rows = result.rows;
        id_comp = result.id_param;
        console.log(id_comp);

        if(result.rows < 1){
          id_comp = null;
          $.confirm({
            title: "WARNING!",
            text: "NO COMPONENT ON THIS GROUP AREA!<br/>PLEASE ASSIGN FIRST IN COMPONENT ASSIGNMENT MENU",
            confirmButton: "OK",
            cancelButton: "Cancel",
            confirmButtonClass: "btn-danger"
          })
          $(".cancel").css("display","none");
          $('button[name=save]').prop('disabled', true);
          handsontable.updateSettings({
            columns: result.colHeader
          });
        }else{
          $('button[name=save]').prop('disabled', false);
          handsontable.updateSettings({
            columns: result.colHeader
          });
          
        }

        //Update Handsontable setting
        handsontable.clear();
        handsontable.updateSettings({
          height: 25+(25*rows),
          minRows: rows,
          maxRows: rows
        });
        handsontable.deselectCell();
        handsontable.selectCell(0,1);
        $("#saving").css('display','none');
        handsontable.loadData(result.product);
      });
    })

    $('button[name=save]').click(function () {
      $("#saving").css('display','');
      var formData = $("#formData").serializeArray();
      var handsonData = handsontable.getData();

      $.ajax({
        url: "<?php echo site_url("component_order/save_table");?>",
        data: {"data": handsonData, "formData": formData, "id_comp": id_comp}, //returns all cells' data
        dataType: 'json',
        type: 'POST',
        success: function (res) {
          if (res.result === 'ok') {
            $("#a-notice-success").click();
            console.log('Data saved');
          }
          else {
            $("#a-notice-error").click();
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

    
    /*$(document).on("change", function () {
      if($("#ID_GROUPAREA").val() == '1'){
        $("label[for='DISPLAY']").css('display','');
        $("#DISPLAY").css('display','');
      }else{
        $("label[for='DISPLAY']").css('display','none');
        $("#DISPLAY").css('display','none');
      }
    });*/



  /** Notification **/
  $(".notice-error").confirm({ 
    confirm: function(button) { /* Nothing */ },
    confirmButton: "OK",
    cancelButton: "Cancel",
    confirmButtonClass: "btn-danger"
  });

  $(".notice-success").confirm({ 
    confirm: function(button) { /* Nothing */ },
    confirmButton: "OK",
    cancelButton: "Cancel",
    confirmButtonClass: "btn-success"
  });

});
  
</script>
