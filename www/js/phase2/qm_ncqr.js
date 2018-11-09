var tmp = '';
function toFixed(num, fixed) {
    var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
    return num.toString().match(re)[0];
}
function trend(opco, data){
	var avg = 0;
	if(opco==8){
		avg = data.Total[0].AVG_SCORE;
	}else if(opco==9){
		avg = data.Total[1].AVG_SCORE;
	}else if(opco==10){
		avg = data.Total[2].AVG_SCORE;
	}else{
		avg = data.Total[3].AVG_SCORE;
	}
	avg = (avg==null) ? '0':avg;
	$('#avarage').html(toFixed(avg, 2));
	var nw = [];
	var sld = [];
	for (var x=0;x<data.Trend.length;x++) {
		nw.push(data.Trend[x].BARU);
		sld.push(data.Trend[x].SOLVED);
	}
	$('#chart').highcharts({
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
			categories: '',
			tickInterval: 1,
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			},
	        stackLabels: {
	            enabled: true,
	            style: {
	                fontWeight: 'bold',
	                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
	            }
	        }
		},
		tooltip: {
			formatter: function () {
				var n = this.y;
				var s = this.series.name;
				return s;
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
		legend: {
	        enabled: false
	    },
	    tooltip: {
			formatter: function () {
				var n = this.y;
				var s = this.series.name;
				var t = this.point.x + 1;
				return 'Tanggal '+ t + '<br>' + s + ':'+n+'</span><br>Total Incident: '+this.point.stackTotal;
			}

		},
		plotOptions: {
	        column: {
	            stacking: 'normal',
	            dataLabels: {
	                enabled: true,
	                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
	            }
	        }
	    },
		series: [{
	        name: 'New Incident',
	        data: nw,
	        color:'#FF4757'
	    }, {
	        name: 'Incident Solved',
	        data: sld,
	        color:'#1E90FF'
	    }]
	});
}

function action_list(datas, date){
	tmp = '';
	var comp;
	for(var i=0; i<datas.length; i++) {
		if(datas[i].opco=="SP"){
			comp='Semen Padang';
		}else if(datas[i].opco=="SG"){
			comp='Semen Gresik';
		}else if(datas[i].opco=="ST"){
			comp='Semen Tonasa';
		}else{
			comp='TLCC';
		}
		tmp += '<a href="p2_qm_siramah_detail.html#'+datas[i].opco+'/'+date+'" style="border-top:5px solid '+datas[i].color+'">'
			tmp += '<span style="color:'+datas[i].color+'">'+comp+'</span>'
			tmp += '<ul>'
				tmp += datas[i].catatan 
			tmp += '</ul>'
		tmp += '</a>'
    }
	$("#action").html(tmp);
}

function opcoGroup (opco, selyear){
    run_waitMe('.wrapper', 'ios');

	var urlDev = 'http://par4digma.semenindonesia.com/api/';
	$.getJSON(urlDev+'index.php/quality_management/ncqr?year='+selyear+'&comp='+opco, function(data){
		trend(opco, data);
    	stop_waitMe('.wrapper');
	});
}


