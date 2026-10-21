<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <!--
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
        -->
                <!-- /.col -->
                <!--
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
          -->
                <!-- /.col -->
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
                        <div class="card-header">
                            <h2>Data Transaksi SPP</h2>
                        </div>
                        <div class="card-header">
                            <?php
                            if ($session->get('start_date') && $session->get('end_date')) {
                                $start_date = $session->get('start_date');
                                $end_date = $session->get('end_date');
                            } else {
                                $start_date = $coockie->get_cookie('start_date');
                                $end_date = $coockie->get_cookie('end_date');
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <a data-target="#myModal" class="btn btn-app" data-toggle="modal">
                                        <span class="badge bg-purple">152</span><i class="fas fa-users"></i>Pilih Siswa SPP</a>
                                </div>
                                <div class="col-md-9">
                                    <table class="table table-bordered">
                                        <tr><?php if (isset($cekbeasiswa) && $cekbeasiswa["peserta"] == "yes") { ?>
                                                <td bgcolor=yellow align=center>
                                                    <h5>Siswa Beasiswa</h5>
                                                </td>
                                            <?php } ?>
                                            <td>
                                                <h5>Saldo Rp. <?php
                                                                if (isset($DetilSiswa)) {
                                                                    $saldo = ceksaldotabungan($DetilSiswa['id_siswa']);
                                                                    echo $saldo['SALDO'];
                                                                }

                                                                ?>
                                                </h5>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Pilih Siswa SPP</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php $session = \Config\Services::session();
                                    if ($session->getFlashdata('sukses')) { ?>
                                        <p class="alert alert-success"><?php echo $session->getFlashdata('sukses'); ?></p>
                                    <?php } ?>
                                    <div class="modal-body">
                                        <form action="<?php echo base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                            <table id="modalShow" class="table table-striped table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th width=100 scope="col">id_siswa</th>
                                                        <th scope="col">nama_siswa SPP</th>
                                                        <th scope="col">Kelas</th>
                                                        <th scope="col">Pilih</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (isset($DataSiswa)) {
                                                        foreach ($DataSiswa as $DataSiswa2) { ?>
                                                            <tr>
                                                                <td><?php echo $DataSiswa2['id_siswa']; ?></td>
                                                                <td><?php echo $DataSiswa2['nama_siswa']; ?></td>
                                                                <td><?php echo $DataSiswa2['nama_kelas']; ?></td>
                                                                <td><input type="radio" id="louie" name="id_siswa" value="<?php echo $DataSiswa2['id_siswa']; ?>"></td>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                            </table>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Pilih Siswa</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="ModalDebet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content bg-danger">
                                    <div class="modal-body">
                                        <?php if (isset($kodeTabungan)) {
                                            //dd($kodeTabungan); 
                                        ?> <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Entri Data Debet <br><?php echo "Nama : " . $DetilSiswa['nama_siswa'] . "<br>kode Tab : " . $kodeTabungan['kode_tab']; ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form name=modalEntriDebet action="<?php echo base_url('index.php/TataUsaha/Spp/saveDebet/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" onsubmit="return cek_null_entridebet()">
                                                <h4>Tanggal</h4>
                                                <div class="form-group">
                                                    <input name="tanggal" type="date" class="form-control" id="recipient-name" value="">
                                                    <input name="kode_tab_trans" type="hidden" class="form-control" id="recipient-name" value="<?php echo $kodeTabungan['kode_tab']; ?>">
                                                    <input name="id_siswa" type="hidden" class="form-control" id="recipient-name" value="<?php echo $DetilSiswa['id_siswa']; ?>">
                                                </div>
                                                <h4>Kode Tabungan Siswa</h4>
                                                <div class="form-group">
                                                    <input name="kode_tab" type="text" class="form-control" id="recipient-name" value="<?php echo $kodeTabungan['kode_tab']; ?>">
                                                </div>
                                                <h4>Kode Transaksi</h4>
                                                <div class="form-group">
                                                    <select name="NKKodeTransaksi" id="KKodeTransaksi" class="form-control">
                                                        <?php if (isset($dataKodeTransaksiDebet)) {
                                                            foreach ($dataKodeTransaksiDebet as $DataKodeTransaksiList) {
                                                        ?>
                                                                <option value="<?php echo $DataKodeTransaksiList['kode']; ?>"><?php echo $DataKodeTransaksiList['kode'] . "::" . $DataKodeTransaksiList['keterangan_kode']; ?></option>
                                                        <?PHP }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Rp</span>
                                                    <input name="rp" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Keterangan</span>
                                                    <input name="keterangan_trans" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Bukti Transfer</span>
                                                    <input name="buktitransfer" type="file" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">save</button>
                                                </div>
                                            </form>
                                        <?php } ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="ModalDSB" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content bg-yellow">
                                    <div class="modal-body">
                                        <?php if (isset($kodeTabungan)) {
                                            //dd($kodeTabungan); 
                                        ?> <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Entri Data DSB <br><?php echo "Nama : " . $DetilSiswa['nama_siswa'] . "<br>kode Tab : " . $kodeTabungan['kode_tab']; ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id=modalEntriDSB name=modalEntriDSB>
                                                <h4>Tanggal</h4>
                                                <div class="form-group">
                                                    <input name="tanggal" type="date" class="form-control" id="recipient-name" value="">
                                                    <input name="kode_tab" type="hidden" class="form-control" id="recipient-name" value="<?php echo $kodeTabungan['kode_tab']; ?>">
                                                    <input name="id_siswa" type="hidden" class="form-control" id="recipient-name" value="<?php echo $DetilSiswa['id_siswa']; ?>">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Rp</span>
                                                    <input name="rp" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Keterangan</span>
                                                    <input name="keterangan_trans" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Bukti Transfer</span>
                                                    <input name="buktitransfer" type="file" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">save</button>
                                                </div>
                                            </form>
                                        <?php } ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="ModalDU" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content bg-blue">
                                    <div class="modal-body">
                                        <?php if (isset($kodeTabungan)) {
                                            //dd($kodeTabungan); 
                                        ?> <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Entri Data Daftar Ulang <br><?php echo "Nama : " . $DetilSiswa['nama_siswa'] . "<br>kode Tab : " . $kodeTabungan['kode_tab']; ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id=modalEntriDU name=modalEntriDU>
                                                <h4>Tanggal</h4>
                                                <div class="form-group">
                                                    <input name="tanggal" type="date" class="form-control" id="recipient-name" value="">
                                                    <input name="kode_tab" type="hidden" class="form-control" id="recipient-name" value="<?php echo $kodeTabungan['kode_tab']; ?>">
                                                    <input name="id_siswa" type="hidden" class="form-control" id="recipient-name" value="<?php echo $DetilSiswa['id_siswa']; ?>">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Rp</span>
                                                    <input name="rp" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Keterangan</span>
                                                    <input name="keterangan_trans" type="text" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Bukti Transfer</span>
                                                    <input name="buktitransfer" type="file" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-secondary">save</button>
                                                </div>
                                            </form>
                                        <?php } ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <?php $session = \Config\Services::session();
                        if ($session->getFlashdata('sukses')) { ?>
                            <p class="alert alert-success"><?php echo $session->getFlashdata('sukses'); ?></p>
                        <?php } ?>
                        <?php if (isset($DataTabunganSiswa)) {
                        ?>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">

                                        <div class="card card-primary card-outline">
                                            <div class="card-body box-profile">
                                                <div class="text-center">
                                                    <img class="profile-user-img img-fluid img-circle" src="data:image/png;base64,<?php echo $DetilSiswa['image']; ?>" alt="User profile picture">
                                                </div>
                                                <h3 class="profile-username text-center"><?php echo $DetilSiswa['nama_siswa']; ?></h3>
                                                <p class="text-muted text-center">Siswa Arafah</p>
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>Alamat</b> <a class="float-right"><?php echo $DetilSiswa['alamat_siswa']; ?></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Nis</b> <a class="float-right"><?php echo $DetilSiswa['nis']; ?></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Kelas</b> <a class="float-right"><?php echo $DetilSiswa['nama_kelas']; ?></a>
                                                    </li>
                                                </ul>
                                                <a href="#" class="btn btn-primary btn-block"><b>Detil</b></a>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">


                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalDebet"><i class="fas fa-plus"></i> (SPP/LDR/KES)</button>
                                            <BR><BR>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-primary card-tabs">
                                                        <div class="card-header p-0 pt-1">
                                                            <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" id="custom-tabs-five-overlay-tab" data-toggle="pill" href="#custom-tabs-five-overlay" role="tab" aria-controls="custom-tabs-five-overlay" aria-selected="true">Debit All dari Juli</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="#tabdsb" data-toggle="pill" href="#dsb" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Dana Siswa Baru</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#du" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Daftar Ulang</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="custom-tabs-five-overlay-dark-tab" data-toggle="pill" href="#custom-tabs-five-overlay-dark" role="tab" aria-controls="custom-tabs-five-overlay-dark" aria-selected="false">Debit SPP ALL</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#custom-tabs-five-normal" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Debit Loundry All</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#custom-tabs-five-normal2" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Debit Kesehatan All</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="tab-content" id="custom-tabs-five-tabContent">
                                                                <div class="tab-pane fade active show" id="custom-tabs-five-overlay" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-tab">
                                                                    <div class="overlay-wrapper">
                                                                        <table class="table table-striped table-bordered table-sm">
                                                                            <thead>
                                                                                <tr>
                                                                                    <!-- <th width=100 scope="col"></th> -->
                                                                                    <th scope="col">No</th>
                                                                                    <th scope="col">Pembayaran</th>
                                                                                    <th scope="col">Jumlah Bulan</th>
                                                                                    <th scope="col">Tarif</th>
                                                                                    <th bgcolor=#c6ff1a>Total Sudah di bayar</th>
                                                                                    <th bgcolor=#ff8566>Total Tarif</th>
                                                                                    <th scope="col" width=25%>Selisih</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>1</td>
                                                                                    <td>SPP</td>
                                                                                    <td><?php echo $countMonth["MONTH"] + 1; ?></td>
                                                                                    <td align=right><?php echo number_format((float)$tarifspp, 0, ',', '.'); ?></td>
                                                                                    <td align=right> <?php if (isset($sumDebitSpp)) {
                                                                                                            echo number_format(isset($sumDebitSpp["TOTALSPP"]), 0);
                                                                                                        } ?></td>
                                                                                    <td align=right>
                                                                                        <?php
                                                                                        $totalspp = $tarifspp * ($countMonth["MONTH"] + 1);
                                                                                        echo number_format((float)$totalspp, 0, ',', '.');
                                                                                        ?>
                                                                                    </td>
                                                                                    <td align=right>
                                                                                        <?php
                                                                                        echo  number_format($sumDebitSpp["TOTALSPP"] - $totalspp, 0);
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>2</td>
                                                                                    <td>Loundry</td>
                                                                                    <td><?php echo $countMonth["MONTH"] + 1; ?></td>
                                                                                    <td align=right><?php echo number_format((float)$tarifldr, 0, ',', '.'); ?></td>
                                                                                    <td align=right>
                                                                                        <?php
                                                                                        if (isset($sumDebitLdr)) {
                                                                                            echo number_format(isset($sumDebitLdr["TOTALLDR"]), 0);
                                                                                        }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td align=right>
                                                                                        <?php
                                                                                        $totalldr = $tarifldr * ($countMonth["MONTH"] + 1);
                                                                                        echo number_format((float)$totalldr, 0, ',', '.');
                                                                                        ?>
                                                                                    </td>
                                                                                    <td align=right>
                                                                                        <?php
                                                                                        echo number_format($sumDebitLdr["TOTALLDR"] - $totalldr, 0);
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>3</td>
                                                                                    <td>Kesehatan</td>
                                                                                    <td><?php echo $countMonth["MONTH"] + 1; ?></td>
                                                                                    <td align=right><?php echo number_format((float)$tarifkes, 0, ',', '.'); ?></td>
                                                                                    <td align=right>
                                                                                        <?php
                                                                                        if (isset($sumDebitKes)) {
                                                                                            echo number_format(isset($sumDebitKes["TOTALKES"]), 0);
                                                                                        }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td align=right>
                                                                                        <?php
                                                                                        $totalkes = $tarifkes * ($countMonth["MONTH"] + 1);
                                                                                        echo number_format((float)$totalkes, 0, ',', '.');
                                                                                        ?>
                                                                                    </td>
                                                                                    <td align=right>
                                                                                        <?php
                                                                                        echo number_format($sumDebitKes["TOTALKES"] - $totalkes, 0);
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="custom-tabs-five-overlay-dark" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-dark-tab">
                                                                    <div class="overlay-wrapper">
                                                                        <table id="tspp" class="table table-striped table-bordered table-sm">
                                                                            <thead>
                                                                                <tr>
                                                                                    <!-- <th width=100 scope="col"></th> -->
                                                                                    <th scope="col">No</th>
                                                                                    <th scope="col">Kode Tabungan</th>
                                                                                    <th scope="col">Tanggal</th>
                                                                                    <th scope="col">Kode</th>
                                                                                    <th scope="col">Debit</th>
                                                                                    <th scope="col" width=25%>Keterangan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $i = 1;
                                                                                foreach ($dataDebitSpp as $DataMenuv) { ?>
                                                                                    <tr>
                                                                                        <td><?php echo $i;
                                                                                            $i++; ?></td>
                                                                                        <td><?php echo $DataMenuv['kode_tab_trans']; ?></td>
                                                                                        <td><?php echo $DataMenuv['tanggal']; ?></td>
                                                                                        <td><?php echo $DataMenuv['kodetransaksi']; ?></td>
                                                                                        <td align=right><?php echo number_format((float)$DataMenuv['rp'], 0, ',', '.'); ?></td>
                                                                                        <td><?php echo $DataMenuv['keterangan_trans']; ?></td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="custom-tabs-five-normal" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                                                    <table id="tldr" class="table table-striped table-bordered table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <!-- <th width=100 scope="col"></th> -->
                                                                                <th scope="col">No</th>
                                                                                <th scope="col">Kode Tabungan</th>
                                                                                <th scope="col">Tanggal</th>
                                                                                <th scope="col">Kode</th>
                                                                                <th scope="col">Debit</th>
                                                                                <th scope="col" width=25%>Keterangan</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $i = 1;
                                                                            foreach ($dataDebitLdr as $DataMenuv) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i;
                                                                                        $i++; ?></td>
                                                                                    <td><?php echo $DataMenuv['kode_tab_trans']; ?></td>
                                                                                    <td><?php echo $DataMenuv['tanggal']; ?></td>
                                                                                    <td><?php echo $DataMenuv['kodetransaksi']; ?></td>
                                                                                    <td align=right><?php echo number_format((float)$DataMenuv['rp'], 0, ',', '.'); ?></td>
                                                                                    <td><?php echo $DataMenuv['keterangan_trans']; ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="tab-pane fade" id="custom-tabs-five-normal2" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                                                    <table id="tkes" class="table table-striped table-bordered table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <!-- <th width=100 scope="col"></th> -->
                                                                                <th scope="col">No</th>
                                                                                <th scope="col">Kode Tabungan</th>
                                                                                <th scope="col">Tanggal</th>
                                                                                <th scope="col">Kode</th>
                                                                                <th scope="col">Debit</th>
                                                                                <th scope="col" width=25%>Keterangan</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $i = 1;
                                                                            foreach ($dataDebitKes as $DataMenuv) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i;
                                                                                        $i++; ?></td>
                                                                                    <td><?php echo $DataMenuv['kode_tab_trans']; ?></td>
                                                                                    <td><?php echo $DataMenuv['tanggal']; ?></td>
                                                                                    <td><?php echo $DataMenuv['kodetransaksi']; ?></td>
                                                                                    <td align=right><?php echo number_format((float)$DataMenuv['rp'], 0, ',', '.'); ?></td>
                                                                                    <td><?php echo $DataMenuv['keterangan_trans']; ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="tab-pane fade" id="du" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalDU" onclick="addDU()"><i class="fas fa-plus"></i> DU</button>
                                                                    <table id="tdu" class="table table-striped table-bordered table-sm">
                                                                    </table>
                                                                </div>
                                                                <div class="tab-pane fade" id="dsb" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ModalDSB" onclick="addDSB()"><i class="fas fa-plus"></i> DSB</button>
                                                                    <table id="tdsb" class="table table-striped table-bordered table-sm">
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

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
<script src="<?php echo BPATH; ?>/asset/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/js/VSpp.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php //echo BPATH; 
                    ?>/asset/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>
<!-- Page specific script -->
<script>
    var deleteDSBUrl = '<?php echo base_url('index.php/TataUsaha/Spp/deleteDSB/' . $menuAktip . "/" . $moduleAktip) ?>';
    var deleteDUUrl = '<?php echo base_url('index.php/TataUsaha/Spp/deleteDU/' . $menuAktip . "/" . $moduleAktip) ?>';
    var addDSBUrl = '<?php echo base_url('index.php/TataUsaha/Spp/saveDSB/' . $menuAktip . "/" . $moduleAktip) ?>';
    var addDUUrl = '<?php echo base_url('index.php/TataUsaha/Spp/saveDU/' . $menuAktip . "/" . $moduleAktip) ?>';
</script>
<?php if (!isset($DataTabunganSiswa)) { ?>
    <script>
        $('#myModal').modal({
            show: true
        })
    </script>
<?php } ?>

<?php if (isset($DetilSiswa)) { ?>
    <script>
        var tdsbDatatables = '<?= base_url('index.php/TataUsaha/Spp/readjsonDSB/' . $menuAktip . '/' . $moduleAktip . "?id_siswa=" . $DetilSiswa["id_siswa"]) ?>';
        var tduDatatables = '<?= base_url('index.php/TataUsaha/Spp/readjsonDU/' . $menuAktip . '/' . $moduleAktip . "?id_siswa=" . $DetilSiswa["id_siswa"]) ?>';
    </script>
    <script src="<?php echo BPATH; ?>/asset/js/Datatables.js"></script>
<?php } ?>
<?= $this->endSection() ?>