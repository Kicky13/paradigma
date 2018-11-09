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
            data: [0,0,0]
            //data: data['rkap']
        }
        ]
    });
}

function graphicChart_opco(labels, data){
	Highcharts.chart('graphic_compare_opco', {
        chart: {
          backgroundColor: 'rgba(0, 255, 0, 0)',
		  type: 'column',
		  polar: true
          // height: 300,
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['Clinker', 'Cement'],
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
            name: 'RKAP',
            color: '#FF615D',
            data: [0,0]
        }, { 
			name: 'Actual',
            color: '#45DD90',
            data: data['actual']
        }
        ]
    });
}

function graphicChart_opcor(labels, data){
	Highcharts.chart('graphic_compare_opcor', {
        chart: {
          backgroundColor: 'rgba(0, 255, 0, 0)',
		  type: 'column',
		  polar: true
          // height: 300,
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['Clinker', 'Cement'],
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
            name: 'RKAP',
            color: '#FF615D',
            data: [0,0]
        }, { 
			name: 'Actual',
            color: '#45DD90',
            data: data['actual']
        }
        ]
    });
}

var opco = [];

var totalall = totaldomcem = totaldomcli = clinkersmi = clinkersp = clinkerst = clinkersmieks = clinkersmieksi = clinkerspeksi = clinkersteksi = prcnclinker = cementsmi = cementsp = cementst =  cementsmieks = cementspeks = cementsteks =  cementsmieksi = cementspeksi = cementsteksi = prcncement = totalekscem = totalekscli= prcncementeks = prcnclinkereks = totalallr = clinkerspeksr = clinkerspeksir = totaldomcemr = totaldomclir = clinkersmir = clinkerspr = clinkerstr = prcnclinkerr = cementsmir = cementspr = cementstr =  cementsmieksr = cementspeksr = cementsteksr =  cementsmieksir = cementspeksir = cementsteksir = prcncementr = totalekscemr = totaleksclir = prcncementeksr = prcnclinkereksr = 0;

var datas = datasr = new Array();
datas = {"actual":[],"rkap":[]};
datasr = {"actual":[],"rkap":[]};

