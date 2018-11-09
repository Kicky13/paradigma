var label = [];
var now = [];
var last = [];
var hei = '';
var totat

var opco = [];
var datas = datasub = datasub2 = datasub3 = datasProd =  datasProdOpco = datasProdOpco1 = new Array();
datas = {"actualcem": [], "actualclin": []};
datasProd = {"cement": [], "clinker": []};
datasProdOpco = {"3000": [], "4000": [], "7000": []};
datasProdOpco1 = {"3000": [], "4000": [], "7000": []};
datasub = {"actual": [], "rkap": [], "actual1": []};

datasub3000 = {"P_3301":[], "P_3302":[], "P_3303":[], "P_3304":[], "P_3309":[]};
datasub4000 = {"P_4301":[], "P_4302":[], "P_4303":[]};
datasub7000 = {"P_7301":[], "P_7302":[], "P_7303":[], "P_7304":[], "P_7305":[]};
datasub30001 = {"P_3301":[], "P_3302":[], "P_3303":[], "P_3304":[], "P_3309":[]};
datasub40001 = {"P_4301":[], "P_4302":[], "P_4303":[]};
datasub70001 = {"P_7301":[], "P_7302":[], "P_7303":[], "P_7304":[], "P_7305":[]};


var ajsCem = 0;
var ajsClin =0;

var OpcoCement = 0;
var OpcoClinker =0;


var total = 0;
var totalCement = 0;
var totalClinker = 0;
var totalRKAPcement = 0;
var totalRKAPclinker = 0;
var totalCementLastYear = 0;
var totalClinkerLastYear = 0;


function graphicChart_perform(labels, data) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_perform', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [month[labels - 1]],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'SP',
            color: '#1E8BC3',
            data: [data[0]]
        }, {
            name: 'SG',
            color: '#E9D460',
            data: [data[1]]
        }, {
            name: 'ST',
            color: '#EF4836',
            data: [data[2]]
        }
        ]
    });
}
function graphicChart_perform1(labels, data) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_perform1', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [month[labels - 1]],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'ST',
            color: '#1E8BC3',
            data: [data[0]]
        }, {
            name: 'SG',
            color: '#E9D460',
            data: [data[1]]
        }, {
            name: 'ST',
            color: '#EF4836',
            data: [data[2]]
        }
        ]
    });
}
function graphicChart_Gresik(labels, data) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_perform', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [month[labels - 1]],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Gresik',
            color: '#1E8BC3',
            data: [data[0]]
        }, {
            name: 'Tuban 1',
            color: '#E9D460',
            data: [data[1]]
        }, {
            name: 'Tuban 2',
            color: '#EF4836',
            data: [data[2]]
        }, {
            name: 'Tuban 3',
            color: '#16d308',
            data: [data[3]]
        }, {
            name: 'Tuban 4',
            color: '#19B5FE',
            data: [data[4]]
        }
        ]
    });
}
function graphicChart_Gresik1(labels, data) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_perform1', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [month[labels - 1]],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Tuban 1',
            color: '#1E8BC3',
            data: [data[0]]
        }, {
            name: 'Tuban 2',
            color: '#E9D460',
            data: [data[1]]
        }, {
            name: 'Tuban 3',
            color: '#EF4836',
            data: [data[2]]
        }, {
            name: 'Tuban 4',
            color: '#16d308',
            data: [data[3]]
        },
        ]
    });
}
function graphicChart_Tonasa(labels, data) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_perform', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [month[labels - 1]],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Tonasa II & III',
            color: '#1E8BC3',
            data: [data[0]]
        }, {
            name: 'Tonasa IV',
            color: '#E9D460',
            data: [data[1]]
        }, {
            name: 'Tonasa V',
            color: '#EF4836',
            data: [data[2]]
        }
        ]
    });
}
function graphicChart_Tonasa1(labels, data) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_perform1', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [month[labels - 1]],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Tonasa II & III',
            color: '#1E8BC3',
            data: [data[0]]
        }, {
            name: 'Tonasa IV',
            color: '#E9D460',
            data: [data[1]]
        }, {
            name: 'Tonasa V',
            color: '#EF4836',
            data: [data[2]]
        }
        ]
    });
}
function graphicChart_Padang(labels, data) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_perform', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [month[labels - 1]],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Indarung I',
            color: '#1E8BC3',
            data: [data[0]]
        }, {
            name: 'Indarung II & III',
            color: '#E9D460',
            data: [data[1]]
        }, {
            name: 'Indarung IV',
            color: '#EF4836',
            data: [data[2]]
        }, {
            name: 'Indarung V',
            color: '#16d308',
            data: [data[3]]
        }, {
            name: 'Mill Dumai',
            color: '#19B5FE',
            data: [data[4]]
        }
        ]
    });
}
function graphicChart_Padang1(labels, data) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_perform1', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [month[labels - 1]],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Indarung I',
            color: '#1E8BC3',
            data: [data[0]]
        }, {
            name: 'Indarung II & III',
            color: '#E9D460',
            data: [data[1]]
        }, {
            name: 'Indarung IV',
            color: '#EF4836',
            data: [data[2]]
        }, {
            name: 'Indarung V',
            color: '#16d308',
            data: [data[3]]
        }, {
            name: 'Mill Dumai',
            color: '#19B5FE',
            data: [data[4]]
        }
        ]
    });
}


