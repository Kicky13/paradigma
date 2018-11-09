$(function () {
    $.ajax({
        url: url_src+ '/api/index.php/stokppudang/stokdetails6000',
        type: 'GET',
        success: function (data) {
            //var data1 = data.replace("<title>Json</title>", "");
           // var data2 = data.replace("(", "[");
            //var data3 = data2.replace(");", "]");
            var dataJson = JSON.parse(data);
            var myData = dataJson.Terak;
            //console.log(myData);
            var count = Object.keys(myData).length;
            console.log('panjang : ' + count);

            var labelArray = [];
            var index = [];
            var prognose = [];
            var real = [];
			var rkap = [];
            var reals = [];
            var maxc = [];
            var min = [];
            var progs = [];
            for (x in myData){
             index.push(x);
            }
            var iArray = index.sort();
            for (var x=0;x<iArray.length;x++) {
                var c = x+1; 
                if (c < 10){
                 var c = '0'+c;
                } 
                console.log(typeof(x));
                labelArray.push(c);
                realisasi_stok = dataJson.Terak[c].realisasi_stok;
                realisasi_prod = dataJson.Terak[c].realisasi_prod;
				prog_produk = dataJson.Terak[c].prog_produk;
                rkap_produk = dataJson.Terak[c].rkap_produk;
                prog_stok = dataJson.Terak[c].prog_stok;
                 min_stok = dataJson.Terak[c].min_stok;
                max_stok = dataJson.Terak[c].max_stok;

                progs.push(parseFloat(prog_stok));
if (realisasi_prod) {
                    prognose.push(null);
                }else{
                    prognose.push(parseFloat(prog_produk));
                }
                prognose.push(parseFloat(prog_produk));
                rkap.push(parseFloat(rkap_produk));
                reals.push(parseFloat(realisasi_stok));
                real.push(parseFloat(realisasi_prod));
                maxc.push(parseFloat(max_stok));
                min.push(parseFloat(max_stok)/2);

               

                console.log('realisasi_stok : ' + realisasi_stok);
                console.log('realisasi_prod : ' + realisasi_prod);
                console.log('prog_produk : ' + prog_produk);
                console.log('prog_stok : ' + prog_stok);
                console.log('min_stok : ' + min_stok);
                console.log('max_stok : ' + max_stok);
            }
			console.log(labelArray);
                        console.log(real);
                        console.log(prognose);
                        console.log(rkap);

            $('#terak_stock').highcharts({
                chart: {
                    type: 'column',
                    spacingBottom: 8,
                    spacingTop: 8,
                    spacingLeft: 5,
                    spacingRight: 5,
                    animation: Highcharts.svg
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: labelArray,
                    tickInterval: 1,
//                    tickmarkPlacement: 'on',
                    gridLineWidth: 1
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    formatter: function(){
                            var n = this.y;
                            var s = this.series.name;
                            var t = this.point.x+1;
                            return '<b>'+t+'<br>'+s+'<br>'+setFormat(n,0)+' Ton</b>';
                            }
                },
                exporting: {
                    enabled: false
                },
                legend: {
                    enabled: false,
                    //layout: 'horizontal',
                    //align: 'left',
                    //verticalAlign: 'bottom',
                   // x: 0,
                    ///\y: 0,
                    //backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    //shadow: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                        name: 'Prognose',
                        color: '#E9D460',
                        data: prognose,
						stacking: 'normal'
                    },{
						name: 'Realisasi',
                        color: '#22A7F0',
                        data: real,
						stacking: 'normal'
                    },{
						type: 'spline',
                        name: 'RKAP',
                        color: '#D91E18',
                        data: rkap,
                    }]
            });

            $('#terak_cap').highcharts({
                chart: {
                    type: 'column',
                    spacingBottom: 8,
                    spacingTop: 8,
                    spacingLeft: 5,
                    spacingRight: 5,
                    animation: Highcharts.svg
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: labelArray,
                    tickInterval: 1,
//                    tickmarkPlacement: 'on',
                    gridLineWidth: 1
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                tooltip:{
                            formatter: function(){
                            var n = this.y;
                            var s = this.series.name;
                            var t = this.point.x+1;
                            return '<b>'+t+'<br>'+s+'<br>'+setFormat(n,0)+' Ton</b>';
                            }
                            
                 },
                exporting: {
                    enabled: false
                },
                legend: {
                    enabled: false,
                    //layout: 'horizontal',
                    align: 'center',
                    //verticalAlign: 'bottom',
                    //x: 0,
                    //y: 0,
                    //backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    //shadow: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                        type: 'spline',
                        name: 'Prognosa',
                        data: progs,
                        color: '#E9D460'
                        
                    },{
                        type: 'spline',
                        name: '100% CAP',
                        data: maxc,
                        color: '#1BBC9B'
                    },{
                        type: 'spline',
                        name: '50% CAP',
                        data: min,
                        color: '#D91E18'
                        
                    },{
                        type: 'spline',
                        name: 'Realisasi',
                        data: reals,
                        color: '#22A7F0'                        
                    }]
            });
        }
    }).done(function (data) {
    }).fail(function () {

    });
});