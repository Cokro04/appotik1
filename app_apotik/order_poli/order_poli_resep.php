<?php include "inc.session.php";
$Kode  = $_GET['Kode'];
?>
<script>
  var Kode = $Kode;
</script>

<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="css/component-chosen.css" rel="stylesheet">

<div class="br-mainpanel">

  <div class="br-pagetitle">
    <i class="fa fa-inbox fa-4x"></i>
    <div>
      <h4>Data Order Poli</h4>
      <p class="mg-b-0">Berikut adalah data order poli</p>
    </div>
  </div><!-- d-flex -->

  <div class="br-pagebody">
    <div class="br-section-wrapper">

      <?php

      $mySql    = "SELECT antrian.*, pasien.* FROM pasien
      LEFT JOIN antrian ON antrian.no_pasien = pasien.no_pasien
      WHERE antrian.no_registrasi = '$Kode'";

      $myQry    = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
      $myData  = mysql_fetch_array($myQry);

      $tanggal  = new DateTime($myData['tanggal_lahir']);
      // $date2    = date_create($myData['tanggal_bayar_lunas']);

      // tanggal hari ini
      $today = new DateTime('today');

      // tahun
      $y = $today->diff($tanggal)->y;

      // bulan
      $m = $today->diff($tanggal)->m;

      // hari
      $d = $today->diff($tanggal)->d;

      // format tanggal
      $date2 = date_create($myData['waktu_registrasi']);

      //gender awesome
      $kel  = $myData['jenis_kelamin'];

      if ($kel == "L") {
        $hasilKel  = "<i class='fa fa-mars' aria-hidden='true'></i>";
      } else {
        $hasilKel  = "<i class='fa fa-venus' aria-hidden='true'></i>";
      }
      ?>

      <?php
      // Query untuk di tampilkan pada tabel
      $mySQL = "SELECT obat_copy.*, order_obat_item.* FROM obat_copy
      LEFT JOIN order_obat_item ON order_obat_item.kode_obat = obat_copy.kode_obat
      WHERE order_obat_item.no_order_obat = '$Kode' AND (order_obat_item.status = '1' OR order_obat_item.status = '2' OR order_obat_item.status = '3') ORDER BY obat_copy.nama_obat, order_obat_item.status ";
      $myQry = mysql_query($mySQL, $koneksidb) or die("Query salah : " . mysql_error());

      $mySQLAsli = "SELECT obat_copy.*, order_obat_item.* FROM obat_copy
      LEFT JOIN order_obat_item ON order_obat_item.kode_obat = obat_copy.kode_obat
      WHERE order_obat_item.no_order_obat = '$Kode' AND NOT (order_obat_item.status = '1' OR order_obat_item.status = '2' OR order_obat_item.status = '3') ";
      $myQryAsli = mysql_query($mySQLAsli, $koneksidb) or die("Query salah : " . mysql_error());

      $MySeleksi = "SELECT obat_copy.*, order_obat_item.* FROM obat_copy
      LEFT JOIN order_obat_item ON order_obat_item.kode_obat = obat_copy.kode_obat
      WHERE order_obat_item.no_order_obat = '$Kode' AND (order_obat_item.status = '2' OR order_obat_item.status = '3')";
      $QrySeleksi = mysql_query($MySeleksi, $koneksidb) or die("Query salah : " . mysql_error());

      $MySQLPar = "SELECT obat_copy.*, order_obat_item.* FROM obat_copy
      LEFT JOIN order_obat_item ON order_obat_item.kode_obat = obat_copy.kode_obat
      WHERE order_obat_item.no_order_obat = '$Kode' AND NOT (order_obat_item.status = '1' OR order_obat_item.status = '2' OR order_obat_item.status = '3') ";
      $MyQryPar = mysql_query($MySQLPar, $koneksidb) or die("Query salah : " . mysql_error());

      $MySQLPar1 = "SELECT obat_copy.*, order_obat_item.* FROM obat_copy
      LEFT JOIN order_obat_item ON order_obat_item.kode_obat = obat_copy.kode_obat
      WHERE order_obat_item.no_order_obat = '$Kode' AND (order_obat_item.status = '1' OR order_obat_item.status = '2' OR order_obat_item.status = '3') ";
      $MyQryPar1 = mysql_query($MySQLPar1, $koneksidb) or die("Query salah : " . mysql_error());
      ?>


      <?php
      // Obat Diambil atau di tebus.
      if (isset($_POST['btnTebus'])) {

        $id                   = count($_POST['id_insert']);

        $no_order_obat_a      = $_POST['no_order_obat_a'];
        $no_order_obat        = $_POST['no_order_obat'];
        $kode_obat            = $_POST['kode_obat'];
        $qty                  = $_POST['qty_insert'];
        $aturan_minum         = $_POST['aturan_minum'];
        $harga_obat           = $_POST['harga_obat'];
        $waktu_transaksi      = date('Y-m-d H:i:s');
        $total_transaksi      = $_POST['total_transaksi'];
      	$total_transaksi2     = str_replace(".", "", $total_transaksi );
        $uang_bayar           = $_POST['uang_bayar'];
        $no_pasien            = $_POST['no_pasien'];

        for ($i = 0; $i < $id; $i++){
          // Query Untuk insert sekaligus banyak data ke penjualan obat item
          $SqlObatItem  = "INSERT INTO penjualan_obat_item (no_transaksi, kode_obat, qty, aturan_minum, harga_obat) VALUES ('$no_order_obat_a[$i]','$kode_obat[$i]','$qty[$i]','$aturan_minum[$i]','$harga_obat[$i]')";
          $db           = mysql_query($SqlObatItem);
          // Query Untuk update stok obat
          $MySQL        = "UPDATE obat_copy SET stok='" . $_POST['stoks'][$i] . "' WHERE kode_obat='" . $kode_obat[$i] . "'";
          $db           = mysql_query($MySQL);
        }

        // Query untuk insert data penjualan obat
        $SqlObatPenj = "INSERT INTO penjualan_obat (no_transaksi, waktu_transaksi, no_pasien, total_transaksi, uang_bayar) VALUES ('$no_order_obat','$waktu_transaksi','$no_pasien','$total_transaksi2','$uang_bayar')";
        $db          = mysql_query($SqlObatPenj);
        // Query untuk update data status ambil obat menjadi 1
        $sql         = "UPDATE antrian SET ambil_obat='" . $_POST['ambil_obat'] . "' WHERE no_registrasi='" . $_POST['no_order_obat'] . "'";
        $dbs         = mysql_query($sql);
        if ($dbs) {
          echo "<script>";
          echo "swal({
              type: 'success',
              title: 'Obat Telah Diambil',
                      text: '',
                timer: 5000,
                showConfirmButton: false,
              html: true
                    })";
          echo "</script>";

          // $lokasi = $_SERVER['PHP_SELF'];
          // $tujuan = '?open=Order-Obat-Data';
          // $url = $lokasi . $tujuan . $Kode;
          //
          // echo "<script>";
          // echo "window.location.replace('$url')";
          // echo "</script>";

          echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Order-Obat-Data"} , 1500);</script>';
          echo "<script>";
          echo "window.open('cetak_ambil_obat.php?kodeRegis=$Kode', width=330,height=330,left=100, top=25)";
          echo "</script>";
        }
      }
      // Akhir Ambil obat
      ?>

      <?php
      // kode untuk menambah data
      if (isset($_POST['btnAdd'])) {

        $no_order_obat  = $_POST['no_order_obat'];
        $kode_obat      = $_POST['kode_obat'];
        $qty            = $_POST['qty'];
        $aturan_minum   = $_POST['aturan_minum'];
        $status         = $_POST['status'];

        $myCekAdd    = "SELECT * FROM order_obat_item WHERE no_order_obat ='$no_order_obat' AND kode_obat= '$kode_obat'";
        $pageQryAdd	= mysql_query($myCekAdd, $koneksidb) or die ("error paging: ".mysql_error());
        $cekAdaAdd 	= mysql_num_rows($pageQryAdd);

        if ($cekAdaAdd > 0){

          echo "<script>";
          echo "swal({
                  type: 'error',
                  title: 'Maaf Data Obat Telah Ada',
                          text: '',
                    timer: 5000,
                    showConfirmButton: false,
                  html: true
                        })";
          echo "</script>";

        }else{

          $sqlAddObat = "INSERT INTO order_obat_item (no_order_obat, kode_obat, qty, aturan_minum, status) VALUES ('$no_order_obat','$kode_obat','$qty','$aturan_minum','$status')";
          $dbAdd = mysql_query($sqlAddObat, $koneksidb) or die("Gagal query" . mysql_error());

          if ($dbAdd) {

            echo "<script>";
            echo "swal({
                    type: 'success',
                    title: 'Edit Telah Berhasil',
                            text: '',
                      timer: 2000,
                      showConfirmButton: false,
                    html: true
                          })";
            echo "</script>";

            $a = $_SERVER['PHP_SELF'];
            $b = '?open=Order-Obat-Resep&Kode=';
            $c = $a . $b . $Kode;

            echo "<script>";
            echo "window.location.replace('$c')";
            echo "</script>";

          }

        }
        // Query untuk insert data obat ditambah baru

      }
      // Akhir dari menambah data obat
      ?>

      <?php
      // Kode Untuk Memperbaharui data obat tanpa menambah baris
      if (isset($_POST['btnAddEdit'])) {

        $no_order_obat    = $_POST['no_order_obat_modal'];
        $kode_obat        = $_POST['kode_obat_modal'];
        $qty              = $_POST['qty_data_modal'];
        $aturan_minum     = $_POST['aturan_minum_data_modal'];
        $status           = $_POST['status_modal'];
        $id_modal         = $_POST['id_data_modal'];
        $status1          = $_POST['status1_modal'];

        $sqlUpdt = "UPDATE order_obat_item SET  status= $status1 WHERE id=$id_modal";
        $dbsH = mysql_query($sqlUpdt);


        //update obat jika sudah ada dalam temp

        $myCek    = "SELECT * FROM order_obat_item WHERE no_order_obat ='$no_order_obat' AND kode_obat= '$kode_obat'";
        $pageQry	= mysql_query($myCek, $koneksidb) or die ("error paging: ".mysql_error());
        $cekAda 	= mysql_num_rows($pageQry);

        if ($cekAda > 0){

          $sqlAddObat = "UPDATE order_obat_item SET qty = qty+$qty , aturan_minum = '$aturan_minum' , status = $status WHERE no_order_obat = '$no_order_obat' AND (kode_obat = '$kode_obat' AND harga_obat = '0')";
          $dbAdd = mysql_query($sqlAddObat, $koneksidb) or die("Gagal query" . mysql_error());

        }else{

          $sqlAddObat = "INSERT INTO order_obat_item (no_order_obat, kode_obat, qty, aturan_minum, status) VALUES ('$no_order_obat','$kode_obat','$qty','$aturan_minum','$status')";
          $dbAdd = mysql_query($sqlAddObat, $koneksidb) or die("Gagal query" . mysql_error());

        }

        if ($dbAdd) {

          echo "<script>";
          echo "swal({
                  type: 'success',
                  title: 'Edit Telah Berhasil',
                          text: '',
                    timer: 2000,
                    showConfirmButton: false,
                  html: true
                        })";
          echo "</script>";

          $a = $_SERVER['PHP_SELF'];
          $b = '?open=Order-Obat-Resep&Kode=';
          $c = $a . $b . $Kode;

          echo "<script>";
          echo "window.location.replace('$c')";
          echo "</script>";
        }
      }
      // Akhir Kode

      if(isset($_POST['qty']) && isset( $_POST['id'])){

        foreach ($_POST['id'] as $key => $value) {
          $idedit = $_POST['id'][$key];
          $qtyUpd = $_POST['qty'][$key];


          $sqlEditOrder = "UPDATE order_obat_item SET qty = $qtyUpd WHERE id = '$idedit'";
          $dbAdd = mysql_query($sqlEditOrder, $koneksidb) or die("Gagal query" . mysql_error());

          if ($dbAdd) {

            $a = $_SERVER['PHP_SELF'];
            $b = '?open=Order-Obat-Resep&Kode=';
            $c = $a . $b . $Kode;

            echo "<script>";
            echo "window.location.replace('$c')";
            echo "</script>";
          }
        }
      }

      if(isset($_POST['btnApprov'])){

        foreach ($_POST['id1'] as $key => $value) {

          $no_order_obat1    = $_POST['no_order_obat1'][$key];
          $kode_obat1        = $_POST['kode_obat1'][$key];
          $qty1              = $_POST['qty1'][$key];
          $aturan_minum1     = $_POST['aturan_minum1'][$key];
          $status2           = $_POST['status2'][$key];


          $sqlApprov = "INSERT INTO order_obat_item (no_order_obat, kode_obat, qty, aturan_minum, status) VALUES ('$no_order_obat1','$kode_obat1','$qty1','$aturan_minum1','$status2')";
          $dbApprov = mysql_query($sqlApprov, $koneksidb) or die("Gagal query" . mysql_error());

          if ($dbApprov) {

            $a = $_SERVER['PHP_SELF'];
            $b = '?open=Order-Obat-Resep&Kode=';
            $c = $a . $b . $Kode;

            echo "<script>";
            echo "window.location.replace('$c')";
            echo "</script>";
          }
        }

      }
      ?>

