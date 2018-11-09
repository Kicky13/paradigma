function opcoGroup (selday, selmonth, selyear, plant){
	var monthBefore = selmonth-1;
	if(monthBefore<=9){
		monthBefore = '0'+monthBefore
	}
	
	stop_waitMe('.wrapper');
	showChart();
	showChart2();
}


var labelArray = ['Pembangkit', 'Tonasa 2/3', 'Tonasa 4', 'Tonasa 5', 'UP Tonasa', 'UP Biringkassi', 'UP Makassar', 'UP Samarinda', 'UP Bitung', 'UP Celukan Bawang', 'UP Banjarmasin', 'UP Ambon', 'UP Palu', 'UP Kendari', 'UP Sorong', 'UP Mamuju'];
function showChart(){
	$('.cost_sheet_chart').highcharts({
		chart: {
			type: 'column'
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
			headerFormat: '<span style="font-size:10px;color:#999">{point.key}</span><table>',
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
			name: 'Listrik',
			data: [12382, 23423, 12343, 34536, 42345, 46453, 45645, 34534, 34535, 12315, 12356, 43215, 23421, 34532, 12314, 34231]

		}
		]
	});
}

var labelArray2 = ['Pembangkit', 'Tonasa 2/3', 'Tonasa 4', 'Tonasa 5', 'UP Tonasa', 'UP Biringkassi', 'UP Makassar', 'UP Samarinda', 'UP Bitung', 'UP Celukan Bawang', 'UP Banjarmasin', 'UP Ambon', 'UP Palu', 'UP Kendari', 'UP Sorong', 'UP Mamuju'];
function showChart2(){
	$('.cost_sheet_chart2').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: labelArray2,
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
			name: 'Listrik',
			data: [49.9]

		}, {
			showInLegend: false,
			name: 'Batu Kapur Tambang',
			data: [83.6]

		}, {
			showInLegend: false,
			name: 'Batu Kapur Pecah',
			data: [48.9]

		}, {
			showInLegend: false,
			name: 'Tanah Liat Tambang',
			data: [42.4]

		}, {
			showInLegend: false,
			name: 'Batu Kapur Tambang',
			data: [83.6]

		}, {
			showInLegend: false,
			name: 'Batu Kapur Pecah',
			data: [48.9]

		}, {
			showInLegend: false,
			name: 'Tanah Liat Tambang',
			data: [42.4]

		}, {
			showInLegend: false,
			name: 'Batu Kapur Tambang',
			data: [83.6]

		}, {
			showInLegend: false,
			name: 'Batu Kapur Pecah',
			data: [48.9]

		}, {
			showInLegend: false,
			name: 'Tanah Liat Tambang',
			data: [42.4]

		}, {
			showInLegend: false,
			name: 'Batu Kapur Tambang',
			data: [83.6]

		}, {
			showInLegend: false,
			name: 'Batu Kapur Pecah',
			data: [48.9]

		}, {
			showInLegend: false,
			name: 'Tanah Liat Tambang',
			data: [42.4]

		}
		]
	});
}

