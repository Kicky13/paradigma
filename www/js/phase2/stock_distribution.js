
var dist = '';
var group = '';
var selgroup = '';

var idDist={'id':[]};
var idGudang={'id':[]};
var dataDist=[];
var dataGudang=[];

function distribution_list(data){
	for(var i=0; i<data.length; i++) {
        dist += '<div class="item_distributor">'
            dist += '<h1><a href="p2_stock_distribution_detail.html#'+data[i].id+'&'+data[i].name+'"><span>'+data[i].name+'</span><i class="fa fa-window-maximize" aria-hidden="true" style="float:right;padding-right: 5px;font-size:14px;margin-top:3px;"></i></a></h1>'
            dist += '<div class="item_detail">'
                dist += '<div>'
                    dist += '<h2>Qty on hand</h2>'
                    dist += '<h3>'+setFormat(data[i].qtyonhand/1000)+'</h3>'   
                dist += '</div>'
                dist += '<div>'
                    dist += '<h2>Qty reserved</h2>'
                    dist += '<h3>'+setFormat(data[i].qtyreserved/1000)+'</h3>'   
                dist += '</div>'
                dist += '<div>'
                    dist += '<h2>Qty available</h2>'
                    dist += '<h3>'+setFormat(data[i].qtyavailable/1000)+'</h3>'   
                dist += '</div>'
                dist += '<div>'
                    dist += '<h2>Qty ordered</h2>'
                    dist += '<h3>'+setFormat(data[i].qtyordered/1000)+'</h3>'   
                dist += '</div>'
            dist += '</div>'
        dist += '</div>';
    }
	$("#stock_distributor").html(dist);
}

function group_list(idDetDist, data){
    var datas = data.resultdata;
    getOrg(datas);

    for(var i=0; i<datas.length; i++) {
        var prodname ='';
        if(idDetDist == '1000001' || idDetDist == '1000012'){
            prodname = datas[i].name;
        }else{
            prodname = datas[i].produk;
        }
        var wid = idGudang.id.indexOf(datas[i].m_warehouse_id);
        if(wid < 0){
            idGudang.id.push(datas[i].m_warehouse_id);
            dataGudang.push({
                'id':datas[i].m_warehouse_id,
                'name':datas[i].m_warehouse_name,
                'value':[{
                    'product':prodname,
                    'm_locator_value':datas[i].m_locator_value,
                    'qtyonhand':datas[i].qtyonhand,
                    'qtyreserved':datas[i].qtyreserved,
                    'qtyavailable':datas[i].qtyavailable,
                    'qtyordered':datas[i].qtyordered
                }]
            });
        }else{
            dataGudang[wid].value.push({
                'product':prodname,
                'm_locator_value':datas[i].m_locator_value,
                'qtyonhand':datas[i].qtyonhand,
                'qtyreserved':datas[i].qtyreserved,
                'qtyavailable':datas[i].qtyavailable,
                'qtyordered':datas[i].qtyordered
            });
        }
    }

    selgroup += '<option value="all">Choose Warehouse</option>';
    for(var j=0;j<dataGudang.length;j++){
        selgroup += '<option value='+dataGudang[j].id+'>'+dataGudang[j].name+'</option>';
    }
    $("#grouparea").html(selgroup);

    $('#grouparea').change(function(){
        run_waitMe('.wrapper', 'ios');
        var active = $(this).val();
        if(active=='all'){
            $(".item_distributor").show();
        }else{
            $(".item_distributor").hide();
            $(".item_group"+active).show();
        }
        stop_waitMe('.wrapper');
    })  

    for(var i=0; i<dataGudang.length; i++) {
        group += '<div class="item_distributor item_group'+dataGudang[i].id+'">'
        group += '<h1><i class="fa fa-cubes" aria-hidden="true"></i> '+dataGudang[i].name+'</h1>'
        var val = dataGudang[i].value;
        for(var j=0; j<val.length; j++) {
            group += '<div id="subgroup">'
                group += '<h4>'+val[j].product+'</h4>'
                group += '<h5>'+val[j].m_locator_value+'</h5>'
                group += '<div class="item_detail">'
                    group += '<div>'
                        group += '<h2>Qty on hand</h2>'
                        group += '<h3>'+setFormat(val[j].qtyonhand/10)+'</h3>'   
                    group += '</div>'
                    group += '<div>'
                        group += '<h2>Qty reserved</h2>'
                        group += '<h3>'+setFormat(val[j].qtyreserved/10)+'</h3>'   
                    group += '</div>'
                    group += '<div>'
                        group += '<h2>Qty available</h2>'
                        group += '<h3>'+setFormat(val[j].qtyavailable/10)+'</h3>'   
                    group += '</div>'
                    group += '<div>'
                        group += '<h2>Qty ordered</h2>'
                        group += '<h3>'+setFormat(val[j].qtyordered/10)+'</h3>'   
                    group += '</div>'
                group += '</div>'
            group += '</div>'
        }
        group += '</div>';
    }

    // for(var i=0; i<datas.length; i++) {
    //     var prodname ='';
    //     if(idDetDist == '1000001' || idDetDist == '1000012'){
    //         prodname = datas[i].name;
    //     }else{
    //         prodname = datas[i].produk;
    //     }
    //     group += '<div class="item_distributor item_group'+datas[i].ad_org_id+'">'
    //         group += '<h1><i class="fa fa-cubes" aria-hidden="true"></i> '+datas[i].m_warehouse_name+'</h1>'
    //         group += '<h4><i class="fa fa-cube" aria-hidden="true"></i> '+prodname+'</h4>'
    //         group += '<h5><i class="fa fa-map-marker" aria-hidden="true"></i> '+datas[i].m_locator_value+'</h5>'
    //         group += '<div class="item_detail">'
    //             group += '<div>'
    //                 group += '<h2>Qty on hand</h2>'
    //                 group += '<h3>'+setFormat(datas[i].qtyonhand/10)+'</h3>'   
    //             group += '</div>'
    //             group += '<div>'
    //                 group += '<h2>Qty reserved</h2>'
    //                 group += '<h3>'+setFormat(datas[i].qtyreserved/10)+'</h3>'   
    //             group += '</div>'
    //             group += '<div>'
    //                 group += '<h2>Qty available</h2>'
    //                 group += '<h3>'+setFormat(datas[i].qtyavailable/10)+'</h3>'   
    //             group += '</div>'
    //             group += '<div>'
    //                 group += '<h2>Qty ordered</h2>'
    //                 group += '<h3>'+setFormat(datas[i].qtyordered/10)+'</h3>'   
    //             group += '</div>'
    //         group += '</div>'
    //     group += '</div>';
    // }
    $("#stock_distributor_detail").html(group);
}