/*===============================================*/
/*              GRAFIK CEMENT AND                */
/*===============================================*/
function graphicChart_CemCli_SMI(labels, datass) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_totCemClin', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            // categories: [],
            categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Cemen',
            color: '#1E8BC3',
            data: datass['cement']
        }, {
            name: 'Clinker',
            color: '#EF4836',
            data: datass['clinker']
        }
        ]
    });
}

function graphicChart_CemCli_Opco(labels, datasProdOpco) {
    console.log(datasProdOpco);
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_totAllOpco', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            // categories: [],
            categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Semen Padang',
            color: '#1E8BC3',
            data: datasProdOpco['3000']
        }, {
            name: 'Semen Tonasa',
            color: '#E9D460',
            data: datasProdOpco['4000']
        }, {
            name: 'Semen Gresik',
            color: '#EF4836',
            data: datasProdOpco['7000']
        }
        ]
    });
}

function graphicChart_CemCli_Opco1(labels, datasProdOpco) {
    console.log(datasProdOpco);
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_totAllOpco1', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            // categories: [],
            categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Semen Padang',
            color: '#1E8BC3',
            data: datasProdOpco['3000']
        }, {
            name: 'Semen Tonasa',
            color: '#E9D460',
            data: datasProdOpco['4000']
        }, {
            name: 'Semen Gresik',
            color: '#EF4836',
            data: datasProdOpco['7000']
        }
        ]
    });
}

function graphicChartPerforma_Padang(labels, datasub3000) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_totAllOpco', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            // categories: [],
            categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        // series: [{
        //     name: 'Indarung I',
        //     color: '#1E8BC3',
        //     data: [100]
        // }, {
        //     name: 'Indarung II/III',
        //     color: '#E9D460',
        //     data: [100]
        // }, {
        //     name: 'Indarung IV',
        //     color: '#009933',
        //     data: [100]
        // }, {
        //     name: 'Indarung V',
        //     color: '#0033cc',
        //     data: [100]
        // }, {
        //     name: 'Indarung V',
        //     color: '#EF4836',
        //     data: [100]
        // }
        // ]
        series: [{
            name: 'Indarung I',
            color: '#1E8BC3',
            data: datasub3000['P_3301']
        }, {
            name: 'Indarung II/III',
            color: '#E9D460',
            data: datasub3000['P_3302']
        }, {
            name: 'Indarung IV',
            color: '#EF4836',
            data: datasub3000['P_3303']
        }, {
            name: 'Indarung V',
            color: '#009933',
            data: datasub3000['P_3304']
        }, {
            name: 'Indarung V',
            color: '#0033cc',
            data: datasub3000['P_3309']
        }
        ]
    });
}

function graphicChartPerforma_Padang1(labels, datasub3000) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_totAllOpco1', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            // categories: [],
            categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        // series: [{
        //     name: 'Indarung I',
        //     color: '#1E8BC3',
        //     data: [100]
        // }, {
        //     name: 'Indarung II/III',
        //     color: '#E9D460',
        //     data: [100]
        // }, {
        //     name: 'Indarung IV',
        //     color: '#009933',
        //     data: [100]
        // }, {
        //     name: 'Indarung V',
        //     color: '#0033cc',
        //     data: [100]
        // }, {
        //     name: 'Indarung V',
        //     color: '#EF4836',
        //     data: [100]
        // }
        // ]
        series: [{
            name: 'Indarung I',
            color: '#1E8BC3',
            data: datasub3000['P_3301']
        }, {
            name: 'Indarung II/III',
            color: '#E9D460',
            data: datasub3000['P_3302']
        }, {
            name: 'Indarung IV',
            color: '#EF4836',
            data: datasub3000['P_3303']
        }, {
            name: 'Indarung V',
            color: '#009933',
            data: datasub3000['P_3304']
        }, {
            name: 'Indarung V',
            color: '#0033cc',
            data: datasub3000['P_3309']
        }
        ]
    });
}

