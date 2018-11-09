   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Access Log
        <small></small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">

       <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <div class="box-body">
              <div class="row">
                <div class="form-group">
                  <div class="form-group col-sm-4 col-sm-2 pd_start">
                    <label for="start">COMPANY</label>
                    <select id="ID_COMPANY" name="ID_COMPANY" class="form-control select2">
                      <option value="ALL">ALL</option>
                      <?php  foreach($this->list_company as $company): ?>
                        <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-sm-4 col-sm-2 pd_start">
                    <label for="start">USER GROUP</label>
                    <select class="form-control select2" id="ID_USERGROUP" NAME="ID_USERGROUP" >
                      <option value="ALL">ALL</option>
                      <?php  foreach($this->list_usergroup as $usergroup): ?>
                      <option value="<?php echo $usergroup->ID_USERGROUP ?>" <?php echo ($this->ID_USERGROUP == $usergroup->ID_USERGROUP)?"SELECTED":""; ?> ><?php echo $usergroup->NM_USERGROUP ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-sm-4 col-sm-2 pd_start">
                    <label for="start">GROUP MENU</label>
                    <select id="ID_GROUPMENU" class="form-control select2">
                      <option value="ALL">ALL</option>
        							<?php  foreach($this->list_groupmenu as $groupmenu): ?>
        							  <option value="<?php echo $groupmenu->ID_GROUPMENU;?>" ><?php echo $groupmenu->NM_GROUPMENU;?></option>
        							<?php endforeach; ?>
      						  </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group">
                  <div class="form-group col-sm-4 col-sm-2 pd_start">
                    <label for="start">START</label>
                    <input name="start" id="pd_start" type="text" class="form-control">
                  </div>
                  <div class="form-group col-sm-4 col-sm-2 pd_end">
                    <label for="start">END</label>
                    <input name="start" id="pd_end" type="text" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-sm-6 col-sm-4">
                  <button class="btn-primary" name="load" id="btLoad">Load</button>
                </div>
              </div>
              <hr>
              <table  id="dt_tables"
                      class="table table-striped table-bordered table-hover dt-responsive nowrap"
                      cellspacing="0"
                      width="100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th width="5%">No.</th>
                    <th width="10%">TIME</th>
                    <th width="10%">USERNAME</th>
                    <th width="10%">USERGROUP</th>
                    <th width="10%">COMPANY</th>
                    <th width="10%">GROUPMENU</th>
                    <th width="10%">MENU</th>
                    <th width="10%">URL</th>
                    <th width="10%">FROM IP</th>
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

<!-- picker css | js -->
<link href="<?php echo base_url("plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css");?>" rel="stylesheet">
<script src="<?php echo base_url("plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js");?>"/></script>

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
  $("#pd_start").datetimepicker({format: 'dd/mm/yyyy hh:ii:ss', autoclose: true, minView: 0});
  $("#pd_end").datetimepicker({format: 'dd/mm/yyyy hh:ii:ss', autoclose: true, minView: 0});

	/** DataTables Init **/
      var table = $("#dt_tables").DataTable({
      "order": [[ 0, 'desc' ]],
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
      "url" : '<?php echo site_url("access_log/get_list");?>',
      "type": 'post',
      "data": function(data){
          data.company = $("#ID_COMPANY").val();
          data.usergroup = $("#ID_USERGROUP").val();
          data.groupmenu = $("#ID_GROUPMENU").val();
          data.time_start = $("#pd_start").val();
          data.time_end = $("#pd_end").val();
        }
      },
      "columnDefs": [{
        "targets": 0,
        "visible": false,
        "searchable": false
      },
      { responsivePriority: 1, targets: -1 },
      ]
    })

    /** DataTable Ajax Reload **/
    function dtReload(table,time) {
      var time = (isNaN(time)) ? 100:time;
      setTimeout(function(){
        table.search('').draw();
        table.ajax.reload( null, false );
      }, time);
    }

    $("#btLoad").click(function(){
        table.ajax.reload();
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


});
</script>
