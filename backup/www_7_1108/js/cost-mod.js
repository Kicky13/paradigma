	var label = [];
	var now = [];
	var last = [];
	var hei = '';
    var d = new Date();
    var yearnow = d.getFullYear();

function cost_data(bulan, opco, yearnow){
	run_waitMe('.wrapper', 'ios');

	// var param = (opco!='SMI')?'&company='+opco:'';
	var param = (opco!='SMI')?'&company='+opco:'';

	$('#tag_current_cost').html(month[bulan-1]);
	$('#tag_current_cost1').html(month[bulan-1]);
	$('#tag_current_cost2').html(month[bulan-1]);
	$('#tag_current_cost3').html(month[bulan-1]);
	$('#tag_current_cost4').html(month[bulan-1]);
	$('#tag_current_cost5').html(month[bulan-1]);
	$('#tag_current_cost6').html(month[bulan-1]);
	$('#tag_current_cost7').html(month[bulan-1]);
	$('#tag_current_cost8').html(month[bulan-1]);

	$('#tag_last_cost').html(month[bulan-2]);
	$('#tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);
	// $.post(url_src+'/api/index.php/Project', function(data){
	// $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){

	$.post(url_src+'par4digma/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+param, function(data){
			// var data1 = data.replace("<title>Json</title>", "");
		  	// var data2 = data.replace("(", "[");
		  	//   var data3 = data2.replace(");", "]");

				// var dataJson  = JSON.parse(data);
				// var dataJson = eval('(' + data + ')');
				try{
			dataJson = JSON.parse(data);
			}catch(e){
				console.log('data error');
				stop_waitMe('.wrapper');
				alert('Sorry, data is empty, please choose another month');
			}
				var dataJson = JSON.parse(data);
		            // var myData = dataJson.Terak;
				console.log(dataJson);
				console.log(opco);


			// ############## NOW
				var clin_now = Number(dataJson['s'+opco]["0"].bulan_ini.clinker);
				var cmnt_now = Number(dataJson['s'+opco]["0"].bulan_ini.cement);
				var salevol_now = Number(dataJson['s'+opco]["0"].bulan_ini.sales)/1000000000;
			// production_cost
				var pcost_rw_now = Number(dataJson.production_cost["0"].bulan_ini["Raw Material"]);
				var pcost_sm_now = Number(dataJson.production_cost["0"].bulan_ini["Supporting Material"]);
				var pcost_f_now = Number(dataJson.production_cost["0"].bulan_ini.Fuel);
				var pcost_amor_now = Number(dataJson.production_cost["0"].bulan_ini["Depl. Deprec. and Amortization"]);
				var pcost_elc_now = Number(dataJson.production_cost["0"].bulan_ini.Electricity);
				var pcost_gadm_now = Number(dataJson.production_cost["0"].bulan_ini["General & Adminitration"]);
				var pcost_lab_now = Number(dataJson.production_cost["0"].bulan_ini.Labor);
				var pcost_main_now = Number(dataJson.production_cost["0"].bulan_ini.Maintenance);
				var pcost_tax_now = Number(dataJson.production_cost["0"].bulan_ini["Taxes and Insurance"]);
				var tot_pcost_nw = (pcost_rw_now+pcost_sm_now+pcost_f_now+pcost_amor_now+pcost_elc_now+pcost_gadm_now+pcost_lab_now+pcost_main_now+pcost_tax_now)/1000000000;
				
			// cogs
				var cogs_dist_now = Number(dataJson.good_of_sold["0"].bulan_ini.Distribution);
				var cogs_pack_now = Number(dataJson.good_of_sold["0"].bulan_ini.Packaging);
				var cogs_vs_now = Number(dataJson.good_of_sold["0"].bulan_ini["Variance Stok"]);
				var cogs_wip_now = Number(dataJson.good_of_sold["0"].bulan_ini["WIP (Purchasing)"]);
				var tot_cogs_nw = (cogs_dist_now+cogs_pack_now+cogs_vs_now+cogs_wip_now)/1000000000;
			// General Adminitration
				var gen_dam_now = Number(dataJson.general_admininstration["0"].bulan_ini["Depl. Deprec. and Amortization"]);
				var gen_el_now = Number(dataJson.general_admininstration["0"].bulan_ini.Electricity);
				var gen_fuel_now = Number(dataJson.general_admininstration["0"].bulan_ini.Fuel);
				var gen_gm_now = Number(dataJson.general_admininstration["0"].bulan_ini["General & Adminitration"]);
				var gen_labor_now = Number(dataJson.general_admininstration["0"].bulan_ini.Labor);
				var gen_mainte_now = Number(dataJson.general_admininstration["0"].bulan_ini.Maintenance);
				var gen_support_now = Number(dataJson.general_admininstration["0"].bulan_ini["Supporting Material"]);
				var gen_tax_now = Number(dataJson.general_admininstration["0"].bulan_ini["Taxes and insurance"]);
				var tot_gen_nw = (gen_dam_now+gen_el_now+gen_fuel_now+gen_gm_now+gen_labor_now+gen_mainte_now+gen_support_now+gen_tax_now)/1000000000;
			// Selling Marketing
				var sell_dam_now = Number(dataJson.selling_marketing["0"].bulan_ini["Depl. Deprec. and Amortization"]);
				var sell_elc_now = Number(dataJson.selling_marketing["0"].bulan_ini.Electricity);
				var sell_fuel_now = Number(dataJson.selling_marketing["0"].bulan_ini.Fuel);
				var sell_gm_now = Number(dataJson.selling_marketing["0"].bulan_ini["General & Adminitration"]);
				var sell_labor_now = Number(dataJson.selling_marketing["0"].bulan_ini.Labor);
				var sell_main_now = Number(dataJson.selling_marketing["0"].bulan_ini.Maintenance);
				var sell_sm_now = Number(dataJson.selling_marketing["0"].bulan_ini["Supporting Material"]);
				var sell_tax_now = Number(dataJson.selling_marketing["0"].bulan_ini["Taxes and insurance"]);
				var tot_sell_nw = (sell_dam_now+sell_elc_now+sell_fuel_now+sell_gm_now+sell_labor_now+sell_main_now+sell_sm_now+sell_tax_now)/1000000000;


				// console.log('raw mtr'+rw_now);
				// console.log('sup mtr'+sm_now);
				// console.log('fuel'+f_now);
			// ############## PAST
				var clin_past = Number(dataJson['s'+opco]["0"].bulan_lalu.clinker);
				var cmnt_past = Number(dataJson['s'+opco]["0"].bulan_lalu.cement);
				var salevol_past = Number(dataJson['s'+opco]["0"].bulan_lalu.sales)/1000000000;	

				var pcost_rw_past = Number(dataJson.production_cost["0"].up_bulan_ini["Raw Material"]);
				var pcost_sm_past = Number(dataJson.production_cost["0"].up_bulan_ini["Supporting Material"]);
				var pcost_f_past = Number(dataJson.production_cost["0"].up_bulan_ini.Fuel);
				var pcost_amor_past = Number(dataJson.production_cost["0"].up_bulan_ini["Depl. Deprec. and Amortization"]);
				var pcost_elc_past = Number(dataJson.production_cost["0"].up_bulan_ini.Electricity);
				var pcost_gadm_past = Number(dataJson.production_cost["0"].up_bulan_ini["General & Adminitration"]);
				var pcost_lab_past = Number(dataJson.production_cost["0"].up_bulan_ini.Labor);
				var pcost_main_past = Number(dataJson.production_cost["0"].up_bulan_ini.Maintenance);
				var pcost_tax_past = Number(dataJson.production_cost["0"].up_bulan_ini["Taxes and Insurance"]);
				var tot_pcost_pst = (pcost_rw_past+pcost_sm_past+pcost_f_past+pcost_amor_past+pcost_elc_past+pcost_gadm_past+pcost_lab_past+pcost_main_past+pcost_tax_past)/1000000000;
			// cogs
				var cogs_dist_past = Number(dataJson.good_of_sold["0"].up_bulan_ini.Distribution);
				var cogs_pack_past = Number(dataJson.good_of_sold["0"].up_bulan_ini.Packaging);
				var cogs_vs_past = Number(dataJson.good_of_sold["0"].up_bulan_ini["Variance Stok"]);
				var cogs_wip_past = Number(dataJson.good_of_sold["0"].up_bulan_ini["WIP (Purchasing)"]);
				var tot_cogs_pst = (cogs_dist_past+cogs_pack_past+cogs_vs_past+cogs_wip_past)/1000000000;
			// General Adminitration
				var gen_dam_past = Number(dataJson.general_admininstration["0"].up_bulan_ini["Depl. Deprec. and Amortization"]);
				var gen_el_past = Number(dataJson.general_admininstration["0"].up_bulan_ini.Electricity);
				var gen_fuel_past = Number(dataJson.general_admininstration["0"].up_bulan_ini.Fuel);
				var gen_gm_past = Number(dataJson.general_admininstration["0"].up_bulan_ini["General & Adminitration"]);
				var gen_labor_past = Number(dataJson.general_admininstration["0"].up_bulan_ini.Labor);
				var gen_mainte_past = Number(dataJson.general_admininstration["0"].up_bulan_ini.Maintenance);
				var gen_support_past = Number(dataJson.general_admininstration["0"].up_bulan_ini["Supporting Material"]);
				var gen_tax_past = Number(dataJson.general_admininstration["0"].up_bulan_ini["Taxes and insurance"]);
				var tot_gen_pst = (gen_dam_past+gen_el_past+gen_fuel_past+gen_gm_past+gen_labor_past+gen_mainte_past+gen_support_past+gen_tax_past)/1000000000;
			// Selling Marketing
				var sell_dam_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["Depl. Deprec. and Amortization"]);
				var sell_elc_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Electricity);
				var sell_fuel_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Fuel);
				var sell_gm_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["General & Adminitration"]);
				var sell_labor_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Labor);
				var sell_main_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Maintenance);
				var sell_sm_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["Supporting Material"]);
				var sell_tax_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["Taxes and insurance"]);
				var tot_sell_pst = (sell_dam_past+sell_elc_past+sell_fuel_past+sell_gm_past+sell_labor_past+sell_main_past+sell_sm_past+sell_tax_past)/1000000000;
				
