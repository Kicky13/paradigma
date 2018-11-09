$(function () {
	run_waitMe("#mainchart","facebook");
    $.ajax({
        //url: 'http://10.15.3.146/android/FiCoDataGen.php',
		url: url_src+'/json/FiCoDataGen.php',
        type: 'GET',
        success: function (data) {

            console.log(data);
           //console.log(data);
            var data1 = data.replace("<title>Json</title>", "");
            console.log(JSON.parse(data1));
            var data2 = data1.replace("(", "[");
            var data3 = data2.replace(");", "]");
   //console.log(data['7000'].finance);          
            var dataJson = JSON.parse(data3);
           //var dataJson = data;

            var myLogData = dataJson['7000'].finance['5000'];
            
           // var  cashout = dataJson['7000'].finance[0].acc_pay/1000000;
            //var  cashin = dataJson['7000'].finance[0].acc_rec/1000000;

            var my_saldo = dataJson['7000'].last['5000'].last_balance;
            console.log(my_saldo);
            var last_saldo = parseFloat(my_saldo);
            var dataSaldo = [];
            
            //console.log(last_saldo);
         //$("#cashin").html(parseFloat(cashin).toFixed(2) +' M');
         //$("#cashout").html(parseFloat(cashout).toFixed(2) +' M');

            var labelArray = [];
            var dataCompany = [];
            var dataPay = [];
			var datadump = [9,9,9,10,11,11,11,11.4];
            var dataRec = [];
            var dataTime = [];
            var dataDay = [];
            var index = [];
            var trim;
            var date = new Date();

            var dataPay2 = [];
            var dataRec2 = [];

            for (var x in myLogData) {
                // console.log(x);
                // trim = x.replace(/^\D+|\D+$/gm,'');
                // if (trim!=x) {
                //     trim = "-"+trim;
                // }
                trim = x;
                if (trim >= -7 && trim <= 7) {
                    index.push(trim);
                    //(trim + " -> " + x);

                }
            }

            //console.log("before : "+ index);
            //console.log("label array : "+ labelArray);
            index.sort(function(a, b){return a-b});
            //console.log("before : "+ index[1]);
            var days;
            for (var x in index){              
                  // console.log(index[x]);
                if (index[x] <= 0) {
                    trim = index[x].replace(/^\D+|\D+$/gm,'');
                    if (trim!=index[x]) {
                        days = new Date(date.getTime() - (trim * 24 * 60 * 60 * 1000)).getDate();
                        trim = "-"+trim;
                    }else{
                        days = new Date(date.getTime() + (trim * 24 * 60 * 60 * 1000)).getDate();
                    }

                    labelArray.push(days);
                    //console.log(trim + " -> " + index[x]);
                    nilaiCompany = dataJson['7000'].finance['5000'][trim].company;
                    nilaiPay = dataJson['7000'].finance['5000'][trim].acc_pay;
                    nilaiRec = dataJson['7000'].finance['5000'][trim].acc_rec;
                    nilaiTime = dataJson['7000'].finance['5000'][trim].date_time;
                    nilaiDay = dataJson['7000'].finance['5000'][trim].day;

                    var tmpPay = parseFloat(nilaiPay);
                    var tmpRec = parseFloat(nilaiRec);

                    dataCompany.push(parseInt(nilaiCompany.replace(',', '.')));
                    dataPay.push(parseInt(tmpPay/1000000));
                    dataRec.push(parseInt(tmpRec/1000000));
                    // dataPay.push(parseInt(nilaiPay.replace(',', '.')));
                    // dataRec.push(parseInt(nilaiRec.replace(',', '.')));
                    dataTime.push(parseInt(nilaiTime.replace(',', '.')));
                    dataDay.push(parseInt(nilaiDay.replace(',', '.')));

                    //console.log(last_saldo+'-'+nilaiPay+'-'+nilaiRec);

                    dataSaldo.push(parseInt(last_saldo/1000000));
                    last_saldo = last_saldo + (tmpRec-tmpPay);
                }else{
                    nilaiPay = dataJson['7000'].finance['5000'][x].acc_pay;
                    nilaiRec = dataJson['7000'].finance['5000'][x].acc_rec;
                    
                    dataPay2.push(nilaiPay/1000000);
                    dataRec2.push(nilaiRec/1000000);

                    // dataSaldo.push(parseInt(last_saldo/1000000));
                    // last_saldo = last_saldo + (parseFloat(nilaiRec)-parseFloat(nilaiPay));

                }  
            }
            //console.log(dataRec+"-"+dataPay);
            //console.log(dataSaldo);
             console.log(parseFloat(dataPay2[1]));
            //$('#totalSaldo').html(FormatNumberBy3((last_saldo/1000000000).toFixed(2))+" B");
            // $('#payh1').html(parseFloat(dataPay2[1]).toFixed(2) +' M');
            // $('#rech1').html(parseFloat(dataRec2[1]).toFixed(2) +' M');

            // $('#payh2').html(parseFloat(dataPay2[2]).toFixed(2) +' M');
            // $('#rech2').html(parseFloat(dataRec2[2]).toFixed(2) +' M');

            // $('#payh3').html(parseFloat(dataPay2[3]).toFixed(2) +' M');
            // $('#rech3').html(parseFloat(dataRec2[3]).toFixed(2) +' M');

            // $('#payw1').html(parseFloat(dataPay2[6]).toFixed(2) +' M');
            // $('#recw1').html(parseFloat(dataRec2[6]).toFixed(2) +' M');

            $('#mainchart').highcharts({
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                chart: {
                    backgroundColor: 'rgba(0, 255, 0, 0)',
                    polar: true,
                },
                xAxis: {
                    categories: labelArray,
                    gridLineWidth: 1
                },
                yAxis: {
                    title: ''
                },
                plotOptions: {
                    series: {
                        states: {
                            hover: {
                                enabled: false
                            }
                        }
                    }
                },
                series: [{
                        name: 'Cash In',
                        color: '#26c95c',
                        data: dataRec,
                        type: 'column',
                    }, {
                        name: 'Cash Out',
                        color: '#e74c3c',
                        data: dataPay,
                        type: 'column', 
                    }
//                    ,
//                    {
//                        name: 'Saldo',
//                        color: '#3498db',
//                        type: 'line',
//                        data: dataSaldo,
//			visible: false
//                        
//                    }
                ]
            });
		stop_waitMe('#mainchart');
        }
    }).done(function (data) {
    }).fail(function () {

    });

});