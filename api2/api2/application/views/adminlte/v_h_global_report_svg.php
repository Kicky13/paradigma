<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  GLOBAL REPORT
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
              <div class="form-group col-sm-5 col-sm-2">
                <label for="ID_COMPANY">MONTH</label>
                <SELECT style="width:auto;" class="form-control select2" name="MONTH" id='bulan'>
                  <?php for($i=1;$i<=12;$i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo (date("m")==$i) ? "selected":"";?>><?php echo strtoupper(date("F", mktime(0, 0, 0, $i, 10))); ?></option>
                  <?php endfor; ?>
                </SELECT>
              </div>
              <div class="form-group col-sm-5 col-sm-3">
                <label for="ID_COMPANY">YEAR</label>
                <SELECT style="width:auto;" class="form-control select2" name="YEAR" id='tahun'>
                <?php for($i=2016;$i<=date("Y");$i++): ?>
                  <option value="<?php echo $i; ?>" <?php echo (date("Y")==$i) ? "selected":"";?>><?php echo $i; ?></option>
                <?php endfor; ?>
                </SELECT>
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
          <div id="divTable" style="width:100%;display:none;margin:auto;" class="text-center">
            <div style="float:left;">
              <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" style="font-family:'lucida grande', 'lucida sans unicode', arial, helvetica, sans-serif;font-size:12px;" width="300" height="400">
               
                <rect x="10" y="10" rx="0" ry="0" width="250" height="87" style="fill:rgb(200,246,108);stroke:black;stroke-width:1;opacity:0.5" />
                <text x='100' y='35' text-anchor='middle'>
                  <tspan dy="1.2em" x='90'>UTILIZATION OF NCQR</tspan>
                  <tspan dy="1.2em" x='135'>(NON CONFORMITY QUALITY REPORT)</tspan>
                </text>

                <rect x="10" y="110" rx="0" ry="0" width="250" height="87" style="fill:rgb(200,229,246);stroke:black;stroke-width:1;opacity:0.5" />
                <text x='100' y='135' text-anchor='middle'>
                  <tspan dy="1.2em" x='125'>UPLOADING TIME NOTOFICATION</tspan>
                  <tspan dy="1.2em" x='127'>AND THE MOST COMPLETED DATA</tspan>
                  <tspan dy="1.2em" x='68'>ON QM ONLINE</tspan>
                </text>

                <rect x="10" y="210" rx="0" ry="0" width="250" height="87" style="fill:rgb(234,215,214);stroke:black;stroke-width:1;opacity:0.5" />
                <text x='100' y='235' text-anchor='middle'>
                  <tspan dy="1.2em" x='83'>CEMENT QUALITY :</tspan>
                  <tspan dy="1.2em" x='90'>QAF OF SETTING TIME</tspan>
                </text>

                <rect x="10" y="310" rx="0" ry="0" width="250" height="87" style="fill:rgb(246,223,133);stroke:black;stroke-width:1;opacity:0.5" />
                <text x='100' y='335' text-anchor='middle'>
                  <tspan dy="1.2em" x='83'>CEMENT QUALITY :</tspan>
                  <tspan dy="1.2em" x='127'>QAF OF COMPRESSIVE STRENGTH</tspan>
                </text>
              </svg>
            </div>
            <div id="boxPlot_div" class="boxPlot_div" style="margin-top:25px;float:left;">
              <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" style="font-family:'lucida grande', 'lucida sans unicode', arial, helvetica, sans-serif;font-size:12px;" width="600" height="400">
              <desc>Created with Highcharts 4.2.7</desc>
              <defs>
                <clipPath id="highcharts-28">
                  <rect x="0" y="0" width="580" height="338"/>
                </clipPath>
              </defs>
              <rect x="1" y="1" width="600" height="400" fill="none" class=" highcharts-background"/>
                <g class="highcharts-series-group">
                <g class="highcharts-series highcharts-series-0" transform="translate(10,10) scale(1 1)">
                  <rect x="340" y="190" rx="20" ry="20" width="250" height="150" style="fill:white;stroke:black;stroke-width:3;opacity:0.5" />
                  <text x='530' y='195' text-anchor='middle' style='stroke: #000000;stroke-width:0.5px;'>
                    <tspan dy="1.2em" x='530'>ACTION PLAN 3</tspan>
                  </text>
                  <text x='510' y='215' text-anchor='middle'>
                    <tspan dy="1.2em" x='510'>&nbsp;</tspan>
                  </text>
                  
                  <rect x="340" y="5" rx="20" ry="20" width="250" height="150" style="fill:white;stroke:black;stroke-width:3;opacity:0.5" />
                  <text x='50' y='195' text-anchor='middle' style='stroke: #000000;stroke-width:0.5px;'>
                    <tspan dy="1.2em" x='50'>ACTION PLAN 4</tspan>
                  </text>
                  <text x='60' y='215' text-anchor='middle'>
                    <tspan dy="1.2em" x='60'>&nbsp;</tspan>
                  </text>

                  <rect id='myshape' x="-8" y="5" rx="20" ry="20" width="250" height="150" style="fill:white;stroke:black;stroke-width:3;opacity:0.5" />
                  <text x='50' y='10' text-anchor='middle' style='stroke: #000000;stroke-width:0.5px;'>
                    <tspan dy="1.2em" x='50'>ACTION PLAN 1</tspan>
                  </text>
                  <text x='80' y='30' text-anchor='middle' text-align="justified">
                    <tspan dy="1.2em" x='110'>&nbsp;</tspan>
                  </text>

                  <rect x="-8" y="190" rx="20" ry="20" width="250" height="150" style="fill:white;stroke:black;stroke-width:3;opacity:0.5" />
                  <text x='530' y='10' text-anchor='middle' style='stroke: #000000;stroke-width:0.5px;'>
                    <tspan dy="1.2em" x='530'>ACTION PLAN 2</tspan>
                  </text>
                  <text x='510' y='30' text-anchor='middle'>
                    <tspan dy="1.2em" x='510'>&nbsp;</tspan>
                  </text>
                  
                  <path id='q3' fill="#ED561B" fill-opacity="0.9" d="M 449 169 A 159 159 0 0 1 290.1266159470066 327.99994958616173 L 290 169 A 0 0 0 0 0 290 169 Z" stroke="#FFFFFF" stroke-width="1" stroke-linejoin="round" transform="translate(0,0)"/>
                  <path id='q4' fill="#DDDF00" fill-opacity="0.9" d="M 289.9676159606125 327.99999670211946 A 159 159 0 0 1 131.00002792344225 169.09423191526082 L 290 169 A 0 0 0 0 0 290 169 Z" stroke="#FFFFFF" stroke-width="1" stroke-linejoin="round" transform="translate(0,0)"/>
                  <path id='q1' fill="#24CBE5" fill-opacity="0.9" d="M 131.0000131915221 168.9352319225683 A 159 159 0 0 1 289.7791521898466 10.000153376662809 L 290 169 A 0 0 0 0 0 290 169 Z" stroke="#FFFFFF" stroke-width="1" stroke-linejoin="round" transform="translate(0,0)"/>
                  <path id='q2' fill="#BBBBBB" fill-opacity="0.9" d="M 289.9676159606125 10.000003297880568 A 159 159 0 0 1 448.9999205000066 168.8410000265 L 290 169 A 0 0 0 0 0 290 169 Z" stroke="#FFFFFF" stroke-width="1" stroke-linejoin="round" transform="translate(0,0)"/>
                  
                  <text x='250' y='120' font-size='18px' text-anchor='middle'>
                    <tspan id='tx_cp1' dy="1.2em" x='250'></tspan>
                    <tspan id='tx_cpv1' dy="1.2em" x='250'></tspan>
                  </text>
                  <text x='325' y='120' font-size='18px' text-anchor='middle'>
                    <tspan id='tx_cp2' dy="1.2em" x='325'></tspan>
                    <tspan id='tx_cpv2' dy="1.2em" x='325'></tspan>
                  </text>
                  <text x='325' y='180' font-size='18px' text-anchor='middle'>
                    <tspan id='tx_cp3' dy="1.2em" x='325'></tspan>
                    <tspan id='tx_cpv3' dy="1.2em" x='325'></tspan>
                  </text>
                  <text x='250' y='180' font-size='18px' text-anchor='middle'>
                    <tspan id='tx_cp4' dy="1.2em" x='250'></tspan>
                    <tspan id='tx_cpv4' dy="1.2em" x='250'></tspan>
                  </text>           
                </g>
                <g class="highcharts-markers highcharts-series-0" transform="translate(10,10) scale(1 1)"/></g>
              </svg>
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

  /* CSS Plotly */
  .annotation {
    border: 20px solid black;
  }

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

  #ap_1 {
    float: left;
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
    
    $("#btLoad").click(function(event){
      event.preventDefault();

      /* Animation */
      $body = $("body");
      $body.addClass("loading");
      $body.css("cursor", "progress");

      /* Initialize Vars */

      $.ajax({
          type: "POST",
          dataType: "json",
          data: {
            opt_company: $("#opt_company").val(),
            MONTH: $("#bulan").val(),
            YEAR: $("#tahun").val(),
          },
          //url: '<?php echo base_url("js/json/global.json");?>',
          url: '<?php echo base_url("h_report_score/global_json");?>',
          success: function(res){
            $body.removeClass("loading");
            $body.css("cursor", "default");          

            //console.log(res);
            $("#divTable").css('display','');
            //console.log(res.data[0]);

            //Label + Value + Color
            var i = 0;
            $(res.data[0].labels).each(function(idx, elm) {
              $('#tx_cp' + res.data[0].rank[i]).text(elm);
              $('#tx_cpv' + res.data[0].rank[i]).text(res.data[0].values[i]);
              $('#q' + res.data[0].rank[i]).css('fill', res.data[0].warna[i]);
              console.log(res.data[0].rank[i]);
              i++;
            });
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

    /** Notification **/
    $(".notice-error").confirm({ 
      confirm: function(button) { /* Nothing */ },
      confirmButton: "OK",
      cancelButton: "Cancel",
      confirmButtonClass: "btn-danger"
    });
  });
</script>