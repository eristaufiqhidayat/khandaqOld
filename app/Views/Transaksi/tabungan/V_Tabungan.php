<?php
// Variabel yang hanya ada bila siswa sudah dipilih
$ta    = $ta ?? null;
$jenis = $jenis ?? '';
$mm    = $menuAktip . '/' . $moduleAktip;
$dasar = base_url('index.php/transaksi/indexTabungan/' . $mm);
$rp    = static function ($n) {
    return 'Rp ' . number_format((float) $n, 0, ',', '.');
};
$namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$singkat   = ['Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
$tglIndo   = static function ($tgl) use ($namaBulan) {
    $t = strtotime((string) $tgl);
    return $t ? date('d', $t) . ' ' . substr($namaBulan[(int) date('n', $t)], 0, 3) . ' ' . date('Y', $t) : '—';
};
$gayaJenis = static function ($kode, $kodeTran) {
    if ($kodeTran === 'K') return 'tb-j-masuk';
    if ($kode === 'TDTNI') return 'tb-j-tunai';
    if (in_array($kode, ['TDSPP', 'TDLDR', 'TDKES', 'TDADM', 'TDPTS', 'TDPAS'], true)) return 'tb-j-bayar';
    return 'tb-j-lain';
};
$urlTa = static function (array $ubah) use ($dasar, $siswa, $ta, $jenis) {
    $q = array_merge(['siswa' => $siswa['id_siswa'] ?? null, 'ta' => $ta ?? null, 'jenis' => $jenis ?? ''], $ubah);
    $q = array_filter($q, static function ($v) {
        return $v !== '' && $v !== null;
    });
    return $dasar . '?' . http_build_query($q);
};
?>
<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<?= view('Transaksi/tabungan/_gaya') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="content-wrapper ds">
  <div class="ds-wadah">

    <div class="ds-kepala" style="align-items: center">
      <h1 style="font-size: 26px">Tabungan Siswa</h1>
      <form method="get" action="<?= esc($dasar, 'attr') ?>" role="search" class="ds-cari" style="flex: 0 1 400px; max-width: none">
        <label for="cari-siswa" class="ds-tersembunyi">Cari siswa</label>
        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
        <input id="cari-siswa" name="q" class="ds-isian" type="search" value="<?= esc($q, 'attr') ?>" placeholder="<?= $siswa ? 'Cari siswa lain: nama, NIS, atau kode tabungan' : 'Cari siswa: nama, NIS, atau kode tabungan' ?>" <?= $siswa ? '' : 'autofocus' ?>>
      </form>
    </div>

    <?php if (session('sukses')) : ?>
      <div class="ds-pesan ds-pesan-ok" role="status"><?= esc(session('sukses')) ?></div>
    <?php endif ?>

    <?php if ($q !== '' && count($hasilCari) !== 1) : ?>
      <section class="ds-kartu" aria-labelledby="h-hasil">
        <div style="padding: 16px 20px; border-bottom: 1px solid #E2E8F0"><h2 id="h-hasil" style="font-size: 16px">Hasil pencarian “<?= esc($q) ?>”</h2></div>
        <?php if (! $hasilCari) : ?>
          <div class="ds-kosong"><strong>Tidak ada siswa yang cocok</strong><span class="ds-kecil">Coba nama lain, NIS, atau kode tabungan.</span></div>
        <?php else : ?>
          <ul style="list-style: none; margin: 0; padding: 0">
            <?php foreach ($hasilCari as $h) : ?>
              <li style="border-top: 1px solid #E2E8F0">
                <a href="<?= esc($dasar . '?siswa=' . (int) $h['id_siswa'], 'attr') ?>" style="display: flex; flex-wrap: wrap; gap: 4px 16px; padding: 12px 20px; text-decoration: none; color: #0F172A">
                  <strong style="flex: 1 1 220px"><?= esc($h['nama_siswa']) ?></strong>
                  <span class="ds-kecil">NIS <?= esc($h['nis'] ?: '—') ?> · <?= esc($h['nama_kelas'] ?: '—') ?> · <?= esc($h['kode_tab'] ?: 'belum ada kode tabungan') ?></span>
                </a>
              </li>
            <?php endforeach ?>
          </ul>
          <?php if (count($hasilCari) >= 20) : ?><p class="ds-kecil" style="padding: 12px 20px; margin: 0">Hanya 20 hasil pertama yang ditampilkan. Ketik lebih lengkap.</p><?php endif ?>
        <?php endif ?>
      </section>
    <?php endif ?>

    <?php if (! $siswa) : ?>
      <?php if ($q === '') : ?>
        <div class="ds-kartu ds-kosong" style="padding: 48px 20px">
          <strong style="font-size: 18px">Pilih siswa</strong>
          <span class="ds-kecil" style="font-size: 14px">Ketik nama, NIS, atau kode tabungan di kotak pencarian di atas.</span>
        </div>
      <?php endif ?>
    <?php else : ?>

      <?= view('Transaksi/tabungan/_siswa', ['siswa' => $siswa, 'kode' => $kode, 'laundry' => $laundry, 'tombol' => true, 'menuAktip' => $menuAktip, 'moduleAktip' => $moduleAktip]) ?>

      <?php if (! $kode) : ?>
        <section class="ds-kartu ds-kosong" style="padding: 40px 20px">
          <strong style="font-size: 18px">Siswa ini belum punya kode tabungan</strong>
          <span class="ds-kecil" style="font-size: 14px">Buat kode tabungan dulu supaya bisa menyetor dan menarik.</span>
          <form method="post" action="<?= esc(base_url('index.php/transaksi/saveNewDataTabungan/' . $mm), 'attr') ?>" style="margin-top: 8px">
            <input type="hidden" name="id_siswa" value="<?= (int) $siswa['id_siswa'] ?>">
            <input type="hidden" name="nama_siswa" value="<?= esc($siswa['nama_siswa'], 'attr') ?>">
            <input type="hidden" name="kode_tab" value="<?= esc('T' . (int) $siswa['id_siswa'] . '-' . date('dmY'), 'attr') ?>">
            <button type="submit" class="ds-tombol ds-tombol-utama">Buat kode tabungan T<?= (int) $siswa['id_siswa'] ?>-<?= date('dmY') ?></button>
          </form>
        </section>
      <?php else : ?>

        <div class="tb-kpi">
          <div class="tb-utama">
            <span class="tb-judul">Saldo saat ini</span>
            <span class="tb-angka"><?= ($saldo < 0 ? '− ' : '') . $rp(abs($saldo)) ?></span>
            <span class="tb-ket">per <?= esc($tglIndo(date('Y-m-d'))) ?></span>
          </div>
          <div>
            <span class="tb-judul">Masuk <?= $ta === 'semua' ? 'semua tahun' : 'TA ' . $ta . '/' . ($ta + 1) ?></span>
            <span class="tb-angka tb-masuk"><?= $rp($masuk) ?></span>
            <span class="tb-ket">setoran ke tabungan</span>
          </div>
          <div>
            <span class="tb-judul">Keluar <?= $ta === 'semua' ? 'semua tahun' : 'TA ' . $ta . '/' . ($ta + 1) ?></span>
            <span class="tb-angka tb-keluar"><?= $rp($keluar) ?></span>
            <span class="tb-ket">SPP, laundry, kesehatan, uang saku, dll.</span>
          </div>
          <div>
            <span class="tb-judul">Uang saku <?= esc($namaBulan[(int) date('n')]) ?></span>
            <span class="tb-angka"><?= $rp($saku) ?></span>
            <span class="tb-ket"><?= $sakuN ?> kali penarikan tunai</span>
          </div>
        </div>

        <section class="ds-kartu" aria-labelledby="h-bayar" style="padding: 20px 24px; display: flex; flex-direction: column; gap: 14px">
          <div class="ds-baris" style="justify-content: space-between; align-items: baseline">
            <h2 id="h-bayar" style="font-size: 17px">Pembayaran bulanan TA <?= $taAktif ?>/<?= $taAktif + 1 ?></h2>
            <div class="ds-baris" style="gap: 14px; font-size: 12px; color: #334155">
              <span class="ds-baris" style="gap: 6px"><span style="width: 12px; height: 12px; border-radius: 3px; background: #0F766E"></span>Lunas</span>
              <span class="ds-baris" style="gap: 6px"><span style="width: 12px; height: 12px; border-radius: 3px; border: 2px solid #D97706; box-sizing: border-box"></span>Bulan ini, belum</span>
              <span class="ds-baris" style="gap: 6px"><span style="width: 12px; height: 12px; border-radius: 3px; background: #E2E8F0"></span>Belum dibayar</span>
            </div>
          </div>
          <div style="overflow-x: auto">
            <table class="tb-bulan">
              <thead><tr><th scope="col"><span class="ds-tersembunyi">Jenis</span></th><?php foreach ($singkat as $b) : ?><th scope="col"><?= $b ?></th><?php endforeach ?></tr></thead>
              <tbody>
                <?php foreach ($tagihan as [$nama, $tarif, $lunas]) : ?>
                  <tr>
                    <th scope="row"><?= esc($nama) ?><br><span class="ds-kecil" style="font-weight: 500"><?= $tarif > 0 ? $rp($tarif) . ' / bln' : 'tarif belum diatur' ?></span></th>
                    <?php for ($i = 0; $i < 12; $i++) :
                      $kelas = ($lunas !== null && $i < $lunas) ? 'tb-lunas' : ($i === $posBulan ? 'tb-kini' : 'tb-nanti');
                      $judul = $singkat[$i] . ': ' . ($kelas === 'tb-lunas' ? 'lunas' : ($kelas === 'tb-kini' ? 'bulan ini, belum dibayar' : 'belum dibayar')); ?>
                      <td class="<?= $kelas ?>" title="<?= esc($judul, 'attr') ?>"><?= $kelas === 'tb-lunas' ? '✓' : ($kelas === 'tb-kini' ? '!' : '') ?><span class="ds-tersembunyi"><?= esc($judul) ?></span></td>
                    <?php endfor ?>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <?php $lunasSpp = $tagihan[0][2]; ?>
          <p class="ds-kecil" style="margin: 0; font-size: 13px; color: #334155">
            <?php if ($lunasSpp === null) : ?>
              Tarif SPP untuk kelas siswa ini belum diatur, jadi status SPP tidak bisa dihitung.
            <?php elseif ($lunasSpp >= 12) : ?>
              SPP tahun ajaran ini sudah lunas semua.
            <?php elseif ($lunasSpp > 0) : ?>
              SPP lunas sampai <strong><?= $namaBulan[(($lunasSpp + 5) % 12) + 1] ?></strong>. Bulan berikutnya bisa dibayar langsung saat menyetor.
            <?php else : ?>
              Belum ada SPP yang dibayar tahun ajaran ini.
            <?php endif ?>
            Jumlah bulan lunas dihitung dari total potongan dibagi tarif, mulai Juli.
          </p>
        </section>

        <section class="ds-kartu" aria-labelledby="h-riwayat">
          <form method="get" action="<?= esc($dasar, 'attr') ?>" class="ds-alat">
            <h2 id="h-riwayat" style="font-size: 17px; margin-right: auto">Riwayat transaksi</h2>
            <input type="hidden" name="siswa" value="<?= (int) $siswa['id_siswa'] ?>">
            <nav class="ds-tab" aria-label="Jenis transaksi">
              <?php foreach (['' => 'Semua', 'masuk' => 'Masuk', 'keluar' => 'Keluar'] as $k => $l) : ?>
                <a href="<?= esc($urlTa(['jenis' => $k]), 'attr') ?>" <?= $jenis === $k ? 'aria-current="page"' : '' ?>><?= $l ?></a>
              <?php endforeach ?>
            </nav>
            <?php if ($jenis !== '') : ?><input type="hidden" name="jenis" value="<?= esc($jenis, 'attr') ?>"><?php endif ?>
            <label for="ta" class="ds-tersembunyi">Tahun ajaran</label>
            <select id="ta" name="ta" class="ds-isian" style="width: auto" data-kirim-otomatis>
              <?php foreach ($taPilihan as $t) : ?>
                <option value="<?= $t ?>" <?= $ta === $t ? 'selected' : '' ?>>TA <?= $t ?>/<?= $t + 1 ?></option>
              <?php endforeach ?>
              <option value="semua" <?= $ta === 'semua' ? 'selected' : '' ?>>Semua tahun</option>
            </select>
            <noscript><button type="submit" class="ds-tombol ds-tombol-netral">Tampilkan</button></noscript>
          </form>

          <?php if (! $riwayat) : ?>
            <div class="ds-kosong">
              <strong>Belum ada transaksi<?= $ta === 'semua' ? '' : ' di TA ' . $ta . '/' . ($ta + 1) ?></strong>
              <span class="ds-kecil">Pilih tahun ajaran lain atau "Semua tahun" untuk melihat transaksi lama.</span>
            </div>
          <?php else : ?>
            <div class="ds-tabel-wadah">
              <table class="tb-tabel">
                <thead>
                  <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jenis</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col" class="tb-rp">Masuk</th>
                    <th scope="col" class="tb-rp">Keluar</th>
                    <th scope="col" class="tb-rp">Saldo</th>
                    <th scope="col"><span class="ds-tersembunyi">Aksi</span></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $bulanLalu = '';
                  foreach ($riwayat as $r) :
                    $t = strtotime((string) $r['tanggal']);
                    $bulanIni = $t ? $namaBulan[(int) date('n', $t)] . ' ' . date('Y', $t) : '—';
                    if ($bulanIni !== $bulanLalu) : $bulanLalu = $bulanIni; ?>
                      <tr class="tb-kepala"><td colspan="7"><?= esc($bulanIni) ?></td></tr>
                    <?php endif;
                    $isMasuk = $r['kode_tran'] === 'K';
                    $no = (int) $r['notransaksi']; ?>
                    <tr class="tb-isi">
                      <td style="white-space: nowrap"><?= esc($tglIndo($r['tanggal'])) ?><br><span class="ds-kecil">#<?= $no ?></span></td>
                      <td><span class="tb-jenis <?= $gayaJenis($r['kodetransaksi'], $r['kode_tran']) ?>"><?= esc($r['nama']) ?></span><br><span class="ds-kecil" style="font-size: 11px"><?= esc($r['kodetransaksi']) ?></span></td>
                      <td style="color: #334155">
                        <?= esc($r['keterangan_trans'] ?: '—') ?>
                        <?php if ($r['buktitransfer']) :
                          $folderBukti = in_array(strtolower(pathinfo($r['buktitransfer'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'], true) ? 'uploads/tabungan/' : 'uploads/buktitransfer/'; ?> · <a href="<?= esc(base_url($folderBukti . rawurlencode($r['buktitransfer'])), 'attr') ?>" target="_blank" rel="noopener" style="font-size: 13px; font-weight: 600">Lihat bukti</a><?php endif ?>
                      </td>
                      <td class="tb-rp tb-masuk" style="font-weight: 700"><?= $isMasuk ? $rp($r['rp']) : '' ?></td>
                      <td class="tb-rp tb-keluar" style="font-weight: 700"><?= ! $isMasuk && $r['kode_tran'] === 'D' ? $rp($r['rp']) : '' ?></td>
                      <td class="tb-rp"><?= ($r['saldo'] < 0 ? '− ' : '') . $rp(abs($r['saldo'])) ?></td>
                      <td style="text-align: right; white-space: nowrap">
                        <details class="ds-menu" style="margin-left: 0">
                          <summary aria-label="Aksi untuk transaksi <?= $no ?>">
                            <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="#334155"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                          </summary>
                          <div class="ds-menu-isi">
                            <a href="<?= esc(base_url('index.php/transaksi/tabungan/ubah/' . $mm . '/' . $no), 'attr') ?>">Ubah transaksi</a>
                            <form method="post" action="<?= esc(base_url('index.php/transaksi/delete/' . $mm), 'attr') ?>" data-konfirmasi="<?= esc('Hapus transaksi #' . $no . ' (' . $r['nama'] . ' ' . $rp($r['rp']) . ')? Saldo akan dihitung ulang. Data yang dihapus tidak bisa dikembalikan.', 'attr') ?>">
                              <input type="hidden" name="notransaksi" value="<?= $no ?>">
                              <input type="hidden" name="kembali" value="tabungan">
                              <button type="submit" class="ds-bahaya">Hapus transaksi</button>
                            </form>
                          </div>
                        </details>
                      </td>
                    </tr>
                  <?php endforeach ?>
                  <?php if ($ta !== 'semua' && $jenis === '') : ?>
                    <tr style="background: #F8FAFC">
                      <td colspan="5" style="font-size: 13px; color: #334155">Saldo awal TA <?= $ta ?>/<?= $ta + 1 ?> (1 Jul <?= $ta ?>)</td>
                      <td class="tb-rp" style="font-weight: 700"><?= ($saldoAwal < 0 ? '− ' : '') . $rp(abs($saldoAwal)) ?></td>
                      <td></td>
                    </tr>
                  <?php endif ?>
                </tbody>
              </table>
            </div>
          <?php endif ?>
          <div class="ds-kaki">
            <span>Menampilkan <?= count($riwayat) ?><?= $jenis !== '' ? ' dari ' . $jumlahSemua : '' ?> transaksi<?= $ta === 'semua' ? ' (semua tahun)' : ' TA ' . $ta . '/' . ($ta + 1) ?></span>
            <?php if ($ta !== 'semua') : ?><a href="<?= esc($urlTa(['ta' => 'semua']), 'attr') ?>" style="font-weight: 600">Lihat semua tahun</a><?php endif ?>
          </div>
        </section>
      <?php endif ?>
    <?php endif ?>

  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<?= view('Transaksi/tabungan/_skrip') ?>
<script>
  (function () {
    document.querySelectorAll('[data-kirim-otomatis]').forEach(function (el) {
      el.addEventListener('change', function () { el.form.submit(); });
    });
    document.querySelectorAll('form[data-konfirmasi]').forEach(function (f) {
      f.addEventListener('submit', function (e) {
        if (!window.confirm(f.getAttribute('data-konfirmasi'))) e.preventDefault();
      });
    });
    document.addEventListener('click', function (e) {
      document.querySelectorAll('details.ds-menu[open]').forEach(function (d) {
        if (!d.contains(e.target)) d.removeAttribute('open');
      });
    });
  })();
</script>
<?= $this->endSection() ?>
