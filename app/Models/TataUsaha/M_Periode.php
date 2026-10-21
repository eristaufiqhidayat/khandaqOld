<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_Periode extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'setup_periode';
    protected $primaryKey    = 'id_periode';
    protected $allowedFields = ['nama_semester', 'tahun_ajaran', 'semester', 'status_aktif'];

    // Tabel yang menyimpan data per periode: tabel => kolom periode
    private $terkait = [
        'tarif'  => ['tbl_tarif_spp' => 'periode'],
        'ruang'  => ['tbl_ruangan_periode' => 'id_periode'],
        'jadwal' => ['tbl_jadwal_mengajar' => 'id_periode'],
        'nilai'  => ['tbl_nilai' => 'id_periode', 'tbl_nilai_akhir' => 'id_periode'],
        'siswa'  => ['data_siswa' => 'id_periode'],
    ];

    // Daftar periode beserta jumlah data terkait di tiap tabel
    public function listing()
    {
        $db = db_connect('arafah');
        $rows = $db->query("SELECT id_periode, nama_semester, tahun_ajaran, semester, status_aktif
            FROM setup_periode ORDER BY tahun_ajaran DESC, semester DESC, id_periode DESC")->getResultArray();
        $jumlah = [];
        foreach ($this->terkait as $jenis => $tabel) {
            foreach ($tabel as $nama => $kolom) {
                if (!$db->tableExists($nama)) continue;
                foreach ($db->query("SELECT `$kolom` p, COUNT(*) jml FROM `$nama` GROUP BY `$kolom`")->getResultArray() as $r) {
                    $jumlah[$r['p']][$jenis] = ($jumlah[$r['p']][$jenis] ?? 0) + (int) $r['jml'];
                }
            }
        }
        foreach ($rows as &$row) {
            foreach (array_keys($this->terkait) as $jenis) {
                $row[$jenis] = $jumlah[$row['id_periode']][$jenis] ?? 0;
            }
        }
        unset($row);
        return $rows;
    }

    public function jumlahSiswaAktif()
    {
        $db = db_connect('arafah');
        return (int) $db->query("SELECT COUNT(*) jml FROM data_siswa WHERE locked = 'no'")->getRow()->jml;
    }

    public function detail($id_periode)
    {
        return $this->where('id_periode', $id_periode)->first();
    }

    public function sudahAda($tahunAjaran, $namaSemester)
    {
        return $this->where('tahun_ajaran', $tahunAjaran)->where('nama_semester', $namaSemester)->countAllResults() > 0;
    }

    public function tambah($data)
    {
        return $this->insert($data);
    }

    // Hanya satu periode aktif: semua dinonaktifkan lalu yang dipilih diaktifkan, dalam satu transaksi
    public function aktifkan($id_periode)
    {
        $db = db_connect('arafah');
        $db->transStart();
        $db->query("UPDATE setup_periode SET status_aktif = 'no' WHERE id_periode <> ?", [$id_periode]);
        $db->query("UPDATE setup_periode SET status_aktif = 'yes' WHERE id_periode = ?", [$id_periode]);
        $db->transComplete();
        return $db->transStatus();
    }

    // Jumlah data terkait (tarif, ruang, jadwal, nilai, siswa) untuk satu periode
    public function jumlahTerkait($id_periode)
    {
        $db = db_connect('arafah');
        $total = 0;
        foreach ($this->terkait as $tabel) {
            foreach ($tabel as $nama => $kolom) {
                if (!$db->tableExists($nama)) continue;
                $total += (int) $db->query("SELECT COUNT(*) jml FROM `$nama` WHERE `$kolom` = ?", [$id_periode])->getRow()->jml;
            }
        }
        return $total;
    }

    public function hapus($id_periode)
    {
        return $this->delete($id_periode);
    }

    // Salin kelas sekarang (tbl_ruangan) ke periode, hanya untuk siswa aktif yang belum tercatat di periode itu
    public function prosesRuang($id_periode)
    {
        $db = db_connect('arafah');
        $db->query("INSERT INTO tbl_ruangan_periode (id_siswa, id_kelas, id_periode)
            SELECT r.id_siswa, MAX(r.id_kelas), ?
            FROM tbl_ruangan r
            INNER JOIN data_siswa s ON s.id_siswa = r.id_siswa
            WHERE s.locked = 'no'
              AND NOT EXISTS (SELECT 1 FROM tbl_ruangan_periode x WHERE x.id_siswa = r.id_siswa AND x.id_periode = ?)
            GROUP BY r.id_siswa", [$id_periode, $id_periode]);
        return $db->affectedRows();
    }
}
