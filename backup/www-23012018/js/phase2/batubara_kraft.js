/**
 * Created by robi on 29/05/2017.
 */


function getAFRopco(opco, bulan, tahun) {
    console.log(opco);
    var dts;
    var isiTabel = "";
    var isiDefault = '<tr rel="asset" class=""><td valign="middle" align="center" id="ar_stok" CLASS="fblack">' + '-' + '</td><td valign="middle" align="center" id="ar_min" CLASS="fblack">' + '-' + '</td><td valign="middle" align="center" id="ar_max" CLASS="fblack">' + 0 + '</td><td valign="middle" align="center" id="ar_max" CLASS="fblack">' + 0 + '</td></tr>';
    var apiSG = url_ol + '/api/index.php/material_usage/get_coal_usage?company=' + opco + '&tahun=' + tahun + '&bulan=' + bulan;

    $.ajax({
        url: apiSG
    }).done(function (datas) {
        $("#dtTabelAFR").html(isiDefault);
        var dt = (JSON.parse(datas));
        var dts = dt.data;
        isiTabel = "";
        var count = Object.keys(dts).length;
        // for (var i = 1; i <= count; i++){
        //     console.log(dts[i].WERKS);
        //     // isiTabel += '<tr rel="asset" class=""><td valign="middle" align="center" id="ar_stok" CLASS="fblack">'+dts[i]['WERKS'] +'</td><td valign="middle" align="center" id="ar_min" CLASS="fblack">'+dts[i]['MAKTX']+'</td><td valign="middle" align="center" id="ar_max" CLASS="fblack">'+dts[i]['MENGE']+'</td><td valign="middle" align="center" id="ar_max" CLASS="fblack">'+dts[i]['DMBTR']+'</td></tr>';
        // }

        console.log(count);
        if( count == 0){
            console.log('datakosong')
        }else {
            console.log('dataisi ' + count)
            var i = 0;
            for (var key in dts) {
                console.log(dts[key].WERKS);
                isiTabel += '<tr rel="asset" class=""><td valign="middle" align="" id="ar_stok" CLASS="fblack">' + dts[key]['WERKS'] + '</td><td valign="middle" align="center" id="ar_min" CLASS="fblack">' + dts[key]['MAKTX'] + '</td><td valign="middle" align="center" id="ar_max" CLASS="fblack">' + dts[key]['MENGE'] + '</td><td valign="middle" align="right" id="ar_max" CLASS="fblack">' + dts[key]['DMBTR'] + '</td></tr>';
                i++;
            }
            $("#dtTabelAFR").html(isiTabel);
        }

    });

}