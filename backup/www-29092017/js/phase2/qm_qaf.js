var temp = '';
function data_list(product, data){
	temp = '';
	if(product=='cement'){
		for(var i=0; i<data.length; i++) {
			temp += '<div class="highlight-tot" style="width:100%;margin:0;padding:0 15px;box-sizing:border-box;">'
				temp += '<h1>'+data[i].plant+'</h1>'
					for(var y=0; y<data[i].data.length; y++) {
						temp += '<div class="item" style="width:100%">'
							temp += '<div align="left" class="col-xs-8" style="margin-bottom: 8px; padding-left:0;">'
								temp += '<span class="ttl_fp">'+data[i].data[y].kode+'</span>'
							temp += '</div>'
							temp += '<div align="right" class="col-xs-4" style="margin-bottom: 8px; padding-right:0;">'
								// temp += '<a onmousedown="gotochart("p2_fin_smi_pc_chart.html")"><i class="fa fa-line-chart right grp_ico" aria-hidden="true"></i></a>'
							temp += '</div>'
							temp += '<div class="detail">'
								temp += '<table>'
									temp += '<tr>'
										temp += '<td>Finish Mill</td>'
										temp += '<td width="100" style="text-align:center;">Total</td>'
									temp += '</tr>'
									for(var x=0; x<data[i].data[y].data.length; x++) {
										for(var z=0; z<data[i].data[y].data[x].data.length; z++) {
											temp += '<tr>'
												temp += '<td>'+data[i].data[y].data[x].data[z].NM_AREA+'</td>'
												temp += '<td style="text-align:center;">'+data[i].data[y].data[x].data[z].PERSEN_QAF+'</td>'
											temp += '</tr>'
										}
									}
								temp += '</table>';
							temp += '</div>'
						temp += '</div>'
					}
			temp += '</div>';
		}
    }else{
		for(var i=0; i<data.length; i++) {
			temp += '<div class="highlight-tot" style="width:100%;margin:0;padding:0 15px;box-sizing:border-box;">'
				temp += '<h1>'+data[i].plant+'</h1>'
						temp += '<div class="item" style="width:100%">'
							temp += '<div class="detail">'
								temp += '<table>'
									temp += '<tr>'
										temp += '<td>Clinker</td>'
										temp += '<td width="100" style="text-align:center;">Total</td>'
									temp += '</tr>'
									for(var y=0; y<data[i].data.length; y++) {
										temp += '<tr>'
											temp += '<td>'+data[i].data[y].NM_AREA+'</td>'
											temp += '<td style="text-align:center;">'+data[i].data[y].PERSEN_QAF+'</td>'
										temp += '</tr>'
									}
								temp += '</table>';
							temp += '</div>'
						temp += '</div>'
			temp += '</div>';
		}
    }
	$(".detailQaf").html(temp);
}

function opcoGroup (selprod, selopco, selmonth, selyear){
    run_waitMe('.wrapper', 'ios');
	$.ajax({
		url: 'http://10.15.2.130/par4digma/get_report_qaf?product='+selprod+'&company='+selopco+'&month='+selmonth+'&year='+selyear,
		type: "get",
		dataType: "json",
		success: function (data) {
			console.log(data);
			data_list(selprod, data);
			stop_waitMe('.wrapper');
		}
	});
	
}

