<?= $this->extend('Views\layout.php') ?>


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
                            <h2>Data Pengeluaran Formulir</h2>

                        </div>

                        <div class="card-body">
                            <center>
                                <form action="<?php echo base_url('index.php//ReportEks/Formulir/' . $menuAktip . "/" . $moduleAktip) ?>" method="post">
                                    <label for="start">Pilih Bulan : &nbsp;&nbsp;&nbsp;</label>
                                    <input type="month" name="monthyear" value="<?php echo $monthyear; ?>">&nbsp;&nbsp;&nbsp;
                                    <button>Pilih Bulan</button>

                                </form>
                            </center>
                            <div class="modal fade" id="Modaldetildsb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <!-- <div class="card card-primary">
                                            <div class="card-header">
                                                <h5 class="modal-title" id="test2">Jadwal Matapelajaran</h5>
                                            </div>
                                        </div> -->
                                        <div id="carddata" class="modal-body">
                                            <table id="detildsb" class="table table-bordered table-striped"></table>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table id="detildsb2" class="table table-bordered table-striped">
                                <!-- <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align:right">Total:</th>
                                        <th></th>
                                    </tr>
                                </tfoot> -->
                            </table>
                            <table id="example1" class="table table-striped table-bordered table-sm">
                                <thead align=center>
                                    <th>Nama Sumber</th>
                                    <th>Total</th>
                                    <th>Detil</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $dataDSB = rowFormulirpertahunajaran($monthyear);

                                    foreach ($dataDSB as $dataDSBk => $dataDSBv) {
                                        if ($dataDSBv['nama_siswa']) $namasiswa = $dataDSBv['nama_siswa'];
                                        else $namasiswa = "Luncuran dari DSB Sebelumnya";
                                    ?>
                                        <!-- <tr>
                                            <td><?= $namasiswa ?></td>
                                            <td align=right><?= number_format($dataDSBv['rp'], 0) ?></td>
                                            <td></td>
                                        </tr> -->

                                    <?php } ?>
                                    <!-- <tr>
                                        <td colspan=3 bgcolor=red></td>
                                    </tr> -->
                                    <?php
                                    if (substr($monthyear, 5, 2) < 7 && substr($monthyear, 5, 2) >= 1) $tahunAjaran = substr($monthyear, 0, 4) - 1;
                                    else $tahunAjaran = tahunajaran();
                                    ?>
                                    <tr>
                                        <td>Total Formulir Tahunn ajaran <?= tahunajaran() ?>/<?= tahunajaran() + 1 ?></td>
                                        <td align=right><?= number_format(sumFormulirpertahunajaran($monthyear)["total"], 0); ?></td>
                                        <td align=center><button type="button" class="btn btn-secondary" data-id="' + row.id_guru + '" data-nama_guru="' + row.nama_guru + '" data-toggle="modal" data-target="#Modaldetildsb" data-whatever="@mdo" title="Lihat Jadwal"><i class="fa fa-search" title="Lihat Jadwal"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>Total Pengeluaran Formulir Tahunn ajaran 2 <?= tahunajaran() ?>/<?= tahunajaran() + 1 ?></td>
                                        <td align=right><?= number_format(sumPengeluaranFormulirpertahunajaran($monthyear)["total"] ?? 0, 0); ?></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td>Saldo Berjalan <?= tahunajaran() ?>/<?= tahunajaran() + 1 ?></td>
                                    <td align=right><?= number_format(sumFormulirpertahunajaran($monthyear)["total"] - sumPengeluaranFormulirpertahunajaran($monthyear)["total"], 0); ?></td>
                                    <td></td>
                                </tr>
                            </table>
                            <br>
                            <table id="example2" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Kode Akun</th>
                                        <th>Rutin/NonRutin</th>
                                        <th>Kode</th>
                                        <th width=35%>keterangan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($dataPengeluaran as $dataPengeluaranv) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $dataPengeluaranv['tanggal'] ?></td>
                                            <td><?php echo $dataPengeluaranv['kode_akun'] . "::" . $dataPengeluaranv['nama_akun'] ?></td>
                                            <td><?php echo $dataPengeluaranv['rutin'] ?></td>
                                            <td align=right><?php echo number_format($dataPengeluaranv['rp'], 0) ?></td>
                                            <td><?php echo $dataPengeluaranv['keterangan'] ?></td>
                                        </tr>


                                    <?php
                                        $no++;
                                    }
                                    ?>


                                </tbody>
                            </table>
                            <table id="examplesum" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Total Rutin</th>
                                        <th style="text-align:right"><?php echo number_format(isset($totalRutin['totalRutin']), 0); ?></th>
                                        <th width=40%></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Total NonRutin</th>
                                        <th style="text-align:right"><?php echo number_format(isset($totalNonRutin['totalNonRutin']) ?? 0, 0); ?></th>
                                        <th width=40%></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Total All</th>
                                        <th style="text-align:right"><?php echo number_format(isset($totalAll['totalAll']), 0); ?></th>
                                        <th width=40%></th>
                                    </tr>
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
    $(document).ready(function() {
        ftablewali('<?php echo base_url(); ?>/index.php/ReportEks/pengeluaranFormulir/JSON?monthyear=<?= $monthyear ?>', '#detildsb2');
    });


    function ftablewali(urld, id) {
        var numberRenderer = $.fn.dataTable.render.number(',', '.', 0, ).display;
        $(id).DataTable({
            "pageLength": 50,
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
                'url': urld,
                'dataSrc': ""
            },
            columnDefs: [{
                targets: 2,
                render: $.fn.dataTable.render.number(',', '.', 0, ''),
                className: 'dt-body-right'
            }],
            footerCallback: function(row, data, start, end, display) {
                let api = this.api();

                // Remove the formatting to get integer data for summation
                let intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i :
                        0;
                };
                total = api
                    .column(2)
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);
                pageTotal = api
                    .column(2, {
                        page: 'current'
                    })
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);
                // Update footer
                // api.column(2).footer().innerHTML =
                //     ' Total Rp ' + numberRenderer(total);

            },
            'columns': [{
                    'data': 'row_num',
                    'title': 'RP'
                },
                {
                    'data': 'nama_siswa',
                    'title': 'NAMA SISWA',
                    render: function(data, type, row, meta) {
                        if (!row.nama_siswa)
                            return 'Luncuran dari bulan sebelumnya'
                        else
                            return row.nama_siswa
                    }

                },

                {
                    'data': 'sum',
                    'title': 'Total Bayar (Rp)'
                },

            ],

        });
    }

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

<?= $this->endSection() ?>