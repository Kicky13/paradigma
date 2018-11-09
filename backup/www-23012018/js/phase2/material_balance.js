function numberFormat(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function highlight(selmonth, selyear){
	var Url = $.getJSON(url_src+'/api/index.php/material_balance_st?bulan='+selmonth+'&tahun='+selyear, function(data){
        $('#stokakhir').html(parseFloat(data[0].STOK));
        $('#stok_awal').html(parseFloat(data[0].SALDO_AKHIR));
        $('#gr').html(parseFloat(data[0].GR));
        $('#gi').html(parseFloat(data[0].STOK_OPENYARD));
		$('#last_update').html('Last Update : '+data[0].LAST_UPDATE);
        
//              kiln 2/3
        var produksi23 = parseFloat(data['PLANT']['KILN23'][1].NILAI)+parseFloat(data['PLANT']['KILN23'][2].NILAI);
        var gifm23 = parseFloat(data['PLANT']['KILN23'][4].NILAI)+parseFloat(data['PLANT']['KILN23'][5].NILAI);
        $('#stokawal23').html(numberFormat(data['PLANT']['KILN23'][0].NILAI));
        $('#produksi23').html(numberFormat(produksi23));
        $('#dariplantlain23').html(numberFormat(data['PLANT']['KILN23'][3].NILAI));
        $('#gifm23').html(numberFormat(gifm23));
        $('#keplantlain23').html(numberFormat(data['PLANT']['KILN23'][6].NILAI));
        $('#openyard23').html(numberFormat(data['PLANT']['KILN23'][7].NILAI));
        $('#jual23').html(numberFormat(data['PLANT']['KILN23'][8].NILAI));
        $('#selisihstok23').html(numberFormat(data['PLANT']['KILN23'][9].NILAI));
        $('#stokakhir23').html(numberFormat(data['PLANT']['KILN23'][10].NILAI));
        
//              kiln 4
        var gifm4 = parseFloat(data['PLANT']['KILN4'][3].NILAI)+parseFloat(data['PLANT']['KILN4'][4].NILAI);
        $('#stokawal4').html(numberFormat(data['PLANT']['KILN4'][0].NILAI));
        $('#produksi4').html(numberFormat(data['PLANT']['KILN4'][1].NILAI));
        $('#dariplantlain4').html(numberFormat(data['PLANT']['KILN4'][2].NILAI));
        $('#gifm4').html(numberFormat(gifm4));
        $('#keplantlain4').html(numberFormat(data['PLANT']['KILN4'][5].NILAI));
        $('#openyard4').html(numberFormat(data['PLANT']['KILN4'][6].NILAI));
        $('#jual4').html(numberFormat(data['PLANT']['KILN4'][7].NILAI));
        $('#selisihstok4').html(numberFormat(data['PLANT']['KILN4'][8].NILAI));
        $('#stokakhir4').html(numberFormat(data['PLANT']['KILN4'][9].NILAI));
        
//              kiln 5
        var gifm5 = parseFloat(data['PLANT']['KILN5'][2].NILAI)+parseFloat(data['PLANT']['KILN5'][3].NILAI);
        $('#stokawal5').html(numberFormat(data['PLANT']['KILN5'][0].NILAI));
        $('#produksi5').html(numberFormat(data['PLANT']['KILN5'][1].NILAI));
        $('#dariplantlain5').html(numberFormat(data['PLANT']['KILN5'][4].NILAI));
        $('#gifm5').html(numberFormat(gifm5));
        $('#keplantlain5').html(numberFormat(data['PLANT']['KILN5'][5].NILAI));
        $('#openyard5').html(numberFormat(data['PLANT']['KILN5'][6].NILAI));
        $('#jual5').html(numberFormat(data['PLANT']['KILN5'][7].NILAI));
        $('#selisihstok5').html(numberFormat(data['PLANT']['KILN5'][8].NILAI));
        $('#stokakhir5').html(numberFormat(data['PLANT']['KILN5'][9].NILAI));

//              Openyard
        $('#stokawalOY').html(numberFormat(data['PLANT']['CLOSEDYARD'][0].NILAI));
        $('#penerimaanOY').html(numberFormat(data['PLANT']['CLOSEDYARD'][1].NILAI));
        $('#keplantlainOY').html(numberFormat(data['PLANT']['CLOSEDYARD'][2].NILAI));
        $('#jualOY').html(numberFormat(data['PLANT']['CLOSEDYARD'][3].NILAI));
        $('#selisihstokOY').html(numberFormat(data['PLANT']['CLOSEDYARD'][4].NILAI));
        $('#stokakhirOY').html(numberFormat(data['PLANT']['CLOSEDYARD'][5].NILAI));
        
//              Total
		var totStok = parseFloat(data['PLANT']['KILN23'][0].NILAI)+parseFloat(data['PLANT']['KILN4'][0].NILAI)+parseFloat(data['PLANT']['KILN5'][0].NILAI)+parseFloat(data['PLANT']['CLOSEDYARD'][0].NILAI);
		var totProd = produksi23+parseFloat(data['PLANT']['KILN4'][1].NILAI)+parseFloat(data['PLANT']['KILN5'][1].NILAI);
        var totTPnrm = data['PLANT']['CLOSEDYARD'][1].NILAI;
		var totDpl = parseFloat(data['PLANT']['KILN23'][3].NILAI)+parseFloat(data['PLANT']['KILN4'][2].NILAI)+parseFloat(data['PLANT']['KILN5'][4].NILAI);
		var totGi = gifm23+gifm4+gifm5;
		var totKpl = parseFloat(data['PLANT']['KILN23'][6].NILAI)+parseFloat(data['PLANT']['KILN4'][5].NILAI)+parseFloat(data['PLANT']['KILN5'][5].NILAI);
		var totTkb = data['PLANT']['CLOSEDYARD'][2].NILAI;
		var totTop = parseFloat(data['PLANT']['KILN23'][7].NILAI)+parseFloat(data['PLANT']['KILN4'][6].NILAI)+parseFloat(data['PLANT']['KILN5'][6].NILAI);
		var totJual = parseFloat(data['PLANT']['KILN23'][8].NILAI)+parseFloat(data['PLANT']['KILN4'][7].NILAI)+parseFloat(data['PLANT']['KILN5'][7].NILAI)+parseFloat(data['PLANT']['CLOSEDYARD'][3].NILAI);
		var totSelisih = parseFloat(data['PLANT']['KILN23'][9].NILAI)+parseFloat(data['PLANT']['KILN4'][8].NILAI)+parseFloat(data['PLANT']['KILN5'][8].NILAI)+parseFloat(data['PLANT']['CLOSEDYARD'][4].NILAI);
		var totAkhir = parseFloat(data['PLANT']['KILN23'][10].NILAI)+parseFloat(data['PLANT']['KILN4'][9].NILAI)+parseFloat(data['PLANT']['KILN5'][9].NILAI)+parseFloat(data['PLANT']['CLOSEDYARD'][5].NILAI);

		$('#stokawal_total').html(numberFormat(totStok));
        $('#produksi_total').html(numberFormat(totProd));
        $('#penerimaan_total').html(numberFormat(totTPnrm));
        $('#dariplantlain_total').html(numberFormat(totDpl));
        $('#gifm_total').html(numberFormat(totGi));
        $('#keplantlain_total').html(numberFormat(totKpl));
        $('#kepabrik_total').html(numberFormat(totTkb));
        $('#openyard_total').html(numberFormat(totTop));
        $('#jual_total').html(numberFormat(totJual));
        $('#selisihstok_total').html(numberFormat(totSelisih));
        $('#stokakhir_total').html(numberFormat(totAkhir));
                
	});
        
    var Url = $.getJSON(url_src+'/api/index.php/material_balance_st?bulan='+selmonth+'&tahun='+selyear+'&plant=2', function(data){
        $('#stokfm').html(parseFloat(data[0].STOK));
        $('#saldoawalfm').html(parseFloat(data[0].SALDO_AKHIR));
        $('#grfm').html(parseFloat(data[0].GR));
        $('#gifm').html(parseFloat(data[0].GI));
		$('#last_update_fm').html('Last Update : '+data[0].LAST_UPDATE);
                
        //fm23
        var produksifm23 = (parseFloat(data['PLANT']['FINISHMIL23'][1].NILAI)+parseFloat(data['PLANT']['FINISHMIL23'][2].NILAI)).toFixed(2);
        var gistozak23 = (parseFloat(data['PLANT']['FINISHMIL23'][6].NILAI)+parseFloat(data['PLANT']['FINISHMIL23'][7].NILAI)+parseFloat(data['PLANT']['FINISHMIL23'][8].NILAI)).toFixed(2);
        var gistocurah23 = parseFloat(parseFloat(data['PLANT']['FINISHMIL23'][9].NILAI)+parseFloat(data['PLANT']['FINISHMIL23'][10].NILAI)+parseFloat(data['PLANT']['FINISHMIL23'][13].NILAI)).toFixed(2);
        var penjualanfm23 = parseFloat(parseFloat(data['PLANT']['FINISHMIL23'][5].NILAI)+parseFloat(data['PLANT']['FINISHMIL23'][11].NILAI)+parseFloat(data['PLANT']['FINISHMIL23'][12].NILAI)).toFixed(2);
        $('#stokawalfm23').html(numberFormat(data['PLANT']['FINISHMIL23'][0].NILAI));
        $('#produksifm23').html(numberFormat(produksifm23));
        $('#grstocurah23').html(numberFormat(data['PLANT']['FINISHMIL23'][3].NILAI));
        $('#produksipc23').html(numberFormat(data['PLANT']['FINISHMIL23'][4].NILAI));
        $('#gistozak23').html(numberFormat(gistozak23));
        $('#gistocurah23').html(numberFormat(gistocurah23));
        $('#penjualanfm23').html(numberFormat(penjualanfm23));
        $('#selisihstokfm23').html(numberFormat(data['PLANT']['FINISHMIL23'][14].NILAI));
        $('#stokakhirfm23').html(numberFormat(data['PLANT']['FINISHMIL23'][15].NILAI));
        
        //fm4
        var produksifm4 = (parseFloat(data['PLANT']['FINISHMIL4'][1].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][2].NILAI)).toFixed(2);
        // var gistozak4 = parseFloat(parseFloat(data['PLANT']['FINISHMIL4'][6].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][7].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][8].NILAI)).toFixed(2);
        var gistocurah4 = (parseFloat(data['PLANT']['FINISHMIL4'][4].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][5].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][8].NILAI)).toFixed(2);
        var penjualanfm4 = (parseFloat(data['PLANT']['FINISHMIL4'][6].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][7].NILAI)).toFixed(2);
        $('#stokawalfm4').html(numberFormat(data['PLANT']['FINISHMIL4'][0].NILAI));
        $('#produksifm4').html(numberFormat(produksifm4));
        $('#grstocurah4').html(numberFormat(data['PLANT']['FINISHMIL4'][3].NILAI));
        $('#produksipc4').html('0,00');
        $('#gistozak4').html('0,00');
        $('#gistocurah4').html(numberFormat(gistocurah4));
        $('#penjualanfm4').html(numberFormat(penjualanfm4));
        $('#selisihstokfm4').html(numberFormat(data['PLANT']['FINISHMIL4'][9].NILAI));
        $('#stokakhirfm4').html(numberFormat(data['PLANT']['FINISHMIL4'][10].NILAI));
        
        //fm5
        var produksifm5 = (parseFloat(data['PLANT']['FINISHMIL5'][1].NILAI)+parseFloat(data['PLANT']['FINISHMIL5'][2].NILAI)).toFixed(2);
        // var gistozak4 = parseFloat(parseFloat(data['PLANT']['FINISHMIL4'][6].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][7].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][8].NILAI)).toFixed(2);
        var gistocurah5 = (parseFloat(data['PLANT']['FINISHMIL5'][4].NILAI)+parseFloat(data['PLANT']['FINISHMIL5'][5].NILAI)+parseFloat(data['PLANT']['FINISHMIL5'][8].NILAI)).toFixed(2);
        var penjualanfm5 = (parseFloat(data['PLANT']['FINISHMIL5'][6].NILAI)+parseFloat(data['PLANT']['FINISHMIL5'][7].NILAI)).toFixed(2);
        $('#stokawalfm5').html(numberFormat(data['PLANT']['FINISHMIL5'][0].NILAI));
        $('#produksifm5').html(numberFormat(produksifm5));
        $('#grstocurah5').html(numberFormat(data['PLANT']['FINISHMIL5'][3].NILAI));
        $('#produksipc5').html('0,00');
        $('#gistozak5').html('0,00');
        $('#gistocurah5').html(numberFormat(gistocurah5));
        $('#penjualanfm5').html(numberFormat(penjualanfm5));
        $('#selisihstokfm5').html(numberFormat(data['PLANT']['FINISHMIL5'][9].NILAI));
        $('#stokakhirfm5').html(numberFormat(data['PLANT']['FINISHMIL5'][10].NILAI));
         
         //fm6
        $('#stokawalfm6').html(numberFormat(data['PLANT']['4402'][0].NILAI));
        $('#pengirimanfm6').html(numberFormat(data['PLANT']['4402'][1].NILAI));
        $('#produksipc6').html(numberFormat(data['PLANT']['4402'][2].NILAI));
        $('#penjualanfm6').html(numberFormat(data['PLANT']['4402'][3].NILAI));
        $('#selisihstokfm6').html(numberFormat(data['PLANT']['4402'][4].NILAI));
        $('#stokakhirfm6').html(numberFormat(data['PLANT']['4402'][5].NILAI));

         //fm7
        $('#stokawalfm7').html(numberFormat(data['PLANT']['4403'][0].NILAI));
        $('#grstocurah7').html(numberFormat(data['PLANT']['4403'][1].NILAI));
        $('#belifm7').html('0');
        $('#gistozak7').html(numberFormat(data['PLANT']['4403'][5].NILAI));
        $('#selisihstokfm7').html(numberFormat(data['PLANT']['4403'][6].NILAI));
        $('#stokakhirfm7').html(numberFormat(data['PLANT']['4403'][7].NILAI));

         //fm8
        $('#stokawalfm8').html(numberFormat(data['PLANT']['UPLUAR'][0].NILAI));
        $('#gistozak8').html(numberFormat(data['PLANT']['UPLUAR'][1].NILAI));
        $('#gistocurah8').html(numberFormat(data['PLANT']['UPLUAR'][2].NILAI));
        $('#selisihstokfm8').html(numberFormat(data['PLANT']['UPLUAR'][2].NILAI));
        $('#belifm8').html(numberFormat(data['PLANT']['UPLUAR'][4].NILAI));
        $('#selisihstokfm8').html(numberFormat(data['PLANT']['UPLUAR'][3].NILAI));
        $('#stokakhirfm8').html(numberFormat(data['PLANT']['UPLUAR'][5].NILAI));

        //Total
        var stokawalfm_total = parseFloat(data['PLANT']['FINISHMIL23'][0].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][0].NILAI)+parseFloat(data['PLANT']['FINISHMIL5'][0].NILAI)+parseFloat(data['PLANT']['4402'][0].NILAI)+parseFloat(data['PLANT']['4403'][0].NILAI)+parseFloat(data['PLANT']['UPLUAR'][0].NILAI);
        var produksifm_total = parseFloat(produksifm23)+parseFloat(produksifm4)+parseFloat(produksifm5);
        var produksipc_total =  parseFloat(data['PLANT']['FINISHMIL23'][4].NILAI)+parseFloat(data['PLANT']['4402'][2].NILAI);
        var gistozak_total = parseFloat(gistozak23)+parseFloat(data['PLANT']['4403'][5].NILAI)+parseFloat(data['PLANT']['UPLUAR'][1].NILAI);
        var gistocurah_total = parseFloat(gistocurah23)+parseFloat(gistocurah4)+parseFloat(gistocurah5)+parseFloat(data['PLANT']['UPLUAR'][2].NILAI);
		var penjualanfm_total = parseFloat(penjualanfm23)+parseFloat(penjualanfm4)+parseFloat(penjualanfm5)+parseFloat(data['PLANT']['4402'][3].NILAI);
		var selisihstokfm_total = parseFloat(data['PLANT']['FINISHMIL23'][14].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][9].NILAI)+parseFloat(data['PLANT']['FINISHMIL5'][9].NILAI)+parseFloat(data['PLANT']['4402'][4].NILAI)+parseFloat(data['PLANT']['4403'][6].NILAI)+parseFloat(data['PLANT']['UPLUAR'][3].NILAI);
		var stokakhirfm_total = parseFloat(data['PLANT']['FINISHMIL23'][15].NILAI)+parseFloat(data['PLANT']['FINISHMIL4'][10].NILAI)+parseFloat(data['PLANT']['FINISHMIL5'][10].NILAI)+parseFloat(data['PLANT']['4402'][5].NILAI)+parseFloat(data['PLANT']['4403'][7].NILAI)+parseFloat(data['PLANT']['UPLUAR'][5].NILAI);

        $('#stokawalfm_total').html(numberFormat(stokawalfm_total));
        $('#produksifm_total').html(numberFormat(produksifm_total));
        $('#grstocurah_total').html('0');
        $('#produksipc_total').html(numberFormat(produksipc_total));
        $('#gistozak_total').html(numberFormat(gistozak_total));
        $('#gistocurah_total').html(numberFormat(gistocurah_total));
        $('#belifm_total').html('0');
        $('#pengirimanfm_total').html('0');
        $('#penjualanfm_total').html(numberFormat(penjualanfm_total));
        $('#selisihstokfm_total').html(numberFormat(selisihstokfm_total));
        $('#stokakhirfm_total').html(numberFormat(stokakhirfm_total));



});
	
}


