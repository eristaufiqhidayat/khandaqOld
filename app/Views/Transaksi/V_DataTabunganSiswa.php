<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<?php

$session = \Config\Services::session();
$coockie = \Config\Services::response();
$request = \Config\Services::request();

$menuAktip = $menuAktip ?? '';
$moduleAktip = $moduleAktip ?? '';

$DetilSiswa = $DetilSiswa ?? [
    'id_siswa' => '',
    'nama_siswa' => '',
    'alamat_siswa' => '',
    'nis' => '',
    'nama_kelas' => '',
    'image' => '',
];
$DataSiswa = $DataSiswa ?? [];
$DataTabunganSiswa = $DataTabunganSiswa ?? [];

$kodeTabungan = $kodeTabungan ?? [
    'kode_tab' => '',
];

$dataKodeTransaksiKredit = $dataKodeTransaksiKredit ?? [];
$dataKodeTransaksiDebet = $dataKodeTransaksiDebet ?? [];

$cekspp = $cekspp ?? [];
$cekloundry = $cekloundry ?? false;

$bulanbayar = $bulanbayar ?? 0;
$bulanbayarldr = $bulanbayarldr ?? 0;
$bulanbayarkes = $bulanbayarkes ?? 0;

$tarifspp = $tarifspp ?? 0;
$tarifldr = $tarifldr ?? 0;
$tarifkes = $tarifkes ?? 0;

$readonly = [];
$readonlyldr = [];
$readonlykes = [];

for ($i = 1; $i <= 12; $i++) {
    $readonly[$i] = '';
    $readonlyldr[$i] = '';
    $readonlykes[$i] = '';
}

