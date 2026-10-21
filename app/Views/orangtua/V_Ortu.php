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
                            <h2>Data Siswa</h2>
                        </div>
                        <div class="card-header">
                            <?php
                            if ($session->get('start_date') && $session->get('end_date')) {
                                $start_date = $session->get('start_date');
                                $end_date = $session->get('end_date');
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-9">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>
                                                <h5>Saldo Rp. <?php
                                                                if (isset($DetilSiswa)) {
                                                                    $saldo = ceksaldotabungan($DetilSiswa['id_siswa']);
                                                                    echo number_format((float)$saldo['SALDO'], 0, ',', '.');
                                                                }

                                                                ?>
                                                </h5>
                                            </td>
                                            <td bgcolor=#c6ff1a>
                                                <h5>Kredit Rp. <?php
                                                                if (isset($DetilSiswa)) {
                                                                    $saldo = cekkredittabungan($DetilSiswa['id_siswa']);
                                                                    echo number_format((float)$saldo['KREDIT'], 0, ',', '.');;
                                                                }

                                                                ?>
                                                </h5>
                                            </td>
                                            <td bgcolor=#ff8566>
                                                <h5>Debet Rp. <?php
                                                                if (isset($DetilSiswa)) {
                                                                    $saldo = cekdebettabungan($DetilSiswa['id_siswa']);
                                                                    echo number_format((float)$saldo['DEBET'], 0, ',', '.');;
                                                                }

                                                                ?>
                                                </h5>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <?php $session = \Config\Services::session();
                        if ($session->getFlashdata('sukses')) { ?>
                            <p class="alert alert-success"><?php echo $session->getFlashdata('sukses'); ?></p>
                        <?php } ?>
                        <?php if (isset($DataTabunganSiswa)) {
                        ?>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">

                                        <div class="card card-primary card-outline">
                                            <div class="card-body box-profile">

                                                <div class="text-center">
                                                    <img class="profile-user-img img-fluid img-circle" src="data:image/png;base64,<?php if (isset($DetilSiswa['image'])) echo $DetilSiswa['image']; ?>" alt="User profile picture">
                                                </div>
                                                <h3 class="profile-username text-center"><?php echo $DetilSiswa['nama_siswa']; ?></h3>
                                                <p class="text-muted text-center">Siswa Arafah</p>
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>Alamat</b> <a class="float-right"><?php echo $DetilSiswa['alamat_siswa']; ?></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Nis</b> <a class="float-right"><?php echo $DetilSiswa['nis']; ?></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Kelas</b> <a class="float-right"><?php echo $DetilSiswa['nama_kelas']; ?></a>
                                                    </li>
                                                </ul>
                                                <a href="#" class="btn btn-primary btn-block"><b>Detil</b></a>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-primary card-tabs">
                                                        <div class="card-header p-0 pt-1">
                                                            <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" id="custom-tabs-five-overlay-tab" data-toggle="pill" href="#custom-tabs-five-overlay" role="tab" aria-controls="custom-tabs-five-overlay" aria-selected="true">Transaksi All</a>
                                                                </li>
                                                                <!-- <li class="nav-item">
                                                                    <a class="nav-link" id="custom-tabs-five-overlay-dark-tab" data-toggle="pill" href="#custom-tabs-five-overlay-dark" role="tab" aria-controls="custom-tabs-five-overlay-dark" aria-selected="false">Debit SPP <?= $tahunAjaran ?> </a>
                                                                </li> -->
                                                                <!-- <li class="nav-item">
                                                                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#custom-tabs-five-normal" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Debit Loundry <?= $tahunAjaran ?></a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#custom-tabs-five-normal2" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Debit Kesehatan <?= $tahunAjaran ?></a>
                                                                </li> -->
                                                            </ul>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="tab-content" id="custom-tabs-five-tabContent">
                                                                <div class="tab-pane fade active show" id="custom-tabs-five-overlay" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-tab">
                                                                    <div class="overlay-wrapper">
                                                                        <table id=example1 class="table table-striped table-bordered table-sm">
                                                                            <thead>
                                                                                <tr>
                                                                                    <!-- <th width=100 scope="col"></th> -->
                                                                                    <th scope="col">No</th>
                                                                                    <th scope="col">Kode Tabungan</th>
                                                                                    <th scope="col">Tanggal</th>
                                                                                    <th scope="col">Kode</th>
                                                                                    <th scope="col">Debit</th>
                                                                                    <th scope="col">Kredit</th>
                                                                                    <th scope="col">Saldo</th>
                                                                                    <th scope="col" width=25%>Keterangan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $i = 1;
                                                                                $kredit = "";
                                                                                $debit = "";
                                                                                $saldo = "";
                                                                                foreach ($DataTabunganSiswa as $DataMenuv) { ?>
                                                                                    <tr>

                                                                                        <td><?php echo $i;
                                                                                            $i++; ?></td>
                                                                                        <td><?php echo $DataMenuv['kode_tab_trans']; ?></td>
                                                                                        <td><?php echo $DataMenuv['tanggal']; ?></td>
                                                                                        <td><?php echo $DataMenuv['kodetransaksi']; ?></td>
                                                                                        <?php
                                                                                        if ($DataMenuv['kode_tran'] == "K") {
                                                                                            $kredit = $DataMenuv['rp'];
                                                                                        } else {
                                                                                            $kredit = "";
                                                                                        }
                                                                                        if ($DataMenuv['kode_tran'] == "D") {
                                                                                            $debit = $DataMenuv['rp'];
                                                                                        } else {
                                                                                            $debit = "";
                                                                                        }
                                                                                        if ($debit) $debitv = number_format((float)$debit, 0, ',', '.');
                                                                                        else $debitv = "";
                                                                                        if ($kredit) $kreditv = number_format((float)$kredit, 0, ',', '.');
                                                                                        else $kreditv = "";
                                                                                        ?>

                                                                                        <td align=right><?php echo  $debitv; ?></td>
                                                                                        <td align=right><?php echo  $kreditv; ?></td>
                                                                                        <?php
                                                                                        if (!$kredit) {
                                                                                            //$kredit = 0;
                                                                                            $saldo = floatval($saldo) - floatval($debit);
                                                                                        }
                                                                                        if (!$debit) {
                                                                                            //$debit = 0;
                                                                                            $saldo = floatval($saldo) + floatval($kredit);
                                                                                        }

                                                                                        ?>
                                                                                        <td align=right><?php echo number_format($saldo, 0, ',', '.'); ?></td>
                                                                                        <td><?php echo $DataMenuv['keterangan_trans']; ?></td>

                                                                                    </tr>

                                                                                    <!-- Modal Edit  -->

                                                                                    <!-- /Modal Delete -->

                                                                                <?php } ?>
                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="custom-tabs-five-overlay-dark" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-dark-tab">
                                                                    <div class="overlay-wrapper">
                                                                        <table class="table table-striped table-bordered table-sm">
                                                                            <thead>
                                                                                <tr>
                                                                                    <!-- <th width=100 scope="col"></th> -->
                                                                                    <th scope="col">No</th>
                                                                                    <th scope="col">Kode Tabungan</th>
                                                                                    <th scope="col">Tanggal</th>
                                                                                    <th scope="col">Kode</th>
                                                                                    <th scope="col">Debit</th>
                                                                                    <th scope="col" width=25%>Keterangan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $i = 1;
                                                                                foreach ($dataDebitSpp as $DataMenuv) { ?>
                                                                                    <tr>
                                                                                        <td><?php echo $i;
                                                                                            $i++; ?></td>
                                                                                        <td><?php echo $DataMenuv['kode_tab_trans']; ?></td>
                                                                                        <td><?php echo $DataMenuv['tanggal']; ?></td>
                                                                                        <td><?php echo $DataMenuv['kodetransaksi']; ?></td>
                                                                                        <td align=right><?php echo number_format((float)$DataMenuv['rp'], 0, ',', '.'); ?></td>
                                                                                        <td><?php echo $DataMenuv['keterangan_trans']; ?></td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="custom-tabs-five-normal" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                                                    <table class="table table-striped table-bordered table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <!-- <th width=100 scope="col"></th> -->
                                                                                <th scope="col">No</th>
                                                                                <th scope="col">Kode Tabungan</th>
                                                                                <th scope="col">Tanggal</th>
                                                                                <th scope="col">Kode</th>
                                                                                <th scope="col">Debit</th>
                                                                                <th scope="col" width=25%>Keterangan</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $i = 1;
                                                                            foreach ($dataDebitLdr as $DataMenuv) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i;
                                                                                        $i++; ?></td>
                                                                                    <td><?php echo $DataMenuv['kode_tab_trans']; ?></td>
                                                                                    <td><?php echo $DataMenuv['tanggal']; ?></td>
                                                                                    <td><?php echo $DataMenuv['kodetransaksi']; ?></td>
                                                                                    <td align=right><?php echo number_format((float)$DataMenuv['rp'], 0, ',', '.'); ?></td>
                                                                                    <td><?php echo $DataMenuv['keterangan_trans']; ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="tab-pane fade" id="custom-tabs-five-normal2" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                                                    <table class="table table-striped table-bordered table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <!-- <th width=100 scope="col"></th> -->
                                                                                <th scope="col">No</th>
                                                                                <th scope="col">Kode Tabungan</th>
                                                                                <th scope="col">Tanggal</th>
                                                                                <th scope="col">Kode</th>
                                                                                <th scope="col">Debit</th>
                                                                                <th scope="col" width=25%>Keterangan</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $i = 1;
                                                                            foreach ($dataDebitKes as $DataMenuv) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i;
                                                                                        $i++; ?></td>
                                                                                    <td><?php echo $DataMenuv['kode_tab_trans']; ?></td>
                                                                                    <td><?php echo $DataMenuv['tanggal']; ?></td>
                                                                                    <td><?php echo $DataMenuv['kodetransaksi']; ?></td>
                                                                                    <td align=right><?php echo number_format((float)$DataMenuv['rp'], 0, ',', '.'); ?></td>
                                                                                    <td><?php echo $DataMenuv['keterangan_trans']; ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?>
                                    </div>
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
    function cek_null_entrikredit() {
        var x = document.forms["modalEntriKredit"]["tanggal"].value;
        var y = document.forms["modalEntriKredit"]["rp"].value;
        if (x == "") {
            alert("Tanggal harus diisi");
            return false;
        }
        if (y == "") {
            alert("rupiah harus diisi");
            return false;
        }


    }

    function cek_null_entridebet() {
        var x = document.forms["modalEntriDebet"]["tanggal"].value;
        var y = document.forms["modalEntriDebet"]["rp"].value;
        if (x == "") {
            alert("Tanggal harus diisi");
            return false;
        }
        if (y == "") {
            alert("rupiah harus diisi");
            return false;
        }
    }
</script>
<script>
    function sppBulan() {
        var jml = 0;

        for (var i = 1; i <= 12; i++) {
            if (document.getElementsByName("sppbulan" + i)[0].type == 'checkbox' &&
                document.getElementsByName("sppbulan" + i)[0].checked == true &&
                document.getElementsByName("sppbulan" + i)[0].disabled == false) {
                jml = parseInt(jml) + parseInt(document.getElementsByName("sppbulan" + i)[0].value);
            }
        }
        jml = parseInt(document.getElementsByName("rp")[0].value) - parseInt(jml);
        return jml;

    }

    function cekangka(str) {
        return Boolean(str.match(/^[0-9]*$/));
    }

    function cekJml() {
        var jml = sppBulan();
        if (!document.forms["modalEntriKredit"]["tanggal"].value) {
            alert("Tanggal Harus diisi");
            return false;
        }
        if (!document.forms["modalEntriKredit"]["rp"].value) {
            alert("Rupiah Harus diisi");
            return false;
        }
        if (!cekangka(document.getElementsByName("rp")[0].value)) {
            alert("harus angka");
            return false;
        }
        if (jml < 0) {
            alert("Nilai Rupiah yang dimasukan kurang dari total SPP");
            return false;
        }
    }
</script>

<script>
    $(function() {
        $('#checklistspp').hide();
        $('#savespp1').hide();
        $('#KKodeTransaksi').change(function() {
            if ($('#KKodeTransaksi').val() == 'TKSPP') {
                $('#checklistspp').show();
                $('#savespp1').show();
                $('#savenonspp1').hide();
            } else {
                $('#checklistspp').hide();
                $('#savespp1').hide();
                $('#savenonspp1').show();
            }
        });
    })
</script>
<?php if (!isset($DataTabunganSiswa)) { ?>
    <script>
        $('#myModal').modal({
            show: true
        })
    </script>
<?php } ?>
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
            "paging": false,
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