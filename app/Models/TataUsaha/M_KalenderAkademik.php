<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_KalenderAkademik extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_kalender_akedemik';
    protected $primaryKey    = 'no';
    protected $allowedFields = ['no', 'tanggal', 'kegiatan'];

    // Listing sub query
    public function listing()
    {
        $db = db_connect('arafah');
        $sql = "SELECT no, tanggal, kegiatan
				FROM " . $this->table;
        $query = $db->query($sql);
        return $query->getResultArray();
    }

    // Detail
    public function detail($id_periode)
    {
        $this->select('*');
        $this->where(array('no'    => $id_periode));
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
        $this->where('no', $data['no']);
        $this->replace($data);
    }

    // Delete
    public function hapus($data)
    {
        $this->where('no', $data['no']);
        $this->delete();
    }
}
