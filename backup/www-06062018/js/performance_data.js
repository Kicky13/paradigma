$(function(){
	run_waitMe('.wrapper', 'ios');
	var url7000 = 'http://10.15.5.150/dev/api/index.php/f_performance/performance?company=7000';
	var url3000 = 'http://10.15.5.150/dev/api/index.php/f_performance/performance?company=3000';
	var url4000 = 'http://10.15.5.150/dev/api/index.php/f_performance/performance?company=4000';
	var url6000 = 'http://10.15.5.150/dev/api/index.php/f_performance/performance?company=6000';

	$.when(
		$.getJSON(url7000),
	    $.getJSON(url3000),
	    $.getJSON(url4000),
	    $.getJSON(url6000)
	).done(function(data7000, data3000, data4000, data6000){
		var data = {
			sg: data7000[0],
			sp: data3000[0],
			st: data4000[0],
			tl: data6000[0]
		};
		console.log(data6000);


		var total_volume = 0;
		var total_price = 0;
		var total_cost =0 ;
		var total_real_value = 0;
		var total_rkap_value = 0;
		var total_ebitda_value = 0;


		$.each(data, function(i, result){
			console.log(i+'-> '+result.real_cost);
			total_real_value += parseFloat(result.ebitdabulan_real);
			total_rkap_value += parseFloat(result.ebitdbulan_rkap);
			total_ebitda_value += parseFloat(result.ebitdbulanvarian);

			total_volume += parseFloat(result.real_vol);
			total_price += parseFloat(result.real_price);
			total_cost += parseFloat(result.real_biaya);
			$('#'+i+'_variance_vol').html(getformatedM(result.variance_vol));
			$('#'+i+'_target_vol').html(getformatedM(result.rkap_vol));
			$('#'+i+'_real_vol').html(getformatedM(result.real_vol));

			$('#'+i+'_variance_vol_up').html(getformatedM(result.variance_vol_prev_up));
			$('#'+i+'_target_vol_up').html(getformatedM(result.rkap_vol_prev_up));
			$('#'+i+'_real_vol_up').html(getformatedM(result.real_vol_prev_up));

			$('#'+i+'_variance_price').html(getformatedB(result.variance_price) );
			$('#'+i+'_target_price').html(getformatedB(result.rkap_price));
			$('#'+i+'_real_price').html(getformatedB(result.real_price));

			$('#'+i+'_variance_price_up').html(getformatedB(result.variance_price_prev_up));
			$('#'+i+'_target_price_up').html(getformatedB(result.rkap_price_prev_up));
			$('#'+i+'_real_price_up').html(getformatedB(result.real_price_prev_up));



			$('#'+i+'_variance_cost').html(getformatedB(result.variance_biaya));
			$('#'+i+'_target_cost').html(getformatedB(result.rkap_biaya));
			$('#'+i+'_real_cost').html(getformatedB(result.real_biaya));

			$('#'+i+'_variance_cost_up').html(getformatedB(result.variance_biaya_prev_up));
			$('#'+i+'_target_cost_up').html(getformatedB(result.rkap_biaya_prev_up));
			$('#'+i+'_real_cost_up').html(getformatedB(result.real_biaya_prev_up));
		});

		console.log(total_volume + '- '+ total_price+ '-'+total_cost);

		$('#real_value').html(setFormat(total_real_value,2));
	    $('#rkap_value').html(setFormat(total_rkap_value,2));
	    $('#ebitda_value').html(setFormat(total_ebitda_value,2));

		$('#smi_volume_real').html(getformatedB(total_volume));
		$('#smi_price_real').html(getformatedB(total_price));
		$('#smi_cost_real').html(getformatedB(total_cost));
		stop_waitMe('.wrapper');
	});

})

function getformatedB(val){


	return ( setFormat(( parseFloat(val) / 1000000000 ), 2) ) + ' B' ;
}

function getformatedM(val){


	return ( setFormat(( parseFloat(val) / 1000000 ), 2) ) + ' M' ;
}