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
                            <h2>Data DSB</h2>

                        </div>

                        <div class="card-body">
                            <table id="detildsb" class="table table-bordered table-striped">
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align:right">Total:</th>
                                        <th></th>
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
<script src="<?php echo BPATH; ?>/asset/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>

<script>
    $('#Modaldetildsb').on('shown.bs.modal', function(e) {
        let triggerLink = $(e.relatedTarget);
        let id = triggerLink[0].dataset['id'];
        ftablewali('<?php echo base_url(); ?>/ReportEks/pengeluaranSPP/JSON?monthyear=<?= $monthyear ?>');
        //$("#carddata ").load(urlwali);
    })

    function ftablewali(urld) {
        var numberRenderer = $.fn.dataTable.render.number(',', '.', 0, ).display;
        $('#detildsb').DataTable({
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
                targets: 3,
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
                    .column(3)
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);
                pageTotal = api
                    .column(3, {
                        page: 'current'
                    })
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);
                // Update footer
                api.column(3).footer().innerHTML =
                    ' Total Rp ' + numberRenderer(total);

            },
            'columns': [{
                    'data': 'row_num',
                    'title': 'No'
                },
                {
                    'data': 'id_siswa',
                    'title': 'ID SISWA',
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
                    'title': 'Total Bayar'
                },
                {
                    'data': 'locked',
                    'title': 'STATUS SISWA'
                }
            ],

        });
    }
    $(document).ready(function() {

        ftablewali('<?php echo base_url(); ?>/ReportEks/pengeluaranSPP/JSON?monthyear=<?= $monthyear ?>');
    });
</script>
<?= $this->endSection() ?>