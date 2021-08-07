
<?php
error_reporting(0);
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

// Baca Jam pada Komputer
date_default_timezone_set("Asia/Jakarta");	
?>












<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from themepixels.me/bracketplus/1.4/app/template/signin-simple.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 30 Dec 2018 17:02:36 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Apotik</title>

    <!-- vendor css -->
    <link href="lib/%40fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="css/bracket.css">
	
	<!-- FontAwesome CSS -->

	<link rel="stylesheet" type="text/css" href="library/font-awesome-4.3.0/css/font-awesome.min.css" />
	
  </head>

  <body>
	  
	  


    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">
		
		

      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
        <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal">[</span> Klinik <span class="tx-info">Utama CMI</span> <span class="tx-normal">]</span></div>
        <div class="tx-center mg-b-60">Apotik</div>
		<?php

# MEMBACA TOMBOL KOGIN DARI FILE login.php
if(isset($_POST['btnLogin'])){
	//echo ".";
	# Baca variabel form
	$txtUser 		= $_POST['txtUser'];
	$txtUser 		= str_replace("'","&acute;",$txtUser);
	
	$txtPassword	= $_POST['txtPassword'];
	$txtPassword	= str_replace("'","&acute;",$txtPassword);
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if ( trim($txtUser)=="") {
		$pesanError[] = "Data <b> Username </b>  tidak boleh kosong !";	
		
		    echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">Username belum di isi </p>
                  </div>
                </div>
              </div></div>';
		
		//echo '<script type="text/javascript">setTimeout(function(){window.top.location="index.php"} , 2000);</script>';
		
		
	} else if (trim($txtPassword)=="") {
		    $pesanError[] = "Data <b> Password </b>  tidak boleh kosong !";	
		
		    echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">Password belum di isi </p>
                  </div>
                </div>
              </div></div>';
		
		//echo '<script type="text/javascript">setTimeout(function(){window.top.location="index.php"} , 2000);</script>';
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;	
			} 
		echo "</div> <br>"; 
		
	}
	else {
		# LOGIN CEK KE TABEL USER LOGIN OPERASIONAL
		$mySql = "SELECT * FROM user_admin WHERE username='$txtUser' AND password='".md5($txtPassword)."'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Query Login Salah : ".mysql_error());
		$myData= mysql_fetch_array($myQry);
		
		# JIKA LOGIN SUKSES
		if(mysql_num_rows($myQry) >=1) {
			// Menyimpan Kode yang Login
			$_SESSION['SES_LOGIN_APOTIK'] 			= $myData['kode_user']; 
			$_SESSION['SES_LOGIN_NO_APOTIK'] 		= $myData['no_pegawai']; 
			
			$mySql2 = "SELECT * FROM pegawai WHERE no_pegawai = '$myData[no_pegawai]'";
			$myQry2 = mysql_query($mySql2, $koneksidb) or die ("Query Login Salah : ".mysql_error());
			$myData2= mysql_fetch_array($myQry2);
			
			$namaDokter	= ucwords(strtolower($myData2['nama_pegawai']));
			

			  echo '<div class="pesan">
              <div class="alert alert-success alert-solid pd-20" role="alert">
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-user fa-4x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Selamat datang,</h5>
                    <p class="mg-b-0 tx-xs op-8">'.$namaDokter.'</p>
                  </div>
                </div>
              </div></div>';

		
			
			echo '<script type="text/javascript">setTimeout(function(){window.top.location="utama.php?open=Home"} , 1500);</script>';
			
		
		// Log Login
	$dateNow	= date('Y-m-d H:i:s');			
	$hostname   = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    $mySql  	= "INSERT INTO log_login (kode_user , username, ip_login, pc_login, browser_login, system_app, waktu_login)
            VALUES ('$myData[kode_user]', '$txtUser','". get_client_ip()."','$hostname','".get_client_browser()."','app_apotik','$dateNow')";
    $myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			
			
			
			
		} else  {
			  echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">User tidak di kenal </p>
                  </div>
                </div>
              </div></div>';
			}
		}
	
  }
// End POST
?>	

		  
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Masukan username" name="txtUser">
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Masukan password" name="txtPassword">
        </div><!-- form-group -->
        <button type="submit" class="btn btn-info btn-block" name="btnLogin">Login</button>
		</form>
		
		  
		<br>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->

    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
	

</body>

</html>



		<script>
//            angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
            $(document).ready(function(){setTimeout(function(){$(".pesan").fadeIn('slow');}, 700);});
//            angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
            setTimeout(function(){$(".pesan").fadeOut('slow');}, 3000);
        </script>

