var label = [];
var now = [];
var last = [];
var hei = '';

//COMPARE CHART//
function graphicChart_compare(labels, data){
	  Highcharts.chart('graphic_compare', {
        chart: {
          backgroundColor: 'rgba(0, 255, 0, 0)',
          type: 'bar',
          // height: 300,
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: labels,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' millions'
        },
        credits: {
                    enabled: false
                },
	       exporting: {
                    enabled: false
                },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
         
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Actual',
            color: '#1E8BC3',
            data: data['actual']
        }, {
            name: 'RKAP',
            color: '#E9D460',
            data: data['rkap']
        }, {
            name: 'Actual Bulan Lalu',
            color: '#EF4836',
            data: data['actual1']
        }
        ]
    });
}

function graphicChart_compareSub(labels, data){
	  Highcharts.chart('graphic_compare_sub', {
		chart: {
		  backgroundColor: 'rgba(0, 255, 0, 0)',
		  type: 'bar',
		  // height: 300,
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: labels,
			title: {
				text: null
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: '',
				align: 'high'
			},
			labels: {
				overflow: 'justify'
			}
		},
		tooltip: {
			valueSuffix: ' millions'
		},
		credits: {
					enabled: false
				},
		   exporting: {
					enabled: false
				},
		plotOptions: {
			bar: {
				dataLabels: {
					enabled: true
				}
			}
		},
		legend: {
		 
		},
		credits: {
			enabled: false
		},
		series: [{
			name: 'Actual',
			color: '#1E8BC3',
			data: data['actual']
		}, {
            name: 'RKAP',
            color: '#E9D460',
            data: data['rkap']
        }, {
            name: 'Actual Bulan Lalu',
            color: '#EF4836',
            data: data['actual1']
        }
		]
    });
}

//PERFORM CHART//
function graphicChart_perform(labels, data){
	  Highcharts.chart('graphic_perform', {
        chart: {
			type: 'column',
			spacingBottom: 8,
			spacingTop: 8,
			spacingLeft: 5,
			spacingRight: 5,
			backgroundColor: 'rgba(0, 255, 0, 0)',
			animation: Highcharts.svg
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
			tickInterval: 1,
			tickmarkPlacement: 'on',
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			}
		},
		tooltip: {
			shared: true
		},
		exporting: {
			enabled: false
		},
		legend: {
			enabled: true,
			layout: 'horizontal',
			align: 'left',
			verticalAlign: 'bottom',
			x: 0,
			y: 0,
			backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
			shadow: true
		},
		credits: {
			enabled: false
		},
        series: [{
            name: 'Semen Padang',
            color: '#1E8BC3',
            data: data['3000']
        }, {
            name: 'Semen Gresik',
            color: '#E9D460',
            data: data['7000']
        }, {
            name: 'Semen Tonasa',
            color: '#EF4836',
            data: data['4000']
        }, {
            name: 'TLCC',
            color: '#19B5FE',
            data: []
        }
        ]
    });
}

function graphicChart_perform_sp(labels, data){
	  Highcharts.chart('graphic_perform_sub', {
        chart: {
			type: 'column',
			spacingBottom: 8,
			spacingTop: 8,
			spacingLeft: 5,
			spacingRight: 5,
			backgroundColor: 'rgba(0, 255, 0, 0)',
			animation: Highcharts.svg
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
			tickInterval: 1,
			tickmarkPlacement: 'on',
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			}
		},
		tooltip: {
			shared: true
		},
		exporting: {
			enabled: false
		},
		legend: {
			enabled: true,
			layout: 'horizontal',
			align: 'left',
			verticalAlign: 'bottom',
			x: 0,
			y: 0,
			backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
			shadow: true
		},
		credits: {
			enabled: false
		},
        series: [{
            name: 'Plant Indarung I',
            color: '#1E8BC3',
            data: data['P_3301']
        }, {
            name: 'Plant Indarung II/III',
            color: '#E9D460',
            data: data['P_3302']
        }, {
            name: 'Plant Indarung IV',
            color: '#EF4836',
            data: data['P_3303']
        }, {
            name: 'Plant Indarung V',
            color: '#19B5FE',
            data: data['P_3304']
        }, {
            name: 'Plant Cement Mill Dumai',
            color: '#BE90D4',
            data: data['P_3309']
        }
        ]
    });
}


