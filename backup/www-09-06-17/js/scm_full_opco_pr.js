
        function scm_full_detail(tahun, bulan, opco){

        	var param = '?tahun='+tahun+'&bulan='+bulan;
            
 			run_waitMe('.wrapper', 'ios');

	          $.ajax({

	            //url: url,
	            url: url_src+'/api/index.php/produksi_smig/prod_data'+param,
	            type: 'GET',
	            success: function (data) {

	                // var data = eval('(' + data + ')');
	                // console.log(data);

	                // var spro = parseFloat(data.semen['s'+opco].prognose).toFixed(2);
	                // var svpro = parseInt(data.semen['s'+opco].vol_prog);
	                // var srela = parseInt(data.semen['s'+opco].realisasi);

	                // var tpro = parseFloat(data.terak['s'+opco].prognose).toFixed(2);
	                // var tvpro = parseInt(data.terak['s'+opco].vol_prog);
	                // var trela = parseInt(data.terak['s'+opco].realisasi);

	                console.log(data);
                	var produksi = JSON.parse(data);
                	console.log(produksi);
                	console.log(opco);


                	var REAL1 = Number(produksi['Terak_'+opco]['REALISASI']);
                	var RKAPSD1 = Number(produksi['Terak_'+opco]['RKAP_SD']);
                	var REAL2 = Number(produksi['Semen_'+opco]['REALISASI']);
                	var RKAPSD2 = Number(produksi['Semen_'+opco]['RKAP_SD']);
                	$('#T_REAL').html(setFormat(REAL1,0,",","."));
                	$('#T_RKAPSD').html(setFormat(RKAPSD1,0,",","."));
                	var SELISIH1 = Number(REAL1-RKAPSD1);
					$('#T_SLSH').html(setFormat(SELISIH1,0,",","."));
                	var PERSEN1 = division(REAL1,RKAPSD1)*100;
					$('#T_PRS').html(setFormat(PERSEN1,1)+" %"); 


					$('#S_REAL').html(setFormat(REAL2,0,",","."));
                	$('#S_RKAPSD').html(setFormat(RKAPSD2,0,",","."));
                	var SELISIH2 = Number(REAL2-RKAPSD2);
					$('#S_SLSH').html(setFormat(SELISIH2,0,",","."));
                	var PERSEN2 = division(REAL2,RKAPSD2)*100;
					$('#S_PRS').html(setFormat(PERSEN2,1)+" %");

	               
	              
	                //var cmprog = parseFloat(data.Semen.prognose).toFixed(0);
	                
	                
	                
	               
	                // $('#sprogv').html(FormatNumberBy3(spro, ",", "."));
	                // $('#clin_now').html(setFormat(clin_now, 0)+' B');


	                // $('#sprogvx').html(FormatNumberBy3(spro, ",", ".")+ ' %');
	                // $('#svprov').html(FormatNumberBy3(svpro, ",", "."));
	                // $('#srelav').html(setFormat(srela, 0));
	                // $('#tprogv').html(FormatNumberBy3(tpro, ",", ".")+ ' %');
	                // $('#tvprov').html(FormatNumberBy3(tvpro, ",", "."));
	                // $('#trelav').html(setFormat(trela, 0));

	               // console.log(per_cm);
	                // if ( tpro >= 100 ){
	                //          $('#headcolp1').addClass('grunder');
	                //          $('#boxcolp1').addClass('grind'); 
	                //    }else {

	                //    }
	                // if (spro >= 100)  {
	                //          $('#headcolp').addClass('grunder');
	                //          $('#boxcolp').addClass('grind');   
	                //    }else {
	                        
	                //    }
	                    
	                //$('#clprogv').html(clprog);
	              
	                //console.log(per_cm);
	                        
	                
	                             
	                //console.log(cmreal);
	                stop_waitMe('.wrapper');

	            }
	        }).done(function (data) {
	        }).fail(function () {
	        	

	        });

        }


        function division($a,$b){
                	    
    				if($a == 0 || $a == null){
    					return 0;
    				}else if($b == 0 || $b == null){
    					return 1;
    				}
    				else{
    					$tmp = $a/$b;  
    					
    					return $tmp;
    				}

	    }
