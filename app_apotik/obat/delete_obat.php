<?php

// Membaca data dari URL
$Kode  = $_GET['Kode'];
if (isset($Kode)) {
  // Skrip menghapus data dari tabel database
  $mySql = "DELETE FROM obat_copy WHERE kode_obat = '$Kode'";
  $myQry = mysql_query($mySql, $koneksidb) or die("Error query" . mysql_error());

  // Refresh
  $_SESSION['pesan'] = 'Data obat berhasil di hapus';

  echo "<meta http-equiv='refresh' content='0; url=?open=Data-Obat'>";
} else {
  echo "Data yang dihapus tidak ada";
}
