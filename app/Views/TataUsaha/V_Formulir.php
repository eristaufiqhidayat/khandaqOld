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
                            <h2>Data Pengeluaran </h2>

                        </div>

                        <!-- /.modal new -->
                        <div class="modal fade" id="ModalNewData" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Input Formulir</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form name=modalEntri action="<?= base_url('index.php/TataUsaha/Formulir/insertPengeluaran/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Nama Siswa</span>
                                                <input name="nama_siswa" type="text" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Alamat</span>
                                                <textarea name="alamat"></textarea>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Telp</span>
                                                <input name="telp" type="text" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Tanggal</span>
                                                <input name="tanggal" type="date" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Rupiah</span>
                                                <input name="rp" type="text" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Nama Orang Tua</span>
                                                <input name="nama_ortu" type="text" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Bukti Transfer</span>
                                                <input name="foto" type="file" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Keterangan</span>
                                                <input name="keterangan" type="text" class="form-control" id="recipient-name" value="">
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
                            <!--
                            <center>
                                <form action="<?= base_url('index.php/TataUsaha/Formulir/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="post">
                                    <label for="start">Pilih Bulan : &nbsp;&nbsp;&nbsp;</label>
                                    <input type="month" name="monthyear" value="<?= $monthyear ?>">&nbsp;&nbsp;&nbsp;
                                    <button>Pilih Bulan</button>
                                </form>
                            </center>
-->
                            <p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalNewData"><i class="fas fa-plus"></i> New Data</button>
                            </p>
                            <table id="example2" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <!-- <th width=100 scope="col"></th> -->
                                        <th>No Urut</th>
                                        <th>id</th>
                                        <th>Nama Siswa</th>
                                        <th>Rutin/NonRutin</th>
                                        <th>Kode</th>
                                        <th>No Ortu</th>
                                        <th>Rp</th>
                                        <th width=35%>keterangan</th>
                                        <th>Bukti</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($dataFormulir as $dataFormulirv) {
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $dataFormulirv['no'] ?></td>
                                            <td><?= $dataFormulirv['nama_siswa'] ?></td>
                                            <td><?= $dataFormulirv['alamat'] ?></td>
                                            <td><?= $dataFormulirv['telp'] ?></td>
                                            <td><?= $dataFormulirv['nama_ortu'] ?></td>
                                            <td><?= number_format($dataFormulirv['rp'], 0) ?></td>
                                            <td><?= $dataFormulirv['keterangan'] ?></td>
                                            <td><img width="200" src="<?= base_url() . "/uploads/formulir/" . $dataFormulirv['foto'] ?>" alt="Foto Tidak ada" /></td>
                                            <!-- <td><img width="200" src="data:image/png;base64,<?= $dataFormulirv['image'] ?>" alt="Foto Tidak ada" /></td>-->
                                            <td>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#ModalEditData<?php echo $dataFormulirv['no']; ?>" type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
                                                <button class="btn btn-primary btn-danger" data-toggle="modal" data-target="#ModalDeleteData<?php echo $dataFormulirv['no']; ?>" type="button" class="btn btn-primary"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <!-- /.modal edit -->
                                        <div class="modal fade" id="ModalEditData<?php echo $dataFormulirv['no']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Data Pengeluaran </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form name=modalUpdate action="<?php echo base_url('index.php/TataUsaha/Formulir/updatePengeluaran/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Tanggal</span>
                                                                <input name="tanggal" type="date" class="form-control" id="recipient-name" value="<?php echo $dataFormulirv['tanggal'] ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Rupiah</span>
                                                                <input name="rp" type="text" class="form-control" id="recipient-name" value="<?php echo $dataFormulirv['rp'] ?>">
                                                                <input name="no" type="hidden" class="form-control" id="recipient-name" value="<?php echo $dataFormulirv['no'] ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Keterangan</span>
                                                                <input name="keterangan" type="text" class="form-control" id="recipient-name" value="<?php echo $dataFormulirv['keterangan'] ?>">
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
                                        <div class="modal fade" id="ModalDeleteData<?php echo $dataFormulirv['no']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title">Hapus Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form name=modalUpdate action="<?php echo base_url('index.php/TataUsaha/Formulir/deletePengeluaran/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">No</span>
                                                                <input name="no" type="text" class="form-control" id="recipient-name" value="<?php echo $dataFormulirv['no'] ?>" readonly>
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