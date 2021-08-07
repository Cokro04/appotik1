<?php 
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include "qrcode/qrlib.php";

$tempdir = "temp/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
if (!file_exists($tempdir))#kalau folder belum ada, maka buat.
    mkdir($tempdir);

$noPasien	= $_GET['noPasien']; 
$mySql 		= "SELECT * FROM pasien WHERE no_pasien = '$noPasien'";
$myQry 		= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData		= mysql_fetch_array($myQry);

?>

<table width="100%">
  <tbody>
    <tr>
      <td width="1%" rowspan="5">
		
<?php

//lanjutan yang tadi
 
#parameter inputan
$isi_teks = $myData['no_pasien'];
$namafile = "coba.png";
$quality  = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran   = 5; //batasan 1 paling kecil, 10 paling besar
$padding  = 0;
 
QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
 
echo '<img src="'.$tempdir.'coba.png" />';  
 
?>
		
		
	  </td>
      <td width="2%">&nbsp;</td>
      <td width="97%"><strong><?php echo $myData['no_pasien'] ?></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo strtoupper($myData['nama_pasien']) ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo $myData['jenis_kelamin'] ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo IndonesiaTgl($myData['tanggal_lahir']) ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
