function numberWithCommas(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

var tmp="";
function viewAll(dataStRkap, dataStReal){
	var dataMonthReal = dataStReal[0].up_month.total;
	var dataMonthRkap = dataStRkap[0].up_month.total;
	
	var percenProgUp = (parseInt(dataMonthReal.REAL)/parseInt(dataMonthRkap.PROGNOSA))*100;
	var percenRkapUp = (parseInt(dataMonthReal.REAL)/parseInt(dataMonthRkap.RKAP))*100;
	
	$('#up_prognosa').html(dataMonthRkap.PROGNOSA);
	$('#up_rkap').html(dataMonthRkap.RKAP);
	$('#up_real').html(dataMonthReal.REAL);
	
	$('#up_prognosa_percent').html(percenProgUp.toFixed(2)+'%');
	$('#up_rkap_percent').html(percenRkapUp.toFixed(2)+'%');
	
}

function viewWilayah(dataStRkap, dataStReal){
	var dataMonthReal = dataStReal[0].up_month.wilayah;
	var dataMonthRkap = dataStRkap[0].up_month.wilayah;
	
	var percenProgUp1 = (parseInt(dataMonthReal['1'].REAL)/parseInt(dataMonthRkap['WILAYAH I'].PROGNOSA))*100;
	var percenRkapUp1 = (parseInt(dataMonthReal['1'].REAL)/parseInt(dataMonthRkap['WILAYAH I'].RKAP))*100;
	
	var percenProgUp2 = (parseInt(dataMonthReal['2'].REAL)/parseInt(dataMonthRkap['WILAYAH II'].PROGNOSA))*100;
	var percenRkapUp2 = (parseInt(dataMonthReal['2'].REAL)/parseInt(dataMonthRkap['WILAYAH II'].RKAP))*100;
	
	var percenProgUp3 = (parseInt(dataMonthReal['3'].REAL)/parseInt(dataMonthRkap['WILAYAH III'].PROGNOSA))*100;
	var percenRkapUp3 = (parseInt(dataMonthReal['3'].REAL)/parseInt(dataMonthRkap['WILAYAH III'].RKAP))*100;
	
	$('#wil_real1 strong').html(numberWithCommas(dataMonthReal['1'].REAL));
	$('#wil_real2 strong').html(numberWithCommas(dataMonthReal['2'].REAL));
	$('#wil_real3 strong').html(numberWithCommas(dataMonthReal['3'].REAL));
	
	$('#wil_rkap1 strong').html(numberWithCommas(dataMonthRkap['WILAYAH I'].RKAP));
	$('#wil_rkap2 strong').html(numberWithCommas(dataMonthRkap['WILAYAH II'].RKAP));
	$('#wil_rkap3 strong').html(numberWithCommas(dataMonthRkap['WILAYAH III'].RKAP));
	
	$('#wil_prognosa1 strong').html(numberWithCommas(dataMonthRkap['WILAYAH I'].PROGNOSA));
	$('#wil_prognosa2 strong').html(numberWithCommas(dataMonthRkap['WILAYAH II'].PROGNOSA));
	$('#wil_prognosa3 strong').html(numberWithCommas(dataMonthRkap['WILAYAH III'].PROGNOSA));
	
	$('#wil_percent_rkap1 strong').html(percenRkapUp1.toFixed(2)+'%');
	$('#wil_percent_rkap2 strong').html(percenRkapUp2.toFixed(2)+'%');
	$('#wil_percent_rkap3 strong').html(percenRkapUp3.toFixed(2)+'%');
	
	$('#wil_percent_prognosa1 strong').html(percenProgUp1.toFixed(2)+'%');
	$('#wil_percent_prognosa2 strong').html(percenProgUp2.toFixed(2)+'%');
	$('#wil_percent_prognosa3 strong').html(percenProgUp3.toFixed(2)+'%');
	
}

function viewKemasan(dataStRkap, dataStReal){
	var dataMonthReal = dataStReal[0].up_month.kemasan;
	var dataMonthRkap = dataStRkap[0].up_month.kemasan;
	
	var percenProgUp1 = (parseInt(dataMonthReal['SEMEN PCC ZAK 50KG'].REAL)/parseInt(dataMonthRkap['BAG'].PROGNOSA))*100;
	var percenRkapUp1 = (parseInt(dataMonthReal['SEMEN PCC ZAK 50KG'].REAL)/parseInt(dataMonthRkap['BAG'].RKAP))*100;
	
	var percenProgUp2 = (parseInt(dataMonthReal['SEMEN PCC CURAH'].REAL)/parseInt(dataMonthRkap['CURAH'].PROGNOSA))*100;
	var percenRkapUp2 = (parseInt(dataMonthReal['SEMEN PCC CURAH'].REAL)/parseInt(dataMonthRkap['CURAH'].RKAP))*100;
	
	$('#kem_real1 strong').html(numberWithCommas(dataMonthReal['SEMEN PCC ZAK 50KG'].REAL));
	$('#kem_real2 strong').html(numberWithCommas(dataMonthReal['SEMEN PCC CURAH'].REAL));
	$('#kem_real3 strong').html(numberWithCommas(dataMonthReal['KLINKER OPC'].REAL));
	    
	$('#kem_rkap1 strong').html(numberWithCommas(dataMonthRkap['BAG'].RKAP));
	$('#kem_rkap2 strong').html(numberWithCommas(dataMonthRkap['CURAH'].RKAP));
	    
	$('#kem_prognosa1 strong').html(numberWithCommas(dataMonthRkap['BAG'].PROGNOSA));
	$('#kem_prognosa2 strong').html(numberWithCommas(dataMonthRkap['CURAH'].PROGNOSA));
	    
	$('#kem_percent_rkap1 strong').html(percenRkapUp1.toFixed(2)+'%');
	$('#kem_percent_rkap2 strong').html(percenRkapUp2.toFixed(2)+'%');
	    
	$('#kem_percent_prognosa1 strong').html(percenProgUp1.toFixed(2)+'%');
	$('#kem_percent_prognosa2 strong').html(percenProgUp2.toFixed(2)+'%');
}

function viewIncoterm(dataStRkap, dataStReal){
	var dataMonthReal = dataStReal[0].up_month.incoterm;
	var dataMonthRkap = dataStRkap[0].up_month.incoterm;
	
	var percenProgUp1 = (parseInt(dataMonthReal['CIF'].REAL)/parseInt(dataMonthRkap['CIF'].PROGNOSA))*100;
	var percenRkapUp1 = (parseInt(dataMonthReal['CIF'].REAL)/parseInt(dataMonthRkap['CIF'].RKAP))*100;
	
	var percenProgUp2 = (parseInt(dataMonthReal['FOB'].REAL)/parseInt(dataMonthRkap['FOB'].PROGNOSA))*100;
	var percenRkapUp2 = (parseInt(dataMonthReal['FOB'].REAL)/parseInt(dataMonthRkap['FOB'].RKAP))*100;
	
	var percenProgUp3 = (parseInt(dataMonthReal['FOT'].REAL)/parseInt(dataMonthRkap['FOT'].PROGNOSA))*100;
	var percenRkapUp3 = (parseInt(dataMonthReal['FOT'].REAL)/parseInt(dataMonthRkap['FOT'].RKAP))*100;
	
	var percenProgUp4 = (parseInt(dataMonthReal['FRC'].REAL)/parseInt(dataMonthRkap['FRC'].PROGNOSA))*100;
	var percenRkapUp4 = (parseInt(dataMonthReal['FRC'].REAL)/parseInt(dataMonthRkap['FRC'].RKAP))*100;
	
	$('#inc_real1 strong').html(numberWithCommas(dataMonthReal['FOT'].REAL));
	$('#inc_real2 strong').html(numberWithCommas(dataMonthReal['FOB'].REAL));
	$('#inc_real3 strong').html(numberWithCommas(dataMonthReal['CIF'].REAL));
	$('#inc_real4 strong').html(numberWithCommas(dataMonthReal['FRC'].REAL));
	    
	$('#inc_rkap1 strong').html(numberWithCommas(dataMonthRkap['FOT'].RKAP));
	$('#inc_rkap2 strong').html(numberWithCommas(dataMonthRkap['FOB'].RKAP));
	$('#inc_rkap3 strong').html(numberWithCommas(dataMonthRkap['CIF'].RKAP));
	$('#inc_rkap4 strong').html(numberWithCommas(dataMonthRkap['FRC'].RKAP));
	    
	$('#inc_prognosa1 strong').html(numberWithCommas(dataMonthRkap['FOT'].PROGNOSA));
	$('#inc_prognosa2 strong').html(numberWithCommas(dataMonthRkap['FOB'].PROGNOSA));
	$('#inc_prognosa3 strong').html(numberWithCommas(dataMonthRkap['CIF'].PROGNOSA));
	$('#inc_prognosa4 strong').html(numberWithCommas(dataMonthRkap['FRC'].PROGNOSA));
	    
	$('#inc_percent_rkap1 strong').html(percenRkapUp1.toFixed(2)+'%');
	$('#inc_percent_rkap2 strong').html(percenRkapUp2.toFixed(2)+'%');
	$('#inc_percent_rkap3 strong').html(percenRkapUp2.toFixed(2)+'%');
	$('#inc_percent_rkap4 strong').html(percenRkapUp2.toFixed(2)+'%');
	    
	$('#inc_percent_prognosa1 strong').html(percenProgUp1.toFixed(2)+'%');
	$('#inc_percent_prognosa2 strong').html(percenProgUp2.toFixed(2)+'%');
	$('#inc_percent_prognosa3 strong').html(percenProgUp2.toFixed(2)+'%');
	$('#inc_percent_prognosa4 strong').html(percenProgUp2.toFixed(2)+'%');
}

function showChart(dataStRkapChart, dataStRealChart){
	
	var labelArray = [];
	var prognose = [];
	var real = [];
	var rkap = [];
	
	var dataRkap = dataStRkapChart[0].daily.all;
	var dataReal = dataStRealChart[0].daily.all;
	
	for (var x=0;x<dataRkap.length;x++) {
		prognose.push(parseFloat(dataRkap[x][x+1].PROGNOSA));
		rkap.push(parseFloat(dataRkap[x][x+1].RKAP));
	}
	for (var x=0;x<dataReal.length;x++) {
		real.push(parseFloat(dataReal[x][x+1].REAL));
	}
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
					return '<b>'+t+'<br>'+s+' '+setFormat(n,0)+' Ton</b>';
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
				},{
					name: 'Realisasi',
					color: '#22A7F0',
					data: real,
					pointPadding: 0.25,
					pointPlacement: 0
				},{
		type: 'spline',
					name: 'RKAP',
					color: '#D91E18',
					data: rkap,
				}]
		});
}

