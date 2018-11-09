$(function () {   
                        $.ajax({
                                  url: url_src+'/ScoOpcoGenDetail.php?company=1&tahun=2016',
                                    type:'GET',
                                      success: function(data) {
                                       var data = eval('('+data+')');
                                       
                                       var targetjanuari = data['s01'].target;
                                       var realjanuari = data['s01'].real;

                                       var targetfebruari = data['s02'].target;
                                       var realfebruari = data['s02'].real;

                                       var targetmaret = data['s03'].target;
                                       var realmaret = data['s03'].real;
                                        
                                       var targetapril = data['s04'].target;
                                       var realapril = data['s04'].real;
                                        
                                       var targetmei = data['s05'].target;
                                       var realmei = data['s05'].real;

                                       var targetjuni = data['s06'].target;
                                       var realjuni = data['s06'].real;

                                       var targetjuli = data['s07'].target;
                                       var realjuli = data['s07'].real;
                                        
                                       var targetagustus = data['s08'].target;
                                       var realagustus = data['s08'].real;
                                        
                                       var targetseptember = data['s09'].target;
                                       var realseptember = data['s09'].real;
                                           
                                     //  var smigtarget = Number(target7000)+Number(target4000)+Number(target3000);
                                    //   var smigreal = Number(real7000)+Number(real4000)+Number(real3000);

                                       var percentjanuari = (realjanuari/targetjanuari)*100;
                                       var percentfebruari = (realfebruari/targetfebruari)*100;
                                       var percentmaret = (realmaret/targetmaret)*100;
                                       var percentapril = (realapril/targetapril)*100;
                                       var percentmei = (realmei/targetmei)*100;
                                       var percentjuni = (realjuni/targetjuni)*100;
                                       var percentjuli = (realjuli/targetjuli)*100;
                                       var percentagustus = (realagustus/targetagustus)*100;
                                       var percentseptember = (realseptember/targetseptember)*100;
                                      

                                        $("#percentjanuari").html(percentjanuari.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percentfebruari").html(percentfebruari.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percentmaret").html(percentmaret.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percentapril").html(percentapril.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percentmei").html(percentmei.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percentjuni").html(percentjuni.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percentjuli").html(percentjuli.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percentagustus").html(percentagustus.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percentseptember").html(percentseptember.toFixed(2)+'<font size="3"> %</font>');
                                          
                                        //Chart
                                        var rkap_chart = [];
                                        var real_chart = [];

                                        rkap_chart.push(parseInt(targetjanuari/1000));
                                        real_chart.push(parseInt(realjanuari)/1000);

                                        rkap_chart.push(parseInt(targetfebruari/1000));
                                        real_chart.push(parseInt(realfebruari)/1000);

                                        rkap_chart.push(parseInt(targetmaret)/1000);
                                        real_chart.push(parseInt(realmaret)/1000);

                                        rkap_chart.push(parseInt(targetapril)/1000);
                                        real_chart.push(parseInt(realapril)/1000);
                                          
                                        rkap_chart.push(parseInt(targetmei/1000));
                                        real_chart.push(parseInt(realmei)/1000);

                                        rkap_chart.push(parseInt(targetjuni/1000));
                                        real_chart.push(parseInt(realjuni)/1000);

                                        rkap_chart.push(parseInt(targetjuli)/1000);
                                        real_chart.push(parseInt(realjuli)/1000);

                                        rkap_chart.push(parseInt(targetagustus)/1000);
                                        real_chart.push(parseInt(realagustus)/1000);
                                          
                                        rkap_chart.push(parseInt(targetseptember)/1000);
                                        real_chart.push(parseInt(realseptember)/1000);
                                          
                                     
                                          
                                        

                                        
                                $('#container').highcharts({
                                    title: {
                                        text: ''            
                                    },

                                    credits: {
                                        enabled :false
                                    },

                                    chart: {
                                        backgroundColor:'rgba(0, 255, 0, 0)',
                                        polar: true,
                                       

                                    },
                                    xAxis: {
                                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
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
                                        name: 'RKAP Value',
                                        color: '#EB1745',
                                        data: rkap_chart,
                                         type: 'line'
                                    }, {
                                        name: 'Real Value',
                                         color: '#5317EB',
                                        data: real_chart,
                                         type: 'column'

                                    }]        


                                });  
                                          
                                var labelArrays = ['JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'];

                                        var ctx3 = document.getElementById("prodOpco");
                                        var data3 = {                                          
                                        labels: labelArrays,
                                        datasets: [
                                            {
                                                label: "RKAP",
                                                backgroundColor: '#f44336',
                                                data: rkap_chart,
                                            },
                                            {
                                                label: "Realisasi",
                                                backgroundColor: '#56aec2',
                                                data: real_chart,
                                            }

                                        ]
                                        };
                                        var myBarChart = new Chart(ctx3, {
                                            type: 'bar',
                                            data: data3,
                                            options: {
                                                legend: {
                                                    display: false,
                                                },                                                
                                                maintainAspectRatio: true,
                                                scales: {
                                                  yAxes: [{
                                                    scaleLabel: {
                                                      display: true,
                                                      size:5,
                                                      labelString: 'Dalam Ribuan'
                                                    }
                                                  }]
                                                }

                                            }
                                        });

                                      }
                                    }).done(function(data){
                                    }).fail(function(){

                                    });
    
     $.ajax({
                                  url: url_src+'/ScoOpcoGen.php',
                                    type:'GET',
                                      success: function(data) {
                                        var data = eval('('+data+')');
                               
                                       var target7000 = data['s7000'].target;
                                       var real7000 = data['s7000'].real;

                                       var target4000 = data['s4000'].target;
                                       var real4000 = data['s4000'].real;

                                       var target3000 = data['s3000'].target;
                                       var real3000 = data['s3000'].real;

                                       var smigtarget = Number(target7000)+Number(target4000)+Number(target3000);
                                       var smigreal = Number(real7000)+Number(real4000)+Number(real3000);

                                       var percent3000 = (real3000/target3000)*100;
                                       var percent4000 = (real4000/target4000)*100;
                                       var percent7000 = (real7000/target7000)*100;
                                       var percentsmig = (smigreal/smigtarget)*100;

                                        $("#rkap7000").html('<span style="font-size:8px; color:#333333"></span> '+((data.s7000.target)/1000).toFixed(2) +' K');
                                        $("#real7000").html('<span style="font-size:8px; color:#333333"></span> '+ ((data.s7000.real)/1000).toFixed(2)+' K');

                                        $("#rkap4000").html('<span style="font-size:8px; color:#333333"></span>'+((data.s4000.target)/1000).toFixed(2)+' K');
                                        $("#real4000").html('<span style="font-size:8px; color:#333333"></span>'+ ((data.s4000.real)/1000).toFixed(2)+' K</strong></span>');

                                        $("#rkap3000").html('<span style="font-size:8px; color:#333333"></span>'+((data.s3000.target)/1000).toFixed(2)+' K');
                                        $("#real3000").html('<span style="font-size:8px; color:#333333"></span>'+ ((data.s3000.real)/1000).toFixed(2)+' K</strong></span>');

                                        $("#rkapsmig").html('<span style="font-size:8px; color:#333333"></span> '+(smigtarget/1000).toFixed(2)+' K');
                                        $("#realsmig").html('<strong></strong> <span class="row-xs-2 noPadding" align="left" style="font-weight: bold; font-size:8px; color:#696969"><strong>'+(smigreal/1000).toFixed(2)+'k</strong></span>');

                                        $("#percent3000").html(percent3000.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percent4000").html(percent4000.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percent7000").html(percent7000.toFixed(2)+'<font size="3"> %</font>');
                                        $("#percentsmig").html(percentsmig.toFixed(2)+'<font size="3"> %</font>');

                                        //Chart
                                        var rkap_chart = [];
                                        var real_chart = [];

                                        rkap_chart.push(parseInt(smigtarget));
                                        real_chart.push(parseInt(smigreal));

                                        rkap_chart.push(parseInt(target7000));
                                        real_chart.push(parseInt(real7000));

                                        rkap_chart.push(parseInt(target3000));
                                        real_chart.push(parseInt(real3000));

                                        rkap_chart.push(parseInt(target4000));
                                        real_chart.push(parseInt(real4000));


                                        var labelArrays = ['SMIG','Semen Gresik','Semen Padang','Semen Tonasa'];

                                        var ctx3 = document.getElementById("prodOpco");
                                        var data3 = {
                                        labels: labelArrays,
                                        datasets: [
                                            {
                                                label: "RKAP",
                                                backgroundColor: '#f44336',
                                                data: rkap_chart,
                                            },
                                            {
                                                label: "Realisasi",
                                                backgroundColor: '#fcf903',
                                                data: real_chart,
                                            }

                                        ]
                                        };
                                        var myBarChart = new Chart(ctx3, {
                                            type: 'bar',
                                            data: data3,
                                            options: {
                                                legend: {
                                                    display: false,
                                                },
                                                maintainAspectRatio: false
                                            }
                                        });

                                      }
                                    }).done(function(data){
                                    }).fail(function(){

                                    });
    
});