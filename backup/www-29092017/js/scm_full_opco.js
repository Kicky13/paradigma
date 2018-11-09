
        function scm_full_detail(tahun, bulan, opco){

        	var param = '?tahun='+tahun+'&bulan='+bulan;
            $.ajax({
	            //url: url,
	            url: url_src+'/api/index.php/stokppudang/stoks'+opco+param,
	            type: 'GET',
	            success: function (data) {

	                var data = eval('(' + data + ')');
	                console.log(data);
	                var cmreal = parseFloat(data.Semen.realisasi).toFixed(0);
	                //var cmprog = parseFloat(data.Semen.prognose).toFixed(0);
	                var cmmax = parseFloat(data.Semen.max_stock).toFixed(0);
	                var clreal = parseFloat(data.Terak.realisasi).toFixed(0);
	                //var clprog = parseFloat(data.Terak.prognose).toFixed(0);
	                var clmax = parseFloat(data.Terak.max_stock).toFixed(0);
	                var per_cm = ((cmreal) / (cmmax)) * 100;
	                var per_cl = (Number(clreal) / Number(clmax)) * 100;
	                if(cmreal == 'NaN' && clreal == 'NaN' ){
	                        cmreal = 0;
	                        cmmax = 0;
	                        clreal = 0;
	                        clmax = 0;
	                        per_cm = 0;
	                        per_cl = 0;
	                    }else{

	                    }

	                console.log(cmreal);
	                console.log(typeof(cmreal));
	                
	                $('#cmrealv').html(FormatNumberBy3(cmreal, ",", "."));
	               // $('#cmprogv').html(cmprog);   
	                $('#cmmaxv').html(FormatNumberBy3(cmmax, ",", "."));
	                $('#clrealv').html(FormatNumberBy3(clreal, ",", "."));
	                //$('#clprogv').html(clprog);
	                $('#clmaxv').html(FormatNumberBy3(clmax, ",", "."));
	                    
	                
	                //console.log(per_cm);
	                        
	                $('#per_cmv').html(FormatNumberBy3(per_cm.toFixed(2).replace(".", ","), ",", ".")+ ' %');
	                $('#per_clv').html(FormatNumberBy3(per_cl.toFixed(2).replace(".", ","), ",", ".")+ ' %');
	                
	                if ( per_cm >= 80 && per_cm <= 100){
	                         $('#headcolm').addClass('ylunder');
	                         $('#boxcolm').addClass('ylind'); 
	                         $('#headcolm').removeClass('grunder');
	                         $('#boxcolm').removeClass('grind');
	                         $('#headcolm').removeClass('redunder');
	                         $('#boxcolm').removeClass('redind');
	                   }else if ( per_cm >= 50 && per_cm <= 80 ) {
	                   		 $('#headcolm').removeClass('ylunder');
	                         $('#boxcolm').removeClass('ylind');
	                         $('#headcolm').addClass('grunder');
	                         $('#boxcolm').addClass('grind');
	                         $('#headcolm').removeClass('redunder');
	                         $('#boxcolm').removeClass('redind');
	                   }
	                   else if ( per_cm >= 100 ) {
	                         $('#headcolm').addClass('grunder');
	                         $('#boxcolm').addClass('grind');
	                         $('#headcolm').removeClass('ylunder');
	                         $('#boxcolm').removeClass('ylind');
	                         $('#headcolm').removeClass('redunder');
	                         $('#boxcolm').removeClass('redind');
	                   }else{
	                   		 $('#headcolm').removeClass('grunder');
	                         $('#boxcolm').removeClass('grind');
	                         $('#headcolm').removeClass('ylunder');
	                         $('#boxcolm').removeClass('ylind');
	                   }
	               // console.log(per_cm);
	                if ( per_cl >= 80 && per_cl <= 100){
	                         $('#headcolc').addClass('ylunder');
	                         $('#boxcolc').addClass('ylind'); 
	                         $('#headcolc').removeClass('grunder');
	                         $('#boxcolc').removeClass('grind'); 
	                         $('#headcolc').removeClass('redunder');
	                         $('#boxcolc').removeClass('redind');
	                   }else if ( per_cl >= 50 && per_cl <= 80 ) {
	                         $('#headcolc').removeClass('ylunder');
	                         $('#boxcolc').removeClass('ylind');
	                         $('#headcolc').addClass('grunder');
	                         $('#boxcolc').addClass('grind');
	                         $('#headcolc').removeClass('redunder');
	                         $('#boxcolc').removeClass('redind');
	                   }
	                    else if ( per_cm >= 100 ) {
	                         $('#headcolc').addClass('grunder');
	                         $('#boxcolc').addClass('grind');
	                         $('#headcolc').removeClass('ylunder');
	                         $('#boxcolc').removeClass('ylind');
	                         $('#headcolc').removeClass('redunder');
	                         $('#boxcolc').removeClass('redind');
	                   }else{
	                   		 $('#headcolc').removeClass('grunder');
	                         $('#boxcolc').removeClass('grind');
	                         $('#headcolc').removeClass('ylunder');
	                         $('#boxcolc').removeClass('ylind');
	                   }
	               
	                //console.log(cmreal);

	            }
	        }).done(function (data) {
	        }).fail(function () {

	        });


	          $.ajax({

	            //url: url,
	            url: url_src+'/api/index.php/produksi_smig'+param,
	            type: 'GET',
	            success: function (data) {

	                var data = eval('(' + data + ')');
	                // console.log(data);

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
	                $('#srelav').html(setFormat(srela, 2));
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

	            }
	        }).done(function (data) {
	        }).fail(function () {

	        });


	                    run_waitMe('.wrapper', 'ios');
	        $.ajax({

	            //url: url,
	            url: url_src+'/api/index.php/volproduksi'+opco+param,
	            type: 'GET',
	            success: function (data) {
	                var per_ex ='';

	                var data = eval('(' + data + ')');
	                console.log(data);

	                var dreal = parseInt(data['s'+opco].dom.real_sdk);
	                var drkap = parseInt(data['s'+opco].dom.rkap_sdk);
	                var dmin = (data['s'+opco].dom.selisih);

	                var ereals = parseInt(data.ekspor.real_sm);
	                var erealt = parseInt(data.ekspor.real_tr);
	                var erkaps = parseFloat(data.ekspor.rkap_eks);

	                var gd_up = parseFloat(data.growth.dom_real).toFixed(1);
	                var gd_dw = parseFloat(data.growth.dom_prog).toFixed(1);
	                var ge = parseFloat(data.growth.ekspor_real).toFixed(1);
	                var tot = parseFloat(data.growth.total).toFixed(1);
	               
	                 var per_dm = ((dreal) / (drkap)) * 100;
	                 

	                 if (ereals == 0){
	                    per_ex = 0;
	                 }else if (erkaps == 0){
	                    erkaps = 0;
	                    per_ex = 0;
	                 } else{
	                 per_ex = ((ereals) / (erkaps)) * 100;
	                }
	               
	               if (tot == "NaN" || tot== 0){
                        tot = gd_up;
                     } else{
                     
                    }
                    if(erkaps == 'NaN'){
	                 	erkaps = 0;
	                 	per_ex = 0;
	                 }else{

	                 }

	                $('#dreal').html(FormatNumberBy3(dreal, ",", "."));
	                $('#drkap').html(FormatNumberBy3(drkap, ",", "."));
	                $('#dmin').html(dmin.toFixed(0));
	               $('#perd').html(FormatNumberBy3(per_dm.toFixed(1).replace(".", ","), ",", ".")+ ' <span style="font-size: 12px;">%</span>');

	                $('#erls').html(FormatNumberBy3(ereals, ",", "."));
	                $('#erlt').html(FormatNumberBy3(erealt, ",", "."));
	                $('#erks').html(FormatNumberBy3(erkaps, ",", "."));
	                $('#pere').html(FormatNumberBy3(per_ex.toFixed(1).replace(".", ","), ",", ".")+ ' <span style="font-size: 12px;">%</span>');

	                $('#dl').html(gd_up+' % / '+gd_dw+' %');
	                $('#ec').html(ge+' %');
	                $('#tota').html(tot+' %');
	             

	               // console.log(per_cm);
	                if ( per_dm >= 90 && per_dm <= 100 ){
	                         $('#headcold').addClass('ylunder');
	                         $('#boxcold').addClass('ylind');
	                         $('#headcold').removeClass('redunder');
	                         $('#boxcold').removeClass('redind');
	                   }else if (per_dm >= 100)  {
	                         $('#headcold').addClass('grunder');
	                         $('#boxcold').addClass('grind'); 
	                         $('#headcold').removeClass('redunder');
	                         $('#boxcold').removeClass('redind');  
	                   }else {
	                        
	                   }

	                   if ( per_ex >= 90 && per_ex <= 100 ){
	                         $('#headcole').addClass('ylunder');
	                         $('#boxcole').addClass('ylind');
	                         $('#headcole').removeClass('redunder');
	                         $('#boxcole').removeClass('redind');
	                   }else if (per_ex >= 100)  {
	                         $('#headcole').addClass('grunder');
	                         $('#boxcole').addClass('grind');
	                         $('#headcole').removeClass('redunder');
	                         $('#boxcole').removeClass('redind');     
	                   }else {
	                        
	                   }
	                    
	                
	           stop_waitMe('.wrapper');
	            }

	        }).done(function (data) {

	        }).fail(function () {

	        });

        }