<!-- Data info pasien -->
      <div class="col-md-12 mg-t-20">
        <div class="card bd-0">
          <div class="card-header tx-medium bd-0 tx-white bg-teal">
            Informasi Pasien
          </div><!-- card-header -->

          <div class="card-body bd bd-t-0 rounded-bottom">
            <table width="100%" border="0">
              <tbody>
                <tr>
                  <td>No. Registrasi</td>
                  <td>:</td>
                  <td><?php echo $Kode ?></td>
                </tr>
                <tr>
                  <td>Tanggal Regis</td>
                  <td>:</td>
                  <td><?php echo IndonesiaTgl($myData['tanggal_registrasi']); ?></td>
                </tr>
                <tr>
                  <td width="33%">No. Pasien</td>
                  <td width="1%">:</td>
                  <td width="66%"><?php echo $myData['no_pasien'] ?></td>
                </tr>
                <tr>
                  <td><span class="mg-b-0">Nama. Pasien</span></td>
                  <td>:</td>
                  <td><?php echo $hasilKel ?> / <?php echo strtoupper($myData['nama_pasien']) ?>
                  </td>
                </tr>
                <td>Usia</td>
                <td>:</td>
                <td><?php echo $y; ?> tahun <?php echo $m; ?> bulan <?php echo $d; ?> hari</td>
                </tr>
              </tbody>
            </table>
            <br>
