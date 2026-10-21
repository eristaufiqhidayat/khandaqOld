<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_TarifSpp extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_tarif_spp';
    protected $primaryKey    = 'no';
    protected $allowedFields = ['no', 'id_kelas', 'tarif', 'periode', 'tanggal'];

    // Semua periode, terbaru di atas (Genap setelah Ganjil dalam satu tahun ajaran),
    // beserta jumlah kelas yang sudah punya tarif
    public function dataPeriode()
    {
        $db = db_connect('arafah');
        return $db->query("SELECT p.id_periode, p.nama_semester, p.tahun_ajaran, p.semester, p.status_aktif,
                (SELECT COUNT(DISTINCT t.id_kelas) FROM tbl_tarif_spp t WHERE t.periode = p.id_periode) jml_tarif
            FROM setup_periode p
            ORDER BY p.tahun_ajaran DESC, CASE p.semester WHEN 'genap' THEN 0 ELSE 1 END, p.id_periode DESC")->getResultArray();
    }

    public function dataKelas()
    {
        $db = db_connect('arafah');
        return $db->query("SELECT id_kelas, nama_kelas FROM setup_kelas ORDER BY id_kelas")->getResultArray();
    }

    // Tarif per periode per kelas: [id_periode => [id_kelas => tarif]].
    // Kalau satu kelas punya lebih dari satu tarif di periode yang sama, dipakai yang terakhir dicatat.
    public function petaTarif()
    {
        $db = db_connect('arafah');
        $peta = [];
        foreach ($db->query("SELECT periode, id_kelas, tarif FROM tbl_tarif_spp ORDER BY no")->getResultArray() as $r) {
            $peta[$r['periode']][$r['id_kelas']] = (int) $r['tarif'];
        }
        return $peta;
    }

    // Kelas yang tarifnya tercatat lebih dari sekali di satu periode
    public function kelasGanda($id_periode)
    {
        $db = db_connect('arafah');
        return array_column($db->query("SELECT id_kelas FROM tbl_tarif_spp WHERE periode = ?
            GROUP BY id_kelas HAVING COUNT(*) > 1", [$id_periode])->getResultArray(), 'id_kelas');
    }

    public function periodeAda($id_periode)
    {
        $db = db_connect('arafah');
        return $db->query("SELECT id_periode FROM setup_periode WHERE id_periode = ?", [$id_periode])->getRowArray() !== null;
    }

    // Simpan tarif satu periode sekaligus: $tarif = [id_kelas => angka atau null].
    // null menghapus tarif kelas itu. Satu kelas hanya punya satu baris per periode
    // (baris ganda dibereskan). Mengembalikan jumlah kelas yang berubah, atau false kalau gagal.
    public function simpanPeriode($id_periode, array $tarif)
    {
        $db = db_connect('arafah');
        $lama = [];
        foreach ($db->query("SELECT no, id_kelas, tarif FROM tbl_tarif_spp WHERE periode = ? ORDER BY no", [$id_periode])->getResultArray() as $r) {
            $lama[$r['id_kelas']][] = $r;
        }
        $berubah = 0;
        $db->transStart();
        foreach ($tarif as $id_kelas => $nilai) {
            $baris = $lama[$id_kelas] ?? [];
            if ($nilai === null) {
                if ($baris) {
                    $db->query("DELETE FROM tbl_tarif_spp WHERE periode = ? AND id_kelas = ?", [$id_periode, $id_kelas]);
                    $berubah++;
                }
                continue;
            }
            if (!$baris) {
                $db->query("INSERT INTO tbl_tarif_spp (id_kelas, tarif, periode, tanggal) VALUES (?, ?, ?, ?)",
                    [$id_kelas, $nilai, $id_periode, date('Y-m-d')]);
                $berubah++;
                continue;
            }
            $simpan = array_pop($baris);
            foreach ($baris as $ganda) {
                $db->query("DELETE FROM tbl_tarif_spp WHERE no = ?", [$ganda['no']]);
            }
            if ((int) $simpan['tarif'] !== $nilai) {
                $db->query("UPDATE tbl_tarif_spp SET tarif = ?, tanggal = ? WHERE no = ?", [$nilai, date('Y-m-d'), $simpan['no']]);
                $berubah++;
            } elseif ($baris) {
                $berubah++;
            }
        }
        $db->transComplete();
        return $db->transStatus() ? $berubah : false;
    }
}
