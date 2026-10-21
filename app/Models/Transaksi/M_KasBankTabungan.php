<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class M_KasBankTabungan extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_tabungan_kasbank';
    protected $primaryKey    = 'no';
    protected $allowedFields = ['no', 'jenis', 'tanggal',  'rp', 'keterangan'];


    // Listing sub query
    public function listing()
    {

        $db = db_connect('arafah');
        $sql = "SELECT 
                `no`, `jenis`,  `tanggal`,  `rp`, `keterangan`
				FROM " . $this->table . " order by no desc";
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
