$(function () {
var rkap_value = [0,0,0,0,0,0,0,0,0,0,0,0];
 var gr_value =   [0,0,0,0,0,0,0,0,0,0,0,0];
 var po_value = [0,0,0,0,0,0,0,0,0,0,0,0]; 
 var catg = [];

 var sg_rkap = 0;
 var sg_po = 0;
 var sg_gr = 0;
 var sp_rkap = 0;
 var sp_po = 0;
 var sp_gr = 0;
 var st_rkap = 0;
 var st_po = 0;
 var st_gr = 0;
 var tlcc_rkap = 0;
 var tlcc_po = 0;
 var tlcc_gr = 0;
 $.ajax({
    url: url_src+'/json/GenerateJsonMM3.php',
    type: 'GET',
    success: function(data){
        rkap_value = [];
        gr_value = [];
        po_value = [];
        var obj = jQuery.parseJSON(data);

        //total sg
        $.each(obj['sg'], function(key, val){
        

            //sg_rkap = sg_rkap + parseFloat(val['RKAPVAL']/1000000000);
			sg_rkap = sg_rkap + parseFloat(val['RKAPVAL']/10000000);
			sg_po = sg_po + parseFloat(val['POVAL']/1000000000);
            sg_gr = sg_gr + parseFloat(val['GRVAL']/1000000000);

            //var rkap = parseFloat(val['RKAPVAL']/1000000000).toFixed(2);
            var rkap = parseFloat(val['RKAPVAL']/10000000).toFixed(2);
            var gr = parseFloat(val['GRVAL']/1000000000).toFixed(2);
            var po = parseFloat(val['POVAL']/1000000000).toFixed(2);

            //total
            // sg_rkap = sg_rkap + parseFloat(rkap);
            // sg_po = sg_po + parseFloat(po);
            // sg_gr = sg_gr + parseFloat(gr);

            catg.push(key);
            console.log('sg -' +sg_rkap);
            rkap_value.push(parseFloat(rkap));
            gr_value.push(parseFloat(gr));
            po_value.push(parseFloat(po));
       });
        //total st
         $.each(obj['st'], function(key, val){
        
            //var rkap = parseFloat(val['RKAPVAL']/1000000000);
            var rkap = parseFloat(val['RKAPVAL']/10000000);
            var gr = parseFloat(val['GRVAL']/1000000000);
            var po = parseFloat(val['POVAL']/1000000000);

            //total
            st_rkap = st_rkap + parseFloat(rkap);
            st_po = st_po + parseFloat(po);
            st_gr = st_gr + parseFloat(gr);

             console.log('st -' +rkap);

       });
         //total sp
         $.each(obj['sp'], function(key, val){
        
            //var rkap = parseFloat(val['RKAPVAL']/1000000000);
            var rkap = parseFloat(val['RKAPVAL']/10000000);
            var gr = parseFloat(val['GRVAL']/1000000000);
            var po = parseFloat(val['POVAL']/1000000000);

            //total
            sp_rkap = sp_rkap + parseFloat(rkap);
            sp_po = sp_po + parseFloat(po);
            sp_gr = sp_gr + parseFloat(gr);

             console.log('sp -' +rkap);

       });
         //total tlcc
         $.each(obj['tlcc'], function(key, val){
        
			//var rkap = parseFloat(val['RKAPVAL']/1000000000);
                      
			var rkap = parseFloat(val['RKAPVAL']/10000000);
            var gr = parseFloat(val['GRVAL']/1000000000);
            var po = parseFloat(val['POVAL']/1000000000);

            //total
            tlcc_rkap = tlcc_rkap + parseFloat(rkap);
            tlcc_po = tlcc_po + parseFloat(po);
            tlcc_gr = tlcc_gr + parseFloat(gr);

            console.log('tlcc -' +rkap);

       });
          console.log(gr_value);
        console.log(po_value);
        console.log(rkap_value);
        $('#sg_rkap').html(sg_rkap.toFixed(0) +'<font size="2"> B</font>');
        $('#sg_po').html(sg_po.toFixed(0) +'<font size="2"> B</font>');
        $('#sg_gr').html(sg_gr.toFixed(0) +'<font size="2"> B</font>');
        $('#sp_rkap').html(sp_rkap.toFixed(0) +'<font size="2"> B</font>');
        $('#sp_po').html(sp_po.toFixed(0) +'<font size="2"> B</font>');
        $('#sp_gr').html(sp_gr.toFixed(0)+'<font size="2"> B</font>');
        $('#st_rkap').html(st_rkap.toFixed(0) +'<font size="2"> B</font>');
        $('#st_po').html(st_po.toFixed(0) +'<font size="2"> B</font>');
        $('#st_gr').html(st_gr.toFixed(0) +'<font size="2"> B</font>');
        $('#tlcc_rkap').html(tlcc_rkap +'<font size="2"> B</font>');
        $('#tlcc_po').html(tlcc_po.toFixed(0) +'<font size="2"> B</font>');
        $('#tlcc_gr').html(tlcc_gr.toFixed(0) +'<font size="2"> B</font>');

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
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
    }
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
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
    
});