function getOrg(data){
    for(var i=0;i<data.length;i++){
        var vid = idDist.id.indexOf(data[i].ad_org_id);
        if(vid < 0){
            idDist.id.push(data[i].ad_org_id);
            dataDist.push({'id':data[i].ad_org_id, 'name':data[i].ad_org_name});
        }
    }
}

function opcoGroup (idDetDist){
    run_waitMe('.wrapper', 'ios');
	var stock = 'http://apperp.semenindonesia.com/ws/forca/admin/master/storage_stock';
	 $.ajax({
        url: stock,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({username: 'WsAdmin', password: 'WsAdmin', ad_client_id: idDetDist, ad_org_id: '', m_product_id: ''}),
        success: function (data) {
            if(idDetDist){
                group_list(idDetDist, data);
            }else{
                getDistributor(data);
                distribution_list(dataDist);
            }
            stop_waitMe('.wrapper');
        }
    });
}

function getDistributor(data){
    for(var i=0;i<data.resultdata.length;i++){
        var vid = idDist.id.indexOf(data.resultdata[i].ad_client_id);
        if(vid < 0){
            idDist.id.push(data.resultdata[i].ad_client_id);
            dataDist.push({'id':data.resultdata[i].ad_client_id, 'name':data.resultdata[i].ad_client_name, 'qtyonhand':parseInt(data.resultdata[i].qtyonhand), 'qtyreserved':parseInt(data.resultdata[i].qtyreserved), 'qtyavailable':parseInt(data.resultdata[i].qtyavailable), 'qtyordered':parseInt(data.resultdata[i].qtyordered)});
        }else{
            dataDist[vid].qtyonhand += parseInt(data.resultdata[i].qtyonhand);
            dataDist[vid].qtyreserved += parseInt(data.resultdata[i].qtyreserved);
            dataDist[vid].qtyavailable += parseInt(data.resultdata[i].qtyavailable);
            dataDist[vid].qtyordered += parseInt(data.resultdata[i].qtyordered);
        }
    }
}

