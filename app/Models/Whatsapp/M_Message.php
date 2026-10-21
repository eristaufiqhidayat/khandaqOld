<?php

namespace App\Models\Whatsapp;

use CodeIgniter\Model;

class M_Message extends Model
{
    protected $DBGroup          = 'daftar';
    protected $table            = 'tbl_message';
    protected $primaryKey       = 'no';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\EMessage::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no', 'message', 'device'];

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

    public function get_Message($no)
    {
        $db = db_connect('daftar');
        $query = "select * from " .
            $this->table . "  where no = '$no'";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function get_Log()
    {
        $db = db_connect('daftar');
        $query = "select * from tbl_log_status";
        $query = $db->query($query);
        return $query->getRowArray();
    }
}
