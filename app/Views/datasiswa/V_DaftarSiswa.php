<?php

use App\Controllers\C_DataSiswa;
use App\Models\M_DataSiswa;

$dasar = 'index.php/datasiswa/';
$mm    = $menuAktip . '/' . $moduleAktip;

// URL daftar dengan filter sekarang, ditimpa oleh $ubah
$urlDaftar = static function (array $ubah = []) use ($filter, $dasar, $mm) {
    $q = array_merge(['q' => $filter['q'], 'kelas' => $filter['kelas'] ?: '', 'status' => $filter['status']], $ubah);
    $q = array_filter($q, static function ($v) {
        return $v !== '' && $v !== null;
    });

    return base_url($dasar . 'index/' . $mm) . ($q ? '?' . http_build_query($q) : '');
};
$tabs = ['' => 'Semua'] + M_DataSiswa::STATUS;
$warnaAvatar = [['#CCFBF1', '#115E59'], ['#FEF3C7', '#92400E'], ['#E0E7FF', '#3730A3'], ['#FCE7F3', '#9D174D']];
$dari = $total ? ($halaman - 1) * $perHalaman + 1 : 0;
$sampai = min($total, $halaman * $perHalaman);
?>
<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<?= $this->include('datasiswa/_gaya') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="content-wrapper ds">
  <div class="ds-wadah">

    <?php if (session('sukses')) : ?>
      <div class="ds-pesan ds-pesan-ok" role="status"><?= esc(session('sukses')) ?></div>
    <?php endif ?>

    <header class="ds-kepala">
      <div class="ds-judul">
        <h1>Data Siswa</h1>
        <p class="ds-sub">Cari, lihat, dan kelola data siswa.<?php if (! empty($periodeAktif)) : ?> Periode aktif <?= esc($periodeAktif['tahun_ajaran'] . ' ' . ucfirst($periodeAktif['semester'])) ?>.<?php endif ?></p>
      </div>
      <div class="ds-baris">
        <a class="ds-tombol ds-tombol-netral" href="<?= esc(base_url($dasar . 'ekspor/' . $mm) . (parse_url($urlDaftar(), PHP_URL_QUERY) ? '?' . parse_url($urlDaftar(), PHP_URL_QUERY) : ''), 'attr') ?>">
          <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
          Ekspor ke Excel
        </a>
        <a class="ds-tombol ds-tombol-utama" href="<?= esc(base_url($dasar . 'tambah/' . $mm), 'attr') ?>">
          <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
          Tambah siswa
        </a>
      </div>
    </header>

    <section class="ds-kartu" aria-label="Daftar siswa">
      <div class="ds-alat">
        <nav class="ds-tab" aria-label="Filter status">
          <?php foreach ($tabs as $kode => $label) : ?>
            <a href="<?= esc($urlDaftar(['status' => $kode, 'hal' => '']), 'attr') ?>" <?= $filter['status'] === $kode ? 'aria-current="page"' : '' ?>>
              <?= esc($label) ?> <span class="ds-hitung"><?= (int) $hitung[$kode === '' ? 'semua' : $kode] ?></span>
            </a>
          <?php endforeach ?>
        </nav>
        <form method="get" action="<?= esc(base_url($dasar . 'index/' . $mm), 'attr') ?>" class="ds-baris" style="flex: 1 1 260px; justify-content: flex-end" role="search">
          <?php if ($filter['status'] !== '') : ?><input type="hidden" name="status" value="<?= esc($filter['status'], 'attr') ?>"><?php endif ?>
          <div class="ds-cari">
            <label for="cari" class="ds-tersembunyi">Cari siswa</label>
            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
            <input id="cari" name="q" class="ds-isian" type="search" placeholder="Cari nama, NIS, atau NISN" value="<?= esc($filter['q'], 'attr') ?>">
          </div>
          <label for="kelas" class="ds-tersembunyi">Kelas</label>
          <select id="kelas" name="kelas" class="ds-isian" style="width: auto; min-width: 150px" data-kirim-otomatis>
            <option value="">Semua kelas</option>
            <?php foreach ($kelas as $k) : ?>
              <option value="<?= (int) $k['id_kelas'] ?>" <?= (int) $filter['kelas'] === (int) $k['id_kelas'] ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?></option>
            <?php endforeach ?>
          </select>
          <button type="submit" class="ds-tombol ds-tombol-netral">Cari</button>
        </form>
      </div>

      <?php if ($siswa) : ?>
        <div class="ds-tabel-wadah">
          <table class="ds-tabel">
            <thead>
              <tr>
                <th scope="col">Siswa</th>
                <th scope="col">L/P</th>
                <th scope="col">Kelas</th>
                <th scope="col">Orang tua</th>
                <th scope="col">Status</th>
                <th scope="col">Kelengkapan</th>
                <th scope="col"><span class="ds-tersembunyi">Aksi</span></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($siswa as $i => $s) :
                $id       = (int) $s['id_siswa'];
                $urlUbah  = base_url($dasar . 'ubah/' . $mm . '/' . $id);
                $kata     = preg_split('/\s+/', trim((string) $s['nama_siswa']));
                $inisial  = strtoupper(substr($kata[0] ?? '', 0, 1) . substr($kata[1] ?? '', 0, 1));
                $warna    = $warnaAvatar[$i % count($warnaAvatar)];
                $kode     = M_DataSiswa::kodeKelamin($s['kelamin']);
                $kelamin  = $kode === 'L' ? 'Laki-laki' : ($kode === 'P' ? 'Perempuan' : ($s['kelamin'] ?: '—'));
                $terisi   = count(array_filter(array_column($s['kelengkapan'], 1)));
                $jml      = count($s['kelengkapan']);
                $kurang   = $jml - $terisi;
                $status   = M_DataSiswa::STATUS[$s['locked']] ?? ($s['locked'] ?: '—');
              ?>
                <tr>
                  <td>
                    <div style="display: flex; align-items: center; gap: 12px">
                      <span class="ds-avatar" style="position: relative; background: <?= $warna[0] ?>; color: <?= $warna[1] ?>" aria-hidden="true"><?= esc($inisial) ?>
                        <?php if (C_DataSiswa::TAMPIL_FOTO_DAFTAR && $s['ada_foto']) : ?>
                          <img class="ds-avatar" style="position: absolute; inset: 0" src="<?= esc(base_url($dasar . 'foto/' . $id) . '?ukuran=kecil&v=' . (int) $s['foto_v'], 'attr') ?>" alt="" loading="lazy" width="40" height="40" onerror="this.remove()">
                        <?php endif ?>
                      </span>
                      <div style="display: flex; flex-direction: column; gap: 2px; min-width: 0">
                        <a class="ds-nama" href="<?= esc($urlUbah, 'attr') ?>"><?= esc($s['nama_siswa']) ?></a>
                        <span class="ds-kecil">NIS <?= esc($s['nis'] ?: '—') ?> · NISN <?= esc($s['nisn'] ?: '—') ?></span>
                      </div>
                    </div>
                  </td>
                  <td><?= esc($kelamin) ?></td>
                  <td><?= esc($s['nama_kelas'] ?: '—') ?></td>
                  <td>
                    <div style="display: flex; flex-direction: column; gap: 2px">
                      <span><?= esc($s['nama_ortu'] ?: '—') ?></span>
                      <span class="ds-kecil"><?= esc($s['telpon_siswa'] ?: '—') ?></span>
                    </div>
                  </td>
                  <td><span class="ds-lencana ds-st-<?= esc($s['locked'], 'attr') ?>"><?= esc($status) ?></span></td>
                  <td>
                    <div style="display: flex; flex-direction: column; gap: 6px" title="<?= esc(implode(', ', array_column(array_filter($s['kelengkapan'], static function ($c) { return ! $c[1]; }), 0)), 'attr') ?>">
                      <div class="ds-bar"><div style="width: <?= (int) round($terisi / $jml * 100) ?>%; background: <?= $kurang ? '#D97706' : '#0F766E' ?>"></div></div>
                      <span class="ds-kecil"><?= $kurang ? 'Kurang ' . $kurang . ' data' : 'Lengkap' ?></span>
                    </div>
                  </td>
                  <td>
                    <a class="ds-tombol ds-tombol-netral ds-tombol-kecil" href="<?= esc($urlUbah, 'attr') ?>">Ubah</a>
                    <details class="ds-menu">
                      <summary aria-label="Aksi lain untuk <?= esc($s['nama_siswa'], 'attr') ?>">
                        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="#334155"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                      </summary>
                      <div class="ds-menu-isi">
                        <?php if (C_DataSiswa::TAMPIL_FOTO_DAFTAR && $s['ada_foto']) : ?>
                          <a href="<?= esc(base_url($dasar . 'foto/' . $id), 'attr') ?>" target="_blank" rel="noopener">Lihat foto</a>
                        <?php endif ?>
                        <form method="post" action="<?= esc(base_url($dasar . 'hapus/' . $mm), 'attr') ?>" data-konfirmasi="<?= esc('Hapus data ' . $s['nama_siswa'] . '? Data yang dihapus tidak bisa dikembalikan. Untuk siswa yang lulus atau pindah, sebaiknya ubah statusnya menjadi Tidak aktif.', 'attr') ?>">
                          <input type="hidden" name="id_siswa" value="<?= $id ?>">
                          <input type="hidden" name="nama_siswa" value="<?= esc($s['nama_siswa'], 'attr') ?>">
                          <button type="submit" class="ds-bahaya">Hapus data</button>
                        </form>
                      </div>
                    </details>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      <?php else : ?>
        <div class="ds-kosong">
          <strong style="font-size: 16px">Tidak ada siswa yang cocok</strong>
          <span class="ds-kecil" style="font-size: 14px">Coba kata kunci lain, pilih "Semua kelas", atau pilih status "Semua".</span>
        </div>
      <?php endif ?>

      <div class="ds-kaki">
        <span>Menampilkan <?= $dari ?>–<?= $sampai ?> dari <?= (int) $total ?> siswa</span>
        <?php if ($jmlHalaman > 1) : ?>
          <nav class="ds-halaman" aria-label="Halaman">
            <?php if ($halaman > 1) : ?>
              <a href="<?= esc($urlDaftar(['hal' => $halaman - 1]), 'attr') ?>">Sebelumnya</a>
            <?php else : ?>
              <span class="ds-mati">Sebelumnya</span>
            <?php endif ?>
            <?php
            $tampil = array_unique(array_filter([1, $halaman - 1, $halaman, $halaman + 1, $jmlHalaman], static function ($h) use ($jmlHalaman) {
                return $h >= 1 && $h <= $jmlHalaman;
            }));
            sort($tampil);
            $sebelum = 0;
            foreach ($tampil as $h) :
              if ($h - $sebelum > 1) : ?><span class="ds-mati" aria-hidden="true">…</span><?php endif;
              $sebelum = $h; ?>
              <a href="<?= esc($urlDaftar(['hal' => $h]), 'attr') ?>" <?= $h === $halaman ? 'aria-current="page"' : '' ?>><?= $h ?></a>
            <?php endforeach ?>
            <?php if ($halaman < $jmlHalaman) : ?>
              <a href="<?= esc($urlDaftar(['hal' => $halaman + 1]), 'attr') ?>">Berikutnya</a>
            <?php else : ?>
              <span class="ds-mati">Berikutnya</span>
            <?php endif ?>
          </nav>
        <?php endif ?>
      </div>
    </section>

  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<!-- Skrip dasar AdminLTE (menutup layar jam pasir, menu samping). Tiap halaman memuatnya sendiri. -->
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>
<script>
  (function () {
    // Pilihan kelas langsung menyaring
    document.querySelectorAll('[data-kirim-otomatis]').forEach(function (el) {
      el.addEventListener('change', function () { el.form.submit(); });
    });
    // Konfirmasi sebelum hapus
    document.querySelectorAll('form[data-konfirmasi]').forEach(function (f) {
      f.addEventListener('submit', function (e) {
        if (!window.confirm(f.getAttribute('data-konfirmasi'))) e.preventDefault();
      });
    });
    // Tutup menu aksi saat klik di luar
    document.addEventListener('click', function (e) {
      document.querySelectorAll('details.ds-menu[open]').forEach(function (d) {
        if (!d.contains(e.target)) d.removeAttribute('open');
      });
    });
  })();
</script>
<?= $this->endSection() ?>