function graphicChartPerforma_Gresik(labels, datasub7000) {
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_totAllOpco', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            // categories: [],
            categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Gresik',
            color: '#1E8BC3',
            data: datasub7000['P_7301']
        }, {
            name: 'Tuban I',
            color: '#E9D460',
            data: datasub7000['P_7302']
        }, {
            name: 'Tuban II',
            color: '#EF4836',
            data: datasub7000['P_7303']
        }, {
            name: 'Tuban III',
            color: '#009933',
            data: datasub7000['P_7304']
        }, {
            name: 'Tuban IV',
            color: '#0033cc',
            data: datasub7000['P_7305']
        }
        ]
    });
}

function graphicChartPerforma_Gresik1(labels, datasub70001){
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_totAllOpco1', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            // categories: [],
            categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Gresik',
            color: '#1E8BC3',
            data: datasub70001['P_7301']
        }, {
            name: 'Tuban I',
            color: '#E9D460',
            data: datasub70001['P_7302']
        }, {
            name: 'Tuban II',
            color: '#EF4836',
            data: datasub70001['P_7303']
        }, {
            name: 'Tuban III',
            color: '#009933',
            data: datasub70001['P_7304']
        }, {
            name: 'Tuban IV',
            color: '#0033cc',
            data: datasub70001['P_7305']
        }
        ]
    });
}

function graphicChartPerforma_Tonasa(labels, datasub4000){
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_totAllOpco', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            // categories: [],
            categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Tonasa II & III',
            color: '#1E8BC3',
            data: datasub4000['P_4301']
        }, {
            name: 'Tonasa IV',
            color: '#E9D460',
            data: datasub4000['P_4302']
        }, {
            name: 'Tonasa V',
            color: '#EF4836',
            data: datasub4000['P_4303']
        }
        ]
    });
}

function graphicChartPerforma_Tonasa1(labels, datasub40001){
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    Highcharts.chart('graphic_totAllOpco1', {
        chart: {
            type: 'column',
            spacingBottom: 8,
            spacingTop: 8,
            spacingLeft: 5,
            spacingRight: 5,
            backgroundColor: 'rgba(0, 255, 0, 0)',
            animation: Highcharts.svg
        },
        title: {
            text: ''
        },
        xAxis: {
            // categories: [],
            categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            tickInterval: 1,
            tickmarkPlacement: 'on',
            gridLineWidth: 1
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            shared: true
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'left',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Tonasa II & III',
            color: '#1E8BC3',
            data: datasub40001['P_4301']
        }, {
            name: 'Tonasa IV',
            color: '#E9D460',
            data: datasub40001['P_4302']
        }, {
            name: 'Tonasa V',
            color: '#EF4836',
            data: datasub40001['P_4303']
        }
        ]
    });
}


