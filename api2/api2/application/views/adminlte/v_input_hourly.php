<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Input Hourly
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
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_COMPANY">COMPANY</label>
                <select id="ID_COMPANY" name="ID_COMPANY" class="form-control select2">
                  <?php  foreach($this->list_company as $company): ?>
                    <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                  <?php endforeach; ?>
                </select>
              </div>
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
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_COMPANY">MONTH/YEAR</label>
                <input name="TANGGAL" id="datepicker" type="text" class="form-control" value="<?php echo date("d/m/Y");?>">
              </div>
              <div class="form-group col-sm-6 col-sm-4" style="display:none;" id="DIVID_PRODUCT">
                <label for="ID_PRODUCT">TYPE</label>
                <select id="ID_PRODUCT" name="ID_PRODUCT" class="form-control select2">
                  <option value="">Please wait...</option>
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
                <button class="btn-warning" name="preview" id="btPreview">Preview</button>
              </div>
            </div>

            <div id="boxModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 id="modTitle" style="text-align:center;"></h3>
                  </div>

                  <div class="modal-body">
                    <div id="boxDiv" style="display:table; margin: 0 auto;"></div>
                    <hr/>
                    <div style="display:table; margin: 0 auto;">
                      <table id="tb_dev">
                        <thead>
                          <th>COMPONENT</th>
                          <th>MIN</th>
                          <th>MAX</th>
                          <th>AVG</th>
                          <th>DEV</th>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
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

<div class="modal_load"><!-- Loading modal --></div>

<!-- css -->
<style type="text/css">
  label { margin-bottom: 0px; }
  .form-group { margin-bottom: 5px; }
  hr { margin-top: 10px; }

  /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
  .modal_load {
      display:    none;
      position:   fixed;
      z-index:    1000;
      top:        0;
      left:       0;
      height:     100%;
      width:      100%;
      background: rgba( 255, 255, 255, .8 )
                  url('<?php echo base_url("images/ajax-loader-modal.gif");?>')
                  50% 50%
                  no-repeat;
  }

  /* When the body has the loading class, we turn
     the scrollbar off with overflow:hidden */
  body.loading {
      overflow: hidden;
  }

  /* Anytime the body has the loading class, our
     modal element will be visible */
  body.loading .modal_load {
      display: block;
  }

 table #tb_dev {
    border-collapse: collapse;
    width: 100%;
  }

  #tb_dev th, td {
      text-align: center;
      padding: 8px;
  }

  #tb_dev tr:nth-child(even){background-color: #f2f2f2}

  #tb_dev th {
      background-color: #ffaf38;
      color: white;
  }
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
<script src="<?php echo base_url("plugins/plotly/plotly-latest.min.js");?>"/></script>
<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>

