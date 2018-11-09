
function balance_data(bulan, opco){
	run_waitMe('.headsix add_fix', 'ios');

	var param = (opco!='SMI')?'&company='+opco:'';
  var nowdate = moment();

	$('#tag_current_balance').html(month[bulan-1]);
	$('#tag_last_balance').html(month[bulan-2]);
	$('#tag_past_balance').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[bulan-1]);
	$('#tag_chart_past').html(month[bulan-2]);
	// $.post(url_src+'/api/index.php/Project', function(data){
  if (sessionStorage.getItem('balance_data'+bulan)==null) {
  	$.post(url_src+'par4digma/api/index.php/balance?bulan='+bulan+param, function(data){
      console.log(data);
      sessionStorage.setItem('balance_data'+bulan, data);
      sessionStorage.setItem('last_balance_data', moment().format('MM/DD/YYYY HH:mm'));
      var dataJson  = JSON.parse(data);

    	tagHtmlBalanceSheet(dataJson);
    	console.log(dataJson);

    	dataLineChart(bulan, opco);

  	
  	});
  }else {
    var data = sessionStorage.getItem('balance_data'+bulan);
    var dataJson  = JSON.parse(data);

      tagHtmlBalanceSheet(dataJson);
      console.log(dataJson);

      dataLineChart(bulan, opco);

    // company_balance(bulan);
  }
    

}

function tagHtmlBalanceSheet(dataJson){

       $.each(dataJson.ratio, function(i, result){
            $.each(result, function(key, value){
            console.log(key+'->'+value);

            $('#'+key).html(setFormat(value, 2)+ ' %');

            });
          });

      var asset_now = Number(dataJson.asset.now.jmlh_aset)/1000000000;
      var asset_last = Number(dataJson.asset.last.jmlh_aset)/1000000000;
      var asset_past = Number(dataJson.asset.past.jmlh_aset)/1000000000;
      $('#curr_asset').html(setFormat(asset_now, 2)+' B');
      $('#last_asset').html(setFormat(asset_last, 2)+' B');
      $('#past_asset').html(setFormat(asset_past, 2)+' B');

      var liab_now = Number(dataJson.liability.now.total_liabilitas)/1000000000;
      var liab_last = Number(dataJson.liability.last.total_liabilitas)/1000000000;
      var liab_past = Number(dataJson.liability.past.total_liabilitas)/1000000000;
      $('#curr_liab').html(setFormat(liab_now, 2)+' B');
      $('#last_liab').html(setFormat(liab_last, 2)+' B');
      $('#past_liab').html(setFormat(liab_past, 2)+' B');

      var equ_now = Number(dataJson.equity.now.total)/1000000000;
      var equ_last = Number(dataJson.equity.last.total)/1000000000;
      var equ_past = Number(dataJson.equity.past.total)/1000000000;
      $('#curr_equ').html(setFormat(equ_now, 2)+' B');
      $('#last_equ').html(setFormat(equ_last, 2)+' B');
      $('#past_equ').html(setFormat(equ_past, 2)+' B');

      chartDonut('donut1', liab_now , equ_now, ['#FCFDA7', '#E4E960']);
      chartDonut('donut2', liab_last , equ_last, ['#FDA7A7', '#E96060']);

}

function nextPage(bulanSekarang, tahun){

  sessionStorage.setItem('bln', bulanSekarang);

  window.location.href = "balance_s_dt.html";
}
function refresh(html){
     sessionStorage.removeItem('bs_dt');
     window.location.href = html+".html";
     // loadData(tahun, '05', '7000');
}

