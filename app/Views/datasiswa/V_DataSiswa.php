<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Siswa </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">

            <?php if (session('error')) : ?>
              <div class="alert alert-danger">
                <?= session('error') ?>
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
              </div>
            <?php endif ?>
            <?php if (session('msg')) : ?>
              <div class="alert alert-success">
                <?= session('msg') ?>
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
              </div>
            <?php endif ?>

            <div class="card-body">
              <!-- Modal new  -->
              <div class="modal fade" id="databaru" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="card card-primary">
                      <h5 class="card-header" id="exampleModalLabel">New Data Siswa</h5>
                    </div>
                    <div class="modal-body">
                      <form action="<?php echo base_url('index.php/datasiswa/tambah/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                          <span class="input-group-text">NIS</span>
                          <input name="nis" type="text" class="form-control" value="">
                          <span class="input-group-text">NISN</span>
                          <input name="nisn" type="text" class="form-control" value="">
                          <span class="input-group-text">Unik CODE</span>
                          <input name="unik" type="text" class="form-control" value="">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">Nama Siswa</span>
                          <input name="nama_siswa" type="text" class="form-control" value="">
                          <span class="input-group-text">Jenis Kelamin</span>
                          <input name="kelamin" type="text" class="form-control" value="">
                          <span class="input-group-text">Email</span>
                          <input name="email" type="text" class="form-control" value="">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">Alamat</span>
                          <textarea name="alamat_siswa" class="form-control" id="message-text"></textarea>
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">Nama Orang Tua</span>
                          <input name="nama_ortu" type="text" class="form-control" value="">
                          <span class="input-group-text">Telp</span>
                          <input name="telpon_siswa" type="text" class="form-control" value="">
                        </div>
                        <div class="input-group mb-3">

                          <span class="input-group-text">Status</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="locked" id="exampleRadios1" value="baru" checked>
                            <label class="form-check-label" for="exampleRadios1">
                              Mahasiswa baru
                            </label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="locked" id="exampleRadios2" value="no">
                            <label class="form-check-label" for="exampleRadios2">
                              Aktif
                            </label>
                          </div>
                          <div class="form-check  form-check-inline">
                            <input class="form-check-input" type="radio" name="locked" id="exampleRadios3" value="yes">
                            <label class="form-check-label" for="exampleRadios3">
                              Tidak Aktif
                            </label>
                          </div>
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">Periode</span>
                          <input name="id_periode" type="text" class="form-control" value="2023">
                          <span class="input-group-text">Tanggal Masuk</span>
                          <input name="tanggal_masuk" type="date" class="form-control" value="">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">Photo Kegiatan</span>
                          <input name="photo" type="text" class="form-control" value="">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">Tempat lahir</span>
                          <input name="tempat_lahir" type="text" class="form-control" value="">
                          <span class="input-group-text">tanggal_lahir</span>
                          <input name="tanggal_lahir" type="date" class="form-control" value="">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">Foto</span>
                          <input name="image" id="inputfotonew" type="file" class="form-control" value="">

                        </div>
                        <div id="imagenew"></div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">keterangan</span>
                          <input name="keterangan" type="text" class="form-control" value="">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button class="btn btn-primary"><i class="fas fa-save"> Save</i></button>
                        </div>
                      </form>
                    </div>

                  </div>
                </div>
              </div>
              <!-- /Modal new -->
              <div class="card-header">
                <form action="<?php echo base_url('index.php/datasiswa/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="get">
                  <label for="start">Masukan Nama Siswa (% untuk semua data) &nbsp;&nbsp;&nbsp;</label>
                  <input type="text" name="nama_siswa" value="<?php echo $nama_siswa; ?>">&nbsp;&nbsp;&nbsp;
                  <label for="start">Tampilkan hanya siswa baru saja &nbsp;&nbsp;&nbsp;</label>
                  <input type="checkbox" name="siswa_baru" value="baru">&nbsp;&nbsp;&nbsp;
                  <button data-toggle="modal" data-target="#ModalAllert">Cari</button>
                </form>
              </div><br>
              <p>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#databaru" class="btn btn-primary"><i class="fas fa-folder-plus"></i>New Data</button>
              </p>

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width=100 scope="col"></th>
                    <th scope="col">id</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">nis</th>
                    <th scope="col">kelamin</th>
                    <th scope="col">alamat_siswa</th>
                    <th scope="col">telpon_siswa</th>
                    <th scope="col">email</th>
                    <th scope="col">username</th>
                    <th scope="col">password</th>
                    <th scope="col">locked</th>
                    <th scope="col">id_periode</th>
                    <th scope="col">photo</th>
                    <th scope="col">tanggal_masuk</th>
                    <th scope="col">tempat_lahir</th>
                    <th scope="col">tanggal_lahir</th>
                    <th scope="col">nama_ortu</th>
                    <th scope="col">nisn</th>
                    <th scope="col">keterangan</th>
                    <th scope="col">unik</th>

                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($DataSiswa as $DataSiswav) { ?>
                    <tr>
                      <td>
                        <button type="button" class="btn btn-primary" data-id="<?= $DataSiswav['id_siswa'] ?>" data-toggle="modal" data-target="#ModalEdit"><i class="fas fa-pencil-alt" title="Edit Data"></i></button>
                        <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#Modaledit<?php echo $DataSiswav['id_siswa']; ?>" type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button> -->
                        <button class="btn btn-primary btn-danger" data-toggle="modal" data-target="#Modalhapus<?php echo $DataSiswav['id_siswa']; ?>" type="button" class="btn btn-primary"><i class="fas fa-trash"></i></button>
                      </td>
                      <td><?php echo $DataSiswav['id_siswa']; ?></td>
                      <td>
                        <?php
                        if (isset($DataSiswav['image']) && !$DataSiswav['image'] == "") {
                          $srcfoto = "data:image/png;base64," . $DataSiswav['image'];
                          $altfoto = $DataSiswav['nama_siswa'];
                        } else {
                          $srcfoto = base_url() . "/uploads/images/no-image-icon-33.png";
                          $altfoto = "Foto Tidak ada";
                        }
                        ?>
                        <button type="button" class="btn btn-secondary" data-id="<?= $DataSiswav['id_siswa'] ?>" data-toggle="modal" data-target="#ModalFoto"><i class="far fa-eye" title="Edit Data"></i></button>
                      </td>
                      <td><?php echo $DataSiswav['nama_siswa']; ?></td>
                      <td><?php echo $DataSiswav['nis']; ?></td>
                      <td><?php echo $DataSiswav['kelamin']; ?></td>
                      <td><?php echo $DataSiswav['alamat_siswa']; ?></td>
                      <td><?php echo $DataSiswav['telpon_siswa']; ?></td>
                      <td><?php echo $DataSiswav['email']; ?></td>
                      <td><?php echo $DataSiswav['username']; ?></td>
                      <td><?php echo $DataSiswav['password']; ?></td>
                      <td><?php echo $DataSiswav['locked']; ?></td>
                      <td><?php echo $DataSiswav['id_periode']; ?></td>
                      <td><?php echo $DataSiswav['photo']; ?></td>
                      <td><?php echo $DataSiswav['tanggal_masuk']; ?></td>
                      <td><?php echo $DataSiswav['tempat_lahir']; ?></td>
                      <td><?php echo $DataSiswav['tanggal_lahir']; ?></td>
                      <td><?php echo $DataSiswav['nama_ortu']; ?></td>
                      <td><?php echo $DataSiswav['nisn']; ?></td>
                      <td><?php echo $DataSiswav['keterangan']; ?></td>
                      <td><?php echo $DataSiswav['unik']; ?></td>

                    </tr>

                    <!-- Modal Edit  -->
                    <div class="modal fade" id="Modaledit<?php echo $DataSiswav['id_siswa']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="card card-primary">
                            <h5 class="card-header" id="exampleModalLabel">Data Siswa</h5>
                          </div>
                          <div class="modal-body">
                            <form action="<?php echo base_url('index.php/datasiswa/edit/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">ID Siswa</span>
                                <input name="id_siswa" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['id_siswa']; ?>">
                                <span class="input-group-text" id="basic-addon3">NIS</span>
                                <input name="nis" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['nis']; ?>">
                                <span class="input-group-text" id="basic-addon3">NISN</span>
                                <input name="nisn" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['nisn']; ?>">
                                <span class="input-group-text" id="basic-addon3">Unik CODE</span>
                                <input name="unik" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['unik']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">Nama Siswa</span>
                                <input name="nama_siswa" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['nama_siswa']; ?>">
                                <span class="input-group-text" id="basic-addon3">Jenis Kelamin</span>
                                <input name="kelamin" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['kelamin']; ?>">
                                <span class="input-group-text" id="basic-addon3">Email</span>
                                <input name="email" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['email']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">Alamat</span>
                                <textarea name="alamat_siswa" class="form-control" id="message-text"><?php echo $DataSiswav['alamat_siswa']; ?></textarea>
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">Nama Orang Tua</span>
                                <input name="nama_ortu" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['nama_ortu']; ?>">
                                <span class="input-group-text" id="basic-addon3">Telp</span>
                                <input name="telpon_siswa" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['telpon_siswa']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <?php $cbaru = "";
                                $caktif = "";
                                $ctidakaktif = "";
                                if (trim($DataSiswav['locked']) == "baru") {
                                  $cbaru = "checked";
                                } elseif (trim($DataSiswav['locked']) == "no") {
                                  $caktif = "checked";
                                } else {
                                  $ctidakaktif = "checked";
                                }

                                ?>
                                <span class="input-group-text" id="basic-addon3">Status</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="locked" id="exampleRadios1" value="baru" <?php echo $cbaru; ?>>
                                  <label class="form-check-label" for="exampleRadios1">
                                    Mahasiswa baru
                                  </label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="locked" id="exampleRadios2" value="no" <?php echo $caktif; ?>>
                                  <label class="form-check-label" for="exampleRadios2">
                                    Aktif
                                  </label>
                                </div>
                                <div class="form-check  form-check-inline">
                                  <input class="form-check-input" type="radio" name="locked" id="exampleRadios3" value="yes" <?php echo $ctidakaktif; ?>>
                                  <label class="form-check-label" for="exampleRadios3">
                                    Tidak Aktif
                                  </label>
                                </div>
                                <span class="input-group-text" id="basic-addon1">Periode</span>
                                <input name="id_periode" type="text" class="form-control" value="<?php echo $DataSiswav['id_periode']; ?>">
                              </div>


                              <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">Tgl Masuk</span>
                                <input name="tanggal_masuk" type="date" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['tanggal_masuk']; ?>">
                                <span class="input-group-text" id="basic-addon3">Tempat lahir</span>
                                <input name="tempat_lahir" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['tempat_lahir']; ?>">
                                <span class="input-group-text" id="basic-addon3">Tgl Lahir</span>
                                <input name="tanggal_lahir" type="date" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['tanggal_lahir']; ?>">
                              </div>

                              <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">keterangan</span>
                                <input name="keterangan" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['keterangan']; ?>">
                              </div>

                              <div class="row">
                                <div class="col-12">
                                  <div class="d-flex justify-content-center">
                                    <img src="<?= $srcfoto ?>" class="img-circle" alt="<?= $altfoto ?>" width="200" title="<?= $altfoto ?>">
                                    <!--- PREVIEW --->
                                    <div id="preview<?php echo $DataSiswav['id_siswa']; ?>"></div>

                                  </div>

                                  <div class="d-flex justify-content-center">
                                    <div class="col-6">
                                      <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon3">Foto</span>
                                        <input name="image" type="file" id="inputfoto" class="form-control" id="imageEdit" onchange="imagePreview(this, '#preview<?php echo $DataSiswav['id_siswa']; ?>');" value="">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary"><i class="fas fa-save"> Save</i></button>
                              </div>
                            </form>
                          </div>

                        </div>
                      </div>
                    </div>
                    <!-- /Modal Edit -->
                    <!-- Modal hapus -->
                    <div class="modal fade" id="Modalhapus<?php echo $DataSiswav['id_siswa']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content bg-danger">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Data Siswa Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?php echo base_url('index.php/datasiswa/hapus/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">ID Siswa</span>
                                <input name="id_siswa" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['id_siswa']; ?>">
                              </div>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">Nama</span>
                                <input name="nama_siswa" type="text" class="form-control" id="recipient-name" value="<?php echo $DataSiswav['nama_siswa']; ?>">
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-secondary" onclick="return confirm('Yakin ingin menghapus kategori ini?')"><i class="fas fa-trash">Hapus</i></button>
                              </div>
                            </form>
                          </div>

                        </div>
                      </div>
                    </div>
                    <!-- /Modal hapus -->
                  <?php } ?>
                </tbody>
              </table>
              <!-- /Modet edit JSON -->
              <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="card card-primary">
                      <h5 class="card-header" id="exampleModalLabel">Data Siswa</h5>
                    </div>
                    <div id="LoadingImageEdit" style="display: none">
                      <center><img src="<?= base_url() ?>/uploads/Loading_2.gif" /></center>
                    </div>
                    <div id="modaledit" class="modal-body" style="display: none">
                      <form action="<?php echo base_url('index.php/datasiswa/edit/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                          <span class="input-group-text">Unik CODE</span>
                          <input id="unik" name="unik" class="form-control">
                          <span class="input-group-text">ID Siswa</span>
                          <input name="id_siswa" id="id_siswa" type="text" class="form-control">
                          <span class="input-group-text">NIS</span>
                          <input name="nis" id="nis" type="text" class="form-control">
                          <span class="input-group-text">NISN</span>
                          <input name="nisn" id="nisn" type="text" class="form-control">

                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">Nama Siswa</span>
                          <input name="nama_siswa" id="nama_siswa" type="text" class="form-control">
                          <span class="input-group-text">Jenis Kelamin</span>
                          <input name="kelamin" id="kelamin" type="text" class="form-control">
                          <span class="input-group-text">Email</span>
                          <input name="email" id="email" type="text" class="form-control">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">Alamat</span>
                          <textarea name="alamat_siswa" id="alamat_siswa" class="form-control" id="message-text"></textarea>
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text">Nama Orang Tua</span>
                          <input name="nama_ortu" id="nama_ortu" type="text" class="form-control">
                          <span class="input-group-text">Telp</span>
                          <input name="telpon_siswa" id="telpon_siswa" type="text" class="form-control">
                        </div>
                        <div class="input-group mb-3">

                          <span class="input-group-text">Status</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <div class="form-check form-check-inline">
                            <input type="radio" name="locked" id="locked1" value="baru">
                            <label class="form-check-label" for="exampleRadios1">&nbsp;&nbsp;
                              Mahasiswa baru
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="locked" id="locked2" value="no">&nbsp;&nbsp;
                            <label class="form-check-label" for="exampleRadios2">
                              Aktif
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="locked" id="locked3" value="yes">&nbsp;&nbsp;
                            <label class="form-check-label" for="exampleRadios3">
                              Tidak Aktif
                            </label>
                          </div>
                          <span class="input-group-text">Periode</span>
                          <input name="id_periode" id="id_periode" type="text" class="form-control">
                        </div>


                        <div class="input-group mb-3">

                          <span class="input-group-text">Tgl Masuk</span>
                          <input name="tanggal_masuk" id="tanggal_masuk" type="date" class="form-control">
                          <span class="input-group-text">Tempat lahir</span>
                          <input name="tempat_lahir" id="tempat_lahir" type="text" class="form-control">
                          <span class="input-group-text">Tgl Lahir</span>
                          <input name="tanggal_lahir" id="tanggal_lahir" type="date" class="form-control">
                        </div>

                        <div class="input-group mb-3">

                          <span class="input-group-text">keterangan</span>
                          <input name="keterangan" id="keterangan" type="text" class="form-control" value="">
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <div class="d-flex justify-content-center">
                              <img id=image src="" class="img-circle" alt="" width="200" title="">
                              <!--- PREVIEW --->
                              <div id="preview"></div>

                            </div>

                            <div class="row">
                              <div class="col-12">

                                <div class="d-flex justify-content-center">
                                  <div class="col-6">
                                    <div class="input-group mb-6">
                                      <span class="input-group-text" id="basic-addon3">Foto</span>
                                      <input name="image" type="file" id="inputfoto" class="form-control" id="imageEdit" onchange="imagePreview(this, '#preview');" value="">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button class="btn btn-primary"><i class="fas fa-save"> Save</i></button>
                        </div>
                      </form>
                    </div>

                  </div>
                </div>
              </div>

              <!-- /End Modal edit JSON -->
              <!-- modal Foto -->
              <div class="modal fade" id="ModalFoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="card card-primary">
                      <h5 class="card-header" id="exampleModalLabel">Foto Siswa</h5>
                    </div>
                    <div id="LoadingImage" style="display: none">
                      <center><img src="<?= base_url() ?>/uploads/Loading_2.gif" /></center>
                    </div>
                    <div class="modal-body">
                      <img id=imageFoto src="" alt="" width="300" title="" style="display: none">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal foto -->
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
<!-- Bootstrap 4 -->
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo BPATH; ?>/asset/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo BPATH; ?>/asset/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo BPATH; ?>/asset/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo BPATH; ?>/asset/plugins/moment/moment.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo BPATH; ?>/asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo BPATH; ?>/asset/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo BPATH; ?>/asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>

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
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php //echo base_url(); 
                  ?>/asset/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>
<!-- Page specific script -->
<script>
  function imagePreview(fileInput, selector) {
    if (fileInput.files && fileInput.files[0]) {
      var fileReader = new FileReader();
      fileReader.onload = function(event) {
        $(selector).html('<br><br><img src="<?php echo BPATH; ?>/images/panah.jpg" width="50"><img src="' + event.target.result + '" width="200" height="auto"/>');
      };
      fileReader.readAsDataURL(fileInput.files[0]);
    }
  }

  function loadJSONDetilSiswa(link, selectId) {
    var data_file = "<?php echo base_url() . '/index.php/datasiswa/' ?>" + link;
    var http_request = new XMLHttpRequest();

    try {
      // Opera 8.0+, Firefox, Chrome, Safari membuat popau
      $("#modaledit").hide();
      $("#LoadingImageEdit").show();
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
        if (selectId === 'idsiswa') {
          document.getElementById("tanggal_masuk").value = jsonObj.tanggal_masuk;
          document.getElementById("tanggal_lahir").value = jsonObj.tanggal_lahir;
          document.getElementById("tempat_lahir").value = jsonObj.tempat_lahir;
          document.getElementById("id_periode").value = jsonObj.id_periode;
          document.getElementById("nama_ortu").value = jsonObj.nama_ortu;
          document.getElementById("nis").value = jsonObj.nis;
          document.getElementById("id_siswa").value = jsonObj.id_siswa;
          document.getElementById("nama_siswa").value = jsonObj.nama_siswa;
          document.getElementById("unik").value = jsonObj.unik;
          document.getElementById("nisn").value = jsonObj.nisn;
          document.getElementById("kelamin").value = jsonObj.kelamin;
          document.getElementById("alamat_siswa").innerHTML = jsonObj.alamat_siswa;
          document.getElementById("telpon_siswa").value = jsonObj.telpon_siswa;
          document.getElementById("email").value = jsonObj.email;
          //document.getElementById("keterangan").value = jsonObj.keterangan;
          $("#keterangan").attr("value", jsonObj.keterangan);
          if (jsonObj.image) {
            $("#image").attr("src", "data:image/png;base64," + jsonObj.image);
          } else {
            $("#image").attr("src", "<?= base_url() ?>" + "/uploads/images/no-image-icon-33.png");
          }

          if (jsonObj.locked == "no") {
            $("#locked2").prop('checked', true);
          } else if (jsonObj.locked == "baru") {
            $("#locked1").prop('checked', true);
          } else {
            $("#locked3").prop('checked', true);
          }
          $("#LoadingImageEdit").hide();
          $("#modaledit").show();
        }
      }
    }

    http_request.open("GET", data_file, true);
    http_request.send();
  }

  function loadFoto(link, selectId) {
    var data_file = "<?php echo base_url() . '/index.php/datasiswa/' ?>" + link;
    var http_request = new XMLHttpRequest();

    try {
      // Opera 8.0+, Firefox, Chrome, Safari membuat popau
      $("#imageFoto").hide();
      $("#LoadingImage").show();
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
        if (selectId === 'idsiswa') {

          if (jsonObj.image) {
            $("#imageFoto").attr("src", "data:image/png;base64," + jsonObj.image);
          } else {
            $("#imageFoto").attr("src", "<?= base_url() ?>" + "/uploads/images/no-image-icon-33.png");
          }
          $("#LoadingImage").hide();
          $("#imageFoto").show();

        }
      }
    }

    http_request.open("GET", data_file, true);
    http_request.send();
  }

  // $('#inputfoto').on("change", function() {
  //   imagePreview(this, '#preview');
  // });
  $('#inputfotonew').on("change", function() {
    imagePreview(this, '#imagenew');
  });
  // $("#imageEdit").on("change", function() {
  //imagePreview(this);
  // });
  $('#ModalEdit').on('shown.bs.modal', function(e) {
    let triggerLink = $(e.relatedTarget);
    let id = triggerLink[0].dataset['id'];
    loadJSONDetilSiswa('JSON/?id_siswa=' + id, 'idsiswa');
  })
  $('#ModalFoto').on('shown.bs.modal', function(e) {
    let triggerLink = $(e.relatedTarget);
    let id = triggerLink[0].dataset['id'];
    loadFoto('JSON/?id_siswa=' + id, 'idsiswa');
  })
  $('#modalButton').click(function() {
    $('#modal').modal('show')
      .find('#modalContent')
      .load($(this).attr('value'));
  });
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
      "lengthChange": false,
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