<?php



if(empty($_SESSION['SES_LOGIN_NO_APOTIK'])) {

	
	  		echo "<script>";
			echo "swal({
				  type: 'error',
				  title: '',
                  text: '<b>Silahkan Login terlebih dahulu !</b>',
				    timer: 3000,
  					showConfirmButton: false,
				  html: true
                })";
			echo "</script>";
		
			echo '<script type="text/javascript">setTimeout(function(){window.top.location="index.php"} , 1500);</script>';
	  

	exit;
}
?>