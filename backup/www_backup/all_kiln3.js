$(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    $.ajax({
        url: url_src+'/json/_Klin3All.php',
        type: 'GET',
        success: function (data) {
            // var data1 = data.replace("<title>Json</title>", "");
            // var data2 = data1.replace("(", "[");
            // var data3 = data2.replace(");", "]");
            // var dataJson = JSON.parse(data3);
            // var myLogData = dataJson['7000'].Acc_KL3;
            // // console.log('data:',myLogData);

            // var labelArray = [];
            // var dataKL3_BearTemp = [];
            // var dataKL3_KilnAmp = [];
            // var dataKL3_OpsDampIdF1 = [];
            // var dataKL3_OpsDampIdF2 = [];
            // var dataKL3_OpsExTemp1 = [];
            // var dataKL3_OpsExTemp2 = [];
            // var dataKL3_OpsPowerIdF11 = [];
            // var dataKL3_OpsPowerIdF21 = [];
            // var dataKL3_OpsSpeedIdF12 = [];
            // var dataKL3_OpsSpeedIdF22 = [];
            // var dataKL3_OpsVib1IdF11 = [];
            // var dataKL3_OpsVib1IdF21 = [];
            // var dataKL3_OpsVib2IdF12 = [];
            // var dataKL3_OpsVib2IdF22 = [];

            // var index = [];

            // for (var x in myLogData) {
            //     index.push(x);
            //     labelArray.push(x);
            //     nilaiKL3_BearTemp = dataJson['7000'].Acc_KL3[x].KL3_BearTemp;
            //     dataKL3_BearTemp.push(parseInt(nilaiKL3_BearTemp.replace(',', '.')));

            //     nilaiKL3_BearTemp = dataJson['7000'].Acc_KL3[x].KL3_KilnAmp;
            //     dataKL3_KilnAmp.push(parseInt(nilaiKL3_BearTemp.replace(',', '.')));

            //     nilaiKL3_OpsDampIdF1 = dataJson['7000'].Acc_KL3[x].KL3_OpsDampIdF1;
            //     dataKL3_OpsDampIdF1.push(parseInt(nilaiKL3_OpsDampIdF1.replace(',', '.')));

            //     nilaiKL3_OpsDampIdF2 = dataJson['7000'].Acc_KL3[x].KL3_OpsDampIdF2;
            //     dataKL3_OpsDampIdF2.push(parseInt(nilaiKL3_OpsDampIdF2.replace(',', '.')));

            //     nilaiKL3_OpsExTemp1 = dataJson['7000'].Acc_KL3[x].KL3_OpsExTemp1;
            //     dataKL3_OpsExTemp1.push(parseInt(nilaiKL3_OpsExTemp1.replace(',', '.')));

            //     nilaiKL3_OpsExTemp2 = dataJson['7000'].Acc_KL3[x].KL3_OpsExTemp2;
            //     dataKL3_OpsExTemp2.push(parseInt(nilaiKL3_OpsExTemp2.replace(',', '.')));

            //     nilaiKL3_OpsPowerIdF11 = dataJson['7000'].Acc_KL3[x].KL3_OpsPowerIdF11;
            //     dataKL3_OpsPowerIdF11.push(parseInt(nilaiKL3_OpsPowerIdF11.replace(',', '.')));

            //     nilaiKL3_OpsPowerIdF21 = dataJson['7000'].Acc_KL3[x].KL3_OpsPowerIdF21;
            //     dataKL3_OpsPowerIdF21.push(parseInt(nilaiKL3_OpsPowerIdF21.replace(',', '.')));

            //     nilaiKL3_OpsSpeedIdF12 = dataJson['7000'].Acc_KL3[x].KL3_OpsSpeedIdF12;
            //     dataKL3_OpsSpeedIdF12.push(parseInt(nilaiKL3_OpsSpeedIdF12.replace(',', '.')));

            //     nilaiKL3_OpsSpeedIdF22 = dataJson['7000'].Acc_KL3[x].KL3_OpsSpeedIdF22;
            //     dataKL3_OpsSpeedIdF22.push(parseInt(nilaiKL3_OpsSpeedIdF22.replace(',', '.')));

            //     nilaiKL3_OpsVib1IdF11 = dataJson['7000'].Acc_KL3[x].KL3_OpsVib1IdF11;
            //     dataKL3_OpsVib1IdF11.push(parseInt(nilaiKL3_OpsVib1IdF11.replace(',', '.')));

            //     nilaiKL3_OpsVib1IdF21 = dataJson['7000'].Acc_KL3[x].KL3_OpsVib1IdF21;
            //     dataKL3_OpsVib1IdF21.push(parseInt(nilaiKL3_OpsVib1IdF21.replace(',', '.')));

            //     nilaiKL3_OpsVib2IdF12 = dataJson['7000'].Acc_KL3[x].KL3_OpsVib2IdF12;
            //     dataKL3_OpsVib2IdF12.push(parseInt(nilaiKL3_OpsVib2IdF12.replace(',', '.')));

            //     nilaiKL3_OpsVib2IdF22 = dataJson['7000'].Acc_KL3[x].KL3_OpsVib2IdF22;
            //     dataKL3_OpsVib2IdF22.push(parseInt(nilaiKL3_OpsVib2IdF22.replace(',', '.')));

            // }

            $('#KL3_BearTemp').highcharts({
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
                        color: '#F7CA18',
                        data: [10, 69, 55, 45, 42, 25, 52, 15, 33, 18, 13, 46]
                        // dataKL3_BearTemp
                    }]
            });



            $('#KL3_KilnAmp').highcharts({
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
                        name: 'Motor Currrent',
                        color: '#E74C3C',
                        data: [10, 69, 55, 45, 42, 25, 52, 15, 33, 18, 13, 46]
                        // dataKL3_KilnAmp
                    }]
            });

