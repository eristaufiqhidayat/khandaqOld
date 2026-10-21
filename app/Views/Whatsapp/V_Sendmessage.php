<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/select2/css/select2.min.css">
<style>
    @media(max-width: 576px) {
        .nota {
            justify-content: center !important;
            text-align: center !important;
        }
    }
</style>
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<?= $this->endSection() ?>
<?= $this->section('main') ?>
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card" style="width: 40rem;">
                        <div class="card-header">
                            <h2>Daftar Message Wa</h2>
                        </div>
                        <div class="card-body">
                            <form id="form">
                                <input type="hidden" name="id">
                                <div class="form-group">
                                    <label>API Server</label>
                                    <select name="myapp" id="myapp" class="form-control select2" required></select>
                                </div>
                                <div class="form-group">
                                    <label>ID Message Wa</label>
                                    <select name="message" id="message" class="form-control select2" required></select>
                                </div>
                                <div class="form-group">
                                    <label>Group WA</label>
                                    <select name="groupwa" id="groupwa" class="form-control select2" required></select>
                                </div>
                                <div class="form-group">
                                    <label>Template</label>
                                    <select name="template" id="template" class="form-control select2"></select>
                                    <input type="hidden" id="type" name="type" value="">
                                    <input type="hidden" id="type" name="imageurl" value="">
                                </div>
                                <button class="btn btn-success" type="submit">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 40rem;">
                        <div class="card-header">
                            <h2>View Logger</h2>
                        </div>
                        <div class="card-body">
                            <table class="table w-100 table-bordered table-hover" id="logger">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Id</th>
                                        <th>no hp</th>
                                        <th>template</th>
                                        <th>DateTime</th>
                                        <th>myapp</th>
                                        <th>Status</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 40rem;">
                        <div class="card-header">
                            <h2>View Message Wa</h2>
                        </div>
                        <div class="card-body">
                            <form id="form2">
                                <textarea name=vmessage id=vmessage cols="80" rows="9"></textarea>
                                <button name="buttonesave" class="btn btn-success" type="submit">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 40rem;">
                        <div class="card-header">
                            <h2>View No Telp</h2>
                        </div>
                        <div class="card-body">
                            <table class="table w-100 table-bordered table-hover" id="notelp">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Id</th>
                                        <th>Nama</th>
                                        <th>No Hp</th>
                                        <th>Group</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 40rem;">
                        <div class="card-header">
                            <h2>View API Server</h2>
                        </div>
                        <div class="card-body">
                            <table class="table w-100 table-bordered table-hover" id="apiserver">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Id</th>
                                        <th>App Key</th>
                                        <th>Auth Key</th>
                                        <th>Vendor</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
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
<!-- <script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script> -->
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php //echo base_url(); 
                    ?>/asset/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>
<!-- Page specific script -->
<script src="<?php echo BPATH; ?>/asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/sweetalert/sweetalert.min.js"></script>

<script>
    var readgroupwa = '<?php echo site_url('Whatsapp/sendwa/groupwa') ?>';
    var readapiserver = '<?php echo site_url('Whatsapp/sendwa/apiserver') ?>';
    var sendUrl = '<?php echo site_url('Whatsapp/sendwa/send') ?>';
    var JSONmyapp = '<?php echo site_url('Whatsapp/sendwa/readjsonAPIServer/58/1') ?>';
    var JSONmessage = '<?php echo site_url('Whatsapp/sendwa/readjsonMessage/58/1') ?>';
    var JSONmessagebyno = '<?php echo site_url('Whatsapp/sendwa/readjsonMessagebyno') ?>';
    var JSONGroupwa = '<?php echo site_url('Whatsapp/sendwa/readjsonGroupwa/58/1') ?>';
    var JSONLogger = '<?php echo site_url('Whatsapp/sendwa/readjsonlog') ?>';
    var JSONTemplate = '<?php echo site_url('Whatsapp/sendwa/readjsontemplate') ?>';
</script>
<script src="<?php echo BPATH; ?>/asset/js/sendwa.min.js"></script>
<?= $this->endSection() ?>