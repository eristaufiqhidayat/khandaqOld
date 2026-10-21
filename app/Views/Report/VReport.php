<?= $this->extend('Views\layout.php') ?>
<?php
/** @var int|string $tahunAjaran */
/** @var array $dataCrosstab */
/** @var array $dataCrosstab2 */
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
                            <h2>Report SPP</h2>

                        </div>
                        <center>
                            <form action="<?php echo base_url('index.php/Report/Spp/' . $menuAktip . "/" . $moduleAktip) ?>" method="get">
                                <label for="start">Pilih Tahun : &nbsp;&nbsp;&nbsp;</label>
                                <select name="tahunajaranselect">
                                    <?php foreach (selecttahunajaran() as $tahunajaranS) {
                                        (isset($_REQUEST["tahunajaranselect"])) ? $tahunajaranselect = $_REQUEST["tahunajaranselect"] : $tahunajaranselect = $tahunAjaran;
                                        (isset($tahunajaranselect) && $tahunajaranselect == $tahunajaranS["tahun"]) ? $selected = "selected" : $selected = "";
                                    ?>
                                        <option value="<?= $tahunajaranS["tahun"] ?>" <?= $selected ?>><?= $tahunajaranS["tahun"] ?></option>
                                    <?PHP } ?>
                                </select>
                                <button>Pilih Tahun Ajaran</button>
                            </form>
                        </center>
                        <div class=" card-body">
                            <table id="example2" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <!-- <th width=100 scope="col"></th> -->
                                        <th>Nama Kelas</th>
                                        <th>jml siswa</th>
                                        <th>jml Besis</th>
                                        <th>Tarip SPP</th>
                                        <th>Tarip SPP x Jml Siswa</th>
                                        <th>Jul</th>
                                        <th>Aug</th>
                                        <th>Sep</th>
                                        <th>Oct</th>
                                        <th>Nov</th>
                                        <th>Dec</th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>Mei</th>
                                        <th>Jun</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 0;
                                    $totalPemasukan['Jul'] =  0;
                                    $totalPemasukan['Aug'] =  0;
                                    $totalPemasukan['Sep'] =  0;
                                    $totalPemasukan['Oct'] =  0;
                                    $totalPemasukan['Nov'] =  0;
                                    $totalPemasukan['Des'] =  0;
                                    $totalPemasukan['Jan'] =  0;
                                    $totalPemasukan['Feb'] =  0;
                                    $totalPemasukan['Mar'] =  0;
                                    $totalPemasukan['Apr'] =  0;
                                    $totalPemasukan['Mei'] =  0;
                                    $totalPemasukan['Jun'] =  0;
                                    $totalsiswa = 0;
                                    $totalbesis = 0;
                                    $besis = 0;
                                    $sumtarifsiswa = 0;
                                    foreach ($dataCrosstab as $dataCrosstabv) {
                                        $totalPemasukan['Jul'] =  $totalPemasukan['Jul'] + $dataCrosstabv['Jul'];
                                        $totalPemasukan['Aug'] =  $totalPemasukan['Aug'] + $dataCrosstabv['Aug'];
                                        $totalPemasukan['Sep'] =  $totalPemasukan['Sep'] + $dataCrosstabv['Sep'];
                                        $totalPemasukan['Oct'] =  $totalPemasukan['Oct'] + $dataCrosstabv['Oct'];
                                        $totalPemasukan['Nov'] =  $totalPemasukan['Nov'] + $dataCrosstabv['Nov'];
                                        $totalPemasukan['Des'] =  $totalPemasukan['Des'] + $dataCrosstabv['Des'];
                                        $totalPemasukan['Jan'] =  $totalPemasukan['Jan'] + $dataCrosstabv['Jan'];
                                        $totalPemasukan['Feb'] =  $totalPemasukan['Feb'] + $dataCrosstabv['Feb'];
                                        $totalPemasukan['Mar'] =  $totalPemasukan['Mar'] + $dataCrosstabv['Mar'];
                                        $totalPemasukan['Apr'] =  $totalPemasukan['Apr'] + $dataCrosstabv['Apr'];
                                        $totalPemasukan['Mei'] =  $totalPemasukan['Mei'] + $dataCrosstabv['Mei'];
                                        $totalPemasukan['Jun'] =  $totalPemasukan['Jun'] + $dataCrosstabv['Jun'];

                                    ?>
                                        <tr>
                                            <td><?php echo $dataCrosstabv['nama_kelas']
                                                ?></td>
                                            <td>
                                                <?php if (isset(sumsiswakelas($dataCrosstabv['id_kelas'], $tahunAjaran)['jml'])) {
                                                    echo sumsiswakelas($dataCrosstabv['id_kelas'], $tahunAjaran)['jml'];
                                                    $totalsiswa = sumsiswakelas($dataCrosstabv['id_kelas'], $tahunAjaran)['jml'] + $totalsiswa;
                                                }
                                                //echo $dataCrosstabv['id_kelas'];
                                                ?>
                                            </td>
                                            <td align=right>
                                                <?php if (isset(sumbeasiswakelas($dataCrosstabv['id_kelas'])['jml'])) {
                                                    $besis = sumbeasiswakelas($dataCrosstabv['id_kelas'])['jml'];
                                                    $totalbesis = $besis + $totalbesis;
                                                    echo $besis;
                                                } else {
                                                    $besis = 0;
                                                    echo $besis;
                                                }

                                                ?>
                                            </td>
                                            <td align=right><?php echo number_format((float)rowdatatarifspp2()[$dataCrosstabv['id_kelas']], 0, ',', '.'); ?></td>
                                            <td align=right>
                                                <?php
                                                if (isset(sumsiswakelas($dataCrosstabv['id_kelas'], $tahunAjaran)['jml'])) {
                                                    $sumtarifsiswa = (sumsiswakelas($dataCrosstabv['id_kelas'], $tahunAjaran)['jml'] - $besis) * rowdatatarifspp2()[$dataCrosstabv['id_kelas']] + $sumtarifsiswa;
                                                    echo number_format((sumsiswakelas($dataCrosstabv['id_kelas'], $tahunAjaran)['jml'] - $besis) * rowdatatarifspp2()[$dataCrosstabv['id_kelas']], 0, ',', '.');
                                                }
                                                ?>
                                            </td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Jul'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Aug'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Sep'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Oct'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Nov'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Des'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Jan'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Feb'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Mar'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Apr'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Mei'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Jun'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    $totalSelisih['Jul'] =  $totalPemasukan['Jul'] - sumpengeluaransppbulan(7, $tahunAjaran)["total"];
                                    $totalSelisih['Aug'] =  $totalPemasukan['Aug'] - sumpengeluaransppbulan(8, $tahunAjaran)["total"];
                                    $totalSelisih['Sep'] =  $totalPemasukan['Sep'] - sumpengeluaransppbulan(9, $tahunAjaran)["total"];
                                    $totalSelisih['Oct'] =  $totalPemasukan['Oct'] - sumpengeluaransppbulan(10, $tahunAjaran)["total"];
                                    $totalSelisih['Nov'] =  $totalPemasukan['Nov'] - sumpengeluaransppbulan(11, $tahunAjaran)["total"];
                                    $totalSelisih['Des'] =  $totalPemasukan['Des'] - sumpengeluaransppbulan(12, $tahunAjaran)["total"];
                                    $totalSelisih['Jan'] =  $totalPemasukan['Jan'] - sumpengeluaransppbulan(1, $tahunAjaran + 1)["total"];
                                    $totalSelisih['Feb'] =  $totalPemasukan['Feb'] - sumpengeluaransppbulan(2, $tahunAjaran + 1)["total"];
                                    $totalSelisih['Mar'] =  $totalPemasukan['Mar'] - sumpengeluaransppbulan(3, $tahunAjaran + 1)["total"];
                                    $totalSelisih['Apr'] =  $totalPemasukan['Apr'] - sumpengeluaransppbulan(4, $tahunAjaran + 1)["total"];
                                    $totalSelisih['Mei'] =  $totalPemasukan['Mei'] - sumpengeluaransppbulan(5, $tahunAjaran + 1)["total"];
                                    $totalSelisih['Jun'] =  $totalPemasukan['Jun'] - sumpengeluaransppbulan(6, $tahunAjaran + 1)["total"];
                                    ?>
                                    <tr>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                        <td bgcolor=red>::</td>
                                    </tr>
                                    <tr>
                                        <td align="right">::Total Siswa</td>
                                        <td align="right"><?php echo $totalsiswa ?></td>
                                        <td align="right"><?php echo $totalbesis ?></td>
                                        <td></td>
                                        <td align="right"><?php echo number_format($sumtarifsiswa, 0, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align=right><?php echo "Total Pemasukan"; ?></td>
                                        <td align=right></td>
                                        <td align=right></td>
                                        <td align=right></td>
                                        <td align=right></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Jul'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Aug'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Sep'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Oct'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Nov'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Des'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Jan'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Feb'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Mar'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Apr'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Mei'], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)$totalPemasukan['Jun'], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php $sumAllpemasukanspp = $totalPemasukan['Jul'] +
                                        $totalPemasukan['Aug'] +
                                        $totalPemasukan['Sep'] +
                                        $totalPemasukan['Oct'] +
                                        $totalPemasukan['Nov'] +
                                        $totalPemasukan['Des'] +
                                        $totalPemasukan['Jan'] +
                                        $totalPemasukan['Feb'] +
                                        $totalPemasukan['Mar'] +
                                        $totalPemasukan['Apr'] +
                                        $totalPemasukan['Mei'] +
                                        $totalPemasukan['Jun'];
                                    ?>
                                    <tr>
                                        <td align=right><?php echo "Total Pengeluaran" ?></td>
                                        <td align=right></td>
                                        <td align=right></td>
                                        <td align=right></td>
                                        <td align=right></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(7, $tahunAjaran)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(8, $tahunAjaran)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(9, $tahunAjaran)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(10, $tahunAjaran)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(11, $tahunAjaran)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(12, $tahunAjaran)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(1, $tahunAjaran + 1)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(2, $tahunAjaran + 1)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(3, $tahunAjaran + 1)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(4, $tahunAjaran + 1)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(5, $tahunAjaran + 1)["total"], 0, ',', '.') ?></td>
                                        <td align=right><?php echo number_format((float)sumpengeluaransppbulan(6, $tahunAjaran + 1)["total"], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php $sumAllpengeluaranspp = sumpengeluaransppbulan(7, $tahunAjaran)["total"] +
                                        sumpengeluaransppbulan(8, $tahunAjaran)["total"] +
                                        sumpengeluaransppbulan(9, $tahunAjaran)["total"] +
                                        sumpengeluaransppbulan(10, $tahunAjaran)["total"] +
                                        sumpengeluaransppbulan(11, $tahunAjaran)["total"] +
                                        sumpengeluaransppbulan(12, $tahunAjaran)["total"] +
                                        sumpengeluaransppbulan(1, $tahunAjaran + 1)["total"] +
                                        sumpengeluaransppbulan(2, $tahunAjaran + 1)["total"] +
                                        sumpengeluaransppbulan(3, $tahunAjaran + 1)["total"] +
                                        sumpengeluaransppbulan(4, $tahunAjaran + 1)["total"] +
                                        sumpengeluaransppbulan(5, $tahunAjaran + 1)["total"] +
                                        sumpengeluaransppbulan(6, $tahunAjaran + 1)["total"];
                                    ?>
                                    <tr>
                                        <td align=right><?php echo "Total Selisih" ?></td>
                                        <td align=right></td>
                                        <td align=right></td>
                                        <td align=right></td>
                                        <td align=right></td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Jul'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Aug'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Sep'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Oct'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Nov'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Des'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Jan'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Feb'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Mar'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Apr'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Mei'], 0, ',', '.'); ?> </td>
                                        <td align=right><?php echo number_format((float)$totalSelisih['Jun'], 0, ',', '.'); ?> </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table id="example3" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <th>Total Bulan Berjalan</th>
                                    <th>Pemasukan Seharusnya / bulan</th>
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                    <th>Selisih</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td align="right"><?= sumbulanberjalan() ?></td>
                                        <td align="right"><?= number_format((float)($sumtarifsiswa * sumbulanberjalan()), 0, ',', '.') ?></td>
                                        <td align="right"><?= number_format((float)$sumAllpemasukanspp, 0, ',', '.') ?></td>
                                        <td align="right"><?= number_format((float)$sumAllpengeluaranspp, 0, ',', '.') ?></td>
                                        <td align="right"><?= number_format((float)$sumAllpemasukanspp - $sumAllpengeluaranspp, 0, ',', '.') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <table id="example1" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <!-- <th width=100 scope="col"></th> -->
                                        <th>Nama Siswa</th>
                                        <th>Nama Kelas</th>
                                        <th>Jul</th>
                                        <th>Aug</th>
                                        <th>Sep</th>
                                        <th>Oct</th>
                                        <th>Nov</th>
                                        <th>Dec</th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>Mei</th>
                                        <th>Jun</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    foreach ($dataCrosstab2 as $dataCrosstabv) {
                                    ?>
                                        <tr>
                                            <td><?php echo $dataCrosstabv['nama_siswa'] ?></td>
                                            <td><?php echo $dataCrosstabv['nama_kelas'] ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Jul'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Aug'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Sep'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Oct'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Nov'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Des'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Jan'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Feb'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Mar'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Apr'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Mei'], 0, ',', '.') ?></td>
                                            <td align=right><?php echo number_format((float)$dataCrosstabv['Jun'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php

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
            "pageLength": 200,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": false,
            "lengthChange": false,
            "pageLength": 50,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": false,
            //"destroy":true,
        });
        $('#example3').DataTable({
            "paging": false,
            "lengthChange": false,
            "pageLength": 50,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            //"destroy":true,
        });
    });
</script>
<?= $this->endSection() ?>