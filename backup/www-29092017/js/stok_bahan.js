var label = [];
var now = [];
var last = [];
var hei = '';
var judul ='';
var link = '';
function bahan_data(bulan, opco, yearnow, plant) {

    run_waitMe('.wrapper', 'ios');
    // bulan = bulan-1;
    // if(bulan<10) {
    //     bulan='0'+bulan
    // }
    // stop_waitMe('.wrapper');
    $.post(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        // $.post(url_src+'/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+param, function(data){

            
             // var dataJson = JSON.parse(data);

        var dataJson = paradigma.json_parse(data, '.wrapper');
        console.log(dataJson);
        console.log('Plsnt' + plant);


        // ############## NOW

        try{
            var ar_stok = Number(dataJson.last[1700].qty_stok);
            }catch(e){
             console.log('data error');
             stop_waitMe('.wrapper');
             alert('Sorry, data is empty, please choose another month');
            }

       // var ar_stok = Number(dataJson.act_stok[1700].stok);
		//var ar_stok = Number(dataJson.last[1700].qty_stok);
		var ar_stok = Number(dataJson.last[1700].qty_stok);
        var ar_ua = Number(dataJson.stok[1700].stok);
        var ar_din2 = Number(dataJson.stok[1700].stok);
        var ar_din = Math.ceil(ar_stok / ar_din2);
        var ar_min = Number(dataJson.maxmin[1700].min);
        var ar_max = Number(dataJson.maxmin[1700].max);
        var ar_rp = Number(dataJson.maxmin[1700].rp);
        var tgl = dataJson.last[1600].update;
		//var tgl = dataJson.last[1700].update;

        var bt_stok = Number(dataJson.last[1000].qty_stok); //1000
        var bt_ua = Number(dataJson.stok[1000].stok);
        var bt_din2 = Number(dataJson.stok[1000].stok);
        var bt_din = Math.ceil(bt_stok / bt_din2);
        var bt_min = Number(dataJson.maxmin[1000].min);
        var bt_max = Number(dataJson.maxmin[1000].max);
        var bt_rp = Number(dataJson.maxmin[1000].rp);

        var bb_stok = Number(dataJson.last[1600].qty_stok); //1600
        var bb_ua = Number(dataJson.stok[1600].stok);
        var bb_din2 = Number(dataJson.stok[1600].stok);
        var bb_din = Math.ceil(bb_stok / bb_din2);
        var bb_min = Number(dataJson.maxmin[1600].min);
        var bb_max = Number(dataJson.maxmin[1600].max);
        var bb_rp = Number(dataJson.maxmin[1600].rp);

        var cp_stok = Number(dataJson.last[1100].qty_stok);
        var cp_ua = Number(dataJson.stok[1100].stok);
        var cp_din2 = Number(dataJson.stok[1100].stok);
        var cp_din = Math.ceil(cp_stok / cp_din2);
        var cp_min = Number(dataJson.maxmin[1100].min);
        var cp_max = Number(dataJson.maxmin[1100].max);
        var cp_rp = Number(dataJson.maxmin[1100].rp);

        var gpg_stok = Number(dataJson.last[1400].qty_stok);
        var gpg_ua = Number(dataJson.stok[1400].stok);
        var gpg_din2 = Number(dataJson.stok[1400].stok);
        var gpg_din = Math.ceil(gpg_stok / gpg_din2);
        var gpg_min = Number(dataJson.maxmin[1400].min);
        var gpg_max = Number(dataJson.maxmin[1400].max);
        var gpg_rp = Number(dataJson.maxmin[1400].rp);

        var gtj_stok = Number(dataJson.last[1300].qty_stok);
        var gtj_ua = Number(dataJson.stok[1300].stok);
        var gtj_din2 = Number(dataJson.stok[1300].stok);
        var gtj_din = Math.ceil(gtj_stok / gtj_din2);
        var gtj_min = Number(dataJson.maxmin[1300].min);
        var gtj_max = Number(dataJson.maxmin[1300].max);
        var gtj_rp = Number(dataJson.maxmin[1300].rp);

        var id_stok = Number(dataJson.last[1500].qty_stok);
        var id_ua = Number(dataJson.stok[1500].stok);
        var id_din2 = Number(dataJson.stok[1500].stok);
        var id_din = Math.ceil(id_stok / id_din2);
        var id_min = Number(dataJson.maxmin[1500].min);
        var id_max = Number(dataJson.maxmin[1500].max);
        var id_rp = Number(dataJson.maxmin[1500].rp);

        var sl_stok = Number(dataJson.last[1200].qty_stok);
        var sl_ua = Number(dataJson.stok[1200].stok);
        var sl_din2 = Number(dataJson.stok[1200].stok);
        var sl_din = Math.ceil(sl_stok / sl_din2);
        var sl_min = Number(dataJson.maxmin[1200].min);
        var sl_max = Number(dataJson.maxmin[1200].max);
        var sl_rp = Number(dataJson.maxmin[1200].rp);
		
		var gn_stok = Number(dataJson.last[2700].qty_stok);
        var gn_ua = Number(dataJson.stok[2700].stok);
        var gn_din2 = Number(dataJson.stok[2700].stok);
        var gn_din = Math.ceil(gn_stok / gn_din2);
        var gn_min = Number(dataJson.maxmin[2700].min);
        var gn_max = Number(dataJson.maxmin[2700].max);
        var gn_rp = Number(dataJson.maxmin[2700].rp);


        var ar_progpkai = Number(dataJson.prog_pakai[1700].prog_use);
        var bt_progpkai = Number(dataJson.prog_pakai[1000].prog_use);
        var bb_progpkai = Number(dataJson.prog_pakai[1600].prog_use);
        var cp_progpkai = Number(dataJson.prog_pakai[1100].prog_use);
        var gpg_progpkai = Number(dataJson.prog_pakai[1400].prog_use);
        var gtj_progpkai = Number(dataJson.prog_pakai[1300].prog_use);
        var id_progpkai = Number(dataJson.prog_pakai[1500].prog_use);
        var sl_progpkai = Number(dataJson.prog_pakai[1200].prog_use);
        var gn_progpkai = Number(dataJson.prog_pakai[2700].prog_use);

		
		
        console.log('stok' + ar_stok);
        console.log('ua' + ar_ua);
        console.log('day invent' + ar_din);


// TOTAL #################################################################################################################

        $('#ar_prog').html(setFormat(ar_progpkai, 0));
        $('#bt_prog').html(setFormat(bt_progpkai, 0));
        $('#bb_prog').html(setFormat(bb_progpkai, 0));
        $('#cp_prog').html(setFormat(cp_progpkai, 0));
        $('#gpg_prog').html(setFormat(gpg_progpkai, 0));
        $('#gtj_prog').html(setFormat(gtj_progpkai, 0));
        $('#id_prog').html(setFormat(id_progpkai, 0));
        $('#sl_prog').html(setFormat(sl_progpkai, 0));
        $('#gn_prog').html(setFormat(gn_progpkai, 0));

        $('#ar_stok').html(setFormat(ar_stok, 0));
        $('#ar_ua').html(setFormat(ar_ua, 0));
        $('#ar_din').html(Math.ceil(ar_din));
        $('#ar_min').html(setFormat(ar_min, 0));
        $('#ar_max').html(setFormat(ar_max, 0));
        $('#ar_rp').html(setFormat(ar_rp, 0));
        $('#tanggal').html(tgl);

        $('#bt_stok').html(setFormat(bt_stok, 0));
        $('#bt_ua').html(setFormat(bt_ua, 0));
        $('#bt_din').html(Math.ceil(bt_din));
        $('#bt_min').html(setFormat(bt_min, 0));
        $('#bt_max').html(setFormat(bt_max, 0));
        $('#bt_rp').html(setFormat(bt_rp, 0));

        $('#bb_stok').html(setFormat(bb_stok, 0));
        $('#bb_ua').html(setFormat(bb_ua, 0));
        $('#bb_din').html(Math.ceil(bb_din));
        $('#bb_min').html(setFormat(bb_min, 0));
        $('#bb_max').html(setFormat(bb_max, 0));
        $('#bb_rp').html(setFormat(bb_rp, 0));


        $('#cp_stok').html(setFormat(cp_stok, 0));
        $('#cp_ua').html(setFormat(cp_ua, 0));
        $('#cp_din').html(Math.ceil(cp_din));
        $('#cp_min').html(setFormat(cp_min, 0));
        $('#cp_max').html(setFormat(cp_max, 0));
        $('#cp_rp').html(setFormat(cp_rp, 0));



        $('#gpg_stok').html(setFormat(gpg_stok, 0));
        $('#gpg_ua').html(setFormat(gpg_ua, 0));
        $('#gpg_din').html(Math.ceil(gpg_din));
        $('#gpg_min').html(setFormat(gpg_min, 0));
        $('#gpg_max').html(setFormat(gpg_max, 0));
        $('#gpg_rp').html(setFormat(gpg_rp, 0));



        $('#gtj_stok').html(setFormat(gtj_stok, 0));
        $('#gtj_ua').html(setFormat(gtj_ua, 0));
        $('#gtj_din').html(Math.ceil(gtj_din));
        $('#gtj_min').html(setFormat(gtj_min, 0));
        $('#gtj_max').html(setFormat(gtj_max, 0));
        $('#gtj_rp').html(setFormat(gtj_rp, 0));

		$('#gn_stok').html(setFormat(gn_stok, 0));
        $('#gn_ua').html(setFormat(gn_ua, 0));
        $('#gn_din').html(Math.ceil(gn_din));
        $('#gn_min').html(setFormat(gn_min, 0));
        $('#gn_max').html(setFormat(gn_max, 0));
        $('#gn_rp').html(setFormat(gn_rp, 0));

        $('#id_stok').html(setFormat(id_stok, 0));
        $('#id_ua').html(setFormat(id_ua, 0));
        $('#id_din').html(Math.ceil(id_din));
        $('#id_min').html(setFormat(id_min, 0));
        $('#id_max').html(setFormat(id_max, 0));
        $('#id_rp').html(setFormat(id_rp, 0));


        $('#sl_stok').html(setFormat(sl_stok, 0));
        $('#sl_ua').html(setFormat(sl_ua, 0));
        $('#sl_din').html(Math.ceil(sl_din));
        $('#sl_min').html(setFormat(sl_min, 0));
        $('#sl_max').html(setFormat(sl_max, 0));
        $('#sl_rp').html(setFormat(sl_rp, 0));


// TOTAL #################################################################################################################

        if ( ar_stok <= ar_min){
            $('#ar_sd').addClass('redmm');
            $('#ar_sd').removeClass('ylmm');
            $('#ar_sd').removeClass('grmm');
            $('#ar_sd').removeClass('blmm');
            $('#ar_bt').addClass('rdbt');
            $('#ar_bt').removeClass('grbt');
            $('#ar_bt').removeClass('ylbt');
            $('#ar_bt').removeClass('blbt');
        }else if ( ar_stok > ar_max) {
            $('#ar_sd').addClass('blmm');
            $('#ar_sd').removeClass('ylmm');
            $('#ar_sd').removeClass('grmm');
            $('#ar_sd').removeClass('redmm');
            $('#ar_bt').addClass('blbt');
            $('#ar_bt').removeClass('grbt');
            $('#ar_bt').removeClass('ylbt');
            $('#ar_bt').removeClass('rdbt');
        }else if ( ar_stok > ar_min && ar_stok < ar_max) {
            $('#ar_sd').addClass('grmm');
            $('#ar_sd').removeClass('ylmm');
            $('#ar_sd').removeClass('blmm');
            $('#ar_sd').removeClass('redmm');
            $('#ar_bt').addClass('grbt');
            $('#ar_bt').removeClass('blbt');
            $('#ar_bt').removeClass('ylbt');
            $('#ar_bt').removeClass('rdbt');
        }else if ( ar_stok <= ar_rp) {
            $('#ar_sd').addClass('ylmm');
            $('#ar_sd').removeClass('grmm');
            $('#ar_sd').removeClass('blmm');
            $('#ar_sd').removeClass('redmm');
            $('#ar_bt').addClass('ylbt');
            $('#ar_bt').removeClass('blbt');
            $('#ar_bt').removeClass('grbt');
            $('#ar_bt').removeClass('rdbt');
        }

        if ( bt_stok <= bt_min){
            $('#bt_sd').addClass('redmm');
            $('#bt_sd').removeClass('ylmm');
            $('#bt_sd').removeClass('grmm');
            $('#bt_sd').removeClass('blmm');
            $('#bt_bt').addClass('rdbt');
            $('#bt_bt').removeClass('grbt');
            $('#bt_bt').removeClass('ylbt');
            $('#bt_bt').removeClass('blbt');
        }else if ( bt_stok > bt_max) {
            $('#bt_sd').addClass('blmm');
            $('#bt_sd').removeClass('ylmm');
            $('#bt_sd').removeClass('grmm');
            $('#bt_sd').removeClass('redmm');
            $('#bt_bt').addClass('blbt');
            $('#bt_bt').removeClass('grbt');
            $('#bt_bt').removeClass('ylbt');
            $('#bt_bt').removeClass('rdbt');
        }else if ( bt_stok > bt_min && bt_stok < bt_max) {
            $('#bt_sd').addClass('grmm');
            $('#bt_sd').removeClass('ylmm');
            $('#bt_sd').removeClass('blmm');
            $('#bt_sd').removeClass('redmm');
            $('#bt_bt').addClass('grbt');
            $('#bt_bt').removeClass('blbt');
            $('#bt_bt').removeClass('ylbt');
            $('#bt_bt').removeClass('rdbt');
        }else if ( bt_stok <= bt_rp) {
            $('#bt_sd').addClass('ylmm');
            $('#bt_sd').removeClass('grmm');
            $('#bt_sd').removeClass('blmm');
            $('#bt_sd').removeClass('redmm');
            $('#bt_bt').addClass('ylbt');
            $('#bt_bt').removeClass('blbt');
            $('#bt_bt').removeClass('grbt');
            $('#bt_bt').removeClass('rdbt');
        }

       if ( bb_stok <= bb_min){
            $('#bb_sd').addClass('redmm');
            $('#bb_sd').removeClass('ylmm');
            $('#bb_sd').removeClass('grmm');
            $('#bb_sd').removeClass('blmm');
            $('#bb_bt').addClass('rdbt');
            $('#bb_bt').removeClass('grbt');
            $('#bb_bt').removeClass('ylbt');
            $('#bb_bt').removeClass('blbt');
        }else if ( bb_stok > bb_max) {
            $('#bb_sd').addClass('blmm');
            $('#bb_sd').removeClass('ylmm');
            $('#bb_sd').removeClass('grmm');
            $('#bb_sd').removeClass('redmm');
            $('#bb_bt').addClass('blbt');
            $('#bb_bt').removeClass('grbt');
            $('#bb_bt').removeClass('ylbt');
            $('#bb_bt').removeClass('rdbt');
        }else if ( bb_stok > bb_min && bb_stok < bb_max) {
            $('#bb_sd').addClass('grmm');
            $('#bb_sd').removeClass('ylmm');
            $('#bb_sd').removeClass('blmm');
            $('#bb_sd').removeClass('redmm');
            $('#bb_bt').addClass('grbt');
            $('#bb_bt').removeClass('blbt');
            $('#bb_bt').removeClass('ylbt');
            $('#bb_bt').removeClass('rdbt');
        }else if ( bb_stok <= bb_rp) {
            $('#bb_sd').addClass('ylmm');
            $('#bb_sd').removeClass('grmm');
            $('#bb_sd').removeClass('blmm');
            $('#bb_sd').removeClass('redmm');
            $('#bb_bt').addClass('ylbt');
            $('#bb_bt').removeClass('blbt');
            $('#bb_bt').removeClass('grbt');
            $('#bb_bt').removeClass('rdbt');
        }

        if ( cp_stok <= cp_min){
            $('#cp_sd').addClass('redmm');
            $('#cp_sd').removeClass('ylmm');
            $('#cp_sd').removeClass('grmm');
            $('#cp_sd').removeClass('blmm');
            $('#cp_bt').addClass('rdbt');
            $('#cp_bt').removeClass('grbt');
            $('#cp_bt').removeClass('ylbt');
            $('#cp_bt').removeClass('blbt');
        }else if ( cp_stok > cp_max) {
            $('#cp_sd').addClass('blmm');
            $('#cp_sd').removeClass('ylmm');
            $('#cp_sd').removeClass('grmm');
            $('#cp_sd').removeClass('redmm');
            $('#cp_bt').addClass('blbt');
            $('#cp_bt').removeClass('grbt');
            $('#cp_bt').removeClass('ylbt');
            $('#cp_bt').removeClass('rdbt');
        }else if ( cp_stok > cp_min && cp_stok < cp_max) {
            $('#cp_sd').addClass('grmm');
            $('#cp_sd').removeClass('ylmm');
            $('#cp_sd').removeClass('blmm');
            $('#cp_sd').removeClass('redmm');
            $('#cp_bt').addClass('grbt');
            $('#cp_bt').removeClass('blbt');
            $('#cp_bt').removeClass('ylbt');
            $('#cp_bt').removeClass('rdbt');
        }else if ( cp_stok <= cp_rp) {
            $('#cp_sd').addClass('ylmm');
            $('#cp_sd').removeClass('grmm');
            $('#cp_sd').removeClass('blmm');
            $('#cp_sd').removeClass('redmm');
            $('#cp_bt').addClass('ylbt');
            $('#cp_bt').removeClass('blbt');
            $('#cp_bt').removeClass('grbt');
            $('#cp_bt').removeClass('rdbt');
        }

        if ( gtj_stok <= gtj_min){
            $('#gtj_sd').addClass('redmm');
            $('#gtj_sd').removeClass('ylmm');
            $('#gtj_sd').removeClass('grmm');
            $('#gtj_sd').removeClass('blmm');
            $('#gtj_bt').addClass('rdbt');
            $('#gtj_bt').removeClass('grbt');
            $('#gtj_bt').removeClass('ylbt');
            $('#gtj_bt').removeClass('blbt');
        }else if ( gtj_stok > gtj_max) {
            $('#gtj_sd').addClass('blmm');
            $('#gtj_sd').removeClass('ylmm');
            $('#gtj_sd').removeClass('grmm');
            $('#gtj_sd').removeClass('redmm');
            $('#gtj_bt').addClass('blbt');
            $('#gtj_bt').removeClass('grbt');
            $('#gtj_bt').removeClass('ylbt');
            $('#gtj_bt').removeClass('rdbt');
        }else if ( gtj_stok > gtj_min && gtj_stok < gtj_max) {
            $('#gtj_sd').addClass('grmm');
            $('#gtj_sd').removeClass('ylmm');
            $('#gtj_sd').removeClass('blmm');
            $('#gtj_sd').removeClass('redmm');
            $('#gtj_bt').addClass('grbt');
            $('#gtj_bt').removeClass('blbt');
            $('#gtj_bt').removeClass('ylbt');
            $('#gtj_bt').removeClass('rdbt');
        }else if ( gtj_stok <= gtj_rp) {
            $('#gtj_sd').addClass('ylmm');
            $('#gtj_sd').removeClass('grmm');
            $('#gtj_sd').removeClass('blmm');
            $('#gtj_sd').removeClass('redmm');
            $('#gtj_bt').addClass('ylbt');
            $('#gtj_bt').removeClass('blbt');
            $('#gtj_bt').removeClass('grbt');
            $('#gtj_bt').removeClass('rdbt');
        }

        if ( gpg_stok <= gpg_min){
            $('#gpg_sd').addClass('redmm');
            $('#gpg_sd').removeClass('ylmm');
            $('#gpg_sd').removeClass('grmm');
            $('#gpg_sd').removeClass('blmm');
            $('#gpg_bt').addClass('rdbt');
            $('#gpg_bt').removeClass('grbt');
            $('#gpg_bt').removeClass('ylbt');
            $('#gpg_bt').removeClass('blbt');
        }else if ( gpg_stok > gpg_max) {
            $('#gpg_sd').addClass('blmm');
            $('#gpg_sd').removeClass('ylmm');
            $('#gpg_sd').removeClass('grmm');
            $('#gpg_sd').removeClass('redmm');
            $('#gpg_bt').addClass('blbt');
            $('#gpg_bt').removeClass('grbt');
            $('#gpg_bt').removeClass('ylbt');
            $('#gpg_bt').removeClass('rdbt');
        }else if ( gpg_stok > gpg_min && gpg_stok < gpg_max) {
            $('#gpg_sd').addClass('grmm');
            $('#gpg_sd').removeClass('ylmm');
            $('#gpg_sd').removeClass('blmm');
            $('#gpg_sd').removeClass('redmm');
            $('#gpg_bt').addClass('grbt');
            $('#gpg_bt').removeClass('blbt');
            $('#gpg_bt').removeClass('ylbt');
            $('#gpg_bt').removeClass('rdbt');
        }else if ( gpg_stok <= gpg_rp) {
            $('#gpg_sd').addClass('ylmm');
            $('#gpg_sd').removeClass('grmm');
            $('#gpg_sd').removeClass('blmm');
            $('#gpg_sd').removeClass('redmm');
            $('#gpg_bt').addClass('ylbt');
            $('#gpg_bt').removeClass('blbt');
            $('#gpg_bt').removeClass('grbt');
            $('#gpg_bt').removeClass('rdbt');
        }

        if ( id_stok <= id_min){
            $('#id_sd').addClass('redmm');
            $('#id_sd').removeClass('ylmm');
            $('#id_sd').removeClass('grmm');
            $('#id_sd').removeClass('blmm');
            $('#id_bt').addClass('rdbt');
            $('#id_bt').removeClass('grbt');
            $('#id_bt').removeClass('ylbt');
            $('#id_bt').removeClass('blbt');
        }else if ( id_stok > id_max) {
            $('#id_sd').addClass('blmm');
            $('#id_sd').removeClass('ylmm');
            $('#id_sd').removeClass('grmm');
            $('#id_sd').removeClass('redmm');
            $('#id_bt').addClass('blbt');
            $('#id_bt').removeClass('grbt');
            $('#id_bt').removeClass('ylbt');
            $('#id_bt').removeClass('rdbt');
        }else if ( id_stok > id_min && id_stok < id_max) {
            $('#id_sd').addClass('grmm');
            $('#id_sd').removeClass('ylmm');
            $('#id_sd').removeClass('blmm');
            $('#id_sd').removeClass('redmm');
            $('#id_bt').addClass('grbt');
            $('#id_bt').removeClass('blbt');
            $('#id_bt').removeClass('ylbt');
            $('#id_bt').removeClass('rdbt');
        }else if ( id_stok <= id_rp) {
            $('#id_sd').addClass('ylmm');
            $('#id_sd').removeClass('grmm');
            $('#id_sd').removeClass('blmm');
            $('#id_sd').removeClass('redmm');
            $('#id_bt').addClass('ylbt');
            $('#id_bt').removeClass('blbt');
            $('#id_bt').removeClass('grbt');
            $('#id_bt').removeClass('rdbt');
        }

        if ( sl_stok <= sl_min){
            $('#sl_sd').addClass('redmm');
            $('#sl_sd').removeClass('ylmm');
            $('#sl_sd').removeClass('grmm');
            $('#sl_sd').removeClass('blmm');
            $('#sl_bt').addClass('rdbt');
            $('#sl_bt').removeClass('grbt');
            $('#sl_bt').removeClass('ylbt');
            $('#sl_bt').removeClass('blbt');
        }else if ( sl_stok > sl_max) {
            $('#sl_sd').addClass('blmm');
            $('#sl_sd').removeClass('ylmm');
            $('#sl_sd').removeClass('grmm');
            $('#sl_sd').removeClass('redmm');
            $('#sl_bt').addClass('blbt');
            $('#sl_bt').removeClass('grbt');
            $('#sl_bt').removeClass('ylbt');
            $('#sl_bt').removeClass('rdbt');
        }else if ( sl_stok > sl_min && sl_stok < sl_max) {
            $('#sl_sd').addClass('grmm');
            $('#sl_sd').removeClass('ylmm');
            $('#sl_sd').removeClass('blmm');
            $('#sl_sd').removeClass('redmm');
            $('#sl_bt').addClass('grbt');
            $('#sl_bt').removeClass('blbt');
            $('#sl_bt').removeClass('ylbt');
            $('#sl_bt').removeClass('rdbt');
        }else if ( sl_stok <= sl_rp) {
            $('#sl_sd').addClass('ylmm');
            $('#sl_sd').removeClass('grmm');
            $('#sl_sd').removeClass('blmm');
            $('#sl_sd').removeClass('redmm');
            $('#sl_bt').addClass('ylbt');
            $('#sl_bt').removeClass('blbt');
            $('#sl_bt').removeClass('grbt');
            $('#sl_bt').removeClass('rdbt');
        }
	
	if ( gn_stok <= gn_min){
            $('#gn_sd').addClass('redmm');
            $('#gn_sd').removeClass('ylmm');
            $('#gn_sd').removeClass('grmm');
            $('#gn_sd').removeClass('blmm');
            $('#gn_bt').addClass('rdbt');
            $('#gn_bt').removeClass('grbt');
            $('#gn_bt').removeClass('ylbt');
            $('#gn_bt').removeClass('blbt');
        }else if ( gn_stok > gn_max) {
            $('#gn_sd').addClass('blmm');
            $('#gn_sd').removeClass('ylmm');
            $('#gn_sd').removeClass('grmm');
            $('#gn_sd').removeClass('redmm');
            $('#gn_bt').addClass('blbt');
            $('#gn_bt').removeClass('grbt');
            $('#gn_bt').removeClass('ylbt');
            $('#gn_bt').removeClass('rdbt');
        }else if ( gn_stok > gn_min && gn_stok < gn_max) {
            $('#gn_sd').addClass('grmm');
            $('#gn_sd').removeClass('ylmm');
            $('#gn_sd').removeClass('blmm');
            $('#gn_sd').removeClass('redmm');
            $('#gn_bt').addClass('grbt');
            $('#gn_bt').removeClass('blbt');
            $('#gn_bt').removeClass('ylbt');
            $('#gn_bt').removeClass('rdbt');
        }else if ( gn_stok <= gn_rp) {
            $('#gn_sd').addClass('ylmm');
            $('#gn_sd').removeClass('grmm');
            $('#gn_sd').removeClass('blmm');
            $('#gn_sd').removeClass('redmm');
            $('#gn_bt').addClass('ylbt');
            $('#gn_bt').removeClass('blbt');
            $('#gn_bt').removeClass('grbt');
            $('#gn_bt').removeClass('rdbt');
        }
	
	
	
	


        stop_waitMe('.wrapper');


    });


}

