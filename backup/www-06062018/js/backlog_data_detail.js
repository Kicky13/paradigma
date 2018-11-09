$(function () {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var opco = vars[1];
    var total_processed_bymonth = [];
    var total_backlog_percentage_bymonth = [];
    var total_backlog_bymonth = [];
    var cp = ['2000', '3000', '4000', '5000', '6000', '7000'];
    $.ajax({
        url: url_src+'/json/GenerateJsonMaintenance.php',
        //url: 'http://localhost/mobile_pis/document.json',
        type: 'GET',
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            //obj = data;
            if (opco == 'padang') {
                var data_src = obj['3000'];
                $('#logo_cp').attr('src', 'img/icKota2.png');
            } else if (opco == 'tonasa') {
                var data_src = obj['4000'];
                $('#logo_cp').attr('src', 'img/icKota3.png');
            } else if (opco == 'tlcc') {
                var data_src = obj['6000'];
                $('#logo_cp').attr('src', 'img/icKota4.png');
            } else if (opco == 'gresik') {
                var data_src1 = obj['2000'];
                var data_src2 = obj['5000'];
                var data_src3 = obj['7000'];
                $('#logo_cp').attr('src', 'img/icKota1.png');
            }
            var total = 0;
            var total_osno = 0;
            var total_nopr = 0;
            var total_noco = 0;
            var total_dlfl = 0;
            var d = new Date();
            var n = d.getFullYear();

            if (opco == 'padang' || opco == 'tonasa' || opco == 'tlcc') {
                var total_all = 0;
                var total_osp = 0;
                $.each(data_src, function (key, val) {
                    total_all += Number(val.OSNO) + Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS) + Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS) + Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                    total_osp += Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS) + Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS) + Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                    total_osno += Number(val.OSNO);
                    total_nopr += Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS);
                    total_noco += Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS);
                    total_dlfl += Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                })
                // Total Backlog
                total = Number(((total_osp) / (total_all)) * 100);
                if (Number(100 - Number(total)) <= 15) {
                    $('#total_backlog').html('<span style="color:#45DD90">' + setFormat(Number(100 - Number(total)),2) + '%</span>');
                } else {
                    $('#total_backlog').html('<span style="color:#FF615D">' + setFormat(Number(100 - Number(total)),2) + '%</span>');
                }
                // Backlog per Bulan
                var s = '';
                for (var b = 1; b < 13; b++) {
                    if (b < 10) {
                        var s = '0' + b;
                    } else {
                        var s = b;
                    }
                    total_permonth(n + '-' + s);
                }
            } else if (opco == 'gresik') {
                var total_all = 0;
                var total_osp = 0;
                $.each(data_src1, function (key, val) {
                    total_all += Number(val.OSNO) + Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS) + Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS) + Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                    total_osp += Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS) + Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS) + Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                    total_osno += Number(val.OSNO);
                    total_nopr += Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS);
                    total_noco += Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS);
                    total_dlfl += Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                })
                $.each(data_src2, function (key, val) {
                    total_all += Number(val.OSNO) + Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS) + Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS) + Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                    total_osp += Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS) + Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS) + Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                    total_osno += Number(val.OSNO);
                    total_nopr += Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS);
                    total_noco += Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS);
                    total_dlfl += Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                })
                $.each(data_src3, function (key, val) {
                    total_all += Number(val.OSNO) + Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS) + Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS) + Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                    total_osp += Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS) + Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS) + Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                    total_osno += Number(val.OSNO);
                    total_nopr += Number(val.NOPR) + Number(val.NOPR_NOPT) + Number(val.NOPR_NOPT_ORAS) + Number(val.NOPR_ORAS);
                    total_noco += Number(val.NOCO) + Number(val.NOCO_NOPR) + Number(val.NOCO_NOPT_ORAS) + Number(val.NOCO_ORAS);
                    total_dlfl += Number(val.DLFL_NOCO) + Number(val.DLFL_NOCO_ORAS);
                })
                total = Number(((total_osp) / (total_all)) * 100).toFixed(2);
                if (Number(100 - Number(total)).toFixed(2) <= 15) {
                    $('#total_backlog').html('<span style="color:#45DD90">' + setFormat(Number(100 - Number(total)),2) + '%</span>');
                } else {
                    $('#total_backlog').html('<span style="color:#FF615D">' + setFormat(Number(100 - Number(total)),2) + '%</span>');
                }
                // Backlog per Bulan
                var s = '';
                for (var b = 1; b < 13; b++) {
                    if (b < 10) {
                        var s = '0' + b;
                    } else {
                        var s = b;
                    }
                    total_permonth(n + '-' + s);
                }
            }
            createChart('backlog-chart', total_processed_bymonth, total_backlog_percentage_bymonth, total_backlog_bymonth);
            $('#osno').html(setFormat(total_osno,0));
            $('#nopr').html(setFormat(total_nopr,0));
            $('#noco').html(setFormat(total_noco,0));
            $('#dlfl').html(setFormat(total_dlfl,0));
            function total_permonth(periode) {
                var total_backlog_perbulan = 0;
                var total_all_perbulan = 0;
                var total_osp_perbulan = 0;
                if (opco == 'padang') {
                    var data_src = '3000';
                } else if (opco == 'tonasa') {
                    var data_src = '4000';
                } else if (opco == 'tlcc') {
                    var data_src = '6000';
                } else if (opco == 'gresik') {
                    var data_src1 = '2000';
                    var data_src2 = '5000';
                    var data_src3 = '7000';
                }
                if (opco == 'padang' || opco == 'tonasa' || opco == 'tlcc') {
                    if (obj[data_src][periode] != undefined) {
                        $.each(obj[data_src][periode], function (key, val) {
                            if (key == 'OSNO' || key == 'NOPR' || key == 'NOPR_NOPT' || key == 'NOPR_NOPT_ORAS' || key == 'NOPR_ORAS' || key == 'NOCO' || key == 'NOCO_NOPR' || key == 'NOCO_NOPT_ORAS' || key == 'NOCO_ORAS' || key == 'DLFL_NOCO' || key == 'DLFL_NOCO_ORAS') {
                                total_all_perbulan += Number(val);
                            }
                            if (key == 'NOPR' || key == 'NOPR_NOPT' || key == 'NOPR_NOPT_ORAS' || key == 'NOPR_ORAS' || key == 'NOCO' || key == 'NOCO_NOPR' || key == 'NOCO_NOPT_ORAS' || key == 'NOCO_ORAS' || key == 'DLFL_NOCO' || key == 'DLFL_NOCO_ORAS') {
                                total_osp_perbulan += Number(val);
                            }
                        })
                        if (total_all_perbulan > 0){
                         total_backlog_perbulan = (100 - (Number((total_osp_perbulan / total_all_perbulan)) * 100)).toFixed(2);
                        }else{
                         total_backlog_perbulan = 0;                    
                        }

                    } else {
                        total_backlog_perbulan = 0;
                    }
                } else if (opco == 'gresik') {
                    if (obj[data_src1][periode] == undefined) {
                        obj[data_src1][periode] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    }
                    if (obj[data_src2][periode] == undefined) {
                        obj[data_src2][periode] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    }
                    if (obj[data_src3][periode] == undefined) {
                        obj[data_src3][periode] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    }
                    $.each(obj[data_src1][periode], function (key, val) {
                        if (key == 'OSNO' || key == 'NOPR' || key == 'NOPR_NOPT' || key == 'NOPR_NOPT_ORAS' || key == 'NOPR_ORAS' || key == 'NOCO' || key == 'NOCO_NOPR' || key == 'NOCO_NOPT_ORAS' || key == 'NOCO_ORAS' || key == 'DLFL_NOCO' || key == 'DLFL_NOCO_ORAS') {
                            total_all_perbulan += Number(val);
                        }
                        if (key == 'NOPR' || key == 'NOPR_NOPT' || key == 'NOPR_NOPT_ORAS' || key == 'NOPR_ORAS' || key == 'NOCO' || key == 'NOCO_NOPR' || key == 'NOCO_NOPT_ORAS' || key == 'NOCO_ORAS' || key == 'DLFL_NOCO' || key == 'DLFL_NOCO_ORAS') {
                            total_osp_perbulan += Number(val);
                        }
                    })
                    $.each(obj[data_src2][periode], function (key, val) {
                        if (key == 'OSNO' || key == 'NOPR' || key == 'NOPR_NOPT' || key == 'NOPR_NOPT_ORAS' || key == 'NOPR_ORAS' || key == 'NOCO' || key == 'NOCO_NOPR' || key == 'NOCO_NOPT_ORAS' || key == 'NOCO_ORAS' || key == 'DLFL_NOCO' || key == 'DLFL_NOCO_ORAS') {
                            total_all_perbulan += Number(val);
                        }
                        if (key == 'NOPR' || key == 'NOPR_NOPT' || key == 'NOPR_NOPT_ORAS' || key == 'NOPR_ORAS' || key == 'NOCO' || key == 'NOCO_NOPR' || key == 'NOCO_NOPT_ORAS' || key == 'NOCO_ORAS' || key == 'DLFL_NOCO' || key == 'DLFL_NOCO_ORAS') {
                            total_osp_perbulan += Number(val);
                        }
                    })
                    $.each(obj[data_src3][periode], function (key, val) {
                        if (key == 'OSNO' || key == 'NOPR' || key == 'NOPR_NOPT' || key == 'NOPR_NOPT_ORAS' || key == 'NOPR_ORAS' || key == 'NOCO' || key == 'NOCO_NOPR' || key == 'NOCO_NOPT_ORAS' || key == 'NOCO_ORAS' || key == 'DLFL_NOCO' || key == 'DLFL_NOCO_ORAS') {
                            total_all_perbulan += Number(val);
                        }
                        if (key == 'NOPR' || key == 'NOPR_NOPT' || key == 'NOPR_NOPT_ORAS' || key == 'NOPR_ORAS' || key == 'NOCO' || key == 'NOCO_NOPR' || key == 'NOCO_NOPT_ORAS' || key == 'NOCO_ORAS' || key == 'DLFL_NOCO' || key == 'DLFL_NOCO_ORAS') {
                            total_osp_perbulan += Number(val);
                        }
                    })
                    if (total_all_perbulan > 0){
                     total_backlog_perbulan = (100 - (Number((total_osp_perbulan / total_all_perbulan)) * 100)).toFixed(2);
                    }else{
                     total_backlog_perbulan = 0;                    
                    }
                }

                total_processed_bymonth.push(total_all_perbulan - (total_all_perbulan - total_osp_perbulan));
                total_backlog_percentage_bymonth.push(Number(total_backlog_perbulan));
                total_backlog_bymonth.push(total_all_perbulan - total_osp_perbulan);
            }
            function createChart(id_chart, total_processed_bymonth, total_backlog_percentage_bymonth, total_backlog_bymonth) {
                console.log(total_processed_bymonth);
                console.log(total_backlog_percentage_bymonth);
                console.log(total_backlog_bymonth);
                $('#' + id_chart).highcharts({
                    credits: {
                        enabled: false
                    },
                    chart: {
                        backgroundColor: 'rgba(0, 255, 0, 0)',
                        type: 'bar'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Des']
                    },
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                        tickInterval: 1000,
                        title: {
                            text: ''
                        },
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontSize: '9px',
                                color: '#3498db'
                            },
                            formatter: function () {
                                var p = total_backlog_percentage_bymonth[this.x];
                                var v = total_backlog_bymonth[this.x];
                                if (v > 0) {
                                    if (p == 0) {
                                        return p.toFixed(0) + '%';
                                    } else {
                                        return p.toFixed(2) + '%';
                                    }
                                } else {
                                    return '';
                                }
                            }
                        }
                    },
                    legend: {
                        reversed: true
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Total Notification : ' + this.point.stackTotal;
                        }
                    },
                    plotOptions: {
                        series: {
                            events: {
                                legendItemClick: function () {
                                    var series_name = this.name;
                                    var series_visible = this.visible;
                                    var chart = $('#' + id_chart).highcharts();
                                    var yAxis = chart.yAxis[0];
                                    yAxis.update({
                                        stackLabels: {
                                            enabled: true,
                                            style: {
                                                fontSize: '9px',
                                                color: '#3498db'
                                            },
                                            formatter: function () {
                                                if (series_name == 'Backlog') {
                                                    if (series_visible == false) {
                                                        var p = total_backlog_percentage_bymonth[this.x];
                                                        var v = total_backlog_bymonth[this.x];
                                                        if (v > 0) {
                                                            if (p == 0) {
                                                                return '';
                                                            } else {
                                                                return p.toFixed(2) + '%';
                                                            }
                                                        } else {
                                                            return '';
                                                        }
                                                    } else {
                                                        var p = 100 - total_backlog_percentage_bymonth[this.x];
                                                        var v = total_backlog_bymonth[this.x];
                                                        if (v > 0) {
                                                            if (p == 0) {
                                                                return '';
                                                            } else {
                                                                return p.toFixed(2) + '%';
                                                            }
                                                        } else {
                                                            return '';
                                                        }
                                                    }
                                                } else {
                                                    var p = total_backlog_percentage_bymonth[this.x];
                                                    var v = total_backlog_bymonth[this.x];
                                                    if (v > 0) {
                                                        if (p == 0) {
                                                            return '';
                                                        } else {
                                                            return p.toFixed(2) + '%';
                                                        }
                                                    } else {
                                                        return '';
                                                    }
                                                }

                                            }
                                        }
                                    });

                                }
                            },
                            stacking: 'normal'
                        }
                    },
                    series: [{
                            name: 'Backlog',
                            data: total_backlog_bymonth,
                            pointWidth: 22,
                            color: '#FF615D',
                            states: {
                                hover: {
                                    enabled: false
                                }
                            }
                        }, {
                            name: 'Processed',
                            data: total_processed_bymonth,
                            pointWidth: 22,
                            color: '#45DD90',
                            states: {
                                hover: {
                                    enabled: false
                                }
                            }
                        }]
                });
            }
        }
    })
})