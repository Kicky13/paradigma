   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data User
        <small></small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
	
       <div class="row">
        <div class="col-xs-12">
          <div class="box">
			     <table><tr><td>
            <div class="box-header">
              <form class="form-inline">
            <?php if($this->PERM_WRITE): ?>
              <div class="input-group input-group-sm" style="width: 150px; ">
                <a href="<?php echo site_url("user/add");?>" type="button" class="btn btn-block btn-primary btn-sm">Create New</a>
              </div>
            <?PHP endif; ?>
            </form>
              <hr/>
              
            </div>
            </td></tr>
            <!-- /.box-header -->
            <tr><td>
            <div class="box-body">
              <table  id="dt_tables"
              class="table table-striped table-bordered table-hover dt-responsive nowrap"
              cellspacing="0"
              width="100%">
              <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="5%">No.</th>
                  <th width="30%">FULLNAME</th>
                  <th width="30%">USERNAME</th>
                  <th width="30%">USER GROUP</th>
                  <th width="20%"></th>
                </tr>
              </thead>
            </table>
            </div>
            </td></tr></table>
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
  ></a>            
<?php endif; ?>
<!-- eof msg confirm -->  

<!-- css -->
<style type="text/css">
  .btEdit { margin-right:5px; }
</style>

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
	$(".delete").confirm({ 
		confirmButton: "Remove",
		cancelButton: "Cancel",
		confirmButtonClass: "btn-danger"
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


  /** DataTables Init **/
  var table = $("#dt_tables").DataTable({
      language: {
        searchPlaceholder: ""
      },
      "paging": true,
      "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
      "dom":  "<'row'<'col-sm-6 text-left'B><'col-sm-6 text-right'f>>" +
              "<'row'<'col-sm-12'rt>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "buttons": [
      {
        extend: "pageLength",
        className: "btn-sm bt-separ"
      },
      {
        text: "<i class='fa fa-refresh'></i> Reload",
        className: "btn-sm",
          action: function(){
            dtReload(table);
          }
        }
      ],
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": {
      "url" : '<?php echo site_url("user/get_list");?>',
      "type": 'post',
      "data": function(data){
          //data.user = $("#ID_COMPANY").val();
        }
      },
      "columnDefs": [{
        "targets": 0,
        "visible": false,
        "searchable": false
        },
        { responsivePriority: 1, targets: -1 },
        {
        "targets": -1,
        "data": null,
        "defaultContent":
        '<?php if($this->PERM_WRITE): ?><button title="Edit" class="btEdit btn btn-warning btn-xs" type="button"><i class="fa fa-pencil-square-o"></i> Edit</button><?php endif; ?>' + 
        '<?php if($this->PERM_WRITE): ?><button title="Delete" class="btDelete btn btn-danger btn-xs delete" type="button"><i class="fa fa-trash-o"></i> Delete</button><?php endif; ?>'
        }
      ]
    })

    /** DataTable Ajax Reload **/
    function dtReload(table,time) {
      var time = (isNaN(time)) ? 100:time;
      setTimeout(function(){ table.search('').draw(); }, time);
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

    /** btEdit Click **/
    $(document).on('click',".btEdit",function () {
      var data = table.row($(this).parents('tr')).data();
      var url = '<?php echo site_url("user/edit/");?>' + data[0];
      window.location.href = url;
    });

    /** btDelete Click **/
    $(document).on('click',".btDelete",function () {
      var data = table.row($(this).parents('tr')).data();
      var url = '<?php echo site_url("user/delete/");?>' + data[0];

      $.confirm({
          title: "Remove Company",
          text: "This user will be removed. Are you sure?",
          confirmButton: "Remove",
          confirmButtonClass: "btn-danger",
          cancelButton: "Cancel",
          confirm: function() {
            window.location.href = url;
          },
          cancel: function() {
              // nothing to do
          }
      });
    });
});
</script>
