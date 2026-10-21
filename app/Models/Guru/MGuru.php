<?php

namespace App\Models\Guru;

use CodeIgniter\Model;

class MGuru extends Model
{
    protected $DBGroup          = 'arafah';
    protected $table            = 'data_guru';
    protected $primaryKey       = 'id_guru';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\EGuru::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_guru', 'nama_guru', 'nip', 'kelamin', 'alamat_guru', 'telpon_guru', 'username', 'password', 'locked', 'gelar', 'tempat_lahir', 'tanggal_lahir', 'agama', 'email', 'photo', 'nama_rek', 'bank_rek', 'no_rek'];

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

    public function JSONWALIKELAS($id_guru)
    {
        $periode = periodeaktif()['id_periode'];
        $db = db_connect('arafah');
        $sql = "SELECT * FROM `tbl_jadwal_mengajar` a 
        LEFT join setup_kelas b on a.id_kelas = b.id_kelas 
        left join data_guru c on a.id_guru = c.id_guru 
        left join setup_matapelajaran d on a.id_matapelajaran = d.id_matapelajaran
        left join setup_periode e on a.id_periode = e.id_periode
        where a.id_guru = '$id_guru' and a.id_periode = '$periode'
        order by a.hari desc
        ";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function JSONJADWAL($id_kelas = "")
    {
        (isset($id_kelas) && $id_kelas !== "") ? $where = "and b.id_kelas = '$id_kelas' " : $where = "";
        $periode = periodeaktif()['id_periode'];
        $db = db_connect('arafah');
        $sql = "SELECT a.id_guru,c.nama_guru,hari,b.nama_kelas, 
        (case when a.jam >='06:00' and a.jam < '09:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam08_00,
        (case when a.jam >='09:00' and a.jam < '10:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam09_00,
        (case when a.jam >='10:00' and a.jam < '11:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam10_00, 
        (case when a.jam >='11:00' and a.jam < '12:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam11_00, 
        (case when a.jam >='12:00' and a.jam < '13:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam12_00,        
        (case when a.jam >='13:00' and a.jam < '14:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam13_00,        
        (case when a.jam >='14:00' and a.jam < '15:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam14_00,    
        (case when a.jam >='15:00' and a.jam < '16:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam15_00, 
        (case when a.jam >='16:00' and a.jam < '17:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam16_00, 
        (case when a.jam >='17:00' and a.jam < '18:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam17_00 
        FROM `tbl_jadwal_mengajar` a 
        LEFT join setup_kelas b on a.id_kelas = b.id_kelas 
        left join data_guru c on a.id_guru = c.id_guru 
        left join setup_matapelajaran d on a.id_matapelajaran = d.id_matapelajaran 
        left join setup_periode e on a.id_periode = e.id_periode 
        where a.id_periode = '$periode' $where group by a.hari,a.id_kelas ORDER BY `b`.`nama_kelas` ASC
        ";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function JSONJADWALPERGURU($id_guru)
    {
        $periode = periodeaktif()['id_periode'];
        $db = db_connect('arafah');
        $sql = "SELECT a.id_guru,c.nama_guru,hari,b.nama_kelas, 
        (case when a.jam >='06:00' and a.jam < '09:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam08_00,
        (case when a.jam >='09:00' and a.jam < '10:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam09_00,
        (case when a.jam >='10:00' and a.jam < '11:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam10_00, 
        (case when a.jam >='11:00' and a.jam < '12:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam11_00, 
        (case when a.jam >='12:00' and a.jam < '13:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam12_00,        
        (case when a.jam >='13:00' and a.jam < '14:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam13_00,        
        (case when a.jam >='14:00' and a.jam < '15:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam14_00,    
        (case when a.jam >='15:00' and a.jam < '16:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam15_00, 
        (case when a.jam >='16:00' and a.jam < '17:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam16_00, 
        (case when a.jam >='17:00' and a.jam < '18:00' then concat(d.nama_matapelajaran,' jam ',a.jam) end) as jam17_00 
        FROM `tbl_jadwal_mengajar` a 
        LEFT join setup_kelas b on a.id_kelas = b.id_kelas 
        left join data_guru c on a.id_guru = c.id_guru 
        left join setup_matapelajaran d on a.id_matapelajaran = d.id_matapelajaran 
        left join setup_periode e on a.id_periode = e.id_periode 
        where a.id_periode = '$periode' and a.id_guru = '$id_guru'
        ";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function deletejadwal($id_jadwal)
    {
        $db = db_connect('arafah');
        $sql = "DELETE FROM tbl_jadwal_mengajar WHERE `tbl_jadwal_mengajar`.`id_jadwal` = '$id_jadwal'";
        $query = $db->query($sql);
    }
}
