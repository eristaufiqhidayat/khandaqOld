<?= $this->extend('Views\layout.php') ?>
<?= $this->section('main') ?>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <h2 class="card-header"><?= lang('Auth.resetYourPassword') ?></h2>
                <div class="card-body">
                    <?= view('Myth\Auth\Views\_message_block') ?>
                    <p><?= lang('Auth.enterCodeEmailPassword') ?></p>

                    <form action="<?php echo base_url(); ?>/index.php/users/cpassdo/10/2" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" class="form-control" name="username" value="<?= user()->username; ?>">
                        <div class="form-group">
                            <label for="password"><?= lang('Auth.newPassword') ?></label>
                            <input type="password" class="form-control" name="password_hash">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass_confirm"><?= lang('Auth.newPasswordRepeat') ?></label>
                            <input type="password" class="form-control" name="pass_confirm">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.resetPassword') ?></button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<!-- jQuery -->
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.js"></script>

<?= $this->endSection() ?>