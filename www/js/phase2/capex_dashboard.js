// var api_url = 'http://10.15.5.150/dev/par4digma';
var api_url = 'http://par4digma.semenindonesia.com';
var currentTime = new Date();

$(document).ready(function () {
    console.log('Ready Func');

    loadData(currentTime.getFullYear());

    $('#year').change(function () {
        console.log($(this).val());
        loadData($(this).val());
    });
});

function loadData(year) {
    $.ajax({
        url: api_url + '/api/index.php/capex/getDataDashboard/' + year,
        type: 'GET',
        dataType: 'JSON',
    }).done(function (data) {
        console.log(data);
        [].forEach.call(document.querySelectorAll('.card_data'), function (xy) {
            xy.setAttribute('hidden', true);
        });
        for (x = 0; x < data.length; x++) {
            document.getElementById('card_data' + data[x].company).removeAttribute('hidden');
            document.getElementById('chart_title' + data[x].company).innerHTML = '&nbsp;&nbsp;&nbsp;' + data[x].company_name;
            str_bud = 0;
            pko_bud = 0;
            po_bud = 0;
            ko_bud = 0;
            m_bud = 0;
            str_act = 0;
            pko_act = 0;
            po_act = 0;
            ko_act = 0;
            m_act = 0;
            if (data[x].data.length > 0){
                for (y = 0; y < data[x].data.length; y++) {
                    if (data[x].data[y].PRIORITY == 1){
                        str_bud = (data[x].data[y].COST_BUD) / 1000000;
                        str_act = (data[x].data[y].COST_ACT) / 1000000;
                    } else if (data[x].data[y].PRIORITY == 2){
                        po_bud = (data[x].data[y].COST_BUD) / 1000000;
                        po_act = (data[x].data[y].COST_ACT) / 1000000;
                    } else if (data[x].data[y].PRIORITY == 3) {
                        pko_bud = (data[x].data[y].COST_BUD) / 1000000;
                        pko_act = (data[x].data[y].COST_ACT) / 1000000;
                    } else if (data[x].data[y].PRIORITY == 4) {
                        ko_bud = (data[x].data[y].COST_BUD) / 1000000;
                        ko_act = (data[x].data[y].COST_ACT) / 1000000;
                    } else if (data[x].data[y].PRIORITY == 5) {
                        m_bud = (data[x].data[y].COST_BUD) / 1000000;
                        m_act = (data[x].data[y].COST_ACT) / 1000000;
                    }
                }
            }
            workingOnChart(data[x].company, str_bud, str_act, pko_bud, pko_act, po_bud, po_act, ko_bud, ko_act, m_bud, m_act);
        }
    });
}

function workingOnChart(company, str_bud, str_act, pko_bud, pko_act, po_bud, po_act, ko_bud, ko_act, m_bud, m_act) {
    chartID1 = 'graph_budget' + company;
    chartID2 = 'graph_actual' + company;
    Highcharts.chart(chartID1, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
            marginTop:10
        },
        title: {
            text: 'Budget',
            margin: 10
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                size: 100,
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'CAPEX',
            colorByPoint: true,
            data: [{
                name: 'PKO',
                y: pko_bud,
                sliced: true,
                selected: true
            }, {
                name: 'PO',
                y: po_bud
            }, {
                name: 'M',
                y: m_bud
            }, {
                name: 'KO',
                y: ko_bud
            }, {
                name: 'STR',
                y: str_bud
            }]
        }]
    });

    Highcharts.chart(chartID2, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
            marginTop:10,
        },
        title: {
            text: 'Actual'
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                size: 100,
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'CAPEX',
            colorByPoint: true,
            data: [{
                name: 'PKO',
                y: pko_act,
                sliced: true,
                selected: true
            }, {
                name: 'PO',
                y: po_act
            }, {
                name: 'M',
                y: m_act
            }, {
                name: 'KO',
                y: ko_act
            }, {
                name: 'STR',
                y: str_act
            }]
        }]
    });
}