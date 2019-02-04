// var api_url = 'http://10.15.5.150/dev/par4digma/api/index.php/';
var api_url = 'http://par4digma.semenindonesia.com/api/index.php/';
var currentTime = new Date();

$(document).ready(function () {
    console.log("Coba");
    loadData(currentTime.getMonth(), currentTime.getFullYear());
    initiateView();
    $('.footer-logo').click(function () {
        console.log(this.getAttribute('rel') + ' ' + this.getAttribute('data-status'));
        changeCompanyDisplay(this.getAttribute('rel'), this.getAttribute('data-status'));
    });
    $('a[href=".tab-click"]').click(function (e) {
        e.preventDefault();
        var r = $(this).attr('rel');
        if (r == 'pr') {
            $('.pr').removeClass('hidden');
            $('.prrel').addClass('hidden');
            $('.rfq').addClass('hidden');
            $('.po').addClass('hidden');
            $('.gr').addClass('hidden');
            $('.tab-pr').addClass('act_tb');
            $('.tab-prrel').removeClass('act_tb');
            $('.tab-rfq').removeClass('act_tb');
            $('.tab-po').removeClass('act_tb');
            $('.tab-gr').removeClass('act_tb');
        } else if (r == 'prrel') {
            $('.pr').addClass('hidden');
            $('.prrel').removeClass('hidden');
            $('.rfq').addClass('hidden');
            $('.po').addClass('hidden');
            $('.gr').addClass('hidden');
            $('.tab-pr').removeClass('act_tb');
            $('.tab-prrel').addClass('act_tb');
            $('.tab-rfq').removeClass('act_tb');
            $('.tab-po').removeClass('act_tb');
            $('.tab-gr').removeClass('act_tb');
        } else if (r == 'rfq') {
            $('.pr').addClass('hidden');
            $('.prrel').addClass('hidden');
            $('.rfq').removeClass('hidden');
            $('.po').addClass('hidden');
            $('.gr').addClass('hidden');
            $('.tab-pr').removeClass('act_tb');
            $('.tab-prrel').removeClass('act_tb');
            $('.tab-rfq').addClass('act_tb');
            $('.tab-po').removeClass('act_tb');
            $('.tab-gr').removeClass('act_tb');
        } else if (r == 'po') {
            $('.pr').addClass('hidden');
            $('.prrel').addClass('hidden');
            $('.rfq').addClass('hidden');
            $('.po').removeClass('hidden');
            $('.gr').addClass('hidden');
            $('.tab-pr').removeClass('act_tb');
            $('.tab-prrel').removeClass('act_tb');
            $('.tab-rfq').removeClass('act_tb');
            $('.tab-po').addClass('act_tb');
            $('.tab-gr').removeClass('act_tb');
        } else if (r == 'gr') {
            $('.pr').addClass('hidden');
            $('.prrel').addClass('hidden');
            $('.rfq').addClass('hidden');
            $('.po').addClass('hidden');
            $('.gr').removeClass('hidden');
            $('.tab-pr').removeClass('act_tb');
            $('.tab-prrel').removeClass('act_tb');
            $('.tab-rfq').removeClass('act_tb');
            $('.tab-po').removeClass('act_tb');
            $('.tab-gr').addClass('act_tb');
        }
    });
    $('#month').change(function () {
        console.log($(this).val());
        loadData($(this).val(), $('#year').val());
    });
    $('#year').change(function () {
        console.log($(this).val());
        loadData($('#month').val(), $(this).val());
    });
});

function loadData(month, year) {
    loadDataPerCompany(month, year, '7000');
    loadDataPerCompany(month, year, '3000');
    loadDataPerCompany(month, year, '4000');
    loadDataPerCompany(month, year, '5000');
    loadDataPerCompany(month, year, '6000');
}

