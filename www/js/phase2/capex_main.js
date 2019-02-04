// var api_url = 'http://10.15.5.150/dev/par4digma';
var api_url = 'http://par4digma.semenindonesia.com';
var currentTime = new Date();

$(document).ready(function () {
    console.log('CAPEX Ongoing find Data');

    $(".regular").slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 6,
        arrows:false,
        centerMode: false
    });

    loadData(currentTime.getFullYear());

    $('#year').change(function () {
        console.log($(this).val());
        loadData($(this).val());
    });
});

function loadData(year) {
    $.ajax({
        url: api_url + '/api/index.php/capex/getCAPEXSMIG',
        type: 'POST',
        dataType: 'JSON',
        data: {
            year: year
        }
    }).done(function (data) {
        as = '';
        bud1 = 0; bud2 = 0; bud3 = 0; bud4 = 0; bud5 = 0;
        act1 = 0; act2 = 0; act3 = 0; act4 = 0; act5 = 0;
        if (data.length == 0){
            Highcharts.chart('compare_graph', {
                chart: {
                    height: 250,
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: [
                        'SMI',
                        'SP',
                        'ST',
                        'SG',
                        'SI'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Budget',
                    data: [0, 0, 0, 0, 0]
                }, {
                    name: 'Actual',
                    data: [0, 0, 0, 0, 0]
                }]
            });
        } else {
            for (i = 0; i < data.length; i++){
                if (data[i].company == '2000') {
                    bud1 = parseInt(data[i].data.COST_BUD) / 1000000;
                    act1 = parseInt(data[i].data.COST_ACT) / 1000000;
                } else if (data[i].company == '3000') {
                    bud2 = parseInt(data[i].data.COST_BUD) / 1000000;
                    act2 = parseInt(data[i].data.COST_ACT) / 1000000;
                } else if (data[i].company == '4000') {
                    bud3 = parseInt(data[i].data.COST_BUD) / 1000000;
                    act3 = parseInt(data[i].data.COST_ACT) / 1000000;
                } else if (data[i].company == '5000') {
                    bud4 = parseInt(data[i].data.COST_BUD) / 1000000;
                    act4 = parseInt(data[i].data.COST_ACT) / 1000000;
                } else if (data[i].company == '7000') {
                    bud5 = parseInt(data[i].data.COST_BUD) / 1000000;
                    act5 = parseInt(data[i].data.COST_ACT) / 1000000;
                }
                as += '<a href="javascript:CAPEXperCompany(\'' + data[i].company + '\')">';
                as += '<div class="col-xs-12 bagan" style="padding: 4px">';
                as += '<div class="col-xs-12 box" id="report_proj" style="margin-top: 12px">';
                as += '<div class="col-xs-12 noPadding titl" style="padding-top: 10px;">';
                as += '<span class="undertx" id="headcol_sg" style="font-size: 16px;">' + data[i].company_name + '</span>';
                as += '<a href="javascript:CAPEXperCompany(\'' + data[i].company + '\')"><i class="fa fa-chevron-right right grp_ico routePage" aria-hidden="true"></i></a>';
                as += '</div>';
                as += '<div style="margin-bottom:0px;">';
                as += '<div id="container" style="width: 100%; margin: 0 auto; padding: 2%;">';
                as += '<table class="table" style="margin-bottom: 0px; padding-bottom: 100px; margin-top: 20px">';
                as += '<thead>';
                as += '<tr>';
                as += '<th valign="middle" data-sort="string" class="ctr_th"><strong>Budget</strong></th>';
                as += '<th valign="middle" data-sort="string" class="ctr_th"><strong>Actual</strong></th>';
                as += '<th valign="middle" data-sort="string" class="ctr_th"><strong>Commitment</strong></th>';
                as += '<th valign="middle" data-sort="string" class="ctr_th"><strong>Cash Out</strong></th>';
                as += '<th valign="middle" data-sort="string" class="ctr_th"><strong>Available</strong></th>';
                as += '</tr>';
                as += '</thead>';
                as += '<tbody>';
                as += '<tr rel="asset" class="f19">';
                as += '<td valign="middle" align="center" class="val_capex or_budget">' + nominalFormatter(data[i].data.COST_BUD) + '</td>';
                as += '<td valign="middle" align="center" class="val_capex rel_budget">' + nominalFormatter(data[i].data.COST_ACT) + '</td>';
                as += '<td valign="middle" align="center" class="val_capex avlble">' + nominalFormatter(data[i].data.COST_COMIT) + '</td>';
                as += '<td valign="middle" align="center" class="val_capex commit">' + nominalFormatter(data[i].data.COST_CO) + '</td>';
                as += '<td valign="middle" align="center" class="val_capex act">' + nominalFormatter(data[i].data.COST_AVB) + '</td>';
                as += '</tr>';
                as += '</tbody>';
                as += '</table>';
                as += '</div>';
                as += '</div>';
                as += '</div>';
                as += '</div>';
                as += '</a>';
            }
        }
        document.getElementById('dataContent').innerHTML = as;
        data1 =
            Highcharts.chart('compare_graph', {
                chart: {
                    height: 250,
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: [
                        'SMI',
                        'SP',
                        'ST',
                        'SG',
                        'SI'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Budget',
                    data: [bud1, bud2, bud3, bud4, bud5]
                }, {
                    name: 'Actual',
                    data: [act1, act2, act3, act4, act5]
                }]
            });
    });
}

function CAPEXperCompany(company) {
    url = 'project_report_proj.html?company='+company;
    console.log(url);
    window.location = url;
}

function nominalFormatter(numValue) {
    if (numValue.length > 6 && numValue.length < 9){
        x = (parseInt(numValue) / 1000000).toFixed(2);
        valueReturn = x.toString() + 'M';
    } else {
        x = (parseInt(numValue) / 1000000000).toFixed(2);
        valueReturn = x.toString() + 'B';
    }
    return valueReturn;
}