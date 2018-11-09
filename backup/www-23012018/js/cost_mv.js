	var label = [];
	var now = [];
	var last = [];
	var hei = '';
	// var clin_now = '';
	// var cmnt_now = '';
	// var salevol_now = '';

	// var clin_past = '';
	// var cmnt_past = '';
	// var salevol_past = '';
function cost_data(bulan, opco, yearnow){
	run_waitMe('.wrapper', 'ios');
                var d = new Date();
                var month = new Array();
                month[0] = "January";
                month[1] = "February";
                month[2] = "March";
                month[3] = "April";
                month[4] = "May";
                month[5] = "June";
                month[6] = "July";
                month[7] = "August";
                month[8] = "September";
                month[9] = "October";
                month[10] = "November";
                month[11] = "December";

    $('#tag_ly1').html('Real '+(yearnow-1));
                    $('#tag_ly2').html('Real '+(yearnow-1));
                    $('#tag_ly3').html('Real '+(yearnow-1));
                    $('#tag_ly4').html('Real '+(yearnow-1));
                    $('#tag_ly5').html('Real '+(yearnow-1));
                    $('#tag_ly6').html('Real '+(yearnow-1));
                    $('#tag_ly7').html('Real '+(yearnow-1));
                    $('#tag_ly8').html('Real '+(yearnow-1));
                    $('#tag_ly9').html('Real '+(yearnow-1));
                    $('#tag_ly10').html('Real '+(yearnow-1));
                    $('#tag_ly11').html('Real '+(yearnow-1));
                    $('#tag_ly12').html('Real '+(yearnow-1));
                    $('#tag_ly13').html('Real '+(yearnow-1));
                    $('#tag_ly14').html('Real '+(yearnow-1));
                    $('#tag_ly15').html('Real '+(yearnow-1));
                    $('#tag_ly16').html('Real '+(yearnow-1));
                    
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

	$('#tag_last_cost').html('Up to '+month[bulan-1]);
	$('#tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);

	$('#ton_tag_current_cost').html(month[bulan-1]);
	$('#ton_tag_current_cost1').html(month[bulan-1]);
	$('#ton_tag_current_cost2').html(month[bulan-1]);
	$('#ton_tag_current_cost3').html(month[bulan-1]);
	$('#ton_tag_current_cost4').html(month[bulan-1]);
	$('#ton_tag_current_cost5').html(month[bulan-1]);
	$('#ton_tag_current_cost6').html(month[bulan-1]);
	$('#ton_tag_current_cost7').html(month[bulan-1]);
	$('#ton_tag_current_cost8').html(month[bulan-1]);

	$('#ton_tag_last_cost').html('Up to '+month[bulan-1]);
	$('#ton_tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#ton_tag_chart_curr').html(month[bulan-1]);
	$('#ton_tag_chart_past').html(month[bulan-2]);

	// $.post(url_src+'/api/index.php/Project', function(data){
	// $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){

	// console.log('chandra : '+url_src+'/api/index.php/cost_structure/get_data_mview?date='+yearnow+'.'+bulan+param);
	 $.post(url_src+'/api/index.php/cost_structure/get_data_mview?date='+yearnow+'.'+bulan+param, function(data){
	// $.post(url_src+'/api/cost_structure.php?date='+yearnow+'.'+bulan+param, function(data){
			// var data1 = data.replace("<title>Json</title>", "");
		  	// var data2 = data.replace("(", "[");
		  	//   var data3 = data2.replace(");", "]");

				// var dataJson  = JSON.parse(data);
				// var dataJson = eval('(' + data + ')');
			// 	try{
			// dataJson = JSON.parse(data);
			// }catch(e){
			// 	console.log('data error');
			// 	stop_waitMe('.wrapper');
			// 	alert('Sorry, data is empty, please choose another month');
			// }
			// 	var dataJson = JSON.parse(data);
			// console.log(data);
				var dataJson = paradigma.json_parse(data, '.wrapper');
		            // var myData = dataJson.Terak;
				console.log(dataJson);
				//console.log(opco);


			// ############## NOW
				 var clin_now = Number(dataJson['s'+opco]["0"].bulan_ini.clinker);
				 var cmnt_now = Number(dataJson['s'+opco]["0"].bulan_ini.cement);
				 var salevol_now = Number(dataJson['s'+opco]["0"].bulan_ini.sales);

				 var ton_clin_now = Number(dataJson['s'+opco]["0"].bulan_ini.clinker);
				 var ton_cmnt_now = Number(dataJson['s'+opco]["0"].bulan_ini.cement);
				 var ton_salevol_now = Number(dataJson['s'+opco]["0"].bulan_ini.sales);

				 var ton_rkap_clin_now = Number(dataJson['s'+opco]["0"].rkap_bulan_ini.clinker);
				 var ton_rkap_cmnt_now = Number(dataJson['s'+opco]["0"].rkap_bulan_ini.cement);
				 var ton_rkap_salevol_now = Number(dataJson['s'+opco]["0"].rkap_bulan_ini.sales);
			// production_cost
				var pcost_rw_now = Number(dataJson.production_cost["0"].bulan_ini["Raw Material"]);
				var pcost_sm_now = Number(dataJson.production_cost["0"].bulan_ini["Supporting Material"]);
				var pcost_f_now = Number(dataJson.production_cost["0"].bulan_ini.Fuel);
				var pcost_amor_now = Number(dataJson.production_cost["0"].bulan_ini["Depl. Deprec. and Amortization"]);
				var pcost_elc_now = Number(dataJson.production_cost["0"].bulan_ini.Electricity);
				var pcost_gadm_now = Number(dataJson.production_cost["0"].bulan_ini["General & Administration"]);
				var pcost_lab_now = Number(dataJson.production_cost["0"].bulan_ini.Labor);
				var pcost_main_now = Number(dataJson.production_cost["0"].bulan_ini.Maintenance);
				var pcost_tax_now = Number(dataJson.production_cost["0"].bulan_ini["Taxes and Insurance"]);
				var tot_pcost_nw = (pcost_rw_now+pcost_sm_now+pcost_f_now+pcost_amor_now+pcost_elc_now+pcost_gadm_now+pcost_lab_now+pcost_main_now+pcost_tax_now)/1000000;
				var ton_tot_pcost_nw = tot_pcost_nw/ton_cmnt_now;
			// cogs
				var cogs_dist_now = Number(dataJson.good_of_sold["0"].bulan_ini.Distribution);
				var cogs_pack_now = Number(dataJson.good_of_sold["0"].bulan_ini.Packaging);
				var cogs_vs_now = Number(dataJson.good_of_sold["0"].bulan_ini["Variance Stok"]);
				var cogs_wip_now = Number(dataJson.good_of_sold["0"].bulan_ini["WIP (Purchasing)"]);
				var tot_cogs_nw = (cogs_dist_now+cogs_pack_now+cogs_vs_now+cogs_wip_now)/1000000;
				var ton_tot_cogs_nw = (tot_cogs_nw/ton_salevol_now)/10;
			// General Adminitration
				var gen_dam_now = Number(dataJson.general_administration["0"].bulan_ini["Depl. Deprec. and Amortization"]);
				var gen_el_now = Number(dataJson.general_administration["0"].bulan_ini.Electricity);
				var gen_fuel_now = Number(dataJson.general_administration["0"].bulan_ini.Fuel);
				var gen_gm_now = Number(dataJson.general_administration["0"].bulan_ini["General & Administration"]);
				var gen_labor_now = Number(dataJson.general_administration["0"].bulan_ini.Labor);
				var gen_mainte_now = Number(dataJson.general_administration["0"].bulan_ini.Maintenance);
				var gen_support_now = Number(dataJson.general_administration["0"].bulan_ini["Supporting Material"]);
				var gen_tax_now = Number(dataJson.general_administration["0"].bulan_ini["Taxes and insurance"]);
				var tot_gen_nw = (gen_dam_now+gen_el_now+gen_fuel_now+gen_gm_now+gen_labor_now+gen_mainte_now+gen_support_now+gen_tax_now)/1000000;
				var ton_tot_gen_nw = tot_gen_nw/ton_salevol_now;
			// Selling Marketing
				var sell_dam_now = Number(dataJson.selling_marketing["0"].bulan_ini["Depl. Deprec. and Amortization"]);
				var sell_elc_now = Number(dataJson.selling_marketing["0"].bulan_ini.Electricity);
				var sell_fuel_now = Number(dataJson.selling_marketing["0"].bulan_ini.Fuel);
				var sell_gm_now = Number(dataJson.selling_marketing["0"].bulan_ini["General & Administration"]);
				var sell_labor_now = Number(dataJson.selling_marketing["0"].bulan_ini.Labor);
				var sell_main_now = Number(dataJson.selling_marketing["0"].bulan_ini.Maintenance);
				var sell_sm_now = Number(dataJson.selling_marketing["0"].bulan_ini["Supporting Material"]);
				var sell_tax_now = Number(dataJson.selling_marketing["0"].bulan_ini["Taxes and insurance"]);
				var tot_sell_nw = (sell_dam_now+sell_elc_now+sell_fuel_now+sell_gm_now+sell_labor_now+sell_main_now+sell_sm_now+sell_tax_now)/1000000;
				var ton_tot_sell_nw = tot_sell_nw/ton_salevol_now;


				// console.log('raw mtr'+rw_now);
				// console.log('sup mtr'+sm_now);
				// console.log('fuel'+f_now);
			// ############## PAST
				var clin_past = Number(dataJson['s'+opco]["0"].bulan_lalu.clinker);
				var cmnt_past = Number(dataJson['s'+opco]["0"].bulan_lalu.cement);
				var salevol_past = Number(dataJson['s'+opco]["0"].bulan_lalu.sales);

				var ton_clin_past = Number(dataJson['s'+opco]["0"].bulan_lalu.clinker);
				var ton_cmnt_past = Number(dataJson['s'+opco]["0"].bulan_lalu.cement);
				var ton_salevol_past = Number(dataJson['s'+opco]["0"].bulan_lalu.sales);	

				var ton_rkap_clin_past = Number(dataJson['s'+opco]["0"].rkap_bulan_lalu.clinker);
				var ton_rkap_cmnt_past = Number(dataJson['s'+opco]["0"].rkap_bulan_lalu.cement);
				var ton_rkap_salevol_past = Number(dataJson['s'+opco]["0"].rkap_bulan_lalu.sales);	
// #################
				var pcost_rw_past = Number(dataJson.production_cost["0"].up_bulan_ini["Raw Material"]);
				var pcost_sm_past = Number(dataJson.production_cost["0"].up_bulan_ini["Supporting Material"]);
				var pcost_f_past = Number(dataJson.production_cost["0"].up_bulan_ini.Fuel);
				var pcost_amor_past = Number(dataJson.production_cost["0"].up_bulan_ini["Depl. Deprec. and Amortization"]);
				var pcost_elc_past = Number(dataJson.production_cost["0"].up_bulan_ini.Electricity);
				var pcost_gadm_past = Number(dataJson.production_cost["0"].up_bulan_ini["General & Administration"]);
				var pcost_lab_past = Number(dataJson.production_cost["0"].up_bulan_ini.Labor);
				var pcost_main_past = Number(dataJson.production_cost["0"].up_bulan_ini.Maintenance);
				var pcost_tax_past = Number(dataJson.production_cost["0"].up_bulan_ini["Taxes and Insurance"]);
				var tot_pcost_pst = (pcost_rw_past+pcost_sm_past+pcost_f_past+pcost_amor_past+pcost_elc_past+pcost_gadm_past+pcost_lab_past+pcost_main_past+pcost_tax_past)/1000000000;
				var ton_tot_pcost_pst = (tot_pcost_pst/ton_cmnt_past);
		// cogs
				var cogs_dist_past = Number(dataJson.good_of_sold["0"].up_bulan_ini.Distribution);
				var cogs_pack_past = Number(dataJson.good_of_sold["0"].up_bulan_ini.Packaging);
				var cogs_vs_past = Number(dataJson.good_of_sold["0"].up_bulan_ini["Variance Stok"]);
				var cogs_wip_past = Number(dataJson.good_of_sold["0"].up_bulan_ini["WIP (Purchasing)"]);
				var tot_cogs_pst = (cogs_dist_past+cogs_pack_past+cogs_vs_past+cogs_wip_past)/1000000000;
				var ton_tot_cogs_pst = (tot_cogs_pst/ton_salevol_past)/10;

			// General Adminitration
				var gen_dam_past = Number(dataJson.general_administration["0"].up_bulan_ini["Depl. Deprec. and Amortization"]);
				var gen_el_past = Number(dataJson.general_administration["0"].up_bulan_ini.Electricity);
				var gen_fuel_past = Number(dataJson.general_administration["0"].up_bulan_ini.Fuel);
				var gen_gm_past = Number(dataJson.general_administration["0"].up_bulan_ini["General & Administration"]);
				var gen_labor_past = Number(dataJson.general_administration["0"].up_bulan_ini.Labor);
				var gen_mainte_past = Number(dataJson.general_administration["0"].up_bulan_ini.Maintenance);
				var gen_support_past = Number(dataJson.general_administration["0"].up_bulan_ini["Supporting Material"]);
				var gen_tax_past = Number(dataJson.general_administration["0"].up_bulan_ini["Taxes and insurance"]);
				var tot_gen_pst = (gen_dam_past+gen_el_past+gen_fuel_past+gen_gm_past+gen_labor_past+gen_mainte_past+gen_support_past+gen_tax_past)/1000000000;
				var ton_tot_gen_pst = tot_gen_pst/ton_salevol_past;
			// Selling Marketing
				var sell_dam_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["Depl. Deprec. and Amortization"]);
				var sell_elc_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Electricity);
				var sell_fuel_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Fuel);
				var sell_gm_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["General & Administration"]);
				var sell_labor_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Labor);
				var sell_main_past = Number(dataJson.selling_marketing["0"].up_bulan_ini.Maintenance);
				var sell_sm_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["Supporting Material"]);
				var sell_tax_past = Number(dataJson.selling_marketing["0"].up_bulan_ini["Taxes and insurance"]);
				var tot_sell_pst = (sell_dam_past+sell_elc_past+sell_fuel_past+sell_gm_past+sell_labor_past+sell_main_past+sell_sm_past+sell_tax_past)/1000000000;
				var ton_tot_sell_pst = tot_sell_pst/ton_salevol_past;
