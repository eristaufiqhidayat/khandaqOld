<?php

namespace App\Models\Whatsapp;

use CodeIgniter\Model;

class M_Myapp extends Model
{
    protected $DBGroup          = 'daftar';
    protected $table            = 'tbl_myapp';
    protected $primaryKey       = 'no';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\EMyapp::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no', 'appkey', 'authkey', 'message', 'vendor'];

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

    public function get_Myapp($no)
    {
        $db = db_connect('daftar');
        $query = "select * from " .
            $this->table . "  where no = '$no'";
        $query = $db->query($query);

        return $query->getRowArray();
    }

    public function get_Myapp2($no)
    {
        $db = db_connect('daftar');
        $query = "select * from " .
            $this->table . "  where no = '$no'";
        $query = $db->query($query);
        return $query->getResultArray();
    }
    public function myappsearch()
    {
        $db = db_connect('daftar');
        $query = "select * from " . $this->table;
        $query = $db->query($query);
        return $query->getResultArray();
    }
}
