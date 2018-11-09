<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Product Assignment
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
                  <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <select id="ID_PLANT" name="ID_PLANT" class="form-control select2">
                <option value="">Please wait...</option>
              </select>
            </div>

            <div class="form-group">
              <select id="ID_AREA" name="ID_AREA" class="form-control select2">
                <option value="">Please wait...</option>
              </select>
            </div>

          </form>
          <hr/>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="dt_tables"
            class="table table-striped table-bordered table-hover dt-responsive nowrap"
            cellspacing="0"
            width="100%">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th width="5%">No.</th>
                <th width="20%">PRODUCT CODE</th>
                <th width="20%">PRODUCT NAME</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
<!-- DataTables css -->
<link href="<?php echo base_url("plugins/datatables/datatables.net-bs/css/dataTables.bootstrap.min.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/datatables/datatables.net-buttons-bs/css/buttons.bootstrap.min.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/datatables/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/datatables/datatables.net-responsive-bs/css/responsive.bootstrap.min.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/datatables/datatables.net-scroller-bs/css/scroller.bootstrap.min.css");?>" rel="stylesheet">
<!-- DataTables js -->
<script src="<?php echo base_url("plugins/datatables/datatables.net/js/jquery.dataTables.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-bs/js/dataTables.bootstrap.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-buttons/js/dataTables.buttons.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-buttons-bs/js/buttons.bootstrap.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-buttons/js/buttons.h5.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-buttons/js/buttons.print.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-keytable/js/dataTables.keyTable.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-responsive/js/dataTables.responsive.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-responsive-bs/js/responsive.bootstrap.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-scroller/js/dataTables.scroller.min.js");?>"/></script>

<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script>
  $(document).ready(function(){
    //BfLrtip
    var table = $("#dt_tables").DataTable({
      language: {
        searchPlaceholder: ""
      },
      "paging": true,
      "dom":  "<'row'<'col-sm-8 text-left'><'col-sm-4 text-right'f>>" +
              "<'row'<'col-sm-12'rt>>" +
              "<'row'<'col-sm-5'B><'col-sm-7'>>",
      "buttons": [
        {
          text: '<i class="fa fa-check-square-o"></i> Assign',
          className: "btn-success btn-sm",
          action: function() {
            goPost('<?php echo site_url("config_component_range/edit");?>', {"id_plant":<?php echo $this->id_plant;?>, "id_grouparea": <?php echo $this->id_grouparea;?>});
          }
        },
        {
          text: "<i class='fa fa-mail-reply-all'></i> Back",
          className: "btn-normal btn-sm",
          action: function(){ 
            window.location.href = '<?php echo site_url("product_assignment");?>';
          }
        }
      ],
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url" : '<?php echo site_url("config_component_range/get_list_product");?>',
        "type": 'post',
        "data": function(data){
          data.id_area = $("#ID_AREA").val();
          data.id_plant = $("#ID_PLANT").val();
          data.id_company = $("#ID_COMPANY").val();
        }
      },
      "columnDefs": [{
        "targets": 0,
        "visible": false,
        "searchable": false
      }]
    })

    /** DataTable Ajax Reload **/
    function dtReload(table,time) {
      var time = (isNaN(time)) ? 100:time;
      setTimeout(function(){ table.ajax.reload(); }, time);
    }

    //DataTable search on enter
    $('#dt_tables_filter input').unbind();
    $('#dt_tables_filter input').bind('keyup', function(e) {
      var val = this.value;
      var len = val.length;
      if(len==0) table.search('').draw();
      if(e.keyCode == 13) {
        table.search(this.value).draw();  
      }
    });

    $("#ID_COMPANY").change(function(){
      var company = $(this).val(), plant = $('#ID_PLANT');
      $.getJSON('<?php echo site_url("product_assignment/ajax_get_plant/");?>' + company, function (result) {
        var values = result;
        
        plant.find('option').remove();
        if (values != undefined && values.length > 0) {
          plant.css("display","");
          $('#ID_AREA').css("display","");
          $(values).each(function(index, element) {
            plant.append($("<option></option>").attr("value", element.ID_PLANT).text(element.NM_PLANT));
          });
          
        }else{
          plant.css("display","none");
          $('#ID_AREA').css("display","none");
        }
      $("#ID_PLANT").change();
      });
    });

    $("#ID_PLANT").change(function(){
      var plant = $(this).val(), area = $('#ID_AREA');
      $.getJSON('<?php echo site_url("product_assignment/ajax_get_area/");?>' + plant, function (result) {
        var values = result;
        
        area.find('option').remove();
        if (values != undefined && values.length > 0) {
          area.css("display","");
          $(values).each(function(index, element) {
            area.append($("<option></option>").attr("value", element.ID_AREA).text(element.NM_AREA));
          });
        }else{
          area.css("display","none");
        }

        $("#ID_AREA").val('<?php echo $this->ID_AREA;?>');
        $("#ID_AREA").change();
      });
    });

    $("#ID_AREA").change(function(){
      $('#dt_tables').DataTable().ajax.reload();
    });

    $("#ID_COMPANY").change();
  });
</script>