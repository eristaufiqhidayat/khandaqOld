<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class M_DataPengeluaranUAS extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_pengeluaran_pas';
    protected $primaryKey    = 'no';
    protected $allowedFields = ['no', 'tanggal', 'kode_akun', 'kode_pengusul', 'rutin', 'rp', 'keterangan'];

    // Listing sub query
    public function listing($monthyear)
    {
        $db = db_connect('arafah');
        if ($monthyear) {
            $sql = "SELECT 
                no, tanggal, tbl_akun.kode_akun, tbl_akun.nama_akun,kode_pengusul, rutin, rp, keterangan
				FROM " . $this->table .
                " left join tbl_akun on " . $this->table . ".kode_akun = tbl_akun.kode_akun
                where DATE_FORMAT(tanggal, '%Y-%m') = '$monthyear'";
        } else {
            $sql = "SELECT 
            no, tanggal, tbl_akun.kode_akun, tbl_akun.nama_akun,kode_pengusul, rutin, rp, keterangan
            FROM " . $this->table .
                " left join tbl_akun on " . $this->table . ".kode_akun = tbl_akun.kode_akun";
        }
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function totalAll($monthyear)
    {
        $db = db_connect('arafah');
        $sql = "SELECT sum(rp) totalAll
				FROM " . $this->table . " where DATE_FORMAT(tanggal, '%Y-%m') = '$monthyear'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function totalRutin($monthyear)
    {
        $db = db_connect('arafah');
        $sql = "SELECT sum(rp) totalRutin
				FROM " . $this->table . " where DATE_FORMAT(tanggal, '%Y-%m') = '$monthyear' and rutin = 'RUTIN'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function totalNonRutin($monthyear)
    {
        $db = db_connect('arafah');
        $sql = "SELECT sum(rp) totalNonRutin
				FROM " . $this->table . " where DATE_FORMAT(tanggal, '%Y-%m') = '$monthyear' and rutin = 'NONRUTIN'";
        $query = $db->query($sql);
        return $query->getRowArray();
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
