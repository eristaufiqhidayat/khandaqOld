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
                            <h2>Data Kelas Siswa</h2>

                        </div>

                        <div class="card-body">
                            <!-- <p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalNewData"><i class="fas fa-plus"></i> New Data</button>
                            </p> -->
                            <center>
                                <form id="formkelas" action="<?php echo base_url('index.php/TataUsaha/Kelas/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="post">
                                    <!-- <label for="start">Pilih Periode : &nbsp;&nbsp;&nbsp;</label>
                                    <select name=id_periode>
                                        <?php
                                        foreach ($dataPeriode as $dataPeriodev) { ?>
                                            <?php if ($id_periode == $dataPeriodev['id_periode']) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            } ?>
                                            <option value="<?php echo $dataPeriodev['id_periode'] ?>" <?php echo $selected ?>><?php echo $dataPeriodev['tahun_ajaran'] . "::" . $dataPeriodev['nama_semester'] . ":: [Active=" . $dataPeriodev['status_aktif'] . "]"; ?></option>
                                        <?php
                                        } ?>
                                    </select> -->
                                    <label for="start">Pilih Kelas : &nbsp;&nbsp;&nbsp;</label>
                                    <select name=id_kelas id=idid_kelas>
                                        <option value="">Semua Kelas</option>
                                        <?php
                                        foreach ($dataKelas as $dataKelasv) { ?>
                                            <?php if ($id_kelas == $dataKelasv['id_kelas']) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            } ?>
                                            <option value="<?php echo $dataKelasv['id_kelas'] ?>" <?php echo $selected ?>><?php echo $dataKelasv['nama_kelas']; ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                    <!-- <button type="submit">Pilih Kelas</button> -->
                                </form>
                            </center>
                            <form name=modalUpdate action="<?php echo base_url('index.php/TataUsaha/Kelas/update/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                <table id="example2" class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <!-- <th width=100 scope="col"></th> -->
                                            <th>No</th>
                                            <th>id_siswa</th>
                                            <th>Nama Siswa</th>
                                            <th>Nama Kelas</th>
                                            <th>Nis</th>
                                            <th>id_kelas</th>
                                            <th width=130px><input class="cekbox_id" type="checkbox" id="cekall">&nbsp;&nbsp;cek All</th>
                                        </tr>
                                    </thead>

                                    <?php if (isset($_REQUEST['id_kelas'])) echo "<input type=hidden name=\"id_kelas\" value='" . $_REQUEST['id_kelas'] . "'>"; ?>
                                    <tbody>
                                        <?php
                                        $no = 1;

                                        foreach ($dataSiswa as $datav) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $datav['id_siswa'] ?></td>
                                                <td><?php echo $datav['nama_siswa'] ?></td>
                                                <td><?php echo $datav['nama_kelas'] ?></td>
                                                <td><?php echo $datav['nis'] ?></td>
                                                <td><?php echo $datav['id_kelas'] ?></td>
                                                <td><input class="cekbox_id" type="checkbox" name="id_siswa[<?= $datav['id_siswa'] ?>]" data-id="<?= $no ?>" id="ceknew<?= $no ?>">
                                                </td>
                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                        ?>


                                    </tbody>
                                    <tfoot>
                                        <th colspan="5"></th>
                                        <th><button id="bnaikkelas" class="btn btn-primary"><i class="fas fa-save">&nbsp;&nbsp;&nbsp;Naik Kelas</i></button></th>
                                        <th> <select name=id_kelasnew>
                                                <?php
                                                foreach ($dataKelas as $dataKelasv) { ?>
                                                    <option value="<?php echo $dataKelasv['id_kelas'] ?>" <?php echo $selected ?>><?php echo $dataKelasv['nama_kelas']; ?></option>
                                                <?php
                                                } ?>
                                            </select></th>
                                    </tfoot>

                                </table>
                            </form>
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
    $(document).ready(function() {
        let ididkelas = $('#idid_kelas').find(":selected").val();
        if (ididkelas == "%") {
            //alert($('#idid_kelas').find(":selected").val());
            $(".cekbox_id").prop('disabled', true);
            $("#bnaikkelas").prop('disabled', true);
        } else {
            $(".cekbox_id").prop('disabled', false);
            $("#bnaikkelas").prop('disabled', false);
        }
    })
    $('#cekall').change(function() {
        if (this.checked) {
            //alert("test");
            for (let i = 1; i <= <?= $no ?>; i++) {
                $('#ceknew' + i).prop('checked', true);
            }

        } else {
            for (let i = 1; i <= <?= $no ?>; i++) {
                $('#ceknew' + i).prop('checked', false);
            }
        }
    })
    $('#idid_kelas').on('change', function() {
        let ididkelas = $(this).find(":selected").val();
        $("#formkelas").first().trigger("submit");
        if (ididkelas) {
            //alert($(this).find(":selected").val());
            $(".cekbox_id").prop('disabled', false);
            $("#bnaikkelas").prop('disabled', false);
        }
    })
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
            "lengthChange": true,
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