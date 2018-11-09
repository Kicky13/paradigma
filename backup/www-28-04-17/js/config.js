 var url_local = 'http://localhost/paradigma_data/paradigma_dev';
 var url_ol = 'http://10.15.5.150/dev/par4digma';
 var url_src = 'http://10.15.5.150/dev/Android';
 var url_opc = 'http://10.15.3.146/android';
 var url_tmp = 'http://10.15.5.150/dev/Android';

 var url_tab_prod_rm = {
      sp: 'prod_rm_sp.html',
      sg: 'prod_rm_sg.html',
      st: 'prod_rm_st.html',
      tlcc: 'prod_rm_tlcc.html' 
  };

  var url_tab_overview_detail = {
      sp: 'overview_sp_detail.html',
      sg: 'overview_sg_detail.html',
      st: 'overview_st_detail.html',
      tlcc: 'overview_tlcc_detail.html' 

  };

  var url_tab_sm_daily = {
      sp: 'sm_daily_sp.html',
      sg: 'sm_daily_sg.html',
      st: 'sm_daily_st.html',
      tlcc: 'sm_daily_tlc.html' 
  };

  var url_tab_sm_detail = {
      sp: 'sm_sp_detail.html',
      sg: 'sm_sg_detail.html',
      st: 'sm_st_detail.html',
      tlcc: 'sm_tl_detail.html' 
  };

  var url_tab_scm_hm = {
      sp: 'scm_hm_sp.html',
      sg: 'scm_hm_sg.html',
      st: 'scm_hm_st.html',
      tlcc: 'scm_hm_tl.html'
  };



 // function setFormat(nilai, dec){
 //  var tmp = accounting.formatMoney(nilai,"",dec,".",",");
 //  return tmp;
 // }
 // function run_waitMe(which, effect){
 //  $(which).waitMe({
 //   //none, rotateplane, stretch, orbit, roundBounce, win8, 
 //   //win8_linear, ios, facebook, rotation, timer, pulse, 
 //   //progressBar, bouncePulse or img
 //   effect: effect,
 //   //place text under the effect (string).
 //   text: '',
 //   //background for container (string).
 //   bg: 'rgba(255,255,255,0.7)',
 //   //color for background animation and text (string).
 //   color: '#000',
 //   //change width for elem animation (string).
 //   sizeW: '',
 //   //change height for elem animation (string).
 //   sizeH: '',
 //   // url to image
 //   source: '',
 //   // callback
 //   onClose: function(){}
 //  }); 
 // } 
 // function stop_waitMe(which){
 //  $(which).waitMe('hide');
 //  // console.log(which);
 // } 

 function getOpco(){
      var data = JSON.parse(sessionStorage.getItem('data'));
      // console.log('opco : '+opco);
      return data.OPCO;
      // return '7000';
 }
 function getlevel(){
      var data = JSON.parse(sessionStorage.getItem('data'));
      // console.log(data.ESELON);
      return null;
      // return data.OPCO;
 }

 function tab_bottom(link, opco){

      var current_link = (window.location.href).split('/').pop();
  
      if (opco == '4000') {
          $('#tab-sp').removeClass('img_foot2');
          $('#tab-sg').addClass('img_foot2');
          $('#tab-st').addClass('img_foot2');
          $('#tab-tl').addClass('img_foot2');
          if (current_link!=link.sp) {
            window.location.href = link.sp;
          }
          
      } else if (opco == '7000') {
          $('#tab-sp').addClass('img_foot2');
          $('#tab-sg').removeClass('img_foot2');
          $('#tab-st').addClass('img_foot2');
          $('#tab-tl').addClass('img_foot2');
          if (current_link!=link.sg) {
            window.location.href = link.sg;
          }
          
      } else if (opco == '3000') {
          $('#tab-sp').addClass('img_foot2');
          $('#tab-sg').addClass('img_foot2');
          $('#tab-st').removeClass('img_foot2');
          $('#tab-tl').addClass('img_foot2');
          if (current_link!=link.st) {
            window.location.href = link.st;
          }
          // window.location.href = link.st;
      } else if (opco == '6000') {
          $('#tab-sp').addClass('img_foot2');
          $('#tab-sg').addClass('img_foot2');
          $('#tab-st').addClass('img_foot2');
          $('#tab-tl').removeClass('img_foot2');
          if (current_link!=link.tlcc) {
            window.location.href = link.tlcc;
          }
          // window.location.href = link.tlcc;
      }
 }

 function tab_finance_detail(opco, finance){

    if (opco == '4000') {
        $('#tab-sp').removeClass('img_foot2');
        $('#tab-sg').addClass('img_foot2');
        $('#tab-st').addClass('img_foot2');
        $('#tab-tl').addClass('img_foot2');
        $('#table tbody').empty();
        $('#table tfoot').empty();
        // if (finance=='in') {
        //      income(opco);
        // }else{
        //   expanse(opco);
        // }
       
    } else if (opco == '7000') {
        $('#tab-sp').addClass('img_foot2');
        $('#tab-sg').removeClass('img_foot2');
        $('#tab-st').addClass('img_foot2');
        $('#tab-tl').addClass('img_foot2');
         $('#table tbody').empty();
        $('#table tfoot').empty();
        //  if (finance=='in') {
        //      income(opco);
        // }else{
        //   expanse(opco);
        // }
    } else if (opco== '3000') {
        $('#tab-sp').addClass('img_foot2');
        $('#tab-sg').addClass('img_foot2');
        $('#tab-st').removeClass('img_foot2');
        $('#tab-tl').addClass('img_foot2');
        $('#table tbody').empty();
        $('#table tfoot').empty();
        //  if (finance=='in') {
        //      income(opco);
        // }else{
        //   expanse(opco);
        // }
    } else if (opco == '6000') {
        $('#tab-sp').addClass('img_foot2');
        $('#tab-sg').addClass('img_foot2');
        $('#tab-st').addClass('img_foot2');
        $('#tab-tl').removeClass('img_foot2');
        $('#table tbody').empty();
        $('#table tfoot').empty();
        //  if (finance=='in') {
        //      income(opco);
        // }else{
        //   expanse(opco);
        // }
    }
              
 }
 function tab_bottom_dev(link){

    var level = getlevel();
    console.log('level :'+level);
    var current_link = (window.location.href).split('/').pop();


     $('a[href="#tab-click"]').click(function (e) {
          e.preventDefault();
          var r = $(this).attr('rel');

          if (level==null) {
            if (r == 'data-sp') {
                $('#tab-sp').removeClass('img_foot2');
                $('#tab-sg').addClass('img_foot2');
                $('#tab-st').addClass('img_foot2');
                $('#tab-tl').addClass('img_foot2');
                if (current_link!=link.sp) {
                  window.location.href = link.sp;
                }
                
            } else if (r == 'data-sg') {
                $('#tab-sp').addClass('img_foot2');
                $('#tab-sg').removeClass('img_foot2');
                $('#tab-st').addClass('img_foot2');
                $('#tab-tl').addClass('img_foot2');
                if (current_link!=link.sg) {
                  window.location.href = link.sg;
                }
            } else if (r == 'data-st') {
                $('#tab-sp').addClass('img_foot2');
                $('#tab-sg').addClass('img_foot2');
                $('#tab-st').removeClass('img_foot2');
                $('#tab-tl').addClass('img_foot2');
                if (current_link!=link.st) {
                  window.location.href = link.st;
                }
            } else if (r == 'data-tl') {
                $('#tab-sp').addClass('img_foot2');
                $('#tab-sg').addClass('img_foot2');
                $('#tab-st').addClass('img_foot2');
                $('#tab-tl').removeClass('img_foot2');
                if (current_link!=link.tlcc) {
                  window.location.href = link.tlcc;
                }
            }
          }
         
      })

 }
 function tab_prod_rm(){
    var link = this.url_tab_prod_rm;
    var opco = getOpco();
    tab_bottom(link, opco);
    tab_bottom_dev(link);
    // console.log(link.sg+'-'+opco);
 }