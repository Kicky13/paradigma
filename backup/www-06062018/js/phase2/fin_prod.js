function view(selyear, selmonth){
	$('#cashonhand').html('');
	$('#cash').html('');
	$('#cashin').html('');
	$('#cashout').html('');

	// var Url = $.getJSON('http://par4digma.semenindonesia.com/api/index.php/finance_prod/show?time='+selyear+'.'+selmonth, function(data){
	var Url = $.getJSON('http://10.15.5.150/dev/par4digma/api/index.php/finance_prod/show?time='+selyear+'.'+selmonth, function(data){
		console.log(data);
	});
	
}
view('2018', '03');