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
                            <h5>Data Nilai Siswa</h5>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-1">
                                    <label>Pilih kelas : </label>
                                </div>
                                <div class="col-2">
                                    <form class="form-group" action="<?php echo base_url('index.php/guru/jadwalmengajar/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="get" accept-charset="utf-8" enctype="multipart/form-data">
                                        <select id="idid_kelas" name="id_kelas" class="form-control select2 select2-hidden-accessible">
                                            <?php foreach (rowkelas() as $kelasv) {
                                            ?>
                                                <option value="<?= $kelasv["id_kelas"] ?>"><?= $kelasv["nama_kelas"] ?> </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </form>
                                </div>
                                <div class="col-2">
                                    <label>Pilih Mata Pelajaran : </label>
                                </div>
                                <div class="col-2">
                                    <form class="form-group" action="<?php echo base_url('index.php/guru/jadwalmengajar/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="get" accept-charset="utf-8" enctype="multipart/form-data">
                                        <select id="idid_matapelajaran" name="id_matapelajaran" class="form-control select2 select2-hidden-accessible">
                                            <?php foreach (MataPelajaran() as $kelasv) {
                                            ?>
                                                <option value="<?= $kelasv["id_matapelajaran"] ?>"><?= $kelasv["nama_matapelajaran"] ?> </option>
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
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Siswa</th>
                                        <th colspan="20" style="text-align: center; vertical-align: middle;">Nilai</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;">Tugas</th>
                                        <th style="text-align: center; vertical-align: middle;">UTS</th>
                                        <th style="text-align: center; vertical-align: middle;">UAS</th>
                                        <th style="text-align: center; vertical-align: middle;">H1</th>
                                        <th style="text-align: center; vertical-align: middle;">H2</th>
                                        <th style="text-align: center; vertical-align: middle;">H3</th>
                                        <th style="text-align: center; vertical-align: middle;">H4</th>
                                        <th style="text-align: center; vertical-align: middle;">H5</th>
                                        <th style="text-align: center; vertical-align: middle;">H6</th>
                                        <th style="text-align: center; vertical-align: middle;">H7</th>
                                        <th style="text-align: center; vertical-align: middle;">H8</th>
                                        <th style="text-align: center; vertical-align: middle;">K1</th>
                                        <th style="text-align: center; vertical-align: middle;">K2</th>
                                        <th style="text-align: center; vertical-align: middle;">K3</th>
                                        <th style="text-align: center; vertical-align: middle;">K4</th>
                                        <th style="text-align: center; vertical-align: middle;">K5</th>
                                        <th style="text-align: center; vertical-align: middle;">K6</th>
                                        <th style="text-align: center; vertical-align: middle;">K7</th>
                                        <th style="text-align: center; vertical-align: middle;">K8</th>
                                        <th style="text-align: center; vertical-align: middle;">Nilai Akhhir</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;"></th>
                                        <th style="text-align: center; vertical-align: middle;">Nama Siswa</th>
                                        <th style="text-align: center; vertical-align: middle;">tugas</th>
                                        <th style="text-align: center; vertical-align: middle;">uts</th>
                                        <th style="text-align: center; vertical-align: middle;">uas</th>
                                        <th style="text-align: center; vertical-align: middle;">H1</th>
                                        <th style="text-align: center; vertical-align: middle;">H2</th>
                                        <th style="text-align: center; vertical-align: middle;">H3</th>
                                        <th style="text-align: center; vertical-align: middle;">H4</th>
                                        <th style="text-align: center; vertical-align: middle;">H5</th>
                                        <th style="text-align: center; vertical-align: middle;">H6</th>
                                        <th style="text-align: center; vertical-align: middle;">H7</th>
                                        <th style="text-align: center; vertical-align: middle;">H8</th>
                                        <th style="text-align: center; vertical-align: middle;">K1</th>
                                        <th style="text-align: center; vertical-align: middle;">K2</th>
                                        <th style="text-align: center; vertical-align: middle;">K3</th>
                                        <th style="text-align: center; vertical-align: middle;">K4</th>
                                        <th style="text-align: center; vertical-align: middle;">K5</th>
                                        <th style="text-align: center; vertical-align: middle;">K6</th>
                                        <th style="text-align: center; vertical-align: middle;">K7</th>
                                        <th style="text-align: center; vertical-align: middle;">K8</th>
                                        <th style="text-align: center; vertical-align: middle;">Nilai Akhhir</th>
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
            "columns": [{
                    "data": "row_num"
                },
                {
                    "data": "nama_siswa"
                },
                {
                    "data": "nilai_tugas"
                },
                {
                    "data": "nilai_uts"
                },
                {
                    "data": "nilai_uas"
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
                    "data": "K8"
                },
                {
                    "data": null,
                    render: function(data, type, row, meta) {
                        var nilaiharian = [data["H1"], data["H2"], data["H3"], data["H4"], data["H5"], data["H6"], data["H7"], data["H8"]];

                        return ((0.2 * data["nilai_tugas"]) + (0.3 * data["nilai_uts"]) + (0.5 * data["nilai_uas"]))
                    }
                }
            ]
        });
    }
    var urldf = '<?= base_url('index.php/nilaisiswa/json/?id_kelas=') ?>' + $('#idid_kelas').find(":selected").val() + '&id_matapelajaran=' + $('#idid_matapelajaran').find(":selected").val();;
    $(document).ready(function() {
        ftable(urldf);
    });
    $('#idid_kelas').on('change', function() {
        var urldf = '<?= base_url('index.php/nilaisiswa/json/?id_kelas=') ?>' + $(this).find(":selected").val() + '&id_matapelajaran=' + $('#idid_matapelajaran').find(":selected").val();
        $('#example').DataTable().destroy();
        ftable(urldf);
    })
    $('#idid_matapelajaran').on('change', function() {
        var urldf = '<?= base_url('index.php/nilaisiswa/json/?id_kelas=') ?>' + $('#idid_kelas').find(":selected").val() + '&id_matapelajaran=' + $(this).find(":selected").val();
        $('#example').DataTable().destroy();
        ftable(urldf);
    })
</script>
<?= $this->endSection() ?>