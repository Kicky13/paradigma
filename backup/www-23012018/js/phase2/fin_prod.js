function numberWithCommas(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

var tmp=""; 
function viewAll(dataSt, dataSt2){
	var percenRkapUp = (parseFloat(dataSt[0]['s2017'][1].REAL)/parseFloat(dataSt[0]['s2017'][0].RKAP))*100;
	var percenRkapUpBefore = (parseFloat(dataSt[0]['s2016'][1].REAL)/parseFloat(dataSt[0]['s2016'][0].RKAP))*100;
	
	$('#up_rkap').html(numberWithCommas(dataSt[0]['s2017'][0].RKAP));
	$('#up_rkap_percent').html(percenRkapUp.toFixed(2)+'%');
	$('#up_rkap_before').html(numberWithCommas(dataSt[0]['s2016'][1].REAL));
	$('#up_rkap_percent_before').html(percenRkapUpBefore.toFixed(2)+'%');
	$('#up_real').html(numberWithCommas(dataSt[0]['s2017'][1].REAL));

	var percenRkapUp_kiln = (parseFloat(dataSt2[0]['s2017'][1].REAL)/parseFloat(dataSt2[0]['s2017'][0].RKAP))*100;
	var percenRkapUpBefore_kiln = (parseFloat(dataSt2[0]['s2016'][1].REAL)/parseFloat(dataSt2[0]['s2016'][0].RKAP))*100;
	
	$('#up_rkap_kiln').html(numberWithCommas(dataSt2[0]['s2017'][0].RKAP));
	$('#up_rkap_percent_kiln').html(percenRkapUp_kiln.toFixed(2)+'%');
	$('#up_rkap_kiln_before').html(numberWithCommas(dataSt2[0]['s2016'][1].REAL));
	$('#up_rkap_percent_kiln_before').html(percenRkapUpBefore_kiln.toFixed(2)+'%');
	$('#up_real_kiln').html(numberWithCommas(dataSt2[0]['s2017'][1].REAL));
}

function viewPlant(dataDetailStKiln1, dataDetailStCement1, dataDetailStKiln2, dataDetailStCement2, dataDetailStKiln3, dataDetailStCement3){
	
	//CLINKER
	var totalRkap = parseFloat(dataDetailStKiln1[0][0][2])+parseFloat(dataDetailStKiln2[0][0][1])+parseFloat(dataDetailStKiln3[0][0][1]);
	$('#up_rkap1 strong').html(numberWithCommas(dataDetailStKiln1[0][0][2]));
	$('#up_rkap2 strong').html(numberWithCommas(dataDetailStKiln2[0][0][1]));
	$('#up_rkap3 strong').html(numberWithCommas(dataDetailStKiln3[0][0][1]));
	$('#total_up_rkap strong').html(numberWithCommas(totalRkap));

	var totalPrognosa = parseFloat(dataDetailStKiln1[0][1][2])+parseFloat(dataDetailStKiln2[0][1][1])+parseFloat(dataDetailStKiln3[0][1][1]);
	$('#up_prognosa1 strong').html(numberWithCommas(dataDetailStKiln1[0][1][2]));
	$('#up_prognosa2 strong').html(numberWithCommas(dataDetailStKiln2[0][1][1]));
	$('#up_prognosa3 strong').html(numberWithCommas(dataDetailStKiln3[0][1][1]));
	$('#total_up_prognosa strong').html(numberWithCommas(totalPrognosa));

	var totalPercentRkap = (totalPrognosa/totalRkap)*100;
	$('#up_percent_rkap1 strong').html(((numberWithCommas(dataDetailStKiln1[0][2][2]) < 100) ? '<span style="color:#e41a1c">'+numberWithCommas(dataDetailStKiln1[0][2][2])+'%</span>' : '<span style="color:#4daf4a">'+numberWithCommas(dataDetailStKiln1[0][2][2])+'%</span>'));
	$('#up_percent_rkap2 strong').html(((numberWithCommas(dataDetailStKiln1[0][2][1]) < 100) ? '<span style="color:#e41a1c">'+numberWithCommas(dataDetailStKiln1[0][2][1])+'%</span>' : '<span style="color:#4daf4a">'+numberWithCommas(dataDetailStKiln1[0][2][1])+'%</span>'));
	$('#up_percent_rkap3 strong').html(((numberWithCommas(dataDetailStKiln1[0][2][1]) < 100) ? '<span style="color:#e41a1c">'+numberWithCommas(dataDetailStKiln1[0][2][1])+'%</span>' : '<span style="color:#4daf4a">'+numberWithCommas(dataDetailStKiln1[0][2][1])+'%</span>'));
	$('#total_up_percent_rkap strong').html(((numberWithCommas(totalPercentRkap) < 100) ? '<span style="color:#e41a1c">'+numberWithCommas(totalPercentRkap)+'%</span>' : '<span style="color:#4daf4a">'+numberWithCommas(totalPercentRkap)+'%</span>'));

	var totalReal = parseFloat(dataDetailStKiln1[0][3][2])+parseFloat(dataDetailStKiln2[0][3][1])+parseFloat(dataDetailStKiln3[0][3][1]);
	$('#up_real1 strong').html(numberWithCommas(dataDetailStKiln1[0][3][2]));
	$('#up_real2 strong').html(numberWithCommas(dataDetailStKiln2[0][3][1]));
	$('#up_real3 strong').html(numberWithCommas(dataDetailStKiln3[0][3][1]));
	$('#total_up_real strong').html(numberWithCommas(totalReal));

	var totalSisaPrognosa = parseFloat(dataDetailStKiln1[0][4][2])+parseFloat(dataDetailStKiln2[0][4][1])+parseFloat(dataDetailStKiln3[0][4][1]);
	$('#sisa_prognosa1 strong').html(numberWithCommas(dataDetailStKiln1[0][4][2]));
	$('#sisa_prognosa2 strong').html(numberWithCommas(dataDetailStKiln2[0][4][1]));
	$('#sisa_prognosa3 strong').html(numberWithCommas(dataDetailStKiln3[0][4][1]));
	$('#total_sisa_prognosa strong').html(numberWithCommas(totalSisaPrognosa));

	var totalKapasitasReal = parseFloat(dataDetailStKiln1[0][7][2])+parseFloat(dataDetailStKiln2[0][7][1])+parseFloat(dataDetailStKiln3[0][7][1]);
	var totalHariOprasi = totalReal/totalKapasitasReal;
	$('#up_hari_oprasi1 strong').html(numberWithCommas(dataDetailStKiln1[0][5][2]));
	$('#up_hari_oprasi2 strong').html(numberWithCommas(dataDetailStKiln2[0][5][1]));
	$('#up_hari_oprasi3 strong').html(numberWithCommas(dataDetailStKiln3[0][5][1]));
	$('#total_up_hari_oprasi strong').html(numberWithCommas(totalHariOprasi));

	var totalKapasitasSisa = parseFloat(dataDetailStKiln1[0][8][2])+parseFloat(dataDetailStKiln2[0][8][1])+parseFloat(dataDetailStKiln3[0][8][1]);
	var totalSisaHariOprasi = totalSisaPrognosa/totalKapasitasSisa;
	$('#sisa_oprasi1 strong').html(numberWithCommas(dataDetailStKiln1[0][6][2]));
	$('#sisa_oprasi2 strong').html(numberWithCommas(dataDetailStKiln2[0][6][1]));
	$('#sisa_oprasi3 strong').html(numberWithCommas(dataDetailStKiln3[0][6][1]));
	$('#total_sisa_oprasi strong').html(numberWithCommas(totalSisaHariOprasi));

	$('#kapasitas_real1 strong').html(numberWithCommas(dataDetailStKiln1[0][7][2]));
	$('#kapasitas_real2 strong').html(numberWithCommas(dataDetailStKiln2[0][7][1]));
	$('#kapasitas_real3 strong').html(numberWithCommas(dataDetailStKiln3[0][7][1]));
	$('#total_kapasitas_real strong').html(numberWithCommas(totalKapasitasReal));

	$('#kapasitas_sisa1 strong').html(numberWithCommas(dataDetailStKiln1[0][8][2]));
	$('#kapasitas_sisa2 strong').html(numberWithCommas(dataDetailStKiln2[0][8][1]));
	$('#kapasitas_sisa3 strong').html(numberWithCommas(dataDetailStKiln3[0][8][1]));
	$('#total_kapasitas_sisa strong').html(numberWithCommas(totalKapasitasSisa));
	
	//CEMENT
	var totalRkapCement = parseFloat(dataDetailStCement1[0][0][2])+parseFloat(dataDetailStCement2[0][0][2])+parseFloat(dataDetailStCement3[0][0][2]);
	$('#up_rkap1_kiln strong').html(numberWithCommas(dataDetailStCement1[0][0][2]));
	$('#up_rkap2_kiln strong').html(numberWithCommas(dataDetailStCement2[0][0][2]));
	$('#up_rkap3_kiln strong').html(numberWithCommas(dataDetailStCement3[0][0][2]));
	$('#total_up_rkap_kiln strong').html(numberWithCommas(totalRkapCement));

	var totalPrognosaCement = parseFloat(dataDetailStCement1[0][1][2])+parseFloat(dataDetailStCement2[0][1][2])+parseFloat(dataDetailStCement3[0][1][2]);
	$('#up_prognosa1_kiln strong').html(numberWithCommas(dataDetailStCement1[0][1][2]));
	$('#up_prognosa2_kiln strong').html(numberWithCommas(dataDetailStCement2[0][1][2]));
	$('#up_prognosa3_kiln strong').html(numberWithCommas(dataDetailStCement3[0][1][2]));
	$('#total_up_prognosa_kiln strong').html(numberWithCommas(totalPrognosaCement));

	var totalPercentRkapCement = (totalPrognosaCement/totalRkapCement)*100;
	$('#up_percent_rkap1_kiln strong').html(((numberWithCommas(dataDetailStCement1[0][2][2]) < 100) ? '<span style="color:#e41a1c">'+numberWithCommas(dataDetailStCement1[0][2][2])+'%</span>' : '<span style="color:#4daf4a">'+numberWithCommas(dataDetailStCement1[0][2][2])+'%</span>'));
	$('#up_percent_rkap2_kiln strong').html(((numberWithCommas(dataDetailStCement2[0][2][2]) < 100) ? '<span style="color:#e41a1c">'+numberWithCommas(dataDetailStCement2[0][2][2])+'%</span>' : '<span style="color:#4daf4a">'+numberWithCommas(dataDetailStCement2[0][2][2])+'%</span>'));
	$('#up_percent_rkap3_kiln strong').html(((numberWithCommas(dataDetailStCement3[0][2][2]) < 100) ? '<span style="color:#e41a1c">'+numberWithCommas(dataDetailStCement3[0][2][2])+'%</span>' : '<span style="color:#4daf4a">'+numberWithCommas(dataDetailStCement3[0][2][2])+'%</span>'));
	$('#total_up_percent_rkap_kiln strong').html(((numberWithCommas(totalPercentRkapCement) < 100) ? '<span style="color:#e41a1c">'+numberWithCommas(totalPercentRkapCement)+'%</span>' : '<span style="color:#4daf4a">'+numberWithCommas(totalPercentRkapCement)+'%</span>'));

	var totalRealCement = parseFloat(dataDetailStCement1[0][3][2])+parseFloat(dataDetailStCement2[0][3][2])+parseFloat(dataDetailStCement3[0][3][2]);
	$('#up_real1_kiln strong').html(numberWithCommas(dataDetailStCement1[0][3][2]));
	$('#up_real2_kiln strong').html(numberWithCommas(dataDetailStCement2[0][3][2]));
	$('#up_real3_kiln strong').html(numberWithCommas(dataDetailStCement3[0][3][2]));
	$('#total_up_real_kiln strong').html(numberWithCommas(totalRealCement));

	var totalSisaPrognosaCement = parseFloat(dataDetailStCement1[0][4][2])+parseFloat(dataDetailStCement2[0][4][2])+parseFloat(dataDetailStCement3[0][4][2]);
	$('#sisa_prognosa1_kiln strong').html(numberWithCommas(dataDetailStCement1[0][4][2]));
	$('#sisa_prognosa2_kiln strong').html(numberWithCommas(dataDetailStCement2[0][4][2]));
	$('#sisa_prognosa3_kiln strong').html(numberWithCommas(dataDetailStCement3[0][4][2]));
	$('#total_sisa_prognosa_kiln strong').html(numberWithCommas(totalSisaPrognosaCement));

	var totalKapasitasRealCement = parseFloat(dataDetailStCement1[0][7][2])+parseFloat(dataDetailStCement2[0][7][2])+parseFloat(dataDetailStCement3[0][7][2]);
	var totalHariOprasiCement = totalRealCement/totalKapasitasRealCement;
	$('#up_hari_oprasi1_kiln strong').html(numberWithCommas(dataDetailStCement1[0][5][2]));
	$('#up_hari_oprasi2_kiln strong').html(numberWithCommas(dataDetailStCement2[0][5][2]));
	$('#up_hari_oprasi3_kiln strong').html(numberWithCommas(dataDetailStCement3[0][5][2]));
	$('#total_up_hari_oprasi_kiln strong').html(numberWithCommas(totalHariOprasiCement));

	var totalKapasitasSisaCement = parseFloat(dataDetailStCement1[0][8][2])+parseFloat(dataDetailStCement2[0][8][2])+parseFloat(dataDetailStCement3[0][8][2]);
	var totalSisaHariOprasiCement = totalSisaPrognosaCement/totalKapasitasSisaCement;
	$('#sisa_oprasi1_kiln strong').html(numberWithCommas(dataDetailStCement1[0][6][2]));
	$('#sisa_oprasi2_kiln strong').html(numberWithCommas(dataDetailStCement2[0][6][2]));
	$('#sisa_oprasi3_kiln strong').html(numberWithCommas(dataDetailStCement3[0][6][2]));
	$('#total_sisa_oprasi_kiln strong').html(numberWithCommas(totalSisaHariOprasiCement));

	$('#kapasitas_real1_kiln strong').html(numberWithCommas(dataDetailStCement1[0][7][2]));
	$('#kapasitas_real2_kiln strong').html(numberWithCommas(dataDetailStCement2[0][7][2]));
	$('#kapasitas_real3_kiln strong').html(numberWithCommas(dataDetailStCement3[0][7][2]));
	$('#total_kapasitas_real_kiln strong').html(numberWithCommas(totalKapasitasRealCement));

	$('#kapasitas_sisa1_kiln strong').html(numberWithCommas(dataDetailStCement1[0][8][2]));
	$('#kapasitas_sisa2_kiln strong').html(numberWithCommas(dataDetailStCement2[0][8][2]));
	$('#kapasitas_sisa3_kiln strong').html(numberWithCommas(dataDetailStCement3[0][8][2]));
	$('#total_kapasitas_sisa_kiln strong').html(numberWithCommas(totalKapasitasSisaCement));
	
}

var labelArrayDay = [];
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}

