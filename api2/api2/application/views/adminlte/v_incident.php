   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        NCQR Incident
        <small></small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
	
       <div class="row">
        <div class="col-xs-12">
		
		      <div class="form-group">
            <select id="j_incident" name="j_incident" class="form-control select2">
              <option value="incident">INCIDENT</option>
              <option value="solved">SOLVED</option>
            </select>
          </div>
          <div class="box">
			       <table>
               <tr>
                <td>
                  <div class="box-header">
                  </div>
                </td>
              </tr>
              <!-- /.box-header -->
              <tr>
                <td>
                  <div class="box-body">
                    <table  id="dt_tables"
                            class="table table-striped table-bordered table-hover dt-responsive nowrap"
                            cellspacing="0"
                            width="100%">
                      <thead>
                        <tr>
                          <th width="5%">ID</th>
                          <th width="5%">No.</th>
                          <th width="30%">Subject</th>
                          <th width="30%">Date</th>
                          <th width="30%">Solved</th>
                          <th width="30%">Solution</th>
                          <th width="20%"></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </td>
              </tr>
            </table>
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
      "url" : '<?php echo site_url("incident/get_list");?>',
      "type": 'post',
      "data": function(data){
          data.j_incident = $("#j_incident").val();
        }
      },
      "columnDefs": [{
        "targets": 0,
        "visible": false,
        "searchable": false
        },
        { responsivePriority: 1, targets: -1 },
        {
        "render" : function(data){
          var btn;
          if (data[4]=='Solved') {
            btn = '<?php if($this->PERM_WRITE): ?><button title="Edit" class="btEdit btn btn-success btn-xs" type="button">View Incident Detail</button><?php endif; ?>';
          }else{
            btn = '<?php if($this->PERM_WRITE): ?><button title="Edit" class="btEdit btn btn-warning btn-xs" type="button">View Incident Detail</button><?php endif; ?>';
          }
          return btn;
          console.log(data[4]);
        },
        "targets": -1,
        "data": null
        }
      ]
    })

    /** DataTable Ajax Reload **/
    function dtReload(table,time) {
      var time = (isNaN(time)) ? 100:time;
      setTimeout(function(){ table.search('').draw(); }, time);
    }

    $("#j_incident").change(function(){
      $('#dt_tables').DataTable().ajax.reload();
    });

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
      var url = '<?php echo site_url("incident/solve/");?>' + data[0];
      window.location.href = url;
    });  	
});


</script>
