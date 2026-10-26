<?php

use App\Models\M_DataSiswa;

$dasar = 'index.php/datasiswa/';
$mm    = $menuAktip . '/' . $moduleAktip;

// Nilai isian: isian sebelumnya (kalau gagal validasi), atau data siswa
$nilai = static function (string $kolom) use ($siswa) {
    $lama = old($kolom, null, false); // mentah; di-escape saat ditampilkan

    return (string) ($lama !== null ? $lama : ($siswa[$kolom] ?? ''));
};
$galat = static function (string $kolom) use ($errors) {
    return $errors[$kolom] ?? null;
};
$kelasSalah = static function (string $kolom) use ($errors) {
    return isset($errors[$kolom]) ? ' ds-salah' : '';
};
$pesanGalat = static function (string $kolom) use ($errors) {
    return isset($errors[$kolom])
        ? '<span class="ds-galat" id="galat-' . esc($kolom, 'attr') . '">' . esc($errors[$kolom]) . '</span>'
        : '';
};
$descGalat = static function (string $kolom) use ($errors) {
    return isset($errors[$kolom]) ? ' aria-invalid="true" aria-describedby="galat-' . esc($kolom, 'attr') . '"' : '';
};

// No. HP seluler ditampilkan tanpa awalan 0 / 62 karena kotaknya sudah berawalan +62.
// Isian lama yang bukan nomor seluler (telepon rumah, dua nomor, ada catatan) ditampilkan apa adanya.
$hp = $nilai('telpon_siswa');
if (preg_match('/^(?:\+?62|0)?(8[0-9]{7,12})$/', preg_replace('/[\s\-.]/', '', $hp), $m)) {
    $hp = $m[1];
}

