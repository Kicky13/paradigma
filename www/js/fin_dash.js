var label = [];
var now = [];
var last = [];
var hei = '';
var judul ='';
var link = '';
function fin_data(bulan, opco , yearnow) {
    // setParam(opco, bulan, yearnow);
    // $('#data-volume').removeClass('hidden');
    // $('#data-revenew').addClass('hidden');
    // $('#tab-volume').addClass('act_tb');
    // $('#tab-revenew').removeClass('act_tb');
    var tag_bulan = bulan-1;
    if (tag_bulan<0) {
        tag_bulan = 11;
      }
    
    console.log(bulan);
    console.log(yearnow);
    console.log(opco);
    console.log(tag_bulan);

    console.log(month[tag_bulan]);
    console.log(month[tag_bulan]+' '+yearnow);
    console.log("Up To "+month[tag_bulan]);
    console.log("Kinerja Up To "+month[tag_bulan]+' '+yearnow);

    $('#tagMonth').html(month[tag_bulan]);
    $('#thismolast').html("Kinerja "+month[tag_bulan]+' '+yearnow);
    $('#tagupMonth').html("Up To "+month[tag_bulan]);
    $('#thismolastup').html("Kinerja Up To "+month[tag_bulan]+' '+yearnow);

    run_waitMe('.wrapper', 'ios');
    $.post(url_src+'/api/index.php/performance/mix?company='+opco+'&bulan='+yearnow+'.'+bulan, function (data) {

    // $.post('http://par4digma.semenindonesia.comapi/index.php/c_coalstock/get_data_bahan?plant=' + plant + '&opco=' + opco + '&tahun=' + yearnow + '&bulan=' + bulan, function (data) {
        // $.post(url_src+'/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+param, function(data){

            
             // var dataJson = JSON.parse(data);

        var dataJson = paradigma.json_parse(data, '.wrapper');
        console.log(dataJson);
        console.log('Data ecit '+dataJson.variance_ebit);
        console.log(typeof(dataJson.variance_ebit));
        // console.log('Plsnt' + plant);


       
        
        try{
            var vari_now = Number(dataJson.variance_ebit);
            }catch(e){
             console.log('data error');
             stop_waitMe('.wrapper');
             alert('Sorry, data is empty, please choose another month');
             
            }
 // ############## NOW
        var vari_now = Number(dataJson.variance_ebit)/1000000000;
        var vari_vol_now = Number(dataJson.variance_vol)/1000;
        var vari_price_now = Number(dataJson.variance_price)/1000;
        var vari_cost_now = Number(dataJson.variance_cost)/1000000000;

        var real_vol_now = Number(dataJson.real_vol)/1000;
        var real_rev_now = Number(dataJson.real_rev)/1000000000;
        var real_net_now = Number(dataJson.real_net)/1000000000;
        var real_ebit_now = Number(dataJson.real_ebit)/1000000000;
        var real_eat_now = 0;

        var rkap_vol_now = Number(dataJson.rkap_vol)/1000;
        var rkap_rev_now = Number(dataJson.rkap_rev)/1000000000;
        var rkap_net_now = Number(dataJson.rkap_net)/1000000000;
        var rkap_ebit_now = Number(dataJson.rkap_ebit)/1000000000;
        var rkap_eat_now = 0;

        // var prs_vol_now = (real_vol_now/rkap_vol_now)*100;
        // var prs_rev_now = (real_rev_now/rkap_rev_now)*100;
        // var prs_net_now = (real_net_now/rkap_net_now)*100;
        // var prs_ebit_now = (real_ebit_now/rkap_ebit_now)*100;
        // var prs_eat_now = (real_eat_now/rkap_eat_now)*100;

        var prs_vol_now = dataJson.persen_vol;
        var prs_rev_now = dataJson.persen_rev;
        var prs_net_now = dataJson.persen_net;
        var prs_ebit_now = dataJson.persen_ebit;
        var prs_eat_now = dataJson.persen_eat;



// UP #################################################################################################################


        var vari_up = Number(dataJson.variance_ebit_up)/1000000000;
        var vari_vol_up = Number(dataJson.variance_vol_up)/1000;
        var vari_price_up = Number(dataJson.variance_price_up)/1000;
        var vari_cost_up = Number(dataJson.variance_cost_up)/1000000000;

        var real_vol_up = Number(dataJson.real_vol_up)/1000;
        var real_rev_up = Number(dataJson.real_rev_up)/1000000000;
        var real_net_up = Number(dataJson.real_net_up)/1000000000;
        var real_ebit_up = Number(dataJson.real_ebit_up)/1000000000;
        var real_eat_up = 0;
         var rkap_vol_up = Number(dataJson.rkap_vol_up)/1000;
        var rkap_rev_up = Number(dataJson.rkap_rev_up)/1000000000;
        var rkap_net_up = Number(dataJson.rkap_net_up)/1000000000;
        var rkap_ebit_up = Number(dataJson.rkap_ebit_up)/1000000000;
        var rkap_eat_up = 0;

        // var prs_vol_up = (real_vol_up/rkap_vol_up)*100;
        // var prs_rev_up = (real_rev_up/rkap_rev_up)*100;
        // var prs_net_up = (real_net_up/rkap_net_up)*100;
        // var prs_ebit_up = (real_ebit_up/rkap_ebit_up)*100;
        // var prs_eat_up = (real_eat_up/rkap_eat_up)*100;
         var prs_vol_up = dataJson.persen_vol_up;
        var prs_rev_up = dataJson.persen_rev_up;
        var prs_net_up = dataJson.persen_net_up;
        var prs_ebit_up = dataJson.persen_ebit_up;
        var prs_eat_up = dataJson.persen_eat_up;

        // console.log('Prec '+prs_vol_up);


// ID #################################################################################################################
       if (prs_vol_now < 100) {
            $('#prs_vol_now').html('<font color="#f64747">'+setFormat(prs_vol_now, 1)+'</font>');
        } else{
            $('#prs_vol_now').html('<font color="#6fc962">'+setFormat(prs_vol_now, 1)+'</font>');
        }
        if (prs_rev_now < 100) {
            $('#prs_rev_now').html('<font color="#f64747">'+setFormat(prs_rev_now, 1)+'</font>');
        } else{
            $('#prs_rev_now').html('<font color="#6fc962">'+setFormat(prs_rev_now, 1)+'</font>');
        }
        if (prs_net_now < 100) {
            $('#prs_net_now').html('<font color="#f64747">'+setFormat(prs_net_now, 1)+'</font>');
        } else{
            $('#prs_net_now').html('<font color="#6fc962">'+setFormat(prs_net_now, 1)+'</font>');
        }
        if (prs_ebit_now < 100) {
            $('#prs_ebit_now').html('<font color="#f64747">'+setFormat(prs_ebit_now, 1)+'</font>');
        } else{
            $('#prs_ebit_now').html('<font color="#6fc962">'+setFormat(prs_ebit_now, 1)+'</font>');
        }
        if (prs_eat_now < 100) {
            $('#prs_eat_now').html('<font color="#f64747">'+setFormat(prs_eat_now, 1)+'</font>');
        } else{
            $('#prs_eat_now').html('<font color="#6fc962">'+setFormat(prs_eat_now, 1)+'</font>');
        }
// ################################################################################################################
        if (prs_vol_up < 100) {
            $('#prs_vol_up').html('<font color="#f64747">'+setFormat(prs_vol_up, 1)+'</font>');
        } else{
            $('#prs_vol_up').html('<font color="#6fc962">'+setFormat(prs_vol_up, 1)+'</font>');
        }
        if (prs_rev_up < 100) {
            $('#prs_rev_up').html('<font color="#f64747">'+setFormat(prs_rev_up, 1)+'</font>');
        } else{
            $('#prs_rev_up').html('<font color="#6fc962">'+setFormat(prs_rev_up, 1)+'</font>');
        }
        if (prs_net_up < 100) {
            $('#prs_net_up').html('<font color="#f64747">'+setFormat(prs_net_up, 1)+'</font>');
        } else{
            $('#prs_net_up').html('<font color="#6fc962">'+setFormat(prs_net_up, 1)+'</font>');
        }
        if (prs_ebit_up < 100) {
            $('#prs_ebit_up').html('<font color="#f64747">'+setFormat(prs_ebit_up, 1)+'</font>');
        } else{
            $('#prs_ebit_up').html('<font color="#6fc962">'+setFormat(prs_ebit_up, 1)+'</font>');
        }
        if (prs_eat_up < 100) {
            $('#prs_eat_up').html('<font color="#f64747">'+setFormat(prs_eat_up, 1)+'</font>');
        } else{
            $('#prs_eat_up').html('<font color="#6fc962">'+setFormat(prs_eat_up, 1)+'</font>');
        }


        $('#vari_now').html('<font color="red">'+setFormat(vari_now, 1)+'</font>');
        $('#vari_vol_now').html(setFormat(vari_vol_now, 1));
        $('#vari_price_now').html(setFormat(vari_price_now, 1));
        $('#vari_cost_now').html(setFormat(vari_cost_now, 1));

        $('#real_vol_now').html(setFormat(real_vol_now, 1));
        $('#real_rev_now').html(setFormat(real_rev_now, 1));
        $('#real_net_now').html(setFormat(real_net_now, 1));
        $('#real_ebit_now').html(setFormat(real_ebit_now, 1));
        $('#real_eat_now').html(setFormat(real_eat_now, 1));

        $('#rkap_vol_now').html(setFormat(rkap_vol_now, 1));
        $('#rkap_rev_now').html(setFormat(rkap_rev_now, 1));
        $('#rkap_net_now').html(setFormat(rkap_net_now, 1));
        $('#rkap_ebit_now').html(setFormat(rkap_ebit_now, 1));
        $('#rkap_eat_now').html(setFormat(rkap_eat_now, 1));

        $('#rkap_vol_now').html(setFormat(rkap_vol_now, 1));
        $('#rkap_rev_now').html(setFormat(rkap_rev_now, 1));
        $('#rkap_net_now').html(setFormat(rkap_net_now, 1));
        $('#rkap_ebit_now').html(setFormat(rkap_ebit_now, 1));
        $('#rkap_eat_now').html(setFormat(rkap_eat_now, 1));
        // ###################################################################################

        $('#vari_up').html(setFormat(vari_up, 1));
        $('#vari_vol_up').html(setFormat(vari_vol_up, 1));
        $('#vari_price_up').html(setFormat(vari_price_up, 1));
        $('#vari_cost_up').html(setFormat(vari_cost_up, 1));

        $('#real_vol_up').html(setFormat(real_vol_up, 1));
        $('#real_rev_up').html(setFormat(real_rev_up, 1));
        $('#real_net_up').html(setFormat(real_net_up, 1));
        $('#real_ebit_up').html(setFormat(real_ebit_up, 1));
        $('#real_eat_up').html(setFormat(real_eat_up, 1));

        $('#rkap_vol_up').html(setFormat(rkap_vol_up, 1));
        $('#rkap_rev_up').html(setFormat(rkap_rev_up, 1));
        $('#rkap_net_up').html(setFormat(rkap_net_up, 1));
        $('#rkap_ebit_up').html(setFormat(rkap_ebit_up, 1));
        $('#rkap_eat_up').html(setFormat(rkap_eat_up, 1));
        



// TOTAL #################################################################################################################

       

        // if ( sl_stok <= sl_min){
        //     $('#sl_sd').addClass('redmm');
        //     $('#sl_sd').removeClass('ylmm');
        //     $('#sl_sd').removeClass('grmm');
        //     $('#sl_sd').removeClass('blmm');
        //     $('#sl_bt').addClass('rdbt');
        //     $('#sl_bt').removeClass('grbt');
        //     $('#sl_bt').removeClass('ylbt');
        //     $('#sl_bt').removeClass('blbt');
        // }else if ( sl_stok > sl_max) {
        //     $('#sl_sd').addClass('blmm');
        //     $('#sl_sd').removeClass('ylmm');
        //     $('#sl_sd').removeClass('grmm');
        //     $('#sl_sd').removeClass('redmm');
        //     $('#sl_bt').addClass('blbt');
        //     $('#sl_bt').removeClass('grbt');
        //     $('#sl_bt').removeClass('ylbt');
        //     $('#sl_bt').removeClass('rdbt');
        // }else if ( sl_stok > sl_min && sl_stok < sl_max) {
        //     $('#sl_sd').addClass('grmm');
        //     $('#sl_sd').removeClass('ylmm');
        //     $('#sl_sd').removeClass('blmm');
        //     $('#sl_sd').removeClass('redmm');
        //     $('#sl_bt').addClass('grbt');
        //     $('#sl_bt').removeClass('blbt');
        //     $('#sl_bt').removeClass('ylbt');
        //     $('#sl_bt').removeClass('rdbt');
        // }else if ( sl_stok <= sl_rp) {
        //     $('#sl_sd').addClass('ylmm');
        //     $('#sl_sd').removeClass('grmm');
        //     $('#sl_sd').removeClass('blmm');
        //     $('#sl_sd').removeClass('redmm');
        //     $('#sl_bt').addClass('ylbt');
        //     $('#sl_bt').removeClass('blbt');
        //     $('#sl_bt').removeClass('grbt');
        //     $('#sl_bt').removeClass('rdbt');
        // }



        stop_waitMe('.wrapper');


    });


}



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