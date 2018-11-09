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
            var index = [];

            for (var x in myLogData) {
                index.push(x);
                labelArray.push(x);
                nilaiRate1 = dataJson['7000'].Acc_CM[x].CM3_MotAmp;
                dataRate1.push(parseInt(nilaiRate1.replace(',', '.')));

                nilaiRate2 = dataJson['7000'].Acc_CM[x].CM3_MotBearTemp;
                dataRate2.push(parseInt(nilaiRate2.replace(',', '.')));

                nilaiRate3 = dataJson['7000'].Acc_CM[x].CM3_MotVib;
                dataRate3.push(parseInt(nilaiRate3.replace(',', '.')));
            }
            
            $('#ampere').highcharts({
                chart: {
                    type: 'spline',
                    zoomType: 'x',
                    animation: Highcharts.svg//,
                            //marginRight: 10
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: labelArray,
                    min: labelArray.length - 5,
                    max: labelArray.length - 1
                },
                yAxis: [{
                        min: 0,
                        max: 80,
                        tickPixelInterval: 8,
                        title: {
                            text: 'Value'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    }],
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
                    enabled: true,
                    liveRedraw: true
                },
                series: [{
                        name: 'Rate Ampere',
                        data: dataRate1
                    }]
            });
            
            $('#vibrasi').highcharts({
                chart: {
                    type: 'spline',
                    zoomType: 'x',
                    animation: Highcharts.svg//,
                            //marginRight: 10
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: labelArray,
                    min: labelArray.length - 5,
                    max: labelArray.length - 1
                },
                yAxis: [{
                        min: 0,
                        max: 80,
                        tickPixelInterval: 8,
                        title: {
                            text: 'Value'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    }],
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
                    enabled: true,
                    liveRedraw: true
                },
                series: [{
                        name: 'Rate Vibrasi',
                        data: dataRate3
                    }]
            });
            
            $('#temperature').highcharts({
                chart: {
                    type: 'spline',
                    zoomType: 'x',
                    animation: Highcharts.svg//,
                            //marginRight: 10
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: labelArray,
                    min: labelArray.length - 5,
                    max: labelArray.length - 1
                },
                yAxis: [{
                        min: 0,
                        max: 80,
                        tickPixelInterval: 8,
                        title: {
                            text: 'Value'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    }],
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
                    enabled: true,
                    liveRedraw: true
                },
                series: [{
                        name: 'Rate Temperatire',
                        data: dataRate2
                    }]
            });
        }
    }).done(function (data) {
    }).fail(function () {

    });
});