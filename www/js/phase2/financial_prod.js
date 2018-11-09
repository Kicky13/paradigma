function setParam(opco, selyear, selmonth){
	var comp, plant, ttl;
	$(".imgsi").css({width:"130px", "margin-bottom":"0"});
	if(opco=="3000"){
		comp=12;
		plant=5;
		ttl="Semen Padang";
	}else if(opco=="7000"){
		comp=27;
		plant=5;
		ttl="Semen Indonesia";
	}else if(opco=="5000"){
		comp=20;
		plant=3;
		ttl="Semen Gresik";
	}else if(opco=="4000"){
		comp=16;
		plant=3;
		ttl="Semen Tonasa";
	}else{
		comp=28;
		ttl="";
		$(".imgsi").css({width:"220px", "margin-bottom":"-10px"});
	}
	$(".planttittle").html(ttl)
	$("#title_chart").html("Total "+ttl);

	// GET COMPARE DATA
	var save_data_cement=JSON.parse(sessionStorage.getItem("data_cement"+selyear+selmonth));
	var save_data_clinker=JSON.parse(sessionStorage.getItem("data_clinker"+selyear+selmonth));
	if(save_data_cement&&save_data_clinker){
		compareArea(comp, plant, save_data_cement, save_data_clinker);
	}else{
    	run_waitMe('.wrapper', 'ios');
		var Url = $.getJSON('http://par4digma.semenindonesia.com/api/index.php/finance_prod/show_cement?time='+selyear+'.'+selmonth, function(data_cement){
		// var Url1 = $.getJSON('http://10.15.5.150/dev/par4digma/api/index.php/finance_prod/show_cement?time='+selyear+'.'+selmonth, function(data_cement){
			sessionStorage.setItem("data_cement"+selyear+selmonth, JSON.stringify(data_cement));
			var Url = $.getJSON('http://par4digma.semenindonesia.com/api/index.php/finance_prod/show_clinker?time='+selyear+'.'+selmonth, function(data_clinker){
			// var Url2 = $.getJSON('http://10.15.5.150/dev/par4digma/api/index.php/finance_prod/show_clinker?time='+selyear+'.'+selmonth, function(data_clinker){
				sessionStorage.setItem("data_clinker"+selyear+selmonth, JSON.stringify(data_clinker));
				compareArea(comp, plant, data_cement, data_clinker);
				stop_waitMe('.wrapper');
			});
		});
	}

	// GET PERFORM DATA
	var save_data_cement_perform=JSON.parse(sessionStorage.getItem("data_cement_perform"+selyear+selmonth));
	var save_data_clinker_perform=JSON.parse(sessionStorage.getItem("data_clinker_perform"+selyear+selmonth));
	if(save_data_cement_perform&&save_data_clinker_perform){
		chart_perform(opco, comp, plant, save_data_cement_perform, save_data_clinker_perform);
	}else{
    	run_waitMe('.wrapper', 'ios');
		var Url = $.getJSON('http://par4digma.semenindonesia.com/api/index.php/finance_prod/show_perform_cement?year='+selyear, function(data_cement){
		// var Url3 = $.getJSON('http://10.15.5.150/dev/par4digma/api/index.php/finance_prod/show_perform_cement?year='+selyear, function(data_cement){
			sessionStorage.setItem("data_cement_perform"+selyear+selmonth, JSON.stringify(data_cement));
			var Url = $.getJSON('http://par4digma.semenindonesia.com/api/index.php/finance_prod/show_perform_clinker?year='+selyear, function(data_clinker){
			// var Url4 = $.getJSON('http://10.15.5.150/dev/par4digma/api/index.php/finance_prod/show_perform_clinker?year='+selyear, function(data_clinker){
				sessionStorage.setItem("data_clinker_perform"+selyear+selmonth, JSON.stringify(data_clinker));
				chart_perform(opco, comp, plant, data_cement, data_clinker);
				stop_waitMe('.wrapper');
			});
		});
	}
}

