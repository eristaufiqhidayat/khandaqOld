<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_Formulir extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_formulir';
    protected $primaryKey    = 'no';
    protected $allowedFields = ['no', 'nama_siswa', 'alamat', 'telp', 'tanggal', 'nama_ortu', 'rp', 'keterangan', 'image', 'foto'];

    // Listing sub query
    public function listing($monthyear)
    {
        //$tahun = date('Y');
        if (!$monthyear) {
            $tahun = tahunajaran();
        } else {
            $tahun = $monthyear;
        }
        $tahun = tahunajaran();
        $tahun1 = $tahun + 1;
        $db = db_connect('arafah');
        // $sql = "SELECT 
        //         `no`,`nama_siswa`,`alamat`,`telp`,`tanggal`,`nama_ortu`,`rp`,`keterangan`,`image`,`foto`
		// 		FROM " . $this->table .
        //     " Where tanggal BETWEEN '$tahun-08-01' AND '$tahun1-07-30'";
            $sql = "SELECT 
                `no`,`nama_siswa`,`alamat`,`telp`,`tanggal`,`nama_ortu`,`rp`,`keterangan`,`foto`
				FROM " . $this->table;
        //echo $sql;
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
