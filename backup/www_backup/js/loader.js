  var url_src = 'http://10.15.5.150/dev/par4digma';
 var url_opc = 'http://10.15.3.146/android';
 var url_tmp = 'http://10.15.5.150/dev/Android';

 

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