function opcoGroup (selday, selmonth, selyear, plant){
	
	var days = daysInMonth(selmonth,selyear);
	for (var x = 1; x <= days; x++) {
		if (x < 10) {
			var tgl = '0' + x;
		} else {
			var tgl = x;
		}
		labelArrayDay.push(tgl);
	}
	
	var monthBefore = selmonth-1;
	if(monthBefore<=9){
		monthBefore = '0'+monthBefore
	}
	
	var yearBefore = selyear-1;
    run_waitMe('.wrapper', 'ios');
	
	var urlSt =  url_ol+'/api/index.php/produksi_daily_st?bulan='+selmonth+'&tahun='+selyear+'&kode_produk=1';
	var urlSt2 =  url_ol+'/api/index.php/produksi_daily_st?bulan='+selmonth+'&tahun='+selyear+'&kode_produk=2';
	var urlDetailStKiln1 =  url_ol+'/api/index.php/produksi_daily_st/detail_plant?bulan='+selmonth+'&tahun='+selyear+'&kode_produk=1&plant=4301';
	var urlDetailStCement1 =  url_ol+'/api/index.php/produksi_daily_st/detail_plant?bulan='+selmonth+'&tahun='+selyear+'&kode_produk=2&plant=4301';
	var urlDetailStKiln2 =  url_ol+'/api/index.php/produksi_daily_st/detail_plant?bulan='+selmonth+'&tahun='+selyear+'&kode_produk=1&plant=4302';
	var urlDetailStCement2 =  url_ol+'/api/index.php/produksi_daily_st/detail_plant?bulan='+selmonth+'&tahun='+selyear+'&kode_produk=2&plant=4302';
	var urlDetailStKiln3 =  url_ol+'/api/index.php/produksi_daily_st/detail_plant?bulan='+selmonth+'&tahun='+selyear+'&kode_produk=1&plant=4303';
	var urlDetailStCement3 =  url_ol+'/api/index.php/produksi_daily_st/detail_plant?bulan='+selmonth+'&tahun='+selyear+'&kode_produk=2&plant=4303';

	stop_waitMe('.wrapper');
	
	$.when(
	    $.getJSON(urlSt),
	    $.getJSON(urlSt2),
	    $.getJSON(urlDetailStKiln1),
	    $.getJSON(urlDetailStCement1),
	    $.getJSON(urlDetailStKiln2),
	    $.getJSON(urlDetailStCement2),
	    $.getJSON(urlDetailStKiln3),
	    $.getJSON(urlDetailStCement3)
	    ).done(function(dataSt, dataSt2, dataDetailStKiln1, dataDetailStCement1, dataDetailStKiln2, dataDetailStCement2, dataDetailStKiln3, dataDetailStCement3){
			viewAll(dataSt, dataSt2);
			viewPlant(dataDetailStKiln1, dataDetailStCement1, dataDetailStKiln2, dataDetailStCement2, dataDetailStKiln3, dataDetailStCement3);
			stop_waitMe('.wrapper');
		}).fail(function(jqXHR, textStatus, errorThrown) {
			console.log('getJSON request failed! ' + textStatus);
		});
}

