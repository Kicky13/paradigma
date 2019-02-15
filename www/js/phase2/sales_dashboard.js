var api_url = 'http://10.15.5.150/dev/par4digma/api/index.php';
// var api_url = 'http://par4digma.semenindonesia.com/api/index.php';

$(document).ready(function () {
    console.log("Test");
    dataThisDay();
    dataDayUpTo();
    dataMonthUpTo();
    $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: false
    });
    $(".center").slick({
        dots: true,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: false
    });
    $(".variable").slick({
        dots: true,
        infinite: true,
        variableWidth: true,
        arrows: false,
    });
    $('.single-item').slick({
        // autoplay: true,
        // autoplaySpeed: 5000
        arrows: false
    });
    $('.single-item').slick();
    $('.multiple-items').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4
    });
    $(".regular").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: true,
        centerMode: true
        // variableWidth: true
    });
});

function dataThisDay() {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: api_url + '/sales_new/getSMIGThisDay'
    }).done(function (data) {
        console.log(data);
        document.getElementById('ZAKVD').innerHTML = (data.perDay.ZAK.VOLUME/1).toFixed(2);
        document.getElementById('ZAKPD').innerHTML = (data.perDay.ZAK.PRICE/1).toFixed(2);
        document.getElementById('ZAKPRSD').innerHTML = 0;
        document.getElementById('ZAKRD').innerHTML = (data.perDay.ZAK.REVENUE/1000000).toFixed(2);
        document.getElementById('CRHVD').innerHTML = (data.perDay.Curah.VOLUME/1).toFixed(2);
        document.getElementById('CRHPD').innerHTML = (data.perDay.Curah.PRICE/1).toFixed(2);
        document.getElementById('CRHPRSD').innerHTML = 0;
        document.getElementById('CRHRD').innerHTML = (data.perDay.Curah.REVENUE/1000000).toFixed(2);
        document.getElementById('CLINKVD').innerHTML = (data.perDay.Clinker.VOLUME/1).toFixed(2);
        document.getElementById('CLINKPD').innerHTML = (data.perDay.Clinker.PRICE/1).toFixed(2);
        document.getElementById('CLINKPRSD').innerHTML = 0;
        document.getElementById('CLINKRD').innerHTML = (data.perDay.Clinker.REVENUE/1000000).toFixed(2);
        document.getElementById('KSOVD').innerHTML = (data.perOpco.SI.VOLUME/1).toFixed(2);
        document.getElementById('KSOPD').innerHTML = (data.perOpco.SI.PRICE/1).toFixed(2);
        document.getElementById('KSORD').innerHTML = (data.perOpco.SI.REVENUE/1000000).toFixed(2);
        document.getElementById('SGVD').innerHTML = (data.perOpco.SG.VOLUME/1).toFixed(2);
        document.getElementById('SGPD').innerHTML = (data.perOpco.SG.PRICE/1).toFixed(2);
        document.getElementById('SGRD').innerHTML = (data.perOpco.SG.REVENUE/1000000).toFixed(2);
        document.getElementById('SPVD').innerHTML = (data.perOpco.SP.VOLUME/1).toFixed(2);
        document.getElementById('SPPD').innerHTML = (data.perOpco.SP.PRICE/1).toFixed(2);
        document.getElementById('SPRD').innerHTML = (data.perOpco.SP.REVENUE/1000000).toFixed(2);
        document.getElementById('STVD').innerHTML = (data.perOpco.ST.VOLUME/1).toFixed(2);
        document.getElementById('STPD').innerHTML = (data.perOpco.ST.PRICE/1).toFixed(2);
        document.getElementById('STRD').innerHTML = (data.perOpco.ST.REVENUE/1000000).toFixed(2);
        document.getElementById('TLCCVD').innerHTML = (data.perOpco.TL.VOLUME/1).toFixed(2);
        document.getElementById('TLCCPD').innerHTML = (data.perOpco.TL.PRICE/1).toFixed(2);
        document.getElementById('TLCCRD').innerHTML = (data.perOpco.TL.REVENUE/1000000).toFixed(2);
    }).always(function (data) {
        console.log(data);
        uploadControl(JSON.stringify(data), 'SalesDaily', 'Sales/Daily');
    });
}

function dataDayUpTo() {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: api_url + '/sales_new/getSMIGUpToday'
    }).done(function (data) {
        console.log(data);
    }).always(function (data) {
        console.log(data);
        uploadControl(JSON.stringify(data), 'SalesDailyUpTo', 'Sales/DailyUpTo');
    });
}
    
function dataMonthUpTo() {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: api_url + '/sales_new/getSMIGUpToMonth'
    }).done(function (data) {
        console.log(data);
    }).always(function (data) {
        console.log(data);
        uploadControl(JSON.stringify(data), 'SalesMonthly', 'Sales/MonthlyUpTo');
    });
}

function uploadControl(textFile, taskType, saveDir) {
    $.ajax({
        url: api_url + '/upload_control/uploadFile',
        type: 'POST',
        dataType: 'JSON',
        data: {
            text: textFile,
            task: taskType,
            folder: saveDir
        }
    }).always(function (data) {
        console.log(textFile + ' ' + taskType + ' ' + data);
    }).done(function (data) {
        console.log(textFile + ' ' + taskType + ' ' + data);
    })
}