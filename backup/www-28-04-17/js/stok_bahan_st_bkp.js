var label = [];
var now = [];
var last = [];
var hei = '';
function bahan_data(bulan, opco, yearnow, plant) {

    run_waitMe('.wrapper', 'ios');
    bulan = bulan-1;
    if(bulan<10) {
        bulan='0'+bulan
    }
    $.post(url_src+'/api/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        // $.post(url_src+'/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+param, function(data){

            
             // var dataJson = JSON.parse(data);

        var dataJson = paradigma.json_parse(data, '.wrapper');
        console.log(dataJson);
        console.log('Plsnt' + plant);


        // ############## NOW
        
        try{
            var bb_stok = Number(dataJson.act_stok[1600].stok);
            }catch(e){
             console.log('data error');
             stop_waitMe('.wrapper');
             alert('Sorry, data is empty, please choose another month');
             
            }

		var bb_stok = Number(dataJson.last[1600].qty_stok);
        var bb_ua = Number(dataJson.stok[1600].stok);
        var bb_din2 = Number(dataJson.stok[1600].stok);
        var bb_din = Math.ceil(bb_stok / bb_din2);
        var bb_min = Number(dataJson.maxmin[1600].min);
        var bb_max = Number(dataJson.maxmin[1600].max);
        var bb_rp = Number(dataJson.maxmin[1600].rp);
        var tgl = dataJson.last[1600].update;
		
        //var cp_stok = Number(dataJson.act_stok[1100].stok);
        var cp_stok = Number(dataJson.last[1100].qty_stok);
		var cp_ua = Number(dataJson.stok[1100].stok);
        var cp_din2 = Number(dataJson.stok[1100].stok);
        var cp_din = Math.ceil(cp_stok / cp_din2);
        var cp_min = Number(dataJson.maxmin[1100].min);
        var cp_max = Number(dataJson.maxmin[1100].max);
        var cp_rp = Number(dataJson.maxmin[1100].rp);
		
		var sr_stok = Number(dataJson.last[2100].qty_stok);
        //var sr_stok = Number(dataJson.act_stok[2100].stok);
        var sr_ua = Number(dataJson.stok[2100].stok);
        var sr_din2 = Number(dataJson.stok[2100].stok);
        var sr_din = Math.ceil(sr_stok / sr_din2);
         var sr_min = Number(dataJson.maxmin[2100].min);
         var sr_max = Number(dataJson.maxmin[2100].max);
         var sr_rp = Number(dataJson.maxmin[2100].rp);

        //var gy_stok = Number(dataJson.act_stok[2200].stok);
        var gy_stok = Number(dataJson.last[2200].qty_stok);
		var gy_ua = Number(dataJson.stok[2200].stok);
        var gy_din2 = Number(dataJson.stok[2200].stok);
        var gy_din = Math.ceil(gy_stok / gy_din2);
        var gy_min = Number(dataJson.maxmin[2200].min);
        var gy_max = Number(dataJson.maxmin[2200].max);
        var gy_rp = Number(dataJson.maxmin[2200].rp);

         //var pz_stok = Number(dataJson.act_stok[2300].stok);
        var pz_stok = Number(dataJson.last[2300].qty_stok);
		var pz_ua = Number(dataJson.stok[2300].stok);
        var pz_din2 = Number(dataJson.stok[2300].stok);
        var pz_din = Math.ceil(pz_stok / pz_din2);
         var pz_min = Number(dataJson.maxmin[2300].min);
         var pz_max = Number(dataJson.maxmin[2300].max);
         var pz_rp = Number(dataJson.maxmin[2300].rp);

         //var cy_stok = Number(dataJson.act_stok[2400].stok);
        var cy_stok = Number(dataJson.last[2400].qty_stok);
		var cy_ua = Number(dataJson.stok[2400].stok);
        var cy_din2 = Number(dataJson.stok[2400].stok);
        var cy_din = Math.ceil(cy_stok / cy_din2);
        var cy_min = Number(dataJson.maxmin[2400].min);
        var cy_max = Number(dataJson.maxmin[2400].max);
        var cy_rp = Number(dataJson.maxmin[2400].rp);

       

        // console.log('stok' + ar_stok);
        // console.log('ua' + ar_ua);
        // console.log('day invent' + ar_din);


// TOTAL #################################################################################################################
        $('#gy_stok').html(setFormat(gy_stok, 0));
        $('#gy_ua').html(setFormat(gy_ua, 0));
        $('#gy_din').html(Math.ceil(gy_din));
        $('#gy_min').html(setFormat(gy_min, 0));
        $('#gy_max').html(setFormat(gy_max, 0));
        $('#gy_rp').html(setFormat(gy_rp, 0));


        $('#tanggal').html(tgl);

        $('#pz_stok').html(setFormat(pz_stok, 0));
        $('#pz_ua').html(setFormat(pz_ua, 0));
        $('#pz_din').html(Math.ceil(pz_din));
        $('#pz_min').html(setFormat(pz_min, 0));
        $('#pz_max').html(setFormat(pz_max, 0));
        $('#pz_rp').html(setFormat(pz_rp, 0));

        

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


        $('#cy_stok').html(setFormat(cy_stok, 0));
        $('#cy_ua').html(setFormat(cy_ua, 0));
        $('#cy_din').html(Math.ceil(cy_din));
        $('#cy_min').html(setFormat(cy_min, 0));
        $('#cy_max').html(setFormat(cy_max, 0));
        $('#cy_rp').html(setFormat(cy_rp, 0));



        $('#sr_stok').html(setFormat(sr_stok, 0));
        $('#sr_ua').html(setFormat(sr_ua, 0));
        $('#sr_din').html(Math.ceil(sr_din));
        $('#sr_min').html(setFormat(sr_min, 0));
        $('#sr_max').html(setFormat(sr_max, 0));
        $('#sr_rp').html(setFormat(sr_rp, 0));



// TOTAL #################################################################################################################

        if ( gy_stok <= gy_min){
            $('#gy_sd').addClass('redmm');
            $('#gy_sd').removeClass('ylmm');
            $('#gy_sd').removeClass('grmm');
            $('#gy_sd').removeClass('blmm');
            $('#gy_bt').addClass('rdbt');
            $('#gy_bt').removeClass('grbt');
            $('#gy_bt').removeClass('ylbt');
            $('#gy_bt').removeClass('blbt');
        }else if ( gy_stok > gy_max) {
            $('#gy_sd').addClass('blmm');
            $('#gy_sd').removeClass('ylmm');
            $('#gy_sd').removeClass('grmm');
            $('#gy_sd').removeClass('redmm');
            $('#gy_bt').addClass('blbt');
            $('#gy_bt').removeClass('grbt');
            $('#gy_bt').removeClass('ylbt');
            $('#gy_bt').removeClass('rdbt');
        }else if ( gy_stok > gy_min && gy_stok < gy_max) {
            $('#gy_sd').addClass('grmm');
            $('#gy_sd').removeClass('ylmm');
            $('#gy_sd').removeClass('blmm');
            $('#gy_sd').removeClass('redmm');
            $('#gy_bt').addClass('grbt');
            $('#gy_bt').removeClass('blbt');
            $('#gy_bt').removeClass('ylbt');
            $('#gy_bt').removeClass('rdbt');
        }else if ( gy_stok <= gy_rp) {
            $('#gy_sd').addClass('ylmm');
            $('#gy_sd').removeClass('grmm');
            $('#gy_sd').removeClass('blmm');
            $('#gy_sd').removeClass('redmm');
            $('#gy_bt').addClass('ylbt');
            $('#gy_bt').removeClass('blbt');
            $('#gy_bt').removeClass('grbt');
            $('#gy_bt').removeClass('rdbt');
        }

        if ( pz_stok <= pz_min){
            $('#pz_sd').addClass('redmm');
            $('#pz_sd').removeClass('ylmm');
            $('#pz_sd').removeClass('grmm');
            $('#pz_sd').removeClass('blmm');
            $('#pz_bt').addClass('rdbt');
            $('#pz_bt').removeClass('grbt');
            $('#pz_bt').removeClass('ylbt');
            $('#pz_bt').removeClass('blbt');
        }else if ( pz_stok > pz_max) {
            $('#pz_sd').addClass('blmm');
            $('#pz_sd').removeClass('ylmm');
            $('#pz_sd').removeClass('grmm');
            $('#pz_sd').removeClass('redmm');
            $('#pz_bt').addClass('blbt');
            $('#pz_bt').removeClass('grbt');
            $('#pz_bt').removeClass('ylbt');
            $('#pz_bt').removeClass('rdbt');
        }else if ( pz_stok > pz_min && pz_stok < pz_max) {
            $('#pz_sd').addClass('grmm');
            $('#pz_sd').removeClass('ylmm');
            $('#pz_sd').removeClass('blmm');
            $('#pz_sd').removeClass('redmm');
            $('#pz_bt').addClass('grbt');
            $('#pz_bt').removeClass('blbt');
            $('#pz_bt').removeClass('ylbt');
            $('#pz_bt').removeClass('rdbt');
        }else if ( pz_stok <= pz_rp) {
            $('#pz_sd').addClass('ylmm');
            $('#pz_sd').removeClass('grmm');
            $('#pz_sd').removeClass('blmm');
            $('#pz_sd').removeClass('redmm');
            $('#pz_bt').addClass('ylbt');
            $('#pz_bt').removeClass('blbt');
            $('#pz_bt').removeClass('grbt');
            $('#pz_bt').removeClass('rdbt');
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


        if ( cy_stok <= cy_min){
            $('#cy_sd').addClass('redmm');
            $('#cy_sd').removeClass('ylmm');
            $('#cy_sd').removeClass('grmm');
            $('#cy_sd').removeClass('blmm');
            $('#cy_bt').addClass('rdbt');
            $('#cy_bt').removeClass('grbt');
            $('#cy_bt').removeClass('ylbt');
            $('#cy_bt').removeClass('blbt');
        }else if ( cy_stok > cy_max) {
            $('#cy_sd').addClass('blmm');
            $('#cy_sd').removeClass('ylmm');
            $('#cy_sd').removeClass('grmm');
            $('#cy_sd').removeClass('redmm');
            $('#cy_bt').addClass('blbt');
            $('#cy_bt').removeClass('grbt');
            $('#cy_bt').removeClass('ylbt');
            $('#cy_bt').removeClass('rdbt');
        }else if ( cy_stok > cy_min && cy_stok < cy_max) {
            $('#cy_sd').addClass('grmm');
            $('#cy_sd').removeClass('ylmm');
            $('#cy_sd').removeClass('blmm');
            $('#cy_sd').removeClass('redmm');
            $('#cy_bt').addClass('grbt');
            $('#cy_bt').removeClass('blbt');
            $('#cy_bt').removeClass('ylbt');
            $('#cy_bt').removeClass('rdbt');
        }else if ( cy_stok <= cy_rp) {
            $('#cy_sd').addClass('ylmm');
            $('#cy_sd').removeClass('grmm');
            $('#cy_sd').removeClass('blmm');
            $('#cy_sd').removeClass('redmm');
            $('#cy_bt').addClass('ylbt');
            $('#cy_bt').removeClass('blbt');
            $('#cy_bt').removeClass('grbt');
            $('#cy_bt').removeClass('rdbt');
        }

        

        if ( sr_stok <= sr_min){
            $('#sr_sd').addClass('redmm');
            $('#sr_sd').removeClass('ylmm');
            $('#sr_sd').removeClass('grmm');
            $('#sr_sd').removeClass('blmm');
            $('#sr_bt').addClass('rdbt');
            $('#sr_bt').removeClass('grbt');
            $('#sr_bt').removeClass('ylbt');
            $('#sr_bt').removeClass('blbt');
        }else if ( sr_stok > sr_max) {
            $('#sr_sd').addClass('blmm');
            $('#sr_sd').removeClass('ylmm');
            $('#sr_sd').removeClass('grmm');
            $('#sr_sd').removeClass('redmm');
            $('#sr_bt').addClass('blbt');
            $('#sr_bt').removeClass('grbt');
            $('#sr_bt').removeClass('ylbt');
            $('#sr_bt').removeClass('rdbt');
        }else if ( sr_stok > sr_min && sr_stok < sr_max) {
            $('#sr_sd').addClass('grmm');
            $('#sr_sd').removeClass('ylmm');
            $('#sr_sd').removeClass('blmm');
            $('#sr_sd').removeClass('redmm');
            $('#sr_bt').addClass('grbt');
            $('#sr_bt').removeClass('blbt');
            $('#sr_bt').removeClass('ylbt');
            $('#sr_bt').removeClass('rdbt');
        }else if ( sr_stok <= sr_rp) {
            $('#sr_sd').addClass('ylmm');
            $('#sr_sd').removeClass('grmm');
            $('#sr_sd').removeClass('blmm');
            $('#sr_sd').removeClass('redmm');
            $('#sr_bt').addClass('ylbt');
            $('#sr_bt').removeClass('blbt');
            $('#sr_bt').removeClass('grbt');
            $('#sr_bt').removeClass('rdbt');
        }



        stop_waitMe('.wrapper');


    });


}

function bahan_data_detail_gy(bulan, opco, yearnow, type, plant) {
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
    bulan = bulan-1;
    if(bulan<10) {
        bulan='0'+bulan
    }
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

        $.each(iArray, function (index) {

            var c = index + 1;
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
            min.push(Number(dataJson[c].qty_min));
            max.push(Number(dataJson[c].qty_max));
            rp.push(Number(dataJson[c].rp));
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
                var gy_rkap_us = 0;

            } else {
                var gy_rkap_us = Number(dataJson.rkap[2200].rkap);
            }

        // production_cost
        var gy_stok = Number(dataJson.last[2200].qty_stok);
		//var gy_stok = Number(dataJson.act_stok[2200].stok);
        var gy_ua = Number(dataJson.stok[2200].stok);
        var gy_din2 = Number(dataJson.stok[2200].stok);
        var gy_din = Math.ceil(gy_stok / gy_din2);
        var gy_real_rc = Number(dataJson.data[2200].terima);
        var gy_real_us = Number(dataJson.data[2200].pakai);
        
        var gy_prog_us = '';
        var gy_min = Number(dataJson.maxmin[2200].min);
        var gy_max = Number(dataJson.maxmin[2200].max);
        var gy_rp = Number(dataJson.maxmin[2200].rp);

        $('#gy_stok').html(setFormat(gy_stok, 0));
        $('#gy_ua').html(setFormat(gy_ua, 0));
        $('#gy_din').html(gy_din);
        $('#gy_real_rc').html(setFormat(gy_real_rc, 0));
        $('#gy_real_us').html(setFormat(gy_real_us, 0));
        $('#gy_rkap_us').html(setFormat(gy_rkap_us, 0));
        $('#gy_min').html(setFormat(gy_min, 0));
        $('#gy_max').html(setFormat(gy_max, 0));
        $('#gy_rp').html(setFormat(gy_rp, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);



        // graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

function bahan_data_detail_pz(bulan, opco, yearnow, type, plant) {
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
    bulan = bulan-1;
    if(bulan<10) {
        bulan='0'+bulan
    }
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

        $.each(iArray, function (index) {

            var c = index + 1;
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
            rp.push(Number(dataJson[c].rp));
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
                var pz_rkap_us = 0;

            } else {
                var pz_rkap_us = Number(dataJson.rkap[2300].rkap);
            }

// production_cost
        var pz_stok = Number(dataJson.last[2300].qty_stok);
		//var pz_stok = Number(dataJson.act_stok[2300].stok);
        var pz_ua = Number(dataJson.stok[2300].stok);
        var pz_din2 = Number(dataJson.stok[2300].stok);
        if (pz_din2 = '0') {
            var pz_din = 0
        } else{
            var pz_din = Math.ceil(pz_stok / pz_din2);
        }
        // var pz_real_rc = Number(dataJson.data[2300].terima);
        // var pz_real_us = Number(dataJson.data[2300].pakai);
        
        var pz_prog_us = '';
        // var pz_min = Number(dataJson.maxmin[2300].min);
        // var pz_max = Number(dataJson.maxmin[2300].max);
        // var pz_rp = Number(dataJson.maxmin[2300].rp);

        $('#pz_stok').html(setFormat(pz_stok, 0));
        $('#pz_ua').html(setFormat(pz_ua, 0));
        $('#pz_din').html(pz_din);
        $('#pz_real_rc').html(setFormat(pz_real_rc, 0));
        $('#pz_real_us').html(setFormat(pz_real_us, 0));
        $('#pz_rkap_us').html(setFormat(pz_rkap_us, 0));
        $('#pz_min').html(setFormat(pz_min, 0));
        $('#pz_max').html(setFormat(pz_max, 0));
        $('#pz_rp').html(setFormat(pz_rp, 0));

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
    bulan = bulan-1;
    if(bulan<10) {
        bulan='0'+bulan
    }
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

        $.each(iArray, function (index) {

            var c = index + 1;
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
            rp.push(Number(dataJson[c].rp));
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
                var bb_rkap_us = Number(dataJson.rkap[1600].rkap);
            }

// production_cost
        var bb_stok = Number(dataJson.last[1600].qty_stok);
		//var bb_stok = Number(dataJson.act_stok[1600].stok);
        var bb_ua = Number(dataJson.stok[1600].stok);
        var bb_din2 = Number(dataJson.stok[1600].stok);
        var bb_din = Math.ceil(bb_stok / bb_din2);
        var bb_real_rc = Number(dataJson.data[1600].terima);
        var bb_real_us = Number(dataJson.data[1600].pakai);
        
        var bb_prog_us = '';
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
    console.log('ioyyy',yearnow);
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
    bulan = bulan-1;
    if(bulan<10) {
        bulan='0'+bulan
    }
    console.log(bulan);
    console.log('teeeeessss');
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

        $.each(iArray, function (index) {

            var c = index + 1;
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
            rp.push(Number(dataJson[c].rp));
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
        
        var cp_prog_us = '';
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

        $('#linked').attr('href',link);
        $('#head').html(judul);




// graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}


function bahan_data_detail_cy(bulan, opco, yearnow, type, plant) {
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
    bulan = bulan-1;
    if(bulan<10) {
        bulan='0'+bulan
    }
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

        $.each(iArray, function (index) {

            var c = index + 1;
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
            rp.push(Number(dataJson[c].rp));
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
                var cy_rkap_us = 0;

            } else {
                var cy_rkap_us = Number(dataJson.rkap[2400].rkap);
            }


// production_cost
        var cy_stok = Number(dataJson.last[2400].qty_stok);
		//var cy_stok = Number(dataJson.act_stok[2400].stok);
        var cy_ua = Number(dataJson.stok[2400].stok);
        var cy_din2 = Number(dataJson.stok[2400].stok);
        var cy_din = Math.ceil(cy_stok / cy_din2);
        var cy_real_rc = Number(dataJson.data[2400].terima);
        var cy_real_us = Number(dataJson.data[2400].pakai);
        
        var cy_prog_us = '';
        var cy_min = Number(dataJson.maxmin[2400].min);
        var cy_max = Number(dataJson.maxmin[2400].max);
        var cy_rp = Number(dataJson.maxmin[2400].rp);

        $('#cy_stok').html(setFormat(cy_stok, 0));
        $('#cy_ua').html(setFormat(cy_ua, 0));
        $('#cy_din').html(cy_din);
        $('#cy_real_rc').html(setFormat(cy_real_rc, 0));
        $('#cy_real_us').html(setFormat(cy_real_us, 0));
        $('#cy_rkap_us').html(setFormat(cy_rkap_us, 0));
        $('#cy_min').html(setFormat(cy_min, 0));
        $('#cy_max').html(setFormat(cy_max, 0));
        $('#cy_rp').html(setFormat(cy_rp, 0));

        $('#linked').attr('href',link);
        $('#head').html(judul);




// graphicChart(now, last, label, '350');

        stop_waitMe('.wrapper');


    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}


function bahan_data_detail_sr(bulan, opco, yearnow, type, plant) {
    run_waitMe('.wrapper', 'ios');
    console.log(bulan);
    console.log(bulan);
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
    bulan = bulan-1;
    if(bulan<10) {
        bulan='0'+bulan
    }
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
    $.get(url_src+'/api/index.php/c_coalstock/get_bahan_chart?material=' + type + '&plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        var dataJson = paradigma.json_parse(data);
        console.log(dataJson);
        var datax = Object.keys(dataJson).length;
        console.log(datax);
        for (x in dataJson) {
            index.push(x);
        }
        var iArray = index.sort();

        $.each(iArray, function (index) {

            var c = index + 1;
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
            rp.push(Number(dataJson[c].rp));
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
                var sr_rkap_us = 0;

            } else {
                 var sr_rkap_us = Number(dataJson.rkap[2100].rkap);
            }

// production_cost

		var sr_stok = Number(dataJson.last[2100].qty_stok);
        //var sr_stok = Number(dataJson.act_stok[2100].stok);
        var sr_ua = Number(dataJson.stok[2100].stok);
        var sr_din2 = Number(dataJson.stok[2100].stok);
        if (sr_din2 = '0') {
            var sr_din = 0
        } else{
            var sr_din = Math.ceil(sr_stok / sr_din2);
        }
        // var sr_real_rc = Number(dataJson.data[2100].terima);
        // var sr_real_us = Number(dataJson.data[2100].pakai);
       
        var sr_prog_us = '';
        // var sr_min = Number(dataJson.maxmin[2100].min);
        // var sr_max = Number(dataJson.maxmin[2100].max);
        // var sr_rp = Number(dataJson.maxmin[2100].rp);

        $('#sr_stok').html(setFormat(sr_stok, 0));
        $('#sr_ua').html(setFormat(sr_ua, 0));
        $('#sr_din').html(sr_din);
        $('#sr_real_rc').html(setFormat(sr_real_rc, 0));
        $('#sr_real_us').html(setFormat(sr_real_us, 0));
        $('#sr_rkap_us').html(setFormat(sr_rkap_us, 0));
        $('#sr_min').html(setFormat(sr_min, 0));
        $('#sr_max').html(setFormat(sr_max, 0));
        $('#sr_rp').html(setFormat(sr_rp, 0));

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
    if (type == '2100') {
        type = 'solar'
    }
    if (type == '2200') {
        type = 'gyp'
    }
    if (type == '2300') {
        type = 'poz'
    }
    if (type == '2400') {
        type = 'clay'
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
            }, {
                name: 'Rp',
                data: rp,
                color: '#F9BF3B',
                type: 'line'
            }]
    });
}