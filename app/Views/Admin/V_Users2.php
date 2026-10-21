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
                            <h2>Data User</h2>
                        </div>
                        <div class="card-body">
                            <!-- Start Modal Add -->
                            <div class="modal fade" id="ModalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id=form>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Nama User</span>
                                                    <input name="username" type="text" class="form-control" id="recipient-name" value="">
                                                    <input name="user_id" type="text" class="form-control" id="id" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Email</span>
                                                    <input name="email" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Password</span>
                                                    <input name="password" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Retype Password</span>
                                                    <input name="pass_confirm" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3">Group</span>
                                                    <select name="group" id="group" class="form-control select2" style="width: 75%; height: 100%;" required></select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save">save</i></button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Modal Add -->
                            <p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="add()" data-target="#ModalTambah" data-whatever="@mdo"><i class="fas fa-folder-plus"></i></button>
                            </p>
                            <table id="tusers" class="table table-striped table-bordered table-sm">
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
    var addUrl = '<?= base_url('index.php/users/tambah/' . $menuAktip . '/' . $moduleAktip) ?>';
    var editUrl = '<?= base_url('index.php/users/edit/' . $menuAktip . '/' . $moduleAktip) ?>';
    var editFormUrl = '<?= base_url('index.php/users/usergroupjson/' . $menuAktip . '/' . $moduleAktip) ?>';
    var deleteUrl = '<?= base_url('index.php/users/delete/' . $menuAktip . '/' . $moduleAktip) ?>';
    var dataUsers = '<?= base_url('index.php/users/readjson/' . $menuAktip . '/' . $moduleAktip) ?>';
    var groupUsers = '<?= base_url('index.php/users/groupjson/' . $menuAktip . '/' . $moduleAktip) ?>';
</script>
<script src="<?php echo BPATH; ?>/asset/js/DatatablesUsers.js"></script>
<script src="<?php echo BPATH; ?>/asset/js/V_Users.js"></script>

<?= $this->endSection() ?>