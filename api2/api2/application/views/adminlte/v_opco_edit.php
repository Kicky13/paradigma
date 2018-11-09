<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Notify Reciever
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
          <form id="formData" method="POST" action="<?php echo site_url("opco/update/".$this->data_opco->ID_OPCO) ?>" >
            <div class="form-group row">
              <div class="form-group col-sm-12 col-sm-4">
                <label for="ID_COMPANY">GROUP NOTIFICATION</label>
               
                <select id="ID_JABATAN" name="ID_JABATAN" class="form-control select2">
                  <?php  foreach($this->list_jabatan as $jabatan): ?>
                    <option value="<?php echo $jabatan->ID_JABATAN;?>" <?php echo ($this->data_opco->ID_JABATAN == $jabatan->ID_JABATAN)?"SELECTED":"";?> ><?php echo $jabatan->NM_JABATAN;?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_COMPANY">&nbsp;&nbsp;</label><br />
                <input type=checkbox name=TEMBUSAN value=1 <?php echo ($this->data_opco->TEMBUSAN)?"CHECKED":""; ?> /> SEND AS A COPY LETTER
              </div>
              
            </div>
            
            <div class="form-group row">
              <div class="form-group col-sm-12 col-sm-4">
                <label for="ID_COMPANY">COMPANY</label>
                <?php if($this->USER->ID_COMPANY): ?>
                <input type=text value="<?php echo $this->USER->NM_COMPANY ?>" class="form-control" readonly />
                <input type=hidden id="ID_COMPANY"  value="<?php echo $this->USER->ID_COMPANY ?>" class="form-control" readonly />
                <?php else: ?>
                <select id="ID_COMPANY" class="form-control select2">
                  <?php  foreach($this->list_company as $company): ?>
                    <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->data_opco->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                  <?php endforeach; ?>
                </select>
                <?php endif; ?>
              </div>
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_COMPANY">PLANT</label>
                <?php if($this->USER->ID_PLANT): ?>
                <input type=text value="<?php echo $this->USER->NM_PLANT ?>" class="form-control" readonly />
                <input type=hidden id="ID_PLANT" value="<?php echo $this->USER->ID_PLANT ?>" class="form-control" readonly />
                <?php else: ?>
                <select id="ID_PLANT"  class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>
            </div>

            <div class="form-group row">
              <div class="form-group col-sm-12 col-sm-4">
                <label for="ID_COMPANY">GROUP AREA</label>
                <?php if($this->USER->ID_GROUPAREA): ?>
                <input type=text value="<?php echo $this->USER->NM_GROUPAREA ?>" class="form-control" readonly />
                <input type=hidden id="ID_GROUPAREA" value="<?php echo $this->USER->ID_GROUPAREA ?>" class="form-control" readonly />
                <?php else: ?>
                <select id="ID_GROUPAREA"  class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_AREA">AREA</label>
                <?php if($this->USER->ID_AREA): ?>
                <input type=text value="<?php echo $this->USER->NM_AREA ?>" class="form-control" readonly />
                <input type=hidden id="ID_AREA" NAME="ID_AREA" value="<?php echo $this->USER->ID_AREA ?>" class="form-control" readonly />
                <?php else: ?>
                <select id="ID_AREA" name="ID_AREA" class="form-control select2">
                  <option value="">Please wait...</option>
                </select>
                <?php endif; ?>
              </div>

            </div>
				
			 <div class="form-group row">
              <div class="form-group col-sm-12 col-sm-4">
                <label for="ID_COMPANY">FULLNAME</label>
                
                <input id="fullName" type=text value="<?php echo $this->data_opco->FULLNAME ?>" NAME="FULLNAME" class="form-control"  required  />
                
              </div>
              <div class="form-group col-sm-6 col-sm-4">
                <label for="ID_AREA">EMAIL</label>
               
                <input id="eMail" type=text value="<?php echo $this->data_opco->EMAIL ?>" NAME="EMAIL" class="form-control"  required />
               
              </div>

            </div>
            
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
              
          </form>
          
          
			
        </div>
        
         <div class="box">
        <!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
              <table class="table-fixed table-hover">
					<thead>
						<tr><th>NO.</th><th>NOTIFICATION GROUP</th><th>COMPANY</th><th>PLANT</th><th>AREA</th><th>NAME</th><th>EMAIL</th><TH>SEND AS</TH></tr>
					</thead>
					<tbody id="body_conf">
						<tr><td colspan=8><img src="<?php echo base_url("images/hourglass.gif");?>"> Please wait...</td></tr>
					</tbody>
				</table>

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

<!-- Additional CSS -->
<link href="<?php echo base_url("plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/EasyAutocomplete-1.3.5/easy-autocomplete.themes.min.css");?>" rel="stylesheet">

