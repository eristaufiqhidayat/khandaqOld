<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<!-- Content Wrapper. Contains page content -->
<?php
$session = \Config\Services::session();

$menuAktip = $menuAktip ?? '';
$moduleAktip = $moduleAktip ?? '';
$DataTransaksiTabungan = $DataTransaksiTabungan ?? [];
$dataKodeTransaksi = $dataKodeTransaksi ?? [];
$getKodeTransaksi = $getKodeTransaksi ?? '';

$total = 0;

if ($session->get('start_date') && $session->get('end_date')) {
    $start_date = $session->get('start_date');
    $end_date = $session->get('end_date');
} else {
    $start_date = date('Y-m-d');
    $end_date = date('Y-m-d');
}
?>
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
                            <h2>Data Mutasi Tabungan</h2>
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
                            <form action="<?php echo base_url('index.php/mutasi/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="post">
                                <label for="start">Pilih Start date: &nbsp;&nbsp;&nbsp;</label>
                                <input type="date" name="start_date" value="<?php echo $start_date; ?>">&nbsp;&nbsp;&nbsp;
                                <label for="end">End date: &nbsp;&nbsp;&nbsp;</label>
                                <input type="date" name="end_date" value="<?php echo $end_date; ?>">
                                <label for="start">Pilih Kode Transaksi : &nbsp;&nbsp;&nbsp;</label>
                                <select name="KodeTransaksi">
                                    <?php
                                    if (isset($dataKodeTransaksi)) {
                                        foreach ($dataKodeTransaksi as $DataKodeTransaksiList) {
                                            if (isset($getKodeTransaksi) &&  $getKodeTransaksi == $DataKodeTransaksiList['kode']) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }

                                    ?>
                                            <option value="<?php echo $DataKodeTransaksiList['kode']; ?>" <?= $selected ?>><?php echo $DataKodeTransaksiList['kode'] . "::" . $DataKodeTransaksiList['keterangan_kode']; ?></option>
                                    <?PHP }
                                    } ?>
                                </select>
                                <button>Pilih</button>

                            </form>
                        </div>
                        <!-- /.card-header -->
                        <?php $session = \Config\Services::session();
                        if ($session->getFlashdata('sukses')) { ?>
                            <p class="alert alert-success"><?php echo $session->getFlashdata('sukses'); ?></p>
                        <?php } ?>
                        <div class="card-body">
                            <table id="datatable" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">notransaksi</th>
                                        <th scope="col">Nama Siswa</th>
                                        <th scope="col">kode_tab_trans</th>
                                        <th scope="col">kode_trans</th>
                                        <th scope="col">tanggal</th>
                                        <th scope="col">rp</th>
                                        <th scope="col">keterangan_trans</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    foreach ($DataTransaksiTabungan as $DataMenuv) { ?>
                                        <tr>
                                            <td><?php echo $DataMenuv['notransaksi']; ?></td>
                                            <td><?php echo $DataMenuv['nama_siswa']; ?></td>
                                            <td><?php echo $DataMenuv['kode_tab_trans']; ?></td>
                                            <td><?php echo $DataMenuv['kodetransaksi']; ?></td>
                                            <td><?php echo $DataMenuv['tanggal']; ?></td>
                                            <td align="right"><?php echo number_format($DataMenuv['rp'], 0); ?></td>
                                            <td><?php echo $DataMenuv['keterangan_trans']; ?></td>

                                        </tr>
                                    <?php
                                        $total = $DataMenuv['rp'] + $total;
                                    }
                                    ?>
                                </tbody>
                                <tr>
                                    <td colspan=4>Total</td>
                                    <td align="right"><?= number_format($total, 0); ?></td>
                                    <td colspan=2></td>
                                </tr>

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
            "paging": false,
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