function opcoGroup (opco, prod, type, labels, sd, model){
    run_waitMe('.wrapper', 'ios');
	var urlsmi = url_ol+'/api/index.php/fin_sales/get_data_salesvp?date='+sd+'&company=smi';
	var urlsmii = url_ol+'/api/index.php/fin_sales/get_data_salesvp?date='+sd+'&company=smii';
	var url3000 = url_ol+'/api/index.php/fin_sales/get_data_salesvp?date='+sd+'&company=3000';
	var url3000i = url_ol+'/api/index.php/fin_sales/get_data_salesvp?date='+sd+'&company=3000i';
	var url4000 = url_ol+'/api/index.php/fin_sales/get_data_salesvp?date='+sd+'&company=4000';
	var url4000i = url_ol+'/api/index.php/fin_sales/get_data_salesvp?date='+sd+'&company=4000i';
	
	var urlsmir = url_ol+'/api/index.php/fin_sales/get_data_salesrp?date='+sd+'&company=smi';
	var urlsmiir = url_ol+'/api/index.php/fin_sales/get_data_salesrp?date='+sd+'&company=smii';
	var url3000r = url_ol+'/api/index.php/fin_sales/get_data_salesrp?date='+sd+'&company=3000';
	var url3000ir = url_ol+'/api/index.php/fin_sales/get_data_salesrp?date='+sd+'&company=3000i';
	var url4000r = url_ol+'/api/index.php/fin_sales/get_data_salesrp?date='+sd+'&company=4000';
	var url4000ir = url_ol+'/api/index.php/fin_sales/get_data_salesrp?date='+sd+'&company=4000i';
	
	$.when(
	    $.getJSON(urlsmi),
	    $.getJSON(urlsmii),
	    $.getJSON(url3000),
	    $.getJSON(url3000i),
	    $.getJSON(url4000),
	    $.getJSON(url4000i),
	    $.getJSON(urlsmir),
	    $.getJSON(urlsmiir),
	    $.getJSON(url3000r),
	    $.getJSON(url3000ir),
	    $.getJSON(url4000r),
	    $.getJSON(url4000ir)
	    ).done(function(resultsmi, resultsmii, result3000, result3000i, result4000, result4000i, resultsmir, resultsmiir, result3000r, result3000ir, result4000r, result4000ir){
			totalall = totaldomcem = totaldomcli = clinkersmi = clinkersp = clinkerst = clinkersmieks = clinkersmieksi = clinkerspeksi = clinkersteksi = prcnclinker = cementsmi = cementsp = cementst =  cementsmieks = cementspeks = cementsteks =  cementsmieksi = cementspeksi = cementsteksi = prcncement = totalekscem = totalekscli= prcncementeks = prcnclinkereks = totalallr = totaldomcemr = totaldomclir = clinkersmir = clinkerspr = clinkersteksr = clinkerstr = clinkersteksir = prcnclinkerr = clinkerspeksr = clinkerspeksir = cementsmir = cementspr = cementstr =  cementsmieksr = cementspeksr = cementsteksr =  cementsmieksir = cementspeksir = cementsteksir = prcncementr = totalekscemr = totaleksclir = prcncementeksr = prcnclinkereksr = 0;
			datas = {"actual":[],"rkap":[]};
			datasr = {"actual":[],"rkap":[]};
			if(opco=='smi' && model==""){
				plotPlant('smi', type, resultsmi);
				plotPlant('3000', type, result3000);
				plotPlant('4000', type, result4000);
				plotPlantr('smi', type, resultsmir);
				plotPlantr('3000', type, result3000r);
				plotPlantr('4000', type, result4000r);
			}
			if(opco=='3000'){
				plotPlant('3000', type, result3000);
			}
			if(opco=='4000'){
				plotPlant('4000', type, result4000);
			}
			
			if(type=='chart'){
				if(selectareas=="Export"){
					if(opco=='smi'){
						if(model=="Volume"){
							plotPlant('smi', type, resultsmi);
							plotPlant('3000', type, result3000);
							plotPlant('4000', type, result4000);
							plotPlant('smii', type, resultsmii);
							plotPlant('3000i', type, result3000i);
							plotPlant('4000i', type, result4000i);
						}else{
							plotPlant('smi', type, resultsmir);
							plotPlant('3000', type, result3000r);
							plotPlant('4000', type, result4000r);
							plotPlantr('smii', type, resultsmiir);
							plotPlantr('3000i', type, result3000ir);
							plotPlantr('4000i', type, result4000ir);
						}
					}
				}else{
					if(opco=='smi'){
						if(model=="Volume"){
							plotPlant('smi', type, resultsmi);
							plotPlant('3000', type, result3000);
							plotPlant('4000', type, result4000);
						}else{
							plotPlantr('smi', type, resultsmir);
							plotPlantr('3000', type, result3000r);
							plotPlantr('4000', type, result4000r);
						}
					}
				}
				graphicChart_compare(labels, datas);
			}else{
				if(opco=='smi'){
					plotPlant('smii', type, resultsmii);
					plotPlant('3000i', type, result3000i);
					plotPlant('4000i', type, result4000i);
					plotPlantr('smii', type, resultsmiir);
					plotPlantr('3000i', type, result3000ir);
					plotPlantr('4000i', type, result4000ir);
				}
				if(opco=='3000'){
					plotPlant('3000i', type, result3000i);
					plotPlantr('3000', type, result3000r);
					plotPlantr('3000i', type, result3000ir);
					datas['actual'].push(clinkersp+clinkerspeks+clinkerspeksi);
					datas['actual'].push(cementsp+cementspeks+cementspeksi);
					graphicChart_opco(labels, datas);
					datasr['actual'].push(clinkerspr+clinkerspeksr+clinkerspeksir);
					datasr['actual'].push(cementspr+cementspeksr+cementspeksir);
					graphicChart_opcor(labels, datasr);
				}
				if(opco=='4000'){
					plotPlant('4000i', type, result4000i);
					plotPlantr('4000', type, result4000r);
					plotPlantr('4000i', type, result4000ir);
					datas['actual'].push(clinkerst+clinkersteks+clinkersteksi);
					datas['actual'].push(cementst+cementsteks+cementsteksi);
					graphicChart_opco(labels, datas);
					datasr['actual'].push(clinkerstr+clinkersteksr+clinkersteksir);
					datasr['actual'].push(cementstr+cementsteksr+cementsteksir);
					graphicChart_opcor(labels, datasr);
				}
				if(opco=='7000'){
					plotPlant('smii', type, resultsmii);
					plotPlantr('smi', type, resultsmir);
					plotPlantr('smii', type, resultsmiir);
					datas['actual'].push(clinkersmi+clinkersmieks+clinkersmieksi);
					datas['actual'].push(cementsmi+cementsmieks+cementsmieksi);
					graphicChart_opco(labels, datas);
					datasr['actual'].push(clinkersmir+clinkersmieksr+clinkersmieksir);
					datasr['actual'].push(cementsmir+cementsmieksr+cementsmieksir);
					graphicChart_opcor(labels, datasr);
				}
				
				totalall = (totaldomcem+totaldomcli)+(totalekscem+totalekscli);
				var prcnall = ((totalall - 0) / totalall) * 100;
				
				totalallr = (totaldomcemr+totaldomclir)+(totalekscemr+totaleksclir);
				var prcnallr = ((totalallr - 0) / totalallr) * 100;
				
				$('#target_actual_vol').html(setFormat(totalall));
				$('#achievement_vol').html(setFormat(prcnall));
				$('#tot_dom_cem').html(setFormat(totaldomcem));
				$('#tot_dom_cli').html(setFormat(totaldomcli));
				$('#prcnclinker').html(setFormat(prcnclinker));
				$('#prcncement').html(setFormat(prcncement));
				$('#tot_eks_cem').html(setFormat(totalekscem));
				$('#tot_eks_cli').html(setFormat(totalekscli));
				$('#prcnclinkereks').html(setFormat(prcnclinkereks));
				$('#prcncementeks').html(setFormat(prcncementeks));		
				$('#target_actual_volr').html(setFormat(totalallr / 1000000000));
				$('#achievement_volr').html(setFormat(prcnallr / 1000000000));
				$('#tot_dom_cemr').html(setFormat(totaldomcemr / 1000000000));
				$('#tot_dom_clir').html(setFormat(totaldomclir / 1000000000));
				$('#prcnclinkerr').html(setFormat(prcnclinkerr / 1000000000));
				$('#prcncementr').html(setFormat(prcncementr / 1000000000));
				$('#tot_eks_cemr').html(setFormat(totalekscemr / 1000000000));
				$('#tot_eks_clir').html(setFormat(totaleksclir / 1000000000));
				$('#prcnclinkereksr').html(setFormat(prcnclinkereksr / 1000000000));
				$('#prcncementeksr').html(setFormat(prcncementeksr / 1000000000));
				
				if (prcnall > 50) {
					$('#icon_achievement_all').addClass('fa-sort-asc');
					$('#icon_achievement_all').attr('style', 'color: #7be668;position:relative;top: 10px;');
				} else {
					$('#icon_achievement_all').addClass('fa-sort-desc');
					$('#icon_achievement_all').attr('style', 'color: #EB1717;position:relative;top: 10px;');
				}
				
				if (prcnallr > 50) {
					$('#icon_achievement_allr').addClass('fa-sort-asc');
					$('#icon_achievement_allr').attr('style', 'color: #7be668;position:relative;top: 10px;');
				} else {
					$('#icon_achievement_allr').addClass('fa-sort-desc');
					$('#icon_achievement_allr').attr('style', 'color: #EB1717;position:relative;top: 10px;');
				}
				
				$('#clinkersmi').html(setFormat(clinkersmi));
				$('#clinkersp').html(setFormat(clinkersp));
				$('#clinkerst').html(setFormat(clinkerst));
				$('#cementsmi').html(setFormat(cementsmi));
				$('#cementsp').html(setFormat(cementsp));
				$('#cementst').html(setFormat(cementst));
				$('#totalsmi').html(setFormat(clinkersmi+cementsmi));
				$('#totalsp').html(setFormat(clinkersp+cementsp));
				$('#totalst').html(setFormat(clinkerst+cementst));
				
				if(opco=='smi'){
					$('#clinkersmieks').html(setFormat(clinkersmieks));
					$('#clinkerspeks').html(setFormat(clinkerspeks));
					$('#clinkersteks').html(setFormat(clinkersteks));
					$('#cementsmieks').html(setFormat(cementsmieks));
					$('#cementspeks').html(setFormat(cementspeks));
					$('#cementsteks').html(setFormat(cementsteks));
					$('#totalsmieks').html(setFormat(clinkersmieks+cementsmieks));
					$('#totalspeks').html(setFormat(clinkerspeks+cementspeks));
					$('#totalsteks').html(setFormat(clinkersteks+cementsteks));
					
					$('#clinkersmieksi').html(setFormat(clinkersmieksi));
					$('#clinkerspeksi').html(setFormat(clinkerspeksi));
					$('#clinkersteksi').html(setFormat(clinkersteksi));
					$('#cementsmieksi').html(setFormat(cementsmieksi));
					$('#cementspeksi').html(setFormat(cementspeksi));
					$('#cementsteksi').html(setFormat(cementsteksi));
					$('#totalsmieksi').html(setFormat(clinkersmieksi+cementsmieksi));
					$('#totalspeksi').html(setFormat(clinkerspeksi+cementspeksi));
					$('#totalsteksi').html(setFormat(clinkersteksi+cementsteksi));
					
					
					$('#clinkersmieksr').html(setFormat(clinkersmieksr / 1000000000));
					$('#clinkerspeksr').html(setFormat(clinkerspeksr / 1000000000));
					$('#clinkersteksr').html(setFormat(clinkersteksr / 1000000000));
					$('#cementsmieksr').html(setFormat(cementsmieksr / 1000000000));
					$('#cementspeksr').html(setFormat(cementspeksr / 1000000000));
					$('#cementsteksr').html(setFormat(cementsteksr / 1000000000));
					$('#totalsmieksr').html(setFormat((clinkersmieksr+cementsmieksr) / 1000000000));
					$('#totalspeksr').html(setFormat((clinkerspeksr+cementspeksr) / 1000000000));
					$('#totalsteksr').html(setFormat((clinkersteksr+cementsteksr) / 1000000000));
					
					$('#clinkersmieksir').html(setFormat(clinkersmieksir / 1000000000));
					$('#clinkerspeksir').html(setFormat(clinkerspeksir / 1000000000));
					$('#clinkersteksir').html(setFormat(clinkersteksir / 1000000000));
					$('#cementsmieksir').html(setFormat(cementsmieksir / 1000000000));
					$('#cementspeksir').html(setFormat(cementspeksir / 1000000000));
					$('#cementsteksir').html(setFormat(cementsteksir / 1000000000));
					$('#totalsmieksir').html(setFormat((clinkersmieksir+cementsmieksir) / 1000000000));
					$('#totalspeksir').html(setFormat((clinkerspeksir+cementspeksir) / 1000000000));
					$('#totalsteksir').html(setFormat((clinkersteksir+cementsteksir) / 1000000000));
				}
				
				
				$('#clinkersmir').html(setFormat(clinkersmir / 1000000000));
				$('#clinkerspr').html(setFormat(clinkerspr / 1000000000));
				$('#clinkerstr').html(setFormat(clinkerstr / 1000000000));
				$('#cementsmir').html(setFormat(cementsmir / 1000000000));
				$('#cementspr').html(setFormat(cementspr / 1000000000));
				$('#cementstr').html(setFormat(cementstr / 1000000000));
				$('#totalsmir').html(setFormat((clinkersmir+cementsmir) / 1000000000));
				$('#totalspr').html(setFormat((clinkerspr+cementspr) / 1000000000));
				$('#totalstr').html(setFormat((clinkerstr+cementstr) / 1000000000));
				
			}
			stop_waitMe('.wrapper');
	});
}
function plotPlant(opco, type, dataJson){
	var tableVal = dataJson['0']['s'+opco][0];
	if(type=='chart'){
		var actThisMonth, actThisMonthr;
		if(selectcat=="Clinker"){
			actThisMonth = tableVal[selectareas].act_bulan_ini.terak;
		}else{
			actThisMonth = tableVal[selectareas].act_bulan_ini.cement;
		}
		datas['actual'].push(actThisMonth);
		// datas['rkap'].push(actRkapThisMonth);
	}else{
		totaldomcem += tableVal.Domestic.act_bulan_ini.cement;
		totaldomcli += tableVal.Domestic.act_bulan_ini.terak;
		totalekscem += tableVal.Export.act_bulan_ini.cement;
		totalekscli += tableVal.Export.act_bulan_ini.terak;
		
		prcnclinker = ((totaldomcli - 0) / totaldomcli) * 100;
		if (prcnclinker > 50) {
			$('#icon_achievement_dcli').addClass('fa-sort-asc');
			$('#icon_achievement_dcli').attr('style', 'color: #7be668');
		} else {
			$('#icon_achievement_dcli').addClass('fa-sort-desc');
			$('#icon_achievement_dcli').attr('style', 'color: #EB1717');
		}
		
		prcncement = ((totaldomcem - 0) / totaldomcem) * 100;
		if (prcncement > 50) {
			$('#icon_achievement_dcem').addClass('fa-sort-asc');
			$('#icon_achievement_dcem').attr('style', 'color: #7be668');
		} else {
			$('#icon_achievement_dcem').addClass('fa-sort-desc');
			$('#icon_achievement_dcem').attr('style', 'color: #EB1717');
		}
		
		prcncementeks = ((totalekscem - 0) / totalekscem) * 100;
		if (prcncementeks > 50) {
			$('#icon_achievement_ecem').addClass('fa-sort-asc');
			$('#icon_achievement_ecem').attr('style', 'color: #7be668');
		} else {
			$('#icon_achievement_ecem').addClass('fa-sort-desc');
			$('#icon_achievement_ecem').attr('style', 'color: #EB1717');
		}
			
		prcnclinkereks = ((totalekscli - 0) / totalekscli) * 100;
		if (prcnclinkereks > 50) {
			$('#icon_achievement_ecli').addClass('fa-sort-asc');
			$('#icon_achievement_ecli').attr('style', 'color: #7be668');
		} else {
			$('#icon_achievement_ecli').addClass('fa-sort-desc');
			$('#icon_achievement_ecli').attr('style', 'color: #EB1717');
		}	
		if(opco=='smi'){
			cementsmi = tableVal.Domestic.act_bulan_ini.cement;
			clinkersmi = tableVal.Domestic.act_bulan_ini.terak;
			cementsmieks = tableVal.Export.act_bulan_ini.cement;
			clinkersmieks = tableVal.Export.act_bulan_ini.terak;
		}else if(opco=='smii'){
			cementsmieksi = tableVal.Export.act_bulan_ini.cement;
			clinkersmieksi = tableVal.Export.act_bulan_ini.terak;
		}else if(opco=='3000'){
			cementsp = tableVal.Domestic.act_bulan_ini.cement;
			clinkersp = tableVal.Domestic.act_bulan_ini.terak;
			cementspeks = tableVal.Export.act_bulan_ini.cement;
			clinkerspeks = tableVal.Export.act_bulan_ini.terak;
		}else if(opco=='3000i'){
			cementspeksi = tableVal.Export.act_bulan_ini.cement;
			clinkerspeksi = tableVal.Export.act_bulan_ini.terak;
		}else if(opco=='4000'){
			cementst = tableVal.Domestic.act_bulan_ini.cement;
			clinkerst = tableVal.Domestic.act_bulan_ini.terak;
			cementsteks = tableVal.Export.act_bulan_ini.cement;
			clinkersteks = tableVal.Export.act_bulan_ini.terak;
		}else if(opco=='4000i'){
			cementsteksi = tableVal.Export.act_bulan_ini.cement;
			clinkersteksi = tableVal.Export.act_bulan_ini.terak;
		}
	}
}

