
function balance_data(bulan, opco, year){
  var tag_bln = bulan-1;
  var tag_last_bln = tag_bln;
  if (tag_last_bln==0) {
    tag_last_bln = 12;
  }
  console.log(bulan+'-'+tag_last_bln);

	run_waitMe('.headsix', 'ios');
  sessionStorage.setItem('com', opco);
	var param = (opco!='SMI')?'&company='+opco:'';
  var nowdate = moment();
    $('#tag_current_month').html(month[tag_bln]);
	$('#tag_current_balance').html(month[tag_bln]);
	$('#tag_last_balance').html(month[tag_last_bln-1]);
	$('#tag_past_balance').html(month[11]+' '+(tahun-1));
	$('#tag_chart_curr').html(month[tag_bln]);
	$('#tag_chart_past').html(month[tag_last_bln]);
	// $.post(url_src+'/api/index.php/Project', function(data){
  // if (sessionStorage.getItem('balance_data'+bulan)==null) {
  	$.post(url_src+'/api/index.php/balance_report?bulan='+bulan+'&tahun='+tahun+param, function(data){
      // sessionStorage.setItem('balance_data'+bulan, data);
      sessionStorage.setItem('last_balance_data', moment().format('MM/DD/YYYY HH:mm'));
      var dataJson  = JSON.parse(data);

    	tagHtmlBalanceSheet(dataJson);
    	console.log(dataJson);


      dataLineChart(year, bulan, opco);
  	
  	});


  // }else {
  //   var data = sessionStorage.getItem('balance_data'+bulan);
  //   var dataJson  = JSON.parse(data);

  //     tagHtmlBalanceSheet(dataJson);
  //     console.log(dataJson);

  //     dataLineChart(bulan, opco);

  //   // company_balance(bulan);
  // }
    

}

function tagHtmlBalanceSheet(dataJson){

       $.each(dataJson.ratio, function(i, result){
            $.each(result, function(key, value){
            console.log(key+'->'+value);

            $('#'+key).html(setFormat(value, 2)+' ');

            });
          });

      var asset_now = Number(dataJson.asset.now.jmlh_aset)/1000000000;
      var asset_last = Number(dataJson.asset.last.jmlh_aset)/1000000000;
      var asset_past = Number(dataJson.asset.past.jmlh_aset)/1000000000;
      $('#curr_asset').html(setFormat(asset_now, 2));
      $('#last_asset').html(setFormat(asset_last, 2));
      $('#past_asset').html(setFormat(asset_past, 2));

      var liab_now = Number(dataJson.liability.now.total_liabilitas)/1000000000;
      var liab_last = Number(dataJson.liability.last.total_liabilitas)/1000000000;
      var liab_past = Number(dataJson.liability.past.total_liabilitas)/1000000000;
      $('#curr_liab').html(setFormat(liab_now, 2));
      $('#last_liab').html(setFormat(liab_last, 2));
      $('#past_liab').html(setFormat(liab_past, 2));

      var equ_now = Number(dataJson.equity.now.total)/1000000000;
      var equ_last = Number(dataJson.equity.last.total)/1000000000;
      var equ_past = Number(dataJson.equity.past.total)/1000000000;
      $('#curr_equ').html(setFormat(equ_now, 2));
      $('#last_equ').html(setFormat(equ_last, 2));
      $('#past_equ').html(setFormat(equ_past, 2));

      chartDonut('donut1', liab_now , equ_now, ['#FCFDA7', '#E4E960']);
      chartDonut('donut2', liab_last , equ_last, ['#FDA7A7', '#E96060']);

}

function nextPage(month, year){

  sessionStorage.setItem('bln', month);
  sessionStorage.setItem('thn', year);

  window.location.href = "balance_s_dt.html";
}
function refresh(html){
     sessionStorage.removeItem('bs_dt');
     window.location.href = html+".html";
     // loadData(tahun, '05', '7000');
}

