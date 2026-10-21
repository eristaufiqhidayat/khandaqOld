<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_Periode extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'setup_periode';
    protected $primaryKey    = 'id_periode';
    protected $allowedFields = ['id_periode', 'nama_semester', 'tahun_ajaran', 'semester', 'status_aktif'];

    // Listing sub query
    public function listing()
    {
        $db = db_connect('arafah');
        $sql = "SELECT id_periode, nama_semester, tahun_ajaran, semester, status_aktif
				FROM " . $this->table;
        $query = $db->query($sql);
        return $query->getResultArray();
    }

    // Detail
    public function detail($id_periode)
    {
        $this->select('*');
        $this->where(array('id_periode'    => $id_periode));
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
        $this->where('id_periode', $data['id_periode']);
        $this->replace($data);
    }

    // Delete
    public function hapus($data)
    {
        $this->where('id_periode', $data['id_periode']);
        $this->delete();
    }
}