function opcoGroupNew(opco, sd, selectedLastYear) {
    // console.log(opco);
    // console.log(selectedLastYear);
    /* COMPARISON */
    var url3000 = url_ol + '/api/index.php/fin_cost/get_data_mview?date=' + sd + '&company=3000';
    var url4000 = url_ol + '/api/index.php/fin_cost/get_data_mview?date=' + sd + '&company=4000';
    var url7000 = url_ol + '/api/index.php/fin_cost/get_data_mview?date=' + sd + '&company=7000';
    var url30000 = url_ol + '/api/index.php/fin_cost/get_data_mview?date=' + selectedLastYear + '&company=3000';
    var url40000 = url_ol + '/api/index.php/fin_cost/get_data_mview?date=' + selectedLastYear + '&company=4000';
    var url70000 = url_ol + '/api/index.php/fin_cost/get_data_mview?date=' + selectedLastYear + '&company=7000';
    $.when(
        $.getJSON(url3000),
        $.getJSON(url4000),
        $.getJSON(url7000),
        $.getJSON(url30000),
        $.getJSON(url40000),
        $.getJSON(url70000)
    ).done(function (result3000, result4000, result7000, result30000, result40000, result70000) {
        // console.log('Data robi '+JSON.stringify(result3000));
        //COMPARISON CHART//
        totalCement = 0;
        totalClinker = 0;
        totalRKAPcement = 0;
        totalRKAPclinker = 0;
        totalCementLastYear = 0;
        totalClinkerLastYear = 0;

        /* Nampilkan Data JSON SEMEN INDONESIA */
        if (opco == 'smi') {
            dataCement('3000', result3000);
            dataCement('4000', result4000);
            dataCement('7000', result7000);
            dataCement1('3000', result30000);
            dataCement1('4000', result40000);
            dataCement1('7000', result70000);
        }
        /* Nampilkan Data JSON SEMEN PADANG */
        if (opco == '3000') {
            dataCement('3000', result3000);
            dataCement1('3000', result30000);
        }
        /* Nampilkan Data JSON SEMEN TONASA */
        if (opco == '4000') {
            dataCement('4000', result4000);
            dataCement1('4000', result40000);
        }
        /* Nampilkan Data JSON SEMEN GRESIK */
        if (opco == '7000') {
            dataCement('7000', result7000);
            dataCement1('7000', result70000);
        }

        var PersnCement = (totalCement / totalRKAPcement) * 100;
        var PersnClinker = (totalClinker / totalRKAPclinker) * 100;

        /* YOY = (Bulan ini Total - Bulan Tahun Lalu) */
        var YOY = (totalCement / totalCementLastYear) * 100;
        var YOYclinker = (totalClinker / totalClinkerLastYear) * 100;
        var realCement = totalCement;
        var realClinker = totalClinker;
        var RKAPcement = totalRKAPcement;
        var RKAPclinker = totalRKAPclinker;
        var CementLastYear = totalCementLastYear;
        var ClinkerLastYear = totalClinkerLastYear;
        if (PersnCement == Infinity) {
            PersnCement = 100;
        }
        if (PersnClinker == Infinity) {
            PersnClinker = 100;
        }

        /*==================================   SET HTML KE WEBSITE ================================= */
        $('#RealCementComp').html(setFormat(realCement));
        $('#RealClinkerComp').html(setFormat(realClinker));
        $('#RKAPCementComp').html(setFormat(RKAPcement));
        $('#RKAPClinkerComp').html(setFormat(RKAPclinker));
        $('#REALcementLastyear').html(setFormat(CementLastYear));
        $('#REALclinkerLastyear').html(setFormat(ClinkerLastYear));
        $('#perc3a').html(setFormat(PersnCement));
        $('#perc4a').html(setFormat(PersnClinker));
        $('#yoy_current_Cement').html(setFormat(YOY.toFixed(2)));
        $('#yoy_current_Clinker').html(setFormat(YOYclinker.toFixed(2)));
    });
}

