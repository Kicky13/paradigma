
var tmp = '';
function highlight(selmonth, selyear){
	$('#cashonhand').html('');
	$('#cash').html('');
	$('#cashin').html('');
	$('#cashout').html('');
	var Url = $.getJSON('http://par4digma.semenindonesia.com/api/index.php/cash_flow_st?bulan='+selmonth+'&tahun='+selyear, function(data){
		$('#cashonhand').html((parseInt(data[0].SALDO))/1000);
		$('#cash').html((parseInt(data[0].BEGINING_BALANCE))/1000);
		$('#cashin').html((parseInt(data[0].CASHIN))/1000);
		$('#cashout').html((parseInt(data[0].CASHOUT))/1000);
		$('#last_update').html('Last Update : '+data[0].LAST_UPDATE);
	});
	
}
var labelArrayDay = [];
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}
function graphic_saldo(selmonth, selyear){

			console.log(url_src+'/api/index.php/cash_flow_st/saldo_harian?bulan='+selmonth+'&tahun='+selyear);
		$.ajax({
		url: url_src+'/api/index.php/cash_flow_st/saldo_harian?bulan='+selmonth+'&tahun='+selyear,
		type: 'GET',
		success: function (data) {
			var dataJson = JSON.parse(data);
			var saldo = [];
			
			for (var x=0;x<dataJson.length;x++) {
				saldo.push(parseFloat(dataJson[x].NILAI));
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
			type: 'spline',
			name: 'Saldo',
			color: '#D91E18',
			// data : [11,44,22,23,12,55,64,23,78,96,12,32,76,98,34,77,74,89,13,23,53,68],
			data : saldo,
		}]
	});
}
});
}
function graphic_pemasukan(data){
		var rkap=[];
		var cashin =[];
		for (var i = 0; i < data['CASHIN'].length; i++) {
			cashin.push(parseFloat(data['CASHIN'][i].NILAI));
			rkap.push(parseFloat(data['CASHIN'][i].RKAP));
		}
	
	$('#chart2').highcharts({
		chart: {
			type: 'column'
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
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
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
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [
		{
			showInLegend: false,
			name: 'Receipt',
			color:'#E9D460',
			// data: [123, 345, 231, 432, 123, 345, 231, 432, 123, 345, 231, 432, 123, 345, 231, 432, 123, 345, 231, 432]
			data : cashin

		}, {
			type: 'spline',
			showInLegend: false,
			name: 'RKAP',
			color: '#EF4836',
			data: rkap
			// data: [234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234]

		}
		]
	});
}
function graphic_pembayaran(data){
	var cashout =[];
	var rkap=[];
		for (var i = 0; i < data['CASHOUT'].length; i++) {
			cashout.push(parseFloat(data['CASHOUT'][i].NILAI));
			rkap.push(parseFloat(data['CASHOUT'][i].RKAP));
		}
	$('#chart3').highcharts({
		chart: {
			type: 'column'
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
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
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
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [
		{
			showInLegend: false,
			name: 'Disburstement',
			color:'#E9D460',
			// data: [123, 345, 231, 432, 123, 345, 231, 432, 123, 345, 231, 432, 123, 345, 231, 432, 123, 345, 231, 432, 321]
			data: cashout


		}, {
			type: 'spline',
			showInLegend: false,
			name: 'RKAP',
			color: '#EF4836',
			data: rkap
			// data: [234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234, 234]

		}
		]
	});
}
var labelArrayMonth=['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
function graphic_deposito(data){
	var deposito =[];
		for (var i = 0; i < data['DEPOSITO'].length; i++) {
			deposito.push(((data['DEPOSITO'][i].NILAI == null) ? 0 : parseFloat(data['DEPOSITO'][i].NILAI)))
		}
	$('#chart4').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: labelArrayMonth,
			tickInterval: 1,
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
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
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [
		{
			showInLegend: false,
			name: 'Deposito',
			color:'#E9D460',
			// data: [123, 345, 231]
			data: deposito


		}
		]
	});
}

function opcoGroup(selmonth, selyear){
	var days = daysInMonth(selmonth,selyear);
	for (var x = 1; x <= days; x++) {
		if (x < 10) {
			var tgl = '0' + x;
		} else {
			var tgl = x;
		}
		labelArrayDay.push(tgl);
	}
	
	$.getJSON('http://par4digma.semenindonesia.com/api/index.php/cash_flow_st/average?bulan='+selmonth+'&tahun='+selyear,function (data) {
		
		graphic_pemasukan(data);
		graphic_pembayaran(data);
		graphic_deposito(data);
	});
    run_waitMe('.wrapper', 'ios');
	highlight(selmonth, selyear);
	graphic_saldo(selmonth, selyear);
	stop_waitMe('.wrapper');
}



