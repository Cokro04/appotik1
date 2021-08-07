<?php

include "inc.session.php";
$Kode	= $_GET['Kode'];

?>



<div class="br-mainpanel">

      <div class="br-pagetitle">
       <i class="fa fa-money fa-4x"></i>
        <div>
          <h4>Proses Selesai Obat Racikan</h4>
          <p class="mg-b-0">Berikut adalah data racikan obat pasien komplementer.</p>
        </div>
      </div><!-- d-flex -->





      <div class="br-pagebody">
        <div class="br-section-wrapper">

<?php
	$mySql 	 = "SELECT antrian.*, pasien.*, order_obat_komp.* FROM order_obat_komp
			    LEFT JOIN antrian ON antrian.no_registrasi = order_obat_komp.no_registrasi
				LEFT JOIN pasien ON pasien.no_pasien = antrian.no_pasien
			    WHERE order_obat_komp.no_registrasi = '$Kode'";
	$myQry 	 = mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$myData  = mysql_fetch_array($myQry);

			$tanggal  = new DateTime($myData['tanggal_lahir']);
			$date2    = date_create($myData['tanggal_bayar_lunas']);

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
			$kel	= $myData['jenis_kelamin'];

			if($kel == "L"){
				$hasilKel	= "<i class='fa fa-mars' aria-hidden='true'></i>";
			} else {
				$hasilKel	= "<i class='fa fa-venus' aria-hidden='true'></i>";
			}
?>




<?php
if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel


	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();


	# MENAMPILKAN PESAN JIKA ADA ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){

			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) {
			$noPesan++;
				echo "$pesan_tampil";
			}
		echo "";
	}
	else {
		# SIMPAN DATA KE DATABASE.
		// Jika tidak menemukan error, simpan data ke database

		$dateNow	= date('Y-m-d H:i:s');
		$noPegawai	= $_SESSION['SES_LOGIN_NO_APOTIK'];



		$mySql  	= "UPDATE order_obat_komp SET status_racik = '2' WHERE no_registrasi = '$Kode'";
		$myQry		=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());

		if($myQry){

		$_SESSION['pesan'] = 'Status obat komplemeter sudah siap di berikan kepada pasien. Terima kasih';

		echo "<meta http-equiv='refresh' content='0; url=?open=Order-Obat-K'>";

		}
		exit;
	}
} // Penutup POST


?>


	            <div class="col-md-4 mg-t-20">
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
      <td>Tanggal Order</td>
      <td>:</td>
      <td><?php echo date_format($date2, 'd-m-Y H:i:s'); ?></td>
    </tr>
    <tr>
      <td width="33%">No. Pasien</td>
      <td width="1%">:</td>
      <td width="66%"><?php echo $myData['no_pasien'] ?></td>
    </tr>
    <tr>
      <td><span class="mg-b-0">Nama. Pasien</span></td>
      <td>:</td>
      <td><?php echo $hasilKel ?> / <?php echo strtoupper($myData['nama_pasien']) ?></td>
    </tr>
      <td>Usia</td>
      <td>:</td>
      <td><?php echo $y; ?> tahun <?php echo $m; ?> bulan <?php echo $d; ?> hari</td>
    </tr>
  </tbody>
</table>
                </div><!-- card-body -->
              </div><!-- card -->
            </div><!-- col -->


	<br>
	<br>






         <div class="bd bd-gray-300 rounded table-responsive">
            <table class="table table-hover mg-b-0">

	<thead>
    <tr>
      <td width="28"><strong>No</strong></td>
      <td width="79"><strong>Kode Obat</strong></td>
      <td width="268"><strong>Nama  Obat</strong></td>
      <td width="146"><strong>Jangka Waktu</strong></td>
      </tr>
	</thead>
<?php

$totalTagihan	= 0;

// Qury menampilkan data dalam Grid TMP_Penjualan
$tmpSql ="SELECT order_obat_komp_item.*, order_obat_komp.*, obat_herbal.* FROM order_obat_komp
         LEFT JOIN order_obat_komp_item ON order_obat_komp_item.no_order_obat_komp = order_obat_komp.no_order_obat_komp
         LEFT JOIN obat_herbal ON obat_herbal.kode_obat_herbal = order_obat_komp_item.kode_obat_herbal
WHERE order_obat_komp.no_registrasi = '$Kode'
ORDER BY obat_herbal.nama_obat_herbal";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$KodeObat       = $tmpData['kode_obat_herbal'];

?>
	<tbody>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kode_obat_herbal']; ?></b></td>
      <td><?php echo strtoupper($tmpData['nama_obat_herbal']); ?> (<?php echo strtoupper($tmpData['kualitas_obat']); ?>)</td>
      <td><?php echo $tmpData['jangka_waktu']; ?> hari</td>
      </tr>
	<?php } ?>
    </tbody>

    </table>
              </div>




			<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">

			<br>


			  <a href="?open=Order-Obat-K" class="btn btn-secondary">< Kembali</a>
              <button class="btn btn-success" name="btnSimpan" onclick="return confirm('Yakin peracikan obat telah selesai, dan siap di berikan kepada pasien ?')">Peracikan Obat Selesai</button>

							</form>




</div>



          </div><!-- table-wrapper -->

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

    </div><!-- br-mainpanel -->


	<script src="lib/jquery/jquery.min.js"></script>









		<script>
//            angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
            $(document).ready(function(){setTimeout(function(){$(".pesan").fadeIn('slow');}, 700);});
//            angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
            setTimeout(function(){$(".pesan").fadeOut('slow');}, 3000);
        </script>
