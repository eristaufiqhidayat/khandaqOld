<?= $this->extend('Views\layout.php') ?>
<?php
/** @var array $dataPeriode */
/** @var array $dataKelas */
/** @var array $petaTarif */
/** @var string|null $id_periode */
/** @var string|null $sumber */
/** @var array $kelasGanda */
/** @var string $menuAktip */
/** @var string $moduleAktip */
?>
<?= $this->section('css') ?>
<style>
  .ts-muted { color: #5a6472; }
  .ts-kpi { font-size: 1.8rem; font-weight: 700; line-height: 1.2; }
  .ts-table { font-variant-numeric: tabular-nums; }
  .ts-table th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; color: #5a6472; }
  .ts-table td, .ts-table th { vertical-align: middle; white-space: nowrap; }
  .ts-table tr.ts-ubah td { background: #fdf6e8; }
  .ts-input { width: 160px; text-align: right; }
  .ts-belum { color: #8a4600; font-weight: 700; }
  .ts-diubah { color: #b35c00; font-weight: 700; }
  .ts-ok { color: #1d5b32; font-weight: 600; }
  .ts-naik { color: #1f5fbf; font-weight: 600; }
  .ts-turun { color: #b35c00; font-weight: 600; }
</style>
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?php
$url = function ($aksi) use ($menuAktip, $moduleAktip) {
  return base_url('index.php/TataUsaha/TarifSpp/' . $aksi . '/' . $menuAktip . '/' . $moduleAktip);
};
$labelOf = [];
foreach ($dataPeriode as $p) $labelOf[$p['id_periode']] = labelPeriode($p) . ($p['status_aktif'] === 'yes' ? ' · aktif' : '');
$tarifIni = $petaTarif[$id_periode] ?? [];
$tarifSumber = $sumber !== null ? ($petaTarif[$sumber] ?? []) : [];
$terisi = count(array_intersect_key($tarifIni, array_column($dataKelas, 'nama_kelas', 'id_kelas')));
$rp = function ($n) { return $n === null || $n === '' ? '' : number_format((int) $n, 0, ',', '.'); };
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex flex-wrap align-items-end justify-content-between" style="gap:12px">
      <div>
        <h1 class="m-0">Tarif SPP</h1>
        <div class="ts-muted">Tarif per kelas per periode · satu tarif untuk satu kelas di satu periode</div>
      </div>
      <?php if ($dataPeriode) { ?>
        <form method="get" action="<?= $url('index') ?>" class="form-inline" style="gap:8px">
          <label for="periode" class="font-weight-bold mr-2">Periode</label>
          <select id="periode" name="periode" class="form-control" onchange="this.form.submit()">
            <?php foreach ($dataPeriode as $p) { ?>
              <option value="<?= esc($p['id_periode']) ?>" <?= $p['id_periode'] == $id_periode ? 'selected' : '' ?>><?= esc($labelOf[$p['id_periode']]) ?></option>
            <?php } ?>
          </select>
          <noscript><button class="btn btn-outline-primary">Tampilkan</button></noscript>
        </form>
      <?php } ?>
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
      <div class="alert alert-success" role="status" id="pesanSalin" style="display:none"></div>

      <?php if (!$dataPeriode || !$dataKelas) { ?>
        <div class="alert alert-warning">Belum ada <?= !$dataPeriode ? 'periode' : 'kelas' ?>. Tambahkan dulu di menu <?= !$dataPeriode ? 'Periode' : 'Kelas' ?>.</div>
      <?php } else { ?>
        <?php if ($kelasGanda) { ?>
          <div class="alert alert-warning">Ada <?= count($kelasGanda) ?> kelas dengan tarif ganda di periode ini. Klik Simpan supaya hanya tersisa satu tarif per kelas (nilai yang tampil di bawah).</div>
        <?php } ?>

        <div class="row">
          <div class="col-md-6">
            <div class="card"><div class="card-body">
              <div class="ts-muted font-weight-bold">Kelas sudah ada tarif</div>
              <div class="ts-kpi"><?= $terisi ?> dari <?= count($dataKelas) ?> kelas</div>
            </div></div>
          </div>
          <div class="col-md-6">
            <div class="card"><div class="card-body">
              <div class="ts-muted font-weight-bold">Perubahan belum disimpan</div>
              <div class="ts-kpi ts-diubah" id="kpiUbah">Tidak ada</div>
            </div></div>
          </div>
        </div>

        <div class="card">
          <div class="card-body d-flex flex-wrap align-items-center" style="gap:12px">
            <div class="mr-auto">
              <div class="font-weight-bold" style="font-size:1.05rem">Salin tarif dari periode lain</div>
              <div class="ts-muted small">Tarif sumber disalin ke form di bawah, belum disimpan. Ubah yang perlu, lalu klik Simpan.</div>
            </div>
            <label for="sumber" class="mb-0">Dari</label>
            <select id="sumber" class="form-control" style="width:auto">
              <?php foreach ($dataPeriode as $p) if ($p['id_periode'] != $id_periode) { ?>
                <option value="<?= esc($p['id_periode']) ?>" <?= $p['id_periode'] == $sumber ? 'selected' : '' ?>><?= esc($labelOf[$p['id_periode']]) ?><?= $p['jml_tarif'] ? '' : ' (belum ada tarif)' ?></option>
              <?php } ?>
            </select>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="timpa">
              <label class="custom-control-label" for="timpa">Timpa yang sudah ada</label>
            </div>
            <button type="button" class="btn btn-outline-primary" id="btnSalin">Salin ke form</button>
          </div>
        </div>

        <form class="card" method="post" action="<?= $url('simpan') ?>" id="formTarif">
          <input type="hidden" name="id_periode" value="<?= esc($id_periode) ?>">
          <div class="card-header"><h3 class="card-title font-weight-bold">Tarif <?= esc(labelPeriode(array_column($dataPeriode, null, 'id_periode')[$id_periode] ?? null)) ?></h3></div>
          <div class="card-body p-0 table-responsive">
            <table class="table table-sm ts-table mb-0">
              <thead>
                <tr>
                  <th class="pl-3">Kelas</th>
                  <th class="text-right" id="judulSumber">Tarif sumber</th>
                  <th>Tarif periode ini (Rp/bulan)</th>
                  <th class="text-right">Selisih</th>
                  <th class="pr-3">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($dataKelas as $k) {
                  $awal = $tarifIni[$k['id_kelas']] ?? null;
                ?>
                  <tr data-kelas="<?= esc($k['id_kelas']) ?>">
                    <td class="pl-3 font-weight-bold"><?= esc($k['nama_kelas']) ?></td>
                    <td class="text-right ts-muted ts-sumber"><?= isset($tarifSumber[$k['id_kelas']]) ? $rp($tarifSumber[$k['id_kelas']]) : '–' ?></td>
                    <td>
                      <div class="input-group input-group-sm" style="width:200px">
                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                        <input type="text" inputmode="numeric" class="form-control ts-input" name="tarif[<?= esc($k['id_kelas']) ?>]"
                          value="<?= $rp($awal) ?>" data-awal="<?= $awal === null ? '' : (int) $awal ?>" placeholder="belum diisi"
                          aria-label="Tarif <?= esc($k['nama_kelas']) ?>">
                      </div>
                    </td>
                    <td class="text-right ts-selisih">–</td>
                    <td class="pr-3 ts-status"></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer d-flex flex-wrap align-items-center" style="gap:12px">
            <div class="ts-muted small mr-auto">Angka boleh diketik dengan titik (150.000). Kosongkan untuk menghapus tarif kelas itu.</div>
            <button type="button" class="btn btn-outline-secondary" id="btnBatal" disabled>Batalkan perubahan</button>
            <button class="btn btn-primary" id="btnSimpan" disabled>Simpan</button>
          </div>
        </form>
      <?php } ?>
    </div>
  </section>
</div>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>
<script>
  (function() {
    var peta = <?= json_encode((object) array_map(function ($t) { return (object) $t; }, $petaTarif)) ?>;
    var label = <?= json_encode((object) $labelOf) ?>;
    var dikirim = false;
    var angka = function(s) { s = String(s).replace(/[^0-9]/g, ''); return s === '' ? null : parseInt(s, 10); };
    var rp = function(n) { return n === null ? '' : n.toLocaleString('id-ID'); };
    var sumber = function() { return peta[$('#sumber').val()] || {}; };

    function hitung() {
      var src = sumber(), ubah = 0;
      $('#formTarif tbody tr').each(function() {
        var tr = $(this), id = tr.data('kelas'), inp = tr.find('.ts-input');
        var v = angka(inp.val()), awal = angka(inp.data('awal')), s = src[id];
        var beda = v !== awal;
        if (beda) ubah++;
        tr.toggleClass('ts-ubah', beda);
        tr.find('.ts-sumber').text(s === undefined ? '–' : rp(s));
        var sel = v !== null && s !== undefined ? v - s : null;
        tr.find('.ts-selisih').html(sel === null ? '<span class="ts-muted">–</span>'
          : '<span class="' + (sel > 0 ? 'ts-naik' : sel < 0 ? 'ts-turun' : 'ts-muted') + '">' + (sel > 0 ? '+' : sel < 0 ? '−' : '') + rp(Math.abs(sel)) + '</span>');
        tr.find('.ts-status').html(beda ? '<span class="ts-diubah">' + (v === null ? 'Akan dihapus' : 'Diubah, belum disimpan') + '</span>'
          : v === null ? '<span class="ts-belum">Belum diisi</span>' : '<span class="ts-ok">Tersimpan</span>');
      });
      $('#judulSumber').text('Tarif ' + (label[$('#sumber').val()] || 'sumber').replace(' · aktif', ''));
      $('#kpiUbah').text(ubah ? ubah + ' kelas' : 'Tidak ada');
      $('#btnSimpan').prop('disabled', !ubah).text(ubah ? 'Simpan ' + ubah + ' perubahan' : 'Simpan');
      $('#btnBatal').prop('disabled', !ubah);
      return ubah;
    }

    $('#formTarif').on('input', '.ts-input', hitung)
      .on('blur', '.ts-input', function() { $(this).val(rp(angka($(this).val()))); })
      .on('submit', function() { dikirim = true; $('#btnSimpan').prop('disabled', true).text('Menyimpan…'); });
    $('#sumber').on('change', function() { $('#pesanSalin').hide(); hitung(); });
    $('#btnSalin').on('click', function() {
      var src = sumber(), timpa = $('#timpa').prop('checked'), n = 0;
      $('#formTarif tbody tr').each(function() {
        var inp = $(this).find('.ts-input'), s = src[$(this).data('kelas')];
        if (s === undefined || (!timpa && angka(inp.val()) !== null)) return;
        inp.val(rp(s)); n++;
      });
      hitung();
      $('#pesanSalin').text(n ? n + ' tarif disalin dari ' + label[$('#sumber').val()].replace(' · aktif', '') + ' ke form. Periksa dan ubah bila perlu, lalu klik Simpan.'
        : 'Tidak ada tarif yang disalin. Periode sumber belum punya tarif, atau semua kelas sudah terisi (centang "Timpa yang sudah ada" untuk menimpa).').show();
    });
    $('#btnBatal').on('click', function() {
      $('#formTarif .ts-input').each(function() { $(this).val(rp(angka($(this).data('awal')))); });
      $('#pesanSalin').hide();
      hitung();
    });
    window.addEventListener('beforeunload', function(e) {
      if (!dikirim && hitung()) { e.preventDefault(); e.returnValue = ''; }
    });
    hitung();
  })();
</script>
<?= $this->endSection() ?>
