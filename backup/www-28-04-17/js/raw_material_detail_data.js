
function materialDetailData(opco){
  var rkap_value;
  var gr_value;
  var po_value;
// var rkap_value = [1201500,1115400,1175000,1217500,1183400,1203800,877200,1355100,1175000,1203800,0,0];
//  var gr_value =   [600750,557700,587500,608750,591700,601900,438600,677550,67100,690100,0,0];
//  var po_value = [580750,517700,517500,588750,521700,501900,418600,617550,622000,61010,0,0]; 
  var catg = [];
  // var urlParams = new URLSearchParams(window.location.search);
  // var urlGet = urlParams.get('i');
  // console.log(urlParams.get('i'));
  $.ajax({
    url: url_src+'/json/GenerateJsonMM3.php',
    //url: 'http://localhost/mobile_pis/document.json',
    type: 'GET',
    success: function(data){
    rkap_value = [];
    gr_value = [];
    po_value = [];
     var obj = jQuery.parseJSON(data);
     console.log(opco);

     $.each(obj[opco], function(key, val){
      
      var rkap = parseFloat(val['RKAPVAL']/10000000).toFixed(2);
      var gr = parseFloat(val['GRVAL']/1000000000).toFixed(2);
      var po = parseFloat(val['POVAL']/1000000000).toFixed(2);

      // console.log(key + ' - ' + val['RKAPVAL'] + ' ->' + rkap);
      // console.log(key + ' - ' + val['GRVAL'] +' -> ' + gr);
      console.log(key + ' - ' + val['POVAL'] + '  -> '+ po);

      catg.push(key);

      rkap_value.push(parseFloat(rkap));
      gr_value.push(parseFloat(gr));
      po_value.push(parseFloat(po));
     });
    
      $('#raw_data').highcharts({
            chart: {
                type: 'bar',
                backgroundColor:'rgba(0, 255, 0, 0)'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                categories : catg,
                title: {
                            text: null
                        }
            },
            yAxis: {
                min: 0,
              max: 1400,
              tickAmmont: 4,
                    title: {
                        text: '',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' Bilions'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'horizontal',
                    align: 'right',
                    verticalAlign: 'bottom',
                    x: 0,
                    y: 0,
                    //floating: true,
                    //borderWidth: 1,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                   name: 'RKAP Value',
                    color: '#FF4B4B',
                    data:rkap_value
                }, {
            name: 'GR Value',
            color: '#03BCE4',
                    data: gr_value
                }, {
            name: 'PO Value',
            color: '#2B82AD',
                    data: po_value
                }]
      });
       console.log(gr_value);
      console.log(po_value);
      console.log(rkap_value);
    }
   });
  


 // createChart_monthly('raw_material_chart', rkap_value, gr_value, po_value);  
 

 var rkap_value = [10,0,0];
 var gr_value =   [0,2,0];
 var po_value = [0,0,12]; 
 createChart('baku_bulan', rkap_value, gr_value, po_value);
 createChart('baku_to_bulan', rkap_value, gr_value, po_value); 
 createChart('bakar_bulan', rkap_value, gr_value, po_value);
 createChart('bakar_to_bulan', rkap_value, gr_value, po_value);   
 
}
function createChart(id_chart, rkap_value, gr_value, po_value){
  $('#'+id_chart).highcharts({
   chart: {
    type: 'bar',
    height: 150
   },
   title: {
    text: ''
   },
   xAxis: {
    categories: ['RKAP', 'GR', 'PO'],
    title: {
     text: null
    },
   },
   yAxis: {
    min: 0,
    title: {
     text: '',
     align: 'high'
    },
    labels: {
     overflow: 'justify',
     enabled: true
    }
   },
   tooltip: {
    valueSuffix: ' billion'
   },
   plotOptions: {
    bar: {
     dataLabels: {
      enabled: false
     }
    }
   },
   credits: {
    enabled: false
   },
   series: [{
    name: 'rkap',
     color: '#FF4B4B',
    data: rkap_value
   }, {
    name: 'gr',
     color: '#03BCE4',
    data: gr_value
   }, {
    name: 'po',
     color: '#2B82AD',
    data: po_value
   }],
   legend: {
    enabled: false
   }
  });                   
 }
function createChart_monthly(id_chart, rkap_value, gr_value, po_value){
  $('#'+id_chart).highcharts({
   title: {
    text: ''            
   },
   credits: {
    enabled :false
   },
   chart: {
    backgroundColor:'rgba(0, 255, 0, 0)',
    type: 'column'
   },
   xAxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
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
   series: [{
    name: 'RKAP Value',
    color: '#FF4B4B',
    data: rkap_value
   }, {
    name: 'GR Value',
    color: '#03BCE4',
    data: gr_value,
    stacking: 'normal'
   }, {
    name: 'PO Value',
    color: '#2B82AD',
    data: po_value,
    stacking: 'normal'
   }]        
  });                      
 }