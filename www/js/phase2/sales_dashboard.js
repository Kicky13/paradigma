// var api_url = 'http://10.15.5.150/dev/par4digma/api/index.php';
var api_url = 'http://par4digma.semenindonesia.com/api/index.php';

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
        document.getElementById('TOTRD').innerHTML = ((parseFloat(data.perDay.ZAK.REVENUE) + parseFloat(data.perDay.Clinker.REVENUE) + parseFloat(data.perDay.Curah.REVENUE))/1000000).toFixed(2);
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
        document.getElementById('ZAKVUD').innerHTML = (data.upToday.ZAK.VOLUME/1).toFixed(2);
        document.getElementById('ZAKPUD').innerHTML = (data.upToday.ZAK.PRICE/1).toFixed(2);
        document.getElementById('ZAKPRSUD').innerHTML = 0;
        document.getElementById('ZAKRUD').innerHTML = (data.upToday.ZAK.REVENUE/1000000).toFixed(2);
        document.getElementById('CRHVUD').innerHTML = (data.upToday.Curah.VOLUME/1).toFixed(2);
        document.getElementById('CRHPUD').innerHTML = (data.upToday.Curah.PRICE/1).toFixed(2);
        document.getElementById('CRHPRSUD').innerHTML = 0;
        document.getElementById('CRHRUD').innerHTML = (data.upToday.Curah.REVENUE/1000000).toFixed(2);
        document.getElementById('CLINKVUD').innerHTML = (data.upToday.Clinker.VOLUME/1).toFixed(2);
        document.getElementById('CLINKPUD').innerHTML = (data.upToday.Clinker.PRICE/1).toFixed(2);
        document.getElementById('CLINKPRSUD').innerHTML = 0;
        document.getElementById('CLINKRUD').innerHTML = (data.upToday.Clinker.REVENUE/1000000).toFixed(2);
        document.getElementById('KSOVUD').innerHTML = (data.perOpco.SI.VOLUME/1).toFixed(2);
        document.getElementById('KSOPUD').innerHTML = (data.perOpco.SI.PRICE/1).toFixed(2);
        document.getElementById('KSORUD').innerHTML = (data.perOpco.SI.REVENUE/1000000).toFixed(2);
        document.getElementById('SGVUD').innerHTML = (data.perOpco.SG.VOLUME/1).toFixed(2);
        document.getElementById('SGPUD').innerHTML = (data.perOpco.SG.PRICE/1).toFixed(2);
        document.getElementById('SGRUD').innerHTML = (data.perOpco.SG.REVENUE/1000000).toFixed(2);
        document.getElementById('SPVUD').innerHTML = (data.perOpco.SP.VOLUME/1).toFixed(2);
        document.getElementById('SPPUD').innerHTML = (data.perOpco.SP.PRICE/1).toFixed(2);
        document.getElementById('SPRUD').innerHTML = (data.perOpco.SP.REVENUE/1000000).toFixed(2);
        document.getElementById('STVUD').innerHTML = (data.perOpco.ST.VOLUME/1).toFixed(2);
        document.getElementById('STPUD').innerHTML = (data.perOpco.ST.PRICE/1).toFixed(2);
        document.getElementById('STRUD').innerHTML = (data.perOpco.ST.REVENUE/1000000).toFixed(2);
        document.getElementById('TLCCVUD').innerHTML = (data.perOpco.TL.VOLUME/1).toFixed(2);
        document.getElementById('TLCCPUD').innerHTML = (data.perOpco.TL.PRICE/1).toFixed(2);
        document.getElementById('TLCCRUD').innerHTML = (data.perOpco.TL.REVENUE/1000000).toFixed(2);
        document.getElementById('TOTRUD').innerHTML = ((parseFloat(data.upToday.ZAK.REVENUE) + parseFloat(data.upToday.Clinker.REVENUE) + parseFloat(data.upToday.Curah.REVENUE))/1000000).toFixed(2);
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
        document.getElementById('ZAKVUM').innerHTML = (data.perMonth.ZAK.VOLUME/1).toFixed(2);
        document.getElementById('ZAKPUM').innerHTML = (data.perMonth.ZAK.PRICE/1).toFixed(2);
        document.getElementById('ZAKPRSUM').innerHTML = 0;
        document.getElementById('ZAKRUM').innerHTML = (data.perMonth.ZAK.REVENUE/1000000).toFixed(2);
        document.getElementById('CRHVUM').innerHTML = (data.perMonth.Curah.VOLUME/1).toFixed(2);
        document.getElementById('CRHPUM').innerHTML = (data.perMonth.Curah.PRICE/1).toFixed(2);
        document.getElementById('CRHPRSUM').innerHTML = 0;
        document.getElementById('CRHRUM').innerHTML = (data.perMonth.Curah.REVENUE/1000000).toFixed(2);
        document.getElementById('CLINKVUM').innerHTML = (data.perMonth.Clinker.VOLUME/1).toFixed(2);
        document.getElementById('CLINKPUM').innerHTML = (data.perMonth.Clinker.PRICE/1).toFixed(2);
        document.getElementById('CLINKPRSUM').innerHTML = 0;
        document.getElementById('CLINKRUM').innerHTML = (data.perMonth.Clinker.REVENUE/1000000).toFixed(2);
        document.getElementById('KSOVUM').innerHTML = (data.perOpco.SI.VOLUME/1).toFixed(2);
        document.getElementById('KSOPUM').innerHTML = (data.perOpco.SI.PRICE/1).toFixed(2);
        document.getElementById('KSORUM').innerHTML = (data.perOpco.SI.REVENUE/1000000).toFixed(2);
        document.getElementById('SGVUM').innerHTML = (data.perOpco.SG.VOLUME/1).toFixed(2);
        document.getElementById('SGPUM').innerHTML = (data.perOpco.SG.PRICE/1).toFixed(2);
        document.getElementById('SGRUM').innerHTML = (data.perOpco.SG.REVENUE/1000000).toFixed(2);
        document.getElementById('SPVUM').innerHTML = (data.perOpco.SP.VOLUME/1).toFixed(2);
        document.getElementById('SPPUM').innerHTML = (data.perOpco.SP.PRICE/1).toFixed(2);
        document.getElementById('SPRUM').innerHTML = (data.perOpco.SP.REVENUE/1000000).toFixed(2);
        document.getElementById('STVUM').innerHTML = (data.perOpco.ST.VOLUME/1).toFixed(2);
        document.getElementById('STPUM').innerHTML = (data.perOpco.ST.PRICE/1).toFixed(2);
        document.getElementById('STRUM').innerHTML = (data.perOpco.ST.REVENUE/1000000).toFixed(2);
        document.getElementById('TLCCVUM').innerHTML = (data.perOpco.TL.VOLUME/1).toFixed(2);
        document.getElementById('TLCCPUM').innerHTML = (data.perOpco.TL.PRICE/1).toFixed(2);
        document.getElementById('TLCCRUM').innerHTML = (data.perOpco.TL.REVENUE/1000000).toFixed(2);
        document.getElementById('TOTRUM').innerHTML = ((parseFloat(data.perMonth.ZAK.REVENUE) + parseFloat(data.perMonth.Clinker.REVENUE) + parseFloat(data.perMonth.Curah.REVENUE))/1000000).toFixed(2);
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