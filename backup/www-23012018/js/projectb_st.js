$(function(){
	$('.table tbody').empty();
	run_waitMe('.wrapper', 'ios');
	// $.post(url_src+'/api/index.php/Project', function(data){
	$.post(url_src+'par4digma/api/index.php/Project/st', function(data){
		var dataJson  = JSON.parse(data);
		var total = 0;
		var nama, pic, subnama, progress = null, issue = false;
		var date_now = new Date ();
		 date_now = moment(date_now, 'DD/MM/YYYY');
		var date_first_year = moment('01/01/2016' , 'DD/MM/YYYY');
		var kpi_cur = 0;
		var kpi_kum = 0;
		var active_proj=0;
		var closed_proj=0;
		//console.log(dataJson);
		console.log(date_now+'-'+date_now.get('month'));
		$.each(dataJson, function(i, result){
			total = i;
			nama = (result.project_name==null)? '-':result.project_name;
			subnama = (result.issue.title==null)? '-':result.issue.title;
			pic = (result.PIC==null)? '-':result.PIC;

			if (result.project_start!==null) {
					var date_start = moment(result.project_start, 'DD/MM/YYYY');
					var date_finish = moment(result.project_finish, 'DD/MM/YYYY');
					
					if (date_finish > date_now) {
						progress = true;
					}else {
						progress = false;
					}

			}
		
			if (result.issue.status=='Active') {
				active_proj ++;
				issue = true;
			}else{
				closed_proj ++;
			}


			if (result.status.created!=null) {
				var date_created = moment(result.status.created, 'DD/MM/YYYY');

				// console.log('get month created = '+ date_created.get('month'));
				///get curren kpi
				if (date_created.get('month')==date_now.get('month')) {
					// console.log(result.kpi);
					kpi_cur += Number(result.kpi);
				}
				//get kumulasi kpi
				if (date_created >= date_first_year && date_created <= date_now) {
					kpi_kum += parseFloat(result.kpi);
				}
				
			}

			console.log('kpi current : ' +kpi_cur+' kpi_kum :'+kpi_kum);

			addRow(i, nama,subnama, pic, progress, issue);
		});

		stop_waitMe('.wrapper');
	
	});
	
})

function addRow(no,nama, subnama,pic, progress, issue){

	tag_progress =(progress!=null && progress==true)? '<i class="fa fa-eercast fa-1x" aria-hidden="true" style="color:#669966"></i></div>':'';
	var tag_issue = (issue)? '<i class="fa fa-eercast fa-1x" aria-hidden="true" style="color:#DC0033"></i></div>':'';

	$('.table tbody').append(
		'<tr onclick="show()" id="a"> <td>  '+no+',</td><td>'+nama+'<br><span style="color:#C7C3C3;">'+subnama+'</span> </td><td valign="middle"><div align="center">'+pic+'</div></td><td valign="middle"><div align="center">'+tag_progress+'</td><td valign="middle"><div align="center">'+tag_issue+'</td><td><div align="center"><a href="#"><i class="fa fa-ellipsis-v" aria-hidden="true" style="color: #909090;"></i></a></div>  </td></tr> ' 		
		
		);
	}

function show(nr) {
	var a = $(this).text();	
 	window.location = 'ppj_project_detail.html';
}
