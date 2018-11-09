function daysInMonth(month, year) {
	return new Date(year, month, 0).getDate();
}
function showdate(){
		var daysInSelectedMonth = daysInMonth($('.selmonth').val(), $('.selyear').val());

		for (var i = 1; i <= daysInSelectedMonth; i++) {
			if(i<=9){
				i='0'+i
			}
			$('.selday').append($("<option></option>").attr("value", i).text(i));
		}

}
function numberWithCommas(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function formatNew(val) {
	return val.replace('.',',');
}
var tmp="";
function viewAll(dataStRkap, dataStReal, urlStRkapMBefore, urlStRealMBefore, urlStRkapYBefore, urlStRealYBefore){
	var percenProg = (parseInt(dataStReal[0].month.ACTUAL_PRODUK)/parseInt(dataStRkap[0].month.PROGONOSE_PRODUK))*100;
	var percenRkap = (parseInt(dataStReal[0].month.ACTUAL_PRODUK)/parseInt(dataStRkap[0].month.RKAP))*100;
	var percenProgUp = (parseInt(dataStReal[0].up_month.ACTUAL_PRODUK)/parseInt(dataStRkap[0].up_month.PROGONOSE_PRODUK))*100;
	var percenRkapUp = (parseInt(dataStReal[0].up_month.ACTUAL_PRODUK)/parseInt(dataStRkap[0].up_month.RKAP))*100;
	var percenProg2 = (parseInt(urlStRealMBefore[0].month.ACTUAL_PRODUK)/parseInt(urlStRkapMBefore[0].month.PROGONOSE_PRODUK))*100;
	var percenRkap2 = (parseInt(urlStRealMBefore[0].month.ACTUAL_PRODUK)/parseInt(urlStRkapMBefore[0].month.RKAP))*100;
	var percenProgUp2 = (parseInt(urlStRealYBefore[0].up_month.ACTUAL_PRODUK)/parseInt(urlStRkapYBefore[0].up_month.PROGONOSE_PRODUK))*100;
	var percenRkapUp2 = (parseInt(urlStRealYBefore[0].up_month.ACTUAL_PRODUK)/parseInt(urlStRkapYBefore[0].up_month.RKAP))*100;
	
	var percenProg_2 = (parseInt(urlStRealMBefore[0].up_month2.ACTUAL_PRODUK)/parseInt(urlStRkapMBefore[0].up_month2.PROGONOSE_PRODUK))*100;
	var percenRkap_2 = (parseInt(urlStRealMBefore[0].up_month2.ACTUAL_PRODUK)/parseInt(urlStRkapMBefore[0].up_month2.RKAP))*100;
	var percenProgUp_2 = (parseInt(urlStRealYBefore[0].up_month2.ACTUAL_PRODUK)/parseInt(urlStRkapYBefore[0].up_month2.PROGONOSE_PRODUK))*100;
	var percenRkapUp_2 = (parseInt(urlStRealYBefore[0].up_month2.ACTUAL_PRODUK)/parseInt(urlStRkapYBefore[0].up_month2.RKAP))*100;
	
	$('#prognosa').html(numberWithCommas(dataStRkap[0].month.PROGONOSE_PRODUK));
	$('#prognosa_percent').html(percenProg+'%');
	$('#rkap').html(numberWithCommas(dataStRkap[0].month.RKAP));
	$('#rkap_percent').html(percenRkap.toFixed(2)+'%');
	$('#real').html(numberWithCommas(dataStReal[0].month.ACTUAL_PRODUK));
	$('#operation_day').html(dataStReal[0].month.HARI_OPERASI);
	
	$('#up_prognosa').html(numberWithCommas(dataStRkap[0].up_month.PROGONOSE_PRODUK));
	$('#up_prognosa_percent').html(percenProgUp+'%');
	$('#up_rkap').html(numberWithCommas(dataStRkap[0].up_month.RKAP));
	$('#up_rkap_percent').html(percenRkapUp.toFixed(2)+'%');
	$('#up_real').html(numberWithCommas(dataStReal[0].up_month.ACTUAL_PRODUK));
	$('#up_operation_day').html(dataStReal[0].up_month.HARI_OPERASI);
	
	$('#prognosa2').html(numberWithCommas(urlStRkapMBefore[0].month.PROGONOSE_PRODUK));
	$('#prognosa_percent2').html(percenProg2+'%');
	$('#rkap2').html(numberWithCommas(urlStRkapMBefore[0].month.RKAP));
	$('#rkap_percent2').html(percenRkap2.toFixed(2)+'%');
	$('#real2').html(numberWithCommas(urlStRealMBefore[0].month.ACTUAL_PRODUK));
	$('#operation_day2').html(urlStRealMBefore[0].month.HARI_OPERASI);
	$('#up_prognosa2').html(numberWithCommas(urlStRkapYBefore[0].up_month.PROGONOSE_PRODUK));
	$('#up_prognosa_percent2').html(percenProgUp2+'%');
	$('#up_rkap2').html(numberWithCommas(urlStRkapYBefore[0].up_month.RKAP));
	$('#up_rkap_percent2').html(percenRkapUp2.toFixed(2)+'%');
	$('#up_real2').html(numberWithCommas(urlStRealYBefore[0].up_month.ACTUAL_PRODUK));
	$('#up_operation_day2').html(urlStRealYBefore[0].up_month.HARI_OPERASI);
	
	$('#prognosa_2').html(numberWithCommas(dataStRkap[0].up_month2.PROGONOSE_PRODUK));
	$('#prognosa_percent_2').html(percenProg_2.toFixed(2)+'%');
	$('#rkap_2').html(numberWithCommas(dataStRkap[0].up_month2.RKAP));
	$('#rkap_percent_2').html(percenRkap_2.toFixed(2)+'%');
	$('#real_2').html(numberWithCommas(dataStReal[0].up_month2.ACTUAL_PRODUK));
	$('#operation_day_2').html(dataStReal[0].up_month2.HARI_OPERASI);
	
	$('#up_prognosa_2').html(numberWithCommas(urlStRkapYBefore[0].up_month2.PROGONOSE_PRODUK));
	$('#up_prognosa_percent_2').html(percenProgUp_2.toFixed(2)+'%');
	$('#up_rkap_2').html(numberWithCommas(urlStRkapYBefore[0].up_month2.RKAP));
	$('#up_rkap_percent_2').html(percenRkapUp_2.toFixed(2)+'%');
	$('#up_real_2').html(numberWithCommas(urlStRealYBefore[0].up_month2.ACTUAL_PRODUK));
	$('#up_operation_day_2').html(urlStRealYBefore[0].up_month2.HARI_OPERASI);
}

function viewPlant(urlStRkapPlant, urlStRealPlant, urlStRkapPlantMBefore, urlStRealPlantMBefore, urlStRkapPlantYBefore, urlStRealPlantYBefore){
	$('#real1 strong').html(numberWithCommas(urlStRealPlant[0].month['4301'].ACTUAL_PRODUK));
	$('#real2 strong').html(numberWithCommas(urlStRealPlant[0].month['4302'].ACTUAL_PRODUK));
	$('#real3 strong').html(numberWithCommas(urlStRealPlant[0].month['4303'].ACTUAL_PRODUK));
	
	$('#rkap1 strong').html(numberWithCommas(urlStRkapPlant[0].month['4301'].RKAP));
	$('#rkap2 strong').html(numberWithCommas(urlStRkapPlant[0].month['4302'].RKAP));
	$('#rkap3 strong').html(numberWithCommas(urlStRkapPlant[0].month['4303'].RKAP));
	
	$('#prognosa1 strong').html(numberWithCommas(urlStRkapPlant[0].month['4301'].PROGONOSE_PRODUK));
	$('#prognosa2 strong').html(numberWithCommas(urlStRkapPlant[0].month['4302'].PROGONOSE_PRODUK));
	$('#prognosa3 strong').html(numberWithCommas(urlStRkapPlant[0].month['4303'].PROGONOSE_PRODUK));
	
	var percenRkap1 = (parseInt(urlStRealPlant[0].month['4301'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].month['4301'].RKAP))*100;
	var percenRkap2 = (parseInt(urlStRealPlant[0].month['4302'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].month['4302'].RKAP))*100;
	var percenRkap3 = (parseInt(urlStRealPlant[0].month['4303'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].month['4303'].RKAP))*100;
	
	$('#percent_rkap1 strong').html(percenRkap1.toFixed(2)+'%');
	$('#percent_rkap2 strong').html(percenRkap2.toFixed(2)+'%');
	$('#percent_rkap3 strong').html(percenRkap3.toFixed(2)+'%');
	
	var percenProg1 = (parseInt(urlStRealPlant[0].month['4301'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].month['4301'].PROGONOSE_PRODUK))*100;
	var percenProg2 = (parseInt(urlStRealPlant[0].month['4302'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].month['4302'].PROGONOSE_PRODUK))*100;
	var percenProg3 = (parseInt(urlStRealPlant[0].month['4303'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].month['4303'].PROGONOSE_PRODUK))*100;
	
	$('#percent_prognosa1 strong').html(percenProg1.toFixed(2)+'%');
	$('#percent_prognosa2 strong').html(percenProg3.toFixed(2)+'%');
	$('#percent_prognosa3 strong').html(percenProg2.toFixed(2)+'%');
	
	$('#hari_oprasi1 strong').html(urlStRealPlant[0].month['4301'].HARI_OPERASI);
	$('#hari_oprasi2 strong').html(urlStRealPlant[0].month['4302'].HARI_OPERASI);
	$('#hari_oprasi3 strong').html(urlStRealPlant[0].month['4303'].HARI_OPERASI);
	
	$('#up_real1 strong').html(numberWithCommas(urlStRealPlant[0].up_month['4301'].ACTUAL_PRODUK));
	$('#up_real2 strong').html(numberWithCommas(urlStRealPlant[0].up_month['4302'].ACTUAL_PRODUK));
	$('#up_real3 strong').html(numberWithCommas(urlStRealPlant[0].up_month['4303'].ACTUAL_PRODUK));
	
	$('#up_rkap1 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['4301'].RKAP));
	$('#up_rkap2 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['4302'].RKAP));
	$('#up_rkap3 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['4303'].RKAP));
	
	$('#up_prognosa1 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['4301'].PROGONOSE_PRODUK));
	$('#up_prognosa2 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['4302'].PROGONOSE_PRODUK));
	$('#up_prognosa3 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['4303'].PROGONOSE_PRODUK));
	
	var up_percenRkap1 = (parseInt(urlStRealPlant[0].up_month['4301'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['4301'].RKAP))*100;
	var up_percenRkap2 = (parseInt(urlStRealPlant[0].up_month['4302'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['4302'].RKAP))*100;
	var up_percenRkap3 = (parseInt(urlStRealPlant[0].up_month['4303'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['4303'].RKAP))*100;
	
	$('#up_percent_rkap1 strong').html(up_percenRkap1.toFixed(2)+'%');
	$('#up_percent_rkap2 strong').html(up_percenRkap2.toFixed(2)+'%');
	$('#up_percent_rkap3 strong').html(up_percenRkap3.toFixed(2)+'%');
	
	var up_percenProg1 = (parseInt(urlStRealPlant[0].up_month['4301'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['4301'].PROGONOSE_PRODUK))*100;
	var up_percenProg2 = (parseInt(urlStRealPlant[0].up_month['4302'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['4302'].PROGONOSE_PRODUK))*100;
	var up_percenProg3 = (parseInt(urlStRealPlant[0].up_month['4303'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['4303'].PROGONOSE_PRODUK))*100;
	
	$('#up_percent_prognosa1 strong').html(up_percenProg1.toFixed(2)+'%');
	$('#up_percent_prognosa2 strong').html(up_percenProg3.toFixed(2)+'%');
	$('#up_percent_prognosa3 strong').html(up_percenProg2.toFixed(2)+'%');
	
	$('#up_hari_oprasi1 strong').html(urlStRealPlant[0].up_month['4301'].HARI_OPERASI);
	$('#up_hari_oprasi2 strong').html(urlStRealPlant[0].up_month['4302'].HARI_OPERASI);
	$('#up_hari_oprasi3 strong').html(urlStRealPlant[0].up_month['4303'].HARI_OPERASI);
	
	
	
	
	$('#up_real_month1 strong').html(numberWithCommas(urlStRealPlant[0].up_month2['4301'].ACTUAL_PRODUK));
	$('#up_real_month2 strong').html(numberWithCommas(urlStRealPlant[0].up_month2['4302'].ACTUAL_PRODUK));
	$('#up_real_month3 strong').html(numberWithCommas(urlStRealPlant[0].up_month2['4303'].ACTUAL_PRODUK));
	
	$('#up_rkap_month1 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['4301'].RKAP));
	$('#up_rkap_month2 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['4302'].RKAP));
	$('#up_rkap_month3 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['4303'].RKAP));
	
	$('#up_prognosa_month1 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['4301'].PROGONOSE_PRODUK));
	$('#up_prognosa_month2 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['4302'].PROGONOSE_PRODUK));
	$('#up_prognosa_month3 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['4303'].PROGONOSE_PRODUK));
	
	var up_percenRkap_month1 = (parseInt(urlStRealPlant[0].up_month2['4301'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['4301'].RKAP))*100;
	var up_percenRkap_month2 = (parseInt(urlStRealPlant[0].up_month2['4302'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['4302'].RKAP))*100;
	var up_percenRkap_month3 = (parseInt(urlStRealPlant[0].up_month2['4303'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['4303'].RKAP))*100;
	
	$('#up_percent_rkap_month1 strong').html(up_percenRkap_month1.toFixed(2)+'%');
	$('#up_percent_rkap_month2 strong').html(up_percenRkap_month2.toFixed(2)+'%');
	$('#up_percent_rkap_month3 strong').html(up_percenRkap_month3.toFixed(2)+'%');
	
	var up_percenProg_month1 = (parseInt(urlStRealPlant[0].up_month2['4301'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['4301'].PROGONOSE_PRODUK))*100;
	var up_percenProg_month2 = (parseInt(urlStRealPlant[0].up_month2['4302'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['4302'].PROGONOSE_PRODUK))*100;
	var up_percenProg_month3 = (parseInt(urlStRealPlant[0].up_month2['4303'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['4303'].PROGONOSE_PRODUK))*100;
	
	$('#up_percent_prognosa1 strong').html(up_percenProg_month1.toFixed(2)+'%');
	$('#up_percent_prognosa2 strong').html(up_percenProg_month2.toFixed(2)+'%');
	$('#up_percent_prognosa3 strong').html(up_percenProg_month3.toFixed(2)+'%');
	
	$('#up_hari_oprasi_month1 strong').html(urlStRealPlant[0].up_month2['4301'].HARI_OPERASI);
	$('#up_hari_oprasi_month2 strong').html(urlStRealPlant[0].up_month2['4302'].HARI_OPERASI);
	$('#up_hari_oprasi_month3 strong').html(urlStRealPlant[0].up_month2['4303'].HARI_OPERASI);
	
	
	
}

function numb(val){
	var toTon = val;
	return parseFloat(Math.round(toTon * 100) / 100).toFixed(2);
}

function opcoGroup (selday, selmonth, selyear, plant){
	var monthBefore = selmonth-1;
	if(monthBefore<=9){
		monthBefore = '0'+monthBefore
	}
	
	var yearBefore = selyear-1;
    run_waitMe('.wrapper', 'ios');
	var urlStRkap =  url_ol+'/api/index.php/rkap_produksi_st?hari='+selday+'&bulan='+selmonth+'&tahun='+selyear+'&plant='+plant;
	var urlStReal =  url_ol+'/api/index.php/real_produksi_st?hari='+selday+'&bulan='+selmonth+'&tahun='+selyear+'&plant='+plant;
	
	var urlStRkapMBefore =  url_ol+'/api/index.php/rkap_produksi_st?hari='+selday+'&bulan='+monthBefore+'&tahun='+selyear+'&plant='+plant;
	var urlStRealMBefore =  url_ol+'/api/index.php/real_produksi_st?hari='+selday+'&bulan='+monthBefore+'&tahun='+selyear+'&plant='+plant;
	var urlStRkapYBefore =  url_ol+'/api/index.php/rkap_produksi_st?hari='+selday+'&bulan='+selmonth+'&tahun='+yearBefore+'&plant='+plant;
	var urlStRealYBefore =  url_ol+'/api/index.php/real_produksi_st?hari='+selday+'&bulan='+selmonth+'&tahun='+yearBefore+'&plant='+plant;
	
	var urlStRkapPlant =  url_ol+'/api/index.php/rkap_produksi_st/rkap_plant?hari='+selday+'&bulan='+selmonth+'&tahun='+selyear;
	var urlStRealPlant =  url_ol+'/api/index.php/real_produksi_st/real_plant?hari='+selday+'&bulan='+selmonth+'&tahun='+selyear;
	
	var urlStRkapPlantMBefore =  url_ol+'/api/index.php/rkap_produksi_st/rkap_plant?hari='+selday+'&bulan='+monthBefore+'&tahun='+selyear;
	var urlStRealPlantMBefore =  url_ol+'/api/index.php/real_produksi_st/real_plant?hari='+selday+'&bulan='+monthBefore+'&tahun='+selyear;
	var urlStRkapPlantYBefore =  url_ol+'/api/index.php/rkap_produksi_st/rkap_plant?hari='+selday+'&bulan='+selmonth+'&tahun='+yearBefore;
	var urlStRealPlantYBefore =  url_ol+'/api/index.php/real_produksi_st/real_plant?hari='+selday+'&bulan='+selmonth+'&tahun='+yearBefore;
	
	$.when(
	    $.getJSON(urlStRkap),
	    $.getJSON(urlStReal),
	    $.getJSON(urlStRkapPlant),
	    $.getJSON(urlStRealPlant),
	    $.getJSON(urlStRkapMBefore),
	    $.getJSON(urlStRealMBefore),
	    $.getJSON(urlStRkapYBefore),
	    $.getJSON(urlStRealYBefore),
	    $.getJSON(urlStRkapPlantMBefore),
	    $.getJSON(urlStRealPlantMBefore),
	    $.getJSON(urlStRkapPlantYBefore),
	    $.getJSON(urlStRealPlantYBefore)
	    ).done(function(dataStRkap, dataStReal, urlStRkapPlant, urlStRealPlant, urlStRkapMBefore, urlStRealMBefore, urlStRkapYBefore, urlStRealYBefore, urlStRkapPlantMBefore, urlStRealPlantMBefore, urlStRkapPlantYBefore, urlStRealPlantYBefore){
			viewAll(dataStRkap, dataStReal, urlStRkapMBefore, urlStRealMBefore, urlStRkapYBefore, urlStRealYBefore);
			viewPlant(urlStRkapPlant, urlStRealPlant, urlStRkapPlantMBefore, urlStRealPlantMBefore, urlStRkapPlantYBefore, urlStRealPlantYBefore);
			stop_waitMe('.wrapper');
		});
}