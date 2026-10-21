<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
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
                    <h1 class="m-0">Jadwal Ngajar</h1>
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
                            <h5>Data Jadwal Ngajar<?= $id_kelas ?></h5>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">

                            <table id=example class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan=2 style="text-align: center; vertical-align: middle;">Hari</th>
                                        <th rowspan=2 style="text-align: center; vertical-align: middle;">Nama Kelas</th>
                                        <th rowspan=2 style="text-align: center; vertical-align: middle;">Nama Guru</th>
                                        <th colspan=10 style="text-align: center; vertical-align: middle;">Jam</th>

                                    </tr>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;">08</th>
                                        <th style="text-align: center; vertical-align: middle;">09</th>
                                        <th style="text-align: center; vertical-align: middle;">10</th>
                                        <th style="text-align: center; vertical-align: middle;">11</th>
                                        <th style="text-align: center; vertical-align: middle;">12</th>
                                        <th style="text-align: center; vertical-align: middle;">13</th>
                                        <th style="text-align: center; vertical-align: middle;">14</th>
                                        <th style="text-align: center; vertical-align: middle;">15</th>
                                        <th style="text-align: center; vertical-align: middle;">16</th>
                                        <th style="text-align: center; vertical-align: middle;">17</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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

<?php if (isset($pguru)) { ?>
    <script>
        function ftable(urld) {
            let idguru = "<?= $pguru["id_guru"] ?>";
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

                'columns': [{
                        'data': 'hari'
                    },
                    {
                        'data': 'nama_kelas'
                    }, {
                        'data': 'nama_guru',
                        render: function(data, type, row, meta) {
                            if (row.id_guru === idguru)
                                return '<b style="color:red;">' + row.nama_guru + '</b>'
                            else
                                return row.nama_guru
                        }
                    },
                    {
                        'data': 'jam08_00'
                    },
                    {
                        'data': 'jam09_00'
                    },
                    {
                        'data': 'jam10_00'
                    },
                    {
                        'data': 'jam11_00'
                    },
                    {
                        'data': 'jam12_00',
                        render: function(data, type, row, meta) {
                            return 'ISTIRAHAT'
                        }
                    },
                    {
                        'data': 'jam13_00',
                        render: function() {
                            return 'ISTIRAHAT'
                        }
                    },
                    {
                        'data': 'jam14_00'
                    },
                    {
                        'data': 'jam15_00'
                    },
                    {
                        'data': 'jam16_00'
                    },
                    {
                        'data': 'jam17_00'
                    }
                ],
            });
        }

        var urldf = '<?= base_url('index.php/guru/walikelas/jsonjadwalperguru/?id_guru=' . $pguru["id_guru"]) ?>';
        $(document).ready(function() {
            ftable(urldf);
        });
    </script>
<?php } ?>
<?= $this->endSection() ?>