//            $('#KL3_OpsDampIdF1').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsDampIdF1'
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
//                        name: 'KL3_OpsDampIdF1',
//                        data: dataKL3_OpsDampIdF1
//                    }]
//            });
//            
//             $('#KL3_OpsDampIdF2').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsDampIdF2'
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
//                        name: 'KL3_OpsDampIdF2',
//                        data: dataKL3_OpsDampIdF2
//                    }]
//            });
//            
//            $('#KL3_OpsExTemp1').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsExTemp1'
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
//                        name: 'KL3_OpsExTemp1',
//                        data: dataKL3_OpsExTemp1
//                    }]
//            });
//            
//            $('#KL3_OpsExTemp2').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsExTemp2'
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
//                        name: 'KL3_OpsExTemp2',
//                        data: dataKL3_OpsExTemp2
//                    }]
//            });
//            
//            $('#KL3_OpsPowerIdF11').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsPowerIdF11'
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
//                        name: 'KL3_OpsPowerIdF11',
//                        data: dataKL3_OpsPowerIdF11
//                    }]
//            });
//            
//            $('#KL3_OpsPowerIdF21').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsPowerIdF21'
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
//                        name: 'KL3_OpsPowerIdF21',
//                        data: dataKL3_OpsPowerIdF21
//                    }]
//            });
//            
//            $('#KL3_OpsSpeedIdF12').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsSpeedIdF12'
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
//                        name: 'KL3_OpsSpeedIdF12',
//                        data: dataKL3_OpsSpeedIdF12
//                    }]
//            });
//            
//            
//             $('#KL3_OpsSpeedIdF22').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsSpeedIdF22'
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
//                        name: 'KL3_OpsSpeedIdF22',
//                        data: dataKL3_OpsSpeedIdF22
//                    }]
//            });
//            
//            $('#KL3_OpsVib1IdF11').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsVib1IdF11'
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
//                        name: 'KL3_OpsVib1IdF11',
//                        data: dataKL3_OpsVib1IdF11
//                    }]
//            });
//         
//            $('#KL3_OpsVib1IdF21').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsVib1IdF21'
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
//                        name: 'KL3_OpsVib1IdF21',
//                        data: dataKL3_OpsVib1IdF21
//                    }]
//            });
//            
//            $('#KL3_OpsVib2IdF12').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsVib2IdF12'
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
//                        name: 'KL3_OpsVib2IdF12',
//                        data: dataKL3_OpsVib2IdF12
//                    }]
//            });
//            
//            $('#KL3_OpsVib2IdF22').highcharts({
//                chart: {
//                    type: 'spline',
//                    zoomType: 'x',
//                    animation: Highcharts.svg//,
//                            //marginRight: 10
//                },
//                title: {
//                    text: 'KL3_OpsVib2IdF22'
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
//                        name: 'KL3_OpsVib2IdF22',
//                        data: dataKL3_OpsVib2IdF22
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
            //     nilaiRate1 = dataJson['7000'].Additional[x].kl3_sp;
            //     dataRate1.push(parseInt(nilaiRate1.replace(',', '')));
                
            //     nilaiRate2 = dataJson['7000'].Additional[x].kl3_tq;
            //     dataRate2.push(parseInt(nilaiRate2.replace(',', '')));

            // }

            $('#speed3').highcharts({
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
                        color: '#87D37C',
                        data: [1, 4, 3, 0, 2, 2, 4, 3, 3, 1, 1, 4]
                                // dataRate1
                    }]
            });
            
            $('#torque3').highcharts({
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