
        function scm_full_detail(tahun, bulan, opco){

        	var param = '?tahun='+tahun+'&bulan='+bulan;
            
 			run_waitMe('.wrapper', 'ios');

	          $.ajax({

	            //url: url,
	            url: url_src+'/api/index.php/produksi_smig'+param,
	            type: 'GET',
	            success: function (data) {

	                var data = eval('(' + data + ')');
	                console.log(data);

	                var spro = parseFloat(data.semen['s'+opco].prognose).toFixed(2);
	                var svpro = parseInt(data.semen['s'+opco].vol_prog);
	                var srela = parseInt(data.semen['s'+opco].realisasi);

	                var tpro = parseFloat(data.terak['s'+opco].prognose).toFixed(2);
	                var tvpro = parseInt(data.terak['s'+opco].vol_prog);
	                var trela = parseInt(data.terak['s'+opco].realisasi);

	               
	              
	                //var cmprog = parseFloat(data.Semen.prognose).toFixed(0);
	                
	                
	                
	               
	                // $('#sprogv').html(FormatNumberBy3(spro, ",", "."));
	                // $('#clin_now').html(setFormat(clin_now, 0)+' B');
	                $('#sprogvx').html(FormatNumberBy3(spro, ",", ".")+ ' %');
	                $('#svprov').html(FormatNumberBy3(svpro, ",", "."));
	                $('#srelav').html(setFormat(srela, 0));
	                $('#tprogv').html(FormatNumberBy3(tpro, ",", ".")+ ' %');
	                $('#tvprov').html(FormatNumberBy3(tvpro, ",", "."));
	                $('#trelav').html(setFormat(trela, 0));

	               // console.log(per_cm);
	                if ( tpro >= 100 ){
	                         $('#headcolp1').addClass('grunder');
	                         $('#boxcolp1').addClass('grind'); 
	                   }else {

	                   }
	                if (spro >= 100)  {
	                         $('#headcolp').addClass('grunder');
	                         $('#boxcolp').addClass('grind');   
	                   }else {
	                        
	                   }
	                    
	                //$('#clprogv').html(clprog);
	              
	                //console.log(per_cm);
	                        
	                
	                             
	                //console.log(cmreal);
	                stop_waitMe('.wrapper');

	            }
	        }).done(function (data) {
	        }).fail(function () {
	        	

	        });


	        

        }
