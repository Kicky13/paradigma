<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Quality Boxplot
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
              <div class="form-group col-sm-4 col-sm-4">
                <label for="dh_ly">DAILY / HOURLY</label>
                <select id="dh_ly" name="dh_ly" class="form-control">
                  <option value="D">DAILY</option>
                  <option value="H">HOURLY</option>
                </select>
              </div>
              <div class="form-group col-sm-4 col-sm-4">
                <label for="start">DATE START</label>
                <input name="start" id="start" type="text" class="form-control" value="<?php echo date("d/m/Y");?>">
              </div>
              <div class="form-group col-sm-4 col-sm-4">
                <label for="end">DATE END</label>
                <input name="end" id="end" type="text" class="form-control" value="<?php echo date("d/m/Y");?>">
              </div>
            </div>
            <hr/>
            <div class="form-group row">
              <div class="col-sm-4">
                <label for="OPT_COMPANY">COMPANY</label><br>
                <?php  foreach($this->list_company as $company): 
                  $checked  = ($this->USER->ID_COMPANY==$company->ID_COMPANY) ? 'checked':NULL;
                ?>
                  <div class="form-group">
                  <label>
                    <input type="checkbox"  NAME="OPT_COMPANY[]" class="minimal OPT_COMPANY" value="<?php echo $company->ID_COMPANY;?>" <?php echo $checked;?>>
                    <?php echo $company->NM_COMPANY;?>
                  </label>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="col-sm-8">
                <label for="OPT_GROUPAREA">GROUP AREA</label><br>
                <?php foreach($this->list_grouparea as $grouparea): ?>
                  <div class="form-group">
                    <label>
                      <input id="<?php echo trim($grouparea->KD_GROUPAREA);?>" type="radio"  NAME="OPT_GROUPAREA[]" class="minimal OPT_GROUPAREA" value="<?php echo $grouparea->ID_GROUPAREA;?>" >
                      <?php echo $grouparea->NM_GROUPAREA ?>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <hr/>
            <div class="form-group row">
              <div id="planarea" class="col-sm-4" style="display:none;">
                <label for="OPT_AREA">PLANT - AREA</label><br>
                <div id="opt_area"></div>
              </div>
              <div id="produk" style="display:none;" class="col-sm-4">
                <label for="OPT_PRODUCT">PRODUCT TYPE</label><br>
                <div id="opt_product"></div>
              </div>
              <div id="komponen" style="display:none;" class="col-sm-4">
                <label for="OPT_COMPONENT">COMPONENT</label><br>
                <div id="opt_component"></div>
              </div>

            </div>
            <hr/>
            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-4">
                <button class="btn-primary" name="load" id="btLoad">Load</button>
              </div>
            </div>
            
          </form>
          <hr/>
          <div id="divTable" style="display:none;text-align:'center';" class="text-center"></div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

<a  id="a-notice-error"
  class="notice-error"
  style="display:none";
  href="#"
  data-title="Alert"
  data-text=""
></a>
<div class="modal_load"><!-- Loading modal --></div>


<!-- css -->
<style type="text/css">
  label { margin-bottom: 0px; }
  .form-group { margin-bottom: 5px; }
  .boxPlot_div { margin:auto;margin-bottom:10px; }
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
</style>

<!-- Additional CSS -->
<link href="<?php echo base_url("plugins/handsontable/pikaday/pikaday.css");?>" rel="stylesheet">

<!-- Additional JS-->
<script src="<?php echo base_url("plugins/handsontable/moment/moment.js");?>"/></script>
<script src="<?php echo base_url("plugins/handsontable/pikaday/pikaday.js");?>"/></script>
<script src="<?php echo base_url("plugins/plotly/plotly-latest.min.js");?>"/></script>

<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>

