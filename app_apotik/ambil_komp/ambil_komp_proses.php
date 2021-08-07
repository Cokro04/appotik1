<?php

include "inc.session.php";
$Kode	= $_GET['Kode'];

?>



<div class="br-mainpanel">

      <div class="br-pagetitle">
       <i class="fa fa-gift fa-4x"></i>
        <div>
          <h4>Proses pengambilan obat pasien komplementer</h4>
          <p class="mg-b-0">Berikut adalah data obat pasien komplementer.</p>
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

	$mySql2 	 = "SELECT * FROM kecamatan WHERE kode_kecamatan = '$myData[kode_kecamatan]'";
	$myQry2 	 = mysql_query($mySql2, $koneksidb)  or die ("Query kecamatan salah : ".mysql_error());
	$myData2  	 = mysql_fetch_array($myQry2);

	$mySql3 	 = "SELECT * FROM kelurahan WHERE kode_kelurahan = '$myData[kode_kelurahan]'";
	$myQry3 	 = mysql_query($mySql3, $koneksidb)  or die ("Query kelurahan salah : ".mysql_error());
	$myData3  	 = mysql_fetch_array($myQry3);
?>




<?php
if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$cmbAmbil		= $_POST['cmbAmbil'];

	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();

	if ($cmbAmbil == "") {
		$pesanError[] = "";
	 echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">Pilihan pengambilan obat belum di pilih </p>
                  </div>
                </div>
           </div></div>';
	}


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
		// Jika tidak menemukan error, simpan data ke database   id_notif 	kode_pesan_notif 	no_pasien 	kode_poli 	tanggal_notif 	tanggal_follow_up 	cek_pembayaran 	ambil_obat 	keadaan_baik 	keadaan_buruk 	no_pegawai 	status_notif

		$dateNow	= date('Y-m-d');
		$noPegawai	= $_SESSION['SES_LOGIN_NO_APOTIK'];


		//+9 day
		$date 		 = date_create($dateNow);
		date_add($date, date_interval_create_from_date_string('2 days'));
		$sembilan    =  date_format($date, 'Y-m-d');

		//+11 day
		$date2 		 = date_create($dateNow);
		date_add($date2, date_interval_create_from_date_string('11 days'));
		$sebelas     =  date_format($date2, 'Y-m-d');

		//+12 day
		$date3 		 = date_create($dateNow);
		date_add($date3, date_interval_create_from_date_string('12 days'));
		$duabelas    =  date_format($date3, 'Y-m-d');

		//+13 day
		$date4 		 = date_create($dateNow);
		date_add($date4, date_interval_create_from_date_string('13 days'));
		$tigabelas   =  date_format($date4, 'Y-m-d');

		//+15 day
		$date5 		 = date_create($dateNow);
		date_add($date5, date_interval_create_from_date_string('15 days'));
		$limabelas   =  date_format($date5, 'Y-m-d');

		//+22 day
		$date6 		 = date_create($dateNow);
		date_add($date6, date_interval_create_from_date_string('22 days'));
		$duadua   	 =  date_format($date6, 'Y-m-d');

		//+24 day
		$date7 		 = date_create($dateNow);
		date_add($date7, date_interval_create_from_date_string('24 days'));
		$duaempat    =  date_format($date7, 'Y-m-d');

		//+25 day
		$date8 		 = date_create($dateNow);
		date_add($date8, date_interval_create_from_date_string('25 days'));
		$dualima     =  date_format($date8, 'Y-m-d');

		//+26 day
		$date9 		 = date_create($dateNow);
		date_add($date9, date_interval_create_from_date_string('26 days'));
		$duaenam     =  date_format($date9, 'Y-m-d');

		//+3 day - ekspedisi
		$date10 		 = date_create($dateNow);
		date_add($date10, date_interval_create_from_date_string('3 days'));
		$tiga       	 =  date_format($date10, 'Y-m-d');

		//+14 day - ekspedisi
		$date11 		 = date_create($dateNow);
		date_add($date11, date_interval_create_from_date_string('14 days'));
		$empatbelas    	 =  date_format($date11, 'Y-m-d');

		//+18 day - ekspedisi
		$date12 		 = date_create($dateNow);
		date_add($date12, date_interval_create_from_date_string('18 days'));
		$delapanbelas  	 =  date_format($date12, 'Y-m-d');

		//+29 day - ekspedisi
		$date13 		 = date_create($dateNow);
		date_add($date13, date_interval_create_from_date_string('29 days'));
		$duasembilan   	 =  date_format($date13, 'Y-m-d');


		$tmpSql2  ="SELECT antrian.*, pasien.*, order_obat_komp.* FROM order_obat_komp
			    	LEFT JOIN antrian ON antrian.no_registrasi = order_obat_komp.no_registrasi
				    LEFT JOIN pasien ON pasien.no_pasien = antrian.no_pasien
			        WHERE order_obat_komp.no_registrasi = '$Kode'";
		$tmpQry2  = mysql_query($tmpSql2, $koneksidb) or die ("Gagal Query baca data order obat : ".mysql_error()); // `status_kirim`,`status_sampai`,`status_obat_siap` '','',''
		$tmpData2 = mysql_fetch_array($tmpQry2);

		$jWaktu	  = $tmpData2['jangka_waktu'];


		if ($cmbAmbil == "Ambil langsung" AND $jWaktu == "14"){

			$mySql  	= "UPDATE order_obat_komp SET status_ambil = '1' WHERE no_registrasi = '$Kode'";
			$myQry		=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());

			$mySql2  	= "INSERT INTO `notifikasi_pengingat`(`kode_pesan_notif`, `no_pasien`, `kode_poli`, `tanggal_notif`, `tanggal_follow_up`, `cek_pembayaran`, `ambil_obat`, `status_kirim`,`status_sampai`,`status_obat_siap`,`keadaan_baik`, `keadaan_buruk`, `no_pegawai`, `status_notif`) VALUES

			('1','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$sembilan','','0','0','','','','','','','0'),
			('2','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$sebelas','','0','0','','','','','','','0'),
			('3','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$duabelas','','0','0','','','','','','','0'),
			('6','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$tigabelas','','0','0','','','','','','','0')


			";
			$myQry2		=mysql_query($mySql2, $koneksidb) or die ("Gagal query simpan ambil langsung 14 : ".mysql_error());


		} else if ($cmbAmbil == "Ambil langsung" AND $jWaktu == "28"){

			$mySql  	= "UPDATE order_obat_komp SET status_ambil = '1' WHERE no_registrasi = '$Kode'";
			$myQry		=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());

			$mySql2  	= "INSERT INTO `notifikasi_pengingat`(`kode_pesan_notif`, `no_pasien`, `kode_poli`, `tanggal_notif`, `tanggal_follow_up`, `cek_pembayaran`, `ambil_obat`, `status_kirim`,`status_sampai`,`status_obat_siap`,`keadaan_baik`, `keadaan_buruk`, `no_pegawai`, `status_notif`) VALUES

			('1','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$limabelas','','0','0','','','','','','','0'),
			('1','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$duadua','','0','0','','','','','','','0'),
			('2','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$duaempat','','0','0','','','','','','','0'),
			('3','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$dualima','','0','0','','','','','','','0'),
			('6','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$duaenam','','0','0','','','','','','','0')


			";
			$myQry2		=mysql_query($mySql2, $koneksidb) or die ("Gagal query simpan ambil langsung 28 : ".mysql_error());


		} else if ($cmbAmbil == "Ekspedisi" AND $jWaktu == "14") {

			$mySql  	= "UPDATE order_obat_komp SET status_ambil = '2' WHERE no_registrasi = '$Kode'";
			$myQry		=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());

			$mySql2  	= "INSERT INTO `notifikasi_pengingat`(`kode_pesan_notif`, `no_pasien`, `kode_poli`, `tanggal_notif`, `tanggal_follow_up`, `cek_pembayaran`, `ambil_obat`, `status_kirim`,`status_sampai`,`status_obat_siap`,`keadaan_baik`, `keadaan_buruk`, `no_pegawai`, `status_notif`) VALUES

			('4','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$dateNow','','0','0','','','','','','','0'),
			('5','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$tiga','','0','0','','','','','','','0'),
			('1','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$sembilan','','0','0','','','','','','','0'),
			('2','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$sebelas','','0','0','','','','','','','0'),
			('3','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$duabelas','','0','0','','','','','','','0'),
			('6','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$empatbelas','','0','0','','','','','','','0')


			";
			$myQry2		=mysql_query($mySql2, $koneksidb) or die ("Gagal query simpan ekspedisi 14 : ".mysql_error());

		} else if ($cmbAmbil == "Ekspedisi" AND $jWaktu == "28") {

			$mySql  	= "UPDATE order_obat_komp SET status_ambil = '2' WHERE no_registrasi = '$Kode'";
			$myQry		=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());

			$mySql2  	= "INSERT INTO `notifikasi_pengingat`(`kode_pesan_notif`, `no_pasien`, `kode_poli`, `tanggal_notif`, `tanggal_follow_up`, `cek_pembayaran`, `ambil_obat`, `status_kirim`,`status_sampai`,`status_obat_siap`,`keadaan_baik`, `keadaan_buruk`, `no_pegawai`, `status_notif`) VALUES

			('4','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$dateNow','','0','0','','','','','','','0'),
			('5','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$tiga','','0','0','','','','','','','0'),
			('1','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$duabelas','','0','0','','','','','','','0'),
			('1','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$delapanbelas','','0','0','','','','','','','0'),
			('2','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$dualima','','0','0','','','','','','','0'),
			('3','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$duaenam','','0','0','','','','','','','0'),
			('6','$tmpData2[no_pasien]','$tmpData2[kode_poli]','$duasembilan','','0','0','','','','','','','0')


			";
			$myQry2		=mysql_query($mySql2, $koneksidb) or die ("Gagal query simpan ekspedisi 28 : ".mysql_error());

		}





		if($myQry){

		$_SESSION['pesan'] = 'Pengambilan obat komplemeter berhasil. Terima kasih';

		echo "<meta http-equiv='refresh' content='0; url=?open=Ambil-Obat-K'>";

		}
		exit;
	}
} // Penutup POST


