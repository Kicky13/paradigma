<html>
<head>
<title>Manage User</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/waitMe.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/waitMe.min.js"/></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" ></script>
<script src="<?php echo base_url(); ?>assets/js/notify.min.js"/></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    function load(){
        // $('#dataTable').DataTable();
    
    }
</script>
<style>


/*.fixed_headers {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
  }
  
  td:nth-child(1), th:nth-child(1) { min-width: 90px; }
  td:nth-child(2), th:nth-child(2) { min-width: 90px; }
  td:nth-child(3), th:nth-child(3) { min-width: 90px; }
  td:nth-child(4), th:nth-child(4) { min-width: 90px; }
  td:nth-child(5), th:nth-child(4) { min-width: 90px; }
  td:nth-child(6), th:nth-child(4) { min-width: 90px; }
  td:nth-child(7), th:nth-child(4) { min-width: 90px; }
  td:nth-child(8), th:nth-child(4) { min-width: 90px; }
  td:nth-child(9), th:nth-child(4) { min-width: 90px; }
  td:nth-child(10), th:nth-child(4) { min-width: 90px; }
  td:nth-child(11), th:nth-child(4) { min-width: 90px; }
  td:nth-child(12), th:nth-child(4) { min-width: 90px; }
  td:nth-child(13), th:nth-child(4) { min-width: 90px; }
  td:nth-child(14), th:nth-child(4) { min-width: 90px; }
  td:nth-child(15), th:nth-child(4) { min-width: 90px; }

  thead {
    tr {
      display: block;
      position: relative;
    }
  }
  tbody {
    display: block;
    overflow: auto;
    width: 901%;
    tr:nth-child(even) {
    }
  }
}

.old_ie_wrapper {
    width: 100%;
  overflow-x: hidden;
  overflow-y: auto;
  tbody { height: auto; }
}*/
table
{
    /*width: 500px;*/
    border-collapse: collapse;
}

thead
{
    display: block;
    /*width: 500px;*/
    overflow: auto;
    color: #fff;
    /*background: #000;*/
}

tbody
{
    display: block;
    width: 100%;
    height: 200px;
    /*background: pink;*/
    overflow: auto;
}

tbody td, thead th
{
    width: 50px !important;
}

tbody td:nth-child(1), thead th:nth-child(1)
{
    width: 150px !important; 
}

tbody td:nth-child(2), thead th:nth-child(2)
{
    width: 200px !important;
}

tbody td:nth-child(3), thead th:nth-child(3), tbody td:nth-child(4), thead th:nth-child(4), tbody td:nth-child(5), thead th:nth-child(5)
{
    width: 100px !important;
    text-align: center;
}

tbody td:last-child
{
    white-space: nowrap;
}
tbody td:last-child button
{
    margin:0 2px;
}

th,td
{
    padding: .5em 1em;
    /*text-align: left;*/
    vertical-align: top;
    border-left: 1px solid #fff;
}
th{background-color: grey;}
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

.search_result th{
    color:#fff;
    padding-bottom:5px !important;
}
#DivKaryawan table tbody{height:504px !important;}
#visit_par4digma li, #visit_eis li, #ol_par4digma li, #ol_eis li{font-size:12px;margin-bottom:5px;}
</style>    
</head>
<body onLoad="load()">
<div class="row" style="padding: 0px; margin: 0px;">
    <div class="col-md-12">
        <div class="col-md-6">
            <img src="<?php echo base_url(); ?>assets/img/pp.jpg" alt="PAR4DIGMA" style="float: left; width: 50px; padding-top: 9px; padding-bottom: 9px;">
            <div><h3 style="font-weight: bold; font-style: italic;">&nbsp;MANAGE PAR4DIGMA &amp; EIS USER</h3></div>
        </div>
        <div class="col-md-6">
            <button type="button" id="btn_logout" class="btn btn-danger" style="float: right; margin: 10px;">LOGOUT</button>
          <!--   <a href="<?= base_url('index.php/c_role')?>" id="btn_role" class="btn btn-warning" style="float: right; margin: 10px;">ROLE USER</a> -->
        </div>
    </div>