function bahan_data_detail(bulan, opco, yearnow, type, plant) {
    run_waitMe('.wrapper', 'ios');
    console.log(yearnow);
    // console.log(bulan);
    // var param = (opco!='SMI')?'&company='+opco:'';
    var opco = '';

    if (sessionStorage.getItem('bahan-bln') != null) {
        var data = sessionStorage.getItem('bahan-bln');

        console.log(data);
        bulan = data;

    }
    if (sessionStorage.getItem('bahan-thn') != null) {
        var data = sessionStorage.getItem('bahan-thn');

        console.log(data);
        yearnow = data;

    }
    if (sessionStorage.getItem('bahan-opco') != null) {
        var data = sessionStorage.getItem('bahan-opco');

        console.log(data);
        opco = data;

    }
    if (sessionStorage.getItem('bahan-type') != null) {
        var data = sessionStorage.getItem('bahan-type');

        console.log(data);
        type = data;

    }
    if (sessionStorage.getItem('bahan-plant') != null) {
        var data = sessionStorage.getItem('bahan-plant');

        console.log(data);
        plant = data;

    }
    if (opco == '7000') {
        link = 'stok_bahan.html';
        judul = 'SEMEN GRESIK';
    }else
    if (opco == '3000') {
        link = 'stok_bahan_sp.html';
        judul = 'SEMEN PADANG';
    }else
    if (opco == '4000') {
        link = 'stok_bahan_st.html';
        judul = 'SEMEN TONASA';
    }else
    if (opco == '6000') {
        link = 'stok_bahan_tl.html';
        judul = 'THANG LONG';
    }
    console.log(bulan);

    $('#tag_month_selected').html(type);
    // $.post(url_src+'/api/index.php/Project', function(data){
    // $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){
    //============================================================
    var label = [];
    var terima = [];
    var pakai = [];
    var prognose = [];

    var stok = [];
    var min = [];
    var max = [];
    var rp = [];
    // bulan = bulan-1;
    // if(bulan<10) {
    //     bulan='0'+bulan
    // }
    var index = [];
    $.get(url_src+'/api/index.php/c_coalstock/get_bahan_chart?material=' + type + '&plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        var dataJson = paradigma.json_parse(data);
        console.log(dataJson);
        var datax = Object.keys(dataJson).length;
        console.log(datax);
        for (x in dataJson) {
            index.push(x);
        }
        var iArray = index.sort();
console.log(iArray);
        $.each(iArray, function (index,val) {
            console.log(index);
            console.log(val);
            
            
            var prog = Number(dataJson[val].qty_min) + Number(dataJson[val].qty_max);
            label.push(val);
            if (dataJson[val].qty_pakai != null) {
                pakai.push(Number(dataJson[val].qty_pakai));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                pakai.push(Number(dataJson[val].pakai_prog));
            }
            
            if (dataJson[val].qty_terima != null) {
                terima.push(Number(dataJson[val].qty_terima));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                terima.push(Number(dataJson[val].terima_prog));
                }
            prognose.push(0);

            if (dataJson[val].qty_stok == null) {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }
            /*       
            pakai.push(Number(dataJson[val].pakai_prog));
            terima.push(Number(dataJson[val].terima_prog));
            prognose.push(0);

            if (dataJson[val].qty_stok = 'null') {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));*/
            
            min.push(Number(dataJson[val].qty_min));
            max.push(Number(dataJson[val].qty_max));
            rp.push(Number(dataJson[val].rp));
            
        /*    var c = index + 1;
            if (c < 10) {
                var c = '0' + c;
            }
            console.log(c);
            label.push(c);
            // console.log(index+'- pakai prog -> '+el.pakai_prog);
            var prog = Number(dataJson[c].qty_min) + Number(dataJson[c].qty_max);

            pakai.push(Number(dataJson[c].pakai_prog));
            terima.push(Number(dataJson[c].terima_prog));
            prognose.push(0);

            if (dataJson[c].qty_stok = 'null') {
                stok.push(Number(dataJson[c].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[c].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));*/
        });console.log(iArray);
        $.each(iArray, function (index,val) {
            console.log(index);
            console.log(val);
            
            
            var prog = Number(dataJson[val].qty_min) + Number(dataJson[val].qty_max);
            label.push(val);
            if (dataJson[val].qty_pakai != null) {
                pakai.push(Number(dataJson[val].qty_pakai));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                pakai.push(Number(dataJson[val].pakai_prog));
            }
            
            if (dataJson[val].qty_terima != null) {
                terima.push(Number(dataJson[val].qty_terima));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                terima.push(Number(dataJson[val].terima_prog));
                }
            prognose.push(0);

            if (dataJson[val].qty_stok == null) {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }
            /*       
            pakai.push(Number(dataJson[val].pakai_prog));
            terima.push(Number(dataJson[val].terima_prog));
            prognose.push(0);

            if (dataJson[val].qty_stok = 'null') {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));*/
            
            min.push(Number(dataJson[val].qty_min));
            max.push(Number(dataJson[val].qty_max));
            rp.push(Number(dataJson[val].rp));
            
        /*    var c = index + 1;
            if (c < 10) {
                var c = '0' + c;
            }
            console.log(c);
            label.push(c);
            // console.log(index+'- pakai prog -> '+el.pakai_prog);
            var prog = Number(dataJson[c].qty_min) + Number(dataJson[c].qty_max);

            pakai.push(Number(dataJson[c].pakai_prog));
            terima.push(Number(dataJson[c].terima_prog));
            prognose.push(0);

            if (dataJson[c].qty_stok = 'null') {
                stok.push(Number(dataJson[c].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[c].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));*/
        });

        chart(label, pakai, terima, prognose, stok, min, max, rp);


    });

    //============================================================
    var dataJson;
    $.get(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {

        dataJson = paradigma.json_parse(data, '.wrapper');

        console.log(dataJson);
        // try{
        //     var ar_stok = Number(dataJson.rkap[1700].rkap);
        //     }catch(e){
        //      console.log('data error');
        //      stop_waitMe('.wrapper');
        //      alert('Sorry, data is empty, please choose another month');
             
        //     }
            if (dataJson.rkap == 0) {
                var ar_rkap_us = 0;

            } else {
                var ar_rkap_us = Number(dataJson.rkap[1700].rkap); //1700
            }

        // production_cost
        //var ar_stok = Number(dataJson.act_stok[1700].stok);
		var ar_stok = Number(dataJson.last[1700].qty_stok);
        var ar_ua = Number(dataJson.stok[1700].stok);
        var ar_din2 = Number(dataJson.stok[1700].stok);
        var ar_din = Math.ceil(ar_stok / ar_din2);
        var ar_real_rc = Number(dataJson.data[1700].terima);
        var ar_real_us = Number(dataJson.data[1700].pakai);
		var tgl = dataJson.last[1600].update;
        
        var ar_prog_us = Number(dataJson.prog_pakai[1700].prog_use);
        var ar_min = Number(dataJson.maxmin[1700].min);
        var ar_max = Number(dataJson.maxmin[1700].max);
        var ar_rp = Number(dataJson.maxmin[1700].rp);

        $('#ar_stok').html(setFormat(ar_stok, 0));
        $('#ar_ua').html(setFormat(ar_ua, 0));
        $('#ar_din').html(ar_din);
        $('#ar_real_rc').html(setFormat(ar_real_rc, 0));
        $('#ar_real_us').html(setFormat(ar_real_us, 0));
        $('#ar_rkap_us').html(setFormat(ar_rkap_us, 0));
        $('#ar_min').html(setFormat(ar_min, 0));
        $('#ar_max').html(setFormat(ar_max, 0));
        $('#ar_rp').html(setFormat(ar_rp, 0));
        $('#ar_prog').html(setFormat(ar_prog_us, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);





        // graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

function bahan_data_detail_bt(bulan, opco, yearnow, type, plant) {
    run_waitMe('.wrapper', 'ios');

    console.log(bulan);
    console.log(opco);
    console.log(yearnow);

    // console.log(bulan);
    // var param = (opco!='SMI')?'&company='+opco:'';
    var opco = '';

    if (sessionStorage.getItem('bahan-bln') != null) {
        var data = sessionStorage.getItem('bahan-bln');

        console.log(data);
        bulan = data;

    }
    if (sessionStorage.getItem('bahan-thn') != null) {
        var data = sessionStorage.getItem('bahan-thn');

        console.log(data);
        yearnow = data;

    }
    if (sessionStorage.getItem('bahan-opco') != null) {
        var data = sessionStorage.getItem('bahan-opco');

        console.log(data);
        opco = data;

    }
    if (sessionStorage.getItem('bahan-type') != null) {
        var data = sessionStorage.getItem('bahan-type');

        console.log(data);
        type = data;

    }
    if (sessionStorage.getItem('bahan-plant') != null) {
        var data = sessionStorage.getItem('bahan-plant');

        console.log(data);
        plant = data;

    }
    if (opco == '7000') {
        link = 'stok_bahan.html';
        judul = 'SEMEN GRESIK';
    }else
    if (opco == '3000') {
        link = 'stok_bahan_sp.html';
        judul = 'SEMEN PADANG';
    }else
    if (opco == '4000') {
        link = 'stok_bahan_st.html';
        judul = 'SEMEN TONASA';
    }else
    if (opco == '6000') {
        link = 'stok_bahan_tl.html';
        judul = 'THANG LONG';
    }
    console.log(bulan);

    $('#tag_month_selected').html(type);
    // $.post(url_src+'/api/index.php/Project', function(data){
    // $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){
    var label = [];
    var terima = [];
    var pakai = [];
    var prognose = [];

    var stok = [];
    var min = [];
    var max = [];
    var rp = [];

    var index = [];

    console.log(type);
    console.log(plant);
    console.log(bulan);
    // bulan = bulan-1;
    // if(bulan<10) {
    //     bulan='0'+bulan
    // }
    console.log(opco);
    console.log(yearnow);

    $.get(url_src+'/api/index.php/c_coalstock/get_bahan_chart?material=' + type + '&plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        var dataJson = paradigma.json_parse(data);
        console.log(dataJson);
        var datax = Object.keys(dataJson).length;
        console.log(datax);
        for (x in dataJson) {
            index.push(x);
        }
        var iArray = index.sort();
console.log(iArray);
        $.each(iArray, function (index,val) {
            console.log(index);
            console.log(val);
            
            
            var prog = Number(dataJson[val].qty_min) + Number(dataJson[val].qty_max);
            label.push(val);
            if (dataJson[val].qty_pakai != null) {
                pakai.push(Number(dataJson[val].qty_pakai));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                pakai.push(Number(dataJson[val].pakai_prog));
            }
            
            if (dataJson[val].qty_terima != null) {
                terima.push(Number(dataJson[val].qty_terima));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                terima.push(Number(dataJson[val].terima_prog));
                }
            prognose.push(0);

            if (dataJson[val].qty_stok == null) {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }
            /*       
            pakai.push(Number(dataJson[val].pakai_prog));
            terima.push(Number(dataJson[val].terima_prog));
            prognose.push(0);

            if (dataJson[val].qty_stok = 'null') {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));*/
            
            min.push(Number(dataJson[val].qty_min));
            max.push(Number(dataJson[val].qty_max));
            rp.push(Number(dataJson[val].rp));
            
        /*    var c = index + 1;
            if (c < 10) {
                var c = '0' + c;
            }
            console.log(c);
            label.push(c);
            // console.log(index+'- pakai prog -> '+el.pakai_prog);
            var prog = Number(dataJson[c].qty_min) + Number(dataJson[c].qty_max);

            pakai.push(Number(dataJson[c].pakai_prog));
            terima.push(Number(dataJson[c].terima_prog));
            prognose.push(0);

            if (dataJson[c].qty_stok = 'null') {
                stok.push(Number(dataJson[c].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[c].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));*/
        });


        chart(label, pakai, terima, prognose, stok, min, max, rp);


    });
    var dataJson;
    $.post(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {

        dataJson = paradigma.json_parse(data, '.wrapper');

        console.log(dataJson);
        // try{
        //     var ar_stok = Number(dataJson.rkap[1700].rkap);
        //     }catch(e){
        //      console.log('data error');
        //      stop_waitMe('.wrapper');
        //      alert('Sorry, data is empty, please choose another month');
             
        //     }
        if (dataJson.rkap == 0) {
                var bt_rkap_us = 0;

            } else {
                var bt_rkap_us = Number(dataJson.rkap[1000].rkap); //1000
            }

// production_cost
		var bt_stok = Number(dataJson.last[1000].qty_stok);
        //var bt_stok = Number(dataJson.act_stok[1000].stok);
        var bt_ua = Number(dataJson.stok[1000].stok);
        var bt_din2 = Number(dataJson.stok[1000].stok);
        var bt_din = Math.ceil(bt_stok / bt_din2);
        var bt_real_rc = Number(dataJson.data[1000].terima);
        var bt_real_us = Number(dataJson.data[1000].pakai);
        
        // var bt_prog_us = '';
        var bt_min = Number(dataJson.maxmin[1000].min);
        var bt_max = Number(dataJson.maxmin[1000].max);
        var bt_rp = Number(dataJson.maxmin[1000].rp);

        $('#bt_stok').html(setFormat(bt_stok, 0));
        $('#bt_ua').html(setFormat(bt_ua, 0));
        $('#bt_din').html(bt_din);
        $('#bt_real_rc').html(setFormat(bt_real_rc, 0));
        $('#bt_real_us').html(setFormat(bt_real_us, 0));
        $('#bt_rkap_us').html(setFormat(bt_rkap_us, 0));
        $('#bt_min').html(setFormat(bt_min, 0));
        $('#bt_max').html(setFormat(bt_max, 0));
        $('#bt_rp').html(setFormat(bt_rp, 0));
        var bt_prog_us = Number(dataJson.prog_pakai[1000].prog_use);
        $('#bt_prog').html(setFormat(bt_prog_us, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);




// graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

function bahan_data_detail_bb(bulan, opco, yearnow, type, plant) {
    run_waitMe('.wrapper', 'ios');
    console.log(yearnow);
    // console.log(bulan);
    // var param = (opco!='SMI')?'&company='+opco:'';
    var opco = '';

    if (sessionStorage.getItem('bahan-bln') != null) {
        var data = sessionStorage.getItem('bahan-bln');

        console.log(data);
        bulan = data;

    }
    if (sessionStorage.getItem('bahan-thn') != null) {
        var data = sessionStorage.getItem('bahan-thn');

        console.log(data);
        yearnow = data;

    }
    if (sessionStorage.getItem('bahan-opco') != null) {
        var data = sessionStorage.getItem('bahan-opco');

        console.log(data);
        opco = data;

    }
    if (sessionStorage.getItem('bahan-type') != null) {
        var data = sessionStorage.getItem('bahan-type');

        console.log(data);
        type = data;

    }
    if (sessionStorage.getItem('bahan-plant') != null) {
        var data = sessionStorage.getItem('bahan-plant');

        console.log(data);
        plant = data;

    }
    if (opco == '7000') {
        link = 'stok_bahan.html';
        judul = 'SEMEN GRESIK';
    }else
    if (opco == '3000') {
        link = 'stok_bahan_sp.html';
        judul = 'SEMEN PADANG';
    }else
    if (opco == '4000') {
        link = 'stok_bahan_st.html';
        judul = 'SEMEN TONASA';
    }else
    if (opco == '6000') {
        link = 'stok_bahan_tl.html';
        judul = 'THANG LONG';
    }
    console.log(bulan);

    $('#tag_month_selected').html(type);
    // $.post(url_src+'/api/index.php/Project', function(data){
    // $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){

    var label = [];
    var terima = [];
    var pakai = [];
    var prognose = [];

    var stok = [];
    var min = [];
    var max = [];
    var rp = [];
    // bulan = bulan-1;
    // if(bulan<10) {
    //     bulan='0'+bulan
    // }
    var index = [];
    $.get(url_src+'/api/index.php/c_coalstock/get_bahan_chart?material=' + type + '&plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        var dataJson = paradigma.json_parse(data);
        console.log(dataJson);
        var datax = Object.keys(dataJson).length;
        console.log(datax);
        for (x in dataJson) {
            index.push(x);
        }
        var iArray = index.sort();
		console.log(iArray);
        $.each(iArray, function (index,val) {
			console.log(index);
			console.log(val);
			
			
			var prog = Number(dataJson[val].qty_min) + Number(dataJson[val].qty_max);
			label.push(val);
			if (dataJson[val].qty_pakai != null) {
                pakai.push(Number(dataJson[val].qty_pakai));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                pakai.push(Number(dataJson[val].pakai_prog));
            }
			
			if (dataJson[val].qty_terima != null) {
                terima.push(Number(dataJson[val].qty_terima));
				// console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                terima.push(Number(dataJson[val].terima_prog));
				}
            prognose.push(0);

            if (dataJson[val].qty_stok == null) {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }
			/*       
			pakai.push(Number(dataJson[val].pakai_prog));
            terima.push(Number(dataJson[val].terima_prog));
            prognose.push(0);

            if (dataJson[val].qty_stok = 'null') {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));*/
			
            min.push(Number(dataJson[val].qty_min));
            max.push(Number(dataJson[val].qty_max));
            rp.push(Number(dataJson[val].rp));
			
        /*    var c = index + 1;
            if (c < 10) {
                var c = '0' + c;
            }
            console.log(c);
            label.push(c);
            // console.log(index+'- pakai prog -> '+el.pakai_prog);
            var prog = Number(dataJson[c].qty_min) + Number(dataJson[c].qty_max);

            pakai.push(Number(dataJson[c].pakai_prog));
            terima.push(Number(dataJson[c].terima_prog));
            prognose.push(0);

            if (dataJson[c].qty_stok = 'null') {
                stok.push(Number(dataJson[c].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[c].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));*/
        });
	

        chart(label, pakai, terima, prognose, stok, min, max, rp);


    });


    var dataJson;
    $.post(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {

        dataJson = paradigma.json_parse(data, '.wrapper');

        console.log(dataJson);
        // try{
        //     var ar_stok = Number(dataJson.rkap[1700].rkap);
        //     }catch(e){
        //      console.log('data error');
        //      stop_waitMe('.wrapper');
        //      alert('Sorry, data is empty, please choose another month');
             
        //     }
        if (dataJson.rkap == 0) {
                var bb_rkap_us = 0;

            } else {
                var bb_rkap_us = Number(dataJson.rkap[1600].rkap); //1600
            }

// production_cost
		var bb_stok = Number(dataJson.last[1600].qty_stok);
        //var bb_stok = Number(dataJson.act_stok[1600].stok);
        var bb_ua = Number(dataJson.stok[1600].stok);
        var bb_din2 = Number(dataJson.stok[1600].stok);
        var bb_din = Math.ceil(bb_stok / bb_din2);
        var bb_real_rc = Number(dataJson.data[1600].terima);
        var bb_real_us = Number(dataJson.data[1600].pakai);
        
        // var bb_prog_us = '';
        var bb_min = Number(dataJson.maxmin[1600].min);
        var bb_max = Number(dataJson.maxmin[1600].max);
        var bb_rp = Number(dataJson.maxmin[1600].rp);

        $('#bb_stok').html(setFormat(bb_stok, 0));
        $('#bb_ua').html(setFormat(bb_ua, 0));
        $('#bb_din').html(bb_din);
        $('#bb_real_rc').html(setFormat(bb_real_rc, 0));
        $('#bb_real_us').html(setFormat(bb_real_us, 0));
        $('#bb_rkap_us').html(setFormat(bb_rkap_us, 0));
        $('#bb_min').html(setFormat(bb_min, 0));
        $('#bb_max').html(setFormat(bb_max, 0));
        $('#bb_rp').html(setFormat(bb_rp, 0));
        var bb_prog_us = Number(dataJson.prog_pakai[1600].prog_use);
$('#bb_prog').html(setFormat(bb_prog_us, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);




// graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

function bahan_data_detail_cp(bulan, opco, yearnow, type, plant) {
    run_waitMe('.wrapper', 'ios');
    console.log(yearnow);
    // console.log(bulan);
    // var param = (opco!='SMI')?'&company='+opco:'';
    var opco = '';

    if (sessionStorage.getItem('bahan-bln') != null) {
        var data = sessionStorage.getItem('bahan-bln');

        console.log(data);
        bulan = data;

    }
    if (sessionStorage.getItem('bahan-thn') != null) {
        var data = sessionStorage.getItem('bahan-thn');

        console.log(data);
        yearnow = data;

    }
    if (sessionStorage.getItem('bahan-opco') != null) {
        var data = sessionStorage.getItem('bahan-opco');

        console.log(data);
        opco = data;

    }
    if (sessionStorage.getItem('bahan-type') != null) {
        var data = sessionStorage.getItem('bahan-type');

        console.log(data);
        type = data;

    }
    if (sessionStorage.getItem('bahan-plant') != null) {
        var data = sessionStorage.getItem('bahan-plant');

        console.log(data);
        plant = data;

    }
    if (opco == '7000') {
        link = 'stok_bahan.html';
        judul = 'SEMEN GRESIK';
    }else
    if (opco == '3000') {
        link = 'stok_bahan_sp.html';
        judul = 'SEMEN PADANG';
    }else
    if (opco == '4000') {
        link = 'stok_bahan_st.html';
        judul = 'SEMEN TONASA';
    }else
    if (opco == '6000') {
        link = 'stok_bahan_tl.html';
        judul = 'THANG LONG';
    }
    console.log(bulan);

    $('#tag_month_selected').html(type);
    // $.post(url_src+'/api/index.php/Project', function(data){
    // $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){

    var label = [];
    var terima = [];
    var pakai = [];
    var prognose = [];

    var stok = [];
    var min = [];
    var max = [];
    var rp = [];
    // bulan = bulan-1;
    // if(bulan<10) {
    //     bulan='0'+bulan
    // }
    var index = [];
    $.get(url_src+'/api/index.php/c_coalstock/get_bahan_chart?material=' + type + '&plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        var dataJson = paradigma.json_parse(data);
        console.log(dataJson);
        var datax = Object.keys(dataJson).length;
        console.log(datax);
        for (x in dataJson) {
            index.push(x);
        }
        var iArray = index.sort();
console.log(iArray);
        $.each(iArray, function (index,val) {
            console.log(index);
            console.log(val);
            
            
            var prog = Number(dataJson[val].qty_min) + Number(dataJson[val].qty_max);
            label.push(val);
            if (dataJson[val].qty_pakai != null) {
                pakai.push(Number(dataJson[val].qty_pakai));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                pakai.push(Number(dataJson[val].pakai_prog));
            }
            
            if (dataJson[val].qty_terima != null) {
                terima.push(Number(dataJson[val].qty_terima));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                terima.push(Number(dataJson[val].terima_prog));
                }
            prognose.push(0);

            if (dataJson[val].qty_stok == null) {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }
            /*       
            pakai.push(Number(dataJson[val].pakai_prog));
            terima.push(Number(dataJson[val].terima_prog));
            prognose.push(0);

            if (dataJson[val].qty_stok = 'null') {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));*/
            
            min.push(Number(dataJson[val].qty_min));
            max.push(Number(dataJson[val].qty_max));
            rp.push(Number(dataJson[val].rp));
            
        /*    var c = index + 1;
            if (c < 10) {
                var c = '0' + c;
            }
            console.log(c);
            label.push(c);
            // console.log(index+'- pakai prog -> '+el.pakai_prog);
            var prog = Number(dataJson[c].qty_min) + Number(dataJson[c].qty_max);

            pakai.push(Number(dataJson[c].pakai_prog));
            terima.push(Number(dataJson[c].terima_prog));
            prognose.push(0);

            if (dataJson[c].qty_stok = 'null') {
                stok.push(Number(dataJson[c].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[c].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));*/
        });


        chart(label, pakai, terima, prognose, stok, min, max, rp);


    });
    var dataJson;
    $.post(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {

        dataJson = paradigma.json_parse(data, '.wrapper');

        console.log(dataJson);
        // try{
        //     var ar_stok = Number(dataJson.rkap[1700].rkap);
        //     }catch(e){
        //      console.log('data error');
        //      stop_waitMe('.wrapper');
        //      alert('Sorry, data is empty, please choose another month');
             
        //     }
        if (dataJson.rkap == 0) {
                var cp_rkap_us = 0;

            } else {
                var cp_rkap_us = Number(dataJson.rkap[1100].rkap);
            }

// production_cost
var cp_stok = Number(dataJson.last[1100].qty_stok);
        //var cp_stok = Number(dataJson.act_stok[1100].stok);
        var cp_ua = Number(dataJson.stok[1100].stok);
        var cp_din2 = Number(dataJson.stok[1100].stok);
        var cp_din = Math.ceil(cp_stok / cp_din2);
        var cp_real_rc = Number(dataJson.data[1100].terima);
        var cp_real_us = Number(dataJson.data[1100].pakai);
        
        // var cp_prog_us = '';
        var cp_min = Number(dataJson.maxmin[1100].min);
        var cp_max = Number(dataJson.maxmin[1100].max);
        var cp_rp = Number(dataJson.maxmin[1100].rp);

        $('#cp_stok').html(setFormat(cp_stok, 0));
        $('#cp_ua').html(setFormat(cp_ua, 0));
        $('#cp_din').html(cp_din);
        $('#cp_real_rc').html(setFormat(cp_real_rc, 0));
        $('#cp_real_us').html(setFormat(cp_real_us, 0));
        $('#cp_rkap_us').html(setFormat(cp_rkap_us, 0));
        $('#cp_min').html(setFormat(cp_min, 0));
        $('#cp_max').html(setFormat(cp_max, 0));
        $('#cp_rp').html(setFormat(cp_rp, 0));
        var cp_prog_us = Number(dataJson.prog_pakai[1100].prog_use);
$('#cp_prog').html(setFormat(cp_prog_us, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);




// graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}


function bahan_data_detail_gpg(bulan, opco, yearnow, type, plant) {
    run_waitMe('.wrapper', 'ios');
    console.log(yearnow);
    // console.log(bulan);
    // var param = (opco!='SMI')?'&company='+opco:'';
    var opco = '';

    if (sessionStorage.getItem('bahan-bln') != null) {
        var data = sessionStorage.getItem('bahan-bln');

        console.log(data);
        bulan = data;

    }
    if (sessionStorage.getItem('bahan-thn') != null) {
        var data = sessionStorage.getItem('bahan-thn');

        console.log(data);
        yearnow = data;

    }
    if (sessionStorage.getItem('bahan-opco') != null) {
        var data = sessionStorage.getItem('bahan-opco');

        console.log(data);
        opco = data;

    }
    if (sessionStorage.getItem('bahan-type') != null) {
        var data = sessionStorage.getItem('bahan-type');

        console.log(data);
        type = data;

    }
    if (sessionStorage.getItem('bahan-plant') != null) {
        var data = sessionStorage.getItem('bahan-plant');

        console.log(data);
        plant = data;

    }
    if (opco == '7000') {
        link = 'stok_bahan.html';
        judul = 'SEMEN GRESIK';
    }else
    if (opco == '3000') {
        link = 'stok_bahan_sp.html';
        judul = 'SEMEN PADANG';
    }else
    if (opco == '4000') {
        link = 'stok_bahan_st.html';
        judul = 'SEMEN TONASA';
    }else
    if (opco == '6000') {
        link = 'stok_bahan_tl.html';
        judul = 'THANG LONG';
    }
    console.log(bulan);

    $('#tag_month_selected').html(type);
    // $.post(url_src+'/api/index.php/Project', function(data){
    // $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){
    var label = [];
    var terima = [];
    var pakai = [];
    var prognose = [];

    var stok = [];
    var min = [];
    var max = [];
    var rp = [];
    // bulan = bulan-1;
    // if(bulan<10) {
    //     bulan='0'+bulan
    // }
    var index = [];
    $.get(url_src+'/api/index.php/c_coalstock/get_bahan_chart?material=' + type + '&plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        var dataJson = paradigma.json_parse(data);
        console.log(dataJson);
        var datax = Object.keys(dataJson).length;
        console.log(datax);
        for (x in dataJson) {
            index.push(x);
        }
        var iArray = index.sort();
console.log(iArray);
        $.each(iArray, function (index,val) {
            console.log(index);
            console.log(val);
            
            
            var prog = Number(dataJson[val].qty_min) + Number(dataJson[val].qty_max);
            label.push(val);
            if (dataJson[val].qty_pakai != null) {
                pakai.push(Number(dataJson[val].qty_pakai));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                pakai.push(Number(dataJson[val].pakai_prog));
            }
            
            if (dataJson[val].qty_terima != null) {
                terima.push(Number(dataJson[val].qty_terima));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                terima.push(Number(dataJson[val].terima_prog));
                }
            prognose.push(0);

            if (dataJson[val].qty_stok == null) {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }
            /*       
            pakai.push(Number(dataJson[val].pakai_prog));
            terima.push(Number(dataJson[val].terima_prog));
            prognose.push(0);

            if (dataJson[val].qty_stok = 'null') {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));*/
            
            min.push(Number(dataJson[val].qty_min));
            max.push(Number(dataJson[val].qty_max));
            rp.push(Number(dataJson[val].rp));
            
        /*    var c = index + 1;
            if (c < 10) {
                var c = '0' + c;
            }
            console.log(c);
            label.push(c);
            // console.log(index+'- pakai prog -> '+el.pakai_prog);
            var prog = Number(dataJson[c].qty_min) + Number(dataJson[c].qty_max);

            pakai.push(Number(dataJson[c].pakai_prog));
            terima.push(Number(dataJson[c].terima_prog));
            prognose.push(0);

            if (dataJson[c].qty_stok = 'null') {
                stok.push(Number(dataJson[c].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[c].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));*/
        });


        chart(label, pakai, terima, prognose, stok, min, max, rp);


    });
    $.post(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {

        dataJson = paradigma.json_parse(data, '.wrapper');

        console.log(dataJson);
        // try{
        //     var ar_stok = Number(dataJson.rkap[1700].rkap);
        //     }catch(e){
        //      console.log('data error');
        //      stop_waitMe('.wrapper');
        //      alert('Sorry, data is empty, please choose another month');
             
        //     }
        if (dataJson.rkap == 0) {
                var gpg_rkap_us = 0;

            } else {
                var gpg_rkap_us = Number(dataJson.rkap[1400].rkap);
            }


// production_cost
var gpg_stok = Number(dataJson.last[1400].qty_stok);
        //var gpg_stok = Number(dataJson.act_stok[1400].stok);
        var gpg_ua = Number(dataJson.stok[1400].stok);
        var gpg_din2 = Number(dataJson.stok[1400].stok);
        var gpg_din = Math.ceil(gpg_stok / gpg_din2);
        var gpg_real_rc = Number(dataJson.data[1400].terima);
        var gpg_real_us = Number(dataJson.data[1400].pakai);
        
        // var gpg_prog_us = '';
        var gpg_min = Number(dataJson.maxmin[1400].min);
        var gpg_max = Number(dataJson.maxmin[1400].max);
        var gpg_rp = Number(dataJson.maxmin[1400].rp);

        $('#gpg_stok').html(setFormat(gpg_stok, 0));
        $('#gpg_ua').html(setFormat(gpg_ua, 0));
        $('#gpg_din').html(gpg_din);
        $('#gpg_real_rc').html(setFormat(gpg_real_rc, 0));
        $('#gpg_real_us').html(setFormat(gpg_real_us, 0));
        $('#gpg_rkap_us').html(setFormat(gpg_rkap_us, 0));
        $('#gpg_min').html(setFormat(gpg_min, 0));
        $('#gpg_max').html(setFormat(gpg_max, 0));
        $('#gpg_rp').html(setFormat(gpg_rp, 0));
        var gpg_prog_us = Number(dataJson.prog_pakai[1400].prog_use);
$('#gpg_prog').html(setFormat(gpg_prog_us, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);




// graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}


function bahan_data_detail_gtj(bulan, opco, yearnow, type, plant) {
    run_waitMe('.wrapper', 'ios');
    console.log(yearnow);
    // console.log(bulan);
    // var param = (opco!='SMI')?'&company='+opco:'';
    var opco = '';

    if (sessionStorage.getItem('bahan-bln') != null) {
        var data = sessionStorage.getItem('bahan-bln');

        console.log(data);
        bulan = data;

    }
    if (sessionStorage.getItem('bahan-thn') != null) {
        var data = sessionStorage.getItem('bahan-thn');

        console.log(data);
        yearnow = data;

    }
    if (sessionStorage.getItem('bahan-opco') != null) {
        var data = sessionStorage.getItem('bahan-opco');

        console.log(data);
        opco = data;

    }
    if (sessionStorage.getItem('bahan-type') != null) {
        var data = sessionStorage.getItem('bahan-type');

        console.log(data);
        type = data;

    }
    if (sessionStorage.getItem('bahan-plant') != null) {
        var data = sessionStorage.getItem('bahan-plant');

        console.log(data);
        plant = data;

    }
    if (opco == '7000') {
        link = 'stok_bahan.html';
        judul = 'SEMEN GRESIK';
    }else
    if (opco == '3000') {
        link = 'stok_bahan_sp.html';
        judul = 'SEMEN PADANG';
    }else
    if (opco == '4000') {
        link = 'stok_bahan_st.html';
        judul = 'SEMEN TONASA';
    }else
    if (opco == '6000') {
        link = 'stok_bahan_tl.html';
        judul = 'THANG LONG';
    }
    console.log(bulan);

    $('#tag_month_selected').html(type);
    // $.post(url_src+'/api/index.php/Project', function(data){
    // $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){
    var label = [];
    var terima = [];
    var pakai = [];
    var prognose = [];

    var stok = [];
    var min = [];
    var max = [];
    var rp = [];
    // bulan = bulan-1;
    // if(bulan<10) {
    //     bulan='0'+bulan
    // }
    var index = [];
    $.get(url_src+'/api/index.php/c_coalstock/get_bahan_chart?material=' + type + '&plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        var dataJson = paradigma.json_parse(data);
        console.log(dataJson);
        var datax = Object.keys(dataJson).length;
        console.log(datax);
        for (x in dataJson) {
            index.push(x);
        }
        var iArray = index.sort();
console.log(iArray);
        $.each(iArray, function (index,val) {
            console.log(index);
            console.log(val);
            
            
            var prog = Number(dataJson[val].qty_min) + Number(dataJson[val].qty_max);
            label.push(val);
            if (dataJson[val].qty_pakai != null) {
                pakai.push(Number(dataJson[val].qty_pakai));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                pakai.push(Number(dataJson[val].pakai_prog));
            }
            
            if (dataJson[val].qty_terima != null) {
                terima.push(Number(dataJson[val].qty_terima));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                terima.push(Number(dataJson[val].terima_prog));
                }
            prognose.push(0);

            if (dataJson[val].qty_stok == null) {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }
            /*       
            pakai.push(Number(dataJson[val].pakai_prog));
            terima.push(Number(dataJson[val].terima_prog));
            prognose.push(0);

            if (dataJson[val].qty_stok = 'null') {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));*/
            
            min.push(Number(dataJson[val].qty_min));
            max.push(Number(dataJson[val].qty_max));
            rp.push(Number(dataJson[val].rp));
            
        /*    var c = index + 1;
            if (c < 10) {
                var c = '0' + c;
            }
            console.log(c);
            label.push(c);
            // console.log(index+'- pakai prog -> '+el.pakai_prog);
            var prog = Number(dataJson[c].qty_min) + Number(dataJson[c].qty_max);

            pakai.push(Number(dataJson[c].pakai_prog));
            terima.push(Number(dataJson[c].terima_prog));
            prognose.push(0);

            if (dataJson[c].qty_stok = 'null') {
                stok.push(Number(dataJson[c].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[c].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));*/
        });


        chart(label, pakai, terima, prognose, stok, min, max, rp);


    });
    var dataJson;
    $.post(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {

        dataJson = paradigma.json_parse(data, '.wrapper');

        console.log(dataJson);
        // try{
        //     var ar_stok = Number(dataJson.rkap[1700].rkap);
        //     }catch(e){
        //      console.log('data error');
        //      stop_waitMe('.wrapper');
        //      alert('Sorry, data is empty, please choose another month');
             
        //     }
        if (dataJson.rkap == 0) {
                var gtj_rkap_us = 0;

            } else {
                var gtj_rkap_us = Number(dataJson.rkap[1300].rkap);
            }

// production_cost
var gtj_stok = Number(dataJson.last[1300].qty_stok);
        //var gtj_stok = Number(dataJson.act_stok[1300].stok);
        var gtj_ua = Number(dataJson.stok[1300].stok);
        var gtj_din2 = Number(dataJson.stok[1300].stok);
        var gtj_din = Math.ceil(gtj_stok / gtj_din2);
        var gtj_real_rc = Number(dataJson.data[1300].terima);
        var gtj_real_us = Number(dataJson.data[1300].pakai);
        
        // var gtj_prog_us = '';
        var gtj_min = Number(dataJson.maxmin[1300].min);
        var gtj_max = Number(dataJson.maxmin[1300].max);
        var gtj_rp = Number(dataJson.maxmin[1300].rp);

        $('#gtj_stok').html(setFormat(gtj_stok, 0));
        $('#gtj_ua').html(setFormat(gtj_ua, 0));
        $('#gtj_din').html(gtj_din);
        $('#gtj_real_rc').html(setFormat(gtj_real_rc, 0));
        $('#gtj_real_us').html(setFormat(gtj_real_us, 0));
        $('#gtj_rkap_us').html(setFormat(gtj_rkap_us, 0));
        $('#gtj_min').html(setFormat(gtj_min, 0));
        $('#gtj_max').html(setFormat(gtj_max, 0));
        $('#gtj_rp').html(setFormat(gtj_rp, 0));
        var gtj_prog_us = Number(dataJson.prog_pakai[1300].prog_use);
$('#gtj_prog').html(setFormat(gtj_prog_us, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);




// graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}
//-----start bahan data gn-----------//

function bahan_data_detail_gn(bulan, opco, yearnow, type, plant) {
    run_waitMe('.wrapper', 'ios');
    console.log(yearnow);
    // console.log(bulan);
    // var param = (opco!='SMI')?'&company='+opco:'';
    var opco = '';

    if (sessionStorage.getItem('bahan-bln') != null) {
        var data = sessionStorage.getItem('bahan-bln');

        console.log(data);
        bulan = data;

    }
    if (sessionStorage.getItem('bahan-thn') != null) {
        var data = sessionStorage.getItem('bahan-thn');

        console.log(data);
        yearnow = data;

    }
    if (sessionStorage.getItem('bahan-opco') != null) {
        var data = sessionStorage.getItem('bahan-opco');

        console.log(data);
        opco = data;

    }
    if (sessionStorage.getItem('bahan-type') != null) {
        var data = sessionStorage.getItem('bahan-type');

        console.log(data);
        type = data;

    }
    if (sessionStorage.getItem('bahan-plant') != null) {
        var data = sessionStorage.getItem('bahan-plant');

        console.log(data);
        plant = data;

    }
    if (opco == '7000') {
        link = 'stok_bahan.html';
        judul = 'SEMEN GRESIK';
    }else
    if (opco == '3000') {
        link = 'stok_bahan_sp.html';
        judul = 'SEMEN PADANG';
    }else
    if (opco == '4000') {
        link = 'stok_bahan_st.html';
        judul = 'SEMEN TONASA';
    }else
    if (opco == '6000') {
        link = 'stok_bahan_tl.html';
        judul = 'THANG LONG';
    }
    console.log(bulan);

    $('#tag_month_selected').html(type);
    // $.post(url_src+'/api/index.php/Project', function(data){
    // $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){
    var label = [];
    var terima = [];
    var pakai = [];
    var prognose = [];

    var stok = [];
    var min = [];
    var max = [];
    var rp = [];
    // bulan = bulan-1;
    // if(bulan<10) {
    //     bulan='0'+bulan
    // }
    var index = [];
    $.get(url_src+'/api/index.php/c_coalstock/get_bahan_chart?material=' + type + '&plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        var dataJson = paradigma.json_parse(data);
        console.log(dataJson);
        var datax = Object.keys(dataJson).length;
        console.log(datax);
        for (x in dataJson) {
            index.push(x);
        }
        var iArray = index.sort();
console.log(iArray);
        $.each(iArray, function (index,val) {
            console.log(index);
            console.log(val);
            
            
            var prog = Number(dataJson[val].qty_min) + Number(dataJson[val].qty_max);
            label.push(val);
            if (dataJson[val].qty_pakai != null) {
                pakai.push(Number(dataJson[val].qty_pakai));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                pakai.push(Number(dataJson[val].pakai_prog));
            }
            
            if (dataJson[val].qty_terima != null) {
                terima.push(Number(dataJson[val].qty_terima));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                terima.push(Number(dataJson[val].terima_prog));
                }
            prognose.push(0);

            if (dataJson[val].qty_stok == null) {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }
            /*       
            pakai.push(Number(dataJson[val].pakai_prog));
            terima.push(Number(dataJson[val].terima_prog));
            prognose.push(0);

            if (dataJson[val].qty_stok = 'null') {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));*/
            
            min.push(Number(dataJson[val].qty_min));
            max.push(Number(dataJson[val].qty_max));
            rp.push(Number(dataJson[val].rp));
            
        /*    var c = index + 1;
            if (c < 10) {
                var c = '0' + c;
            }
            console.log(c);
            label.push(c);
            // console.log(index+'- pakai prog -> '+el.pakai_prog);
            var prog = Number(dataJson[c].qty_min) + Number(dataJson[c].qty_max);

            pakai.push(Number(dataJson[c].pakai_prog));
            terima.push(Number(dataJson[c].terima_prog));
            prognose.push(0);

            if (dataJson[c].qty_stok = 'null') {
                stok.push(Number(dataJson[c].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[c].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));*/
        });


        chart(label, pakai, terima, prognose, stok, min, max, rp);


    });
    var dataJson;
    $.post(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {

        dataJson = paradigma.json_parse(data, '.wrapper');

        console.log(dataJson);
        // try{
        //     var ar_stok = Number(dataJson.rkap[1700].rkap);
        //     }catch(e){
        //      console.log('data error');
        //      stop_waitMe('.wrapper');
        //      alert('Sorry, data is empty, please choose another month');
             
        //     }
        if (dataJson.rkap == 0) {
                var gn_rkap_us = 0;

            } else {
                var gn_rkap_us = Number(dataJson.rkap[2700].rkap);
            }

// production_cost
var gn_stok = Number(dataJson.last[2700].qty_stok);
        //var id_stok = Number(dataJson.act_stok[1500].stok);
        var gn_ua = Number(dataJson.stok[2700].stok);
        var gn_din2 = Number(dataJson.stok[2700].stok);
        var gn_din = Math.ceil(gn_stok / gn_din2);
        var gn_real_rc = Number(dataJson.data[2700].terima);
        var gn_real_us = Number(dataJson.data[2700].pakai);
        
        // var gn_prog_us = '';
        var gn_min = Number(dataJson.maxmin[2700].min);
        var gn_max = Number(dataJson.maxmin[2700].max);
        var gn_rp = Number(dataJson.maxmin[2700].rp);

        $('#gn_stok').html(setFormat(gn_stok, 0));
        $('#gn_ua').html(setFormat(gn_ua, 0));
        $('#gn_din').html(gn_din);
        $('#gn_real_rc').html(setFormat(gn_real_rc, 0));
        $('#gn_real_us').html(setFormat(gn_real_us, 0));
        $('#gn_rkap_us').html(setFormat(gn_rkap_us, 0));
        $('#gn_min').html(setFormat(gn_min, 0));
        $('#gn_max').html(setFormat(gn_max, 0));
        $('#gn_rp').html(setFormat(gn_rp, 0));

        var gn_prog_us = Number(dataJson.prog_pakai[2700].prog_use);
        console.log(gn_prog_us);
$('#gn_prog').html(setFormat(gn_prog_us, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);




// graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

//----end bahan data gy-------//
function bahan_data_detail_id(bulan, opco, yearnow, type, plant) {
    run_waitMe('.wrapper', 'ios');
    console.log(yearnow);
    // console.log(bulan);
    // var param = (opco!='SMI')?'&company='+opco:'';
    var opco = '';

    if (sessionStorage.getItem('bahan-bln') != null) {
        var data = sessionStorage.getItem('bahan-bln');

        console.log(data);
        bulan = data;

    }
    if (sessionStorage.getItem('bahan-thn') != null) {
        var data = sessionStorage.getItem('bahan-thn');

        console.log(data);
        yearnow = data;

    }
    if (sessionStorage.getItem('bahan-opco') != null) {
        var data = sessionStorage.getItem('bahan-opco');

        console.log(data);
        opco = data;

    }
    if (sessionStorage.getItem('bahan-type') != null) {
        var data = sessionStorage.getItem('bahan-type');

        console.log(data);
        type = data;

    }
    if (sessionStorage.getItem('bahan-plant') != null) {
        var data = sessionStorage.getItem('bahan-plant');

        console.log(data);
        plant = data;

    }
    if (opco == '7000') {
        link = 'stok_bahan.html';
        judul = 'SEMEN GRESIK';
    }else
    if (opco == '3000') {
        link = 'stok_bahan_sp.html';
        judul = 'SEMEN PADANG';
    }else
    if (opco == '4000') {
        link = 'stok_bahan_st.html';
        judul = 'SEMEN TONASA';
    }else
    if (opco == '6000') {
        link = 'stok_bahan_tl.html';
        judul = 'THANG LONG';
    }
    console.log(bulan);

    $('#tag_month_selected').html(type);
    // $.post(url_src+'/api/index.php/Project', function(data){
    // $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){
    var label = [];
    var terima = [];
    var pakai = [];
    var prognose = [];

    var stok = [];
    var min = [];
    var max = [];
    var rp = [];
    // bulan = bulan-1;
    // if(bulan<10) {
    //     bulan='0'+bulan
    // }
    var index = [];
    $.get(url_src+'/api/index.php/c_coalstock/get_bahan_chart?material=' + type + '&plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        var dataJson = paradigma.json_parse(data);
        console.log(dataJson);
        var datax = Object.keys(dataJson).length;
        console.log(datax);
        for (x in dataJson) {
            index.push(x);
        }
        var iArray = index.sort();
console.log(iArray);
        $.each(iArray, function (index,val) {
            console.log(index);
            console.log(val);
            
            
            var prog = Number(dataJson[val].qty_min) + Number(dataJson[val].qty_max);
            label.push(val);
            if (dataJson[val].qty_pakai != null) {
                pakai.push(Number(dataJson[val].qty_pakai));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                pakai.push(Number(dataJson[val].pakai_prog));
            }
            
            if (dataJson[val].qty_terima != null) {
                terima.push(Number(dataJson[val].qty_terima));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                terima.push(Number(dataJson[val].terima_prog));
                }
            prognose.push(0);

            if (dataJson[val].qty_stok == null) {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }
            /*       
            pakai.push(Number(dataJson[val].pakai_prog));
            terima.push(Number(dataJson[val].terima_prog));
            prognose.push(0);

            if (dataJson[val].qty_stok = 'null') {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));*/
            
            min.push(Number(dataJson[val].qty_min));
            max.push(Number(dataJson[val].qty_max));
            rp.push(Number(dataJson[val].rp));
            
        /*    var c = index + 1;
            if (c < 10) {
                var c = '0' + c;
            }
            console.log(c);
            label.push(c);
            // console.log(index+'- pakai prog -> '+el.pakai_prog);
            var prog = Number(dataJson[c].qty_min) + Number(dataJson[c].qty_max);

            pakai.push(Number(dataJson[c].pakai_prog));
            terima.push(Number(dataJson[c].terima_prog));
            prognose.push(0);

            if (dataJson[c].qty_stok = 'null') {
                stok.push(Number(dataJson[c].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[c].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));*/
        });


        chart(label, pakai, terima, prognose, stok, min, max, rp);


    });
    var dataJson;
    $.post(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {

        dataJson = paradigma.json_parse(data, '.wrapper');

        console.log(dataJson);
        // try{
        //     var ar_stok = Number(dataJson.rkap[1700].rkap);
        //     }catch(e){
        //      console.log('data error');
        //      stop_waitMe('.wrapper');
        //      alert('Sorry, data is empty, please choose another month');
             
        //     }
        if (dataJson.rkap == 0) {
                var id_rkap_us = 0;

            } else {
                var id_rkap_us = Number(dataJson.rkap[1500].rkap);
            }

// production_cost
var id_stok = Number(dataJson.last[1500].qty_stok);
        //var id_stok = Number(dataJson.act_stok[1500].stok);
        var id_ua = Number(dataJson.stok[1500].stok);
        var id_din2 = Number(dataJson.stok[1500].stok);
        var id_din = Math.ceil(id_stok / id_din2);
        var id_real_rc = Number(dataJson.data[1500].terima);
        var id_real_us = Number(dataJson.data[1500].pakai);
        
        // var id_prog_us = '';
        var id_min = Number(dataJson.maxmin[1500].min);
        var id_max = Number(dataJson.maxmin[1500].max);
        var id_rp = Number(dataJson.maxmin[1500].rp);

        $('#id_stok').html(setFormat(id_stok, 0));
        $('#id_ua').html(setFormat(id_ua, 0));
        $('#id_din').html(id_din);
        $('#id_real_rc').html(setFormat(id_real_rc, 0));
        $('#id_real_us').html(setFormat(id_real_us, 0));
        $('#id_rkap_us').html(setFormat(id_rkap_us, 0));
        $('#id_min').html(setFormat(id_min, 0));
        $('#id_max').html(setFormat(id_max, 0));
        $('#id_rp').html(setFormat(id_rp, 0));
        var id_prog_us = Number(dataJson.prog_pakai[1500].prog_use);
$('#id_prog').html(setFormat(id_prog_us, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);




// graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

function bahan_data_detail_sl(bulan, opco, yearnow, type, plant) {
    run_waitMe('.wrapper', 'ios');
    console.log(yearnow);
    // console.log(bulan);
    // var param = (opco!='SMI')?'&company='+opco:'';
    var opco = '';

    if (sessionStorage.getItem('bahan-bln') != null) {
        var data = sessionStorage.getItem('bahan-bln');

        console.log(data);
        bulan = data;

    }
    if (sessionStorage.getItem('bahan-thn') != null) {
        var data = sessionStorage.getItem('bahan-thn');

        console.log(data);
        yearnow = data;

    }
    if (sessionStorage.getItem('bahan-opco') != null) {
        var data = sessionStorage.getItem('bahan-opco');

        console.log(data);
        opco = data;

    }
    if (sessionStorage.getItem('bahan-type') != null) {
        var data = sessionStorage.getItem('bahan-type');

        console.log(data);
        type = data;

    }
    if (sessionStorage.getItem('bahan-plant') != null) {
        var data = sessionStorage.getItem('bahan-plant');

        console.log(data);
        plant = data;

    }
    if (opco == '7000') {
        link = 'stok_bahan.html';
        judul = 'SEMEN GRESIK';
    }else
    if (opco == '3000') {
        link = 'stok_bahan_sp.html';
        judul = 'SEMEN PADANG';
    }else
    if (opco == '4000') {
        link = 'stok_bahan_st.html';
        judul = 'SEMEN TONASA';
    }else
    if (opco == '6000') {
        link = 'stok_bahan_tl.html';
        judul = 'THANG LONG';
    }
    console.log(bulan);

    $('#tag_month_selected').html(type);
    // $.post(url_src+'/api/index.php/Project', function(data){
    // $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){
    var label = [];
    var terima = [];
    var pakai = [];
    var prognose = [];

    var stok = [];
    var min = [];
    var max = [];
    var rp = [];
    // bulan = bulan-1;
    // if(bulan<10) {
    //     bulan='0'+bulan
    // }
    var index = [];
    $.get(url_src+'/api/index.php/c_coalstock/get_bahan_chart?material=' + type + '&plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        var dataJson = paradigma.json_parse(data);
        console.log(dataJson);
        var datax = Object.keys(dataJson).length;
        console.log(datax);
        for (x in dataJson) {
            index.push(x);
        }
        var iArray = index.sort();
console.log(iArray);
        $.each(iArray, function (index,val) {
            console.log(index);
            console.log(val);
            
            
            var prog = Number(dataJson[val].qty_min) + Number(dataJson[val].qty_max);
            label.push(val);
            if (dataJson[val].qty_pakai != null) {
                pakai.push(Number(dataJson[val].qty_pakai));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                pakai.push(Number(dataJson[val].pakai_prog));
            }
            
            if (dataJson[val].qty_terima != null) {
                terima.push(Number(dataJson[val].qty_terima));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                terima.push(Number(dataJson[val].terima_prog));
                }
            prognose.push(0);

            if (dataJson[val].qty_stok == null) {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }
            /*       
            pakai.push(Number(dataJson[val].pakai_prog));
            terima.push(Number(dataJson[val].terima_prog));
            prognose.push(0);

            if (dataJson[val].qty_stok = 'null') {
                stok.push(Number(dataJson[val].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[val].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));*/
            
            min.push(Number(dataJson[val].qty_min));
            max.push(Number(dataJson[val].qty_max));
            rp.push(Number(dataJson[val].rp));
            
        /*    var c = index + 1;
            if (c < 10) {
                var c = '0' + c;
            }
            console.log(c);
            label.push(c);
            // console.log(index+'- pakai prog -> '+el.pakai_prog);
            var prog = Number(dataJson[c].qty_min) + Number(dataJson[c].qty_max);

            pakai.push(Number(dataJson[c].pakai_prog));
            terima.push(Number(dataJson[c].terima_prog));
            prognose.push(0);

            if (dataJson[c].qty_stok = 'null') {
                stok.push(Number(dataJson[c].stok_prog));
                // console.log('Datanya Null');
            }else{
                // console.log('Datanya tak null');
                stok.push(Number(dataJson[c].qty_stok));
            }

            // stok.push(Number(dataJson[c].qty_stok));
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));*/
        });

        chart(label, pakai, terima, prognose, stok, min, max, rp);


    });
    var dataJson;
    $.post(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {

        dataJson = paradigma.json_parse(data, '.wrapper');

        console.log(dataJson);
        // try{
        //     var ar_stok = Number(dataJson.rkap[1700].rkap);
        //     }catch(e){
        //      console.log('data error');
        //      stop_waitMe('.wrapper');
        //      alert('Sorry, data is empty, please choose another month');
        //     }
        if (dataJson.rkap == 0) {
                var sl_rkap_us = 0;

            } else {
                 var sl_rkap_us = Number(dataJson.rkap[1200].rkap);
            }

// production_cost

var sl_stok = Number(dataJson.last[1200].qty_stok);
        //var sl_stok = Number(dataJson.act_stok[1200].stok);
        var sl_ua = Number(dataJson.stok[1200].stok);
        var sl_din2 = Number(dataJson.stok[1200].stok);
        var sl_din = Math.ceil(sl_stok / sl_din2);
        var sl_real_rc = Number(dataJson.data[1200].terima);
        var sl_real_us = Number(dataJson.data[1200].pakai);
       
        // var sl_prog_us = '';
        var sl_min = Number(dataJson.maxmin[1200].min);
        var sl_max = Number(dataJson.maxmin[1200].max);
        var sl_rp = Number(dataJson.maxmin[1200].rp);

        $('#sl_stok').html(setFormat(sl_stok, 0));
        $('#sl_ua').html(setFormat(sl_ua, 0));
        $('#sl_din').html(sl_din);
        $('#sl_real_rc').html(setFormat(sl_real_rc, 0));
        $('#sl_real_us').html(setFormat(sl_real_us, 0));
        $('#sl_rkap_us').html(setFormat(sl_rkap_us, 0));
        $('#sl_min').html(setFormat(sl_min, 0));
        $('#sl_max').html(setFormat(sl_max, 0));
        $('#sl_rp').html(setFormat(sl_rp, 0));
        var sl_prog_us = Number(dataJson.prog_pakai[1200].prog_use);
$('#sl_prog').html(setFormat(sl_prog_us, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);




// graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}



// ############################ Sales volume ############################



function nextPage(company, bulan, tahun, type, plant) {
    console.log(company + '-' + bulan + '-' + tahun + '-');
    sessionStorage.setItem('bahan-bln', bulan);
    sessionStorage.setItem('bahan-opco', company);
    sessionStorage.setItem('bahan-thn', tahun);
    sessionStorage.setItem('bahan-type', type);
    sessionStorage.setItem('bahan-plant', plant);
    if (type == '1700') {
        type = 'afr'
    }
    if (type == '1100') {
        type = 'copper'
    }
    if (type == '1600') {
        type = 'bbara'
    }
    if (type == '1900') {
        type = 'klin'
    }
    if (type == '1200') {
        type = 'silika'
    }
    if (type == '1300') {
        type = 'gtj'
    }
    if (type == '1400') {
        type = 'gpg'
    }
    if (type == '1800') {
        type = 'ash'
    }
    if (type == '1500') {
        type = 'ido'
    }
    if (type == '2000') {
        type = 'kapur'
    }
    if (type == '1000') {
        type = 'tras'
    }
	if (type == '2700') {
        type = 'gn'
    }
	

    window.location.href = "bahan_" + type + ".html";
}

function graphicChart(now, last, label, hei) {
    Highcharts.chart('graphc', {
        chart: {
            backgroundColor: 'rgba(0, 255, 0, 0)',
            type: 'bar',
            height: hei
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: label,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' millions'
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
        },
        credits: {
            enabled: false
        },
        series: [{
                name: 'This Month',
                color: '#fed700',
                data: now
            }, {
                name: 'This Month Last Year',
                color: '#807d6e',
                data: last
            }]
    });
}

function graphicChart_opco(label, data) {
    Highcharts.chart('PlantCompare', {
        chart: {
            backgroundColor: 'rgba(0, 255, 0, 0)',
            type: 'bar',
            // height: 300,
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['G.ADM', 'COGS', 'COGM', 'Sell.MRT'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' millions'
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
        },
        credits: {
            enabled: false
        },
        series: [{
                name: 'SP',
                color: '#1E8BC3',
                data: data['3000']
            }, {
                name: 'SG',
                color: '#E9D460',
                data: data['7000']
            }, {
                name: 'ST',
                color: '#EF4836',
                data: data['4000']
            },
            // , {
            //     name: label[3],
            //     color: '#807d6e',
            //     data: data4
            // }
        ]
    });

    console.log('graphic has loaded');
}

var genrl = [];
var good = [];
var prod = [];
var selling = [];

var data = [];

// function opcoGroup (yearnow, bulan){
// 	genrl = [12,12,12];
// 	good = [12,12,12];
// 	prod = [12,12,12];
// 	selling = [12,12,12];

// 	data['3000'] = [];
// 	data['7000'] = [];
// 	data['4000'] = [];
// 	var total = 0;
// 	var urlsmi = url_src+'/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+'&company=smi';
// 	var url3000 = url_src+'/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+'&company=3000';
// 	var url4000 = url_src+'/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+'&company=4000';
// 	var url7000 = url_src+'/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+'&company=7000';
// 	var opco = [];
// 	// alert('haha');
// 	var label = ['General Admininstration', 'Good Of Sold', 'Production Cost', 'Selling Marketing'];

// 	// graphicChart_opco(label, genrl, good, prod, selling);

// 	$.when(
// 	    // $.getJSON(urlsmi),
// 	    $.getJSON(url3000),
// 	    $.getJSON(url4000),
// 	    $.getJSON(url7000)
// 	    ).done(function(result3000, result4000, result7000) {
// 	    	genrl = [];
// 			good = [];
// 			prod = [];
// 			selling = [];
// 	    	// console.log(result4000);
// 	    	plotPlantCompare('3000', result3000);
// 	    	plotPlantCompare('7000', result7000);
// 	    	plotPlantCompare('4000', result4000);

// 	    	// plotPlantCompare('3000', result3000);
// 	    	graphicChart_opco(label, data);
// 	    	console.log(genrl);
// 	    	console.log(good);
// 	    	console.log(prod);
// 	    	console.log(selling);



// 	    });

// }

// function plotPlantCompare(opco, dataJson){
// 	// var data = dataJson['s'+opco];
// 	var tableVal = dataJson["0"]['s'+opco]['0'].bulan_ini;
// 	var ga_tot = gos_tot = pc_tot = sm_tot = 0;
// 	console.log(tableVal);
// 	$.each(tableVal, function(index, el) {
// 		// console.log(index, el);
// 		$('#'+index+opco).html(setFormat(el));
// 	});


// 	var general_admininstration = dataJson['0'].general_admininstration['0'].bulan_ini;
// 	ga_tot = dataJson['0'].general_admininstration['0'].bulan_ini.Total ;//totalPlantCompare(general_admininstration);
// 	data[opco].push(Math.round(ga_tot/1000000));

// 	var good_of_sold = dataJson['0'].good_of_sold['0'].bulan_ini;
// 	gos_tot = dataJson['0'].good_of_sold['0'].bulan_ini.Total;//totalPlantCompare(good_of_sold);
// 	data[opco].push(Math.round(gos_tot/1000000));


// 	var production_cost = dataJson['0'].production_cost['0'].bulan_ini;
// 	pc_tot = dataJson['0'].production_cost['0'].bulan_ini.Total;//totalPlantCompare(production_cost);
// 	data[opco].push(Math.round(pc_tot/1000000));

// 	var selling_marketing = dataJson['0'].selling_marketing['0'].bulan_ini;
// 	sm_tot = dataJson['0'].selling_marketing['0'].bulan_ini.Total;totalPlantCompare(selling_marketing);
// 	data[opco].push(Math.round(sm_tot/1000000));
// }

// function totalPlantCompare(dataJson){
// 	var tempTotal = 0;
// 	$.each(dataJson, function(index, el) {
// 		tempTotal += Number(el);
// 		// console.log(index, el);
// 	});
// 	return tempTotal;
// }

function chart(label, pakai, terima, prognose, stok, min, max, rp) {
    Highcharts.chart('trialchart', {
        chart: {
            backgroundColor: 'rgba(0, 255, 0, 0)',
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: label
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        tooltip: {
            valueSuffix: ' T'
        },
        legend: {
            borderWidth: 0,
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            //shadow: true
        },
        plotOptions: {
            line: {
                marker: {
                    enabled: false
                }
            }
        },
        series: [{
                name: 'Terima',
                data: terima,
                color: '#D91E18',
                type: 'spline'
            }, {
                name: 'Pakai',
                data: pakai,
                color: '#26A65B',
                type: 'spline'
            }, {
                name: 'Prognose',
                data: prognose,
                color: '#BDC3C7',
                type: 'spline'
            }]
    });

    Highcharts.chart('trialchartmm', {
        chart: {
            backgroundColor: 'rgba(0, 255, 0, 0)',
        },
        title: {
            text: ''
        },
        xAxis: {
            // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            //     'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            categories: label
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        tooltip: {
            valueSuffix: ' T'
        },
        legend: {
            borderWidth: 0,
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            //shadow: true
        },
        plotOptions: {
            line: {
                marker: {
                    enabled: false
                }
            }
        },
        series: [{
                name: 'Stock',
                data: stok,
                color: '#19B5FE',
                type: 'spline'
            }, {
                name: 'Min',
                data: min,
                color: '#D91E18',
                type: 'line'
            }, {
                name: 'Max',
                data: max,
                color: '#26A65B',
                type: 'line'
            }
            // , {
            //     name: 'Rp',
            //     data: rp,
            //     color: '#F9BF3B',
            //     type: 'line'
            // }
            ]
    });
}