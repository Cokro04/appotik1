 <?php
  include "inc.session.php";

  $waktuNow  = date('Y:m:d');


  //pasien
  $pageSql  = "SELECT * FROM pasien";
  $pageQry  = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
  $jumlah    = mysql_num_rows($pageQry);

  //kamar
  $pageSql2  = "SELECT * FROM kamar WHERE status_kosong = 'kosong' AND status_bersih = 'bersih'";
  $pageQry2  = mysql_query($pageSql2, $koneksidb) or die("error paging: " . mysql_error());
  $jumlah2  = mysql_num_rows($pageQry2);

  //kunjungan
  $pageSql3  = "SELECT * FROM antrian WHERE tanggal_registrasi = '$waktuNow' AND kode_poli = 'A01'";
  $pageQry3  = mysql_query($pageSql3, $koneksidb) or die("error paging: " . mysql_error());
  $jumlah3  = mysql_num_rows($pageQry3);

  //pasien baru
  $pageSql4  = "SELECT * FROM pasien WHERE tanggal_daftar = '$waktuNow'";
  $pageQry4  = mysql_query($pageSql4, $koneksidb) or die("error paging: " . mysql_error());
  $jumlah4  = mysql_num_rows($pageQry4);

  //pemasukan
  $pageSql5  = "SELECT SUM(harga_registrasi) AS total_harga FROM antrian WHERE tanggal_registrasi = '$waktuNow'";
  $pageQry5  = mysql_query($pageSql5, $koneksidb) or die("error paging: " . mysql_error());
  $myData5    = mysql_fetch_array($pageQry5);


  $SqlpoliUmum  = "SELECT * FROM antrian WHERE kode_poli = 'A01'";
  $accQry1      = mysql_query($SqlpoliUmum, $koneksidb) or die("error: " . mysql_error());
  $datapoliumum = mysql_num_rows($accQry1);

  $blnsekarang = date('Y-m');
  $today       = date('Y-m-d');

  $Sqlpasienbulan  = "SELECT * FROM antrian WHERE tanggal_registrasi LIKE '%$blnsekarang%'";
  $accQry2         = mysql_query($Sqlpasienbulan, $koneksidb) or die("error: " . mysql_error());
  $pasienbulan     = mysql_num_rows($accQry2);

  $Sqlpasienhari   = "SELECT * FROM antrian WHERE tanggal_registrasi LIKE '%$today%'";
  $accQry3         = mysql_query($Sqlpasienhari, $koneksidb) or die("error: " . mysql_error());
  $pasienhari      = mysql_num_rows($accQry3);

  $Sqltunggu       = "SELECT * FROM antrian WHERE tanggal_registrasi LIKE '%$today%' AND status_periksa='0'";
  $accQry4         = mysql_query($Sqltunggu, $koneksidb) or die("error: " . mysql_error());
  $tungu           = mysql_num_rows($accQry4);

  // komplementer gabungan

  $Sqlkom          = "SELECT * FROM antrian WHERE kode_poli='A09' OR kode_poli='A10' OR kode_poli='A11' OR kode_poli='A12'";
  $accQry5         = mysql_query($Sqlkom, $koneksidb) or die("error: " . mysql_error());
  $komplementer    = mysql_num_rows($accQry5);

  // Ambil Obat poliklinik umum

  $SqlAmbilObat    = "SELECT * FROM antrian WHERE ambil_obat='1'";
  $accQry6         = mysql_query($SqlAmbilObat, $koneksidb) or die("error: " . mysql_error());
  $AmbilObat       = mysql_num_rows($accQry6);

  // ambil obat komplementer

  $SqlAmbilObatKomp    = "SELECT order_obat_komp.*, antrian.*, pasien.* FROM order_obat_komp
                          LEFT JOIN antrian ON antrian.no_registrasi = order_obat_komp.no_registrasi
                          LEFT JOIN pasien ON pasien.no_pasien = antrian.no_pasien
                          WHERE order_obat_komp.status_order = '1' AND order_obat_komp.status_racik = '2'";
  $accQry7             = mysql_query($SqlAmbilObatKomp, $koneksidb)  or die("Query  salah : " . mysql_error());
  $AmbilObatKomp       = mysql_num_rows($accQry7);


  $SqlSedangDiracik    = "SELECT order_obat_komp.*, antrian.*, pasien.* FROM order_obat_komp
                          LEFT JOIN antrian ON antrian.no_registrasi = order_obat_komp.no_registrasi
                          LEFT JOIN pasien ON pasien.no_pasien = antrian.no_pasien
                          WHERE order_obat_komp.status_racik = '0'";
  $accQry8             = mysql_query($SqlSedangDiracik, $koneksidb)  or die("Query  salah : " . mysql_error());
  $SedangDiracik       = mysql_num_rows($accQry8);

  $SqlSudahDiracik    = "SELECT order_obat_komp.*, antrian.*, pasien.* FROM order_obat_komp
                          LEFT JOIN antrian ON antrian.no_registrasi = order_obat_komp.no_registrasi
                          LEFT JOIN pasien ON pasien.no_pasien = antrian.no_pasien
                          WHERE order_obat_komp.status_racik = '1'";
  $accQry9             = mysql_query($SqlSudahDiracik, $koneksidb)  or die("Query  salah : " . mysql_error());
  $SudahDiracik       = mysql_num_rows($accQry9);


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

 <div class="br-mainpanel">
   <div class="br-pagetitle">
     <i class="fa fa-home tx-60 lh-0 op-7"></i>
     <div>
       <h4>Dashboard</h4>
       <p class="mg-b-0">Klinik Utama Canon Medicinae Indonesia , Jl. Tubagus Ismail VII No.21, Sekeloa, Coblong, Kota Bandung, Jawa Barat 40134</p>
     </div>
   </div>

   <div class="br-pagebody">
     <div class="row row-sm">


       <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
         <div class="bg-purple rounded overflow-hidden">
           <div class="pd-x-20 pd-t-20 d-flex align-items-center">
             <i class="fa fa-share-square tx-60 lh-0 tx-white op-7"></i>
             <div class="mg-l-20">
               <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Kunjungan Pasien Poliklinik Umum</p>
               <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $datapoliumum; ?></p>
               <span class="tx-11 tx-roboto tx-white-8">Poliklinik Umum</span>
             </div>
           </div>
           <div id="ch3" class="ht-50 tr-y-1"></div>
         </div>
       </div><!-- col-3 -->

       <div class="col-sm-6 col-xl-3">
         <div class="bg-info rounded overflow-hidden">
           <div class="pd-x-20 pd-t-20 d-flex align-items-center">
             <i class="fa fa-user-plus tx-60 lh-0 tx-white op-7"></i>
             <div class="mg-l-20">
               <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Pasien Menungu Hari Ini</p>
               <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $tungu; ?></p>
               <span class="tx-11 tx-roboto tx-white-8">per tanggal <?php echo date('d-m-Y') ?></span>
             </div>
           </div>
           <div id="ch1" class="ht-50 tr-y-1"></div>
         </div>
       </div><!-- col-3 -->


       <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
         <div class="bg-primary rounded overflow-hidden">
           <div class="pd-x-20 pd-t-20 d-flex align-items-center">
             <i class="fa fa-user-md tx-60 lh-0 tx-white op-7"></i>
             <div class="mg-l-20">
               <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Pasien di tangani Hari Ini</p>
               <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $pasienhari; ?></p>
               <span class="tx-11 tx-roboto tx-white-8">per tanggal <?php echo date('d-m-Y') ?></span>
             </div>
           </div>
           <div id="ch4" class="ht-50 tr-y-1"></div>
         </div>
       </div><!-- col-3 -->

       <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
         <div class="bg-teal rounded overflow-hidden">
           <div class="pd-x-20 pd-t-20 d-flex align-items-center">
             <i class="fa fa-user-md tx-60 lh-0 tx-white op-7"></i>
             <div class="mg-l-20">
               <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Pasien di tangani Bulan Ini</p>
               <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $pasienbulan; ?></p>
               <span class="tx-11 tx-roboto tx-white-8">Per bulan <?php echo date('m-Y') ?></span>
             </div>
           </div>
           <div id="ch2" class="ht-50 tr-y-1"></div>
         </div>
       </div><!-- col-3 -->

     </div><!-- row -->

     <br>

     <div class="row row-sm">

       <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
         <div class="bg-danger rounded overflow-hidden">
           <div class="pd-x-20 pd-t-20 d-flex align-items-center">
             <i class="fa fa-share-square tx-60 lh-0 tx-white op-7"></i>
             <div class="mg-l-20">
               <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Kunjungan Pasien Komplementer</p>
               <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $komplementer; ?></p>
               <span class="tx-11 tx-roboto tx-white-8">Komplementer</span>
             </div>
           </div>
           <div id="ch3" class="ht-50 tr-y-1"></div>
         </div>
       </div><!-- col-3 -->

       <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
         <div class="bg-teal rounded overflow-hidden">
           <div class="pd-x-20 pd-t-20 d-flex align-items-center">
             <i class="fa fa-user tx-60 lh-0 tx-white op-7"></i>
             <div class="mg-l-20">
               <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Pasien Ambil Obat Komplementer</p>
               <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $AmbilObatKomp; ?></p>
               <span class="tx-11 tx-roboto tx-white-8">Obat Komplementer</span>
             </div>
           </div>
           <div id="ch2" class="ht-50 tr-y-1"></div>
         </div>
       </div><!-- col-3 -->

       <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
         <div class="bg-teal rounded overflow-hidden">
           <div class="pd-x-20 pd-t-20 d-flex align-items-center">
             <i class="fa fa-tasks tx-60 lh-0 tx-white op-7"></i>
             <div class="mg-l-20">
               <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Obat Komplementer Sedang Diracik</p>
               <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $SedangDiracik; ?></p>
               <span class="tx-11 tx-roboto tx-white-8">Obat Komplementer</span>
             </div>
           </div>
           <div id="ch2" class="ht-50 tr-y-1"></div>
         </div>
       </div><!-- col-3 -->

       <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
         <div class="bg-teal rounded overflow-hidden">
           <div class="pd-x-20 pd-t-20 d-flex align-items-center">
             <i class="fa fa-check tx-60 lh-0 tx-white op-7"></i>
             <div class="mg-l-20">
               <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Obat Komplementer Selesai Diracik</p>
               <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $SudahDiracik; ?></p>
               <span class="tx-11 tx-roboto tx-white-8">Obat Komplementer</span>
             </div>
           </div>
           <div id="ch2" class="ht-50 tr-y-1"></div>
         </div>
       </div><!-- col-3 -->

     </div><!-- row -->

     <br>

     <div class="row row-sm">

       <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
         <a href="?open=Data_Obat_Kadaluarsa">
           <div class="bg-danger rounded overflow-hidden">
             <div class="pd-x-20 pd-t-20 d-flex align-items-center">
               <i class="fa fa-calendar-o tx-60 lh-0 tx-white op-7"></i>
               <div class="mg-l-20">
                 <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Obat Telah Kadaluarsa</p>
                 <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $Kadaluarsa; ?></p>
                 <span class="tx-11 tx-roboto tx-white-8">Obat</span>
               </div>
             </div>
             <div id="ch3" class="ht-50 tr-y-1"></div>
           </div>
         </a>
       </div><!-- col-3 -->


       <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
         <a href="?open=Data_Obat_Hampir_Kadaluarsa">
           <div class="bg-danger rounded overflow-hidden">
             <div class="pd-x-20 pd-t-20 d-flex align-items-center">
               <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
               <div class="mg-l-20">
                 <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Obat Hampir Kadaluarsa</p>
                 <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $hampir; ?></p>
                 <span class="tx-11 tx-roboto tx-white-8">Obat</span>
               </div>
             </div>
             <div id="ch3" class="ht-50 tr-y-1"></div>
           </div>
         </a>
       </div><!-- col-3 -->


       <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
         <a href="?open=Data_Obat_Hampir_Habis">
           <div class="bg-danger rounded overflow-hidden">
             <div class="pd-x-20 pd-t-20 d-flex align-items-center">
               <i class="fa fa-plus-square tx-60 lh-0 tx-white op-7"></i>
               <div class="mg-l-20">
                 <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Obat Hampir Habis</p>
                 <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $StokHabis; ?></p>
                 <span class="tx-11 tx-roboto tx-white-8">Obat</span>
               </div>
             </div>
             <div id="ch3" class="ht-50 tr-y-1"></div>
           </div>
         </a>
       </div><!-- col-3 -->

       <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
         <a href="?open=Data-Obat-Habis">
           <div class="bg-danger rounded overflow-hidden">
             <div class="pd-x-20 pd-t-20 d-flex align-items-center">
               <i class="fa fa-check-square-o tx-60 lh-0 tx-white op-7"></i>
               <div class="mg-l-20">
                 <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Obat Sudah Habis</p>
                 <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><?= $Habis; ?></p>
                 <span class="tx-11 tx-roboto tx-white-8">Obat</span>
               </div>
             </div>
             <div id="ch3" class="ht-50 tr-y-1"></div>
           </div>
         </a>
       </div><!-- col-3 -->



     </div><!-- row -->








   </div><!-- br-pagebody -->

 </div>
