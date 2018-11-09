// JavaScript Document <script>
$(function myChart(Vib, Temp, Amp) {

    var gaugeOptions = {
        chart: {
            type: 'solidgauge'
        },
        credits: {
            enabled: false
        },
        title: null,
        pane: {
            center: ['50%', '85%'],
            size: '140%',
            startAngle: -90,
            endAngle: 90,
            background: {
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
        },
        tooltip: {
            enabled: false
        },
        // the value axis
        yAxis: {
            stops: [
                [0.1, '#55BF3B'], // green
                [0.5, '#DDDF0D'], // yellow
                [0.9, '#DF5353'] // red
            ],
            lineWidth: 0,
            minorTickInterval: null,
            tickAmount: 2,
            title: {
                y: -70
            },
            labels: {
                y: 16
            }
        },
        plotOptions: {
            solidgauge: {
                dataLabels: {
                    y: 5,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        }
    };

    // The speed gauge
    $('#container-speed').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 200,
            title: {
                text: 'Speed'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
                name: 'Speed',
                data: [],
                dataLabels: {
                    format: '<div style="text-align:center"><span style="font-size:15px;color:' +
                            ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                            '<span style="font-size:12px;color:silver">rpm</span></div>'
                },
                tooltip: {
                    valueSuffix: ' km/h'
                }
            }]

    }));

    // The Temp gauge
    $('#container-temp').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'temp'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
                name: 'temp',
                data: Temp,
                dataLabels: {
                    format: '<div style="text-align:center"><span style="font-size:15px;color:' +
                            ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                            '<span style="font-size:12px;color:silver">Celc</span></div>'
                },
                tooltip: {
                    valueSuffix: ' Celcius'
                }
            }]

    }));
// The vibra gauge
    $('#container-vibre').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 20,
            title: {
                text: 'vibre'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
                name: 'vibre',
                data: Vib,
                dataLabels: {
                    format: '<div style="text-align:center"><span style="font-size:15px;color:' +
                            ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                            '<span style="font-size:12px;color:silver">mm/s</span></div>'
                },
                tooltip: {
                    valueSuffix: ' vibra'
                }
            }]

    }));

    // The ampere gauge
    $('#container-ampere').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'ampere'
            }
        },
        series: [{
                name: 'ampere',
                data: Amp,
                dataLabels: {
                    format: '<div style="text-align:center"><span style="font-size:15px;color:' +
                            ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y:.1f}</span><br/>' +
                            '<span style="font-size:12px;color:silver">Amp</span></div>'
                },
                tooltip: {
                    valueSuffix: ' A'
                }
            }]

    }));

    // Bring life to the dials
    
//    $.ajax({
//            url: url_opc+'/GenerateJsonAccTuban34.php',
//            type: 'GET',
//            success: function (data) {
//                var data1 = data.replace("<title>Json</title>", "");
//                var data2 = data1.replace("(", "[");
//                var data3 = data2.replace(");", "]");
//                var dataJson = JSON.parse(data3);
//
//                ValVibRM3 = dataJson[0].tags[43].props[0].val;
//                ValAmpRM3 = dataJson[0].tags[41].props[0].val;
//                ValTempRM3 = dataJson[0].tags[42].props[0].val;
//
//                Vib = Number(parseFloat(ValVibRM3).toFixed(2));
//                Amp = Number(parseFloat(ValAmpRM3).toFixed(2));
//                Temp = Number(parseFloat(ValTempRM3).toFixed(2));
//                
//                myChart(Vib, Temp, Amp);

//            }
//        }).done(function (data) {}).fail(function () {
//
//        });
    setInterval( function () {
        $.ajax({
            url: url_opc+'/GenerateJsonAccTuban34.php',
            type: 'GET',
            success: function (data) {
                var data1 = data.replace("<title>Json</title>", "");
                var data2 = data1.replace("(", "[");
                var data3 = data2.replace(");", "]");
                var dataJson = JSON.parse(data3);

                ValVibRM3 = dataJson[0].tags[43].props[0].val;
                ValAmpRM3 = dataJson[0].tags[41].props[0].val;
                ValTempRM3 = dataJson[0].tags[42].props[0].val;

                Vib = Number(parseFloat(ValVibRM3).toFixed(2));
                Amp = Number(parseFloat(ValAmpRM3).toFixed(2));
                Temp = Number(parseFloat(ValTempRM3).toFixed(2));
                
                myChart(Vib, Temp, Amp);
//                var vibchart = $('#container-vibre').highcharts().series[0].points[0];
//                vibchart.update(Vib);
//                var ampchart = $('#container-ampere').highcharts().series[0].points[0];
//                ampchart.update(Amp);
//                var tempchart = $('#container-temp').highcharts().series[0].points[0];
//                tempchart.update(Temp);
            }
        }).done(function (data) {}).fail(function () {

        });
    }, 2000);
});

