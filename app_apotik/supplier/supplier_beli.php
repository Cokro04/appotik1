<?php include "inc.session.php"; ?>

<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="css/component-chosen.css" rel="stylesheet">

<?php
$getTempObat = "SELECT obat_copy.*, beli_obat_temp.* FROM obat_copy
                RIGHT JOIN beli_obat_temp ON beli_obat_temp.kode_obat = obat_copy.kode_obat
                ORDER BY beli_obat_temp.kode_obat";
$qryTempOabt = mysql_query($getTempObat, $koneksidb) or die("Query salah : " . mysql_error());


$bacaSql2    = "SELECT no_transaksi from beli_obat";
$bacaQry2    = mysql_query($bacaSql2, $koneksidb) or die("Gagal Query" . mysql_error());
$bacaData2   = mysql_fetch_array($bacaQry2);

$jumlah_data  = mysql_num_rows($bacaQry2);
if ($bacaData2) {
  $nilaikode = substr($jumlah_data[0], 1);
  $kode = (int) $nilaikode;
  $kode = $jumlah_data + 1;
  $koOb = "ORD-";
  $dataKode = str_pad($kode, 6, "0", STR_PAD_LEFT);

  $kod = $koOb . $dataKode;
} else {
  $kod = "ORD-000001";
}

if(isset($_POST['btnAddObat'])){

  $kode_obat    = $_POST['nama_obat_temp'];
  $qty          = $_POST['qty_obat_temp'];

  if(trim($kode_obat) == ''){
    echo "<script>";
    echo "swal({
            type: 'error',
            title: 'Data Obat Kosong',
                    text: '',
              timer: 3000,
              showConfirmButton: false,
            html: true
                  })";
    echo "</script>";
    echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Pemesanan-Obat"} , 1500);</script>';
  }elseif (trim($qty) == '') {
    echo "<script>";
    echo "swal({
            type: 'error',
            title: 'Data Qty Kosong',
                    text: '',
              timer: 3000,
              showConfirmButton: false,
            html: true
                  })";
    echo "</script>";
    echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Pemesanan-Obat"} , 1500);</script>';
  }else {
    $myCek    = "SELECT * FROM beli_obat_temp WHERE kode_obat ='$kode_obat'";
    $pageQry	= mysql_query($myCek, $koneksidb) or die ("error paging: ".mysql_error());
    $cekAda 	= mysql_num_rows($pageQry);

    if($cekAda > 0){
      $sqlAddObat = "UPDATE beli_obat_temp SET qty = qty+$qty WHERE kode_obat = '$kode_obat'";
      $dbAdd = mysql_query($sqlAddObat, $koneksidb) or die("Gagal query" . mysql_error());

      if ($dbAdd) {
          echo "<script>";
          echo "swal({
                  type: 'success',
                  title: 'Data Obat Diperbaharui',
                          text: '',
                    timer: 3000,
                    showConfirmButton: false,
                  html: true
                        })";
          echo "</script>";
          echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Pemesanan-Obat"} , 1500);</script>';
      }

    } else {
      $sqlApprov = "INSERT INTO beli_obat_temp(kode_obat, qty) VALUES ('$kode_obat','$qty')";
      $dbApprov = mysql_query($sqlApprov, $koneksidb) or die("Gagal query" . mysql_error());

      if ($dbApprov) {
          echo "<script>";
          echo "swal({
                  type: 'success',
                  title: 'Input Obat Berhasil',
                          text: '',
                    timer: 3000,
                    showConfirmButton: false,
                  html: true
                        })";
          echo "</script>";
          echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Pemesanan-Obat"} , 1500);</script>';
      }
    }
  }
}

