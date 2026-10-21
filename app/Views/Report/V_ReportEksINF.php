<?= $this->extend('Views\layout.php') ?>


<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <center>
                                <form action="<?php echo base_url('index.php/ReportEks/INF/' . $menuAktip . "/" . $moduleAktip) ?>" method="post">
                                    <label for="start">Pilih Bulan : &nbsp;&nbsp;&nbsp;</label>
                                    <input type="month" name="monthyear" value="<?php echo $monthyear; ?>">&nbsp;&nbsp;&nbsp;
                                    <button>Pilih Bulan</button>

                                </form>
                            </center>
                            <h2>Report Infak</h2>

                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Pemasukan Infak (Year-Month)</th>
                                        <th>Rp</th>
                                        <th>Sudah Dibayar Rp</th>
                                        <th>Tanggal Bayar</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $totalpengeluaran = 0;
                                    foreach ($dataInf as $dataInfakv) {
                                    ?>
                                        <tr>
                                            <td><?= $monthyear ?></td>
                                            <td align=right><?= number_format($dataInfakv['jml'], 0) ?></td>
                                            <td align=right></td>
                                            <td align=right></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                            <table id="datatable2" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Rp</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($rowdataInf as $rowdataInfv) {
                                    ?>
                                        <tr>
                                            <td align=Left><?= $no ?></td>
                                            <td align=Left><?= $rowdataInfv['nama_siswa'] ?></td>
                                            <td align=right><?= number_format($rowdataInfv['rp'], 0) ?></td>
                                            <td align=right><?= $rowdataInfv['tanggal'] ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>



<?= $this->section('javascript') ?>


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
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>


<script>
    $('#modalButton').click(function() {
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
</script>
<script>
    $(function() {
        $('#datatable').DataTable({
            "paging": false,
            "lengthChange": false,
            "pageLength": 50,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "responsive": true,
            //"destroy":true,
        });
        $('#datatable2').DataTable({
            "paging": false,
            "lengthChange": false,
            "pageLength": 50,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "responsive": true,
            //"destroy":true,
        });
    });
</script>
<?= $this->endSection() ?>