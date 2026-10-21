<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<form action="<?php echo base_url('index.php/TataUsaha/UserOrtu/aksesSiswaDo/' . $menuAktip . "/" . $moduleAktip) ?>" method="post">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Data Akses Orangtua</h2>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">save</button>
                </div>
                <div class="card-header">
                    <h5>Data Orangtua</h5>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-4">Id</div>
                        <div class="col-6"><?= $DataMenu['id_orangtua'] ?></div>
                        <input name=id_orangtua value=<?= $DataMenu['id_orangtua'] ?> type=hidden>
                        <div class="col-4">Nama Orang Tua</div>
                        <div class="col-6"><?= $DataMenu['nama_orangtua'] ?></div>
                        <div class="col-4">Alamat</div>
                        <div class="col-6"><?= $DataMenu['alamat_orangtua'] ?></div>
                        <div class="col-4">Status Keluarga</div>
                        <div class="col-6"><?= $DataMenu['status_keluarga'] ?></div>
                        <div class="col-4">Email</div>
                        <div class="col-6"><?= $DataMenu['email'] ?></td>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <h2></h2>
                </div><br>
                <div class="card-header">
                    <h5>Data Siswa</h5>
                </div>
                <table id="example2" class="table table-striped table-bordered table-lg">
                    <thead>
                        <tr>
                            <th scope="col">id siswa</th>
                            <th scope="col">Nama siswa</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Cek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($DataSiswa as $DataSiswak => $DataSiswav) { ?>
                            <tr>
                                <td><?= $DataSiswav['id_siswa'] ?></td>
                                <td><?= $DataSiswav['nama_siswa'] ?></td>
                                <td><?= $DataSiswav['alamat_siswa'] ?></td>
                                <td><input name=cid_siswa value=<?= $DataSiswav['id_siswa'] ?> type=radio></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </section>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/sparklines/sparkline.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/moment/moment.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
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
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>
<!-- Page specific script -->
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