var labelArrayDay = [];
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}
function graphic_stock1(selmonth, selyear){

	$.ajax({
	url: url_src+'/api/index.php/material_balance_st?bulan='+selmonth+'&tahun='+selyear,
	type: 'GET',
	success: function (data) {
		var dataJson = JSON.parse(data);
		var nilai = [];
		var kapasitas = [];
		
		for (var x=0;x<dataJson['CHART'].length;x++) {
			nilai.push(parseFloat(dataJson['CHART'][x].NILAI));
			kapasitas.push(parseFloat(dataJson['CHART'][x].KAPASITAS));
		}

		$('#chart1').highcharts({
			chart: {
				type: 'column',
				spacingBottom: 8,
				spacingTop: 8,
				spacingLeft: 5,
				spacingRight: 5,
				animation: Highcharts.svg
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: labelArrayDay,
				tickInterval: 1,
				gridLineWidth: 1
			},
			yAxis: {
				title: {
					text: ''
				}
			},
			tooltip: {
				formatter: function () {
					var n = this.y;
					var s = this.series.name;
					var t = this.point.x + 1;
					return s + ' Tgl ' + t + ' :<br>' + setFormat(n, 0);
				}

			},
			exporting: {
				enabled: false
			},
			legend: {
				enabled: false,
				align: 'center',
			},
			credits: {
				enabled: false
			},
			plotOptions: {
				column: {
					grouping: false,
					shadow: false,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Kapasitas',
				color: '#E9D460',
				data : kapasitas,
				pointPadding: 0.05,
				pointPlacement: 0
			},{
				name: 'Stok',
				color: '#22A7F0',
				data : nilai,
				pointPadding: 0.25,
				pointPlacement: 0
			}]
		});
	}
});
}
function graphic_stock2(selmonth, selyear){
 
		$.ajax({
		url: url_src+'/api/index.php/material_balance_st?bulan='+selmonth+'&tahun='+selyear+'&plant=2',
		type: 'GET',
		success: function (data) {
		var dataJson = JSON.parse(data);
		var saldo = [];
		var kapasitas = [];
		
		for (var x=0;x<dataJson['CHART'].length;x++) {
			saldo.push(parseFloat(dataJson['CHART'][x].NILAI));
			kapasitas.push(parseFloat(dataJson['CHART'][x].KAPASITAS));
		}

		$('#chart2').highcharts({
			chart: {
				type: 'column',
				spacingBottom: 8,
				spacingTop: 8,
				spacingLeft: 5,
				spacingRight: 5,
				animation: Highcharts.svg
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: labelArrayDay,
				tickInterval: 1,
				gridLineWidth: 1
			},
			yAxis: {
				title: {
					text: ''
				}
			},
			tooltip: {
				formatter: function () {
					var n = this.y;
					var s = this.series.name;
					var t = this.point.x + 1;
					return s + ' Tgl ' + t + ' :<br>' + setFormat(n, 0);
				}

			},
			exporting: {
				enabled: false
			},
			legend: {
				enabled: false,
				align: 'center',
			},
			credits: {
				enabled: false
			},
			plotOptions: {
				column: {
					grouping: false,
					shadow: false,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Kapasitas',
				color: '#E9D460',
				data : kapasitas,
				pointPadding: 0.05,
				pointPlacement: 0
			},{
				name: 'Stok',
				color: '#22A7F0',
				data : saldo,
				pointPadding: 0.25,
				pointPlacement: 0
			}]
		});
	}
});
}
function opcoGroup (selmonth, selyear){
	
	var days = daysInMonth(selmonth,selyear);
	for (var x = 1; x <= days; x++) {
		if (x < 10) {
			var tgl = '0' + x;
		} else {
			var tgl = x;
		}
		labelArrayDay.push(tgl);
	}
    run_waitMe('.wrapper', 'ios');
	highlight(selmonth, selyear);
	graphic_stock1(selmonth, selyear);
	graphic_stock2(selmonth, selyear);
	stop_waitMe('.wrapper');
}