?>
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

                        <div class="card-header">
                            <h2>Data Transaksi Tabungan</h2>
                        </div>
                        <div class="card-header">
                            <?php
                            if ($session->get('start_date') && $session->get('end_date')) {

                                $start_date = $session->get('start_date');
                                $end_date = $session->get('end_date');
                            } else {

                                $start_date = $request->getCookie('start_date');
                                $end_date = $request->getCookie('end_date');
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <a data-target="#myModal" class="btn btn-app" data-toggle="modal">
                                        <span class="badge bg-purple">152</span><i class="fas fa-users"></i>Pilih Siswa</a>
                                </div>
                                <div class="col-md-9">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>
                                                <h5>Saldo Rp. <?php
                                                                if (isset($DetilSiswa)) {
                                                                    $saldo = ceksaldotabungan($DetilSiswa['id_siswa']);
                                                                    echo number_format((float)$saldo['SALDO'], 0, ',', '.');
                                                                }

                                                                ?>
                                                </h5>
                                            </td>
                                            <td bgcolor=#c6ff1a>
                                                <h5>Kredit Rp. <?php
                                                                if (isset($DetilSiswa)) {
                                                                    $saldo = cekkredittabungan($DetilSiswa['id_siswa']);
                                                                    echo number_format((float)$saldo['KREDIT'], 0, ',', '.');;
                                                                }

                                                                ?>
                                                </h5>
                                            </td>
                                            <td bgcolor=#ff8566>
                                                <h5>Debet Rp. <?php
                                                                if (isset($DetilSiswa)) {
                                                                    $saldo = cekdebettabungan($DetilSiswa['id_siswa']);
                                                                    echo number_format((float)$saldo['DEBET'], 0, ',', '.');;
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
                                        <h5 class="modal-title" id="exampleModalLabel">Pilih Siswa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php $session = \Config\Services::session();
                                    if ($session->getFlashdata('sukses')) { ?>
                                        <p class="alert alert-success"><?php echo $session->getFlashdata('sukses'); ?></p>
                                    <?php } ?>
                                    <div class="modal-body">
                                        <form action="<?php echo base_url('index.php/transaksi/indexTabungan/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                            <table id="modalShow" class="table table-striped table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th width=100 scope="col">id_siswa<?= $session->id_siswa ?></th>
                                                        <th scope="col">nama_siswa</th>
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

                        <div class="modal fade" id="ModalKredit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog  modal-lg" role="document">
                                <div class="modal-content bg-success">
                                    <?php if (isset($kodeTabungan)) {
                                        //dd($kodeTabungan); 
                                    ?>
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLabel">Entri Data Kredit <br><?php echo "Nama : " . $DetilSiswa['nama_siswa'] . "<br>kode Tab : " . $kodeTabungan['kode_tab']; ?></h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form name=modalEntriKredit action="<?php echo base_url('index.php/transaksi/saveKredit/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                <?= csrf_field(); ?>
                                                <h4>Tanggal</h4>
                                                <div class="form-group">
                                                    <input name="tanggal" type="date" class="form-control" id="recipient-name" value="">
                                                    <input name="kode_tab_trans" type="hidden" class="form-control" id="recipient-name" value="<?php echo $kodeTabungan['kode_tab']; ?>">
                                                    <input name="id_siswa" type="hidden" class="form-control" id="recipient-name" value="<?php echo $DetilSiswa['id_siswa']; ?>">
                                                </div>
                                                <h4>Kode Transaksi</h4>
                                                <div class="form-group">
                                                    <select name="NKKodeTransaksi" id="KKodeTransaksi" class="form-control">
                                                        <?php
                                                        if (isset($bulanbayar)) {
                                                            foreach ($dataKodeTransaksiKredit as $DataKodeTransaksiKreditList) {
                                                        ?>
                                                                <option value="<?php echo $DataKodeTransaksiKreditList['kode']; ?>"><?php echo $DataKodeTransaksiKreditList['kode'] . "::" . $DataKodeTransaksiKreditList['keterangan_kode']; ?></option>
                                                        <?PHP }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group bg-light" id="checklistspp">
                                                    <?php
                                                    $dataspp = $cekspp;
                                                    $cekbayarspp = cekbayarspp($DetilSiswa['id_siswa']);
                                                    $pesertaloundry = $cekloundry;

                                                    if ($pesertaloundry) {
                                                        $readonlyldr = "checked";
                                                        $peserta = "Peserta";
                                                    } else {
                                                        $readonlyldr = "disabled";
                                                        $peserta = "Bukan Peserta";
                                                    }

                                                    if (isset($bulanbayar)) {
                                                        $readonly = array();
                                                        for ($i = 1; $i <= 12; $i++) {
                                                            if ($i <= $bulanbayar) {
                                                                $readonly[$i] = "disabled checked";
                                                            } else {
                                                                $readonly[$i] = "";
                                                            }
                                                        }
                                                    }
                                                    if (isset($cekbayarspp)) {
                                                        foreach ($cekbayarspp as $cekbayarsppk => $cekbayarsppv) {
                                                            if (isset($cekbayarsppv['spp'][$cekbayarsppv['spp']]))
                                                                $cekbayarsppv['spp'][$cekbayarsppv['spp']] = $cekbayarsppv['spp'];
                                                        }
                                                        $readonly = array();
                                                        for ($i = 1; $i <= 12; $i++) {
                                                            if (isset($cekbayarsppv['spp'][$i])) {
                                                                $readonly[$i] = "disabled checked";
                                                            } else {
                                                                $readonly[$i] = "";
                                                            }
                                                        }
                                                    }
                                                    if (isset($bulanbayarldr)) {
                                                        $readonlyldr = array();
                                                        for ($i = 1; $i <= 12; $i++) {
                                                            if ($i <= $bulanbayarldr) {
                                                                $readonlyldr[$i] = "disabled checked";
                                                            } else {
                                                                $readonlyldr[$i] = "";
                                                            }
                                                        }
                                                    }
                                                    if (isset($bulanbayarkes)) {
                                                        $readonlykes = array();
                                                        for ($i = 1; $i <= 12; $i++) {
                                                            if ($i <= $bulanbayarkes) {
                                                                $readonlykes[$i] = "disabled checked";
                                                            } else {
                                                                $readonlykes[$i] = "";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <table class="table table-bordered table-sm">
                                                        <tr>
                                                            <td>
                                                                SPP
                                                            </td>
                                                            <td>
                                                                Jul <input name="sppbulan1" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[1]; ?>>
                                                                Ags <input name="sppbulan2" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[2]; ?>>
                                                                Sep <input name="sppbulan3" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[3]; ?>>
                                                                Oct <input name="sppbulan4" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[4]; ?>>
                                                                Nov <input name="sppbulan5" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[5]; ?>>
                                                                Dec <input name="sppbulan6" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[6]; ?>>
                                                                Jan <input name="sppbulan7" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[7]; ?>>
                                                                Feb <input name="sppbulan8" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[8]; ?>>
                                                                Mar <input name="sppbulan9" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[9]; ?>>
                                                                Apr <input name="sppbulan10" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[10]; ?>>
                                                                Mei <input name="sppbulan11" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[11]; ?>>
                                                                Jun <input name="sppbulan12" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifspp; ?>" <?php echo $readonly[12]; ?>>
                                                            </td>
                                                        </tr>
                                                        <?php if ($pesertaloundry) {
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <p class="text-danger">Loundry</p>
                                                                </td>
                                                                <td>
                                                                    Jul <input name="ldrbulan1" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[1]; ?>>
                                                                    Ags <input name="ldrbulan2" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[2]; ?>>
                                                                    Sep <input name="ldrbulan3" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[3]; ?>>
                                                                    Oct <input name="ldrbulan4" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[4]; ?>>
                                                                    Nov <input name="ldrbulan5" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[5]; ?>>
                                                                    Dec <input name="ldrbulan6" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[6]; ?>>
                                                                    Jan <input name="ldrbulan7" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[7]; ?>>
                                                                    Feb <input name="ldrbulan8" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[8]; ?>>
                                                                    Mar <input name="ldrbulan9" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[9]; ?>>
                                                                    Apr <input name="ldrbulan10" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[10]; ?>>
                                                                    Mei <input name="ldrbulan11" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[11]; ?>>
                                                                    Jun <input name="ldrbulan12" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifldr; ?>" <?php echo $readonlyldr[12]; ?>>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                            <?php }
                                                            ?>
                                                            <td>
                                                                Kesehatan
                                                            </td>
                                                            <td>
                                                                Jul <input name="kesbulan1" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[1]; ?>>
                                                                Ags <input name="kesbulan2" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[2]; ?>>
                                                                Sep <input name="kesbulan3" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[3]; ?>>
                                                                Oct <input name="kesbulan4" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[4]; ?>>
                                                                Nov <input name="kesbulan5" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[5]; ?>>
                                                                Dec <input name="kesbulan6" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[6]; ?>>
                                                                Jan <input name="kesbulan7" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[7]; ?>>
                                                                Feb <input name="kesbulan8" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[8]; ?>>
                                                                Mar <input name="kesbulan9" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[9]; ?>>
                                                                Apr <input name="kesbulan10" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[10]; ?>>
                                                                Mei <input name="kesbulan11" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[11]; ?>>
                                                                Jun <input name="kesbulan12" type="checkbox" class="checkbox checkbox-success" value="<?php echo $tarifkes; ?>" <?php echo $readonlykes[12]; ?>>
                                                            </td>
                                                            </tr>
                                                    </table>

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
                                                    <input name="buktitransfer" type="file" accept="image/jpeg,image/png,image/webp" class="form-control" id="recipient-name" value="">
                                                </div>
                                                <div class="modal-footer" id="savenonspp1">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" onclick="return cek_null_entrikredit()">save</button>
                                                </div>
                                                <div class="modal-footer" id="savespp1">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-warning" onclick="return cekJml();">save</button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } ?>
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
                                            <form name=modalEntriDebet action="<?php echo base_url('index.php/transaksi/saveDebet/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" onsubmit="return cek_null_entridebet()">
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
                                                    <input name="buktitransfer" type="file" accept="image/jpeg,image/png,image/webp" class="form-control" id="recipient-name" value="">
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


                                    <?php
                                    if (!isset(cekDataTabungan($DetilSiswa["id_siswa"])["kode_tab"])) { ?>
                                        <div class="modal fade" id="ModalDaftarTabungan">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Daftar Tabungan</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?php echo base_url('index.php/transaksi/saveNewDataTabungan/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text" id="basic-addon3">Nama Siswa</span>
                                                                    <input name="nama_siswa" type="text" class="form-control" id="recipient-name" value="<?php echo $DetilSiswa['nama_siswa']; ?>" readonly>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text" id="basic-addon3">Id Siswa</span>
                                                                    <input name="id_siswa" type="text" class="form-control" id="recipient-name" value="<?php echo $DetilSiswa['id_siswa']; ?>" readonly>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text" id="basic-addon3">Kode Tabungan</span>
                                                                    <input name="kode_tab" type="text" class="form-control" id="recipient-name" value="<?php echo "T" . $DetilSiswa['id_siswa'] . "-" . date('dmY'); ?>" readonly>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"> Save</i></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card text-center">
                                                <div class="card-header">
                                                    Siswa Belum ada Kode Tabungan
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">Silahkan Buat Kode Tabungan Klick buat kode tabungan</p>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalDaftarTabungan"><i class="fas fa-plus"></i>Buat Kode Tabungan</button>
                                                </div>
                                                <div class="card-footer text-muted">
                                                    Warning
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <p>
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalKredit"><i class="fas fa-plus"></i>Input Kredit</button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalDebet"><i class="fas fa-plus"></i>Input Debet</button>
                                                </p>
                                                <table class="table table-striped table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th width=100 scope="col"></th> -->
                                                            <th scope="col">No</th>
                                                            <th scope="col">No Transaksi</th>
                                                            <th scope="col">Kode Tabungan</th>
                                                            <th scope="col">Tanggal</th>
                                                            <th scope="col">Kode</th>
                                                            <th scope="col">Debit</th>
                                                            <th scope="col">Kredit</th>
                                                            <th scope="col">Saldo</th>
                                                            <th scope="col" width=25%>Keterangan</th>
                                                            <th scope="col">Bukti Transfer</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        $kredit = "";
                                                        $debit = "";
                                                        $saldo = "";
                                                        foreach ($DataTabunganSiswa as $DataMenuv) { ?>
                                                            <tr>
                                                                <!--
                                                <td>
                                                    <button class="btn btn-primary" data-toggle="modal" data-target="#Modal<?php echo $DataMenuv['notransaksi']; ?>" type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
                                                    <button class="btn btn-primary btn-danger" data-toggle="modal" data-target="#ModalDelete<?php echo $DataMenuv['notransaksi']; ?>" type="button" class="btn btn-primary"><i class="fas fa-trash"></i></button>
                                                </td>
                                                -->
                                                                <td><?php echo $i;
                                                                    $i++; ?></td>
                                                                <td><?php echo $DataMenuv['notransaksi']; ?></td>
                                                                <td><?php echo $DataMenuv['kode_tab_trans']; ?></td>
                                                                <td><?php echo $DataMenuv['tanggal']; ?></td>
                                                                <td><?php echo $DataMenuv['kodetransaksi']; ?></td>
                                                                <?php
                                                                if ($DataMenuv['kode_tran'] == "K") {
                                                                    $kredit = $DataMenuv['rp'];
                                                                } else {
                                                                    $kredit = "";
                                                                }
                                                                if ($DataMenuv['kode_tran'] == "D") {
                                                                    $debit = $DataMenuv['rp'];
                                                                } else {
                                                                    $debit = "";
                                                                }
                                                                if ($debit) $debitv = number_format((float)$debit, 0, ',', '.');
                                                                else $debitv = "";
                                                                if ($kredit) $kreditv = number_format((float)$kredit, 0, ',', '.');
                                                                else $kreditv = "";
                                                                ?>

                                                                <td align=right><?php echo  $debitv; ?></td>
                                                                <td align=right><?php echo  $kreditv; ?></td>
                                                                <?php
                                                                if (!$kredit) {
                                                                    //$kredit = 0;
                                                                    $saldo = floatval($saldo) - floatval($debit);
                                                                }
                                                                if (!$debit) {
                                                                    //$debit = 0;
                                                                    $saldo = floatval($saldo) + floatval($kredit);
                                                                }

                                                                ?>
                                                                <td align=right><?php echo number_format($saldo, 0, ',', '.'); ?></td>
                                                                <td><?php echo $DataMenuv['keterangan_trans']; ?></td>
                                                                <td align="center">

                                                                    <?php if (!empty($DataMenuv['buktitransfer'])) { ?>

                                                                        <?php
                                                                        $ext = strtolower(pathinfo($DataMenuv['buktitransfer'], PATHINFO_EXTENSION));
                                                                        ?>

                                                                        <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) { ?>

                                                                            <a href="<?= base_url('uploads/tabungan/' . $DataMenuv['buktitransfer']); ?>" target="_blank">
                                                                                <img src="<?= base_url('uploads/tabungan/' . $DataMenuv['buktitransfer']); ?>"
                                                                                    width="80"
                                                                                    class="img-thumbnail">
                                                                            </a>

                                                                        <?php } else { ?>

                                                                            <a href="<?= base_url('uploads/buktitransfer/' . $DataMenuv['buktitransfer']); ?>"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-info">
                                                                                Lihat File
                                                                            </a>

                                                                        <?php } ?>

                                                                    <?php } else { ?>

                                                                        <span class="badge badge-secondary">Tidak Ada</span>

                                                                    <?php } ?>

                                                                </td>
                                                            </tr>

                                                            <!-- Modal Edit  -->
                                                            <div class="modal fade" id="Modal<?php echo $DataMenuv['notransaksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Data Transaksi</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="<?php echo base_url('index.php/transaksi/edit/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="basic-addon3">No Transaksi</span>
                                                                                    <input name="notransaksi" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['notransaksi']; ?>">
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="basic-addon3">kode_tab_trans</span>
                                                                                    <input name="kode_tab_trans" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['kode_tab_trans']; ?>">
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="basic-addon3">kodetransaksi</span>
                                                                                    <input name="kodetransaksi" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['kodetransaksi']; ?>">
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="basic-addon3"><?php echo $DataMenuv['tanggal']; ?>tanggal</span>
                                                                                    <input name="tanggal" type="date" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['tanggal']; ?>">
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="basic-addon3">Rp</span>
                                                                                    <input name="rp" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['rp']; ?>">
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="basic-addon3">keterangan_trans</span>
                                                                                    <input name="keterangan_trans" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['keterangan_trans']; ?>">
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="basic-addon3">spp</span>
                                                                                    <input name="spp" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['spp']; ?>">
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="basic-addon3">buktitransfer</span>
                                                                                    <input name="buktitransfer" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['buktitransfer']; ?>">
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="basic-addon3">tahunajaran</span>
                                                                                    <input name="tahunajaran" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['tahunajaran']; ?>">
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <input name="start_date" type="hidden" value="<?php echo $start_date; ?>">
                                                                                    <input name="end_date" type="hidden" value="<?php echo $end_date; ?>">
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
                                                            <!-- /Modal Delete -->
                                                            <div class="modal fade" id="ModalDelete<?php echo $DataMenuv['notransaksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Data Transaksi</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body danger">
                                                                            <form action="<?php echo base_url('index.php/transaksi/delete/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="basic-addon3">No Transaksi</span>
                                                                                    <input name="notransaksi" type="text" class="form-control" id="recipient-name" value="<?php echo $DataMenuv['notransaksi']; ?>">
                                                                                    <input name="start_date" type="hidden" value="<?php echo $start_date; ?>">
                                                                                    <input name="end_date" type="hidden" value="<?php echo $end_date; ?>">
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
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            <?php } ?>
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

<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php //echo BPATH; 
                    ?>/asset/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>
<!-- Page specific script -->
<script>
    function cek_null_entrikredit() {
        var x = document.forms["modalEntriKredit"]["tanggal"].value;
        var y = document.forms["modalEntriKredit"]["rp"].value;
        if (x == "") {
            alert("Tanggal harus diisi");
            return false;
        }
        if (y == "") {
            alert("rupiah harus diisi");
            return false;
        }


    }

    function cek_null_entridebet() {
        var x = document.forms["modalEntriDebet"]["tanggal"].value;
        var y = document.forms["modalEntriDebet"]["rp"].value;
        if (x == "") {
            alert("Tanggal harus diisi");
            return false;
        }
        if (y == "") {
            alert("rupiah harus diisi");
            return false;
        }
    }
</script>
<script>
    function sppBulan() {
        var jml = 0;

        for (var i = 1; i <= 12; i++) {
            if (document.getElementsByName("sppbulan" + i)[0].type == 'checkbox' &&
                document.getElementsByName("sppbulan" + i)[0].checked == true &&
                document.getElementsByName("sppbulan" + i)[0].disabled == false) {
                jml = parseInt(jml) + parseInt(document.getElementsByName("sppbulan" + i)[0].value);
            }
        }
        jml = parseInt(document.getElementsByName("rp")[0].value) - parseInt(jml);
        return jml;

    }

    function cekangka(str) {
        return Boolean(str.match(/^[0-9]*$/));
    }

    function cekJml() {
        var jml = sppBulan();
        if (!document.forms["modalEntriKredit"]["tanggal"].value) {
            alert("Tanggal Harus diisi");
            return false;
        }
        if (!document.forms["modalEntriKredit"]["rp"].value) {
            alert("Rupiah Harus diisi");
            return false;
        }
        if (!cekangka(document.getElementsByName("rp")[0].value)) {
            alert("harus angka");
            return false;
        }
        if (jml < 0) {
            alert("Nilai Rupiah yang dimasukan kurang dari total SPP");
            return false;
        }
    }
</script>

<script>
    $(function() {
        $('#checklistspp').hide();
        $('#savespp1').hide();
        $('#KKodeTransaksi').change(function() {
            if ($('#KKodeTransaksi').val() == 'TKSPP') {
                $('#checklistspp').show();
                $('#savespp1').show();
                $('#savenonspp1').hide();
            } else {
                $('#checklistspp').hide();
                $('#savespp1').hide();
                $('#savenonspp1').show();
            }
        });
    })
</script>
<?php if ($session->id_siswa) { ?>
    <script>
        $('#myModal').modal({
            show: false
        })
    </script>
<?php } else { ?>
    <script>
        $('#myModal').modal({
            show: true
        })
    </script>
<?php } ?>
<script>
    $(function() {
        $("#modalShow").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "paging": true,
        });
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