// TOTAL #################################################################################################################
				var rkap_current_prod = Number(dataJson.production_cost["0"].rkap_bulan_ini.Total)/1000000000;
				var real_current_prod = Number(dataJson.production_cost["0"].bulan_ini.Total)/1000000000;
				var real_lyear_prod = Number(dataJson.production_cost["0"].bulan_ini_lyear.Total)/1000000000;
				var yoy_current = parseFloat(dataJson.production_cost["0"].bulan_ini.Yoy).toFixed(2);
				console.log("yoy cur : "+yoy_current);

				var rkap_up_prod = Number(dataJson.production_cost["0"].rkap_up_bulan_ini.Total)/1000000000;
				var real_up_prod = Number(dataJson.production_cost["0"].up_bulan_ini.Total)/1000000000;
				var real_up_lyear_prod = Number(dataJson.production_cost["0"].up_bulan_ini_lyear.Total)/1000000000;
				var yoy_up = parseFloat(dataJson.production_cost["0"].up_bulan_ini.Yoy).toFixed(2);
				console.log("yoy up : "+yoy_up);
				console.log(typeof(yoy_up))


				var perc1b = (real_up_prod/rkap_up_prod)*100;
				var perc1a = (real_current_prod/rkap_current_prod)*100;
// COGS #################################################################################################################
				var rkap_current_cogs = Number(dataJson.good_of_sold["0"].rkap_bulan_ini.Total)/1000000000;
				var real_current_cogs = Number(dataJson.good_of_sold["0"].bulan_ini.Total)/1000000000;
				var real_lyear_cogs = Number(dataJson.good_of_sold["0"].bulan_ini_lyear.Total)/1000000000;
				var yoy_current_cogs = parseFloat(dataJson.good_of_sold["0"].bulan_ini.Yoy).toFixed(2);
				console.log("yoy cur : "+yoy_current);

				var rkap_up_cogs = Number(dataJson.good_of_sold["0"].rkap_up_bulan_ini.Total)/1000000000;
				var real_up_cogs = Number(dataJson.good_of_sold["0"].up_bulan_ini.Total)/1000000000;
				var real_up_lyear_cogs = Number(dataJson.good_of_sold["0"].up_bulan_ini_lyear.Total)/1000000000;
				var yoy_up_cogs = parseFloat(dataJson.good_of_sold["0"].up_bulan_ini.Yoy).toFixed(2);
				console.log("yoy up : "+yoy_up);
				console.log(typeof(yoy_up))


				var perc2b = (real_up_cogs/rkap_up_cogs)*100;
				var perc2a = (real_current_cogs/rkap_current_cogs)*100;

