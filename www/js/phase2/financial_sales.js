function numberFormat(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function setParam(opco, selyear, selmonth){
	var comp, plant, ttl;
	$(".imgsi").css({width:"130px", "margin-bottom":"0"});
	if(opco=="3000"){
		comp=1;
		ttl="Semen Padang";
	}else if(opco=="7000"){
		comp=5;
		ttl="Semen Indonesia";
	}else if(opco=="5000"){
		comp=3;
		ttl="Semen Gresik";
	}else if(opco=="4000"){
		comp=2;
		ttl="Semen Tonasa";
	}else{
		comp=4;
		ttl="Thang Long";
	}
	$(".planttittle").html(ttl)
	$("#title_chart").html("Total "+ttl);

	// GET COMPARE DATA
    var save_data_sales_rev=JSON.parse(sessionStorage.getItem("data_sales_rev"+selyear+selmonth));
	var save_data_sales_vol=JSON.parse(sessionStorage.getItem("data_sales_vol"+selyear+selmonth));
	if(save_data_sales_rev&&save_data_sales_vol){
		viewArea(comp, save_data_sales_rev, save_data_sales_vol);
        stop_waitMe('.wrapper');
	}else{
    	run_waitMe('.wrapper', 'ios');
		var Url1 = $.getJSON('http://par4digma.semenindonesia.com/api/index.php/finance_sales/show_rev?time='+selyear+'.'+selmonth+'&typ=V2', function(data_rev){
		// var Url1 = $.getJSON('http://10.15.5.150/dev/par4digma/api/index.php/finance_sales/show_rev?time='+selyear+'.'+selmonth+'&typ=V2', function(data_rev){
			sessionStorage.setItem("data_sales_rev"+selyear+selmonth, JSON.stringify(data_rev));
            var Url2 = $.getJSON('http://par4digma.semenindonesia.com/api/index.php/finance_sales/show_vol?time='+selyear+'.'+selmonth+'&typ=V2', function(data_vol){
            // var Url2 = $.getJSON('http://10.15.5.150/dev/par4digma/api/index.php/finance_sales/show_vol?time='+selyear+'.'+selmonth+'&typ=V2', function(data_vol){
                sessionStorage.setItem("data_sales_vol"+selyear+selmonth, JSON.stringify(data_vol));
                viewArea(comp, data_rev, data_vol);
                stop_waitMe('.wrapper');
            });
		});
	}
    $('.se-pre-con').fadeOut();
}

function viewArea(comp, data_rev, data_vol){

    var dataChartCementRev=parseFloat(data_rev[1].children[comp].children[0]["F3"]);
    var dataChartClinkerRev=parseFloat(data_rev[1].children[comp].children[1]["F3"]);

    var dataChartCementVol=parseFloat(data_vol[1].children[comp].children[0]["F3"]);
    var dataChartClinkerVol=parseFloat(data_vol[1].children[comp].children[1]["F3"]);

    $("#target_rkap_rev").html(numberFormat(data_rev[1].children[comp]["F2"]));
    $("#target_actual_rev").html(numberFormat(data_rev[1].children[comp]["F3"]));
	$("#achievement_rev").html(numberFormat(data_rev[1].children[comp]["F8"]));
    $("#target_rkap_vol").html(numberFormat(data_vol[1].children[comp]["F2"]));
    $("#target_actual_vol").html(numberFormat(data_vol[1].children[comp]["F3"]));
    $("#achievement_vol").html(numberFormat(data_vol[1].children[comp]["F8"]));

    Highcharts.chart('graphic_compare_rev', {
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
            categories:[1,2,3,4,5,6,7,8,9,10,11,12],
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
            align: 'center',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series:[{
            name:"Cement",
            color:"#1d8bc3",
            data:[dataChartCementRev]
        },{
            name:"Clinker",
            color:"#f04736",
            data:[dataChartClinkerRev]
        }]
    });

    Highcharts.chart('graphic_compare_vol', {
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
            categories:[1,2,3,4,5,6,7,8,9,10,11,12],
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
            align: 'center',
            verticalAlign: 'bottom',
            x: 0,
            y: 0,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            // shadow: true
        },
        credits: {
            enabled: false
        },
        series:[{
            name:"Cement",
            color:"#1d8bc3",
            data:[dataChartCementVol]
        },{
            name:"Clinker",
            color:"#f04736",
            data:[dataChartClinkerVol]
        }]
    });
}
