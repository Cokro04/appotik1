<?php include "inc.session.php"; ?>

<link rel="stylesheet" href="lib/chosen/docsupport/prism.css">
<link rel="stylesheet" href="lib/chosen/chosen.css">
<script type='text/javascript' src='js/ajax.js'></script>


<script language="javascript">
  function prosesHasilPpn() {
    var elemen_txtHna = document.getElementById("txtHna");
    var nama_txtHna = elemen_txtHna.value;

    var elemen_txtHnaPpn = document.getElementById("txtHnaPpn");
    var nama_txtHnaPpn = elemen_txtHnaPpn.value;


    var url = "hasil_ppn.php?kode=" + nama_txtHnaPpn + "&kode2=" + nama_txtHna;
    ambilData(url, "id_ppn");
  }
</script>



<div class="br-mainpanel">

  <div class="br-pagetitle">
    <i class="fa fa-user-plus fa-4x"></i>
    <div>
      <h4>Input Obat</h4>
      <p class="mg-b-0">Lengkapi sesuai form yang telah di sediakan !</p>
    </div>
  </div><!-- d-flex -->




  <div class="br-pagebody">
    <div class="br-section-wrapper">


      <?php

      # SKRIP SAAT TOMBOL SIMPAN DIKLIK
      if (isset($_POST['btnSimpan'])) {
        # BACA DATA DALAM FORM, masukkan datake variabel


        $txtKode        = $_POST['txtKode'];
        $txtNama        = $_POST['txtNama'];
        $cmbSediaan     = $_POST['cmbSediaan'];
        $cmbEtiket      = $_POST['cmbEtiket'];
        $txtStok        = $_POST['txtStok'];
        $txtMinStok     = $_POST['txtMinStok'];
        $cmbSatuan      = $_POST['cmbSatuan'];
        $txtHna         = $_POST['txtHna'];
        $txtHnaPpn      = $_POST['txtHnaPpn'];
        $hasil          = (($txtHnaPpn / 100) * ($txtHna)) + $txtHna;
        $txtHnaPpn2     = $hasil;
        $txtPpnRj       = $_POST['txtPpnRj'];
        $txtPpnRi       = $_POST['txtPpnRi'];
        $txtKadaluarsa  = $_POST['txtKadaluarsa'];


        # VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
        $pesanError = array();

        if (trim($txtNama) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">Nama Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        } else if (trim($cmbSediaan) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">Bentuk Sediaan Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        } else if (trim($cmbEtiket) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">Etiket Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        } else if (trim($txtStok) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">Stok Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        } else if (trim($txtMinStok) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">Minimal Stok Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        } else if (trim($cmbSatuan) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">Satuan Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        } else if (trim($txtHna) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">HNA Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        } else if (trim($txtHnaPpn) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">PPn HNA Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        } else if (trim($txtPpnRj) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">PPn Rawat Jalan Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        } else if (trim($txtPpnRi) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">PPn Rawat Inap Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        } else if (trim($txtKadaluarsa) == "") {
          $pesanError[] = "";

          echo '<div class="pesan">
              <div class="alert alert-danger alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-close fa-2x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Maaf !</h5>
                    <p class="mg-b-0 tx-xs op-8">Tanggal Kadaluarsa Obat belum di isi </p>
                  </div>
                </div>
              </div></div>';
        }



        # MENAMPILKAN PESAN JIKA ADA ERROR DARI VALIDASI
        if (count($pesanError) >= 1) {

          $noPesan = 0;
          foreach ($pesanError as $indeks => $pesan_tampil) {
            $noPesan++;
            echo "$pesan_tampil";
          }
          echo "";
        } else {
          # SIMPAN DATA KE DATABASE.
          // Jika tidak menemukan error, simpan data ke database
          $dateNow  = date('Y-m-d H:i:s');
          // QRY untuk menyimpan data obat
          $mySql    = "INSERT INTO obat_copy (kode_obat, nama_obat, kode_sediaan, stok, stok_minimal, kode_satuan, hna, ppn_hna, hasil_hna_ppn, ppn_rj, ppn_ri, etiket, tanggal_kadaluarsa, tanggal_input, tanggal_update)
						VALUES ('$txtKode', '$txtNama' , '$cmbSediaan', '$txtStok', '$txtMinStok', '$cmbSatuan', '$txtHna', '$txtHnaPpn','$txtHnaPpn2','$txtPpnRj','$txtPpnRi','$cmbEtiket','$txtKadaluarsa','$dateNow','')";
          $myQry    = mysql_query($mySql, $koneksidb) or die("Gagal query" . mysql_error());
          if ($myQry) {
            // Pesan jika data obat berhasil di input
            $_SESSION['pesan'] = 'Data obat berhasil di input';
            // redirect
            echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Data-Obat"} , 1500);</script>';
            //echo '<script type="text/javascript">play_sound();</script>';
          }
          exit;
        }
      }

      // Script untuk membuat kode otomatis

      $bacaSql2    = "SELECT kode_obat from obat_copy";
      $bacaQry2    = mysql_query($bacaSql2, $koneksidb) or die("Gagal Query" . mysql_error());
      $bacaData2   = mysql_fetch_array($bacaQry2);

      $jumlah_data  = mysql_num_rows($bacaQry2);
      if ($bacaData2) {
        $nilaikode  = substr($jumlah_data[0], 1);
        $kode       = (int) $nilaikode;
        $kode       = $jumlah_data + 1;
        $koOb       = "OBT-";
        $dataKode   = str_pad($kode, 6, "0", STR_PAD_LEFT);
        $kod        = $koOb . $dataKode;
      } else {
        $kod = "OBT-000001";
      }


      $dataNama      = isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
      $dataSediaan   = isset($_POST['cmbSediaan']) ? $_POST['cmbSediaan'] : '';
      $dataEtiket    = isset($_POST['cmbEtiket']) ? $_POST['cmbEtiket'] : '';
      $dataStok      = isset($_POST['txtStok']) ? $_POST['txtStok'] : '';
      $dataMinStok   = isset($_POST['txtMinStok']) ? $_POST['txtMinStok'] : '';
      $dataSatuan    = isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : '';
      $dataHna       = isset($_POST['txtHna']) ? $_POST['txtHna'] : '';
      $dataHnaPpn    = isset($_POST['txtHnaPpn']) ? $_POST['txtHnaPpn'] : '';
      $dataHnaPpn2   = isset($_POST['txtHnaPpn2']) ? $_POST['txtHnaPpn2'] : '';
      $dataPpnRj      = isset($_POST['txtPpnRj']) ? $_POST['txtPpnRj'] : '';
      $dataPpnRi      = isset($_POST['txtPpnRi']) ? $_POST['txtPpnRi'] : '';
      $dataKadaluarsa = isset($_POST['txtKadaluarsa']) ? $_POST['txtKadaluarsa'] : '';
      ?>



