$(function () {
    $.ajax({
        url: 'http://10.15.5.150/dev/api/index.php/api/stocksemendetail',
        type: 'GET',
        success: function (data) {
            var data1 = data.replace("<title>Json</title>", "");
            var data2 = data1.replace("(", "[");
            var data3 = data2.replace(");", "]");
            var dataJson = JSON.parse(data3);
            var myData = dataJson.Semen;
            console.log(myData);
            var count = Object.keys(myData).length;
            console.log('panjang : ' + count);

            var labelArray = [];
            var index = [];
            var prognose = [];
            var real = [];
			var rkap = [];

            for (var x in myData) {
                index.push(x);
                labelArray.push(x);
                realisasi_stok = dataJson.Semen[x].realisasi_stok;
                real.push(parseFloat(realisasi_stok));

                realisasi_prod = dataJson.Semen[x].realisasi_prod;
				prog_produk = dataJson.Semen[x].prog_produk;
                rkap_produk = dataJson.Semen[x].rkap_produk;
                prog_stok = dataJson.Semen[x].prog_stok;
                prognose.push(parseFloat(prog_stok));
				rkap.push(parseFloat(rkap_produk));

                min_stok = dataJson.Semen[x].min_stok;
                max_stok = dataJson.Semen[x].max_stok;

                console.log('realisasi_stok : ' + realisasi_stok);
                console.log('realisasi_prod : ' + realisasi_prod);
                console.log('prog_produk : ' + prog_produk);
                console.log('prog_stok : ' + prog_stok);
                console.log('min_stok : ' + min_stok);
                console.log('max_stok : ' + max_stok);
            }

            $('#semen_stock').highcharts({
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
                    tickmarkPlacement: 'on',
                    gridLineWidth: 1
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    shared: true
                },
                exporting: {
                    enabled: false
                },
                legend: {
                    enabled: true,
                    layout: 'horizontal',
                    align: 'left',
                    verticalAlign: 'bottom',
                    x: 0,
                    y: 0,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: true
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
        }
    }).done(function (data) {
    }).fail(function () {

    });
});