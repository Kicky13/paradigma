$(function () {
    $('#vibrasi').highcharts({
        chart: {
            type: 'gauge',
            height: 198
        },
        title: {
            text: 'Vibration'
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '103%',
                    innerRadius: '103%'
                }]
        },
        yAxis: {
            min: 0,
            max: 100,
            labels: {
                rotation: 'auto'
            },
            title: {
                text: ''
            },
            plotBands: [{
                    from: 0,
                    to: 75,
                    color: '#DF5353', // green
                    innerRadius: 69,
                    outerRadius: 89
                }, {
                    from: 75,
                    to: 100,
                    color: '#55BF3B', // red
                    innerRadius: 69,
                    outerRadius: 89
                }],
        },
        series: [{
                name: 'Vibration',
                data: [0],
                tooltip: {
                    valueSuffix: 'mm/s'
                }
            }]

    },
            function (chart) {
                if (!chart.renderer.forExport) {
                    setInterval(function () {
                        $.ajax({
                            url: url_opc+'/GenerateJsonAccTuban34.php',
                            type: 'GET',
                            success: function (data) {
                                var data1 = data.replace("<title>Json</title>", "");
                                var data2 = data1.replace("(", "[");
                                var data3 = data2.replace(");", "]");
                                var dataJson = JSON.parse(data3);

                                ValVibRM3 = dataJson[0].tags[2].props[0].val;
                                Vib = Number(parseFloat(ValVibRM3).toFixed(2));

                                var point = chart.series[0].points[0];
                                point.update(Vib);
                            }
                        }).done(function (data) {}).fail(function () {

                        });
                    }, 500);
                }
            });
    $('#ampere').highcharts({
        chart: {
            type: 'gauge',
            height: 198
        },
        title: {
            text: 'Current'
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '103%',
                    innerRadius: '103%'
                }]
        },
        yAxis: {
            min: 0,
            max: 100,
            labels: {
                rotation: 'auto'
            },
            title: {
                text: ''
            },
            plotBands: [{
                    from: 0,
                    to: 75,
                    color: '#DF5353', // green
                    innerRadius: 69,
                    outerRadius: 89
                }, {
                    from: 75,
                    to: 100,
                    color: '#55BF3B', // red
                    innerRadius: 69,
                    outerRadius: 89
                }],
        },
        series: [{
                name: 'Ampere',
                data: [0],
                tooltip: {
                    valueSuffix: 'Amp'
                }
            }]

    },
            function (chart) {
                if (!chart.renderer.forExport) {
                    setInterval(function () {
                        $.ajax({
                            url: url_opc+'/GenerateJsonAccTuban34.php',
                            type: 'GET',
                            success: function (data) {
                                var data1 = data.replace("<title>Json</title>", "");
                                var data2 = data1.replace("(", "[");
                                var data3 = data2.replace(");", "]");
                                var dataJson = JSON.parse(data3);

                                ValAmpRM3 = dataJson[0].tags[1].props[0].val;
                                Amp = Number(parseFloat(ValAmpRM3).toFixed(2));

                                var point = chart.series[0].points[0];
                                point.update(Amp);
                            }
                        }).done(function (data) {}).fail(function () {

                        });
                    }, 500);
                }
            });
    $('#temperature').highcharts({
        chart: {
            type: 'gauge',
            height: 198
        },
        credits: {
            enabled: false
        },
        title: {
            text: 'Temperature'
        },
        exporting: {
            enabled: false
        },
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '103%',
                    innerRadius: '103%'
                }]
        },
        yAxis: {
            min: 0,
            max: 100,
            labels: {
                rotation: 'auto'
            },
            title: {
                text: ''
            },
            plotBands: [{
                    from: 0,
                    to: 75,
                    color: '#DF5353', // green
                    innerRadius: 69,
                    outerRadius: 89
                }, {
                    from: 75,
                    to: 100,
                    color: '#55BF3B', // red
                    innerRadius: 69,
                    outerRadius: 89
                }],
        },
        series: [{
                name: 'Temp',
                data: [0],
                tooltip: {
                    valueSuffix: '̊Celc'
                }
            }]

    },
            function (chart) {
                if (!chart.renderer.forExport) {
                    setInterval(function () {
                        $.ajax({
                            url: url_opc+'/GenerateJsonAccTuban34.php',
                            type: 'GET',
                            success: function (data) {
                                var data1 = data.replace("<title>Json</title>", "");
                                var data2 = data1.replace("(", "[");
                                var data3 = data2.replace(");", "]");
                                var dataJson = JSON.parse(data3);

                                ValTempRM3 = dataJson[0].tags[0].props[0].val;
                                Temp = Number(parseFloat(ValTempRM3).toFixed(2));

                                var point = chart.series[0].points[0];
                                point.update(Temp);
                            }
                        }).done(function (data) {}).fail(function () {

                        });
                    }, 500);
                }
            });
    $('#speed').highcharts({
        chart: {
            type: 'gauge',
            height: 198
        },
        credits: {
            enabled: false
        },
        title: {
            text: 'Speed'
        },
        exporting: {
            enabled: false
        },
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '103%',
                    innerRadius: '103%'
                }]
        },
        yAxis: {
            min: 0,
            max: 100,
            labels: {
                rotation: 'auto'
            },
            title: {
                text: ''
            },
            plotBands: [{
                    from: 0,
                    to: 75,
                    color: '#DF5353', // green
                    innerRadius: 69,
                    outerRadius: 89
                }, {
                    from: 75,
                    to: 100,
                    color: '#55BF3B', // red
                    innerRadius: 69,
                    outerRadius: 89
                }],
        },
        series: [{
                name: 'Speed',
                data: [0],
                tooltip: {
                    shared: true,
                    valueSuffix: 'rpm'
                }
            }]

    });
});

