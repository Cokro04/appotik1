<?php

include_once "library/inc.connection.php";
include_once "library/inc.library.php";

$noPeg  = $_SESSION['SES_LOGIN_NO_APOTIK'];
$today       = date('Y-m-d');

$mySql2 = "SELECT * FROM pegawai WHERE no_pegawai = '$noPeg'";
$myQry2 = mysql_query($mySql2, $koneksidb) or die("Query Login Salah : " . mysql_error());
$myData2 = mysql_fetch_array($myQry2);

$namaPeg  = ucwords(substr(strtolower($myData2['nama_pegawai']), 0, 20));

$mySql = "SELECT *  FROM antrian WHERE kode_poli = 'A01' AND ambil_obat = '1'";
$myQry = mysql_query($mySql, $koneksidb) or die("Query Salah : " . mysql_error());
$notif = mysql_num_rows($myQry);


$sqlTerimaObat = "SELECT status_terima FROM beli_obat WHERE status_terima = '0'";
$qryTerimaObat = mysql_query($sqlTerimaObat, $koneksidb) or die("Query salah : " . mysql_error());
$notifTerObat  = mysql_num_rows($qryTerimaObat);

// untuk data obat kadaluarsa
$SqlKadaluarsa    = "SELECT * FROM obat_copy WHERE tanggal_kadaluarsa < '$today'";
$accQry10         = mysql_query($SqlKadaluarsa, $koneksidb) or die("error: " . mysql_error());
$Kadaluarsa       = mysql_num_rows($accQry10);

// untuk data obat hampir kaladuarsa
$SqlHampirK       = "SELECT * FROM `obat_copy` WHERE (datediff(`tanggal_kadaluarsa`,current_date()) <= 100) AND (datediff(`tanggal_kadaluarsa`,current_date()) >= 0)";
$accQry11         = mysql_query($SqlHampirK, $koneksidb) or die("error: " . mysql_error());
$hampir           = mysql_num_rows($accQry11);


$SqlStokHabis     = "SELECT * FROM obat_copy WHERE (stok <= stok_minimal) AND (stok > 0)";
$accQry12         = mysql_query($SqlStokHabis, $koneksidb) or die("error: " . mysql_error());
$StokHabis        = mysql_num_rows($accQry12);

$SqlHabis         = "SELECT * FROM obat_copy WHERE (stok <= 0) AND (stok >= 0)";
$accQry13         = mysql_query($SqlHabis, $koneksidb) or die("error: " . mysql_error());
$Habis            = mysql_num_rows($accQry13);

?>

