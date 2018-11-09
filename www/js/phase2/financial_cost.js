var url_live="http://par4digma.semenindonesia.com/";
// var url_live="http://10.15.5.150/dev/par4digma/";
function numberFormat(x) {
    return parseFloat(x).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function setParam(opco, selyear, selmonth){
	var comp, plant, ttl;
	$(".imgsi").css({width:"130px", "margin-bottom":"0"});
	if(opco=="3000"){
		ttl="Semen Padang";
	}else if(opco=="7000"){
		ttl="Semen Indonesia";
	}else if(opco=="5000"){
		ttl="Semen Gresik";
	}else if(opco=="4000"){
		ttl="Semen Tonasa";
	}else if(opco=="6000"){
		ttl="Thang Long";
	}else{
        ttl="";
        $(".imgsi").css({width:"220px", "margin-bottom":"-10px"});
    }
	$(".planttittle").html(ttl)

	// GET COMPARE DATA
    var data_cost_3000=JSON.parse(sessionStorage.getItem("data_cost_3000"+selyear+selmonth));
    var data_cost_4000=JSON.parse(sessionStorage.getItem("data_cost_4000"+selyear+selmonth));
    var data_cost_5000=JSON.parse(sessionStorage.getItem("data_cost_5000"+selyear+selmonth));
    var data_cost_7000=JSON.parse(sessionStorage.getItem("data_cost_7000"+selyear+selmonth));
	if(data_cost_3000&&data_cost_4000&&data_cost_5000&&data_cost_7000){
        // console.log(data_cost);
		viewArea(opco, data_cost_3000, data_cost_4000, data_cost_5000, data_cost_7000);
        stop_waitMe('.wrapper');
	}else{
    	run_waitMe('.wrapper', 'ios');
        var Url1 = $.getJSON(url_live+'api/index.php/finance_cost/get_data?year='+selyear+'&month='+selmonth+'&comp=3000', function(data_cost_3000){
            var Url2 = $.getJSON(url_live+'api/index.php/finance_cost/get_data?year='+selyear+'&month='+selmonth+'&comp=4000', function(data_cost_4000){
                var Url3 = $.getJSON(url_live+'api/index.php/finance_cost/get_data?year='+selyear+'&month='+selmonth+'&comp=5000', function(data_cost_5000){
                    var Url4 = $.getJSON(url_live+'api/index.php/finance_cost/get_data?year='+selyear+'&month='+selmonth+'&comp=7000', function(data_cost_7000){
                        sessionStorage.setItem("data_cost_3000"+selyear+selmonth, JSON.stringify(data_cost_3000));
                        sessionStorage.setItem("data_cost_4000"+selyear+selmonth, JSON.stringify(data_cost_4000));
                        sessionStorage.setItem("data_cost_5000"+selyear+selmonth, JSON.stringify(data_cost_5000));
            			sessionStorage.setItem("data_cost_7000"+selyear+selmonth, JSON.stringify(data_cost_7000));
                        viewArea(opco, data_cost_3000, data_cost_4000, data_cost_5000, data_cost_7000);
                        stop_waitMe('.wrapper');
                    });
                });
            });
		});
	}
    $('.se-pre-con').fadeOut();
}

function viewArea(opco, data_cost_3000, data_cost_4000, data_cost_5000, data_cost_7000){
    if(opco=='1000'){

        $('#page1').removeClass('hidden');
        $('#page2').addClass('hidden');

        $("#clinker7000").html(numberFormat(data_cost_7000.rows[1].ACT1));
        $("#cement7000").html(numberFormat(data_cost_7000.rows[2].ACT1));
        $("#sales7000").html(numberFormat(data_cost_7000.rows[3].ACT1));

        $("#clinker3000").html(numberFormat(data_cost_3000.rows[1].ACT1));
        $("#cement3000").html(numberFormat(data_cost_3000.rows[2].ACT1));
        $("#sales3000").html(numberFormat(data_cost_3000.rows[3].ACT1));

        $("#clinker4000").html(numberFormat(data_cost_4000.rows[1].ACT1));
        $("#cement4000").html(numberFormat(data_cost_4000.rows[2].ACT1));
        $("#sales4000").html(numberFormat(data_cost_4000.rows[3].ACT1));

        $("#clinker5000").html(numberFormat(data_cost_5000.rows[1].ACT1));
        $("#cement5000").html(numberFormat(data_cost_5000.rows[2].ACT1));
        $("#sales5000").html(numberFormat(data_cost_5000.rows[3].ACT1));

        var dataChartSI=[parseFloat((data_cost_7000.rows[20].ACT1/1000000).toFixed(0)), parseFloat((data_cost_7000.rows[15].ACT1/1000000).toFixed(0)), parseFloat((data_cost_7000.rows[31].ACT1/1000000).toFixed(0)), parseFloat((data_cost_7000.rows[42].ACT1/1000000).toFixed(0))];
        var dataChartSP=[parseFloat((data_cost_3000.rows[20].ACT1/1000000).toFixed(0)), parseFloat((data_cost_3000.rows[15].ACT1/1000000).toFixed(0)), parseFloat((data_cost_3000.rows[31].ACT1/1000000).toFixed(0)), parseFloat((data_cost_3000.rows[42].ACT1/1000000).toFixed(0))];
        var dataChartST=[parseFloat((data_cost_4000.rows[20].ACT1/1000000).toFixed(0)), parseFloat((data_cost_4000.rows[15].ACT1/1000000).toFixed(0)), parseFloat((data_cost_4000.rows[31].ACT1/1000000).toFixed(0)), parseFloat((data_cost_4000.rows[42].ACT1/1000000).toFixed(0))];
        var dataChartSG=[parseFloat((data_cost_5000.rows[20].ACT1/1000000).toFixed(0)), parseFloat((data_cost_5000.rows[15].ACT1/1000000).toFixed(0)), parseFloat((data_cost_5000.rows[31].ACT1/1000000).toFixed(0)), parseFloat((data_cost_5000.rows[42].ACT1/1000000).toFixed(0))];

        Highcharts.chart('PlantCompare', {
            chart: {
                type: 'bar',
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
                categories:['COGM','COGS','Gen.Adm','Sell & Market'],
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
                name:"SI",
                color:"#1d8bc3",
                data:dataChartSI
            },{
                name:"SP",
                color:"#f14736",
                data:dataChartSP
            },{
                name:"ST",
                color:"#23b901",
                data:dataChartST
            },{
                name:"SG",
                color:"#ead65f",
                data:dataChartSG
            }]
        });
    }else{

        $('#page1').addClass('hidden');
        $('#page2').removeClass('hidden');

        var dataChoosed, data1, data2, data3, data4;
        // if($("#subpage1").hashClass("hidden")){

        // }else{

        // }
        if(opco=='3000'){
            dataChoosed=data_cost_3000;
            data1=15;
            data2=20;
            data3=31;
            data4=42;
            dataton1=56;
            dataton2=61;
            dataton3=72;
            dataton4=83;
        }else if(opco=='4000'){
            dataChoosed=data_cost_4000;
            data1=15;
            data2=20;
            data3=31;
            data4=42;
            dataton1=56;
            dataton2=61;
            dataton3=72;
            dataton4=83;
        }else if(opco=='5000'){
            dataChoosed=data_cost_5000;
            data1=15;
            data2=20;
            data3=32;
            data4=44;
            dataton1=58;
            dataton2=63;
            dataton3=75;
            dataton4=87;
        }else if(opco=='7000'){
            dataChoosed=data_cost_7000;
            data1=15;
            data2=20;
            data3=32;
            data4=44;
            dataton1=58;
            dataton2=63;
            dataton3=75;
            dataton4=87;
        }
        

        $("#clin_now").html(numberFormat(dataChoosed.rows[1].ACT1));
        $("#cmnt_now").html(numberFormat(dataChoosed.rows[2].ACT1));
        $("#salevol_now").html(numberFormat(dataChoosed.rows[3].ACT1));

        $("#clin_past").html(numberFormat(dataChoosed.rows[1].ACT2));
        $("#cmnt_past").html(numberFormat(dataChoosed.rows[2].ACT2));
        $("#salevol_past").html(numberFormat(dataChoosed.rows[3].ACT2));

        // COGM
        $("#tot_pcost_nw").html(numberFormat(dataChoosed.rows[data1].ACT1/1000000000));
        $("#rkap_current_prod").html(numberFormat(dataChoosed.rows[data1].BUD1/1000000000));
        $("#real_lyear_prod").html(numberFormat(dataChoosed.rows[data1].ACT11/1000000000));
        $("#yoy_current_p").html(dataChoosed.rows[data1].PERSEN11);
        $("#perc1a").html(dataChoosed.rows[data1].PERSEN1);

        $("#tot_pcost_pst").html(numberFormat(dataChoosed.rows[data1].ACT2/1000000000));
        $("#rkap_up_prod").html(numberFormat(dataChoosed.rows[data1].BUD2/1000000000));
        $("#real_up_lyear_prod").html(numberFormat(dataChoosed.rows[data1].ACT22/1000000000));
        $("#yoy_up_p").html(dataChoosed.rows[data1].PERSEN22);
        $("#perc1b").html(dataChoosed.rows[data1].PERSEN2);

        // COGS
        $("#tot_cogs_nw").html(numberFormat(dataChoosed.rows[data2].ACT1/1000000000));
        $("#rkap_current_cogs").html(numberFormat(dataChoosed.rows[data2].BUD1/1000000000));
        $("#real_lyear_cogs").html(numberFormat(dataChoosed.rows[data2].ACT11/1000000000));
        $("#yoy_current_cogs").html(dataChoosed.rows[data2].PERSEN11);
        $("#perc2a").html(dataChoosed.rows[data2].PERSEN1);

        $("#tot_cogs_pst").html(numberFormat(dataChoosed.rows[data2].ACT2/1000000000));
        $("#rkap_up_cogs").html(numberFormat(dataChoosed.rows[data2].BUD2/1000000000));
        $("#real_up_lyear_cogs").html(numberFormat(dataChoosed.rows[data2].ACT22/1000000000));
        $("#yoy_up_cogs").html(dataChoosed.rows[data2].PERSEN22);
        $("#perc2b").html(dataChoosed.rows[data2].PERSEN2);

        // Gen.Admin
        $("#tot_gen_nw").html(numberFormat(dataChoosed.rows[data3].ACT1/1000000000));
        $("#rkap_current_gnrl").html(numberFormat(dataChoosed.rows[data3].BUD1/1000000000));
        $("#real_lyear_gnrl").html(numberFormat(dataChoosed.rows[data3].ACT11/1000000000));
        $("#yoy_current_gnrl").html(dataChoosed.rows[data3].PERSEN11);
        $("#perc3a").html(dataChoosed.rows[data3].PERSEN1);

        $("#tot_gen_pst").html(numberFormat(dataChoosed.rows[data3].ACT2/1000000000));
        $("#rkap_up_gnrl").html(numberFormat(dataChoosed.rows[data3].BUD2/1000000000));
        $("#real_up_lyear_gnrl").html(numberFormat(dataChoosed.rows[data3].ACT22/1000000000));
        $("#yoy_up_gnrl").html(dataChoosed.rows[data3].PERSEN22);
        $("#perc3b").html(dataChoosed.rows[data3].PERSEN2);

        // Sell & Marketing
        $("#tot_sell_nw").html(numberFormat(dataChoosed.rows[data4].ACT1/1000000000));
        $("#rkap_current_sale").html(numberFormat(dataChoosed.rows[data4].BUD1/1000000000));
        $("#real_lyear_sale").html(numberFormat(dataChoosed.rows[data4].ACT11/1000000000));
        $("#yoy_current_sale").html(dataChoosed.rows[data4].PERSEN11);
        $("#perc4a").html(dataChoosed.rows[data4].PERSEN1);

        $("#tot_sell_pst").html(numberFormat(dataChoosed.rows[data4].ACT2/1000000000));
        $("#rkap_up_sale").html(numberFormat(dataChoosed.rows[data4].BUD2/1000000000));
        $("#real_up_lyear_sale").html(numberFormat(dataChoosed.rows[data4].ACT22/1000000000));
        $("#yoy_up_sale").html(dataChoosed.rows[data4].PERSEN22);
        $("#perc4b").html(dataChoosed.rows[data4].PERSEN2);


        //TON
        $("#ton_clin_now").html(numberFormat(dataChoosed.rows[1].ACT1/1000));
        $("#ton_cmnt_now").html(numberFormat(dataChoosed.rows[2].ACT1/1000));
        $("#ton_salevol_now").html(numberFormat(dataChoosed.rows[3].ACT1/1000));

        $("#ton_clin_past").html(numberFormat(dataChoosed.rows[1].ACT2/1000));
        $("#ton_cmnt_past").html(numberFormat(dataChoosed.rows[2].ACT2/1000));
        $("#ton_salevol_past").html(numberFormat(dataChoosed.rows[3].ACT2/1000));

        // COGM
        $("#ton_tot_pcost_nw").html(numberFormat(dataChoosed.rows[dataton1].ACT1));
        $("#ton_rkap_current_prod").html(numberFormat(dataChoosed.rows[dataton1].BUD1));
        $("#ton_real_lyear_prod").html(numberFormat(dataChoosed.rows[dataton1].ACT11));
        $("#ton_yoy_current_p").html(dataChoosed.rows[dataton1].PERSEN11);
        $("#ton_perc1a").html(dataChoosed.rows[dataton1].PERSEN1);

        $("#ton_tot_pcost_pst").html(numberFormat(dataChoosed.rows[dataton1].ACT2));
        $("#ton_rkap_up_prod").html(numberFormat(dataChoosed.rows[dataton1].BUD2));
        $("#ton_real_up_lyear_prod").html(numberFormat(dataChoosed.rows[dataton1].ACT22));
        $("#ton_yoy_up_p").html(dataChoosed.rows[dataton1].PERSEN22);
        $("#ton_perc1b").html(dataChoosed.rows[dataton1].PERSEN2);

        // COGS
        $("#ton_tot_cogs_nw").html(numberFormat(dataChoosed.rows[dataton2].ACT1));
        $("#ton_rkap_current_cogs").html(numberFormat(dataChoosed.rows[dataton2].BUD1));
        $("#ton_real_lyear_cogs").html(numberFormat(dataChoosed.rows[dataton2].ACT11));
        $("#ton_yoy_current_cogs").html(dataChoosed.rows[dataton2].PERSEN11);
        $("#ton_perc2a").html(dataChoosed.rows[dataton2].PERSEN1);

        $("#ton_tot_cogs_pst").html(numberFormat(dataChoosed.rows[dataton2].ACT2));
        $("#ton_rkap_up_cogs").html(numberFormat(dataChoosed.rows[dataton2].BUD2));
        $("#ton_real_up_lyear_cogs").html(numberFormat(dataChoosed.rows[dataton2].ACT22));
        $("#ton_yoy_up_cogs").html(dataChoosed.rows[dataton2].PERSEN22);
        $("#ton_perc2b").html(dataChoosed.rows[dataton2].PERSEN2);

        // Gen.Admin
        $("#ton_tot_gen_nw").html(numberFormat(dataChoosed.rows[dataton3].ACT1));
        $("#ton_rkap_current_gnrl").html(numberFormat(dataChoosed.rows[dataton3].BUD1));
        $("#ton_real_lyear_gnrl").html(numberFormat(dataChoosed.rows[dataton3].ACT11));
        $("#ton_yoy_current_gnrl").html(dataChoosed.rows[dataton3].PERSEN11);
        $("#ton_perc3a").html(dataChoosed.rows[dataton3].PERSEN1);

        $("#ton_tot_gen_pst").html(numberFormat(dataChoosed.rows[dataton3].ACT2));
        $("#ton_rkap_up_gnrl").html(numberFormat(dataChoosed.rows[dataton3].BUD2));
        $("#ton_real_up_lyear_gnrl").html(numberFormat(dataChoosed.rows[dataton3].ACT22));
        $("#ton_yoy_up_gnrl").html(dataChoosed.rows[dataton3].PERSEN22);
        $("#ton_perc3b").html(dataChoosed.rows[dataton3].PERSEN2);

        // Sell & Marketing
        $("#ton_tot_sell_nw").html(numberFormat(dataChoosed.rows[dataton4].ACT1));
        $("#ton_rkap_current_sale").html(numberFormat(dataChoosed.rows[dataton4].BUD1));
        $("#ton_real_lyear_sale").html(numberFormat(dataChoosed.rows[dataton4].ACT11));
        $("#ton_yoy_current_sale").html(dataChoosed.rows[dataton4].PERSEN11);
        $("#ton_perc4a").html(dataChoosed.rows[dataton4].PERSEN1);

        $("#ton_tot_sell_pst").html(numberFormat(dataChoosed.rows[dataton4].ACT2));
        $("#ton_rkap_up_sale").html(numberFormat(dataChoosed.rows[dataton4].BUD2));
        $("#ton_real_up_lyear_sale").html(numberFormat(dataChoosed.rows[dataton4].ACT22));
        $("#ton_yoy_up_sale").html(dataChoosed.rows[dataton4].PERSEN22);
        $("#ton_perc4b").html(dataChoosed.rows[dataton4].PERSEN2);




    }
}