// General #################################################################################################################
				var rkap_current_gnrl = Number(dataJson.general_admininstration["0"].rkap_bulan_ini.Total)/1000000000;
				var real_current_gnrl = Number(dataJson.general_admininstration["0"].bulan_ini.Total)/1000000000;
				var real_lyear_gnrl = Number(dataJson.general_admininstration["0"].bulan_ini_lyear.Total)/1000000000;
				var yoy_current_gnrl = parseFloat(dataJson.general_admininstration["0"].bulan_ini.Yoy).toFixed(2);
				console.log("yoy cur : "+yoy_current);

				var rkap_up_gnrl = Number(dataJson.general_admininstration["0"].rkap_up_bulan_ini.Total)/1000000000;
				var real_up_gnrl = Number(dataJson.general_admininstration["0"].up_bulan_ini.Total)/1000000000;
				var real_up_lyear_gnrl = Number(dataJson.general_admininstration["0"].up_bulan_ini_lyear.Total)/1000000000;
				var yoy_up_gnrl = parseFloat(dataJson.general_admininstration["0"].up_bulan_ini.Yoy).toFixed(2);
				console.log("yoy up : "+yoy_up);
				console.log(typeof(yoy_up))


				var perc3b = (real_up_gnrl/rkap_up_gnrl)*100;
				var perc3a = (real_current_gnrl/rkap_current_gnrl)*100;

// Sale Market #################################################################################################################
				var rkap_current_sale = Number(dataJson.selling_marketing["0"].rkap_bulan_ini.Total)/1000000000;
				var real_current_sale = Number(dataJson.selling_marketing["0"].bulan_ini.Total)/1000000000;
				var real_lyear_sale = Number(dataJson.selling_marketing["0"].bulan_ini_lyear.Total)/1000000000;
				var yoy_current_sale = parseFloat(dataJson.selling_marketing["0"].bulan_ini.Yoy).toFixed(2);
				console.log("yoy cur : "+yoy_current);

				var rkap_up_sale = Number(dataJson.selling_marketing["0"].rkap_up_bulan_ini.Total)/1000000000;
				var real_up_sale = Number(dataJson.selling_marketing["0"].up_bulan_ini.Total)/1000000000;
				var real_up_lyear_sale = Number(dataJson.selling_marketing["0"].up_bulan_ini_lyear.Total)/1000000000;
				var yoy_up_sale = parseFloat(dataJson.selling_marketing["0"].up_bulan_ini.Yoy).toFixed(2);
				console.log("yoy up : "+yoy_up);
				console.log(typeof(yoy_up))


				var perc4b = (real_up_sale/rkap_up_sale)*100;
				var perc4a = (real_current_sale/rkap_current_sale)*100;

// TOTAL #################################################################################################################
				$('#perc1a').html(setFormat(perc1a, 1));
				$('#rkap_current_prod').html(setFormat(rkap_current_prod, 1));
				$('#real_lyear_prod').html(setFormat(real_lyear_prod, 1));
				$('#yoy_current_p').html(yoy_current);

				$('#perc1b').html(setFormat(perc1b, 1));
				$('#rkap_up_prod').html(setFormat(rkap_up_prod, 1));
				$('#real_up_lyear_prod').html(setFormat(real_up_lyear_prod, 1));
				$('#yoy_up_p').html(yoy_up);

// Cogs #################################################################################################################
				$('#perc2a').html(setFormat(perc2a, 1));
				$('#rkap_current_cogs').html(setFormat(rkap_current_cogs, 1));
				$('#real_lyear_cogs').html(setFormat(real_lyear_cogs, 1));
				$('#yoy_current_cogs').html(yoy_current_cogs);

				$('#perc2b').html(setFormat(perc2b, 1));
				$('#rkap_up_cogs').html(setFormat(rkap_up_cogs, 1));
				$('#real_up_lyear_cogs').html(setFormat(real_up_lyear_cogs, 1));
				$('#yoy_up_cogs').html(yoy_up_cogs);

// gnrl #################################################################################################################
				$('#perc3a').html(setFormat(perc3a, 1));
				$('#rkap_current_gnrl').html(setFormat(rkap_current_gnrl, 1));
				$('#real_lyear_gnrl').html(setFormat(real_lyear_gnrl, 1));
				$('#yoy_current_gnrl').html(yoy_current_gnrl);

				$('#perc3b').html(setFormat(perc3b, 1));
				$('#rkap_up_gnrl').html(setFormat(rkap_up_gnrl, 1));
				$('#real_up_lyear_gnrl').html(setFormat(real_up_lyear_gnrl, 1));
				$('#yoy_up_gnrl').html(yoy_up_gnrl);

