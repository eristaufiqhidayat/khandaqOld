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
                            <h2>Data Beasiswa</h2>
                        </div>
                        <div class="card-body">
                            <form name=modalUpdate action="<?php echo base_url('index.php/TataUsaha/Beasiswa/updateBeasiswa/' . $menuAktip . "/" . $moduleAktip) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                <button type=submit class="btn btn-primary btn-blue"><i class="fas fa-save"> Update Data Beasiswa</i></button>
                                <table id="example2" class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <!-- <th width=100 scope="col"></th> -->
                                            <th>No</th>
                                            <th>id_siswa</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Beasiswa</th>
                                            <th>Persen Beasiswa</th>
                                            <th>Rp</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php

                                        foreach ($dataBeasiswa as $kdatabeasiswa => $vdataBeasiswa) {
                                            $id_siswa = $vdataBeasiswa['id_siswa'];
                                            $cdataBeasiswa[$id_siswa] = array(
                                                'id_beasiswa' => $vdataBeasiswa["id_beasiswa"],
                                                'peserta' => $vdataBeasiswa["peserta"],
                                                'persen' => $vdataBeasiswa["persen"],
                                                'rp' => $vdataBeasiswa["rp"]
                                            );
                                        }
                                        //dd($cdataBeasiswa);
                                        ?>

                                        <?php
                                        $no = 1;
                                        foreach ($dataList as $dataListv) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $dataListv['id_siswa'] ?></td>
                                                <td><?php echo $dataListv['nama_siswa'] ?></td>
                                                <td><?php echo $dataListv['nama_kelas'] ?></td>
                                                <?php
                                                if (isset($cdataBeasiswa[$dataListv['id_siswa']]['peserta'])) {
                                                    if ($cdataBeasiswa[$dataListv['id_siswa']]['peserta'] == 'yes') {
                                                        $checked = 'checked';
                                                    } else {
                                                        $checked = '';
                                                    }
                                                } else {
                                                    $checked = '';
                                                }
                                                if (isset($cdataBeasiswa[$dataListv['id_siswa']]['id_beasiswa'])) {
                                                    $id_beasiswa = isset($cdataBeasiswa[$dataListv['id_siswa']]['id_beasiswa']);
                                                } else {
                                                    $id_beasiswa = "";
                                                }
                                                ?>
                                                <td><input type=hidden name=id_siswa[<?= $dataListv['id_siswa'] ?>] value=<?= $dataListv['id_siswa'] ?>>
                                                    <input type=hidden name=id_beasiswa[<?= $dataListv['id_siswa'] ?>] value=<?= $id_beasiswa ?>>
                                                    <input type=checkbox name=peserta[<?= $dataListv['id_siswa'] ?>] <?= $checked ?>>
                                                </td>
                                                <td><input type=text name=persen[<?= $dataListv['id_siswa'] ?>] value=<?php if (isset($cdataBeasiswa[$dataListv['id_siswa']]['persen'])) echo $cdataBeasiswa[$dataListv['id_siswa']]['persen'] ?>></td>
                                                <td><input type=text name=rp[<?= $dataListv['id_siswa'] ?>] value=<?php if (isset($cdataBeasiswa[$dataListv['id_siswa']]['rp'])) echo $cdataBeasiswa[$dataListv['id_siswa']]['rp'] ?>></td>
                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
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
            "lengthChange": false,
            "pageLength": 300,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            //"destroy":true,
        });
    });
</script>
<?= $this->endSection() ?>