<!-- Akhir info data pasien -->

        <!-- tombol modal tambah data -->
        <?php   $myData   = mysql_num_rows($MyQryPar1); ?>
        <?php if ($myData > '0'): ?>
            <a href="#" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-toggle="modal" data-target="#modaldemo1">Tambah Obat</a>
        <?php endif; ?>
        <!-- Akhir tombol tambah data -->

<!-- data asli dari dokter -->


<?php
$dataPembanding  = mysql_fetch_array($MyQryPar);

if($dataPembanding['status'] == '0') {
  ?>

      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">

        <table id="example" class="table display responsive nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Obat</th>
              <th>Aturan Minum</th>
              <th>Jumlah</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $i = 1;
            $totalTagihan  = 0; ?>
            <?php while ($myData = mysql_fetch_array($myQryAsli)) {
              if($myData['status'] == 0 OR $myData['status'] == 2){
                $subTotal    = $myData['hasil_hna_ppn'] * $myData['qty'];
                $totalTagihan  = $totalTagihan + $subTotal;
              }
              $KodeObat       = $myData['kode_obat'];
              $HTotal         = format_angka($totalTagihan);
            ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= $myData['nama_obat']; ?></td>
                <td><?= $myData['aturan_minum']; ?></td>
                <td><?= $myData['qty']; ?></td>
              </tr>
              <input type="hidden" value="<?= $myData['id'] ?>" name="id1[]">
              <input type="hidden" value="<?= $myData['no_order_obat'] ?>" name="no_order_obat1[]">
              <input type="hidden" value="<?= $myData['kode_obat'] ?>" name="kode_obat1[]">
              <input type="hidden" value="<?= $myData['qty'] ?>" name="qty1[]">
              <input type="hidden" value="<?= $myData['aturan_minum'] ?>" name="aturan_minum1[]">
              <input type="hidden" value="<?= $myData['hasil_hna_ppn'] ?>" name="harga_obat1[]">
              <input type="hidden" value="3" name="status2[]">
            <?php } ?>
          </tbody>
        </table>
<?php $myDataA   = mysql_num_rows($MyQryPar1); ?>
<?php if ($myDataA == '0'): ?>
<input type="submit" name="btnApprov" value=" approve " class="btn btn-info" onclick="return confirm('Yakin Sudah Sesuai ?')" />
<?php endif; ?>


      </form>


<br><br>
<?php }
$dataPem  = mysql_num_rows($MyQryPar1);
if($dataPem > '0') { ?>


        <!-- form input update data obat -->
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form2" target="_self" enctype="multipart/form-data" class="pure-form">
              <!-- tabel data obat yang di pesan -->
              <table id="example" class="table display responsive nowrap">
                <thead>
                  <tr>
                    <th>Aksi</th>
                    <th>Nama Obat</th>
                    <th>Aturan Minum</th>
                    <th>Status Obat</th>
                    <th>Info</th>
                    <th>Jumlah</th>
                    <th style="text-align:right">Harga Satuan (Rp.)</th>
                    <th style="text-align:right">Subtotal (Rp.)</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $totalTagihan  = 0; ?>
                  <?php while ($myData = mysql_fetch_array($myQry)) {
                    if($myData['status'] == 3 OR $myData['status'] == 2){
                      $subTotal    = $myData['hasil_hna_ppn'] * $myData['qty'];
                      $totalTagihan  = $totalTagihan + $subTotal;
                    }
                    $KodeObat       = $myData['kode_obat'];
                    $HTotal         = format_angka($totalTagihan);
                  ?>
                    <tr>
                      <td>
                        <!-- tombol modal perbaharui data obat -->
                        <a href="#" class="btn btn-warning " data-toggle="modal" data-target="#modal<?=$myData['id']; ?>" title="Perbaharui Data Obat"><i class="fa fa-edit"></i></a>
                        <!-- akhir tombol -->
                      </td>
                      <td><?= $myData['nama_obat']; ?></td>
                      <td><?= $myData['aturan_minum']; ?></td>
                      <td>
                        <?php if ($myData['stok'] < $myData['qty']) { ?>
                            <font color="#FF0000"><strong><?= 'Obat Kurang' ?></strong></font>
                        <?php } else { ?>
                            <font color="#279144"><strong><?= 'Obat Ada' ?></strong></font>
                        <?php } ?>
                      </td>
                      <td>
                        <?php
                        if ($myData['status'] == 2){
                          echo 'pengganti';
                        } elseif ($myData['status'] == 1) {
                          echo 'diganti';
                        }
                        ?>
                      </td>

                      <td>

                        <input type="hidden" value="<?= $myData['id']; ?>" style="width:50%;" name="id[]" onchange="this.form.submit()">

                        <input type="text" value="<?= $myData['qty']; ?>"  max="<?= $myData['stok']; ?>" min="1" style="width:50%;" placeholder="<?= $myData['stok']; ?>" onkeypress="return angkadanhuruf(event,'1234567890',this);this.form.submit()" name="qty[]" onchange="this.form.submit()"  >

                      </td>

                      <td align="right"><?= format_angka($myData['hasil_hna_ppn']);?></td>
                      <td align="right">
                      <?php if ($myData['status'] == "1"){ ?>
                        <font color="#FF0000"><?= format_angka($myData['hasil_hna_ppn'] * $myData['qty']); ?></font>
                      <?php } else { ?>
                        <?= format_angka($myData['hasil_hna_ppn'] * $myData['qty']); ?>
                      <?php } ?>
                      </td>
                    </tr>
                    <?php
                        $MySqlAdd = "SELECT * FROM order_obat_item WHERE no_order_obat = '$Kode'";
                        $MyQryAdd = mysql_query($MySqlAdd, $koneksidb) or die("Query salah : " . mysql_error());
                        $addNewData = mysql_fetch_array($MyQryAdd);
                    ?>
                    <!-- awal modal untuk memperbaharui data obat -->
                      <div id="modal<?= $myData['id']; ?>" class="modal fade">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content bd-0 tx-14">
                            <div class="modal-header pd-y-20 pd-x-25">
                              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Perbaharui Obat</h6>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body pd-25">
                              <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">
                                <div class="form-group">
                                  <label for="formGroupExampleInput">Nama Obat</label>
                                  <input type="hidden" class="form-control" value="<?= $myData['id']; ?>" name="id_data_modal">
                                  <input type="hidden" class="form-control" value="<?= $addNewData['no_order_obat'] ?>" name="no_order_obat_modal">
                                <select name="kode_obat_modal" class="chosen-select">
                                 <option value="">pilih obat</option>
                                       <?php
                                       $SqlObat = "SELECT * FROM obat_copy ORDER BY nama_obat";
                                       $QryObat = mysql_query($SqlObat, $koneksidb) or die ("Gagal Query".mysql_error());
                                   while ($bacaData = mysql_fetch_array($QryObat)) {
                                     // Status terpilih
                                   if ($bacaData['kode_obat'] == $dataProvinsi) {
                                     $pilih = " selected";
                                   } else { $pilih=""; }

                                   $hargaObat = format_angka($bacaData[hasil_hna_ppn]);

                                   echo "<option value='$bacaData[kode_obat]' $pilih> $bacaData[nama_obat] - Rp.$hargaObat </option>";
                                   }
                                  ?>
                               </select>
                              </div>

                                <div class="form-group">
                                  <label for="formGroupExampleInput2">Jumlah</label>
                                  <input type="text" class="form-control" name="qty_data_modal" value="1"  onkeypress="return angkadanhuruf(event,'1234567890',this)" maxlength="2">
                                </div>
                                <div class="form-group">
                                  <label for="formGroupExampleInput2">Aturan Minum</label>
                                  <select class="form-control" data-placeholder="Choose Browser" name="aturan_minum_data_modal">
                                    <option value="1 x 1">1 x 1</option>
                                    <option value="1 x 2">1 x 2</option>
                                    <option value="1 x 3">1 x 3</option>
                                  </select>
                                  <input type="hidden" class="form-control" value="2" name="status_modal">
                                  <input type="hidden" class="form-control" value="1" name="status1_modal">
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" name="btnAddEdit" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Input</button>
                              <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Batal</button>
                            </div>
                              </form>
                          </div>
                        </div>
                    </div>
                    <!-- Akhir daro modal -->
                  <?php } ?>

                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                      <strong>Total Tagihan Rp. </strong>
                    </td>
                    <td>
                    <font size="+2">
                      <input type="text" value="<?= $HTotal ?>" class="form-control" style="text-align:right;font-weight: bold" readonly />
                      <input type="hidden" id="txt2" value="<?= ($totalTagihan) ?>"  onkeyup="sum();" class="form-control" name="total_transaksi" readonly />
                    </font>
                    </td>
                  </tr>

                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                      <strong>Uang Bayar Rp. </strong>
                    </td>
                    <td>
                      <input type="number" id="txt1"  onkeyup="sum();" class="form-control" name="uang_bayar" style="text-align:right" />
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                      <strong>Uang Kembalian Rp. </strong>
                    </td>
                    <td>
                      <input type="text" id="txt3" class="form-control" style="text-align:right" />
                    </td>
                  </tr>
                </tbody>
              </table>
              <!-- Akhir tabel data obat yang di pesan -->

              <?php
                while ($inputData = mysql_fetch_array($QrySeleksi)) {
              ?>


              <input type="hidden" value="<?= $inputData['kode_obat']; ?>" name="kode_obat[]">
              <input type="hidden" value="<?= $myData['id'] ?>" name="id_insert[]">
              <input type="hidden" value="1" name="ambil_obat">
              <input type="hidden" value="<?= ($inputData['stok']) - ($inputData['qty']) ?>" name="stoks[]">
              <input type="hidden" value="<?= $inputData['no_order_obat'] ?>" name="no_order_obat">
              <input type="hidden" value="<?= $inputData['no_order_obat'] ?>" name="no_order_obat_a[]">
              <input type="hidden" value="<?= $inputData['qty'] ?>" name="qty_insert[]">
              <input type="hidden" value="<?= $inputData['aturan_minum'] ?>" name="aturan_minum[]">
              <input type="hidden" value="<?= $inputData['hasil_hna_ppn'] ?>" name="harga_obat[]">
            <?php } ?>

              <?php
              $mySql    = "SELECT * FROM antrian WHERE no_registrasi = '$Kode'";
              $MyQ    = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
              $myData   = mysql_fetch_array($MyQ); ?>
              <input type="hidden" name="no_pasien" value="<?= $myData['no_pasien'] ?>"/>

              <?php if ($myData['ambil_obat'] == '0') { ?>
                <input type="submit" name="btnTebus" value=" Ambil Obat " class="btn btn-info" onclick="return confirm('Yakin Sudah Sesuai ?')" />
              <?php } else { ?>
                <input type="submit" value=" Obat Sudah DiAmbil " class="btn btn-info" />
              <?php } ?>

            </form>

      <?php } ?>
    <!--Akhir form input update data obat -->
          </div>
        </div><!-- card -->
      </div><!-- col -->

    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->

