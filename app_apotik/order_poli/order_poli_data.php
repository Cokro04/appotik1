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
      $mySql = "SELECT antrian.*, pasien.*, poliklinik.*FROM antrian
      LEFT JOIN pasien ON pasien.no_pasien = antrian.no_pasien
      LEFT JOIN poliklinik ON poliklinik.kode_poli = antrian.kode_poli
      ORDER BY antrian.no_registrasi";
      // $mySql = "SELECT * FROM antrian";
      $myQry = mysql_query($mySql, $koneksidb) or die("Query salah : " . mysql_error());
      // $myData = mysql_fetch_array($myQry);
      ?>

      <table id="example" class="table display responsive nowrap">
        <thead>
          <tr>
            <th width="1%">No.</th>
            <th>No Registrasi</th>
            <th>Nama</th>
            <th>Tanggal Registrasi</th>
            <th>Poli</th>
            <th>Keterangan</th>
          </tr>
        </thead>

        <tbody>
          <?php $no = 1;
          $totalTagihan  = 0; ?>
          <?php while ($myData = mysql_fetch_array($myQry)) { ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $myData['no_registrasi']; ?></td>
              <td><?= $myData['nama_pasien']; ?></td>
              <td><?= $myData['tanggal_registrasi']; ?></td>
              <td><?= $myData['nama_poli']; ?></td>
              <td>
                <?php $par = $myData['status_periksa'];
                $par1 = $myData['ambil_obat'];
                if ($par == 0) { ?>
                  <a href="#" class="btn btn-danger" onclick="return confirm('Maaf Resep Obat Belum Ada ?')"> Belum Ada Resep</a>
                <?php } elseif ($par1 == 1) { ?>
                  <a href="?open=Obat-Telah-Diambil&amp;Kode=<?php echo $myData['no_registrasi']; ?>" class="btn btn-info"> Obat Telah Diambil</a>
                <?php } else { ?>
                  <a href="?open=Order-Obat-Resep&amp;Kode=<?php echo $myData['no_registrasi']; ?>" class="btn btn-success"> Sudah Ada Resep</a>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
  </div>

</div>

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
