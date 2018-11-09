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
			<?php if($this->USER->ID_COMPANY): ?>
			<input type=hidden id="ID_COMPANY" value="<?php echo $this->USER->ID_COMPANY; ?>" />
			<?php else: ?>
            <div class="form-group">
              <select id="ID_COMPANY" name="ID_COMPANY" class="form-control select2">
                <?php  foreach($this->list_company as $company): ?>
                <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <?php endif; ?>
           
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
        <form role="form" method="post" action="<?php echo site_url("product_assignment/create");?>">
          <input type="hidden" name="HID_AREA" id="HID_AREA">
          <div class="box-body table-responsive padding">
            <?php foreach($this->list_product as $product): ?>
            <div class="col-sm-2">
              <div class="form-group">
                <label>
                  <input type="checkbox"  NAME="OPT_PRODUCT[]" class="minimal opt_product" value="<?php echo $product->ID_PRODUCT;?>" >
                  <?php echo $product->KD_PRODUCT ?>
                </label>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger" onclick="document.location.href='<?php echo site_url("product_assignment");?>';">Cancel</button>
          </div>
          <!-- /.box-body -->
        </form>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script>
  $(document).ready(function() {
    $("#ID_COMPANY").change(function() {
      var company = $(this).val(),
        plant = $('#ID_PLANT');

      $.getJSON('<?php echo site_url("product_assignment/ajax_get_plant/");?>' + company, function(result) {
        var values = result;
        if (values != undefined && values.length > 0) {
          plant.find('option').remove();
          $(values).each(function(index, element) {
            plant.append(
              $("<option></option>").attr("value", element.ID_PLANT).text(element.NM_PLANT)
            );
          });
        }
        $("#ID_PLANT").change();
      });
    });

    $("#ID_PLANT").change(function() {
      var optionValue = <?php echo $this->ID_AREA;?>;
      var plant = $(this).val(),
        area = $('#ID_AREA');
        console.log(plant);
        area.empty();
		  $.getJSON('<?php echo site_url("product_assignment/ajax_get_area/");?>' + $("#ID_COMPANY").val()+"/"+plant, function(result) {
  			var values = result;
  			if (values != undefined && values.length > 0) {
  			  //area.find('option').remove();
  			  //area.empty();
  			  $(values).each(function(index, element) {
    				area.append(
    				  $("<option></option>").attr("value", element.ID_AREA).text(element.NM_AREA)
    				);
  			  });
  			}
        <?php if ($this->ID_AREA):?>
  			$("#ID_AREA").val(<?php echo $this->ID_AREA;?>);
        <?php endif;?>
  			$("#HID_AREA").val($("#ID_AREA").val());
  			$("#ID_AREA").change();
		  });
    });

    $("#ID_AREA").change(function() {
      var id_area = $(this).val();
      $("#HID_AREA").val(id_area);
      var url = '<?php echo site_url("product_assignment/async_product/");?>' + id_area;

      $.getJSON(url, function(data) {
        var arr_product = new Array();
        data.forEach(function(r) {
          arr_product.push(r.ID_PRODUCT);
        });
        console.log(arr_product);
        var arr_opt = $(".opt_product");
        for (i = 0; i < arr_opt.length; i++) {
          var checked = ($.inArray($(arr_opt[i]).val(), arr_product) == "-1") ? false : true;
          console.log(arr_opt[i]+" - "+checked);
          $(arr_opt[i]).prop('checked', checked);
        }
      });
    });

    $("#ID_COMPANY").change();

  });
</script>
