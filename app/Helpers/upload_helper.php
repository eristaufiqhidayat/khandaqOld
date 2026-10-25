<?php

use CodeIgniter\HTTP\Files\UploadedFile;

if (! defined('PESAN_GAMBAR_DITOLAK')) {
    define('PESAN_GAMBAR_DITOLAK', 'File tidak disimpan: harus berupa gambar JPG, PNG, atau WEBP.');
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
        if (! $file instanceof UploadedFile || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return '';
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

        $nama = $awalan . time() . '_' . bin2hex(random_bytes(4)) . '.' . $jenis[$mime];
        $file->move(rtrim($folder, '/\\'), $nama);

        return $nama;
    }
}
