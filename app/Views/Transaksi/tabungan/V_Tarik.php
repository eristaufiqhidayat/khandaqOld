<?php

use App\Controllers\Transaksi\C_DataTransaksiTabungan as T;

$mm = $menuAktip . '/' . $moduleAktip;
$rp = static function ($n) {
    return 'Rp ' . number_format((float) $n, 0, ',', '.');
};
$lama = static function ($k, $bawaan = '') {
    $v = old($k, null, false);
    return $v !== null ? (string) $v : (string) $bawaan;
};
// Penarikan tunai paling sering dipakai, jadi tampil paling atas dan terpilih
usort($kodeList, static function ($a, $b) {
    return ($b['kode'] === 'TDTNI') <=> ($a['kode'] === 'TDTNI');
});
$kodeAda  = array_column($kodeList, 'kode');
$kodeAwal = $lama('NKKodeTransaksi', in_array('TDTNI', $kodeAda, true) ? 'TDTNI' : ($kodeAda[0] ?? ''));
$totalSaku = array_sum(array_column($sakuBulanIni, 'rp'));
?>
<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<?= view('Transaksi/tabungan/_gaya') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="content-wrapper ds" style="--tb-aksen: #B45309; --tb-latar: #FFFBEB">
  <form method="post" action="<?= esc(base_url('index.php/transaksi/saveDebet/' . $mm), 'attr') ?>" enctype="multipart/form-data" id="formTarik" novalidate>
    <input type="hidden" name="id_siswa" value="<?= (int) $siswa['id_siswa'] ?>">
    <input type="hidden" name="kode_tab_trans" value="<?= esc($kode, 'attr') ?>">
    <input type="hidden" name="rp" id="rp" value="<?= esc(preg_replace('/\D/', '', $lama('rp')), 'attr') ?>">
    <div class="ds-wadah">

      <nav aria-label="Breadcrumb" class="ds-baris" style="gap: 8px; font-size: 13px; color: #475569">
        <a href="<?= esc(base_url('index.php/transaksi/indexTabungan/' . $mm), 'attr') ?>" style="text-decoration: none">Tabungan Siswa</a>
        <span aria-hidden="true">/</span>
        <a href="<?= esc(base_url('index.php/transaksi/indexTabungan/' . $mm . '?siswa=' . (int) $siswa['id_siswa']), 'attr') ?>" style="text-decoration: none"><?= esc($siswa['nama_siswa']) ?></a>
        <span aria-hidden="true">/</span>
        <span style="color: #0F172A; font-weight: 600">Tarik / bayar</span>
      </nav>

      <header class="ds-kepala">
        <div class="ds-judul">
          <h1 style="font-size: 26px">Tarik atau bayar dari tabungan</h1>
          <p class="ds-sub"><?= esc($siswa['nama_siswa']) ?> · <?= esc($siswa['nama_kelas'] ?: 'Belum ada kelas') ?> · Kode tabungan <?= esc($kode) ?></p>
        </div>
        <div style="background: #0B2545; color: #FFFFFF; border-radius: 12px; padding: 12px 18px; display: flex; flex-direction: column; gap: 2px">
          <span style="font-size: 12px; color: #CBD5E1; font-weight: 600">Saldo tersedia</span>
          <span style="font-size: 22px; font-weight: 800"><?= ($saldo < 0 ? '− ' : '') . $rp(abs($saldo)) ?></span>
        </div>
      </header>

      <div class="ds-isi">
        <section class="ds-kartu ds-bagian ds-utama" aria-labelledby="h-form">
          <h2 id="h-form" style="font-size: 17px">Transaksi keluar</h2>
          <div class="ds-kolom" style="gap: 8px">
            <span class="ds-label" id="lbl-jenis">Untuk apa? <span class="ds-wajib">*</span></span>
            <div class="tb-pilih-jenis" role="radiogroup" aria-labelledby="lbl-jenis">
              <?php foreach ($kodeList as $k) : $kd = $k['kode']; ?>
                <input type="radio" name="NKKodeTransaksi" id="jenis-<?= esc($kd, 'attr') ?>" value="<?= esc($kd, 'attr') ?>" <?= $kodeAwal === $kd ? 'checked' : '' ?>>
                <label for="jenis-<?= esc($kd, 'attr') ?>">
                  <span class="ds-bulat" aria-hidden="true"></span>
                  <span style="display: flex; flex-direction: column; gap: 2px">
                    <strong style="font-size: 14px"><?= esc(T::NAMA_JENIS[$kd] ?? $k['keterangan_kode']) ?> <span class="ds-kecil" style="font-size: 11px; font-weight: 600"><?= esc($kd) ?></span></strong>
                    <span class="ds-kecil"><?= esc(T::KET_JENIS[$kd] ?? $k['keterangan_kode']) ?></span>
                  </span>
                </label>
              <?php endforeach ?>
            </div>
          </div>
          <div class="ds-grid2">
            <div class="ds-kolom">
              <label for="tanggal" class="ds-label">Tanggal <span class="ds-wajib">*</span></label>
              <input id="tanggal" name="tanggal" class="ds-isian" type="date" required value="<?= esc($lama('tanggal', date('Y-m-d')), 'attr') ?>">
            </div>
            <div class="ds-kolom">
              <label for="jumlah" class="ds-label">Jumlah <span class="ds-wajib">*</span></label>
              <div class="tb-rp-isian">
                <span aria-hidden="true">Rp</span>
                <input id="jumlah" class="ds-isian" type="text" inputmode="numeric" autocomplete="off" placeholder="0" value="<?= esc($lama('rp') !== '' ? number_format((int) preg_replace('/\D/', '', $lama('rp')), 0, ',', '.') : '', 'attr') ?>">
              </div>
              <div class="ds-baris" style="gap: 6px">
                <?php foreach ([50000, 100000, 150000, 200000] as $n) : ?>
                  <button type="button" class="ds-tombol ds-tombol-netral ds-tombol-kecil" style="border-radius: 999px" data-cepat="<?= $n ?>"><?= $rp($n) ?></button>
                <?php endforeach ?>
              </div>
            </div>
            <div class="ds-kolom">
              <label for="keterangan_trans" class="ds-label">Keterangan</label>
              <input id="keterangan_trans" name="keterangan_trans" class="ds-isian" type="text" maxlength="200" placeholder="Misalnya: uang saku minggu ke-4" value="<?= esc($lama('keterangan_trans'), 'attr') ?>">
            </div>
            <div class="ds-kolom">
              <label for="buktitransfer" class="ds-label">Bukti (opsional)</label>
              <input id="buktitransfer" name="buktitransfer" type="file" class="ds-isian" style="padding-top: 9px" accept="image/jpeg,image/png,image/webp">
            </div>
          </div>
        </section>

        <aside class="ds-samping">
          <section class="ds-kartu tb-ringkas" aria-labelledby="h-ringkas" aria-live="polite">
            <h2 id="h-ringkas" style="font-size: 16px">Ringkasan</h2>
            <div class="tb-brs"><span>Saldo sekarang</span><strong><?= ($saldo < 0 ? '− ' : '') . $rp(abs($saldo)) ?></strong></div>
            <div class="tb-brs tb-keluar"><span id="rsJenis">− Transaksi</span><span id="rsJumlah">Rp 0</span></div>
            <div class="tb-brs tb-garis" style="font-size: 15px"><span>Saldo setelahnya</span><strong id="rsSisa">—</strong></div>
            <p id="rsKurang" class="ds-pesan ds-pesan-salah" role="alert" style="margin: 0; display: none"></p>
          </section>
          <section class="ds-kartu tb-ringkas" aria-labelledby="h-saku" style="gap: 8px">
            <h3 id="h-saku" style="margin: 0; font-size: 14px; font-weight: 700">Penarikan tunai bulan ini</h3>
            <?php if (! $sakuBulanIni) : ?>
              <span class="ds-kecil">Belum ada.</span>
            <?php else : foreach ($sakuBulanIni as $s) : ?>
              <div class="tb-brs ds-kecil" style="font-size: 13px; color: #334155"><span><?= esc(date('d', strtotime($s['tanggal'])) . ' ' . ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'][(int) date('n', strtotime($s['tanggal']))]) ?></span><span><?= $rp($s['rp']) ?></span></div>
            <?php endforeach ?>
              <div class="tb-brs" style="border-top: 1px solid #E2E8F0; padding-top: 8px; font-size: 13px; font-weight: 700"><span>Total</span><span><?= $rp($totalSaku) ?></span></div>
            <?php endif ?>
          </section>
        </aside>
      </div>
    </div>

    <div class="ds-aksi">
      <div>
        <a class="ds-batal" href="<?= esc(base_url('index.php/transaksi/indexTabungan/' . $mm), 'attr') ?>">Batal</a>
        <button type="submit" class="ds-tombol" style="background: #B45309; color: #FFFFFF !important" id="tombolSimpan">Simpan</button>
      </div>
    </div>
  </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<?= view('Transaksi/tabungan/_skrip') ?>
<script>
  (function () {
    var form = document.getElementById('formTarik');
    var saldo = <?= json_encode((float) $saldo) ?>;
    var cekSaldo = <?= json_encode(T::CEK_SALDO) ?>;
    var nama = <?= json_encode(array_combine($kodeAda, array_map(static function ($k) { return T::NAMA_JENIS[$k['kode']] ?? $k['keterangan_kode']; }, $kodeList)) ?: new stdClass(), JSON_HEX_TAG) ?>;
    var jumlah = document.getElementById('jumlah'), rp = document.getElementById('rp');
    function rupiah(n) { return (n < 0 ? '− ' : '') + 'Rp ' + Math.abs(Math.round(n)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
    function hitung() {
      var angka = parseInt(jumlah.value.replace(/\D/g, ''), 10) || 0;
      rp.value = angka ? String(angka) : '';
      jumlah.value = angka ? angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
      var r = form.querySelector('input[name="NKKodeTransaksi"]:checked'), j = r ? r.value : '';
      var sisa = saldo - angka, blokir = sisa < 0 && cekSaldo.indexOf(j) >= 0;
      document.getElementById('rsJenis').textContent = '− ' + (nama[j] || 'Transaksi');
      document.getElementById('rsJumlah').textContent = rupiah(angka);
      var el = document.getElementById('rsSisa');
      el.textContent = rupiah(sisa); el.style.color = sisa < 0 ? '#B42318' : '#0F172A';
      var k = document.getElementById('rsKurang');
      k.style.display = sisa < 0 ? '' : 'none';
      k.textContent = blokir ? 'Saldo tidak cukup. Maksimal yang bisa diambil ' + rupiah(Math.max(saldo, 0)) + '.' : (sisa < 0 ? 'Perhatian: saldo akan menjadi minus.' : '');
      var t = document.getElementById('tombolSimpan');
      t.textContent = angka ? 'Simpan ' + rupiah(angka) : 'Simpan';
      t.style.background = blokir ? '#94A3B8' : '#B45309';
      return { angka: angka, j: j, blokir: blokir };
    }
    document.querySelectorAll('[data-cepat]').forEach(function (b) {
      b.addEventListener('click', function () { jumlah.value = b.getAttribute('data-cepat'); hitung(); });
    });
    form.addEventListener('input', hitung);
    form.addEventListener('change', hitung);
    form.addEventListener('submit', function (e) {
      var h = hitung(), masalah = [];
      if (!form.elements.tanggal.value) masalah.push('tanggal');
      if (!h.j) masalah.push('jenis transaksi');
      if (!h.angka) masalah.push('jumlah');
      if (masalah.length) { e.preventDefault(); alert('Lengkapi dulu: ' + masalah.join(', ') + '.'); return; }
      if (h.blokir) { e.preventDefault(); alert('Saldo tidak cukup untuk transaksi ini.'); return; }
      if (!confirm('Simpan ' + (nama[h.j] || h.j) + ' ' + rupiah(h.angka) + ' untuk <?= esc($siswa['nama_siswa'], 'js') ?>?')) e.preventDefault();
    });
    hitung();
  })();
</script>
<?= $this->endSection() ?>
