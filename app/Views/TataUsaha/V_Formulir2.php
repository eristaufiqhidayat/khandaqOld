<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Data Formulir Siswa Baru</h2>
                        </div>
                        <div class="card-body">
                            <!-- Start Modal Add -->
                            <!-- /.modal new -->
                            <div class="modal fade" id="ModalNewData" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Input Formulir</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form">
                                                <input name="no" type="hidden" class="form-control" id="recipient-name" value="">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Nama Siswa</span>
                                                    <input name="nama_siswa" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Alamat</span>
                                                    <textarea class="form-control" name="alamat"></textarea>
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
                                                    <img name="bukti" id="bukti" style="max-width:200px;">
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
                                                    <button type="submit" class="btn btn-primary" onclick="return ceknull();"><i class="fas fa-save"> Save</i></button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Modal Add -->
                            <p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="add()" data-target="#ModalNewData" data-whatever="@mdo"><i class="fas fa-folder-plus"></i></button>
                            </p>
                            <table id="tformulir" class="table table-striped table-bordered table-sm">
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
<!-- Harus Ada -->
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>
<!-- Bootstrap 4 (buat show mdal) -->
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- -->

<script src="<?php echo BPATH; ?>/asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/select2/js/select2.min.js"></script>
<script>
    var addUrl = '<?= base_url('index.php/TataUsaha/Formulir/insertPengeluaran/' . $menuAktip . '/' . $moduleAktip) ?>';
    var editUrl = '<?= base_url('index.php/TataUsaha/Formulir/updatePengeluaran/' . $menuAktip . '/' . $moduleAktip) ?>';
    var editFormUrl = '<?= base_url('index.php/TataUsaha/Formulir/editjson/' . $menuAktip . '/' . $moduleAktip) ?>';
    var deleteUrl = '<?= base_url('index.php/TataUsaha/Formulir/deletePengeluaran/' . $menuAktip . '/' . $moduleAktip) ?>';
    var dataFormulir = '<?= base_url('index.php/TataUsaha/Formulir/readjson/' . $menuAktip . '/' . $moduleAktip) ?>';
    var groupUsers = '<?= base_url('index.php/users/groupjson/' . $menuAktip . '/' . $moduleAktip) ?>';
    var imgFolder = '<?= base_url('uploads/formulir/') ?>';
</script>
<script src="<?php echo BPATH; ?>/asset/js/DatatablesFormulir.js"></script>
<script src="<?php echo BPATH; ?>/asset/js/V_Formulir.js"></script>

<?= $this->endSection() ?>