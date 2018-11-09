var urlDev = 'http://par4digma.semenindonesia.com/api/';

function numberFormat(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function equivalen(selmonth, selyear, opco){
	var Url = $.getJSON(urlDev+'index.php/cashflow_liquidity/get_saldo?month='+selmonth+'&year='+selyear+'&comp=ALL', function(data){
    	for(var i=0; i<data.length;i++){
    		if(data[i].ID == 'ALL.'+opco){
    			var value=0;
				var currentdate = new Date(); 
				if(selmonth == currentdate.getMonth()+1 &&  i<currentdate.getDate()){
	    			value = numberFormat((data[i].VALUE[currentdate.getDate()-1]/1000000));
				}else{
	    			var lastdate = data[i].VALUE.length -1;
	    			value = numberFormat((data[i].VALUE[lastdate]/1000000));
				}
				$('#equivalen').html(value);
				graphic_saldo(data[i].VALUE);
    		}
    	}
	});
}
function slickCarousel() {
  $('#saldoperkurs').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    autoplay: true,
    dots: true,
    arrow:false,
    autoplaySpeed: 3000
  });
}
function destroyCarousel() {
  if ($('#saldoperkurs').hasClass('slick-initialized')) {
    $('#saldoperkurs').slick('destroy');
  }      
}
function highlight(selmonth, selyear, opco){
	var tmp = '';
	var Url = $.getJSON(urlDev+'index.php/cashflow_liquidity/get_saldo?month='+selmonth+'&year='+selyear+'&comp='+opco, function(data){
    	destroyCarousel();
    	tmp = '';
    	var d = new Date()
    	var day = d.getDate()-1;
		for(var i=0; i<data.length;i++){
			tmp += '<div class="col-xs-4" style="border-right:1px solid #CCCCCC;padding:0;">'
				tmp += '<img src="img/ic-'+data[i].JENIS+'.png" style="width:40px;">'
				tmp += '<p class="inex" style="color:#5d5d5d;">'+numberFormat(data[i].VALUE[day])+'</p>'
				tmp += '<span class="inex_down" style="padding:0;display:block;width:100%;"><h6>In '+data[i].JENIS+'</h6></span>'
			tmp += '</div>'
		}
		$('#saldoperkurs').html(tmp);
		slickCarousel();
	});
}

var labelArrayDay = [];
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}
function graphic_saldo(dataJson){
	var saldo = [];
	for (var x=0;x<dataJson.length;x++) {
		saldo.push(parseFloat(dataJson[x]));
	}
	$('#chart_eqv').highcharts({
		chart: {
			type: 'column',
			spacingBottom: 8,
			spacingTop: 8,
			spacingLeft: 5,
			spacingRight: 5,
			animation: Highcharts.svg
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: labelArrayDay,
			tickInterval: 1,
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			}
		},
		tooltip: {
			formatter: function () {
				var n = this.y;
				var s = this.series.name;
				var t = this.point.x + 1;
				return s + ' Tgl ' + t + ' :<br><span style="font-size:12px;font-weight:bold;">'+setFormat((n/1000000), 0)+'</span><b style="font-size:10px; opacity:.6"> (In IDR mio)</b>';
			}

		},
		exporting: {
			enabled: false
		},
		legend: {
			enabled: false,
			align: 'center',
		},
		credits: {
			enabled: false
		},
		plotOptions: {
			column: {
				grouping: false,
				shadow: false,
				borderWidth: 0
			}
		},
		series: [{
			type: 'spline',
			name: 'Saldo',
			color: '#D91E18',
			data : saldo,
		}]
	});
}


