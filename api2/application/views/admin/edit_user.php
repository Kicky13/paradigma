<title>Manage User</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/waitMe.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/waitMe.min.js"/></script>

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
<div class="row" style="padding: 0px; margin: 0px;">
    <div class="col-md-12">
        <div class="col-md-6">
            <img src="<?php echo base_url(); ?>assets/img/pp.jpg" alt="PAR4DIGMA" style="float: left; width: 50px; padding-top: 9px; padding-bottom: 9px;">
            <div><h3 style="font-weight: bold; font-style: italic;">&nbsp;MANAGE PAR4DIGMA USER</h3></div>
        </div>
        <div class="col-md-6">
            <button type="button" id="btn_logout" class="btn btn-danger" style="float: right; margin: 10px;">LOGOUT</button>
        </div>
    </div>
</div>
<div class="row" style="padding: 0px; margin: 0px; max-height: 600px;">
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><div class="panel-title">Search User</div></div>
                <div class="panel-body">
                    <input id="namaPegawai" type="text" name="input[nama]"class="form-control" placeholder="Search with employee name, then hit Enter" onkeypress = "search_namaPegawai(this.value);">
                    <input id="noPegawai" type="text" name="input[nopeg]"class="form-control" placeholder="Search with employee number, then hit Enter" onkeypress = "search_noPegawai(this.value);">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default" style="height:385px;overflow-x:auto;">
                <div class="panel-heading"><div class="panel-title">Registered User :&nbsp;<span style="font-weight: bolder;" id="hitung"></span>&nbsp;<span>Employee (Exclude 3 SISI employee)</span></div></div>
                <div class="panel-body">
                    <table class="table table-bordered" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>User Name</th>
                                <th>Nopeg</th>
                                <th>Email</th>
                                <th>Delete?</th>
                            </tr>
                        </thead>
                        <tbody id="user_terdaftar">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
            <div id="search_emp" class="panel panel-default" style="height:550px;overflow-x:auto;">
                <div class="panel-heading"><div class="panel-title">Search Result</div></div>
                <span id="loading" style="display:none;"><i  class="fa fa-cog fa-spin fa-5x fa-fw" ></i>Loading data...</span>
                <div id="DivKaryawan"><h1 class="blink_me" style="text-align: center;">Search result will be appeared here</h1></div>               
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
        $('#loading').show();
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
                $('#user_terdaftar').load("<?php echo site_url('c_admin/GetKaryawanTerdaftar'); ?>");
                $('#loading').hide();
                $('#button' + seq).removeClass('btn btn-warning');
                $('#button' + seq).addClass('btn btn-success');
            }
        });

    }

    function delete_list(seq) {
        $('#loading').show();
        $.ajax({
            url: 'c_admin/HapusUser',
            type: 'POST',
            data: {ldapname: seq},
            async: false,
            success: function (data) {
                $('#user_terdaftar').load("<?php echo site_url('c_admin/GetKaryawanTerdaftar'); ?>");
                $('#loading').hide();
            }
        });
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
</script>
