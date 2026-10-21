<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<style>
    .text-left-custom {
        text-align: left;
    }
    .text-right-custom {
        text-align: right;
    }
    .text-center-custom {
        text-align: center;
    }
    .number {
        text-align: right;
        font-weight: 600;
        white-space: nowrap;
    }
    .text {
        text-align: left;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
        </div>
    </div>

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-header">
                            <h2>Laporan Saldo Tabungan Santri</h2>
                        </div>

                        <div class="card-body">


                            <div class="table-responsive mb-4">

                                <table class="table table-bordered table-sm">

                                    <thead class="bg-primary">

                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Kode Transaksi</th>
                                            <th>Deskripsi</th>
                                            <th>Total</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php
                                        $transaksiDesc = [
                                            "TKSPP"=>"Setoran SPP",
                                            "TDSPP"=>"Penarikan SPP",
                                            "TDINF"=>"Penarikan Infaq",
                                            "TDADM"=>"Penarikan Administrasi",
                                            "TDTNI"=>"Penarikan Tunai",
                                            "TDLDR"=>"Penarikan Loundry",
                                            "TDKES"=>"Penarikan Kesehatan",
                                            "TKTNI"=>"Setoran Tunai",
                                            "TDPTS"=>"Penarikan Semester",
                                            "TKTRF"=>"Setoran Transfer",
                                            "TKPAS"=>"Setoran Ujian Akhir Semester",
                                            "TKPTS"=>"Setoran TengahSemester",
                                            "TKKOR"=>"Setoran Koreksi",
                                            "TKTAB"=>"Setoran Tabungan",
                                            "TDPAS"=>"Penarikan Ujian Akhir Semester",
                                            "TDPRE"=>"Penarikan Prestasi",
                                            "TDKOR"=>"Penarikan Koreksi",
                                            ];
                                        $saldoTapsan   = $saldoTapsan ?? [];
                                        $saldoTapsan2  = $saldoTapsan2 ?? [];
                                        $detailTapsan  = $detailTapsan ?? [];
                                        $monthyear     = $monthyear ?? date('Y-m');
                                        $no2 = 1;
                                        $totalTK = 0;
                                        $totalTD = 0;
                                        $grandTotal2 = 0;

                                        if (isset($saldoTapsan2) && !empty($saldoTapsan2)) :

                                            foreach ($saldoTapsan2 as $row2) :
                                                if (substr($row2->kodetransaksi, 0, 2) == 'TK') {
                                                    $totalTK += $row2->total;
                                                }

                                                if (substr($row2->kodetransaksi, 0, 2) == 'TD') {
                                                    $totalTD += $row2->total;
                                                }
                                        ?>

                                                <tr>

                                                    <td align="center">
                                                        <?= $no2++; ?>
                                                    </td>

                                                    <td align="left">

                                                        <form method="POST" action="">

                                                            <?= csrf_field() ?>

                                                            <input
                                                                type="hidden"
                                                                name="kodetransaksi"
                                                                value="<?= $row2->kodetransaksi ?>">

                                                            <button
                                                                type="submit"
                                                                class="btn btn-link p-0"
                                                                style="font-weight:bold;">
                                                                <?= $row2->kodetransaksi ?>
                                                            </button>

                                                        </form>

                                                    </td>

                                                    <td align="left">
                                                        <?= $transaksiDesc[$row2->kodetransaksi] ?? $row2->kodetransaksi ?>
                                                    </td>

                                                    <td align="right">

                                                        <?= number_format($row2->total, 0, ',', '.') ?>

                                                    </td>

                                                </tr>

                                        <?php
                                            endforeach;

                                        endif;
                                        ?>

                                    </tbody>

                                    <tfoot>

                                        <tr>
                                            <th></th>
                                            <th colspan="2" style="text-align:right">
                                                TOTAL KREDIT
                                            </th>

                                            <th style="text-align:right">
                                                <?= number_format($totalTK, 0, ',', '.') ?>
                                            </th>
                                        </tr>

                                        <tr>
                                            <th></th>
                                            <th colspan="2" style="text-align:right">
                                                TOTAL DEBET
                                            </th>

                                            <th style="text-align:right">
                                                <?= number_format($totalTD, 0, ',', '.') ?>
                                            </th>
                                        </tr>

                                        <tr>
                                            <th></th>
                                            <th colspan="2" style="text-align:right">
                                                TOTAL SALDO
                                            </th>

                                            <th style="text-align:right">
                                                <?= number_format($totalTK - $totalTD, 0, ',', '.') ?>
                                            </th>
                                        </tr>

                                    </tfoot>

                                </table>

                            </div>
                            <br>
                            <?php if (!empty($detailTapsan)) : ?>

                                <div class="card mt-4">

                                    <div class="card-header bg-info">

                                        <h3 class="card-title">

                                            Detail Transaksi <?= $detailTapsan[0]->kodetransaksi ?>

                                        </h3>

                                    </div>

                                    <div class="card-body table-responsive">

                                        <table class="table table-bordered table-striped table-sm">

                                            <thead>

                                                <tr>

                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>ID Siswa</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Kode</th>
                                                    <th>Keterangan</th>
                                                    <th>Nominal</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                <?php
                                                $noDetail = 1;
                                                $totalDetail = 0;

                                                foreach ($detailTapsan as $detail) :

                                                    $totalDetail += $detail->rp;
                                                ?>

                                                    <tr>

                                                        <td align="center">
                                                            <?= $noDetail++; ?>
                                                        </td>

                                                        <td align="center">
                                                            <?= $detail->tanggal ?>
                                                        </td>

                                                        <td align="center">
                                                            <?= $detail->id_siswa ?>
                                                        </td>

                                                        <td>
                                                            <?= $detail->nama_siswa ?>
                                                        </td>

                                                        <td align="center">
                                                            <?= $detail->kodetransaksi ?>
                                                        </td>

                                                        <td>
                                                            <?= $detail->keterangan ?? '-' ?>
                                                        </td>

                                                        <td align="right">

                                                            <?= number_format($detail->rp, 0, ',', '.') ?>

                                                        </td>

                                                    </tr>

                                                <?php endforeach; ?>

                                            </tbody>

                                            <tfoot>

                                                <tr>

                                                    <th colspan="6" style="text-align:right">

                                                        TOTAL

                                                    </th>

                                                    <th style="text-align:right">

                                                        <?= number_format($totalDetail, 0, ',', '.') ?>

                                                    </th>

                                                </tr>

                                            </tfoot>

                                        </table>

                                    </div>

                                </div>

                            <?php endif; ?>
                            <table id="example1" class="table table-striped table-bordered table-sm">

                                <thead align="center">

                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">ID SISWA</th>
                                        <th>NAMA SISWA</th>
                                        <th width="15%">KREDIT</th>
                                        <th width="15%">DEBET</th>
                                        <th width="15%">SALDO</th>
                                        <th width="10%">DETIL</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php
                                    $no = 1;

                                    $totalKredit = 0;
                                    $totalDebet  = 0;
                                    $totalSaldo  = 0;

                                    if (isset($saldoTapsan) && !empty($saldoTapsan)) :

                                        foreach ($saldoTapsan as $row) :

                                            $totalKredit += $row->jumlah_kredit;
                                            $totalDebet  += $row->jumlah_debet;
                                            $totalSaldo  += $row->saldo;
                                    ?>

                                            <tr>

                                                <td align="center">
                                                    <?= $no++; ?>
                                                </td>

                                                <td align="center">
                                                    <?= $row->id_siswa ?>
                                                </td>

                                                <td>
                                                    <?= $row->nama_siswa ?>
                                                </td>

                                                <td align="right">
                                                    <?= number_format($row->jumlah_kredit, 0, ',', '.') ?>
                                                </td>

                                                <td align="right">
                                                    <?= number_format($row->jumlah_debet, 0, ',', '.') ?>
                                                </td>

                                                <td align="right">

                                                    <b style="color:<?= ($row->saldo < 0) ? 'red' : 'green' ?>">

                                                        <?= number_format($row->saldo, 0, ',', '.') ?>

                                                    </b>

                                                </td>

                                                <td align="center">

                                                    <form action="<?= base_url('transaksi/indexTabungan/17/4') ?>" method="POST">

                                                        <?= csrf_field() ?>

                                                        <input type="hidden" name="id_siswa" value="<?= $row->id_siswa ?>">

                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                            Detil
                                                        </button>

                                                    </form>

                                                </td>

                                            </tr>

                                    <?php
                                        endforeach;
                                    endif;
                                    ?>

                                </tbody>

                                <tfoot>

                                    <tr>

                                        <th colspan="3" style="text-align:right">

                                            TOTAL

                                        </th>

                                        <th style="text-align:right">

                                            <?= number_format($totalKredit, 0, ',', '.') ?>

                                        </th>

                                        <th style="text-align:right">

                                            <?= number_format($totalDebet, 0, ',', '.') ?>

                                        </th>

                                        <th style="text-align:right">

                                            <?= number_format($totalSaldo, 0, ',', '.') ?>

                                        </th>

                                    </tr>

                                </tfoot>

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

<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="<?php echo BPATH; ?>/asset/plugins/jszip/jszip.min.js"></script>

<script src="<?php echo BPATH; ?>/asset/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/pdfmake/vfs_fonts.js"></script>

<script src="<?php echo BPATH; ?>/asset/plugins/jquery-ui/jquery-ui.min.js"></script>

<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>

<script>
    $(function() {

        $("#example1").DataTable({

            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 50,
            "ordering": true,
            "searching": true,
            "paging": true,
            "info": true,

            "buttons": [
                "copy",
                "csv",
                "excel",
                "pdf",
                "print",
                "colvis"
            ]

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    });
</script>

<?= $this->endSection() ?>