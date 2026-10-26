<?php

use App\Controllers\Transaksi\C_DataTransaksiTabungan as T;

$mm = $menuAktip . '/' . $moduleAktip;
$lama = static function ($k, $bawaan = '') {
    $v = old($k, null, false);
    return $v !== null ? (string) $v : (string) $bawaan;
};
$masuk = $trx['kode_tran'] !== 'D';
$kodeSekarang = $lama('kodetransaksi', $trx['kodetransaksi']);
$adaDiDaftar = in_array($trx['kodetransaksi'], array_column($kodeList, 'kode'), true);
?>
<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<?= view('Transaksi/tabungan/_gaya') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="content-wrapper ds">
  <form method="post" action="<?= esc(base_url('index.php/transaksi/edit/' . $mm), 'attr') ?>" id="formUbah" novalidate>
    <input type="hidden" name="notransaksi" value="<?= (int) $trx['notransaksi'] ?>">
    <input type="hidden" name="kembali" value="tabungan">
    <div class="ds-wadah" style="max-width: 760px">

      <nav aria-label="Breadcrumb" class="ds-baris" style="gap: 8px; font-size: 13px; color: #475569">
        <a href="<?= esc(base_url('index.php/transaksi/indexTabungan/' . $mm), 'attr') ?>" style="text-decoration: none">Tabungan Siswa</a>
        <span aria-hidden="true">/</span>
        <a href="<?= esc(base_url('index.php/transaksi/indexTabungan/' . $mm . '?siswa=' . (int) $siswa['id_siswa']), 'attr') ?>" style="text-decoration: none"><?= esc($siswa['nama_siswa']) ?></a>
        <span aria-hidden="true">/</span>
        <span style="color: #0F172A; font-weight: 600">Ubah transaksi #<?= (int) $trx['notransaksi'] ?></span>
      </nav>

      <header class="ds-judul">
        <h1 style="font-size: 26px">Ubah transaksi #<?= (int) $trx['notransaksi'] ?></h1>
        <p class="ds-sub"><?= esc($siswa['nama_siswa']) ?> · <?= $masuk ? 'Transaksi masuk (setoran)' : 'Transaksi keluar' ?> · Kode tabungan <?= esc($trx['kode_tab_trans']) ?></p>
      </header>

      <?php if ($trx['kodetransaksi'] === 'TKSPP' || in_array($trx['kodetransaksi'], ['TDSPP', 'TDLDR', 'TDKES', 'TDINF'], true)) : ?>
        <div class="ds-pesan" style="background: #FFFBEB; border: 1px solid #FCD34D; color: #78350F">
          Transaksi ini bagian dari setoran SPP (setoran, potongan SPP/laundry/kesehatan, dan infak dicatat terpisah). Mengubah satu transaksi tidak ikut mengubah yang lain.
        </div>
      <?php endif ?>

      <section class="ds-kartu ds-bagian" aria-label="Isi transaksi">
        <div class="ds-grid2">
          <div class="ds-kolom">
            <label for="tanggal" class="ds-label">Tanggal <span class="ds-wajib">*</span></label>
            <input id="tanggal" name="tanggal" class="ds-isian" type="date" required value="<?= esc($lama('tanggal', $trx['tgl']), 'attr') ?>">
          </div>
          <div class="ds-kolom">
            <label for="jumlah" class="ds-label">Jumlah <span class="ds-wajib">*</span></label>
            <div class="tb-rp-isian">
              <span aria-hidden="true">Rp</span>
              <input id="jumlah" class="ds-isian" type="text" inputmode="numeric" autocomplete="off" value="<?= esc(number_format((int) preg_replace('/\D/', '', $lama('rp', (string) (int) $trx['rp'])), 0, ',', '.'), 'attr') ?>">
            </div>
            <input type="hidden" name="rp" id="rp" value="<?= esc((string) (int) preg_replace('/\D/', '', $lama('rp', (string) (int) $trx['rp'])), 'attr') ?>">
          </div>
          <div class="ds-kolom ds-penuh">
            <label for="kodetransaksi" class="ds-label">Jenis <span class="ds-wajib">*</span></label>
            <select id="kodetransaksi" name="kodetransaksi" class="ds-isian">
              <?php if (! $adaDiDaftar) : ?>
                <option value="<?= esc($trx['kodetransaksi'], 'attr') ?>" selected disabled><?= esc($trx['kodetransaksi']) ?> (tidak bisa dipilih untuk akun ini)</option>
              <?php endif ?>
              <?php foreach ($kodeList as $k) : $kd = $k['kode']; ?>
                <option value="<?= esc($kd, 'attr') ?>" <?= $kodeSekarang === $kd ? 'selected' : '' ?>><?= esc((T::NAMA_JENIS[$kd] ?? $k['keterangan_kode']) . ' · ' . $kd) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="ds-kolom ds-penuh">
            <label for="keterangan_trans" class="ds-label">Keterangan</label>
            <input id="keterangan_trans" name="keterangan_trans" class="ds-isian" type="text" maxlength="200" value="<?= esc($lama('keterangan_trans', $trx['keterangan_trans']), 'attr') ?>">
          </div>
        </div>
      </section>
    </div>

    <div class="ds-aksi">
      <div style="max-width: 760px">
        <a class="ds-batal" href="<?= esc(base_url('index.php/transaksi/indexTabungan/' . $mm . '?siswa=' . (int) $siswa['id_siswa']), 'attr') ?>">Batal</a>
        <button type="submit" class="ds-tombol ds-tombol-utama">Simpan perubahan</button>
      </div>
    </div>
  </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<?= view('Transaksi/tabungan/_skrip') ?>
<script>
  (function () {
    var jumlah = document.getElementById('jumlah'), rp = document.getElementById('rp');
    jumlah.addEventListener('input', function () {
      var angka = parseInt(jumlah.value.replace(/\D/g, ''), 10) || 0;
      rp.value = angka ? String(angka) : '';
      jumlah.value = angka ? angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
    });
  })();
</script>
<?= $this->endSection() ?>
