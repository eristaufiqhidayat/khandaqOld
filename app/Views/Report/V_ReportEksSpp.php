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
                            <h2>Data Pengeluaran SPP</h2>

                        </div>

                        <div class="card-body">
                            <center>
                                <form action="<?php echo base_url('index.php//ReportEks/pengeluaranSPP/' . $menuAktip . "/" . $moduleAktip) ?>" method="post">
                                    <label for="start">Pilih Bulan : &nbsp;&nbsp;&nbsp;</label>
                                    <input type="month" name="monthyear" value="<?php echo $monthyear; ?>">&nbsp;&nbsp;&nbsp;
                                    <button>Pilih Bulan</button>

                                </form>
                            </center>
                            <?php try {
                            ?>
                                <table id="example1" class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <th>Nama Sumber</th>
                                        <th>Total</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>SPP BULAN INI</td>
                                            <td><?= number_format(sumtransaksiperbulanPeriodeBefore($monthyear)["total"], 0); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php
                            } catch (Exception $e) {
                                echo '<font style="color:red">Pesan Error ',  $e->getMessage(), "</font>";
                            } ?>
                            <table id="example2" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <!-- <th width=100 scope="col"></th> -->
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Kode Akun</th>
                                        <th>Rutin/NonRutin</th>
                                        <th>Kode</th>
                                        <th width=35%>keterangan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($dataPengeluaran as $dataPengeluaranv) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $dataPengeluaranv['tanggal'] ?></td>
                                            <td><?php echo $dataPengeluaranv['kode_akun'] . "::" . $dataPengeluaranv['nama_akun'] ?></td>
                                            <td><?php echo $dataPengeluaranv['rutin'] ?></td>
                                            <td align=right><?php echo number_format($dataPengeluaranv['rp'], 0) ?></td>
                                            <td><?php echo $dataPengeluaranv['keterangan'] ?></td>
                                        </tr>
                                        <!-- /.modal edit -->


                                    <?php
                                        $no++;
                                    }
                                    ?>


                                </tbody>
                            </table>
                            <table id="example2" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <!-- <th width=100 scope="col"></th> -->
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Total Rutin</th>
                                        <th style="text-align:right"><?php echo $totalRutin['totalRutin']; ?></th>
                                        <th width=40%></th>
                                    </tr>
                                    <tr>
                                        <!-- <th width=100></th> -->
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Total NonRutin</th>
                                        <th style="text-align:right"><?php echo $totalNonRutin['totalNonRutin']; ?></th>
                                        <th width=40%></th>
                                    </tr>
                                    <tr>
                                        <!-- <th width=100></th> -->
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Total All</th>
                                        <th style="text-align:right"><?php echo $totalAll['totalAll']; ?></th>
                                        <th width=40%></th>
                                    </tr>
                                    <tr>
                                        <!-- <th width=100></th> -->
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Selisih</th>
                                        <th style="text-align:right"><?php echo sumtransaksiperbulan($monthyear, "TDSPP")["total"] - $totalAll['totalAll']; ?></th>
                                        <th width=40%></th>
                                    </tr>
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
            "searching": false,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "pageLength": 50,
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