function getPerformDataTable(opco, sd, labels) {
    var url3000 = url_ol + '/api/index.php/fin_cost/get_data_mview?date=' + sd + '&company=3000';
    var url4000 = url_ol + '/api/index.php/fin_cost/get_data_mview?date=' + sd + '&company=4000';
    var url7000 = url_ol + '/api/index.php/fin_cost/get_data_mview?date=' + sd + '&company=7000';
    $.when(
        $.getJSON(url3000),
        $.getJSON(url4000),
        $.getJSON(url7000)
    ).done(function (result3000, result4000, result7000) {

        totalCement = 0;
        totalClinker = 0;
        datas = {"actualcem": [], "actualclin": []};
        if (opco == 'smi') {
            SetDataPerItem('3000', result3000);
            SetDataPerItem('4000', result4000);
            SetDataPerItem('7000', result7000);
            // graphicChart_perform(labels, datas['actualcem']);
            // graphicChart_perform1(labels, datas['actualclin']);

            $('#cemPadang').html(setFormat(datas['actualcem'][0]));
            $('#ClinPadang').html(setFormat(datas['actualclin'][0]));
            $('#CemGresik').html(setFormat(datas['actualcem'][1]));
            $('#ClinkGresik').html(setFormat(datas['actualclin'][1]));
            $('#CemTonasa').html(setFormat(datas['actualcem'][2]));
            $('#ClinTonasa').html(setFormat(datas['actualclin'][2]));
            $('#nilaiTabelTotalCem').html(setFormat(totalCement));
            $('#nilaiTabelTotalClin').html(setFormat(totalClinker));

            // $('#cemPadang1').html(setFormat(datas['actualcem'][0]));
            // $('#ClinPadang1').html(setFormat(datas['actualclin'][0]));
            // $('#CemGresik1').html(setFormat(datas['actualcem'][1]));
            // $('#ClinkGresik1').html(setFormat(datas['actualclin'][1]));
            // $('#CemTonasa1').html(setFormat(datas['actualcem'][2]));
            // $('#ClinTonasa1').html(setFormat(datas['actualclin'][2]));
            // $('#plantCem3').html(setFormat(datas['actualcem'][3]));
            // $('#plantClin3').html(setFormat(datas['actualclin'][3]));
            // $('#plantCem4').html(setFormat(datas['actualcem'][4]));
            // $('#plantClin4').html(setFormat(datas['actualclin'][4]));
            // $('#nilaiTabelTotalCem1').html(setFormat(totalCement));
            // $('#nilaiTabelTotalClin1').html(setFormat(totalClinker));
        }
        if (opco == '3000') {
            SetDataPerItem1('3000', result3000);

            $('#CemenPadang1').html(setFormat(datas['actualcem'][0]));
            $('#ClinkerPadang1').html(setFormat(datas['actualclin'][0]));
            $('#CemenPadang2').html(setFormat(datas['actualcem'][1]));
            $('#ClinkerPadang2').html(setFormat(datas['actualclin'][1]));
            $('#CemenPadang4').html(setFormat(datas['actualcem'][2]));
            $('#ClinkerPadang4').html(setFormat(datas['actualclin'][2]));
            $('#CemenPadang5').html(setFormat(datas['actualcem'][3]));
            $('#ClinkerPadang5').html(setFormat(datas['actualclin'][3]));
            $('#CemenMillDumai').html(setFormat(datas['actualcem'][4]));
            $('#ClinkerMillDumai').html(setFormat(datas['actualclin'][4]));
            $('#totCemPadang').html(setFormat(totalCement));
            $('#totClinPadang').html(setFormat(totalClinker));

            // $('#CemenPadang1a').html(setFormat(datas['actualcem'][0]));
            // $('#ClinkerPadang1a').html(setFormat(datas['actualclin'][0]));
            // $('#CemenPadang2a').html(setFormat(datas['actualcem'][1]));
            // $('#ClinkerPadang2a').html(setFormat(datas['actualclin'][1]));
            // $('#CemenPadang4a').html(setFormat(datas['actualcem'][2]));
            // $('#ClinkerPadang4a').html(setFormat(datas['actualclin'][2]));
            // $('#CemenPadang5a').html(setFormat(datas['actualcem'][3]));
            // $('#ClinkerPadang5a').html(setFormat(datas['actualclin'][3]));
            // $('#CemenMillDumai1').html(setFormat(datas['actualcem'][4]));
            // $('#ClinkerMillDumai1').html(setFormat(datas['actualclin'][4]));
            // $('#totCemPadang1').html(setFormat(totalCement));
            // $('#totClinPadang1').html(setFormat(totalClinker));

        }
        if (opco == '4000') {
            SetDataPerItem1('4000', result4000);
            // graphicChart_Tonasa(labels, datas['actualcem']);
            // graphicChart_Tonasa1(labels, datas['actualclin']);
            $('#CemenTonasa2').html(setFormat(datas['actualcem'][0]));
            $('#ClinkerTonasa2').html(setFormat(datas['actualclin'][0]));
            $('#CmTonasa4').html(setFormat(datas['actualcem'][1]));
            $('#ClnTonasa4').html(setFormat(datas['actualclin'][1]));
            $('#CmtTonasa5').html(setFormat(datas['actualcem'][2]));
            $('#ClnTonasa5').html(setFormat(datas['actualclin'][2]));
            $('#totCemTonasa').html(setFormat(totalCement));
            $('#totClinTonasa').html(setFormat(totalClinker));

            // $('#CemenTonasa2a').html(setFormat(datas['actualcem'][0]));
            // $('#ClinkerTonasa2a').html(setFormat(datas['actualclin'][0]));
            // $('#CmTonasa4a').html(setFormat(datas['actualcem'][1]));
            // $('#ClnTonasa4a').html(setFormat(datas['actualclin'][1]));
            // $('#CmtTonasa5a').html(setFormat(datas['actualcem'][2]));
            // $('#ClnTonasa5a').html(setFormat(datas['actualclin'][2]));
            // $('#totCemTonasa1').html(setFormat(totalCement));
            // $('#totClinTonasa1').html(setFormat(totalClinker));
        }
        if (opco == '7000') {
            /* OPCO GRESIK */
            SetDataPerItem1('7000', result7000);
            $('#cemPadang').html(setFormat(datas['actualcem'][0]));
            $('#ClinPadang').html(setFormat());
            $('#CemGresik').html(setFormat(datas['actualcem'][1]));
            $('#ClinkGresik').html(setFormat(datas['actualclin'][0]));
            $('#CemTonasa').html(setFormat(datas['actualcem'][2]));
            $('#ClinTonasa').html(setFormat(datas['actualclin'][1]));
            $('#plantCem').html(setFormat(datas['actualcem'][3]));
            $('#plantClin').html(setFormat(datas['actualclin'][2]));
            $('#plantCeme').html(setFormat(datas['actualcem'][4]));
            $('#plantCline').html(setFormat(datas['actualclin'][3]));
            $('#nilaiTabelTotalCem').html(setFormat(totalCement));
            $('#nilaiTabelTotalClin').html(setFormat(totalClinker));

            // $('#cemPadang1').html(setFormat(datas['actualcem'][0]));
            // $('#ClinPadang1').html(setFormat());
            // $('#CemGresik1').html(setFormat(datas['actualcem'][1]));
            // $('#ClinkGresik1').html(setFormat(datas['actualclin'][0]));
            // $('#CemTonasa1').html(setFormat(datas['actualcem'][2]));
            // $('#ClinTonasa1').html(setFormat(datas['actualclin'][1]));
            // $('#plantCem1').html(setFormat(datas['actualcem'][3]));
            // $('#plantClin1').html(setFormat(datas['actualclin'][2]));
            // $('#plantCeme1').html(setFormat(datas['actualcem'][4]));
            // $('#plantCline1').html(setFormat(datas['actualclin'][3]));
            // $('#nilaiTabelTotalCem1').html(setFormat(totalCement));
            // $('#nilaiTabelTotalClin1').html(setFormat(totalClinker));
        }
        $(".se-pre-con").fadeOut("slow");

    });
}

