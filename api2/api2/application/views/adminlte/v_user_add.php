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
    <!-- left column -->
    <div class="col-md-12">

      <?php if($notice->error): ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        <?php echo $notice->error; ?>
      </div>
      <?php endif; ?>

      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Data User</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo site_url("user/create") ?>" >
          <div class="box-body" style="background-color:#c5d5ea;">

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>FULLNAME </label>
                <input id="fullName" type="text" class="form-control" name="FULLNAME" placeholder="Full Name" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>USERNAME </label>
                <input id="uName" type="text" class="form-control" name="USERNAME" placeholder="User Name" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>USER GROUP </label>
                <select class="form-control select2" id="ID_USERGROUP" NAME="ID_USERGROUP" >
                  <?php  foreach($this->list_usergroup as $usergroup): ?>
                  <option value="<?php echo $usergroup->ID_USERGROUP ?>" <?php echo ($this->ID_USERGROUP == $usergroup->ID_USERGROUP)?"SELECTED":""; ?> ><?php echo $usergroup->NM_USERGROUP ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="form-group" id="div_company" style="display:none">
              <div class="col-sm-4 clearfix">
                <label>COMPANY </label>
                <select class="form-control select2" name="ID_COMPANY" id="ID_COMPANY">
					<option value="">ALL COMPANY</option>
                  <?php  foreach($this->list_company as $company): ?>
                  <option value="<?php echo $company->ID_COMPANY ?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":""; ?> ><?php echo $company->NM_COMPANY ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="form-group" id="div_plant" style="display:none">
              <div class="col-sm-4 clearfix">
                <label>PLANT </label>
                <select class="form-control select2" NAME="ID_PLANT" id="ID_PLANT">
					<option value="">ALL PLANT</option>
                </select>
              </div>
            </div>

            <div class="form-group" id="div_area" style="display:none">
              <div class="col-sm-4 clearfix">
                <label>AREA</label>
                <select class="form-control select2" NAME="ID_AREA" id="ID_AREA">
					<option value="">ALL AREA</option>
				</select>
              </div>
            </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a type="button" class="btn btn-danger" href="<?php echo site_url("user");?>" >Cancel</a>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->

<!-- Additional CSS -->
<link href="<?php echo base_url("plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/EasyAutocomplete-1.3.5/easy-autocomplete.themes.min.css");?>" rel="stylesheet">

<!-- Additional JS-->
<script src="<?php echo base_url("plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js");?>"/></script>

<script language="javascript" type="text/javascript">
$(function(){

	$("#ID_USERGROUP").change(function(){
		//if(this.value != '1' && this.value != '2' ){
		if(this.value != '1'){
			$("#div_company").css("display","");
			$("#div_plant").css("display","");
			$("#div_area").css("display","");
		}
		else{
			$("#div_company").css("display","none");
			$("#div_plant").css("display","none");
			$("#div_area").css("display","none");
			$("#ID_COMPANY").val(0);
		}
		$("#ID_COMPANY").change();
	});

	$("#ID_COMPANY").change(function(){
		$("#ID_PLANT").empty();
		var url = "<?php echo site_url("plant/json_plant_list/") ?>"+this.value;
		$.getJSON(url,function(data){
			$("#ID_PLANT").empty();
			$("#ID_PLANT").append("<option value=''>ALL PLANT</option>");
			data.forEach(function(r){
				$("#ID_PLANT").append("<option value='"+r.ID_PLANT+"'>"+r.NM_PLANT+"</option>");
			});
			$("#ID_PLANT").change();
		});
	});

	$("#ID_PLANT").change(function(){
		$("#ID_AREA").empty();
		var url = "<?php echo site_url("area/ajax_area_list/");?>"+this.value;
		$.getJSON(url,function(data){
			$("#ID_AREA").empty();
			$("#ID_AREA").append("<option value=''>ALL AREA</option>");
			data.forEach(function(r){
				$("#ID_AREA").append("<option value='"+r.ID_AREA+"'>"+r.NM_AREA+"</option>");
			});
		//	$("#ID_AREA").change();
		});
	});

	$("#ID_USERGROUP").change();

  /* Auto Complete */
  var options = {
    url: function(username) {
      return '<?php echo site_url("user/get_username/") ?>';
    },

    getValue: function(element) {
      return element.mk_nama;
    },

    //Description
    template: {
      type: "description",
      fields: {
        description: "MK_CCTR_TEXT"
      }
    },

    //Set return data
    list: {
      onSelectItemEvent: function() {
        var selectedItemValue = $("#fullName").getSelectedItemData().USERNAME;
        $("#uName").val(selectedItemValue).trigger("change");
      }
    },

    ajaxSettings: {
      dataType: "json",
      method: "POST",
      data: {
        dataType: "json"
      }
    },

    //Sending post data
    preparePostData: function(data) {
      data.username = $("#fullName").val();
      return data;
    },
    theme: "plate-dark", //square | round | plate-dark | funky
    requestDelay: 400
  };

  $("#fullName").easyAutocomplete(options);

});
</script>
