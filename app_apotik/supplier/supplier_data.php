<?php include "inc.session.php"; ?>



<link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="css/component-chosen.css" rel="stylesheet">



<?php
$SqlGetSupplier = "SELECT * FROM supplier_data ORDER BY supplier_data.id";
$QryExeSupplier = mysql_query($SqlGetSupplier, $koneksidb) or die("Query salah : " . mysql_error());

if(isset($_POST['btnEditSup'])){

  $id_modals      = $_POST['id_modal_edit'];
  $produk         = $_POST['produk_modal_edit'];
  $nama_supplier  = $_POST['nama_supplier_modal_edit'];
  $brand          = $_POST['brand_modal_edit'];
  $alamat         = $_POST['alamat_modal_edit'];
  $telepon        = $_POST['telepon_modal_edit'];
  $fax            = $_POST['fax_modal_edit'];
  $website        = $_POST['website_modal_edit'];

  $sqlEditSup = "UPDATE supplier_data SET nama_supplier = '$nama_supplier' , produk = '$produk' , brand = '$brand' , alamat = '$alamat' , telepon = '$telepon' , fax = '$fax' , website='$website' WHERE id = '$id_modals'";
  $qryEditSup = mysql_query($sqlEditSup, $koneksidb) or die("Gagal query" . mysql_error());

  if($qryEditSup){
    echo "<script>";
    echo "swal({
        type: 'success',
        title: 'Update Data Supplier',
                text: '',
          timer: 5000,
          showConfirmButton: false,
        html: true
              })";
    echo "</script>";

    echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Supplier-Data"} , 1500);</script>';
  }
}

if(isset($_POST['btnAddSup'])){

  $id_modals_add      = $_POST['id_modal_add'];
  $produk_add         = $_POST['produk_modal_add'];
  $nama_supplier_add  = $_POST['nama_supplier_modal_add'];
  $brand_add          = $_POST['brand_modal_add'];
  $alamat_add         = $_POST['alamat_modal_add'];
  $telepon_add        = $_POST['telepon_modal_add'];
  $fax_add            = $_POST['fax_modal_add'];
  $website_add        = $_POST['website_modal_add'];


  $sqlAddSup = "INSERT INTO supplier_data (nama_supplier, produk, brand, alamat, telepon, fax, website) VALUES ('$nama_supplier_add','$produk_add','$brand_add','$alamat_add','$telepon_add','$fax_add', '$website_add')";
  $qryAddSup = mysql_query($sqlAddSup, $koneksidb) or die("Gagal query" . mysql_error());

  if($qryAddSup){

    echo "<script>";
    echo "swal({
        type: 'success',
        title: 'Tambah Data Supplier',
                text: '',
          timer: 5000,
          showConfirmButton: false,
        html: true
              })";
    echo "</script>";

    echo '<script type="text/javascript">setTimeout(function(){window.top.location="?open=Supplier-Data"} , 1500);</script>';
  }
}
?>