function dataCement(opco, dataJson) {
    var tableVal = dataJson['0']['s' + opco]['0'];
    var cementActThisMonth = tableVal.act_bulan_ini.cement;
    var clinkerActThisMont = tableVal.act_bulan_ini.clinker;
    var RKAPCement = tableVal.rkap_bulan_ini.cement;
    var RKAPClinker = tableVal.rkap_bulan_ini.clinker;
    totalCement += cementActThisMonth;
    totalClinker += clinkerActThisMont;
    totalRKAPcement += RKAPCement;
    totalRKAPclinker += RKAPClinker;
}

function dataCement1(opco, dataJson) {
    var tableVal = dataJson['0']['s' + opco]['0'];
    var cementLastYear = tableVal.act_bulan_ini.cement;
    var clinkerLasYear = tableVal.act_bulan_ini.clinker;
    totalCementLastYear += cementLastYear;
    totalClinkerLastYear += clinkerLasYear;
}

function SetDataPerItem(opco, dataJson) {
    var tableVal = dataJson['0']['s' + opco]['0'];
    var actThisMonthCem = tableVal.act_bulan_ini.cement;
    var actThisMonthClin = tableVal.act_bulan_ini.clinker;
    // console.log(actThisMonthCem);
    datas['actualcem'].push(actThisMonthCem);
    datas['actualclin'].push(actThisMonthClin);
    totalCement += actThisMonthCem;
    totalClinker += actThisMonthClin;
}

function SetDataPerItem1(opco, dataJson) {
    var tableVal = dataJson['0']['s' + opco]['0'];
    totalCement = tableVal.act_bulan_ini.cement;
    totalClinker = tableVal.act_bulan_ini.clinker;
    var actThisMonthCem = tableVal.act_bulan_ini.opcosubcement;
    var actThisMonthClin = tableVal.act_bulan_ini.opcosubclinker;


    for (var i = 0; i < actThisMonthCem.length; i++) {
        datas['actualcem'].push(actThisMonthCem[i].JML);
    }
    for (var i = 0; i < actThisMonthClin.length; i++) {
        datas['actualclin'].push(actThisMonthClin[i].JML);
    }
}

