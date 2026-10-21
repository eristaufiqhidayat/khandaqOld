<?= $this->extend('Views\layout.php') ?>
<?= $this->section('css') ?>
<style>
  .spp-kpi { font-size: 2rem; font-weight: 700; line-height: 1.2; }
  .spp-muted { color: #5a6472; }
  .spp-bar { display: flex; height: 22px; border-radius: 4px; overflow: hidden; background: #eef1f5; }
  .spp-bar > div { height: 100%; }
  .spp-lunas { background: #1f5fbf; }
  .spp-kurang { background: #f0a030; }
  .spp-beasiswa { background: #c9d1dc; }
  .spp-swatch { display: inline-block; width: 12px; height: 12px; border-radius: 3px; margin-right: 4px; vertical-align: middle; }
  .spp-progress { height: 8px; background: #eef1f5; border-radius: 4px; overflow: hidden; flex: 1; }
  .spp-progress > div { height: 100%; background: #1f5fbf; }
  .spp-text-kurang { color: #b35c00; }
  .spp-badge { padding: 3px 10px; border-radius: 999px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; }
  .spp-badge-lunas { background: #e3ecfa; color: #174a94; }
  .spp-badge-kurang { background: #fdf0dc; color: #8a4600; }
  .spp-badge-beasiswaPenuh { background: #e4e8ee; color: #3a4350; }
  .spp-table td, .spp-table th { vertical-align: middle; }
  .spp-row-aktif { background: #eef4fd !important; }
</style>
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?php
$rp = function ($n) {
  return 'Rp ' . number_format($n, 0, ',', '.');
};
$persenLunas = $total['siswa'] ? round(($total['siswa'] - $total['kurang']) * 100 / $total['siswa']) : 0;
$labelStatus = ['lunas' => 'Lunas', 'kurang' => 'Kurang bayar', 'beasiswaPenuh' => 'Beasiswa 100%'];
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Rekap SPP per Kelas</h1>
      <div class="spp-muted">Tahun ajaran <?= esc($tahunAjaran) ?> · tagihan dihitung <?= $bulan ?> bulan</div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="card"><div class="card-body">
            <div class="spp-muted font-weight-bold">Siswa aktif</div>
            <div class="spp-kpi"><?= $total['siswa'] ?></div>
            <div class="spp-muted"><?= count($kelas) ?> kelas</div>
          </div></div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="card"><div class="card-body">
            <div class="spp-muted font-weight-bold">Sudah lunas</div>
            <div class="spp-kpi" style="color:#1f5fbf"><?= $total['lunas'] ?></div>
            <div class="spp-muted"><?= $persenLunas ?>% tidak menunggak</div>
          </div></div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="card"><div class="card-body">
            <div class="spp-muted font-weight-bold">Kurang bayar</div>
            <div class="spp-kpi spp-text-kurang"><?= $total['kurang'] ?></div>
            <div class="spp-muted"><?= $total['beasiswa'] ?> siswa penerima beasiswa</div>
          </div></div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="card"><div class="card-body">
            <div class="spp-muted font-weight-bold">Total tunggakan</div>
            <div class="spp-kpi spp-text-kurang"><?= $rp($total['tunggakan']) ?></div>
            <div class="spp-muted">jumlah selisih yang belum dibayar</div>
          </div></div>
        </div>
      </div>

      <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center">
          <h3 class="card-title mr-auto">Status pembayaran per kelas</h3>
          <div class="spp-muted small">
            <span class="mr-3"><span class="spp-swatch spp-lunas"></span>Lunas</span>
            <span class="mr-3"><span class="spp-swatch spp-kurang"></span>Kurang bayar</span>
            <span><span class="spp-swatch spp-beasiswa"></span>Beasiswa penuh</span>
          </div>
        </div>
        <div class="card-body">
          <?php foreach ($kelas as $k) { ?>
            <div class="d-flex align-items-center mb-2">
              <div style="width:90px" class="font-weight-bold"><?= esc($k['nama']) ?></div>
              <div class="spp-bar flex-grow-1">
                <div class="spp-lunas" style="width:<?= $k['lunas'] * 100 / $k['siswa'] ?>%"></div>
                <div class="spp-kurang" style="width:<?= $k['kurang'] * 100 / $k['siswa'] ?>%"></div>
                <div class="spp-beasiswa" style="width:<?= $k['beasiswaPenuh'] * 100 / $k['siswa'] ?>%"></div>
              </div>
              <div style="width:140px" class="text-right spp-muted small"><?= $k['kurang'] ?> dari <?= $k['siswa'] ?> kurang</div>
            </div>
          <?php } ?>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Rincian per kelas</h3>
        </div>
        <div class="card-body p-0 table-responsive">
          <table class="table table-sm spp-table mb-0" style="min-width:720px">
            <thead>
              <tr>
                <th class="pl-3">Kelas</th>
                <th class="text-right">Siswa</th>
                <th class="text-right">Beasiswa</th>
                <th class="text-right">Kurang bayar</th>
                <th style="width:180px">Tidak menunggak</th>
                <th class="text-right">Tunggakan</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($kelas as $i => $k) {
                $persen = round(($k['siswa'] - $k['kurang']) * 100 / $k['siswa']); ?>
                <tr data-kelas-row="<?= $i ?>">
                  <td class="pl-3 font-weight-bold"><?= esc($k['nama']) ?></td>
                  <td class="text-right"><?= $k['siswa'] ?></td>
                  <td class="text-right"><?= $k['beasiswa'] ?></td>
                  <td class="text-right font-weight-bold spp-text-kurang"><?= $k['kurang'] ?></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="spp-progress mr-2"><div style="width:<?= $persen ?>%"></div></div>
                      <span class="small"><?= $persen ?>%</span>
                    </div>
                  </td>
                  <td class="text-right"><?= $rp($k['tunggakan']) ?></td>
                  <td class="text-right pr-3">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-kelas="<?= $i ?>">Lihat siswa</button>
                  </td>
                </tr>
              <?php } ?>
              <tr class="font-weight-bold" style="background:#f8f9fb">
                <td class="pl-3">Total</td>
                <td class="text-right"><?= $total['siswa'] ?></td>
                <td class="text-right"><?= $total['beasiswa'] ?></td>
                <td class="text-right spp-text-kurang"><?= $total['kurang'] ?></td>
                <td><?= $persenLunas ?>%</td>
                <td class="text-right"><?= $rp($total['tunggakan']) ?></td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <?php foreach ($kelas as $i => $k) { ?>
        <div class="card spp-detail" id="spp-detail-<?= $i ?>" style="display:none">
          <div class="card-header d-flex flex-wrap align-items-baseline">
            <h3 class="card-title mr-auto">Siswa kelas <?= esc($k['nama']) ?></h3>
            <span class="spp-muted small">diurutkan dari tunggakan terbesar</span>
          </div>
          <div class="card-body p-0 table-responsive">
            <table class="table table-sm spp-table mb-0" style="min-width:680px">
              <thead>
                <tr>
                  <th class="pl-3">Nama siswa</th>
                  <th>Status</th>
                  <th class="text-right">Tarif/bulan</th>
                  <th class="text-right">Harus bayar</th>
                  <th class="text-right">Sudah bayar</th>
                  <th class="text-right pr-3">Selisih</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($k['daftar'] as $s) { ?>
                  <tr>
                    <td class="pl-3"><?= esc($s['nama_siswa']) ?></td>
                    <td>
                      <span class="spp-badge spp-badge-<?= $s['status'] ?>"><?= $labelStatus[$s['status']] ?><?= ($s['beasiswa'] && $s['status'] !== 'beasiswaPenuh') ? ' · beasiswa ' . (0 + $s['persen']) . '%' : '' ?></span>
                    </td>
                    <td class="text-right"><?= $rp($s['tarif']) ?></td>
                    <td class="text-right"><?= $rp($s['harus']) ?></td>
                    <td class="text-right"><?= $rp($s['dibayar']) ?></td>
                    <td class="text-right pr-3 font-weight-bold <?= $s['selisih'] < 0 ? 'spp-text-kurang' : '' ?>"><?= ($s['selisih'] < 0 ? '−' : '') . $rp(abs($s['selisih'])) ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>
</div>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.min.js?v=3.2.0"></script>
<script>
  // Tampilkan daftar siswa kelas yang dipilih di bawah tabel rincian
  $('[data-kelas]').on('click', function() {
    var i = $(this).data('kelas');
    $('.spp-detail').hide();
    $('[data-kelas-row]').removeClass('spp-row-aktif');
    $('[data-kelas-row="' + i + '"]').addClass('spp-row-aktif');
    $('#spp-detail-' + i).show()[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
</script>
<?= $this->endSection() ?>
