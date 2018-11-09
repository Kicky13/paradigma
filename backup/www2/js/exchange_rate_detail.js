 $(function(){
                var opco = 'smi';
                var d = new Date();
                //var tahun = d.getFullYear();
                var yearnow = tahun;
                var bulanS = '0'+5;
                var tmp = getParam();
                //var opco = tmp['opco'];
               // var thn = tmp['thn'];
				var thn = d.getFullYear();
				var tahun = d.getFullYear();
                //var bulanSekarang = tmp['bln'];
				/*var d = new Date();
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
	  var pengurang = 2;
      var bulan = month[moment().subtract(pengurang, 'months').format('MM')];
      //var bulanSekarang = paradigma.date('now', 'month');
		var bulanSekarang = month[moment().subtract(pengurang, 'months').format('MM')];
		var tahun = d.getFullYear();*/
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
                var pengurang = 2;
                var bulan = month[moment().subtract(pengurang, 'months').format('MM')];
                var bulanSekarang = moment().subtract(pengurang, 'months').format('MM');
                var tahun = moment().subtract(pengurang, 'months').format('YYYY');
                var dd = d.getDate();
                var mm = d.getMonth()+1; //January is 0!
                var yyyy = d.getFullYear();
                if(dd<10) {
                    dd='0'+dd
                } 
                if(mm<10) {
                    mm='0'+mm
                } 
                console.log((bulanSekarang)+' '+thn);
                 onLoad('',bulanSekarang, tahun);

                // $('.selmonth').change(function(){
                //     bulanS = '0'+5;
                //     tahun = $('.selyear').val();   

                //     cost_data(bulanS, opco, yearnow);

                // })
             
     loadData(url_src+'/api/index.php/market_share/detail?bulan='+(bulanSekarang)+'&tahun='+tahun);
     $('.selmonth').change(function(){
                 bulanSekarang = $(this).val();
                 // tahun = $('.selyear').val(); 
                 // year = ($('.selyear').val())-1; 
                 thn = ($('.selyear').val());
                 var t = $(this).attr('rel');
                 
                 //loadData(url_src+'/SDRKAP_'+src_t+'Daily_all.php?tahun='+tahun+'&bulan='+bulanSekarang, t, '7000');
                 loadData(url_src+'/api/index.php/market_share/detail?bulan='+(bulanSekarang-3)+'&tahun='+thn);
                 //loadData(url_src+'/market_share.php?tahun='+year+'&bulan='+bulanSekarang, 'last');
                })
                $('.selyear').change(function(){
                 thn = $(this).val();
                 bulanSekarang = $('.selmonth').val(); 
                 var t = $(this).attr('rel');
                
                 //loadData(url_src+'/SDRKAP_'+src_t+'Daily_all.php?tahun='+tahun+'&bulan='+bulanSekarang, t, '7000');
                 loadData(url_src+'/api/index.php/market_share/detail?bulan='+(bulanSekarang-3)+'&tahun='+thn);

                 //
                })
                
 function loadData(datasrc, id){

  run_waitMe('.wrapper','facebook');  
         console.log(datasrc);
  
      $.ajax({
  url: datasrc,
  //url: url_src+'/api/index.php/market_share/detail?region=1&bulan=10',
  type : 'GET',
  success: function(data){
    var logdata = JSON.parse(data);
    $('#tbhead_last').html('MS '+(thn-1));
    $('#tbhead_now').html('MS '+thn);
    console.log(logdata);
    var count = Object.keys(logdata).length;
    console.log(count);
    for(var x = 1;x<=count; x++){
            if(x<10){
              var y = '0'+ x;
            }else{
              y = x;
            }        
       }
	$('#isidetail').html(' ');
       chart();
      chart2();
       var isiprovinsi;
       
        var namapt=[];
        var nama = [];
      var prov = [];

    var growth1 = 0;
    var growth2 = 0;
    var growth3 = 0;
    var growth4 = 0;
    var growth5 = 0;
    var growth6 = 0;
    var growth7 = 0;
    var growth8 = 0;
    var growth9 = 0;
    var growth10 = 0;
    var growth11 = 0;
    var growth12 = 0;
    var growth13 = 0;
    var growth14 = 0;
    var growth15 = 0;
    var growth16 = 0;
    var growth17 = 0;
    var growth18 = 0;
    var growth19 = 0;
    var growth20 = 0;
    var growth21 = 0;
    var growth22 = 0;
    var growth23 = 0;
    var growth24 = 0;
    var growth25 = 0;
    var growth26 = 0;
    var growth27 = 0;
    var growth28 = 0;
    var growth29 = 0;
    var growth30 = 0;
    var growth31 = 0;
    var growth32 = 0;
    var growth33 = 0;
    var growth34 = 0;
      var growth = [];

    var last_growth1 = 0;
    var last_growth2 = 0;
    var last_growth3 = 0;
    var last_growth4 = 0;
    var last_growth5 = 0;
    var last_growth6 = 0;
    var last_growth7 = 0;
    var last_growth8 = 0;
    var last_growth9 = 0;
    var last_growth10 = 0;
    var last_growth11 = 0;
    var last_growth12 = 0;
    var last_growth13 = 0;
    var last_growth14 = 0;
    var last_growth15 = 0;
    var last_growth16 = 0;
    var last_growth17 = 0;
    var last_growth18 = 0;
    var last_growth19 = 0;
    var last_growth20 = 0;
    var last_growth21 = 0;
    var last_growth22 = 0;
    var last_growth23 = 0;
    var last_growth24 = 0;
    var last_growth25 = 0;
    var last_growth26 = 0;
    var last_growth27 = 0;
    var last_growth28 = 0;
    var last_growth29 = 0;
    var last_growth30 = 0;
    var last_growth31 = 0;
    var last_growth32 = 0;
    var last_growth33 = 0;
    var last_growth34 = 0;
      var last_growth = [];

    var volume1 = 0;
    var volume2 = 0;
    var volume3 = 0;
    var volume4 = 0;
    var volume5 = 0;
    var volume6 = 0;
    var volume7 = 0;
    var volume8 = 0;
    var volume9 = 0;
    var volume10 = 0;
    var volume11 = 0;
    var volume12 = 0;
    var volume13 = 0;
    var volume14 = 0;
    var volume15 = 0;
    var volume16 = 0;
    var volume17 = 0;
    var volume18 = 0;
    var volume19 = 0;
    var volume20 = 0;
    var volume21 = 0;
    var volume22 = 0;
    var volume23 = 0;
    var volume24 = 0;
    var volume25 = 0;
    var volume26 = 0;
    var volume27 = 0;
    var volume28 = 0;
    var volume29 = 0;
    var volume30 = 0;
    var volume31 = 0;
    var volume32 = 0;
    var volume33 = 0;
    var volume34 = 0;
    var volume = [];
    
    var gwt = 0;
    var ms_smi1 = 0;
    var ms_smi2 = 0;
    var ms_smi3 = 0;
    var ms_smi4 = 0;
    var ms_smi5 = 0;
    var ms_smi6 = 0;
    var ms_smi7 = 0;
    var ms_smi8 = 0;
    var ms_smi9 = 0;
    var ms_smi10 = 0;
    var ms_smi11 = 0;
    var ms_smi12 = 0;
    var ms_smi13 = 0;
    var ms_smi14 = 0;
    var ms_smi15 = 0;
    var ms_smi16 = 0;
    var ms_smi17 = 0;
    var ms_smi18 = 0;
    var ms_smi19 = 0;
    var ms_smi20 = 0;
    var ms_smi21 = 0;
    var ms_smi22 = 0;
    var ms_smi23 = 0;
    var ms_smi24 = 0;
    var ms_smi25 = 0;
    var ms_smi26 = 0;
    var ms_smi27 = 0;
    var ms_smi28 = 0;
    var ms_smi29 = 0;
    var ms_smi30 = 0;
    var ms_smi31 = 0;
    var ms_smi32 = 0;
    var ms_smi33 = 0;
    var ms_smi34 = 0;
    var ms_smi = [];

    var last_ms_smi1 = 0;
    var last_ms_smi2 = 0;
    var last_ms_smi3 = 0;
    var last_ms_smi4 = 0;
    var last_ms_smi5 = 0;
    var last_ms_smi6 = 0;
    var last_ms_smi7 = 0;
    var last_ms_smi8 = 0;
    var last_ms_smi9 = 0;
    var last_ms_smi10 = 0;
    var last_ms_smi11 = 0;
    var last_ms_smi12 = 0;
    var last_ms_smi13 = 0;
    var last_ms_smi14 = 0;
    var last_ms_smi15 = 0;
    var last_ms_smi16 = 0;
    var last_ms_smi17 = 0;
    var last_ms_smi18 = 0;
    var last_ms_smi19 = 0;
    var last_ms_smi20 = 0;
    var last_ms_smi21 = 0;
    var last_ms_smi22 = 0;
    var last_ms_smi23 = 0;
    var last_ms_smi24 = 0;
    var last_ms_smi25 = 0;
    var last_ms_smi26 = 0;
    var last_ms_smi27 = 0;
    var last_ms_smi28 = 0;
    var last_ms_smi29 = 0;
    var last_ms_smi30 = 0;
    var last_ms_smi31 = 0;
    var last_ms_smi32 = 0;
    var last_ms_smi33 = 0;
    var last_ms_smi34 = 0;
    var last_ms_smi = [];
    
    var provinsi;
    var chartCategory=[];
    var chartData1=[];
    var chartData2=[];
    var chartDatax=[];
    var chartDatay=[];
    var prop = [];
     $.each(logdata, function(key, val){
    prop.push(key);
    
    })
     console.log(prop);
    console.log(logdata['Jawa Timur']);
    $.each(logdata['Jawa Timur'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume1 += Number(val.VOLUME_BULAN);
        ms_smi1 += Number(val.MS_TAHUN_KUM);
        last_ms_smi1 += Number(val.LAST_MS_TAHUN_KUM);
        growth1 += Number(val.GROWTH_MOM);
        last_growth1 += Number(val.GROWTH_MOM_LAST);
        console.log(volume1);
    }
    })
     volume.push(volume1);
     ms_smi.push(ms_smi1);
     last_ms_smi.push(last_ms_smi1);
     growth.push(growth1);
     last_growth.push(last_growth1);

    console.log(logdata['Jawa Barat']);
    $.each(logdata['Jawa Barat'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume2 += Number(val.VOLUME_BULAN);
        ms_smi2 += Number(val.MS_TAHUN_KUM);
        last_ms_smi2 += Number(val.LAST_MS_TAHUN_KUM);
        growth2 += Number(val.GROWTH_MOM);
        last_growth2 += Number(val.GROWTH_MOM_LAST);
        console.log(volume2);    
    }
    })
    volume.push(volume2);
    ms_smi.push(ms_smi2);
     last_ms_smi.push(last_ms_smi2);
     growth.push(growth2);
     last_growth.push(last_growth2);
    console.log(logdata['Jawa Tengah']);
    $.each(logdata['Jawa Tengah'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume3 += Number(val.VOLUME_BULAN);
        ms_smi3 += Number(val.MS_TAHUN_KUM);
        last_ms_smi3 += Number(val.LAST_MS_TAHUN_KUM);
        growth3 += Number(val.GROWTH_MOM);
        last_growth3 += Number(val.GROWTH_MOM_LAST);
        console.log(volume3);
        
    }
    })
    volume.push(volume3);
    ms_smi.push(ms_smi3);
     last_ms_smi.push(last_ms_smi3);
     growth.push(growth3);
     last_growth.push(last_growth3);
    console.log(logdata['DKI Jakarta']);
    $.each(logdata['DKI Jakarta'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume4 += Number(val.VOLUME_BULAN);
        ms_smi4 += Number(val.MS_TAHUN_KUM);
        last_ms_smi4 += Number(val.LAST_MS_TAHUN_KUM);
        growth4 += Number(val.GROWTH_MOM);
        last_growth4 += Number(val.GROWTH_MOM_LAST);
        console.log(volume4);
        
    }
    })
    volume.push(volume4);
    ms_smi.push(ms_smi4);
     last_ms_smi.push(last_ms_smi4);
     growth.push(growth4);
     last_growth.push(last_growth4);
    console.log(logdata['Sulawesi Selatan']);
    $.each(logdata['Sulawesi Selatan'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume5 += Number(val.VOLUME_BULAN);
        ms_smi5 += Number(val.MS_TAHUN_KUM);
        last_ms_smi5 += Number(val.LAST_MS_TAHUN_KUM);
        growth5 += Number(val.GROWTH_MOM);
        last_growth5 += Number(val.GROWTH_MOM_LAST);
        console.log(volume5);
        
    }
    })
    volume.push(volume5);
    ms_smi.push(ms_smi5);
     last_ms_smi.push(last_ms_smi5);
     growth.push(growth5);
     last_growth.push(last_growth5);
    console.log(logdata['Riau Daratan']);
    $.each(logdata['Riau Daratan'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume6 += Number(val.VOLUME_BULAN);
        ms_smi6 += Number(val.MS_TAHUN_KUM);
        last_ms_smi6 += Number(val.LAST_MS_TAHUN_KUM);
        growth6 += Number(val.GROWTH_MOM);
        last_growth6 += Number(val.GROWTH_MOM_LAST);
        console.log(volume6);
        
    }
    })
    volume.push(volume6);
    ms_smi.push(ms_smi6);
     last_ms_smi.push(last_ms_smi6);
     growth.push(growth6);
     last_growth.push(last_growth6);
    console.log(logdata['Banten']);
    $.each(logdata['Banten'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume7 += Number(val.VOLUME_BULAN);
        ms_smi7 += Number(val.MS_TAHUN_KUM);
        last_ms_smi7 += Number(val.LAST_MS_TAHUN_KUM);
        growth7 += Number(val.GROWTH_MOM);
        last_growth7 += Number(val.GROWTH_MOM_LAST);
        console.log(volume7);
        
    }
    })
    volume.push(volume7);
    ms_smi.push(ms_smi7);
     last_ms_smi.push(last_ms_smi7);
     growth.push(growth7);
     last_growth.push(last_growth7);
    console.log(logdata['Sumatera Utara']);
    $.each(logdata['Sumatera Utara'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume8 += Number(val.VOLUME_BULAN);
        ms_smi8 += Number(val.MS_TAHUN_KUM);
        last_ms_smi8 += Number(val.LAST_MS_TAHUN_KUM);
        growth8 += Number(val.GROWTH_MOM);
        last_growth8 += Number(val.GROWTH_MOM_LAST);
        console.log(volume8);
        
    }
    })
    volume.push(volume8);
    ms_smi.push(ms_smi8);
     last_ms_smi.push(last_ms_smi8);
     growth.push(growth8);
     last_growth.push(last_growth8);
    console.log(logdata['Sumatera Selatan']);
    $.each(logdata['Sumatera Selatan'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume9 += Number(val.VOLUME_BULAN);
        ms_smi9 += Number(val.MS_TAHUN_KUM);
        last_ms_smi9 += Number(val.LAST_MS_TAHUN_KUM);
        growth9 += Number(val.GROWTH_MOM);
        last_growth9 += Number(val.GROWTH_MOM_LAST);
        console.log(volume9);
        
    }
    })
    volume.push(volume9);
    ms_smi.push(ms_smi9);
     last_ms_smi.push(last_ms_smi9);
     growth.push(growth9);
     last_growth.push(last_growth9);
    console.log(logdata['Sumatera Barat']);
    $.each(logdata['Sumatera Barat'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume10 += Number(val.VOLUME_BULAN);
        ms_smi10 += Number(val.MS_TAHUN_KUM);
        last_ms_smi10 += Number(val.LAST_MS_TAHUN_KUM);
        growth10 += Number(val.GROWTH_MOM);
        last_growth10 += Number(val.GROWTH_MOM_LAST);
        console.log(volume10);
        
    }
    })
    volume.push(volume10);
    ms_smi.push(ms_smi10);
     last_ms_smi.push(last_ms_smi10);
     growth.push(growth10);
     last_growth.push(last_growth10);
    console.log(logdata['Aceh']);
    $.each(logdata['Aceh'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume11 += Number(val.VOLUME_BULAN);
        ms_smi11 += Number(val.MS_TAHUN_KUM);
        last_ms_smi11 += Number(val.LAST_MS_TAHUN_KUM);
        growth11 += Number(val.GROWTH_MOM);
        last_growth11 += Number(val.GROWTH_MOM_LAST);
        console.log(volume11);
        
    }
    })
    volume.push(volume11);
    ms_smi.push(ms_smi11);
     last_ms_smi.push(last_ms_smi11);
     growth.push(growth11);
     last_growth.push(last_growth11);
    console.log(logdata['Jambi']);
    $.each(logdata['Jambi'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume12 += Number(val.VOLUME_BULAN);
        ms_smi12 += Number(val.MS_TAHUN_KUM);
        last_ms_smi12 += Number(val.LAST_MS_TAHUN_KUM);
        growth12 += Number(val.GROWTH_MOM);
        last_growth12 += Number(val.GROWTH_MOM_LAST);
        console.log(volume12);
        
    }
    })
    volume.push(volume12);
    ms_smi.push(ms_smi12);
     last_ms_smi.push(last_ms_smi12);
     growth.push(growth12);
     last_growth.push(last_growth12);
    console.log(logdata['Sulawesi Tengah']);
    $.each(logdata['Sulawesi Tengah'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume13 += Number(val.VOLUME_BULAN);
        ms_smi13 += Number(val.MS_TAHUN_KUM);
        last_ms_smi13 += Number(val.LAST_MS_TAHUN_KUM);
        growth13 += Number(val.GROWTH_MOM);
        last_growth13 += Number(val.GROWTH_MOM_LAST);
        console.log(volume13);
        
    }
    })
    volume.push(volume13);
    ms_smi.push(ms_smi13);
     last_ms_smi.push(last_ms_smi13);
     growth.push(growth13);
     last_growth.push(last_growth13);
    console.log(logdata['Nusa Tenggara Barat']);
    $.each(logdata['Nusa Tenggara Barat'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume14 += Number(val.VOLUME_BULAN);
        ms_smi14 += Number(val.MS_TAHUN_KUM);
        last_ms_smi14 += Number(val.LAST_MS_TAHUN_KUM);
        growth14 += Number(val.GROWTH_MOM);
        last_growth14 += Number(val.GROWTH_MOM_LAST);
        console.log(volume14);
        
    }
    })
    volume.push(volume14);
    ms_smi.push(ms_smi14);
     last_ms_smi.push(last_ms_smi14);
     growth.push(growth14);
     last_growth.push(last_growth14);
    console.log(logdata['Kalimantan Selatan']);
    $.each(logdata['Kalimantan Selatan'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume15 += Number(val.VOLUME_BULAN);
        ms_smi15 += Number(val.MS_TAHUN_KUM);
        last_ms_smi15 += Number(val.LAST_MS_TAHUN_KUM);
        growth15 += Number(val.GROWTH_MOM);
        last_growth15 += Number(val.GROWTH_MOM_LAST);
        console.log(volume15);
        
    }
    })
    volume.push(volume15);
    ms_smi.push(ms_smi15);
     last_ms_smi.push(last_ms_smi15);
     growth.push(growth15);
     last_growth.push(last_growth15);
    console.log(logdata['Lampung']);
    $.each(logdata['Lampung'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume16 += Number(val.VOLUME_BULAN);
        ms_smi16 += Number(val.MS_TAHUN_KUM);
        last_ms_smi16 += Number(val.LAST_MS_TAHUN_KUM);
        growth16 += Number(val.GROWTH_MOM);
        last_growth16 += Number(val.GROWTH_MOM_LAST);
        console.log(volume16);
        
    }
    })
    volume.push(volume16);
    ms_smi.push(ms_smi16);
     last_ms_smi.push(last_ms_smi16);
     growth.push(growth16);
     last_growth.push(last_growth16);
    console.log(logdata['Sulawesi Tenggara']);
    $.each(logdata['Sulawesi Tenggara'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume17 += Number(val.VOLUME_BULAN);
        ms_smi17 += Number(val.MS_TAHUN_KUM);
        last_ms_smi17 += Number(val.LAST_MS_TAHUN_KUM);
        growth17 += Number(val.GROWTH_MOM);
        last_growth17 += Number(val.GROWTH_MOM_LAST);
        console.log(volume17);
        
    }
    })
    volume.push(volume17);
    ms_smi.push(ms_smi17);
     last_ms_smi.push(last_ms_smi17);
     growth.push(growth17);
     last_growth.push(last_growth17);
    console.log(logdata['Sulawesi Utara']);
    $.each(logdata['Sulawesi Utara'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume18 += Number(val.VOLUME_BULAN);
        ms_smi18 += Number(val.MS_TAHUN_KUM);
        last_ms_smi18 += Number(val.LAST_MS_TAHUN_KUM);
        growth18 += Number(val.GROWTH_MOM);
        last_growth18 += Number(val.GROWTH_MOM_LAST);
        console.log(volume18);
        
    }
    })
    volume.push(volume18);
    ms_smi.push(ms_smi18);
     last_ms_smi.push(last_ms_smi18);
     growth.push(growth18);
     last_growth.push(last_growth18);
    console.log(logdata['Bali']);
    $.each(logdata['Bali'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume19 += Number(val.VOLUME_BULAN);
        ms_smi19 += Number(val.MS_TAHUN_KUM);
        last_ms_smi19 += Number(val.LAST_MS_TAHUN_KUM);
        growth19 += Number(val.GROWTH_MOM);
        last_growth19 += Number(val.GROWTH_MOM_LAST);
        console.log(volume19);
        
    }
    })
    volume.push(volume19);
    ms_smi.push(ms_smi19);
     last_ms_smi.push(last_ms_smi19);
     growth.push(growth19);
     last_growth.push(last_growth19);
    console.log(logdata['Kalimantan Barat']);
    $.each(logdata['Kalimantan Barat'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume20 += Number(val.VOLUME_BULAN);
        ms_smi20 += Number(val.MS_TAHUN_KUM);
        last_ms_smi20 += Number(val.LAST_MS_TAHUN_KUM);
        growth20 += Number(val.GROWTH_MOM);
        last_growth20 += Number(val.GROWTH_MOM_LAST);
        console.log(volume20);
        
    }
    })
    volume.push(volume20)
    ms_smi.push(ms_smi20);
     last_ms_smi.push(last_ms_smi20);
     growth.push(growth20);
     last_growth.push(last_growth20);
    console.log(logdata['Kalimantan Tengah']);
    $.each(logdata['Kalimantan Tengah'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume21 += Number(val.VOLUME_BULAN);
        ms_smi21 += Number(val.MS_TAHUN_KUM);
        last_ms_smi21 += Number(val.LAST_MS_TAHUN_KUM);
        growth21 += Number(val.GROWTH_MOM);
        last_growth21 += Number(val.GROWTH_MOM_LAST);
        console.log(volume21);
        
    }
    })
    volume.push(volume21);
    ms_smi.push(ms_smi21);
     last_ms_smi.push(last_ms_smi21);
     growth.push(growth21);
     last_growth.push(last_growth21);
    console.log(logdata['Bengkulu']);
    $.each(logdata['Bengkulu'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume22 += Number(val.VOLUME_BULAN);
        ms_smi22 += Number(val.MS_TAHUN_KUM);
        last_ms_smi22 += Number(val.LAST_MS_TAHUN_KUM);
        growth22 += Number(val.GROWTH_MOM);
        last_growth22 += Number(val.GROWTH_MOM_LAST);
        console.log(volume22);
        
    }
    })
    volume.push(volume22);
    ms_smi.push(ms_smi22);
     last_ms_smi.push(last_ms_smi22);
     growth.push(growth22);
     last_growth.push(last_growth22);
    console.log(logdata['DI Yogyakarta']);
    $.each(logdata['DI Yogyakarta'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume23 += Number(val.VOLUME_BULAN);
        ms_smi23 += Number(val.MS_TAHUN_KUM);
        last_ms_smi23 += Number(val.LAST_MS_TAHUN_KUM);
        growth23 += Number(val.GROWTH_MOM);
        last_growth23 += Number(val.GROWTH_MOM_LAST);
        console.log(volume23);
        
    }
    })
    volume.push(volume23);
    ms_smi.push(ms_smi23);
     last_ms_smi.push(last_ms_smi23);
     growth.push(growth23);
     last_growth.push(last_growth23);
    console.log(logdata['Kalimantan Timur']);
    $.each(logdata['Kalimantan Timur'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume24 += Number(val.VOLUME_BULAN);
        ms_smi24 += Number(val.MS_TAHUN_KUM);
        last_ms_smi24 += Number(val.LAST_MS_TAHUN_KUM);
        growth24 += Number(val.GROWTH_MOM);
        last_growth24 += Number(val.GROWTH_MOM_LAST);
        console.log(volume24);
        
    }
    })
    volume.push(volume24);
    ms_smi.push(ms_smi24);
     last_ms_smi.push(last_ms_smi24);
     growth.push(growth24);
     last_growth.push(last_growth24);
    console.log(logdata['Nusa Tenggara Timur']);
    $.each(logdata['Nusa Tenggara Timur'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume25 += Number(val.VOLUME_BULAN);
        ms_smi25 += Number(val.MS_TAHUN_KUM);
        last_ms_smi25 += Number(val.LAST_MS_TAHUN_KUM);
        growth25 += Number(val.GROWTH_MOM);
        last_growth25 += Number(val.GROWTH_MOM_LAST);
        console.log(volume25);
        
    }
    })
    volume.push(volume25);
    ms_smi.push(ms_smi25);
     last_ms_smi.push(last_ms_smi25);
     growth.push(growth25);
     last_growth.push(last_growth25);
    console.log(logdata['Papua']);
    $.each(logdata['Papua'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume26 += Number(val.VOLUME_BULAN);
        ms_smi26 += Number(val.MS_TAHUN_KUM);
        last_ms_smi26 += Number(val.LAST_MS_TAHUN_KUM);
        growth26 += Number(val.GROWTH_MOM);
        last_growth26 += Number(val.GROWTH_MOM_LAST);
        console.log(volume26);
        
    }
    })
    volume.push(volume26);
    ms_smi.push(ms_smi26);
     last_ms_smi.push(last_ms_smi26);
     growth.push(growth26);
     last_growth.push(last_growth26);
    console.log(logdata['Riau Kepulauan']);
    $.each(logdata['Riau Kepulauan'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume27 += Number(val.VOLUME_BULAN);
        ms_smi27 += Number(val.MS_TAHUN_KUM);
        last_ms_smi27 += Number(val.LAST_MS_TAHUN_KUM);
        growth27 += Number(val.GROWTH_MOM);
        last_growth27 += Number(val.GROWTH_MOM_LAST);
        console.log(volume27);
        
    }
    })
    volume.push(volume27);
    ms_smi.push(ms_smi27);
     last_ms_smi.push(last_ms_smi27);
     growth.push(growth27);
     last_growth.push(last_growth27);
    console.log(logdata['Sulawesi Barat']);
    $.each(logdata['Sulawesi Barat'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume28 += Number(val.VOLUME_BULAN);
        ms_smi28 += Number(val.MS_TAHUN_KUM);
        last_ms_smi28 += Number(val.LAST_MS_TAHUN_KUM);
        growth28 += Number(val.GROWTH_MOM);
        last_growth28 += Number(val.GROWTH_MOM_LAST);
        console.log(volume28);
        
    }
    })
    volume.push(volume28);
    ms_smi.push(ms_smi28);
     last_ms_smi.push(last_ms_smi28);
     growth.push(growth28);
     last_growth.push(last_growth28);
    console.log(logdata['Maluku']);
    $.each(logdata['Maluku'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume29 += Number(val.VOLUME_BULAN);
        ms_smi29 += Number(val.MS_TAHUN_KUM);
        last_ms_smi29 += Number(val.LAST_MS_TAHUN_KUM);
        growth29 += Number(val.GROWTH_MOM);
        last_growth29 += Number(val.GROWTH_MOM_LAST);
        console.log(volume29);
        
    }
    })
    volume.push(volume29);
    ms_smi.push(ms_smi29);
     last_ms_smi.push(last_ms_smi29);
     growth.push(growth29);
     last_growth.push(last_growth29);
    console.log(logdata['Bangka Belitung']);
    $.each(logdata['Bangka Belitung'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume30 += Number(val.VOLUME_BULAN);
        ms_smi30 += Number(val.MS_TAHUN_KUM);
        last_ms_smi30 += Number(val.LAST_MS_TAHUN_KUM);
        growth30 += Number(val.GROWTH_MOM);
        last_growth30 += Number(val.GROWTH_MOM_LAST);
        console.log(volume30);
        
    }
    })
    volume.push(volume30);
    ms_smi.push(ms_smi30);
     last_ms_smi.push(last_ms_smi30);
     growth.push(growth30);
     last_growth.push(last_growth30);
    console.log(logdata['Maluku Utara']);
    $.each(logdata['Maluku Utara'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume31 += Number(val.VOLUME_BULAN);
        ms_smi31 += Number(val.MS_TAHUN_KUM);
        last_ms_smi31 += Number(val.LAST_MS_TAHUN_KUM);
        growth31 += Number(val.GROWTH_MOM);
        last_growth31 += Number(val.GROWTH_MOM_LAST);
        console.log(volume31);
        
    }
    })
    volume.push(volume31);
    ms_smi.push(ms_smi31);
     last_ms_smi.push(last_ms_smi31);
     growth.push(growth31);
     last_growth.push(last_growth31);
    console.log(logdata['Papua Barat']);
    $.each(logdata['Papua Barat'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume32 += Number(val.VOLUME_BULAN);
        ms_smi32 += Number(val.MS_TAHUN_KUM);
        last_ms_smi32 += Number(val.LAST_MS_TAHUN_KUM);
        growth32 += Number(val.GROWTH_MOM);
        last_growth32 += Number(val.GROWTH_MOM_LAST);
        console.log(volume32);
        
    }
    })
    volume.push(volume32);
    ms_smi.push(ms_smi32);
     last_ms_smi.push(last_ms_smi32);
     growth.push(growth32);
     last_growth.push(last_growth32);
    console.log(logdata['Gorontalo']);
    $.each(logdata['Gorontalo'], function(key, val){
      //console.log(key+' '+val);
      if(key == '102' || key == '110' || key == '112'){
        volume33 += Number(val.VOLUME_BULAN);
        ms_smi33 += Number(val.MS_TAHUN_KUM);
        last_ms_smi33 += Number(val.LAST_MS_TAHUN_KUM);
        growth33 += Number(val.GROWTH_MOM);
        last_growth33 += Number(val.GROWTH_MOM_LAST);
        console.log(volume33);
        
    }
    })
    volume.push(volume33);
    ms_smi.push(ms_smi33);
     last_ms_smi.push(last_ms_smi33);
     growth.push(growth33);
     last_growth.push(last_growth33);
    
    console.log(volume);
    for(var y = 0;y<=(count-2); y++){
      
    isiprovinsi += '<tr><td align="left" >'+prop[y]+'</td><td align="left" >'+setFormat(volume[y],2) +'</td><td align="right">'+ setFormat(last_ms_smi[y],2)+' </td><td align="right">'+ setFormat(ms_smi[y],2) + '</td><td align="right">'+ setFormat(growth[y],2) + ' %</td></tr>';
   
          // provinsi = (logdata[y][b].PROVINSI);
          
        chartCategory.push(prop);
        chartData1.push(ms_smi);
      chartData2.push(last_ms_smi);
      chartDatax.push(growth);
        chartDatay.push(last_growth);

  chart(prop, tahun-1, tahun, ms_smi, last_ms_smi);
chart2(prop, tahun-1, tahun, growth, last_growth);
  //console.log(gwt);
  $('#isidetail').html(isiprovinsi);

  //console.log(isitable2);
	stop_waitMe('.wrapper');
}
    } 
 })
  }         
function chart(categorieslabel, last_year_label, year_label, Yeardata, lastYearData){
     Highcharts.chart('chart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Marketshare Province'
                    },
                     credits: {
                        enabled: false
                    },
                    xAxis: {
                        categories: categorieslabel,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.8,
                            pointWidth: 7,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: last_year_label,
                        data: lastYearData

                    }, {
                        name: year_label,
                        data: Yeardata

                    }]
                });
}


function chart2(categorieslabel2, last_year_label, year_label, Yeardata2, lastYearData2){
     Highcharts.chart('chart2', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Growth Province'
                    },
                     credits: {
                        enabled: false
                    },
                    xAxis: {
                        categories: categorieslabel2,
                        crosshair: true
                    },
                    yAxis: {
                        // min: 0,
                        
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.8,
                            pointWidth: 10,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: last_year_label,
                        data: lastYearData2

                    }, {
                        name: year_label,
                        data: Yeardata2

                    }]
                });
}
})