function showkurs(selmonth, selyear, opco){
	$('#data-kurs').empty();
	var Url = $.getJSON(urlDev+'index.php/cashflow_liquidity/get_kurs?date='+selyear+''+selmonth, function(data){
    	
    	var vnd = data['VND'];
    	var dkk = data['DKK'];
    	var sgd = data['SGD'];
    	var aud = data['AUD'];
    	var usd = data['USD'];
    	var chf = data['CHF'];
    	var eur = data['EUR'];
    	var gbp = data['GBP'];
    	var jpy = data['JPY'];

    		console.log(1);
    	if(opco=="2000"){
    		var i=1;
    		for(var j in data){
	    		graphic_kurs(i, j, data[j]);
	    		i++;
    		}
    	}else if(opco=="3000"){
    		var kurs_total = 4;
    		var data_kurs;
    		var name;
    		for(var i=0; i<kurs_total; i++){
    			if(i==0){
    				data_kurs = chf;
    				name='CHF';
    			}else if(i==1){
    				data_kurs = eur;
    				name='EUR';
    			}else if(i==2){
    				data_kurs = sgd;
    				name='SGD';
    			}else{
    				data_kurs = usd;
    				name='USD';
    			}
    			graphic_kurs(i, name, data_kurs);
    		}
    	}else if(opco="4000"){
    		var kurs_total = 5;
    		var data_kurs;
    		var name;
    		for(var i=0; i<kurs_total; i++){
    			if(i==0){
    				data_kurs = aud;
    				name='AUD';
    			}else if(i==1){
    				data_kurs = eur;
    				name='EUR';
    			}else if(i==2){
    				data_kurs = gbp;
    				name='GBP';
    			}else if(i==3){
    				data_kurs = jpy;
    				name='JPY';
    			}else{
    				data_kurs = usd;
    				name='USD';
    			}
    			graphic_kurs(i, name, data_kurs);
    		}
    	}else if(opco="5000"){
    		console.log(1);
    		var kurs_total = 2;
    		var data_kurs;
    		var name;
    		for(var i=0; i<kurs_total; i++){
    			if(i==0){
    				data_kurs = eur;
    				name='EUR';
    			}else{
    				data_kurs = usd;
    				name='USD';
    			}
    			graphic_kurs(i, name, data_kurs);
    		}
    	}else if(opco="6000"){
    		var kurs_total = 2;
    		var data_kurs;
    		var name;
    		for(var i=0; i<kurs_total; i++){
    			if(i==0){
    				data_kurs = usd;
    				name='EUR';
    			}else{
    				data_kurs = vnd;
    				name='VND';
    			}
    			graphic_kurs(i, name, data_kurs);
    		}
    	}else if(opco="7000"){
    		var kurs_total = 2;
    		var data_kurs;
    		var name;
    		for(var i=0; i<kurs_total; i++){
    			if(i==0){
    				data_kurs = eur;
    				name='EUR';
    			}else{
    				data_kurs = usd;
    				name='USD';
    			}
    			graphic_kurs(i, name, data_kurs);
    		}
    	}
	});
}
function graphic_kurs(no, name, data_kurs){
	var kurs = [];
	for (var i in data_kurs) {
		kurs.push(parseFloat(data_kurs[i]['KURS']));
	}
	var tmpl = "";
	tmpl+='<div>'
		tmpl+='<div class="col-xs-12" align="left" style="">'
	        tmpl+='<i class="fa fa-bar-chart" aria-hidden="true"></i>'
	        tmpl+='<span style=""> &nbsp; Kurs Tengah BI ('+name+' 1,-)<i style="float:right; font-style:normal;">Today: Rp.'+setFormat(kurs[kurs.length-1], 0)+'</i></span>'
	    tmpl+='</div>'
	    tmpl+='<div style="width:100%;overflow-x:scroll;">'
	        tmpl+='<div class="chart_full" id="kurs'+no+'"></div>'
	    tmpl+='</div>';
    tmpl+='</div>';
    $('#data-kurs').append(tmpl);
	$('#kurs'+no).highcharts({
		chart: {
			type: 'column',
			spacingBottom: 8,
			spacingTop: 8,
			spacingLeft: 5,
			spacingRight: 5,
			animation: Highcharts.svg
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: labelArrayDay,
			tickInterval: 1,
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			}
		},
		tooltip: {
			formatter: function () {
				var n = this.y;
				var s = this.series.name;
				var t = this.point.x + 1;
				return s + ' Tgl ' + t + ' :<br>' + setFormat(n, 0);
			}

		},
		exporting: {
			enabled: false
		},
		legend: {
			enabled: false,
			align: 'center',
		},
		credits: {
			enabled: false
		},
		plotOptions: {
			column: {
				grouping: false,
				shadow: false,
				borderWidth: 0
			}
		},
		series: [{
			type: 'spline',
			name: 'Kurs',
			color: '#D91E18',
			data : kurs,
		}]
	});
}


var labelArrayMonth=['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
function graphic_deposito(data){
	var deposito =[];
		for (var i = 0; i < data['DEPOSITO'].length; i++) {
			deposito.push(((data['DEPOSITO'][i].NILAI == null) ? 0 : parseFloat(data['DEPOSITO'][i].NILAI)))
		}
	$('#chart4').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: labelArrayMonth,
			tickInterval: 1,
			gridLineWidth: 1
		},
		yAxis: {
			title: {
				text: ''
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		exporting: {
			enabled: false
		},
		legend: {
			enabled: false
		},
		credits: {
			enabled: false
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [
		{
			showInLegend: false,
			name: 'Deposito',
			color:'#E9D460',
			// data: [123, 345, 231]
			data: deposito


		}
		]
	});
}

function opcoGroup(selmonth, selyear, opco){

	var days = daysInMonth(selmonth,selyear);
	for (var x = 1; x <= days; x++) {
		if (x < 10) {
			var tgl = '0' + x;
		} else {
			var tgl = x;
		}
		labelArrayDay.push(tgl);
	}
	
    $('#data-kurs').html('');
    run_waitMe('.wrapper', 'ios');
    equivalen(selmonth, selyear, opco);
	highlight(selmonth, selyear, opco);
	showkurs(selmonth, selyear, opco);
	stop_waitMe('.wrapper');
}