function loadData(tahun, bulan, company){
    var tmp = bulan;
    var bln = parseInt(tmp);


    var nowdate = moment();
    var checkdate = moment('12-16-2016 14:30');
    // console.log("now :"+nowdate+" last :"+checkdate+" [last update "+checkdate.from(nowdate)+" ]");

    if (sessionStorage.getItem('bln')!=null) {
      var data = sessionStorage.getItem('bln');

      // var dataParse = JSON.parse(data);
      console.log(data);
      bln = parseInt(data);

    }
   
    console.log(bln);
     $('#tag_current_month').html(month[bln-1]);
    $('#headerSelectedMonth1').html(month[bln-1]+' '+tahun);
    $('#headerSelectedMonth2').html(month[bln-1]+' '+tahun);
    $('#headerSelectedMonth3').html(month[bln-1]+' '+tahun);

    $('#asset').addClass('hidden');
    $('#liability').addClass('hidden');
    $('#equity').addClass('hidden');
   run_waitMe('.wrapper','ios');

   // console.log(sessionStorage.getItem('bs_dt'));

   if (sessionStorage.getItem('bs_dt'+bln)==null) {
         $.ajax({
        url: url_src+'par4digma/api/index.php/balance/dt?tahun='+tahun+'&bulan='+bulan+'&company='+company,
        type: 'GET',
        success: function (data) {
            sessionStorage.setItem('bs_dt', 'not null');
            sessionStorage.setItem('bs_dt'+bln, data);
            // sessionStorage.setItem('last_bs_dt', moment().format('MM/DD/YYYY HH:mm'));
          var dataJson = JSON.parse(data);
         
          setTagHTML(dataJson);

        

            // var equity_liability_now_total = (Number(dataJson.total_liability_equity.now))/1000000;
            // var equity_liability_last_total = (Number(dataJson.total_liability_equity.last))/1000000;
            
            // $("#equity_liability_last_total").html(FormatNumberBy3(equity_liability_last_total.toFixed(2)),",", "."+'<font size="3"> </font>');
            // $("#equity_liability_now_total").html(FormatNumberBy3(equity_liability_now_total.toFixed(2)),",", "."+'<font size="3"> </font>');
             stop_waitMe('.wrapper');
          } 
      }).done(function (data) {
        // console.log('get done'+data);
      }).fail(function () {

    });
   }else {
        var data = sessionStorage.getItem('bs_dt'+bln);
        var dataJson = JSON.parse(data);

        setTagHTML(dataJson);
         stop_waitMe('.wrapper');
   }

    var datesafe = moment(sessionStorage.getItem('last_bs_dt'));
    $('#last_update').html('last update : ' + datesafe.from(nowdate));

   

  
}

