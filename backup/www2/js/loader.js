  var url_src = 'http://10.15.5.150/dev/par4digma';
 var url_opc = 'http://10.15.3.146/android';
 var url_tmp = 'http://10.15.5.150/dev/Android';

var listTab = ['sp', 'sg', 'st', 'tl', 'smi'];

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