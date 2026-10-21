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

                        <!-- /.modal new -->
                        <div class="modal fade" id="ModalNewData" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Rubah Kelas</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form name=modalEntri action="<?php echo base_url('index.php/TataUsaha/Periode/insert/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">nama_semester</span>
                                                <input name="nama_semester" type="text" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">tahun_ajaran</span>
                                                <input name="tahun_ajaran" type="text" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">semester</span>
                                                <input name="semester" type="text" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Active</span>
                                                <select class="form-control" name="status_aktif">
                                                    <option value="yes">yes</option>
                                                    <option value="no">no</option>
                                                </select>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>

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
                                            <td>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#ModalEditData<?php echo $datav['id_siswa']; ?>" type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
                                                <!-- <button class="btn btn-primary btn-danger" data-toggle="modal" data-target="#ModalDeleteData<?php echo $datav['id_siswa']; ?>" type="button" class="btn btn-primary"><i class="fas fa-trash"></i></button> -->
                                            </td>
                                        </tr>
                                        <!-- /.modal edit -->
                                        <div class="modal fade" id="ModalEditData<?php echo $datav['id_siswa']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Rubah Data Kelas</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form name=modalUpdate action="<?php echo base_url('index.php/TataUsaha/Kelas/update/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">id_periode</span>
                                                                <input name="id_periode" type="text" class="form-control" id="recipient-name" value="<?php echo $dataPeriodeAktif['id_periode'] ?>">
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
                                                                <span class="input-group-text" id="basic-addon3">Nama Siswa</span>
                                                                <input name="id_siswa" type="text" class="form-control" id="recipient-name" value="<?php echo $datav['nama_siswa'] ?>">
                                                                <input name="id_siswa" type="hidden" class="form-control" id="recipient-name" value="<?php echo $datav['id_siswa'] ?>">
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
                                        <div class="modal fade" id="ModalDeleteData<?php echo $datav['id_kelas']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title">Hapus Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form name=modalUpdate action="<?php echo base_url('index.php/TataUsaha/Periode/delete/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                            <div class="input-group mb-3">

                                                                <span class="input-group-text" id="basic-addon3">No</span>
                                                                <input name="id_kelas" type="text" class="form-control" id="recipient-name" value="<?php echo $datav['id_kelas'] ?>" readonly>
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
    $('#idid_kelas').on('change', function() {
        $("#formkelas").first().trigger("submit");
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