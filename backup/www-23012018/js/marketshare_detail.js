function marketshare(opco, bulan, tahun){
	var def_bulan = ('0'+(bulan)).substr(-2);
	var def_bulan_last = ('0'+(bulan-1)).substr(-2);
	var url_now = url_src+'/api/index.php/market_share?bulan='+def_bulan+'&tahun='+thn+'&company='+opco;

	var url_last = url_src+'/api/index.php/market_share?bulan='+def_bulan+'&tahun='+(thn-1)+'&company='+opco;

	console.log(url_now+'           '+url_last);

	console.log(bulan + '- ' + thn + '-' + opco + '( '+ def_bulan+def_bulan_last+' )');
	$('#monthTag').html(month[def_bulan-1]);
	$('#month_upto').html('Up To '+ month[def_bulan-1]);
	$('#monthTag2').html(month[def_bulan-1]);
	$('#month_upto2').html('Up To '+ month[def_bulan-1]);
	$('#year_now').html(thn);
	$('#year_last').html(thn-1);
	$('#tbhead_last').html('MS '+(thn-1));
	$('#tbhead_now').html('MS '+thn);

	$('#ms_now').html('0 %');
	$('#ms_now_upto').html('0 %')
	$('#bulanReal').html('0 K');
	$('#tahunReal').html('0 K');
	$('#growthMoM').html('0 %');
	$('#growthYoY').html('0 %');


	$('#ms_last').html('0 %');
	$('#ms_last_upto').html('0 %')
	$('#bulanReal_last').html('0 K');
	$('#tahunReal_last').html('0 K');
	$('#growthMoM_last').html('0 %');
	$('#growthYoY_last').html('0 %');

	run_waitMe('.wrapper', 'ios');
	$.when(
		$.getJSON(url_now),
	    $.getJSON(url_last)
		).done(function(result_now, result_last) {
			console.log(result_last);
			console.log(result_now);
			var data_now = result_now[0][opco];
			var data_last = result_last[0][opco];

			var target_now = parseFloat(data_now['TARGET']);
			var target_last = parseFloat(data_last['TARGET']);
			if (data_now!=null) {
				
				var bulanreal = FormatNumberBy3( (parseFloat(data_now['VOLUME_BULAN'])/1000).toFixed(0) );
				var tahunreal = FormatNumberBy3( (parseFloat(data_now['TAHUN_VOLUME_KUM'])/1000).toFixed(0) );
				$('#ms_now').html(data_now['MS_BULAN']+ ' %');
				$('#ms_now_upto').html(data_now['MS_TAHUN_KUM'] + ' %')
				$('#bulanReal').html(bulanreal+ ' K');
				$('#tahunReal').html(tahunreal+ ' K');
				$('#growthMoM').html(data_now['GROWTH'].MOM + ' %');
				$('#growthYoY').html(data_now['GROWTH'].KUM_YOY + ' %');


				tag_indicator(data_now['MS_BULAN'], data_now['MS_TAHUN_KUM'], target_now, '');
                
               


			}
			if (data_last!=null) {
				var bulanreal = FormatNumberBy3( (parseFloat(data_last['VOLUME_BULAN'])/1000).toFixed(0) );
				var tahunreal = FormatNumberBy3( (parseFloat(data_last['TAHUN_VOLUME_KUM'])/1000).toFixed(0) );
				$('#ms_last').html(data_last['MS_BULAN']+ ' %');
				$('#ms_last_upto').html(data_last['MS_TAHUN_KUM'] + ' %')
				$('#bulanReal_last').html(bulanreal+ ' K');
				$('#tahunReal_last').html(tahunreal+ ' K');
				$('#growthMoM_last').html(data_last['GROWTH'].MOM + ' %');
				$('#growthYoY_last').html(data_last['GROWTH'].KUM_YOY + ' %');

				tag_indicator(data_last['MS_BULAN'], data_last['MS_TAHUN_KUM'], target_last, '2');

				
			}
			// console.log(data_now);
			// console.log(data_last);

			marketShareProvinsi(opco, bulan, tahun);
		});
			setTimeout(function(){
					console.log('timeaout');
					stop_waitMe('.wrapper');
				},1000);


}