if(isset($_POST['PesanObat'])){


  $transaksi     = $_POST['no_transaksi_obat'];
  $tanggal       = date('Y-m-d H:i:s');
  $supplier      = $_POST['kode_supplier_obat'];

  if (trim($supplier) == '') {
    echo "<script>";
    echo "swal({
            type: 'error',
            title: 'Data Supplier Belum Dipilih',
                    text: '',
              timer: 3000,
              showConfirmButton: false,
            html: true
                  })";
    echo "</script>";
    echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Pemesanan-Obat"} , 1500);</script>';

  } else {

    $sqlBeliObat = "INSERT INTO beli_obat(no_transaksi, tanggal_transaksi, kode_supplier) VALUES ('$transaksi','$tanggal','$supplier')";
    $dbAddObat = mysql_query($sqlBeliObat, $koneksidb) or die("Gagal query" . mysql_error());

    foreach ($_POST['id'] as $key => $value) {
      $id          = $_POST['id'][$key];
      $noTransaksi = $_POST['noTransaksi'][$key];
      $kodeObat    = $_POST['kodeObat'][$key];
      $qtyObat     = $_POST['qtyObat'][$key];


      $sqlInsertObat = "INSERT INTO beli_obat_item(no_transaksi, kode_obat, qty) VALUES ('$noTransaksi','$kodeObat','$qtyObat')";
      $dbAdd = mysql_query($sqlInsertObat, $koneksidb) or die("Gagal query" . mysql_error());

      $deleteTemp    = "DELETE FROM beli_obat_temp WHERE no_transaksi='$id'";
      $dbdelete      = mysql_query($deleteTemp, $koneksidb) or die("Gagal query" . mysql_error());
      if ($dbAdd) {

        echo "<script>";
        echo "swal({
                type: 'success',
                title: 'Pesan Obat Berhasil',
                        text: '',
                  timer: 3000,
                  showConfirmButton: false,
                html: true
                      })";
        echo "</script>";
        echo "<script>";
        echo "window.open('cetak_order_supplier.php?nTran=$noTransaksi', width=330,height=330,left=100, top=25)";
        echo "</script>";
        echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Pemesanan-Obat"} , 1500);</script>';
      }
    }
  }
}


$TempCek ="SELECT * FROM beli_obat_temp";
$myCekD = mysql_query($TempCek, $koneksidb) or die("Query salah : " . mysql_error());
$cekTemp = mysql_num_rows($myCekD);


?>