// sale #################################################################################################################
				$('#perc4a').html(setFormat(perc4a, 1));
				$('#rkap_current_sale').html(setFormat(rkap_current_sale, 1));
				$('#real_lyear_sale').html(setFormat(real_lyear_sale, 1));
				$('#yoy_current_sale').html(yoy_current_sale);

				$('#perc4b').html(setFormat(perc4b, 1));
				$('#rkap_up_sale').html(setFormat(rkap_up_sale, 1));
				$('#real_up_lyear_sale').html(setFormat(real_up_lyear_sale, 1));
				$('#yoy_up_sale').html(yoy_up_sale);





				console.log(tot_pcost_nw);
				console.log(tot_pcost_pst);

				$('#clin_now').html(setFormat(clin_now, 0)+' B');
				$('#cmnt_now').html(setFormat(cmnt_now, 2)+' B');
				$('#salevol_now').html(setFormat(salevol_now, 2)+' B');

				$('#clin_past').html(setFormat(clin_past, 0)+' B');
				$('#cmnt_past').html(setFormat(cmnt_past, 2)+' B');
				$('#salevol_past').html(setFormat(salevol_past, 2)+' B');
				// DETAIL
				
				$('#tot_pcost_nw').html(setFormat(tot_pcost_nw, 2));
				$('#tot_pcost_pst').html(setFormat(tot_pcost_pst, 2));

				$('#tot_cogs_nw').html(setFormat(real_current_cogs, 1));
				$('#tot_cogs_pst').html(setFormat(real_up_cogs, 1));

				$('#tot_gen_nw').html(setFormat(tot_gen_nw, 2));
				$('#tot_gen_pst').html(setFormat(tot_gen_pst, 2));

				$('#tot_sell_nw').html(setFormat(tot_sell_nw, 2));
				$('#tot_sell_pst').html(setFormat(tot_sell_pst, 2));

				console.log(tot_pcost_nw);
				console.log()

				

				stop_waitMe('.wrapper');
				

		
	});
	    

}

