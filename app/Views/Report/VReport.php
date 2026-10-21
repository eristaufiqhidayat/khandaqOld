<?= $this->extend('Views\layout.php') ?>
<?php
/** @var array $report */
/** @var int $tahunAjaran */
/** @var array $pilihanTahun */
/** @var int $bulanBerjalan */
/** @var string $menuAktip */
/** @var string $moduleAktip */
?>
<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<style>
  .rs-kpi { font-size: 1.8rem; font-weight: 700; line-height: 1.2; }
  .rs-muted { color: #5a6472; }
  .rs-masuk { color: #1f5fbf; }
  .rs-keluar { color: #b35c00; }
  .rs-chart { position: relative; height: 220px; display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 8px; align-items: end; border-bottom: 1px solid #c9d1dc; min-width: 640px; }
  .rs-chart-col { height: 100%; display: flex; align-items: flex-end; justify-content: center; gap: 3px; }
  .rs-chart-col > div { width: 38%; border-radius: 3px 3px 0 0; }
  .rs-bar-masuk { background: #1f5fbf; }
  .rs-bar-keluar { background: #f0a030; }
  .rs-target { position: absolute; left: 0; right: 0; border-top: 2px dashed #3a4350; pointer-events: none; }
  .rs-labels { display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 8px; padding-top: 6px; min-width: 640px; text-align: center; font-size: 0.8rem; }
  .rs-swatch { display: inline-block; width: 12px; height: 12px; border-radius: 3px; margin-right: 4px; vertical-align: middle; }
  .rs-table { font-variant-numeric: tabular-nums; font-size: 0.9rem; }
  .rs-table td, .rs-table th { white-space: nowrap; vertical-align: middle; }
  .rs-table th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; color: #5a6472; }
  .rs-kurang { background: #fdf0dc !important; color: #8a4600; font-weight: 600; }
  .rs-nanti { color: #9aa3ae; }
  .rs-ringkas td { background: #f8f9fb; font-weight: 700; }
  .rs-ringkas-akhir td { background: #eef1f5; font-weight: 700; }
</style>
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?php
$namaBulan = ['Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
$rp = function ($n) {
  return number_format((float) $n, 0, ',', '.');
};
// Sel bulan: "–" untuk bulan yang belum berjalan dan belum ada transaksi
$sel = function ($v, $i, $kurang = false) use ($bulanBerjalan, $rp) {
  if ($i >= $bulanBerjalan) {
    if ($v == 0) return '<td class="text-right rs-nanti">–</td>';
    $kurang = false;
  }
  return '<td class="text-right' . ($kurang ? ' rs-kurang' : '') . '">' . $rp($v) . '</td>';
};
$selisih = [];
foreach ($report['masuk'] as $i => $v) $selisih[$i] = $v - $report['keluar'][$i];
$maks = max(array_merge($report['masuk'], $report['keluar'], [$report['targetBulan'], 1]));
$capaian = $report['targetBerjalan'] > 0 ? round($report['totalMasuk'] * 100 / $report['targetBerjalan']) : 0;
$kelasList = array_unique(array_column($report['siswa'], 'nama_kelas'));
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex flex-wrap align-items-end justify-content-between">
      <div class="mb-2">
        <h1 class="m-0">Report SPP</h1>
        <div class="rs-muted">Pemasukan SPP (TDSPP) per bulan · Juli <?= $tahunAjaran ?> – Juni <?= $tahunAjaran + 1 ?></div>
      </div>
      <form class="form-inline mb-2" action="<?= base_url('index.php/Report/Spp/' . $menuAktip . '/' . $moduleAktip) ?>" method="get">
        <label for="tahunajaranselect" class="mr-2">Tahun ajaran</label>
        <select id="tahunajaranselect" name="tahunajaranselect" class="form-control mr-2">
          <?php foreach ($pilihanTahun as $t) { ?>
            <option value="<?= $t ?>" <?= $t === $tahunAjaran ? 'selected' : '' ?>><?= $t ?>/<?= $t + 1 ?></option>
          <?php } ?>
        </select>
        <button class="btn btn-primary">Tampilkan</button>
      </form>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="card"><div class="card-body">
            <div class="rs-muted font-weight-bold">Target <?= $bulanBerjalan ?> bulan</div>
            <div class="rs-kpi"><?= $rp($report['targetBerjalan']) ?></div>
            <div class="rs-muted small">target per bulan <?= $rp($report['targetBulan']) ?></div>
          </div></div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="card"><div class="card-body">
            <div class="rs-muted font-weight-bold">Pemasukan SPP</div>
            <div class="rs-kpi rs-masuk"><?= $rp($report['totalMasuk']) ?></div>
            <div class="rs-muted small"><?= $capaian ?>% dari target</div>
          </div></div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="card"><div class="card-body">
            <div class="rs-muted font-weight-bold">Pengeluaran</div>
            <div class="rs-kpi rs-keluar"><?= $rp($report['totalKeluar']) ?></div>
            <div class="rs-muted small">dari tabel pengeluaran</div>
          </div></div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="card"><div class="card-body">
            <div class="rs-muted font-weight-bold">Saldo</div>
            <div class="rs-kpi"><?= $rp($report['totalMasuk'] - $report['totalKeluar']) ?></div>
            <div class="rs-muted small">pemasukan − pengeluaran</div>
          </div></div>
        </div>
      </div>

      <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center">
          <h3 class="card-title mr-auto">Pemasukan vs pengeluaran per bulan</h3>
          <div class="rs-muted small">
            <span class="mr-3"><span class="rs-swatch rs-bar-masuk"></span>Pemasukan</span>
            <span class="mr-3"><span class="rs-swatch rs-bar-keluar"></span>Pengeluaran</span>
            <span><span class="rs-swatch" style="height:0;border-top:2px dashed #3a4350"></span>Target/bulan</span>
          </div>
        </div>
        <div class="card-body" style="overflow-x:auto">
          <div class="rs-chart">
            <div class="rs-target" style="bottom:<?= $report['targetBulan'] * 100 / $maks ?>%"></div>
            <?php foreach ($namaBulan as $i => $b) { ?>
              <div class="rs-chart-col" title="<?= $b ?>: masuk <?= $rp($report['masuk'][$i]) ?>, keluar <?= $rp($report['keluar'][$i]) ?>">
                <div class="rs-bar-masuk" style="height:<?= $report['masuk'][$i] * 100 / $maks ?>%"></div>
                <div class="rs-bar-keluar" style="height:<?= $report['keluar'][$i] * 100 / $maks ?>%"></div>
              </div>
            <?php } ?>
          </div>
          <div class="rs-labels rs-muted">
            <?php foreach ($namaBulan as $b) { ?><div><?= $b ?></div><?php } ?>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Pemasukan per kelas</h3>
        </div>
        <div class="card-body p-0 table-responsive">
          <table class="table table-sm rs-table mb-0">
            <thead>
              <tr>
                <th class="pl-3">Kelas</th>
                <th class="text-right">Siswa</th>
                <th class="text-right">Beasiswa</th>
                <th class="text-right">Target/bln</th>
                <?php foreach ($namaBulan as $b) { ?><th class="text-right"><?= $b ?></th><?php } ?>
                <th class="text-right pr-3">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($report['kelas'] as $k) { ?>
                <tr>
                  <td class="pl-3 font-weight-bold"><?= esc($k['nama']) ?></td>
                  <td class="text-right"><?= $k['siswa'] ?></td>
                  <td class="text-right"><?= $k['beasiswa'] ?></td>
                  <td class="text-right"><?= $rp($k['target']) ?></td>
                  <?php foreach ($k['bulan'] as $i => $v) echo $sel($v, $i, $v < $k['target']); ?>
                  <td class="text-right pr-3 font-weight-bold"><?= $rp($k['total']) ?></td>
                </tr>
              <?php } ?>
              <tr class="rs-ringkas">
                <td class="pl-3" colspan="4">Total pemasukan</td>
                <?php foreach ($report['masuk'] as $i => $v) echo $sel($v, $i); ?>
                <td class="text-right pr-3"><?= $rp($report['totalMasuk']) ?></td>
              </tr>
              <tr class="rs-ringkas">
                <td class="pl-3" colspan="4">Pengeluaran</td>
                <?php foreach ($report['keluar'] as $i => $v) echo $sel($v, $i); ?>
                <td class="text-right pr-3"><?= $rp($report['totalKeluar']) ?></td>
              </tr>
              <tr class="rs-ringkas-akhir">
                <td class="pl-3" colspan="4">Selisih</td>
                <?php foreach ($selisih as $i => $v) echo $sel($v, $i, $v < 0); ?>
                <td class="text-right pr-3"><?= $rp($report['totalMasuk'] - $report['totalKeluar']) ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer rs-muted small">Sel oranye: pemasukan bulan itu di bawah target kelas (tarif × siswa, dikurangi potongan beasiswa).</div>
      </div>

      <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center">
          <h3 class="card-title mr-auto">Pembayaran per siswa</h3>
          <div class="btn-group btn-group-sm flex-wrap" role="group" aria-label="Filter kelas">
            <button type="button" class="btn btn-primary rs-filter" data-kelas="">Semua</button>
            <?php foreach ($kelasList as $kl) { ?>
              <button type="button" class="btn btn-outline-primary rs-filter" data-kelas="<?= esc($kl) ?>"><?= esc($kl) ?></button>
            <?php } ?>
          </div>
        </div>
        <div class="card-body">
          <table id="tabelSiswa" class="table table-sm rs-table" style="width:100%">
            <thead>
              <tr>
                <th>Nama siswa</th>
                <th>Kelas</th>
                <?php foreach ($namaBulan as $b) { ?><th class="text-right"><?= $b ?></th><?php } ?>
                <th class="text-right">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($report['siswa'] as $s) { ?>
                <tr>
                  <td><?= esc($s['nama_siswa']) ?></td>
                  <td><?= esc($s['nama_kelas']) ?></td>
                  <?php foreach ($s['bulan'] as $i => $v) echo $sel($v, $i, $v == 0); ?>
                  <td class="text-right font-weight-bold"><?= $rp($s['total']) ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <div class="rs-muted small mt-2">Sel oranye: belum ada pembayaran di bulan yang sudah berjalan.</div>
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
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>
<script>
  $(function() {
    var tabel = $('#tabelSiswa').DataTable({
      pageLength: 50,
      autoWidth: false,
      scrollX: true,
      order: [[1, 'asc'], [0, 'asc']],
      buttons: [{ extend: 'excelHtml5', text: 'Export Excel', title: 'Report SPP <?= $tahunAjaran ?>-<?= $tahunAjaran + 1 ?>' }],
      language: { search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ baris', info: '_START_–_END_ dari _TOTAL_ siswa', paginate: { previous: '‹', next: '›' } }
    });
    tabel.buttons().container().appendTo('#tabelSiswa_wrapper .col-md-6:eq(0)');
    // Filter kelas: cocokkan persis pada kolom Kelas
    $('.rs-filter').on('click', function() {
      var kelas = $(this).data('kelas');
      $('.rs-filter').removeClass('btn-primary').addClass('btn-outline-primary');
      $(this).removeClass('btn-outline-primary').addClass('btn-primary');
      tabel.column(1).search(kelas ? '^' + $.fn.dataTable.util.escapeRegex(String(kelas)) + '$' : '', true, false).draw();
    });
  });
</script>
<?= $this->endSection() ?>