$(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    $.ajax({
        url: url_opc+'/_CMTuban34.php',
        type: 'GET',
        success: function (data) {
            var data1 = data.replace("<title>Json</title>", "");
            var data2 = data1.replace("(", "[");
            var data3 = data2.replace(");", "]");

            var dataJson = JSON.parse(data3);
            var myLogData = dataJson['7000'].Acc_CM;

            var labelArray = [];
            var dataRate1 = [];
            var dataRate2 = [];
            var dataRate3 = [];
            var dataRate4 = [];
            var dataRate5 = [];
            var dataRate6 = [];
            var index = [];

            for (var x in myLogData) {
                index.push(x);
                labelArray.push(x);
                nilaiRate1 = dataJson['7000'].Acc_CM[x].CM3_MotAmp;
                dataRate1.push(parseInt(nilaiRate1.replace(',', '.')));

                nilaiRate2 = dataJson['7000'].Acc_CM[x].CM3_MotBearTemp
                dataRate2.push(parseInt(nilaiRate2.replace(',', '.')));
                
                nilaiRate3 = dataJson['7000'].Acc_CM[x].CM3_MotVib;
                dataRate3.push(parseInt(nilaiRate3.replace(',', '.')));

                nilaiRate4 = dataJson['7000'].Acc_CM[x].CM4_MotAmp
                dataRate4.push(parseInt(nilaiRate4.replace(',', '.')));
                
                nilaiRate5 = dataJson['7000'].Acc_CM[x].CM4_MotBearTemp;
                dataRate5.push(parseInt(nilaiRate5.replace(',', '.')));

                nilaiRate6 = dataJson['7000'].Acc_CM[x].CM4_MotVib
                dataRate6.push(parseInt(nilaiRate6.replace(',', '.')));
                
                console.log(dataRate6);
            }

            $('#container').highcharts({
                chart: {
                    type: 'spline',
                    zoomType: 'x',
                    animation: Highcharts.svg//,
                            //marginRight: 10
                },
                title: {
                    text: 'Rate KILN 3'
                },
                xAxis: {
                    categories: labelArray,
                    max: 5
                },
                yAxis: {
                    title: {
                        text: 'Value'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                tooltip: {
                    shared: true
                },
                legend: {
                    enabled: true
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                scrollbar: {
                    enabled: true
                },
                series: [{
                        name: 'Rate KILN 3',
                        data: dataRate1
                    },{
                        name: 'Rate KILN 3',
                        data: dataRate2
                    },{
                        name: 'Rate KILN 3',
                        data: dataRate3,
                    }]
                
            });
            console.log(dataRate3);
        }
    }).done(function (data) {
    }).fail(function () {

    });
});