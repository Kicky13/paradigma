var api_url = 'http://10.15.5.150/dev/par4digma';
// var api_url = 'http://par4digma.semenindonesia.com';
var currentTime = new Date();

$(document).ready(function () {
    console.log('Ready Func');
    loadDataTable();
    loadDataChart();
    loadUpToMontth();

    $('a[href="#tab-opco"]').click(function (e) {
        e.preventDefault();
        var r = $(this).attr('rel');
        if (r == 'capex-table') {
            $('#capex-table').removeClass('hidden');
            $('#capex-chart').addClass('hidden');

            $('#tab-capex-table').addClass('act_tb');
            $('#tab-capex-chart').removeClass('act_tb');
        } else if (r == 'capex-chart') {
            $('#capex-chart').removeClass('hidden');
            $('#capex-table').addClass('hidden');

            $('#tab-capex-chart').addClass('act_tb');
            $('#tab-capex-table').removeClass('act_tb');
        }
    });
    $('.footer-logo').click(function () {
        changeOpco(this.getAttribute('data-opco'));
    });
    $('#typeOf').change(function () {
        console.log($(this).val());
    });
});

function loadDataTable() {
    var semuaOpco = ['3000', '4000', '5000', '7000'];
    semuaOpco.forEach(getTableDashboard);
}

function loadDataChart() {
    var semuaOpco = ['3000', '4000', '5000', '7000'];
    semuaOpco.forEach(getChartDashboard);
}

function loadUpToMontth() {
    var semuaOpco = ['3000', '4000', '5000', '7000'];
    semuaOpco.forEach(getChartSMIGUpToMonth);
}

function test(opco) {
    console.log('Test ' + opco);
}

function changeOpco(codeOpco) {
    console.log(codeOpco);
    if (codeOpco == "2000"){
        [].forEach.call(document.querySelectorAll('.content-divider'), function (bt) {
            bt.setAttribute('hidden', true);
        });
        document.getElementById('cont-div1').removeAttribute('hidden');
    } else {
        [].forEach.call(document.querySelectorAll('.content-divider'), function (bt) {
            bt.setAttribute('hidden', true);
        });
        document.getElementById('cont-div2').removeAttribute('hidden');
        [].forEach.call(document.querySelectorAll('.table-opco'), function (az) {
            az.setAttribute('hidden', true);
        });
        document.getElementById('table-' + codeOpco).removeAttribute('hidden');
        [].forEach.call(document.querySelectorAll('.chart-opco'), function (cv) {
            cv.setAttribute('hidden', true);
        });
        document.getElementById('chart-' + codeOpco).removeAttribute('hidden');
    }
    [].forEach.call(document.querySelectorAll('.footer-logo'), function (ab) {
        ab.classList.add("img_foot2");
    });
    document.getElementById('logo-' + codeOpco).classList.remove("img_foot2");
    changeTitle(codeOpco);
}

function changeTitle(opco) {
    if(opco == "3000") {
        ttl = "SEMEN PADANG";
    } else if(opco == "7000") {
        ttl = "SEMEN INDONESIA";
    } else if(opco == "5000") {
        ttl = "SEMEN GRESIK";
    } else if(opco == "4000") {
        ttl = "SEMEN TONASA";
    } else if(opco == "6000") {
        ttl = "THANG LONG";
    } else {
        ttl = "";
    }
    $(".planttittle").html(ttl);
}

function getTableDashboard(opco) {
    console.log('Loading Get Data ' + opco);
    invType = $('#typeOf').val();
    $.ajax({
        url: api_url + '/api/index.php/capex/getTableDashboard/' + opco + '/' + invType,
        type: 'GET',
        dataType: 'JSON',
    }).done(function (data) {
        console.log(mioFormatting(data[0].BUDGET));
        if (data.length > 0) {
            txt = '';
            for (x = 0; x < data.length; x++) {
                txt += '<a href="#">';
                txt += '<div class="col-xs-12 bagan" style="padding: 5px">';
                txt += '<div class="col-xs-12 box" style="margin-top: 12px">';
                txt += '<div class="col-xs-12 noPadding titl" style="padding-top: 10px;">';
                txt += '<span class="undertx" style="font-size: 16px;">' + data[x].WBS + ' ' + data[x].DESCRIPTION + '</span>';
                txt += '<a href="#"><i class="fa fa-chevron-down right grp_ico" aria-hidden="true"></i></a>';
                txt += '</div>';
                txt += '<div style="margin-bottom:0px;">';
                txt += '<div style="width: 100%; margin: 0 auto; padding: 2%;">';
                txt += '<table class="table" style="margin-bottom: 0px; padding-bottom: 100px; margin-top: 20px">';
                txt += '<thead>';
                txt += '<tr>';
                txt += '<th valign="middle" align="center" data-sort="string" class="ctr_th"><strong>Budget</strong></th>';
                txt += '<th valign="middle" align="center" data-sort="string" class="ctr_th"><strong>Planning</strong></th>';
                txt += '<th valign="middle" align="center" data-sort="string" class="ctr_th"><strong>GR</strong></th>';
                txt += '<th valign="middle" align="center" data-sort="string" class="ctr_th"><strong>Invoice</strong></th>';
                txt += '<th valign="middle" align="center" data-sort="string" class="ctr_th"><strong>Cash Out</strong></th>';
                txt += '</tr>';
                txt += '</thead>';
                txt += '<tbody>';
                txt += '<tr rel="asset">';
                txt += '<td valign="middle" align="center" class="val_capex">' + mioFormatting(data[x].BUDGET) + '</td>';
                txt += '<td valign="middle" align="center" class="val_capex">' + mioFormatting(data[x].PLANNING) + '</td>';
                txt += '<td valign="middle" align="center" class="val_capex">' + mioFormatting(data[x].GR) + '</td>';
                txt += '<td valign="middle" align="center" class="val_capex">' + mioFormatting(data[x].INVOICE) + '</td>';
                txt += '<td valign="middle" align="center" class="val_capex">' + mioFormatting(data[x].CASHOUT) + '</td>';
                txt += '</tr>';
                txt += '</tbody>';
                txt += '</table>';
                txt += '</div>';
                txt += '</div>';
                txt += '</div>';
                txt += '</div>';
                txt += '</a>';
            }
            document.getElementById('table-' + opco).innerHTML = txt;
        }
    });
}

