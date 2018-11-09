$(function () {
	
	
$.ajax({
		
			url:"http://10.15.5.150/dev/par4digma/api/index.php/pusb/project",
		type:"GET",					
		  success: function(data){
	      var data = eval('(' + data + ')');
	      console.log(data);
			
			//$("#oke").html(jumlah);
			alert('yes');
		
			}

	});	
				


    Highcharts.chart('container_pusb', {
		

        chart: {
            type: 'solidgauge',
            marginTop: 0,

			
        },

        title: {
            text: '',
            style: {
                fontSize: '24px'
            }
        },

        tooltip: {
            borderWidth: 0,
            backgroundColor: 'none',
            shadow: false,
            style: {
                fontSize: '9px'
            },
            pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}%</span>',
            positioner: function (labelWidth) {
                return {
                    x: 58 - labelWidth / 2,
                    y: 10
                };
            }
        },

        pane: {
            startAngle: 0,
            endAngle: 360,
            background: [{ // Track for Move
                
                outerRadius: '110%',
                innerRadius: '90%',
                backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0.3).get(),
                borderWidth: 0
            },]
        },

        yAxis: {
            min: 0,
            max: 100,
            lineWidth: 0,
            tickPositions: []
        },

        plotOptions: {
            solidgauge: {
                borderWidth: '10px',
                dataLabels: {
                    enabled: false
                },
                linecap: 'round',
                stickyTracking: false
            }
        },

        series: [{
            name: ' ',
            borderColor: Highcharts.getOptions().colors[0],
            data: [{
                color: Highcharts.getOptions().colors[0],
                radius: '100%',
                innerRadius: '100%',
                y: 90
            }]
        }
		]
    },
	
  function callback() {

      

    });


    Highcharts.chart('container_pusb2', {
		

        chart: {
            type: 'solidgauge',
            marginTop: 0,

			
        },

        title: {
            text: '',
            style: {
                fontSize: '24px'
            }
        },

        tooltip: {
            borderWidth: 0,
            backgroundColor: 'none',
            shadow: false,
            style: {
                fontSize: '9px'
            },
            pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}%</span>',
            positioner: function (labelWidth) {
                return {
                    x: 58 - labelWidth / 2,
                    y: 10
                };
            }
        },

        pane: {
            startAngle: 0,
            endAngle: 360,
            background: [{ // Track for Move
                
                outerRadius: '110%',
                innerRadius: '90%',
                backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[2]).setOpacity(0.3).get(),
                borderWidth: 0
            },]
        },

        yAxis: {
            min: 0,
            max: 100,
            lineWidth: 0,
            tickPositions: []
        },

        plotOptions: {
            solidgauge: {
                borderWidth: '10px',
                dataLabels: {
                    enabled: false
                },
                linecap: 'round',
                stickyTracking: false
            }
        },

        series: [{
            name: ' ',
            borderColor: Highcharts.getOptions().colors[2],
            data: [{
                color: Highcharts.getOptions().colors[2],
                radius: '100%',
                innerRadius: '100%',
                y: 40
            }]
        }
		]
    },

    /**
     * In the chart load callback, add icons on top of the circular shapes
     */
    function callback() {

      

    });
	
	  Highcharts.chart('container_pusb3', {
		

        chart: {
            type: 'solidgauge',
            marginTop: 0,

			
        },

        title: {
            text: '',
            style: {
                fontSize: '24px'
            }
        },

        tooltip: {
            borderWidth: 0,
            backgroundColor: 'none',
            shadow: false,
            style: {
                fontSize: '9px'
            },
            pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}%</span>',
            positioner: function (labelWidth) {
                return {
                    x: 58 - labelWidth / 2,
                    y: 10
                };
            }
        },

        pane: {
            startAngle: 0,
            endAngle: 360,
            background: [{ // Track for Move
                
                outerRadius: '110%',
                innerRadius: '90%',
                backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[3]).setOpacity(0.3).get(),
                borderWidth: 0
            },]
        },

        yAxis: {
            min: 0,
            max: 100,
            lineWidth: 0,
            tickPositions: []
        },

        plotOptions: {
            solidgauge: {
                borderWidth: '10px',
                dataLabels: {
                    enabled: false
                },
                linecap: 'round',
                stickyTracking: false
            }
        },

        series: [{
            name: ' ',
            borderColor: Highcharts.getOptions().colors[3],
            data: [{
                color: Highcharts.getOptions().colors[3],
                radius: '100%',
                innerRadius: '100%',
                y: 40
            }]
        }
		]
    },

    /**
     * In the chart load callback, add icons on top of the circular shapes
     */
    function callback() {

      

    });


});
