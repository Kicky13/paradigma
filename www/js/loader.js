 var url_ol = 'http://par4digma.semenindonesia.com';
 var url_src = 'http://10.15.5.150/dev/par4digma';
 // var url_src = url_ol;
 var url_opc = 'http://10.15.3.146/android';
 var url_tmp = 'http://10.15.5.150/dev/Android';

var listTab = ['smi', 'sp', 'sg', 'st', 'tl', 'kso'];

var tab_url = {
  'fin_cost_str': {
    'sg': 'fin_cost_str_sg',
    'st': 'fin_cost_str_st',
    'sp': 'fin_cost_str_sp',
    'tl': 'fin_cost_str_tl',
    'kso': 'fin_cost_str_kso',
    'smi': 'fin_cost_str_pc'
  },
  'fin_rec_mng': {
    'sg': 'fin_rec_mng_sg',
    'st': 'fin_rec_mng_st',
    'sp': 'fin_rec_mng_sp',
    'tl': 'fin_rec_mng_tl',
    'kso': 'fin_rec_mng_kso',
    'smi': 'fin_rec_mng'
  }
};

function get_my_url(url, com){
  var result = '';
  if (tab_url.hasOwnProperty(url)) {
    if (tab_url[url].hasOwnProperty(com)) {
      result = tab_url[url][com];
    }else{
       result = url;
    }
  }else{
    result = url;
  }

  console.log(result);
  return result;
}

