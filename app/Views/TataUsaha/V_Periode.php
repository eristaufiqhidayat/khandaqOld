<?= $this->extend('Views\layout.php') ?>
<?php

/** @var array $dataperiode */
/** @var string $menuAktip */
/** @var string $moduleAktip */

?>

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
                            <?php if (session()->getFlashdata('success')) : ?>
                                <div class="alert alert-success">
                                    <?= session()->getFlashdata('success'); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('error')) : ?>
                                <div class="alert alert-danger">
                                    <?= session()->getFlashdata('error'); ?>
                                </div>
                            <?php endif; ?>
                            <h2>Data Periode</h2>

                        </div>

                        <!-- /.modal new -->
                        <div class="modal fade" id="ModalNewData" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Data Periode</h5>
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
                            <p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalNewData"><i class="fas fa-plus"></i> New Data</button>
                            </p>
                            <table id="example2" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <!-- <th width=100 scope="col"></th> -->
                                        <th>No</th>
                                        <th>id_periode</th>
                                        <th>nama_semester</th>
                                        <th>tahun_ajaran</th>
                                        <th>semester</th>
                                        <th>status_aktif</th>
                                        <th>Action</th>
                                        <th>Status Ruang</th>
                                        <th>Proses</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($dataperiode as $datav) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $datav['id_periode'] ?></td>
                                            <td><?php echo $datav['nama_semester'] ?></td>
                                            <td><?php echo $datav['tahun_ajaran'] ?></td>
                                            <td><?php echo $datav['semester'] ?></td>
                                            <td><?php echo $datav['status_aktif'] ?></td>
                                            <td>
                                                <button class="btn btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#ModalEditData<?php echo $datav['id_periode']; ?>">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>

                                                <button class="btn btn-danger"
                                                    data-toggle="modal"
                                                    data-target="#ModalDeleteData<?php echo $datav['id_periode']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <a href="<?= base_url('index.php/TataUsaha/Periode/cekPeriode/' . $datav['id_periode']) ?>"
                                                    class="btn btn-warning"
                                                    onclick="return confirm('Cek data ruang untuk periode <?= $datav['id_periode'] ?> ?')">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <?php if ($datav['jml_ruang'] > 0) : ?>
                                                    <span class="badge badge-success">
                                                        Sudah Ada (<?= $datav['jml_ruang'] ?>)
                                                    </span>
                                                <?php else : ?>
                                                    <span class="badge badge-danger">
                                                        Belum Ada
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (($datav['jml_ruang'] ?? 0) == 0) : ?>
                                                    <a href="<?= base_url('index.php/TataUsaha/Periode/prosesRuang/' . $datav['id_periode']) ?>"
                                                        class="btn btn-warning btn-sm"
                                                        onclick="return confirm('Proses data ruang untuk periode <?= $datav['id_periode'] ?> ?')">
                                                        <i class="fas fa-cogs"></i> Proses Status Ruang
                                                    </a>
                                                <?php else : ?>
                                                    <button class="btn btn-success btn-sm" disabled>
                                                        <i class="fas fa-check"></i> Selesai
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <!-- /.modal edit -->
                                        <div class="modal fade" id="ModalEditData<?php echo $datav['id_periode']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Data Periode</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form name=modalUpdate action="<?php echo base_url('index.php/TataUsaha/Periode/update/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">nama_semester</span>
                                                                <input name="nama_semester" type="text" class="form-control" id="recipient-name" value="<?php echo $datav['nama_semester'] ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">tahun_ajaran</span>
                                                                <input name="tahun_ajaran" type="text" class="form-control" id="recipient-name" value="<?php echo $datav['tahun_ajaran'] ?>">
                                                                <input name="id_periode" type="hidden" class="form-control" id="recipient-name" value="<?php echo $datav['id_periode'] ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">semester</span>
                                                                <input name="semester" type="text" class="form-control" id="recipient-name" value="<?php echo $datav['semester'] ?>">
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
                                                                <button class="btn btn-primary" onclick="return ceknullUpdate();"><i class="fas fa-save"> Save</i></button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal edit -->
                                        <div class="modal fade" id="ModalDeleteData<?php echo $datav['id_periode']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
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
                                                                <input name="id_periode" type="text" class="form-control" id="recipient-name" value="<?php echo $datav['id_periode'] ?>" readonly>
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