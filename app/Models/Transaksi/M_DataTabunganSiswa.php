<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class M_DataTabunganSiswa extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_tabungan_siswa';
    protected $primaryKey    = 'no';
    protected $allowedFields = [
        'no', 'kode_siswa', 'kode_tab', 'tanggal', 'kode_transaksi', 'tanggal_transaksi', 'rp_transaksi', 'rp',
        'kredit_tab', 'debit_tab', 'keterangan', 'kode_unik'
    ];

    // Listing sub query
    public function listing()
    {
        $db = db_connect('arafah');
        $sql = "SELECT 
                'no', 'kode_siswa', 'kode_tab', 'tanggal','kode_transaksi','tanggal_transaksi', 'rp_transaksi','rp', 
                'kredit_tab','debit_tab','keterangan', 'kode_unik'
				FROM " . $this->table;
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