function setTagHTML(dataJson){
          console.log(dataJson);

          $.each(dataJson.ratio, function(i, result){
            $.each(result, function(key, value){
            console.log(key+'->'+value);

            $('#'+key).html(setFormat(value, 2)+ ' %');

            });
          });

         //asset
            $.each(dataJson.asset.now,function(data){
                  var x = (Number(dataJson.asset.now[data]))/1000000;

                  console.log(data + " " + x);

                     $("#asset_last_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')
            });

             $.each(dataJson.asset.last,function(data){
                  var x = (Number(dataJson.asset.last[data]))/1000000;

                  console.log(data + " " + x);

                  $("#asset_now_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')

            });
            //liability
             $.each(dataJson.liability.now,function(data){
                  var x = (Number(dataJson.liability.now[data]))/1000000;

                  console.log(data + " " + x);

                  $("#liability_last_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')
            });

             $.each(dataJson.liability.last,function(data){
                  var x = (Number(dataJson.liability.last[data]))/1000000;

                  console.log(data + " " + x);

                  $("#liability_now_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')
            });
             //equity
             //
              $.each(dataJson.equity.now,function(data){
                  var x = (Number(dataJson.equity.now[data]))/1000000;

                  console.log(data + " " + x);

                  $("#equity_last_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')
            });

             $.each(dataJson.equity.last,function(data){
                  var x = (Number(dataJson.equity.last[data]))/1000000;

                  console.log(data + " " + x);

                  $("#equity_now_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')
            });
             var asset_total = Number(dataJson.asset.now.jmlh_aset)/1000000;
             var equity_total = Number(dataJson.equity.now.total)/1000000;
             var liab_total = Number(dataJson.liability.now.total_liabilitas)/1000000;

             $('#tag_asset_now_total').html(setFormat(asset_total, 2));
             $('#tag_liab_now_total').html(setFormat(liab_total, 2));
             $('#tag_equ_now_total').html(setFormat(equity_total, 2));

             // chartDonut2('donut2', liab_total, equity_total);
}


function dataLineChart(bulan, opco){
	// run_waitMe('#line', 'facebook');
	var param = (opco!='SMI')?'&company='+opco:'';

  var tahun = moment().format('YYYY');
  var last_date = (tahun-1)+'.12';
	// $.post(url_src+'/api/index.php/Project', function(data){
  if (sessionStorage.getItem('monthly'+bulan)==null) {
	$.post(url_src+'par4digma/api/index.php/balance/monthly?bulan='+bulan+param, function(data){
    sessionStorage.setItem('monthly'+bulan, data);
		var dataJson  = JSON.parse(data);
    setTagHtmlLineChart(dataJson, last_date);
		console.log(dataJson);
		var tag;


	
	});

  }else{

    var data = sessionStorage.getItem('monthly'+bulan);
    var dataJson  = JSON.parse(data);
    setTagHtmlLineChart(dataJson, last_date);


  }
}
function setTagHtmlLineChart(dataJson, last_date){
    var past =[];
    var current=[];

    $.each(dataJson, function(i, result){
        console.log(last_date+'->'+result[last_date]);


      $.each(result, function(date, value){
        console.log(date+'->'+result[date]);
        console.log(date+'->'+result[last_date]);


        if (date!=last_date) {
          current.push( (Number(result[date])/1000000) );
          past.push( (Number(result[last_date])/1000000) );
        }
      })
     

    })
    // past_data = dataJson[opco][(tahun-1)+'.12'];
    // currData = dataJson[opco];
    // past = [past_data,past_data,past_data,past_data,past_data,past_data,past_data,past_data,past_data,past_data,past_data,past_data];
    // current = [
    //  (currData[tahun+'.01']==null)?0:currData[tahun+'.01'],
    //  (currData[tahun+'.02']==null)?0:currData[tahun+'.02'],
    //  (currData[tahun+'.03']==null)?0:currData[tahun+'.03'],
    //  (currData[tahun+'.04']==null)?0:currData[tahun+'.04'],
    //  (currData[tahun+'.05']==null)?0:currData[tahun+'.05'],
    //  (currData[tahun+'.06']==null)?0:currData[tahun+'.06'],
    //  (currData[tahun+'.07']==null)?0:currData[tahun+'.07'],
    //  (currData[tahun+'.08']==null)?0:currData[tahun+'.08'],
    //  (currData[tahun+'.09']==null)?0:currData[tahun+'.09'],
    //  (currData[tahun+'.10']==null)?0:currData[tahun+'.10'],
    //  (currData[tahun+'.11']==null)?null:currData[tahun+'.11'],
    //  (currData[tahun+'.12']==null)?null:currData[tahun+'.12']
    // ]
    console.log(past);
    console.log(current);
    chartline(past, current);
    // stop_waitMe('#line');
    stop_waitMe('.headsix add_fix');
}

function chartline(past_data, monthly){
	 Highcharts.chart('line', {
        title: {
            text: ''
        },
        
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' T'
        },
        legend: {
            borderWidth: 0,
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            //shadow: true
        },
        credits: {
                    enabled: false
                },
        series: [{
            name: 'Current',
            data: monthly,
            color: '#EF4836',
            type: 'spline'
        }, {
            name: 'Dec last Year',
            data: past_data,
            color: '#E9D460',
            type: 'spline'
        }]
    });
}
function chartDonut(tag, liab, equ, color){
	 Highcharts.chart(tag, {
        chart: {
            backgroundColor: 'rgba(0, 255, 0, 0)',
            type: 'pie',
            margin : [0, 0, 0, 0],
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        // colors: ['#FDA7A7', '#E96060'],
         colors: color,
        title: {
            text: ''
        },
        credits: {
                    enabled: false
                },
	       exporting: {
                    enabled: false
                },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                innerSize: 40,
                depth: 25,
                showInLegend: true
            }
        },
        series: [{
            name: 'Amount',
            data: [
                ['liability', liab],
                ['Equity', equ],
            ]
        }]
    });
}
function chartDonut2(tag, liab, equ){
    Highcharts.chart(tag, {
        chart: {
            backgroundColor: 'rgba(0, 255, 0, 0)',
            type: 'pie',
            margin : [0, 0, 0, 0],
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        colors: ['#EC644B', '#F1A9A0'],
        title: {
            text: ''
        },
        credits: {
                    enabled: false
                },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                innerSize: 40,
                depth: 25,
                showInLegend: true
            }
        },
        exporting: {
                    enabled: false
                },
        series: [{
            name: 'Amount',
            data: [
                ['Liability', liab],
                ['Equity', equ],
            ]
        }]
    });
}

function company_balance(bulan){

    run_waitMe('#table_opco', 'ios');

  
    $.post(url_src+'par4digma/api/index.php/balance/company_balance?bulan='+bulan, function(data){
        var dataJson  = JSON.parse(data);

        var asset_data = dataJson.asset.now;
        var liab_data = dataJson.liability.now;
        var equ_data = dataJson.equity.now;
        console.log(asset_data);
        console.log(liab_data);
        console.log(equ_data);

        $.each(asset_data, function(i, result){
            var value = Number(result.jmlh_aset)/1000000000;
            console.log(i +'-> '+value);
            $('#'+i+'_asset').html(setFormat(value, 2));
        });
        $.each(liab_data, function(i, result){

            var value = Number(result.total_liabilitas)/1000000000;
            console.log(i +'-> '+value);

            $('#'+i+'_liab').html(setFormat(value, 2));
        });
        $.each(equ_data, function(i, result){

            var value = Number(result.total)/1000000000;
            console.log(i +'-> '+value);

            $('#'+i+'_equ').html(setFormat(value, 2));
        });



        console.log(dataJson);

        
        stop_waitMe('#table_opco');
    
    });

}