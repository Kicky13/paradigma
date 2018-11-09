<?php
$email_to = 'Kepala Biro';
$email_cc = 'Wakil';
?>
<html>
    <head>
        <title>Admin PAR4DIGMA</title>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
        <style>
            body{
                font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
            }
            #gradient-style
            {
                font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
                font-size: 12px;
                margin: 45px;
                width: 480px;
                text-align: left;
                border-collapse: collapse;
            }
            #gradient-style th
            {
                font-size: 13px;
                font-weight: normal;
                padding: 8px;
                background: #1C2A39;
                border-top: 2px solid #d3ddff;
                border-bottom: 1px solid #fff;
                color: #ffffff;
                text-align: center;
            }
            #gradient-style td
            {
                padding: 8px; 
                border-bottom: 1px solid #fff;
                color: #669;
                border-top: 1px solid #fff;
                background: #e8edff;
            }
            #gradient-style tfoot tr td
            {
                background: #e8edff;
                font-size: 12px;
                color: #99c;
            }
            #gradient-style tbody tr:hover td
            {
                background: #d0dafd;
                color: #339;
            }
        </style>
    </head>
    <body>
        <div>
            <p style="padding: 0px; margin: 2px;">Kepada YTH</p>
            <p style="padding: 0px; margin: 2px;"><?php echo $email_to; ?></p>
            <p style="padding: 0px; margin: 2px;"><?php echo $email_cc; ?></p>
            <p>Dengan hormat</p>
            <p>Berikut informasi posisi Stock Material yang sudah dibawah minimum stock sebagai berikut :</p>
            <table id="gradient-style" summary="SCM Results">
                <thead>
                    <tr>
                        <th scope="col">Material</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Min. Stock</th>
                        <th scope="col">ROP</th>
                        <th scope="col">Update</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="5">Source Data dari <a href="https://scm.semenindonesia.com/scm/">scm.semenindonesia.com</a></td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $nama = array("Batu Bara", "Trass", "Fly Ash", "Coal");
                    $stok = array(1000, 1000, 1000, 1000);
                    $min = array(10000, 10000, 10000, 10000);
                    $rop = array(5000, 5000, 5000, 5000);
                    $update = array('29 Jan 2017', '28 Jan 2017', '20 Jan 2017', '21 Jan 2017');

                    for ($i = 0; $i <= 3; $i++) {
                        echo '<tr>
                                    <td><b>' . $nama[$i] . '</b></td>
                                    <td>' . $stok[$i] . '</td>
                                    <td>' . $min[$i] . '</td>
                                    <td>' . $rop[$i] . '</td>
                                    <td>' . $update[$i] . '</td>
                                </tr>';
                    }
                    ?>
                </tbody>
            </table>
            <p>Informasi ini terkirim secara otomatis dari System PAR4DIGMA</p>
            <p style="padding: 0px; margin: 2px;">Terimakasih</p>
        </div>
    </body>
</html>