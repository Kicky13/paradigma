$(function(){
 var total_processed_bymonth = [];
 var total_backlog_percentage_bymonth = [];
 var total_backlog_bymonth = [];
 var total_per_cp = [];
 var cp = ['2000','3000','4000','5000','6000','7000'];
 $.ajax({
  url: url_src+'/GenerateJsonMaintenance.php',
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
   if (Number(100 - Number(total)).toFixed(2) <= 15){
    $('#total_backlog').html('<span style="color:#1EC416">'+Number(100 - Number(total)).toFixed(2)+'%</span>');
   }else{
    $('#total_backlog').html('<span style="color:#EB1717">'+Number(100 - Number(total)).toFixed(2)+'%</span>'); 
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
   //console.log(obj['2000']['2016-01']);
   createChart('backlog-chart', total_processed_bymonth, total_backlog_percentage_bymonth, total_backlog_bymonth);
   createGauge2('backlog-gauge1', 'SP', Number(total_per_cp[0]));
   createGauge2('backlog-gauge3', 'ST', Number(total_per_cp[1]));
   createGauge2('backlog-gauge2', 'SG', Number(total_per_cp[2]));
   createGauge2('backlog-gauge4', 'TL', Number(total_per_cp[3]));
   function total_permonth(periode){
    var total_backlog_perbulan = 0;
    var total_all_perbulan = 0;
    var total_osp_perbulan = 0;

    for (var i in cp){
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
   }
   function createChart(id_chart, total_processed_bymonth, total_backlog_percentage_bymonth, total_backlog_bymonth){
    console.log(total_processed_bymonth);
    console.log(total_backlog_percentage_bymonth);
    console.log(total_backlog_bymonth);
    $('#'+id_chart).highcharts({
     credits: {
      enabled :false
     },
     chart: {
      backgroundColor:'rgba(0, 255, 0, 0)',
      type: 'column'
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
        var b = total_backlog_percentage_bymonth[this.x];
        if (b > 0){
         return b.toFixed(2) + '%'; 
        }else{
         return ''; 
        }
       }       
      }      
     },
     tooltip: {
      formatter: function (){
       return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Total Notification : ' + this.point.stackTotal;
      }
     },
     plotOptions: {
      column: {
       stacking: 'normal'
      },
      series: {
       states: {
        hover: {
         enabled: false
        }
       }
      }    
     },
     series: [{
      name: 'Backlog',
      data: total_backlog_bymonth,
      pointWidth: 22,
      color : '#EB1717'
     },{
      name: 'Processed',
      data: total_processed_bymonth,
      pointWidth: 22,
      color : '#1EC416'
     }]
    });                    
   }
   function createGauge2(id_gauge, caption, total_cp){ 
    $('#'+id_gauge).highcharts({
        chart: {
            type: 'gauge',
            height: 198
        },
        title: {
            text: caption
        },
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                backgroundColor: 'none',
                borderWidth: 0,
                outerRadius: '109%'
            },  {
                backgroundColor: 'none',
                borderWidth: 0,
                outerRadius: '103%',
                innerRadius: '103%'
            }]
        },
        // the value axis
        yAxis: {
            min: 0,
            max: 100,

            labels: {
               // step: 2,
                rotation: 'auto'
            },
            title: {
                text: ''
            },
            plotBands: [{
                from: 0,
                to: 85,
                color: '#DF5353', // green
                innerRadius: 69,
                outerRadius: 89                
//                innerRadius: 102
//                outerRadius: 110
            }, {
                from: 86,
                to: 100,
                color: '#55BF3B', // red
                innerRadius: 69,
                outerRadius: 89                
//                innerRadius: 102
//                outerRadius: 110
            }],
           
        },      
        series: [{
            name: 'Processed',
            data: [total_cp],
            tooltip: {
                valueSuffix: '%'
            },
            dataLabels: {
             formatter: function(){
              var b = 100 - this.y;
              if (isNaN(b) == false){
               if (b <= 15){
                return '<span style="font-size:12px; color: #1EC416; font-weight: bold">'+b.toFixed(2) + '%</span>';
               }else{
                return '<span style="font-size:12px; color: #EB1717; font-weight: bold">'+b.toFixed(2) + '%</span>'; 
               }
              }else{
               return ''; 
              }
             }
            }
        }]

    });    
   }
   function createGauge(id_gauge, caption, total_cp){
    var txtcolor = '#1EC416';
    if (total_cp <= 15){
     var txtcolor = '#eb1717';
    }
    Highcharts.chart(id_gauge,{
     chart: {
      type: 'solidgauge',
      marginTop: 25,
      backgroundColor:'rgba(0, 255, 0, 0)'
     },
     title: {
      text: caption,
      style: {
       fontSize: '12px'
      }
     },
     tooltip: {
      borderWidth: 0,
      backgroundColor: 'none',
      shadow: false,
      style: {
       fontSize: '8px'
      },
      pointFormat: '<span style="font-size:12px; color: {point.color}; font-weight: bold">{point.y}%</span>',
      positioner: function (labelWidth) {
       return {
        x: 45 - labelWidth / 2,
        y: 45
       };
      }
     },
     pane: {
      startAngle: 0,
      endAngle: 360,
      background: [{ 
       outerRadius: '112%',
       innerRadius: '88%',
       backgroundColor: '#eb1717',
       borderWidth: 0
      }]
     },
     yAxis: {
      min: 0,
      max: 100,
      lineWidth: 0,
      tickPositions: []
     },
     plotOptions: {
      solidgauge: {
       borderWidth: '6px',
       dataLabels: {
        enabled: true,
        align: 'center',
        borderWidth: '0px',
        formatter: function() {
         var b = 100 - this.y;
         if (isNaN(b) == false){
          if (b <= 15){
           return '<span style="font-size:10px; color: #1EC416; font-weight: bold">'+b.toFixed(2) + '%</span>';
          }else{
           return '<span style="font-size:10px; color: #EB1717; font-weight: bold">'+b.toFixed(2) + '%</span>'; 
          }
         }else{
          return ''; 
         }
        }            
       },
       enableMouseTracking: false,
       linecap: 'round',
       stickyTracking: false
      }
     },
     series: [{
      name: 'Move',
      borderColor:'#1EC416',
      data: [{
       color: txtcolor,
       radius: '100%',
       innerRadius: '100%',
       y: total_cp
      }]
     }]
    });
   }
  }                 
 })
})