<script>
  $(document).ready(function(){
    var picker = new Pikaday({
      field: $('#datepicker')[0],
      format: 'DD/MM/YYYY'
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
        //alert('asd');
        if (source === 'loadData') {
          return; //don't save this change
        }
      }
    });

    var handsontable = $container.data('handsontable');

    $('button[name=save]').click(function () {
      var fm = $("#ID_GROUPAREA").val();
      if (fm==='1' || fm==='4') {
        //alert('Save Cement');
        saveCement();
      }else{
        //alert('Save Input');
        saveTable();
      }

    });

    function saveCement(argument) {
      /* Animation */
      $body = $("body");
      $body.addClass("loading");
      $body.css("cursor", "progress");

      var formData = $("#formData").serializeArray();
      var handsonData = handsontable.getData();

      $.ajax({
        url: "<?php echo site_url("input_hourly/save_table_cement");?>",
        data: {"data": handsonData, "formData": formData, "id_comp": id_comp}, //returns all cells' data
        dataType: 'json',
        type: 'POST',
        success: function (res) {
          $body.removeClass("loading");
          $body.css("cursor", "default");

          if (res.result != 'nok') {
            $("#a-notice-success").click();
            console.log('Data saved');
          }
          else {
            $("#a-notice-error").data("text", res.msg);
            $("#a-notice-error").click();
            if (res.row | res.col) {
              $(handsontable.getCell(res.row, res.col)).css({'border':'2px solid red'});
            };
            console.log('Save error');
          }
          $("#saving").css('display','none');
        },
        error: function () {
          $("#a-notice-error").click();
          $body.removeClass("loading");
          $body.css("cursor", "default");
          console.log('Save error');
        }
      });
    }

    function saveTable() {
      /* Animation */
      $body = $("body");
      $body.addClass("loading");
      $body.css("cursor", "progress");

      var formData = $("#formData").serializeArray();
      var handsonData = handsontable.getData();

      $.ajax({
        url: "<?php echo site_url("input_hourly/save_table");?>",
        data: {"data": handsonData, "formData": formData, "id_comp": id_comp}, //returns all cells' data
        dataType: 'json',
        type: 'POST',
        success: function (res) {
          if (res.result != 'nok') {
            $("#a-notice-success").click();
            console.log('Data saved');
          }
          else {
            $("#a-notice-error").data("text", res.msg);
            $("#a-notice-error").click();
            if (res.row | res.col) {
              $(handsontable.getCell(res.row, res.col)).css({'border':'2px solid red'});
            };
            console.log('Save error');
          }
          $body.removeClass("loading");
          $body.css("cursor", "default");
        },
        error: function () {
          $("#a-notice-error").click();
          $body.removeClass("loading");
          $body.css("cursor", "default");
          console.log('Save error');
        }
      });
    }

    $("#ID_COMPANY").change(function(){
      var company = $(this).val(), plant = $('#ID_PLANT');
      $.getJSON('<?php echo site_url("input_hourly/ajax_get_plant/");?>' + company, function (result) {
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
      $.getJSON('<?php echo site_url("input_hourly/ajax_get_grouparea/");?>' + $("#ID_COMPANY").val() + '/' + plant, function (result) {
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
      var fm = $("#ID_GROUPAREA").val();
      if (fm==='1') {
        $('#DIVID_PRODUCT').css('display','');
      }else{
        $('#DIVID_PRODUCT').css('display','none');
      }

      var grouparea = $(this).val(), area = $('#ID_AREA');
      $.getJSON('<?php echo site_url("input_hourly/ajax_get_area/");?>' + $("#ID_COMPANY").val() + '/' + $("#ID_PLANT").val() + '/' + grouparea, function (result) {
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
        $("#ID_AREA").change();
      });
    });

    function loadInput() {
      var blTh = $("#datepicker").val();
      var jam;
      if (blTh === "<?php echo date("d/m/Y");?>") {
        jam = <?php echo date("H");?>
      } else{
        jam = 24;
      }

      var formData = $("#formData").serializeArray();

      $("#saving").css('display','');
      $("#divTable").css("display","");

      //Set table columns | Update setting
      //Load handsonData
      $.ajax({
        url: "<?php echo site_url("input_hourly/load_table");?>",
        data: {"formData": formData},
        dataType: 'json',
        type: 'POST',
        success: function (result) {
          cols = [];
          cols = JSON.stringify(result.header.colHeader);
          id_comp = result.header.id_comp;

          if(result.header.colHeader.length==2){
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
            height: 25+(25*jam),
            minRows: jam,
            maxRows: jam,
            columns: result.header.colHeader
          });
          handsontable.deselectCell();
          $("#saving").css('display','none');
          handsontable.loadData(result.data);
        },
        error: function () {
          $("#saving").css('display','none');
          console.log('Save error');
        }
      });
    }

    function loadCement() {
      var blTh = $("#datepicker").val();
      var jam;
      if (blTh === "<?php echo date("d/m/Y");?>") {
        jam = <?php echo date("H");?>
      } else{
        jam = 24;
      }

      var formData = $("#formData").serializeArray();

      $("#saving").css('display','');
      $("#divTable").css("display","");

      //Set table columns | Update setting
      //Load handsonData
      $.ajax({
        url: "<?php echo site_url("input_hourly/load_cement");?>",
        data: {"formData": formData},
        dataType: 'json',
        type: 'POST',
        success: function (result) {
          cols = [];
          cols = JSON.stringify(result.header.colHeader);
          id_comp = result.header.id_comp;

          if(result.header.colHeader.length==2){
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
            height: 25+(25*jam),
            minRows: jam,
            maxRows: jam,
            columns: result.header.colHeader
          });
          handsontable.deselectCell();
          $("#saving").css('display','none');
          handsontable.loadData(result.data);
        },
        error: function () {
          $("#saving").css('display','none');
          console.log('Save error');
        }
      });
    }

    $("#ID_AREA").change(function(){
      var area = $(this).val(), product = $('#ID_PRODUCT');
      $.getJSON('<?php echo site_url("input_hourly/ajax_get_product/");?>' + $(this).val() + '/' + $("#ID_PLANT").val() + '/' + $("#ID_COMPANY").val(), function (result) {
        var values = result;

        product.find('option').remove();
        if (values != undefined && values.length > 0) {
          product.css("display","");
          $(values).each(function(index, element) {
            product.append($("<option></option>").attr("value", element.ID_PRODUCT).text(element.KD_PRODUCT));
          });
        }else{
          product.find('option').remove();
          product.append($("<option></option>").attr("value", '00').text("NO TYPE"));
        }
      });
    });

    $("#btLoad").click(function(event){
      event.preventDefault();
      var fm = $("#ID_GROUPAREA").val();
      if (fm==='1' || fm==='4') {
        //alert('Load Cement');
        loadCement();
      }else{
        //alert('Load Input');
        loadInput();
      }
    });

    $("#btPreview").click(function(event){
      event.preventDefault();
      var formData = $("#formData").serializeArray();
      var handsonData = handsontable.getData();
      var g_area = ($("#ID_GROUPAREA option:selected").text() == "FINISH MILL") ? "FM" : "OTHER";

      $.ajax({
        url: "<?php echo site_url("input_hourly/preview_boxplot");?>",
        data: {"data": handsonData, "formData": formData, "comp": cols, "g_area": g_area}, //returns all cells' data
        dataType: 'json',
        type: 'POST',
        success: function (res) {
          var judul = $("#ID_PLANT option:selected").text() + " - " + $("#ID_AREA option:selected").text()
          $("#modTitle").html(judul);
          BoxPlot = document.getElementById('boxDiv');
          Plotly.purge(BoxPlot);
          Plotly.plot(BoxPlot, {
            data: res.data,
            layout: res.layout
          });

          console.log(res.data.length);
          $("#tb_dev tbody").remove();
          $("#tb_dev").append("<tbody></tbody>");
          var table = document.getElementById("tb_dev").getElementsByTagName("tbody")[0];
          $(res.data).each(function(index, element) {
            var row = table.insertRow(0);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            cell1.innerHTML = element.name;
            cell2.innerHTML = element.min_value;
            cell3.innerHTML = element.max_value;
            cell4.innerHTML = element.avg_value;
            cell5.innerHTML = element.dev_value;
          });
        },
        error: function () {
          console.log('Preview error');
        }
      });
      $('#boxModal').modal('show');
    });

  $("#ID_COMPANY").change();

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
