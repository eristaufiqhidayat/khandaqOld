<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.semanticui.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">


                <div class="col-sm-6">
                    <h1 class="m-0">Nilai Siswa</h1>
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
    <?php
    $pguru = listProfileDataGuru(user()->username);
    $id_periode = periodeaktif()['id_periode'];
    if (session('error')) : ?>
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
                            <h5>Data Nilai Siswa</h5>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <!-- Modal New -->
                            <div class="modal fade" id="ModalNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog  modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h5 class="modal-title" id="test2">New Input Nilai</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo base_url('index.php/nilaisiswa/tambah/') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="exampleInputEmail1">Nama Siswa</label>
                                                        </div>
                                                        <div class="col-4">
                                                            <select id="idid_siswa" name="id_siswa" class="form-control">
                                                                <?php foreach (comboDataSiswaGuru($pguru['id_guru']) as $dataSiswa) {   ?><option value="<?= $dataSiswa["id_siswa"] ?>"><?= $dataSiswa["nama_siswa"] ?></option><?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-2">
                                                            <label for="exampleInputEmail1">Kelas</label>
                                                        </div>
                                                        <div class="col-4">
                                                            <input class="form-control" id="id_kelas" name="id_kelas" type="hidden">
                                                            <div id="nama_kelas"></div>
                                                        </div>
                                                    </div><BR>
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="exampleInputEmail1">Pelajaran</label>
                                                        </div>
                                                        <div class="col-4">
                                                            <select id="idid_matapelajarannew" name="id_matapelajaran" class="form-control">
                                                                <?php foreach (MataPelajaranNilaiGuru($pguru['id_guru'], $id_periode) as $dataMataPelajaran) {

                                                                ?><option value="<?= $dataMataPelajaran["id_matapelajaran"] ?>"><?= $dataMataPelajaran["nama_matapelajaran"] ?></option><?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-2">
                                                            <label for="exampleInputEmail1">Nama Guru</label>
                                                        </div>
                                                        <div class="col-4">
                                                            <input class="form-control" id="id_guru" name="id_guru" type="hidden">
                                                            <div id="nama_guru"></div>
                                                        </div>
                                                    </div><br><br>
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H1</label><input class="form-control" id="H1" name="H1" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H2</label><input class="form-control" id="H2" name="H2" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H3</label><input class="form-control" id="H3" name="H3" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H4</label><input class="form-control" id="H4" name="H4" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H5</label><input class="form-control" id="H5" name="H5" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H6</label><input class="form-control" id="H6" name="H6" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H7</label><input class="form-control" id="H7" name="H7" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H8</label><input class="form-control" id="H8" name="H8" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">HPTS</label><input class="form-control" id="HUTS" name="HUTS" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">HPAS</label><input class="form-control" id="HUAS" name="HUAS" type=text value="">
                                                        </div>
                                                    </div><BR>
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">K1</label><input class="form-control" id="K1" name="K1" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">K2</label><input class="form-control" id="K2" name="K2" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">K3</label><input class="form-control" id="K3" name="K3" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">K4</label><input class="form-control" id="K4" name="K4" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">K5</label><input class="form-control" id="K5" name="K5" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">K6</label><input class="form-control" id="K6" name="K6" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">K7</label><input class="form-control" id="K7" name="K7" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">K8</label><input class="form-control" id="K8" name="K8" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">HPKTS</label><input class="form-control" id="HPKTS" name="HPKTS" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">HPKAS</label><input class="form-control" id="HPKAS" name="HPKAS" type=text value="">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div> Keterangan</div>
                                                            <div> * H1-H8 = Hasil Penilaian Harian</div>
                                                            <div> * HPTS = Hasil Penilaian Tengah Semester</div>
                                                            <div> * HPAS = Hasil Penilaian Semester</div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div>-</div>
                                                            <div> * K1-K8 = Hasil Penilaian Keterampilan Harian</div>
                                                            <div> * HPKTS = Hasil Penilaian Keterampilan Tengah Semester</div>
                                                            <div> * HPKAS = Hasil Penilaian Keterampilan Akhir Semester</div>
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
                            <!-- Modal Edit -->

                            <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog  modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h5 class="modal-title" id="test2">New Input Nilai</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form id="formEdit" action="<?php echo base_url('index.php/nilaisiswa/edit') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="exampleInputEmail1">Nama Siswa</label>
                                                        </div>
                                                        <div class="col-3">
                                                            <input class="form-control" id="Enama_siswa" name="nama_siswa" type=text readonly>
                                                            <input class="form-control" id="Eid_siswa" name="id_siswa" type=hidden readonly>
                                                            <input class="form-control" id="Eid_nilai" name="id_nilai" type=hidden value="" readonly>
                                                        </div>
                                                        <div class="col-2">
                                                            <label for="exampleInputEmail1">Kelas</label>
                                                        </div>
                                                        <div class="col-3">
                                                            <input class="form-control" id="Enama_kelas" name="nama_kelas" type=text value="" readonly>
                                                            <input class="form-control" id="Eid_kelas" name="id_kelas" type=hidden value="" readonly>
                                                        </div>
                                                    </div><BR>
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="exampleInputEmail1">Pelajaran</label>
                                                        </div>
                                                        <div class="col-3">
                                                            <input class="form-control" id="Enama_matapelajaran" name="nama_matapelajaran" type=text value="" readonly>
                                                            <input class="form-control" id="Eid_matapelajaran" name="id_matapelajaran" type=hidden value="" readonly>
                                                        </div>
                                                        <div class="col-2">
                                                            <label for="exampleInputEmail1">Nama Guru</label>
                                                        </div>
                                                        <div class="col-3">
                                                            <input class="form-control" id="Enama_guru" name="nama_guru" type=text value="" readonly>
                                                            <input class="form-control" id="Eid_guru" name="id_guru" type=hidden value="" readonly>
                                                        </div>
                                                    </div><br><br>
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H1</label><input class="form-control" id="EH1" name="H1" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H2</label><input class="form-control" id="EH2" name="H2" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H3</label><input class="form-control" id="EH3" name="H3" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H4</label><input class="form-control" id="EH4" name="H4" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H5</label><input class="form-control" id="EH5" name="H5" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H6</label><input class="form-control" id="EH6" name="H6" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H7</label><input class="form-control" id="EH7" name="H7" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">H8</label><input class="form-control" id="EH8" name="H8" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">HPTS</label><input class="form-control" id="EHPTS" name="HUTS" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="exampleInputEmail1">HPAS</label><input class="form-control" id="EHPAS" name="HUAS" type=text value="">
                                                        </div>
                                                    </div><BR>
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label>K1</label><input class="form-control" id="EK1" name="K1" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label>K2</label><input class="form-control" id="EK2" name="K2" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label>K3</label><input class="form-control" id="EK3" name="K3" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label>K4</label><input class="form-control" id="EK4" name="K4" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label>K5</label><input class="form-control" id="EK5" name="K5" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label>K6</label><input class="form-control" id="EK6" name="K6" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label>K7</label><input class="form-control" id="EK7" name="K7" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label>K8</label><input class="form-control" id="EK8" name="K8" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label>HPKTS</label><input class="form-control" id="EHPKTS" name="HPKTS" type=text value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <label>HPKAS</label><input class="form-control" id="EHPKAS" name="HPKAS" type=text value="">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div> Keterangan</div>
                                                            <div> * H1-H8 = Hasil Penilaian Harian</div>
                                                            <div> * HPTS = Hasil Penilaian Tengah Semester</div>
                                                            <div> * HPAS = Hasil Penilaian Semester</div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div>-</div>
                                                            <div> * K1-K8 = Hasil Penilaian Keterampilan Harian</div>
                                                            <div> * HPKTS = Hasil Penilaian Keterampilan Tengah Semester</div>
                                                            <div> * HPKAS = Hasil Penilaian Keterampilan Akhir Semester</div>
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
                            <div class="row">
                                <div class="col-1">
                                    <label>Pilih kelas :</label>
                                </div>
                                <div class="col-2">
                                    <form class="form-group" action="<?php echo base_url('index.php/guru/jadwalmengajar/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="get" accept-charset="utf-8" enctype="multipart/form-data">
                                        <select id="idid_kelas" name="id_kelas" class="form-control select2 select2-hidden-accessible">
                                            <?php foreach (rowkelasNilaiGuru($pguru['id_guru']) as $kelasv) {
                                                (isset($id_kelas) && $id_kelas == $kelasv["id_kelas"]) ? $selected = "selected" : $selected = "";
                                            ?>
                                                <option value="<?= $kelasv["id_kelas"] ?>" <?= $selected ?>><?= $kelasv["nama_kelas"] ?> </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </form>
                                </div>
                                <div class="col-2">
                                    <label>Pilih Mata Pelajaran : </label>
                                </div>
                                <div class="col-4">
                                    <form class="form-group" action="<?php echo base_url('index.php/guru/jadwalmengajar/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="get" accept-charset="utf-8" enctype="multipart/form-data">
                                        <select id="idid_matapelajaran" name="id_matapelajaran" class="form-control select2 select2-hidden-accessible">
                                            <?php foreach (MataPelajaranNilaiGuru($pguru['id_guru'], $id_periode) as $kelasv) {
                                                (isset($id_matapelajaran) && $id_matapelajaran == $kelasv["id_matapelajaran"]) ? $selected = "selected" : $selected = "";
                                            ?>
                                                <option value="<?= $kelasv["id_matapelajaran"] ?>" <?= $selected ?>><?= $kelasv["nama_matapelajaran"] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </form>
                                </div>
                            </div><br>
                            <table id=example class="ui celled table">
                                <thead>
                                    <tr>
                                        <th rowspan="3" style="text-align: center; vertical-align: middle;">No</th>
                                        <th rowspan="3" style="text-align: center; vertical-align: middle;">Nama Siswa</th>
                                        <th rowspan="3" style="text-align: center; vertical-align: middle;">Mata Pelajaran</th>
                                        <th rowspan="3" style="text-align: center; vertical-align: middle;">Kelas</th>
                                        <th colspan="11" style="text-align: center; vertical-align: middle;">Nilai</th>
                                        <th rowspan="3" style="text-align: center; vertical-align: middle;">Command</th>

                                    </tr>
                                    <tr>
                                        <th colspan="8" style="text-align: center; vertical-align: middle;">Harian 50%</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">HPTS 25%</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">HPAS 25%</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">HPA</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;">H1</th>
                                        <th style="text-align: center; vertical-align: middle;">H2</th>
                                        <th style="text-align: center; vertical-align: middle;">H3</th>
                                        <th style="text-align: center; vertical-align: middle;">H4</th>
                                        <th style="text-align: center; vertical-align: middle;">H5</th>
                                        <th style="text-align: center; vertical-align: middle;">H6</th>
                                        <th style="text-align: center; vertical-align: middle;">H7</th>
                                        <th style="text-align: center; vertical-align: middle;">H8</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;"></th>
                                        <th style="text-align: center; vertical-align: middle;">Nama Siswa</th>
                                        <th style="text-align: center; vertical-align: middle;">Mata Pelajaran</th>
                                        <th style="text-align: center; vertical-align: middle;">Kelas</th>
                                        <th style="text-align: center; vertical-align: middle;">H1</th>
                                        <th style="text-align: center; vertical-align: middle;">H2</th>
                                        <th style="text-align: center; vertical-align: middle;">H3</th>
                                        <th style="text-align: center; vertical-align: middle;">H4</th>
                                        <th style="text-align: center; vertical-align: middle;">H5</th>
                                        <th style="text-align: center; vertical-align: middle;">H6</th>
                                        <th style="text-align: center; vertical-align: middle;">H7</th>
                                        <th style="text-align: center; vertical-align: middle;">H8</th>
                                        <th style="text-align: center; vertical-align: middle;">HPTS</th>
                                        <th style="text-align: center; vertical-align: middle;">HPAS</th>
                                        <th style="text-align: center; vertical-align: middle;">HPA</th>
                                        <th style="text-align: center; vertical-align: middle;">Command</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="col-2">
                                <h5>Data Nilai Praktek Siswa</h5>
                            </div><br><br>
                            <table id=exampleK class="ui celled table">
                                <thead>
                                    <tr>
                                        <th rowspan="3" style="text-align: center; vertical-align: middle;">No</th>
                                        <th rowspan="3" style="text-align: center; vertical-align: middle;">Nama Siswa</th>
                                        <th rowspan="3" style="text-align: center; vertical-align: middle;">Mata Pelajaran</th>
                                        <th rowspan="3" style="text-align: center; vertical-align: middle;">Kelas</th>
                                        <th colspan="11" style="text-align: center; vertical-align: middle;">Nilai</th>

                                    </tr>
                                    <tr>
                                        <th colspan="8" style="text-align: center; vertical-align: middle;">Harian 50%</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">HPKTS 25%</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">HPKAS 25%</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">HPKA</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;">K1</th>
                                        <th style="text-align: center; vertical-align: middle;">K2</th>
                                        <th style="text-align: center; vertical-align: middle;">K3</th>
                                        <th style="text-align: center; vertical-align: middle;">K4</th>
                                        <th style="text-align: center; vertical-align: middle;">K5</th>
                                        <th style="text-align: center; vertical-align: middle;">K6</th>
                                        <th style="text-align: center; vertical-align: middle;">K7</th>
                                        <th style="text-align: center; vertical-align: middle;">K8</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;"></th>
                                        <th style="text-align: center; vertical-align: middle;">Nama Siswa</th>
                                        <th style="text-align: center; vertical-align: middle;">Mata Pelajaran</th>
                                        <th style="text-align: center; vertical-align: middle;">Kelas</th>
                                        <th style="text-align: center; vertical-align: middle;">K1</th>
                                        <th style="text-align: center; vertical-align: middle;">K2</th>
                                        <th style="text-align: center; vertical-align: middle;">K3</th>
                                        <th style="text-align: center; vertical-align: middle;">K4</th>
                                        <th style="text-align: center; vertical-align: middle;">K5</th>
                                        <th style="text-align: center; vertical-align: middle;">K6</th>
                                        <th style="text-align: center; vertical-align: middle;">K7</th>
                                        <th style="text-align: center; vertical-align: middle;">K8</th>
                                        <th style="text-align: center; vertical-align: middle;">HPKTS</th>
                                        <th style="text-align: center; vertical-align: middle;">HPKAS</th>
                                        <th style="text-align: center; vertical-align: middle;">HPKA</th>
                                    </tr>
                                </tfoot>
                            </table>
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

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.semanticui.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>

<!-- Modal Bootstrap -->
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>

<script>
    function ftable(urld) {
        $('#example').DataTable({
            'processing': true,
            'bVisible': true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "destroy": true,
            "deferRender": true,
            'serverMethod': 'get',
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            'ajax': {
                'url': urld,
                'dataSrc': "DataModule"
            },
            columnDefs: [{
                    width: "1px",
                    targets: [0]
                },
                {
                    width: "125px",
                    targets: [1, 2]
                },
                {
                    width: "5px",
                    className: 'dt-body-center',
                    targets: [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
                },
                {
                    width: "100px",
                    className: 'dt-body-center',
                    targets: [15]
                }
            ],
            "columns": [{
                    "data": "row_num"
                },
                {
                    "data": "nama_siswa"
                },
                {
                    "data": "nama_matapelajaran"
                },
                {
                    "data": "nama_kelas"
                },
                {
                    "data": "H1"
                },
                {
                    "data": "H2"
                },
                {
                    "data": "H3"
                },
                {
                    "data": "H4"
                },
                {
                    "data": "H5"
                },
                {
                    "data": "H6"
                },
                {
                    "data": "H7"
                },
                {
                    "data": "H8"
                },
                {
                    "data": "nilai_uts"
                },
                {
                    "data": "nilai_uas"
                },
                {
                    "data": null,
                    render: function(data, type, row, meta) {
                        const formatter = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0,
                        });
                        let a = 0;
                        let sum = 0;
                        let HPH = 0;
                        let HPA = 0;
                        let HPTS = 0;
                        let HPAS = 0;
                        if (data["nilai_uts"]) HPTS = parseInt(data["nilai_uts"]);
                        if (data["nilai_uas"]) HPAS = parseInt(data["nilai_uas"]);

                        for (i = 1; i < 8; i++) {
                            if (data["H" + i]) {
                                a = a + 1;
                                sum += parseInt(data["H" + i]);
                            }
                        }
                        if (sum > 0) HPH = sum / a;
                        HPA = (HPH * data['NH']) / 100 + (HPTS * data['NHPTS']) / 100 + (HPAS * data['NHPAS']) / 100;
                        return formatter.format(HPA);
                    }
                },
                {
                    data: null,
                    'title': 'Command',

                    render: function(data, type, row, meta) {
                        return '<button type="button" class="btn btn-primary" data-id="' + data['id_nilai'] + '" data-toggle="modal" data-target="#ModalEdit"><i class="fas fa-pencil-alt" title="Edit Data"></i></button>'
                        //return '<a id="modalnew" class="btn btn-primary" href="<?= base_url() ?>' + '/index.php/nilaisiswa/index/<?= $menuAktip ?>/<?= $moduleAktip ?>?id_nilai=' + row.id_nilai + '&id_kelas=' + row.id_kelas + '&id_matapelajaran=' + row.id_matapelajaran + '" target="_self" role="button" data-id="' + row.id_jadwal + '"><i class="fas fa-pencil-alt" title="Edit Data"></i></a>'
                    }
                }
            ]
        });
    }

    function loadJSONGuruNilai(link, selectId) {
        var data_file = "<?php echo base_url() . '/index.php/nilaisiswa/' ?>" + link;
        //alert(data_file);
        var http_request = new XMLHttpRequest();

        try {
            // Opera 8.0+, Firefox, Chrome, Safari
            http_request = new XMLHttpRequest();
        } catch (e) {
            // Internet Explorer Browsers
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");

            } catch (e) {

                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }

            }
        }

        http_request.onreadystatechange = function() {

            if (http_request.readyState == 4) {
                // Javascript function JSON.parse to parse JSON data
                var jsonObj = JSON.parse(http_request.responseText);

                // jsonObj variable now contains the data structure and can
                // be accessed as jsonObj.name and jsonObj.country.
                //document.getElementById("nama_guru").innerHTML = jsonObj.nama_guru;
                if (selectId === 'idguru') {
                    document.getElementById("nama_guru").innerHTML = jsonObj.nama_guru;
                    document.getElementById("id_guru").value = jsonObj.id_guru;
                } else if (selectId === 'idsiswa') {
                    document.getElementById("nama_kelas").innerHTML = jsonObj.nama_kelas;
                    document.getElementById("id_kelas").value = jsonObj.id_kelas;
                } else if (selectId === 'idnilai') {
                    var linkaddr = "<?php echo base_url('index.php/nilaisiswa/edit') ?>" + "?id_kelas=" + jsonObj.id_kelas + "&id_matapelajaran=" + jsonObj.id_matapelajaran
                    //alert(data_file);<?php echo base_url('index.php/nilaisiswa/edit') ?>
                    document.getElementById("formEdit").action = linkaddr;
                    document.getElementById("Eid_nilai").value = jsonObj.id_nilai;
                    document.getElementById("Eid_siswa").value = jsonObj.id_siswa;
                    document.getElementById("Eid_kelas").value = jsonObj.id_kelas;
                    document.getElementById("Eid_matapelajaran").value = jsonObj.id_matapelajaran;
                    document.getElementById("Eid_guru").value = jsonObj.id_guru;
                    document.getElementById("Enama_siswa").value = jsonObj.nama_siswa;
                    document.getElementById("Enama_kelas").value = jsonObj.nama_kelas;
                    document.getElementById("Enama_matapelajaran").value = jsonObj.nama_matapelajaran;
                    document.getElementById("Enama_guru").value = jsonObj.nama_guru;
                    document.getElementById("EH1").value = jsonObj.H1;
                    document.getElementById("EH2").value = jsonObj.H2;
                    document.getElementById("EH3").value = jsonObj.H3;
                    document.getElementById("EH4").value = jsonObj.H4;
                    document.getElementById("EH5").value = jsonObj.H5;
                    document.getElementById("EH6").value = jsonObj.H6;
                    document.getElementById("EH7").value = jsonObj.H7;
                    document.getElementById("EH8").value = jsonObj.H8;
                    document.getElementById("EHPTS").value = jsonObj.nilai_uts;
                    document.getElementById("EHPAS").value = jsonObj.nilai_uas;
                    document.getElementById("EK1").value = jsonObj.K1;
                    document.getElementById("EK2").value = jsonObj.K2;
                    document.getElementById("EK3").value = jsonObj.K3;
                    document.getElementById("EK4").value = jsonObj.K4;
                    document.getElementById("EK5").value = jsonObj.K5;
                    document.getElementById("EK6").value = jsonObj.K6;
                    document.getElementById("EK7").value = jsonObj.K7;
                    document.getElementById("EK8").value = jsonObj.K8;
                    document.getElementById("EHPKTS").value = jsonObj.HPKTS;
                    document.getElementById("EHPKAS").value = jsonObj.HPKAS;
                }
            }
        }

        http_request.open("GET", data_file, true);
        http_request.send();
    }

    function ftableK(urld) {
        $('#exampleK').DataTable({
            'processing': true,
            'bVisible': true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "destroy": true,
            'serverMethod': 'get',
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            'ajax': {
                'url': urld,
                'dataSrc': "DataModule"
            },
            columnDefs: [{
                    width: "5px",
                    targets: [0]
                },
                {
                    width: "150px",
                    targets: [1, 2]
                },
                {
                    width: "5px",
                    className: 'dt-body-center',
                    targets: [3, 4, 5, 6, 7, 8, 9, 10, 11]
                }
            ],
            "columns": [{
                    "data": "row_num"
                },
                {
                    "data": "nama_siswa"
                }, {
                    "data": "nama_matapelajaran"
                },
                {
                    "data": "nama_kelas"
                },
                {
                    "data": "K1"
                },
                {
                    "data": "K2"
                },
                {
                    "data": "K3"
                },
                {
                    "data": "K4"
                },
                {
                    "data": "K5"
                },
                {
                    "data": "K6"
                },
                {
                    "data": "K7"
                },
                {
                    "data": "K8",
                },
                {
                    "data": "HPKTS"
                },
                {
                    "data": "HPKAS"
                },
                {
                    "data": null,
                    render: function(data, type, row, meta) {
                        const formatter = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0,
                        });
                        let a = 0;
                        let sum = 0;
                        let HPH = 0;
                        let HPA = 0;
                        let HPKTS = 0;
                        let HPKAS = 0;
                        if (data["HPKTS"]) HPKTS = parseInt(data["HPKTS"]);
                        if (data["HPKAS"]) HPKAS = parseInt(data["HPKAS"]);

                        for (i = 1; i < 8; i++) {
                            if (data["K" + i]) {
                                a = a + 1;
                                sum += parseInt(data["K" + i]);
                            }
                        }
                        if (sum > 0) HPH = sum / a;
                        HPA = (HPH * data['NK']) / 100 + (HPKTS * data['NHPKTS']) / 100 + (HPKAS * data['NHPKAS']) / 100;
                        return formatter.format(HPA);
                    }
                },
            ]
        });
    }

    $(document).ready(function() {
        var urldf = '<?= base_url('index.php/nilaisiswa/json/?id_kelas=') ?>' + $('#idid_kelas').find(":selected").val() + '&id_matapelajaran=' + $('#idid_matapelajaran').find(":selected").val();
        //alert(urldf);
        ftable(urldf);
        ftableK(urldf);
    });
    $('#ModalEdit').on('shown.bs.modal', function(e) {
        let triggerLink = $(e.relatedTarget);
        let id = triggerLink[0].dataset['id'];
        loadJSONGuruNilai('jsonCekNilai/?id_nilai=' + id, 'idnilai');
    })
    $('#idid_kelas').on('change', function() {
        var urldf = '<?= base_url('index.php/nilaisiswa/json/?id_kelas=') ?>' + $(this).find(":selected").val() + '&id_matapelajaran=' + $('#idid_matapelajaran').find(":selected").val();
        $('#example').DataTable().destroy();
        ftable(urldf);
        ftableK(urldf);
    });
    $('#idid_matapelajarannew').on('change', function() {
        loadJSONGuruNilai('jsonCekGuru/?id_matapelajaran=' + $(this).find(":selected").val(), 'idguru');
    });
    $('#idid_siswa').on('change', function() {
        //alert($(this).find(":selected").val());
        loadJSONGuruNilai('jsonCekKelas/?id_siswa=' + $(this).find(":selected").val(), 'idsiswa');
        loadJSONGuruNilai('jsonCekGuru/?id_matapelajaran=' + $('#idid_matapelajarannew').find(":selected").val(), 'idguru');
    });
    $('#idid_matapelajaran').on('change', function() {
        var urldf = '<?= base_url('index.php/nilaisiswa/json/?id_kelas=') ?>' + $('#idid_kelas').find(":selected").val() + '&id_matapelajaran=' + $(this).find(":selected").val();
        $('#example').DataTable().destroy();
        ftable(urldf);
        ftableK(urldf);
    });
    $('#ModalNew').on('shown.bs.modal', function() {
        loadJSONGuruNilai('jsonCekKelas/?id_siswa=' + $(this).find(":selected").val(), 'idsiswa');
        loadJSONGuruNilai('jsonCekGuru/?id_matapelajaran=' + $('#idid_matapelajarannew').find(":selected").val(), 'idguru');
    });
</script>
<?= $this->endSection() ?>