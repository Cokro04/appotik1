<?php include "inc.session.php"; ?>

<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">

<div class="br-mainpanel">

  <div class="br-pagetitle">
    <i class="fa fa-database fa-4x"></i>
    <div>
      <h4>Data Obat Hampir Kadaluarsa</h4>
      <p class="mg-b-0">Berikut adalah data obat di apotik.</p>
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

      <div class="table-wrapper">
        <table id="example" class="table display responsive nowrap">
          <thead>
            <tr>
              <th width="1%">No.</th>
              <th>Kode Obat</th>
              <th>Nama Obat</th>
              <th>Bentuk Sediaan</th>
              <th>Stok</th>
              <th>Min. Stok</th>
              <th>Satuan</th>
              <th><a data-toggle="tooltip-primary" data-placement="top" title="Harga Obat Rawat Jalan">RJ</a></th>
              <th><a data-toggle="tooltip-primary" data-placement="top" title="Harga Obat Rawat Inap">RI</a></th>
              <th align="center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Skrip menampilkan data dari database
            $mySql   = "SELECT obat_copy.*, bentuk_sediaan.*, satuan_obat.* FROM obat_copy
			                  LEFT JOIN bentuk_sediaan ON bentuk_sediaan.kode_sediaan = obat_copy.kode_sediaan
			                  LEFT JOIN satuan_obat ON satuan_obat.kode_satuan = obat_copy.kode_satuan
                        WHERE (datediff(`tanggal_kadaluarsa`,current_date()) <= 100) AND (datediff(`tanggal_kadaluarsa`,current_date()) >= 0)
			                  ORDER BY obat_copy.nama_obat";
            $myQry   = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
            $nomor   = 0;
            while ($myData = mysql_fetch_array($myQry)) {
              $nomor++;
              $Kode    = $myData['kode_obat'];
              $hnaPpn  = $myData['hasil_hna_ppn'];
              $ppnRj   = ($hnaPpn * ($myData['ppn_rj'] / 100)) + $hnaPpn;
              $ppnRi   = ($hnaPpn * ($myData['ppn_ri'] / 100)) + $hnaPpn;
            ?>
              <tr>
                <td align="center"><?php echo $nomor; ?></th>
                <td><?php echo $myData['kode_obat']; ?></td>
                <td><a data-toggle="tooltip-primary" data-placement="top" title="<?php echo strtoupper($myData['nama_obat']); ?>"><?php echo strtoupper(substr($myData['nama_obat'], 0, 20)); ?></a></td>
                <td><a data-toggle="tooltip-primary" data-placement="top" title="<?php echo strtoupper($myData['nama_sediaan']); ?>"><?php echo strtoupper(substr($myData['nama_sediaan'], 0, 20)); ?></a></td>
                <td>
                  <?php if (($myData['stok'] <= $myData['stok_minimal']) && ($myData['stok'] > 0)) { ?>
                    <font color="#ffd800"><?php echo $myData['stok']; ?></font>
                  <?php } elseif (($myData['stok'] <= $myData['stok_minimal']) && ($myData['stok'] >= 0)) { ?>
                    <font color="#FF0004"><?php echo $myData['stok']; ?></font>
                  <?php } else { ?>
                    <?php echo $myData['stok']; ?>
                  <?php } ?>
                </td>
                <td><?php echo $myData['stok_minimal']; ?></td>
                <td><?php echo $myData['nama_satuan']; ?></td>
                <td><a data-toggle="tooltip-primary" data-placement="top" title="ppn <?php echo $myData['ppn_rj']; ?> %"><?php echo format_angka($ppnRj); ?></a></td>
                <td><a data-toggle="tooltip-primary" data-placement="top" title="ppn <?php echo $myData['ppn_ri']; ?> %"><?php echo format_angka($ppnRi); ?></a></td>
                <td align="center"><a href="?open=Obat-Edit&amp;Kode=<?php echo $Kode; ?>" class="badge badge-info"><i class="fa fa-edit"></i> Edit</a> <a href="#" data-toggle="modal" data-target="#modaldemo3<?= $myData['kode_obat']; ?>" class="badge badge-success"><i class="fa fa-file"></i> Detail</a>
                  <a href="?open=Obat-Delete&amp;Kode=<?php echo $Kode; ?>" class="badge badge-danger" onclick="return confirm('Yakin akan di hapus ?')"><i class="fa fa-minus-circle"></i> Hapus</a>
                </td>

                <!-- Awal Modal -->
                <div id="modaldemo3<?= $myData['kode_obat']; ?>" class="modal fade">

                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                      <div class="modal-content bd-0 tx-14">
                        <div class="modal-header pd-y-20 pd-x-25">
                          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Info Obat</h6>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body pd-25">
                          <div class="pd-30 bd">
                            <dl class="row">
                              <dt class="col-sm-6 tx-inverse" align="right">Kode Obat</dt>
                              <dd class="col-sm-6"><?= $myData['kode_obat']; ?></dd>
                              <dt class="col-sm-6 tx-inverse" align="right">Nama Obat</dt>
                              <dd class="col-sm-6"><?= $myData['nama_obat']; ?></dd>
                              <dt class="col-sm-6 tx-inverse" align="right">Tanggal Kadaluarsa</dt>
                              <dd class="col-sm-6"><?= IndonesiaTgl($myData['tanggal_kadaluarsa']); ?></dd>
                              <dt class="col-sm-6 tx-inverse" align="right">Harga Obat Rp.</dt>
                              <dd class="col-sm-6"><?= format_angka($hnaPpn); ?></dd>
                              <dt class="col-sm-6 tx-inverse" align="right">Stok Obat</dt>
                              <dd class="col-sm-6"><?= $myData['stok']; ?></dd>
                              <dt class="col-sm-6 tx-inverse" align="right">Etiket Obat</dt>
                              <dd class="col-sm-6"><?= $myData['etiket']; ?></dd>
                              <dt class="col-sm-6 tx-inverse" align="right">Bentuk Sediaan</dt>
                              <dd class="col-sm-6"><?= $myData['nama_sediaan']; ?></dd>
                              <dt class="col-sm-6 tx-inverse" align="right">Satuan Obat</dt>
                              <dd class="col-sm-6"><?= $myData['nama_satuan']; ?></dd>
                          </dl>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- Akhir Modal -->
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>



    </div>
  </div>

</div>

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
