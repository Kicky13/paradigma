var selpel = ''; var det_kapal = '';
function port_list(data){
	selpel += '<option value="all">PILIH PELABUHAN ASAL</option>';
	for(var i=0; i<data.length; i++) {
		for (var pelawal in data[i]) {
			if (data[i].hasOwnProperty(pelawal)) {
				selpel += '<option value='+i+'>'+pelawal+'</option>';
				for (var namakade in data[i][pelawal]) {
					if (data[i][pelawal].hasOwnProperty(namakade)) {
						for (var namakapal in data[i][pelawal][namakade]) {
							if (data[i][pelawal][namakade].hasOwnProperty(namakapal)) {
								var detail = data[i][pelawal][namakade][namakapal];
								det_kapal += '<div class="headsix port_mngmt pel'+i+'" rel="active"><div class="ic_ship"><img src="img/img_ship_pm.png"></div>'
									det_kapal += '<div class="title_ship">'
										det_kapal += '<h1>'+namakade+'</h1>'
										det_kapal += '<h2>'+namakapal+'</h2>'
										det_kapal += '<h1 style="color:#EF4836">'+detail.RENCANA_MUAT+'</h1>'
									det_kapal += '</div><div class="detail">'
										det_kapal += '<ul>'
											det_kapal += '<li>Daftar : '+detail.DAFTAR+'</li>'
											det_kapal += '<li>Labuh : '+detail.LABUH+'</li>'
											det_kapal += '<li>Sandar : '+detail.SANDAR+'</li>'
											det_kapal += '<li>Bongkar : '+detail.BONGKAR+'</li>'
											det_kapal += '<li>Tolak : '+detail.TOLAK+'</li>'
											det_kapal += '<li>ETA : '+detail.ETA+'</li>'
										det_kapal += '</ul>'
									det_kapal += '</div>'
									det_kapal += '<div class="tujuan">'
										det_kapal += '<span>&#9658;</span>'
										det_kapal += '<p>'+detail.TUJUAN+'</p>'
									det_kapal += '</div>'
								det_kapal += '</div>';
							}
						}	
					}
				}	
			}
		}
	}
	$('#selpel').html('<select class="selpel">'+selpel+'</select>');
	$("#port_list").html(det_kapal);
}

function opcoGroup (sdate, fdate){
    run_waitMe('.wrapper', 'ios');
	var port1 = url_ol+'/api/index.php/port_management/get_data_port?dstart='+sdate+'&dfinish='+fdate;
	$.ajax({url: port1, dataType:'json', success: function(result){
		port_list(result);
		stop_waitMe('.wrapper');
		$('.port_mngmt').click(function (e) {
			var r = $(this).attr('rel');
			e.preventDefault();
			if(r=="active"){
				$(this).find('.detail').addClass('show');
				$(this).attr('rel', 'inactive');
			}else{
				$(this).find('.detail').removeClass('show');
				$(this).attr('rel', 'active');
			}
		});
		
		$('.selpel').change(function(){
			run_waitMe('.wrapper', 'ios');
			var active = $(this).val();
			if(active=='all'){
				$(".port_mngmt").show();
			}else{
				$(".port_mngmt").hide();
				$(".pel"+active).show();
			}
			stop_waitMe('.wrapper');
		})	
    }});
}
