var api_url = 'http://10.15.5.150/dev/par4digma';
// var api_url = 'http://par4digma.semenindonesia.com';
var currentTime = new Date();

$(document).ready(function () {
    console.log('Ready Func');
    loadDataTable();

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
});

function loadDataTable() {
    var semuaOpco = ['3000', '4000', '5000', '7000'];
    semuaOpco.forEach(getTableDashboard);
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
    $.ajax({
        url: api_url + '/api/index.php/capex/getTableDashboard/' + opco,
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

function mioFormatting(valueNumb) {
    if (parseInt(valueNumb) != 0) {
        txt = (valueNumb / 1000000).toFixed(2);
    } else {
        txt = '0';
    }
    return txt;
}