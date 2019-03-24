var api_url = 'http://10.15.5.150/dev/par4digma';
// var api_url = 'http://par4digma.semenindonesia.com';
var currentTime = new Date();

$(document).ready(function () {
    console.log('Ready Func');
    getDataDashboard('2019');
});

function getDataDashboard(fullYear) {
    console.log('Loading Get Data');
    $.ajax({
        url: api_url + '/api/index.php/capex/getDataDashboardNew/' + fullYear,
        type: 'GET',
        dataType: 'JSON',
    }).done(function (data) {
        console.log(data);
    })
}