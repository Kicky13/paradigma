
function income(opco){
	run_waitMe('.wrapper', 'facebook');
	var total = 0;
	$.ajax({
			url: url_src+'/json/FicoDataDistributor_ar.php',
			type: 'GET',
			success: function(data){
				total = 0.00;
				// var obj = JSON.parse(data);
				var obj = data;
				// console.log(obj[opco]);

				$.each(obj['7000'], function(i,data){
					// console.log(i +"- "+ data);
					// console.log(data['0000000138']);
					$.each(obj['7000'][i], function(result){
						// console.log(result);
						var company = obj['7000'][i][result]['company'];
						var vendor_name = obj['7000'][i][result]['vendor_name'];
						var acc_rec = obj['7000'][i][result]['acc_rec'];
						var income = parseFloat(acc_rec/1000).toFixed(2);
						
						if (company == opco) {
							// console.log('opco 7000');
							total = total + parseFloat(acc_rec);
							$('#tableBody').append(

								' <tr><td>'+ vendor_name +'</td><td valign="middle" align="right"><span style="color:#669966">'+ FormatNumberBy3(income) +'</span></td></tr>'

								);

						}
						// console.log(obj[opco][i][result]);
					
					});
				});
				console.log(total);
				var totalfix = parseFloat(total/1000000).toFixed(2);
				$('#cashin_t').append('<span class="det_tittle" style="font-size: 20px;color:#669966;">'+totalfix+ ' M</span><br><span class="upercent">Total</span>');
				// $('.table-responsive').append(
				// 		'<tfoot><tr style="background-color: ghostwhite;"><td>TOTAL<br></td><td valign="middle"><div align="right"><span style="color:#669966">'+ FormatNumberBy3(totalfix)+'</span></div></td></tr></tfoot>'
				// );
				setTimeout(function(){
					console.log('timeaout');
					stop_waitMe('.wrapper');
				},1000);
			}
		});
}

function expanse(opco){
	run_waitMe('.wrapper', 'facebook');

	var total = 0;
	$.ajax({
			url: url_src+'/json/FicoDataVendor_ar.php',
			type: 'GET',
			success: function(data){
				total = 0.00;
				var obj = JSON.parse(data);
				// console.log(obj[opco]);
				console.log(total);
				$.each(obj['7000'], function(i,data){
					// console.log(i +"- "+ data);
					// console.log(data['0000000138']);
					$.each(obj['7000'][i], function(result){
						// console.log(result);
						var company = obj['7000'][i][result]['company'];
						var vendor_name = obj['7000'][i][result]['vendor_name'];
						var acc_pay = obj['7000'][i][result]['acc_pay'];
						var outcome = parseFloat(acc_pay/1000).toFixed(2);
						
						if (company == opco) {
							// console.log('opco 7000');
							total = total + parseFloat(acc_pay);
							$('#tableBody').append(

								' <tr><td>'+ vendor_name +'</td><td valign="middle" align="right"><span style="color:#996666">'+ FormatNumberBy3(outcome) +'</span></td></tr>'

								);
						}
						// console.log(obj[opco][i][result]);
					
					});
				});
				console.log(total);
				var totalfix = parseFloat(total/1000000).toFixed(2);
				$('#cashin_t').append('<span class="det_tittle" style="font-size: 20px;color:#DC0033;">'+totalfix+ ' M</span><br><span class="upercent">Total</span>');
				// $('.table-responsive').append(
				// 		'<tfoot><tr style="background-color: ghostwhite;"><td>TOTAL<br></td><td valign="middle"><div align="right"><span style="color:#996666">'+ FormatNumberBy3(totalfix)+'</span></div></td></tr></tfoot>'
				// );
				setTimeout(function(){
					console.log('timeaout');
					stop_waitMe('.wrapper');
				},1000);
				
			}
		});
}