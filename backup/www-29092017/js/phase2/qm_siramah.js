var tmp = '';
function graphicChart_compare(datas){
	  Highcharts.chart('graphic_compare', {
        chart: {
          backgroundColor: 'rgba(0, 255, 0, 0)',
          type: 'bar',
          height:300
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ["SP", "SG", "ST", "TLCC"],
            title: {
                text: ''
            }
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            pointFormatter: function() {
	        	return this.y + ' %';
	        }
        },
        credits: {
                    enabled: false
                },
	       exporting: {
                    enabled: false
                },
        plotOptions: {
            bar: {
		        showInLegend: true,
                dataLabels: {
                    enabled: true,
                    formatter:function(){
                        return this.y + ' %';;
                    }
                }
            }
        },
        legend: {
         	enabled: false
        },
        credits: {
            enabled: false
        },
        series: [
        	{
	            data: [{
	                y: parseFloat(datas[0].total),
	                color: ''+datas[0].color,
	                name: ''+datas[0].opco
		        },{
	                y: parseFloat(datas[1].total),
	                color: ''+datas[1].color,
	                name: ''+datas[1].opco
		        },{
	                y: parseFloat(datas[2].total),
	                color: ''+datas[2].color,
	                name: ''+datas[2].opco
		        },{
	                y: parseFloat(datas[3].total),
	                color: ''+datas[3].color,
	                name: ''+datas[3].opco
		        }]
	        }
        ]
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

function opcoGroup (selmonth, selyear){
	datas = {"total":[],"colors":[],"action":{"opco":[], "list":[]}};
    run_waitMe('.wrapper', 'ios');

	var date = selmonth+'-'+selyear;
	$.ajax({
		url: 'http://10.15.2.130/par4digma/global_report?date='+date,
		type: "get",
		dataType: "json",
		success: function (data) {
			console.log(data);
    		graphicChart_compare(data);
			action_list(data, date);
			stop_waitMe('.wrapper');
		}
	});	
}