function compareArea(comp, plant, data_cement, data_clinker){
	var tbl="";
	$(".table-striped").html("");
	if(data_cement.rows[comp].val4>=100){
		$("#arrow1").removeClass("fa-sort-desc").addClass("fa-sort-asc").css({color:"green"});
	}else{
		$("#arrow1").removeClass("fa-sort-asc").addClass("fa-sort-desc").css({color:"red"});
	}
	$("#perc3a").html(data_cement.rows[comp].val4);
	$("#RealCementComp").html(data_cement.rows[comp].val2);
	$("#RKAPCementComp").html(data_cement.rows[comp].val1);
	$("#REALcementLastyear").html(data_cement.rows[comp].val3);
	$("#yoy_current_Cement").html(data_cement.rows[comp].val5);

	if(data_clinker.rows[comp-1].val4>=100){
		$("#arrow2").removeClass("fa-sort-desc").addClass("fa-sort-asc").css({color:"green"});
	}else{
		$("#arrow2").removeClass("fa-sort-asc").addClass("fa-sort-desc").css({color:"red"});
	}
	$("#perc4a").html(data_clinker.rows[comp-1].val4);
	$("#RealClinkerComp").html(data_clinker.rows[comp-1].val2);
	$("#RKAPClinkerComp").html(data_clinker.rows[comp-1].val1);
	$("#REALclinkerLastyear").html(data_clinker.rows[comp-1].val3);
	$("#yoy_current_Clinker").html(data_clinker.rows[comp-1].val5);

	if(opco=="1000"){
		tbl +="<thead>"
			tbl +="<tr class='headtr'>"
				tbl +="<td>OPCO</td>"
				tbl +="<td>Cement</td>"
				tbl +="<td>Clinker</td>"
			tbl +="</tr>"
		tbl +="</thead>"
		tbl +="<tr>"
			tbl +="<td>Semen Indonesia</td>"
			tbl +="<td>"+data_cement.rows[27].val2+"</td>"
			tbl +="<td>"+data_clinker.rows[26].val2+"</td>"
		tbl +="</tr>"
		tbl +="<tr>"
			tbl +="<td>Semen Padang</td>"
			tbl +="<td>"+data_cement.rows[12].val2+"</td>"
			tbl +="<td>"+data_clinker.rows[11].val2+"</td>"
		tbl +="</tr>"
		tbl +="<tr>"
			tbl +="<td>Semen Tonasa</td>"
			tbl +="<td>"+data_cement.rows[16].val2+"</td>"
			tbl +="<td>"+data_clinker.rows[15].val2+"</td>"
		tbl +="</tr>"
		tbl +="<tr>"
			tbl +="<td>Semen Gresik</td>"
			tbl +="<td>"+data_cement.rows[21].val2+"</td>"
			tbl +="<td>"+data_clinker.rows[20].val2+"</td>"
		tbl +="</tr>"
		tbl +="<tr style='font-weight:bold'>"
			tbl +="<td>Total Semen Indonesia Group</td>"
			tbl +="<td>"+data_cement.rows[28].val2+"</td>"
			tbl +="<td>"+data_clinker.rows[27].val2+"</td>"
		tbl +="</tr>"
	}else{
		tbl +="<thead>"
			tbl +="<tr class='headtr'>"
				tbl +="<td>Plant</td>"
				tbl +="<td>Cement</td>"
				tbl +="<td>Clinker</td>"
			tbl +="</tr>"
		tbl +="</thead>"
		for(var i=(comp-plant);i<=comp;i++){
			tbl +="<tr>";
				tbl +="<td>"+data_cement.rows[i].desc.replace("&nbsp;&nbsp;", "")+"</td>"
				tbl +="<td>"+data_cement.rows[i].val2+"</td>"
				tbl +="<td>"+data_clinker.rows[i].val2+"</td>"
			tbl +="</tr>"
		}
	}

	$(".table-striped").html(tbl);
}

function chart_perform(opco, comp, plant, data_cement, data_clinker) {
	var color=["#1d8bc3", "#f04736", "#22b900", "#e9d560", "#04fff9"];
	var dataChart=[{"dataChartCement":[], "dataChartClinker":[]}];
	var dataChartOpco=[{"si":[], "sg":[], "sp":[], "st":[]},{"si":[], "sg":[], "sp":[], "st":[]}];
	for(var i=1;i<13;i++){
		dataChart[0].dataChartCement.push(parseFloat(data_cement.rows[comp]["val"+i]));
		dataChart[0].dataChartClinker.push(parseFloat(data_clinker.rows[comp]["val"+i]));
	}
	if(opco=="1000"){
		for(var i=1;i<13;i++){
			dataChartOpco[0].si.push(parseFloat(data_cement.rows[27]["val"+i]));
			dataChartOpco[0].sg.push(parseFloat(data_cement.rows[20]["val"+i]));
			dataChartOpco[0].sp.push(parseFloat(data_cement.rows[12]["val"+i]));
			dataChartOpco[0].st.push(parseFloat(data_cement.rows[16]["val"+i]));
			dataChartOpco[1].si.push(parseFloat(data_clinker.rows[27]["val"+i]));
			dataChartOpco[1].sg.push(parseFloat(data_clinker.rows[20]["val"+i]));
			dataChartOpco[1].sp.push(parseFloat(data_clinker.rows[12]["val"+i]));
			dataChartOpco[1].st.push(parseFloat(data_clinker.rows[16]["val"+i]));
		}
		dataChartCement=[{
            name: 'SI',
            color: '#1d8bc3',
            data: dataChartOpco[0].si
        },{
            name: 'SG',
            color: '#f04736',
            data: dataChartOpco[0].sg
        },{
            name: 'SP',
            color: '#22b900',
            data: dataChartOpco[0].sp
        },{
            name: 'ST',
            color: '#e9d560',
            data: dataChartOpco[0].st
        }];
		dataChartClinker=[{
            name: 'SI',
            color: '#1d8bc3',
            data: dataChartOpco[1].si
        },{
            name: 'SG',
            color: '#f04736',
            data: dataChartOpco[1].sg
        },{
            name: 'SP',
            color: '#22b900',
            data: dataChartOpco[1].sp
        },{
            name: 'ST',
            color: '#e9d560',
            data: dataChartOpco[1].st
        }]
	}else{
		dataChartCement=[];
		dataChartClinker=[];
		var a=0;
		for(var i=(comp-plant);i<comp;i++){
			var dataPlantCement=[];
			var dataPlantClinker=[];
			for(var j=1;j<13;j++){
				dataPlantCement.push(parseFloat(data_cement.rows[i]["val"+j]));
				dataPlantClinker.push(parseFloat(data_clinker.rows[i]["val"+j]));
			}
			var listOpcoCement = {name:data_cement.rows[i]["desc"].replace("&nbsp;&nbsp;",""), color:color[a], data:dataPlantCement};
			var listOpcoClinker = {name:data_clinker.rows[i]["desc"].replace("&nbsp;&nbsp;",""), color:color[a], data:dataPlantClinker};
			dataChartCement.push(listOpcoCement);
			dataChartClinker.push(listOpcoClinker);
			a++;
		}
	}

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
            name: 'Cement',
            color: '#1E8BC3',
            data: dataChart[0].dataChartCement
        },{
            name: 'Clinker',
            color: '#f04736',
            data: dataChart[0].dataChartClinker
        }]
    });

    Highcharts.chart('graphic_cement', {
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
        series:dataChartCement
    });
    Highcharts.chart('graphic_clinker', {
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
        series:dataChartClinker
    });
}
