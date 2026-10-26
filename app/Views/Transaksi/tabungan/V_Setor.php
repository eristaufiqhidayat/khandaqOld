<?php

use App\Controllers\Transaksi\C_DataTransaksiTabungan as T;

$mm      = $menuAktip . '/' . $moduleAktip;
$singkat = ['Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
$rp      = static function ($n) {
    return 'Rp ' . number_format((float) $n, 0, ',', '.');
};
$lama = static function ($k, $bawaan = '') {
    $v = old($k, null, false);
    return $v !== null ? (string) $v : (string) $bawaan;
};
$kodeAda   = array_column($kodeList, 'kode');
$kodeAwal  = $lama('NKKodeTransaksi'); // sengaja tidak ada pilihan bawaan: petugas memilih sendiri
?>
<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<?= view('Transaksi/tabungan/_gaya') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="content-wrapper ds">
  <form method="post" action="<?= esc(base_url('index.php/transaksi/saveKredit/' . $mm), 'attr') ?>" enctype="multipart/form-data" id="formSetor" novalidate>
    <input type="hidden" name="id_siswa" value="<?= (int) $siswa['id_siswa'] ?>">
    <input type="hidden" name="kode_tab_trans" value="<?= esc($kode, 'attr') ?>">
    <input type="hidden" name="rp" id="rp" value="<?= esc(preg_replace('/\D/', '', $lama('rp')), 'attr') ?>">
    <div class="ds-wadah">

      <nav aria-label="Breadcrumb" class="ds-baris" style="gap: 8px; font-size: 13px; color: #475569">
        <a href="<?= esc(base_url('index.php/transaksi/indexTabungan/' . $mm), 'attr') ?>" style="text-decoration: none">Tabungan Siswa</a>
        <span aria-hidden="true">/</span>
        <a href="<?= esc(base_url('index.php/transaksi/indexTabungan/' . $mm . '?siswa=' . (int) $siswa['id_siswa']), 'attr') ?>" style="text-decoration: none"><?= esc($siswa['nama_siswa']) ?></a>
        <span aria-hidden="true">/</span>
        <span style="color: #0F172A; font-weight: 600">Setor</span>
      </nav>

      <header class="ds-judul">
        <h1 style="font-size: 26px">Setor ke tabungan</h1>
        <p class="ds-sub"><?= esc($siswa['nama_siswa']) ?> · <?= esc($siswa['nama_kelas'] ?: 'Belum ada kelas') ?> · Kode tabungan <?= esc($kode) ?> · Saldo sekarang <strong style="color: #0F172A"><?= ($saldo < 0 ? '− ' : '') . $rp(abs($saldo)) ?></strong></p>
      </header>

      <div class="ds-isi">
        <div class="ds-utama">
          <section class="ds-kartu ds-bagian" aria-labelledby="h-setoran">
            <h2 id="h-setoran" style="font-size: 17px">Setoran</h2>
            <div class="ds-grid2">
              <div class="ds-kolom">
                <label for="tanggal" class="ds-label">Tanggal <span class="ds-wajib">*</span></label>
                <input id="tanggal" name="tanggal" class="ds-isian" type="date" required value="<?= esc($lama('tanggal', date('Y-m-d')), 'attr') ?>">
              </div>
              <div class="ds-kolom">
                <label for="jumlah" class="ds-label">Jumlah setoran <span class="ds-wajib">*</span></label>
                <div class="tb-rp-isian">
                  <span aria-hidden="true">Rp</span>
                  <input id="jumlah" class="ds-isian" type="text" inputmode="numeric" autocomplete="off" placeholder="0" value="<?= esc($lama('rp') !== '' ? number_format((int) preg_replace('/\D/', '', $lama('rp')), 0, ',', '.') : '', 'attr') ?>">
                </div>
              </div>
            </div>
            <div class="ds-kolom" style="gap: 8px">
              <span class="ds-label" id="lbl-jenis">Jenis setoran <span class="ds-wajib">*</span></span>
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
          </section>

          <section class="ds-kartu ds-bagian" aria-labelledby="h-tagihan" id="bagianTagihan">
            <div class="ds-judul">
              <h2 id="h-tagihan" style="font-size: 17px">Bulan SPP yang dibayar dari setoran ini</h2>
              <p class="ds-sub" style="font-size: 13px">Pilih sampai bulan berapa SPP dibayar; bulan dibayar berurutan mulai bulan pertama yang belum lunas. Untuk setiap bulan, laundry (<?= $rp(T::TARIF_LAUNDRY) ?>) dan kesehatan (<?= $rp(T::TARIF_KESEHATAN) ?>) ikut dipotong. Sisa setoran masuk ke saldo uang saku.</p>
            </div>
            <?php if ($tarifSpp <= 0) : ?>
              <p class="ds-pesan ds-pesan-salah" style="margin: 0">Tarif SPP untuk kelas siswa ini belum diatur. Atur dulu di menu Tarif SPP sebelum membayar SPP.</p>
            <?php else : ?>
              <div class="ds-baris" style="justify-content: space-between; font-size: 14px"><strong>SPP TA <?= $taAktif ?>/<?= $taAktif + 1 ?></strong><span class="ds-kecil" style="font-size: 13px"><?= $rp($tarifSpp) ?> / bulan · lunas <?= $lunasSpp ?> bulan</span></div>
              <div class="tb-bln" role="group" aria-label="Bulan SPP">
                <?php for ($i = 1; $i <= 12; $i++) :
                  $lunas = $i <= $lunasSpp;
                  $dipilih = ! $lunas && old('sppbulan' . $i) !== null; ?>
                  <input type="checkbox" name="sppbulan<?= $i ?>" id="spp<?= $i ?>" value="<?= esc((string) $tarifSpp, 'attr') ?>" <?= $lunas ? 'disabled checked' : '' ?> <?= $dipilih ? 'checked' : '' ?> data-bulan>
                  <label for="spp<?= $i ?>" title="<?= esc($singkat[$i - 1] . ($lunas ? ': sudah lunas' : ''), 'attr') ?>"><?= $lunas ? '✓ ' : '' ?><?= $singkat[$i - 1] ?></label>
                <?php endfor ?>
              </div>
            <?php endif ?>
          </section>

          <section class="ds-kartu ds-bagian" aria-labelledby="h-bukti">
            <h2 id="h-bukti" style="font-size: 17px">Bukti &amp; keterangan</h2>
            <div class="ds-grid2">
              <div class="ds-kolom">
                <label for="buktitransfer" class="ds-label">Bukti transfer</label>
                <input id="buktitransfer" name="buktitransfer" type="file" class="ds-isian" style="padding-top: 9px" accept="image/jpeg,image/png,image/webp">
                <span class="ds-bantu">JPG, PNG, atau WEBP · tidak wajib untuk setoran tunai.</span>
              </div>
              <div class="ds-kolom">
                <label for="keterangan_trans" class="ds-label">Keterangan</label>
                <input id="keterangan_trans" name="keterangan_trans" class="ds-isian" type="text" maxlength="200" placeholder="Misalnya: transfer dari ayah" value="<?= esc($lama('keterangan_trans'), 'attr') ?>">
              </div>
            </div>
          </section>
        </div>

        <aside class="ds-samping">
          <section class="ds-kartu tb-ringkas" aria-labelledby="h-ringkas" aria-live="polite">
            <h2 id="h-ringkas" style="font-size: 16px">Ringkasan</h2>
            <div class="tb-brs"><span>Setoran</span><strong id="rsSetor">Rp 0</strong></div>
            <div id="rsPotongan"></div>
            <div class="tb-brs tb-garis"><span>Masuk ke saldo uang saku</span><strong id="rsSisa">Rp 0</strong></div>
            <div class="tb-brs ds-kecil" style="font-size: 14px"><span>Saldo setelah setoran</span><strong id="rsSaldo" style="color: #0F172A">—</strong></div>
            <p id="rsKurang" class="ds-pesan ds-pesan-salah" role="alert" style="margin: 0; display: none"></p>
            <p class="ds-bantu" style="margin: 0">Saat disimpan, sistem mencatat setoran lalu tiap potongan sebagai transaksi terpisah.</p>
          </section>
        </aside>
      </div>
    </div>

    <div class="ds-aksi">
      <div>
        <a class="ds-batal" href="<?= esc(base_url('index.php/transaksi/indexTabungan/' . $mm), 'attr') ?>">Batal</a>
        <button type="submit" class="ds-tombol ds-tombol-utama" id="tombolSimpan">Simpan setoran</button>
      </div>
    </div>
  </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<?= view('Transaksi/tabungan/_skrip') ?>
<script>
  (function () {
    var form = document.getElementById('formSetor');
    var saldo = <?= json_encode((float) $saldo) ?>;
    var tarif = { spp: <?= json_encode((float) $tarifSpp) ?>, ldr: <?= (int) T::TARIF_LAUNDRY ?>, kes: <?= (int) T::TARIF_KESEHATAN ?> };
    var infak = <?= (int) T::POTONGAN_INFAK ?>;
    var tanpaInfak = <?= json_encode(T::TANPA_INFAK) ?>;
    var jumlah = document.getElementById('jumlah'), rp = document.getElementById('rp');
    var bagianTagihan = document.getElementById('bagianTagihan');

    function rupiah(n) { return (n < 0 ? '− ' : '') + 'Rp ' + Math.abs(Math.round(n)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
    function jenis() { var r = form.querySelector('input[name="NKKodeTransaksi"]:checked'); return r ? r.value : ''; }
    function baris(label, nilai) { return '<div class="tb-brs tb-keluar"><span>− ' + label + '</span><span>' + rupiah(nilai) + '</span></div>'; }

    function hitung() {
      var angka = parseInt(jumlah.value.replace(/\D/g, ''), 10) || 0;
      rp.value = angka ? String(angka) : '';
      jumlah.value = angka ? angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
      var j = jenis(), spp = j === 'TKSPP';
      bagianTagihan.style.display = spp ? '' : 'none';
      // Bulan hanya ikut terkirim untuk setoran SPP; bulan lunas selalu terkunci
      form.querySelectorAll('[data-bulan]').forEach(function (c) { if (c.dataset.lunas !== '1') c.disabled = !spp; });
      var n = spp ? form.querySelectorAll('[data-bulan]:checked:not([disabled])').length : 0;
      var html = '', potong = 0;
      if (n) {
        html += baris('SPP ' + n + ' bln', tarif.spp * n) + baris('Laundry ' + n + ' bln', tarif.ldr * n) + baris('Kesehatan ' + n + ' bln', tarif.kes * n);
        potong += (tarif.spp + tarif.ldr + tarif.kes) * n;
      }
      if (j && tanpaInfak.indexOf(j) < 0) { html += baris('Infak (potongan tiap setoran)', infak); potong += infak; }
      var sisa = angka - potong;
      document.getElementById('rsSetor').textContent = rupiah(angka);
      document.getElementById('rsPotongan').innerHTML = html;
      var elSisa = document.getElementById('rsSisa');
      elSisa.textContent = rupiah(sisa);
      elSisa.style.color = sisa < 0 ? '#B42318' : '#166534';
      document.getElementById('rsSaldo').textContent = rupiah(saldo + sisa);
      var kurang = document.getElementById('rsKurang');
      kurang.style.display = sisa < 0 ? '' : 'none';
      kurang.textContent = sisa < 0 ? 'Setoran kurang ' + rupiah(-sisa) + ' untuk membayar yang dipilih. Kurangi bulan atau tambah setoran.' : '';
      document.getElementById('tombolSimpan').textContent = angka ? 'Simpan setoran ' + rupiah(angka) : 'Simpan setoran';
      return { angka: angka, sisa: sisa, j: j };
    }
    var kotakBulan = Array.prototype.slice.call(form.querySelectorAll('[data-bulan]'));
    kotakBulan.forEach(function (c) { c.dataset.lunas = c.disabled ? '1' : ''; });
    // Bulan dipilih berurutan: klik satu bulan = bayar dari bulan pertama yang belum lunas sampai bulan itu
    kotakBulan.forEach(function (c, i) {
      c.addEventListener('click', function () {
        var sampai = c.checked ? i : i - 1;
        kotakBulan.forEach(function (k, j) { if (k.dataset.lunas !== '1') k.checked = j <= sampai; });
      });
    });
    form.addEventListener('input', hitung);
    form.addEventListener('change', hitung);
    form.addEventListener('submit', function (e) {
      var h = hitung();
      var masalah = [];
      if (!form.elements.tanggal.value) masalah.push('tanggal');
      if (!h.j) masalah.push('jenis setoran');
      if (!h.angka) masalah.push('jumlah setoran');
      if (h.j === 'TKSPP' && tarif.spp <= 0) masalah.push('jenis setoran lain (tarif SPP kelas ini belum diatur)');
      else if (h.j === 'TKSPP' && !form.querySelector('[data-bulan]:checked:not([disabled])')) masalah.push('bulan SPP yang dibayar (minimal satu)');
      if (masalah.length) { e.preventDefault(); alert('Lengkapi dulu: ' + masalah.join(', ') + '.'); return; }
      if (h.sisa < 0) { e.preventDefault(); alert('Setoran kurang untuk membayar bulan yang dipilih.'); return; }
      if (!confirm('Simpan setoran ' + rupiah(h.angka) + ' untuk <?= esc($siswa['nama_siswa'], 'js') ?>?')) e.preventDefault();
    });
    hitung();
  })();
</script>
<?= $this->endSection() ?>
