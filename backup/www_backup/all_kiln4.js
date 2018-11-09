$(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    $.ajax({
        url: url_src+'/json/_Klin4All.php',
        type: 'GET',
        success: function (data) {
            // var data1 = data.replace("<title>Json</title>", "");
            // var data2 = data1.replace("(", "[");
            // var data3 = data2.replace(");", "]");
            // var dataJson = JSON.parse(data3);
            // var myLogData = dataJson['7000'].Acc_KL4;
            // // console.log('data:',myLogData);

            // var labelArray = [];
            // var dataKL4_BearAmp = [];
            // var dataKL4_MotorAmp = [];
            // var dataKL4_OpsAmpIdF1 = [];
            // var dataKL4_OpsAmpIdF2 = [];
            // var dataKL4_OpsDampIdF1 = [];
            // var dataKL4_OpsDampIdF2 = [];
            // var dataKL4_OpsExTemp11 = [];
            // var dataKL4_OpsExTemp12 = [];
            // var dataKL4_OpsExTemp21 = [];
            // var dataKL4_OpsExTemp22 = [];
            // var dataKL4_OpsSpeedIdF1 = [];
            // var dataKL4_OpsSpeedIdF2 = [];
            // var dataKL4_OpsVib1IdF1 = [];
            // var dataKL4_OpsVib1IdF2 = [];
            // var dataKL4_OpsVib2IdF1 = [];
            // var dataKL4_OpsVib2IdF2 = [];

            // var index = [];

            // for (var x in myLogData) {
            //     index.push(x);
            //     labelArray.push(x);
            //     nilaiKL4_BearAmp = dataJson['7000'].Acc_KL4[x].KL4_BearAmp;
            //     dataKL4_BearAmp.push(parseInt(nilaiKL4_BearAmp.replace(',', '.')));

            //     nilaiKL4_BearAmp = dataJson['7000'].Acc_KL4[x].KL4_MotorAmp;
            //     dataKL4_MotorAmp.push(parseInt(nilaiKL4_BearAmp.replace(',', '.')));

            //     nilaiKL4_OpsAmpIdF1 = dataJson['7000'].Acc_KL4[x].KL4_OpsAmpIdF1;
            //     dataKL4_OpsAmpIdF1.push(parseInt(nilaiKL4_OpsAmpIdF1.replace(',', '.')));

            //     nilaiKL4_OpsAmpIdF2 = dataJson['7000'].Acc_KL4[x].KL4_OpsAmpIdF2;
            //     dataKL4_OpsAmpIdF2.push(parseInt(nilaiKL4_OpsAmpIdF2.replace(',', '.')));

            //     nilaiKL4_OpsDampIdF1 = dataJson['7000'].Acc_KL4[x].KL4_OpsDampIdF1;
            //     dataKL4_OpsDampIdF1.push(parseInt(nilaiKL4_OpsDampIdF1.replace(',', '.')));

            //     nilaiKL4_OpsDampIdF2 = dataJson['7000'].Acc_KL4[x].KL4_OpsDampIdF2;
            //     dataKL4_OpsDampIdF2.push(parseInt(nilaiKL4_OpsDampIdF2.replace(',', '.')));

            //     nilaiKL4_OpsExTemp11 = dataJson['7000'].Acc_KL4[x].KL4_OpsExTemp11;
            //     dataKL4_OpsExTemp11.push(parseInt(nilaiKL4_OpsExTemp11.replace(',', '.')));

            //     nilaiKL4_OpsExTemp12 = dataJson['7000'].Acc_KL4[x].KL4_OpsExTemp12;
            //     dataKL4_OpsExTemp12.push(parseInt(nilaiKL4_OpsExTemp12.replace(',', '.')));

            //     nilaiKL4_OpsExTemp21 = dataJson['7000'].Acc_KL4[x].KL4_OpsExTemp21;
            //     dataKL4_OpsExTemp21.push(parseInt(nilaiKL4_OpsExTemp21.replace(',', '.')));

            //     nilaiKL4_OpsExTemp22 = dataJson['7000'].Acc_KL4[x].KL4_OpsExTemp22;
            //     dataKL4_OpsExTemp22.push(parseInt(nilaiKL4_OpsExTemp22.replace(',', '.')));

            //     nilaiKL4_OpsSpeedIdF1 = dataJson['7000'].Acc_KL4[x].KL4_OpsSpeedIdF1;
            //     dataKL4_OpsSpeedIdF1.push(parseInt(nilaiKL4_OpsSpeedIdF1.replace(',', '.')));

            //     nilaiKL4_OpsSpeedIdF2 = dataJson['7000'].Acc_KL4[x].KL4_OpsSpeedIdF2;
            //     dataKL4_OpsSpeedIdF2.push(parseInt(nilaiKL4_OpsSpeedIdF2.replace(',', '.')));

            //     nilaiKL4_OpsVib1IdF1 = dataJson['7000'].Acc_KL4[x].KL4_OpsVib1IdF1;
            //     dataKL4_OpsVib1IdF1.push(parseInt(nilaiKL4_OpsVib1IdF1.replace(',', '.')));

            //     nilaiKL4_OpsVib1IdF2 = dataJson['7000'].Acc_KL4[x].KL4_OpsVib1IdF2;
            //     dataKL4_OpsVib1IdF2.push(parseInt(nilaiKL4_OpsVib1IdF2.replace(',', '.')));

            //     nilaiKL4_OpsVib2IdF1 = dataJson['7000'].Acc_KL4[x].KL4_OpsVib2IdF1;
            //     dataKL4_OpsVib2IdF1.push(parseInt(nilaiKL4_OpsVib2IdF1.replace(',', '.')));

            //     nilaiKL4_OpsVib2IdF2 = dataJson['7000'].Acc_KL4[x].KL4_OpsVib2IdF2;
            //     dataKL4_OpsVib2IdF2.push(parseInt(nilaiKL4_OpsVib2IdF2.replace(',', '.')));

            // }

            $('#KL4_BearAmp').highcharts({
                chart: {
                    type: 'line',
//                    zoomType: 'xy',
                    animation: Highcharts.svg//,
                            //marginRight: 10
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            // labelArray,
                    gridLineWidth: 1
//                    min: labelArray.length - 5,
//                    max: labelArray.length - 1
                },
                yAxis: {
                    min: 0,
                    max: 80,
                    tickPixelInterval: 8,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    shared: true
                },
                legend: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    line: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                scrollbar: {
                    enabled: false,
                    liveRedraw: true
                },
                series: [{
                        name: 'Bearing Temperature',
                        color: '#87D37C',
                        data: [70, 49, 55, 45, 20, 21, 25, 50, 23, 83, 13, 46]
                        // dataKL4_BearAmp
                    }]
            });

            $('#KL4_MotorAmp').highcharts({
                chart: {
                    type: 'line',
//                    zoomType: 'xy',
                    animation: Highcharts.svg//,
                            //marginRight: 10
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            // labelArray,
                    gridLineWidth: 1
//                    min: labelArray.length - 5,
//                    max: labelArray.length - 1
                },
                yAxis: {
                    min: 0,
                    max: 800,
                    tickPixelInterval: 8,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    shared: true
                },
                legend: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    line: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                scrollbar: {
                    enabled: false,
                    liveRedraw: true
                },
                series: [{
                        name: 'Motor Current',
                        color: '#F7CA18',
                        data: [70, 49, 55, 45, 20, 21, 25, 50, 23, 83, 13, 46]
                        // dataKL4_MotorAmp
                    }]
            });

//            $('#KL4_OpsAmpIdF1').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsAmpIdF1'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsAmpIdF1',
//                        data: dataKL4_OpsAmpIdF1
//                    }]
//            });
//            
//             $('#KL4_OpsAmpIdF2').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsAmpIdF2'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsAmpIdF2',
//                        data: dataKL4_OpsAmpIdF2
//                    }]
//            });
//            
//            $('#KL4_OpsDampIdF1').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsDampIdF1'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsDampIdF1',
//                        data: dataKL4_OpsDampIdF1
//                    }]
//            });
//            
//            $('#KL4_OpsDampIdF2').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsDampIdF2'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsDampIdF2',
//                        data: dataKL4_OpsDampIdF2
//                    }]
//            });
//            
//            $('#KL4_OpsExTemp11').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsExTemp11'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsExTemp11',
//                        data: dataKL4_OpsExTemp11
//                    }]
//            });
//            
//            $('#KL4_OpsExTemp12').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsExTemp12'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsExTemp12',
//                        data: dataKL4_OpsExTemp12
//                    }]
//            });
//            
//            $('#KL4_OpsExTemp21').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsExTemp21'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsExTemp21',
//                        data: dataKL4_OpsExTemp21
//                    }]
//            });
//            
//            
//             $('#KL4_OpsExTemp22').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsExTemp22'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsExTemp22',
//                        data: dataKL4_OpsExTemp22
//                    }]
//            });
//            
//            $('#KL4_OpsSpeedIdF1').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsSpeedIdF1'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsSpeedIdF1',
//                        data: dataKL4_OpsSpeedIdF1
//                    }]
//            });
//         
//            $('#KL4_OpsSpeedIdF2').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsSpeedIdF2'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsSpeedIdF2',
//                        data: dataKL4_OpsSpeedIdF2
//                    }]
//            });
//            
//            $('#KL4_OpsVib1IdF1').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsVib1IdF1'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsVib1IdF1',
//                        data: dataKL4_OpsVib1IdF1
//                    }]
//            });
//            
//            $('#KL4_OpsVib1IdF2').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsVib1IdF2'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsVib1IdF2',
//                        data: dataKL4_OpsVib1IdF2
//                    }]
//            });
//    
//    
//     $('#KL4_OpsVib2IdF1').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsVib2IdF1'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsVib2IdF1',
//                        data: dataKL4_OpsVib2IdF1
//                    }]
//            });
//    
//
//    $('#KL4_OpsVib2IdF2').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL4_OpsVib2IdF2'
//                },
//                xAxis: {
//                    categories: labelArray,
//                    max: 5
//                },
//                yAxis: {
//                    title: {
//                        text: 'Value'
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    shared: true
//                },
//                legend: {
//                    enabled: true
//                },
//                exporting: {
//                    enabled: false
//                },
//                credits: {
//                    enabled: false
//                },
//                scrollbar: {
//                    enabled: true
//                },
//                series: [{
//                        name: 'KL4_OpsVib2IdF2',
//                        data: dataKL4_OpsVib2IdF2
//                    }]
//            });

        }
    }).done(function (data) {
    }).fail(function () {

    });
});
$(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
    $.ajax({
        url: url_src+'/json/AddTuban34.php',
        type: 'GET',
        success: function (data) {
            // var data1 = data.replace("<title>Json</title>", "");
            // var data2 = data1.replace("(", "[");
            // var data3 = data2.replace(");", "]");

            // var dataJson = JSON.parse(data3);
            // var myLogData = dataJson['7000'].Additional;

            // var labelArray = [];
            // var dataRate1 = [];
            // var dataRate2 = [];
            // var index = [];

            // for (var x in myLogData) {
            //     index.push(x);
            //     labelArray.push(x);
            //     nilaiRate1 = dataJson['7000'].Additional[x].kl4_sp;
            //     dataRate1.push(parseInt(nilaiRate1.replace(',', '')));
                
            //     nilaiRate2 = dataJson['7000'].Additional[x].kl4_tq;
            //     dataRate2.push(parseInt(nilaiRate2.replace(',', '')));
            // }
            $('#speed4').highcharts({
                chart: {
                    type: 'line',
//                                zoomType: 'xy',
                    animation: Highcharts.svg//,
                            //marginRight: 10
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            // labelArray,
                    gridLineWidth: 1
//                                min: labelArray.length - 5,
//                                max: labelArray.length - 1
                },
                yAxis: [{
                        min: 0,
                        max: 5,
                        tickPixelInterval: 8,
                        title: {
                            text: ''
                        }
                    }],
                tooltip: {
                    shared: true
                },
                exporting: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    line: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                scrollbar: {
                    enabled: false,
                    liveRedraw: true
                },
                series: [{
                        name: 'Speed',
                        color: '#E74C3C',
                        data: [1, 4, 3, 0, 2, 2, 4, 3, 3, 1, 1, 4]
                                // dataRate1
                    }]
            });
            
            $('#torque4').highcharts({
                chart: {
                    type: 'line',
//                                zoomType: 'xy',
                    animation: Highcharts.svg//,
                            //marginRight: 10
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            // labelArray,
                    gridLineWidth: 1
//                                min: labelArray.length - 5,
//                                max: labelArray.length - 1
                },
                yAxis: [{
                        min: 0,
                        max: 80,
                        tickPixelInterval: 8,
                        title: {
                            text: ''
                        }
                    }],
                tooltip: {
                    shared: true
                },
                exporting: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    line: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                scrollbar: {
                    enabled: false,
                    liveRedraw: true
                },
                series: [{
                        name: 'Torque',
                        color: '#19B5FE',
                        data: [70, 49, 55, 45, 20, 21, 25, 50, 23, 83, 13, 46]
                                // dataRate2
                    }]
            });
        }
    }).done(function (data) {
    }).fail(function () {

    });
});