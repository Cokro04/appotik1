<?php
unset($_SESSION['SES_LOGIN_APOTIK']);
unset($_SESSION['SES_LOGIN_NO_APOTIK']);

			echo "<script>";
			echo "swal({
				  type: 'success',
				  title: 'Logout Berhasil',
				    timer: 5000,
  					showConfirmButton: false,
				  html: true
                })";
			echo "</script>";
		
			echo '<script type="text/javascript">setTimeout(function(){window.top.location="index.php"} , 1500);</script>';
			//echo "<meta http-equiv='refresh' content='0; url=?open'>";
exit;
?>