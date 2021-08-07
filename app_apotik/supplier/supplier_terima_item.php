<?php include "inc.session.php";
$Kode  = $_GET['Kode'];
?>
<script>
  var Kode = $Kode;
</script>
<?php
$getData = "SELECT beli_obat.*, beli_obat_item.*, obat_copy.* FROM beli_obat_item
LEFT JOIN beli_obat ON beli_obat.no_transaksi = beli_obat_item.no_transaksi
LEFT JOIN obat_copy ON obat_copy.kode_obat = beli_obat_item.kode_obat
WHERE beli_obat.no_transaksi = '$Kode'";
$myQry = mysql_query($getData, $koneksidb) or die("Query salah : " . mysql_error());


$getSupplier = "SELECT beli_obat.*, supplier_data.* FROM beli_obat
LEFT JOIN supplier_data ON beli_obat.kode_supplier = supplier_data.id
WHERE beli_obat.no_transaksi = '$Kode'";
$mySupp = mysql_query($getSupplier, $koneksidb) or die("Query salah : " . mysql_error());

$cekStatus ="SELECT * FROM beli_obat WHERE status_terima = '1' AND no_transaksi = '$Kode'";
$myCek = mysql_query($cekStatus, $koneksidb) or die("Query salah : " . mysql_error());
$cekOK = mysql_num_rows($myCek);

if($cekOK > 0){

  echo "<script>";
  echo "window.open('cetak_terima_supplier.php?nTran=$Kode', width=330,height=330,left=100, top=25)";
  echo "</script>";

  echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Terima-Obat"} , 1500);</script>';
}

if(isset($_POST['kodeObat']) && isset( $_POST['noTransaksi'])){

  foreach ($_POST['kodeObat'] as $key => $value) {
    $kObat = $_POST['kodeObat'][$key];
    $nTran = $_POST['noTransaksi'][$key];
    $qtyUpd  = $_POST['qty'][$key];


    $sqlEditQty = "UPDATE beli_obat_item SET qty = $qtyUpd WHERE no_transaksi = '$nTran' AND kode_obat = '$kObat'";
    $dbEdit = mysql_query($sqlEditQty, $koneksidb) or die("Gagal query" . mysql_error());

    if ($dbEdit) {

      $a = $_SERVER['PHP_SELF'];
      $b = '?open=Terima-Obat-Item&Kode=';
      $c = $a . $b . $Kode;

      echo "<script>";
      echo "window.location.replace('$c')";
      echo "</script>";
    }
  }
}

if(isset($_POST['terimaObat'])){

  $status = $_POST['statusTerima'];
  $sqlEditStatus = "UPDATE beli_obat SET status_terima = $status WHERE no_transaksi = '$Kode'";
  $dbEdit1 = mysql_query($sqlEditStatus, $koneksidb) or die("Gagal query" . mysql_error());

  foreach ($_POST['noTransaksi_fix'] as $key => $value) {
    $id_obat     = $_POST['kodeObat_fix'][$key];
    $qty_obat    = $_POST['qty_fix'][$key];

    $sqlStokObt = "UPDATE obat_copy SET stok = stok+$qty_obat WHERE kode_obat = '$id_obat'";
    $dbStokObat = mysql_query($sqlStokObt, $koneksidb) or die("Gagal query" . mysql_error());
  }



}
?>

<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="css/component-chosen.css" rel="stylesheet">

<div class="br-mainpanel">

  <div class="br-pagetitle">
    <i class="fa fa-inbox fa-4x"></i>
    <div>
      <h4>Data Terima Obat</h4>
      <p class="mg-b-0">Berikut adalah data penerimaan obat</p>
    </div>
  </div><!-- d-flex -->

  <div class="br-pagebody">
    <div class="br-section-wrapper">

<!-- Data info pasien -->
<?php $mySupplier = mysql_fetch_array($mySupp) ?>
      <div class="col-md-12 mg-t-20">
        <div class="card bd-0">
          <div class="card-header tx-medium bd-0 tx-white bg-teal">
            Data Terima Obat
          </div><!-- card-header -->

          <div class="card-body bd bd-t-0 rounded-bottom">
            <table width="100%" border="0">
              <tbody>
                <tr>
                  <td>No. Transaksi</td>
                  <td>:</td>
                  <td><?= $mySupplier['no_transaksi'] ?></td>
                </tr>
                <tr>
                  <td>Tanggal Transaksi</td>
                  <td>:</td>
                  <td><?= $mySupplier['tanggal_transaksi'] ?></td>
                </tr>
                <tr>
                  <td width="33%">Nama Supplier</td>
                  <td width="1%">:</td>
                  <td width="66%"><?= $mySupplier['nama_supplier'] ?></td>
                </tr>
              </tbody>
            </table>
            <br>


      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">

        <table id="example" class="table display responsive nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Obat</th>
              <th>Banyak Obat</th>
            </tr>
          </thead>

          <tbody>
            <?php $i = 1;?>
            <?php while ($myData = mysql_fetch_array($myQry)) { ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= $myData['nama_obat']?></td>
                <td>
                  <input type="hidden" value="<?= $myData['no_transaksi']; ?>" style="width:50%;" name="noTransaksi[]" onchange="this.form.submit()">
                  <input type="hidden" value="<?= $myData['kode_obat']; ?>" style="width:50%;" name="kodeObat[]" onchange="this.form.submit()">
                  <input type="text" value="<?= $myData['qty']; ?>"  style="width:30%;" onkeypress="return angkadanhuruf(event,'1234567890',this);this.form.submit()" name="qty[]" onchange="this.form.submit()"  ></td>
                  <td>
                  <input type="hidden" value="<?= $myData['no_transaksi']; ?>" style="width:50%;" name="noTransaksi_fix[]">
                  <input type="hidden" value="<?= $myData['kode_obat']; ?>" style="width:50%;" name="kodeObat_fix[]">
                  <input type="hidden" value="<?= $myData['qty']; ?>"  style="width:30%;" name="qty_fix[]">
                  <input type="hidden" value="1" name="statusTerima">
</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>


          <input type="submit" name="terimaObat" value=" Terima Obat " class="btn btn-success" onclick="return confirm('Yakin Sudah Sesuai ?')" />

      </form>


          </div>
        </div><!-- card -->
      </div><!-- col -->

    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->

</div><!-- br-mainpanel -->