</div>
<div class="row" style="padding: 0px; margin: 0px; max-height: 600px;">
    <div class="col-md-12">
         <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><div class="panel-title">Online User</div></div>
                <div class="panel-body">
                    <div class="col-md-6" style="border-right:1px solid #ddd;border-box:0">
                        <h1 style="font-size:20px;">Par4digma</h1>
                        <ul style="padding-left: 17px;" id="ol_par4digma"></ul>
                    </div>
                    <div class="col-md-6">
                        <h1 style="font-size:20px;">EIS</h1>
                        <ul style="padding-left: 17px;" id="ol_eis"></ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><div class="panel-title">Most Visitor</div></div>
                <div class="panel-body">
                    <div class="col-md-6" style="border-right:1px solid #ddd;border-box:0">
                        <h1 style="font-size:20px;">Par4digma</h1>
                        <ul style="padding-left: 17px;" id="visit_par4digma"></ul>
                    </div>
                    <div class="col-md-6">
                        <h1 style="font-size:20px;">EIS</h1>
                        <ul style="padding-left: 17px;" id="visit_eis"></ul>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><div class="panel-title">Search User</div></div>
                <div class="panel-body">
                    <input id="namaPegawai" type="text" name="input[nama]" class="form-control" style="margin-bottom:10px; input {text-transform: lowercase;}" placeholder="Search with employee name" onkeypress = "search_namaPegawai(this.value);">
                    <input id="noPegawai" type="text" name="input[nopeg]" class="form-control" placeholder="Search with employee number" onkeypress = "search_noPegawai(this.value);">
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div id="search_emp" class="panel panel-default" style="min-height:153px;">
                <div class="panel-heading"><div class="panel-title">Search Result</div></div>
                <span id="loading" style="display:none;"><i  class="fa fa-cog fa-spin fa-5x fa-fw" ></i>Loading data...</span>
                <div id="DivKaryawan" style="width:100%;overflow-x:auto;overflow-y:hidden;"><h1 class="blink_me" style="text-align: center;">Search result will be appeared here</h1></div>               
            </div>
        </div>
    </div>
    <hr style="width: 100%; size: 50px; color: red;">
        <div class="col-md-12">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><div class="panel-title">Search User</div></div>
                <div class="panel-body">
                    <div class="col-md-6">
                         <input id="tagNAME" type="text" name="input[nama]" class="form-control" style="input {text-transform: lowercase;}" placeholder="Search with employee name" >
                    </div>

                    <div class="col-md-4">
                         <input id="tagNOPEG" type="text" name="input[nopeg]" class="form-control" placeholder="Search with employee number">
                    </div>
        
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary" onclick="search_Pegawai()">Search</button>
                    </div>
                       
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading"><div class="panel-title">Add New MENU (index.html)</div></div>
                <div class="panel-body">
                    <div class="col-xs-4 col-md-">
                         <input id="colName" type="text" name="colName" class="form-control" style="input {text-transform: uppercase;}" placeholder="column name" >
                    </div>  

                    <div class="col-xs-3 col-md-3">
                         <select name="defValue" id="defValue" class="form-control">
                            <option value="1">Enable All</option>
                            <option value="0">Disable All</option>
                         </select>
                    </div>
        
                    <div class="col-xs-2 col-md-2 col-sm-offset-1 col-md-offset-1">
                        <button type="button" class="btn btn-success btn-block" onclick="addColumn()">Add</button>
                    </div>
                    <div class="col-xs-2 col-md-2">
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target=".bs-example-modal-sm">Del</button>
                    </div>
                       
                </div>
            </div>
        </div>

       
       <!--  <div class="col-md-12">
            <div class="panel panel-default" style="height:385px;overflow-x:auto;">
                <div class="panel-heading"><div class="panel-title">Registered User :&nbsp;<span style="font-weight: bolder;" id="hitung"></span>&nbsp;<span>Employee (Include <span id="sisi"></span> SISI employee)</span></div></div>
                <div class="panel-body">
                    <table class="table table-bordered" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>User Name</th>
                                <th>Nopeg</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="user_terdaftar">
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->
        <div  class="col-md-12" >
        <div class="panel panel-default" >
            <div class="panel-heading">
            <div class="panel-title">Registered User :&nbsp;<span style="font-weight: bolder;" id="hitung"></span>&nbsp;<span>Employee (Include <span id="sisi"></span> SISI employee)</span></div>           
            </div>
            <div class="panel-body" >
                 <!-- <table id="headTable" class="table table-bordered" style="font-size:12px;margin-left: 14px;"></table> -->
                <div class="col-md-12" style="height: 500px; overflow: auto;">
                <!-- style="height: 400px; overflow-x: auto;" -->
                     <table id="dataTable" class="table table-hover table-striped" style="font-size:12px;">
                 </table>
                </div>
                
               
            <!-- <table id="headTable" class="table table-bordered scroll" style="font-size:12px;"></table> -->

           
            </div>
        </div>

            <!-- Modal -->
    </div>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">List Menu</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Choose Menu .</label>
            <select id="drop_column">
                <option value="">-------</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="dropColumn()">Save changes</button>
      </div>
    </div>
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

    function showModal(data){
        console.log('showmodal', data);
        $("#myModal .modal-title").html(data)
        $("#myModal").modal();
    }
    $(function () {
        $('#user_terdaftar').load("<?php echo site_url('c_admin/GetKaryawanTerdaftar'); ?>");
    });
    run_waitMe('search_emp', 'ios');
    function search_noPegawai(data) {
        var total = $('#noPegawai').val().length;
        if (total > 2 && total < 5) {
            var nama = '%' + $('#namaPegawai').val() + '%';
            $('#loading').show();
            var nopeg = '%' + data + '%';
            $.ajax({
                url: 'c_admin/GetKaryawan',
                type: 'POST',
                data: {'input[nopeg]': nopeg, 'input[nama]': nama},
                async: false,
                success: function (data) {
                    $('#DivKaryawan').html(data);
                    $('#loading').hide();
                }
            });
        }
        stop_waitMe('search_emp');
    }
    run_waitMe('search_emp', 'ios');
    function search_namaPegawai(data) {
        var total = $('#namaPegawai').val().length;
        if (total > 3 && total < 10) {
            var nopeg = '%' + $('#noPegawai').val() + '%';
            $('#loading').show();
            var nama = '%' + data + '%';
            $.ajax({
                url: 'c_admin/GetKaryawan',
                type: 'POST',
                data: {'input[nama]': nama, 'input[nopeg]': nopeg},
                async: false,
                success: function (data) {
                    $('#DivKaryawan').html(data);
                    $('#loading').hide();
                }
            });
        }
        stop_waitMe('search_emp');
    }

    function load_toform(seq) {
        // $('#loading').show();
        var a = $('#a' + seq).html();
        var b = $('#b' + seq).html();
        var c = $('#c' + seq).html();
        var d = $('#d' + seq).html();
        var e = $('#e' + seq).html();
        var f = $('#f' + seq).html();
        var g = $('#g' + seq).html();

        $.ajax({
            url: 'c_admin/SimpanUser',
            type: 'POST',
            data: {
                nopeg: a,
                nama: b,
                email: c,
                eselon: d,
                opco: e,
                jabatan: f,
                menu: g
            },
            async: false,
            success: function (data) {
                console.log(data);
                $('#user_terdaftar').load("<?php echo site_url('c_admin/GetKaryawanTerdaftar'); ?>");
                // $('#loading').hide();
                $('#button' + seq).removeClass('btn btn-warning');
                $('#button' + seq).addClass('btn btn-success');
                $.notify('user added.',  { globalPosition: 'top center' })
            }
        });

    }

    $(function () {
        // run_waitMe('#list', 'bounce');
        loadData();
        $.ajax({
            url: 'c_role/GetActiveUser',
            type: 'get',
            async: false,
            success: function (data) {
               // console.log(data);
               var dataJson = JSON.parse(data);
                
                var par4digma1 = dataJson.active_user.PAR4DIGMA;
                var eis1 = dataJson.active_user.BOD;
                var ol_par="";
                var ol_eis="";
                for(var i=0;i<par4digma1.length;i++){
                    ol_par+="<li>"+par4digma1[i].NAME+"</li>"
                }
                for(var i=0;i<eis1.length;i++){
                    ol_eis+="<li>"+eis1[i].NAME+"</li>"
                }
                $('#ol_par4digma').html(ol_par);
                $('#ol_eis').html(ol_eis);

                var par4digma2 = dataJson.most_visitor.PAR4DIGMA;
                var eis2 = dataJson.most_visitor.BOD;
                var visit_par="";
                var visit_eis="";
                for(var i=0;i<par4digma2.length;i++){
                    visit_par+="<li>"+par4digma2[i].NAME+" - "+par4digma2[i].TOTAL+"</li>"
                }
                for(var i=0;i<eis2.length;i++){
                    visit_eis+="<li>"+eis2[i].NAME+" - "+eis2[i].TOTAL+"</li>"
                }
                $('#visit_par4digma').html(visit_par);
                $('#visit_eis').html(visit_eis);

            }
        });
        $.ajax({
            url: 'c_role/roleList',
            type: 'get',
            async: false,
            success: function (data) {
               // console.log(data);
               var dataJson = JSON.parse(data);

               $.each(dataJson, function(index, el) {
                $('#drop_column').append('<option value="'+el+'">'+el+'</option>');
               });

            }
        });

    });

    function saveClick(no, name){
        console.log(name);
        var checkedVal = [];
        var searchName = $('#tagNAME').val();
        var searchNopeg = $('#tagNOPEG').val(); 
        var unlockVal = ($('#unlock'+no).is(':checked'))?'1':'0';
       
        checkedVal.push(name);
        // checkedVal.push(unlockVal);
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
                    if (result['status']=='success') {

                        if (searchName || searchNopeg) {
                            search_Pegawai()
                        }else{
                            loadData();
                        }
                        $.notify('save success',  { globalPosition: 'top center' })
                    }else{
                        $.notify('save fail',  { globalPosition: 'top center' })
                    
                    }
                    
                }
            });
        }
    }

    function addColumn(){
        var name = $('#colName').val();
        var val = $('#defValue').val();
        if (confirm("Do You want to add new menu !!!")) {
            $.ajax({
            url: 'c_role/newColumn',
            type: 'post',
            data: {'name': name, 'value': val},
            async: false,
            success: function (data) {
               // console.log(data);
               var dataJson = JSON.parse(data);

                location.reload();

            }
        });
        }
    }

    function dropColumn(){
        var name = $('#drop_column').val();
        if (confirm("Do You want to add new menu !!!")) {
            $.ajax({
            url: 'c_role/dropColumn',
            type: 'post',
            data: {'name': name},
            async: false,
            success: function (data) {
               // console.log(data);
               var dataJson = JSON.parse(data);

                location.reload();

            }
        });
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
               var thead = "<t"+tag+" >";
               
               $.each(dataJson, function(index, el){
                    // $('#header').append("<th align=\"center\">"+el+"</th>");
                    var width = '20px; ';
                    if (el=='USERNAME') {
                        width = '124px;';
                    }
                    if (el=='NAME') {
                        width = '253px;';
                    }
                    // if (el=='PRODUCTION') {
                    //     el = 'PRD';
                    // }
                    if (el=='CAPEX') {
                        el = 'CPX';
                    }
                    if (el=='SALES') {
                        el = 'SLS';
                    }
                    if (el=='FINANCE') {
                        el = 'FNC';
                    }
                    if (el=='PROJECT') {
                        el = 'PRJ';
                    }
                    if (el=='INVENTORY') {
                        el = 'INVT';
                    }
                    if (el=='MAINTENANCE') {
                        el = 'MNT';
                    }
                    if (el=='TRESURI') {
                        el = 'TRS';
                    }
                    if (el=='QUALITY') {
                        el = 'QTY';
                    }
                   
                    if (index >2){
                            if ((index%=2)==0) {
                                thead += "<th style=' width:"+width+";' align=\"center\">"+el+"</th>";
        
                            }else{
                                thead += "<th style=' width: "+width+" ; ' align=\"center\">"+el+"</th>";
                            }
                        }else{
                            thead += "<th style=' width: "+width+" ; ' align=\"center\">"+el+"</th>";
                        }
                   
               })
               thead += "</t"+tag+">";
               $('#headTable').append(thead);
               $('#dataTable').append(thead);
               // $('#footTable').append(thead);
              
            }
        });
    }

    function add(dataJson){
            $('#dataTable').empty();
            $('#headTable').empty();
            addHeader('head');
            
            var no = 0;
            var string_append = '<tbody style="height: 400px; overflow-x: auto;" >';
            $.each(dataJson, function(index, el){
                var nopeg = (el.NOPEG==null)?"-":el.NOPEG;
                var checked = (el.UNLOCK=='1')? 'checked':'';
                console.log('typeof'+(typeof checked)+'=>'+checked);
                string_append += " <tr id='index"+no+"'><td>"+el.USERNAME+"</td><td>"+el.NAME+"</td><td>"+ nopeg +"</td><td align='center' style='width:78px;'><input id='unlock"+no+"' type='checkbox' "+checked+"></td>";
                var dataCheck = el.val;
                // dataCheck.pop();
                // string_append = string_append + '<form id="'++'">'
                var testCheck = 4;
                $.each(dataCheck, function(index, value){
                    var checked = (value=='1')? 'checked':'';
                    var checkedVal = (value=='1')? '':'0';

                    if (index!='USERNAME') {
                        if ((testCheck%=2)!=0) {
                            string_append += "<td style='background-color: #eef0f1;width:43px;' align='center' ><input id='"+index+no+"' type='checkbox' "+checked+"></td>";
                        }else{
                            string_append += "<td align='center' style='width:43px;'><input id='"+index+no+"' type='checkbox' "+checked+"></td>";
                        }
                       
                    }

                    testCheck ++;
                   
                    
                });
                string_append += "<td align='center'><button onclick='saveClick(\""+no+"\", \""+el.USERNAME+"\")' id='"+el.USERNAME+"' type='button' class='btn btn-primary'><i class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></i></button><button type='button' class='btn btn-danger' onclick='delete_list(\""+el.USERNAME+"\")'><i class='fa fa-times' aria-hidden='true'></i></button></td> </tr>";

                // $('#list_karyawan').append(string_append);
                no++;

           });
            string_append += '</tbody>';
            $('#dataTable').append(string_append)
            // addHeader('foot');

    }



    function delete_list(seq) {
        // $('#loading').show();
        if(confirm('Are you sure delete '+seq +'!!!')){
                $.ajax({
                    url: 'c_admin/HapusUser',
                    type: 'POST',
                    data: {ldapname: seq},
                    async: false,
                    success: function (data) {
                        search_Pegawai();
                        $.notify('user deleted.',  { globalPosition: 'top center' })
                    }
                });
            }
    }
    $(function () {
        $('#btn_logout').click(function () {
            window.location.href = '<?php echo base_url(); ?>index.php/ldap_access/logout';
        });

    });

    $.ajax({
        url: 'http://par4digma.semenindonesia.com/api/index.php/c_admin/HitungKaryawanTerdaftar',
        type: 'GET',
        success: function (data) {
            var dataJson = JSON.parse(data);
            $("#hitung").html(dataJson);
        }
    }).done(function (data) {
    }).fail(function () {

    });

    $.ajax({
        url: 'http://par4digma.semenindonesia.com/api/index.php/c_admin/HitungSISITerdaftar',
        type: 'GET',
        success: function (data) {
            var dataJson = JSON.parse(data);
            $("#sisi").html(dataJson);
        }
    }).done(function (data) {
    }).fail(function () {

    });
</script>
</body>
</html>
