<?php

namespace App\Models\Nilai;

use CodeIgniter\Model;

class MMataPelajaran extends Model
{
    protected $DBGroup          = 'arafah';
    protected $table            = 'setup_matapelajaran';
    protected $primaryKey       = 'id_matapelajaran';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\EMataPelajaran::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_matapelajaran ', 'id_kelompok', 'nama_matapelajaran', 'kode_matapelajaran'];

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

    public function searchByidkelompok($id_kelompok)
    {
        (isset($id_kelompok) && $id_kelompok !== "") ? $where = "where setup_matapelajaran.id_kelompok = '$id_kelompok'" : $where = "";
        $db = db_connect('arafah');
        $sql = "SELECT * FROM setup_matapelajaran
        left join setup_kelompok_matpel on setup_matapelajaran.id_kelompok = setup_kelompok_matpel.id_kelompok
         $where";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResultObject();
    }
}
