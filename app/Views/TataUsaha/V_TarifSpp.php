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
                            <h2>Data Tarif SPP</h2>

                        </div>

                        <!-- /.modal new -->
                        <div class="modal fade" id="ModalNewData" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Data Tarid SPP</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form name=modalEntri action="<?php echo base_url('index.php/TataUsaha/TarifSpp/insert/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Periode</span>
                                                <select name=periode>
                                                    <?php
                                                    foreach ($dataPeriode as $dataPeriodev) { ?>
                                                        <?php if ($id_periode == $dataPeriodev['id_periode']) {
                                                            $selected = "selected";
                                                        } else {
                                                            $selected = "";
                                                        } ?>
                                                        <option value="<?php echo $dataPeriodev['id_periode'] ?>" <?php echo $selected ?>><?php echo $dataPeriodev['tahun_ajaran'] . "::" . $dataPeriodev['nama_semester']; ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Kelas</span>
                                                <select name=id_kelas>
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
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Tarif</span>
                                                <input name="tarif" type="text" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Tanggal</span>
                                                <input name="tanggal" type="date" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" onclick="return ceknull();"><i class="fas fa-save"> Save</i></button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalNewData"><i class="fas fa-plus"></i> New Data</button>
                            </p>
                            <center>
                                <form action="<?php echo base_url('index.php/TataUsaha/TarifSpp/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="post">
                                    <label for="start">Pilih Periode : &nbsp;&nbsp;&nbsp;</label>
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
                                    </select>
                                    <button type="submit">Pilih Periode</button>
                                </form>
                            </center>
                            <table id="example2" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <!-- <th width=100 scope="col"></th> -->
                                        <th>No</th>
                                        <th>Id Tarif</th>
                                        <th>id_kelas</th>
                                        <th>Tarif</th>
                                        <th>Periode</th>
                                        <th>Tanggal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($dataTarifSpp as $datav) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $datav['no'] ?></td>
                                            <td><?php echo $datav['nama_kelas'] ?></td>
                                            <td><?php echo number_format($datav['tarif'], 0, ",", ".") ?></td>
                                            <td><?php echo $datav['tahun_ajaran'] . "::" . $datav['nama_semester'] . "::" . $datav['semester'] ?></td>
                                            <td><?php echo $datav['tanggal'] ?></td>
                                            <td>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#ModalEditData<?php echo $datav['no']; ?>" type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
                                                <button class="btn btn-primary btn-danger" data-toggle="modal" data-target="#ModalDeleteData<?php echo $datav['no']; ?>" type="button" class="btn btn-primary"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <!-- /.modal edit -->
                                        <div class="modal fade" id="ModalEditData<?php echo $datav['no']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Data Tarif SPP</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form name=modalUpdate action="<?php echo base_url('index.php/TataUsaha/TarifSpp/update/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Periode</span>
                                                                <select name=periode>
                                                                    <?php
                                                                    foreach ($dataPeriode as $dataPeriodev) { ?>
                                                                        <?php if ($datav['periode'] == $dataPeriodev['id_periode']) {
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        } ?>
                                                                        <option value="<?php echo $dataPeriodev['id_periode'] ?>" <?php echo $selected ?>><?php echo $dataPeriodev['tahun_ajaran'] . "::" . $dataPeriodev['nama_semester']; ?></option>
                                                                    <?php
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Kelas</span>
                                                                <select name=id_kelas>
                                                                    <?php
                                                                    foreach ($dataKelas as $dataKelasv) { ?>
                                                                        <?php if ($datav['id_kelas'] == $dataKelasv['id_kelas']) {
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        } ?>
                                                                        <option value="<?php echo $dataKelasv['id_kelas'] ?>" <?php echo $selected ?>><?php echo $dataKelasv['nama_kelas']; ?></option>
                                                                    <?php
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Tarif</span>
                                                                <input name="tarif" type="text" class="form-control" id="recipient-name" value="<?php echo $datav['tarif'] ?>">
                                                                <input name="no" type="hidden" class="form-control" id="recipient-name" value="<?php echo $datav['no'] ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Tanggal</span>
                                                                <input name="tanggal" type="date" class="form-control" id="recipient-name" value="<?php echo $datav['tanggal'] ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button class="btn btn-primary" onclick="return ceknullUpdate();"><i class="fas fa-save"> Save</i></button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal edit -->
                                        <div class="modal fade" id="ModalDeleteData<?php echo $datav['no']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title">Hapus Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form name=modalUpdate action="<?php echo base_url('index.php/TataUsaha/TarifSpp/delete/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                            <div class="input-group mb-3">

                                                                <span class="input-group-text" id="basic-addon3">No</span>
                                                                <input name="no" type="text" class="form-control" id="recipient-name" value="<?php echo $datav['no'] ?>" readonly>
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