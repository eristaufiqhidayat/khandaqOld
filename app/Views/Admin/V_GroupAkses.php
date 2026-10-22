<?= $this->extend('Views\layout.php') ?>

<?= $this->section('main') ?>
<?php
$seg = (int) $menuAktip . '/' . (int) $moduleAktip;
$grp = null;
foreach ($groups as $g) {
  if ((int) $g['id'] === $dipilih) $grp = $g;
}
?>
<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <?= view('Admin/_flash') ?>
      <div class="row">
        <div class="col-md-4 col-lg-3">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title font-weight-bold">Group</h3>
              <button class="btn btn-primary btn-xs ml-auto" data-toggle="modal" data-target="#mGroup" data-judul-group="Tambah group"><i class="fas fa-plus"></i> Group</button>
            </div>
            <div class="list-group list-group-flush">
              <?php foreach ($groups as $g) : ?>
                <a href="<?= base_url('index.php/groups/index/' . $seg) . '?g=' . (int) $g['id'] ?>"
                  class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= (int) $g['id'] === $dipilih ? 'active' : '' ?>">
                  <span><?= esc($g['description'] ?: $g['name']) ?><br><small class="<?= (int) $g['id'] === $dipilih ? '' : 'text-muted' ?>"><?= esc($g['name']) ?></small></span>
                  <span class="badge badge-light"><?= (int) $g['jml_user'] ?> user</span>
                </a>
              <?php endforeach ?>
            </div>
          </div>
        </div>

        <div class="col-md-8 col-lg-9">
          <?php if ($grp) : ?>
            <form class="card" method="post" action="<?= base_url('index.php/groups/akses/' . $seg) ?>">
              <?= csrf_field() ?>
              <input type="hidden" name="group_id" value="<?= (int) $grp['id'] ?>">
              <div class="card-header d-flex flex-wrap align-items-center">
                <div>
                  <h3 class="card-title font-weight-bold">Hak akses <?= esc($grp['description'] ?: $grp['name']) ?></h3><br>
                  <small class="text-muted">Centang modul yang boleh dibuka. Semua menu di dalam modul ikut tampil di sidebar.</small>
                </div>
                <div class="ml-auto mt-2 mt-md-0">
                  <button type="button" class="btn btn-xs btn-outline-secondary" data-toggle="modal" data-target="#mGroup" data-judul-group="Ubah group"
                    data-isi="<?= esc(json_encode(['id' => $grp['id'], 'name' => $grp['name'], 'description' => $grp['description']]), 'attr') ?>">Ubah nama</button>
                  <?php if (!in_array($grp['name'], $terkunci, true)) : ?>
                    <button type="button" class="btn btn-xs btn-outline-danger" data-toggle="modal" data-target="#mHapusGroup"
                      data-isi="<?= esc(json_encode(['id' => $grp['id']]), 'attr') ?>">Hapus</button>
                  <?php endif ?>
                </div>
              </div>
              <div class="card-body">
                <div class="mb-2">
                  <button type="button" class="btn btn-xs btn-outline-secondary" onclick="$('.cek-modul').prop('checked', true)">Centang semua</button>
                  <button type="button" class="btn btn-xs btn-outline-secondary" onclick="$('.cek-modul').prop('checked', false)">Kosongkan</button>
                </div>
                <div class="row">
                  <?php foreach ($modul as $m) : ?>
                    <?php $on = in_array((int) $m['id_module'], $modulGroup, true); ?>
                    <div class="col-sm-6 col-xl-4 mb-2">
                      <div class="custom-control custom-checkbox border rounded p-2 pl-5 h-100">
                        <input type="checkbox" class="custom-control-input cek-modul" id="m<?= (int) $m['id_module'] ?>" name="modul[]" value="<?= (int) $m['id_module'] ?>" <?= $on ? 'checked' : '' ?>>
                        <label class="custom-control-label d-block" for="m<?= (int) $m['id_module'] ?>">
                          <i class="<?= esc($m['icon'], 'attr') ?> mr-1"></i><strong><?= esc($m['nama_module']) ?></strong><br>
                          <small class="text-muted"><?= $m['menus'] ? esc(implode(', ', array_column($m['menus'], 'menu'))) : 'Belum ada menu' ?></small>
                        </label>
                      </div>
                    </div>
                  <?php endforeach ?>
                </div>
                <?php if ($grp['name'] === 'admin') : ?>
                  <p class="text-muted small mb-0">Group admin tetap bisa membuka halaman admin lewat URL walaupun modul Admin tidak dicentang, tapi menunya hilang dari sidebar.</p>
                <?php endif ?>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary">Simpan hak akses</button>
              </div>
            </form>
          <?php else : ?>
            <div class="card"><div class="card-body text-muted">Belum ada group.</div></div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Group: tambah / ubah -->
<div class="modal fade" id="mGroup" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('index.php/groups/simpan/' . $seg) ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id">
      <div class="modal-header">
        <h5 class="modal-title" data-judul="judul-group" data-default="Group"></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Kode group</label>
          <input name="name" class="form-control" required maxlength="100" pattern="[a-z0-9_]+" placeholder="bendahara">
          <small class="text-muted">Huruf kecil, angka, garis bawah. Kode <?= esc(implode(', ', $terkunci)) ?> dipakai sistem dan tidak berubah walau diisi lain.</small>
        </div>
        <div class="form-group mb-0">
          <label>Nama tampilan</label>
          <input name="description" class="form-control" required maxlength="255" placeholder="Bendahara">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Group: hapus -->
<div class="modal fade" id="mHapusGroup" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('index.php/groups/delete/' . $seg) ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id">
      <div class="modal-header">
        <h5 class="modal-title">Hapus group <?= $grp ? esc($grp['description'] ?: $grp['name']) : '' ?>?</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">Hak akses group ini ikut dihapus. Group yang masih punya pengguna tidak bisa dihapus.</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-danger">Hapus</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<?= view('Admin/_scripts') ?>
<?= $this->endSection() ?>