function cost_data_detail(){
	run_waitMe('.wrapper', 'ios');
	var param = '';
   
	if (sessionStorage.getItem('cost-bln')!=null) {
      var data = sessionStorage.getItem('cost-bln');

      console.log(data);
      bulan = data;

    }
	if (sessionStorage.getItem('cost-opco')!=null) {
      var data = sessionStorage.getItem('cost-opco');

      console.log(data);
      param = "&company="+data;

    }
    console.log(bulan);
    $('#tag_month_selected').html(month[bulan-1]);
	$('#tag_current_cost').html(month[bulan-1]);
	$('#tag_current_cost1').html(month[bulan-1]);
	$('#tag_current_cost2').html(month[bulan-1]);
	$('#tag_current_cost3').html(month[bulan-1]);
	$('#tag_current_cost4').html(month[bulan-1]);
	$('#tag_current_cost5').html(month[bulan-1]);
	$('#tag_current_cost6').html(month[bulan-1]);
	$('#tag_current_cost7').html(month[bulan-1]);
	$('#tag_current_cost8').html(month[bulan-1]);

	$('#tag_last_cost').html(month[bulan-2]);
	$('#tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);
	// $.post(url_src+'/api/index.php/Project', function(data){
	// $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){
		var dataJson ;
		$.post(url_src+'par4digma/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+param, function(data){
			// var data1 = data.replace("<title>Json</title>", "");
   //         var data2 = data.replace("(", "[");
   //          var data3 = data2.replace(");", "]");

		// var dataJson  = JSON.parse(data);
		// var dataJson = eval('(' + data + ')');
		try{
			dataJson = JSON.parse(data);
		}catch(e){
			console.log('data error');

		}
		
		console.log(dataJson);
		$.each(dataJson.production_cost["0"].bulan_ini, function(i, result){
			console.log(i+"");
			label.push(i);
			var value = Number(dataJson.production_cost["0"].bulan_ini[i])/1000000;
			now.push(Math.round(value));
		})
		$.each(dataJson.production_cost["0"].up_bulan_ini, function(i, result){

			var value = Number(dataJson.production_cost["0"].up_bulan_ini[i])/1000000;
			
			last.push(Math.round(value));
		})
		label.pop();last.pop();now.pop();
		label.pop();last.pop();now.pop();


// production_cost
		var pcost_rw_now = Number(dataJson.production_cost["0"].bulan_ini["Raw Material"]);
		var pcost_sm_now = Number(dataJson.production_cost["0"].bulan_ini["Supporting Material"]);
		var pcost_f_now = Number(dataJson.production_cost["0"].bulan_ini.Fuel);
		var pcost_amor_now = Number(dataJson.production_cost["0"].bulan_ini["Depl. Deprec. and Amortization"]);
		var pcost_elc_now = Number(dataJson.production_cost["0"].bulan_ini.Electricity);
		var pcost_gadm_now = Number(dataJson.production_cost["0"].bulan_ini["General & Adminitration"]);
		var pcost_lab_now = Number(dataJson.production_cost["0"].bulan_ini.Labor);
		var pcost_main_now = Number(dataJson.production_cost["0"].bulan_ini.Maintenance);
		var pcost_tax_now = Number(dataJson.production_cost["0"].bulan_ini["Taxes and Insurance"]);
		var tot_pcost_nw = (pcost_rw_now+pcost_sm_now+pcost_f_now+pcost_amor_now+pcost_elc_now+pcost_gadm_now+pcost_lab_now+pcost_main_now+pcost_tax_now);
		


		
// ############## PAST
		

		var pcost_rw_past = Number(dataJson.production_cost["0"].up_bulan_ini["Raw Material"]);
		var pcost_sm_past = Number(dataJson.production_cost["0"].up_bulan_ini["Supporting Material"]);
		var pcost_f_past = Number(dataJson.production_cost["0"].up_bulan_ini.Fuel);
		var pcost_amor_past = Number(dataJson.production_cost["0"].up_bulan_ini["Depl. Deprec. and Amortization"]);
		var pcost_elc_past = Number(dataJson.production_cost["0"].up_bulan_ini.Electricity);
		var pcost_gadm_past = Number(dataJson.production_cost["0"].up_bulan_ini["General & Adminitration"]);
		var pcost_lab_past = Number(dataJson.production_cost["0"].up_bulan_ini.Labor);
		var pcost_main_past = Number(dataJson.production_cost["0"].up_bulan_ini.Maintenance);
		var pcost_tax_past = Number(dataJson.production_cost["0"].up_bulan_ini["Taxes and Insurance"]);
		var tot_pcost_pst = (pcost_rw_past+pcost_sm_past+pcost_f_past+pcost_amor_past+pcost_elc_past+pcost_gadm_past+pcost_lab_past+pcost_main_past+pcost_tax_past);


console.log(tot_pcost_nw);
console.log(tot_pcost_pst);

		
// DETAIL
		



		$('#pcost_rw_now').html(setFormat(pcost_rw_now, 0));
		$('#pcost_sm_now').html(setFormat(pcost_sm_now, 0));
		$('#pcost_f_now').html(setFormat(pcost_f_now, 0));
		$('#pcost_amor_now').html(setFormat(pcost_amor_now, 0));
		$('#pcost_elc_now').html(setFormat(pcost_elc_now, 0));
		$('#pcost_gadm_now').html(setFormat(pcost_gadm_now, 0));
		$('#pcost_lab_now').html(setFormat(pcost_lab_now, 0));
		$('#pcost_main_now').html(setFormat(pcost_main_now, 0));
		$('#pcost_tax_now').html(setFormat(pcost_tax_now, 0));
		var tot_pcost_nwx = Number(tot_pcost_nw);
		$('#tot_pcost_nwu').html(setFormat(tot_pcost_nwx, 0));
		$('#tot_pcost_nw').html(setFormat(tot_pcost_nwx, 0));
		// console.log('mentah '+tot_pcost_nwx);

		$('#pcost_rw_past').html(setFormat(pcost_rw_past, 0));
		$('#pcost_sm_past').html(setFormat(pcost_sm_past, 0));
		$('#pcost_f_past').html(setFormat(pcost_f_past, 0));
		$('#pcost_amor_past').html(setFormat(pcost_amor_past, 0));
		$('#pcost_elc_past').html(setFormat(pcost_elc_past, 0));
		$('#pcost_gadm_past').html(setFormat(pcost_gadm_past, 0));
		$('#pcost_lab_past').html(setFormat(pcost_lab_past, 0));
		$('#pcost_main_past').html(setFormat(pcost_main_past, 0));
		$('#pcost_tax_past').html(setFormat(pcost_tax_past, 0));
		var tot_pcost_psx = Number(tot_pcost_pst);
		$('#tot_pcost_psu').html(setFormat(tot_pcost_psx, 0));
		$('#tot_pcost_ps').html(setFormat(tot_pcost_nwx, 0));

graphicChart(now, last, label, '350');

stop_waitMe('.wrapper');

	
	});
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

// ############################ COGS ############################
function cost_data_cogs(bulan, opco, yearnow){
	
	run_waitMe('.wrapper', 'ios');
	 console.log(bulan);
	// var param = (opco!='SMI')?'&company='+opco:'';
	var param = (opco!='SMI')?'&company='+opco:'';

	if (sessionStorage.getItem('cost-bln')!=null) {
      var data = sessionStorage.getItem('cost-bln');

      console.log(data);
      bulan = data;

    }
    console.log(bulan);
    $('#tag_month_selected').html(month[bulan-1]);
	$('#tag_current_cost').html(month[bulan-1]);
	$('#tag_current_cost1').html(month[bulan-1]);
	$('#tag_current_cost2').html(month[bulan-1]);
	$('#tag_current_cost3').html(month[bulan-1]);
	$('#tag_current_cost4').html(month[bulan-1]);
	$('#tag_current_cost5').html(month[bulan-1]);
	$('#tag_current_cost6').html(month[bulan-1]);
	$('#tag_current_cost7').html(month[bulan-1]);
	$('#tag_current_cost8').html(month[bulan-1]);

	$('#tag_last_cost').html(month[bulan-2]);
	$('#tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);
	
		var dataJson ;
		$.post(url_src+'par4digma/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+param, function(data){
		try{
			dataJson = JSON.parse(data);
		}catch(e){
			console.log('data error');
		}
		
		console.log(dataJson);

		$.each(dataJson.good_of_sold["0"].bulan_ini, function(i, result){
			console.log(i+"");
			label.push(i);
			var value = Number(dataJson.good_of_sold["0"].bulan_ini[i])/1000000;
			now.push(Math.round(value));
		})
		$.each(dataJson.good_of_sold["0"].up_bulan_ini, function(i, result){

			var value = Number(dataJson.good_of_sold["0"].up_bulan_ini[i])/1000000;
			
			last.push(Math.round(value));
		})
		label.pop();last.pop();now.pop();
		label.pop();last.pop();now.pop();
		
		console.log(label);
		console.log(now);
		console.log(last);

// cogs now
		var cogs_dist_now = Number(dataJson.good_of_sold["0"].bulan_ini.Distribution);
		var cogs_pack_now = Number(dataJson.good_of_sold["0"].bulan_ini.Packaging);
		var cogs_vs_now = Number(dataJson.good_of_sold["0"].bulan_ini["Variance Stok"]);
		var cogs_wip_now = Number(dataJson.good_of_sold["0"].bulan_ini["WIP (Purchasing)"]);
		var tot_cogs_nw = (cogs_dist_now+cogs_pack_now+cogs_vs_now+cogs_wip_now);
// cogs PAST
		var cogs_dist_past = Number(dataJson.good_of_sold["0"].up_bulan_ini.Distribution);
		var cogs_pack_past = Number(dataJson.good_of_sold["0"].up_bulan_ini.Packaging);
		var cogs_vs_past = Number(dataJson.good_of_sold["0"].up_bulan_ini["Variance Stok"]);
		var cogs_wip_past = Number(dataJson.good_of_sold["0"].up_bulan_ini["WIP (Purchasing)"]);
		var tot_cogs_pst = (cogs_dist_past+cogs_pack_past+cogs_vs_past+cogs_wip_past);



		$('#cogs_dist_now').html(setFormat(cogs_dist_now, 0));
		$('#cogs_pack_now').html(setFormat(cogs_pack_now, 0));
		$('#cogs_vs_now').html(setFormat(cogs_vs_now, 0));
		$('#cogs_wip_now').html(setFormat(cogs_wip_now, 0));
		
		var tot_cogs_nwx = Number(tot_cogs_nw);
		$('#tot_cogs_nwu').html(setFormat(tot_cogs_nwx, 0));
		$('#tot_cogs_nw').html(setFormat(tot_cogs_nwx, 0));
		// console.log('mentah '+tot_pcost_nwx);

		$('#cogs_dist_past').html(setFormat(cogs_dist_past, 0));
		$('#cogs_pack_past').html(setFormat(cogs_pack_past, 0));
		$('#cogs_vs_past').html(setFormat(cogs_vs_past, 0));
		$('#cogs_wip_past').html(setFormat(cogs_wip_past, 0));
		
		var tot_cogs_pstx = Number(tot_cogs_pst);
		$('#tot_cogs_pstu').html(setFormat(tot_cogs_pstx, 0));
		$('#tot_cogs_pst').html(setFormat(tot_cogs_pstx, 0));

		
		graphicChart(now, last, label, '300');

stop_waitMe('.wrapper');
	
	
	});
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}



// ############################ generel admn ############################

function cost_data_gnrl(bulan, opco, yearnow){
	run_waitMe('.wrapper', 'ios');
	 console.log(bulan);
	// var param = (opco!='SMI')?'&company='+opco:'';
	var param = (opco!='SMI')?'&company='+opco:'';

	if (sessionStorage.getItem('cost-bln')!=null) {
      var data = sessionStorage.getItem('cost-bln');

      console.log(data);
      bulan = data;

    }
    console.log(bulan);
    $('#tag_month_selected').html(month[bulan-1]);
	$('#tag_current_cost').html(month[bulan-1]);
	$('#tag_current_cost1').html(month[bulan-1]);
	$('#tag_current_cost2').html(month[bulan-1]);
	$('#tag_current_cost3').html(month[bulan-1]);
	$('#tag_current_cost4').html(month[bulan-1]);
	$('#tag_current_cost5').html(month[bulan-1]);
	$('#tag_current_cost6').html(month[bulan-1]);
	$('#tag_current_cost7').html(month[bulan-1]);
	$('#tag_current_cost8').html(month[bulan-1]);

	$('#tag_last_cost').html(month[bulan-2]);
	$('#tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);
	
		var dataJson ;
		$.post(url_src+'par4digma/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+param, function(data){
		try{
			dataJson = JSON.parse(data);
		}catch(e){
			console.log('data error');
		}
		
		console.log(dataJson);
		$.each(dataJson.general_admininstration["0"].bulan_ini, function(i, result){
			console.log(i+"");
			label.push(i);
			var value = Number(dataJson.general_admininstration["0"].bulan_ini[i])/1000000;
			now.push( Math.round(value));
		})
		$.each(dataJson.general_admininstration["0"].up_bulan_ini, function(i, result){

			var value = Number(dataJson.general_admininstration["0"].up_bulan_ini[i])/1000000;
			
			last.push( Math.round(value) );
		})


// General now
		var gen_dam_now = Number(dataJson.general_admininstration["0"].bulan_ini["Depl. Deprec. and Amortization"]);
		var gen_el_now = Number(dataJson.general_admininstration["0"].bulan_ini.Electricity);
		var gen_fuel_now = Number(dataJson.general_admininstration["0"].bulan_ini.Fuel);
		var gen_gm_now = Number(dataJson.general_admininstration["0"].bulan_ini["General & Adminitration"]);
		var gen_labor_now = Number(dataJson.general_admininstration["0"].bulan_ini.Labor);
		var gen_mainte_now = Number(dataJson.general_admininstration["0"].bulan_ini.Maintenance);
		var gen_support_now = Number(dataJson.general_admininstration["0"].bulan_ini["Supporting Material"]);
		var gen_tax_now = Number(dataJson.general_admininstration["0"].bulan_ini["Taxes and insurance"]);
		var tot_gen_nw = (gen_dam_now+gen_el_now+gen_fuel_now+gen_gm_now+gen_labor_now+gen_mainte_now+gen_support_now+gen_tax_now);
// General PAST
		var gen_dam_past = Number(dataJson.general_admininstration["0"].up_bulan_ini["Depl. Deprec. and Amortization"]);
		var gen_el_past = Number(dataJson.general_admininstration["0"].up_bulan_ini.Electricity);
		var gen_fuel_past = Number(dataJson.general_admininstration["0"].up_bulan_ini.Fuel);
		var gen_gm_past = Number(dataJson.general_admininstration["0"].up_bulan_ini["General & Adminitration"]);
		var gen_labor_past = Number(dataJson.general_admininstration["0"].up_bulan_ini.Labor);
		var gen_mainte_past = Number(dataJson.general_admininstration["0"].up_bulan_ini.Maintenance);
		var gen_support_past = Number(dataJson.general_admininstration["0"].up_bulan_ini["Supporting Material"]);
		var gen_tax_past = Number(dataJson.general_admininstration["0"].up_bulan_ini["Taxes and insurance"]);
		var tot_gen_pst = (gen_dam_past+gen_el_past+gen_fuel_past+gen_gm_past+gen_labor_past+gen_mainte_past+gen_support_past+gen_tax_past);


		$('#gen_dam_now').html(setFormat(gen_dam_now, 0));
		$('#gen_el_now').html(setFormat(gen_el_now, 0));
		$('#gen_fuel_now').html(setFormat(gen_fuel_now, 0));
		$('#gen_gm_now').html(setFormat(gen_gm_now, 0));
		$('#gen_labor_now').html(setFormat(gen_labor_now, 0));
		$('#gen_mainte_now').html(setFormat(gen_mainte_now, 0));
		$('#gen_support_now').html(setFormat(gen_support_now, 0));
		$('#gen_tax_now').html(setFormat(gen_tax_now, 0));
		
		var tot_gen_nwx = Number(tot_gen_nw);
		$('#tot_gen_nwu').html(setFormat(tot_gen_nwx, 0));
		$('#tot_gen_nw').html(setFormat(tot_gen_nwx, 0));
		// console.log('mentah '+tot_pcost_nwx);

		$('#gen_dam_past').html(setFormat(gen_dam_past, 0));
		$('#gen_el_past').html(setFormat(gen_el_past, 0));
		$('#gen_fuel_past').html(setFormat(gen_fuel_past, 0));
		$('#gen_gm_past').html(setFormat(gen_gm_past, 0));
		$('#gen_labor_past').html(setFormat(gen_labor_past, 0));
		$('#gen_mainte_past').html(setFormat(gen_mainte_past, 0));
		$('#gen_support_past').html(setFormat(gen_support_past, 0));
		$('#gen_tax_past').html(setFormat(gen_tax_past, 0));
		
		var tot_gen_pstx = Number(tot_gen_pst);
		$('#tot_gen_pstu').html(setFormat(tot_gen_pstx, 0));
		$('#tot_gen_pst').html(setFormat(tot_gen_pstx, 0));

	graphicChart(now, last, label, '350');

stop_waitMe('.wrapper');

	
	});
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

// ############################ Sales volume ############################

function cost_data_sell(bulan, opco, yearnow){
	run_waitMe('.wrapper', 'ios');
	 console.log(bulan);
	// var param = (opco!='SMI')?'&company='+opco:'';
	var param = (opco!='SMI')?'&company='+opco:'';

	if (sessionStorage.getItem('cost-bln')!=null) {
      var data = sessionStorage.getItem('cost-bln');

      console.log(data);
      bulan = data;

    }
    console.log(bulan);
    $('#tag_month_selected').html(month[bulan-1]);
	$('#tag_current_cost').html(month[bulan-1]);
	$('#tag_current_cost1').html(month[bulan-1]);
	$('#tag_current_cost2').html(month[bulan-1]);
	$('#tag_current_cost3').html(month[bulan-1]);
	$('#tag_current_cost4').html(month[bulan-1]);
	$('#tag_current_cost5').html(month[bulan-1]);
	$('#tag_current_cost6').html(month[bulan-1]);
	$('#tag_current_cost7').html(month[bulan-1]);
	$('#tag_current_cost8').html(month[bulan-1]);

	$('#tag_last_cost').html(month[bulan-2]);
	$('#tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);
	
		var dataJson ;
		$.post(url_src+'par4digma/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+param, function(data){
		try{
			dataJson = JSON.parse(data);
		}catch(e){
			console.log('data error');
		}
		
		console.log(dataJson);
		$.each(dataJson.selling_marketing["0"].bulan_ini, function(i, result){
			console.log(i+"");
			label.push(i);
			var value = Number(dataJson.selling_marketing["0"].bulan_ini[i])/1000000;
			now.push(Math.round(value));
		})
		$.each(dataJson.selling_marketing["0"].up_bulan_ini, function(i, result){

			var value = Number(dataJson.selling_marketing["0"].up_bulan_ini[i])/1000000;
			
			last.push(Math.round(value));
		})


// sales now
		var sell_dam_now = Number(dataJson.selling_marketing["0"].bulan_ini["Depl. Deprec. and Amortization"]);
				var sell_elc_now = Number(dataJson.selling_marketing["0"].bulan_ini.Electricity);
				var sell_fuel_now = Number(dataJson.selling_marketing["0"].bulan_ini.Fuel);
				var sell_gm_now = Number(dataJson.selling_marketing["0"].bulan_ini["General & Adminitration"]);
				var sell_labor_now = Number(dataJson.selling_marketing["0"].bulan_ini.Labor);
				var sell_main_now = Number(dataJson.selling_marketing["0"].bulan_ini.Maintenance);
				var sell_sm_now = Number(dataJson.selling_marketing["0"].bulan_ini["Supporting Material"]);
				var sell_tax_now = Number(dataJson.selling_marketing["0"].bulan_ini["Taxes and insurance"]);
				var tot_sell_nw = (sell_dam_now+sell_elc_now+sell_fuel_now+sell_gm_now+sell_labor_now+sell_main_now+sell_sm_now+sell_tax_now);

// sales PAST
		var sell_dam_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["Depl. Deprec. and Amortization"]);
		var sell_elc_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Electricity);
		var sell_fuel_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Fuel);
		var sell_gm_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["General & Adminitration"]);
		var sell_labor_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Labor);
		var sell_main_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Maintenance);
		var sell_sm_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["Supporting Material"]);
		var sell_tax_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["Taxes and insurance"]);
		var tot_sell_pst = (sell_dam_past+sell_elc_past+sell_fuel_past+sell_gm_past+sell_labor_past+sell_main_past+sell_sm_past+sell_tax_past);
