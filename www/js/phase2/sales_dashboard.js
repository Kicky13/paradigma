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
    var table = $('#dailyTable tbody');
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: api_url + '/sales_new/getSMIGThisDay'
    }).done(function (data) {
        console.log(data);
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