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
                            <h2>Data Pengeluaran UTS</h2>

                        </div>

                        <!-- /.modal new -->
                        <div class="modal fade" id="ModalNewData" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Data Pengeluaran SPP</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form name=modalEntri action="<?php echo base_url('index.php/transaksi/pengeluaranUTS/insertPengeluaran/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Kode Akun</span>
                                                <select name=kode_akun class="form-control">
                                                    <?php $kodeakun = dataakun() ?>
                                                    <?php foreach ($kodeakun as $kodeakunv) { ?>
                                                        <option value="<?php echo $kodeakunv['kode_akun'] ?>"><?php echo $kodeakunv['kode_akun'] . "::" . $kodeakunv['nama_akun'] ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Nama Pengusul</span>
                                                <select name=kode_pengusul class="form-control">
                                                    <?php $kodepengusul = datapengusul() ?>
                                                    <?php foreach ($kodepengusul as $kodepengusulv) { ?>

                                                        <option value="<?php echo $kodepengusulv['kode_pengusul'] ?>"><?php echo $kodepengusulv['nama_pengusul'] ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <?php $rutin = array('RUTIN', 'NONRUTIN'); ?>

                                                <span class="input-group-text" id="basic-addon3">Rutin/Non Rutin</span>
                                                <select name=rutin class="form-control">
                                                    <?php
                                                    ?>
                                                    <?php
                                                    foreach ($rutin as $rutinv) { ?>
                                                        <option value="<?php echo $rutinv ?>"><?php echo $rutinv; ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Tanggal</span>
                                                <input name="tanggal" type="date" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Rupiah</span>
                                                <input name="rp" type="text" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">Keterangan</span>
                                                <input name="keterangan" type="text" class="form-control" id="recipient-name" value="">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" onclick="return ceknull();"><i class="fas fa-save"> Save</i></button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <center>
                                <form action="<?php echo base_url('index.php/transaksi/pengeluaranUTS/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="post">
                                    <label for="start">Pilih Bulan : &nbsp;&nbsp;&nbsp;</label>
                                    <input type="month" name="monthyear" value="<?php echo $monthyear; ?>">&nbsp;&nbsp;&nbsp;
                                    <button>Pilih Bulan</button>

                                </form>
                            </center>
                            <p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalNewData"><i class="fas fa-plus"></i> New Data</button>
                            </p>
                            <table id="example2" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <!-- <th width=100 scope="col"></th> -->
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Kode Akun</th>
                                        <th>Rutin/NonRutin</th>
                                        <th>Kode</th>
                                        <th width=35%>keterangan</th>
                                        <th>Action</th>
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
                                            <td>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#ModalEditData<?php echo $dataPengeluaranv['no']; ?>" type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
                                                <button class="btn btn-primary btn-danger" data-toggle="modal" data-target="#ModalDeleteData<?php echo $dataPengeluaranv['no']; ?>" type="button" class="btn btn-primary"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <!-- /.modal edit -->
                                        <div class="modal fade" id="ModalEditData<?php echo $dataPengeluaranv['no']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Data Pengeluaran SPP</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form name=modalUpdate action="<?php echo base_url('index.php/transaksi/pengeluaranUTS/updatePengeluaran/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Kode Akun</span>
                                                                <select name=kode_akun class="form-control">
                                                                    <?php $kodeakun = dataakun() ?>
                                                                    <?php foreach ($kodeakun as $kodeakunv) { ?>
                                                                        <?php if ($dataPengeluaranv['kode_akun'] == $kodeakunv['kode_akun']) {
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        } ?>
                                                                        <option value="<?php echo $kodeakunv['kode_akun'] ?>" <?php echo $selected ?>><?php echo $kodeakunv['kode_akun'] . "::" . $kodeakunv['nama_akun'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Nama Pengusul</span>
                                                                <select name=kode_pengusul class="form-control">
                                                                    <?php $kodepengusul = datapengusul() ?>
                                                                    <?php foreach ($kodepengusul as $kodepengusulv) { ?>
                                                                        <?php if ($dataPengeluaranv['kode_pengusul'] == $kodepengusulv['kode_pengusul']) {
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        } ?>
                                                                        <option value="<?php echo $kodepengusulv['kode_pengusul'] ?>" <?php echo $selected ?>><?php echo $kodepengusulv['nama_pengusul'] ?></option>

                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <?php $rutin = array('RUTIN', 'NONRUTIN'); ?>

                                                                <span class="input-group-text" id="basic-addon3">Rutin/Non Rutin</span>
                                                                <select name=rutin class="form-control">
                                                                    <?php
                                                                    foreach ($rutin as $rutinv) { ?>
                                                                        <?php if ($rutinv == $dataPengeluaranv['rutin']) {
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        } ?>
                                                                        <option value="<?php echo $rutinv ?>" <?php echo $selected ?>><?php echo $rutinv; ?></option>
                                                                    <?php
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Tanggal</span>
                                                                <input name="tanggal" type="date" class="form-control" id="recipient-name" value="<?php echo $dataPengeluaranv['tanggal'] ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Rupiah</span>
                                                                <input name="rp" type="text" class="form-control" id="recipient-name" value="<?php echo $dataPengeluaranv['rp'] ?>">
                                                                <input name="no" type="hidden" class="form-control" id="recipient-name" value="<?php echo $dataPengeluaranv['no'] ?>">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Keterangan</span>
                                                                <input name="keterangan" type="text" class="form-control" id="recipient-name" value="<?php echo $dataPengeluaranv['keterangan'] ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button class="btn btn-primary" onclick="return ceknullUpdate();"><i class="fas fa-save"> Save</i></button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal edit -->
                                        <div class="modal fade" id="ModalDeleteData<?php echo $dataPengeluaranv['no']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalNewData" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title">Hapus Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form name=modalUpdate action="<?php echo base_url('index.php/transaksi/pengeluaranUTS/deletePengeluaran/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">No</span>
                                                                <input name="no" type="text" class="form-control" id="recipient-name" value="<?php echo $dataPengeluaranv['no'] ?>" readonly>
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
                                    <?php
                                        $no++;
                                    }
                                    ?>


                                </tbody>
                            </table>
                            <table id="example2" class="table table-striped">
                                <tbody>
                                    <tr>
                                        <!-- <th width=100 scope="col"></th> -->
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Total Rutin</th>
                                        <th style="text-align:right"><?php echo number_format(isset($totalRutin['totalRutin']), 0); ?></th>
                                        <th width=40%></th>
                                    </tr>
                                    <tr>
                                        <!-- <th width=100></th> -->
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Total NonRutin</th>
                                        <th style="text-align:right"><?php echo number_format(isset($totalNonRutin['totalNonRutin']), 0); ?></th>
                                        <th width=40%></th>
                                    </tr>
                                    <tr>
                                        <!-- <th width=100></th> -->
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
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "pageLength": 50,
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