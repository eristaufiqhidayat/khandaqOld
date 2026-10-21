<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_Daftar extends Model
{
    protected $DBGroup          = 'daftar';
    protected $table            = 'tbl_daftar_baru';
    protected $primaryKey       = 'no';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\EDaftar::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no', 'email', 'nama', 'nohp', 'alamat', 'nama_siswa', 'tingkat', 'proses'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function get_Daftar($no)
    {
        $db = db_connect('daftar');
        $query = "select * from " .
            $this->table . "  where no = '$no'";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function deletejadwal($id_jadwal)
    {
        $db = db_connect('arafah');
        $sql = "DELETE FROM tbl_jadwal_mengajar WHERE `tbl_jadwal_mengajar`.`id_jadwal` = '$id_jadwal'";
        $query = $db->query($sql);
    }
}
