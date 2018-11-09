var satuan="Billion";
var satuan_ex="B";
var pembagi=1000000000;
var jenis_rkap="RKAP_REVENUE";
var jenis_real="REV";
if(jenis=="volume"){
	satuan='Kilo Ton';
	satuan_ex='KT';
	pembagi=1000;
	jenis_rkap='RKAP_VOLUME';
  	jenis_real="VOL";
}

function numberFormat(x) {
    var nominal = parseFloat(x).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return nominal.replace(".","-").split(",").join('.').replace('-',',');
}
function DailyTrend(data){

	var prognose = [];
	var real = [];
	var rkap = [];
	var label = [];
	for (var i=0;i<data.DATA_RKAP.length;i++) {
		if(data.DATA_RKAP[i].TANGGAL!="  "){
			rkap.push(parseFloat(data.DATA_RKAP[i][jenis_rkap])/pembagi);
			label.push(data.DATA_RKAP[i].TANGGAL);
		}
	};
	for (var i=0;i<data.DATA_ACTUAL.length;i++) {
		real.push(parseFloat(data.DATA_ACTUAL[i][jenis_real])/pembagi);
	};

	$('#dailyTrend').highcharts({
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
			categories: label,
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
				return s + ':<br>' + numberFormat(n)+' '+satuan;
			}

		},
        credits: {
			enabled: false
		},
		exporting: {
			enabled: false
		},
        plotOptions: {
	        series: {
	            borderWidth: 0,
	            dataLabels: {
	                enabled: true,
	                format: '{point.y:.0f}'+satuan_ex,
	                style: {
		                fontSize: '12px',
		                fontFamily: 'Verdana, sans-serif'
		            }
	            }
	        }
	    },
		legend: {
			enabled: false
		},
		series: [{
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
function MonthlyTrend(data){
	var prognose = [];
	var real = [];
	var rkap = [];
	var label = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];

	for (var i=0;i<data.DATA_RKAP.length;i++) {
		rkap.push(parseFloat(data.DATA_RKAP[i][jenis_rkap])/pembagi);
	};
	for (var i=0;i<data.DATA_ACTUAL.length;i++) {
		real.push(parseFloat(data.DATA_ACTUAL[i][jenis_real])/pembagi);
	};

	$('#monthlyTrend').highcharts({
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
			categories: label,
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
				return s + ':<br>' + numberFormat(n)+' '+satuan;
			}

		},
        credits: {
			enabled: false
		},
		exporting: {
			enabled: false
		},
        plotOptions: {
	        series: {
	            borderWidth: 0,
	            dataLabels: {
	                enabled: true,
	                format: '{point.y:.0f}'+satuan_ex,
	                style: {
		                fontSize: '12px',
		                fontFamily: 'Verdana, sans-serif'
		            }
	            }
	        }
	    },
		legend: {
			enabled: false
		},
		series: [{
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
function format_number(nominal){
	if((typeof nominal)=="string"){
		nominal = nominal.split(',').join('');
		nominal = parseFloat(nominal);
	}
	return nominal;
}
function numberFormat(x) {
    var nominal = parseFloat(x).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return nominal.replace(".","-").split(",").join('.').replace('-',',');
}

var url_daily = 'Sales_revenue_bpc/VolumeRevenue_TREND_SMIG/';
var url_monthly = 'Sales_revenue_bpc/VolumeRevenue_TRENDBULAN_SMIG/';
if(opco){
	url_daily = 'Sales_revenue_bpc/VolumeRevenue_TREND_PER_OPCO/'+opco;
	url_monthly = 'Sales_revenue_bpc/VolumeRevenue_TRENDBULAN_PER_OPCO/'+opco;
}
$.getJSON(base_url+url_daily, function(data){
	DailyTrend(data);
});
$.getJSON(base_url+url_monthly, function(data){
	MonthlyTrend(data);
});
