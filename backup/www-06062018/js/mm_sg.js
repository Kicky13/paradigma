$(function () {
var rkap_value = [0,0,0,0,0,0,0,0,0,0,0,0];
 var gr_value =   [0,0,0,0,0,0,0,0,0,0,0,0];
 var po_value = [0,0,0,0,0,0,0,0,0,0,0,0]; 
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