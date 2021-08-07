<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include "qrcode/qrlib.php";

$tempdir = "temp/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
if (!file_exists($tempdir)) #kalau folder belum ada, maka buat.
  mkdir($tempdir);

$kodeTr    = $_GET['nTran'];

$mySql     = "SELECT beli_obat.*, beli_obat_item.*, supplier_data.* FROM beli_obat
              LEFT JOIN beli_obat_item ON beli_obat.no_transaksi = beli_obat_item.no_transaksi
              LEFT JOIN supplier_data ON beli_obat.kode_supplier = supplier_data.id
              WHERE beli_obat.no_transaksi = '$kodeTr'";
$myQry     = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());

$mySql1     = "SELECT  beli_obat_item.*, obat_copy.* FROM beli_obat_item
              LEFT JOIN obat_copy ON obat_copy.kode_obat = beli_obat_item.kode_obat
              WHERE beli_obat_item.no_transaksi = '$kodeTr'";

$MyQry     = mysql_query($mySql1, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
$myData    = mysql_fetch_array($myQry);


$tanggal = new DateTime($myData['tanggal_lahir']);

// tanggal hari ini
$today = new DateTime('today');

// tahun
$y = $today->diff($tanggal)->y;

// bulan
$m = $today->diff($tanggal)->m;

// hari
$d = $today->diff($tanggal)->d;

$date2 = date_create($myData['waktu_registrasi']);



// sesuai kan root file mPDF anda
$nama_dokumen = 'Resi Obat' . ' - ' . $myData['no_pasien'] . ' - ' . $myData['nama_pasien']; //Beri nama file PDF hasil.
define('_MPDF_PATH', 'MPDF53/'); //sesuaikan dengan root folder anda
include(_MPDF_PATH . "mpdf.php"); //includekan ke file mpdf
$mpdf = new mPDF('utf-8', 'A4'); // Create new mPDF Document
//Beginning Buffer to save PHP variables and HTML tags
ob_start();
//Tuliskan file HTML di bawah sini , sesuai File anda .



?>

<body style="font-family: Serif; font-size: 9pt;">
  <table width="100%">
    <tr>
      <td width="20%" rowspan="3" align="left"><img src="img/logo.png" width="150"/></td>
      <td width="80%" align="center"><strong><font size="+3">KLINIK UTAMA CMI & LABORATORIUM</font></strong></td>
    </tr>
    <tr>
      <td align="center">Jl. Tubagus Ismail VII No.21, Sekeloa, Coblong, Kota Bandung, Jawa Barat 40134</td>
    </tr>
    <tr>
      <td height="20" align="center"><font size="-1">Telp : (022) 2531000, Website : www.cmihospital.com, Email: info@cmihospital.com</font></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><hr></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><center>
        <strong>DATA PENERIMAAN OBAT DARI SUPPLIER</strong>
      </center></td>
    </tr>
  </table>

  <table width="100%">
    <tr>
      <td width="20%">&nbsp;</td>
      <td width="80%">&nbsp;</td>
    </tr>
    <tr>
      <td>No Transaksi</td>
      <td><strong><?php echo strtoupper($myData['no_transaksi']) ?></strong></td>
    </tr>
    <tr>
      <td>Nama Supplier</td>
      <td><strong><?php echo strtoupper($myData['nama_supplier']) ?></strong></td>
    </tr>
    <tr>
      <td>Tanggal Order</td>
      <td><?php echo $myData['tanggal_transaksi'] ?></td>
    </tr>


    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><strong>DETAIL DATA OBAT SEPERTI BERIKUT</strong></td>
    </tr>
  </table>

  <table>
    <thead>
      <tr>
        <th width="4%">No.</th>
        <th width="5%">Nama Obat</th>
        <th width="3%">Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; ?>
      <?php while ($myData = mysql_fetch_array($MyQry)) { ?>
        <tr>
          <td align="center"><?= $no++; ?></td>
          <td align="center"><?= $myData['nama_obat']; ?></td>
          <td align="center"><?= $myData['qty']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<br>
  <table width="100%" border="0">
    <tbody>
      <tr>
        <td width="70%">&nbsp;</td>
        <td width="0%"></td>
        <td width="20%"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">BANDUNG, <?php echo date('d-m-Y')?></td>
      </tr>
  	<tr>
  	  <td>&nbsp;</td>
      <td align="center">SUPPLIER</td>
  	  <td align="center">APOTEKER</td>
      </tr>
  	<tr>
  	  <td>&nbsp;</td>
  	  <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
  	<tr>
  	    <td>&nbsp;</td>
        <td align="center"><font size="-1">(_____________________)</font></td>
        <td align="center"><font size="-1">(_____________________)</font></td>
    </tr>
    </tbody>
  </table>
</body>


<?php
//Batas file sampe sini
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML($stylesheet, 1);
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($nama_dokumen . ".pdf", 'I');
exit;
?>
