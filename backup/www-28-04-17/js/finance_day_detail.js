function finance_day_detail(opco, day){
	run_waitMe('.wrapper', 'facebook');
	var tableData = [];//vendor_name//cashin//cashout   //type
	var total = 0;
	var url1 = url_src+'/json/FicoDataDistributor.php';
	var url2 = url_src+'/json/FicoDataVendor.php';

	$.when(
	    $.getJSON(url2),
	    $.getJSON(url1)
	).done(function(result1, result2) {
		var dist = result1[0]['7000'];
		var vendor = result2[0]['7000']

		$.each(dist, function(i,data){
			// console.log(i +"- "+ data);
			// console.log(data['0000000138']);
			$.each(dist[i], function(result){
				// console.log(result);
				var company = dist[i][result]['company'];
				var vendor_name = dist[i][result]['vendor_name'];
				var acc_pay = dist[i][result]['acc_pay'];
				var sourceDay = dist[i][result]['day'];
				var outcome = parseFloat(acc_pay/1000).toFixed(2);
				
				if (company == opco) {
					// console.log('opco 7000');
					total = total + parseFloat(acc_pay);
					var arrayTemp = [];
					arrayTemp['company'] = company;
					arrayTemp['vendor_name'] = vendor_name;
					arrayTemp['day'] = sourceDay;
					arrayTemp['acc_rec'] = '0';
					arrayTemp['acc_pay'] = acc_pay;
					arrayTemp['type'] = 'Vendor';
					tableData.push(arrayTemp);
				
				}
				// console.log(obj[opco][i][result]);
			
			});
		});

		$.each(vendor, function(i,data){
			// console.log(i +"- "+ data);
			// console.log(data['0000000138']);
			$.each(vendor[i], function(result){
				// console.log(result);
				var company = vendor[i][result]['company'];
				var vendor_name = vendor[i][result]['vendor_name'];
				var acc_rec = vendor[i][result]['acc_rec'];
				var sourceDay = vendor[i][result]['day'];
				var income = parseFloat(acc_rec/1000).toFixed(2);
				// console.log(acc_rec);
				if (company == opco) {
					// console.log('opco 7000');
					total = total + parseFloat(acc_rec);
					var arrayTemp = [];
					arrayTemp['company'] = company;
					arrayTemp['vendor_name'] = vendor_name;
					arrayTemp['day'] = sourceDay;
					arrayTemp['acc_rec'] = acc_rec;
					arrayTemp['acc_pay'] = '0';
					arrayTemp['type'] = 'Distributor';
					tableData.push(arrayTemp);

				
				}
				// console.log(obj[opco][i][result]);
			
			});
		});

		console.log("table data lenght : "+tableData.length);
		// console.log(tableData);
		createTableRow(tableData, day);

		setTimeout(function(){
					console.log('timeaout');
					stop_waitMe('.wrapper');
				},1000);

		
	});

	
						
	
}

function createTableRow(data, activeDay){
	var row;
	var total_cashin = 0.00;
	var total_cashout = 0.00;

	for (var i = 0; i < data.length; i++) {
		row = data[i];

		

		if (row.day == activeDay) {
			// console.log(row.acc_rec + "x "+row.acc_pay);
			// console.log('day : '+row.day);
			// console.log('type : '+row.type);
			// console.log('-----------------------------');
			total_cashin = total_cashin + parseFloat(row.acc_rec);
			total_cashout = total_cashout + parseFloat(row.acc_pay);
			addRow(
				row.vendor_name, 
				row.type, 
				parseFloat(row.acc_pay/1000).toFixed(2), 
				parseFloat(row.acc_rec/1000).toFixed(2)
			);
		}
	}
	
	addTotal(
		parseFloat(total_cashout/1000).toFixed(2), 
		parseFloat(total_cashin/1000).toFixed(2)
	);
}

function addRow(vendor_name, type, acc_pay, acc_rec){
	$('table tbody').append(
		' <tr><td><br>'+vendor_name+'<br><span class="upercent font12">'+type+'</span></td><td valign="middle" align="right"><span style="color:#669966">'+FormatNumberBy3(acc_rec)+'</span></td><td valign="middle" align="right"><span style="color:#DC0033">'+FormatNumberBy3(acc_pay)+'</span></td></tr>'
		);
}
function addTotal(total_pay, total_rec){
	console.log(total_pay+" - "+total_rec);
	$('table tfoot').append(
		'<tr style="background-color: ghostwhite;"><td>TOTAL<br></td><td valign="middle"><div align="right"><span style="color:#669966">'+FormatNumberBy3(total_rec)+'</span></div></td><td valign="middle"><div align="right"><span style="color:#DC0033">'+FormatNumberBy3(total_pay)+'</span></div></td></tr>'
		);
}