<!-- Form untuk input data obat baru -->
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">
        <h6 class="br-section-label">DATA OBAT BARU</h6>

        <div class="form-layout form-layout-2">
          <div class="row no-gutters">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Kode Obat : </label>
                <input class="form-control" type="text" name="txtKode" value="<?php echo $kod ?>" readonly>
              </div>
            </div><!-- col-4 -->

            <div class="col-md-6 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Nama Obat : <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="txtNama" value="<?php echo $dataNama ?>" placeholder="Masukan Nama Obat">
              </div>
            </div><!-- col-4 -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Bentuk Sediaan : <span class="tx-danger">*</span></label>
                <select data-placeholder="Pilih Bentuk Sediaan" class="chosen-select" tabindex="7" style="width: 100%" name="cmbSediaan">
                  <option value="">....</option>
                  <?php
                  $bacaSql = "SELECT * FROM bentuk_sediaan ORDER BY nama_sediaan";
                  $bacaQry = mysql_query($bacaSql, $koneksidb) or die("Gagal Query" . mysql_error());
                  while ($bacaData = mysql_fetch_array($bacaQry)) {
                    // Status terpilih
                    if ($dataSediaan == $bacaData['kode_sediaan']) {
                      $pilih = " selected";
                    } else {
                      $pilih = "";
                    }

                    $kapitalNama  = strtoupper($bacaData[nama_sediaan]);

                    echo "<option value='$bacaData[kode_sediaan]' $pilih> $kapitalNama </option>";
                  }
                  ?>
                </select>
              </div>
            </div><!-- col-4 -->
            <div class="col-md-6 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Etiket Obat : <span class="tx-danger">*</span></label>

                <select name="cmbEtiket" class="form-control">
                  <option value="">....</option>
                  <?php
                  $pilihan = array("Biru", "Putih");

                  foreach ($pilihan as $indek) {
                    if ($dataEtiket == $indek) {
                      $cek = "selected";
                    } else {
                      $cek = "";
                    }
                    echo "<option value='$indek' $cek>$indek</option>";
                  }
                  ?>
                </select>



              </div>
            </div><!-- col-4 -->

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-control-label">Stok : <span class="tx-danger">*</span></label>

                <input class="form-control" type="text" name="txtStok" value="<?php echo $dataStok ?>" placeholder="Masukan Stok Obat" onkeypress="return angkadanhuruf(event,'1234567890',this)" maxlength="11">

              </div>
            </div><!-- col-4 -->
            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Minimal Stok : <span class="tx-danger">*</span></label>

                <input class="form-control" type="text" name="txtMinStok" value="<?php echo $dataMinStok ?>" placeholder="Masukan Minimal Stok Obat" onkeypress="return angkadanhuruf(event,'1234567890',this)" maxlength="11">

              </div>
            </div><!-- col-4 -->
            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Satuan Obat : <span class="tx-danger">*</span></label>

                <select data-placeholder="Pilih Satuan Obat" class="chosen-select" tabindex="7" style="width: 100%" name="cmbSatuan">
                  <option value="">....</option>
                  <?php
                  $bacaSql = "SELECT * FROM satuan_obat ORDER BY nama_satuan";
                  $bacaQry = mysql_query($bacaSql, $koneksidb) or die("Gagal Query" . mysql_error());
                  while ($bacaData = mysql_fetch_array($bacaQry)) {
                    // Status terpilih
                    if ($bacaData['kode_satuan'] == $dataSatuan) {
                      $pilih = " selected";
                    } else {
                      $pilih = "";
                    }

                    echo "<option value='$bacaData[kode_satuan]' $pilih> $bacaData[nama_satuan] </option>";
                  }
                  ?>
                </select>


              </div>
            </div><!-- col-4 -->

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--0">
                <label class="form-control-label">HNA : <span class="tx-danger">*</span></label>

                <input class="form-control" type="text" name="txtHna" id="txtHna" value="<?php echo $dataHna ?>" maxlength="11" placeholder="Masukan HNA Obat" onkeypress="return angkadanhuruf(event,'1234567890',this)">

              </div>
            </div><!-- col-4 -->
            <div class="col-md-2 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">PPN HNA : (%) <span class="tx-danger">*</span></label>


                <input class="form-control" type="text" name="txtHnaPpn" id="txtHnaPpn" value="<?php echo $dataHnaPpn ?>" maxlength="2" placeholder="PPN Obat" onkeypress="return angkadanhuruf(event,'1234567890',this)" onchange="prosesHasilPpn()">


              </div>
            </div><!-- col-4 -->
            <div class="col-md-2 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">HNA + PPN :</label>
                <div id="id_ppn">

                  <input class="form-control" type="text" name="txtHnaPpn2" value="<?php echo $dataHnaPpn2 ?>" maxlength="2" onkeypress="return angkadanhuruf(event,'1234567890',this)" readonly>

                </div>
              </div>
            </div><!-- col-4 -->
            <div class="col-md-2 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">PPN Rawat Jalan : (%) <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="txtPpnRj" value="<?php echo $dataPpnRj ?>" maxlength="2" placeholder="Masukan PPN Rawat Jalan Obat" onkeypress="return angkadanhuruf(event,'1234567890',this)">
              </div>
            </div>

            <div class="col-md-2 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">PPN Rawat Inap : (%) <span class="tx-danger">*</span></label>
                <div id="id_Suku">

                  <input class="form-control" type="text" name="txtPpnRi" value="<?php echo $dataPpnRi ?>" maxlength="2" placeholder="Masukan PPN Rawat Inap Obat" onkeypress="return angkadanhuruf(event,'1234567890',this)">

                </div>
              </div>
            </div><!-- col-4 -->

            <div class="col-md-12">
              <div class="form-group">
                <label class="form-control-label">Tanggal Kadaluarsa : <span class="tx-danger">*</span></label>
                <input name="txtKadaluarsa" class="form-control" type="date" value="<?php echo $dataKadaluarsa ?>">
              </div>
            </div><!-- col-4 -->


          </div><!-- row -->

          <div class="form-layout-footer bd pd-20 bd-t-0">
            <a href="?open=Obat-Data" class="btn btn-secondary">Kembali</a>
            <input type="submit" name="btnSimpan" value=" Input " class="btn btn-info" />
            <input type="reset" name="btnReset" value=" Reset " class="btn btn-danger" />
          </div><!-- form-group -->

        </div><!-- form-layout -->
      </form>

<!-- Akhir form data oabat baru -->

    </div>
  </div>
</div>


<script>
  //            angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
  $(document).ready(function() {
    setTimeout(function() {
      $(".pesan").fadeIn('slow');
    }, 700);
  });
  //            angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
  setTimeout(function() {
    $(".pesan").fadeOut('slow');
  }, 3000);
</script>
