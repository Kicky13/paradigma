$(function(){
		var intervalTime = 3600000;//3600000
    var intervalStatus = false;
    var myTimer;
    myTimer = setInterval(intervalCallback, intervalTime);

    $('body').bind('touchstart',function() {
        console.log('touchstart');
        clearInterval(myTimer);
    });

    $('body').bind('touchend', function() {
        console.log('touchend');
        myTimer = setInterval(intervalCallback, intervalTime);
    });

   // document.addEventListener('resume',onResumeCallback, false);
});

function intervalCallback(){
             // alert('log');
    console.log('interval ');
    window.location.href = 'index_login2.html';
}

function setParam(company, bulan, tahun){
  sessionStorage.setItem('opco', company);
  sessionStorage.setItem('bln', bulan);
  sessionStorage.setItem('thn', tahun);
}

function gotoPage(company=null, bulan=null, tahun=null, url){
  setParam(company,bulan, tahun);
  window.location.href = url+".html";
}

function getParamFull(){
  var properties = [];  
  if (sessionStorage.getItem('opco')!=null) {
   var data = sessionStorage.getItem('opco');
   properties['opco'] = data;
  }
  if (sessionStorage.getItem('bln')!=null) {
   var data = sessionStorage.getItem('bln');
   properties['bln'] = data;
  }
  if (sessionStorage.getItem('thn')!=null) {
   var data = sessionStorage.getItem('thn');
   properties['thn'] = data;
  }

  return properties;    
}
function getParam(tag){
  var properties ;  
  if (sessionStorage.getItem(tag)!=null) {
   var data = sessionStorage.getItem(tag);
   properties = data;
  }

  return properties;    
}

function getSession(){
  var properties = [];  
  if (sessionStorage.getItem('userData')!=null) {
   var data = sessionStorage.getItem('userData');
   var dataJson = JSON.parse(data);

   $.each(dataJson, function(index, el){
      properties[index] = el;

   })


  }
 

  return properties;    
}
// function onResumeCallback(){
//   alert('welcome home!!');
// }