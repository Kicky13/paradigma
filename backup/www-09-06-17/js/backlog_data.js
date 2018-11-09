function FormatNumberBy3(num, decpoint, sep) {
  if (arguments.length == 2) {
    sep = ",";
  }
  if (arguments.length == 1) {
    sep = ",";
    decpoint = ".";
  }
  num = num.toString();
  a = num.split(decpoint);
  x = a[0];
  y = a[1];
  z = "";

  if (typeof(x) != "undefined") {
    for (i=x.length-1;i>=0;i--)
      z += x.charAt(i);
    z = z.replace(/(\d{3})/g, "$1" + sep);
    if (z.slice(-sep.length) == sep)
      z = z.slice(0, -sep.length);
    x = "";
    for (i=z.length-1;i>=0;i--)
      x += z.charAt(i);
    if (typeof(y) != "undefined" && y.length > 0)
      x += decpoint + y;
  }
  return x;
}
$(function(){
 var total_processed_bymonth = [];
 var total_backlog_percentage_bymonth = [];
 var total_processed_percentage_bymonth = [];
 var total_backlog_bymonth = [];
 var total_per_cp = [];
 var cp = ['2000','3000','4000','5000','6000','7000'];
 $.ajax({
  url: url_src+'/json/GenerateJsonMaintenance.php',
  //url: 'http://localhost/mobile_pis/document.json',
  type: 'GET',
  success: function(data){
   var obj = jQuery.parseJSON(data);
   //obj = data;
   var data_2000 = obj['2000'];
   var data_3000 = obj['3000'];
   var data_4000 = obj['4000'];
   var data_5000 = obj['5000'];
   var data_6000 = obj['6000'];
   var data_7000 = obj['7000'];
   var total = 0;
   var total_sp = 0;
   var total_sg = 0;
   var total_st = 0;
   var total_tl = 0;   
   var d = new Date();
   var n = d.getFullYear();
   var n = n-1;
   console.log(n);
   // Semen Padang
   var total_all_padang = 0;
   var total_osp_padang = 0;
   $.each(data_3000, function(key, val){
    total_all_padang += Number(val.OSNO)+Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
    total_osp_padang += Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
   })
   total_sp = Number((total_osp_padang / total_all_padang) * 100).toFixed(2);
   total_per_cp.push(total_sp);
   // Semen Tonase
   var total_all_tonasa = 0;
   var total_osp_tonasa = 0;
   $.each(data_4000, function(key, val){
    total_all_tonasa += Number(val.OSNO)+Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
    total_osp_tonasa += Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
   })
   total_st = Number((total_osp_tonasa / total_all_tonasa) * 100).toFixed(2);
   total_per_cp.push(total_st);
   // Semen Gresik
   var total_all_gresik = 0;
   var total_osp_gresik = 0;
   $.each(data_2000, function(key, val){
    total_all_gresik += Number(val.OSNO)+Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
    total_osp_gresik += Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
   })
   $.each(data_5000, function(key, val){
    total_all_gresik += Number(val.OSNO)+Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
    total_osp_gresik += Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
   })
   $.each(data_7000, function(key, val){
    total_all_gresik += Number(val.OSNO)+Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
    total_osp_gresik += Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
   })
   total_sg = Number((total_osp_gresik / total_all_gresik) * 100).toFixed(2);
   total_per_cp.push(total_sg);
   // Semen TLC
   var total_all_tlcc = 0;
   var total_osp_tlcc = 0;
   $.each(data_6000, function(key, val){
    total_all_tlcc += Number(val.OSNO)+Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
    total_osp_tlcc += Number(val.NOPR)+Number(val.NOPR_NOPT)+Number(val.NOPR_NOPT_ORAS)+Number(val.NOPR_ORAS)+Number(val.NOCO)+Number(val.NOCO_NOPR)+Number(val.NOCO_NOPT_ORAS)+Number(val.NOCO_ORAS)+Number(val.DLFL_NOCO)+Number(val.DLFL_NOCO_ORAS);
   })
   total_tl = Number((total_osp_tlcc / total_all_tlcc) * 100).toFixed(2);
   total_per_cp.push(total_tl);
   // Total Backlog
   total = Number(((total_osp_padang+total_osp_gresik+total_osp_tonasa+total_osp_tlcc) / (total_all_padang+total_all_gresik+total_all_tonasa+total_all_tlcc)) * 100).toFixed(1);  
   if (Number(100 - Number(total)) <= 15){
    //$('#total_backlog').html(Number(100 - Number(total)).toFixed(2)+'<font size="5"> %</font>');
    $('#backlog_arrow').removeClass('txt-red');
    $('#backlog_arrow').removeClass('txt-green');
    $('#backlog_arrow').addClass('txt-green');
    $('#total_backlog').html(setFormat(Number(100 - Number(total)),2)+'<font size="5"> %</font>');
   }else{
    //$('#total_backlog').html(Number(100 - Number(total)).toFixed(2)+'<font size="5"> %</font>'); 
    $('#backlog_arrow').removeClass('txt-red');
    $('#backlog_arrow').removeClass('txt-green');
    $('#backlog_arrow').addClass('txt-red');
    $('#total_backlog').html(setFormat(Number(100 - Number(total)),2)+'<font size="5"> %</font>'); 
   }
   // Backlog per Bulan
   var s = '';
   for (var b=1;b<13;b++){
    if (b < 10){
     var s = '0'+b;
    }else{
     var s = b; 
    }
    total_permonth(n+'-'+s);

   }

   console.log(total_processed_bymonth);
   console.log(total_backlog_bymonth);

   createChart('backlog-chart', total_processed_bymonth, total_backlog_percentage_bymonth, total_backlog_bymonth);

    if (Number(100 - (Number(total_per_cp[2]))).toFixed(2) <= 15){
    $('#gauge_gresik').html('<span style="color:#45DD90">'+setFormat(Number(100-(Number(total_per_cp[2]))),2)+'%</span>');
   }else{
    $('#gauge_gresik').html('<span style="color:#FF615D">'+setFormat(Number(100-(Number(total_per_cp[2]))),2)+'%</span>');
   }
    if (Number(100 - (Number(total_per_cp[0]))).toFixed(2) <= 15){
   $('#gauge_padang').html('<span style="color:#45DD90">'+setFormat(Number(100-(Number(total_per_cp[0]))),2)+'%</span>');
   }else{
   $('#gauge_padang').html('<span style="color:#FF615D">'+setFormat(Number(100-(Number(total_per_cp[0]))),2)+'%</span>');
 }
    if (Number(100 - (Number(total_per_cp[1]))).toFixed(2) <= 15){
    $('#gauge_tonasa').html('<span style="color:#45DD90">'+setFormat(Number(100-(Number(total_per_cp[1]))),2)+'%</span>');
 }else{
   $('#gauge_tonasa').html('<span style="color:#FF615D">'+setFormat(Number(100-(Number(total_per_cp[1]))),2)+'%</span>');
 }
 if (Number(100 - (Number(total_per_cp[3]))).toFixed(2) <= 15){
$('#gauge_tlcc').html('<span style="color:#45DD90">'+setFormat(Number(100-(Number(total_per_cp[3]))),2)+'%</span>');
}else{
   $('#gauge_tlcc').html('<span style="color:#FF615D">'+setFormat(Number(100-(Number(total_per_cp[3]))),2)+'%</span>');
 }
   function total_permonth(periode){
    var total_backlog_perbulan = 0;
    var total_all_perbulan = 0;
    var total_osp_perbulan = 0;
    console.log(cp);
    for (var i in cp){
    console.log(i);
    console.log(cp[i]);
    console.log(periode);
     if (obj[cp[i]][periode] != undefined){
      $.each(obj[cp[i]][periode], function(key, val){
       if (key == 'OSNO' || key == 'NOPR' || key == 'NOPR_NOPT' || key == 'NOPR_NOPT_ORAS' || key == 'NOPR_ORAS' || key == 'NOCO' || key == 'NOCO_NOPR' || key == 'NOCO_NOPT_ORAS' || key == 'NOCO_ORAS' ||  key == 'DLFL_NOCO' || key == 'DLFL_NOCO_ORAS'){
        total_all_perbulan += Number(val);
       }
       if (key == 'NOPR' || key == 'NOPR_NOPT' || key == 'NOPR_NOPT_ORAS' || key == 'NOPR_ORAS' || key == 'NOCO' || key == 'NOCO_NOPR' || key == 'NOCO_NOPT_ORAS' || key == 'NOCO_ORAS' ||  key == 'DLFL_NOCO' || key == 'DLFL_NOCO_ORAS'){
        total_osp_perbulan += Number(val);
       }       
      })
      total_backlog_perbulan = (100 - (Number((total_osp_perbulan / total_all_perbulan))*100)).toFixed(2);
     }else{
      total_note_perbulan = 0;
      total_backlog_perbulan = 0;
     }
    }
    total_processed_bymonth.push(total_all_perbulan - (total_all_perbulan - total_osp_perbulan));
    total_backlog_percentage_bymonth.push(Number(total_backlog_perbulan));
    total_backlog_bymonth.push(total_all_perbulan - total_osp_perbulan);
    total_processed_percentage_bymonth.push(100 - Number(total_backlog_perbulan)); 
    // createChart('backlog-chart', total_processed_bymonth, total_backlog_percentage_bymonth, total_backlog_bymonth);
    // console.log('test');
   }
   function createChart(id_chart, total_processed_bymonth, total_backlog_percentage_bymonth, total_backlog_bymonth){
    console.log(total_processed_bymonth);
    console.log(total_backlog_percentage_bymonth);
    console.log(total_backlog_bymonth);
    console.log(total_processed_percentage_bymonth);
    $('#'+id_chart).highcharts({
     credits: {
      enabled :false
     },
     chart: {
      backgroundColor:'rgba(0, 255, 0, 0)',
      type: 'bar'
     },
     title: {
      text: ''
     },
     xAxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Des']
     },
     yAxis: {
      allowDecimals: false,
      min: 0,
      tickInterval: 1000,
      title: {
       text: ''
      },
      stackLabels: {
       enabled: true,
       style: {
        fontSize: '9px',
        color: '#3498db'
       },
       formatter: function() {
        var p = total_backlog_percentage_bymonth[this.x];
        var v = total_backlog_bymonth[this.x];
        var a = total_processed_percentage_bymonth[this.x];
        if (v > 0){
         if (p == 0){
          return p.toFixed(0) + '%';
         }else{
          return p.toFixed(2) + '%'; 
         }
        }else{
         return ''; 
        }        
       }       
      }      
     },
     legend: {
            reversed: true
        },
     tooltip: {
      formatter: function (){
       return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + setFormat(this.y,0) + '<br/>' + 'Total Notification : ' + setFormat(this.point.stackTotal,0);
      }
     },
     plotOptions: {
      series: {
        events: {
                    legendItemClick: function () {
                     var series_name = this.name;
                     var series_visible = this.visible;
                        var chart = $('#'+id_chart).highcharts();
                        var yAxis = chart.yAxis[0];
                        yAxis.update({
            stackLabels: {
             enabled: true,
             style: {
              fontSize: '9px',
              color: '#3498db'
             },
             formatter: function() {
              if (series_name == 'Backlog'){
               if (series_visible == false){
                var p = total_backlog_percentage_bymonth[this.x];
               var v = total_backlog_bymonth[this.x];
               if (v > 0){
               if (p == 0){
                return '';
               }else{
                return p.toFixed(2) + '%'; 
               } 
                }else{
                  return ''; 
                }               
               }else{
                var p = 100 - total_backlog_percentage_bymonth[this.x];
                var v = total_backlog_bymonth[this.x];
                if (v > 0){
                if (p == 0){
                 return '';
                }else{
                 return p.toFixed(2) + '%'; 
                }
                 }else{
                  return ''; 
                }  
               }
                }else{
               var p = total_backlog_percentage_bymonth[this.x];
               var v = total_backlog_bymonth[this.x];
               if (v > 0){
               if (p == 0){
                return '';
               }else{
                return p.toFixed(2) + '%'; 
               } 
                }else{
                  return ''; 
                }                  
              }

             }        
            }                                        
                        });

                    }
                },
        stacking: 'normal'
      } 
     },
     series: [{
      name: 'Backlog',
      data: total_backlog_bymonth,
      pointWidth: 20,
      color : '#FF615D',
      states: {
        hover: {
         enabled: false
        }
      }
     },{
      name: 'Processed',
      data: total_processed_bymonth,
      pointWidth: 20,
      color : '#45DD90',
      states: {
        hover: {
         enabled: false
        }
      }
       }
     ]
    });                    
   }
  }                 
 })
})