function opcoGroup (selday, selmonth, selyear, plant){
	var monthBefore = selmonth-1;
	if(monthBefore<=9){
		monthBefore = '0'+monthBefore
	}
	
	var yearBefore = selyear-1;
    run_waitMe('.wrapper', 'ios');
	
	var urlStRkap =  url_ol+'/api/index.php/rkap_sales_st?bulan='+selmonth+'&tahun='+selyear+'&plant='+plant;
	var urlStReal =  url_ol+'/api/index.php/real_sales_st?bulan='+selmonth+'&tahun='+selyear+'&plant='+plant;
	
	var urlStRkapChart =  url_ol+'/api/index.php/rkap_sales_st/chart?bulan='+selmonth+'&tahun='+selyear+'&plant='+plant;
	var urlStRealChart =  url_ol+'/api/index.php/real_sales_st/chart?bulan='+selmonth+'&tahun='+selyear+'&plant='+plant;
	
	stop_waitMe('.wrapper');
	
	$.when(
	    $.getJSON(urlStRkap),
	    $.getJSON(urlStReal),
	    $.getJSON(urlStRkapChart),
	    $.getJSON(urlStRealChart)
	    ).done(function(dataStRkap, dataStReal, dataStRkapChart, dataStRealChart){
			viewAll(dataStRkap, dataStReal);
			viewWilayah(dataStRkap, dataStReal);
			viewKemasan(dataStRkap, dataStReal);
			viewIncoterm(dataStRkap, dataStReal);
			showChart(dataStRkapChart, dataStRealChart);
			// stop_waitMe('.wrapper');
		});
}