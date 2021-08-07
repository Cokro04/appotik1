<?php include "inc.session.php";
$Kode  = $_GET['Kode'];
?>

<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">

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
      $mySql    = "SELECT antrian.*, pasien.*, order_obat_item.* FROM order_obat_item
			    LEFT JOIN antrian ON antrian.no_registrasi = order_obat_item.no_order_obat
				  LEFT JOIN pasien ON pasien.no_pasien = antrian.no_pasien
			    WHERE order_obat_item.no_order_obat = '$Kode'";
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
      $mySQL = "SELECT obat_copy.*, penjualan_obat_item.* FROM obat_copy
      LEFT JOIN penjualan_obat_item ON penjualan_obat_item.kode_obat = obat_copy.kode_obat
      WHERE penjualan_obat_item.no_transaksi ='$Kode'";
      $myQry = mysql_query($mySQL, $koneksidb) or die("Query salah : " . mysql_error());
      ?>

      <?php
      if (isset($_POST['btnTebus'])) {

        echo "<script>";
        echo "window.open('cetak_ambil_obat.php?kodeRegis=$Kode', width=330,height=330,left=100, top=25)";
        echo "</script>";
      }
      ?>

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
                  <td><?php echo $myData['tanggal_registrasi']; ?></td>
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

            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">
              <table id="example" class="table display responsive nowrap">
                <thead>
                  <tr>
                    <th width="1%">No.</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Aturan Minum</th>
                    <th>Harga Satuan</th>
                  </tr>
                </thead>

                <tbody>
                  <?php $no = 1;
                  $totalTagihan  = 0; ?>
                  <?php while ($myData = mysql_fetch_array($myQry)) {

                    $KodeObat       = $myData['kode_obat'];
                    $subTotal    = $myData['hasil_hna_ppn'] * $myData['qty'];
                    $totalTagihan  = $totalTagihan + $subTotal;


                  ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td>
                        <?= $myData['nama_obat']; ?>
                      </td>
                      <td><?= $myData['qty']; ?></td>
                      <td><?= $myData['aturan_minum']; ?></td>
                      <td>Rp. <?= format_angka($subTotal); ?></td>
                    </tr>
                  <?php } ?>
                  <tr>

                    <td></td>
                    <td></td>
                    <td></td>
                    <th>
                      <strong>Total Tagihan</strong>
                    </th>
                    <td>
                      <font color="#FF0004"><strong>Rp. <?php echo format_angka($totalTagihan); ?></strong></font>
                    </td>
                  </tr>
                </tbody>
              </table>
              <input type="submit" name="btnTebus" value=" Cetak Data " class="btn btn-info" onclick="return confirm('Yakin Mau Cetak ?')" />
            </form>

          </div><!-- card-body -->
        </div><!-- card -->
      </div><!-- col -->

    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->

</div><!-- br-mainpanel -->
