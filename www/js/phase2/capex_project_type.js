var activeCompany, priority, years;
var temp_url = 'http://10.15.5.150/dev/par4digma';
var api_url = 'http://par4digma.semenindonesia.com';

$(document).ready(function () {
    console.log('Page Ready');

    var url_address = window.location.href;
    var url = new URL(url_address);
    activeCompany = url.searchParams.get("company");
    priority = url.searchParams.get("priority");
    years = url.searchParams.get("year");

    loadData()
});

function loadData() {
    console.log(activeCompany + ' ' + priority + ' ' + years);
    $.ajax({
        url: api_url + '/api/index.php/capex/getCurrentProject',
        type: 'POST',
        dataType: 'JSON',
        data: {
            company: activeCompany,
            priority: priority,
            year: years
        }
    }).done(function (data) {
        console.log(data);
        an = '';
        for (i = 0; i < data.length; i++){
            an += '<div class="col-xs-12 bagan" style="padding: 5px">';
            an += '<div class="col-xs-12 box" style="margin-top: 12px">';
            an += '<div class="col-xs-12 noPadding titl" style="padding-top: 10px;">';
            an += '<span class="undertx" style="font-size: 16px;">' + data[i].CURR_PROJECT + '</span>';
            an += '</div>';
            an += '<div style="margin-bottom:0px;">';
            an += '<div style="width: 100%; margin: 0 auto; padding: 2%;">';
            an += '<table class="table" style="margin-bottom: 0px; padding-bottom: 100px; margin-top: 20px">';
            an += '<thead>';
            an += '<tr>';
            an += '<th valign="middle" data-sort="string" class="ctr_th"><strong>Budget</strong></th>';
            an += '<th valign="middle" data-sort="string" class="ctr_th"><strong>Actual</strong></th>';
            an += '<th valign="middle" data-sort="string" class="ctr_th"><strong>Commitment</strong></th>';
            an += '<th valign="middle" data-sort="string" class="ctr_th"><strong>Cash Out</strong></th>';
            an += '<th valign="middle" data-sort="string" class="ctr_th"><strong>Avaible</strong></th>';
            an += '</tr>';
            an += '</thead>';
            an += '<tbody>';
            an += '<tr rel="asset" class="f19">';
            an += '<td valign="middle" align="center">' + ((data[i].COST_BUD) / 1000000).toFixed(1) + '</td>';
            an += '<td valign="middle" align="center">' + ((data[i].COST_ACT) / 1000000).toFixed(1) + '</td>';
            an += '<td valign="middle" align="center">' + ((data[i].COST_COMIT) / 1000000).toFixed(1) + '</td>';
            an += '<td valign="middle" align="center">' + ((data[i].COST_CO) / 1000000).toFixed(1) + '</td>';
            an += '<td valign="middle" align="center">' + ((data[i].COST_AVB) / 1000000).toFixed(1) + '</td>';
            an += '</tr>';
            an += '</tbody>';
            an += '</table>';
            an += '</div>';
            an += '</div>';
            an += '</div>';
            an += '</div>';
        }
        document.getElementById('data-report').innerHTML = an;
    });
}