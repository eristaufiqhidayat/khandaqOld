<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses ditolak</title>
    <style>
        body { margin: 0; font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; background: #f4f6f9; color: #343a40; }
        .kotak { max-width: 480px; margin: 12vh auto; padding: 32px; background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,.12); text-align: center; }
        h1 { font-size: 22px; margin: 0 0 12px; }
        p { line-height: 1.5; margin: 0 0 24px; }
        a { display: inline-block; padding: 8px 18px; background: #001f3f; color: #fff; border-radius: 4px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="kotak">
        <h1>Akses ditolak</h1>
        <p><?= esc($pesan) ?></p>
        <a href="<?= esc(site_url('dashboard/0/0'), 'attr') ?>">Kembali ke Dashboard</a>
    </div>
</body>
</html>
