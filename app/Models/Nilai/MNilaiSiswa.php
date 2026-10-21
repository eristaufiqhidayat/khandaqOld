<?php

namespace App\Models\Nilai;

use CodeIgniter\Model;

class MNilaiSiswa extends Model
{
    protected $DBGroup          = 'arafah';
    protected $table            = 'tbl_nilai';
    protected $primaryKey       = 'id_nilai';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\ENilaiSiswa::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_nilai', 'id_siswa', 'id_matapelajaran', 'id_guru', 'nilai_tugas', 'nilai_uts', 'nilai_uas', 'kunci', 'id_periode', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'H7', 'H8', 'K1', 'K2', 'K3', 'K4', 'K5', 'K6', 'K7', 'K8', 'HPKTS', 'HPKAS', 'perhitungan_nilai'];

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

    public function listing($id_kelas = "", $id_matapelajaran = "")
    {
        $periode = periodeaktif()['id_periode'];
        (isset($id_kelas) && $id_kelas !== "") ? $where = " and d.id_kelas = '$id_kelas' and a.id_matapelajaran ='$id_matapelajaran'" : $where = "";
        $db = db_connect('arafah');
        $sql = "SELECT  f.H AS NH,f.HPTS AS NHPTS,f.HPAS AS NHPAS,f.K AS NK,f.HPKTS AS NHPKTS,f.HPKAS AS NHPKAS,a.HPKTS,
        a.HPKAS,@rownum := @rownum + 1 AS  row_num ,a.id_nilai,a.id_siswa,e.nama_matapelajaran,
        d.id_kelas,d.nama_kelas, b.nama_siswa, a.id_matapelajaran, `id_guru`, `nilai_tugas`, `nilai_uts`, 
        `nilai_uas`, `kunci`, a.id_periode, `H1`, `H2`, `H3`, `H4`, `H5`, `H6`, `H7`, `H8`, 
        `K1`, `K2`, `K3`, `K4`, `K5`, `K6`, `K7`, `K8` FROM `tbl_nilai` a
        left join data_siswa b on a.id_siswa = b.id_siswa 
        left join tbl_ruangan c on a.id_siswa = c.id_siswa
        left join setup_kelas d on c.id_kelas = d.id_kelas
        left join setup_matapelajaran e on a.id_matapelajaran = e.id_matapelajaran
        left join tbl_perhitungan_nilai f on a.perhitungan_nilai = f.id,
        (SELECT @rownum := 0) r
        where a.id_periode ='$periode' and b.locked = 'no' 
         $where";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResultObject();
    }
}
