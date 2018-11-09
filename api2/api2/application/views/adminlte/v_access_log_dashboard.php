   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ACCESS LOG STATISTIC
        <small></small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php  foreach($this->list_company as $company): ?>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon" style="background-color:<?php echo company_color($company->KD_COMPANY);?>"><i class="fa fa-building-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?php echo $company->NM_COMPANY;?></span>
                <span class="info-box-number"><span id="hit_<?php echo $company->ID_COMPANY;?>"></span></span>
                <span class="info-box-text"><small>on <?php echo date('F');?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        <?php endforeach; ?>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Report</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div id="divTable" style="width:90%;margin:auto;">
                  <div id="boxPlot_div" class="boxPlot_div"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Top 5 Groupmenu</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                <?php foreach ($this->topGroupmenu as $key => $groupmenu): ?>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product">
                      <span class="label label-warning pull-right"><?php echo $groupmenu->JML_AKSES; ?></span>
                      <span class="product-description">
                        <?php echo $groupmenu->RNUM . ". " . $groupmenu->NM_GROUPMENU; ?>
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Top 5 Menu</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                <?php foreach ($this->topMenu as $key => $groupmenu): ?>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product">
                      <span class="label label-warning pull-right"><?php echo $groupmenu->JML_AKSES; ?></span>
                      <span class="product-description">
                        <?php echo $groupmenu->RNUM . ". " . $groupmenu->NM_MENU; ?>
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Top 5 User</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                <?php foreach ($this->topUserList as $key => $user): ?>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product">
                      <span class="label label-warning pull-right"><?php echo $user->JML_AKSES; ?></span>
                      <span class="product-description">
                        <?php echo $user->RNUM . ". " . $user->FULLNAME; ?>
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

<style type="text/css">
  .boxPlot_div { margin:auto;margin-bottom:10px; }
</style>

<!-- picker css | js -->
<link href="<?php echo base_url("plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css");?>" rel="stylesheet">
<script src="<?php echo base_url("plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/plotly/plotly-latest.min.js");?>"/></script>

<script>

$(document).ready(function(){
  $("#pd_start").datetimepicker({format: 'dd/mm/yyyy hh:ii:ss', autoclose: true, minView: 0});
  $("#pd_end").datetimepicker({format: 'dd/mm/yyyy hh:ii:ss', autoclose: true, minView: 0});
  get_opco_hit();
  get_opco_hit_month();

});

function get_opco_hit() {
  $.ajax({
    type: "POST",
    dataType: "json",
    data: {
      string: ''
    },
    url: '<?php echo site_url("dashboard/opco_hit");?>',
    success: function(res){
      $(res).each(function(idx, elm) {
        console.log(elm.ID_COMPANY);
        $("#hit_" + elm.ID_COMPANY).text(elm.JML_AKSES);
      });

    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("XHR: " + JSON.stringify(jqXHR));
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
    }
  });
}

function get_opco_hit_month() {
  $.ajax({
    type: "POST",
    dataType: "json",
    data: {
      string: ''
    },
    url: '<?php echo site_url("dashboard/opco_hit/month");?>',
    success: function(res){
      //console.log(res);
      BoxPlot = document.getElementById('boxPlot_div');
      Plotly.purge(BoxPlot);
      Plotly.plot(BoxPlot, {
        data: res.data,
        layout: res.layout
      });
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("XHR: " + JSON.stringify(jqXHR));
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
    }
  });
}
</script>
