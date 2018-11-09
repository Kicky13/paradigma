function numberWithCommas(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function opcoGroup (selday, selmonth, selyear, plant){
	  run_waitMe('.wrapper', 'ios');

	var urlSalesStPropinsi = "http://par4digma.semenindonesia.com/api/index.php/sales_st/wilayah_detail?bulan="+selmonth+"&tahun="+selyear;
	// var urlSalesStPropinsi = "http://localhost/par4digma_live/api/index.php/sales_st/wilayah_detail?bulan="+selmonth+"&tahun="+selyear;
	$.getJSON(urlSalesStPropinsi,function(data){
		stop_waitMe('.wrapper');
		$("#wil1").empty();
			for (var i = 0; i < data['1'].length; i++) {

				if(data['1'][i].RKAP==null){var rkap=0}else{var rkap=data['1'][i].RKAP}
				if(numberWithCommas(data['1'][i].PERCENT_REAL) < 100){var color = 'color:#e41a1c;';}else{var color = 'color:#4daf4a;';}
				if(numberWithCommas(data['1'][i].PERCENT_PROGNOSA) < 100){var color1 = 'color:#e41a1c;';}else{var color1 = 'color:#4daf4a;';}

				$('#title_wil1').html('<tr  style="background-color: #ff00001a"><td colspan="3"><strong>WILAYAH I</strong></td><td align="right"><strong>'+numberWithCommas(data['TOTAL']['1'].REAL)+'</strong></td><td align="right"><strong>'+numberWithCommas(data['TOTAL']['1'].RKAP)+'</strong></td><td align="right"><strong>'+numberWithCommas(data['TOTAL']['1'].PROGNOSA)+'</strong></td></tr>');
				$('#wil1').append('<tr><td>'+data['1'][i].DISTRIK+'</td><td style="text-align:right;'+color+'">'+numberWithCommas(data['1'][i].PERCENT_REAL)+'</td><td style="text-align:right;'+color1+'">'+numberWithCommas(data['1'][i].PERCENT_PROGNOSA)+'</td><td style="text-align:right;">'+numberWithCommas(data['1'][i].REAL)+'</td><td style="text-align:right;">'+numberWithCommas(rkap)+'</td><td style="text-align:right">'+numberWithCommas(data['1'][i].PROGNOSA)+'</td><tr>');

			}
			$("#wil2").empty();
			for (var i = 0; i < data['2'].length; i++) {
				if(data['2'][i].RKAP==null){var rkap=0}else{var rkap=data['2'][i].RKAP}
				if(numberWithCommas(data['2'][i].PERCENT_REAL) < 100){var color = 'color:#e41a1c;';}else{var color = 'color:#4daf4a;';}
				if(numberWithCommas(data['2'][i].PERCENT_PROGNOSA) < 100){var color1 = 'color:#e41a1c;';}else{var color1 = 'color:#4daf4a;';}

				$('#title_wil2').html('<tr  style="background-color: #ff00001a"><td colspan="3"><strong>WILAYAH II</strong></td><td align="right"><strong>'+numberWithCommas(data['TOTAL']['2'].REAL)+'</strong></td><td align="right"><strong>'+numberWithCommas(data['TOTAL']['2'].RKAP)+'</strong></td><td align="right"><strong>'+numberWithCommas(data['TOTAL']['2'].PROGNOSA)+'</strong></td></tr>');
				$('#wil2').append('<tr><td>'+data['2'][i].DISTRIK+'</td><td style="text-align:right;'+color+'">'+numberWithCommas(data['2'][i].PERCENT_REAL)+'</td><td style="text-align:right;'+color1+'">'+numberWithCommas(data['2'][i].PERCENT_PROGNOSA)+'</td><td style="text-align:right;">'+numberWithCommas(data['2'][i].REAL)+'</td><td style="text-align:right;">'+numberWithCommas(rkap)+'</td><td style="text-align:right">'+numberWithCommas(data['2'][i].PROGNOSA)+'</td><tr>');

			}
			$("#wil3").empty();
			for (var i = 0; i < data['3'].length; i++) {
				if(data['3'][i].RKAP==null){var rkap=0}else{var rkap=data['3'][i].RKAP}
				if(numberWithCommas(data['3'][i].PERCENT_REAL) < 100){var color = 'color:#e41a1c;';}else{var color = 'color:#4daf4a;';}
				if(numberWithCommas(data['3'][i].PERCENT_PROGNOSA) < 100){var color1 = 'color:#e41a1c;';}else{var color1 = 'color:#4daf4a;';}

				$('#title_wil3').html('<tr  style="background-color: #ff00001a"><td colspan="3"><strong>WILAYAH III</strong></td><td align="right"><strong>'+numberWithCommas(data['TOTAL']['3'].REAL)+'</strong></td><td align="right"><strong>'+numberWithCommas(data['TOTAL']['3'].RKAP)+'</strong></td><td align="right"><strong>'+numberWithCommas(data['TOTAL']['3'].PROGNOSA)+'</strong></td></tr>');
				$('#wil3').append('<tr><td>'+data['3'][i].DISTRIK+'</td><td style="text-align:right;'+color+'">'+numberWithCommas(data['3'][i].PERCENT_REAL)+'</td><td style="text-align:right;'+color1+'">'+numberWithCommas(data['3'][i].PERCENT_PROGNOSA)+'</td><td style="text-align:right;">'+numberWithCommas(data['3'][i].REAL)+'</td><td style="text-align:right;">'+numberWithCommas(rkap)+'</td><td style="text-align:right">'+numberWithCommas(data['3'][i].PROGNOSA)+'</td><tr>');
			}

		// console.log(data);
	});
}