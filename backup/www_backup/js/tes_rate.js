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
                    }]
            });
        }
    }).done(function (data) {
    }).fail(function () {

    });
});