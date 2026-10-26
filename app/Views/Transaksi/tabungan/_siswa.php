<?php
// Kartu siswa di atas halaman tabungan. Butuh: $siswa, $kode, $laundry; opsional $tombol (bool).
use App\Models\M_DataSiswa;

$kata    = preg_split('/\s+/', trim((string) $siswa['nama_siswa']));
$inisial = strtoupper(substr($kata[0] ?? '', 0, 1) . substr($kata[1] ?? '', 0, 1));
$status  = M_DataSiswa::STATUS[$siswa['locked']] ?? '';
$mm      = $menuAktip . '/' . $moduleAktip;
?>
<section class="ds-kartu" aria-label="Siswa" style="padding: 20px 24px; display: flex; flex-wrap: wrap; gap: 20px; align-items: center">
  <span aria-hidden="true" style="width: 64px; height: 64px; border-radius: 999px; background: #CCFBF1; color: #115E59; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 22px"><?= esc($inisial) ?></span>
  <div style="flex: 1 1 260px; display: flex; flex-direction: column; gap: 6px; min-width: 0">
    <div class="ds-baris" style="gap: 8px">
      <span style="font-size: 20px; font-weight: 800"><?= esc($siswa['nama_siswa']) ?></span>
      <?php if ($status) : ?><span class="ds-lencana ds-st-<?= esc($siswa['locked'], 'attr') ?>"><?= esc($status) ?></span><?php endif ?>
      <?php if ($laundry) : ?><span class="ds-lencana" style="background: #E0E7FF; color: #3730A3">Peserta laundry</span><?php endif ?>
    </div>
    <span style="font-size: 14px; color: #475569">
      NIS <?= esc($siswa['nis'] ?: '—') ?> · <?= esc($siswa['nama_kelas'] ?: 'Belum ada kelas') ?>
      · Kode tabungan <strong style="color: #0F172A"><?= esc($kode ?: 'belum ada') ?></strong>
    </span>
  </div>
  <?php if (! empty($tombol) && $kode) : ?>
    <div class="ds-baris">
      <a class="ds-tombol" style="border-color: #B45309; color: #92400E !important; background: #FFFFFF" href="<?= esc(base_url('index.php/transaksi/tabungan/tarik/' . $mm . '?siswa=' . (int) $siswa['id_siswa']), 'attr') ?>">
        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M6 13l6 6 6-6"/></svg>
        Tarik / bayar
      </a>
      <a class="ds-tombol ds-tombol-utama" href="<?= esc(base_url('index.php/transaksi/tabungan/setor/' . $mm . '?siswa=' . (int) $siswa['id_siswa']), 'attr') ?>">
        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5"/><path d="M6 11l6-6 6 6"/></svg>
        Setor
      </a>
    </div>
  <?php endif ?>
</section>
