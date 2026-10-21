<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_DU extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_daftar_ulang2';
    protected $primaryKey    = 'no';
    protected $allowedFields = ['no', 'jenis', 'id_siswa', 'tahunajaran', 'tanggal',  'rp', 'keterangan', 'bukti', 'semester'];

    // Listing sub query
    public function listing()
    {
        $tahun = date('Y');
        $tahun1 = $tahun + 1;
        $db = db_connect('arafah');
        $sql = "SELECT 
                `no`, `jenis`, `id_siswa`, `tahunajaran`, `tanggal`,  `rp`, `keterangan`, `bukti`,`semester`
				FROM " . $this->table .
            " Where tanggal BETWEEN '$tahun-07-01' AND '$tahun1-06-30'";
        $query = $db->query($sql);
        return $query->getResultArray();
    }

    // Detail
    public function detail($no)
    {
        $this->select('*');
        $this->where(array('no'    => $no));
        $query = $this->get();
        return $query->getRowArray();
    }
    public function readjsonDU($id_siswa)
    {
        $this->select('*');
        $this->where(array('id_siswa'    => $id_siswa));
        $query = $this->get();
        return $query->getResultArray();
    }
    // Insert
    public function tambah($data)
    {
        $this->save($data);
    }

    // Edit
    public function edit($data)
    {
        //var_dump($data);
        $this->where('no', $data['no']);
        $this->replace($data);
    }

    // Delete
    public function hapus($no)
    {
        $this->where('no', $no);
        $this->delete();
    }
}