function showChart(bln, thn){
	
	$.ajax({
		url: url_src+'/api/index.php/real_produksi_st/detail?bulan='+bln+'&tahun='+thn,
		type: 'GET',
		success: function (data) {
			var dataJson = JSON.parse(data);
			var prognose = [];
			var real = [];
			var rkap = [];
			var hari = [];
			
			var prognose2 = [];
			var real2 = [];
			var rkap2 = [];
			var hari2 = [];
			
			for (var x=0;x<dataJson['1'].length;x++) {
				prognose.push(parseFloat(dataJson['1'][x].PROGONOSE_PRODUK));
				rkap.push(parseFloat(dataJson['1'][x].RKAP));
				hari.push(parseFloat(dataJson['1'][x].HARI_OPERASI));
				real.push(parseFloat(dataJson['1'][x].ACTUAL_PRODUK));
			}
			// console.log(rkap);
			$('#terak_stock').highcharts({
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
					// tickmarkPlacement: 'on',
					gridLineWidth: 1
				},
				
				yAxis: {
					title: {
						text: ''
					}
				},
				tooltip: {
					formatter: function(){
							var n = this.y;
							var s = this.series.name;
							var t = this.point.x+1;
							return '<b>'+t+'<br>'+s+' '+setFormat(n,0)+' Ton <br> '+hari[this.point.x]+' (Hari Opr)</b>';
							}
				},
				exporting: {
					enabled: false
				},
				legend: {
					enabled: false
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
						name: 'Prognose',
						color: '#E9D460',
						data: prognose,
		  pointPadding: 0.05,
					pointPlacement: 0
				//stacking: 'normal'
						},{
		  name: 'Realisasi',
							color: '#22A7F0',
							data: real,
		  pointPadding: 0.25,
					pointPlacement: 0
				//stacking: 'normal'
						},{
				type: 'spline',
							name: 'RKAP',
							color: '#D91E18',
							data: rkap,
						}]
				});
				
			for (var x=0;x<dataJson['2'].length;x++) {
				prognose2.push(parseFloat(dataJson['2'][x].PROGONOSE_PRODUK));
				rkap2.push(parseFloat(dataJson['2'][x].RKAP));
				hari2.push(parseFloat(dataJson['2'][x].HARI_OPERASI));
				real2.push(parseFloat(dataJson['2'][x].ACTUAL_PRODUK));
			}
			$('#terak_stock_kiln').highcharts({
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
					// tickmarkPlacement: 'on',
					gridLineWidth: 1
				},
				yAxis: {
					title: {
						text: ''
					}
				},
				tooltip: {
					formatter: function(){
							var n = this.y;
							var s = this.series.name;
							var t = this.point.x+1;
							return '<b>'+t+'<br>'+s+' '+setFormat(n,0)+' Ton <br> '+hari2[this.point.x]+' (Hari Opr)</b>';
							}
				},
				exporting: {
					enabled: false
				},
				legend: {
					enabled: false
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
						name: 'Prognose',
						color: '#E9D460',
						data: prognose2,
		  pointPadding: 0.05,
					pointPlacement: 0
				//stacking: 'normal'
						},{
		  name: 'Realisasi',
							color: '#22A7F0',
							data: real2,
		  pointPadding: 0.25,
					pointPlacement: 0
				//stacking: 'normal'
						},{
				type: 'spline',
							name: 'RKAP',
							color: '#D91E18',
							data: rkap2,
						}]
				});
		}
	})
}

var labelArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
function showChartMonthly(bln, thn){
	$.ajax({
		url: url_src+'/api/index.php/rkap_produksi_st/chart_month?bulan='+bln+'&tahun='+thn,
		type: 'GET',
		success: function (dataStRkap) {
			var index = [];
			var prognose = [];
			var real = [];
			var rkap = [];
			var hari = [];
			var prognose2 = [];
			var real2 = [];
			var rkap2 = [];
			var data = JSON.parse(dataStRkap);
			var hari2 = [];
			for(var i=1;i<=bln;i++){
				prognose.push(parseFloat(data.rkap['1'][i].PROGONOSE_PRODUK));
				rkap.push(parseFloat(data.rkap['1'][i].RKAP));
				hari.push(parseFloat(data.rkap['1'][i].HARI_OPERASI));
				real.push(parseFloat(data.real['1'][i].REAL));
			}
			// console.log(hari);
			
		$('#terak_stock').highcharts({
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
			categories: labelArray,
			tickInterval: 1,
			// tickmarkPlacement: 'on',
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			}
		},
		tooltip: {
			formatter: function(){
					var n = this.y;
					var s = this.series.name;
					var t = this.point.x+1;
					
					return '<b>'+t+'<br>'+s+' '+setFormat(n,0)+' Ton <br> '+hari[this.point.x]+' (Hari Opr)</b>';
					}
		},
		exporting: {
			enabled: false
		},
		legend: {
			enabled: false
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
				name: 'Prognose',
				color: '#E9D460',
				data: prognose,
  pointPadding: 0.05,
			pointPlacement: 0
		// stacking: 'normal'
				},{
  name: 'Realisasi',
					color: '#22A7F0',
					data: real,
  pointPadding: 0.25,
			pointPlacement: 0
		// stacking: 'normal'
				},{
		type: 'spline',
					name: 'RKAP',
					color: '#D91E18',
					data: rkap,
				}]
		});
	
		
			for(var i=1;i<=bln;i++){
				prognose2.push(parseFloat(data.rkap['2'][i].PROGONOSE_PRODUK));
				rkap2.push(parseFloat(data.rkap['2'][i].RKAP));
				hari2.push(parseFloat(data.rkap['2'][i].HARI_OPERASI));
				real2.push(parseFloat(data.real['2'][i].REAL));
			}
			$('#terak_stock_kiln').highcharts({
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
					categories: labelArray,
					tickInterval: 1,
					// tickmarkPlacement: 'on',
					gridLineWidth: 1
				},
				yAxis: {
					title: {
						text: ''
					}
				},
				tooltip: {
					formatter: function(){
							var n = this.y;
							var s = this.series.name;
							var t = this.point.x+1;
							return '<b>'+t+'<br>'+s+' '+setFormat(n,0)+' Ton <br> '+hari2[this.point.x]+' (Hari Opr)</b>';
							}
				},
				exporting: {
					enabled: false
				},
				legend: {
					enabled: false
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
						name: 'Prognose',
						color: '#E9D460',
						data: prognose2,
		  pointPadding: 0.05,
					pointPlacement: 0
				//stacking: 'normal'
						},{
		  name: 'Realisasi',
							color: '#22A7F0',
							data: real2,
		  pointPadding: 0.25,
					pointPlacement: 0
				//stacking: 'normal'
						},{
				type: 'spline',
							name: 'RKAP',
							color: '#D91E18',
							data: rkap2
						}]
				});
	
		}
	});
	
}

function chartss(prognose, rkap, real){
	$('#terak_stock').highcharts({
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
			// tickmarkPlacement: 'on',
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			}
		},
		tooltip: {
			formatter: function(){
					var n = this.y;
					var s = this.series.name;
					var t = this.point.x+1;
					return '<b>'+t+'<br>'+s+'<br>'+setFormat(n,0)+' Ton</b>';
					}
		},
		exporting: {
			enabled: false
		},
		legend: {
			enabled: false
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
				name: 'Prognose',
				color: '#E9D460',
				data: prognose,
  pointPadding: 0.05,
			pointPlacement: 0
		//stacking: 'normal'
				},{
  name: 'Realisasi',
					color: '#22A7F0',
					data: real,
  pointPadding: 0.25,
			pointPlacement: 0
		//stacking: 'normal'
				},{
		type: 'spline',
					name: 'RKAP',
					color: '#D91E18',
					data: rkap,
				}]
		});
}

