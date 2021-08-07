<?php
// Membaca data dari URL
$Kode  = $_GET['Kode'];
if (isset($Kode)) {
  // Skrip menghapus data dari tabel database
  $mySql = "DELETE FROM supplier_data WHERE id = '$Kode'";
  $myQry = mysql_query($mySql, $koneksidb) or die("Error query" . mysql_error());

  // Refresh
  $_SESSION['pesan'] = 'Data Supplier Berhasil dihapus';

  echo "<meta http-equiv='refresh' content='0; url=?open=Supplier-Data'>";
} else {
  echo "Data yang dihapus tidak ada";
}

$Id = $_GET['Id'];

if (isset($Id)){

  $mySqlO = "DELETE FROM beli_obat_temp WHERE no_transaksi = '$Id'";
  $myQryO = mysql_query($mySqlO, $koneksidb) or die("Error query" . mysql_error());

  // Refresh
  $_SESSION['pesan'] = 'Data Obat Berhasil dihapus';

  echo "<meta http-equiv='refresh' content='0; url=?open=Pemesanan-Obat'>";
} else {
  echo "Data yang dihapus tidak ada";
}
