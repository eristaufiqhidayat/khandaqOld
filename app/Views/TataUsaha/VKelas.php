<?= $this->extend('Views\layout.php') ?>
<?php
/** @var array $dataSiswa */
/** @var array $dataKelas */
/** @var int $jmlTanpaKelas */
/** @var array|null $dataPeriodeAktif */
/** @var string $id_kelas */
/** @var string $menuAktip */
/** @var string $moduleAktip */
?>
<?= $this->section('css') ?>
<link rel="stylesheet" href="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<style>
  .nk-muted { color: #5a6472; }
  .nk-table { font-size: 0.95rem; }
  .nk-table th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; color: #5a6472; }
  .nk-table td, .nk-table th { vertical-align: middle; }
  .nk-table input[type=checkbox] { width: 18px; height: 18px; }
  .nk-table tr.nk-pilih td { background: #eef3fb; }
  .nk-tanpa { color: #8a4600; font-weight: 600; }
</style>
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?php
$lihatSaja = $id_kelas === '';
$namaKelas = [];
foreach ($dataKelas as $k) $namaKelas[$k['id_kelas']] = $k['nama_kelas'];
if ($lihatSaja) $judulAsal = 'Semua kelas';
elseif ($id_kelas === '-') $judulAsal = 'Belum ada kelas';
else $judulAsal = 'Kelas ' . ($namaKelas[$id_kelas] ?? '');
$periodeLabel = labelPeriode($dataPeriodeAktif);
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex flex-wrap align-items-end justify-content-between">
      <div class="mb-2">
        <h1 class="m-0">Data Kelas Siswa</h1>
        <div class="nk-muted">Pindah / naik kelas<?= $periodeLabel ? ' · periode aktif ' . esc($periodeLabel) : '' ?></div>
      </div>
      <form id="formkelas" class="form-inline mb-2" action="<?= base_url('index.php/TataUsaha/Kelas/index/' . $menuAktip . '/' . $moduleAktip) ?>" method="get">
        <label for="id_kelas" class="mr-2 font-weight-bold">Kelas asal</label>
        <select id="id_kelas" name="id_kelas" class="form-control" style="min-width:220px" onchange="this.form.submit()">
          <option value="">Semua kelas (hanya lihat)</option>
          <?php foreach ($dataKelas as $k) { ?>
            <option value="<?= esc($k['id_kelas']) ?>" <?= (string) $k['id_kelas'] === $id_kelas ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?> (<?= $k['jml'] ?> siswa)</option>
          <?php } ?>
          <option value="-" <?= $id_kelas === '-' ? 'selected' : '' ?>>Belum ada kelas (<?= $jmlTanpaKelas ?>)</option>
        </select>
        <noscript><button class="btn btn-primary ml-2">Tampilkan</button></noscript>
      </form>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('sukses')) { ?>
        <div class="alert alert-success" role="status"><?= esc(session()->getFlashdata('sukses')) ?></div>
      <?php } ?>
      <?php if (session()->getFlashdata('gagal')) { ?>
        <div class="alert alert-danger" role="alert"><?= esc(session()->getFlashdata('gagal')) ?></div>
      <?php } ?>
      <?php if (!$dataPeriodeAktif) { ?>
        <div class="alert alert-danger">Belum ada periode aktif. Aktifkan periode dulu di menu Periode sebelum memindahkan siswa.</div>
      <?php } else { ?>
        <div class="alert alert-light border">
          Riwayat kelas akan dicatat ke periode aktif <strong><?= esc($periodeLabel) ?></strong>.
          Untuk kenaikan kelas tahun ajaran baru, pastikan periode tahun ajaran baru sudah diaktifkan dulu, supaya riwayat periode lama tidak tertimpa.
        </div>
      <?php } ?>
      <?php if ($lihatSaja) { ?>
        <div class="alert alert-info">Pilih <strong>kelas asal</strong> dulu untuk memindahkan siswa. Mode "Semua kelas" hanya untuk melihat, supaya siswa dari kelas berbeda tidak ikut terpindah bersamaan.</div>
      <?php } ?>

      <form id="formPindah" action="<?= base_url('index.php/TataUsaha/Kelas/update/' . $menuAktip . '/' . $moduleAktip) ?>" method="post">
        <input type="hidden" name="id_kelas" value="<?= esc($id_kelas) ?>">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title font-weight-bold"><?= esc($judulAsal) ?> · <?= count($dataSiswa) ?> siswa</h3>
          </div>
          <div id="infoPilih" class="px-3 py-2 border-bottom" style="display:none;background:#fdf6e8;color:#6b4a10">
            <span id="infoPilihTeks"></span>
            <button type="button" id="batalPilih" class="btn btn-link btn-sm p-0 ml-2 font-weight-bold">Batalkan pilihan</button>
          </div>
          <div class="card-body">
            <table id="tabelKelas" class="table table-sm nk-table" style="width:100%">
              <thead>
                <tr>
                  <th style="width:40px"><input type="checkbox" id="cekall" aria-label="Pilih semua siswa di kelas ini" <?= $lihatSaja ? 'disabled' : '' ?>></th>
                  <th>No</th>
                  <th>NIS</th>
                  <th>Nama siswa</th>
                  <th>Kelas sekarang</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($dataSiswa as $i => $s) { ?>
                  <tr>
                    <td><input type="checkbox" class="cek-siswa" value="<?= esc($s['id_siswa']) ?>" data-nama="<?= esc($s['nama_siswa']) ?>" aria-label="Pilih <?= esc($s['nama_siswa']) ?>" <?= $lihatSaja ? 'disabled' : '' ?>></td>
                    <td class="nk-muted"><?= $i + 1 ?></td>
                    <td><?= esc($s['nis']) ?></td>
                    <td class="font-weight-bold"><?= esc($s['nama_siswa']) ?></td>
                    <td><?= $s['nama_kelas'] !== null ? esc($s['nama_kelas']) : '<span class="nk-tanpa">Belum ada kelas</span>' ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer d-flex flex-wrap align-items-center" style="gap:12px">
            <div id="jmlPilih" class="font-weight-bold mr-auto">Belum ada siswa terpilih</div>
            <label for="id_kelasnew" class="mb-0">Pindahkan ke</label>
            <select id="id_kelasnew" name="id_kelasnew" class="form-control" style="width:auto;min-width:180px" <?= $lihatSaja ? 'disabled' : '' ?>>
              <option value="">— pilih kelas tujuan —</option>
              <?php foreach ($dataKelas as $k) {
                if ((string) $k['id_kelas'] === $id_kelas) continue; ?>
                <option value="<?= esc($k['id_kelas']) ?>"><?= esc($k['nama_kelas']) ?></option>
              <?php } ?>
            </select>
            <button type="button" id="bnaikkelas" class="btn btn-primary" disabled>Naik / pindah kelas</button>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>

<div class="modal fade" id="modalKonfirmasi" tabindex="-1" role="dialog" aria-labelledby="judulKonfirmasi" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="judulKonfirmasi"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Kelas sekarang siswa diganti, dan riwayat periode <?= esc($periodeLabel) ?> dicatat. Semua siswa disimpan dalam satu transaksi: kalau satu gagal, tidak ada yang berubah.</p>
        <p class="nk-muted small mb-0" id="namaKonfirmasi"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="simpanPindah">Ya, pindahkan</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>
<script>
  $(function() {
    var lihatSaja = <?= $lihatSaja ? 'true' : 'false' ?>;
    var asal = <?= json_encode($judulAsal) ?>.replace(/^Kelas /, '');
    var tabel = $('#tabelKelas').DataTable({
      pageLength: 50,
      autoWidth: false,
      order: [[1, 'asc']],
      columnDefs: [{ orderable: false, targets: 0 }],
      language: { search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ baris', info: 'Menampilkan _START_–_END_ dari _TOTAL_ siswa', infoEmpty: 'Tidak ada siswa', zeroRecords: 'Tidak ada siswa', paginate: { previous: '‹', next: '›' } }
    });
    // tabel.$() mencakup baris di semua halaman, bukan hanya yang tampil
    function semuaCek() { return tabel.$('input.cek-siswa'); }
    function terpilih() { return tabel.$('input.cek-siswa:checked'); }
    function segarkan() {
      var n = terpilih().length;
      semuaCek().each(function() { $(this).closest('tr').toggleClass('nk-pilih', this.checked); });
      $('#jmlPilih').text(n ? n + ' siswa terpilih' : 'Belum ada siswa terpilih');
      $('#cekall').prop('checked', n > 0 && n === semuaCek().length);
      var halaman = tabel.page.info().pages;
      $('#infoPilih').toggle(n > 0 && halaman > 1);
      $('#infoPilihTeks').text(n + ' siswa terpilih, termasuk yang ada di halaman lain. Semua ikut dipindahkan.');
      $('#bnaikkelas').prop('disabled', lihatSaja || n === 0 || !$('#id_kelasnew').val());
    }
    $('#tabelKelas').on('change', 'input.cek-siswa', segarkan);
    $('#cekall').on('change', function() { semuaCek().prop('checked', this.checked); segarkan(); });
    $('#batalPilih').on('click', function() { semuaCek().prop('checked', false); segarkan(); });
    $('#id_kelasnew').on('change', segarkan);
    $('#bnaikkelas').on('click', function() {
      var n = terpilih().length;
      var nama = terpilih().map(function() { return $(this).data('nama'); }).get();
      $('#judulKonfirmasi').text('Pindahkan ' + n + ' siswa dari ' + asal + ' ke ' + $('#id_kelasnew option:selected').text() + '?');
      $('#namaKonfirmasi').text(nama.join(', '));
      $('#modalKonfirmasi').modal('show');
    });
    $('#simpanPindah').on('click', function() {
      var form = $('#formPindah');
      form.find('input.kirim-siswa').remove();
      terpilih().each(function() {
        $('<input type="hidden" name="id_siswa[]" class="kirim-siswa">').val(this.value).appendTo(form);
      });
      $(this).prop('disabled', true);
      form.trigger('submit');
    });
    segarkan();
  });
</script>
<?= $this->endSection() ?>
