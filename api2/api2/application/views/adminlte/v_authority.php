   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Authority Configuration
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
				<div class="form-group">
				  <select id="ID_USERGROUP" class="form-control select2">
					<?php  foreach($this->list_usergroup as $usergroup): ?>
					  <option value="<?php echo $usergroup->ID_USERGROUP;?>" ><?php echo $usergroup->NM_USERGROUP;?></option>
					<?php endforeach; ?>
				  </select>
				</div>
				<div class="form-group">
				  <select id="ID_GROUPMENU" class="form-control select2">
					  <OPTION VALUE="">ALL MENU</OPTION>
					<?php  foreach($this->list_groupmenu as $groupmenu): ?>
					  <option value="<?php echo $groupmenu->ID_GROUPMENU;?>" ><?php echo $groupmenu->NM_GROUPMENU;?></option>
					<?php endforeach; ?>
				  </select>
				</div>
			  </form>
			</div>
			</td></tr>
            <!-- /.box-header -->
            <tr><td>
            <div class="box-body table-responsive no-padding">
              <table class="table-fixed table-hover">
                <tr>
                  <th>No</th>
                  <th>Menu Name</th>
                  <th align=center style="text-align: center">Authorized</th>
                </tr>
                <?php $x=1; foreach($this->list_menu as $menu): ?>
                <tr class="trcauth authtr-<?php echo $menu->ID_MENU ?>" id_menu="<?php echo $menu->ID_MENU ?>"  id_groupmenu="<?php echo $menu->ID_GROUPMENU ?>"  >
                  <td class="tdauth-<?php echo $menu->ID_MENU ?>"><?php echo $x++; ?></td>
                  <td><?php echo $menu->NM_MENU ?></td>
                  <td align=center><input type="checkbox" name="auth[<?php echo $menu->ID_MENU ?>]" value="<?php echo $menu->ID_MENU ?>" class="cauth" <?php echo (!$this->PERM_WRITE)?"READONLY DISABLED":""; ?> /></td>
                </tr>
                <?php endforeach; ?>
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
	
<script language="javascript" type="text/javascript" src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>

<script>

$(document).ready(function(){
	$(".delete").confirm({ 
		confirmButton: "Remove",
		cancelButton: "Cancel",
		confirmButtonClass: "btn-danger"
	});
	<?php if($this->PERM_WRITE): ?>
	$(".cauth").click(function(){
		$.get("<?php echo site_url("authority"); ?>/"+((this.checked)?"auth":"deauth")+"/"+$("#ID_USERGROUP").val()+"/"+this.value);
	});
	<?php endif; ?>
	$("#ID_USERGROUP").change(function(){
		var url = "<?php echo site_url("authority/authlist/") ?>"+this.value;
		$.getJSON(url,function(data){
			var authorized = [];
			
			data.forEach(function(r){
				authorized.push(r.ID_MENU);
			});
			
			var menu = $(".cauth");
			for(i=0; i < menu.length; i++){
				$(menu[i]).prop("checked",(($.inArray(menu[i].value,authorized)>-1)?true:false));
			}
		});
	});
	
	$("#ID_USERGROUP").change();
	
	
	$("#ID_GROUPMENU").change(function(){
		var trmenu = $(".trcauth");
		var id_groupmenu = this.value;
		var tdnumber = 1;	
		for(i=0; i < trmenu.length; i++){
			var display = ($(trmenu[i]).attr("id_groupmenu") == id_groupmenu)?"":"none";
			if(id_groupmenu == "") display = "";
			$(trmenu[i]).css("display",display);
			if(display == ""){
				var tdauth = ".tdauth-"+$(trmenu[i]).attr("id_menu");
				$(tdauth).html(tdnumber);
				tdnumber++;
			}
		}
	});

});
</script>
