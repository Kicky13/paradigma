$(function(){
	$('.table tbody').empty();
	//run_waitMe('.wrapper', 'ios');
	// $.post(url_src+'/api/index.php/Project', function(data){
	$.post(url_src+'/api/index.php/Project/status', function(data){
		var dataJson  = JSON.parse(data);
		var total = 0;
		var nama, pic, subnama, progress = null, issue = false;
		var date_now = new Date ();
		 date_now = moment(date_now, 'DD/MM/YYYY');
		var date_first_year = moment('01/01/2016' , 'DD/MM/YYYY');
		// var kpi_cur = 0;
		// var kpi_kum = 0;
		var active_proj=0;
		var closed_proj=0;
		//console.log(dataJson);
		// console.log(date_now+'-'+date_now.get('month'));
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


			// if (result.status.created!=null) {
			// 	var date_created = moment(result.status.created, 'DD/MM/YYYY');

			// 	// console.log('get month created = '+ date_created.get('month'));
			// 	///get curren kpi
			// 	if (date_created.get('month')==date_now.get('month')) {
			// 		// console.log(result.kpi);
			// 		kpi_cur += Number(result.kpi);
			// 	}
			// 	//get kumulasi kpi
			// 	if (date_created >= date_first_year && date_created <= date_now) {
			// 		kpi_kum += parseFloat(result.kpi);
			// 	}
				
			// }

			// console.log('kpi current : ' +kpi_cur+' kpi_kum :'+kpi_kum);

			
		});

		// gaugeChart(active_proj, closed_proj, total);
		// $('#kpi_cur').html(kpi_cur);
		$('#tag_kpi_cur').html('KPI Of '+month[date_now.get('month')-1]+' '+date_now.get('year'));
		// $('#kpi_kum').html(kpi_kum);
		$('#tag_kpi_kum').html('KPI Until '+month[date_now.get('month')-1]+' '+date_now.get('year'));
		$('#total').html(total);
		//stop_waitMe('.wrapper');
	
	});
	
})

// function gaugeChart(active, closed, jumlah){
// 	    Highcharts.chart('container-speed', {
//         chart: {
//             plotBackgroundColor: null,
//             plotBorderWidth: 0,
//             plotShadow: false,
//             backgroundColor: 'rgba(0,255,0,0)',
//             // backgroundColor:'#BDBDBD',
//              // margin: [0,0,0,0],
//              height:300,
//             // width:400,
// 			margin: 0,
// 	        padding: 0,
// 	        spacing: [0, 0, 0, 0]
//         },
//         title: {
//             text:'<div style="text-align:center"><span style="font-size:25px;color:' +
//                     ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">'+jumlah+'</span><br/>' +
//                        '<span style="font-size:12px;color:silver">Project</span></div>',
//             align: 'center',
//             verticalAlign: 'middle',
//             y: 40
//         },
//          credits: {
//              enabled: false
//          },
//         tooltip: {
//             pointFormat: '<b>{point.y}</b> '
//             // pointFormat: '{series.name}: <b>{point.y}</b> '
//         },
//         plotOptions: {
//             pie: {
//                 dataLabels: {
//                     enabled: true,
//                     distance: -50,
//                     style: {
//                         fontWeight: 'bold',
//                         color: 'white'
//                     }
//                 },
//                 startAngle: -90,
//                 endAngle: 90,
//                 center: ['50%', '75%']
//             }
//         },
//         series: [{
//             type: 'pie',
//             // name: 'Jumlah',
//             innerSize: '50%',
//             data: [{
//                     name : 'Low Perform',
//                     color: "#f64747",
//                     y: active
//                   },
//                   {
//                     name : 'Good Perform',
//                     color: "#6fc962",
//                     y: closed
//                   }
//                   ,
              
//                 {
//                     name: 'Proprietary or Undetectable',
//                     y: 0.1,
//                     dataLabels: {
//                         enabled: false
//                     }
//                 }
//             ]
//         }]
//     });
// }