console.log('Nilai = '+tot_sell_pst);
console.log(typeof(tot_sell_nw));
		$('#sell_dam_now').html(setFormat(sell_dam_now, 0));
		$('#sell_elc_now').html(setFormat(sell_elc_now, 0));
		$('#sell_fuel_now').html(setFormat(sell_fuel_now, 0));
		$('#sell_gm_now').html(setFormat(sell_gm_now, 0));
		$('#sell_labor_now').html(setFormat(sell_labor_now, 0));
		$('#sell_main_now').html(setFormat(sell_main_now, 0));
		$('#sell_sm_now').html(setFormat(sell_sm_now, 0));
		$('#sell_tax_now').html(setFormat(sell_tax_now, 0));
		
		var tot_sell_nwx = Number(tot_sell_nw);
		$('#tot_sell_nwu').html(setFormat(tot_sell_nw, 0));
		$('#tot_sell_nw').html(setFormat(tot_sell_nw, 0));
		// console.log('mentah '+tot_pcost_nwx);

		$('#sell_dam_past').html(setFormat(sell_dam_past, 0));
		$('#sell_elc_past').html(setFormat(sell_elc_past, 0));
		$('#sell_fuel_past').html(setFormat(sell_fuel_past, 0));
		$('#sell_gm_past').html(setFormat(sell_gm_past, 0));
		$('#sell_labor_past').html(setFormat(sell_labor_past, 0));
		$('#sell_main_past').html(setFormat(sell_main_past, 0));
		$('#sell_sm_past').html(setFormat(sell_sm_past, 0));
		$('#sell_tax_past').html(setFormat(sell_tax_past, 0));
		
		var tot_sell_pstx = Number(tot_sell_pst);
		$('#tot_sell_pstu').html(setFormat(tot_sell_pstx, 0));
		$('#tot_sell_pst').html(setFormat(tot_sell_pstx, 0));

	graphicChart(now, last, label, '350');