function add_footer(url){
   var footer = '  <div id="tab-smi" class="col-xs-4 noPadding tab_uper col-ft-4 img_foot2" align="center" style="margin-top: 7px; "><a onclick="tabClick(this, \''+url+'\')" rel="data-smi" ><img src="img/smi.png" style="width : 60%;" /></a></div><div id="tab-sp" class="col-xs-3 noPadding tab_uper col-ft-3 img_foot2 " align="center" style="margin-top: 7px;"><a onclick="tabClick(this, \''+url+'\')" rel="data-sp" ><img src="img/icKota2a.png" style="width:60%;" /></a></div><div id="tab-sg" class="col-xs-3 noPadding tab_uper col-ft-3" align="center" style="margin-top: 7px;"><a onclick="tabClick(this, \''+url+'\')" rel="data-sg" ><img src="img/icKota1a.png"  style="width:60%;" /></a></div> <div id="tab-st" class="col-xs-3 noPadding tab_uper col-ft-3 img_foot2 " align="center" style="margin-top: 7px;"><a onclick="tabClick(this, \''+url+'\')" rel="data-st" ><img src="img/icKota3a.png" style="width:60%;"/></a></div> <div id="tab-tl" class="col-xs-3 noPadding tab_uper col-ft-3 img_foot2 " align="center" style="margin-top: 7px; width: 16%;"><a onclick="tabClick(this, \''+url+'\')" rel="data-tl" ><img src="img/icKota4a.png" style="width:60%;"/></a></div><div id="tab-kso" class="col-xs-3 noPadding tab_uper col-ft-3 img_foot2" align="center" style="margin-top: 5px;"><a onclick="tabClick(this, \''+url+'\')" rel="data-kso" ><img src="img/icKSO.png" style="width:100%;"/></a></div>';

   return footer;
}
 function setFormat(nilai, dec){
  var tmp = accounting.formatMoney(nilai,"",dec,".",",");
  return tmp;
 }
 function division(a, b) {   
  if (a == '' || a === '' || a == null){
   var a = 0;
  }    
  if(b == 0){
   return 0;
  }else{
   var tmp = parseFloat(a)/parseFloat(b);  
   return tmp;
  }
 }
 function run_waitMe(which, effect){
  $(which).waitMe({
   //none, rotateplane, stretch, orbit, roundBounce, win8, 
   //win8_linear, ios, facebook, rotation, timer, pulse, 
   //progressBar, bouncePulse or img
   effect: effect,
   //place text under the effect (string).
   text: '',
   //background for container (string).
   bg: 'rgba(255,255,255,0.7)',
   //color for background animation and text (string).
   color: '#000',
   //change width for elem animation (string).
   sizeW: '',
   //change height for elem animation (string).
   sizeH: '',
   // url to image
   source: '',
   // callback
   onClose: function(){}
  });
 } 
 function stop_waitMe(which){
  $(which).waitMe('hide');
  // console.log(which);
 } 
 function linkReplace(link, str){
  var res = link;
    // var regex = /(?!stok)(sg|sp|st|tl)/gi;
    var regex = /(?!stok|status)(sg|sp|st|tl)/gi;
    var replaced = link.search(regex, str)>=0;
    if (replaced) {
        res = link.replace(regex, str);
    }else{
      res = false;
    }
    return res;

 }
 function goto_opco(link, link_alt = null, ready_opco = null){
    var res = link;
    if (link_alt==null) {
      if (sessionStorage.getItem('_com')!='ALL' || sessionStorage.getItem('_com')!=null)
      {
          var opco = sessionStorage.getItem('_com');
          var company = 'sg';
          console.log('goto ', opco);
          if (opco == 4000 || opco == '4000') {
            company = 'st';
          } else if (opco == 7000 || opco == '7000') {
            company = 'sg';
          } else if (opco == 3000 || opco == '3000') {
            company = 'sp';
          } else if (opco == 6000 || opco == '6000') {
            company = 'tl';
          }

          res = linkReplace(link, company);
          if(!res){
            res = link+'_'+company;
          }
          console.log('goto ', res);
      }
    }else if(ready_opco==null){

      var opco = sessionStorage.getItem('_com');
      var company = null;
      console.log('goto ', opco);
      if (opco == 4000 || opco == '4000') {
        company = 'st';
      } else if (opco == 7000 || opco == '7000') {
        company = 'sg';
      } else if (opco == 3000 || opco == '3000') {
        company = 'sp';
      } else if (opco == 6000 || opco == '6000') {
        company = 'tl';
      }
      res = link;
      if (company!=null) {
        replacedLink = linkReplace(link_alt, company);
        if(!replacedLink){
          res = link_alt;
        }else{
            res = replacedLink;
        }
      }
    }else{
      if (sessionStorage.getItem('_com')!='ALL' )
      {
        var opco = sessionStorage.getItem('_com');
        var company = null;
        var fetch_opco = ready_opco.split("|");
        $.each(fetch_opco, function(index, el) {

          if (el==opco) {
            if (opco == 4000 || opco == '4000') {
              company = 'st';
            } else if (opco == 7000 || opco == '7000') {
              company = 'sg';
            } else if (opco == 3000 || opco == '3000') {
              company = 'sp';
            } else if (opco == 6000 || opco == '6000') {
              company = 'tl';
            }
          }
        });
        
        if (company!=null) {
          replacedLink = linkReplace(link_alt, company);
          if(!replacedLink){
            res = link_alt;
          }else{
              res = replacedLink;
          }
        }else{
          if (opco!='ALL') {
            res = 'notfound';
          }
        }
      }

    }
  
    window.location.href = res+'.html';
   
    

  }

   function goto_opco2(link, link_alt = null, ready_opco = null, get_opco = null){
    var res = link;
    if (link_alt==null) {
      if (get_opco!='ALL' || get_opco!=null)
      {
          var opco = get_opco;
          var company = 'sg';
          console.log('goto ', opco);
          if (opco == 4000 || opco == '4000') {
            company = 'st';
          } else if (opco == 7000 || opco == '7000') {
            company = 'sg';
          } else if (opco == 3000 || opco == '3000') {
            company = 'sp';
          } else if (opco == 6000 || opco == '6000') {
            company = 'tl';
          }

          res = linkReplace(link, company);
          if(!res){
            res = link+'_'+company;
          }
          console.log('goto ', res);
      }
    }else if(ready_opco==null){

      var opco = get_opco;
      var company = null;
      console.log('goto ', opco);
      if (opco == 4000 || opco == '4000') {
        company = 'st';
      } else if (opco == 7000 || opco == '7000') {
        company = 'sg';
      } else if (opco == 3000 || opco == '3000') {
        company = 'sp';
      } else if (opco == 6000 || opco == '6000') {
        company = 'tl';
      }
      res = link;
      if (company!=null) {
        replacedLink = linkReplace(link_alt, company);
        if(!replacedLink){
          res = link_alt;
        }else{
            res = replacedLink;
        }
      }
    }else{
      if (get_opco!='ALL' )
      {
        var opco = get_opco;
        var company = null;
        var fetch_opco = ready_opco.split("|");
        $.each(fetch_opco, function(index, el) {

          if (el==opco) {
            if (opco == 4000 || opco == '4000') {
              company = 'st';
            } else if (opco == 7000 || opco == '7000') {
              company = 'sg';
            } else if (opco == 3000 || opco == '3000') {
              company = 'sp';
            } else if (opco == 6000 || opco == '6000') {
              company = 'tl';
            }
          }
        });
        
        if (company!=null) {
          replacedLink = linkReplace(link_alt, company);
          if(!replacedLink){
            res = link_alt;
          }else{
              res = replacedLink;
          }
        }else{
          if (opco!='ALL') {
            res = 'notfound';
          }
        }
      }

    }
  
   return res;
   
    

  }

  function tabClick(element, url){

    var opco = 7000;

    $(element).click(function (e) {
        e.preventDefault();
        var r = $(this).attr('rel');
        if (r == 'data-sp') {
            $('#tab-kso').addClass('img_foot2');
            $('#tab-sp').removeClass('img_foot2');
            $('#tab-sg').addClass('img_foot2');
            $('#tab-st').addClass('img_foot2');
            $('#tab-tl').addClass('img_foot2');
            $('#tab-smi').addClass('img_foot2');

            $('#tab-volume').addClass('act_tb');
            $('#tab-revenew').removeClass('act_tb');
            setParam('3000', bulanSekarang, tahun);

            url = get_my_url(url, 'sp');
            window.location.href = url+".html"
            // fin_data(getParam('bln'), getParam('opco'), getParam('thn'));
        } else if (r == 'data-sg') {
            $('#tab-kso').removeClass('img_foot2');
            $('#tab-sp').addClass('img_foot2');
            $('#tab-sg').addClass('img_foot2');
            $('#tab-st').addClass('img_foot2');
            $('#tab-tl').addClass('img_foot2');
            $('#tab-smi').addClass('img_foot2');
            
            $('#tab-volume').addClass('act_tb');
            $('#tab-revenew').removeClass('act_tb');
            setParam('5000', bulanSekarang, tahun);
            url = get_my_url(url, 'sg');
            window.location.href = url+".html";
            // fin_data(getParam('bln'), getParam('opco'), getParam('thn'));
        } else if (r == 'data-st') {
            $('#tab-kso').addClass('img_foot2');
            $('#tab-sp').addClass('img_foot2');
            $('#tab-sg').addClass('img_foot2');
            $('#tab-st').removeClass('img_foot2');
            $('#tab-tl').addClass('img_foot2');
            $('#tab-smi').addClass('img_foot2');
            
            $('#tab-volume').addClass('act_tb');
            $('#tab-revenew').removeClass('act_tb');
            setParam('4000', bulanSekarang, tahun);
            url = get_my_url(url, 'st');
            window.location.href = url+".html";
            // fin_data(getParam('bln'), getParam('opco'), getParam('thn'));
        } else if (r == 'data-tl') {
            $('#tab-kso').addClass('img_foot2');
            $('#tab-sp').addClass('img_foot2');
            $('#tab-sg').addClass('img_foot2');
            $('#tab-st').addClass('img_foot2');
            $('#tab-tl').removeClass('img_foot2');
            $('#tab-smi').addClass('img_foot2');
            
            $('#tab-volume').addClass('act_tb');
            $('#tab-revenew').removeClass('act_tb');
            setParam('6000', bulanSekarang, tahun);
            url = get_my_url(url, 'tl');
            window.location.href = url+".html";
            // fin_data(getParam('bln'), getParam('opco'), getParam('thn'));
        } else if (r == 'data-smi') {
            $('#tab-kso').addClass('img_foot2');
            $('#tab-sp').addClass('img_foot2');
            $('#tab-sg').addClass('img_foot2');
            $('#tab-st').addClass('img_foot2');
            $('#tab-tl').addClass('img_foot2');
            $('#tab-smi').removeClass('img_foot2');
            
            $('#tab-volume').addClass('act_tb');
            $('#tab-revenew').removeClass('act_tb');
            setParam('2000', bulanSekarang, tahun);
            url = get_my_url(url, 'smi');
            window.location.href = url+".html";
            // fin_data(getParam('bln'), getParam('opco'), getParam('thn'));
        } else if (r == 'data-kso') {
            $('#tab-kso').removeClass('img_foot2');
            $('#tab-sp').addClass('img_foot2');
            $('#tab-sg').addClass('img_foot2');
            $('#tab-st').addClass('img_foot2');
            $('#tab-tl').addClass('img_foot2');
            $('#tab-smi').addClass('img_foot2');
            
            $('#tab-volume').addClass('act_tb');
            $('#tab-revenew').removeClass('act_tb');
            setParam('7000', bulanSekarang, tahun);
            url = get_my_url(url, 'kso');
            window.location.href = url+".html";
            // fin_data(getParam('bln'), getParam('opco'), getParam('thn'));
        }

    })
  }
  