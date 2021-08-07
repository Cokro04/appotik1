<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include "qrcode/qrlib.php";

$tempdir = "temp/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
if (!file_exists($tempdir)) #kalau folder belum ada, maka buat.
  mkdir($tempdir);

$noRegis  = $_GET['kodeRegis'];

$mySql     = "SELECT antrian.*, pasien.*, penjualan_obat_item.*, obat_copy.* FROM penjualan_obat_item
              LEFT JOIN antrian ON antrian.no_registrasi = penjualan_obat_item.no_transaksi
              LEFT JOIN pasien ON pasien.no_pasien = antrian.no_pasien
              LEFT JOIN obat_copy ON penjualan_obat_item.kode_obat = obat_copy.kode_obat
              WHERE penjualan_obat_item.no_transaksi = '$noRegis'";
$myQry     = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
$MyQry     = mysql_query($mySql, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
$myData    = mysql_fetch_array($myQry);


$sqlBayar  = "SELECT * FROM penjualan_obat WHERE no_transaksi = '$noRegis'";
$qryBayar  = mysql_query($sqlBayar, $koneksidb)  or die("Query ambil data salah : " . mysql_error());
$myBayar   = mysql_fetch_array($qryBayar);


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
        <strong>TANDA TERIMA OBAT</strong>
      </center></td>
    </tr>
  </table>
  <!-- <table width="100%">
    <tbody>
      <tr>
        <td align="center"><b>BUKTI AMBIL OBAT</b></td>
      </tr>
    </tbody>
  </table> -->



  <table width="100%">
    <tr>
      <td width="43%"><strong>IDENTITAS PASIEN</strong></td>
      <td width="0%">&nbsp;</td>
      <td width="57%">&nbsp;</td>
    </tr>
    <tr>
      <td><strong><?php echo strtoupper($myData['no_pasien']) ?></strong></td>
    </tr>
    <tr>
      <td><?php echo $myData['title_pasien'] ?> <strong><?php echo strtoupper($myData['nama_pasien']) ?></strong> / <?php echo strtoupper($myData['jenis_kelamin']) ?></td>
    </tr>
    <tr>
      <td><?php echo $myData['tempat_lahir'] ?>, <?php echo IndonesiaTgl($myData['tanggal_lahir']) ?> ( <strong><?php echo $y; ?></strong> th <?php echo $m; ?> bln <?php echo $d; ?> hr )</td>
    </tr>


    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><strong>DATA OBAT</strong></td>
    </tr>
  </table>
  <table>
    <thead>
      <tr>
        <th width="1%">No.</th>
        <th>Nama Obat</th>
        <th>Jumlah</th>
        <th>Aturan Minum</th>
        <th align="right">Total Harga</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1;
      $totalTagihan  = 0; ?>
      <?php while ($myData = mysql_fetch_array($MyQry)) {

        $KodeObat       = $myData['kode_obat'];
        $subTotal    = $myData['hasil_hna_ppn'] * $myData['qty'];
        $totalTagihan  = $totalTagihan + $subTotal;


      ?>
        <tr>
          <td align="center"><?= $no++; ?></td>
          <td align="center"><?= $myData['nama_obat']; ?></td>
          <td align="center"><?= $myData['qty']; ?></td>
          <td align="center"><?= $myData['aturan_minum']; ?></td>
          <td align="right">Rp. <?= format_angka($subTotal); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<hr>
  <table width="100%">
    <tbody>
      <tr>
        <td align="right";  width="75%"><b>Total Tagihan</b></td>
        <td align="right"><font color="#FF0004"><strong>Rp. <?php echo format_angka($totalTagihan); ?></strong></font></td>
      </tr>
    </tbody>
  </table>

  <table width="100%">
    <tbody>
      <tr>
        <td align="right";  width="75%"><b>Total Bayar</b></td>
        <td align="right"><font color="#FF0004"><strong>Rp. <?php echo format_angka($myBayar['uang_bayar']); ?></strong></font></td>
      </tr>
    </tbody>
  </table>
  <hr>

  <table width="100%">
    <tbody>
      <tr>
        <td align="right";  width="75%"><b>Kembalian</b></td>
        <td align="right"><font color="#FF0004"><strong>Rp. <?php echo format_angka($myBayar['uang_bayar']-$totalTagihan); ?></strong></font></td>
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