stop_waitMe('.wrapper');

	
	});
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

function nextPage(opco, bulan, tahun, url){
	//alert(opco+' '+bulan+' '+tahun+' '+url);
  sessionStorage.setItem('cost-bln', bulan);
  sessionStorage.setItem('cost-opco', opco);

  window.location.href = url+".html";
}

function graphicChart(now, last, label, hei){
	  Highcharts.chart('graphc', {
        chart: {
          backgroundColor: 'rgba(0, 255, 0, 0)',
          type: 'bar',
          height: hei
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: label,
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
            name: 'This Month',
            color: '#fed700',
            data: now
        }, {
            name: 'Up to',
            color: '#807d6e',
            data: last
        }]
    });
}

function graphicChart_opco(label, data){
	  Highcharts.chart('PlantCompare', {
        chart: {
          backgroundColor: 'rgba(0, 255, 0, 0)',
          type: 'bar',
          // height: 300,
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['G.ADM', 'COGS', 'COGM', 'Sell.MRT'],
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
            name: 'SP',
            color: '#1E8BC3',
            data: data['3000']
        }, {
            name: 'SG',
            color: '#E9D460',
            data: data['7000']
        }, {
            name: 'ST',
            color: '#EF4836',
            data: data['4000']
        },
        // , {
        //     name: label[3],
        //     color: '#807d6e',
        //     data: data4
        // }
        ]
    });

	console.log('graphic has loaded');
}

