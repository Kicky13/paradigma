// function onLoad() {
var session = getParamFull();
                ////=========================
                if (sessionStorage.getItem('_com')!='ALL') {
                    $.each(listTab, function(index, el){
                        $('#tab-'+el+' a').removeAttr('href');
                        $('#tab-'+el+' a').removeAttr('rel');
                    })
                }
                ////=========================
 //    var bulan = bulanSekarang - 1;
 //    // var year = tahun;
 //    if (bulan==0) {
 //        bulan = 12;
 //        tahun = tahun-1;
 //        year = tahun -1;
 //    }

 //    loadData(url_src + '/api/index.php/market_share?tahun=' + tahun + '&bulan=' + bulan, 'current', bulan, tahun);
 //    loadData(url_src + '/api/index.php/market_share?tahun=' + year + '&bulan=' + bulan, 'last', bulan, tahun);
 //    $('.selmonth').change(function() {
 //        bulanSekarang = $(this).val();
 //        tahun = $('.selyear').val();
 //        year = ($('.selyear').val()) - 1;
	//    setParam('',bulanSekarang, tahun);
	// console.log(bulanSekarang+' '+tahun);
 //        var t = $(this).attr('rel');

 //        //loadData(url_src+'/SDRKAP_'+src_t+'Daily_all.php?tahun='+tahun+'&bulan='+bulanSekarang, t, '7000');

 //        // loadData(url_src+'/market_share.php?tahun='+tahun+'&bulan='+bulanSekarang, 'current', bulan, tahun);
 //        // loadData(url_src+'/market_share.php?tahun='+year+'&bulan='+bulanSekarang, 'last', bulan, tahun);
 //        // run_waitMe('.wrapper', 'ios');
 //        loadData(url_src + '/api/index.php/market_share?tahun=' + tahun + '&bulan=' + bulanSekarang, 'current', bulan, tahun);
 //        loadData(url_src + '/api/index.php/market_share?tahun=' + year + '&bulan=' + bulanSekarang, 'last', bulan, tahun);
 //        // stop_waitMe('.wrapper');
 //    })
 //    $('.selyear').change(function() {
 //        tahun = $(this).val();
 //        year = ($(this).val()) - 1;
 //        bulanSekarang = $('.selmonth').val();
	//    setParam('',bulanSekarang, tahun);
 //        var t = $(this).attr('rel');

 //        //loadData(url_src+'/SDRKAP_'+src_t+'Daily_all.php?tahun='+tahun+'&bulan='+bulanSekarang, t, '7000');
 //        // run_waitMe('.wrapper', 'ios');
 //        loadData(url_src + '/api/index.php/market_share?tahun=' + tahun + '&bulan=' + bulanSekarang, 'current', bulan, tahun);
 //        loadData(url_src + '/api/index.php/market_share?tahun=' + year + '&bulan=' + bulanSekarang, 'last', bulan, tahun);
 //        // stop_waitMe('.wrapper');
 //    })

    // $('.selyear').change(function(){
    //   bulanSekarang = $(this).val();
    //  tahun = ($('.selyear').val()-1);   
    //  var t = $(this).attr('rel');

    //  //loadData(url_src+'/SDRKAP_'+src_t+'Daily_all.php?tahun='+tahun+'&bulan='+bulanSekarang, t, '7000');
    //  loadData(url_src+'/market_share.php?tahun='+tahun+'&bulan='+bulanSekarang, 'last');
    // })
    function loadData(datasrc, id, bulan, tahun) {

        console.log(datasrc);
        // run_waitMe('.wrapper', 'ios');
        //run_waitMe('#data-sminas','facebook');  
        // console.log(datasrc);
        // 
         var thisyear = $('.seltahun').val();
        //console.log(thisyear);
        //var lastyear = moment().format('YYYY')-1;
        //console.log(lastyear);
        $('#now').html(tahun);
        $('#last').html(tahun - 1);
        var lastyear = tahun - 1;
        var bln = $('.selbulan').val();
        var thismo = month[bln-1];

        console.log(bln); 
        $('#thismonth').html(thismo + ' ' + tahun);
        $('#thismolast').html(thismo + ' ' + lastyear);
        $('#upto').html('Up To ' + thismo + ' ' + tahun);
        $('#uptolast').html('Up To ' + thismo + ' ' + lastyear);
        $('#tagthismonth').html(thismo);
        $('#tagthismolast').html(thismo);
        $('#tagupto').html('Up To ' + thismo);
        $('#taguptolast').html('Up To ' + thismo);
        if (id == 'current') {
            $('#qtybulan').html('0');
            $('#msbulan').html('0');
            $('#mstahun').html('0');
            $('#qtytahun').html('0');
            $('#growth').html('0');
            $('#growthtahun').html('0');
            $('#isidetail1').html(' ');
            $('#isidetail2').html(' ');
            $('#isidetail3').html(' ');
            $('#isidetail4').html(' ');
            $('#isidetail5').html(' ');
            $('#isidetail6').html(' ');
        } else {
            $('#qtybulan1').html('0');
            $('#msbulan1').html('0');
            $('#mstahun1').html('0');
            $('#qtytahun1').html('0');
            $('#growth1').html('0');
            $('#growthtahun1').html('0');
            $('#isidetaila').html(' ');
            $('#isidetailb').html(' ');
            $('#isidetailc').html(' ');
            $('#isidetaild').html(' ');
            $('#isidetaile').html(' ');
            $('#isidetailf').html(' ');
        }


        var qtybulan = 0;
        var qtytahun = 0;
        var msbulan = 0;
        var mstahun = 0;
        var growth = 0;
        var growthtahun = 0;
        var qtybulan1 = 0;
        var qtytahun1 = 0;
        var msbulan1 = 0;
        var mstahun1 = 0;
        var growth1 = 0;
        var growthtahun1 = 0;

        var namagr;
        var namapd;
        var namatn;


        $.ajax({
            url: datasrc,
            //url: 'http://localhost/www/MSNasional.json'
            type: 'GET',
            success: function(data) {
                // var a = JSON.parse(data);
                var a = paradigma.json_parse(data);
                //console.log(a);
               

                var qty_bulan7000 = parseFloat(a['7000'].VOLUME_BULAN);
                var qty_bulan3000 = parseFloat(a['3000'].VOLUME_BULAN);
                var qty_bulan4000 = parseFloat(a['4000'].VOLUME_BULAN);
                qty_bulan_ini = (qty_bulan7000 + qty_bulan3000 + qty_bulan4000) / 1000;
                qty_bulan_ini1 = (qty_bulan7000 + qty_bulan3000 + qty_bulan4000) / 1000;
                qty_bulan_ini = (qty_bulan7000 + qty_bulan3000 + qty_bulan4000) / 1000;
                qty_bulan_ini1 = (qty_bulan7000 + qty_bulan3000 + qty_bulan4000) / 1000;
                //$('#qtybulan').html(setFormat(qty_bulan_ini,2));
                //console.log(qty_bulan_ini);

                var ms_bulan7000 = parseFloat(a['7000'].MS_BULAN);
                var ms_bulan3000 = parseFloat(a['3000'].MS_BULAN);
                var ms_bulan4000 = parseFloat(a['4000'].MS_BULAN);
                var ms_bulan_kum = ms_bulan7000 + ms_bulan3000 + ms_bulan4000;
                var ms_bulan_kum1 = ms_bulan7000 + ms_bulan3000 + ms_bulan4000;
                //$('#msbulan').html((setFormat(ms_bulan_kum,2)+' %'));
                //console.log(ms_bulan_kum);

                var ms_tahun7000_kum = parseFloat(a['7000'].MS_TAHUN_KUM);
                var ms_tahun3000_kum = parseFloat(a['3000'].MS_TAHUN_KUM);
                var ms_tahun4000_kum = parseFloat(a['4000'].MS_TAHUN_KUM);
                var ms_tahun_kum = ms_tahun7000_kum + ms_tahun3000_kum + ms_tahun4000_kum;
                var ms_tahun_kum1 = ms_tahun7000_kum + ms_tahun3000_kum + ms_tahun4000_kum;
                //$('#mstahun').html((setFormat(ms_tahun_kum,2)+' %'));
                //console.log(ms_tahun_kum);

                var qty_tahun7000_kum = parseFloat(a['7000'].TAHUN_VOLUME_KUM);
                var qty_tahun3000_kum = parseFloat(a['3000'].TAHUN_VOLUME_KUM);
                var qty_tahun4000_kum = parseFloat(a['4000'].TAHUN_VOLUME_KUM);
                var qty_tahun_kum = (qty_tahun7000_kum + qty_tahun3000_kum + qty_tahun4000_kum) / 1000;
                var qty_tahun_kum1 = (qty_tahun7000_kum + qty_tahun3000_kum + qty_tahun4000_kum) / 1000;
                //$('#qtytahun').html(setFormat(qty_tahun_kum,2));
                // console.log(qty_tahun_kum);
                var mom7000 = parseFloat(a['7000']['GROWTH'].MOM);
                var mom3000 = parseFloat(a['3000']['GROWTH'].MOM);
                var mom4000 = parseFloat(a['4000']['GROWTH'].MOM);
                // var total_mom = mom7000 + mom3000 + mom4000;
                // var total_mom1 = mom7000 + mom3000 + mom4000;
                var total_mom = parseFloat(a['smi']['GROWTH'].MOM);
                var total_mom1 = parseFloat(a['smi']['GROWTH'].MOM);

                //console.log(total_mom);
                var momtahun7000 = parseFloat(a['7000']['GROWTH'].KUM_YOY);
                var momtahun3000 = parseFloat(a['3000']['GROWTH'].KUM_YOY);
                var momtahun4000 = parseFloat(a['4000']['GROWTH'].KUM_YOY);
                // var total_momtahun = momtahun7000 + momtahun3000 + momtahun4000;
                // var total_momtahun1 = momtahun7000 + momtahun3000 + momtahun4000;
                var total_momtahun = parseFloat(a['smi']['GROWTH'].KUM_YOY);
                var total_momtahun1 = parseFloat(a['smi']['GROWTH'].KUM_YOY);

                var rkap = parseFloat(a['smi'].TARGET);
                //console.log(total_momtahun);

                var nama7000 = (a['7000'].NAMA);
                var nama3000 = (a['3000'].NAMA);
                var nama4000 = (a['4000'].NAMA);
                //console.log(nama7000);


                var isitable1 = '<td align="left" >' + nama7000 + '</td><td align="right">' + setFormat(qty_bulan7000, 2) + ' </td><td align="right">' + ms_bulan7000 + '</td><td align="right">' + mom7000 + ' %</td></tr>';
                var isitable2 = '<td align="left">' + nama3000 + '</td><td align="right">' + setFormat(qty_bulan3000, 2) + ' </td><td align="right">' + ms_bulan3000 + '</td><td align="right">' + mom3000 + ' %</td></tr>';
                var isitable3 = '<td align="left">' + nama4000 + '</td><td align="right">' + setFormat(qty_bulan4000, 2) + ' </td><td align="right">' + ms_bulan4000 + '</td><td align="right">' + mom4000 + ' %</td></tr>';
                var isitable4 = '<td align="left">' + nama7000 + '</td><td align="right">' + setFormat(qty_tahun7000_kum, 2) + ' </td><td align="right">' + ms_tahun7000_kum + '</td><td align="right">' + momtahun7000 + ' %</td></tr>';
                var isitable5 = '<td align="left">' + nama3000 + '</td><td align="right">' + setFormat(qty_tahun3000_kum, 2) + ' </td><td align="right">' + ms_tahun3000_kum + '</td><td align="right">' + momtahun3000 + ' %</td></tr>';
                var isitable6 = '<td align="left">' + nama4000 + '</td><td align="right">' + setFormat(qty_tahun4000_kum, 2) + ' </td><td align="right">' + ms_tahun4000_kum + '</td><td align="right">' + momtahun4000 + ' %</td></tr>';


                if (id == 'current') {
                    $('#qtybulan').html(setFormat(qty_bulan_ini, 2));
                    $('#msbulan').html((setFormat(ms_bulan_kum, 2) + ' %'));

                    
                    
                    if (parseFloat(ms_bulan_kum)<=2) {
                        $('#tagthismonth').removeClass('redunder');
                        $('#indthismonth').removeClass('redind');
                        $('#tagthismonth').addClass('ylunder');
                        $('#indthismonth').addClass('ylind');
                    }
                    if (parseFloat(ms_bulan_kum)>=rkap) {
                        $('#tagthismonth').removeClass('redunder');
                        $('#indthismonth').removeClass('redind');
                        $('#tagthismonth').addClass('grunder');
                        $('#indthismonth').addClass('grind');
                    }
                    if (parseFloat(ms_bulan_kum)<=2) {
                        $('#tagthismolast').removeClass('redunder');
                        $('#indthismolast').removeClass('redind');
                        $('#tagthismolast').addClass('ylunder');
                        $('#indthismolast').addClass('ylind');
                    }
                    if (parseFloat(ms_bulan_kum)>=rkap) {
                        $('#tagthismolast').removeClass('redunder');
                        $('#indthismolast').removeClass('redind');
                        $('#tagthismolast').addClass('grunder');
                        $('#indthismolast').addClass('grind');
                    }

                    $('#mstahun').html((setFormat(ms_tahun_kum, 2) + ' %'));
                    $('#qtytahun').html(setFormat(qty_tahun_kum, 2));
                    $('#growth').html((setFormat(total_mom, 2) + ' %'));
                    $('#growthtahun').html((setFormat(total_momtahun, 2) + ' %'));
                    $('#isidetail1').html(isitable1);
                    $('#isidetail2').html(isitable2);
                    $('#isidetail3').html(isitable3);
                    $('#isidetail4').html(isitable4);
                    $('#isidetail5').html(isitable5);
                    $('#isidetail6').html(isitable6);

                } else {
                    $('#qtybulan1').html(setFormat(qty_bulan_ini, 2));
                    $('#msbulan1').html((setFormat(ms_bulan_kum, 2) + ' %'));
                    if (parseFloat(ms_bulan_kum)<=2) {
                        $('#tagthismonth').removeClass('redunder');
                        $('#indthismonth').removeClass('redind');
                        $('#tagthismonth').addClass('ylunder');
                        $('#indthismonth').addClass('ylind');
                    }
                    if (parseFloat(ms_bulan_kum)>=rkap) {
                        $('#tagthismonth').removeClass('redunder');
                        $('#indthismonth').removeClass('redind');
                        $('#tagthismonth').addClass('grunder');
                        $('#indthismonth').addClass('grind');
                    }
                    if (parseFloat(ms_bulan_kum)<=2) {
                        $('#tagthismolast').removeClass('redunder');
                        $('#indthismolast').removeClass('redind');
                        $('#tagthismolast').addClass('ylunder');
                        $('#indthismolast').addClass('ylind');
                    }
                    if (parseFloat(ms_bulan_kum)>=rkap) {
                        $('#tagthismolast').removeClass('redunder');
                        $('#indthismolast').removeClass('redind');
                        $('#tagthismolast').addClass('grunder');
                        $('#indthismolast').addClass('grind');
                    }
                    $('#mstahun1').html((setFormat(ms_tahun_kum, 2) + ' %'));
                    $('#qtytahun1').html(setFormat(qty_tahun_kum, 2));
                    $('#growth1').html((setFormat(total_mom, 2) + ' %'));
                    $('#growthtahun1').html((setFormat(total_momtahun, 2) + ' %'));
                    $('#isidetaila').html(isitable1);
                    $('#isidetailb').html(isitable2);
                    $('#isidetailc').html(isitable3);
                    $('#isidetaild').html(isitable4);
                    $('#isidetaile').html(isitable5);
                    $('#isidetailf').html(isitable6);
                }

                stop_waitMe('.wrapper');

            }
        })
    }
// }