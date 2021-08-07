<?php 
include_once "library/inc.connection.php";
include_once "library/inc.library.php";


$noRegis	= $_GET['noRegis']; 
$mySql 		= "SELECT antrian.*, pasien.*, poliklinik.* FROM antrian 
			   LEFT JOIN pasien ON pasien.no_pasien = antrian.no_pasien
			   LEFT JOIN poliklinik ON poliklinik.kode_poli = antrian.kode_poli
			   WHERE antrian.no_registrasi = '$noRegis'";
$myQry 		= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData		= mysql_fetch_array($myQry);

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

?>


	<!-- Bracket CSS -->
    <link rel="stylesheet" href="css/bracket.css">


	<div class="br-pagebody">

        <div class="card bd-0 shadow-base">
          <div class="card-body pd-30 pd-md-60">
            <div class="d-md-flex justify-content-between flex-row-reverse">
              <h1 class="mg-b-0 tx-uppercase tx-gray-400 tx-mont tx-bold">KWITANSI</h1>
              <div class="mg-t-25 mg-md-t-0">
                <h6 class="tx-primary">KLINIK UTAMA GR SETRA</h6>
                <p class="lh-7">Jl. Tubagus Ismail VII No.21, Sekeloa, Coblong, Kota Bandung, Jawa Barat 40134<br>
                Telp : 324 445-4544 , Email: klinikgrsetra@gmail.com</p>
              </div>
            </div><!-- d-flex -->

            <div class="row mg-t-20">
              <div class="col-md">
                <label class="tx-uppercase tx-13 tx-bold mg-b-20">Sudah di terima dari :</label>
                <h6 class="tx-inverse"><?php echo strtoupper($myData['nama_pasien']) ?> / <?php echo strtoupper($myData['jenis_kelamin']) ?> / <?php echo $y; ?> tahun <?php echo $m; ?> bulan <?php echo $d; ?> hari</h6>
                <p class="lh-7"><?php echo strtoupper($myData['alamat_pasien']) ?> 
              </div><!-- col -->
              <div class="col-md">
                <label class="tx-uppercase tx-13 tx-bold mg-b-20">Informasi Kwitansi</label>
                <p class="d-flex justify-content-between mg-b-5">
                  <span>Tanggal Kwitansi</span><strong> <?php echo date_format($date2, 'd-m-Y H:i:s'); ?></strong></p>
                <p class="d-flex justify-content-between mg-b-5">
                  <span>No. Registrasi</span><strong> <?php echo $myData['no_registrasi'] ?></strong></p>
                
              </div><!-- col -->
            </div><!-- row -->

            <div class="table-responsive mg-t-40">
              <table class="table">
                <thead>
                  <tr>
                    <th class="wd-40p">Keterangan</th>
                    <th class="tx-right">Harga (Rp.)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="tx-12">Registrasi <?php echo $myData['nama_poli'] ?></td>
                    <td class="tx-14" align="right"><?php echo format_angka($myData['harga_registrasi']) ?></td>
                  </tr>

                </tbody>
              </table>
            </div><!-- table-responsive -->
			  
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="82%">
		  <label class="tx-uppercase tx-13 tx-bold mg-b-10">Terbilang</label>
	  </td>
      <td width="18%"><font size="-1">Bandung, <?php echo date('d-m-Y')?></font></td>
    </tr>
    <tr>
      <td><p class="tx-13" align="justify"><b><i><?php echo strtoupper(terbilang($myData['harga_registrasi'])) ?>  RUPIAH</i></b></p></td>
      <td>&nbsp;</td>
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
      <td><font size="-1">(________________)</font></td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td><font size="-1">Kasir</font></td>
    </tr>
  </tbody>
</table>


            <hr>

			  		  <div class="mg-r-20">
                        <p class="tx-13" align="justify"><b>Catatan :</b> Kuitansi ini sah, bila ada tanda tangan Kasir dan cap Klinik GR Setra, dan hanya terbit satu kali.  </p>
                      </div>

          </div><!-- card-body -->
        </div><!-- card -->

      </div><!-- br-pagebody -->