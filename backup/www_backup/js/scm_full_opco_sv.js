
        function scm_full_detail(tahun, bulan, opco){

        	var param = '?tahun='+tahun+'&bulan='+bulan;
            
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
	                $('#dmin').html(setFormat(dmin.toFixed(0), 0));
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
