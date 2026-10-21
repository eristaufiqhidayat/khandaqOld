<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">


                <div class="col-sm-6">
                    <h1 class="m-0">Guru Arafah</h1>
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
                            <h5 id="dt-title">Data Guru Arafah</h5>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">

                            <div class="modal fade" id="ModalNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog  modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h5 class="modal-title" id="test2">New Data Guru</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo base_url('index.php/guru/tambah/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-1">
                                                            <label for="exampleInputEmail1">Id</label><input id="idid_guru" class="form-control" name="id_guru" type=text value="">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">Nama Guru</label><input class="form-control" name="nama_guru" type=text value="">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label for="exampleInputEmail1">Nip</label><input class="form-control" name="nip" type=text value="">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1"> kelamin</label><select class="form-control" id="selectkelamin" name="kelamin">
                                                                <option value="perempuan">Perempuan</option>
                                                                <option value="laki-laki">Laki-laki</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-10">
                                                            <label for="exampleInputEmail1">Alamat</label><textarea class="form-control" name="alamat_guru"> </textarea>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label for="exampleInputEmail1">Telpon</label><input class="form-control" name="telpon_guru" type=text value="">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label for="exampleInputEmail1">User Name</label><input class="form-control" name="username" type=text value="">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">Password</label><input class="form-control" name="password" type=text value="">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label for="exampleInputEmail1">Locked</label>
                                                            <select class="form-control" id=selectlocked name="locked">
                                                                <option value="yes">Yes</option>
                                                                <option value="no">No</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">Gelar</label><input class="form-control" name="gelar" type=text value="">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">Tempat Lahir</label><input class="form-control" name="tempat_lahir" type=text value="">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">Tanggal Lahir</label><input class="form-control" name="tanggal_lahir" type=text value="">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">Agama</label><input class="form-control" name="agama" type=text value="">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">Email</label><input class="form-control" name="email" type=text value="">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">Photo</label><input class="form-control" name="photo" type=text value="">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">Nama Direkening</label><input class="form-control" name="nama_rek" type=text value="">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">Nama Bank</label><input class="form-control" name="bank_rek" type=text value="">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="exampleInputEmail1">No Rek</label><input class="form-control" name="no_rek" type=text value="">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalNew" data-whatever="@mdo"><i class="fas fa-folder-plus"></i></button>
                            </p>

                            <div class="mt-5">
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered table-striped"></table>
                                </div>
                                <div class="modal fade" id="ModalWalikelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h5 class="modal-title" id="test2">Jadwal Matapelajaran</h5>
                                                </div>
                                            </div>
                                            <div id="carddata" class="modal-body">
                                                <table id="examplewali" class="table table-bordered table-striped"></table>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php foreach ($DataModel as $DataModelv) { ?>
                                    <!-- New Record Jadwal Mata Pelajaran-->
                                    <div class="modal fade" id="ModalNewJadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="container">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">

                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h5 class="modal-title">Tambah Jadwal Mengajar</h5>
                                                        </div>
                                                    </div>
                                                    <form action="<?php echo base_url('index.php/guru/tambahjadwal/') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                        <div class="card-body">
                                                            <div class="form-gorup">
                                                                <label for="exampleInputEmail1">ID Guru</label><input class="form-control" type="text" id="Mid_guru" name="id_guru" readonly>
                                                                <label for="exampleInputEmail1">Nama Guru</label><input class="form-control" type="text" id="Mnama_guru" name="nama_guru" readonly>
                                                                <label for="exampleInputEmail1">Nama Mata Pelajaran</label><select class="form-control" name="id_matapelajaran"><?php foreach (MataPelajaran() as $valkel) { ?><option value="<?php echo $valkel["id_matapelajaran"] ?>"><?= $valkel["nama_matapelajaran"] ?></option><?php } ?></select>
                                                                <label for="exampleInputEmail1">Kelas</label><select class="form-control" name="id_kelas"><?php foreach (rowkelas() as $valkel) { ?><option value="<?php echo $valkel["id_kelas"] ?>"><?= $valkel["nama_kelas"] ?></option><?php } ?></select>
                                                                <label for="exampleInputEmail1">Ruang Kelas</label><select class="form-control" name="id_ruang_kelas"><?php foreach (rowruangkelas() as $valkel) { ?><option value="<?php echo $valkel["id_ruang_kelas"] ?>"><?= $valkel["nama_ruang_kelas"] ?></option><?php } ?></select>
                                                                <label for="exampleInputEmail1">Hari</label><select class="form-control" name="hari"><?php $hari = array("senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu");
                                                                                                                                                        foreach ($hari as $valkel) { ?><option value="<?php echo $valkel ?>"><?= $valkel ?></option><?php } ?></select>
                                                                <label for="exampleInputEmail1">Jam</label><input class="form-control" type="time" id="appt" name="jam" min="09:00" max="18:00" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </DIV>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="ModalEdit<?= $DataModelv->id_guru ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog  modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h5 class="modal-title" id="test2">Edit Data Guru</h5>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form action="<?php echo base_url('index.php/guru/edit/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-1">
                                                                    <label for="exampleInputEmail1">Id</label><input id="idid_guru" class="form-control" name="id_guru" type=text value="<?= $DataModelv->id_guru ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Nama Guru</label><input class="form-control" name="nama_guru" type=text value="<?= $DataModelv->nama_guru ?>">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for="exampleInputEmail1">Nip</label><input class="form-control" name="nip" type=text value="<?= $DataModelv->nip ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Jenis kelamin</label>
                                                                    <select class="form-control" id="selectkelamin" name="kelamin">
                                                                        <?php
                                                                        $jeniskelamin = array("perempuan", "laki-laki");
                                                                        foreach ($jeniskelamin as $jeniskelaminv) {
                                                                            ($DataModelv->kelamin == $jeniskelaminv) ? $selected = "selected" : $selected = "";
                                                                        ?>
                                                                            <option value="<?= $jeniskelaminv ?>" <?= $selected ?>><?= $jeniskelaminv ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-10">
                                                                    <label for="exampleInputEmail1">Alamat</label><textarea class="form-control" name="alamat_guru"><?= $DataModelv->alamat_guru ?> </textarea>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="exampleInputEmail1">Telpon</label><input class="form-control" name="telpon_guru" type=text value="<?= $DataModelv->telpon_guru ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label for="exampleInputEmail1">User Name</label><input class="form-control" name="username" type=text value="<?= $DataModelv->username ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Password</label><input class="form-control" name="password" type=text value="<?= $DataModelv->password ?>">
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="exampleInputEmail1">Locked</label>
                                                                    <select class="form-control" id=selectlocked name="locked">
                                                                        <?php
                                                                        $locked = array("yes", "no");
                                                                        foreach ($locked as $lockedv) {
                                                                            ($DataModelv->locked == $lockedv) ? $selected = "selected" : $selected = "";
                                                                        ?>
                                                                            <option value="<?= $lockedv ?>" <?= $selected ?>><?= $lockedv ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Gelar</label><input class="form-control" name="gelar" type=text value="<?= $DataModelv->gelar ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Tempat Lahir</label><input class="form-control" name="tempat_lahir" type=text value="<?= $DataModelv->tempat_lahir ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Tanggal Lahir</label><input class="form-control" name="tanggal_lahir" type=text value="<?= $DataModelv->tanggal_lahir ?>">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Agama</label><input class="form-control" name="agama" type=text value="<?= $DataModelv->agama ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Email</label><input class="form-control" name="email" type=text value="<?= $DataModelv->email ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Photo</label><input class="form-control" name="photo" type=text value="<?= $DataModelv->photo ?>">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Nama Direkening</label><input class="form-control" name="nama_rek" type=text value="<?= $DataModelv->nama_rek ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Nama Bank</label><input class="form-control" name="bank_rek" type=text value="<?= $DataModelv->bank_rek ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">No Rek</label><input class="form-control" name="no_rek" type=text value="<?= $DataModelv->no_rek ?>">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="ModalDelete<?= $DataModelv->id_guru ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog  modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="card card-danger">
                                                    <div class="card-header">
                                                        <h5 class="modal-title" id="test2">Delete Data Guru</h5>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form action="<?php echo base_url('index.php/guru/delete/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-1">
                                                                    <label for="exampleInputEmail1">Id</label><input id="idid_guru" class="form-control" name="id_guru" type=text value="<?= $DataModelv->id_guru ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Nama Guru</label><input class="form-control" name="nama_guru" type=text value="<?= $DataModelv->nama_guru ?>">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for="exampleInputEmail1">Nip</label><input class="form-control" name="nip" type=text value="<?= $DataModelv->nip ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1"> kelamin <?= $DataModelv->kelamin ?></label>
                                                                    <select class="form-control" id="selectkelamin" name="kelamin">
                                                                        <?php
                                                                        $jeniskelamin = array("perempuan", "laki-laki");
                                                                        foreach ($jeniskelamin as $jeniskelaminv) {
                                                                            ($DataModelv->kelamin == $jeniskelaminv) ? $selected = "selected" : $selected = "";
                                                                        ?>
                                                                            <option value="<?= $jeniskelaminv ?>" <?= $selected ?>><?= $jeniskelaminv ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-10">
                                                                    <label for="exampleInputEmail1">Alamat</label><textarea class="form-control" name="alamat_guru"><?= $DataModelv->alamat_guru ?> </textarea>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="exampleInputEmail1">Telpon</label><input class="form-control" name="telpon_guru" type=text value="<?= $DataModelv->telpon_guru ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label for="exampleInputEmail1">User Name</label><input class="form-control" name="username" type=text value="<?= $DataModelv->username ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Password</label><input class="form-control" name="password" type=text value="<?= $DataModelv->password ?>">
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="exampleInputEmail1">Locked</label>
                                                                    <select class="form-control" id=selectlocked name="locked">
                                                                        <?php
                                                                        $locked = array("yes", "no");
                                                                        foreach ($locked as $lockedv) {
                                                                            ($DataModelv->locked == $lockedv) ? $selected = "selected" : $selected = "";
                                                                        ?>
                                                                            <option value="<?= $lockedv ?>" <?= $selected ?>><?= $lockedv ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Gelar</label><input class="form-control" name="gelar" type=text value="<?= $DataModelv->gelar ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Tempat Lahir</label><input class="form-control" name="tempat_lahir" type=text value="<?= $DataModelv->tempat_lahir ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Tanggal Lahir</label><input class="form-control" name="tanggal_lahir" type=text value="<?= $DataModelv->tanggal_lahir ?>">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Agama</label><input class="form-control" name="agama" type=text value="<?= $DataModelv->agama ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Email</label><input class="form-control" name="email" type=text value="<?= $DataModelv->email ?>">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="exampleInputEmail1">Photo</label><input class="form-control" name="photo" type=text value="<?= $DataModelv->photo ?>">
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </form>
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

<!-- AdminLTE App -->
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php //echo base_url(); 
                    ?>/asset/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>
<!-- Page specific script -->
<script>
    function ftable(urld) {
        const table = new DataTable('#example', {
            'processing': true,
            "responsive": true,
            'bVisible': false,
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "destroy": false,
            'serverMethod': 'get',
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    text: 'Copy to clipboard',
                    title: function() {
                        return $('#dt-title').html();
                    }
                }, {
                    extend: 'csv',
                    text: 'CSV',
                    title: function() {
                        return $('#dt-title').html();
                    }
                }, {
                    extend: 'excel',
                    text: 'EXCEL',
                    orientation: 'landscape',
                    title: function() {
                        return $('#dt-title').html();
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    orientation: 'landscape',
                    title: function() {
                        return $('#dt-title').html();
                    },
                },
                {
                    extend: 'print',
                    text: 'PRINT',
                    orientation: 'landscape',
                    title: function() {
                        return $('#dt-title').html();
                    },
                },
                "colvis"
            ],
            'ajax': {
                'url': urld,
                'dataSrc': "DataModule"
            },
            'columns': [{
                    'data': 'gelar',
                    'title': 'No',
                },
                {
                    'data': 'id_guru',
                    'title': 'Id',
                },
                {
                    'data': 'nama_guru',
                    'title': 'Nama Guru'
                },
                {
                    'data': 'alamat_guru',
                    'title': 'Alamat Guru'
                },
                {
                    'data': 'email',
                    'title': 'Email'
                },
                {
                    'data': 'nama_rek',
                    'title': 'Nama di Rek'
                },
                {
                    'data': 'bank_rek',
                    'title': 'Nama Bank'
                },
                {
                    'data': 'no_rek',
                    'title': 'No Rekening'
                },
                {
                    'data': 'nama_guru',
                    'title': 'JADWAL',
                    render: function(data, type, row, meta) {
                        return '<button type="button" class="btn btn-secondary"  data-id="' + row.id_guru + '" data-nama_guru="' + row.nama_guru + '" data-toggle="modal" data-target="#ModalWalikelas" data-whatever="@mdo"  title="Lihat Jadwal"><i class="fa fa-search" title="Lihat Jadwal"></i></button>&nbsp;&nbsp;&nbsp;' +
                            '<button type="button" class="btn btn-primary"  data-id="' + row.id_guru + '" data-nama_guru="' + row.nama_guru + '" data-toggle="modal" data-target="#ModalNewJadwal" data-whatever="@mdo"  title="Tambah Jadwal"><i class="fa fa-plus-circle" title="Tambah Jadwal"></i></button>'
                    }
                },

                {
                    data: null,
                    'title': 'Command',

                    render: function(data, type, row, meta) {
                        return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalEdit' + data['id_guru'] + '"><i class="fas fa-pencil-alt" title="Edit Data"></i></button>&nbsp;&nbsp;&nbsp;' +
                            '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalDelete' + data['id_guru'] + '"><i class="fas fa-trash" title="Delete Data"></i></button>'


                        ;
                    }
                }
            ],

        });
        table
            .on('order.dt search.dt', function() {
                let i = 1;

                table
                    .cells(null, 0, {
                        search: 'applied',
                        order: 'applied'
                    })
                    .every(function(cell) {
                        this.data(i++);
                    });
            })
            .draw();
    }

    function ftablewali(urld, id) {
        $('#examplewali').DataTable({
            'processing': true,
            'bVisible': false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "destroy": true,
            'serverMethod': 'get',
            'ajax': {
                'url': urld + '/' + id + '/',
                'dataSrc': "DataModule"
            },
            'columns': [{
                    'data': 'id_jadwal',
                    'title': 'ID',
                },
                {
                    'data': 'nama_matapelajaran',
                    'title': 'MATA PELAJARAN'
                },
                {
                    'data': 'nama_guru',
                    'title': 'NAMA GURU'
                },
                {
                    'data': 'nama_kelas',
                    'title': 'NAMA KELAS'
                },
                {
                    'data': null,
                    'title': 'Hari Jam',
                    render: function(data, type, row, meta) {
                        return row.hari + ' ' + row.jam
                    }
                },
                {
                    'data': null,
                    'title': 'Periode',
                    render: function(data, type, row, meta) {
                        return row.nama_semester + ' ' + row.tahun_ajaran
                    }
                },
                {
                    'data': null,
                    'title': '',
                    render: function(data, type, row, meta) {
                        return '<a class="btn btn-danger" href="<?= base_url() ?>' + '/index.php/guru/index/48/12?idjadwal=' + row.id_jadwal + '&idguru=' + row.id_guru + '" target="_self" role="button" data-id="' + row.id_jadwal + '"><i class="fas fa-trash" title="Delete Data"></i></a>'
                    }
                }

            ],

        });
    }
    var urldf = '<?= base_url('index.php/guru/json/') ?>' + '/2';
    var urlwali = '<?= base_url('index.php/guru/walikelas/json/') ?>';
    $(document).ready(function() {
        let id_jadwal = "<?= $idjadwal ?>";
        let id_guru = "<?= $idguru ?>";
        if (id_jadwal) {
            $('#ModalWalikelas').modal('show');
            ftablewali(urlwali, id_guru);
        }

        ftable(urldf);
    });
    $('#modalButton').click(function() {
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });

    $('#ModalWalikelas').on('shown.bs.modal', function(e) {
        let triggerLink = $(e.relatedTarget);
        let id = triggerLink[0].dataset['id'];
        ftablewali(urlwali, id);
        //$("#carddata").load(urlwali);
    })
    $('#ModalNewJadwal').on('shown.bs.modal', function(e) {
        let triggerLink = $(e.relatedTarget);
        let id = triggerLink[0].dataset['id'];
        let nama_guru = triggerLink[0].dataset['nama_guru'];
        $('#Mnama_guru').val(nama_guru);
        $('#Mid_guru').val(id);
    })
    $('#idhapusmatapelajaran43').click(function() {
        alert("del matapelajaran");
    })
</script>
<?= $this->endSection() ?>