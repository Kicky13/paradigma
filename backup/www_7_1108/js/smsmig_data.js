$(function () {

    $.ajax({
        url: url_src+'/ScoOpcoGenDetail.php?company=5&tahun=2016',
        type: 'GET',
        success: function (data) {
            var data = eval('(' + data + ')');

            var targetjanuari = data['s01'].target;
            var realjanuari = data['s01'].real;

            var targetfebruari = data['s02'].target;
            var realfebruari = data['s02'].real;

            var targetmaret = data['s03'].target;
            var realmaret = data['s03'].real;

            var targetapril = data['s04'].target;
            var realapril = data['s04'].real;

            var targetmei = data['s05'].target;
            var realmei = data['s05'].real;

            var targetjuni = data['s06'].target;
            var realjuni = data['s06'].real;

            var targetjuli = data['s07'].target;
            var realjuli = data['s07'].real;

            var targetagustus = data['s08'].target;
            var realagustus = data['s08'].real;

            var targetseptember = data['s09'].target;
            var realseptember = data['s09'].real;

            //  var smigtarget = Number(target7000)+Number(target4000)+Number(target3000);
            //   var smigreal = Number(real7000)+Number(real4000)+Number(real3000);

            var percentjanuari = (realjanuari / targetjanuari) * 100;
            var percentfebruari = (realfebruari / targetfebruari) * 100;
            var percentmaret = (realmaret / targetmaret) * 100;
            var percentapril = (realapril / targetapril) * 100;
            var percentmei = (realmei / targetmei) * 100;
            var percentjuni = (realjuni / targetjuni) * 100;
            var percentjuli = (realjuli / targetjuli) * 100;
            var percentagustus = (realagustus / targetagustus) * 100;
            var percentseptember = (realseptember / targetseptember) * 100;


            $("#percentjanuari").html(percentjanuari.toFixed(2) + '<font size="3"> %</font>');
            $("#percentfebruari").html(percentfebruari.toFixed(2) + '<font size="3"> %</font>');
            $("#percentmaret").html(percentmaret.toFixed(2) + '<font size="3"> %</font>');
            $("#percentapril").html(percentapril.toFixed(2) + '<font size="3"> %</font>');
            $("#percentmei").html(percentmei.toFixed(2) + '<font size="3"> %</font>');
            $("#percentjuni").html(percentjuni.toFixed(2) + '<font size="3"> %</font>');
            $("#percentjuli").html(percentjuli.toFixed(2) + '<font size="3"> %</font>');
            $("#percentagustus").html(percentagustus.toFixed(2) + '<font size="3"> %</font>');
            $("#percentseptember").html(percentseptember.toFixed(2) + '<font size="3"> %</font>');

            //Chart
            var rkap_chart = [];
            var real_chart = [];

            rkap_chart.push(parseInt(targetjanuari / 1000));
            real_chart.push(parseInt(realjanuari) / 1000);

            rkap_chart.push(parseInt(targetfebruari / 1000));
            real_chart.push(parseInt(realfebruari) / 1000);

            rkap_chart.push(parseInt(targetmaret) / 1000);
            real_chart.push(parseInt(realmaret) / 1000);

            rkap_chart.push(parseInt(targetapril) / 1000);
            real_chart.push(parseInt(realapril) / 1000);

            rkap_chart.push(parseInt(targetmei / 1000));
            real_chart.push(parseInt(realmei) / 1000);

            rkap_chart.push(parseInt(targetjuni / 1000));
            real_chart.push(parseInt(realjuni) / 1000);

            rkap_chart.push(parseInt(targetjuli) / 1000);
            real_chart.push(parseInt(realjuli) / 1000);

            rkap_chart.push(parseInt(targetagustus) / 1000);
            real_chart.push(parseInt(realagustus) / 1000);

            rkap_chart.push(parseInt(targetseptember) / 1000);
            real_chart.push(parseInt(realseptember) / 1000);


            $('#container').highcharts({
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                chart: {
                    backgroundColor: 'rgba(0, 255, 0, 0)',
                    polar: true
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
                yAxis:{
                    title: ''
                },
                series: [{
                        type: 'line',
                        name: 'RKAP Value',
                        color: '#FF615D',
                        data: rkap_chart,
                    }, {
                        type: 'column',
                        name: 'Real Value',
                        color: '#4c9ed9',
                        data: real_chart,
                    }]


            });

            var labelArrays = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];

            var ctx3 = document.getElementById("prodOpco");
            var data3 = {
                labels: labelArrays,
                datasets: [
                    {
                        label: "RKAP",
                        backgroundColor: '#f44336',
                        data: rkap_chart,
                    },
                    {
                        label: "Realisasi",
                        backgroundColor: '#56aec2',
                        data: real_chart,
                    }

                ]
            };
            var myBarChart = new Chart(ctx3, {
                type: 'bar',
                data: data3,
                options: {
                    legend: {
                        display: false,
                    },
                    maintainAspectRatio: true,
                    scales: {
                        yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    size: 5,
                                    labelString: 'Dalam Ribuan'
                                }
                            }]
                    }
                }
            });

        }
    }).done(function (data) {
    }).fail(function () {

    });

});