var genrl = [];
var good = [];
var prod = [];
var selling = [];

var data = [];

function opcoGroup (yearnow, bulan){
	genrl = [12,12,12];
	good = [12,12,12];
	prod = [12,12,12];
	selling = [12,12,12];

	data['3000'] = [];
	data['7000'] = [];
	data['4000'] = [];
	var total = 0;
	var urlsmi = url_src+'par4digma/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+'&company=smi';
	var url3000 = url_src+'par4digma/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+'&company=3000';
	var url4000 = url_src+'par4digma/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+'&company=4000';
	var url7000 = url_src+'par4digma/api/index.php/cost_report/get_data?date='+yearnow+'.'+bulan+'&company=7000';
	var opco = [];
	// alert('haha');
	var label = ['General Admininstration', 'Good Of Sold', 'Production Cost', 'Selling Marketing'];

	// graphicChart_opco(label, genrl, good, prod, selling);

	$.when(
	    // $.getJSON(urlsmi),
	    $.getJSON(url3000),
	    $.getJSON(url4000),
	    $.getJSON(url7000)
	    ).done(function(result3000, result4000, result7000) {
	    	genrl = [];
			good = [];
			prod = [];
			selling = [];
	    	// console.log(result4000);
	    	plotPlantCompare('3000', result3000);
	    	plotPlantCompare('7000', result7000);
	    	plotPlantCompare('4000', result4000);
	    
	    	// plotPlantCompare('3000', result3000);
	    	graphicChart_opco(label, data);
	    	console.log(genrl);
	    	console.log(good);
	    	console.log(prod);
	    	console.log(selling);

	    	
	    	
	    });

}

function plotPlantCompare(opco, dataJson){
	// var data = dataJson['s'+opco];
	var tableVal = dataJson["0"]['s'+opco]['0'].bulan_ini;
	var ga_tot = gos_tot = pc_tot = sm_tot = 0;
	console.log(tableVal);
	$.each(tableVal, function(index, el) {
		// console.log(index, el);
		$('#'+index+opco).html(setFormat(el));
	});
	

	var general_admininstration = dataJson['0'].general_admininstration['0'].bulan_ini;
	ga_tot = dataJson['0'].general_admininstration['0'].bulan_ini.Total ;//totalPlantCompare(general_admininstration);
	data[opco].push(Math.round(ga_tot/1000000));

	var good_of_sold = dataJson['0'].good_of_sold['0'].bulan_ini;
	gos_tot = dataJson['0'].good_of_sold['0'].bulan_ini.Total;//totalPlantCompare(good_of_sold);
	data[opco].push(Math.round(gos_tot/1000000));


	var production_cost = dataJson['0'].production_cost['0'].bulan_ini;
	pc_tot = dataJson['0'].production_cost['0'].bulan_ini.Total;//totalPlantCompare(production_cost);
	data[opco].push(Math.round(pc_tot/1000000));

	var selling_marketing = dataJson['0'].selling_marketing['0'].bulan_ini;
	sm_tot = dataJson['0'].selling_marketing['0'].bulan_ini.Total;totalPlantCompare(selling_marketing);
	data[opco].push(Math.round(sm_tot/1000000));
}

function totalPlantCompare(dataJson){
	var tempTotal = 0;
	$.each(dataJson, function(index, el) {
		tempTotal += Number(el);
		// console.log(index, el);
	});
	return tempTotal;
}