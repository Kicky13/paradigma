<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  NCQR Dashboard
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
          <form id="formData" method="post" action="<?php echo site_url("incident/export_report") ?>" target="_blank">


            <div class="form-group row">

              <div class="form-group col-sm-12 col-sm-3">
                <label for="ID_COMPANY">START DATE</label>
                <INPUT TYPE="TEXT" id="STARTDATE" NAME="STARTDATE" VALUE="<?php echo date("01/m/Y") ?>" readonly class="form-control" />

              </div>

              <div class="form-group col-sm-6 col-sm-3">
                <label for="ID_COMPANY">END DATE</label>
                <INPUT TYPE="TEXT" id="ENDDATE" name="ENDDATE" VALUE="<?php echo date("t/m/Y") ?>" readonly class="form-control" />

              </div>

            </div>
            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-4">
                <button class="btn-primary" name="load" id="btLoad">VIEW DATA</button> &nbsp;
                <span id="saving" style="display:none;">
                  <img src="<?php echo base_url("images/hourglass.gif");?>"> Please wait...
                </span>
              </div>
            </div>
            <hr/>
          </form>


		   <div class="row">
			<div id="spacer" class="10"></div>
				<canvas id="canvas"></canvas>
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

  canvas {
	-moz-user-select: none;
	-webkit-user-select: none;
	-ms-user-select: none;
  }

</style>


<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script src="<?php echo base_url("js/jquery-ui.js"); ?>" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery-ui.css"); ?>" />
<script src="<?php echo base_url("js/chartjs/Chart.bundle.js") ?>"></script>
<script src="<?php echo base_url("js/chartjs/utils.js") ?>"></script>

<script>
  $(document).ready(function(){

	var list_id_company = [<?php foreach($this->list_company as $company){ echo $company->ID_COMPANY.","; } ?>];

	$("#STARTDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});

	$("#ENDDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});


    $("#btLoad").click(function(event){
      event.preventDefault();
      $("#saving").css('display','');

	  $.post('<?php echo site_url("incident/get_score_company");?>', { STARTDATE: $("#STARTDATE").val(), ENDDATE: $("#ENDDATE").val() }, function (result) {
		    var list_label = [];
		    var list_value = [];
		    $.each(result,function(i,item){
				list_label.push(item.NM_COMPANY);
				list_value.push((item.AVG_SCORE == null)?0:item.AVG_SCORE);
			});
			var chartData = {
				labels: list_label,
				datasets: [{
					type: 'bar',
					label: 'Average Score',
					backgroundColor: window.chartColors.green,
					data: list_value,
					borderColor: 'white',
					borderWidth: 2
				}]

			};

			var ctx = document.getElementById("canvas").getContext("2d");
			window.myMixedChart = new Chart(ctx, {
				type: 'bar',
				data: chartData,
				options: {
          responsive: true,
          showTooltips: true,
					title: {
						display: true,
						text: 'Score Graph of NCQR'
					},
          multiTooltipTemplate : "<%=datasetLabel%> : <%=value%>"
				}
			});

			$("#saving").css('display','none');
	  },"json");

    });
    $("#btLoad").click();


});

</script>