function tag_indicator(ms_bulan, ms_tahun, target, s){
	console.log(ms_bulan+"-"+ms_tahun+"-"+target);
	if (parseFloat(ms_bulan)<=2) {
        $('#monthTag'+s).removeClass('redunder');
        $('#indMonthTag'+s).removeClass('redind');
        $('#monthTag'+s).addClass('ylunder');
        $('#indMonthTag'+s).addClass('ylind');
    }
    if (parseFloat(ms_bulan)>=target) {
        $('#monthTag'+s).removeClass('redunder');
        $('#indMonthTag'+s).removeClass('redind');
        $('#monthTag'+s).addClass('grunder');
        $('#indMonthTag'+s).addClass('grind');
    }

     if (parseFloat(ms_tahun)<=2) {
        $('#month_upto'+s).removeClass('redunder');
        $('#indMonth_upto'+s).removeClass('redind');
        $('#month_upto'+s).addClass('ylunder');
        $('#indMonth_upto'+s).addClass('ylind');
    }
    if (parseFloat(ms_tahun)>=target) {
        $('#month_upto'+s).removeClass('redunder');
        $('#indMonth_upto'+s).removeClass('redind');
        $('#month_upto'+s).addClass('grunder');
        $('#indMonth_upto'+s).addClass('grind');
    }
}


function chart(categorieslabel, last_year_label, year_label, Yeardata, lastYearData){
	 Highcharts.chart('chart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Marketshare Province'
                    },
                     credits: {
                        enabled: false
                    },
                    xAxis: {
                        categories: categorieslabel,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: last_year_label,
                        data: lastYearData,
                        color: '#908E8E'

                    }, {
                        name: year_label,
                        data: Yeardata,
                        color: '#FF0000'

                    }]
                });
}


function chart2(categorieslabel2, last_year_label, year_label, Yeardata2, lastYearData2){
	 Highcharts.chart('chart2', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Growth Province'
                    },
                     credits: {
                        enabled: false
                    },
                    xAxis: {
                        categories: categorieslabel2,
                        crosshair: true
                    },
                    yAxis: {
                        // min: 0,
                        
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: last_year_label,
                        data: lastYearData2,
                        color: '#EADF2C'

                    }, {
                        name: year_label,
                        data: Yeardata2,
                        color: '#14AEDA'

                    }]
                });
}


function marketShareProvinsi(opco, bulan, tahun){

	var chartCategory=[];
	var chartData1=[];
	var chartData2=[];
	var chartDatax=[];
	var chartDatay=[];

	var def_bulan = ('0'+(bulan)).substr(-2);
	var url = url_src + '/api/index.php/market_share/dataProv?bulan='+def_bulan+'&company='+opco+'&tahun='+thn;
console.log(url);

	$.ajax({
			url: url,
			type: 'GET',
			success: function(data){
				var dataJson = JSON.parse(data);
				var prov = dataJson[opco];
				console.log(prov);

				if (prov!=null) {
					$.each(prov, function(nama, result){
						// console.log(nama);
						// console.log(result);

						var volume = FormatNumberBy3(parseFloat(result.TAHUN_VOLUME_KUM).toFixed(0));
						var ms_last = result.LAST_MS_TAHUN;
						var ms_now = result.MS_TAHUN_KUM;
						var growth = result.GROWTH.YOY;
						var gr_last = result.GROWTH.LAST_MOM;
						var gr_now = result.GROWTH.MOM;
						addRow(nama, volume, ms_last, ms_now, growth);

						
						chartCategory.push(result.INISIAL_PROV);
						chartData1.push(ms_now);
						chartData2.push(ms_last);
						chartDatax.push(gr_now);
						chartDatay.push(gr_last);
						// chartData1.sort(function(a, b){return b-a});
						// chartData2.sort(function(a, b){return b-a});
						// chartCategory.sort();

					});
				}else{
					$('table tbody').empty();
				}
				
				// console.log(dataJson);
				
				chart(chartCategory, thn-1, thn, chartData1, chartData2);
				chart2(chartCategory, thn-1, thn, chartDatax, chartDatay);
			}
	
			});
}


function namaProv(nama){
	var before = nama;

}

function addRow(provinsi, volume, last, now, growth){


	$('table tbody').append(
		' <tr><td align="left">'+provinsi+'</td><td valign="middle" align="right">'+volume+'</span></td><td valign="middle" align="right">'+last+' </td> <td valign="middle" align="right">'+now+'</td><td valign="middle" align="right">'+growth+'</td></tr>'
		);
}