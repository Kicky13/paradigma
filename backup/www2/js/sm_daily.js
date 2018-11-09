 function loadData(datasrc, target, company) {
        var tag_target = '';
     if (target == 'vol') {
         run_waitMe('#data-volume', 'ios');
         tag_target = '#data-volume';
     } else {
         // run_waitMe('#data-revenew', 'ios');
         tag_target = '#data-revenew';

     }
     $('#isidetail_' + target).html('');
     $('#target_rkap_' + target).html('<br> 0');
     $('#target_actual_' + target).html('0');
     $('#target_rkap_' + target).html('0');
     $('#achievement_' + target).html(' 0 %');
    
     $.ajax({
         url: datasrc,
         //url: url_src+'/SalesJsonAll.php?company=7000&tahun='+tahun+'&bulan='+bulanSekarang,
         //url: url_src+'/SalesJsonAll.php',
         type: 'GET',
         success: function(data) {

             // var data1 = data.replace("<title>Json</title>", "");
             // var data2 = data1.replace("(", "[");
             // var data3 = data2.replace(");", "]");
             // console.log(data);
             var dataJson = paradigma.json_parse(data, tag_target);
             console.log(dataJson);
             var bulanNow = moment().format('MM');
             var tahunNow = moment().format('YYYY');
             //var days = moment(tahun+bulanSekarang).daysInMonth();
             var days = moment(tahun.toString() + '-' + bulanSekarang, "YYYY-MM").daysInMonth() // 29
             console.log('jumalh hari ->'+days);
             if (target == 'vol') {
                 var isidetail = new Array();
                 var dataBag_rkap = [];
                 var dataBag_real = [];
                 var dataBagkum_rkap = [];
                 var dataBagkum_real = [];
                 var dataBulk_rkap = [];
                 var dataBulk_real = [];
                 var dataBulkBag_rkap = [];
                 var target_rkap_src = dataJson['rkap'];
                 var target_real_src = dataJson['actual'];

                 var labelArray = [];
                 var datacurah = [];
                 var datazak = [];
                 var datacurahrkap = [];
                 var datazakrkap = [];
                 var datacurahzakrkap = [];
                 var totalbulk_rkap = 0;
                 var totalbulk_real = 0;
                 var totalbag_rkap = 0;
                 var totalbag_real = 0;
                 if (bulanSekarang == bulanNow && tahun == tahunNow) {
                     days = moment().format('DD');
                 }
                 console.log();
                 for (var x = 1; x <= days; x++) {
                     if (x < 10) {
                         var tgl = '0' + x;
                     } else {
                         var tgl = x;
                     }
                     labelArray.push(tgl);
                     if (dataJson == false) {
                        dataBag_rkap.push(0);
                        dataBag_real.push(0);
                        dataBulk_rkap.push(0);
                        dataBulk_real.push(0);
                     }else{
                          if (dataJson[company]['zak'][tahun.toString() + bulanSekarang.toString() + tgl] == undefined) {
                              dataBag_rkap.push(0);
                              dataBag_real.push(0);
                          } else {
                              var dataBag_rkap_tmp = parseFloat(dataJson[company]['zak'][tahun.toString() + bulanSekarang.toString() + tgl].rkap);
                              var dataBag_real_tmp = parseFloat(dataJson[company]['zak'][tahun.toString() + bulanSekarang.toString() + tgl].real);
                              dataBag_rkap.push(parseFloat(dataBag_rkap_tmp));
                              dataBag_real.push(parseFloat(dataBag_real_tmp));
                          }
                          if (dataJson[company]['curah'][tahun.toString() + bulanSekarang.toString() + tgl] == undefined) {
                              dataBulk_rkap.push(0);
                              dataBulk_real.push(0);
                          } else {
                              var dataBulk_rkap_tmp = parseFloat(dataJson[company]['curah'][tahun.toString() + bulanSekarang.toString() + tgl].rkap);
                              var dataBulk_real_tmp = parseFloat(dataJson[company]['curah'][tahun.toString() + bulanSekarang.toString() + tgl].real);
                              dataBulk_rkap.push(parseFloat(dataBulk_rkap_tmp));
                              dataBulk_real.push(parseFloat(dataBulk_real_tmp));
                          }
                      }
                     totalbulk_rkap += dataBulk_rkap[x - 1];
                     totalbulk_real += dataBulk_real[x - 1];
                     totalbag_rkap += dataBag_rkap[x - 1];
                     totalbag_real += dataBag_real[x - 1];
                     var dataBulkBag_rkap_tmp = parseFloat(dataBulk_rkap[x - 1] + dataBag_rkap[x - 1]);
                     dataBulkBag_rkap.push(parseFloat(dataBulkBag_rkap_tmp));
                     var akumulativeRkap = 0;
                     var akumulativeReal = 0;
                     for (var i = 0; i < x; i++) {
                         akumulativeRkap += dataBag_rkap[i];
                         akumulativeReal += dataBag_real[i];
                     }
                     dataBagkum_rkap.push(parseFloat(akumulativeRkap));
                     dataBagkum_real.push(parseFloat(akumulativeReal));
                     var res1 = parseFloat(dataBulk_real[x - 1]);
                     var res2 = parseFloat(dataBag_real[x - 1]);
                     var res3 = parseFloat(dataBulk_rkap[x - 1]);
                     var res4 = parseFloat(dataBag_rkap[x - 1]);
                     res = res1 + res2;
                     rez = res3 + res4;
                     var formated = moment(tahun.toString() + bulanSekarang.toString() + tgl);
                     var arrPush = {};
                     arrPush.date = parseInt(formated.format('x'));
                     arrPush.bulk = res1;
                     arrPush.bag = res2;
                     arrPush.total = res;
                     isidetail.push(arrPush);
                 }

                 var result = paradigma.array_sort(isidetail, 'desc', 'date');

                 addRow(isidetail, target);
                 var last_update = moment(tahun.toString() + bulanSekarang.toString() + labelArray[labelArray.length - 1]);
                 $('.last-update').html('Last update : ' + last_update.format('DD MMM YYYY'));
                 $('#bulkrkap_' + target).html(setFormat(totalbulk_rkap, 2));
                 $('#bulkreal_' + target).html(setFormat(totalbulk_real, 2));
                 var bulkreal_persen_vol = (totalbulk_real / totalbulk_rkap) * 100;
                 $('#bulkreal_persen_' + target).html(setFormat(bulkreal_persen_vol, 2));
                 $('#bagrkap_' + target).html(setFormat(totalbag_rkap, 2));
                 $('#bagreal_' + target).html(setFormat(totalbag_real, 2));
                 var bagreal_persen_vol = (totalbag_real / totalbag_rkap) * 100;
                 $('#bagreal_persen_' + target).html(setFormat(bagreal_persen_vol, 2));
                 $('#totalrkap_' + target).html(setFormat(totalbulk_rkap + totalbag_rkap, 2));
                 $('#totalreal_' + target).html(setFormat(totalbulk_real + totalbag_real, 2));
                 var totalreal_persen_vol = ((totalbulk_real + totalbag_real) / (totalbulk_rkap + totalbag_rkap)) * 100;
                 $('#totalreal_persen_' + target).html(setFormat(totalreal_persen_vol, 2));
                 $('#target_rkap_' + target).html(setFormat(totalbulk_rkap + totalbag_rkap, 2));
                 // $('#target_actual_'+target).html(setFormat(totalbulk_real + totalbag_real,2));
                 $('#target_actual_' + target).html(setFormat(target_real_src, 2));

                 var target_rkap = target_rkap_src;
                 $('#target_rkap_' + target).html(setFormat(target_rkap, 2));
                 var nggonku = totalbulk_real + totalbag_real;
                 var target_real = parseFloat($('#target_actual_' + target).text());
                 var achievement_vol = (nggonku / target_rkap) * 100;
                 console.log(achievement_vol+'achievement_vol');
                 if (isFinite(achievement_vol)) {
                    $('#achievement_' + target).html(setFormat(achievement_vol, 2) + '%');

                 }else{
                    $('#achievement_' + target).html(' 0 %');

                 }
                 $('#icon_achievement_' + target).removeClass('fa-sort-asc');
                 $('#icon_achievement_' + target).removeClass('fa-sort-desc');
                 if (((nggonku / target_rkap) * 100) > 50) {
                     $('#icon_achievement_' + target).addClass('fa-sort-asc');
                     $('#icon_achievement_' + target).attr('style', 'color: #7be668');
                 } else {
                     $('#icon_achievement_' + target).addClass('fa-sort-desc');
                     $('#icon_achievement_' + target).attr('style', 'color: #EB1717');
                 }
                 createChart('chartku_' + target, labelArray, dataBulk_real, dataBag_real, dataBulk_rkap, dataBag_rkap, dataBulkBag_rkap, dataBagkum_rkap, dataBagkum_real);
                 stop_waitMe('#data-volume');
                 //console.log(dataBag_real);
                 //console.log(dataBagkum_rkap);
             } else {
                 var isidetail = new Array();
                 var target_rkap_src = dataJson['rkap'];
                 var target_real_src = dataJson['actual'];

                 var dataRkap = [];
                 var dataReal = [];
                 var labelArray = [];
                 var total_rkap = 0;
                 var total_real = 0;
                 if (bulanSekarang == bulanNow && tahun == tahunNow) {
                     days = moment().format('DD');
                 }
                 for (var x = 1; x <= days; x++) {
                     if (x < 10) {
                         var tgl = '0' + x;
                     } else {
                         var tgl = x;
                     }
                     labelArray.push(tgl);
                     if (dataJson[company][tahun.toString() + bulanSekarang.toString() + tgl] == undefined) {
                         dataRkap.push(0);
                         dataReal.push(0);
                     } else {
                         var dataRkap_tmp = parseFloat(dataJson[company][tahun.toString() + bulanSekarang.toString() + tgl].rkap);
                         var dataReal_tmp = parseFloat(dataJson[company][tahun.toString() + bulanSekarang.toString() + tgl].real);

                         // dataBulk_rkap.push(Number(dataBulk_rkap_tmp.toFixed(2)));
                         dataRkap.push(parseFloat(dataRkap_tmp));
                         dataReal.push(parseFloat(dataReal_tmp));
                     }
                     total_rkap += dataRkap[x - 1];
                     total_real += dataReal[x - 1];
                     res = parseFloat(dataReal[x - 1]);
                     var formated = moment(tahun.toString() + bulanSekarang.toString() + tgl);
               

                     
                  var arrPush = {};
                     arrPush.date = parseInt(formated.format('x'));
                     arrPush.total = res;
                     isidetail.push(arrPush);
                 }

                 var result = paradigma.array_sort(isidetail, 'desc', 'date');

                 addRowRevenue(isidetail, target);
                 var last_update = moment(tahun.toString() + bulanSekarang.toString() + labelArray[labelArray.length - 1]);
                 $('.last-update').html('Last update : ' + last_update.format('DD MMM YYYY'));
                 $('#totalrkap_' + target).html(total_rkap / 1000000000);
                 $('#totalreal_' + target).html(total_real / 1000000000);
                 $('#totalreal_persen_' + target).html((total_real / total_rkap) * 100);
                 var target_actual_rev = (target_real_src / 1000000000);
                 // var target_actual_rev = (total_real / 1000000000);
                 $('#target_actual_' + target).html(setFormat(target_actual_rev, 2));
                 var target_rkap = target_rkap_src;
                 var target_rkap_rev = (target_rkap / 1000000000);
                 $('#target_rkap_' + target).html(setFormat(target_rkap_rev, 2));
                 // var nggonku = total_real;
                 var target_real = parseFloat(target_real_src);
                 var achievement_rev = (target_real / target_rkap) * 100;
                 $('#achievement_' + target).html(setFormat(achievement_rev, 2) + '%');
                 $('#icon_achievement_' + target).removeClass('fa-sort-asc');
                 $('#icon_achievement_' + target).removeClass('fa-sort-desc');
                 if (((target_real / target_rkap) * 100) > 50) {
                     $('#icon_achievement_' + target).addClass('fa-sort-asc');
                     $('#icon_achievement_' + target).attr('style', 'color: #7be668');
                 } else {
                     $('#icon_achievement_' + target).addClass('fa-sort-desc');
                     $('#icon_achievement_' + target).attr('style', 'color: #EB1717');
                 }

                 createChartRev('chartku_' + target, labelArray, dataReal, dataRkap);
                 stop_waitMe('#data-revenew');
             }
         }
     }).done(function(data) {}).fail(function() {

     });
 }

 function addRow(data, target) {
     console.log(5+1);
     var isi2;
     $.each(data, function(i, result) {
         // console.log(result);
         var formated = moment(result.date);
         isi2 = '<tr ><td align="center" ><b>' + formated.format('DD-MM-YYYY') + '</b></td><td align="right"> ' + setFormat(result.bulk, 2) + '</td><td align="right"> ' + setFormat(result.bag, 2) + ' </font></td><td align="right" data-sort-value="' + result.total + '"><font color="#ff0000"> ' + setFormat(result.total, 2) + '</font></td></tr>';
         $('#isidetail_' + target).append(isi2);
     });


 }
  function addRowRevenue(data, target) {
     console.log(2+1);
     var isi2;
     $.each(data, function(i, result) {
         // console.log(result);
         var formated = moment(result.date);
         isi2 = '<tr ><td align="center" ><b>' + formated.format('DD-MM-YYYY') + '</b></td><td align="right" data-sort-value="' + result.total + '"><font color="#ff0000"> ' + setFormat(result.total, 2) + '</font></td></tr>';
         $('#isidetail_' + target).append(isi2);
     });


 }

 function createChart(id, date, datacurah, datazak, datacurahrkap, datazakrkap, datacurahzakrkap, datazakrkapkum, datazakrealkum) {
     $('#' + id).highcharts({
         chart: {
             backgroundColor: 'rgba(0, 255, 0, 0)',
             polar: true,
             height: 225,
             //marginLeft: 5,
             //marginLeft: 5
         },
         title: {
             text: ''
         },
         credits: {
             enabled: false
         },
         tooltip: {
             formatter: function() {
                 var n = this.y;
                 var s = this.series.name;
                 var t = this.x;
                 return '<b>' + t + '<br>' + s + ':<br>' + setFormat(n, 2) + ' Ton</b>';
             }

         },
         xAxis: {
             categories: date,
             gridLineWidth: 1
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
         legend: {
             //width: 500,
             enabled: false,
             align: 'left',
             x: -10
         },
         exporting: {
             enabled: false
         },
         yAxis: [{
             title: '',
             //top: 10,
             //min: 0,
             //offset: -30,
             tickWidth: 1
         }, {
             title: '',
             tickWidth: 1,
             opposite: true
         }],
         series: [{
             type: 'column',
             name: 'Bulk',
             color: '#4DAF4A',
             data: datacurah,
             stacking: 'normal'
         }, {
             type: 'column',
             name: 'Bag',
             color: '#4c9ed9',
             data: datazak,
             stacking: 'normal'
         }, {
             type: 'spline',
             name: 'Target Bulk',
             color: '#336699',
             data: datacurahrkap,
             visible: false
         }, {
             type: 'spline',
             name: 'Target Bag',
             color: '#FDAE61',
             data: datazakrkap,
             visible: false
         }, {
             type: 'spline',
             name: 'Target Total',
             color: '#E41A1C',
             data: datacurahzakrkap,
             visible: false
         }, {
             type: 'spline',
             name: 'Kum. Target Bag',
             color: '#BC02FA',
             data: datazakrkapkum,
             yAxis: 1,
             visible: false
         }, {
             type: 'spline',
             name: 'Kum. Real Bag',
             color: '#FA63FF',
             data: datazakrealkum,
             yAxis: 1,
             visible: false
         }]
     });
 }

 function createChartRev(id, date, dataReal, dataRkap) {
     $('#' + id).highcharts({
         chart: {
             backgroundColor: 'rgba(0, 255, 0, 0)',
             polar: true,
             height: 225,
             //marginLeft: 5,
             //marginLeft: 5
         },
         title: {
             text: ''
         },
         credits: {
             enabled: false
         },
         tooltip: {
             formatter: function() {
                 var n = this.y / 1000000000;
                 var s = this.series.name;
                 return '<b>' + s + ':<br>' + setFormat(n, 2) + ' B</b>';
             }

         },
         xAxis: {
             categories: date,
             gridLineWidth: 1
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
         legend: {
             enabled: false,
             width: 500
                 //align: 'left'
         },
         exporting: {
             enabled: false
         },
         yAxis: {
             title: '',
             //top: 10,
             //min: 0,
             //offset: -30,
             tickWidth: 1,
             labels: {
                 formatter: function() {
                     if (this.value == 0) {
                         var t = 0;
                     } else {
                         var t = (this.value / 1000000000) + 'B';
                     }
                     return t;
                 }
             }
             //formatter: {this.series.name}
         },
         series: [{
             type: 'column',
             name: 'Actual',
             color: '#4DAF4A',
             data: dataReal
         }, {
             type: 'spline',
             name: 'Target',
             color: '#E41A1C',
             data: dataRkap
         }]


     });
 }