function loadData(tahun, bulan, company=null){



    var nowdate = moment();
    // var checkdate = moment('12-16-2016 14:30');
    // console.log("now :"+nowdate+" last :"+checkdate+" [last update "+checkdate.from(nowdate)+" ]");

    if (sessionStorage.getItem('bln')!=null) {
      var data = sessionStorage.getItem('bln');

      // var dataParse = JSON.parse(data);
      console.log(data);
      bulan = parseInt(data);

    }
    if (sessionStorage.getItem('thn')!=null) {
      var data = sessionStorage.getItem('thn');

      // var dataParse = JSON.parse(data);
      console.log(data);
      tahun = parseInt(data);

    }
    if (sessionStorage.getItem('com')!=null && company == null) {
      var data = sessionStorage.getItem('com');

      // var dataParse = JSON.parse(data);
      company = data;

    }

    console.log(bulan+'-'+tahun+'-'+company);

    var tmp = bulan;
    var bln = parseInt(tmp);
    var tag_bln = bulan-1;
    var tag_last_bln = bln-1;
    if (tag_bln==0) {
      tag_last_bln = 12;
    }
   
    console.log(bln);
    // setTable(company);
     $('#tag_current_month').html(month[tag_bln]);
    $('#headerSelectedMonth1').html(month[tag_bln]+' '+tahun);
    $('#headerSelectedMonth2').html(month[tag_bln]+' '+tahun);
    $('#headerSelectedMonth3').html(month[tag_bln]+' '+tahun);

    $('#liability').addClass('hidden');
    $('#equity').addClass('hidden');

   
   run_waitMe('.wrapper','ios');

   // console.log(sessionStorage.getItem('bs_dt'));

   // if (sessionStorage.getItem('bs_dt'+bln)==null) {
         $.ajax({
        url: url_src+'/api/index.php/balance_report?tahun='+tahun+'&bulan='+bulan+'&company='+company,
        type: 'GET',
        success: function (data) {
            // sessionStorage.setItem('bs_dt', 'not null');
            // sessionStorage.setItem('bs_dt'+bln, data);
            // sessionStorage.setItem('last_bs_dt', moment().format('MM/DD/YYYY HH:mm'));
          var dataJson = JSON.parse(data);
         
          setDataDetail(dataJson);

          if (company !=3000) {

            $('#row3000al').addClass('hidden');

            $('#row3000sdp').addClass('hidden');

            $('#row3000sp').addClass('hidden');

            // $('#asset_now_sp').empty();
          }else{
            $('#row3000al').removeClass('hidden');

            $('#row3000sdp').removeClass('hidden');

            $('#row3000sp').removeClass('hidden');


          }

         

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
   // }else {
   //      var data = sessionStorage.getItem('bs_dt'+bln);
   //      var dataJson = JSON.parse(data);

   //      setDataDetail(dataJson);
   //       stop_waitMe('.wrapper');
   // }

    var datesafe = moment(sessionStorage.getItem('last_bs_dt'));
    $('#last_update').html('last update : ' + datesafe.from(nowdate));

   

  
}

function setDataDetail(dataJson){
          console.log(dataJson);

          $.each(dataJson.ratio, function(i, result){
            $.each(result, function(key, value){
            // console.log(key+'->'+value);

            $('#'+key).html(setFormat(value, 2)+ ' %');

            });
          });

         //asset
            $.each(dataJson.asset.now,function(data){
                  var x = (Number(dataJson.asset.now[data]))/1000000;

                  // console.log(data + " " + x);

                     $("#asset_last_"+data).html(setFormat(x, 2)+'<font size="3"> </font>')
            });

             $.each(dataJson.asset.last,function(data){
                  var x = (Number(dataJson.asset.last[data]))/1000000;

                  // console.log(data + " " + x);

                  $("#asset_now_"+data).html(setFormat(x, 2)+'<font size="3"> </font>')

            });
            //liability
             $.each(dataJson.liability.now,function(data){
                  var x = (Number(dataJson.liability.now[data]))/1000000;

                  // console.log(data + " " + x);

                  $("#liability_last_"+data).html(setFormat(x, 2)+'<font size="3"> </font>')
            });

             $.each(dataJson.liability.last,function(data){
                  var x = (Number(dataJson.liability.last[data]))/1000000;

                  // console.log(data + " " + x);

                  $("#liability_now_"+data).html(setFormat(x, 2)+'<font size="3"> </font>')
            });
             //equity
             //
              $.each(dataJson.equity.now,function(data){
                  var x = (Number(dataJson.equity.now[data]))/1000000;

                  // console.log(data + " " + x);

                  $("#equity_last_"+data).html(setFormat(x, 2)+'<font size="3"> </font>')
            });

             $.each(dataJson.equity.last,function(data){
                  var x = (Number(dataJson.equity.last[data]))/1000000;

                  // console.log(data + " " + x);

                  $("#equity_now_"+data).html(setFormat(x, 2)+'<font size="3"> </font>')
            });
             var asset_total = Number(dataJson.asset.now.jmlh_aset)/1000000;
             var equity_total = Number(dataJson.equity.now.total)/1000000;
             var liab_total = Number(dataJson.liability.now.total_liabilitas)/1000000;


             $('#tag_asset_now_total').html(setFormat(asset_total, 2));
             $('#tag_liab_now_total').html(setFormat(liab_total, 2));
             $('#tag_equ_now_total').html(setFormat(equity_total, 2));

             // chartDonut2('donut2', liab_total, equity_total);
}

function setTable(opco){
var taga = '<table class="table table-striped" style="background: white;"> <thead style="font-weight: bold; font-size: 10px;" class="borblue"> <td>ASSET LANCAR</td> <td align="right" id="last"><div id="headerSelectedMonth1">This Month</div></td> <td align="right" id="now">Last Month</td> </thead> <tfoot> </tfoot> <tbody > <tr > <td>Kas dan setara kas</td> <td class="num"><div id="asset_last_kas"></div></td> <td class="num"><div id="asset_now_kas"></div></td> </tr> <tr> <td>Bank yg dibatasi penggunaannya</td> <td class="num"><div id="asset_last_bank"></div></td> <td class="num"><div id="asset_now_bank"></div></td> </tr> <tr> <td>investasi jangka panjang</td> <td class="num"><div id="asset_last_invest"></div></td> <td class="num"><div id="asset_now_invest"></div></td> </tr> <tr> <td>Persediaan -bersih</td> <td class="num"><div id="asset_last_p_lain"></div></td> <td class="num"><div id="asset_now_p_lain"></div></td> </tr> <tr> <td>piutang lain-lain</td> <td class="num"><div id="asset_last_p_bersih"></div></td> <td class="num"><div id="asset_now_p_bersih"></div></td> </tr> <tr> <td>Aset lancar lainya</td> <td class="num"><div id="asset_last_aset_lain"></div></td> <td class="num"><div id="asset_now_aset_lain"></div></td> </tr> <tr class="borblue"> <td>Pajak dibayar dimuka</td> <td class="num"><div id="asset_last_pdd"></div></td> <td class="num"><div id="asset_now_pdd"></div></td> </tr> <tr class="active"> <td style="font-weight: bold;">Jumlah asset lancar</td> <td align="right" style="color: red;"><div id="asset_last_jal"></div></td> <td align="right" style="color: red;"><div id="asset_now_jal"></div></td> </tr> </tbody> <tbody > <tr><td colspan="4"></td></tr> <tr style="font-weight: bold;" class="borblue"> <td>ASSET TIDAK LANCAR</td> <td align="right"></td> <td align="right"></td> </tr> <tr> <td>Aset pajak tangguhan </td> <td class="num"><div id="asset_last_apt"></div></td> <td class="num"><div id="asset_now_apt"></div></td> </tr> <tr> <td>Investasi pada entitas asosiasi</td> <td class="num"><div id="asset_last_ipea"></div></td> <td class="num"><div id="asset_now_ipea"></div></td> </tr> <tr> <td>Properti Investasi</td> <td class="num"><div id="asset_last_pi"></div></td> <td class="num"><div id="asset_now_pi"></div></td> </tr> <tr> <td>Aset tetap :</td> <td class="num"></td> <td class="num"></td> </tr> <tr> <td>- Tanah</td> <td class="num"><div id="asset_last_tanah"></div></td> <td class="num"><div id="asset_now_tanah"></div></td> </tr> <tr> <td>- Bangunan</td> <td class="num"><div id="asset_last_bangunan"></div></td> <td class="num"><div id="asset_now_bangunan"></div></td> </tr> <tr> <td>- Mesin dan peralatan</td> <td class="num"><div id="asset_last_mesin"></div></td> <td class="num"><div id="asset_now_mesin"></div></td> </tr> <tr> <td>- Alat-alat berat dan kendaraan</td> <td class="num"><div id="asset_last_alat2"></div></td> <td class="num"><div id="asset_now_alat2"></div></td> </tr> <tr> <td>- perlengkapan</td> <td class="num"><div id="asset_last_perl"></div></td> <td class="num"><div id="asset_now_perl"></div></td> </tr> <tr> <td>- Asset Leasing</td> <td class="num"><div id="asset_last_al"></div></td> <td class="num"><div id="asset_now_al"></div></td> </tr> <tr> <td>- Sarana dan Prasarana</td> <td class="num"><div id="asset_last_sdp"></div></td> <td class="num"><div id="asset_now_sdp"></div></td> </tr> <tr> <td>- Security Part</td> <td class="num"><div id="asset_last_sp"></div></td> <td class="num"><div id="asset_now_sp"></div></td> </tr>';
var tagb = ' <tr> <td>- Akumulasi penyusutan dan deplesi</td> <td class="num"><div id="asset_last_akum"></div></td> <td class="num"><div id="asset_now_akum"></div></td> </tr> <tr> <td></td> <td class="num" style="font-weight: bold; color: red;"><div id="asset_last_total2"></div></td> <td class="num" style="font-weight: bold; color: red;"><div id="asset_now_total2"></div></td> </tr> <tr> <td>- Pekerjaan dalam pelaksanaan</td> <td class="num"><div id="asset_last_pdp"></div></td> <td class="num"><div id="asset_now_pdp"></div></td> </tr> <tr class="active"> <td>Total aset tetap</td> <td class="num" style="font-weight: bold; color: red;"><div id="asset_last_total_at"></div></td> <td class="num" style="font-weight: bold; color: red;"><div id="asset_now_total_at"></div></td> </tr> <tr><td colspan="4"></td></tr> <tr> <td>Uang muka proyek</td> <td class="num"><div id="asset_last_ump"></div></td> <td class="num"><div id="asset_now_ump"></div></td> </tr> <tr> <td>Beban ditangguhkan -bersih</td> <td class="num"><div id="asset_last_btb"></div></td> <td class="num"><div id="asset_now_btb"></div></td> </tr> <tr> <td>Aset tak berwujud</td> <td class="num"><div id="asset_last_atb"></div></td> <td class="num"><div id="asset_now_atb"></div></td> </tr> <tr> <td>Aset tidak lancar lainya</td> <td class="num"><div id="asset_last_atll"></div></td> <td class="num"><div id="asset_now_atll"></div></td> </tr> <tr class="active"> <td>Jumlah aset tidak lancar</td> <td class="num" style="font-weight: bold; color: red;"><div id="asset_last_total_atl"></div></td> <td class="num" style="font-weight: bold; color: red;"><div id="asset_now_total_atl"></div></td> </tr> <tr class="borblue"><td colspan="4"></td></tr> <tr class="active"> <td>Jumlah Aset</td> <td class="num" style="font-weight: bold; color: red;"><div id="asset_last_jmlh_aset"></div></td> <td class="num" style="font-weight: bold; color: red;"><div id="asset_now_jmlh_aset"></div></td> </tr> </tbody> </table>';

var tag3000 = ' <tr> <td>- Asset Leasing</td> <td class="num"><div id="asset_last_al"></div></td> <td class="num"><div id="asset_now_al"></div></td> </tr> <tr> <td>- Sarana dan Prasarana</td> <td class="num"><div id="asset_last_sdp"></div></td> <td class="num"><div id="asset_now_sdp"></div></td> </tr> <tr> <td>- Security Part</td> <td class="num"><div id="asset_last_sp"></div></td> <td class="num"><div id="asset_now_sp"></div></td> </tr>';

if(opco=='3000'||opco==3000){
  // taga = taga + tag3000;
}

 $('#tagTable').html(taga+tagb);
}


function dataLineChart(year, bulan, opco){
	// run_waitMe('#line', 'facebook');
	var param = (opco!='SMI')?'&company='+opco:'';

  var tahun = moment().format('YYYY');
  var last_date = (year-1)+'.12';
	// $.post(url_src+'/api/index.php/Project', function(data){
  // if (sessionStorage.getItem('monthly'+bulan)==null) {
	$.post(url_src+'/api/index.php/balance_report/monthly?bulan='+bulan+'&tahun='+year+param, function(data){
    // sessionStorage.setItem('monthly'+bulan, data);
		var dataJson  = JSON.parse(data);
    setTagHtmlLineChart(dataJson, last_date);
		console.log(dataJson);
		var tag;


	
	});

  // }else{

  //   var data = sessionStorage.getItem('monthly'+bulan);
  //   var dataJson  = JSON.parse(data);
  //   setTagHtmlLineChart(dataJson, last_date);


  // }
}
function setTagHtmlLineChart(dataJson, last_date){
    var past =new Array();
    var current=new Array();

    $.each(dataJson, function(i, result){
        // console.log(last_date+'->'+result[last_date]);


      $.each(result, function(date, value){
        // console.log(date+'->'+result[date]);
        // console.log(date+'->'+result[last_date]);


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
    stop_waitMe('.headsix');
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
        exporting: {
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