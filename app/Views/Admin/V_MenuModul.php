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
            <h3 class="card-title font-weight-bold">Menu &amp; Modul</h3><br>
            <small class="text-muted">Modul = kategori di sidebar. Hak akses modul dibuat otomatis, lalu diatur di halaman Group &amp; Hak Akses.</small>
          </div>
          <div class="ml-auto d-flex mt-2 mt-md-0">
            <input type="search" class="form-control form-control-sm mr-2" placeholder="Cari menu atau path..." data-cari="#daftarModul" style="max-width:220px">
            <button class="btn btn-primary btn-sm text-nowrap" data-toggle="modal" data-target="#mModul" data-judul-modul="Tambah modul"><i class="fas fa-plus"></i> Modul</button>
          </div>
        </div>
        <div class="card-body" id="daftarModul">
          <?php foreach ($modul as $m) : ?>
            <div class="card card-outline card-secondary mb-2">
              <div class="card-header py-2">
                <h3 class="card-title">
                  <i class="<?= esc($m['icon'], 'attr') ?> mr-1"></i>
                  <strong><?= esc($m['nama_module']) ?></strong>
                  <small class="text-muted ml-1">#<?= (int) $m['id_module'] ?> · <?= count($m['menus']) ?> menu</small>
                </h3>
                <div class="card-tools">
                  <button class="btn btn-tool" title="Ubah modul" data-toggle="modal" data-target="#mModul" data-judul-modul="Ubah modul"
                    data-isi="<?= esc(json_encode(['id_module' => $m['id_module'], 'nama_module' => $m['nama_module'], 'icon' => $m['icon']]), 'attr') ?>"><i class="fas fa-pencil-alt"></i></button>
                  <button class="btn btn-tool text-danger" title="Hapus modul" data-toggle="modal" data-target="#mHapusModul"
                    data-nama="<?= esc($m['nama_module'], 'attr') ?>" data-jumlah="<?= count($m['menus']) ?> menu"
                    data-isi="<?= esc(json_encode(['id_module' => $m['id_module']]), 'attr') ?>"><i class="fas fa-trash"></i></button>
                  <button class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                  <tbody>
                    <?php foreach ($m['menus'] as $mn) : ?>
                      <tr data-teks="<?= esc($m['nama_module'] . ' ' . $mn['menu'] . ' ' . $mn['path'], 'attr') ?>">
                        <td style="width:40%"><i class="<?= esc($mn['icon'], 'attr') ?> mr-1 text-muted"></i><?= esc($mn['menu']) ?></td>
                        <td><code><?= esc($mn['path']) ?></code></td>
                        <td class="text-right text-nowrap">
                          <button class="btn btn-xs btn-outline-secondary" data-toggle="modal" data-target="#mMenu" data-judul-menu="Ubah menu"
                            data-isi="<?= esc(json_encode(['id_menu' => $mn['id_menu'], 'id_module' => $mn['id_module'], 'menu' => $mn['menu'], 'path' => $mn['path'], 'icon' => $mn['icon']]), 'attr') ?>">Ubah</button>
                          <button class="btn btn-xs btn-outline-danger" data-toggle="modal" data-target="#mHapusMenu" data-nama="<?= esc($mn['menu'], 'attr') ?>"
                            data-isi="<?= esc(json_encode(['id_menu' => $mn['id_menu']]), 'attr') ?>">Hapus</button>
                        </td>
                      </tr>
                    <?php endforeach ?>
                    <tr>
                      <td colspan="3">
                        <button class="btn btn-xs btn-link" data-toggle="modal" data-target="#mMenu" data-judul-menu="Tambah menu di <?= esc($m['nama_module'], 'attr') ?>"
                          data-isi="<?= esc(json_encode(['id_module' => $m['id_module']]), 'attr') ?>"><i class="fas fa-plus"></i> Menu di <?= esc($m['nama_module']) ?></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          <?php endforeach ?>
          <?php if (!$modul) : ?><p class="text-muted mb-0">Belum ada modul.</p><?php endif ?>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modul: tambah / ubah -->
<div class="modal fade" id="mModul" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('index.php/module/simpan/' . $seg) ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id_module">
      <div class="modal-header">
        <h5 class="modal-title" data-judul="judul-modul" data-default="Modul"></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama modul</label>
          <input name="nama_module" class="form-control" required maxlength="100" placeholder="Tata Usaha">
        </div>
        <div class="form-group mb-0">
          <label>Icon</label>
          <input name="icon" class="form-control" maxlength="100" placeholder="fas fa-folder" pattern="[A-Za-z0-9 \-]+">
          <small class="text-muted">Kelas Font Awesome. Modul baru otomatis bisa dibuka group admin.</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modul: hapus -->
<div class="modal fade" id="mHapusModul" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('index.php/module/delete/' . $seg) ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id_module">
      <div class="modal-header">
        <h5 class="modal-title">Hapus modul <span data-judul="nama"></span>?</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">Ikut terhapus: <strong data-judul="jumlah"></strong> di dalamnya dan hak akses modul ini di semua group.</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-danger">Hapus</button>
      </div>
    </form>
  </div>
</div>

<!-- Menu: tambah / ubah -->
<div class="modal fade" id="mMenu" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('index.php/menu/simpan/' . $seg) ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id_menu">
      <div class="modal-header">
        <h5 class="modal-title" data-judul="judul-menu" data-default="Menu"></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Modul</label>
          <select name="id_module" class="form-control" required>
            <?php foreach ($modul as $m) : ?>
              <option value="<?= (int) $m['id_module'] ?>"><?= esc($m['nama_module']) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label>Nama menu</label>
          <input name="menu" class="form-control" required maxlength="100" placeholder="Data Siswa">
        </div>
        <div class="form-group">
          <label>Path</label>
          <input name="path" class="form-control" required maxlength="150" placeholder="datasiswa/index" pattern="[A-Za-z0-9_/\-]+">
          <small class="text-muted">Tanpa index.php dan tanpa id menu/modul di belakang; keduanya ditambahkan otomatis di sidebar.</small>
        </div>
        <div class="form-group mb-0">
          <label>Icon</label>
          <input name="icon" class="form-control" maxlength="100" placeholder="far fa-circle" pattern="[A-Za-z0-9 \-]+">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Menu: hapus -->
<div class="modal fade" id="mHapusMenu" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('index.php/menu/delete/' . $seg) ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id_menu">
      <div class="modal-header">
        <h5 class="modal-title">Hapus menu <span data-judul="nama"></span>?</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">Menu hilang dari sidebar semua group yang punya akses ke modulnya.</div>
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