function getChartDashboard(opco)
{
    console.log('Loading Get Chart ' + opco);
    invType = $('#typeOf').val();
    $.ajax({
        url: api_url + '/api/index.php/capex/getChartDashboard/' + opco + '/' + invType,
        type: 'GET',
        dataType: 'JSON',
    }).done(function (data) {
        console.log(typeof data.PR);
        txt = '';
        txt += '<div style="width:100%;overflow-x:scroll;">';
        txt += '<div class="chart-val" id="val-"' + opco + ' style="width:100%;height:250px;"></div>';
        txt += '</div>';
        document.getElementById('chart-' + opco).innerHTML = txt;

        Highcharts.chart('chart-' + opco, {
            title: {
                text: ''
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                type: 'column',
                name: 'PR',
                color: '#7CB5EC',
                data: [parseFloat(data.PR)]
            }, {
                type: 'column',
                name: 'PO',
                color: '#5C5C61',
                data: [parseFloat(data.PO)]
            }, {
                type: 'column',
                name: 'GR',
                color: '#4FFF62',
                data: [parseFloat(data.GR)],
            }, {
                type: 'column',
                name: 'Invoice',
                color: '#FF5554',
                data: [parseFloat(data.INVOICE)],
            }, {
                type: 'column',
                name: 'Cash Out',
                color: '#263161',
                data: [parseFloat(data.CASHOUT)],
            }]
        });
    });
}



function getChartSMIGUpToMonth(opco)
{
    $.ajax({
        url: api_url + '/api/index.php/capex/getChartUpToMonth/' + opco,
        type: 'GET',
        dataType: 'JSON'
    }).done(function (data) {
        utreal = 0;
        utrencana = 0;
        var bulan = [];
        var rencana = [];
        var real = [];
        var uptoreal = [];
        var uptorencana = [];
        for (var i = 0; i < data.length; i++) {
            bulan.push(data[i].DATE);
            rencana.push(data[i].PLANNING);
            real.push(data[i].GR);
            utreal += parseFloat(data[i].GR);
            utrencana += parseFloat(data[i].PLANNING);
            uptoreal.push(utreal);
            uptorencana.push(utrencana);
        }
        console.log(bulan);
        console.log(rencana);
        console.log(real);
        console.log(uptoreal);
        console.log(uptorencana);
        Highcharts.chart('chart-capex-' + opco, {
            title: {
                text: ''
            },
            xAxis: {
                categories: bulan,
                crosshair: true
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                type: 'column',
                name: 'Rencana',
                color: '#FF3636',
                data: rencana,
            }, {
                type: 'column',
                name: 'Real',
                color: '#ABAAAA',
                data: real,
            }, {
                type: 'spline',
                name: 'Upt To Rencana',
                color: '#FF3636',
                data: uptorencana,
                marker: {
                    lineWidth: 4,
                    lineColor: '#FF3636',
                    fillColor: 'white'
                }
            }, {
                type: 'spline',
                name: 'Up To Real',
                color: '#ABAAAA',
                data: uptoreal,
                marker: {
                    lineWidth: 4,
                    lineColor: '#ABAAAA',
                    fillColor: 'white'
                }
            }]
        });
    });
}

function mioFormatting(valueNumb) {
    if (parseInt(valueNumb) != 0) {
        txt = (valueNumb / 1000000).toFixed(2);
    } else {
        txt = '0';
    }
    return txt;
}