<!-- Additional JS-->
<script src="<?php echo base_url("plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js");?>"/></script> 
<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>

<script>
  $(document).ready(function(){
   
    $("#ID_COMPANY").change(function(){
      var company = $(this).val(), plant = $('#ID_PLANT');
      $.getJSON('<?php echo site_url("opco/ajax_get_plant/");?>' + company, function (result) {
        var values = result;
        
        plant.find('option').remove();
        if (values != undefined && values.length > 0) {
          plant.css("display","");
          $('#ID_GROUPAREA').css("display","");
          $(values).each(function(index, element) {
            plant.append("<OPTION value='"+element.ID_PLANT+"' "+((element.ID_PLANT==<?php echo $this->data_opco->ID_PLANT ?>)?"selected":"")+"  >"+element.NM_PLANT+"</OPTION>");
          });
          
        }else{
          plant.find('option').remove();
          plant.append($("<option></option>").attr("value", '00').text("NO PLANT"));
        }
      $("#ID_PLANT").change();
      });
    });

    $("#ID_PLANT").change(function(){
      var plant = $(this).val(), grouparea = $('#ID_GROUPAREA');
      $.getJSON('<?php echo site_url("opco/ajax_get_grouparea/");?>' + $("#ID_COMPANY").val() + '/' + plant, function (result) {
        var values = result;
        
        grouparea.find('option').remove();
        if (values != undefined && values.length > 0) {
          grouparea.css("display","");
          $(values).each(function(index, element) {
            if(!$("#ID_GROUPAREA option[value='"+element.ID_GROUPAREA+"']").length > 0){
              grouparea.append("<OPTION value='"+element.ID_GROUPAREA+"' "+((element.ID_GROUPAREA==<?php echo $this->data_opco->ID_GROUPAREA ?>)?"selected":"")+"  >"+element.NM_GROUPAREA+"</OPTION>");
            }
          });
        }else{
          grouparea.find('option').remove();
          grouparea.append($("<option></option>").attr("value", '00').text("NO GROUP AREA"));
        }
        $("#ID_GROUPAREA").change();
      });
    });

    $("#ID_GROUPAREA").change(function(){
      var grouparea = $(this).val(), area = $('#ID_AREA');
      $.getJSON('<?php echo site_url("opco/ajax_get_area/");?>' + $("#ID_COMPANY").val() + '/' + $("#ID_PLANT").val() + '/' + grouparea, function (result) {
        var values = result;
        
        area.find('option').remove();
        if (values != undefined && values.length > 0) {
          area.css("display","");
          $(values).each(function(index, element) {
            area.append("<OPTION value='"+element.ID_AREA+"' "+((element.ID_AREA==<?php echo $this->data_opco->ID_AREA ?>)?"selected":"")+"  >"+element.NM_AREA+"</OPTION>");
          });
        }else{
          area.find('option').remove();
          area.append($("<option></option>").attr("value", '00').text("NO AREA"));
        }
        $("#ID_AREA").change();
      });
    });

	$("#ID_AREA").change(function(){
		$("#body_conf").html("<tr><td colspan=8><img src='<?php echo base_url("images/hourglass.gif");?>'> Please wait...</td></tr>");
		$.getJSON("<?php echo site_url("opco/notification_member") ?>/"+this.value+"/"+$("#ID_JABATAN").val(),function(data){
			$("#body_conf").empty();
			if(data.length == 0){
				$("#body_conf").append("<tr><td colspan=8>There is no opco was added.</td></tr>");
			}
			else{
				var x=1;
				$.each(data,function(key,r){
					var tr = null;
					tr += "<tr>"; 
					tr += "<td align=center>"+(x++)+"</td>";
					tr += "<td>"+r.NM_JABATAN+"</td>";
					tr += "<td>"+r.NM_COMPANY+"</td>";
					tr += "<td>"+r.NM_PLANT+"</td>";
					tr += "<td>"+r.NM_AREA+"</td>";
					tr += "<td>"+r.FULLNAME+"</td>";
					tr += "<td>"+r.EMAIL+"</td>";					
					tr += "<td>"+((r.TEMBUSAN)?"NOTIFICATION":"MAIL COPY")+"</td>";
					tr +="</tr>";
					$("#body_conf").append(tr);
				});
			}
			
		});
	});
	
	$("#ID_JABATAN").change(function(){
		$("#ID_AREA").change();
	});

  $("#ID_COMPANY").change();

  /* Auto Complete */
  var options = {
    url: function(username) {
      return '<?php echo site_url("opco/get_username/") ?>';
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
        var selectedItemValue = $("#fullName").getSelectedItemData().mk_email;
        $("#eMail").val(selectedItemValue).trigger("change");
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