$judul    = $baru ? 'Tambah Data Siswa' : 'Ubah Data Siswa';
$aksiForm = base_url($dasar . ($baru ? 'tambah/' : 'edit/') . $mm);
$adaFoto  = ! $baru && ! empty($siswa['ada_foto']);
$status   = [
    'baru' => ['Siswa baru', 'Pendaftar tahun ini'],
    'no'   => ['Aktif', 'Sudah masuk kelas'],
    'yes'  => ['Tidak aktif', 'Lulus, keluar, atau pindah'],
];
$cek = M_DataSiswa::kelengkapan(array_merge($siswa, [
    'nama_siswa' => $nilai('nama_siswa'), 'kelamin' => $nilai('kelamin'), 'tanggal_lahir' => $nilai('tanggal_lahir'),
    'nisn' => $nilai('nisn'), 'nama_ortu' => $nilai('nama_ortu'), 'telpon_siswa' => $nilai('telpon_siswa'),
]));
$kunciCek = ['nama_siswa', 'kelamin', 'tanggal_lahir', 'nisn', 'nama_ortu', 'telpon_siswa', 'image'];
?>
<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<?= $this->include('datasiswa/_gaya') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="content-wrapper ds">
  <form method="post" action="<?= esc($aksiForm, 'attr') ?>" enctype="multipart/form-data" id="formSiswa" novalidate>
    <?php if (! $baru) : ?><input type="hidden" name="id_siswa" value="<?= (int) $siswa['id_siswa'] ?>"><?php endif ?>
    <div class="ds-wadah">

      <nav aria-label="Breadcrumb" class="ds-baris" style="gap: 8px; font-size: 13px; color: #475569">
        <a href="<?= esc(base_url($dasar . 'index/' . $mm), 'attr') ?>" style="text-decoration: none">Data Siswa</a>
        <span aria-hidden="true">/</span>
        <span style="color: #0F172A; font-weight: 600"><?= $baru ? 'Tambah siswa' : esc($siswa['nama_siswa']) ?></span>
      </nav>

      <?php if (session('sukses')) : ?>
        <div class="ds-pesan ds-pesan-ok" role="status"><?= esc(session('sukses')) ?></div>
      <?php endif ?>
      <?php if ($errors) : ?>
        <div class="ds-pesan ds-pesan-salah" role="alert">
          Data belum tersimpan. Periksa <?= count($errors) ?> isian yang ditandai merah.
        </div>
      <?php endif ?>

      <header class="ds-kepala">
        <div class="ds-judul">
          <h1><?= esc($judul) ?></h1>
          <p class="ds-sub">Kolom bertanda <span class="ds-wajib" style="font-weight: 700">*</span> wajib diisi, sisanya bisa dilengkapi nanti.</p>
        </div>
        <?php if (! empty($periodeAktif)) : ?>
          <span class="ds-pil">Periode aktif: <?= esc($periodeAktif['tahun_ajaran'] . ' ' . ucfirst($periodeAktif['semester'])) ?></span>
        <?php endif ?>
      </header>

      <div class="ds-isi">
        <div class="ds-utama">

          <section class="ds-kartu ds-bagian" aria-labelledby="h-identitas">
            <div class="ds-bagian-kepala"><span class="ds-nomor">1</span><h2 id="h-identitas">Identitas siswa</h2></div>
            <div class="ds-grid2">
              <div class="ds-kolom ds-penuh">
                <label for="nama_siswa" class="ds-label">Nama lengkap siswa <span class="ds-wajib">*</span></label>
                <input id="nama_siswa" name="nama_siswa" class="ds-isian<?= $kelasSalah('nama_siswa') ?>" type="text" maxlength="100" placeholder="Sesuai akta kelahiran" required value="<?= esc($nilai('nama_siswa'), 'attr') ?>"<?= $descGalat('nama_siswa') ?>>
                <?= $pesanGalat('nama_siswa') ?>
              </div>
              <div class="ds-kolom">
                <label for="nis" class="ds-label">NIS</label>
                <input id="nis" name="nis" class="ds-isian<?= $kelasSalah('nis') ?>" type="text" inputmode="numeric" placeholder="Nomor induk sekolah" value="<?= esc($nilai('nis'), 'attr') ?>"<?= $descGalat('nis') ?>>
                <?= $pesanGalat('nis') ?>
              </div>
              <div class="ds-kolom">
                <label for="nisn" class="ds-label">NISN</label>
                <input id="nisn" name="nisn" class="ds-isian<?= $kelasSalah('nisn') ?>" type="text" inputmode="numeric" maxlength="10" pattern="[0-9]{10}" placeholder="10 digit angka" value="<?= esc($nilai('nisn'), 'attr') ?>"<?= $descGalat('nisn') ?>>
                <?= $galat('nisn') ? $pesanGalat('nisn') : '<span class="ds-bantu">Cek di nisn.data.kemdikbud.go.id bila belum tahu.</span>' ?>
              </div>
              <div class="ds-kolom">
                <span class="ds-label" id="lbl-kelamin">Jenis kelamin <span class="ds-wajib">*</span></span>
                <div class="ds-pilih ds-pilih2" role="radiogroup" aria-labelledby="lbl-kelamin">
                  <?php foreach (['L' => 'Laki-laki', 'P' => 'Perempuan'] as $kode => $label) : ?>
                    <input type="radio" name="kelamin" id="kelamin-<?= $kode ?>" value="<?= $kode ?>" <?= $nilai('kelamin') === $kode ? 'checked' : '' ?>>
                    <label class="ds-segmen" for="kelamin-<?= $kode ?>"><?= $label ?></label>
                  <?php endforeach ?>
                </div>
                <?= $pesanGalat('kelamin') ?>
              </div>
              <div class="ds-kolom">
                <label for="unik" class="ds-label">Kode unik</label>
                <input id="unik" name="unik" class="ds-isian" type="text" placeholder="Kode unik siswa (bila ada)" value="<?= esc($nilai('unik'), 'attr') ?>">
              </div>
              <div class="ds-kolom">
                <label for="tempat_lahir" class="ds-label">Tempat lahir</label>
                <input id="tempat_lahir" name="tempat_lahir" class="ds-isian" type="text" placeholder="Kota / kabupaten" value="<?= esc($nilai('tempat_lahir'), 'attr') ?>">
              </div>
              <div class="ds-kolom">
                <label for="tanggal_lahir" class="ds-label">Tanggal lahir</label>
                <input id="tanggal_lahir" name="tanggal_lahir" class="ds-isian<?= $kelasSalah('tanggal_lahir') ?>" type="date" value="<?= esc($nilai('tanggal_lahir') === '0000-00-00' ? '' : $nilai('tanggal_lahir'), 'attr') ?>"<?= $descGalat('tanggal_lahir') ?>>
                <?= $pesanGalat('tanggal_lahir') ?>
              </div>
            </div>
          </section>

          <section class="ds-kartu ds-bagian" aria-labelledby="h-kontak">
            <div class="ds-bagian-kepala"><span class="ds-nomor">2</span><h2 id="h-kontak">Orang tua &amp; kontak</h2></div>
            <div class="ds-grid2">
              <div class="ds-kolom">
                <label for="nama_ortu" class="ds-label">Nama orang tua / wali</label>
                <input id="nama_ortu" name="nama_ortu" class="ds-isian" type="text" placeholder="Nama ayah, ibu, atau wali" value="<?= esc($nilai('nama_ortu'), 'attr') ?>">
              </div>
              <div class="ds-kolom">
                <label for="telpon_siswa" class="ds-label">No. HP / WhatsApp</label>
                <div class="ds-awalan">
                  <span aria-hidden="true">+62</span>
                  <input id="telpon_siswa" name="telpon_siswa" class="ds-isian<?= $kelasSalah('telpon_siswa') ?>" type="tel" inputmode="tel" placeholder="812 3456 7890" value="<?= esc($hp, 'attr') ?>"<?= $descGalat('telpon_siswa') ?>>
                </div>
                <?= $galat('telpon_siswa') ? $pesanGalat('telpon_siswa') : '<span class="ds-bantu">Dipakai untuk pengingat SPP lewat WhatsApp.</span>' ?>
              </div>
              <div class="ds-kolom ds-penuh">
                <label for="email" class="ds-label">Email</label>
                <input id="email" name="email" class="ds-isian<?= $kelasSalah('email') ?>" type="email" placeholder="nama@contoh.com" value="<?= esc($nilai('email'), 'attr') ?>"<?= $descGalat('email') ?>>
                <?= $pesanGalat('email') ?>
              </div>
              <div class="ds-kolom ds-penuh">
                <label for="alamat_siswa" class="ds-label">Alamat</label>
                <textarea id="alamat_siswa" name="alamat_siswa" class="ds-isian" rows="3" placeholder="Jalan, RT/RW, kelurahan, kecamatan, kota"><?= esc($nilai('alamat_siswa')) ?></textarea>
              </div>
            </div>
          </section>

          <section class="ds-kartu ds-bagian" aria-labelledby="h-akademik">
            <div class="ds-bagian-kepala"><span class="ds-nomor">3</span><h2 id="h-akademik">Status &amp; akademik</h2></div>
            <div class="ds-kolom" style="gap: 8px">
              <span class="ds-label" id="lbl-status">Status siswa <span class="ds-wajib">*</span></span>
              <div class="ds-pilih ds-pilih3" role="radiogroup" aria-labelledby="lbl-status">
                <?php foreach ($status as $kode => [$label, $ket]) : ?>
                  <input type="radio" name="locked" id="status-<?= $kode ?>" value="<?= $kode ?>" <?= $nilai('locked') === $kode ? 'checked' : '' ?>>
                  <label class="ds-kartu-pilih" for="status-<?= $kode ?>">
                    <span class="ds-bulat" aria-hidden="true"></span>
                    <span style="display: flex; flex-direction: column; gap: 2px">
                      <strong style="font-size: 14px"><?= $label ?></strong>
                      <span class="ds-kecil"><?= $ket ?></span>
                    </span>
                  </label>
                <?php endforeach ?>
              </div>
              <?= $pesanGalat('locked') ?>
            </div>
            <div class="ds-grid2">
              <div class="ds-kolom">
                <label for="id_periode" class="ds-label">Periode masuk</label>
                <select id="id_periode" name="id_periode" class="ds-isian<?= $kelasSalah('id_periode') ?>"<?= $descGalat('id_periode') ?>>
                  <option value="">— Pilih periode —</option>
                  <?php
                  $adaDiDaftar = false;
                  foreach ($periode as $p) :
                    $dipilih = (string) $p['id_periode'] === $nilai('id_periode');
                    $adaDiDaftar = $adaDiDaftar || $dipilih; ?>
                    <option value="<?= (int) $p['id_periode'] ?>" <?= $dipilih ? 'selected' : '' ?>><?= esc($p['tahun_ajaran'] . ' ' . ucfirst($p['semester'])) ?><?= $p['status_aktif'] === 'yes' ? ' (aktif)' : '' ?></option>
                  <?php endforeach ?>
                  <?php if (! $adaDiDaftar && $nilai('id_periode') !== '') : ?>
                    <option value="<?= esc($nilai('id_periode'), 'attr') ?>" selected>Isian lama: <?= esc($nilai('id_periode')) ?></option>
                  <?php endif ?>
                </select>
                <?= $galat('id_periode') ? $pesanGalat('id_periode') : '<span class="ds-bantu">Diambil dari daftar periode, tidak perlu diketik.</span>' ?>
              </div>
              <div class="ds-kolom">
                <label for="tanggal_masuk" class="ds-label">Tanggal masuk</label>
                <input id="tanggal_masuk" name="tanggal_masuk" class="ds-isian<?= $kelasSalah('tanggal_masuk') ?>" type="date" value="<?= esc($nilai('tanggal_masuk') === '0000-00-00' ? '' : $nilai('tanggal_masuk'), 'attr') ?>"<?= $descGalat('tanggal_masuk') ?>>
                <?= $pesanGalat('tanggal_masuk') ?>
              </div>
            </div>
          </section>

          <section class="ds-kartu ds-bagian" aria-labelledby="h-catatan">
            <div class="ds-bagian-kepala"><span class="ds-nomor">4</span><h2 id="h-catatan">Catatan <span style="font-size: 13px; font-weight: 500; color: #475569">(opsional)</span></h2></div>
            <div class="ds-grid2">
              <div class="ds-kolom">
                <label for="photo" class="ds-label">Link foto kegiatan</label>
                <input id="photo" name="photo" class="ds-isian" type="text" placeholder="https://drive.google.com/…" value="<?= esc($nilai('photo'), 'attr') ?>">
              </div>
              <div class="ds-kolom">
                <label for="keterangan" class="ds-label">Keterangan</label>
                <input id="keterangan" name="keterangan" class="ds-isian" type="text" placeholder="Misalnya: pindahan dari sekolah lain" value="<?= esc($nilai('keterangan'), 'attr') ?>">
              </div>
            </div>
          </section>
        </div>

        <div class="ds-samping">
          <section class="ds-kartu ds-bagian" style="padding: 20px; gap: 14px" aria-labelledby="h-foto">
            <h2 id="h-foto" style="font-size: 16px">Foto siswa</h2>
            <label for="image" class="ds-unggah">
              <span class="ds-pratinjau" id="pratinjau">
                <?php if ($adaFoto) : ?>
                  <img src="<?= esc(base_url($dasar . 'foto/' . (int) $siswa['id_siswa']), 'attr') ?>" alt="Foto <?= esc($siswa['nama_siswa'], 'attr') ?>">
                <?php else : ?>
                  <svg aria-hidden="true" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                <?php endif ?>
              </span>
              <span style="font-size: 14px; font-weight: 600; color: #0F766E" id="teksFoto"><?= $adaFoto ? 'Ganti foto' : 'Pilih foto' ?></span>
              <span class="ds-kecil">JPG, PNG, atau WEBP · maks. <?= esc(ini_get('upload_max_filesize')) ?></span>
              <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="ds-tersembunyi"<?= $descGalat('image') ?>>
            </label>
            <?= $pesanGalat('image') ?>
            <?php if ($adaFoto) : ?>
              <label style="display: flex; gap: 8px; align-items: center; font-size: 13px; font-weight: 500; margin: 0">
                <input type="checkbox" name="hapus_foto" value="1" id="hapus_foto"> Hapus foto yang sekarang
              </label>
            <?php endif ?>
            <span class="ds-bantu">Foto tegak, latar polos.</span>
          </section>

          <section class="ds-kartu ds-bagian" style="padding: 20px; gap: 12px" aria-labelledby="h-cek">
            <div style="display: flex; justify-content: space-between; align-items: baseline">
              <h2 id="h-cek" style="font-size: 16px">Kelengkapan</h2>
              <span style="font-size: 13px; color: #334155; font-weight: 600"><span id="jmlCek"><?= count(array_filter(array_column($cek, 1))) ?></span> dari <?= count($cek) ?></span>
            </div>
            <div class="ds-bar" style="width: 100%; height: 8px"><div id="barCek" style="height: 8px; background: #0F766E; width: <?= (int) round(count(array_filter(array_column($cek, 1))) / count($cek) * 100) ?>%"></div></div>
            <ul class="ds-cek" id="daftarCek">
              <?php foreach ($cek as $i => [$label, $ok]) : ?>
                <li class="<?= $ok ? 'ok' : '' ?>" data-kolom="<?= $kunciCek[$i] ?>"><span aria-hidden="true">✓</span><?= esc($label) ?><span class="ds-tersembunyi"><?= $ok ? '(sudah diisi)' : '(belum diisi)' ?></span></li>
              <?php endforeach ?>
            </ul>
            <p class="ds-bantu" style="margin: 0">Data yang belum lengkap tetap bisa disimpan dan dilengkapi nanti.</p>
          </section>
        </div>
      </div>
    </div>

    <div class="ds-aksi">
      <div>
        <a class="ds-batal" href="<?= esc(base_url($dasar . 'index/' . $mm), 'attr') ?>">Batal, kembali ke daftar</a>
        <?php if ($baru) : ?>
          <button type="submit" name="lanjut" value="1" class="ds-tombol ds-tombol-garis">Simpan &amp; tambah lagi</button>
        <?php endif ?>
        <button type="submit" class="ds-tombol ds-tombol-utama"><?= $baru ? 'Simpan data siswa' : 'Simpan perubahan' ?></button>
      </div>
    </div>
  </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
  (function () {
    var form = document.getElementById('formSiswa');
    var adaFotoLama = <?= $adaFoto ? 'true' : 'false' ?>;
    var inputFoto = document.getElementById('image');
    var hapusFoto = document.getElementById('hapus_foto');
    var pratinjau = document.getElementById('pratinjau');

    function terisi(kolom) {
      if (kolom === 'kelamin') return !!form.querySelector('input[name="kelamin"]:checked');
      if (kolom === 'image') return (inputFoto.files && inputFoto.files.length > 0) || (adaFotoLama && !(hapusFoto && hapusFoto.checked));
      var el = form.elements[kolom];
      return !!(el && el.value.trim() !== '');
    }
    function perbaruiCek() {
      var item = document.querySelectorAll('#daftarCek li'), n = 0;
      item.forEach(function (li) {
        var ok = terisi(li.getAttribute('data-kolom'));
        li.classList.toggle('ok', ok);
        li.querySelector('.ds-tersembunyi').textContent = ok ? '(sudah diisi)' : '(belum diisi)';
        if (ok) n++;
      });
      document.getElementById('jmlCek').textContent = n;
      document.getElementById('barCek').style.width = Math.round(n / item.length * 100) + '%';
    }
    form.addEventListener('input', perbaruiCek);
    form.addEventListener('change', perbaruiCek);

    inputFoto.addEventListener('change', function () {
      var f = inputFoto.files && inputFoto.files[0];
      if (!f) return;
      var img = document.createElement('img');
      img.alt = 'Pratinjau foto';
      img.src = URL.createObjectURL(f);
      pratinjau.innerHTML = '';
      pratinjau.appendChild(img);
      document.getElementById('teksFoto').textContent = 'Ganti foto';
      if (hapusFoto) hapusFoto.checked = false;
    });

    // Cek isian wajib sebelum kirim, supaya tidak perlu bolak-balik ke server
    form.addEventListener('submit', function (e) {
      var kosong = [];
      if (!form.elements.nama_siswa.value.trim()) kosong.push('Nama lengkap');
      if (!form.querySelector('input[name="kelamin"]:checked')) kosong.push('Jenis kelamin');
      if (!form.querySelector('input[name="locked"]:checked')) kosong.push('Status siswa');
      var nisn = form.elements.nisn.value.trim();
      if (nisn && !/^[0-9]{10}$/.test(nisn)) kosong.push('NISN (harus 10 digit angka)');
      if (kosong.length) {
        e.preventDefault();
        alert('Lengkapi dulu: ' + kosong.join(', ') + '.');
        if (!form.elements.nama_siswa.value.trim()) form.elements.nama_siswa.focus();
      }
    });
  })();
</script>
<?= $this->endSection() ?>