function plotPlantr(opco, type, dataJson){
	var tableVal = dataJson['0']['s'+opco][0];
	// console.log(opco);
	if(type=='chart'){
		var actThisMonth, actThisMonthr;
		if(selectcat=="Clinker"){
			actThisMonth = tableVal[selectareas].act_bulan_ini.terak;
		}else{
			actThisMonth = tableVal[selectareas].act_bulan_ini.cement;
		}
		datas['actual'].push(actThisMonth);
		// datas['rkap'].push(actRkapThisMonth);
	}else{
		totaldomcemr += tableVal.Domestic.act_bulan_ini.cement;
		totaldomclir += tableVal.Domestic.act_bulan_ini.terak;
		totalekscemr += tableVal.Export.act_bulan_ini.cement;
		totaleksclir += tableVal.Export.act_bulan_ini.terak;
		
		
		prcnclinkerr = ((totaldomclir - 0) / totaldomclir) * 100;
		if (prcnclinkerr > 50) {
			$('#icon_achievement_dclir').addClass('fa-sort-asc');
			$('#icon_achievement_dclir').attr('style', 'color: #7be668');
		} else {
			$('#icon_achievement_dclir').addClass('fa-sort-desc');
			$('#icon_achievement_dclir').attr('style', 'color: #EB1717');
		}
		
		prcncementr = ((totaldomcemr - 0) / totaldomcemr) * 100;
		if (prcncementr > 50) {
			$('#icon_achievement_dcemr').addClass('fa-sort-asc');
			$('#icon_achievement_dcemr').attr('style', 'color: #7be668');
		} else {
			$('#icon_achievement_dcemr').addClass('fa-sort-desc');
			$('#icon_achievement_dcemr').attr('style', 'color: #EB1717');
		}
		
		prcncementeksr = ((totalekscemr - 0) / totalekscemr) * 100;
		if (prcncementeksr > 50) {
			$('#icon_achievement_ecemr').addClass('fa-sort-asc');
			$('#icon_achievement_ecemr').attr('style', 'color: #7be668');
		} else {
			$('#icon_achievement_ecemr').addClass('fa-sort-desc');
			$('#icon_achievement_ecemr').attr('style', 'color: #EB1717');
		}
			
		prcnclinkereksr = ((totaleksclir - 0) / totaleksclir) * 100;
		if (prcnclinkereksr > 50) {
			$('#icon_achievement_eclir').addClass('fa-sort-asc');
			$('#icon_achievement_eclir').attr('style', 'color: #7be668');
		} else {
			$('#icon_achievement_eclir').addClass('fa-sort-desc');
			$('#icon_achievement_eclir').attr('style', 'color: #EB1717');
		}
					
		if(opco=='smi'){
			cementsmir = tableVal.Domestic.act_bulan_ini.cement;
			clinkersmir = tableVal.Domestic.act_bulan_ini.terak;
			cementsmieksr = tableVal.Export.act_bulan_ini.cement;
			clinkersmieksr = tableVal.Export.act_bulan_ini.terak;
		}else if(opco=='smii'){
			cementsmieksir = tableVal.Export.act_bulan_ini.cement;
			clinkersmieksir = tableVal.Export.act_bulan_ini.terak;
		}else if(opco=='3000'){
			cementspr = tableVal.Domestic.act_bulan_ini.cement;
			clinkerspr = tableVal.Domestic.act_bulan_ini.terak;
			cementspeksr = tableVal.Export.act_bulan_ini.cement;
			clinkerspeksr = tableVal.Export.act_bulan_ini.terak;
		}else if(opco=='3000i'){
			cementspeksir = tableVal.Export.act_bulan_ini.cement;
			clinkerspeksir = tableVal.Export.act_bulan_ini.terak;
		}else if(opco=='4000'){
			cementstr = tableVal.Domestic.act_bulan_ini.cement;
			clinkerstr = tableVal.Domestic.act_bulan_ini.terak;
			cementsteksr = tableVal.Export.act_bulan_ini.cement;
			clinkersteksr = tableVal.Export.act_bulan_ini.terak;
		}else if(opco=='4000i'){
			cementsteksir = tableVal.Export.act_bulan_ini.cement;
			clinkersteksir = tableVal.Export.act_bulan_ini.terak;
		}
	}
}

// function back_(){
	// if (getParam('opco')==7000) {
		// window.location.href = 'fin_cost_str_sg.html';
	// }else if (getParam('opco')==3000) {
		// window.location.href = 'fin_cost_str_sp.html';
	// }else if (getParam('opco')==4000) {
		// window.location.href = 'fin_cost_str_st.html';
	// }else if (getParam('opco')==6000) {
		// window.location.href = 'fin_cost_str_tl.html';
	// }
// }

