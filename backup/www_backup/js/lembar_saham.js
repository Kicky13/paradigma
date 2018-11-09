function lembar_saham(url) {

  run_waitMe('.wrapper', 'facebook');
  $.ajax({
      url: url,
      type: 'GET',
      //data:{bulan:bulan,tahun:tahun},
      success: function(data){
        var obj = JSON.parse(data);
        $('#lembar').empty();
        $.each(obj, function(i,data){
            var ket = obj[i]['ket'];
            var smgr = obj[i]['smgr'];
            var intp= obj[i]['intp'];
            var smcb = obj[i]['smcb'];
              $('#lembar').append(
                ' <tr> <td class="bold_op">'+ket+'</td> <td><span style="color: black;" id="">'+smgr+'</span></td> <td><span style="color: black;" id="">'+intp+'</span></td> <td><span style="color: black;" id="">'+smcb+'</span></td> </tr>'

              );
        });
        setTimeout(function(){
          console.log('timeaout');
          stop_waitMe('.wrapper');
        },1000);
        
      }
    });
  }

  function ev_sg(url) {

  //run_waitMe('.wrapper', 'facebook');
  $.ajax({
      url: url,
      type: 'GET',
      //data:{bulan:bulan,tahun:tahun},
      success: function(data){
        var obj = JSON.parse(data);
        $('#ev').empty();
        $.each(obj, function(i,data){
            var ket = obj[i]['ket'];
            var smgr = obj[i]['smgr'];
              $('#ev').append(
                '<tr> <td class="bold_op">'+ket+'</td>  <td><span style="color: black;" id="">'+smgr+'</span></td> </tr>'

              );
        });
        // setTimeout(function(){
        //   console.log('timeaout');
        //   stop_waitMe('.wrapper');
        // },1000);
        
      }
    });
  }