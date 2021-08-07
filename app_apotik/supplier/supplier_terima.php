<?php include "inc.session.php"; ?>

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
      $mySql = "SELECT * FROM beli_obat ORDER BY no_transaksi";
      $myQry = mysql_query($mySql, $koneksidb) or die("Query salah : " . mysql_error());
        $myQrya = mysql_query($mySql, $koneksidb) or die("Query salah : " . mysql_error());
      ?>

      <table id="example" class="table display responsive nowrap">
        <thead>
          <tr>
            <th width="1%">No.</th>
            <th>No Transaksi</th>
            <th>Tanggal Transaksi</th>
            <th>Status</th>
          </tr>
        </thead>

        <tbody>
          <?php $no = 1;?>
          <?php while ($myData = mysql_fetch_array($myQry)) { ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $myData['no_transaksi']; ?></td>
              <td><?= $myData['tanggal_transaksi']; ?></td>
              <td>
                <?php $par = $myData['status_terima'];
                if ($par == 0) { ?>
                  <a href="?open=Terima-Obat-Item&amp;Kode=<?php echo $myData['no_transaksi']; ?>" class="btn btn-danger"> Belum Diterima</a>
                <?php } else { ?>
                  <a href="#" class="btn btn-success" onclick="return confirm('Obat Telah Diterima ?')"> Sudah Diterima</a>
                <?php } ?>
                  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modaldemo3<?= $myData['no_transaksi']?>"><i class="fa fa-eye"></i> Detail </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>


  <?php $i = 1;?>
<?php while ($myData = mysql_fetch_array($myQrya)) { ?>
      <div id="modaldemo3<?= $myData['no_transaksi']?>" class="modal fade">

        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail Data Supplier</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body pd-20">
            <div class="pd-30 bd">

<?php
$kd = $myData['no_transaksi'];
$mySqltbl = "SELECT beli_obat.*, beli_obat_item.*, obat_copy.* FROM beli_obat_item
          LEFT JOIN beli_obat ON beli_obat.no_transaksi = beli_obat_item.no_transaksi
          LEFT JOIN obat_copy ON obat_copy.kode_obat = beli_obat_item.kode_obat
          WHERE beli_obat.no_transaksi='$kd'";
$myQrytbl = mysql_query($mySqltbl, $koneksidb) or die("Query salah : " . mysql_error());
?>

              <table id="example" class="table display responsive nowrap">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Banyak Obat</th>
                  </tr>
                </thead>
                <?php while ($myData = mysql_fetch_array($myQrytbl)) { ?>
                <tbody>
                    <tr>
                      <td><?= $i++ ?></td>
                      <td><?= $myData['nama_obat']?></td>
                      <td><?= $myData['qty']?></td>
                    </tr>
                </tbody>
              <?php } ?>
              </table>
            </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary tx-size-xs" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div><!-- modal-dialog -->
      </div><!-- modal -->
<?php } ?>


    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->

</div><!-- br-mainpanel -->

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

<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
<script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>



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

      scrollX: true,
      responsive: false,
      "columnDefs": [{
        "searchable": false,
        "orderable": true,
        "targets": 0
      }],
      "order": [
        [1, 'desc']
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