<div class="br-mainpanel">

  <div class="br-pagetitle">
    <i class="fa fa-database fa-4x"></i>
    <div>
      <h4>Data Supplier Obat</h4>
      <p class="mg-b-0">Berikut Merupakan Data dari Supplier Obat</p>
    </div>
  </div><!-- d-flex -->

  <div class="br-pagebody">
    <div class="br-section-wrapper">

      <?php
      //        menampilkan pesan jika ada pesan
      if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {


        echo '<div class="pesan">
              <div class="alert alert-success alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-thumbs-up fa-4x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Berhasil !</h5>
                    <p class="mg-b-0 tx-xs op-8">' . $_SESSION['pesan'] . '</p>
                  </div>
                </div>
              </div></div>';
      }

      //        mengatur session pesan menjadi kosong
      $_SESSION['pesan'] = '';
      ?>

      <br>
      <br>
      <br>



      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">
        <h6 class="br-section-label">DATA PESANAN OBAT</h6>

        <div class="form-layout form-layout-2">
          <div class="row no-gutters">
            <div class="col-md-5">
              <div class="form-group">
                <label class="form-control-label">No Pembelian : </label>
                <input class="form-control" type="text" name="no_transaksi_obat" value="<?php echo $kod ?>">
              </div>
            </div><!-- col-4 -->

            <div class="col-md-7">
              <div class="form-group">
                <label class="form-control-label">Supplier : <span class="tx-danger">*</span></label>
                <select data-placeholder="Pilih Bentuk Sediaan" class="chosen-select" tabindex="7" style="width: 100%" name="kode_supplier_obat">
                  <option value="">....</option>
                  <?php
                  $bacaSql = "SELECT * FROM supplier_data ORDER BY nama_supplier";
                  $bacaQry = mysql_query($bacaSql, $koneksidb) or die("Gagal Query" . mysql_error());
                  while ($bacaData = mysql_fetch_array($bacaQry)) {
                    // Status terpilih
                    if ($dataSediaan == $bacaData['id']) {
                      $pilih = " selected";
                    } else {
                      $pilih = "";
                    }

                    $kapitalNama  = strtoupper($bacaData[nama_supplier]);

                    echo "<option value='$bacaData[id]' $pilih> $kapitalNama </option>";
                  }
                  ?>
                </select>
              </div>
            </div><!-- col-4 -->

            <div class="col-md-5 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Nama Obat : <span class="tx-danger">*</span></label>
                <select data-placeholder="Pilih Bentuk Sediaan" class="chosen-select" tabindex="7" style="width: 100%" name="nama_obat_temp">
                  <option value="">....</option>
                  <?php
                  $obatSql = "SELECT * FROM obat_copy ORDER BY nama_obat";
                  $obatQry = mysql_query($obatSql, $koneksidb) or die("Gagal Query" . mysql_error());
                  while ($obatData = mysql_fetch_array($obatQry)) {
                    // Status terpilih
                    if ($dataSediaan == $obatData['kode_obat']) {
                      $pilih = " selected";
                    } else {
                      $pilih = "";
                    }

                    $obatNama  = strtoupper($obatData[nama_obat]);

                    echo "<option value='$obatData[kode_obat]' $pilih> $obatNama </option>";
                  }
                  ?>
                </select>
              </div>
            </div><!-- col-4 -->

            <div class="col-md-5 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Qty Obat : <span class="tx-danger">*</span></label>
                <input class="form-control" type="number" name="qty_obat_temp" placeholder="Qty Obat">
              </div>
            </div><!-- col-4 -->

            <div class="col-md-2 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <input type="submit" name="btnAddObat" value=" Input Obat " class="btn btn-info" onclick="return confirm('Yakin Sudah Sesuai ?')" />
              </div>
            </div><!-- col-4 -->
          </div><!-- row -->
        </div><!-- form-layout -->


  <h6 class="br-section-label">DATA PESANAN OBAT</h6>
      <div class="table-wrapper">
        <table class="table display responsive nowrap">
          <thead>
            <tr>
              <th width="1%">No.</th>
              <th>Obat</th>
              <th>Qty</th>
              <th align="center">Aksi</th>
            </tr>
          </thead>
            <?php
            $i = '1';
             while ($dataSupplier = mysql_fetch_array($qryTempOabt)) {
            ?>
          <tbody>
              <tr>
                <td><?= $i++?><input type="hidden" name="id[]" value="<?= $dataSupplier['no_transaksi']?>"><input type="hidden" name="noTransaksi[]" value="<?= $kod?>"></td>
                <td><?= $dataSupplier['nama_obat'] ?><input type="hidden" name="kodeObat[]" value="<?= $dataSupplier['kode_obat']?>"></td>
                <td><?= $dataSupplier['qty']?><input type="hidden" name="qtyObat[]" value="<?= $dataSupplier['qty'] ?>"></td>
                <td>
                <a href="?open=Supplier-Delete&amp;Id=<?= $dataSupplier['no_transaksi']; ?>" class="btn btn-danger tx-11 tx-uppercase pd-y-5 pd-x-5 tx-mont tx-medium" onclick="return confirm('Yakin akan di hapus ?')"><i class="fa fa-minus-circle"></i> Delete </a>
                </td>
              </tr>
          </tbody>





        <?php } ?>
        </table>
        <?php if($cekTemp > 0){?>
            <input type="submit" name="PesanObat" value=" Pesan Obat " class="btn btn-info" onclick="return confirm('Yakin Sudah Sesuai ?')" />
        <?php } ?>
  </form>
      </div>
    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->

</div><!-- br-mainpanel -->

<script src="lib/jquery-ui/ui/widgets/datepicker.js"></script>
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
<script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
<script src="js/tooltip-colored.js"></script>
<script src="js/popover-colored.js"></script>


<script>
  $(document).ready(function() {
    var t = $('#example').DataTable({
      aLengthMenu: [
        [25, 50, 75, 100],
        [25, 50, 75, "Semua"]
      ],
      iDisplayLength: 25,

      "language": {
        searchPlaceholder: 'Pencarian...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        lengthMenu: "Menampilkan _MENU_ data",
        zeroRecords: "Tidak ada data yang cocok dengan pencarian anda",
        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
        infoFiltered: "(Pencarian dari _MAX_ total data)",
      },

      "orderFixed": [2, 'asc'],
      scrollX: true,
      responsive: true,
      "columnDefs": [{
        "searchable": false,
        "orderable": true,
        "targets": 0
      }],
      "order": [
        [1, 'asc']
      ]
    });

    t.on('order.dt search.dt', function() {
      t.column(0, {
        search: 'applied',
        order: 'applied'
      }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

  });
</script>



<script>
  //            angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
  $(document).ready(function() {
    setTimeout(function() {
      $(".pesan").fadeIn('slow');
    }, 700);
  });
  //            angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
  setTimeout(function() {
    $(".pesan").fadeOut('slow');
  }, 4000);
</script>