<div class="br-mainpanel">

  <div class="br-pagetitle">
    <i class="fa fa-database fa-4x"></i>
    <div>
      <h4>Data Supplier Obat</h4>
      <p class="mg-b-0">Berikut Merupakan Data dari Supplier Obat</p>
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
                    <p class="mg-b-0 tx-xs op-8">' . $_SESSION['pesan'] . '</p>
                  </div>
                </div>
              </div></div>';
      }

      //        mengatur session pesan menjadi kosong
      $_SESSION['pesan'] = '';
      ?>

      <br>
      <a href="#" class="btn btn-info btn-fill" data-toggle="modal" data-target="#modaldemooo3"><i class="fa fa-plus"></i> Tambah Data Supplier</a>
      <br>
      <br>



      <div class="table-wrapper">
        <table class="table display responsive nowrap">
          <thead>
            <tr>
              <th width="1%">No.</th>
              <th>Nama Supplier</th>
              <th>Produk</th>
              <th>Brand</th>
              <th>Alamat</th>
              <th align="center">Aksi</th>
            </tr>
          </thead>
            <?php
            $i = '1';
             while ($dataSupplier = mysql_fetch_array($QryExeSupplier)) {
            ?>
          <tbody>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= $dataSupplier['nama_supplier'] ?></td>
                <td><?= $dataSupplier['produk']?></td>
                <td><?= $dataSupplier['brand']?></td>
                <td><?= $dataSupplier['alamat']?></td>
                <td>
                  <a href="#" class="btn btn-primary tx-11 tx-uppercase pd-y-5 pd-x-5 tx-mont tx-medium" data-toggle="modal" data-target="#modaldemo3<?= $dataSupplier['id']?>"><i class="fa fa-eye"></i> Detail </a>
                  <a href="#" class="btn btn-warning tx-11 tx-uppercase pd-y-5 pd-x-5 tx-mont tx-medium" data-toggle="modal" data-target="#modaldemoo3<?= $dataSupplier['id']?>"><i class="fa fa-pencil"></i> Edit </a>
                  <a href="?open=Supplier-Delete&amp;Kode=<?= $dataSupplier['id']; ?>" class="btn btn-danger tx-11 tx-uppercase pd-y-5 pd-x-5 tx-mont tx-medium" onclick="return confirm('Yakin akan di hapus ?')"><i class="fa fa-minus-circle"></i> Delete </a>
                  </from>
                </td>

                <!-- LARGE MODAL -->
                <div id="modaldemo3<?= $dataSupplier['id']?>" class="modal fade">
                  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content tx-size-sm">
                      <div class="modal-header pd-x-20">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail Data Supplier</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body pd-20">
                        <div class="pd-30 bd">
                          <dl class="row">
                            <dt class="col-sm-4 tx-inverse" align="right">Nama Supplier</dt>
                            <dd class="col-sm-8"><?= $dataSupplier['nama_supplier'] ?></dd>
                            <dt class="col-sm-4 tx-inverse" align="right">Produk</dt>
                            <dd class="col-sm-8"><?= $dataSupplier['produk'] ?><dd>
                            <dt class="col-sm-4 tx-inverse" align="right">Brand</dt>
                            <dd class="col-sm-8"><?= $dataSupplier['brand'] ?></dd>
                            <dt class="col-sm-4 tx-inverse" align="right">Alamat Supplier</dt>
                            <dd class="col-sm-8"><?= $dataSupplier['alamat'] ?></dd>
                            <dt class="col-sm-4 tx-inverse" align="right">Telepon</dt>
                            <dd class="col-sm-8"><?= $dataSupplier['telepon'] ?></dd>
                            <dt class="col-sm-4 tx-inverse" align="right">Fax</dt>
                            <dd class="col-sm-8"><?= $dataSupplier['fax'] ?></dd>
                            <dt class="col-sm-4 tx-inverse" align="right">Website</dt>
                            <dd class="col-sm-8"><?= $dataSupplier['website'] ?></dd>
                        </dl>
                      </div>
                      </div><!-- modal-body -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tx-size-xs" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div><!-- modal-dialog -->
                </div><!-- modal -->

                <!-- LARGE MODAL -->
                <div id="modaldemoo3<?= $dataSupplier['id']?>" class="modal fade">
                  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content tx-size-sm">
                      <div class="modal-header pd-x-20">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Perbaharui Data Supplier</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body pd-20">
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">
                          <div class="form-group">
                            <label for="formGroupExampleInput">Nama Supplier</label>
                              <input type="hidden" class="form-control" value="<?= $dataSupplier['id'] ?>" name="id_modal_edit">
                            <input type="text" class="form-control" value="<?= $dataSupplier['nama_supplier'] ?>" name="nama_supplier_modal_edit">
                          </div>
                          <div class="form-group">
                            <label for="formGroupExampleInput">Produk</label>
                              <input type="text" class="form-control" value="<?= $dataSupplier['produk'] ?>" name="produk_modal_edit">
                          </div>
                          <div class="form-group">
                            <label for="formGroupExampleInput">Brand</label>
                            <input type="text" class="form-control" value="<?= $dataSupplier['brand'] ?>" name="brand_modal_edit">
                          </div>
                          <div class="form-group">
                            <label for="formGroupExampleInput">Alamat Supplier</label>
                            <input type="text" class="form-control" value="<?= $dataSupplier['alamat'] ?>" name="alamat_modal_edit">
                          </div>
                          <div class="form-group">
                            <label for="formGroupExampleInput">telepon</label>
                            <input type="text" class="form-control" value="<?= $dataSupplier['telepon'] ?>" name="telepon_modal_edit">
                          </div>
                          <div class="form-group">
                            <label for="formGroupExampleInput">Fax</label>
                            <input type="text" class="form-control" value="<?= $dataSupplier['fax'] ?>" name="fax_modal_edit">
                          </div>
                          <div class="form-group">
                            <label for="formGroupExampleInput">Website</label>
                            <input type="text" class="form-control" value="<?= $dataSupplier['website'] ?>" name="website_modal_edit">
                          </div>
                      </div><!-- modal-body -->
                      <div class="modal-footer">
                        <button type="submit" name="btnEditSup" class="btn btn-primary tx-size-xs">Save changes</button>
                        <button type="button" class="btn btn-secondary tx-size-xs" data-dismiss="modal">Close</button>
                      </div>
                          </form>
                    </div>
                  </div><!-- modal-dialog -->
                </div><!-- modal -->

              </tr>
          </tbody>
        <?php } ?>
        </table>
      </div>

      <!-- LARGE MODAL -->
      <div id="modaldemooo3" class="modal fade">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Data Supplier</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body pd-20">
              <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" class="pure-form">
                <div class="form-group">
                  <label for="formGroupExampleInput">Nama Supplier</label>
                    <input type="hidden" class="form-control" name="id_modal_add">
                  <input type="text" class="form-control" name="nama_supplier_modal_add">
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput">Produk</label>
                    <input type="text" class="form-control" name="produk_modal_add">
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput">Brand</label>
                  <input type="text" class="form-control" name="brand_modal_add">
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput">Alamat Supplier</label>
                  <input type="text" class="form-control" name="alamat_modal_add">
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput">telepon</label>
                  <input type="text" class="form-control" name="telepon_modal_add">
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput">Fax</label>
                  <input type="text" class="form-control" name="fax_modal_add">
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput">Website</label>
                  <input type="text" class="form-control" name="website_modal_add">
                </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
              <button type="submit" name="btnAddSup" class="btn btn-primary tx-size-xs">Save changes</button>
              <button type="button" class="btn btn-secondary tx-size-xs" data-dismiss="modal">Close</button>
            </div>
                </form>
          </div>
        </div><!-- modal-dialog -->
      </div><!-- modal -->
    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->

</div><!-- br-mainpanel -->

<script src="lib/jquery-ui/ui/widgets/datepicker.js"></script>
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
<script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
<script src="js/tooltip-colored.js"></script>
<script src="js/popover-colored.js"></script>


<script>
  $(document).ready(function() {
    var t = $('#example').DataTable({
      aLengthMenu: [
        [25, 50, 75, 100],
        [25, 50, 75, "Semua"]
      ],
      iDisplayLength: 25,

      "language": {
        searchPlaceholder: 'Pencarian...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        lengthMenu: "Menampilkan _MENU_ data",
        zeroRecords: "Tidak ada data yang cocok dengan pencarian anda",
        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
        infoFiltered: "(Pencarian dari _MAX_ total data)",
      },

      "orderFixed": [2, 'asc'],
      scrollX: true,
      responsive: true,
      "columnDefs": [{
        "searchable": false,
        "orderable": true,
        "targets": 0
      }],
      "order": [
        [1, 'asc']
      ]
    });

    t.on('order.dt search.dt', function() {
      t.column(0, {
        search: 'applied',
        order: 'applied'
      }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

  });
</script>



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
  }, 4000);
</script>