function loadDataPerCompany(month, year, company) {
    console.log('Data Company' + company + ' ' + month + ' ' + year + ' Onload');
    $.ajax({
        url: api_url + 'proc_tracking/getDataPerCompany',
        type: 'GET',
        dataType: 'JSON',
        data: {
            month: month,
            year: year,
            company: company
        },
        beforeSend: function () {
            document.getElementById('loading-' + company).classList.remove('hidden')
            document.getElementById('content-' + company).classList.add('hidden');
        }
    }).done(function (data) {
        console.log(data.trend_pr.barang[0].TOTAL);
        fillValue(company, 'pr', data.total_pr.TOTAL_PR, data.total_pr_detail.TOTAL_PR_BAHAN, data.total_pr_detail.TOTAL_PR_BARANG, data.total_pr_detail.TOTAL_PR_JASA, data.total_pr.TOTAL_VALUE, data.total_pr_detail.TOTAL_VALUE_BAHAN, data.total_pr_detail.TOTAL_VALUE_BARANG, data.total_pr_detail.TOTAL_VALUE_JASA);
        fillValue(company, 'prrel', data.total_pr_rel.TOTAL_PR, data.total_pr_rel_detail.TOTAL_PR_BAHAN, data.total_pr_rel_detail.TOTAL_PR_BARANG, data.total_pr_rel_detail.TOTAL_PR_JASA, data.total_pr_rel.TOTAL_VALUE, data.total_pr_rel_detail.TOTAL_VALUE_BAHAN, data.total_pr_rel_detail.TOTAL_VALUE_BARANG, data.total_pr_rel_detail.TOTAL_VALUE_JASA);
        fillValue(company, 'rfq', data.total_rfq.TOTAL_RFQ, data.total_rfq_detail.TOTAL_RFQ_BAHAN, data.total_rfq_detail.TOTAL_RFQ_BARANG, data.total_rfq_detail.TOTAL_RFQ_JASA, data.total_rfq.TOTAL_VALUE, data.total_rfq_detail.TOTAL_VALUE_BAHAN, data.total_rfq_detail.TOTAL_VALUE_BARANG, data.total_rfq_detail.TOTAL_VALUE_JASA);
        fillValue(company, 'po', data.total_po.TOTAL_PO, data.total_po_detail.TOTAL_PO_BAHAN, data.total_po_detail.TOTAL_PO_BARANG, data.total_po_detail.TOTAL_PO_JASA, data.total_po.TOTAL_VALUE, data.total_po_detail.TOTAL_VALUE_BAHAN, data.total_po_detail.TOTAL_VALUE_BARANG, data.total_po_detail.TOTAL_VALUE_JASA);
        fillValue(company, 'gr', data.total_gr.TOTAL_GR, data.total_gr_detail.TOTAL_GR_BAHAN, data.total_gr_detail.TOTAL_GR_BARANG, data.total_gr_detail.TOTAL_GR_JASA, data.total_gr.TOTAL_VALUE, data.total_gr_detail.TOTAL_VALUE_BAHAN, data.total_gr_detail.TOTAL_VALUE_BARANG, data.total_gr_detail.TOTAL_VALUE_JASA);
        Highcharts.chart('grafikpr-' + company, {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
                name: 'Spareparts',
                data: [parseFloat(data.trend_pr.barang[0].VAL), parseFloat(data.trend_pr.barang[1].VAL), parseFloat(data.trend_pr.barang[2].VAL), parseFloat(data.trend_pr.barang[3].VAL), parseFloat(data.trend_pr.barang[4].VAL), parseFloat(data.trend_pr.barang[5].VAL), parseFloat(data.trend_pr.barang[6].VAL), parseFloat(data.trend_pr.barang[7].VAL), parseFloat(data.trend_pr.barang[8].VAL), parseFloat(data.trend_pr.barang[9].VAL), parseFloat(data.trend_pr.barang[10].VAL), parseFloat(data.trend_pr.barang[11].VAL)]

            }, {
                name: 'Services',
                data: [parseFloat(data.trend_pr.jasa[0].VAL), parseFloat(data.trend_pr.jasa[1].VAL), parseFloat(data.trend_pr.jasa[2].VAL), parseFloat(data.trend_pr.jasa[3].VAL), parseFloat(data.trend_pr.jasa[4].VAL), parseFloat(data.trend_pr.jasa[5].VAL), parseFloat(data.trend_pr.jasa[6].VAL), parseFloat(data.trend_pr.jasa[7].VAL), parseFloat(data.trend_pr.jasa[8].VAL), parseFloat(data.trend_pr.jasa[9].VAL), parseFloat(data.trend_pr.jasa[10].VAL), parseFloat(data.trend_pr.jasa[11].VAL)]

            }]
        });

        Highcharts.chart('grafikprrel-' + company, {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
                name: 'Spareparts',
                data: [parseFloat(data.trend_pr_rel.barang[0].VAL), parseFloat(data.trend_pr_rel.barang[1].VAL), parseFloat(data.trend_pr_rel.barang[2].VAL), parseFloat(data.trend_pr_rel.barang[3].VAL), parseFloat(data.trend_pr_rel.barang[4].VAL), parseFloat(data.trend_pr_rel.barang[5].VAL), parseFloat(data.trend_pr_rel.barang[6].VAL), parseFloat(data.trend_pr_rel.barang[7].VAL), parseFloat(data.trend_pr_rel.barang[8].VAL), parseFloat(data.trend_pr_rel.barang[9].VAL), parseFloat(data.trend_pr_rel.barang[10].VAL), parseFloat(data.trend_pr_rel.barang[11].VAL)]
            }, {
                name: 'Services',
                data: [parseFloat(data.trend_pr_rel.jasa[0].VAL), parseFloat(data.trend_pr_rel.jasa[1].VAL), parseFloat(data.trend_pr_rel.jasa[2].VAL), parseFloat(data.trend_pr_rel.jasa[3].VAL), parseFloat(data.trend_pr_rel.jasa[4].VAL), parseFloat(data.trend_pr_rel.jasa[5].VAL), parseFloat(data.trend_pr_rel.jasa[6].VAL), parseFloat(data.trend_pr_rel.jasa[7].VAL), parseFloat(data.trend_pr_rel.jasa[8].VAL), parseFloat(data.trend_pr_rel.jasa[9].VAL), parseFloat(data.trend_pr_rel.jasa[10].VAL), parseFloat(data.trend_pr_rel.jasa[11].VAL)]

            }]
        });

        Highcharts.chart('grafikrfq-' + company, {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
                name: 'Raw Material & Fuel',
                data: [parseFloat(data.trend_rfq.bahan[0].VAL), parseFloat(data.trend_rfq.bahan[1].VAL), parseFloat(data.trend_rfq.bahan[2].VAL), parseFloat(data.trend_rfq.bahan[3].VAL), parseFloat(data.trend_rfq.bahan[4].VAL), parseFloat(data.trend_rfq.bahan[5].VAL), parseFloat(data.trend_rfq.bahan[6].VAL), parseFloat(data.trend_rfq.bahan[7].VAL), parseFloat(data.trend_rfq.bahan[8].VAL), parseFloat(data.trend_rfq.bahan[9].VAL), parseFloat(data.trend_rfq.bahan[10].VAL), parseFloat(data.trend_rfq.bahan[11].VAL)]

            }, {
                name: 'Spareparts',
                data: [parseFloat(data.trend_rfq.barang[0].VAL), parseFloat(data.trend_rfq.barang[1].VAL), parseFloat(data.trend_rfq.barang[2].VAL), parseFloat(data.trend_rfq.barang[3].VAL), parseFloat(data.trend_rfq.barang[4].VAL), parseFloat(data.trend_rfq.barang[5].VAL), parseFloat(data.trend_rfq.barang[6].VAL), parseFloat(data.trend_rfq.barang[7].VAL), parseFloat(data.trend_rfq.barang[8].VAL), parseFloat(data.trend_rfq.barang[9].VAL), parseFloat(data.trend_rfq.barang[10].VAL), parseFloat(data.trend_rfq.barang[11].VAL)]

            }, {
                name: 'Services',
                data: [parseFloat(data.trend_rfq.jasa[0].VAL), parseFloat(data.trend_rfq.jasa[1].VAL), parseFloat(data.trend_rfq.jasa[2].VAL), parseFloat(data.trend_rfq.jasa[3].VAL), parseFloat(data.trend_rfq.jasa[4].VAL), parseFloat(data.trend_rfq.jasa[5].VAL), parseFloat(data.trend_rfq.jasa[6].VAL), parseFloat(data.trend_rfq.jasa[7].VAL), parseFloat(data.trend_rfq.jasa[8].VAL), parseFloat(data.trend_rfq.jasa[9].VAL), parseFloat(data.trend_rfq.jasa[10].VAL), parseFloat(data.trend_rfq.jasa[11].VAL)]

            }]
        });

        Highcharts.chart('grafikpo-' + company, {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
                name: 'Raw Material & Fuel',
                data: [parseFloat(data.trend_po.bahan[0].VAL), parseFloat(data.trend_po.bahan[1].VAL), parseFloat(data.trend_po.bahan[2].VAL), parseFloat(data.trend_po.bahan[3].VAL), parseFloat(data.trend_po.bahan[4].VAL), parseFloat(data.trend_po.bahan[5].VAL), parseFloat(data.trend_po.bahan[6].VAL), parseFloat(data.trend_po.bahan[7].VAL), parseFloat(data.trend_po.bahan[8].VAL), parseFloat(data.trend_po.bahan[9].VAL), parseFloat(data.trend_po.bahan[10].VAL), parseFloat(data.trend_po.bahan[11].VAL)]

            }, {
                name: 'Spareparts',
                data: [parseFloat(data.trend_po.barang[0].VAL), parseFloat(data.trend_po.barang[1].VAL), parseFloat(data.trend_po.barang[2].VAL), parseFloat(data.trend_po.barang[3].VAL), parseFloat(data.trend_po.barang[4].VAL), parseFloat(data.trend_po.barang[5].VAL), parseFloat(data.trend_po.barang[6].VAL), parseFloat(data.trend_po.barang[7].VAL), parseFloat(data.trend_po.barang[8].VAL), parseFloat(data.trend_po.barang[9].VAL), parseFloat(data.trend_po.barang[10].VAL), parseFloat(data.trend_po.barang[11].VAL)]

            }, {
                name: 'Services',
                data: [parseFloat(data.trend_po.jasa[0].VAL), parseFloat(data.trend_po.jasa[1].VAL), parseFloat(data.trend_po.jasa[2].VAL), parseFloat(data.trend_po.jasa[3].VAL), parseFloat(data.trend_po.jasa[4].VAL), parseFloat(data.trend_po.jasa[5].VAL), parseFloat(data.trend_po.jasa[6].VAL), parseFloat(data.trend_po.jasa[7].VAL), parseFloat(data.trend_po.jasa[8].VAL), parseFloat(data.trend_po.jasa[9].VAL), parseFloat(data.trend_po.jasa[10].VAL), parseFloat(data.trend_po.jasa[11].VAL)]

            }]
        });

        Highcharts.chart('grafikgr-' + company, {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
                name: 'Raw Material & Fuel',
                data: [parseFloat(data.trend_gr.bahan[0].VAL), parseFloat(data.trend_gr.bahan[1].VAL), parseFloat(data.trend_gr.bahan[2].VAL), parseFloat(data.trend_gr.bahan[3].VAL), parseFloat(data.trend_gr.bahan[4].VAL), parseFloat(data.trend_gr.bahan[5].VAL), parseFloat(data.trend_gr.bahan[6].VAL), parseFloat(data.trend_gr.bahan[7].VAL), parseFloat(data.trend_gr.bahan[8].VAL), parseFloat(data.trend_gr.bahan[9].VAL), parseFloat(data.trend_gr.bahan[10].VAL), parseFloat(data.trend_gr.bahan[11].VAL)]

            }, {
                name: 'Spareparts',
                data: [parseFloat(data.trend_gr.barang[0].VAL), parseFloat(data.trend_gr.barang[1].VAL), parseFloat(data.trend_gr.barang[2].VAL), parseFloat(data.trend_gr.barang[3].VAL), parseFloat(data.trend_gr.barang[4].VAL), parseFloat(data.trend_gr.barang[5].VAL), parseFloat(data.trend_gr.barang[6].VAL), parseFloat(data.trend_gr.barang[7].VAL), parseFloat(data.trend_gr.barang[8].VAL), parseFloat(data.trend_gr.barang[9].VAL), parseFloat(data.trend_gr.barang[10].VAL), parseFloat(data.trend_gr.barang[11].VAL)]

            }, {
                name: 'Services',
                data: [parseFloat(data.trend_gr.jasa[0].VAL), parseFloat(data.trend_gr.jasa[1].VAL), parseFloat(data.trend_gr.jasa[2].VAL), parseFloat(data.trend_gr.jasa[3].VAL), parseFloat(data.trend_gr.jasa[4].VAL), parseFloat(data.trend_gr.jasa[5].VAL), parseFloat(data.trend_gr.jasa[6].VAL), parseFloat(data.trend_gr.jasa[7].VAL), parseFloat(data.trend_gr.jasa[8].VAL), parseFloat(data.trend_gr.jasa[9].VAL), parseFloat(data.trend_gr.jasa[10].VAL), parseFloat(data.trend_gr.jasa[11].VAL)]

            }]
        });
        companySuccesOnLoad(company);
    }).fail(function () {
        companyFailedOnLoad(company);
    });
}