// var datas2 = datasub2 = datasubs2 = new Array();
function getChartTabel(opco, labels, AngkaBulanSaja, yearnow) {

    var url30 = url_ol + '/api/index.php/fin_cost/get_data_mperform?year=' + yearnow + '&company=3000';
    var url40 = url_ol + '/api/index.php/fin_cost/get_data_mperform?year=' + yearnow + '&company=4000';
    var url70 = url_ol + '/api/index.php/fin_cost/get_data_mperform?year=' + yearnow + '&company=7000';
    var urlSMI = url_ol + '/api/index.php/fin_cost/get_data_mperform?year=' + yearnow + '&company=smi';
    $.when(
        $.getJSON(url30),
        $.getJSON(url40),
        $.getJSON(url70),
        $.getJSON(urlSMI)
    ).done(function (result30, result40, result70, resultSMI) {

         ajsCem = 0;
         ajsClin =0;
        if (opco == 'smi') {
            datasProdOpco = {"3000": [], "4000": [], "7000": []};
            datasProdOpco1 = {"3000": [], "4000": [], "7000": []};
            plotOpcoCementClinker('3000', AngkaBulanSaja, result30);
            plotOpcoCementClinker('4000', AngkaBulanSaja, result40);
            plotOpcoCementClinker('7000', AngkaBulanSaja, result70);

            plotOpcoCementClinker1('3000', AngkaBulanSaja, result30);
            plotOpcoCementClinker1('4000', AngkaBulanSaja, result40);
            plotOpcoCementClinker1('7000', AngkaBulanSaja, result70);
            plotCementClinker('smi', AngkaBulanSaja, resultSMI);
            graphicChart_CemCli_SMI(labels, datasProd);
            graphicChart_CemCli_Opco(labels, datasProdOpco);
            graphicChart_CemCli_Opco1(labels, datasProdOpco1);
        }
        if (opco == '3000') {
            datasub2 = [];
            datasub3 = [];
            datasub3000 = {"P_3301":[], "P_3302":[], "P_3303":[], "P_3304":[], "P_3309":[]};
            datasub30001 = {"P_3301":[], "P_3302":[], "P_3303":[], "P_3304":[], "P_3309":[]};
            plotCementClinker('3000', AngkaBulanSaja, result30);
            plotOpcoCementClinkerPADANG('3000', AngkaBulanSaja, result30);
            plotOpcoCementClinkerPADANG1('3000', AngkaBulanSaja, result30);
            graphicChart_CemCli_SMI(labels, datasProd);
            graphicChartPerforma_Padang(labels, datasub3000);
            graphicChartPerforma_Padang1(labels, datasub30001);

        }
        if (opco == '4000') {
            datasub2 = [];
            datasub3 = [];
            datasub4000 = {"P_4301":[], "P_4302":[], "P_4303":[]};
            datasub40001 = {"P_4301":[], "P_4302":[], "P_4303":[]};
            plotCementClinker('4000', AngkaBulanSaja, result40);
            graphicChart_CemCli_SMI(labels, datasProd);
            plotOpcoCementClinkerPADANG('4000', AngkaBulanSaja, result40);
            plotOpcoCementClinkerPADANG1('4000', AngkaBulanSaja, result40);
            graphicChartPerforma_Tonasa(labels, datasub4000);
            graphicChartPerforma_Tonasa1(labels, datasub40001);

        }
        if (opco == '7000') {
            datasub2 = [];
            datasub3 = [];
            datasub7000 = {"P_7301":[], "P_7302":[], "P_7303":[], "P_7304":[], "P_7305":[]};
            datasub70001 = {"P_7301":[], "P_7302":[], "P_7303":[], "P_7304":[], "P_7305":[]};
            plotCementClinker('7000', AngkaBulanSaja, result70);
            plotOpcoCementClinkerPADANG('7000', AngkaBulanSaja, result70);
            plotOpcoCementClinkerPADANG1('7000', AngkaBulanSaja, result70);
            graphicChart_CemCli_SMI(labels, datasProd);
            graphicChartPerforma_Gresik(labels, datasub7000);
            graphicChartPerforma_Gresik1(labels, datasub70001);
        }
        $(".se-pre-con").fadeOut("slow");
    });

}

function plotCementClinker(opco, AngkaBulanSaja, dataJson) {
    var satuanBulan;
    if (AngkaBulanSaja != 10){
        satuanBulan = AngkaBulanSaja.replace("0","");
    }else {
        satuanBulan = 10;
    }
    datasProd = {"cement": [], "clinker": []};
    var tableVal = dataJson['0']['s' + opco]['0'];
    for (var i = 1; i<= satuanBulan; i++) {
        ajsCem = tableVal.act_tahun_ini[i].cement;
        ajsClin = tableVal.act_tahun_ini[i].clinker;
        datasProd['cement'].push(ajsCem);
        datasProd['clinker'].push(ajsClin);
    }


}

function plotOpcoCementClinker(opco, AngkaBulanSaja, dataJson) {
    var satuanBulan1;
    if (AngkaBulanSaja != 10){
        satuanBulan1 = AngkaBulanSaja.replace("0","");
    }else {
        satuanBulan = 10;
    }
    var tableVal = dataJson['0']['s'+opco]['0'];
    for (var i = 1; i<= satuanBulan1; i++) {
        OpcoCement = tableVal.act_tahun_ini[i].cement;
        datasProdOpco[opco].push(OpcoCement);
    }


}

function plotOpcoCementClinkerPADANG(opco, AngkaBulanSaja, dataJson) {
    var satuanBulan1;
    if (AngkaBulanSaja != 10){
        satuanBulan1 = AngkaBulanSaja.replace("0","");
    }else {
        satuanBulan1 = 10;
    }
    var tableVal = dataJson['0']['s'+opco]['0'];
    for (var i = 1; i<= satuanBulan1; i++) {
        OpcoCement = tableVal.act_tahun_ini[i].opcosubcement;
        datasub2.push(OpcoCement);
    }

    for(var j=0;j<datasub2.length;j++){
        for(var y=0;y<datasub2[j].length;y++){
            if(opco=='3000'){
                datasub3000[datasub2[j][y].PLANT].push(datasub2[j][y].JML);
            }
            if(opco=='4000'){
                datasub4000[datasub2[j][y].PLANT].push(datasub2[j][y].JML);
            }
            if(opco=='7000'){
                datasub7000[datasub2[j][y].PLANT].push(datasub2[j][y].JML);
            }
        }
    }


}