<script>
  $(document).ready(function(){
    var startDate,
        endDate,
        updateStartDate = function() {
            startPicker.setStartRange(startDate);
            endPicker.setStartRange(startDate);
            endPicker.setMinDate(startDate);
        },
        updateEndDate = function() {
            startPicker.setEndRange(endDate);
            startPicker.setMaxDate(endDate);
            endPicker.setEndRange(endDate);
        },
        startPicker = new Pikaday({
            field: document.getElementById('start'),
            format: 'DD/MM/YYYY',
            minDate: new Date(2015, 12, 31),
            maxDate: new Date(2020, 12, 31),
            onSelect: function() {
                startDate = this.getDate();
                updateStartDate();
            }
        }),
        endPicker = new Pikaday({
            field: document.getElementById('end'),
            format: 'DD/MM/YYYY',
            minDate: new Date(),
            maxDate: new Date(2020, 12, 31),
            onSelect: function() {
                endDate = this.getDate();
                updateEndDate();
            }
        }),
        _startDate = startPicker.getDate(),
        _endDate = endPicker.getDate();
        if (_startDate) {
            startDate = _startDate;
            updateStartDate();
        }
        if (_endDate) {
            endDate = _endDate;
            updateEndDate();
        }

    function addCheckbox(val, namaFor, divid, txt, tipe) {
      tipe = tipe || 'checkbox';
      var container = document.getElementById(divid);
      var divgrup   = document.createElement('div');
          divgrup.className = divid+' form-group';
      var input = document.createElement('input');
          input.type = tipe;
          input.className = namaFor;
          input.name = namaFor+"[]";
          input.value = val;
      var label = document.createElement('label');
          label.htmlFor = namaFor;

      container.appendChild(divgrup);
      divgrup.appendChild(label);
      label.appendChild(input);
      label.appendChild(document.createTextNode("    "+txt));
    }

    function addBoxplotDiv(ctr){
      var container = document.getElementById('divTable');
      var divbox    = document.createElement('div');
      
      divbox.className = 'boxPlot_div';
      divbox.id        = 'boxPlot_' + ctr;

      container.appendChild(divbox);
    }

    $(".OPT_GROUPAREA").change(function() {
      var opt_gid = $(".OPT_GROUPAREA:radio:checked").attr('id');
      console.log(opt_gid);
      $("#planarea").css("display", "");
      $(".boxPlot_div").remove();
      if(opt_gid=="FM"){ // || opt_gid=="CL"
        $("#produk").css("display", "");
        $("#komponen").css("display", "");
        $("#opt_component :checkbox").remove();
        $(".opt_component").remove();
        $('label[for="OPT_COMPONENT[]"]').remove();
      }else{
        $("#komponen").css("display", "");
        $("#produk").css("display", "none");
        $("#opt_product :checkbox").remove();
        $(".opt_product").remove();
        $('label[for="OPT_PRODUCT[]"]').remove();

        $("#opt_component :checkbox").remove();
        $(".opt_component").remove();
        $('label[for="OPT_COMPONENT[]"]').remove();
      }
      var optComp = $('.OPT_COMPANY:checkbox:checked').map(function() {
        return this.value;
      }).get();

      var optGarea = $('.OPT_GROUPAREA:radio:checked').map(function() {
        return this.value;
      }).get();

      $("#opt_area :checkbox").remove();
      $(".opt_area").remove();
      $('label[for="OPT_AREA[]"]').remove();
      $.ajax({
        type: "POST",
        dataType: "json",
        data: {
          opt_c: optComp, 
          opt_g: optGarea
        },
        url: '<?php echo site_url("trend_graph/ajax_get_area_by_company/");?>',
        success: function(res){
          var val = res;
          $(val).each(function(idx, elm) {
            //console.log(elm.NM_PLANT+'-'+elm.NM_AREA);
            addCheckbox(elm.ID_AREA, "OPT_AREA", "opt_area", elm.NM_PLANT+' - '+elm.NM_AREA);
          });
        }
      });
    });

    $(document).on("change", ".OPT_AREA",function(event){
      var opt_gid = $(".OPT_GROUPAREA:radio:checked").attr('id');
      if(opt_gid=="FM"){ //|| opt_gid=="CL"
        var checkedVals = $('.OPT_AREA:checkbox:checked').map(function() {
          return this.value;
        }).get();

        $("#opt_product :radio").remove();
        $(".opt_product").remove();
        $('label[for="OPT_PRODUCT[]"]').remove();

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {opt: checkedVals},
          url: '<?php echo site_url("trend_graph/ajax_get_product_by_area/");?>',
          success: function(res){
            for (var i = 0; i < res.length; i++) {
              delete res[i].ID_C_PRODUCT
              delete res[i].ID_AREA
              //delete res[i].KD_PRODUCT
            };

            var dupes =  [];
            var val = [];
            $.each(res, function (index, entry) {
              if (!dupes[entry.ID_PRODUCT]) {
                dupes[entry.ID_PRODUCT] = true;
                val.push(entry);
              }
            });

            $(val).each(function(idx, elm) {
              addCheckbox(elm.ID_PRODUCT, "OPT_PRODUCT", "opt_product", elm.KD_PRODUCT, 'radio');
            });
          }
        });
      }else{
        var vArea = $('.OPT_AREA:checkbox:checked').map(function() {
          return this.value;
        }).get();

        var vGroup = $('.OPT_GROUPAREA:radio:checked').map(function() {
          return this.value;
        }).get();

        $("#opt_component :checkbox").remove();
        $(".opt_component").remove();
        $('label[for="OPT_COMPONENT[]"]').remove();
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {group: vGroup, area: vArea, dh_ly:$("#dh_ly").val()},
          url: '<?php echo site_url("trend_graph/ajax_get_component/");?>',
          success: function(res){

            for (var i = 0; i < res.length; i++) {
              delete res[i].ID_PARAMETER
              delete res[i].ID_PLANT
              delete res[i].ID_GROUPAREA
              delete res[i].NM_COMPANY
              delete res[i].NM_PLANT
              delete res[i].DISPLAY
            };

            var dupes =  [];
            var val = [];
            $.each(res, function (index, entry) {
              if (!dupes[entry.ID_COMPONENT]) {
                dupes[entry.ID_COMPONENT] = true;
                val.push(entry);
              }
            });
            addCheckbox('all', "OPT_COMPONENT", "opt_component", 'Check All');
            $(val).each(function(idx, elm) {
              addCheckbox(elm.ID_COMPONENT, "OPT_COMPONENT", "opt_component", strtoupper(elm.KD_COMPONENT));
            });
          }
        });
      }
    })

    $(document).on("change", ".OPT_PRODUCT",function(event){
      var vArea = $('.OPT_AREA:checkbox:checked').map(function() {
        return this.value;
      }).get();

      var vGroup = $('.OPT_GROUPAREA:radio:checked').map(function() {
        return this.value;
      }).get();

      $("#opt_component :checkbox").remove();
      $(".opt_component").remove();
      $('label[for="OPT_COMPONENT[]"]').remove();
      $.ajax({
        type: "POST",
        dataType: "json",
        data: {group: vGroup, area: vArea, dh_ly:$("#dh_ly").val()},
        url: '<?php echo site_url("trend_graph/ajax_get_component/");?>',
        success: function(res){

          for (var i = 0; i < res.length; i++) {
            delete res[i].ID_PARAMETER
            delete res[i].ID_PLANT
            delete res[i].ID_GROUPAREA
            delete res[i].NM_COMPANY
            delete res[i].NM_PLANT
            delete res[i].DISPLAY
          };

          var dupes = [];
          var val = [];
          $.each(res, function (index, entry) {
            if (!dupes[entry.ID_COMPONENT]) {
              dupes[entry.ID_COMPONENT] = true;
              val.push(entry);
            }
          });

          addCheckbox('all', "OPT_COMPONENT", "opt_component", 'Check All');
          $(val).each(function(idx, elm) {
            addCheckbox(elm.ID_COMPONENT, "OPT_COMPONENT", "opt_component", strtoupper(elm.KD_COMPONENT));
          });
        }
      });
    });
    
    $(document).on('click', "input[type=checkbox][value='all']", function(){
      $('.OPT_COMPONENT').not(this).prop('checked', this.checked);
    })

    $("#btLoad").click(function(event){
      event.preventDefault();

      /* Animation */
      $body = $("body");
      $body.addClass("loading");
      $body.css("cursor", "progress");

      /* Initialize Vars */
      var vArea = $('.OPT_AREA:checkbox:checked').map(function() {
        return this.value;
      }).get(); 

      var vGroup = $('.OPT_GROUPAREA:radio:checked').map(function() {
        return this.value;
      }).get();

      var vComp = $('.OPT_COMPANY:checkbox:checked').map(function() {
        return this.value;
      }).get();

      var vParam = $('.OPT_COMPONENT:checkbox:checked').map(function() {
        return this.value;
      }).get();

      var vProd = $('.OPT_PRODUCT:radio:checked').map(function() {
        return this.value;
      }).get();
      console.log(vGroup);
      $.ajax({
          type: "POST",
          dataType: "json",
          data: {
            dh_ly: $("#dh_ly").val(),
            start: $("#start").val(),
            end: $("#end").val(),
            company: vComp,
            area: vArea,
            grouparea: vGroup,
            param: vParam,
            prod: vProd

          },
          url: '<?php echo site_url("trend_graph/generate_boxplot/");?>',
          success: function(res){
            $body.removeClass("loading");
            $body.css("cursor", "default");          

            //console.log(res);
            $("#divTable").css('display','');
            $(".boxPlot_div").remove();
            
            if(res.msg=='200'){
              console.log(res.data.length);
              for (var i = 0; i < parseInt(res.data.length); i++) {
                /* Console log */
                console.log(res.data[i].data);
                console.log(res.layout[i].layout);

                addBoxplotDiv(i);

                BoxPlot = document.getElementById('boxPlot_' + i);
                Plotly.purge(BoxPlot);
                Plotly.plot(BoxPlot, {
                  data: res.data[i].data,
                  layout: res.layout[i].layout
                });
              };
            }else{
              $("#divTable").css('display','none');
              $("#a-notice-error").data("text", 'Data not found!');
              $("#a-notice-error").click();
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $body.removeClass("loading");
            $body.css("cursor", "default");
            $("#a-notice-error").data("text", 'Oops! Something went wrong.<br>Please check message in console');
            $("#a-notice-error").click();

            console.log("XHR: " + JSON.stringify(jqXHR));
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
          }
        });
    });

    $("#ID_COMPANY").change();

    /** Notification **/
    $(".notice-error").confirm({ 
      confirm: function(button) { /* Nothing */ },
      confirmButton: "OK",
      cancelButton: "Cancel",
      confirmButtonClass: "btn-danger"
    });
  });
</script>