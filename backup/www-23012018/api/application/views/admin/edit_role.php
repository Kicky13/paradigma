<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
   <title>Manage User</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/waitMe.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/waitMe.min.js"/></script>
<script src="<?php echo base_url(); ?>assets/js/notify.min.js"/></script>

<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" ></script>

<style>
    .textmenu{
        font-size:10px;
    }
    .btnmenu {
        min-width: 150px;
        max-width: 150px;
    }
    .blink_me {
        animation: blinker 1s linear infinite;
    }
    @keyframes blinker {  
        50% { opacity: 0; }
    }
</style>	
</head>
<body>
    

<div class="row" style="padding: 0px; margin: 0px;">
    <div class="col-xs-12 col-md-12">
        <div class="col-xs-6 col-md-6">
            <img src="<?php echo base_url(); ?>assets/img/pp.jpg" alt="PAR4DIGMA" style="float: left; width: 50px; padding-top: 9px; padding-bottom: 9px;">
            <div><h3 style="font-weight: bold; font-style: italic;">&nbsp;MANAGE PAR4DIGMA USER</h3></div>
        </div>
        <div class="col-xs-6 col-md-6">
            <button type="button" id="btn_logout" class="btn btn-danger" style="float: right; margin: 10px;">LOGOUT</button>
            <a href="<?= base_url('index.php/c_admin') ?>" id="btn_user" class="btn btn-success" style="float: right; margin: 10px;">MANAGE USER</a>
        </div>
    </div>
</div>
<div class="row" style="padding: 0px; margin: 0px; ">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><div class="panel-title">Search User</div></div>
            <div class="panel-body">
                <div class="col-md-6">
                     <input id="tagNAME" type="text" name="input[nama]"class="form-control" style="input {text-transform: lowercase;}" placeholder="Search with employee name" >
                </div>

                <div class="col-md-4">
                     <input id="tagNOPEG" type="text" name="input[nopeg]"class="form-control" placeholder="Search with employee number">
                </div>
    
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary" onclick="search_Pegawai()">Search</button>
                </div>
                   
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                Menu List
           </div>
           <div class="panel-body">
               <div class="col-md-4">
                     <input type="text" id="column_name" class="form-control" style="input {text-transform: uppercase;}" placeholder="Column Name" >
                </div>

                <div class="col-md-4">
                     <input  type="text" id="column_default" class="form-control" placeholder="default value" >
                </div>
                <div class="col-md-4 ">
                     <button type="button" class="btn btn-danger btn-block">add</button>
                </div>
           </div>
        </div>
    </div>
</div>
<div id="list" class="row" style="padding: 0px; margin: 0px; max-height: 600px;">
     <div  class="col-md-12" >
        <div class="panel panel-default" >
            <div class="panel-heading">
            <div class="panel-title">Registered User  </div>           
            </div>
            <div class="panel-body" style="height: 400px; overflow-x: auto">
                 <table id="dataTable" class="table table-bordered" style="font-size:12px;">
                        <!-- <thead id="header">
                            <th align="center">Nama</th>
                            <th align="center">Username</th>
                            <th align="center">Nopeg</th>
                            <th align="center">Production</th>
                            <th align="center">Sales</th>
                            <th align="center">SCM</th>
                            <th align="center">Finance</th>
                            <th align="center">Project</th>
                            <th align="center">Inventory</th>
                            <th align="center">Maintenance</th>
                            <th></th>
                        </thead> -->
                        <!-- <tbody id="list_karyawan" > -->
                           <!--  <tr>
                                <td>Bagus</td>
                                <td>bgs</td>
                                <td>13212</td>
                                <td align="center"><input type="checkbox" value=""></td>
                                <td align="center"><input type="checkbox" value=""></td>
                                <td align="center"><input type="checkbox" value=""></td>
                                <td align="center"><input type="checkbox" value=""></td>
                                <td align="center"><input type="checkbox" value=""></td>
                                <td align="center"><input type="checkbox" value=""></td>
                                <td align="center"><input type="checkbox" value=""></td>
                                <td align="center"><button type="button" class="btn btn-primary">save</button></td>
                            </tr> -->
                        <!-- </tbody> -->
                    </table>
            </div>
        </div>

            <!-- Modal -->
    </div>
