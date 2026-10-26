<?php

use CodeIgniter\HTTP\Files\UploadedFile;

if (! defined('PESAN_GAMBAR_DITOLAK')) {
    define('PESAN_GAMBAR_DITOLAK', 'File tidak disimpan: harus berupa gambar JPG, PNG, atau WEBP dengan ukuran maksimal ' . ini_get('upload_max_filesize') . '.');
}

if (! function_exists('cek_gambar_upload')) {
    /**
     * Cek file upload adalah gambar JPG/PNG/WEBP sungguhan (dari isinya, bukan
     * dari nama file kiriman user).
     *
     * @param UploadedFile|null $file hasil $this->request->getFile('nama_input')
     *
     * @return false|string|null ekstensi yang cocok dengan isi file ('jpg', 'png',
     *                           'webp'); null kalau tidak ada file yang diupload;
     *                           false kalau file ditolak
     */
    function cek_gambar_upload($file)
    {
        if (! $file instanceof UploadedFile || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if (! $file->isValid() || $file->hasMoved()) {
            return false;
        }

        $jenis = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];
        $mime = $file->getMimeType();
        if (! isset($jenis[$mime])) {
            return false;
        }
        $info = @getimagesize($file->getTempName());
        if ($info === false || ($info['mime'] ?? '') !== $mime) {
            return false;
        }

        return $jenis[$mime];
    }
}

if (! function_exists('simpan_gambar_upload')) {
    /**
     * Simpan gambar hasil upload (foto, bukti transfer) ke $folder dengan nama baru.
     *
     * Jenis file dicek dari isinya, bukan dari nama file kiriman user, dan ekstensi
     * file yang disimpan diambil dari jenis yang terdeteksi. Jadi file .php, .phtml,
     * .shtml, atau file PHP yang diberi nama .jpg tidak akan pernah tersimpan sebagai
     * file yang bisa dijalankan server.
     *
     * @param UploadedFile|null $file hasil $this->request->getFile('nama_input')
     *
     * @return false|string nama file yang disimpan; '' kalau tidak ada file yang
     *                      diupload; false kalau file ditolak
     */
    function simpan_gambar_upload($file, string $folder, string $awalan)
    {
        $ext = cek_gambar_upload($file);
        if ($ext === null) {
            return '';
        }
        if ($ext === false) {
            return false;
        }

        $nama = $awalan . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $file->move(rtrim($folder, '/\\'), $nama);

        return $nama;
    }
}

if (! function_exists('baca_gambar_upload')) {
    /**
     * Baca isi gambar hasil upload sebagai base64, untuk tabel yang menyimpan foto
     * langsung di database (misalnya data_siswa.image).
     *
     * @return false|string base64 isi gambar; '' kalau tidak ada file yang
     *                      diupload; false kalau file ditolak
     */
    function baca_gambar_upload($file)
    {
        $ext = cek_gambar_upload($file);
        if ($ext === null) {
            return '';
        }
        if ($ext === false) {
            return false;
        }

        return base64_encode((string) file_get_contents($file->getTempName()));
    }
}
