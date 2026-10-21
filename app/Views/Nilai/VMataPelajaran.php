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
                    <h1 class="m-0">Mata Pelajaran</h1>
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
                            <h5>Data Mata Pelajaran</h5>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">

                            <div class="modal fade" id="ModalNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h5 class="modal-title" id="test2">New Data Mata Pelajaran</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo base_url('index.php/matapelajaran/tambah/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                <div class="form-gorup">
                                                    <label for="exampleInputEmail1">Nama Mata Pelajaran</label><input class="form-control" name="nama_matapelajaran" type=text value="">
                                                    <label for="exampleInputEmail1">Kode Mata Pelajaran</label><input class="form-control" name="kode_matapelajaran" type=text value="">
                                                    <label for="exampleInputEmail1">Nama Kelompok Mata Pelajaran</label>
                                                    <select class="form-control" id="idkelompok" name="id_kelompok">
                                                        <?php foreach (kelompokMataPelajaran() as $valkel) { ?>
                                                            <option value="<?php echo $valkel["id_kelompok"] ?>"><?= $valkel["nama_kelompok"] ?></option><?php } ?>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalNew" data-whatever="@mdo"><i class="fas fa-folder-plus"></i></button>
                            </p>
                            <div class="form-group">

                                <form action="<?php echo base_url('index.php/matapelajaran/index/' . $menuAktip . "/" . $moduleAktip) ?>" method="get" accept-charset="utf-8" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="mataPelajaran">Pilih Kelompok Mata Pelajaran</label>
                                        </div>
                                        <div class="col-3">
                                            <select id="kelompokMataPelajaran" name="id_kelompok" class="form-control select2 select2-hidden-accessible">
                                                <?php
                                                $kelompokMataPelajaran = kelompokMataPelajaran();
                                                foreach (kelompokMataPelajaran() as $val) {
                                                ?>
                                                    <option value="<?= $val['id_kelompok'] ?>"><?= $val['nama_kelompok'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="mt-5">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID Mata Pelajaran</th>
                                            <th>Nama Kelompok</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Kode Pelajaran</th>
                                            <th>Command</th>
                                        </tr>
                                    </thead>
                                </table>
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
<!-- <script src="<?php //echo base_url(); 
                    ?>/asset/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>
<!-- Page specific script -->
<script>
    function ftablematapelajaran(urld) {
        $('#example').DataTable({
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
                'dataSrc': "DataModule"
            },
            select: true,

            'columns': [{
                    'data': 'id_matapelajaran'
                },
                {
                    'data': 'nama_kelompok'
                },
                {
                    'data': 'nama_matapelajaran'
                },
                {
                    'data': 'kode_matapelajaran'
                },
                {
                    data: null,

                    render: function(data, type, row, meta) {
                        $(function() {
                            $("#idkelompok option[value='" + data['id_kelompok'] + "']").attr("selected", true);
                        });

                        return '<!-- Button trigger modal -->' +
                            '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalEdit' + data['id_matapelajaran'] + '"><i class="fas fa-pencil-alt" title="Edit Data"></i></button>' +
                            '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalDelete' + data['id_matapelajaran'] + '"><i class="fas fa-trash" title="Delete Data"></i></button>' +
                            '<!-- Modal Edit-->' +
                            '<form action="<?php echo base_url('index.php/matapelajaran/edit/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">' +
                            '<div class="modal fade" id="ModalEdit' + data['id_matapelajaran'] + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' +
                            '<div class="modal-dialog" role="document">' +
                            '<div class="modal-content">' +

                            '<div class="card card-primary">' +
                            '<div class="card-header">' +
                            '<h5 class="modal-title" id="test2">Edit Data Mata Pelajaran</h5>' +
                            '</div></div>' +

                            '<div class="card-body">' +
                            '<div class="form-gorup">' +

                            '<label for="exampleInputEmail1">Id Mata Pelajaran</label><input class="form-control" name="id_matapelajaran" type=text value="' + data['id_matapelajaran'] + '" >' +
                            '<label for="exampleInputEmail1">Nama Mata Pelajaran</label><input class="form-control" name="nama_matapelajaran" type=text value="' + data['nama_matapelajaran'] + '" > ' +
                            '<label for="exampleInputEmail1">Kode Mata Pelajaran</label><input class="form-control" name="kode_matapelajaran" type=text value="' + data['kode_matapelajaran'] + '" > ' +
                            '<label for="exampleInputEmail1">Nama Kelompok Mata Pelajaran</label><select class="form-control" id="idkelompok" name="id_kelompok"><?php foreach (kelompokMataPelajaran() as $valkel) { ?><option value="<?php echo $valkel["id_kelompok"] ?>"><?= $valkel["nama_kelompok"] ?></option><?php } ?></select>' +
                            '</div>' +
                            '<div class="modal-footer">' +
                            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' +
                            '<button type="submit" class="btn btn-primary">Save changes</button></div></div></div></div></div></form>' +

                            '<!-- Modal Delete-->' +
                            '<form action="<?php echo base_url('index.php/matapelajaran/delete/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">' +
                            '<div class="modal fade" id="ModalDelete' + data['id_matapelajaran'] + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' +
                            '<div class="modal-dialog" role="document">' +
                            '<div class="modal-content">' +

                            '<div class="card card-danger">' +
                            '<div class="card-header">' +
                            '<h5 class="modal-title" id="test2">Delete Data Mata Pelajaran</h5>' +
                            '</div></div>' +

                            '<div class="card-body">' +
                            '<div class="form-gorup">' +

                            '<label for="exampleInputEmail1">Id Mata Pelajaran</label><input class="form-control" name="id_matapelajaran" type=text value="' + data['id_matapelajaran'] + '" >' +
                            '</div>' +
                            '<div class="modal-footer">' +
                            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' +
                            '<button type="submit" class="btn btn-danger">Delete</button></div></div></div></div></div></form>'

                        ;
                    }
                }
            ],

        });
    }
    var urldf = '<?= base_url('index.php/matapelajaran/json/') ?>' + '/2';
    $(document).ready(function() {
        ftablematapelajaran(urldf);
        $('#kelompokMataPelajaran').on('change', function() {
            //alert($(this).find(":selected").val());
            var urld = '<?= base_url('index.php/matapelajaran/json/') ?>' + '/' + $(this).find(":selected").val();
            $('#example').DataTable().destroy();
            ftablematapelajaran(urld);
        });


    });
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