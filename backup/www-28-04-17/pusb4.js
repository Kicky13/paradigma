$(function () {
	   
		run_waitMe('#container_pusb', 'ios');
        run_waitMe('#container_pusb2', 'ios');
        run_waitMe('#container_pusb3', 'ios');
$.ajax({
		
		url:url_src+"/api/index.php/pusb/Project1",
		type:"GET",					
		dataType    : "json",
		  success: function(data){
			  
		
		myJSON = JSON.stringify(data);
		localStorage.setItem("testJSON", myJSON);
		
		text = localStorage.getItem("testJSON");
		obj = JSON.parse(text);
		
		console.log(data);
        console.log(obj);
		
		 
		if(obj.persen_1)		
		{
			 var per=Number(obj.persen_1);
			 var kde=Number(obj.kode_1);
			 var jml=Number(obj.jumlah_1);
		}
		
		if(obj.persen_2)		
		{
			
			 var per2=Number(obj.persen_2);
			 var kde2=Number(obj.kode_2);
			 var jml2=Number(obj.jumlah_2);
		}
		
		if(obj.persen_3)		
		{
			 var per3=Number(obj.persen_3);
			 var kde3=Number(obj.kode_3);
			 var jml3=Number(obj.jumlah_3);
		}
		
		
		
		
		
			
			
    stop_waitMe('#container_pusb');
      $('#container_pusb').highcharts({
		

        chart: {
            type: 'solidgauge',
            marginTop: 0,

			
        },

 credits: {
      enabled: false
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
            pointFormat: '',
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
                    enabled: true,borderWidth: 0,
					  format:' {series.name}<br><span style="font-size:19px;border:10px; color: {point.color}; font-weight: bold">{point.y}%  <br> {point.z}  Project</span>'
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
                y: per,
                z: jml
            }]
        }
		]
    },
	
  function callback() {

      

    });


    stop_waitMe('#container_pusb2');
      $('#container_pusb2').highcharts({
		

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
 credits: {
      enabled: false
  },
        tooltip: {
            borderWidth: 0,
            backgroundColor: 'none',
            shadow: false,
            style: {
                fontSize: '9px'
            },
            pointFormat: '',
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
                    enabled:  true,borderWidth: 0,
					  format:' {series.name}<br><span style="font-size:19px;border:10px; color: {point.color}; font-weight: bold">{point.y}%  <br> {point.z} Project </span>'
                },
                linecap: 'round',
                stickyTracking: false
            }
        },
 credits: {
      enabled: false
  },
        series: [{
            name: ' ',
            borderColor: Highcharts.getOptions().colors[2],
            data: [{
                color: Highcharts.getOptions().colors[2],
                radius: '100%',
                innerRadius: '100%',
                 y: per2,
				 z: jml2
            }]
        }
		]
    },

    /**
     * In the chart load callback, add icons on top of the circular shapes
     */
    function callback() {

      

    });
	
    stop_waitMe('#container_pusb3');
	  $('#container_pusb3').highcharts({
		

        chart: {
            type: 'solidgauge',
            marginTop: 0,

			
        },

        title: {
            text: '',
            style: {
                fontSize: '24px',
				
            }
        },

        tooltip: {
			
            borderWidth: 0,
            backgroundColor: 'none',
            shadow: false,
            style: {
                fontSize: '9px'
            },
            pointFormat: '',
            positioner: function (labelWidth) {
                return {
                    x: 58 - labelWidth / 2,
                    y: 10
                };
            }
        },
 credits: {
      enabled: false
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
                    enabled: true,borderWidth: 0,
					  format:' {series.name}<br><span style="font-size:19px;border:10px; color: {point.color}; font-weight: bold">{point.y}% <br> {point.z} Project</span>'
        
                },
                linecap: 'round',
                stickyTracking: false
            },
        },

        series: [{
            name: ' ',
            borderColor: Highcharts.getOptions().colors[3],
            data: [{
                color: Highcharts.getOptions().colors[3],
                radius: '100%',
                innerRadius: '100%',
                 y: per3,
				 z: jml3
				
            }]
        }
		]
    },

    /**
     * In the chart load callback, add icons on top of the circular shapes
     */
    function callback() {

      

    });

	}

	});	
		
	 stop_waitMe('.wrapper');	
});
