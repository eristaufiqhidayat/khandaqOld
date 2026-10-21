<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class M_DataKodeTransaksi extends Model
{
    protected $DBGroup      = 'arafah';
    protected $table         = 'tbl_kode_transaksi';
    protected $primaryKey     = 'nokode';
    protected $allowedFields = [
        'nokode', 'kode', 'kode_tran', 'keterangan_kode'
    ];

    // Listing sub query
    public function listing($kode_tran, $group_name = "")
    {
        $db = db_connect('arafah');
        $kode = "";
        if ($group_name == "admintabungan" && $kode_tran == "D") $kode = " and kode = 'TDTNI' ";
        if ($group_name == "admintabungan" && $kode_tran == "K") $kode = " and kode  In('TKTNI','TKTAB') ";
        $sql = "SELECT * FROM " . $this->table . " where kode_tran = '" . $kode_tran . "' $kode order by kode";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function listing2($kode)
    {
        $db = db_connect('arafah');
        $sql = "SELECT * FROM " . $this->table . " where kode in(" . $kode . ") order by kode";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    // Detail
    public function detail($notransaksi)
    {
        $this->select('*');
        $this->where(array('notransaksi'    => $notransaksi));
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
        $this->where('notransaksi', $data['nokode']);
        $this->replace($data);
    }

    // Delete
    public function hapus($nokode)
    {
        $this->where('nokode', $nokode);
        $this->delete();
    }
}
