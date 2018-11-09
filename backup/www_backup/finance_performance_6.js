function onLoad() {
   
                $(".burger-menu").click(function (e) {
                    if ($(this).hasClass("is-active")) {
                        $(this).removeClass("is-active");
                        $("#content").removeClass("slideMenu");
                        $("#content").addClass("closeMenu");
                    } else {
                        $(this).addClass("is-active");
                        $("#content").removeClass("closeMenu");
                        $("#content").addClass("slideMenu");
                    }
                });
            
loadData(url_src+'/api/index.php/f_performance/get_priceyear?bulan=05&tahun=2016','7000');
loadData_st(url_src+'/api/index.php/f_performance/get_priceyear_st?bulan=05&tahun=2016','7000');
loadData_sp(url_src+'/api/index.php/f_performance/get_priceyear_sp?bulan=05&tahun=2016','7000');	
loadData_tlcc(url_src+'/api/index.php/f_performance/get_priceyear_tlcc?bulan=05&tahun=2016','7000');		
function loadData(datasrc, id){
 run_waitMe('.wrapper','facebook');
 // run_waitMe('#data-sminas','facebook');  
         //console.log(datasrc);
  
      $.ajax({
		url: datasrc,
		type :'GET',
		success: function(data){
	  
   var logdata = JSON.parse(data);
       
	
	var FISCAL_YEAR_PERIOD='-';
	var HARGACT=0;
	var HARGALAST=0;
	var HARGATARGET=0;
	//var eat_fiscal_year_period='';
		
	var datapriceact=[];
	var datapricetarget=[];
    
		
	for (var i=0;i< logdata.length;i++)
	{
		//if (logdata[i].FISCAL_YEAR_PERIOD=='EBITDA')
		//{
			HARGACT += parseFloat(logdata[i].HARGACT);
			HARGATARGET += parseFloat(logdata[i].HARGATARGET);
			
			datapriceact.push(HARGACT);
			datapricetarget.push(HARGATARGET);
		//}
		
							
		
	}
	
  chart_sg(datapriceact,datapricetarget);
  stop_waitMe('.wrapper');
  }

})

  }
 

function loadData_st(datasrc, id){

 // run_waitMe('#data-sminas','facebook');  
         //console.log(datasrc);
  
      $.ajax({
		url: datasrc,
		type :'GET',
		success: function(data){
	  
   var logdata = JSON.parse(data);
       
	
	var FISCAL_YEAR_PERIOD='-';
	var HARGACT=0;
	var HARGALAST=0;
	var HARGATARGET=0;
	//var eat_fiscal_year_period='';
		
	var datapriceact=[];
	var datapricetarget=[];
    
		
	for (var i=0;i< logdata.length;i++)
	{
		//if (logdata[i].FISCAL_YEAR_PERIOD=='EBITDA')
		//{
			HARGACT += parseFloat(logdata[i].HARGACT);
			HARGATARGET += parseFloat(logdata[i].HARGATARGET);
			
			datapriceact.push(HARGACT);
			datapricetarget.push(HARGATARGET);
		//}
		
							
		
	}
	
  chart_st(datapriceact,datapricetarget);
  }

})

  }
function loadData_sp(datasrc, id){

 // run_waitMe('#data-sminas','facebook');  
         //console.log(datasrc);
  
      $.ajax({
		url: datasrc,
		type :'GET',
		success: function(data){
	  
   var logdata = JSON.parse(data);
       
	
	var FISCAL_YEAR_PERIOD='-';
	var HARGACT=0;
	var HARGALAST=0;
	var HARGATARGET=0;
	//var eat_fiscal_year_period='';
		
	var datapriceact=[];
	var datapricetarget=[];
    
		
	for (var i=0;i< logdata.length;i++)
	{
		//if (logdata[i].FISCAL_YEAR_PERIOD=='EBITDA')
		//{
			HARGACT += parseFloat(logdata[i].HARGACT);
			HARGATARGET += parseFloat(logdata[i].HARGATARGET);
			
			datapriceact.push(HARGACT);
			datapricetarget.push(HARGATARGET);
		//}
		
							
		
	}
	
  chart_sp(datapriceact,datapricetarget);
  }

})

  }

function loadData_tlcc(datasrc, id){

 // run_waitMe('#data-sminas','facebook');  
         //console.log(datasrc);
  
      $.ajax({
		url: datasrc,
		type :'GET',
		success: function(data){
	  
   var logdata = JSON.parse(data);
       
	
	var FISCAL_YEAR_PERIOD='-';
	var HARGACT=0;
	var HARGALAST=0;
	var HARGATARGET=0;
	//var eat_fiscal_year_period='';
		
	var datapriceact=[];
	var datapricetarget=[];
    
		
	for (var i=0;i< logdata.length;i++)
	{
		//if (logdata[i].FISCAL_YEAR_PERIOD=='EBITDA')
		//{
			HARGACT += parseFloat(logdata[i].HARGACT);
			HARGATARGET += parseFloat(logdata[i].HARGATARGET);
			
			datapriceact.push(HARGACT);
			datapricetarget.push(HARGATARGET);
		//}
		
							
		
	}
	
  chart_tlcc(datapriceact,datapricetarget);
  
  }

})

  }  
  
function chart_sg(datapriceact,datapricetarget)
{

    Highcharts.chart('sg_asp', {
        title: {
            text: '',
            x: -20 //center
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
       
        series: [{
            name: 'ACTUAL',
            data: datapriceact
        }, {
            name: 'BUDGET',
            data: datapricetarget
        }]
    });
    
       
    
       
}		
function chart_st(datapriceact,datapricetarget)
{
	
        Highcharts.chart('st_asp', {
        title: {
            text: '',
            x: -20 //center
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
       
        series: [{
            name: 'ACTUAL',
            data: datapriceact
        }, {
            name: 'BUDGET',
            data: datapricetarget
        }]
    });
    
}
function chart_sp(datapriceact,datapricetarget)
{
	 Highcharts.chart('sp_asp', {
        title: {
            text: '',
            x: -20 //center
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
       
        series: [{
            name: 'ACTUAL',
            data: datapriceact
        }, {
            name: 'BUDGET',
            data: datapricetarget
        }]
    });
}
function chart_tlcc(datapriceact,datapricetarget)
{
	 Highcharts.chart('tlcc_asp', {
        title: {
            text: '',
            x: -20 //center
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
       
        series: [{
            name: 'ACTUAL',
            data: datapriceact
        }, {
            name: 'BUDGET',
            data: datapricetarget
        }]
    });
}

}
			

/* $(function () {
}); */