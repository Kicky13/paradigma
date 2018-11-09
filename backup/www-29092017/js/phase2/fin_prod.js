function numberWithCommas(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

var tmp="";
function viewAll(dataStRkap, dataStReal, urlStRkapMBefore, urlStRealMBefore, urlStRkapYBefore, urlStRealYBefore){
	var percenRkapUp = (parseInt(dataStReal[0].up_month['1'].ACTUAL_PRODUK)/parseInt(dataStRkap[0].up_month['1'].RKAP))*100;
	var percenRkapUpBefore = (parseInt(dataStReal[0].up_month['1'].ACTUAL_PRODUK)/parseInt(urlStRealYBefore[0].up_month['1'].ACTUAL_PRODUK))*100;
	
	$('#up_rkap').html(numberWithCommas(dataStRkap[0].up_month['1'].RKAP));
	$('#up_rkap_percent').html(percenRkapUp.toFixed(2)+'%');
	$('#up_rkap_before').html(numberWithCommas(urlStRealYBefore[0].up_month['1'].ACTUAL_PRODUK));
	$('#up_rkap_percent_before').html(percenRkapUpBefore.toFixed(2)+'%');
	$('#up_real').html(numberWithCommas(dataStReal[0].up_month['1'].ACTUAL_PRODUK));
	$('#up_operation_day').html(dataStReal[0].up_month['1'].HARI_OPERASI);
	
	var percenRkap_2 = (parseInt(urlStRealMBefore[0].up_month2['1'].ACTUAL_PRODUK)/parseInt(urlStRkapMBefore[0].up_month2['1'].RKAP))*100;
	var percenRkap_2Before = (parseInt(dataStReal[0].up_month2['1'].ACTUAL_PRODUK)/parseInt(urlStRealYBefore[0].up_month2['1'].ACTUAL_PRODUK))*100;
	
	$('#rkap_2').html(numberWithCommas(dataStRkap[0].up_month2['1'].RKAP));
	$('#rkap_percent_2').html(percenRkap_2.toFixed(2)+'%');
	$('#rkap_2_before').html(numberWithCommas(urlStRealYBefore[0].up_month2['1'].ACTUAL_PRODUK));
	$('#rkap_percent_2_before').html(percenRkap_2Before.toFixed(2)+'%');
	$('#real_2').html(numberWithCommas(dataStReal[0].up_month2['1'].ACTUAL_PRODUK));
	$('#operation_day_2').html(dataStReal[0].up_month2['1'].HARI_OPERASI);
	
}

function viewPlant(urlStRkapPlant, urlStRealPlant, urlStRkapPlantMBefore, urlStRealPlantMBefore, urlStRkapPlantYBefore, urlStRealPlantYBefore){
	
	$('#up_real1 strong').html(numberWithCommas(urlStRealPlant[0].up_month['1']['4301'].ACTUAL_PRODUK));
	$('#up_real2 strong').html(numberWithCommas(urlStRealPlant[0].up_month['1']['4302'].ACTUAL_PRODUK));
	$('#up_real3 strong').html(numberWithCommas(urlStRealPlant[0].up_month['1']['4303'].ACTUAL_PRODUK));
	var total_up_real =  parseInt(urlStRealPlant[0].up_month['1']['4301'].ACTUAL_PRODUK)+parseInt(urlStRealPlant[0].up_month['1']['4302'].ACTUAL_PRODUK)+parseInt(urlStRealPlant[0].up_month['1']['4303'].ACTUAL_PRODUK);
	$('#total_up_real strong').html(numberWithCommas(total_up_real));
	
	$('#up_rkap1 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['1']['4301'].RKAP));
	$('#up_rkap2 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['1']['4302'].RKAP));
	$('#up_rkap3 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['1']['4303'].RKAP));
	var total_up_rkap = parseInt(urlStRkapPlant[0].up_month['1']['4301'].RKAP)+parseInt(urlStRkapPlant[0].up_month['1']['4302'].RKAP)+parseInt(urlStRkapPlant[0].up_month['1']['4303'].RKAP);
	$('#total_up_rkap strong').html(numberWithCommas(total_up_rkap));
	
	$('#up_prognosa1 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['1']['4301'].PROGONOSE_PRODUK));
	$('#up_prognosa2 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['1']['4302'].PROGONOSE_PRODUK));
	$('#up_prognosa3 strong').html(numberWithCommas(urlStRkapPlant[0].up_month['1']['4303'].PROGONOSE_PRODUK));
	var total_up_prognosa = parseInt(urlStRkapPlant[0].up_month['1']['4301'].PROGONOSE_PRODUK)+parseInt(urlStRkapPlant[0].up_month['1']['4302'].PROGONOSE_PRODUK)+parseInt(urlStRkapPlant[0].up_month['1']['4303'].PROGONOSE_PRODUK);
	$('#total_up_prognosa strong').html(numberWithCommas(total_up_prognosa));
	
	var up_percenRkap1 = (parseInt(urlStRkapPlant[0].up_month['1']['4301'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month['1']['4301'].RKAP))*100;
	var up_percenRkap2 = (parseInt(urlStRkapPlant[0].up_month['1']['4302'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month['1']['4302'].RKAP))*100;
	var up_percenRkap3 = (parseInt(urlStRkapPlant[0].up_month['1']['4303'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month['1']['4303'].RKAP))*100;
	
	$('#up_percent_rkap1 strong').html(up_percenRkap1.toFixed(2)+'%');
	$('#up_percent_rkap2 strong').html(up_percenRkap2.toFixed(2)+'%');
	$('#up_percent_rkap3 strong').html(up_percenRkap3.toFixed(2)+'%');
	$('#total_up_percent_rkap strong').html(((total_up_prognosa/total_up_rkap)*100).toFixed(2)+'%');
	
	var up_percenProg1 = (parseInt(urlStRealPlant[0].up_month['1']['4301'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['1']['4301'].PROGONOSE_PRODUK))*100;
	var up_percenProg2 = (parseInt(urlStRealPlant[0].up_month['1']['4302'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['1']['4302'].PROGONOSE_PRODUK))*100;
	var up_percenProg3 = (parseInt(urlStRealPlant[0].up_month['1']['4303'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['1']['4303'].PROGONOSE_PRODUK))*100;
	
	$('#up_percent_prognosa1 strong').html(up_percenProg1.toFixed(2)+'%');
	$('#up_percent_prognosa2 strong').html(up_percenProg3.toFixed(2)+'%');
	$('#up_percent_prognosa3 strong').html(up_percenProg2.toFixed(2)+'%');
	
	$('#up_hari_oprasi1 strong').html(urlStRealPlant[0].up_month['1']['4301'].HARI_OPERASI);
	$('#up_hari_oprasi2 strong').html(urlStRealPlant[0].up_month['1']['4302'].HARI_OPERASI);
	$('#up_hari_oprasi3 strong').html(urlStRealPlant[0].up_month['1']['4303'].HARI_OPERASI);
	
	var sisa_prognosa1 = parseInt(urlStRkapPlant[0].up_month['1']['4301'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month['1']['4301'].ACTUAL_PRODUK);
	var sisa_prognosa2 = parseInt(urlStRkapPlant[0].up_month['1']['4302'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month['1']['4302'].ACTUAL_PRODUK);
	var sisa_prognosa3 = parseInt(urlStRkapPlant[0].up_month['1']['4303'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month['1']['4303'].ACTUAL_PRODUK);
	var total_sisa_prognosa = total_up_prognosa-total_up_real;
	
	$('#sisa_prognosa1 strong').html(numberWithCommas(sisa_prognosa1));
	$('#sisa_prognosa2 strong').html(numberWithCommas(sisa_prognosa2));
	$('#sisa_prognosa3 strong').html(numberWithCommas(sisa_prognosa3));
	$('#total_sisa_prognosa strong').html(numberWithCommas(total_sisa_prognosa));
	
	$('#sisa_oprasi1 strong').html(urlStRkapPlant[0].up_month['1']['4301'].SISA_HARI);
	$('#sisa_oprasi2 strong').html(urlStRkapPlant[0].up_month['1']['4302'].SISA_HARI);
	$('#sisa_oprasi3 strong').html(urlStRkapPlant[0].up_month['1']['4303'].SISA_HARI);
	
	var kapasitas_sisa1 = sisa_prognosa1/parseInt(urlStRkapPlant[0].up_month['1']['4301'].SISA_HARI);
	var kapasitas_sisa2 = sisa_prognosa2/parseInt(urlStRkapPlant[0].up_month['1']['4302'].SISA_HARI);
	var kapasitas_sisa3 = sisa_prognosa3/parseInt(urlStRkapPlant[0].up_month['1']['4303'].SISA_HARI);
	var total_kapasitas_sisa = kapasitas_sisa1+kapasitas_sisa2+kapasitas_sisa3;
	
	$('#total_sisa_oprasi strong').html(numberWithCommas(total_sisa_prognosa/total_kapasitas_sisa));
	
	$('#kapasitas_sisa1 strong').html(numberWithCommas(kapasitas_sisa1));
	$('#kapasitas_sisa2 strong').html(numberWithCommas(kapasitas_sisa2));
	$('#kapasitas_sisa3 strong').html(numberWithCommas(kapasitas_sisa3));
	$('#total_kapasitas_sisa strong').html(numberWithCommas(total_kapasitas_sisa));
	
	var kapasitas_real1 = parseInt(urlStRealPlant[0].up_month['1']['4301'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month['1']['4301'].HARI_OPERASI);
	var kapasitas_real2 = parseInt(urlStRealPlant[0].up_month['1']['4302'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month['1']['4302'].HARI_OPERASI);
	var kapasitas_real3 = parseInt(urlStRealPlant[0].up_month['1']['4303'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month['1']['4303'].HARI_OPERASI);
	var total_kapasitas_real = kapasitas_real1+kapasitas_real2+kapasitas_real3;
	
	$('#total_up_hari_oprasi strong').html((total_up_real/total_kapasitas_real).toFixed(0));
	
	$('#kapasitas_real1 strong').html(numberWithCommas(kapasitas_real1));
	$('#kapasitas_real2 strong').html(numberWithCommas(kapasitas_real2));
	$('#kapasitas_real3 strong').html(numberWithCommas(kapasitas_real3));
	$('#total_kapasitas_real strong').html(numberWithCommas(total_kapasitas_real));
	
	$('#up_real_month1 strong').html(numberWithCommas(urlStRealPlant[0].up_month2['1']['4301'].ACTUAL_PRODUK));
	$('#up_real_month2 strong').html(numberWithCommas(urlStRealPlant[0].up_month2['1']['4302'].ACTUAL_PRODUK));
	$('#up_real_month3 strong').html(numberWithCommas(urlStRealPlant[0].up_month2['1']['4303'].ACTUAL_PRODUK));
	var total_up_real_month =  parseInt(urlStRealPlant[0].up_month2['1']['4301'].ACTUAL_PRODUK)+parseInt(urlStRealPlant[0].up_month2['1']['4302'].ACTUAL_PRODUK)+parseInt(urlStRealPlant[0].up_month2['1']['4303'].ACTUAL_PRODUK);
	$('#total_up_real_month strong').html(numberWithCommas(total_up_real_month));
	
	$('#up_rkap_month1 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['1']['4301'].RKAP));
	$('#up_rkap_month2 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['1']['4302'].RKAP));
	$('#up_rkap_month3 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['1']['4303'].RKAP));
	var total_up_rkap_month = parseInt(urlStRkapPlant[0].up_month2['1']['4301'].RKAP)+parseInt(urlStRkapPlant[0].up_month2['1']['4302'].RKAP)+parseInt(urlStRkapPlant[0].up_month2['1']['4303'].RKAP);
	$('#total_up_rkap_month strong').html(numberWithCommas(total_up_rkap_month));
	
	$('#up_prognosa_month1 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['1']['4301'].PROGONOSE_PRODUK));
	$('#up_prognosa_month2 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['1']['4302'].PROGONOSE_PRODUK));
	$('#up_prognosa_month3 strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['1']['4303'].PROGONOSE_PRODUK));
	var total_up_prognosa_month = parseInt(urlStRkapPlant[0].up_month2['1']['4301'].PROGONOSE_PRODUK)+parseInt(urlStRkapPlant[0].up_month2['1']['4302'].PROGONOSE_PRODUK)+parseInt(urlStRkapPlant[0].up_month2['1']['4303'].PROGONOSE_PRODUK);
	$('#total_up_prognosa_month strong').html(numberWithCommas(total_up_prognosa_month));
	
	var up_percenRkap_month1 = (parseInt(urlStRkapPlant[0].up_month2['1']['4301'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['1']['4301'].RKAP))*100;
	var up_percenRkap_month2 = (parseInt(urlStRkapPlant[0].up_month2['1']['4302'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['1']['4302'].RKAP))*100;
	var up_percenRkap_month3 = (parseInt(urlStRkapPlant[0].up_month2['1']['4303'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['1']['4303'].RKAP))*100;
	
	$('#up_percent_rkap_month1 strong').html(up_percenRkap_month1.toFixed(2)+'%');
	$('#up_percent_rkap_month2 strong').html(up_percenRkap_month2.toFixed(2)+'%');
	$('#up_percent_rkap_month3 strong').html(up_percenRkap_month3.toFixed(2)+'%');
	$('#total_up_percent_rkap_month strong').html(((total_up_prognosa_month/total_up_rkap_month)*100).toFixed(2)+'%');
	
	var up_percenProg_month1 = (parseInt(urlStRealPlant[0].up_month2['1']['4301'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['1']['4301'].PROGONOSE_PRODUK))*100;
	var up_percenProg_month2 = (parseInt(urlStRealPlant[0].up_month2['1']['4302'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['1']['4302'].PROGONOSE_PRODUK))*100;
	var up_percenProg_month3 = (parseInt(urlStRealPlant[0].up_month2['1']['4303'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['1']['4303'].PROGONOSE_PRODUK))*100;
	
	$('#up_percent_prognosa_month1 strong').html(up_percenProg_month1.toFixed(2)+'%');
	$('#up_percent_prognosa_month2 strong').html(up_percenProg_month3.toFixed(2)+'%');
	$('#up_percent_prognosa_month3 strong').html(up_percenProg_month2.toFixed(2)+'%');
	
	$('#up_hari_oprasi_month1 strong').html(urlStRealPlant[0].up_month2['1']['4301'].HARI_OPERASI);
	$('#up_hari_oprasi_month2 strong').html(urlStRealPlant[0].up_month2['1']['4302'].HARI_OPERASI);
	$('#up_hari_oprasi_month3 strong').html(urlStRealPlant[0].up_month2['1']['4303'].HARI_OPERASI);
	
	var sisa_prognosa_month1 = parseInt(urlStRkapPlant[0].up_month2['1']['4301'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month2['1']['4301'].ACTUAL_PRODUK);
	var sisa_prognosa_month2 = parseInt(urlStRkapPlant[0].up_month2['1']['4302'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month2['1']['4302'].ACTUAL_PRODUK);
	var sisa_prognosa_month3 = parseInt(urlStRkapPlant[0].up_month2['1']['4303'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month2['1']['4303'].ACTUAL_PRODUK);
	var total_sisa_prognosa_month = total_up_prognosa_month-total_up_real_month;
	
	$('#sisa_prognosa_month1 strong').html(numberWithCommas(sisa_prognosa_month1));
	$('#sisa_prognosa_month2 strong').html(numberWithCommas(sisa_prognosa_month2));
	$('#sisa_prognosa_month3 strong').html(numberWithCommas(sisa_prognosa_month3));
	$('#total_sisa_prognosa_month strong').html(numberWithCommas(total_sisa_prognosa_month));
	
	$('#sisa_oprasi_month1 strong').html(urlStRkapPlant[0].up_month2['1']['4301'].SISA_HARI);
	$('#sisa_oprasi_month2 strong').html(urlStRkapPlant[0].up_month2['1']['4302'].SISA_HARI);
	$('#sisa_oprasi_month3 strong').html(urlStRkapPlant[0].up_month2['1']['4303'].SISA_HARI);
	
	var kapasitas_sisa_month1 = sisa_prognosa_month1/parseInt(urlStRkapPlant[0].up_month2['1']['4301'].SISA_HARI);
	var kapasitas_sisa_month2 = sisa_prognosa_month2/parseInt(urlStRkapPlant[0].up_month2['1']['4302'].SISA_HARI);
	var kapasitas_sisa_month3 = sisa_prognosa_month3/parseInt(urlStRkapPlant[0].up_month2['1']['4303'].SISA_HARI);
	var total_kapasitas_sisa_month = kapasitas_sisa_month1+kapasitas_sisa_month2+kapasitas_sisa_month3;
	
	$('#total_sisa_oprasi_month strong').html(numberWithCommas(total_sisa_prognosa_month/total_kapasitas_sisa_month));
	
	$('#kapasitas_sisa_month1 strong').html(numberWithCommas(kapasitas_sisa_month1));
	$('#kapasitas_sisa_month2 strong').html(numberWithCommas(kapasitas_sisa_month2));
	$('#kapasitas_sisa_month3 strong').html(numberWithCommas(kapasitas_sisa_month3));
	$('#total_kapasitas_sisa_month strong').html(numberWithCommas(total_kapasitas_sisa_month));
	
	var kapasitas_real_month1 = parseInt(urlStRealPlant[0].up_month2['1']['4301'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month2['1']['4301'].HARI_OPERASI);
	var kapasitas_real_month2 = parseInt(urlStRealPlant[0].up_month2['1']['4302'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month2['1']['4302'].HARI_OPERASI);
	var kapasitas_real_month3 = parseInt(urlStRealPlant[0].up_month2['1']['4303'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month2['1']['4303'].HARI_OPERASI);
	var total_kapasitas_real_month = kapasitas_real_month1+kapasitas_real_month2+kapasitas_real_month3;
	$('#total_up_hari_oprasi_month strong').html((total_up_real_month/total_kapasitas_real_month).toFixed(0));
	
	$('#kapasitas_real_month1 strong').html(numberWithCommas(kapasitas_real_month1));
	$('#kapasitas_real_month2 strong').html(numberWithCommas(kapasitas_real_month2));
	$('#kapasitas_real_month3 strong').html(numberWithCommas(kapasitas_real_month3));
	$('#total_kapasitas_real_month strong').html(numberWithCommas(total_kapasitas_real_month));
	
}

function viewAll_kiln(dataStRkap, dataStReal, urlStRkapMBefore, urlStRealMBefore, urlStRkapYBefore, urlStRealYBefore){
	var percenRkapUp = (parseInt(dataStReal[0].up_month['2'].ACTUAL_PRODUK)/parseInt(dataStRkap[0].up_month['2'].RKAP))*100;
	var percenRkapUpBefore = (parseInt(dataStReal[0].up_month['2'].ACTUAL_PRODUK)/parseInt(urlStRealYBefore[0].up_month['2'].ACTUAL_PRODUK))*100;
	
	$('#up_rkap_kiln').html(numberWithCommas(dataStRkap[0].up_month['2'].RKAP));
	$('#up_rkap_percent_kiln').html(percenRkapUp.toFixed(2)+'%');
	$('#up_rkap_kiln_before').html(numberWithCommas(urlStRealYBefore[0].up_month['2'].ACTUAL_PRODUK));
	$('#up_rkap_percent_kiln_before').html(percenRkapUpBefore.toFixed(2)+'%');
	$('#up_real_kiln').html(numberWithCommas(dataStReal[0].up_month['2'].ACTUAL_PRODUK));
	$('#up_operation_day_kiln').html(dataStReal[0].up_month['2'].HARI_OPERASI);
	
	var percenRkap_2 = (parseInt(urlStRealMBefore[0].up_month2['2'].ACTUAL_PRODUK)/parseInt(urlStRkapMBefore[0].up_month2['2'].RKAP))*100;
	var percenRkap_2_before = (parseInt(dataStReal[0].up_month2['2'].ACTUAL_PRODUK)/parseInt(urlStRealYBefore[0].up_month2['2'].ACTUAL_PRODUK))*100;
	
	$('#rkap_2_kiln').html(numberWithCommas(dataStRkap[0].up_month2['2'].RKAP));
	$('#rkap_percent_2_kiln').html(percenRkap_2.toFixed(2)+'%');
	$('#rkap_2_kiln_before').html(numberWithCommas(urlStRealYBefore[0].up_month2['2'].ACTUAL_PRODUK));
	$('#rkap_percent_2_kiln_before').html(percenRkap_2_before.toFixed(2)+'%');
	$('#real_2_kiln').html(numberWithCommas(dataStReal[0].up_month2['2'].ACTUAL_PRODUK));
	$('#operation_day_2_kiln').html(dataStReal[0].up_month2['2'].HARI_OPERASI);
	
}

function viewPlant_kiln(urlStRkapPlant, urlStRealPlant, urlStRkapPlantMBefore, urlStRealPlantMBefore, urlStRkapPlantYBefore, urlStRealPlantYBefore){
	
	$('#up_real1_kiln strong').html(numberWithCommas(urlStRealPlant[0].up_month['2']['4301'].ACTUAL_PRODUK));
	$('#up_real2_kiln strong').html(numberWithCommas(urlStRealPlant[0].up_month['2']['4302'].ACTUAL_PRODUK));
	$('#up_real3_kiln strong').html(numberWithCommas(urlStRealPlant[0].up_month['2']['4303'].ACTUAL_PRODUK));
	var total_up_real =  parseInt(urlStRealPlant[0].up_month['2']['4301'].ACTUAL_PRODUK)+parseInt(urlStRealPlant[0].up_month['2']['4302'].ACTUAL_PRODUK)+parseInt(urlStRealPlant[0].up_month['2']['4303'].ACTUAL_PRODUK);
	$('#total_up_real_kiln strong').html(numberWithCommas(total_up_real));
	
	$('#up_rkap1_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month['2']['4301'].RKAP));
	$('#up_rkap2_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month['2']['4302'].RKAP));
	$('#up_rkap3_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month['2']['4303'].RKAP));
	var total_up_rkap = parseInt(urlStRkapPlant[0].up_month['2']['4301'].RKAP)+parseInt(urlStRkapPlant[0].up_month['2']['4302'].RKAP)+parseInt(urlStRkapPlant[0].up_month['2']['4303'].RKAP);
	$('#total_up_rkap_kiln strong').html(numberWithCommas(total_up_rkap));
	
	$('#up_prognosa1_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month['2']['4301'].PROGONOSE_PRODUK));
	$('#up_prognosa2_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month['2']['4302'].PROGONOSE_PRODUK));
	$('#up_prognosa3_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month['2']['4303'].PROGONOSE_PRODUK));
	var total_up_prognosa = parseInt(urlStRkapPlant[0].up_month['2']['4301'].PROGONOSE_PRODUK)+parseInt(urlStRkapPlant[0].up_month['2']['4302'].PROGONOSE_PRODUK)+parseInt(urlStRkapPlant[0].up_month['2']['4303'].PROGONOSE_PRODUK);
	$('#total_up_prognosa_kiln strong').html(numberWithCommas(total_up_prognosa));
	
	var up_percenRkap1 = (parseInt(urlStRkapPlant[0].up_month['2']['4301'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month['2']['4301'].RKAP))*100;
	var up_percenRkap2 = (parseInt(urlStRkapPlant[0].up_month['2']['4302'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month['2']['4302'].RKAP))*100;
	var up_percenRkap3 = (parseInt(urlStRkapPlant[0].up_month['2']['4303'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month['2']['4303'].RKAP))*100;
	
	$('#up_percent_rkap1_kiln strong').html(up_percenRkap1.toFixed(2)+'%');
	$('#up_percent_rkap2_kiln strong').html(up_percenRkap2.toFixed(2)+'%');
	$('#up_percent_rkap3_kiln strong').html(up_percenRkap3.toFixed(2)+'%');
	$('#total_up_percent_rkap_kiln strong').html(((total_up_prognosa/total_up_rkap)*100).toFixed(2)+'%');
	
	var up_percenProg1 = (parseInt(urlStRealPlant[0].up_month['2']['4301'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['2']['4301'].PROGONOSE_PRODUK))*100;
	var up_percenProg2 = (parseInt(urlStRealPlant[0].up_month['2']['4302'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['2']['4302'].PROGONOSE_PRODUK))*100;
	var up_percenProg3 = (parseInt(urlStRealPlant[0].up_month['2']['4303'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month['2']['4303'].PROGONOSE_PRODUK))*100;
	
	$('#up_percent_prognosa1_kiln strong').html(up_percenProg1.toFixed(2)+'%');
	$('#up_percent_prognosa2_kiln strong').html(up_percenProg3.toFixed(2)+'%');
	$('#up_percent_prognosa3_kiln strong').html(up_percenProg2.toFixed(2)+'%');
	
	$('#up_hari_oprasi1_kiln strong').html(urlStRealPlant[0].up_month['2']['4301'].HARI_OPERASI);
	$('#up_hari_oprasi2_kiln strong').html(urlStRealPlant[0].up_month['2']['4302'].HARI_OPERASI);
	$('#up_hari_oprasi3_kiln strong').html(urlStRealPlant[0].up_month['2']['4303'].HARI_OPERASI);
	
	var sisa_prognosa1 = parseInt(urlStRkapPlant[0].up_month['2']['4301'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month['2']['4301'].ACTUAL_PRODUK);
	var sisa_prognosa2 = parseInt(urlStRkapPlant[0].up_month['2']['4302'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month['2']['4302'].ACTUAL_PRODUK);
	var sisa_prognosa3 = parseInt(urlStRkapPlant[0].up_month['2']['4303'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month['2']['4303'].ACTUAL_PRODUK);
	var total_sisa_prognosa = total_up_prognosa-total_up_real;
	
	$('#sisa_prognosa1_kiln strong').html(numberWithCommas(sisa_prognosa1));
	$('#sisa_prognosa2_kiln strong').html(numberWithCommas(sisa_prognosa2));
	$('#sisa_prognosa3_kiln strong').html(numberWithCommas(sisa_prognosa3));
	$('#total_sisa_prognosa_kiln strong').html(numberWithCommas(total_sisa_prognosa));
	
	$('#sisa_oprasi1_kiln strong').html(urlStRkapPlant[0].up_month['2']['4301'].SISA_HARI);
	$('#sisa_oprasi2_kiln strong').html(urlStRkapPlant[0].up_month['2']['4302'].SISA_HARI);
	$('#sisa_oprasi3_kiln strong').html(urlStRkapPlant[0].up_month['2']['4303'].SISA_HARI);
	
	var kapasitas_sisa1 = sisa_prognosa1/parseInt(urlStRkapPlant[0].up_month['2']['4301'].SISA_HARI);
	var kapasitas_sisa2 = sisa_prognosa2/parseInt(urlStRkapPlant[0].up_month['2']['4302'].SISA_HARI);
	var kapasitas_sisa3 = sisa_prognosa3/parseInt(urlStRkapPlant[0].up_month['2']['4303'].SISA_HARI);
	var total_kapasitas_sisa = kapasitas_sisa1+kapasitas_sisa2+kapasitas_sisa3;
	
	$('#total_sisa_oprasi_kiln strong').html(numberWithCommas(total_sisa_prognosa/total_kapasitas_sisa));
	
	$('#kapasitas_sisa1_kiln strong').html(numberWithCommas(kapasitas_sisa1));
	$('#kapasitas_sisa2_kiln strong').html(numberWithCommas(kapasitas_sisa2));
	$('#kapasitas_sisa3_kiln strong').html(numberWithCommas(kapasitas_sisa3));
	$('#total_kapasitas_sisa_kiln strong').html(numberWithCommas(total_kapasitas_sisa));
	
	var kapasitas_real1 = parseInt(urlStRealPlant[0].up_month['2']['4301'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month['2']['4301'].HARI_OPERASI);
	var kapasitas_real2 = parseInt(urlStRealPlant[0].up_month['2']['4302'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month['2']['4302'].HARI_OPERASI);
	var kapasitas_real3 = parseInt(urlStRealPlant[0].up_month['2']['4303'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month['2']['4303'].HARI_OPERASI);
	var total_kapasitas_real = kapasitas_real1+kapasitas_real2+kapasitas_real3;
	
	$('#total_up_hari_oprasi_kiln strong').html((total_up_real/total_kapasitas_real).toFixed(0));
	
	$('#kapasitas_real1_kiln strong').html(numberWithCommas(kapasitas_real1));
	$('#kapasitas_real2_kiln strong').html(numberWithCommas(kapasitas_real2));
	$('#kapasitas_real3_kiln strong').html(numberWithCommas(kapasitas_real3));
	$('#total_kapasitas_real_kiln strong').html(numberWithCommas(total_kapasitas_real));
	
	$('#up_real_month1_kiln strong').html(numberWithCommas(urlStRealPlant[0].up_month2['2']['4301'].ACTUAL_PRODUK));
	$('#up_real_month2_kiln strong').html(numberWithCommas(urlStRealPlant[0].up_month2['2']['4302'].ACTUAL_PRODUK));
	$('#up_real_month3_kiln strong').html(numberWithCommas(urlStRealPlant[0].up_month2['2']['4303'].ACTUAL_PRODUK));
	var total_up_real_month =  parseInt(urlStRealPlant[0].up_month2['2']['4301'].ACTUAL_PRODUK)+parseInt(urlStRealPlant[0].up_month2['2']['4302'].ACTUAL_PRODUK)+parseInt(urlStRealPlant[0].up_month2['2']['4303'].ACTUAL_PRODUK);
	$('#total_up_real_month_kiln strong').html(numberWithCommas(total_up_real_month));
	
	$('#up_rkap_month1_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['2']['4301'].RKAP));
	$('#up_rkap_month2_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['2']['4302'].RKAP));
	$('#up_rkap_month3_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['2']['4303'].RKAP));
	var total_up_rkap_month = parseInt(urlStRkapPlant[0].up_month2['2']['4301'].RKAP)+parseInt(urlStRkapPlant[0].up_month2['2']['4302'].RKAP)+parseInt(urlStRkapPlant[0].up_month2['2']['4303'].RKAP);
	$('#total_up_rkap_month_kiln strong').html(numberWithCommas(total_up_rkap_month));
	
	$('#up_prognosa_month1_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['2']['4301'].PROGONOSE_PRODUK));
	$('#up_prognosa_month2_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['2']['4302'].PROGONOSE_PRODUK));
	$('#up_prognosa_month3_kiln strong').html(numberWithCommas(urlStRkapPlant[0].up_month2['2']['4303'].PROGONOSE_PRODUK));
	var total_up_prognosa_month = parseInt(urlStRkapPlant[0].up_month2['2']['4301'].PROGONOSE_PRODUK)+parseInt(urlStRkapPlant[0].up_month2['2']['4302'].PROGONOSE_PRODUK)+parseInt(urlStRkapPlant[0].up_month2['2']['4303'].PROGONOSE_PRODUK);
	$('#total_up_prognosa_month_kiln strong').html(numberWithCommas(total_up_prognosa_month));
	
	var up_percenRkap_month1 = (parseInt(urlStRkapPlant[0].up_month2['2']['4301'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['2']['4301'].RKAP))*100;
	var up_percenRkap_month2 = (parseInt(urlStRkapPlant[0].up_month2['2']['4302'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['2']['4302'].RKAP))*100;
	var up_percenRkap_month3 = (parseInt(urlStRkapPlant[0].up_month2['2']['4303'].PROGONOSE_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['2']['4303'].RKAP))*100;
	
	$('#up_percent_rkap_month1_kiln strong').html(up_percenRkap_month1.toFixed(2)+'%');
	$('#up_percent_rkap_month2_kiln strong').html(up_percenRkap_month2.toFixed(2)+'%');
	$('#up_percent_rkap_month3_kiln strong').html(up_percenRkap_month3.toFixed(2)+'%');
	$('#total_up_percent_rkap_month_kiln strong').html(((total_up_prognosa_month/total_up_rkap_month)*100).toFixed(2)+'%');
	
	var up_percenProg_month1 = (parseInt(urlStRealPlant[0].up_month2['2']['4301'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['2']['4301'].PROGONOSE_PRODUK))*100;
	var up_percenProg_month2 = (parseInt(urlStRealPlant[0].up_month2['2']['4302'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['2']['4302'].PROGONOSE_PRODUK))*100;
	var up_percenProg_month3 = (parseInt(urlStRealPlant[0].up_month2['2']['4303'].ACTUAL_PRODUK)/parseInt(urlStRkapPlant[0].up_month2['2']['4303'].PROGONOSE_PRODUK))*100;
	
	$('#up_percent_prognosa_month1_kiln strong').html(up_percenProg_month1.toFixed(2)+'%');
	$('#up_percent_prognosa_month2_kiln strong').html(up_percenProg_month3.toFixed(2)+'%');
	$('#up_percent_prognosa_month3_kiln strong').html(up_percenProg_month2.toFixed(2)+'%');
	
	$('#up_hari_oprasi_month1_kiln strong').html(urlStRealPlant[0].up_month2['2']['4301'].HARI_OPERASI);
	$('#up_hari_oprasi_month2_kiln strong').html(urlStRealPlant[0].up_month2['2']['4302'].HARI_OPERASI);
	$('#up_hari_oprasi_month3_kiln strong').html(urlStRealPlant[0].up_month2['2']['4303'].HARI_OPERASI);
	
	var sisa_prognosa_month1 = parseInt(urlStRkapPlant[0].up_month2['2']['4301'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month2['2']['4301'].ACTUAL_PRODUK);
	var sisa_prognosa_month2 = parseInt(urlStRkapPlant[0].up_month2['2']['4302'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month2['2']['4302'].ACTUAL_PRODUK);
	var sisa_prognosa_month3 = parseInt(urlStRkapPlant[0].up_month2['2']['4303'].PROGONOSE_PRODUK)-parseInt(urlStRealPlant[0].up_month2['2']['4303'].ACTUAL_PRODUK);
	var total_sisa_prognosa_month = total_up_prognosa_month-total_up_real_month;
	
	$('#sisa_prognosa_month1_kiln strong').html(numberWithCommas(sisa_prognosa_month1));
	$('#sisa_prognosa_month2_kiln strong').html(numberWithCommas(sisa_prognosa_month2));
	$('#sisa_prognosa_month3_kiln strong').html(numberWithCommas(sisa_prognosa_month3));
	$('#total_sisa_prognosa_month_kiln strong').html(numberWithCommas(total_sisa_prognosa_month));
	
	$('#sisa_oprasi_month1_kiln strong').html(urlStRkapPlant[0].up_month2['2']['4301'].SISA_HARI);
	$('#sisa_oprasi_month2_kiln strong').html(urlStRkapPlant[0].up_month2['2']['4302'].SISA_HARI);
	$('#sisa_oprasi_month3_kiln strong').html(urlStRkapPlant[0].up_month2['2']['4303'].SISA_HARI);
	
	var kapasitas_sisa_month1 = sisa_prognosa_month1/parseInt(urlStRkapPlant[0].up_month2['2']['4301'].SISA_HARI);
	var kapasitas_sisa_month2 = sisa_prognosa_month2/parseInt(urlStRkapPlant[0].up_month2['2']['4302'].SISA_HARI);
	var kapasitas_sisa_month3 = sisa_prognosa_month3/parseInt(urlStRkapPlant[0].up_month2['2']['4303'].SISA_HARI);
	var total_kapasitas_sisa_month = kapasitas_sisa_month1+kapasitas_sisa_month2+kapasitas_sisa_month3;
	
	$('#total_sisa_oprasi_month_kiln strong').html(numberWithCommas(total_sisa_prognosa_month/total_kapasitas_sisa_month));
	
	$('#kapasitas_sisa_month1_kiln strong').html(numberWithCommas(kapasitas_sisa_month1));
	$('#kapasitas_sisa_month2_kiln strong').html(numberWithCommas(kapasitas_sisa_month2));
	$('#kapasitas_sisa_month3_kiln strong').html(numberWithCommas(kapasitas_sisa_month3));
	$('#total_kapasitas_sisa_month_kiln strong').html(numberWithCommas(total_kapasitas_sisa_month));
	
	var kapasitas_real_month1 = parseInt(urlStRealPlant[0].up_month2['2']['4301'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month2['2']['4301'].HARI_OPERASI);
	var kapasitas_real_month2 = parseInt(urlStRealPlant[0].up_month2['2']['4302'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month2['2']['4302'].HARI_OPERASI);
	var kapasitas_real_month3 = parseInt(urlStRealPlant[0].up_month2['2']['4303'].ACTUAL_PRODUK)/parseInt(urlStRealPlant[0].up_month2['1']['4303'].HARI_OPERASI);
	var total_kapasitas_real_month = kapasitas_real_month1+kapasitas_real_month2+kapasitas_real_month3;
	$('#total_up_hari_oprasi_month_kiln strong').html((total_up_real_month/total_kapasitas_real_month).toFixed(0));
	
	$('#kapasitas_real_month1_kiln strong').html(numberWithCommas(kapasitas_real_month1));
	$('#kapasitas_real_month2_kiln strong').html(numberWithCommas(kapasitas_real_month2));
	$('#kapasitas_real_month3_kiln strong').html(numberWithCommas(kapasitas_real_month3));
	$('#total_kapasitas_real_month_kiln strong').html(numberWithCommas(total_kapasitas_real_month));
	
}

var labelArrayDay = [];
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
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
	
	var monthBefore = selmonth-1;
	if(monthBefore<=9){
		monthBefore = '0'+monthBefore
	}
	
	var yearBefore = selyear-1;
    run_waitMe('.wrapper', 'ios');
	
	var urlStRkap =  url_ol+'/api/index.php/rkap_produksi_st?bulan='+selmonth+'&tahun='+selyear+'&plant='+plant;
	var urlStReal =  url_ol+'/api/index.php/real_produksi_st?bulan='+selmonth+'&tahun='+selyear+'&plant='+plant;
	
	var urlStRkapMBefore =  url_ol+'/api/index.php/rkap_produksi_st?bulan='+monthBefore+'&tahun='+selyear+'&plant='+plant;
	var urlStRealMBefore =  url_ol+'/api/index.php/real_produksi_st?bulan='+monthBefore+'&tahun='+selyear+'&plant='+plant;
	var urlStRkapYBefore =  url_ol+'/api/index.php/rkap_produksi_st?bulan='+selmonth+'&tahun='+yearBefore+'&plant='+plant;
	var urlStRealYBefore =  url_ol+'/api/index.php/real_produksi_st?bulan='+selmonth+'&tahun='+yearBefore+'&plant='+plant;
	
	var urlStRkapPlant =  url_ol+'/api/index.php/rkap_produksi_st/rkap_plant?bulan='+selmonth+'&tahun='+selyear;
	var urlStRealPlant =  url_ol+'/api/index.php/real_produksi_st/real_plant?bulan='+selmonth+'&tahun='+selyear;
	
	var urlStRkapPlantMBefore =  url_ol+'/api/index.php/rkap_produksi_st/rkap_plant?bulan='+monthBefore+'&tahun='+selyear;
	var urlStRealPlantMBefore =  url_ol+'/api/index.php/real_produksi_st/real_plant?bulan='+monthBefore+'&tahun='+selyear;
	var urlStRkapPlantYBefore =  url_ol+'/api/index.php/rkap_produksi_st/rkap_plant?bulan='+selmonth+'&tahun='+yearBefore;
	var urlStRealPlantYBefore =  url_ol+'/api/index.php/real_produksi_st/real_plant?bulan='+selmonth+'&tahun='+yearBefore;
	
	stop_waitMe('.wrapper');
	
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
			viewAll_kiln(dataStRkap, dataStReal, urlStRkapMBefore, urlStRealMBefore, urlStRkapYBefore, urlStRealYBefore);
			viewPlant_kiln(urlStRkapPlant, urlStRealPlant, urlStRkapPlantMBefore, urlStRealPlantMBefore, urlStRkapPlantYBefore, urlStRealPlantYBefore);
			// stop_waitMe('.wrapper');
		}).fail(function(jqXHR, textStatus, errorThrown) {
			console.log('getJSON request failed! ' + textStatus);
		});
}

function showChart(bln, thn){
	
	$.ajax({
		url: url_src+'/api/index.php/real_produksi_st/detail?bulan='+bln+'&tahun='+thn,
		type: 'GET',
		success: function (data) {
			var dataJson = JSON.parse(data);
			var prognose = [];
			var real = [];
			var rkap = [];
			var hari = [];
			
			var prognose2 = [];
			var real2 = [];
			var rkap2 = [];
			var hari2 = [];
			
			for (var x=0;x<dataJson['1'].length;x++) {
				prognose.push(parseFloat(dataJson['1'][x].PROGONOSE_PRODUK));
				rkap.push(parseFloat(dataJson['1'][x].RKAP));
				hari.push(parseFloat(dataJson['1'][x].HARI_OPERASI));
				real.push(parseFloat(dataJson['1'][x].ACTUAL_PRODUK));
			}
			// console.log(rkap);
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
					// tickmarkPlacement: 'on',
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
							return '<b>'+t+'<br>'+s+' '+setFormat(n,0)+' Ton <br> '+hari[this.point.x]+' (Hari Opr)</b>';
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
				//stacking: 'normal'
						},{
		  name: 'Realisasi',
							color: '#22A7F0',
							data: real,
		  pointPadding: 0.25,
					pointPlacement: 0
				//stacking: 'normal'
						},{
				type: 'spline',
							name: 'RKAP',
							color: '#D91E18',
							data: rkap,
						}]
				});
				
			for (var x=0;x<dataJson['2'].length;x++) {
				prognose2.push(parseFloat(dataJson['2'][x].PROGONOSE_PRODUK));
				rkap2.push(parseFloat(dataJson['2'][x].RKAP));
				hari2.push(parseFloat(dataJson['2'][x].HARI_OPERASI));
				real2.push(parseFloat(dataJson['2'][x].ACTUAL_PRODUK));
			}
			$('#terak_stock_kiln').highcharts({
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
					// tickmarkPlacement: 'on',
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
							return '<b>'+t+'<br>'+s+' '+setFormat(n,0)+' Ton <br> '+hari2[this.point.x]+' (Hari Opr)</b>';
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
						data: prognose2,
		  pointPadding: 0.05,
					pointPlacement: 0
				//stacking: 'normal'
						},{
		  name: 'Realisasi',
							color: '#22A7F0',
							data: real2,
		  pointPadding: 0.25,
					pointPlacement: 0
				//stacking: 'normal'
						},{
				type: 'spline',
							name: 'RKAP',
							color: '#D91E18',
							data: rkap2,
						}]
				});
		}
	})
}

var labelArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
function showChartMonthly(bln, thn){
	$.ajax({
		url: url_src+'/api/index.php/rkap_produksi_st/chart_month?bulan='+bln+'&tahun='+thn,
		type: 'GET',
		success: function (dataStRkap) {
			var index = [];
			var prognose = [];
			var real = [];
			var rkap = [];
			var hari = [];
			var prognose2 = [];
			var real2 = [];
			var rkap2 = [];
			var data = JSON.parse(dataStRkap);
			var hari2 = [];
			for(var i=1;i<=bln;i++){
				prognose.push(parseFloat(data.rkap['1'][i].PROGONOSE_PRODUK));
				rkap.push(parseFloat(data.rkap['1'][i].RKAP));
				hari.push(parseFloat(data.rkap['1'][i].HARI_OPERASI));
				real.push(parseFloat(data.real['1'][i].REAL));
			}
			// console.log(hari);
			
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
			categories: labelArray,
			tickInterval: 1,
			// tickmarkPlacement: 'on',
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
					
					return '<b>'+t+'<br>'+s+' '+setFormat(n,0)+' Ton <br> '+hari[this.point.x]+' (Hari Opr)</b>';
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
		// stacking: 'normal'
				},{
  name: 'Realisasi',
					color: '#22A7F0',
					data: real,
  pointPadding: 0.25,
			pointPlacement: 0
		// stacking: 'normal'
				},{
		type: 'spline',
					name: 'RKAP',
					color: '#D91E18',
					data: rkap,
				}]
		});
	
		
			for(var i=1;i<=bln;i++){
				prognose2.push(parseFloat(data.rkap['2'][i].PROGONOSE_PRODUK));
				rkap2.push(parseFloat(data.rkap['2'][i].RKAP));
				hari2.push(parseFloat(data.rkap['2'][i].HARI_OPERASI));
				real2.push(parseFloat(data.real['2'][i].REAL));
			}
			$('#terak_stock_kiln').highcharts({
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
					categories: labelArray,
					tickInterval: 1,
					// tickmarkPlacement: 'on',
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
							return '<b>'+t+'<br>'+s+' '+setFormat(n,0)+' Ton <br> '+hari2[this.point.x]+' (Hari Opr)</b>';
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
						data: prognose2,
		  pointPadding: 0.05,
					pointPlacement: 0
				//stacking: 'normal'
						},{
		  name: 'Realisasi',
							color: '#22A7F0',
							data: real2,
		  pointPadding: 0.25,
					pointPlacement: 0
				//stacking: 'normal'
						},{
				type: 'spline',
							name: 'RKAP',
							color: '#D91E18',
							data: rkap2
						}]
				});
	
		}
	});
	
}

function chartss(prognose, rkap, real){
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
			// tickmarkPlacement: 'on',
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
					return '<b>'+t+'<br>'+s+'<br>'+setFormat(n,0)+' Ton</b>';
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
		//stacking: 'normal'
				},{
  name: 'Realisasi',
					color: '#22A7F0',
					data: real,
  pointPadding: 0.25,
			pointPlacement: 0
		//stacking: 'normal'
				},{
		type: 'spline',
					name: 'RKAP',
					color: '#D91E18',
					data: rkap,
				}]
		});
}