<ul class="br-sideleft-menu">

  <li class="br-menu-item">
    <a class="br-menu-link">
      <i class="fa fa-user"></i>
      <span class="menu-item-label">Hai, <?php echo $namaPeg ?> ... </span>
    </a><!-- br-menu-link -->
  </li><!-- br-menu-item -->
  <br>


  <li class="br-menu-item">
    <a href="?open=Home" class="br-menu-link

		<?php
    if ($_GET['open'] == "Home") {
    ?>
        active
        <?php
      }
        ?>">
      <i class="fa fa-home"></i>
      <span class="menu-item-label">Dashboard </span>
    </a><!-- br-menu-link -->
  </li><!-- br-menu-item -->




  <li class="br-menu-item">
    <a href="#" class="br-menu-link with-sub <?php
                                              if ($_GET['open'] == "Order-Obat-P" or $_GET['open'] == "Order-Obat-K" or $_GET['open'] == "Ambil-Obat-K" or $_GET['open'] == "Order-Obat-Data") {
                                              ?>
        active
        <?php
                                              }
        ?>	">
      <i class="fa fa-sort"></i>
      <span class="menu-item-label">Order Obat</span>
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub">
      <li class="sub-item"><a href="?open=Order-Obat-Data" class="sub-link <?php
                                                                            if ($_GET['open'] == "Order-Obat-Data") {
                                                                            ?>
        active
        <?php
                                                                            }
        ?>">Poliklinik <span class="badge badge-danger"><?= $notif; ?></span></a></li>
      <li class="sub-item"><a href="?open=Order-Obat-K" class="sub-link <?php
                                                                        if ($_GET['open'] == "Order-Obat-K") {
                                                                        ?>
        active
        <?php
                                                                        }
        ?>">Proses Komplementer</a></li>
      <li class="sub-item"><a href="?open=Ambil-Obat-K" class="sub-link <?php
                                                                        if ($_GET['open'] == "Ambil-Obat-K") {
                                                                        ?>
        active
        <?php
                                                                        }
        ?>">Ambil Komplementer</a></li>

    </ul>
  </li>


  <li class="br-menu-item">
    <a href="#" class="br-menu-link with-sub <?php
                                              if ($_GET['open'] == "Data-Obat" or $_GET['open'] == "Data_Obat_Hampir_Habis" or $_GET['open'] == "Data-Obat-Habis" or $_GET['open'] == "Data_Obat_Hampir_Kadaluarsa" or $_GET['open'] == "Data_Obat_Kadaluarsa") {
                                              ?>
        active
        <?php
                                              }
        ?>	">
      <i class="fa fa-archive"></i>
      <span class="menu-item-label">Data Obat</span>
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub">
      <li class="sub-item"><a href="?open=Data-Obat" class="sub-link <?php
                                                                      if ($_GET['open'] == "Data-Obat") {
                                                                      ?>
        active
        <?php
                                                                      }
        ?>">List Data Obat</a></li>

        <li class="sub-item"><a href="?open=Data_Obat_Hampir_Habis" class="sub-link <?php
                                                                        if ($_GET['open'] == "Data_Obat_Hampir_Habis") {
                                                                        ?>
          active
          <?php
                                                                        }
          ?>">Obat Hampir Habis <span class="badge badge-danger"><?= $StokHabis; ?></span></a></li>

          <li class="sub-item"><a href="?open=Data-Obat-Habis" class="sub-link <?php
                                                                          if ($_GET['open'] == "Data-Obat-Habis") {
                                                                          ?>
            active
            <?php
                                                                          }
            ?>">Obat Telah Habis <span class="badge badge-danger"><?= $Habis; ?></span></a></li>

          <li class="sub-item"><a href="?open=Data_Obat_Hampir_Kadaluarsa" class="sub-link <?php
                                                                          if ($_GET['open'] == "Data_Obat_Hampir_Kadaluarsa") {
                                                                          ?>
            active
            <?php
                                                                          }
            ?>">Obat Hampir Kadaluarsa <span class="badge badge-danger"><?= $hampir; ?></span></a></li>

          <li class="sub-item"><a href="?open=Data_Obat_Kadaluarsa" class="sub-link <?php
                                                                          if ($_GET['open'] == "Data_Obat_Kadaluarsa") {
                                                                          ?>
            active
            <?php
                                                                          }
            ?>">Obat Telah Kadaluarsa <span class="badge badge-danger"><?= $Kadaluarsa; ?></span></a></li>
    </ul>
  </li>


  <li class="br-menu-item">
    <a href="#" class="br-menu-link with-sub <?php
                                              if ($_GET['open'] == "Supplier-Data" or $_GET['open'] == "Pemesanan-Obat" or $_GET['open'] == "Terima-Obat") {
                                              ?>
        active
        <?php
                                              }
        ?>	">
      <i class="fa fa-truck"></i>
      <span class="menu-item-label">Supplier</span>
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub">
      <li class="sub-item"><a href="?open=Supplier-Data" class="sub-link <?php
                                                                      if ($_GET['open'] == "Supplier-Data") {
                                                                      ?>
        active
        <?php
                                                                      }
        ?>">Data Supplier</a></li>

      <li class="sub-item"><a href="?open=Pemesanan-Obat " class="sub-link <?php
                                                                    if ($_GET['open'] == "Pemesanan-Obat") {
                                                                    ?>
      active
      <?php
                                                                    }
      ?>">Pesan Obat</a></li>

      <li class="sub-item"><a href="?open=Terima-Obat" class="sub-link <?php
                                                                    if ($_GET['open'] == "Terima-Obat") {
                                                                    ?>
      active
      <?php
                                                                    }
      ?>">Terima Obat <span class="badge badge-danger"><?= $notifTerObat; ?></span></a></li>
    </ul>
  </li>




  <br>

  <li class="br-menu-item">
    <a href="?open=History-Data" class="br-menu-link

		<?php
    if ($_GET['open'] == "History-Data") {
    ?>
        active
        <?php
      }
        ?>">
      <i class="fa fa-history"></i>
      <span class="menu-item-label">History Order Obat </span>
    </a><!-- br-menu-link -->
  </li><!-- br-menu-item -->

  <br>

  <li class="br-menu-item">
    <a href="?open=Logout" class="br-menu-link">
      <i class="fa fa-sign-out"></i>
      <span class="menu-item-label">Logout</span>
    </a><!-- br-menu-link -->
  </li><!-- br-menu-item -->
</ul><!-- br-sideleft-menu -->


<script src="lib/jquery/jquery.min.js"></script>