function companySuccesOnLoad(company) {
    console.log('Success to load Company ' + company + ' data');
    itemID = 'logocomp-' + company;
    document.getElementById('content-' + company).classList.remove('hidden');
    document.getElementById('loading-' + company).classList.add('hidden');
    document.getElementById(itemID).setAttribute('data-status', '2');
}

function companyFailedOnLoad(company) {
    console.log('Failed to load Company ' + company + ' data');
    itemID = 'logocomp-' + company;
    document.getElementById('content-' + company).classList.remove('hidden');
    document.getElementById('loading-' + company).classList.add('hidden');
    document.getElementById(itemID).setAttribute('data-status', '1');
}

function changeCompanyDisplay(company, status) {
    itemID = 'logocomp-' + company;
    if (status == 0) {
        [].forEach.call(document.querySelectorAll('.footer-logo'), function (xy) {
            xy.classList.add("img_foot2");
        });
        [].forEach.call(document.querySelectorAll('.content-company'), function (a) {
            a.classList.add('hidden')
        });
        document.getElementById('content-company' + company).classList.remove('hidden');
        document.getElementById(itemID).classList.remove("img_foot2");
    } else if (status == 1) {
        alert('This company has no data');
    } else {
        [].forEach.call(document.querySelectorAll('.footer-logo'), function (xy) {
            xy.classList.add("img_foot2");
        });
        [].forEach.call(document.querySelectorAll('.content-company'), function (a) {
            a.classList.add('hidden')
        });
        document.getElementById(itemID).classList.remove("img_foot2");
        document.getElementById('content-company' + company).classList.remove('hidden');
    }
}

