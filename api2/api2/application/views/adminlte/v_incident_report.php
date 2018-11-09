<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  NCQR Report
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
          <form id="formData" method="post" action="<?php echo site_url("incident/export_report") ?>" target="_blank">
            <div class="form-group row">

              <div class="form-group col-sm-12 col-sm-3">
                <label for="ID_COMPANY">COMPANY</label>
                <?php if($this->USER->ID_COMPANY): ?>
                <INPUT TYPE="TEXT" VALUE="<?php echo $this->USER->NM_COMPANY; ?>" readonly class="form-control" />
                <INPUT TYPE="HIDDEN" ID="ID_COMPANY" name="" VALUE="<?php echo $this->USER->ID_COMPANY; ?>" readonly class="form-control" />
                <?php else: ?>
                <select id="ID_COMPANY" class="form-control select2">
                  <?php  foreach($this->list_company as $company): ?>
                    <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                  <?php endforeach; ?>
                </select>
                <?PHP endif; ?>
              </div>

              <div class="form-group col-sm-6 col-sm-3">
                <label for="ID_COMPANY">PLANT</label>
                <?php if($this->USER->ID_PLANT): ?>
                <INPUT TYPE="TEXT" VALUE="<?php echo $this->USER->NM_PLANT; ?>" readonly class="form-control" />
                <INPUT TYPE="HIDDEN" ID="ID_PLANT" name="" VALUE="<?php echo $this->USER->ID_PLANT; ?>" readonly class="form-control" />
                <?php else: ?>
                <select id="ID_PLANT" class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>
              <div class="form-group col-sm-6 col-sm-3">
                <label for="ID_AREA">AREA</label>
                <?php if($this->USER->ID_AREA): ?>
                <INPUT TYPE="TEXT" VALUE="<?php echo $this->USER->NM_AREA; ?>" readonly class="form-control" />
                <INPUT TYPE="HIDDEN" ID="ID_AREA" name=ID_AREA VALUE="<?php echo $this->USER->ID_AREA; ?>" readonly class="form-control" />
                <?php else: ?>
                <select id="ID_AREA" name="ID_AREA" class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>

            </div>

            <div class="form-group row">

              <div class="form-group col-sm-12 col-sm-3">
                <label for="ID_COMPANY">START DATE</label>
                <INPUT TYPE="TEXT" id="STARTDATE" NAME="STARTDATE" VALUE="" readonly class="form-control" />

              </div>

              <div class="form-group col-sm-6 col-sm-3">
                <label for="ID_COMPANY">END DATE</label>
                <INPUT TYPE="TEXT" id="ENDDATE" name="ENDDATE" VALUE="" readonly class="form-control" />

              </div>
              <div class="form-group col-sm-6 col-sm-3">
                <label for="ID_AREA">TYPE</label>

                <select id="ID_INCIDENT_TYPE" name="ID_INCIDENT_TYPE" class="form-control select2">
				  <option value="">All</option>
				  <?php foreach($this->list_type as $type): ?>
                  <option value="<?php echo $type->ID_INCIDENT_TYPE ?>"><?php echo $type->NM_INCIDENT_TYPE ?></option>
				  <?php endforeach; ?>
                </select>
              </div>

            </div>
            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-4">
                <button class="btn-primary" name="load" id="btLoad">VIEW DATA</button> &nbsp;
                <button class="btn-success" id="btnExportXLS">EXPORT (XLS)</button>
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
                <div id="handsonTable">

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

<!-- css -->
<style type="text/css">
  label { margin-bottom: 0px; }
  .form-group { margin-bottom: 5px; }
  hr { margin-top: 10px; }
</style>


<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script src="<?php echo base_url("js/jquery-ui.js"); ?>" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery-ui.css"); ?>" />
<script>
  var bsModal = $.fn.modal.noConflict();
</script>
<script src="<?php echo base_url("js/jquery.modal.js") ?>" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/jquery.modal.css") ?>" />

<script>
  $(document).ready(function(){

	$("#STARTDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});

	$("#ENDDATE").datepicker({
		dateFormat: 'dd/mm/yy'
	});

    $("#ID_COMPANY").change(function(){
      var company = $(this).val(), plant = $('#ID_PLANT');
      $.getJSON('<?php echo site_url("incident/ajax_get_plant/");?>' + company, function (result) {
        var values = result;

        plant.find('option').remove();
        if (values != undefined && values.length > 0) {
          plant.css("display","");
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
      var plant = $(this).val(), area = $('#ID_AREA');
      $.getJSON('<?php echo site_url("incident/ajax_get_area/");?>' + $("#ID_COMPANY").val() + '/' + plant, function (result) {
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
      var formData = $("#formData").serializeArray();
	  var display = $("#DISPLAY").val();
      $("#saving").css('display','');
      $("#divTable").css("display","");

      //Set table columns | Update setting
      $.post('<?php echo site_url("incident/get_report");?>', formData, function (result) {
		//  console.log(result);
		$("#saving").css('display','none');
		var tab = '<div class="box-body table-responsive no-padding"><table class="table" border=1 id=tbldata>';
		tab += '<tr>';
		tab += '<th>No</th><TH>COMPANY</TH><TH>PLANT</TH><TH>AREA</TH><th>SUBJECT</th><th>CREATED BY</th><th>TYPE</th><th>DATE</th><TH>&nbsp;</TH>';
		tab += '</tr>';

		var ltr = 0
		//console.log(result);
		$.each(result, function(i,item){
			tab += "<tr>";
			tab += "<td>"+(i+1)+"</td>";
			tab += "<td>"+item.NM_COMPANY+"</td>";
			tab += "<td>"+item.NM_PLANT+"</td>";
			tab += "<td>"+item.NM_AREA+"</td>";
			tab += "<td>"+item.SUBJECT+"</td>";
			tab += "<td>"+item.FULLNAME+"</td>";
			tab += "<td>"+item.NM_INCIDENT_TYPE+"</td>";
			tab += "<td>"+item.TANGGAL+"</td>";
			tab += "<td><a href='<?php echo site_url("incident/notif_sent") ?>/"+item.ID_INCIDENT+"' rel='modal:open' type='button' class='btn btn-info btn-xs'>Notification Sent</a></td>";
			tab += "</tr>";
			ltr++;
		});

		if(ltr == 0){
			tab += "<tr><td colspan='6'><i>(Empty Data)</i></td></tr>";
		}

		tab += '</table></div>';
		$("#handsonTable").html(tab);

      },"json");
    });


  $("#ID_COMPANY").change();

});

</script>
<style>
.modal-dialog{
    position: relative !important;
    display: inline-block !important;
    overflow-y: auto !important;
    overflow-x: auto !important;
    width: auto !important;
    min-width: 100px !important;
    padding: 5px;
    z-index: 999 !important;
}


.modal a.close-modal {
	top: -50px !important;
	right: -50px !important;
}
</style>
