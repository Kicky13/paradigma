$(function(){
	$('.table tbody').empty();
	// $.post(url_src+'/api/index.php/Project', function(data){
	$.post(url_src+'/api/index.php/Project_dash/', function(data){
		var dataJson  = JSON.parse(data);
		var num = 0;
		
		$.each(dataJson, function(i, result){
			num++;
			pic = i;
			project = dataJson[i].project;
			pic_project = dataJson[i].pic;
			
			budget_bagi = dataJson[i].project_budget/1000000;
			commit_bagi = dataJson[i].commit/1000000;
			cash_out_bagi = dataJson[i].cash_out/1000000;

		    budget_fix = budget_bagi.toFixed(0);
		    commit_fix = commit_bagi.toFixed(0);
			cash_out_fix = cash_out_bagi.toFixed(0);

			budget = FormatNumberBy3(budget_fix, ",",".");
			commit = FormatNumberBy3(commit_fix, ",",".");
			cash_out = FormatNumberBy3(cash_out_fix, ",",".");
			
			//tot_project = FormatNumberBy3(dataJson[i].jumlah_project, ",",".");

			addRow(num, pic, project, budget, commit,cash_out);
			//addRow(i, nama,subnama, pic, progress, issue);
		});

		// console.log('budget:',budget);
	
	});
	
})


function addRow(num,pic, project, budget, commit, cash_out){

	$('.table tbody').append(
		'<tr onclick="show(\''+project+'\')" ><td>'+num+'</td> <td>'+pic_project+'</td> <td valign="middle"><div align="left">'+project+'</div></td> <td valign="middle"><div align="center">'+budget+'</div></td>  </td><td valign="middle"><div align="center">'+commit+'</div></td><td valign="middle"><div align="center">'+cash_out+'</td><td ><div align="center"><i class="fa fa-ellipsis-v" aria-hidden="true" style="color: #909090;"></i></div>  </td></tr> ' 		
		
		);

}

function show(name) {
	
	// alert(name);

	console.log(name);
	sessionStorage.setItem('name', name);
 	window.location = 'ppj_project_detail.html';
}