// TOTAL #################################################################################################################
				var rkap_current_prod = Number(dataJson.production_cost["0"].rkap_bulan_ini.Total)/1000000000;
				var real_current_prod = Number(dataJson.production_cost["0"].bulan_ini.Total)/1000000000;
				var real_lyear_prod = Number(dataJson.production_cost["0"].bulan_ini_lyear.Total)/1000000000;
				var yoy_current = parseFloat(dataJson.production_cost["0"].bulan_ini.Yoy).toFixed(2);
				var perc_current_prod = parseFloat(dataJson.production_cost["0"].bulan_ini.Percent).toFixed(2);
				var ton_real_current_prod = (real_current_prod/ton_cmnt_now)*1000000;
				var ton_rkap_current_prod = (rkap_current_prod/ton_rkap_cmnt_now)*1000000;
				console.log(rkap_current_prod+'/'+ton_cmnt_now);
			// cogs

				//console.log("yoy cur : "+yoy_current);

				var rkap_up_prod = Number(dataJson.production_cost["0"].rkap_up_bulan_ini.Total)/1000000000;
				var real_up_prod = Number(dataJson.production_cost["0"].up_bulan_ini.Total)/1000000000;
				var real_up_lyear_prod = Number(dataJson.production_cost["0"].up_bulan_ini_lyear.Total)/1000000000;
				var yoy_up = parseFloat(dataJson.production_cost["0"].up_bulan_ini.Yoy).toFixed(2);
				var perc_up_prod = parseFloat(dataJson.production_cost["0"].up_bulan_ini.Percent).toFixed(2);
				var ton_real_up_prod = (real_up_prod/ton_cmnt_past)*1000000;
				var ton_rkap_up_prod = (rkap_up_prod/ton_rkap_cmnt_past)*1000000;
				//console.log("yoy up : "+yoy_up);
				//console.log(typeof(yoy_up))


				var perc1b = (real_up_prod/rkap_up_prod)*100;
				var perc1a = (real_current_prod/rkap_current_prod)*100;
				var ton_perc1b = (ton_real_up_prod/ton_rkap_up_prod)*100;
				var ton_perc1a = (ton_real_current_prod/ton_rkap_current_prod)*100;

				console.log("prosen prog"+ton_perc1a)
// COGS #################################################################################################################
				var rkap_current_cogs = Number(dataJson.good_of_sold["0"].rkap_bulan_ini.Total)/1000000000;
				var real_current_cogs = Number(dataJson.good_of_sold["0"].bulan_ini.Total)/1000000000;
				var real_lyear_cogs = Number(dataJson.good_of_sold["0"].bulan_ini_lyear.Total)/1000000000;
				var yoy_current_cogs = parseFloat(dataJson.good_of_sold["0"].bulan_ini.Yoy).toFixed(2);
				var perc_current_cogs = parseFloat(dataJson.good_of_sold["0"].bulan_ini.Percent).toFixed(2);
				var ton_real_current_cogs = (real_current_cogs/(ton_salevol_now/10))*1000000;
				var ton_rkap_current_cogs = (rkap_current_cogs/(ton_rkap_salevol_now/10))*1000000;
				//console.log("yoy cur : "+yoy_current);

				var rkap_up_cogs = Number(dataJson.good_of_sold["0"].rkap_up_bulan_ini.Total)/1000000000;
				var real_up_cogs = Number(dataJson.good_of_sold["0"].up_bulan_ini.Total)/1000000000;
				var real_up_lyear_cogs = Number(dataJson.good_of_sold["0"].up_bulan_ini_lyear.Total)/1000000000;
				var yoy_up_cogs = parseFloat(dataJson.good_of_sold["0"].up_bulan_ini.Yoy).toFixed(2);
				var perc_up_cogs = parseFloat(dataJson.good_of_sold["0"].up_bulan_ini.Percent).toFixed(2);
				var ton_real_up_cogs = (real_up_cogs/(ton_salevol_past/10))*1000000;
				var ton_rkap_up_cogs = (rkap_up_cogs/(ton_rkap_salevol_past/10))*1000000;
				//console.log("yoy up : "+yoy_up);
				//console.log(typeof(yoy_up))


				var perc2b = (real_up_cogs/rkap_up_cogs)*100;
				var perc2a = (real_current_cogs/rkap_current_cogs)*100;
				var ton_perc2b = (ton_real_up_cogs/ton_rkap_up_cogs)*100;
				var ton_perc2a = (ton_real_current_cogs/ton_rkap_current_cogs)*100;

