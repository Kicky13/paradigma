//KILN 34
//function dataUpdate(){
$.ajax({
    url: url_opc+'/FeedKL34.php',
    type: 'GET',
    success: function (data) {
        var data1 = data.replace("<title>Json</title>", "");
        var data2 = data1.replace("(", "[");
        var data3 = data2.replace(");", "]");

        var dataJson = JSON.parse(data3);
        var myLogData = dataJson['7000'].Feed_Kiln;

        var ctx1 = document.getElementById("rateChart");
        var labelArray = [];
        var dataRate1 = [];
        var dataRate2 = [];
        var index = [];

        for (var x in myLogData) {
            index.push(x);
            labelArray.push(x);
            nilaiRate1 = dataJson['7000'].Feed_Kiln[x].kl3;
            dataRate1.push(parseInt(nilaiRate1.replace(',', '.')));

            nilaiRate2 = dataJson['7000'].Feed_Kiln[x].kl4;
            dataRate2.push(parseInt(nilaiRate2.replace(',', '.')));
        }

        var data1 = {
            labels: labelArray,
            datasets: [
                {
                    label: "KL 3",
                    fill: false,
                    lineTension: 0.1,
                    borderColor: "#f44336",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#f44336",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#f44336",
                    pointHoverBorderColor: "#f44336",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataRate1,
                    spanGaps: false,
                },
                {
                    label: "KL 4",
                    fill: false,
                    lineTension: 0.1,
                    borderColor: "#12ff22",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#12ff22",
                    pointBackgroundColor: "#12ff22",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#12ff22",
                    pointHoverBorderColor: "#12ff22",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataRate2,
                    spanGaps: false,
                }
            ]
        }
        var myLineChart = new Chart(ctx1, {
            type: 'line',
            data: data1,
            options: {
                legend: {
                    display: true,
                },
                maintainAspectRatio: false
            }
        });
    }

}).done(function (data) {
}).fail(function () {

});
//Raw Mill 34
$.ajax({
    url: url_opc+'/FeedRM34.php',
    type: 'GET',
    success: function (data) {
        var data1 = data.replace("<title>Json</title>", "");
        var data2 = data1.replace("(", "[");
        var data3 = data2.replace(");", "]");

        var dataJson = JSON.parse(data3);
        var myLogData = dataJson['7000'].Feed_RM;

        var ctx1 = document.getElementById("rmChart");
        var labelArray = [];
        var dataRate1 = [];
        var dataRate2 = [];
        var index = [];

        for (var x in myLogData) {
            index.push(x);
            labelArray.push(x);
            nilaiRate1 = dataJson['7000'].Feed_RM[x].rm3;
            dataRate1.push(parseInt(nilaiRate1.replace(',', '.')));

            nilaiRate2 = dataJson['7000'].Feed_RM[x].rm4;
            dataRate2.push(parseInt(nilaiRate2.replace(',', '.')));
        }

        var data1 = {
            labels: labelArray,
            datasets: [
                {
                    label: "RM 3",
                    fill: false,
                    lineTension: 0.1,
                    borderColor: "#f44336",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#f44336",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#f44336",
                    pointHoverBorderColor: "#f44336",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataRate1,
                    spanGaps: false,
                },
                {
                    label: "RM 4",
                    fill: false,
                    lineTension: 0.1,
                    borderColor: "#12ff22",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#12ff22",
                    pointBackgroundColor: "#12ff22",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#12ff22",
                    pointHoverBorderColor: "#12ff22",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataRate2,
                    spanGaps: false,
                }
            ]
        }
        var myLineChart = new Chart(ctx1, {
            type: 'line',
            data: data1,
            options: {
                legend: {
                    display: false,
                },
                maintainAspectRatio: false
            }
        });
    }

}).done(function (data) {
}).fail(function () {

});

