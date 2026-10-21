<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/dist/css/adminlte.min.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Profile Guru</h1> -->
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php if (session('error')) : ?>
        <div class="alert alert-danger">
            <?= session('error') ?>
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        </div>
    <?php endif ?>
    <?php if (session('messege')) : ?>
        <div class="alert alert-success">
            <?= session('messege') ?>
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        </div>
    <?php endif ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Profile Guru</h5>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <?php
                            $pguru = listProfileDataGuru(user()->username);
                            if (isset($pguru)) {
                                //var_dump($pguru);
                            ?>
                                <div class="container rounded bg-white mt-2 mb-5">
                                    <div class="row">
                                        <div class="col-md-5 border-right">
                                            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-sm mt-5" width="300px" src="<?= $pguru["photo"] ?>"><span class="font-weight-bold"><?= $pguru["nama_guru"] ?></span><span class="text-black-50"><?= $pguru["email"] ?></span><span> </span></div>
                                        </div>
                                        <div class="col-md-5">

                                            <div class="row mt-2">
                                                <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control" placeholder="first name" value="<?= $pguru["nama_guru"] ?>"></div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12"><label class="labels">User Name</label><input type="text" class="form-control" placeholder="education" value="<?= $pguru["username"] ?>"></div>
                                                <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text" class="form-control" placeholder="enter phone number" value="<?= $pguru["telpon_guru"] ?>"></div>
                                                <div class="col-md-12"><label class="labels">Address Line 1</label><input type="text" class="form-control" placeholder="enter address line 1" value="<?= $pguru["alamat_guru"] ?>"></div>
                                                <div class="col-md-12"><label class="labels">Email ID</label><input type="text" class="form-control" placeholder="enter email id" value="<?= $pguru["email"] ?>"></div>
                                                <div class="col-md-12"><label class="labels">Education</label><input type="text" class="form-control" placeholder="education" value="<?= $pguru["gelar"] ?>"></div>

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
</div>
</section>
<!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- jQuery -->
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- AdminLTE App -->
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- Modal Bootstrap -->
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>


<?= $this->endSection() ?>