// General #################################################################################################################
				var rkap_current_gnrl = Number(dataJson.general_administration["0"].rkap_bulan_ini.Total)/1000000000;
				var real_current_gnrl = Number(dataJson.general_administration["0"].bulan_ini.Total)/1000000000;
				var real_lyear_gnrl = Number(dataJson.general_administration["0"].bulan_ini_lyear.Total)/1000000000;
				var yoy_current_gnrl = parseFloat(dataJson.general_administration["0"].bulan_ini.Yoy).toFixed(2);
				var perc_current_gnrl = parseFloat(dataJson.general_administration["0"].bulan_ini.Percent).toFixed(2);
				var ton_real_current_gnrl = (real_current_gnrl/ton_salevol_now)*1000000;
				var ton_rkap_current_gnrl = (rkap_current_gnrl/ton_rkap_salevol_now)*1000000;
				//console.log("yoy cur : "+yoy_current);

				var rkap_up_gnrl = Number(dataJson.general_administration["0"].rkap_up_bulan_ini.Total)/1000000000;
				var real_up_gnrl = Number(dataJson.general_administration["0"].up_bulan_ini.Total)/1000000000;
				var real_up_lyear_gnrl = Number(dataJson.general_administration["0"].up_bulan_ini_lyear.Total)/1000000000;
				var yoy_up_gnrl = parseFloat(dataJson.general_administration["0"].up_bulan_ini.Yoy).toFixed(2);
				var perc_up_gnrl = parseFloat(dataJson.general_administration["0"].up_bulan_ini.Percent).toFixed(2);
				var ton_real_up_gnrl = (real_up_gnrl/ton_salevol_past)*1000000;
				var ton_rkap_up_gnrl = (rkap_up_gnrl/ton_rkap_salevol_past)*1000000;
				//console.log("yoy up : "+yoy_up);
				//console.log(typeof(yoy_up))


				var perc3b = (real_up_gnrl/rkap_up_gnrl)*100;
				var perc3a = (real_current_gnrl/rkap_current_gnrl)*100;
				var ton_perc3b = (ton_real_up_gnrl/ton_rkap_up_gnrl)*100;
				var ton_perc3a = (ton_real_current_gnrl/ton_rkap_current_gnrl)*100;

// Sale Market #################################################################################################################
				var rkap_current_sale = Number(dataJson.selling_marketing["0"].rkap_bulan_ini.Total)/1000000000;
				var real_current_sale = Number(dataJson.selling_marketing["0"].bulan_ini.Total)/1000000000;
				var real_lyear_sale = Number(dataJson.selling_marketing["0"].bulan_ini_lyear.Total)/1000000000;
				var yoy_current_sale = parseFloat(dataJson.selling_marketing["0"].bulan_ini.Yoy).toFixed(2);
				var perc_current_sale = parseFloat(dataJson.selling_marketing["0"].bulan_ini.Percent).toFixed(2);
				var ton_real_current_sale = (real_current_sale/ton_salevol_now)*1000000;
				var ton_rkap_current_sale = (rkap_current_sale/ton_rkap_salevol_now)*1000000;
				//console.log("yoy cur : "+yoy_current);

				var rkap_up_sale = Number(dataJson.selling_marketing["0"].rkap_up_bulan_ini.Total)/1000000000;
				var real_up_sale = Number(dataJson.selling_marketing["0"].up_bulan_ini.Total)/1000000000;
				var real_up_lyear_sale = Number(dataJson.selling_marketing["0"].up_bulan_ini_lyear.Total)/1000000000;
				var yoy_up_sale = parseFloat(dataJson.selling_marketing["0"].up_bulan_ini.Yoy).toFixed(2);
				var perc_up_sale = parseFloat(dataJson.selling_marketing["0"].up_bulan_ini.Percent).toFixed(2);
				var ton_real_up_sale = (real_up_sale/ton_salevol_past)*1000000;
				var ton_rkap_up_sale = (rkap_up_sale/ton_rkap_salevol_past)*1000000;
				//console.log("yoy up : "+yoy_up);
				//console.log(typeof(yoy_up))


				var perc4b = (real_up_sale/rkap_up_sale)*100;
				var perc4a = (real_current_sale/rkap_current_sale)*100;
				var ton_perc4b = (ton_real_up_sale/ton_rkap_up_sale)*100;
				var ton_perc4a = (ton_real_current_sale/ton_rkap_current_sale)*100;


		//LAST YEAR
		//========================================================================================================
				// 
				//COGM
				//
			// ############## NOW
				
				 var clin_lyear = Number(dataJson['s'+opco]["0"].bulan_ini_lyear.clinker);
				 var cmnt_lyear = Number(dataJson['s'+opco]["0"].bulan_ini_lyear.cement);
				 var salevol_lyear = Number(dataJson['s'+opco]["0"].bulan_ini_lyear.sales);

				 console.log("last year =>"+clin_lyear+'-'+cmnt_lyear+'-'+salevol_lyear);

				 var ton_clin_lyear = Number(dataJson['s'+opco]["0"].bulan_ini_lyear.clinker);
				 var ton_cmnt_lyear = Number(dataJson['s'+opco]["0"].bulan_ini_lyear.cement);
				 var ton_salevol_lyear = Number(dataJson['s'+opco]["0"].bulan_ini_lyear.sales);

				 var ton_rkap_clin_lyear = Number(dataJson['s'+opco]["0"].rkap_bulan_ini_lyear.clinker);
				 var ton_rkap_cmnt_lyear = Number(dataJson['s'+opco]["0"].rkap_bulan_ini_lyear.cement);
				 var ton_rkap_salevol_lyear = Number(dataJson['s'+opco]["0"].rkap_bulan_ini_lyear.sales);
			// production_cost
				
				var tot_pcost_lyear = Number(dataJson.production_cost['0'].bulan_ini_lyear.Total)/1000000000;
				var ton_tot_pcost_lyear = tot_pcost_lyear/ton_cmnt_lyear*1000000;
			// cogs
				var tot_cogs_lyear = Number(dataJson.good_of_sold["0"].bulan_ini_lyear.Total)/1000000000;
				var ton_tot_cogs_lyear = ((tot_cogs_lyear/ton_salevol_lyear)/10)*1000000;
			// General Adminitration

				var tot_gen_lyear = Number(dataJson.general_administration["0"].bulan_ini_lyear.Total)/1000000000;
				var ton_tot_gen_lyear = tot_gen_lyear/ton_salevol_lyear*1000000;
			// Selling Marketing

				var tot_sell_lyear = Number(dataJson.selling_marketing["0"].bulan_ini_lyear.Total)/1000000000;
				var ton_tot_sell_lyear = tot_sell_lyear/ton_salevol_lyear*1000000;






				// console.log('raw mtr'+rw_now);
				// console.log('sup mtr'+sm_now);
				// console.log('fuel'+f_now);
			// ############## PAST
				var clin_past_lyear = Number(dataJson['s'+opco]["0"].bulan_lalu_lyear.clinker);
				var cmnt_past_lyear = Number(dataJson['s'+opco]["0"].bulan_lalu_lyear.cement);
				var salevol_past_lyear = Number(dataJson['s'+opco]["0"].bulan_lalu_lyear.sales);

				var ton_clin_past_lyear = Number(dataJson['s'+opco]["0"].bulan_lalu_lyear.clinker);
				var ton_cmnt_past_lyear = Number(dataJson['s'+opco]["0"].bulan_lalu_lyear.cement);
				var ton_salevol_past_lyear = Number(dataJson['s'+opco]["0"].bulan_lalu_lyear.sales);	

				var ton_rkap_clin_past_lyear = Number(dataJson['s'+opco]["0"].rkap_bulan_lalu_lyear.clinker);
				var ton_rkap_cmnt_past_lyear = Number(dataJson['s'+opco]["0"].rkap_bulan_lalu_lyear.cement);
				var ton_rkap_salevol_past_lyear = Number(dataJson['s'+opco]["0"].rkap_bulan_lalu_lyear.sales);	
			// production_cost
				
				var tot_pcost_pst_lyear = Number(dataJson.production_cost['0'].up_bulan_ini_lyear.Total)/1000000000;
				var ton_tot_pcost_pst_lyear = tot_pcost_pst_lyear/ton_cmnt_past_lyear*1000000;
			// cogs
				var tot_cogs_pst_lyear = Number(dataJson.good_of_sold["0"].up_bulan_ini_lyear.Total)/1000000000;
				var ton_tot_cogs_pst_lyear = ((tot_cogs_pst_lyear/ton_salevol_past_lyear)/10)*1000000;
			// General Adminitration

				var tot_gen_pst_lyear = Number(dataJson.general_administration["0"].up_bulan_ini_lyear.Total)/1000000000;
				var ton_tot_gen_pst_lyear = tot_gen_pst_lyear/ton_salevol_past_lyear*1000000;
			// Selling Marketing

				var tot_sell_pst_lyear = Number(dataJson.selling_marketing["0"].up_bulan_ini_lyear.Total)/1000000000;
				var ton_tot_sell_pst_lyear = tot_sell_pst_lyear/ton_salevol_past_lyear*1000000;


				var ton_yoy_current = setFormat(division((ton_real_current_prod - ton_tot_pcost_lyear), ton_tot_pcost_lyear)*100, 1);
				var ton_yoy_up = setFormat(division((ton_real_up_prod - ton_tot_pcost_pst_lyear), ton_tot_pcost_pst_lyear)*100, 1);

				var ton_yoy_current_cogs = setFormat(division((ton_real_current_cogs - ton_tot_cogs_lyear), ton_tot_cogs_lyear), 1);
				var ton_yoy_up_cogs = setFormat(division((ton_real_up_cogs - ton_tot_cogs_pst_lyear), ton_tot_cogs_pst_lyear), 1);
				// var ton_yoy_current_cogs = 0;
				// var ton_yoy_up_cogs = 0;
				console.log(ton_yoy_up_cogs+'='+ton_real_up_cogs+'/'+ton_tot_cogs_pst_lyear);

				var ton_yoy_current_gnrl = setFormat(division((ton_real_current_gnrl - ton_tot_gen_lyear), ton_tot_gen_lyear)*100, 1);
				var ton_yoy_up_gnrl = setFormat(division((ton_real_up_gnrl - ton_tot_gen_pst_lyear), ton_tot_gen_pst_lyear)*100, 1);

				var ton_yoy_current_sale = setFormat(division((ton_real_current_sale - ton_tot_sell_lyear), ton_tot_sell_lyear)*100, 1);
				var ton_yoy_up_sale = setFormat(division((ton_real_up_sale - ton_tot_sell_pst_lyear), ton_tot_sell_pst_lyear)*100, 1);



