<?php 
include "inc.session.php"; 


# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang  WHERE notifikasi_pengingat.status_notif = '1' AND notifikasi_pengingat.kode_poli = 'A09'
$tglAwal 	= isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['cmbTglAkhir']) ? $_POST['cmbTglAkhir'] : date('d-m-Y');

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['cmbTglAkhir']) ? $_POST['cmbTglAkhir'] : date('d-m-Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "WHERE ( notifikasi_pengingat.tanggal_notif BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."' AND notifikasi_pengingat.status_notif = '1' AND notifikasi_pengingat.kode_poli = 'A09')";
}
else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "WHERE ( notifikasi_pengingat.tanggal_notif BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."' AND notifikasi_pengingat.status_notif = '1' AND notifikasi_pengingat.kode_poli = 'A09')";
}



?>

<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">


<div class="br-mainpanel">

      <div class="br-pagetitle">
       <i class="fa fa-arrow-circle-right fa-4x"></i>
        <div>
          <h4>Data History Follow Up Pasien Komplementer</h4>
          <p class="mg-b-0">Berikut adalah data history follow up pasien pada tanggal : <?php echo $tglAwal ?> s/d <?php echo $tglAkhir ?>.</p>
        </div>
      </div><!-- d-flex -->
			
			
      <div class="br-pagebody">
        <div class="br-section-wrapper">
			
			
			<?php 
    //        menampilkan pesan jika ada pesan
            if (isset($_POST['btnTampil'])) {

				
				echo '<div class="pesan">
              <div class="alert alert-success alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-history fa-4x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Set Periode history</h5>
                    <p class="mg-b-0 tx-xs op-8">Dari tanggal : '.$tglAwal.' s/d tanggal '.$tglAkhir.'</p>
                  </div>
                </div>
              </div></div>';
            }

    //        mengatur session pesan menjadi kosong
            $_SESSION['pesan'] = '';
            ?>
			
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table">
    <tr>
      <td colspan="6" bgcolor="#CCCCCC"><strong>Pilih periode history follow up</strong></td>
    </tr>
    <tr>
      <td width="138"><strong>Periode Awal</strong></td>
      <td width="5"><strong>:</strong></td>
      <td colspan="4"><input name="cmbTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Periode Akhir</strong></td>
      <td><strong>:</strong></td>
      <td colspan="4"><input name="cmbTglAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="318"><input name="btnTampil" type="submit" value=" Tampilkan " class="btn btn-info btn-fill pull-left"/></td>
      <td width="138">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="492">&nbsp;</td>
    </tr>
  </table>
</form>

			
			<div class="table-wrapper">
            <table id="example" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th width="1%">No.</th>
				  <th width="9%">Tanggal FU</th>
                  <th width="9%">No. Pasien</th>
                  <th width="15%">Nama Pasien</th>
                  <th width="15%">No. Telp</th>
                  <th width="15%">No. Telp Keluarga</th>
                  <th width="20%">Follow Up Pasien</th>
				  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
	<?php
	// Skrip menampilkan data dari database , 				WHERE DATE(waktu_registrasi) = '$dateNow'
	$dateNow = date("Y-m-d");
			  
	$mySql 	 = "SELECT notifikasi_pengingat.*, pesan_notif.*, pasien.* FROM notifikasi_pengingat 
				LEFT JOIN pasien ON pasien.no_pasien = notifikasi_pengingat.no_pasien
				LEFT JOIN pesan_notif ON pesan_notif.kode_pesan_notif = notifikasi_pengingat.kode_pesan_notif
				$filterSQL
				ORDER BY notifikasi_pengingat.tanggal_follow_up DESC";
	$myQry 	 = mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor   = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode	= $myData['id_notif'];
		
			//gender awesome	
			$kel	= $myData['jenis_kelamin'];
			
			if($kel == "L"){
				$hasilKel	= "<i class='fa fa-mars' aria-hidden='true'></i>";
			} else {
				$hasilKel	= "<i class='fa fa-venus' aria-hidden='true'></i>";
			}
		
			//link follow up
			$fol	= $myData['kode_pesan_notif'];
		
			if($fol == "1"){
				$hasilFol	= "?open=History-Keadaan";
			} else if($fol == "2") {
				$hasilFol	= "?open=History-AmbilObat";
			} else if($fol == "3") {
				$hasilFol	= "?open=History-CekBayar";
			} else if($fol == "4") {
				$hasilFol	= "?open=History-Ekspedisi";
			}
			
			//format tanggal fu
			$date2  = date_create($myData['tanggal_follow_up']);
		
	?>
                <tr>
                  <td></td>
				  <td><?php echo date_format($date2, 'd-m-Y H:i:s'); ?></td>
                  <td><?php echo $myData['no_pasien']; ?></td>
                  <td><?php echo $hasilKel ?> </php><?php echo strtoupper($myData['nama_pasien']); ?></td>
                  <td><?php echo $myData['no_hp_pasien']; ?> - <?php echo $myData['no_telp_pasien']; ?></td>
                  <td><?php echo $myData['no_hp_keluarga']; ?> - <?php echo $myData['no_telp_keluarga']; ?></td>
                  <td><?php echo $myData['isi_pesan_notif'] ?></td>
				  <td><a href="<?php echo $hasilFol ?>&amp;Kode=<?php echo $Kode; ?>" class="btn btn-info" onclick="return confirm('Yakin akan di melihat history follow up ?')">Detail</a></td>
                </tr>
    <?php } ?>       
              </tbody>
            </table>
          </div><!-- table-wrapper -->
			
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
      
    </div><!-- br-mainpanel -->


	<script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>

	

     <script>
     $(document).ready(function() {
     var t = $('#example').DataTable( {
		  aLengthMenu: [[25, 50, 75, 100], [25, 50, 75, "Semua"]],
          iDisplayLength: 25,
		 
		 "language": {
			searchPlaceholder: 'Pencarian...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
			info:           "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
			lengthMenu:     "Menampilkan _MENU_ data",
			zeroRecords:    "Tidak ada data yang cocok dengan pencarian anda",
		    infoEmpty:      "Menampilkan 0 sampai 0 dari 0 data",
    		infoFiltered:   "(Pencarian dari _MAX_ total data)",
        },
		 
		 scrollX:        true,
		 responsive: false,
        "columnDefs": [ {
            "searchable": false,
            "orderable": true,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]]
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
		 
	} );
    </script>


	<script>
//            angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
            $(document).ready(function(){setTimeout(function(){$(".pesan").fadeIn('slow');}, 700);});
//            angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
            setTimeout(function(){$(".pesan").fadeOut('slow');}, 8000);
        </script>
