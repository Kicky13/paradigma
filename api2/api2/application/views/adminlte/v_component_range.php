<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Global Component Range
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">      
      <div class="box">
        <div class="box-header">
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="dt_tables"
            class="table table-striped table-bordered table-hover dt-responsive nowrap"
            cellspacing="0"
            width="100%">
            <thead>
              <tr>
                <th width="5%">ID_COMPONENT</th>
                <th width="5%">No.</th>
                <th width="20%">CODE</th>
                <th width="35%">NAME</th>
                <th width="10%">MIN</th>
                <th width="10%">MAX</th>
                <th width="15%"></th>
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

<!-- msg confirm -->
<?php if($notice->error): ?>
  <a  id="a-notice-error"
    class="notice-error"
    style="display:none";
    href="#"
    data-title="Something Error"
    data-text="<?php echo $notice->error; ?>"
  ></a>

<?php endif; ?>

<?php if($notice->success): ?>
    <a  id="a-notice-success"
    class="notice-success"
    style="display:none";
    href="#"
    data-title="Done!"
    data-text="<?php echo $notice->success; ?>"
  >asdasd</a>            
<?php endif; ?>
<!-- eof msg confirm -->

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
    /** DataTables Init **/
    var table = $("#dt_tables").DataTable({
      language: {
        searchPlaceholder: ""
      },
      "paging": true,
      "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
      "dom":  "<'row'<'col-sm-8 text-left'B><'col-sm-4 text-right'f>>" +
              "<'row'<'col-sm-12'rt>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "buttons": [
        {
          text: '<i class="fa fa-edit"></i> All Configuration',
          className: "btn-sm btn-success",
          action: function(){ 
            window.location.href = '<?php echo site_url("component_range/edit");?>';
          }
        },
        {
          extend: "pageLength",
          className: "btn-sm bt-separ btn-normal"
        },
        {
          text: "<i class='fa fa-refresh'></i> Reload",
          className: "btn-sm btn-normal",
          action: function(){ 
            table.search('').draw();
          }
        }
      ],
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url" : '<?php echo site_url("component_range/get_list");?>',
        "type": 'post',
      },
      "columnDefs": [{
        "targets": 0,
        "visible": false,
        "searchable": false
      },{
        "targets": -1,
        "data": null,
        "defaultContent": 
          '<button title="Assignment" class="btAssign btn btn-success btn-xs" type="button"><i class="fa fa-edit"></i> Configuration</button>'
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


    /** btAssign Click **/
    $(document).on('click',".btAssign",function () {
      var url = '<?php echo site_url("component_range/edit");?>';
      var data = table.row($(this).parents('tr')).data();
      var id_component = data[0];
      goPost(url, {"id_component":id_component});
    });

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

  <?php if($notice->error): ?>
  $("#a-notice-error").click();
  <?php endif; ?>
  
  <?php if($notice->success): ?>
  $("#a-notice-success").click();
  <?php endif; ?>

  });
</script>