// TOTAL #################################################################################################################
				$('#perc1a').html(setFormat(perc_current_prod, 1));
				$('#rkap_current_prod').html(setFormat(rkap_current_prod, 1));
				$('#real_lyear_prod').html(setFormat(real_lyear_prod, 1));
				$('#yoy_current_p').html(yoy_current);

				$('#perc1b').html(setFormat(perc_up_prod, 1));
				$('#rkap_up_prod').html(setFormat(rkap_up_prod, 1));
				$('#real_up_lyear_prod').html(setFormat(real_up_lyear_prod, 1));
				$('#yoy_up_p').html(yoy_up);

				$('#ton_perc1a').html(setFormat(ton_perc1a, 1));
				$('#ton_rkap_current_prod').html(setFormat(ton_rkap_current_prod, 1));
				$('#ton_real_lyear_prod').html(setFormat(ton_tot_pcost_lyear*1000, 1));
				$('#ton_yoy_current_p').html(ton_yoy_current);

				$('#ton_perc1b').html(setFormat(ton_perc1b, 1));
				$('#ton_rkap_up_prod').html(setFormat(ton_rkap_up_prod, 1));
				$('#ton_real_up_lyear_prod').html(setFormat(ton_tot_pcost_pst_lyear*1000, 1));
				$('#ton_yoy_up_p').html(ton_yoy_up);

// Cogs #################################################################################################################
				$('#perc2a').html(setFormat(perc_current_cogs, 1));
				$('#rkap_current_cogs').html(setFormat(rkap_current_cogs, 1));
				$('#real_lyear_cogs').html(setFormat(real_lyear_cogs, 1));
				$('#yoy_current_cogs').html(yoy_current_cogs);

				$('#perc2b').html(setFormat(perc_up_cogs, 1));
				$('#rkap_up_cogs').html(setFormat(rkap_up_cogs, 1));
				$('#real_up_lyear_cogs').html(setFormat(real_up_lyear_cogs, 1));
				$('#yoy_up_cogs').html(yoy_up_cogs);

				$('#ton_perc2a').html(setFormat(ton_perc2a, 1));
				$('#ton_rkap_current_cogs').html(setFormat(ton_rkap_current_cogs, 1));
				$('#ton_real_lyear_cogs').html(setFormat(ton_tot_cogs_lyear*1000, 1));
				$('#ton_yoy_current_cogs').html(ton_yoy_current_cogs);

				$('#ton_perc2b').html(setFormat(ton_perc2b, 1));
				$('#ton_rkap_up_cogs').html(setFormat(ton_rkap_up_cogs, 1));
				$('#ton_real_up_lyear_cogs').html(setFormat(ton_tot_cogs_pst_lyear*1000, 1));
				$('#ton_yoy_up_cogs').html(ton_yoy_up_cogs);

// gnrl #################################################################################################################
				$('#perc3a').html(setFormat(perc_current_gnrl, 1));
				$('#rkap_current_gnrl').html(setFormat(rkap_current_gnrl, 1));
				$('#real_lyear_gnrl').html(setFormat(real_lyear_gnrl, 1));
				$('#yoy_current_gnrl').html(yoy_current_gnrl);

				$('#perc3b').html(setFormat(perc_up_gnrl, 1));
				$('#rkap_up_gnrl').html(setFormat(rkap_up_gnrl, 1));
				$('#real_up_lyear_gnrl').html(setFormat(real_up_lyear_gnrl, 1));
				$('#yoy_up_gnrl').html(yoy_up_gnrl);

				$('#ton_perc3a').html(setFormat(ton_perc3a, 1));
				$('#ton_rkap_current_gnrl').html(setFormat(ton_rkap_current_gnrl, 1));
				$('#ton_real_lyear_gnrl').html(setFormat(ton_tot_gen_lyear*1000, 1));
				$('#ton_yoy_current_gnrl').html(ton_yoy_current_gnrl);

				$('#ton_perc3b').html(setFormat(ton_perc3b, 1));
				$('#ton_rkap_up_gnrl').html(setFormat(ton_rkap_up_gnrl, 1));
				$('#ton_real_up_lyear_gnrl').html(setFormat(ton_tot_gen_pst_lyear*1000, 1));
				$('#ton_yoy_up_gnrl').html(ton_yoy_up_gnrl);

// sale #################################################################################################################
				$('#perc4a').html(setFormat(perc_current_sale, 1));
				$('#rkap_current_sale').html(setFormat(rkap_current_sale, 1));
				$('#real_lyear_sale').html(setFormat(real_lyear_sale, 1));
				$('#yoy_current_sale').html(yoy_current_sale);

				$('#perc4b').html(setFormat(perc_up_sale, 1));
				$('#rkap_up_sale').html(setFormat(rkap_up_sale, 1));
				$('#real_up_lyear_sale').html(setFormat(real_up_lyear_sale, 1));
				$('#yoy_up_sale').html(yoy_up_sale);

				$('#ton_perc4a').html(setFormat(ton_perc4a, 1));
				$('#ton_rkap_current_sale').html(setFormat(ton_rkap_current_sale, 1));
				$('#ton_real_lyear_sale').html(setFormat(ton_tot_sell_lyear*1000, 1));
				$('#ton_yoy_current_sale').html(ton_yoy_current_sale);

				$('#ton_perc4b').html(setFormat(ton_perc4b, 1));
				$('#ton_rkap_up_sale').html(setFormat(ton_rkap_up_sale, 1));
				$('#ton_real_up_lyear_sale').html(setFormat(ton_tot_sell_pst_lyear*1000, 1));
				$('#ton_yoy_up_sale').html(ton_yoy_up_sale);



// DATA DEPAN ################################################################################################################

				//console.log(tot_pcost_nw);
				//console.log(tot_pcost_pst);

				$('#clin_now').html(setFormat(clin_now, 0));
				$('#cmnt_now').html(setFormat(cmnt_now, 2));
				$('#salevol_now').html(setFormat(salevol_now, 2));

				$('#clin_past').html(setFormat(clin_past, 0));
				$('#cmnt_past').html(setFormat(cmnt_past, 2));
				$('#salevol_past').html(setFormat(salevol_past, 2));


				$('#ton_clin_now').html(setFormat(clin_now, 0));
				$('#ton_cmnt_now').html(setFormat(cmnt_now, 2));
				$('#ton_salevol_now').html(setFormat(salevol_now, 2));

				$('#ton_clin_past').html(setFormat(clin_past, 0));
				$('#ton_cmnt_past').html(setFormat(cmnt_past, 2));
				$('#ton_salevol_past').html(setFormat(salevol_past, 2));
				// DETAIL
				
				$('#tot_pcost_nw').html(setFormat(real_current_prod, 2));
				$('#tot_pcost_pst').html(setFormat(real_up_prod, 2));

				$('#tot_cogs_nw').html(setFormat(real_current_cogs, 1));
				$('#tot_cogs_pst').html(setFormat(real_up_cogs, 1));

				$('#tot_gen_nw').html(setFormat(real_current_gnrl, 2));
				$('#tot_gen_pst').html(setFormat(real_up_gnrl, 2));

				$('#tot_sell_nw').html(setFormat(real_current_sale, 2));
				$('#tot_sell_pst').html(setFormat(real_up_sale, 2));


				$('#ton_tot_pcost_nw').html(setFormat(ton_real_current_prod, 3));
				$('#ton_tot_pcost_pst').html(setFormat(ton_real_up_prod, 2));

				$('#ton_tot_cogs_nw').html(setFormat(ton_real_current_cogs, 1));
				$('#ton_tot_cogs_pst').html(setFormat(ton_real_up_cogs, 1));

				$('#ton_tot_gen_nw').html(setFormat(ton_real_current_gnrl, 2));
				$('#ton_tot_gen_pst').html(setFormat(ton_real_up_gnrl, 2));

				$('#ton_tot_sell_nw').html(setFormat(ton_real_current_sale, 2));
				$('#ton_tot_sell_pst').html(setFormat(ton_real_up_sale, 2));

				//console.log(tot_pcost_nw);
				//console.log()

				

				stop_waitMe('.wrapper');
				

		
	}).fail(function() {
     //alert("Gagal konek DB");
     stop_waitMe('.wrapper');
    });

	    

}

