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
  <div id="peringatanPeriode" class="alert alert-warning d-flex flex-wrap align-items-center m-3" role="alert" style="gap:8px">
    <strong>Periode belum sesuai.</strong>
    <span class="mr-auto"><?= esc($peringatanPeriode) ?></span>
    <a class="btn btn-sm btn-dark" href="<?= base_url('index.php/TataUsaha/Periode/index/43/1') ?>">Atur periode</a>
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