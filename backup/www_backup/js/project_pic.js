 $(function(){
          run_waitMe('.wrapper', 'facebook');
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
          $.ajax({
            // url: url_src+'par4digma/api/index.php/stokppudang/stokgudang',
            url: 'http://10.15.5.150/dev/api/index.php/Project/dashboard',
            type: 'GET',
            success: function(data){
              var dataJson = JSON.parse(data);
                  console.log(dataJson);

              $.each(dataJson.smig, function(i,result){
                  // console.log(result['KAPASITAS']);
                  var com = result['ORG'];
                  var dist = result['NM_GDG'];
                  var stok = Number(result['STOK']);
                  var stoklvl = Number(result['STOK_LEVEL']);
                  var cap = Number(result['KAPASITAS']);

                  // console.log(stok+"-"+parseFloat(stok));
                  stok_gudang += stok;
                  if (com == '7000') {
                    total_sg += stok;
                    if (dist!=null) {
                      addTableRow('tbsg',count_sg, dist, stok, cap, stoklvl);
                      count_sg+=1;
                    }
                   
                  }

                  if (com == '4000') {
                    total_st += stok;
                     if (dist!=null) {
                    addTableRow('tbst',count_st, dist, stok, cap, stoklvl);
                    count_st+=1; }
                  }

                  if (com == '3000') {
                    total_sp += stok;
                     if (dist!=null) {
                    addTableRow('tbsp',count_sp, dist, stok, cap, stoklvl);
                    count_sp+=1; }
                  }

                  if (com == '6000') {
                    total_tl += stok;
                     if (dist!=null) {
                    addTableRow('tbsl',count_tl, dist, stok, cap, stoklvl);
                    count_tl+=1; }
                  }
                  
              });
              console.log(stok_gudang);
              console.log(total_tl);
              console.log(total_sp);
              console.log(total_st);
              console.log(total_sg);
              $('#totalstok').html(FormatNumberBy3((stok_gudang.toFixed(2))));
              $('#total_tl').html(FormatNumberBy3(total_tl.toFixed(2)));
              $('#total_sg').html(FormatNumberBy3(total_sg.toFixed(2)));
              $('#total_sp').html(FormatNumberBy3(total_sp.toFixed(2)));
              $('#total_st').html(FormatNumberBy3(total_st.toFixed(2)));
              stop_waitMe('.wrapper');
            }

          });
      });

      function addTableRow(tag,no, dist, stok, cap, stoklvl){


           $('#'+tag).append(
            " <tr><td>"+no+"</td><td align='left'>"+dist+"</td><td align='middle'>"+stok+"</td><td align='middle'>"+cap+"</td><td align='middle'>"+stoklvl+"  % </td></tr>"

          );

      }