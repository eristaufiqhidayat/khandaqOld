<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_Youtube extends Model
{
    protected $DBGroup          = 'arafah';
    protected $table            = 'tbl_youtube';
    protected $primaryKey       = 'no';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\EYoutube::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no', 'alamat', 'descripsi', 'id_siswa'];

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

    public function get_Youtube($no)
    {
        $db = db_connect('arafah');
        $query = "select * from " .
            $this->table . "  where no = '$no'";
        $query = $db->query($query);
        return $query->getRowArray();
    }
}
