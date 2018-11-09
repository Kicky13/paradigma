$(function(){
	$('.table tbody').empty();
	run_waitMe('.wrapper', 'ios');
	var kpi_of =0;
	var kpi_until=0;
	var periode;
	var date_now = new Date ();
	date_now = moment(date_now, 'DD/MM/YYYY');

	$.post(url_src+'/api/index.php/Project/kpi', function(data){
		var dataJson  = JSON.parse(data);
		$.each(dataJson, function(i, result){
			pic = i;
		
			periode = dataJson[i].periode;
			kpi_of = dataJson[i].kpi_of;
			kpi_until = dataJson[i].kpi_until;


		});

	$("#kpi_of").html(kpi_of);
	$("#kpi_until").html(kpi_until);
	$('#tag_kpi_cur').html('KPI Of '+month[date_now.get('month')-1]+' '+date_now.get('year'));
	$('#tag_kpi_kum').html('KPI Until '+month[date_now.get('month')-1]+' '+date_now.get('year'));

	stop_waitMe('.wrapper');
	});
	

	
})
