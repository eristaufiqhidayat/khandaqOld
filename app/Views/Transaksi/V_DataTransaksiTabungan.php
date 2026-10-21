<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">

      <div class="row mb-2">
        <!--
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
        -->
        <!-- /.col -->
        <!--
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
          -->
        <!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h2>Data Transaksi Tabungan</h2>
            </div>
            <div class="card-header">
              <?php
              if ($session->get('start_date') && $session->get('end_date')) {
                $start_date = $session->get('start_date');
                $end_date = $session->get('end_date');
              } else {
                $start_date =  date('Y-m-d');
                $end_date = date('Y-m-d');
              }
              ?>
              <form action="<?php echo base_url('index.php/transaksi/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="post">
                <label for="start">Pilih Start date: &nbsp;&nbsp;&nbsp;</label>
                <input type="date" name="start_date" value="<?php echo $start_date; ?>">&nbsp;&nbsp;&nbsp;
                <label for="end">End date: &nbsp;&nbsp;&nbsp;</label>
                <input type="date" name="end_date" value="<?php echo $end_date; ?>">&nbsp;&nbsp;&nbsp;
                <label for="end">ID Siswa: &nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="id_siswa">
                <button class="btn btn-primary" data-toggle="modal" data-target="#ModalAllert">Search</button>
              </form>
            </div>
            <!-- /.card-header -->
            <?php $session = \Config\Services::session();
            if ($session->getFlashdata('sukses')) { ?>
              <p class="alert alert-success"><?php echo $session->getFlashdata('sukses'); ?></p>
            <?php } ?>
            <div class="card-body">

              <div class="modal fade" id="ModalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Tambah Data Menu</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="<?php echo base_url('index.php/menu/tambah/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon3">id_menu</span>
                          <input name="id_menu" type="text" class="form-control" id="recipient-name" value="">
                        </div>

                        <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon3">id_module</span>
                          <input name="id_module" type="text" class="form-control" id="recipient-name" value="">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon3">Nama Menu</span>
                          <input name="menu" type="text" class="form-control" id="recipient-name" value="">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon3">Path</span>
                          <input name="path" type="text" class="form-control" id="recipient-name" value="">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon3">icon</span>
                          <input name="icon" type="text" class="form-control" id="recipient-name" value="">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">save</button>
                        </div>
                      </form>

                    </div>

                  </div>
                </div>
              </div>
              <p>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalTambah" data-whatever="@mdo"><i class="fas fa-plus"></i> New Data</button>
              </p>

              <table id="datatable" class="table table-striped table-bordered table-sm">
                <thead>
                  <tr>
                    <th width=100 scope="col"></th>
                    <th scope="col">notransaksi</th>
                    <th scope="col">kode_tab_trans</th>
                    <th scope="col">kode_trans</th>
                    <th scope="col">tanggal</th>
                    <th scope="col">rp</th>
                    <th scope="col">keterangan_trans</th>
                    <th scope="col">spp</th>
                    <th scope="col">buktitransfer</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Nama Siswa</th>

                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($DataTransaksiTabungan as $DataMenuv) { ?>
                    <tr>
                      <td>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#Modal<?php echo $DataMenuv['notransaksi']; ?>" type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-primary btn-danger" data-toggle="modal" data-target="#ModalDelete<?php echo $DataMenuv['notransaksi']; ?>" type="button" class="btn btn-primary"><i class="fas fa-trash"></i></button>
                      </td>
                      <td><?php echo $DataMenuv['notransaksi']; ?></td>
                      <td><?php echo $DataMenuv['kode_tab_trans']; ?></td>
                      <td><?php echo $DataMenuv['kodetransaksi']; ?></td>
                      <td><?php echo $DataMenuv['tanggal']; ?></td>
                      <td><?php echo $DataMenuv['rp']; ?></td>
                      <td><?php echo $DataMenuv['keterangan_trans']; ?></td>
                      <td><?php echo $DataMenuv['spp']; ?></td>
                      <td><?php echo $DataMenuv['buktitransfer']; ?></td>
                      <td><?php echo $DataMenuv['nama_kelas']; ?></td>
                      <td><?php echo $DataMenuv['nama_siswa']; ?></td>

                    </tr>
                    <!-- Modal Edit  -->
                    <div class="modal fade" id="Modal<?php echo $DataMenuv['notransaksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Data Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?php echo base_url('index.php/transaksi/edit/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">No Transaksi</span>
                                <input name="notransaksi" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['notransaksi']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">kode_tab_trans</span>
                                <input name="kode_tab_trans" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['kode_tab_trans']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">kodetransaksi</span>
                                <input name="kodetransaksi" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['kodetransaksi']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">tanggal</span>
                                <input name="tanggal" type="datetime-local" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['tanggal']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">Rp</span>
                                <input name="rp" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['rp']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">keterangan_trans</span>
                                <input name="keterangan_trans" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['keterangan_trans']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">spp</span>
                                <input name="spp" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['spp']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">buktitransfer</span>
                                <input name="buktitransfer" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['buktitransfer']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">tahunajaran</span>
                                <input name="tahunajaran" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['tahunajaran']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <input name="start_date" type="hidden" value="<?php echo $start_date; ?>">
                                <input name="end_date" type="hidden" value="<?php echo $end_date; ?>">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary"><i class="fas fa-save"> Save</i></button>
                              </div>
                            </form>
                          </div>

                        </div>
                      </div>
                    </div>
                    <!-- /Modal Delete -->
                    <div class="modal fade" id="ModalDelete<?php echo $DataMenuv['notransaksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Data Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body danger">
                            <form action="<?php echo base_url('index.php/transaksi/delete/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">No Transaksi</span>
                                <input name="notransaksi" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['notransaksi']; ?>">
                                <input name="start_date" type="hidden" value="<?php echo $start_date; ?>">
                                <input name="end_date" type="hidden" value="<?php echo $end_date; ?>">
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary btn-danger"><i class="fas fa-trash"> Delete</i></button>
                              </div>
                            </form>
                          </div>

                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo BPATH; ?>/asset/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo BPATH; ?>/asset/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo BPATH; ?>/asset/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo BPATH; ?>/asset/plugins/moment/moment.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo BPATH; ?>/asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo BPATH; ?>/asset/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo BPATH; ?>/asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>

<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php //echo BPATH; 
                  ?>/asset/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>
<!-- Page specific script -->
<script>
  $('#modalButton').click(function() {
    $('#modal').modal('show')
      .find('#modalContent')
      .load($(this).attr('value'));
  });
</script>
<script>
  $(function() {
    $("#datatable").DataTable({
      "responsive": true,
      "autoWidth": false,
      "paging": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');;
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "paging": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      //"destroy":true,
    });
  });
</script>
<?= $this->endSection() ?>