</div>
<script>
    function run_waitMe(which, effect) {
        $(which).waitMe({
            //none, rotateplane, stretch, orbit, roundBounce, win8, 
            //win8_linear, ios, facebook, rotation, timer, pulse, 
            //progressBar, bouncePulse or img
            effect: effect,
            //place text under the effect (string).
            text: '',
            //background for container (string).
            bg: 'rgba(255,255,255,0.7)',
            //color for background animation and text (string).
            color: '#000',
            //change width for elem animation (string).
            sizeW: '',
            //change height for elem animation (string).
            sizeH: '',
            // url to image
            source: '',
            // callback
            onClose: function () {}
        });
    }
    function stop_waitMe(which) {
        $(which).waitMe('hide');
    }
    var head_menu = [];
    $(function () {
        // run_waitMe('#list', 'bounce');
        loadData();
    });

    function saveClick(no, name){
        console.log(name);
        var checkedVal = [];
        var searchName = $('#tagNAME').val();
        var searchNopeg = $('#tagNOPEG').val(); 
        checkedVal.push(name);
        $('#index'+no+':has(input)').each(function() {
           var row = this;
           $('input', this).each(function() {
                var val = ($(this).is(':checked'))?'1':'0';

                checkedVal.push(val);
           });

        });
        var data = [];
        if (confirm('Are you sure ?')) {
            console.log('confirm yes');
            $.ajax({
                url: 'c_role/updateRoles',
                type: 'POST',
                dataType: 'json',
                data : JSON.stringify(checkedVal),
                success: function (result) {
                    console.log(result);
                    if (result=='success') {

                        if (searchName || searchNopeg) {
                            search_Pegawai()
                        }else{
                            loadData();
                        }
                        
                    }

                    $.notify(result,  { globalPosition: 'top center' })
                }
            });
        }
    }

    function addColumn(){
        var name = $('#column_name').val();
        var nopeg = $('#column_default').val();
        if (confirm("Do You want to add new menu !!!")) {
            
        }
    }
   

    function loadData(nopeg=null, nama=null){
        run_waitMe('#list', 'bounce');
         $.ajax({
            url: 'c_role/getKaryawan',
            type: 'get',
            data: {'nopeg': nopeg, 'nama': nama},
            async: false,
            success: function (data) {
               // console.log(data);
               var dataJson = JSON.parse(data);

                add(dataJson);

               stop_waitMe('#list');

            }
        });
    }
    function search_Pegawai() {
        var total_name = $('#tagNAME').val().length;
        var total_nopeg = $('#tagNOPEG').val().length;
        // if ((total_name > 2 && total_name < 5) || (total_nopeg > 2 && total_nopeg < 5)) {
            var name = $('#tagNAME').val();
            var nopeg = $('#tagNOPEG').val();
            console.log(+'nopeg'+ nopeg+ 'nama'+ name)
            run_waitMe('#list', 'bounce');
            $.ajax({
                url: 'c_role/searchKaryawan',
                type: 'POST',
                data: {'nopeg': nopeg, 'nama': name},
                async: false,
                success: function (data) {
                   var dataJson = JSON.parse(data);

                    add(dataJson);

                   stop_waitMe('#list');
                }
            });
        // }
        stop_waitMe('#list');
    }

    function addHeader(tag){

          $.ajax({
            url: 'c_role/header',
            type: 'get',
            async: false,
            success: function (data) {
               // console.log(data);
               var dataJson = JSON.parse(data);
               var thead = "<t"+tag+">";
               $.each(dataJson, function(index, el){
                    // $('#header').append("<th align=\"center\">"+el+"</th>");
                    thead += "<th align=\"center\">"+el+"</th>";
               })
               thead += "</t"+tag+">";
               $('#dataTable').append(thead);
              
            }
        });
    }

    function add(dataJson){
            $('#dataTable').empty();
            addHeader('head');
            
            var no = 0;
            var string_append = '<tbody>';
            $.each(dataJson, function(index, el){
                var nopeg = (el.NOPEG==null)?"-":el.NOPEG;
                string_append += " <tr id='index"+no+"'><td>"+el.USERNAME+"</td><td>"+el.NAME+"</td><td>"+ nopeg +"</td>";
                var dataCheck = el.val;
                // dataCheck.pop();
                // string_append = string_append + '<form id="'++'">'
                $.each(dataCheck, function(index, value){
                    var checked = (value=='1')? 'checked':'';
                    var checkedVal = (value=='1')? '':'0';

                    if (index!='USERNAME') {
                        string_append += "<td align='center'><input id='"+index+no+"' type='checkbox' "+checked+"></td>";
                    }
                   
                    
                });
                string_append += "<td align='center'><button onclick='saveClick(\""+no+"\", \""+el.USERNAME+"\")' id='"+el.USERNAME+"' type='button' class='btn btn-primary'>save</button></td> </tr>";

                // $('#list_karyawan').append(string_append);
                no++;

           });
            string_append += '</tbody>';
            $('#dataTable').append(string_append)
            addHeader('foot');

    }

    $(function () {
        $('#btn_logout').click(function () {
            window.location.href = '<?php echo base_url(); ?>index.php/ldap_access/logout';
        });

    });


</script>
</body>
</html>