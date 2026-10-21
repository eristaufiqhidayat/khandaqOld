<!--
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
-->
<?php $peringatanPeriode = peringatanPeriode(); ?>
<?php if ($peringatanPeriode) { ?>
  <!-- Peringatan periode (admin): dipindah ke atas konten halaman -->
  <div id="peringatanPeriode" class="alert alert-warning d-flex flex-wrap align-items-start m-3" role="alert" style="gap:8px">
    <div class="mr-auto">
      <strong><?= esc($peringatanPeriode['judul']) ?></strong> Langkah yang belum dikerjakan:
      <ul class="mb-0 pl-3" style="list-style:none">
        <?php foreach ($peringatanPeriode['langkah'] as $l) { ?><li><?= esc($l) ?></li><?php } ?>
      </ul>
    </div>
    <a class="btn btn-sm btn-dark" href="<?= base_url('index.php/TataUsaha/Periode/index/43/1') ?>">Atur periode</a>
    <a class="btn btn-sm btn-outline-dark" href="<?= base_url('index.php/TataUsaha/Kelas/index/44/1') ?>">Naik kelas</a>
    <button type="button" class="close ml-2" aria-label="Tutup" onclick="this.parentNode.remove()"><span aria-hidden="true">&times;</span></button>
  </div>
  <script>
    (function() {
      var el = document.getElementById('peringatanPeriode');
      var konten = document.querySelector('.content-wrapper');
      if (el && konten) konten.insertBefore(el, konten.firstChild);
    })();
  </script>
<?php } ?>
</div>
</body>
</html>