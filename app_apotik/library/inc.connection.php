<?php
$my['host']  = "localhost";
$my['user']  = "root";
$my['pass']  = "";
$my['dbs']  = "grsetra";

$koneksidb  = mysql_connect($my['host'], $my['user'], $my['pass']);
if (!$koneksidb) {
  echo "Failed Connection !";
}
// memilih database pda server
mysql_select_db($my['dbs'])
  or die("Database Klinik GR Setra belum siap");
