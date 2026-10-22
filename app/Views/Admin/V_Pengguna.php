<?= $this->extend('Views\layout.php') ?>

<?= $this->section('main') ?>
<?php $seg = (int) $menuAktip . '/' . (int) $moduleAktip; ?>
<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <?= view('Admin/_flash') ?>
      <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center">
          <div>
            <h3 class="card-title font-weight-bold">Pengguna</h3><br>
            <small class="text-muted">Akun dan group-nya. Password tidak ditampilkan; ganti lewat Reset password.</small>
          </div>
          <div class="ml-auto d-flex mt-2 mt-md-0">
            <input type="search" class="form-control form-control-sm mr-2" placeholder="Cari username / email / group..." data-cari="#tPengguna" style="max-width:240px">
            <button class="btn btn-primary btn-sm text-nowrap" data-toggle="modal" data-target="#mTambah"><i class="fas fa-plus"></i> Pengguna</button>
          </div>
        </div>
        <div class="card-body p-0 table-responsive">
          <table class="table table-sm table-hover mb-0" id="tPengguna">
            <thead>
              <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Group</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $u) : ?>
                <tr data-teks="<?= esc($u['username'] . ' ' . $u['email'] . ' ' . $u['group_desc'] . ' ' . $u['group_name'], 'attr') ?>">
                  <td><strong><?= esc($u['username']) ?></strong></td>
                  <td><?= esc($u['email']) ?></td>
                  <td>
                    <?php if ($u['group_id']) : ?>
                      <span class="badge badge-info" title="<?= esc($u['group_name'], 'attr') ?>"><?= esc($u['group_desc'] ?: $u['group_name']) ?></span>
                    <?php else : ?>
                      <span class="badge badge-light">tanpa group</span>
                    <?php endif ?>
                  </td>
                  <td><?= $u['active'] ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Nonaktif</span>' ?></td>
                  <td class="text-right text-nowrap">
                    <button class="btn btn-xs btn-outline-secondary" data-toggle="modal" data-target="#mUbah" data-nama="<?= esc($u['username'], 'attr') ?>"
                      data-isi="<?= esc(json_encode(['id' => $u['id'], 'email' => $u['email'], 'group_id' => $u['group_id'], 'active' => $u['active'] ? 1 : 0]), 'attr') ?>">Ubah</button>
                    <button class="btn btn-xs btn-outline-secondary" data-toggle="modal" data-target="#mReset" data-nama="<?= esc($u['username'], 'attr') ?>"
                      data-isi="<?= esc(json_encode(['id' => $u['id']]), 'attr') ?>">Reset password</button>
                    <?php if ((int) $u['id'] !== (int) user_id()) : ?>
                      <button class="btn btn-xs btn-outline-danger" data-toggle="modal" data-target="#mHapus" data-nama="<?= esc($u['username'], 'attr') ?>"
                        data-isi="<?= esc(json_encode(['id' => $u['id']]), 'attr') ?>">Hapus</button>
                    <?php endif ?>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-muted small"><?= count($users) ?> pengguna</div>
      </div>
    </div>
  </section>
</div>

<?php $pilihanGroup = function () use ($groups) {
  foreach ($groups as $g) {
    echo '<option value="' . (int) $g['id'] . '">' . esc($g['description'] ?: $g['name']) . ' (' . esc($g['name']) . ')</option>';
  }
}; ?>

<!-- Tambah -->
<div class="modal fade" id="mTambah" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('index.php/users/tambah/' . $seg) ?>" autocomplete="off">
      <?= csrf_field() ?>
      <div class="modal-header">
        <h5 class="modal-title">Tambah pengguna</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group"><label>Username</label><input name="username" class="form-control" required minlength="3" maxlength="30"></div>
        <div class="form-group"><label>Email</label><input name="email" type="email" class="form-control" required></div>
        <div class="form-group"><label>Group</label><select name="group_id" class="form-control" required><?php $pilihanGroup() ?></select></div>
        <div class="form-group"><label>Password</label><input name="password" type="password" class="form-control" required minlength="8" autocomplete="new-password"><small class="text-muted">Minimal 8 karakter.</small></div>
        <div class="form-group mb-0"><label>Ulangi password</label><input name="pass_confirm" type="password" class="form-control" required minlength="8" autocomplete="new-password"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Ubah -->
<div class="modal fade" id="mUbah" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('index.php/users/edit/' . $seg) ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id">
      <div class="modal-header">
        <h5 class="modal-title">Ubah <span data-judul="nama"></span></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group"><label>Email</label><input name="email" type="email" class="form-control" required></div>
        <div class="form-group"><label>Group</label><select name="group_id" class="form-control" required><?php $pilihanGroup() ?></select></div>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="aktif" name="active" value="1">
          <label class="custom-control-label" for="aktif">Akun aktif (bisa login)</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Reset password -->
<div class="modal fade" id="mReset" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('index.php/users/reset/' . $seg) ?>" autocomplete="off">
      <?= csrf_field() ?>
      <input type="hidden" name="id">
      <div class="modal-header">
        <h5 class="modal-title">Reset password <span data-judul="nama"></span></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group"><label>Password baru</label><input name="password" type="password" class="form-control" required minlength="8" autocomplete="new-password"></div>
        <div class="form-group mb-0"><label>Ulangi password</label><input name="pass_confirm" type="password" class="form-control" required minlength="8" autocomplete="new-password"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary">Reset</button>
      </div>
    </form>
  </div>
</div>

<!-- Hapus -->
<div class="modal fade" id="mHapus" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('index.php/users/delete/' . $seg) ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id">
      <div class="modal-header">
        <h5 class="modal-title">Hapus <span data-judul="nama"></span>?</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">Akun dan keanggotaan group-nya dihapus permanen.</div>
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
