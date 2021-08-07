<?php include "inc.session.php"; ?>

<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">


<div class="br-mainpanel">

      <div class="br-pagetitle">
       <i class="fa fa-sort fa-4x"></i>
		  
        <div>
          <h4>Data Order Obat Pasien Komplementer</h4>
          <p class="mg-b-0">Berikut adalah data order obat pasien komplementer.</p>
        </div>
      </div><!-- d-flex -->
			
			
      <div class="br-pagebody">
        <div class="br-section-wrapper">
			
			<?php 
    //        menampilkan pesan jika ada pesan
            if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {

				
				echo '<div class="pesan">
              <div class="alert alert-success alert-solid pd-20" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-sm-flex align-items-center justify-content-start">
                  <i class="fa fa-thumbs-up fa-4x"></i>
                  <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                    <h5 class="mg-b-2 pd-t-2">Berhasil !</h5>
                    <p class="mg-b-0 tx-xs op-8">'.$_SESSION['pesan'].'</p>
                  </div>
                </div>
              </div></div>';
            }

    //        mengatur session pesan menjadi kosong
            $_SESSION['pesan'] = '';
            ?>

			
			<div class="table-wrapper">
            <table id="example" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th width="1%">No.</th>
                  <th width="9%">No. Registrasi</th>
				  <th width="10%">Waktu Registrasi</th>
                  <th width="10%">No. Pasien</th>
                  <th width="15%">Nama Pasien</th>
                  <th width="10%">Status Racik</th>                  
				  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
	<?php
	// Skrip menampilkan data dari database
	$dateNow = date("Y-m-d H:i:s");
	$dateNow2= date("Y-m-d");
	$mySql 	 = "SELECT order_obat_komp.*, antrian.*, pasien.* FROM order_obat_komp
				  LEFT JOIN antrian ON antrian.no_registrasi = order_obat_komp.no_registrasi
			    LEFT JOIN pasien ON pasien.no_pasien = antrian.no_pasien
			    WHERE order_obat_komp.status_order = '1'";
	$myQry 	 = mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor   = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode	= $myData['no_registrasi'];
		$date2  = date_create($myData['waktu_registrasi']);
		
		
		$stRacik	= $myData['status_racik'];
		
		if ($stRacik == "0"){
			$hsLunas	= "Belum";			
		} else if ($stRacik == "1"){
			$hsLunas	= "Peracikan";
		} else if ($stRacik == "2"){
			$hsLunas	= "Obat Siap";
		}

		
	?>
                <tr>
                  <td></td>
                  <td><?php echo $myData['no_registrasi']; ?></td>
				  <td><?php echo date_format($date2, 'd-m-Y H:i:s'); ?></td>
                  <td><?php echo strtoupper($myData['no_pasien']); ?></td>
                  <td><?php echo strtoupper($myData['nama_pasien']); ?></td>
                  <td><?php echo strtoupper($hsLunas); ?></td>                  
				  <td>
				  <?php if ($stRacik == "0") { ?>  
				   <a href="?open=Racik-Obat-K&amp;Kode=<?php echo $Kode; ?>" class="btn btn-info"> Racik Obat</a>
				  <?php } else if ($stRacik == "1") { ?>
				   <a href="?open=Siap-Obat-K&amp;Kode=<?php echo $Kode; ?>" class="btn btn-info"> Racik Selesai</a>  
				  <?php } else if ($stRacik == "2") { ?>
					 
				  <?php } ?>
					
					
				  </td>
                </tr>
    <?php } ?>       
              </tbody>
            </table>
          </div><!-- table-wrapper -->
			
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
      
    </div><!-- br-mainpanel -->


	<script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>

	

     <script>
     $(document).ready(function() {
     var t = $('#example').DataTable( {
		  aLengthMenu: [[25, 50, 75, 100], [25, 50, 75, "Semua"]],
          iDisplayLength: 25,
		 
		 "language": {
			searchPlaceholder: 'Pencarian...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
			info:           "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
			lengthMenu:     "Menampilkan _MENU_ data",
			zeroRecords:    "Tidak ada data yang cocok dengan pencarian anda",
		    infoEmpty:      "Menampilkan 0 sampai 0 dari 0 data",
    		infoFiltered:   "(Pencarian dari _MAX_ total data)",
        },
		 
		 scrollX:        true,
		 responsive: false,
        "columnDefs": [ {
            "searchable": false,
            "orderable": true,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]]
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
		 
	} );
    </script>



		<script>
//            angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
            $(document).ready(function(){setTimeout(function(){$(".pesan").fadeIn('slow');}, 700);});
//            angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
            setTimeout(function(){$(".pesan").fadeOut('slow');}, 4000);
        </script>