function graphicChart_perform_st(labels, data){
	  Highcharts.chart('graphic_perform_sub', {
        chart: {
			type: 'column',
			spacingBottom: 8,
			spacingTop: 8,
			spacingLeft: 5,
			spacingRight: 5,
			backgroundColor: 'rgba(0, 255, 0, 0)',
			animation: Highcharts.svg
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
			tickInterval: 1,
			tickmarkPlacement: 'on',
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			}
		},
		tooltip: {
			shared: true
		},
		exporting: {
			enabled: false
		},
		legend: {
			enabled: true,
			layout: 'horizontal',
			align: 'left',
			verticalAlign: 'bottom',
			x: 0,
			y: 0,
			backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
			shadow: true
		},
		credits: {
			enabled: false
		},
        series: [{
            name: 'Tonasa II & III',
            color: '#1E8BC3',
            data: data['P_4301']
        }, {
            name: 'Tonasa IV',
            color: '#E9D460',
            data: data['P_4302']
        }, {
            name: 'Tonasa V',
            color: '#EF4836',
            data: data['P_4303']
        }
        ]
    });
}

function graphicChart_perform_sg(labels, data){
	  Highcharts.chart('graphic_perform_sub', {
        chart: {
			type: 'column',
			spacingBottom: 8,
			spacingTop: 8,
			spacingLeft: 5,
			spacingRight: 5,
			backgroundColor: 'rgba(0, 255, 0, 0)',
			animation: Highcharts.svg
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
			tickInterval: 1,
			tickmarkPlacement: 'on',
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			}
		},
		tooltip: {
			shared: true
		},
		exporting: {
			enabled: false
		},
		legend: {
			enabled: true,
			layout: 'horizontal',
			align: 'left',
			verticalAlign: 'bottom',
			x: 0,
			y: 0,
			backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
			shadow: true
		},
		credits: {
			enabled: false
		},
        series: [{
            name: 'Tuban I',
            color: '#1E8BC3',
            data: data['P_7302']
        }, {
            name: 'Tuban II',
            color: '#E9D460',
            data: data['P_7303']
        }, {
            name: 'Tuban III',
            color: '#EF4836',
            data: data['P_7304']
        }, {
            name: 'Tuban IV',
            color: '#19B5FE',
            data: data['P_7305']
        }
        ]
    });
}


var opco = [];
var datas = datasub = new Array();
datas = {"actual":[],"rkap":[],"actual1":[]};
datasub = {"actual":[],"rkap":[],"actual1":[]};
var total = 0;

function opcoGroup (opco, prod, labels, sd){
	var url3000 = url_ol+'/api/index.php/fin_cost/get_data_mview?date='+sd+'&company=3000';
	var url4000 = url_ol+'/api/index.php/fin_cost/get_data_mview?date='+sd+'&company=4000';
	var url7000 = url_ol+'/api/index.php/fin_cost/get_data_mview?date='+sd+'&company=7000';
	$.when(
	    $.getJSON(url3000),
	    $.getJSON(url4000),
	    $.getJSON(url7000)
	    ).done(function(result3000, result4000, result7000){
			//COMPARISON CHART//
			if(opco=='smi'){
				plotPlantCompare('3000', prod, result3000);
				plotPlantCompare('4000', prod, result4000);
				plotPlantCompare('7000', prod, result7000);
				graphicChart_compare(labels, datas);
			}
			if(opco=='3000'){
				plotSubPlantCompare('3000', prod, result3000);
				graphicChart_compareSub(labels, datasub);
			}
			if(opco=='4000'){
				plotSubPlantCompare('4000', prod, result4000);
				graphicChart_compareSub(labels, datasub);
			}
			if(opco=='7000'){
				plotSubPlantCompare('7000', prod, result7000);
				graphicChart_compareSub(labels, datasub);
			}
			$(".se-pre-con").fadeOut("slow");
	});
}

function plotPlantCompare(opco, prod, dataJson){
	var tableVal = dataJson['0']['s'+opco]['0'];
	if(prod=='cement'){
		var actThisMonth = tableVal.act_bulan_ini.cement;
		var actRkapThisMonth = tableVal.rkap_bulan_ini.cement;
		var actYesterdayMonth = tableVal.act_bulan_lalu.cement;
	}else{
		var actThisMonth = tableVal.act_bulan_ini.clinker;
		var actRkapThisMonth = tableVal.rkap_bulan_ini.clinker;
		var actYesterdayMonth = tableVal.act_bulan_lalu.clinker;
	}
	datas['actual'].push(actThisMonth);
	datas['rkap'].push(actRkapThisMonth);
	datas['actual1'].push(actYesterdayMonth);
}

