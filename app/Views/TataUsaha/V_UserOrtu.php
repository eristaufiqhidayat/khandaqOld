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
    <?php if (session('error')) : ?>
        <div class="alert alert-danger">
            <?= session('error') ?>
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        </div>
    <?php endif ?>
    <?php if (session('msg')) : ?>
        <div class="alert alert-success">
            <?= session('msg') ?>
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        </div>
    <?php endif ?>
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
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form name=tambahData action="<?php echo base_url('index.php/TataUsaha/UserOrtu/tambah/' . $menuAktip . "/" . $moduleAktip) ?>" onsubmit="return cekemail();" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Nama Orang Tua</span>
                                                    <input name="nama_orangtua" type="text" class="form-control" id="recipient-name" value="">
                                                </div>

                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Alamat</span>
                                                    <input name="alamat_orangtua" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Telp</span>
                                                    <input name="telpon_orangtua" type="text" class="form-control" id="recipient-name" value="">
                                                    <span class="input-group-text" id="basic-addon3">Status Keluarga</span>
                                                    <input name="status_keluarga" type="text" class="form-control" id="recipient-name" value="">
                                                    <span class="input-group-text" id="basic-addon3">Jenis Kelamin</span>
                                                    <input name="kelamin" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Pekerjaan</span>
                                                    <input name="pekerjaan" type="text" class="form-control" id="recipient-name" value="">
                                                    <span class="input-group-text" id="basic-addon3">Email</span>
                                                    <input name="email" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">photo</span>
                                                    <input name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">User Name</span>
                                                    <input name="username" type="text" class="form-control" id="recipient-name" value="">
                                                    <span class="input-group-text" id="basic-addon3">password_hash</span>
                                                    <input name="password_hash" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" onclick="return cekusername();">save</button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalTambah" data-whatever="@mdo"><i class="fas fa-folder-plus"> Create UserName</i></button>
                            </p>
                            <table id="example1" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th width=100 scope="col"></th>
                                        <th scope="col">id</th>
                                        <th scope="col">Nama Orang Tua</th>
                                        <th scope="col">username</th>
                                        <th scope="col">Nama Siswa</th>
                                        <th>Alamat</th>
                                        <th>No Telp</th>
                                        <th>Status Keluarga</th>
                                        <th>Kelamin</th>
                                        <th>pekerjaan</th>
                                        <th scope="col">ListSiswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($DataMenu as $DataMenuv) { ?>
                                        <tr>
                                            <td>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#Modal<?= $DataMenuv['id_orangtua']; ?>" type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
                                                <button class="btn btn-primary btn-danger" data-toggle="modal" data-target="#ModalDelete<?php echo $DataMenuv['id_orangtua']; ?>" type="button" class="btn btn-primary"><i class="fas fa-trash"></i></button>
                                            </td>
                                            <td><?php echo $DataMenuv['id_orangtua']; ?></td>
                                            <td><?php echo $DataMenuv['nama_orangtua']; ?></td>
                                            <td><?php echo $DataMenuv['username']; ?></td>
                                            <td><?= $DataMenuv['nama_siswa']; ?></td>
                                            <td><?= $DataMenuv['alamat_orangtua']; ?></td>
                                            <td><?= $DataMenuv['telpon_orangtua']; ?></td>
                                            <td><?= $DataMenuv['status_keluarga']; ?></td>
                                            <td><?= $DataMenuv['kelamin']; ?></td>
                                            <td><?= $DataMenuv['pekerjaan']; ?></td>
                                            <td>
                                                <form action="<?= base_url('index.php/TataUsaha/UserOrtu/aksesSiswa/' . $menuAktip . "/" . $moduleAktip) ?>">
                                                    <input type="hidden" name="username" value="<?= $DataMenuv['username'] ?>" ?>
                                                    <input type="hidden" name="alamat_orangtua" value="<?= $DataMenuv['alamat_orangtua'] ?>" ?>
                                                    <input type="hidden" name="email" value="<?= $DataMenuv['email'] ?>" ?>
                                                    <input type="hidden" name="status_keluarga" value="<?= $DataMenuv['status_keluarga'] ?>" ?>
                                                    <button type=submit class="btn btn-primary"><i class="fas fa-search"></i>List siswa</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit  -->
                                        <div class="modal fade" id="Modal<?php echo $DataMenuv['id_orangtua']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Data Siswa</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?php echo base_url('index.php/TataUsaha/UserOrtu/edit/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                            <?= csrf_field() ?>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">id</span>
                                                                <input name="id_orangtua" type="text" class="form-control" id="recipient-name" value="<?= $DataMenuv['id_orangtua'] ?>">
                                                                <span class="input-group-text" id="basic-addon3">Nama Orang Tua</span>
                                                                <input name="nama_orangtua" type="text" class="form-control" id="recipient-name" value="<?= $DataMenuv['nama_orangtua'] ?>">
                                                            </div>

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Alamat</span>
                                                                <input name="alamat_orangtua" type="text" class="form-control" id="recipient-name" value="<?= $DataMenuv['alamat_orangtua'] ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Telp</span>
                                                                <input name="telpon_orangtua" type="text" class="form-control" id="recipient-name" value="<?= $DataMenuv['telpon_orangtua'] ?>">
                                                                <span class="input-group-text" id="basic-addon3">Status Keluarga</span>
                                                                <input name="status_keluarga" type="text" class="form-control" id="recipient-name" value="<?= $DataMenuv['status_keluarga'] ?>">
                                                                <span class="input-group-text" id="basic-addon3">Jenis Kelamin</span>
                                                                <input name="kelamin" type="text" class="form-control" id="recipient-name" value="<?= $DataMenuv['kelamin'] ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Pekerjaan</span>
                                                                <input name="pekerjaan" type="text" class="form-control" id="recipient-name" value="<?= $DataMenuv['pekerjaan'] ?>">
                                                                <span class="input-group-text" id="basic-addon3">Email</span>
                                                                <input name="email" type="text" class="form-control" id="recipient-name" value="<?= $DataMenuv['email'] ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">photo</span>
                                                                <input name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="form-control" id="recipient-name" value="">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">User Name</span>
                                                                <input name="username" type="text" class="form-control" id="recipient-name" value="<?= $DataMenuv['username'] ?>">
                                                                <span class="input-group-text" id="basic-addon3">password_hash</span>
                                                                <input name="password_hash" type="text" class="form-control" id="recipient-name" value="">
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
                                        <div class="modal fade" id="ModalDelete<?php echo $DataMenuv['id_orangtua']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete Username</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body danger">
                                                        <form action="<?php echo base_url('index.php/TataUsaha/UserOrtu/delete/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">username</span>
                                                                <input name="username" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['username']; ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">ID Orangtua</span>
                                                                <input name="id_orangtua" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['id_orangtua']; ?>">
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
<?php
$husername = rowUsers();
$username = "";
foreach ($husername as $usernamek => $usernamev) {
    $username .= "{name:\"" . $usernamev['username'] . "\",email:\"" . $usernamev['email'] . "\"},";
}
$username = substr($username, 0, -1);
?>
<script>
    const array = [<?= $username ?>];

    function cekusername() {
        const username = array.find(({
            name
        }) => name === document.forms["tambahData"]["username"].value);
        if (username['name']) {
            alert("User name Sudah ada ");
            return false;
        }
    }

    function cekemail() {
        const cekemail = array.find(({
            email
        }) => email === document.forms["tambahData"]["email"].value);
        if (cekemail['email']) {
            alert("Email Sudah Ada");
            return false;
        }
    }
</script>
<script>
    $(function() {
        $("#modalShow").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "paging": true,
        });
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
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