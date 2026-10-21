<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_TarifSpp extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_tarif_spp';
    protected $primaryKey    = 'no';
    protected $allowedFields = ['no', 'id_kelas', 'tarif', 'periode', 'tanggal'];
    // Listing sub query
    public function listing($id_periode)
    {
        if ($id_periode) $where = "where a.periode like '$id_periode'";
        else $where = "";
        $db = db_connect('arafah');
        $sql = "SELECT *
				FROM " . $this->table . " a " .
            "left join setup_kelas b on a.id_kelas = b.id_kelas
            left join setup_periode c on a.periode = c.id_periode
            $where
            ";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function dataKelas()
    {
        $db = db_connect('arafah');
        $query = $db->query("SELECT * from setup_kelas");
        return $query->getResult('array');
    }
    public function dataPeriode()
    {
        $db = db_connect('arafah');
        $query = $db->query("SELECT * FROM `setup_periode`");
        return $query->getResult('array');
    }
    public function dataSiswa($id_kelas)
    {
        $db = db_connect('arafah');
        $sql = "SELECT 	
        password,username,data_siswa.id_siswa,nama_siswa,nis,kelamin,alamat_siswa,tanggal_lahir,nisn,
        locked,setup_kelas.id_kelas,photo,tanggal_masuk,tempat_lahir,telpon_siswa,email,unik,image,nama_ortu,
        setup_kelas.nama_kelas,data_siswa.keterangan
        from data_siswa 
        left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
        left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
        where locked = 'no' and setup_kelas.id_kelas like '$id_kelas'";
        $query = $db->query($sql);
        //echo $sql;
        return $query->getResult('array');
    }
    public function periode($id_periode = "")
    {
        $db = db_connect('arafah');
        if ($id_periode) $where = "where id_periode = '$id_periode'";
        $query = $db->query("SELECT id_periode,nama_semester,tahun_ajaran,semester,status_aktif
		                     from setup_periode $where");
        return $query->getResult('array');
    }
    public function detail2($id_siswa)
    {
        $db = db_connect('arafah');
        $sql = "select `data_siswa`.`id_siswa`, `nama_siswa`, `nis`, `kelamin`, `alamat_siswa`, 
		`telpon_siswa`, `email`, `username`, `password`, `locked`, `id_periode`, `photo`, 
		`tanggal_masuk`, `tempat_lahir`, `tanggal_lahir`, `nama_ortu`, `nisn`, `keterangan`, 
		`unik`, `image`,`setup_kelas`.`nama_kelas`,`tbl_ruangan`.`id_kelas`  
		from data_siswa
		left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
		left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
		where data_siswa.locked  in('no','baru') and data_siswa.id_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function updateKelasPeriode($id_siswa, $id_kelas, $id_periode)
    {
        $db = db_connect('arafah');
        $sql = "INSERT INTO tbl_kelas_periode (id_siswa, id_kelas, id_periode) 
        VALUES($id_siswa, $id_kelas, $id_periode) ON DUPLICATE KEY UPDATE id_kelas = $id_kelas";
        $db->query($sql);
    }
    public function updateKelasRuangan($id_siswa, $id_kelas, $id_periode)
    {
        $db = db_connect('arafah');
        $sql = "INSERT INTO tbl_ruangan (id_siswa, id_kelas) 
        VALUES($id_siswa, $id_kelas) ON DUPLICATE KEY UPDATE id_kelas = $id_kelas";
        $db->query($sql);
    }
    // Detail
    public function detail($no)
    {
        $this->select('*');
        $this->where(array('id_siswa'    => $no));
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