function plotOpcoCementClinkerPADANG1(opco, AngkaBulanSaja, dataJson) {
    var satuanBulan1;
    if (AngkaBulanSaja != 10){
        satuanBulan1 = AngkaBulanSaja.replace("0","");
    }else {
        satuanBulan1 = 10;
    }
    var tableVal = dataJson['0']['s'+opco]['0'];
    for (var i = 1; i<= satuanBulan1; i++) {
        OpcoClinker = tableVal.act_tahun_ini[i].opcosubclinker;
        datasub3.push(OpcoClinker);
    }

    console.log(datasub3);
    for(var j=0;j<datasub3.length;j++){
        for(var y=0;y<datasub3[j].length;y++){
            if(opco=='3000'){
                datasub30001[datasub3[j][y].PLANT].push(datasub3[j][y].JML);
            }
            if(opco=='4000'){
                datasub40001[datasub3[j][y].PLANT].push(datasub3[j][y].JML);
            }
            if(opco=='7000'){
                datasub70001[datasub3[j][y].PLANT].push(datasub3[j][y].JML);
            }
        }
    }


}


function plotOpcoCementClinker1(opco, AngkaBulanSaja, dataJson) {
    var satuanBulan1;
    if (AngkaBulanSaja != 10){
        satuanBulan1 = AngkaBulanSaja.replace("0","");
    }else {
        satuanBulan1 = 10;
    }
    var tableVal = dataJson['0']['s'+opco]['0'];
    for (var i = 1; i<= satuanBulan1; i++) {
        OpcoCement = tableVal.act_tahun_ini[i].clinker;
        datasProdOpco1[opco].push(OpcoCement);
    }


}


function back_() {
    if (getParam('opco') == 7000) {
        window.location.href = 'fin_cost_str_sg.html';
    } else if (getParam('opco') == 3000) {
        window.location.href = 'fin_cost_str_sp.html';
    } else if (getParam('opco') == 4000) {
        window.location.href = 'fin_cost_str_st.html';
    } else if (getParam('opco') == 6000) {
        window.location.href = 'fin_cost_str_tl.html';
    }
}


function cost_data(bulan, opco, yearnow) {
    run_waitMe('.wrapper', 'ios');
    var d = new Date();
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";


    $('#tag_ly1').html('Real ' + (yearnow - 1));
    $('#tag_ly2').html('Real ' + (yearnow - 1));
    $('#tag_ly3').html('Real ' + (yearnow - 1));
    $('#tag_ly4').html('Real ' + (yearnow - 1));


    // var param = (opco!='SMI')?'&company='+opco:'';
    var param = (opco != 'SMI') ? '&company=' + opco : '';
    $('#tag_current_cost').html(month[bulan - 1]);
    $('#tag_current_cost1').html(month[bulan - 1]);
    $('#tag_current_cost2').html(month[bulan - 1]);
    $('#tag_current_cost3').html(month[bulan - 1]);
    $('#tag_current_cost4').html(month[bulan - 1]);
    $('#tag_current_cost5').html(month[bulan - 1]);
    $('#tag_current_cost6').html(month[bulan - 1]);
    $('#tag_current_cost7').html(month[bulan - 1]);
    $('#tag_current_cost8').html(month[bulan - 1]);


    $('#ton_tag_current_cost').html(month[bulan - 1]);
    $('#ton_tag_current_cost1').html(month[bulan - 1]);
    $('#ton_tag_current_cost2').html(month[bulan - 1]);
    $('#ton_tag_current_cost3').html(month[bulan - 1]);
    $('#ton_tag_current_cost4').html(month[bulan - 1]);
    $('#ton_tag_current_cost5').html(month[bulan - 1]);
    $('#ton_tag_current_cost6').html(month[bulan - 1]);
    $('#ton_tag_current_cost7').html(month[bulan - 1]);
    $('#ton_tag_current_cost8').html(month[bulan - 1]);

    $('#ton_tag_last_cost').html('Up to ' + month[bulan - 1]);
    $('#ton_tag_past_cost').html(month[11] + ' ' + (tahun - 1));
    $('#ton_tag_chart_curr').html(month[bulan - 1]);
    $('#ton_tag_chart_past').html(month[bulan - 2]);

    $.post(url_src + '/api/index.php/cost_structure/get_data_mview?date=' + yearnow + '.' + bulan + param, function (data) {

        stop_waitMe('.wrapper');


    }).fail(function () {
            //alert("Gagal konek DB");
            stop_waitMe('.wrapper');
        }
    );

}