
var tmp = '';
function numberFormat(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function highlight(data){
	$('#cashonhand').html('');
	$('#cash').html('');
	$('#cashin').html('');
	$('#cashout').html('');

	$('#cashonhand').html(numberFormat(data.cashonhand/1000000));
	$('#cash').html(numberFormat(data.detail[0].value/1000000));
	$('#cashin').html(numberFormat(data.detail[1].value/1000000));
	$('#cashout').html(numberFormat(data.detail[2].value/1000000));
	// $('#last_update').html('Last Update : '+data[0].LAST_UPDATE);
	
}
var labelArrayDay = [];
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}
function graphic_saldo(data){
	// var dataJson = JSON.parse(data);
	var saldo = [];
	
	for (var x=data.length-1;x>=0;x--) {
		saldo.push(parseFloat(data[x].cashonhand/1000000));
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
			color: '#337ab7',
			data : saldo,
		}]
	});
}

function graphic_in(data){
	var saldo = [];
	
	for (var x=data.length-1;x>=0;x--) {
		saldo.push(parseFloat(data[x].detail[2].value/1000000));
	}
	console.log('1 '+saldo);
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
			type: 'spline',
			name: 'CASH OUT',
			color: '#D91E18',
			data : saldo,
		}]
	});
}

function graphic_out(data){
	var saldo = [];
	
	for (var x=data.length-1;x>=0;x--) {
		saldo.push(parseFloat(data[x].detail[1].value/1000000));
	}
	console.log('2 '+saldo);
	$('#chart3').highcharts({
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
			name: 'RECEIPT',
			color: '#92c758',
			data : saldo,
		}]
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

function opcoGroup(selmonth, selyear, selcur, selopco){
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
	$.getJSON('http://par4digma.semenindonesia.com/api/index.php/cash_position/get_data?comp='+selopco+'&cur='+selcur+'&month='+selmonth+'&year='+selyear,function (data) {
		highlight(data[0]);
		graphic_saldo(data);
		graphic_in(data);
		graphic_out(data);
		stop_waitMe('.wrapper');
	});
}



