<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

if (isset($_SESSION["lastActivity"])) {
  if ($_SESSION['lastActivity'] + 15 * 60 < time()) {
    // last request was more than 30 minutes ago
    session_unset(); // unset $_SESSION variable for the run-time
    session_destroy(); // destroy session data in storage

    //redirect to your home page
    echo "<script type='text/javascript'>setTimeout(function(){window.top.location='?open=Logout'} , 3000);</script>";
  }
}

$_SESSION["lastActivity"] = time();



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Meta -->
  <meta name="description" content="SIMRS Klinik Utama CMI">
  <meta name="author" content="AndreDEV">

  <title>Apotik</title>

  <!-- vendor css -->
  <!-- FontAwesome CSS -->

  <link rel="stylesheet" type="text/css" href="library/font-awesome-4.3.0/css/font-awesome.min.css" />

  <!-- Ionicons CSS -->
  <link href="css/ionicons.min.css" rel="stylesheet">


  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/rickshaw/rickshaw.min.css" rel="stylesheet">
  <link href="lib/select2/css/select2.min.css" rel="stylesheet">

  <!-- Bracket CSS -->
  <link rel="stylesheet" href="css/bracket.css">

  <script src="alert/js/sweetalert.min.js"></script>
  <script src="alert/js/qunit-1.18.0.js"></script>
  <link rel="stylesheet" href="alert/css/sweetalert.css">

  <!-- Notifikasi -->
  <script type="text/javascript" src="jquery-1.4.3.min.js"></script>
  <script type="text/javascript" src="notifikasi.js"></script>

  <!-- Chosen Select -->
  <!-- <link rel="stylesheet" href="lib/chosen/docsupport/prism.css">
  <link rel="stylesheet" href="lib/chosen/chosen.css"> -->

  <!-- Tigra Calendar -->
  <link rel="stylesheet" type="text/css" href="plugins/tigra_calendar/tcal.css" />
  <script type="text/javascript" src="plugins/tigra_calendar/tcal.js"></script>

  <!-- data tabel -->

  <link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">


  <script language="javascript">
    function getkey(e) {
      if (window.event)
        return window.event.keyCode;
      else if (e)
        return e.which;
      else
        return null;
    }

    function angkadanhuruf(e, goods, field) {
      var angka, karakterangka;
      angka = getkey(e);
      if (angka == null) return true;

      karakterangka = String.fromCharCode(angka);
      karakterangka = karakterangka.toLowerCase();
      goods = goods.toLowerCase();

      // check goodkeys
      if (goods.indexOf(karakterangka) != -1)
        return true;
      // control angka
      if (angka == null || angka == 0 || angka == 8 || angka == 9 || angka == 27)
        return true;

      if (angka == 13) {
        var i;
        for (i = 0; i < field.form.elements.length; i++)
          if (field == field.form.elements[i])
            break;
        i = (i + 1) % field.form.elements.length;
        field.form.elements[i].focus();
        return false;
      };
      // else return false
      return false;
    }
  </script>



</head>

