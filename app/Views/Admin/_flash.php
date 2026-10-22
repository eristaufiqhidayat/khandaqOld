<?php if (session('error')) : ?>
  <div class="alert alert-danger alert-dismissible">
    <?= esc(session('error')) ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
  </div>
<?php endif ?>
<?php if (session('msg')) : ?>
  <div class="alert alert-success alert-dismissible">
    <?= esc(session('msg')) ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
  </div>
<?php endif ?>
