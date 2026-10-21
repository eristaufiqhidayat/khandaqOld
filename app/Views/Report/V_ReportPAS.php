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
                            <h2>Report PAS <?= $tahunAjar ?></h2>

                        </div>

                        <div class="card-body">
                            <br>
                            <table id="example1" class="table table-striped table-bordered table-sm">
                                <tr>
                                    <td>Toal Pendapatan PAS</td>
                                    <td align=right><?= number_format(isset($sumPAS[0]["jml"]), 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>Toal Pengeluaran PAS</td>
                                    <td align=right><?= number_format(isset($sumpengeluaranPAS[0]["jml"]), 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>Saldo</td>
                                    <td align=right><?= number_format(isset($sumPAS[0]["jml"]) -isset($sumpengeluaranPAS[0]["jml"]), 0, ',', '.') ?></td>
                                </tr>
                            </table>
                            <table id="example1" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <!-- <th width=100 scope="col"></th> -->
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Nama Kelas</th>
                                        <th>Jul</th>
                                        <th>Aug</th>
                                        <th>Sep</th>
                                        <th>Oct</th>
                                        <th>Nov</th>
                                        <th>Dec</th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>Mei</th>
                                        <th>Jun</th>
                                        <th>Total</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($dataPAS as $dataPASv) {
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?php echo $dataPASv['nama_siswa'] ?></td>
                                            <td><?php echo $dataPASv['nama_kelas'] ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Jul'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Aug'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Sep'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Oct'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Nov'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Des'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Jan'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Feb'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Mar'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Apr'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Mei'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['Jun'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataPASv['jml'], 0, ',', '.') ?></td>
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
    function ceknull() {
        let tanggal = document.forms["modalEntri"]["tanggal"].value;
        let rp = document.forms["modalEntri"]["rp"].value;
        if (rp == "") {
            alert('Rupiah Harus di isi');
            document.forms["modalEntri"]["rp"].focus();
            return false;
        }
        if (tanggal == "") {
            alert('tanggal Harus di isi');
            document.forms["modalEntri"]["tanggal"].focus();
            return false;
        }
    }

    function ceknullUpdate() {
        let tanggal = document.forms["modalUpdate"]["tanggal"].value;
        let rp = document.forms["modalUpdate"]["rp"].value;
        if (rp == "") {
            alert('Rupiah Harus di isi');
            document.forms["modalUpdate"]["rp"].focus();
            return false;
        }
        if (tanggal == "") {
            alert('tanggal Harus di isi');
            document.forms["modalUpdate"]["tanggal"].focus();
            return false;
        }
    }
</script>
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
            "paging": false,
            "info": false,
            "pageLength": 200,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
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
        $('#example3').DataTable({
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