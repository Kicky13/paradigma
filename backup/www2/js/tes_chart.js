$(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    $.ajax({
        url: url_opc+'/FeedKL34.php',
        type: 'GET',
        success: function (data) {
            var data1 = data.replace("<title>Json</title>", "");
            var data2 = data1.replace("(", "[");
            var data3 = data2.replace(");", "]");

            var dataJson = JSON.parse(data3);
            var myLogData = dataJson['7000'].Feed_Kiln;

            var labelArray = [];
            var dataRate1 = [];
            var dataRate2 = [];
            var index = [];

            for (var x in myLogData) {
                index.push(x);
                labelArray.push(x);
                nilaiRate1 = dataJson['7000'].Feed_Kiln[x].kl3;
                dataRate1.push(parseInt(nilaiRate1.replace(',', '.')));

                nilaiRate2 = dataJson['7000'].Feed_Kiln[x].kl4;
                dataRate2.push(parseInt(nilaiRate2.replace(',', '.')));
            }
            
            console.log(labelArray);
//            $('#container').highcharts({
//                credits: {
//                    enabled: false
//                },
//                exporting: {
//                    enabled: false
//                },
//                chart: {
//                    backgroundColor: 'rgba(0, 255, 0, 0)',
//                    polar: true,
//                },
//                xAxis: {
//                    categories: labelArray
//                },
//                plotOptions: {
//                    series: {
//                        states: {
//                            hover: {
//                                enabled: false
//                            }
//                        }
//                    }
//                },
//                series: [{
//                        name: 'KILN 3',
//                        color: '#e74c3c',
//                        data: dataRate1,
//                        type: 'spline',
//                    }, {
//                        name: 'KILN 4',
//                        color: '#3498db',
//                        data: dataRate2,
//                        type: 'spline',
//                    }
//                ]
//            });


            $('#container').highcharts('StockChart', {
                chart: {
//                    events: {
//                        load: function () {
//
//                            // set up the updating of the chart each second
//                            var series = this.series[0];
//                            setInterval(function () {
//                                var x = (new Date()).getTime(), // current time
//                                        y = Math.round(Math.random() * 100);
//                                series.addPoint([x, y], true, true);
//                            }, 1000);
//                        }
//                    }
                },
                xAxis: {
                    type: String,
                    categories: labelArray
                },
                credits: {
                    enabled: false
                },
//                rangeSelector: {
//                    buttons: [{
//                            count: 1,
//                            type: 'minute',
//                            text: '1M'
//                        }, {
//                            count: 5,
//                            type: 'minute',
//                            text: '5M'
//                        }, {
//                            type: 'all',
//                            text: 'All'
//                        }],
//                    inputEnabled: false,
//                    selected: 0
//                },
                title: {
                    text: 'KILN 3 Rate'
                },
                exporting: {
                    enabled: false
                },
                series: [{
                        name: 'Random data',
                        type: 'spline',
                        data: dataRate1
                    }]
            });
        }
    }).done(function (data) {
    }).fail(function () {

    });
});