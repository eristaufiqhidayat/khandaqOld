<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_Kelas extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_ruangan_periode';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['id_siswa', 'id_kelas', 'id_periode'];

    public function dataKelas()
    {
        $db = db_connect('arafah');
        return $db->query("SELECT k.id_kelas, k.nama_kelas, COUNT(DISTINCT s.id_siswa) jml
            FROM setup_kelas k
            LEFT JOIN tbl_ruangan r ON r.id_kelas = k.id_kelas
            LEFT JOIN data_siswa s ON s.id_siswa = r.id_siswa AND s.locked = 'no'
            GROUP BY k.id_kelas, k.nama_kelas
            ORDER BY k.nama_kelas")->getResultArray();
    }

    public function jumlahTanpaKelas()
    {
        $db = db_connect('arafah');
        $row = $db->query("SELECT COUNT(*) jml FROM data_siswa s
            WHERE s.locked = 'no' AND NOT EXISTS (
                SELECT 1 FROM tbl_ruangan r JOIN setup_kelas k ON k.id_kelas = r.id_kelas
                WHERE r.id_siswa = s.id_siswa)")->getRowArray();
        return (int) ($row['jml'] ?? 0);
    }

    public function dataPeriodeAktif()
    {
        $db = db_connect('arafah');
        return $db->query("SELECT * FROM setup_periode WHERE status_aktif = 'yes' ORDER BY id_periode DESC LIMIT 1")->getRowArray();
    }

    // $id_kelas: '' = semua kelas, '-' = siswa yang belum punya kelas
    public function dataSiswa($id_kelas = '')
    {
        $db = db_connect('arafah');
        $sql = "SELECT s.id_siswa, s.nama_siswa, s.nis, k.id_kelas, k.nama_kelas
            FROM data_siswa s
            LEFT JOIN (SELECT id_siswa, MAX(id_kelas) id_kelas FROM tbl_ruangan GROUP BY id_siswa) r ON r.id_siswa = s.id_siswa
            LEFT JOIN setup_kelas k ON k.id_kelas = r.id_kelas
            WHERE s.locked = 'no'";
        $bind = [];
        if ($id_kelas === '-') {
            $sql .= " AND k.id_kelas IS NULL";
        } elseif ($id_kelas !== '') {
            $sql .= " AND k.id_kelas = ?";
            $bind[] = $id_kelas;
        }
        $sql .= " ORDER BY k.nama_kelas, s.nama_siswa";
        return $db->query($sql, $bind)->getResultArray();
    }

    public function kelasAda($id_kelas)
    {
        $db = db_connect('arafah');
        return $db->query("SELECT id_kelas FROM setup_kelas WHERE id_kelas = ?", [$id_kelas])->getRowArray() !== null;
    }

    // Pindahkan siswa ke kelas baru: kelas sekarang (tbl_ruangan) dan riwayat periode aktif (tbl_ruangan_periode).
    // Semua dalam satu transaksi; mengembalikan jumlah siswa yang dipindahkan, atau false kalau gagal.
    public function pindahKelas(array $idSiswa, $idKelasBaru, $idPeriode)
    {
        $db = db_connect('arafah');
        $db->transStart();
        foreach ($idSiswa as $id) {
            $ada = $db->query("SELECT 1 FROM tbl_ruangan WHERE id_siswa = ?", [$id])->getRowArray();
            if ($ada) {
                $db->query("UPDATE tbl_ruangan SET id_kelas = ? WHERE id_siswa = ?", [$idKelasBaru, $id]);
            } else {
                $db->query("INSERT INTO tbl_ruangan (id_siswa, id_kelas) VALUES (?, ?)", [$id, $idKelasBaru]);
            }
            $ada = $db->query("SELECT 1 FROM tbl_ruangan_periode WHERE id_siswa = ? AND id_periode = ?", [$id, $idPeriode])->getRowArray();
            if ($ada) {
                $db->query("UPDATE tbl_ruangan_periode SET id_kelas = ? WHERE id_siswa = ? AND id_periode = ?", [$idKelasBaru, $id, $idPeriode]);
            } else {
                $db->query("INSERT INTO tbl_ruangan_periode (id_siswa, id_kelas, id_periode) VALUES (?, ?, ?)", [$id, $idKelasBaru, $idPeriode]);
            }
        }
        $db->transComplete();
        return $db->transStatus() ? count($idSiswa) : false;
    }
}
