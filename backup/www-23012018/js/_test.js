$(function () {
    $('#vibrasi').highcharts({
        chart: {
            type: 'gauge',
        },
        title: {
            text: 'KILN'
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '103%',
                    innerRadius: '103%'
                }]
        },
        yAxis: {
            min: 0,
            max: 20,
            labels: {
                rotation: 'auto'
            },
            title: {
                text: 'mm/s'
            },
            plotBands: [{
                    from: 0,
                    to: 15,
                    color: '#DF5353', // green
                    innerRadius: 69,
                    outerRadius: 100
                }, {
                    from: 15,
                    to: 20,
                    color: '#55BF3B', // red
                    innerRadius: 69,
                    outerRadius: 100
                }],
        },
        series: [{
                name: 'Speed',
                data: [5],
                tooltip: {
                    valueSuffix: 'mm/s'
                }
            }]

    });
    $('#ampere').highcharts({
        chart: {
            type: 'gauge',
        },
        title: {
            text: 'KILN'
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '103%',
                    innerRadius: '103%'
                }]
        },
        yAxis: {
            min: 0,
            max: 100,
            labels: {
                rotation: 'auto'
            },
            title: {
                text: 'Amp'
            },
            plotBands: [{
                    from: 0,
                    to: 75,
                    color: '#DF5353', // green
                    innerRadius: 69,
                    outerRadius: 100
                }, {
                    from: 75,
                    to: 100,
                    color: '#55BF3B', // red
                    innerRadius: 69,
                    outerRadius: 100
                }],
        },
        series: [{
                name: 'Speed',
                data: [5],
                tooltip: {
                    valueSuffix: 'Amp'
                }
            }]

    });
    $('#temperature').highcharts({
        chart: {
            type: 'gauge',
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: 'none',
                    borderWidth: 0,
                    outerRadius: '103%',
                    innerRadius: '103%'
                }]
        },
        yAxis: {
            min: 0,
            max: 100,
            labels: {
                rotation: 'auto'
            },
            title: {
                text: 'mm/s'
            },
            plotBands: [{
                    from: 0,
                    to: 15,
                    color: '#DF5353', // green
                    innerRadius: 69,
                    outerRadius: 100
                }, {
                    from: 15,
                    to: 20,
                    color: '#55BF3B', // red
                    innerRadius: 69,
                    outerRadius: 100
                }],
        },
        series: [{
                name: 'Speed',
                data: [5],
                tooltip: {
                    valueSuffix: 'mm/s'
                }
            }]

    });
});