</div><!-- br-mainpanel -->

<?php

    $MySqlAdd = "SELECT * FROM order_obat_item WHERE no_order_obat = '$Kode'";
    $MyQryAdd = mysql_query($MySqlAdd, $koneksidb) or die("Query salah : " . mysql_error());
?>
<?php $addData = mysql_fetch_array($MyQryAdd); ?>
<div id="modaldemo1" class="modal fade">

    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content bd-0 tx-14">
        <div class="modal-header pd-y-20 pd-x-25">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Data Obat</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-25">
          <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">
            <div class="form-group">

              <label for="formGroupExampleInput">Nama Obat</label>
              <input type="hidden" class="form-control" value="<?= $addData['no_order_obat'] ?>" name="no_order_obat">
            <select name="kode_obat" class="chosen-select">
             <option value="">pilih obat</option>
                   <?php
                   $SqlObat = "SELECT * FROM obat_copy ORDER BY nama_obat";
                   $QryObat = mysql_query($SqlObat, $koneksidb) or die ("Gagal Query".mysql_error());
               while ($bacaData = mysql_fetch_array($QryObat)) {
                 // Status terpilih
               if ($bacaData['kode_obat'] == $dataProvinsi) {
                 $pilih = " selected";
               } else { $pilih=""; }

               $hargaObat = format_angka($bacaData[hasil_hna_ppn]);

               echo "<option value='$bacaData[kode_obat]' $pilih> $bacaData[nama_obat] - Rp.$hargaObat </option>";
               }
              ?>
           </select>


            </div>
            <div class="form-group">
              <label for="formGroupExampleInput2">Jumalah</label>
              <input type="number" class="form-control" name="qty" min="1">
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput2">Aturan Minum</label>
              <select class="form-control" data-placeholder="Choose Browser" name="aturan_minum">
                <option value="1 x 1">1 x 1</option>
                <option value="1 x 2">1 x 2</option>
                <option value="1 x 3">1 x 3</option>
              </select>
              <input type="hidden" class="form-control" value="2" name="status">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="btnAdd" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save changes</button>
          <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
        </div>
          </form>
      </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->


<script>
function sum() {
      var txtFirstNumberValue = document.getElementById('txt1').value;
      var txtSecondNumberValue = document.getElementById('txt2').value;
      var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
      if (!isNaN(result)) {
         document.getElementById('txt3').value = result;
      }
}
</script>
