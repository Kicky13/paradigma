<!DOCTYPE html>
<html lang="en">
<head>
  <title>Upload Data</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  
  <div class="row" style="padding: 0px; margin: 0px;">
    <div class="col-xs-12 col-md-12">
        <div class="col-xs-6 col-md-6">
            <img src="<?php echo base_url(); ?>assets/img/pp.jpg" alt="PAR4DIGMA" style="float: left; width: 50px; padding-top: 9px; padding-bottom: 9px;">
            <div><h3 style="font-weight: bold; font-style: italic;">&nbsp;Upload Data </h3></div>
        </div>
    </div>
</div>

<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">&nbsp</div>
    <div class="panel-body">
      <table class="table table-bordered">
        <tr>
          <td>Data Realisasi Produksi</td>
          <td><button class="btn btn-success" onclick="upload_real()">Upload</button></td>
        </tr>
        <tr>
          <td>Data RKAP & Prognosa Produksi</td>
          <td><button class="btn btn-success" onclick="upload_rkap()">Upload</button></td>
        </tr>
        <tr>
          <td>Data RKAP & Prognosa Sales</td>
          <td><button class="btn btn-success" onclick="upload_rkap_sales()">Upload</button></td>
        </tr>
      </table>

    </div>
  </div>
</div>

 <!-- Modal -->
  <div class="modal fade" id="upload_real" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="title"></h4>
        </div>
        <div class="modal-body">
        <div id="pesan_error"></div>
        <form id="form_upload_data" method="post" enctype="multipart/form-data">
          <input type="file" name="file" id="file" accept="application/vnd.ms-excel">
          <div style="font-size: 9px;">*xls</div>
          <div id="link_template"></div>
        </form>
        <div id="load"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="simpan_real" onclick="simpan_real('real')">Upload</button>
          <button type="button" class="btn btn-primary" id="simpan_rkap" onclick="simpan_real('rkap')">Upload</button>
          <button type="button" class="btn btn-primary" id="simpan_rkap_sales" onclick="simpan_real('sales')">Upload</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <script type="text/javascript">
    function upload_real() {
      $('#title').html('Upload Data Realisasi Produksi');
      $('#upload_real').modal('show');
      $('#simpan_rkap').hide();
      $('#simpan_rkap_sales').hide();
      $('#simpan_real').show();
      $('#pesan_error').html('');
      $('#file').val('');
      $('#link_template').html('<a href="<?=base_url()?>assets/ZREPORT_REAL_PRODUK_ST.xls" style="font-size: 12px;text-decoration:none">Template Upload Data Realisasi Produksi</a>');
    }

     function upload_rkap() {
      $('#title').html('Upload Data RKAP Produksi');
      $('#upload_real').modal('show');
      $('#simpan_rkap').show();
      $('#simpan_rkap_sales').hide();
      $('#simpan_real').hide();
      $('#pesan_error').html('');
      $('#file').val('');
      $('#link_template').html('<a href="<?=base_url()?>assets/ZREPORT_RKAP_PRODUK_ST.xls" style="font-size: 12px;text-decoration:none">Template Upload Data RKAP Produksi</a>');
    }

    function upload_rkap_sales(){
       $('#title').html('Upload Data RKAP Sales');
      $('#upload_real').modal('show');
      $('#simpan_rkap').hide();
      $('#simpan_real').hide();
      $('#simpan_rkap_sales').show();
      $('#pesan_error').html('');
      $('#file').val('');
      $('#link_template').html('<a href="<?=base_url()?>assets/ZREPORT_RKAP_SALES_ST.xls" style="font-size: 12px;text-decoration:none">Template Upload Data RKAP Produksi</a>');
    }

    function simpan_real(link) {
      var file_import = $('#file').prop('files')[0];
      if(link=='real'){
        var url1= '<?=site_url('upload_data/import_data_real_produksi')?>';
      }else if(link=='rkap'){
        var url1= '<?=site_url('upload_data/import_data_rkap_produksi')?>';
      }else{
         var url1= '<?=site_url('upload_data/import_data_rkap_sales')?>';
      }
            var form_data = new FormData();
            form_data.append('file',file_import);
            if($('#file').val()==''){
              $('#pesan_error').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>File Import Masih Kosong!.</div>');

            }else{
            $.ajax({
                url : url1,
                type : 'post',
                data : form_data,
                processData: false,
                contentType: false,
                beforeSend : function () {
                  $('#load').html('<img src="<?=base_url()?>assets/img/loading.gif" style="width: 180px;height: 80px;">');
                  document.getElementById("simpan_real").disabled = true; 

                },
                success : function(data){
                  $('#load').html('');
                  document.getElementById("simpan_real").disabled = false; 
                      $('#pesan_error').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data+' </div>');
                    }
            })
          }
    }
  </script>
</body>

</html>