function initiateView() {
    [].forEach.call(document.querySelectorAll('.content-company'), function (x) {
        x.classList.add('hidden');
    });
    document.getElementById('content-company7000').classList.remove('hidden');
}

function fillValue(company, elementName, totalcount, rawcount, partscount, servicecount, totalvalue, rawvalue, partsvalue, servicevalue) {
    document.getElementById("count" + elementName + "-" + company).innerHTML = parseInt(totalcount);
    document.getElementById("rawcount" + elementName + "-" + company).innerHTML = parseInt(rawcount);
    document.getElementById("partscount" + elementName + "-" + company).innerHTML = parseInt(partscount);
    document.getElementById("servicecount" + elementName + "-" + company).innerHTML = parseInt(servicecount);
    document.getElementById("totval" + elementName + "-" + company).innerHTML = (parseFloat(totalvalue) / 1000000).toFixed(3);
    document.getElementById("rawtotval" + elementName + "-" + company).innerHTML = (parseFloat(rawvalue) / 1000000).toFixed(3);
    document.getElementById("partstotval" + elementName + "-" + company).innerHTML = (parseFloat(partsvalue) / 1000000).toFixed(3);
    document.getElementById("servicetotval" + elementName + "-" + company).innerHTML = (parseFloat(servicevalue) / 1000000).toFixed(3);
}