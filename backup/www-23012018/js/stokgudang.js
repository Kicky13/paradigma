  $(function(){

          var stok_gudang = 0.0;
          var total_sg = 0.0;
          var total_sp = 0.0;
          var total_st = 0.0;
          var total_tl = 0.0;

          //di set 1 untuk mengantisipasi jika tidak ada gudang
          var count_sp = 1;
          var count_st = 1;
          var count_sg = 1;
          var count_tl = 1;

          var pers_tl = 0;
          var pers_sg = 0;
          var pers_sp = 0;
          var pers_st = 0;

          var stok_level = 0;
          var count_gudang = 0;
          run_waitMe('.wrapper', 'facebook');
          $.ajax({
            url: url_src+'/api/index.php/stokppudang/stokgudang',
            type: 'GET',
            success: function(data){
              var dataJson = JSON.parse(data);
                  console.log(dataJson);

              $.each(dataJson.smig, function(i,result){
                  // console.log(result['KAPASITAS']);
                  var com = result['ORG'];
                  var dist = result['NM_DISTR'];
                  var stok = Number(result['STOK']);
                  var stoklvl = Number(result['STOK_LEVEL']);
                  var cap = Number(result['KAPASITAS']);

                  // console.log(stok+"-"+parseFloat(stok));
                  stok_gudang += stok;
                  if (com == '7000') {
                    total_sg += stok;
                    addTableRow('tbsg', dist, stok, cap, stoklvl);
                    pers_sg += stoklvl;
                    count_sg +=1;
                  }

                  if (com == '3000') {
                    total_st += stok;
                    addTableRow('tbst', dist, stok, cap, stoklvl);
                    pers_st += stoklvl;
                    count_st +=1;
                  }

                  if (com == '4000') {
                    total_sp += stok;
                    addTableRow('tbsp', dist, stok, cap, stoklvl);
                    pers_sp += stoklvl
                    count_sp +=1;
                  }

                  if (com == '6000') {
                    total_tl += stok;
                    addTableRow('tbsl', dist, stok, cap, stoklvl);
                    pers_tl +=stoklvl;
                    count_tl +=1;
                  }
                  
              });
              console.log(pers_tl+': sp: '+pers_sp+': st: '+pers_st+': sg: '+pers_sg);
              stok_level = pers_tl + pers_sp + pers_st + pers_sg;
              count_gudang = (count_tl + count_sg + count_sp + count_st)-4;
              console.log(stok_level +' % - '+count_gudang);


              stok_level = (stok_level/count_gudang).toFixed(2);
              $('#totalcount').html(count_gudang);
              $('#totalstoklevel').html(stok_level+' %');

              pers_tl = (pers_tl/count_tl).toFixed(2);
              pers_sg = (pers_sg/count_sg).toFixed(2);
              pers_sp = (pers_sp/count_sp).toFixed(2);
              pers_st = (pers_st/count_st).toFixed(2);



              boxColor('sg', pers_sg);
              boxColor('sp', pers_sp);
              boxColor('st', pers_st);
              boxColor('tl', pers_tl);


              console.log(stok_gudang);
              console.log("tl:"+total_tl +'-'+count_tl+"-"+pers_tl);
              console.log("sp:"+total_sp + "-"+count_sp+"-"+pers_sp);
              console.log("st:"+total_st+"-"+count_st+"-"+pers_st);
              console.log("sg:"+total_sg+"-"+count_sg+"-"+pers_sg);


              total_tl = FormatNumberBy3(total_tl.toFixed(2));
              total_sg = FormatNumberBy3(total_sg.toFixed(2));
              total_sp = FormatNumberBy3(total_sp.toFixed(2));
              total_st = FormatNumberBy3(total_st.toFixed(2));

              stok_gudang = FormatNumberBy3(((parseFloat(stok_gudang)/1000).toFixed(2)))

              $('#totalstok').html(stok_gudang+' K');

              tagStokLvl('pers_sg', pers_sg);
              tagStokLvl('pers_sp', pers_sp);
              tagStokLvl('pers_st', pers_st);
              tagStokLvl('pers_tl', pers_tl);

              // di kurangi 1 jika ada data yg 0
              tagCount('count_sp', count_sp-1);
              tagCount('count_st', count_st-1);
              tagCount('count_tl', count_tl-1);
              tagCount('count_sg', count_sg-1);

            
              tagStok('total_tl', total_tl);
              tagStok('total_sg', total_sg);
              tagStok('total_sp', total_sp);
              tagStok('total_st', total_st);


              // total peropco
              tagStok('total_opco_tl', total_tl);
              tagStok('total_opco_sg', total_sg);
              tagStok('total_opco_sp', total_sp);
              tagStok('total_opco_st', total_st);
              
              stop_waitMe('.wrapper');
            }

          });
      });

      function addTableRow(tag, dist, stok, cap, stoklvl){

        $('#'+tag).append(
            " <tr><td></td>=<td align='left'>"+dist+"</td><td align='middle'>"+stok+"</td><td align='middle'>"+cap+"</td><td align='middle'>"+stoklvl+"  % </td></tr>"

          );

      }
      function tagStok(tag, total){
        // $('#'+tag).html(' <span class="inex label">'+parseFloat(total)/1000+' K</span>');
        $('#'+tag).html(' <span class="inex fblack" >'+total+'</span>');
        // $('#'+tag).html(total);
      }

      function tagCount(tag, count){
        $('#'+tag).html(count);
      }
      function tagStokLvl(tag, pers){
        $('#'+tag).html(pers+" %");

      }

      function boxColor(tag, stoklevel){

        if (stoklevel >=70 && stoklevel <= 100) {
          $('#headcol_'+tag).addClass('grunder');
          $('#boxcol_'+tag).addClass('grind'); 
        }else if (stoklevel >=30 && stoklevel < 70) {
          $('#headcol_'+tag).addClass('ylunder');
          $('#boxcol_'+tag).addClass('ylind'); 
        }else if (stoklevel > 100) {
          $('#headcol_'+tag).addClass('blunder');
          $('#boxcol_'+tag).addClass('blind'); 
        }
      
      }