<body>

  <!-- ########## START: LEFT PANEL ########## -->
  <div class="br-logo"><a href="#">Klinik <i>Utama CMI</i></a> </div>
  <div class="br-sideleft sideleft-scrollbar">
    <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigasi</label>
    <?php include "menu.php"; ?>
    <br>
  </div><!-- br-sideleft -->
  <!-- ########## END: LEFT PANEL ########## -->

  <!-- ########## START: HEAD PANEL ########## -->
  <div class="br-header">
    <div class="br-header-left">



      <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="#"><i class="icon ion-navicon-round"></i></a></div>
      <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="#"><i class="icon ion-navicon-round"></i></a></div>

    </div><!-- br-header-left -->
    <div class="br-header-right">
      <nav class="nav">
        <div class="dropdown">

          <div class="dropdown-menu dropdown-menu-header">



          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
        <div class="dropdown">
          <a href="#" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
            <i class="fa fa-bell fa-2x"></i>
            <!-- start: if statement -->
            <span id="notifikasi" class="badge badge-danger"></span>
            <!-- end: if statement -->
          </a>
          <div class="dropdown-menu dropdown-menu-header">
            <div class="dropdown-menu-label">
              <label>Notifikasi</label>
            </div><!-- d-flex -->

            <div class="media-list">
              <!-- loop starts here notifikasi_pengingat.tanggal_notif = '$dateNow' AND  -->
              <?php
              $dateNow = date("Y-m-d");

              $mySql    = "SELECT * FROM order_obat_komp WHERE status_order = '1' AND status_racik ='0'
				ORDER BY tanggal_order DESC
				LIMIT 5";
              $myQry    = mysql_query($mySql, $koneksidb)  or die("Query  salah : " . mysql_error());
              $nomor   = 0;
              while ($myData = mysql_fetch_array($myQry)) {
                $nomor++;
                $Kode  = $myData['no_registrasi'];

              ?>

                <a href="?open=Racik-Obat-K&amp;Kode=<?php echo $Kode; ?>" class="media-list-link read">
                  <div class="media">
                    <i class="fa fa-sort"></i>
                    <div class="media-body">
                      <p class="noti-text"><strong><?php echo $myData['no_registrasi'] ?></strong>, Order Obat Baru</p>
                      <span><?php echo IndonesiaTgl($myData['tanggal_order']) ?></span>
                    </div>
                  </div><!-- media -->
                </a>
              <?php } ?>
              <!-- loop ends here -->

              <div class="dropdown-footer">
                <a href="?open=Order-Obat-K"><i class="fa fa-angle-down"></i> Tampilkan semua notifikasi</a>
              </div>
            </div><!-- media-list -->
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
        <div class="dropdown">

        </div><!-- dropdown -->
      </nav>

    </div><!-- br-header-right -->
  </div><!-- br-header -->



  <!-- ########## START: MAIN PANEL ########## -->
  <?php include "buka_file.php"; ?>

  <!-- ########## END: MAIN PANEL ########## -->

  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="lib/moment/min/moment.min.js"></script>
  <script src="lib/peity/jquery.peity.min.js"></script>
  <script src="lib/rickshaw/vendor/d3.min.js"></script>
  <script src="lib/rickshaw/vendor/d3.layout.min.js"></script>
  <script src="lib/rickshaw/rickshaw.min.js"></script>
  <script src="lib/jquery.flot/jquery.flot.js"></script>
  <script src="lib/jquery.flot/jquery.flot.resize.js"></script>
  <script src="lib/flot-spline/js/jquery.flot.spline.min.js"></script>
  <script src="lib/jquery-sparkline/jquery.sparkline.min.js"></script>
  <script src="lib/echarts/echarts.min.js"></script>
  <script src="lib/select2/js/select2.full.min.js"></script>
  <!--
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8o5-8Y5pudbJMJtDFzb8aHiWJufa5fg"></script>
    <script src="lib/gmaps/gmaps.min.js"></script>
    <script src="lib/jquery/jquery.min.js"></script>
 	<script src="lib/jquery-ui/ui/widgets/datepicker.js"></script>
	-->

  <!--
    chosen select
	<script src="lib/chosen/docsupport/jquery-3.2.1.min.js" type="text/javascript"></script>
    -->
  <script src="lib/chosen/chosen.jquery.js" type="text/javascript"></script>
  <script src="lib/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script src="lib/chosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>

  <script src="js/bracket.js"></script>
  <script src="js/map.shiftworker.js"></script>
  <script src="js/ResizeSensor.js"></script>
  <script src="js/dashboard.js"></script>
  <script>
    $(function() {
      'use strict'

      // FOR DEMO ONLY
      // menu collapsed by default during first page load or refresh with screen
      // having a size between 992px and 1299px. This is intended on this page only
      // for better viewing of widgets demo.
      $(window).resize(function() {
        minimizeMenu();
      });

      minimizeMenu();

      function minimizeMenu() {
        if (window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
          // show only the icons and hide left menu label by default
          $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
          $('body').addClass('collapsed-menu');
          $('.show-sub + .br-menu-sub').slideUp();
        } else if (window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
          $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
          $('body').removeClass('collapsed-menu');
          $('.show-sub + .br-menu-sub').slideDown();
        }
      }
    });
  </script>

</body>

</html>
