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
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div><!-- /.col -->
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
              <h2>Edit Data User</h2>
            </div>
            <!-- /.card-header -->
            <?php $session = \Config\Services::session();
            if ($session->getFlashdata('sukses')) { ?>
              <p class="alert alert-success"><?php echo $session->getFlashdata('sukses'); ?></p>
            <?php } ?>
            <div class="card-body">

              <div class="modal fade" id="ModalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Data Permission group</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php
                    $groupAkses = array();
                    foreach ($groupPermission as $groupPermissionD) {
                      $groupAkses[$groupPermissionD['group_id']][$groupPermissionD['permission_id']] = $groupPermissionD['permission_id'];
                    }
                    ?>
                    <div class="modal-body">
                      <form action="<?php echo base_url('index.php/permissionGroups/tambah/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <table class="table table-striped table-bordered table-sm">
                          <tr>
                            <th>
                              Nama Group
                            </th>
                            <?php foreach ($permission as $jpermission) { ?>
                              <th><?php echo $jpermission['id']; ?></th>
                            <?php } ?>
                          </tr>
                          <?php foreach ($group as $jgroup) { ?>
                            <tr>
                              <td>

                                <label><?php echo $jgroup['description']; ?></label>

                              </td>
                              <?php
                              $checked = "";
                              foreach ($permission as $jpermission) {
                                if (isset($groupAkses[$jgroup['id']][$jpermission['id']])) {
                                  if ($groupAkses[$jgroup['id']][$jpermission['id']] == $jpermission['id']) {
                                    $checked = " readonly checked";
                                  } else {
                                    $checked = "";
                                  }
                                } else {
                                  $checked = "";
                                }
                              ?>
                                <td>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="group_id[<?php echo $jgroup['id']; ?>][<?php echo $jpermission['id']; ?>]" value="<?php echo $jpermission['id']; ?>" id="customCheckbox<?php echo $jgroup['id'] . $jpermission['id']; ?>" <?php echo $checked; ?>>
                                    <label for="customCheckbox<?php echo $jgroup['id'] . $jpermission['id']; ?>" class="custom-control-label"><?php echo $jpermission['description']; ?></label>
                                  </div>
                                </td>
                              <?php } ?>
                            </tr>
                          <?php } ?>
                        </table>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button class="btn btn-primary"><i class="fas fa-save"> Save</i></button>
                        </div>
                      </form>
                    </div>

                  </div>
                </div>
              </div>
              <p>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalTambah" data-whatever="@mdo"><i class="fas fa-key">Edit Permission Group</i>
                </button>
              </p>
              <table id="example1" class="table table-striped table-bordered table-sm">
                <thead>
                  <tr>
                    <th scope="col">auth_permissions_id</th>
                    <th scope="col">auth_groups_name</th>
                    <th scope="col">auth_permissions_description</th>
                    <!-- <th scope="col">COCOK</th> -->

                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($DataMenu as $DataMenuv) { ?>
                    <tr>
                      <td><?php echo $DataMenuv['auth_permissions_id']; ?></td>
                      <td><?php echo $DataMenuv['auth_groups_name']; ?></td>
                      <td><?php echo $DataMenuv['auth_permissions_description']; ?></td>



                    </tr>
                    <!-- Modal Edit  -->
                    <div class="modal fade" id="Modal<?php echo $DataMenuv['auth_permissions_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Data Siswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?php echo base_url('index.php/menu/edit/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">id_menu</span>
                                <input name="id_menu" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['auth_permissions_id']; ?>">
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
                    <div class="modal fade" id="ModalDelete<?php echo $DataMenuv['auth_permissions_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Data User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body danger">
                            <form action="<?php echo base_url('index.php/groups/delete/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">id_menu</span>
                                <input name="id_menu" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['auth_permissions_id']; ?>">
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
<!-- <script src="<?php //echo base_url(); 
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