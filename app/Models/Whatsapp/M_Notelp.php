<?php

namespace App\Models\Whatsapp;

use CodeIgniter\Model;

class M_Notelp extends Model
{
    protected $DBGroup          = 'daftar';
    protected $table            = 'tbl_nama_wa';
    protected $primaryKey       = 'no';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\EMessage::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no', 'nama', 'nohp', 'group'];

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

    public function get_Notelp($no)
    {
        $db = db_connect('daftar');
        $query = "select tbl_nama_wa.no,tbl_nama_wa.nama,tbl_nama_wa.nohp,tbl_nama_wa.group,tbl_groupwa.nama as namagroup from " .
            $this->table . " left join tbl_groupwa on tbl_nama_wa.group = tbl_groupwa.no  where tbl_nama_wa.no = '$no'";
        $query = $db->query($query);

        return $query->getRowArray();
    }
    public function get_Notelparray($no)
    {
        $db = db_connect('daftar');
        $query = "select tbl_nama_wa.no,tbl_nama_wa.nama,tbl_nama_wa.nohp,tbl_nama_wa.group,tbl_groupwa.nama as namagroup from " .
            $this->table . " left join tbl_groupwa on tbl_nama_wa.group = tbl_groupwa.no  where tbl_nama_wa.group = '$no'";

        $query = $db->query($query);
        return $query->getResultArray();
    }
    public function listing()
    {
        $db = db_connect('daftar');
        $query = "select tbl_nama_wa.no,tbl_nama_wa.nama,tbl_nama_wa.nohp,tbl_nama_wa.group,tbl_groupwa.nama as namagroup from " .
            $this->table . " left join tbl_groupwa on tbl_nama_wa.group = tbl_groupwa.no";
        $query = $db->query($query);

        return $query->getResultArray();
    }
    public function get_namawa($no)
    {
        $db = db_connect('daftar');
        $query = "SELECT * FROM `tbl_nama_wa` where tbl_nama_wa.group = '$no'";
        $query = $db->query($query);
        return $query->getResultArray();
    }
    public function get_message($no)
    {
        $db = db_connect('daftar');
        $query = "SELECT * FROM `tbl_message` where tbl_message.no = '$no'";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function get_myapp($no)
    {
        $db = db_connect('daftar');
        $query = "SELECT * FROM `tbl_myapp` where no = '$no'";
        $query = $db->query($query);
        return $query->getRowArray();
    }
}
