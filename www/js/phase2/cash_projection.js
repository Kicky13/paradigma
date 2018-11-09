var tmp = '';
function numberFormat(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function highlight(data){
	
	
}
var labelArrayDay = [];
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}
function graphic_saldo(data){
	var va1 = [];
	var va2 = [];
	var va3 = [];
	
	var vf1 = [];
	var vf2 = [];
	var vf3 = [];

	for (var x=0;x<data.length;x++) {
		va1.push(parseFloat(data[x][0].F3));
		va2.push(parseFloat(data[x][1].F3));
		va3.push(parseFloat(data[x][2].F3));
		vf1.push(parseFloat(data[x][0].F5));
		vf2.push(parseFloat(data[x][1].F5));
		vf3.push(parseFloat(data[x][2].F5));
	}
	$('#chart1').highcharts({
		chart: {
			type: 'column',
			animation: Highcharts.svg
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: labelArrayDay,
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
		},
		series: [{
			name: 'Bank',
			color: '#4caf49',
			data : va1,
		},{
			name: 'Rencana Pembayaran Hutang ',
			color: '#22A7F0',
			data : va2,
		},{
			name: 'Rencana Penerimaan Hutang ',
			color: '#E9D460',
			data : va3,
		}]
	});
	$('#chart2').highcharts({
		chart: {
			type: 'column',
			animation: Highcharts.svg
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: labelArrayDay,
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
		},
		series: [{
			name: 'Bank',
			color: '#4caf49',
			data : vf1,
		},{
			name: 'Rencana Pembayaran Hutang ',
			color: '#22A7F0',
			data : vf2,
		},{
			name: 'Rencana Penerimaan Hutang ',
			color: '#E9D460',
			data : vf3,
		}]
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
	$.getJSON('http://10.15.5.150/dev/par4digma/api/index.php/finance_cash_projection/get_data?COM='+selopco+'&CUR='+selcur+'&month='+selmonth+'&year='+selyear,function (data) {
		graphic_saldo(data);
		stop_waitMe('.wrapper');
	});
}



