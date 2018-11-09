
            function onLoad() {
var session = getParamFull();
                ////=========================
                if (sessionStorage.getItem('_com')!='ALL') {
                    $.each(listTab, function(index, el){
                        $('#tab-'+el+' a').removeAttr('href');
                        $('#tab-'+el+' a').removeAttr('rel');
                    })
                }
                ////=========================

     loadData(url_src+'/api/index.php/market_share/detail?region='+region+'&bulan='+(bulanSekarang-1)+'&tahun='+thn);
     $('.selmonth').change(function(){
                 bulanSekarang = $(this).val();
                  thn = $('.selyear').val(); 
                 // year = ($('.selyear').val())-1; 
                 region = ($('.selpulau').val());
                 var t = $(this).attr('rel');
                 
                 //loadData(url_src+'/SDRKAP_'+src_t+'Daily_all.php?tahun='+tahun+'&bulan='+bulanSekarang, t, '7000');
                 loadData(url_src+'/api/index.php/market_share/detail?region='+region+'&bulan='+bulanSekarang+'&tahun='+thn);
                 //loadData(url_src+'/market_share.php?tahun='+year+'&bulan='+bulanSekarang, 'last');
                })
                $('.selpulau').change(function(){
                 region = $(this).val();
                 thn = $('.selyear').val(); 
                 bulanSekarang = $('.selmonth').val(); 
                 var t = $(this).attr('rel');
                
                 //loadData(url_src+'/SDRKAP_'+src_t+'Daily_all.php?tahun='+tahun+'&bulan='+bulanSekarang, t, '7000');
                 loadData(url_src+'/api/index.php/market_share/detail?region='+region+'&bulan='+bulanSekarang+'&tahun='+thn);
                 //
                })
                $('.selyear').change(function(){
                 bulanSekarang = $('.selmonth').val();
                  thn = $(this).val(); 
                 // year = ($('.selyear').val())-1; 
                 region = ($('.selpulau').val());
                 var t = $(this).attr('rel');
                 
                 //loadData(url_src+'/SDRKAP_'+src_t+'Daily_all.php?tahun='+tahun+'&bulan='+bulanSekarang, t, '7000');
                 loadData(url_src+'/api/index.php/market_share/detail?region='+region+'&bulan='+bulanSekarang+'&tahun='+thn);
                 //loadData(url_src+'/market_share.php?tahun='+year+'&bulan='+bulanSekarang, 'last');
                })
                
 function loadData(datasrc, id){

 // run_waitMe('#data-sminas','facebook');  
         console.log(datasrc);
  
      $.ajax({
  url: datasrc,
  //url: url_src+'/api/index.php/market_share/detail?region=1&bulan=10',
  type : 'GET',
  success: function(data){
    var logdata = JSON.parse(data);
    console.log(logdata);
    var thispulau = $('.selpulau').val();
    var nmpulau = pulau[thispulau-1];
    $('#namapulau').html(nmpulau);
    var count = Object.keys(logdata).length;
    //console.log(count);
    for(var x = 1;x<=count; x++){
            if(x<10){
              var y = '0'+ x;
            }else{
              y = x;
            }        
       }
       var isitable1;
        var isitable2;
        var isitable3;
        var isitable4;
        var isitable5;
        var isitable6;
        var isitable7;
        var isitable8;
        var isitable9;
        var isitable10;
        var isitable11;
        var isitable12;
        var isitable13;
        var isiprovinsi;
        var namapt=[];
        var nama = [];
      var prov = [];
      var ms_thn;
    var volume = 0;
    var gwt = 0;
    var ms_smi = 0;
    var last_ms_smi = 0;
    var ms_smi1 = 0;
    var last_ms_smi1 = 0;
    var ms1 = 0;
    var last_ms1 = 0;
    var ms2 = 0;
    var last_ms2 = 0;
    var ms3 = 0;
    var last_ms3 = 0;
    var ms4 = 0;
    var last_ms4 = 0;
    var ms5 = 0;
    var last_ms5 = 0;
    var ms6 = 0;
    var last_ms6 = 0;
    var ms7 = 0;
    var last_ms7 = 0;
    var ms8 = 0;
    var last_ms8 = 0;
    var ms9 = 0;
    var last_ms9 = 0;
    var ms10 = 0;
    var last_ms10 = 0;
    var ms11 = 0;
    var last_ms11 = 0;
    var ms12 = 0;
    var last_ms12 = 0;
    var ms13 = 0;
    var last_ms13 = 0;
    var provinsi;
$('#isitabel').html(' ');
for(var y in logdata){
   
       namapt = (logdata[y]);
      //console.log(namapt);
      var hit = Object.keys(logdata[y]).length;
      //console.log(hit);
      for(var a = 1;a<=hit; a++){
            if(a<10){
              var b = '0'+ a;
            }else{
              b = a;
            }        
       } 
       for(var b in logdata[y]){
      nama = (logdata[y][b].PERUSAHAAN);
      if(nama == 'SEMEN GRESIK'|| nama == 'SEMEN PADANG' || nama == 'SEMEN TONASA'){
           volume += parseFloat(logdata[y][b].VOLUME_TAHUN_KUM);
      //console.log(volume);
      gwt += parseFloat(logdata[y][b].GROWTH_YOY);
         
      }
      volume += parseFloat(logdata[y][b].VOLUME_TAHUN_KUM);
      //console.log(volume);
      gwt += parseFloat(logdata[y][b].GROWTH_YOY);
      if(nama == 'SEMEN GRESIK'|| nama == 'SEMEN PADANG' || nama == 'SEMEN TONASA'){
           ms_smi = parseFloat(logdata[y][b].MS_TAHUN_KUM);
           last_ms_smi = parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
           provinsi = (logdata[y][b].PROVINSI);
           var growth = ((ms_smi-last_ms_smi)/last_ms_smi)*100;

          // var growth = parseFloat(logdata[y][b].GROWTH_YOY);
           //console.log(last_ms_smi);
    isiprovinsi += '<tr><td align="left" >'+provinsi+'</td><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms_smi,2)+' </td><td align="right">'+ setFormat(ms_smi,2) + '</td><td align="right">'+ setFormat(growth,2) + ' %</td></tr>';
   
        //console.log(nama+' = '+ms_gresik);
        //console.log(ms_thn);
      }
      $('#isitabel').html(isiprovinsi);


//======================================================================================================================================================================================================
      

      if(nama == 'SEMEN GRESIK'|| nama == 'SEMEN PADANG' || nama == 'SEMEN TONASA'){
           ms_smi1 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
           last_ms_smi1 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
           var growth1 = ((ms_smi1-last_ms_smi1)/last_ms_smi1)*100;
          // var growth = parseFloat(logdata[y][b].GROWTH_YOY);
           //console.log(last_ms_smi);
    isitable1 = '<tr><td align="left" >SEMEN INDONESIA</td><td align="right">'+ setFormat(last_ms_smi1,2)+' </td><td align="right">'+ setFormat(ms_smi1,2) + '</td><td align="right">'+ setFormat(growth1,2) + ' %</td></tr>';
   
        //console.log(nama+' = '+ms_gresik);
        //console.log(ms_thn);
      } else if(nama == 'CEMINDO GEMILANG'){
    ms2 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms2 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth2 = ((ms2-last_ms2)/last_ms2)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
    // console.log(last_ms);
      isitable2 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms2,2)+' </td><td align="right">'+ setFormat(ms2,2) + '</td><td align="right">'+ setFormat(grwth2,2) + ' %</td></tr>';
      }
      else if(nama == 'INDOCEMENT TUNGGAL PRAKARSA'){
    ms3 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms3 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth3 = ((ms3-last_ms3)/last_ms3)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
    // console.log(last_ms);
      isitable3 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms3,2)+' </td><td align="right">'+ setFormat(ms3,2) + '</td><td align="right">'+ setFormat(grwth3,2) + ' %</td></tr>';
      }else if(nama == 'HOLCIM INDONESIA'){
    ms4 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms4 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth4 = ((ms4-last_ms4)/last_ms4)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
    // console.log(last_ms);
      isitable4 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms4,2)+' </td><td align="right">'+ setFormat(ms4,2) + '</td><td align="right">'+ setFormat(grwth4,2) + ' %</td></tr>';
      }   else if(nama == 'JUI SHIN INDONESIA'){
    ms5 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms5 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth5 = ((ms5-last_ms5)/last_ms5)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
    // console.log(last_ms);
      isitable5 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms5,2)+' </td><td align="right">'+ setFormat(ms5,2) + '</td><td align="right">'+ setFormat(grwth5,2) + ' %</td></tr>';
      }   else if(nama == 'SEMEN JAWA'){
    ms6 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms6 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth6 = ((ms6-last_ms6)/last_ms6)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
    // console.log(last_ms);
      isitable6 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms6,2)+' </td><td align="right">'+ setFormat(ms6,2) + '</td><td align="right">'+ setFormat(grwth6,2) + ' %</td></tr>';
      }   else if(nama == 'SINAR TAMBANG ARTHALESTARI'){
    ms7 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms7 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth7 = ((ms7-last_ms7)/last_ms7)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
    // console.log(last_ms);
      isitable7 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms7,2)+' </td><td align="right">'+ setFormat(ms7,2) + '</td><td align="right">'+ setFormat(grwth7,2) + ' %</td></tr>';
      }  else if(nama == 'CONCH CEMENT INDONESIA'){
    ms8 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms8 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth8 = ((ms8-last_ms8)/last_ms8)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
     //console.log(last_ms);
      isitable8 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms8,2)+' </td><td align="right">'+ setFormat(ms8,2) + '</td><td align="right">'+ setFormat(grwth8,2) + ' %</td></tr>';
      }  else if(nama == 'SEMEN BOSOWA MAROS'){
    ms9 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms9 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth9 = ((ms9-last_ms9)/last_ms9)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
     //console.log(last_ms);
      isitable9 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms9,2)+' </td><td align="right">'+ setFormat(ms9,2) + '</td><td align="right">'+ setFormat(grwth9,2) + ' %</td></tr>';
      }   else if(nama == 'SEMEN KUPANG'){
    ms10 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms10 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth10 = ((ms10-last_ms10)/last_ms10)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
     //console.log(last_ms);
      isitable10 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms10,2)+' </td><td align="right">'+ setFormat(ms10,2) + '</td><td align="right">'+ setFormat(grwth10,2) + ' %</td></tr>';
      }   else if(nama == 'BATU RAJA'){
    ms11 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms11 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth11 = ((ms11-last_ms11)/last_ms11)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
     //console.log(last_ms);
      isitable11 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms11,2)+' </td><td align="right">'+ setFormat(ms11,2) + '</td><td align="right">'+ setFormat(grwth11,2) + ' %</td></tr>';
      }   
      else if(nama == 'PT LAFARGE CEMENT INDONESIA'){
    ms12 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms12 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth12 = ((ms12-last_ms12)/last_ms12)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
     //console.log(last_ms);
      isitable12 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms12,2)+' </td><td align="right">'+ setFormat(ms12,2) + '</td><td align="right">'+ setFormat(grwth12,2) + ' %</td></tr>';
      }   else {
    ms13 += parseFloat(logdata[y][b].MS_TAHUN_KUM);
      
     last_ms13 += parseFloat(logdata[y][b].LAST_MS_TAHUN_KUM);
     var grwth13 = ((ms13-last_ms13)/last_ms13)*100;
     //var grwth = parseFloat(logdata[y][b].GROWTH_YOY);
     //console.log(last_ms);
      isitable13 = '<tr><td align="left" >'+nama+'</td><td align="right">'+ setFormat(last_ms13,2)+' </td><td align="right">'+ setFormat(ms13,2) + '</td><td align="right">'+ setFormat(grwth13,2) + ' %</td></tr>';
      }   
  }
  }
  var v = setFormat((volume/1000000),2);

$('#vol').html(v+' M');
$('#gwt_all').html(setFormat(gwt,2));
  //console.log(gwt);
  $('#isidetail').html(isitable1+isitable2+isitable3+isitable4+isitable5+isitable6+isitable7+isitable8+isitable9+isitable10+isitable11+isitable12+isitable13);

  //console.log(isitable2);
    } 
 })
  }
}