function cost_data_detail(bulan, opco, yearnow){
  	run_waitMe('.wrapper', 'ios');
    param = '&company='+opco;

    //console.log(bulan);
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

	$('#tag_last_cost').html('Up to '+month[bulan-1]);
	$('#tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);
	// $.post(url_src+'/api/index.php/Project', function(data){
	// $.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){
		var dataJson ;
		$.post(url_src+'/api/index.php/cost_structure/get_data_mview?date='+yearnow+'.'+bulan+param, function(data){
			// $.post(url_src+'/api/cost_structure.php?date='+yearnow+'.'+bulan+param, function(data){
			// var data1 = data.replace("<title>Json</title>", "");
   //         var data2 = data.replace("(", "[");
   //          var data3 = data2.replace(");", "]");

		// var dataJson  = JSON.parse(data);
		// var dataJson = eval('(' + data + ')');
		// try{
		// 	dataJson = JSON.parse(data);
		// }catch(e){
		//console.log('data error');

		// }
		dataJson = paradigma.json_parse(data, '.wrapper');
		
		//console.log(dataJson);
		$.each(dataJson.production_cost["0"].bulan_ini, function(i, result){
			//console.log(i+"");
			label.push(i);
			var value = Number(dataJson.production_cost["0"].bulan_ini[i])/1000000;
			now.push(Math.round(value));
		})
		$.each(dataJson.production_cost["0"].bulan_ini_lyear, function(i, result){

			var value = Number(dataJson.production_cost["0"].bulan_ini_lyear[i])/1000000;
			
			last.push(Math.round(value));
		})
		console.log(dataJson);
		label.pop();last.pop();now.pop();
		label.pop();last.pop();now.pop();
		label.pop();last.pop();now.pop();



// production_cost
		
		var clin_now = Number(dataJson['s'+opco]["0"].bulan_ini.clinker);
		var cmnt_now = Number(dataJson['s'+opco]["0"].bulan_ini.cement);
		var salevol_now = Number(dataJson['s'+opco]["0"].bulan_ini.sales);

		var clin_past = Number(dataJson['s'+opco]["0"].bulan_lalu.clinker);
		var cmnt_past = Number(dataJson['s'+opco]["0"].bulan_lalu.cement);
		var salevol_past = Number(dataJson['s'+opco]["0"].bulan_lalu.sales);



		var pcost_rw_now = Number(dataJson.production_cost["0"].bulan_ini["Raw Material"])/1000000;
		var pcost_sm_now = Number(dataJson.production_cost["0"].bulan_ini["Supporting Material"])/1000000;
		var pcost_f_now = Number(dataJson.production_cost["0"].bulan_ini.Fuel)/1000000;
		var pcost_amor_now = Number(dataJson.production_cost["0"].bulan_ini["Depl. Deprec. and Amortization"])/1000000;
		var pcost_elc_now = Number(dataJson.production_cost["0"].bulan_ini.Electricity)/1000000;
		var pcost_gadm_now = Number(dataJson.production_cost["0"].bulan_ini["General & Administration"])/1000000;
		var pcost_lab_now = Number(dataJson.production_cost["0"].bulan_ini.Labor)/1000000;
		var pcost_main_now = Number(dataJson.production_cost["0"].bulan_ini.Maintenance)/1000000;
		var pcost_tax_now = Number(dataJson.production_cost["0"].bulan_ini["Taxes and Insurance"])/1000000;
		//var tot_pcost_nw = (pcost_rw_now+pcost_sm_now+pcost_f_now+pcost_amor_now+pcost_elc_now+pcost_gadm_now+pcost_lab_now+pcost_main_now+pcost_tax_now);
		var tot_pcost_nw = Number(dataJson.production_cost["0"].bulan_ini["Total"])/1000000;
		console.log("CEMENT PEMBAGI ->"+cmnt_now);

		var ton_pcost_rw_now = (pcost_rw_now/(cmnt_now/10))*1000000;
		var ton_pcost_sm_now = (pcost_sm_now/cmnt_now)*1000000;
		var ton_pcost_f_now = (pcost_f_now/clin_now)*1000000;
		var ton_pcost_amor_now = (pcost_amor_now/cmnt_now)*1000000;
		var ton_pcost_elc_now = (pcost_elc_now/cmnt_now)*1000000;
		var ton_pcost_gadm_now = (pcost_gadm_now / (cmnt_now/10))*1000000;
		var ton_pcost_lab_now = (pcost_lab_now/cmnt_now)*1000000;
		var ton_pcost_main_now = (pcost_main_now/cmnt_now)*1000000;
		var ton_pcost_tax_now = (pcost_tax_now/cmnt_now)*1000000;
		var ton_tot_pcost_nw = (tot_pcost_nw/cmnt_now)*1000000;
		var ton_tot_pcost_nwx = (tot_pcost_nw/cmnt_now)*1000000;

		console.log("tonage raw Material ->"+ton_pcost_rw_now);
	


		
// ############## PAST
		

		var pcost_rw_past = Number(dataJson.production_cost["0"].bulan_ini_lyear["Raw Material"])/1000000;
		var pcost_sm_past = Number(dataJson.production_cost["0"].bulan_ini_lyear["Supporting Material"])/1000000;
		var pcost_f_past = Number(dataJson.production_cost["0"].bulan_ini_lyear.Fuel)/1000000;
		var pcost_amor_past = Number(dataJson.production_cost["0"].bulan_ini_lyear["Depl. Deprec. and Amortization"])/1000000;
		var pcost_elc_past = Number(dataJson.production_cost["0"].bulan_ini_lyear.Electricity)/1000000;
		var pcost_gadm_past = Number(dataJson.production_cost["0"].bulan_ini_lyear["General & Administration"])/1000000;
		var pcost_lab_past = Number(dataJson.production_cost["0"].bulan_ini_lyear.Labor)/1000000;
		var pcost_main_past = Number(dataJson.production_cost["0"].bulan_ini_lyear.Maintenance)/1000000;
		var pcost_tax_past = Number(dataJson.production_cost["0"].bulan_ini_lyear["Taxes and Insurance"])/1000000;
		//var tot_pcost_pst = (pcost_rw_past+pcost_sm_past+pcost_f_past+pcost_amor_past+pcost_elc_past+pcost_gadm_past+pcost_lab_past+pcost_main_past+pcost_tax_past);
		var tot_pcost_pst = Number(dataJson.production_cost["0"].bulan_ini_lyear["Total"])/1000000;

		var tot_pcost_nwx = Number(tot_pcost_nw);
		var tot_pcost_psx = Number(tot_pcost_pst);

		var ton_pcost_rw_past = (pcost_rw_past/(cmnt_past/10))*1000000;
		var ton_pcost_sm_past = (pcost_sm_past/cmnt_past);
		var ton_pcost_f_past = (pcost_f_past/clin_past)*1000000;
		var ton_pcost_amor_past = (pcost_amor_past/cmnt_past)*1000000;
		var ton_pcost_elc_past = (pcost_elc_past/cmnt_past)*1000000;
		var ton_pcost_gadm_past = (pcost_gadm_past/(cmnt_past/10))*1000000;
		var ton_pcost_lab_past = (pcost_lab_past/cmnt_past)*1000000;
		var ton_pcost_main_past = (pcost_main_past/cmnt_past)*1000000;
		var ton_pcost_tax_past = (pcost_tax_past/cmnt_past)*1000000;
		var ton_tot_pcost_pst = (tot_pcost_pst/cmnt_past)*1000000;
		var ton_tot_pcost_psx = (tot_pcost_pst/cmnt_past)*1000000;


//console.log(tot_pcost_nw);
//console.log(tot_pcost_pst);

		
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
		$('#tot_pcost_psu').html(setFormat(tot_pcost_psx, 0));
		$('#tot_pcost_ps').html(setFormat(tot_pcost_nwx, 0));

		$('#ton_pcost_rw_now').html(setFormat(ton_pcost_rw_now, 0));
		$('#ton_pcost_sm_now').html(setFormat(ton_pcost_sm_now, 0));
		$('#ton_pcost_f_now').html(setFormat(ton_pcost_f_now, 0));
		$('#ton_pcost_amor_now').html(setFormat(ton_pcost_amor_now, 0));
		$('#ton_pcost_elc_now').html(setFormat(ton_pcost_elc_now, 0));
		$('#ton_pcost_gadm_now').html(setFormat(ton_pcost_gadm_now, 0));
		$('#ton_pcost_lab_now').html(setFormat(ton_pcost_lab_now, 0));
		$('#ton_pcost_main_now').html(setFormat(ton_pcost_main_now, 0));
		$('#ton_pcost_tax_now').html(setFormat(ton_pcost_tax_now, 0));
		$('#ton_tot_pcost_nw').html(setFormat(ton_tot_pcost_nw, 0));
		$('#ton_tot_pcost_nwu').html(setFormat(ton_tot_pcost_nw, 0));

		$('#ton_pcost_rw_past').html(setFormat(ton_pcost_rw_past, 0));
		$('#ton_pcost_sm_past').html(setFormat(ton_pcost_sm_past, 0));
		$('#ton_pcost_f_past').html(setFormat(ton_pcost_f_past, 0));
		$('#ton_pcost_amor_past').html(setFormat(ton_pcost_amor_past, 0));
		$('#ton_pcost_elc_past').html(setFormat(ton_pcost_elc_past, 0));
		$('#ton_pcost_gadm_past').html(setFormat(ton_pcost_gadm_past, 0));
		$('#ton_pcost_lab_past').html(setFormat(ton_pcost_lab_past, 0));
		$('#ton_pcost_main_past').html(setFormat(ton_pcost_main_past, 0));
		$('#ton_pcost_tax_past').html(setFormat(ton_pcost_tax_past, 0));
		$('#ton_tot_pcost_pst').html(setFormat(ton_tot_pcost_pst, 0));
		$('#ton_tot_pcost_psu').html(setFormat(ton_tot_pcost_psx, 0));

graphicChart(now, last, label, '350');

stop_waitMe('.wrapper');

	
	}).fail(function() {
     //alert("Gagal konek DB");
     stop_waitMe('.wrapper');
    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

// ############################ COGS ############################
function cost_data_cogs(bulan, opco, yearnow){
	
	run_waitMe('.wrapper', 'ios');
	 //console.log(bulan);
	// var param = (opco!='SMI')?'&company='+opco:'';
	var param = '';

      param = '&company='+opco;
    //console.log(bulan);
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

	$('#tag_last_cost').html('Up to '+month[bulan-1]);
	$('#tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);
	
		var dataJson ;
		$.post(url_src+'/api/index.php/cost_structure/get_data_mview?date='+yearnow+'.'+bulan+param, function(data){
	// $.post(url_src+'/api/cost_structure.php?date='+yearnow+'.'+bulan+param, function(data){
		// try{
		// 	dataJson = JSON.parse(data);
		// }catch(e){
		// 	console.log('data error');
		// }
		dataJson = paradigma.json_parse(data, '.wrapper');
		//console.log(dataJson);

		$.each(dataJson.good_of_sold["0"].bulan_ini, function(i, result){
			//console.log(i+"");
			label.push(i);
			var value = Number(dataJson.good_of_sold["0"].bulan_ini[i])/1000000;
			now.push(Math.round(value));
		})
		$.each(dataJson.good_of_sold["0"].bulan_ini_lyear, function(i, result){

			var value = Number(dataJson.good_of_sold["0"].bulan_ini_lyear[i])/1000000;
			
			last.push(Math.round(value));
		})
		label.pop();last.pop();now.pop();
		label.pop();last.pop();now.pop();
		label.pop();last.pop();now.pop();
		
		//console.log(label);
		//console.log(now);
		//console.log(last);
		var clin_now = Number(dataJson['s'+opco]["0"].bulan_ini.clinker);
		var cmnt_now = Number(dataJson['s'+opco]["0"].bulan_ini.cement);
		var salevol_now = Number(dataJson['s'+opco]["0"].bulan_ini.sales);
		
		var clin_past = Number(dataJson['s'+opco]["0"].bulan_lalu.clinker);
		var cmnt_past = Number(dataJson['s'+opco]["0"].bulan_lalu.cement);
		var salevol_past = Number(dataJson['s'+opco]["0"].bulan_lalu.sales);

// cogs now
		var cogs_dist_now = Number(dataJson.good_of_sold["0"].bulan_ini.Distribution)/1000000;
		var cogs_pack_now = Number(dataJson.good_of_sold["0"].bulan_ini.Packaging)/1000000;
		var cogs_vs_now = Number(dataJson.good_of_sold["0"].bulan_ini["Variance Stok"])/1000000;
		var cogs_wip_now = Number(dataJson.good_of_sold["0"].bulan_ini["WIP (Purchasing)"])/1000000;
		var tot_cogs_nw = Number(dataJson.good_of_sold["0"].bulan_ini["Total"])/1000000;
// cogs PAST
		var cogs_dist_past = Number(dataJson.good_of_sold["0"].bulan_ini_lyear.Distribution)/1000000;
		var cogs_pack_past = Number(dataJson.good_of_sold["0"].bulan_ini_lyear.Packaging)/1000000;
		var cogs_vs_past = Number(dataJson.good_of_sold["0"].bulan_ini_lyear["Variance Stok"])/1000000;
		var cogs_wip_past = Number(dataJson.good_of_sold["0"].bulan_ini_lyear["WIP (Purchasing)"])/1000000;
		var tot_cogs_pst = Number(dataJson.good_of_sold["0"].bulan_ini_lyear["Total"])/1000000;

		var tot_cogs_nwx = Number(tot_cogs_nw);
		var tot_cogs_pstx = Number(tot_cogs_pst);
// NOW TON
		var ton_cogs_dist_now = (cogs_dist_now/salevol_now)*1000000;
		var ton_cogs_pack_now = (cogs_pack_now/salevol_now)*1000000;
		var ton_cogs_vs_now = (cogs_vs_now/salevol_now)*1000000;
		var ton_cogs_wip_now = cogs_wip_now;
		var ton_tot_cogs_nwu = (tot_cogs_nw/(salevol_now/10))*1000000;
		var ton_tot_cogs_nw = (tot_cogs_nw/(salevol_now/10))*1000000;
		
		
// PAST TON
		var ton_cogs_dist_past = (cogs_dist_past/salevol_past)*1000000;
		var ton_cogs_pack_past = (cogs_pack_past/salevol_past)*1000000;
		var ton_cogs_vs_past = (cogs_vs_past/salevol_past)*1000000;
		var ton_cogs_wip_past = cogs_wip_past;
		var ton_tot_cogs_pstu = (tot_cogs_pst/(salevol_past/10))*1000000;
		var ton_tot_cogs_pst = (tot_cogs_pst/(salevol_past/10))*1000000;




		$('#cogs_dist_now').html(setFormat(cogs_dist_now, 0));
		$('#cogs_pack_now').html(setFormat(cogs_pack_now, 0));
		$('#cogs_vs_now').html(setFormat(cogs_vs_now, 0));
		$('#cogs_wip_now').html(setFormat(cogs_wip_now, 0));
		
		$('#tot_cogs_nwu').html(setFormat(tot_cogs_nwx, 0));
		$('#tot_cogs_nw').html(setFormat(tot_cogs_nwx, 0));
		// console.log('mentah '+tot_pcost_nwx);

		$('#cogs_dist_past').html(setFormat(cogs_dist_past, 0));
		$('#cogs_pack_past').html(setFormat(cogs_pack_past, 0));
		$('#cogs_vs_past').html(setFormat(cogs_vs_past, 0));
		$('#cogs_wip_past').html(setFormat(cogs_wip_past, 0));
		
		$('#tot_cogs_pstu').html(setFormat(tot_cogs_pstx, 0));
		$('#tot_cogs_pst').html(setFormat(tot_cogs_pstx, 0));

		// #################################################### PER TON
		$('#ton_cogs_dist_now').html(setFormat(ton_cogs_dist_now, 0));
		$('#ton_cogs_pack_now').html(setFormat(ton_cogs_pack_now, 0));
		$('#ton_cogs_vs_now').html(setFormat(ton_cogs_vs_now, 0));
		$('#ton_cogs_wip_now').html(setFormat(ton_cogs_wip_now, 0));
		$('#ton_tot_cogs_nwu').html(setFormat(ton_tot_cogs_nwu, 0));
		$('#ton_tot_cogs_nw').html(setFormat(ton_tot_cogs_nw, 0));

		$('#ton_cogs_dist_past').html(setFormat(ton_cogs_dist_past, 0));
		$('#ton_cogs_pack_past').html(setFormat(ton_cogs_pack_past, 0));
		$('#ton_cogs_vs_past').html(setFormat(ton_cogs_vs_past, 0));
		$('#ton_cogs_wip_past').html(setFormat(ton_cogs_wip_past, 0));
		$('#ton_tot_cogs_pstu').html(setFormat(ton_tot_cogs_pstu, 0));
		$('#ton_tot_cogs_pst').html(setFormat(ton_tot_cogs_pst, 0));

		

		
		graphicChart(now, last, label, '300');

stop_waitMe('.wrapper');
	
	
	}).fail(function() {
     //alert("Gagal konek DB");
     stop_waitMe('.wrapper');
    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}



// ############################ generel admn ############################

function cost_data_gnrl(bulan, opco, yearnow){
	run_waitMe('.wrapper', 'ios');
     param = '&company='+opco;

    //console.log(bulan);
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

	$('#tag_last_cost').html('Up to '+month[bulan-1]);
	$('#tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);
	
		var dataJson ;
		$.post(url_src+'/api/index.php/cost_structure/get_data_mview?date='+yearnow+'.'+bulan+param, function(data){
			// $.post(url_src+'/api/cost_structure.php?date='+yearnow+'.'+bulan+param, function(data){
		// try{
		// 	dataJson = JSON.parse(data);
		// }catch(e){
		//console.log('data error');
		// }
		dataJson = paradigma.json_parse(data, '.wrapper');
		
		//console.log(dataJson);
		$.each(dataJson.general_administration["0"].bulan_ini, function(i, result){
			//console.log(i+"");
			label.push(i);
			var value = Number(dataJson.general_administration["0"].bulan_ini[i])/1000000;
			now.push( Math.round(value));
		})
		$.each(dataJson.general_administration["0"].bulan_ini_lyear, function(i, result){

			var value = Number(dataJson.general_administration["0"].bulan_ini_lyear[i])/1000000;
			
			last.push( Math.round(value) );
		})
		label.pop();last.pop();now.pop();
		label.pop();last.pop();now.pop();

		var clin_now = Number(dataJson['s'+opco]["0"].bulan_ini.clinker);
		var cmnt_now = Number(dataJson['s'+opco]["0"].bulan_ini.cement);
		var salevol_now = Number(dataJson['s'+opco]["0"].bulan_ini.sales);
		
		var clin_past = Number(dataJson['s'+opco]["0"].bulan_lalu.clinker);
		var cmnt_past = Number(dataJson['s'+opco]["0"].bulan_lalu.cement);
		var salevol_past = Number(dataJson['s'+opco]["0"].bulan_lalu.sales);


// General now
		var gen_dam_now = Number(dataJson.general_administration["0"].bulan_ini["Depl. Deprec. and Amortization"])/1000000;
		var gen_el_now = Number(dataJson.general_administration["0"].bulan_ini.Electricity)/1000000;
		var gen_fuel_now = Number(dataJson.general_administration["0"].bulan_ini.Fuel)/1000000;
		var gen_gm_now = Number(dataJson.general_administration["0"].bulan_ini["General & Administration"])/1000000;
		var gen_labor_now = Number(dataJson.general_administration["0"].bulan_ini.Labor)/1000000;
		var gen_mainte_now = Number(dataJson.general_administration["0"].bulan_ini.Maintenance)/1000000;
		var gen_support_now = Number(dataJson.general_administration["0"].bulan_ini["Supporting Material"])/1000000;
		var gen_tax_now = Number(dataJson.general_administration["0"].bulan_ini["Taxes and insurance"])/1000000;
		var tot_gen_nw = Number(dataJson.general_administration["0"].bulan_ini["Total"])/1000000;
// General PAST
		var gen_dam_past = Number(dataJson.general_administration["0"].bulan_ini_lyear["Depl. Deprec. and Amortization"])/1000000;
		var gen_el_past = Number(dataJson.general_administration["0"].bulan_ini_lyear.Electricity)/1000000;
		var gen_fuel_past = Number(dataJson.general_administration["0"].bulan_ini_lyear.Fuel)/1000000;
		var gen_gm_past = Number(dataJson.general_administration["0"].bulan_ini_lyear["General & Administration"])/1000000;
		var gen_labor_past = Number(dataJson.general_administration["0"].bulan_ini_lyear.Labor)/1000000;
		var gen_mainte_past = Number(dataJson.general_administration["0"].bulan_ini_lyear.Maintenance)/1000000;
		var gen_support_past = Number(dataJson.general_administration["0"].bulan_ini_lyear["Supporting Material"])/1000000;
		var gen_tax_past = Number(dataJson.general_administration["0"].bulan_ini_lyear["Taxes and insurance"])/1000000;
		var tot_gen_pst = Number(dataJson.general_administration["0"].bulan_ini_lyear["Total"])/1000000;

		var tot_gen_pstx = Number(tot_gen_pst);
		var tot_gen_nwx = Number(tot_gen_nw);

		// NOW TON
		var ton_gen_dam_now = (gen_dam_now/salevol_now)*1000000;
		var ton_gen_el_now = (gen_el_now/salevol_now)*1000000;
		var ton_gen_fuel_now = (gen_fuel_now/salevol_now)*1000000;
		var ton_gen_gm_now = (gen_gm_now/salevol_now)*1000000;
		var ton_gen_labor_now = (gen_labor_now/(salevol_now/10))*1000000;
		var ton_gen_mainte_now = (gen_mainte_now/salevol_now)*1000000;
		var ton_gen_support_now = (gen_support_now/salevol_now)*1000000;
		var ton_gen_tax_now = (gen_tax_now/salevol_now)*1000000;
		var ton_tot_gen_nw = (tot_gen_nw/salevol_now)*1000000;
		var ton_tot_gen_nwu = (tot_gen_nw/salevol_now)*1000000;
		console.log((tot_gen_nw/salevol_now))
		
				// PAST TON
		var ton_gen_dam_past = (gen_dam_past/salevol_past)*1000000;
		var ton_gen_el_past = (gen_el_past/salevol_past)*1000000;
		var ton_gen_fuel_past = (gen_fuel_past/salevol_past)*1000000;
		var ton_gen_gm_past = (gen_gm_past/salevol_past)*1000000;
		var ton_gen_labor_past = (gen_labor_past/(salevol_past/10))*1000000;
		var ton_gen_mainte_past = (gen_mainte_past/salevol_past)*1000000;
		var ton_gen_support_past = (gen_support_past/salevol_past)*1000000;
		var ton_gen_tax_past = (gen_tax_past/salevol_past)*1000000;
		var ton_tot_gen_pst = (tot_gen_pst/salevol_past)*1000000;
		var ton_tot_gen_pstu = (tot_gen_pst/salevol_past)*1000000;

		$('#gen_dam_now').html(setFormat(gen_dam_now, 0));
		$('#gen_el_now').html(setFormat(gen_el_now, 0));
		$('#gen_fuel_now').html(setFormat(gen_fuel_now, 0));
		$('#gen_gm_now').html(setFormat(gen_gm_now, 0));
		$('#gen_labor_now').html(setFormat(gen_labor_now, 0));
		$('#gen_mainte_now').html(setFormat(gen_mainte_now, 0));
		$('#gen_support_now').html(setFormat(gen_support_now, 0));
		$('#gen_tax_now').html(setFormat(gen_tax_now, 0));
		
		
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
		
		$('#tot_gen_pstu').html(setFormat(tot_gen_pstx, 0));
		$('#tot_gen_pst').html(setFormat(tot_gen_pstx, 0));


		// PERTON
		$('#ton_gen_dam_now').html(setFormat(ton_gen_dam_now, 0));
		$('#ton_gen_el_now').html(setFormat(ton_gen_el_now, 0));
		$('#ton_gen_fuel_now').html(setFormat(ton_gen_fuel_now, 0));
		$('#ton_gen_gm_now').html(setFormat(ton_gen_gm_now, 0));
		$('#ton_gen_labor_now').html(setFormat(ton_gen_labor_now, 0));
		$('#ton_gen_mainte_now').html(setFormat(ton_gen_mainte_now, 0));
		$('#ton_gen_support_now').html(setFormat(ton_gen_support_now, 0));
		console.log(ton_gen_support_now);
		$('#ton_gen_tax_now').html(setFormat(ton_gen_tax_now, 0));
		$('#ton_tot_gen_nw').html(setFormat(ton_tot_gen_nw, 0));
		$('#ton_tot_gen_nwu').html(setFormat(ton_tot_gen_nwu, 0));

		$('#ton_gen_dam_past').html(setFormat(ton_gen_dam_past, 0));
		$('#ton_gen_el_past').html(setFormat(ton_gen_el_past, 0));
		$('#ton_gen_fuel_past').html(setFormat(ton_gen_fuel_past, 0));
		$('#ton_gen_gm_past').html(setFormat(ton_gen_gm_past, 0));
		$('#ton_gen_labor_past').html(setFormat(ton_gen_labor_past, 0));
		$('#ton_gen_mainte_past').html(setFormat(ton_gen_mainte_past, 0));
		$('#ton_gen_support_past').html(setFormat(ton_gen_support_past, 0));
		$('#ton_gen_tax_past').html(setFormat(ton_gen_tax_past, 0));
		$('#ton_tot_gen_pst').html(setFormat(ton_tot_gen_pst, 0));
		$('#ton_tot_gen_pstu').html(setFormat(ton_tot_gen_pstu, 0));






	graphicChart(now, last, label, '350');

stop_waitMe('.wrapper');

	
	}).fail(function() {
     //alert("Gagal konek DB");
     stop_waitMe('.wrapper');
    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

// ############################ Sales volume ############################

function cost_data_sell(bulan, opco, yearnow){
	run_waitMe('.wrapper', 'ios');
	 //console.log(bulan);
	// var param = (opco!='SMI')?'&company='+opco:'';
	var param = '';

     //console.log(data);
     param = '&company='+opco;
    //console.log(bulan);
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

	$('#tag_last_cost').html('Up to '+month[bulan-1]);
	$('#tag_past_cost').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);
	
		var dataJson ;
		$.post(url_src+'/api/index.php/cost_structure/get_data_mview?date='+yearnow+'.'+bulan+param, function(data){
		// $.post(url_src+'/api/cost_structure.php?date='+yearnow+'.'+bulan+param, function(data){
		// try{
		// 	dataJson = JSON.parse(data);
		// }catch(e){
		// 	console.log('data error');
		// }
		dataJson = paradigma.json_parse(data, '.wrapper');
		
		//console.log(dataJson);
		$.each(dataJson.selling_marketing["0"].bulan_ini, function(i, result){
			//console.log(i+"");
			label.push(i);
			var value = Number(dataJson.selling_marketing["0"].bulan_ini[i])/1000000;
			now.push(Math.round(value));
		})
		$.each(dataJson.selling_marketing["0"].bulan_ini_lyear, function(i, result){

			var value = Number(dataJson.selling_marketing["0"].bulan_ini_lyear[i])/1000000;
			
			last.push(Math.round(value));
		})
		label.pop();last.pop();now.pop();
		label.pop();last.pop();now.pop();
		label.pop();last.pop();now.pop();

		var clin_now = Number(dataJson['s'+opco]["0"].bulan_ini.clinker);
		var cmnt_now = Number(dataJson['s'+opco]["0"].bulan_ini.cement);
		var salevol_now = Number(dataJson['s'+opco]["0"].bulan_ini.sales);
		
		var clin_past = Number(dataJson['s'+opco]["0"].bulan_lalu.clinker);
		var cmnt_past = Number(dataJson['s'+opco]["0"].bulan_lalu.cement);
		var salevol_past = Number(dataJson['s'+opco]["0"].bulan_lalu.sales);


// sales now
		var sell_dam_now = Number(dataJson.selling_marketing["0"].bulan_ini["Depl. Deprec. and Amortization"])/1000000;
		var sell_elc_now = Number(dataJson.selling_marketing["0"].bulan_ini.Electricity)/1000000;
		var sell_fuel_now = Number(dataJson.selling_marketing["0"].bulan_ini.Fuel)/1000000;
		var sell_gm_now = Number(dataJson.selling_marketing["0"].bulan_ini["General & Administration"])/1000000;
		var sell_labor_now = Number(dataJson.selling_marketing["0"].bulan_ini.Labor)/1000000;
		var sell_main_now = Number(dataJson.selling_marketing["0"].bulan_ini.Maintenance)/1000000;
		var sell_sm_now = Number(dataJson.selling_marketing["0"].bulan_ini["Supporting Material"])/1000000;
		var sell_md_now = Number(dataJson.selling_marketing["0"].bulan_ini["Marketing & Distribution"])/1000000;
		var tot_sell_nw = Number(dataJson.selling_marketing["0"].bulan_ini["Total"])/1000000;

// sales PAST
		var sell_dam_past = Number(dataJson.selling_marketing["0"].bulan_ini_lyear["Depl. Deprec. and Amortization"])/1000000;
		var sell_elc_past = Number(dataJson.selling_marketing["0"].bulan_ini_lyear.Electricity)/1000000;
		var sell_fuel_past = Number(dataJson.selling_marketing["0"].bulan_ini_lyear.Fuel)/1000000;
		var sell_gm_past = Number(dataJson.selling_marketing["0"].bulan_ini_lyear["General & Adminitration"])/1000000;
		var sell_labor_past = Number(dataJson.selling_marketing["0"].bulan_ini_lyear.Labor)/1000000;
		var sell_main_past = Number(dataJson.selling_marketing["0"].bulan_ini_lyear.Maintenance)/1000000;
		var sell_sm_past = Number(dataJson.selling_marketing["0"].bulan_ini_lyear["Supporting Material"])/1000000;
		var sell_md_past = Number(dataJson.selling_marketing["0"].bulan_ini_lyear["Marketing & Distribution"])/1000000;
		var tot_sell_pst = Number(dataJson.selling_marketing["0"].bulan_ini_lyear["Total"])/1000000;

		var tot_sell_nwx = Number(tot_sell_nw);
		var tot_sell_pstx = Number(tot_sell_pst);

		var ton_sell_dam_now = (sell_dam_now/salevol_now)*1000000;
		var ton_sell_elc_now = (sell_elc_now/salevol_now)*1000000;
		var ton_sell_fuel_now = (sell_fuel_now/salevol_now)*1000000;
		var ton_sell_gm_now = (sell_gm_now/salevol_now)*1000000;
		var ton_sell_labor_now = (sell_labor_now/salevol_now)*1000000;
		var ton_sell_main_now = (sell_main_now/salevol_now)*1000000;
		var ton_sell_sm_now = (sell_sm_now/salevol_now)*1000000;
		var ton_sell_md_now = (sell_md_now/(salevol_now/10))*1000000;
		var ton_tot_sell_nw = (tot_sell_nw/salevol_now)*1000000;
		var ton_tot_sell_nwu = (tot_sell_nw/salevol_now)*1000000;

		var ton_sell_dam_past = (sell_dam_past/salevol_past)*1000000;
		var ton_sell_elc_past = (sell_elc_past/salevol_past)*1000000;
		var ton_sell_fuel_past = (sell_fuel_past/salevol_past)*1000000;
		var ton_sell_gm_past = (sell_gm_past/salevol_past)*1000000;
		var ton_sell_labor_past = (sell_labor_past/salevol_past)*1000000;
		var ton_sell_main_past = (sell_main_past/salevol_past)*1000000;
		var ton_sell_sm_past = (sell_sm_past/salevol_past)*1000000;
		var ton_sell_md_past = (sell_md_past/(salevol_past/10))*1000000;
		var ton_tot_sell_pst = (tot_sell_pst/salevol_past)*1000000;
		var ton_tot_sell_pstu = (tot_sell_pst/salevol_past)*1000000;
		console.log("Material = "+ton_sell_sm_past);

		
//console.log('Nilai = '+tot_sell_pst);
//console.log(typeof(tot_sell_nw));
		$('#sell_dam_now').html(setFormat(sell_dam_now, 0));
		$('#sell_elc_now').html(setFormat(sell_elc_now, 0));
		$('#sell_fuel_now').html(setFormat(sell_fuel_now, 0));
		$('#sell_gm_now').html(setFormat(sell_gm_now, 0));
		$('#sell_labor_now').html(setFormat(sell_labor_now, 0));
		$('#sell_main_now').html(setFormat(sell_main_now, 0));
		$('#sell_sm_now').html(setFormat(sell_sm_now, 0));
		$('#sell_md_now').html(setFormat(sell_md_now, 0));
		
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
		$('#sell_md_past').html(setFormat(sell_md_past, 0));
		
		$('#tot_sell_pstu').html(setFormat(tot_sell_pstx, 0));
		$('#tot_sell_pst').html(setFormat(tot_sell_pstx, 0));

		// TON

		$('#ton_sell_dam_now').html(setFormat(ton_sell_dam_now, 0));
		$('#ton_sell_elc_now').html(setFormat(ton_sell_elc_now, 0));
		$('#ton_sell_fuel_now').html(setFormat(ton_sell_fuel_now, 0));
		$('#ton_sell_gm_now').html(setFormat(ton_sell_gm_now, 0));
		$('#ton_sell_labor_now').html(setFormat(ton_sell_labor_now, 0));
		$('#ton_sell_main_now').html(setFormat(ton_sell_main_now, 0));
		$('#ton_sell_sm_now').html(setFormat(ton_sell_sm_now, 0));
		console.log(ton_sell_sm_now);
		$('#ton_sell_md_now').html(setFormat(ton_sell_md_now, 0));
		$('#ton_tot_sell_nwu').html(setFormat(ton_tot_sell_nw, 0));
		$('#ton_tot_sell_nw').html(setFormat(ton_tot_sell_nw, 0));

		$('#ton_sell_dam_past').html(setFormat(ton_sell_dam_past, 0));
		$('#ton_sell_elc_past').html(setFormat(ton_sell_elc_past, 0));
		$('#ton_sell_fuel_past').html(setFormat(ton_sell_fuel_past, 0));
		$('#ton_sell_gm_past').html(setFormat(ton_sell_gm_past, 0));
		$('#ton_sell_labor_past').html(setFormat(ton_sell_labor_past, 0));
		$('#ton_sell_main_past').html(setFormat(ton_sell_main_past, 0));
		$('#ton_sell_sm_past').html(setFormat(ton_sell_sm_past, 0));
		$('#ton_sell_md_past').html(setFormat(ton_sell_md_past, 0));
		
		$('#ton_tot_sell_pstu').html(setFormat(ton_tot_sell_pst, 0));
		$('#ton_tot_sell_pst').html(setFormat(ton_tot_sell_pst, 0));




	graphicChart(now, last, label, '350');

stop_waitMe('.wrapper');

	
	}).fail(function() {
     //alert("Gagal konek DB");
     stop_waitMe('.wrapper');
    });
    // company_balance(bulan);
    // dataLineChart(bulan, opco);

}

function nextPage(company, bulan, tahun, url){
  console.log(company+'-'+ bulan+'-'+ tahun);
  //sessionStorage.setItem('cost-bln', bulan);
  //sessionStorage.setItem('cost-opco', company);
  //sessionStorage.setItem('cost-thn', tahun);

  //window.location.href = url+".html";
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
            name: 'This Month Last Year',
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
            categories: ['COGM','COGS','Gen.Adm','Sell & Market'],
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

	//console.log('graphic has loaded');
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
	var urlsmi = url_src+'/api/index.php/cost_structure/get_data_mview?date='+yearnow+'.'+bulan+'&company=smi';
	var url3000 = url_src+'/api/index.php/cost_structure/get_data_mview?date='+yearnow+'.'+bulan+'&company=3000';
	var url4000 = url_src+'/api/index.php/cost_structure/get_data_mview?date='+yearnow+'.'+bulan+'&company=4000';
	var url7000 = url_src+'/api/index.php/cost_structure/get_data_mview?date='+yearnow+'.'+bulan+'&company=7000';
	//var urlsmi = url_src+'/api/cost_structure.php?date='+yearnow+'.'+bulan+'&company=smi';
	//var url3000 = url_src+'/api/cost_structure.php?date='+yearnow+'.'+bulan+'&company=3000';
	//var url4000 = url_src+'/api/cost_structure.php?date='+yearnow+'.'+bulan+'&company=4000';
	//var url7000 = url_src+'/api/cost_structure.php?date='+yearnow+'.'+bulan+'&company=7000';
	var opco = [];
	// alert('haha');
	var label = ['Production Cost', 'Good Of Sold', 'General Administration', 'Selling Marketing'];

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
	    
	    	console.log(data);
	    	// plotPlantCompare('3000', result3000);
	    	graphicChart_opco(label, data);
	    	//console.log(good);
	    	//console.log(prod);
	    	//console.log(selling);

	    	
	    	
	    });

}

function plotPlantCompare(opco, dataJson){
	// var data = dataJson['s'+opco];
	var tableVal = dataJson["0"]['s'+opco]['0'].bulan_ini;
	var ga_tot = gos_tot = pc_tot = sm_tot = 0;
	//console.log(tableVal);
	$.each(tableVal, function(index, el) {
		// console.log(index, el);
		$('#'+index+opco).html(setFormat(el));
	});
	
	var production_cost = dataJson['0'].production_cost['0'].bulan_ini;
	pc_tot = dataJson['0'].production_cost['0'].bulan_ini.Total;//totalPlantCompare(production_cost);
	data[opco].push(Math.round(pc_tot/1000000));
	
	

	var good_of_sold = dataJson['0'].good_of_sold['0'].bulan_ini;
	gos_tot = dataJson['0'].good_of_sold['0'].bulan_ini.Total;//totalPlantCompare(good_of_sold);
	data[opco].push(Math.round(gos_tot/1000000));

	var general_administration = dataJson['0'].general_administration['0'].bulan_ini;
	ga_tot = dataJson['0'].general_administration['0'].bulan_ini.Total ;//totalPlantCompare(general_administration);
	data[opco].push(Math.round(ga_tot/1000000));

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