//Coal Mill 34
$.ajax({
    url: url_opc+'/FeedCM34.php',
    type: 'GET',
    success: function (data) {
        var data1 = data.replace("<title>Json</title>", "");
        var data2 = data1.replace("(", "[");
        var data3 = data2.replace(");", "]");

        var dataJson = JSON.parse(data3);
        var myLogData = dataJson['7000'].Feed_CM;

        var ctx1 = document.getElementById("cmChart");
        var labelArray = [];
        var dataRate1 = [];
        var dataRate2 = [];
        var index = [];

        for (var x in myLogData) {
            index.push(x);
            labelArray.push(x);
            nilaiRate1 = dataJson['7000'].Feed_CM[x].cm3;
            dataRate1.push(parseInt(nilaiRate1.replace(',', '.')));

            nilaiRate2 = dataJson['7000'].Feed_CM[x].cm4;
            dataRate2.push(parseInt(nilaiRate2.replace(',', '.')));
        }

        var data1 = {
            labels: labelArray,
            datasets: [
                {
                    label: "CM 3",
                    fill: false,
                    lineTension: 0.1,
                    borderColor: "#f44336",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#f44336",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#f44336",
                    pointHoverBorderColor: "#f44336",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataRate1,
                    spanGaps: false,
                },
                {
                    label: "CM 4",
                    fill: false,
                    lineTension: 0.1,
                    borderColor: "#12ff22",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#12ff22",
                    pointBackgroundColor: "#12ff22",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#12ff22",
                    pointHoverBorderColor: "#12ff22",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataRate2,
                    spanGaps: false,
                }
            ]
        }
        var myLineChart = new Chart(ctx1, {
            type: 'line',
            data: data1,
            options: {
                legend: {
                    display: false,
                },
                maintainAspectRatio: false
            }
        });
    }

}).done(function (data) {
}).fail(function () {

});

//Finish Mill 5678
$.ajax({
    url: url_opc+'/FeedFM34.php',
    type: 'GET',
    success: function (data) {
        var data1 = data.replace("<title>Json</title>", "");
        var data2 = data1.replace("(", "[");
        var data3 = data2.replace(");", "]");

        var dataJson = JSON.parse(data3);
        var myLogData = dataJson['7000'].Feed_FM;

        var ctx1 = document.getElementById("fmChart");
        var labelArray = [];
        var dataRate1 = [];
        var dataRate2 = [];
        var dataRate3 = [];
        var dataRate4 = [];
        var index = [];

        for (var x in myLogData) {
            index.push(x);
            labelArray.push(x);
            nilaiRate1 = dataJson['7000'].Feed_FM[x].fm5;
            dataRate1.push(parseInt(nilaiRate1.replace(',', '.')));

            nilaiRate2 = dataJson['7000'].Feed_FM[x].fm6;
            dataRate2.push(parseInt(nilaiRate2.replace(',', '.')));

            nilaiRate3 = dataJson['7000'].Feed_FM[x].fm7;
            dataRate3.push(parseInt(nilaiRate3.replace(',', '.')));

            nilaiRate4 = dataJson['7000'].Feed_FM[x].fm8;
            dataRate4.push(parseInt(nilaiRate4.replace(',', '.')));
        }

        var data1 = {
            labels: labelArray,
            datasets: [
                {
                    label: "FM 5",
                    fill: false,
                    lineTension: 0.1,
                    borderColor: "#f44336",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#f44336",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#f44336",
                    pointHoverBorderColor: "#f44336",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataRate1,
                    spanGaps: false,
                },
                {
                    label: "FM 6",
                    fill: false,
                    lineTension: 0.1,
                    borderColor: "#12ff22",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#12ff22",
                    pointBackgroundColor: "#12ff22",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#12ff22",
                    pointHoverBorderColor: "#12ff22",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataRate2,
                    spanGaps: false,
                },
                {
                    label: "FM 7",
                    fill: false,
                    lineTension: 0.1,
                    borderColor: "#11e4f3",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#11e4f3",
                    pointBackgroundColor: "#11e4f3",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#11e4f3",
                    pointHoverBorderColor: "#11e4f3",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataRate3,
                    spanGaps: false,
                },
                {
                    label: "FM 8",
                    fill: false,
                    lineTension: 0.1,
                    borderColor: "#f1ff38",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#f1ff38",
                    pointBackgroundColor: "#f1ff38",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#f1ff38",
                    pointHoverBorderColor: "#f1ff38",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataRate4,
                    spanGaps: false,
                }
            ]
        }
        var myLineChart = new Chart(ctx1, {
            type: 'line',
            data: data1,
            options: {
                legend: {
                    display: false,
                },
                maintainAspectRatio: false
            }
        });
    }

}).done(function (data) {
}).fail(function () {

});
//}; setInterval(dataUpdate, 60000);