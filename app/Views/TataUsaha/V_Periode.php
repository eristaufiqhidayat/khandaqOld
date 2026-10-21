<?= $this->extend('Views\layout.php') ?>
<?php
/** @var array $dataperiode */
/** @var int $jmlSiswaAktif */
/** @var int $tahunSekarang */
/** @var string $menuAktip */
/** @var string $moduleAktip */
?>
<?= $this->section('css') ?>
<style>
  .pr-muted { color: #5a6472; }
  .pr-kpi { font-size: 1.8rem; font-weight: 700; color: #1f5fbf; line-height: 1.2; }
  .pr-table { font-variant-numeric: tabular-nums; }
  .pr-table th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; color: #5a6472; }
  .pr-table td, .pr-table th { vertical-align: middle; white-space: nowrap; }
  .pr-table tr.pr-aktif td { background: #eef3fb; }
  .pr-kurang { color: #8a4600; font-weight: 700; }
</style>
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?php
$url = function ($aksi) use ($menuAktip, $moduleAktip) {
  return base_url('index.php/TataUsaha/Periode/' . $aksi . '/' . $menuAktip . '/' . $moduleAktip);
};
$label = function ($p) {
  return $p['tahun_ajaran'] . ' ' . $p['nama_semester'];
};
$aktif = null;
// Sama dengan query lain: kalau aktif lebih dari satu, yang dipakai id_periode terbesar
foreach ($dataperiode as $p) if ($p['status_aktif'] === 'yes' && (!$aktif || $p['id_periode'] > $aktif['id_periode'])) $aktif = $p;
$jmlAktif = count(array_filter($dataperiode, function ($p) { return $p['status_aktif'] === 'yes'; }));
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Periode Akademik</h1>
      <div class="pr-muted">Tahun ajaran dan semester · hanya satu periode yang bisa aktif</div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('success')) { ?>
        <div class="alert alert-success" role="status"><?= esc(session()->getFlashdata('success')) ?></div>
      <?php } ?>
      <?php if (session()->getFlashdata('error')) { ?>
        <div class="alert alert-danger" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
      <?php } ?>
      <?php if ($jmlAktif > 1) { ?>
        <div class="alert alert-warning">Saat ini ada <?= $jmlAktif ?> periode berstatus aktif. Klik "Jadikan aktif" pada periode yang benar supaya yang lain otomatis dinonaktifkan.</div>
      <?php } ?>

      <div class="row">
        <div class="col-lg-6">
          <div class="card"><div class="card-body">
            <div class="pr-muted font-weight-bold">Periode aktif</div>
            <div class="pr-kpi"><?= $aktif ? esc($label($aktif)) : 'Belum ada' ?></div>
            <div class="pr-muted small">
              <?= $aktif ? 'Dipakai untuk tarif SPP, riwayat kelas, jadwal, dan nilai. Ruang: ' . $aktif['ruang'] . ' dari ' . $jmlSiswaAktif . ' siswa aktif.'
                : 'Aktifkan satu periode supaya menu lain bisa berjalan.' ?>
            </div>
          </div></div>
        </div>
        <div class="col-lg-6">
          <div class="card"><div class="card-body">
            <div class="pr-muted font-weight-bold mb-1">Urutan pergantian tahun ajaran</div>
            <ol class="mb-0 pl-3">
              <li>Tambah periode baru (mis. <?= $tahunSekarang + 1 ?>/<?= $tahunSekarang + 2 ?> Ganjil)</li>
              <li>Isi tarif SPP untuk periode itu</li>
              <li>Jadikan aktif</li>
              <li>Proses ruang: salin kelas siswa ke periode baru</li>
              <li>Naik kelas di menu Kelas</li>
            </ol>
          </div></div>
        </div>
      </div>

      <div class="card">
        <div class="card-header"><h3 class="card-title font-weight-bold">Tambah periode</h3></div>
        <div class="card-body">
          <form class="form-inline" action="<?= $url('insert') ?>" method="post" style="gap:12px">
            <label for="tahun" class="mr-2">Tahun ajaran</label>
            <select id="tahun" name="tahun" class="form-control mr-3">
              <?php for ($t = $tahunSekarang - 1; $t <= $tahunSekarang + 1; $t++) { ?>
                <option value="<?= $t ?>" <?= $t === $tahunSekarang + 1 ? 'selected' : '' ?>><?= $t ?>/<?= $t + 1 ?></option>
              <?php } ?>
            </select>
            <label for="nama_semester" class="mr-2">Semester</label>
            <select id="nama_semester" name="nama_semester" class="form-control mr-3">
              <option value="Ganjil">Ganjil</option>
              <option value="Genap">Genap</option>
            </select>
            <button class="btn btn-primary">Tambah</button>
          </form>
          <div class="pr-muted small mt-2">Periode yang sama tidak bisa dibuat dua kali. Periode baru dibuat dalam keadaan tidak aktif.</div>
        </div>
      </div>

      <div class="card">
        <div class="card-header"><h3 class="card-title font-weight-bold">Daftar periode</h3></div>
        <div class="card-body p-0 table-responsive">
          <table class="table table-sm pr-table mb-0">
            <thead>
              <tr>
                <th class="pl-3">Tahun ajaran</th>
                <th>Semester</th>
                <th>Status</th>
                <th class="text-right">Tarif kelas</th>
                <th class="text-right">Ruang siswa</th>
                <th class="text-right">Jadwal</th>
                <th class="text-right">Nilai</th>
                <th class="text-right pr-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataperiode as $p) {
                $isAktif = $p['status_aktif'] === 'yes';
                $adaData = $p['tarif'] + $p['ruang'] + $p['jadwal'] + $p['nilai'] + $p['siswa'] > 0;
                $kurangRuang = $isAktif && $p['ruang'] < $jmlSiswaAktif;
                $judulHapus = $isAktif ? 'Periode aktif tidak bisa dihapus' : ($adaData ? 'Masih ada data tarif, ruang, jadwal, nilai, atau siswa' : 'Hapus periode');
              ?>
                <tr class="<?= $isAktif ? 'pr-aktif' : '' ?>">
                  <td class="pl-3 font-weight-bold"><?= esc($p['tahun_ajaran']) ?></td>
                  <td><?= esc($p['nama_semester']) ?></td>
                  <td><?= $isAktif ? '<span class="badge badge-primary">Aktif</span>' : '<span class="badge badge-light">Tidak aktif</span>' ?></td>
                  <td class="text-right"><?= $p['tarif'] ? $p['tarif'] . ' kelas' : '<span class="pr-kurang">belum diisi</span>' ?></td>
                  <td class="text-right"><?= $kurangRuang ? '<span class="pr-kurang">' . $p['ruang'] . ' / ' . $jmlSiswaAktif . '</span>' : $p['ruang'] ?></td>
                  <td class="text-right"><?= $p['jadwal'] ?></td>
                  <td class="text-right"><?= $p['nilai'] ?></td>
                  <td class="text-right pr-3">
                    <?php if (!$isAktif || $jmlAktif > 1) { ?>
                      <button type="button" class="btn btn-primary btn-sm btn-aktifkan" data-id="<?= esc($p['id_periode']) ?>"
                        data-label="<?= esc($label($p)) ?>" data-tarif="<?= (int) $p['tarif'] ?>">Jadikan aktif</button>
                    <?php } ?>
                    <form class="d-inline" action="<?= $url('prosesRuang') ?>" method="post"
                      onsubmit="return confirm('Salin kelas siswa yang belum tercatat ke <?= esc($label($p), 'js') ?>?')">
                      <input type="hidden" name="id_periode" value="<?= esc($p['id_periode']) ?>">
                      <button class="btn btn-outline-secondary btn-sm" <?= $kurangRuang ? '' : 'disabled' ?>
                        title="<?= !$isAktif ? 'Hanya untuk periode aktif' : ($kurangRuang ? 'Salin kelas siswa yang belum tercatat' : 'Semua siswa sudah tercatat') ?>">Proses ruang</button>
                    </form>
                    <form class="d-inline" action="<?= $url('delete') ?>" method="post"
                      onsubmit="return confirm('Hapus periode <?= esc($label($p), 'js') ?>?')">
                      <input type="hidden" name="id_periode" value="<?= esc($p['id_periode']) ?>">
                      <button class="btn btn-outline-danger btn-sm" <?= $isAktif || $adaData ? 'disabled' : '' ?> title="<?= $judulHapus ?>">Hapus</button>
                    </form>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer pr-muted small">Tulisan oranye: tarif SPP belum diisi untuk periode itu, atau ruang belum lengkap. Periode yang aktif atau masih punya data terkait tidak bisa dihapus.</div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade" id="modalAktifkan" tabindex="-1" role="dialog" aria-labelledby="judulAktifkan" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" action="<?= $url('aktifkan') ?>" method="post">
      <input type="hidden" name="id_periode" id="aktifkanId">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="judulAktifkan"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p><?= $aktif ? esc($label($aktif)) . ' akan otomatis dinonaktifkan. ' : '' ?>Tarif SPP, Naik Kelas, jadwal, dan nilai akan memakai periode ini.</p>
        <div class="alert alert-warning mb-0" id="peringatanTarif" style="display:none">Tarif SPP untuk periode ini belum diisi. Pembayaran SPP akan dihitung 0 sampai tarifnya diisi.</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary">Ya, jadikan aktif</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>
<script>
  $('.btn-aktifkan').on('click', function() {
    var b = $(this);
    $('#aktifkanId').val(b.data('id'));
    $('#judulAktifkan').text('Jadikan ' + b.data('label') + ' periode aktif?');
    $('#peringatanTarif').toggle(Number(b.data('tarif')) === 0);
    $('#modalAktifkan').modal('show');
  });
</script>
<?= $this->endSection() ?>