function plotSubPlantCompare(opco, prod, dataJson){
	var tableVal = dataJson['0']['s'+opco]['0'];
	if(prod=='cement'){
		var actSubThisMonth = tableVal.act_bulan_ini.opcosubcement;
		var actSubRkapThisMonth = tableVal.rkap_bulan_ini.opcosubcement;
		var actSubYesterdayMonth = tableVal.act_bulan_lalu.opcosubcement;
	}else{
		var actSubThisMonth = tableVal.act_bulan_ini.opcosubclinker;
		var actSubRkapThisMonth = tableVal.rkap_bulan_ini.opcosubclinker;
		var actSubYesterdayMonth = tableVal.act_bulan_lalu.opcosubclinker;
	}
	for(var i=0;i<actSubThisMonth.length;i++){
		datasub['actual'].push(actSubThisMonth[i].JML);
		datasub['rkap'].push(actSubRkapThisMonth[i].JML);
		datasub['actual1'].push(actSubYesterdayMonth[i].JML);
	}
}

var datas2 = datasub2 = datasubs2 = new Array();
datas2 = {"3000":[], "4000":[], "7000":[]};
datasub2 = [];
datasub3000 = {"P_3301":[], "P_3302":[], "P_3303":[], "P_3304":[], "P_3309":[]};
datasub4000 = {"P_4301":[], "P_4302":[], "P_4303":[]};
datasub7000 = {"P_7301":[], "P_7302":[], "P_7303":[], "P_7304":[], "P_7305":[]};

function opcoGroupPerform (opco, prod, labels, selectyear){
	var url3000 = url_ol+'/api/index.php/fin_cost/get_data_mperform?year='+selectyear+'&company=3000';
	var url4000 = url_ol+'/api/index.php/fin_cost/get_data_mperform?year='+selectyear+'&company=4000';
	var url7000 = url_ol+'/api/index.php/fin_cost/get_data_mperform?year='+selectyear+'&company=7000';
	$.when(
	    $.getJSON(url3000),
	    $.getJSON(url4000),
	    $.getJSON(url7000)
	    ).done(function(result3000, result4000, result7000){
			if(opco=='smi'){
				plotPlantPerform('3000', prod, result3000);
				plotPlantPerform('4000', prod, result4000);
				plotPlantPerform('7000', prod, result7000);
				graphicChart_perform(labels, datas2);
			}
			if(opco=='3000'){
				plotSubPlantPerform('3000', prod, result3000);
				graphicChart_perform_sp(labels, datasub3000);
			}
			if(opco=='4000'){
				plotSubPlantPerform('4000', prod, result4000);
				graphicChart_perform_st(labels, datasub4000);
			}
			if(opco=='7000'){
				plotSubPlantPerform('7000', prod, result7000);
				graphicChart_perform_sg(labels, datasub7000);
			}
			$(".se-pre-con").fadeOut("slow");
	});
}

function plotPlantPerform(opco, prod, dataJson){
	var tableVal = dataJson['0']['s'+opco]['0'];
	var actThisYear;
	for(var i=1;i<13;i++){
		if(prod=='cement'){
			actThisYear = tableVal.act_tahun_ini[i].cement;
		}else{
			actThisYear = tableVal.act_tahun_ini[i].clinker;
		}
		datas2[opco].push(actThisYear);
	}
}

function plotSubPlantPerform(opco, prod, dataJson){
	var tableVal = dataJson['0']['s'+opco]['0'];
	var actSubThisYear;
	for(var i=1;i<13;i++){
		if(prod=='cement'){
			actSubThisYear = tableVal.act_tahun_ini[i].opcosubcement;
		}else{
			actSubThisYear = tableVal.act_tahun_ini[i].opcosubclinker;
		}
		datasub2.push(actSubThisYear);
	}
	for(var j=0;j<datasub2.length;j++){
		for(var y=0;y<datasub2[j].length;y++){
			if(opco=='3000'){
				datasub3000[datasub2[j][y].PLANT].push(datasub2[j][y].JML);
			}
			if(opco=='4000'){
				datasub4000[datasub2[j][y].PLANT].push(datasub2[j][y].JML);
			}
			if(opco=='7000'){
				datasub7000[datasub2[j][y].PLANT].push(datasub2[j][y].JML);
			}
		}
	}
}


function back_(){
	if (getParam('opco')==7000) {
		window.location.href = 'fin_cost_str_sg.html';
	}else if (getParam('opco')==3000) {
		window.location.href = 'fin_cost_str_sp.html';
	}else if (getParam('opco')==4000) {
		window.location.href = 'fin_cost_str_st.html';
	}else if (getParam('opco')==6000) {
		window.location.href = 'fin_cost_str_tl.html';
	}
}

