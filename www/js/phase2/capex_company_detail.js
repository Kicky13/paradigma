var temp_url = 'http://10.15.5.150/dev/par4digma';
var api_url = 'http://par4digma.semenindonesia.com';
var currentTime = new Date();
var activeCompany;

$(document).ready(function () {
    console.log('Masuk');

    var url_address = window.location.href;
    var url = new URL(url_address);
    activeCompany = url.searchParams.get("company");
    setParam(activeCompany);

    getActiveCompany();

    loadData(currentTime.getFullYear());

    $('.footerLogo').click(function () {
        console.log(this.getAttribute('data-company'));
        changeCompanyDisplay(this.getAttribute('data-company'));
        setParam(this.getAttribute('data-company'));
    });

    $('#year').change(function () {
        console.log($(this).val());
        loadData($(this).val());
    });
});

function getActiveCompany() {
    console.log(activeCompany);
    initiateView();
}

function changeCompanyDisplay(company) {
    elementID = 'comp' + company;
    elementID2 = 'datacomp' + company;
    elementID3 = 'graph' + company;
    [].forEach.call(document.querySelectorAll('.footerLogo'), function (ab) {
        ab.classList.add("img_foot2");
    });
    document.getElementById(elementID).classList.remove("img_foot2");
    [].forEach.call(document.querySelectorAll('.datacomp'), function (ac) {
        ac.setAttribute('hidden', true);
    });
    document.getElementById(elementID2).removeAttribute('hidden');
    [].forEach.call(document.querySelectorAll('.grafik'), function (ad) {
        ad.setAttribute('hidden', true);
    });
    document.getElementById(elementID3).removeAttribute('hidden');
}

function loadData(year) {
    $.ajax({
        url: api_url + '/api/index.php/capex/getReportCAPEXPerCompany',
        type: 'POST',
        dataType: 'JSON',
        data: {
            year: year
        }
    }).done(function (data) {
        console.log(data);
        for (x = 0; x < data.length; x++) {
            an = '';
            str_bud = 0;
            str_act = 0;
            po_bud = 0;
            po_act = 0;
            pko_bud = 0;
            pko_act = 0;
            ko_bud = 0;
            ko_act = 0;
            man_bud = 0;
            man_act = 0;
            if (data[x].data.length > 0) {
                for (y = 0; y < data[x].data.length; y++){
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
                        man_bud = (data[x].data[y].COST_BUD) / 1000000;
                        man_act = (data[x].data[y].COST_ACT) / 1000000;
                    }
                    an += '<a href="javascript:nextPage(\'' + data[x].data[y].COMPANY + '\', \'' + data[x].data[y].PRIORITY + '\')" data-company="" data-priority="" data-year="">';
                    an += '<div class="col-xs-12 bagan" style="padding: 5px">';
                    an += '<div class="col-xs-12 box" style="margin-top: 12px">';
                    an += '<div class="col-xs-12 noPadding titl" style="padding-top: 10px;">';
                    an += '<span class="undertx" style="font-size: 16px;">' + data[x].data[y].DESCRIPTION + '</span>';
                    an += '<a href="javascript:nextPage(\'' + data[x].data[y].COMPANY + '\', \'' + data[x].data[y].PRIORITY + '\')" data-company="" data-priority="" data-year=""><i class="fa fa-chevron-right right grp_ico" aria-hidden="true"></i></a>';
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
                    an += '<tr rel="asset">';
                    an += '<td valign="middle" align="center" class="val_capex">' + ((data[x].data[y].COST_BUD) / 1000000).toFixed(1) + '</td>';
                    an += '<td valign="middle" align="center" class="val_capex">' + ((data[x].data[y].COST_ACT) / 1000000).toFixed(1) + '</td>';
                    an += '<td valign="middle" align="center" class="val_capex">' + ((data[x].data[y].COST_COMIT) / 1000000).toFixed(1) + '</td>';
                    an += '<td valign="middle" align="center" class="val_capex">' + ((data[x].data[y].COST_CO) / 1000000).toFixed(1) + '</td>';
                    an += '<td valign="middle" align="center" class="val_capex">' + ((data[x].data[y].COST_AVB) / 1000000).toFixed(1) + '</td>';
                    an += '</tr>';
                    an += '</tbody>';
                    an += '</table>';
                    an += '</div>';
                    an += '</div>';
                    an += '</div>';
                    an += '</div>';
                    an += '</a>';
                }
            }
            document.getElementById("datacomp" + data[x].company).innerHTML = an;
            Highcharts.chart('graph'+data[x].company, {
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
                        'STR',
                        'PO',
                        'PKO',
                        'KO',
                        'MAN'
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
                    data: [str_bud, po_bud, pko_bud, ko_bud, man_bud]

                }, {
                    name: 'Actual',
                    data: [str_act, po_act, pko_act, ko_act, man_act]

                }]
            });
        }
    });
}

function nominalFormatter(numValue) {
    if (numValue.toString().length > 6 && numValue.toString().length < 9){
        x = (parseInt(numValue) / 1000000).toFixed(2);
        valueReturn = x.toString() + 'M';
    } else {
        x = (parseInt(numValue) / 1000000000).toFixed(2);
        valueReturn = x.toString() + 'B';
    }
    return valueReturn;
}

function initiateView() {
    elementID = 'comp' + activeCompany;
    elementID1 = 'datacomp' + activeCompany;
    elementID2 = 'graph' + activeCompany;
    [].forEach.call(document.querySelectorAll('.footerLogo'), function (ab) {
        ab.classList.add("img_foot2");
    });
    document.getElementById(elementID).classList.remove("img_foot2");
    [].forEach.call(document.querySelectorAll('.datacomp'), function (ac) {
        ac.setAttribute('hidden', true);
    });
    document.getElementById(elementID1).removeAttribute('hidden');
    [].forEach.call(document.querySelectorAll('.grafik'), function (ad) {
        ad.setAttribute('hidden', true);
    });
    document.getElementById(elementID2).removeAttribute('hidden');
}

function nextPage(company, priority) {
    years = $('#year').val();
    url = 'project_report_proj_detail.html?company=' + company + '&priority=' + priority + '&year=' + years;
    console.log(url);
    window.location = url;
}

function setParam(company){
    var ttl;

    if(company=="3000"){
        ttl="SEMEN PADANG";
    }else if(company=="7000"){
        ttl="SEMEN INDONESIA";
    }else if(company=="5000"){
        ttl="SEMEN GRESIK";
    }else if(company=="4000"){
        ttl="SEMEN TONASA";
    }else{
        ttl="";
    }
    $(".planttittle").html(ttl);
}