<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Trend Graph
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
          <hr/>
          <div id="divTable" class="boxPlot_div"></div>
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
  .boxPlot_div { width:90%;margin:auto;margin-bottom:10px; }
</style>

<script src="<?php echo base_url("plugins/plotly/plotly-latest.min.js");?>"/></script>
<script>
  $(document).ready(function(){
    $.ajax({
      type: "POST",
      dataType: "json",
      url: '<?php echo base_url("js/json/box.json");?>',
      success: function(res){
        console.log(res.data[0]);
        BoxPlot = document.getElementById('divTable');
        Plotly.plot(BoxPlot, {
          data: res.data[0].data,
          layout: res.layout[0].layout
        });
      }
    });
  });
</script>