?>
	<div class="row">

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


	            <div class="col-md-8 mg-t-20">
              <div class="card bd-0">
                <div class="card-header tx-medium bd-0 tx-white bg-teal">
                  Alamat Pengiriman Obat
                </div><!-- card-header -->
                <div class="card-body bd bd-t-0 rounded-bottom">
 <table width="100%" border="0">
  <tbody>
    <tr>
      <td width="24%">Alamat Lengkap</td>
      <td width="1%">:</td>
      <td width="75%"><?php echo strtoupper($myData['alamat_pasien']) ?> , <?php echo $myData['kode_pos'] ?></td>
    </tr>
    <tr>
      <td><span class="mg-b-0">Kecamatan / Kelurahan</span></td>
      <td>:</td>
      <td><?php echo strtoupper($myData2['nama_kecamatan']) ?> , <?php echo strtoupper($myData3['nama_kelurahan']) ?></td>
    </tr>
	<tr>
      <td><span class="mg-b-0">No. Telp</span></td>
      <td>:</td>
      <td><?php echo $myData['no_hp_pasien'] ?> - <?php echo $myData['no_telp_pasien'] ?></td>
    </tr>
	<tr>
      <td></td>
      <td></td>
      <td align="right"><span class="mg-b-0"><a href="#" target="_blank">Cetak Alamat Pengiriman Obat</a></span></td>
    </tr>

  </tbody>
</table>
                </div><!-- card-body -->
              </div><!-- card -->
            </div><!-- col -->




            </div>


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
			<div class="form-layout form-layout-1">
            <div class="row mg-b-25">

			 <div class="col-md-6">
                <div class="form-group mg-md-l--1">
                  <label class="form-control-label">Cara Pengambilan Obat : <span class="tx-danger">*</span></label>
                  <select name="cmbAmbil" id="cmbAmbil" class="form-control" >
                    <option value="">....</option>
                    <?php
		   $pilihan = array("Ambil langsung","Ekspedisi");

		  foreach ($pilihan as $indek) {
            if ($dataAmbil==$indek) {
                $cek="selected";
            } else { $cek = ""; }
            echo "<option value='$indek' $cek>$indek</option>";
          }
          ?>
                  </select>
                </div>
              </div>

			<div class="col-md-12">
			 <a href="?open=Ambil-Obat-K" class="btn btn-secondary">< Kembali</a>
             <button class="btn btn-success" name="btnSimpan" onclick="return confirm('Anda yakin obat akan di ambil ?')">Proses</button>
		    </div>


				</div>
				</div>




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
