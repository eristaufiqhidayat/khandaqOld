<?php

namespace App\Models\TataUsaha;

use CodeIgniter\Model;

class M_Beasiswa extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_beasiswa';
    protected $primaryKey    = 'id_beasiswa';
    protected $allowedFields = ['id_beasiswa', 'id_siswa', 'peserta', 'persen', 'rp'];

    // Listing sub query
    public function listing()
    {
        $db = db_connect('arafah');
        $sql = "SELECT 
                `id_beasiswa`, `id_siswa`, `peserta`, `persen`,`rp`
				FROM " . $this->table;
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function dataSiswa()
    {
        $db = db_connect('arafah');
        $query = $db->query("SELECT 	
		                     password,username,data_siswa.id_siswa,nama_siswa,nis,kelamin,alamat_siswa,tanggal_lahir,nisn,
							 locked,id_periode,photo,tanggal_masuk,tempat_lahir,telpon_siswa,email,unik,nama_ortu,
							 setup_kelas.nama_kelas,data_siswa.keterangan
		                     from data_siswa 
							 left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
                        	 left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
							 where locked = 'no' and setup_kelas.nama_kelas != ''");
        return $query->getResult('array');
    }
    public function detail($id_beasiswa)
    {
        $this->select('*');
        $this->where(array('id_beasiswa'    => $id_beasiswa));
        $query = $this->get();
        return $query->getRowArray();
    }
    public function cekdataBeasiswa($id_siswa)
    {
        $db = db_connect('arafah');
        $sql = "SELECT id_siswa
				FROM " . $this->table .
            " Where id_siswa = '$id_siswa'";
        $query = $db->query($sql);
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
        $this->where('id_siswa', $data['id_siswa']);
        $this->replace($data);
    }

    // Delete
    public function hapus($id_siswa)
    {
        $this->where('id_siswa', $id_siswa);
        $this->delete();
    }
    public function kosongkantable()
    {
        $db      = \Config\Database::connect('arafah');
        $builder = $db->table($this->table);
        $builder->truncate();
    }
}
