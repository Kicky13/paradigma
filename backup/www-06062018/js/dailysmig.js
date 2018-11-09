$(function (){
	$.ajax({
		url: url_src+'/SDDaily.php',
		//url: 'SDDaily.json',
        type: 'GET',
        success: function (data) {
        	var data1 = data.replace("<title>Json</title>", "");
            var data2 = data1.replace("(", "[");
            var data = data2.replace(");", "]");
        	var obj = jQuery.parseJSON(data);
        	var realdc = 0;
        	var realdz = 0;
        	var y = new Date().getFullYear();
        	var bulan = new Date().getMonth();
        	// console.log(bulan);
        	
        	//console.log(y);
        	$('#month').change(function(){
    		//var m = $(this).val();
        	var m = $('#month').val();
        	var month = Number(m)+1;
        	if (month < 10){
		     var a = '0'+month;
		    }else{
		     var a = month; 
		    }
        	// console.log(month);
        	// console.log(obj);
        
        	//console.log(month);
        	var s = '';
        	var date = [];
        	var realc = [];
        	var realz = [];
        	var realcurah = [];
        	var realzak = [];
        	
        	for (var b=1;b<32;b++){
		    if (b < 10){
		     var s = '0'+b;
		    }else{
		     var s = b; 
		    }
        	//console.log (obj);
        	var tgl = y+a.toString()+s;
        	$('#tgl').html(tgl);
        	//console.log(tgl);
        	$.each(obj, function(key, val){		
        		$.each(val, function(key2, val2){
        			$.each(val2, function(key3, val3){
        				$.each(val3, function(key4, val4){
        				        	//console.log (key3+' '+val3);
        				        	//console.log(key3);
        	if(key == '7000'){
        		if(key2 == 'curah' ){
		     	 	if(key3 == tgl){
		     	 		//console.log(val3);
		     		 	if (key4 == 'real'){
		      	
		         //console.log(key3); 
		        realdc += Number(val4);
		        realcurah = Number(val4);
		         date.push(s);
		         realc.push(Number(val4));
		         $('#realdc').html(FormatNumberBy3(realdc.toFixed(2)),",", ".");
		         $('#realcurah').html(FormatNumberBy3(realcurah.toFixed(2)),",", ".");
		         //console.log(reald);
		         // rkapv.push(Number(val3));
		         // rkapv7000 = Number(val3);
		         // $('#rkapv7000').html(rkapv7000.toFixed(2)+' K');
		         }
		     }
		      }
		  }
		  if(key == '7000'){
        		if(key2 == 'zak' ){
		     	 	if(key3 == tgl){
		     	 		//console.log(key3);
		     		 	if (key4 == 'real'){
		      	
		         //console.log(key3); 
		        realdz += Number(val4);
		        realzak = Number(val4);
		         realz.push(Number(val4));
		         $('#realdz').html(FormatNumberBy3(realdz.toFixed(2)),",", ".");
		         $('#realzak').html(FormatNumberBy3(realzak.toFixed(2)),",", ".");
		         //console.log(reald);
		         // rkapv.push(Number(val3));
		         // rkapv7000 = Number(val3);
		         // $('#rkapv7000').html(rkapv7000.toFixed(2)+' K');
		         }
		     }
		      }
		  }
		  var total_real = realdz+realdc;
		  $('#total_real').html(FormatNumberBy3(total_real.toFixed(2)),",", ".");
		  var actual = total_real;
		  $('#actual').html((FormatNumberBy3(actual.toFixed(2))).replace(/,/g,'.'));
		  var total = realc + realz;
		  $('#total').html((FormatNumberBy3(total)).replace(/,/g,'.'));

		})
        			})
   })
        		})
			// var res1 = Number(realc);
   //          var res2 = Number(realz);
   //          var res =  res1 + res2;
   //          console.log(res1);
   //          var isi2 = '<tr ><td align="center">' + tgl + '</td><td align="right"> ' + FormatNumberBy3(res1, ",", ".") + ' </td><td align="right"> ' + FormatNumberBy3(res2, ",", ".") + ' </td><td align="right"><font color="red"> ' + FormatNumberBy3(res, ",", ".") + '</font></td></tr>';
   //          $('#isidetail').html(isi2);
   //          console.log(isi2);
        	}
        	

        	$('#chartku').highcharts({
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                chart: {
                    backgroundColor: 'rgba(0, 255, 0, 0)',
                    polar: true
                },
                xAxis: {
                    categories: date
                },
                plotOptions: {
                    series: {
                        states: {
                            hover: {
                                enabled: false
                            }
                        }
                    }
                },
                yAxis:{
                    title: ''
                },
                series: [{
                        type: 'column',
                        name: 'Bulk',
                        color: '#4c9ed9',
                        data: realc,
                        stacking: 'normal'
                    },
                    {
                        type: 'column',
                        name: 'Bag',
                        color: '#2b82ad',
                        data: realz,
                        stacking: 'normal'
                    }]


            });
        })
        
	}
        		})

$.ajax({
		url: url_src+'/SDDaily.php',
		//url: 'SDDaily.json',
        type: 'GET',
        success: function (data) {
        	var data1 = data.replace("<title>Json</title>", "");
            var data2 = data1.replace("(", "[");
            var data = data2.replace(");", "]");
        	var obj = jQuery.parseJSON(data);
        	var realdc = 0;
        	var realdz = 0;
        	var y = new Date().getFullYear();
        	var bulan = new Date().getMonth();
        	// console.log(bulan);
        	
        	//console.log(y);
        	$('#month').change(function(){
    		//var m = $(this).val();
        	var m = $('#month').val();
        	var month = Number(m)+1;
        	if (month < 10){
		     var a = '0'+month;
		    }else{
		     var a = month; 
		    }
        	// console.log(month);
        	// console.log(obj);
        
        	//console.log(month);
        	var s = '';
        	var date = [];
        	var realc = [];
        	var realz = [];
        	var realcurah = [];
        	var realzak = [];
        	
        	for (var b=1;b<32;b++){
		    if (b < 10){
		     var s = '0'+b;
		    }else{
		     var s = b; 
		    }
        	//console.log (obj);
        	var tgl = y+a.toString()+s;
        	$('#tgl').html(tgl);
        	//console.log(tgl);
        	$.each(obj, function(key, val){		
        		$.each(val, function(key2, val2){
        			$.each(val2, function(key3, val3){
        				$.each(val3, function(key4, val4){
        				        	//console.log (key3+' '+val3);
        				        	//console.log(key3);
        	if(key == '7000'){
        		if(key2 == 'curah' ){
		     	 	if(key3 == tgl){
		     	 		//console.log(val3);
		     		 	if (key4 == 'real'){
		      	
		         //console.log(key3); 
		        realdc += Number(val4);
		        realcurah = Number(val4);
		         date.push(s);
		         realc.push(Number(val4));
		         $('#realdc').html(FormatNumberBy3(realdc.toFixed(2)),",", ".");
		         $('#realcurah').html(FormatNumberBy3(realcurah.toFixed(2)),",", ".");
		         //console.log(reald);
		         // rkapv.push(Number(val3));
		         // rkapv7000 = Number(val3);
		         // $('#rkapv7000').html(rkapv7000.toFixed(2)+' K');
		         }
		     }
		      }
		  }
		  if(key == '7000'){
        		if(key2 == 'zak' ){
		     	 	if(key3 == tgl){
		     	 		//console.log(key3);
		     		 	if (key4 == 'real'){
		      	
		         //console.log(key3); 
		        realdz += Number(val4);
		        realzak = Number(val4);
		         realz.push(Number(val4));
		         $('#realdz').html(FormatNumberBy3(realdz.toFixed(2)),",", ".");
		         $('#realzak').html(FormatNumberBy3(realzak.toFixed(2)),",", ".");
		         //console.log(reald);
		         // rkapv.push(Number(val3));
		         // rkapv7000 = Number(val3);
		         // $('#rkapv7000').html(rkapv7000.toFixed(2)+' K');
		         }
		     }
		      }
		  }
		  var total_real = realdz+realdc;
		  $('#total_real').html(FormatNumberBy3(total_real.toFixed(2)),",", ".");
		  var actual = total_real;
		  $('#actual').html((FormatNumberBy3(actual.toFixed(2))).replace(/,/g,'.'));
		  var total = realc + realz;
		  $('#total').html((FormatNumberBy3(total)).replace(/,/g,'.'));

		})
        			})
   })
        		})
			// var res1 = Number(realc);
   //          var res2 = Number(realz);
   //          var res =  res1 + res2;
   //          console.log(res1);
   //          var isi2 = '<tr ><td align="center">' + tgl + '</td><td align="right"> ' + FormatNumberBy3(res1, ",", ".") + ' </td><td align="right"> ' + FormatNumberBy3(res2, ",", ".") + ' </td><td align="right"><font color="red"> ' + FormatNumberBy3(res, ",", ".") + '</font></td></tr>';
   //          $('#isidetail').html(isi2);
   //          console.log(isi2);
        	}
        	

        	$('#chartku').highcharts({
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                chart: {
                    backgroundColor: 'rgba(0, 255, 0, 0)',
                    polar: true
                },
                xAxis: {
                    categories: date
                },
                plotOptions: {
                    series: {
                        states: {
                            hover: {
                                enabled: false
                            }
                        }
                    }
                },
                yAxis:{
                    title: ''
                },
                series: [{
                        type: 'column',
                        name: 'Bulk',
                        color: '#4c9ed9',
                        data: realc,
                        stacking: 'normal'
                    },
                    {
                        type: 'column',
                        name: 'Bag',
                        color: '#2b82ad',
                        data: realz,
                        stacking: 'normal'
                    },
                    {
                        type: 'line',
                        name: 'Bulk RKAP',
                        color: '#2b82ad',
                        data: [1234, 1254, 2542, 1267, 2763, 2652, 1287, 2671, 1762, 1763, 1726, 7261, 2727, 3821],
                        
                    },{
                        type: 'line',
                        name: 'Bag rkap',
                        color: '#2b82ad',
                        data: [1231, 1628, 1234, 1254, 2542, 1267, 2763, 2652, 1287, 2671, 1762, 1763, 1726, 7261],
                        
                    }]


            }); 
        })
        
	}
        		})
		         
});