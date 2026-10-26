<?php

namespace App\Libraries;

/**
 * Foto kecil (thumbnail) siswa untuk halaman Data Siswa.
 *
 * Foto siswa disimpan sebagai base64 di data_siswa.image (ratusan KB per siswa).
 * Membacanya untuk setiap baris daftar membuat halaman lambat, jadi foto kecil
 * disimpan sekali di writable/cache/foto-siswa/ dan daftar cukup membaca file itu:
 * - {id}.img  : foto kecil (JPEG 240 px, atau foto asli bila GD tidak tersedia)
 * - {id}.none : penanda siswa tidak punya foto
 * Panggil lupakan($id) setiap kali foto siswa berubah atau siswa dihapus.
 */
class FotoSiswa
{
    private const SISI = 240;

    public static function folder(): string
    {
        $folder = WRITEPATH . 'cache/foto-siswa/';
        if (! is_dir($folder)) {
            @mkdir($folder, 0775, true);
        }

        return $folder;
    }

    public static function file(int $id): string
    {
        return self::folder() . $id . '.img';
    }

    public static function lupakan(int $id): void
    {
        @unlink(self::folder() . $id . '.img');
        @unlink(self::folder() . $id . '.none');
    }

    /**
     * Status foto beberapa siswa sekaligus.
     *
     * @param int[] $ids
     *
     * @return array<int, int> id => versi foto kecil (waktu file) atau 0 bila tidak ada foto
     */
    public static function status(array $ids): array
    {
        $hasil = [];
        $belum = [];
        foreach (array_unique(array_map('intval', $ids)) as $id) {
            if ($id <= 0) {
                continue;
            }
            $img = self::folder() . $id . '.img';
            if (is_file($img)) {
                $hasil[$id] = (int) filemtime($img);
            } elseif (is_file(self::folder() . $id . '.none')) {
                $hasil[$id] = 0;
            } else {
                $belum[] = $id;
            }
        }

        if ($belum) {
            // Hanya siswa yang belum punya cache yang dibaca fotonya dari database
            $rows = db_connect('arafah')->table('data_siswa')
                ->select('id_siswa, image')
                ->whereIn('id_siswa', $belum)
                ->get()->getResultArray();
            $ada = [];
            foreach ($rows as $r) {
                $ada[(int) $r['id_siswa']] = true;
                $hasil[(int) $r['id_siswa']] = self::simpan((int) $r['id_siswa'], $r['image']);
            }
            foreach ($belum as $id) {
                if (! isset($ada[$id])) {
                    $hasil[$id] = 0;
                }
            }
        }

        return $hasil;
    }

    /** Buat foto kecil dari isi base64; kembalikan versinya, atau 0 bila tidak ada foto. */
    private static function simpan(int $id, ?string $b64): int
    {
        $bin  = ($b64 !== null && $b64 !== '') ? base64_decode($b64, true) : false;
        $mime = $bin ? (new \finfo(FILEINFO_MIME_TYPE))->buffer($bin) : '';
        if (! $bin || ! in_array($mime, ['image/jpeg', 'image/png', 'image/webp', 'image/gif'], true)) {
            @touch(self::folder() . $id . '.none');

            return 0;
        }

        $isi = self::kecilkan($bin) ?? $bin;
        $img = self::folder() . $id . '.img';
        if (@file_put_contents($img, $isi, LOCK_EX) === false) {
            return 0;
        }

        return (int) filemtime($img);
    }

    /** Potong tengah jadi persegi dan perkecil; null bila GD tidak tersedia atau gagal. */
    private static function kecilkan(string $bin): ?string
    {
        if (! function_exists('imagecreatefromstring')) {
            return null;
        }
        $src = @imagecreatefromstring($bin);
        if (! $src) {
            return null;
        }
        $w    = imagesx($src);
        $h    = imagesy($src);
        $sisi = min($w, $h);
        $dst  = imagecreatetruecolor(self::SISI, self::SISI);
        imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255));
        imagecopyresampled($dst, $src, 0, 0, (int) (($w - $sisi) / 2), (int) (($h - $sisi) / 2), self::SISI, self::SISI, $sisi, $sisi);
        ob_start();
        imagejpeg($dst, null, 82);
        $hasil = ob_get_clean();
        imagedestroy($src);
        imagedestroy($dst);

        return $hasil ?: null;
    }
}
