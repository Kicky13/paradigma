function numberFormat(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

var tmp="";
function viewAll(dataSalesSt){
	var dataMonthReal = dataSalesSt['REAL'];
	var dataMonthRkap = dataSalesSt['RKAP'];
	var dataMonthReal_before = dataSalesSt['REAL PREV'];
	
	var percenRkapUp = (parseInt(dataMonthReal)/parseInt(dataMonthRkap))*100;
	var percenRealUp = (parseInt(dataMonthReal)/parseInt(dataMonthReal_before))*100;
	
	$('#up_rkap').html(numberFormat(dataMonthRkap));
	$('#up_real').html(numberFormat(dataMonthReal));
	$('#up_real_before').html(numberFormat(dataMonthReal_before));
	
	$('#up_rkap_percent').html(percenRkapUp.toFixed(2)+'%');
	$('#up_real_before_percent').html(percenRealUp.toFixed(2)+'%');
	
}

var labelArrayDay = [];
function showChart(dataSalesSt){

	var prognose = [];
	var real = [];
	var rkap = [];
	
	for (var x=0;x<dataSalesSt.length;x++) {
		prognose.push(parseFloat(dataSalesSt[x].PROGNOSA));
		rkap.push(parseFloat(dataSalesSt[x].RKAP));
		real.push(parseFloat(dataSalesSt[x].REAL));
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


function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}

function viewTable(rkap, prognosa, rkap_percent, real, sisa_prognosa, hari_operasi, sisa_hari_operasi, kapasitas_sisa_hari_operasi, kapasitas_real) {

	//RKAP WILAYAH
	var tmp_rkap_wil="";
	var total_rkap_wil=0;
	var rkap_wil = rkap['WILAYAH'];
	tmp_rkap_wil+='<td class="bold_op">RKAP</td>'
	for(var i=0; i<rkap_wil.length; i++){
		// total_rkap_wil += parseInt(rkap_wil[i]);
		total_rkap_wil=parseInt(parseInt(rkap_wil[3])+parseInt(rkap_wil[4])+parseInt(rkap_wil[5]));
		tmp_rkap_wil+='<td align="center" valign="middle"><strong>'+numberFormat(rkap_wil[i])+'</strong></td>'
	}
	tmp_rkap_wil+='<td align="center" valign="middle"><strong>'+numberFormat(total_rkap_wil)+'</strong></td>'
	$('#wil_rkap').html(tmp_rkap_wil);

	//PROGNOSA WILAYAH
	var tmp_prognosa_wil="";
	var total_prognosa_wil=0;
	var prognosa_wil = prognosa['WILAYAH'];
	tmp_prognosa_wil+='<td class="bold_op">PROGNOSA</td>'
	for(var i=0; i<prognosa_wil.length; i++){
		// total_prognosa_wil += parseInt(prognosa_wil[i]);
		total_prognosa_wil=parseInt(parseInt(prognosa_wil[3])+parseInt(prognosa_wil[4])+parseInt(prognosa_wil[5]));
		tmp_prognosa_wil+='<td align="center" valign="middle"><strong>'+numberFormat(prognosa_wil[i])+'</strong></td>'
	}
	tmp_prognosa_wil+='<td align="center" valign="middle"><strong>'+numberFormat(total_prognosa_wil)+'</strong></td>'
	$('#wil_prog').html(tmp_prognosa_wil);
	
	//%RKAP WILAYAH
	var tmp_rkap_percent_wil="";
	var total_rkap_percent_wil=(total_prognosa_wil/total_rkap_wil)*100;
	var rkap_percent_wil = rkap_percent['WILAYAH'];
	tmp_rkap_percent_wil+='<td class="bold_op">% RKAP</td>'
	for(var i=0; i<rkap_percent_wil.length; i++){
		tmp_rkap_percent_wil+='<td align="center"  valign="middle"><strong>'+((numberFormat(rkap_percent_wil[i]) < 100) ? '<span style="color:#e41a1c">'+numberFormat(rkap_percent_wil[i])+'%</span>' : '<span style="color:#4daf4a">'+numberFormat(rkap_percent_wil[i])+'%</span>')+'</strong></td>'
	}
	tmp_rkap_percent_wil+='<td align="center"  valign="middle"><strong>'+((numberFormat(total_rkap_percent_wil) < 100) ? '<span style="color:#e41a1c">'+numberFormat(total_rkap_percent_wil)+'%</span>' : '<span style="color:#4daf4a">'+numberFormat(total_rkap_percent_wil)+'%</span>')+'</strong></td>'
	$('#wil_rkap_percent').html(tmp_rkap_percent_wil);
	
	//REAL WILAYAH
	var tmp_real_wil="";
	var total_real_wil=0;
	var real_wil = real['WILAYAH'];
	tmp_real_wil+='<td class="bold_op">REAL UP TO</td>'
	for(var i=0; i<real_wil.length; i++){
		// total_real_wil += parseInt(real_wil[i]);
		total_real_wil=parseInt(parseInt(real_wil[3])+parseInt(real_wil[4])+parseInt(real_wil[5])+parseInt(real_wil[6]));
		tmp_real_wil+='<td align="center"  valign="middle"><strong>'+numberFormat(real_wil[i])+'</strong></td>'
	}
	// alert(total_real_wil);
	tmp_real_wil+='<td align="center" valign="middle"><strong>'+numberFormat(total_real_wil)+'</strong></td>'
	$('#wil_real').html(tmp_real_wil);

	//SISA PROGNOSA WILAYAH
	var tmp_sprog_wil="";
	var total_sprog_wil=total_prognosa_wil-total_real_wil;
	var sprog_wil = sisa_prognosa['WILAYAH'];
	tmp_sprog_wil+='<td class="bold_op">SISA PROGNOSA</td>'
	for(var i=0; i<sprog_wil.length; i++){
		tmp_sprog_wil+='<td align="center"  valign="middle"><strong>'+numberFormat(sprog_wil[i])+'</strong></td>'
	}
	tmp_sprog_wil+='<td align="center" valign="middle"><strong>'+numberFormat(total_sprog_wil)+'</strong></td>'
	$('#wil_sisa_prog').html(tmp_sprog_wil);

	//HARI OPERASI WILAYAH
	var tmp_hopr_wil="";
	var hopr_wil = hari_operasi['WILAYAH'];
	tmp_hopr_wil+='<td class="bold_op">HARI OPERASI</td>'
	for(var i=0; i<hopr_wil.length; i++){
		tmp_hopr_wil+='<td align="center"  valign="middle"><strong>'+numberFormat(hopr_wil[i])+'</strong></td>'
	}

	//SISA HARI OPERASI WILAYAH
	var tmp_shopr_wil="";
	var shopr_wil = sisa_hari_operasi['WILAYAH'];
	tmp_shopr_wil+='<td class="bold_op">SISA HARI OPERASI</td>'
	for(var i=0; i<shopr_wil.length; i++){
		tmp_shopr_wil+='<td align="center"  valign="middle"><strong>'+numberFormat(shopr_wil[i])+'</strong></td>'
	}

	//KAPASITAS SISA HARI WILAYAH
	var tmp_kshopr_wil="";
	var total_kshopr_wil=0;
	var kshopr_wil = kapasitas_sisa_hari_operasi['WILAYAH'];
	tmp_kshopr_wil+='<td class="bold_op">KAPASITAS SISA HARI</td>'
	for(var i=0; i<kshopr_wil.length; i++){
		total_kshopr_wil += parseInt(kshopr_wil[i]);
		tmp_kshopr_wil+='<td align="center"  valign="middle"><strong>'+numberFormat(kshopr_wil[i])+'</strong></td>'
	}
	tmp_kshopr_wil+='<td align="center" valign="middle"><strong>'+numberFormat(total_kshopr_wil)+'</strong></td>'
	$('#wil_kapasitas_sisa_hari').html(tmp_kshopr_wil);

	//KAPASITAS REAL WILAYAH
	var tmp_kreal_wil="";
	var total_kreal_wil=0;
	var kreal_wil = kapasitas_real['WILAYAH'];
	tmp_kreal_wil+='<td class="bold_op">KAPASITAS REAL</td>'
	for(var i=0; i<kreal_wil.length; i++){
		total_kreal_wil += parseInt(kreal_wil[i]);
		tmp_kreal_wil+='<td align="center"  valign="middle"><strong>'+numberFormat(kreal_wil[i])+'</strong></td>'
	}
	tmp_kreal_wil+='<td align="center" valign="middle"><strong>'+numberFormat(total_kreal_wil)+'</strong></td>'
	$('#wil_kapasitas_real').html(tmp_kreal_wil);

	//TOTAL HARI OPERASI WILAYAH
	var total_shopr_wil=total_real_wil/total_kreal_wil;
	tmp_hopr_wil+='<td align="center" valign="middle"><strong>'+numberFormat(total_shopr_wil)+'</strong></td>'
	$('#wil_hari_opr').html(tmp_hopr_wil);

	//TOTAL SISA HARI WILAYAH
	var total_hopr_wil=total_sprog_wil/total_kshopr_wil;
	tmp_shopr_wil+='<td align="center" valign="middle"><strong>'+numberFormat(total_hopr_wil)+'</strong></td>'
	$('#wil_sisa_hari_opr').html(tmp_shopr_wil);

	//RKAP KEMASAN
	var tmp_rkap_kmsn="";
	var total_rkap_kmsn=0;
	var rkap_kmsn = rkap['KEMASAN'];
	tmp_rkap_kmsn+='<td class="bold_op">RKAP</td>'
	for(var i=0; i<rkap_kmsn.length; i++){
		// total_rkap_kmsn += parseInt(rkap_kmsn[i]);
		total_rkap_kmsn=parseInt(parseInt(rkap_kmsn[0])+parseInt(rkap_kmsn[1]));
		tmp_rkap_kmsn+='<td align="center" valign="middle"><strong>'+numberFormat(rkap_kmsn[i])+'</strong></td>'
	}
	tmp_rkap_kmsn+='<td align="center" valign="middle"><strong>'+numberFormat(total_rkap_kmsn)+'</strong></td>'
	$('#kmsn_rkap').html(tmp_rkap_kmsn);

	//PROGNOSA KEMASAN
	var tmp_prognosa_kmsn="";
	var total_prognosa_kmsn=0;
	var prognosa_kmsn = prognosa['KEMASAN'];
	tmp_prognosa_kmsn+='<td class="bold_op">PROGNOSA</td>'
	for(var i=0; i<prognosa_kmsn.length; i++){
		// total_prognosa_kmsn += parseInt(prognosa_kmsn[i]);
		total_prognosa_kmsn=parseInt(parseInt(prognosa_kmsn[0])+parseInt(prognosa_kmsn[1]));
		tmp_prognosa_kmsn+='<td align="center" valign="middle"><strong>'+numberFormat(prognosa_kmsn[i])+'</strong></td>'
	}
	tmp_prognosa_kmsn+='<td align="center" valign="middle"><strong>'+numberFormat(total_prognosa_kmsn)+'</strong></td>'
	$('#kmsn_prog').html(tmp_prognosa_kmsn);

	//%RKAP KEMASAN
	var tmp_rkap_percent_kmsn="";
	var total_rkap_percent_kmsn=(total_prognosa_kmsn/total_rkap_kmsn)*100;
	var rkap_percent_kmsn = rkap_percent['KEMASAN'];
	tmp_rkap_percent_kmsn+='<td class="bold_op">% RKAP</td>'
	for(var i=0; i<rkap_percent_kmsn.length; i++){
		tmp_rkap_percent_kmsn+='<td align="center"  valign="middle"><strong>'+((numberFormat(rkap_percent_kmsn[i]) < 100) ? '<span style="color:#e41a1c">'+numberFormat(rkap_percent_kmsn[i])+'%</span>' : '<span style="color:#4daf4a">'+numberFormat(rkap_percent_kmsn[i])+'%</span>')+'</strong></td>'
	}
	tmp_rkap_percent_kmsn+='<td align="center"  valign="middle"><strong>'+((numberFormat(total_rkap_percent_kmsn) < 100) ? '<span style="color:#e41a1c">'+numberFormat(total_rkap_percent_kmsn)+'%</span>' : '<span style="color:#4daf4a">'+numberFormat(total_rkap_percent_kmsn)+'%</span>')+'</strong></td>'
	$('#kmsn_rkap_percent').html(tmp_rkap_percent_kmsn);

	//REAL KEMASAN
	var tmp_real_kmsn="";
	var total_real_kmsn=0;
	var real_kmsn = real['KEMASAN'];
	tmp_real_kmsn+='<td class="bold_op">REAL UP TO</td>'
	for(var i=0; i<real_kmsn.length-1; i++){
		total_real_kmsn += parseInt(real_kmsn[i]);
		tmp_real_kmsn+='<td align="center"  valign="middle"><strong>'+numberFormat(real_kmsn[i])+'</strong></td>'
	}
	tmp_real_kmsn+='<td align="center" valign="middle"><strong>'+numberFormat(total_real_kmsn)+'</strong></td>'
	$('#kmsn_real').html(tmp_real_kmsn);

	//SISA PROGNOSA KEMASAN
	var tmp_sprog_kmsn="";
	var total_sprog_kmsn=total_prognosa_kmsn-total_real_kmsn;
	var sprog_kmsn = sisa_prognosa['KEMASAN'];
	tmp_sprog_kmsn+='<td class="bold_op">SISA PROGNOSA</td>'
	for(var i=0; i<sprog_kmsn.length; i++){
		tmp_sprog_kmsn+='<td align="center"  valign="middle"><strong>'+numberFormat(sprog_kmsn[i])+'</strong></td>'
	}
	tmp_sprog_kmsn+='<td align="center" valign="middle"><strong>'+numberFormat(total_sprog_kmsn)+'</strong></td>'
	$('#kmsn_sisa_prog').html(tmp_sprog_kmsn);

	//HARI OPERASI KEMASAN
	var tmp_hopr_kmsn="";
	var hopr_kmsn = hari_operasi['KEMASAN'];
	tmp_hopr_kmsn+='<td class="bold_op">HARI OPERASI</td>'
	for(var i=0; i<hopr_kmsn.length; i++){
		tmp_hopr_kmsn+='<td align="center"  valign="middle"><strong>'+numberFormat(hopr_kmsn[i])+'</strong></td>'
	}
	$('#kmsn_hari_opr').html(tmp_hopr_kmsn);

	//SISA HARI OPERASI KEMASAN
	var tmp_shopr_kmsn="";
	var shopr_kmsn = sisa_hari_operasi['KEMASAN'];
	tmp_shopr_kmsn+='<td class="bold_op">SISA HARI OPERASI</td>'
	for(var i=0; i<shopr_kmsn.length; i++){
		tmp_shopr_kmsn+='<td align="center"  valign="middle"><strong>'+numberFormat(shopr_kmsn[i])+'</strong></td>'
	}
	$('#kmsn_sisa_hari_opr').html(tmp_shopr_kmsn);

	//KAPASITAS SISA HARI KEMASAN
	var tmp_kshopr_kmsn="";
	var total_kshopr_kmsn=0;
	var kshopr_kmsn = kapasitas_sisa_hari_operasi['KEMASAN'];
	tmp_kshopr_kmsn+='<td class="bold_op">KAPASITAS SISA HARI</td>'
	for(var i=0; i<kshopr_kmsn.length; i++){
		total_kshopr_kmsn += parseInt(kshopr_kmsn[i]);
		tmp_kshopr_kmsn+='<td align="center"  valign="middle"><strong>'+numberFormat(kshopr_kmsn[i])+'</strong></td>'
	}
	tmp_kshopr_kmsn+='<td align="center" valign="middle"><strong>'+numberFormat(total_kshopr_kmsn)+'</strong></td>'
	$('#kmsn_kapasitas_sisa_hari').html(tmp_kshopr_kmsn);

	//KAPASITAS REAL KEMASAN
	var tmp_kreal_kmsn="";
	var total_kreal_kmsn=0;
	var kreal_kmsn = kapasitas_real['KEMASAN'];
	tmp_kreal_kmsn+='<td class="bold_op">KAPASITAS REAL</td>'
	for(var i=0; i<kreal_kmsn.length; i++){
		total_kreal_kmsn += parseInt(kreal_kmsn[i]);
		tmp_kreal_kmsn+='<td align="center"  valign="middle"><strong>'+numberFormat(kreal_kmsn[i])+'</strong></td>'
	}
	tmp_kreal_kmsn+='<td align="center" valign="middle"><strong>'+numberFormat(total_kreal_kmsn)+'</strong></td>'
	$('#kmsn_kapasitas_real').html(tmp_kreal_kmsn);

	//TOTAL HARI OPERASI KEMASAN
	var total_hopr_kmsn=total_real_kmsn/total_kreal_kmsn;
	tmp_hopr_kmsn+='<td align="center" valign="middle"><strong>'+numberFormat(total_hopr_kmsn)+'</strong></td>'
	$('#kmsn_hari_opr').html(tmp_hopr_kmsn);

	//TOTAL SISA HARI KEMASAN
	var total_shopr_kmsn=total_sprog_kmsn/total_kshopr_kmsn;
	tmp_shopr_kmsn+='<td align="center" valign="middle"><strong>'+numberFormat(total_shopr_kmsn)+'</strong></td>'
	$('#kmsn_sisa_hari_opr').html(tmp_shopr_kmsn);


}

function opcoGroup (selday, selmonth, selyear, plant){
	
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
	
	var urlSalesSt = "http://par4digma.semenindonesia.com/api/index.php/sales_st?bulan="+selmonth+"&tahun="+selyear;
	// var urlSalesSt = "http://localhost/par4digma_live/api/index.php/sales_st?bulan="+selmonth+"&tahun="+selyear;
	
	$.getJSON(urlSalesSt, function(data){
		viewAll(data['TOTAL']);
		showChart(data['CHART']);
		viewTable(data['RKAP'],data['PROGNOSA'],data['PERCENT_RKAP'],data['REAL'],data['SISA_PROGNOSA'],data['HARI_OPERASI'],data['SISA_HARI_OPERASI'],data['KAPASITAS_SISA_HARI'],data['KAPASITAS_REAL']);
		stop_waitMe('.wrapper');
	});

	
}