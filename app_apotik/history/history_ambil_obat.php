<?php include "inc.session.php"; ?>




<div class="br-mainpanel">

      <div class="br-pagetitle">
        <i class="fa fa-history fa-4x"></i>
        <div>
          <h4>Histori Follow up kepastian pengambilan obat pasien komplementer selanjutnya</h4>
          <p class="mg-b-0">Isi sesuai kolom yang di sediakan.</p>
        </div>
      </div><!-- d-flex -->
	

			
			
      <div class="br-pagebody">
        <div class="br-section-wrapper">
			
 		<h6 class="br-section-label">Data Follow up</h6>
			
			
			
<?php
			
$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
$mySql 	= "SELECT notifikasi_pengingat.*, pesan_notif.*, pasien.* FROM notifikasi_pengingat 
		   LEFT JOIN pasien ON pasien.no_pasien = notifikasi_pengingat.no_pasien
		   LEFT JOIN pesan_notif ON pesan_notif.kode_pesan_notif = notifikasi_pengingat.kode_pesan_notif
		   WHERE notifikasi_pengingat.id_notif = '$Kode'";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData	= mysql_fetch_array($myQry);

	$dataKode			= $myData['id_notif'];
	$dataNoPasien		= isset($_POST['txtNoPasien']) ? $_POST['txtNoPasien'] : $myData['no_pasien'];
	$dataNamaPasien		= isset($_POST['txtNamaPasien']) ? $_POST['txtNamaPasien'] : $myData['nama_pasien'];
	$dataHpPasien		= isset($_POST['txtHpPasien']) ? $_POST['txtHpPasien'] : $myData['no_hp_pasien'];
	$dataTelpPasien		= isset($_POST['txtTelpPasien']) ? $_POST['txtTelpPasien'] : $myData['no_telp_pasien'];
	$dataHp2Pasien		= isset($_POST['txtHp2Pasien']) ? $_POST['txtHp2Pasien'] : $myData['no_hp_keluarga'];
	$dataTelp2Pasien	= isset($_POST['txtTelp2Pasien']) ? $_POST['txtTelp2Pasien'] : $myData['no_telp_keluarga'];


			//gender awesome	
			$kel	= $myData['jenis_kelamin'];
			
			if($kel == "L"){
				$hasilKel	= "<i class='fa fa-mars' aria-hidden='true'></i>";
			} else {
				$hasilKel	= "<i class='fa fa-venus' aria-hidden='true'></i>";
			}
			
			
			//ambil obat	
			$amo	= $myData['ambil_obat'];
			
			if($amo == "1"){
				$hasilAmo	= "Ya";
			} else {
				$hasilAmo	= "Tidak";
			}
			
			
			

			$tanggal = new DateTime($myData['tanggal_lahir']);

		// tanggal hari ini
			$today = new DateTime('today');

		// tahun
			$y = $today->diff($tanggal)->y;

		// bulan
			$m = $today->diff($tanggal)->m;

		// hari
			$d = $today->diff($tanggal)->d;
			
			
		//format tanggal fu
			$date2  = date_create($myData['tanggal_follow_up']);

?>   			
			
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">			
			
			

          <div class="form-layout form-layout-2">
            <div class="row no-gutters">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">No. Pasien : </label>
					<input class="form-control" type="text" name="txtNoPasien" value="<?php echo $dataNoPasien ?>" readonly>
					<input class="form-control" type="text" name="txtKode" value="<?php echo $dataKode ?>" hidden>
                </div>
              </div><!-- col-4 -->

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Nama Pasien : </label>
                  <?php echo $hasilKel ?> - <?php echo $y; ?> tahun <?php echo $m; ?> bulan <?php echo $d; ?> hari<input class="form-control" type="text" name="txtNama" value="<?php echo strtoupper($dataNamaPasien) ?>" readonly>
                </div>
              </div><!-- col-4 -->
				
		      <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">No. HP Pasien : </label>
					<input class="form-control" type="text" name="txtHpPasien" value="<?php echo $dataHpPasien ?>" readonly>
                </div>
              </div><!-- col-4 -->

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">No. Telp Pasien : </label>
                  <input class="form-control" type="text" name="txtTelpPasien" value="<?php echo $dataTelpPasien ?>" readonly>
                </div>
              </div><!-- col-4 -->
				
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">No. HP Keluarga Pasien : </label>
					<input class="form-control" type="text" name="txtHp2Pasien" value="<?php echo $dataHp2Pasien ?> , <?php echo strtoupper($myData['nama_keluarga']) ?> - <?php echo strtoupper($myData['hub_keluarga']) ?> PASIEN" readonly>
                </div>
              </div><!-- col-4 -->

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">No. Telp Keluarga Pasien : </label>
                  <input class="form-control" type="text" name="txtTelp2Pasien" value="<?php echo $dataTelp2Pasien ?> , <?php echo strtoupper($myData['nama_keluarga']) ?> - <?php echo strtoupper($myData['hub_keluarga']) ?> PASIEN" readonly>
                </div>
              </div><!-- col-4 -->
				
			  <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label">Pastikan Pasien akan mengambil obat selanjut nya : </label>
				 <select name="cmbObat" class="form-control" disabled>
                    <option value="">....</option>
                    <?php
		   $pilihan = array("Ya","Tidak");
		   
		  foreach ($pilihan as $indek) {
            if ($hasilAmo==$indek) {
                $cek="selected";
            } else { $cek = ""; }
            echo "<option value='$indek' $cek>$indek</option>";
          }
          ?>
                  </select>
                </div>
              </div><!-- col-4 -->
				
				
						
			  <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label">Tanggal Follow Up : </label>
                  <input class="form-control" type="text" name="txtTglFU" value="<?php echo date_format($date2, 'd-m-Y H:i:s'); ?>" readonly>
                </div>
              </div><!-- col-4 -->


            </div><!-- row -->
			  
		    <div class="form-layout-footer bd pd-20 bd-t-0">
			  <a href="?open=History-Data" class="btn btn-secondary">< Kembali</a>
            </div>

          </div><!-- form-layout -->
	
</form>

			
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
      
    </div><!-- br-mainpanel -->
	