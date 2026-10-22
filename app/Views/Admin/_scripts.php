<script src="<?= BPATH ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?= BPATH ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= BPATH ?>/asset/dist/js/adminlte.js"></script>
<script>
  // Isi form modal dari atribut data-* tombol yang membukanya.
  // Contoh: <button data-toggle="modal" data-target="#mMenu" data-isi='{"id_menu":3}'>
  $(document).on('show.bs.modal', '.modal', function(e) {
    var btn = $(e.relatedTarget), form = $(this).find('form');
    if (!btn.length || !form.length) return;
    form[0].reset();
    form.find('input[type=hidden]').not('[name="<?= csrf_token() ?>"]').val('');
    var isi = btn.data('isi') || {};
    $.each(isi, function(k, v) {
      var el = form.find('[name="' + k + '"]');
      if (el.is(':checkbox')) el.prop('checked', String(v) === '1');
      else el.val(v);
    });
    $(this).find('[data-judul]').each(function() {
      $(this).text(btn.data($(this).data('judul')) || $(this).data('default') || '');
    });
  });
  // Filter baris tabel/daftar: <input data-cari="#target"> menyaring elemen [data-teks] di dalam target
  $(document).on('input', '[data-cari]', function() {
    var q = this.value.toLowerCase();
    $($(this).data('cari')).find('[data-teks]').each(function() {
      $(this).toggle($(this).data('teks').toString().toLowerCase().indexOf(q) > -1);
    });
  });
</script>
