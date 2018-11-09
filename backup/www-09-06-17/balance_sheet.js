var selectOp = function(){
    var selectMonth = document.getElementById("month");
    var selectYear = document.getElementById("year");
    var selectedMonth = selectMonth.options[selectMonth.selectedIndex].value;
    var selectedYear = selectYear.options[selectYear.selectedIndex].value;
    alert(selectedMonth+'-'+selectYear);
}


$(function(){

  var company = '7000';
  // var bulanSekarang = $('.selmonth').val();
  // var tahun = $('.selyear').val();
  loadData(tahun, bulanSekarang, company);

  $('.selmonth').change(function(){
       bulanSekarang = $(this).val();
       tahun = $('.selyear').val();   

       console.log(tahun+'-'+bulanSekarang+'-'+month[bulanSekarang]);
      loadData(tahun, bulanSekarang, company);


  })
  $('.selyear').change(function(){
       tahun = $(this).val();
       bulanSekarang = $('.selmonth').val();   
       var t = $(this).attr('rel');
      $('#headerSelectedMonth').html(month[bulanSekarang]+' '+tahun);
      loadData(tahun, bulanSekarang, company);

  })
	});
function loadData(tahun, bulan, company){
    var tmp = bulan;
    var bln = parseInt(tmp);
    console.log(bln);
    $('#headerSelectedMonth1').html(month[bln-1]+' '+tahun);
    $('#headerSelectedMonth2').html(month[bln-1]+' '+tahun);
    $('#headerSelectedMonth3').html(month[bln-1]+' '+tahun);

    $('#asset').addClass('hidden');
    $('#liability').addClass('hidden');
    $('#equity').addClass('hidden');
   run_waitMe('.wrapper','facebook');
   $.ajax({
        url: url_src+'/balance_sheet.php?tahun='+tahun+'&bulan='+bulan+'&company='+company,
        type: 'GET',
        success: function (data) {
          console.log(data);
          var dataJson = JSON.parse(data);

            //assett
            $.each(dataJson.asset.past,function(data){
                  var x = (Number(dataJson.asset.past[data]))/1000000;

                  console.log(data + " " + x);

                     $("#asset_past_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')
            });

             $.each(dataJson.asset.last,function(data){
                  var x = (Number(dataJson.asset.last[data]))/1000000;

                  console.log(data + " " + x);

                  $("#asset_last_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')

            });
            //liability
             $.each(dataJson.liability.past,function(data){
                  var x = (Number(dataJson.liability.past[data]))/1000000;

                  console.log(data + " " + x);

                  $("#liability_past_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')
            });

             $.each(dataJson.liability.last,function(data){
                  var x = (Number(dataJson.liability.last[data]))/1000000;

                  console.log(data + " " + x);

                  $("#liability_last_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')
            });
             //equity
             //
              $.each(dataJson.equity.past,function(data){
                  var x = (Number(dataJson.equity.past[data]))/1000000;

                  console.log(data + " " + x);

                  $("#equity_past_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')
            });

             $.each(dataJson.equity.last,function(data){
                  var x = (Number(dataJson.equity.last[data]))/1000000;

                  console.log(data + " " + x);

                  $("#equity_last_"+data).html(FormatNumberBy3(x.toFixed(2)),",", "."+'<font size="3"> </font>')
            });

            var equity_liability_past_total = (Number(dataJson.total_liability_equity.past))/1000000;
            var equity_liability_last_total = (Number(dataJson.total_liability_equity.last))/1000000;
            
            $("#equity_liability_last_total").html(FormatNumberBy3(equity_liability_last_total.toFixed(2)),",", "."+'<font size="3"> </font>');
            $("#equity_liability_past_total").html(FormatNumberBy3(equity_liability_past_total.toFixed(2)),",", "."+'<font size="3"> </font>');
            stop_waitMe('.wrapper');
          } 
      }).done(function (data) {
        // console.log('get done'+data);
      }).fail(function () {

      });
}