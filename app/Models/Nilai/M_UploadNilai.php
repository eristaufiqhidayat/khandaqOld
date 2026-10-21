<?php

namespace App\Models\Nilai;

use CodeIgniter\Model;

class M_UploadNilai extends Model
{
    protected $DBGroup       = 'arafah';
    protected $table         = 'tbl_nilai_akhir';
    protected $primaryKey    = 'id_nilai';
    protected $allowedFields = ['id_nilai', 'id_siswa', 'image', 'mime', 'id_periode', 'keterangan'];

    // Listing sub query
    public function listing($id_siswa)
    {
        $tahun = date('Y');
        $tahun1 = $tahun - 1;
        $db = db_connect('arafah');
        $sql = "SELECT 
                id_nilai,data_siswa.id_siswa,nama_siswa,nama_kelas,tahun_ajaran,nama_semester,semester,tbl_nilai_akhir.image
				FROM " . $this->table .
            " join (select @no:=0) r
            left join data_siswa on tbl_nilai_akhir.id_siswa = data_siswa.id_siswa
            left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
            left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
            left join setup_periode on tbl_nilai_akhir.id_periode = setup_periode.id_periode
            where data_siswa.locked = 'no' and data_siswa.id_siswa = '$id_siswa'";
        //echo $sql;
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
        // $query = $db->query("SELECT 	
		//                      password,username,data_siswa.id_siswa,nama_siswa,nis,kelamin,alamat_siswa,tanggal_lahir,nisn,
		// 					 locked,id_periode,photo,tanggal_masuk,tempat_lahir,telpon_siswa,email,unik,image,nama_ortu,
		// 					 setup_kelas.nama_kelas,data_siswa.keterangan
		//                      from data_siswa 
		// 					 left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
        //                 	 left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
		// 					 where locked = 'no' and setup_kelas.nama_kelas != ''");
        return $query->getResult('array');
    }
    public function periode($id_periode="")
    {
        $where = '';
        $db = db_connect('arafah');
        if($id_periode)$where = "where id_periode = '$id_periode'";
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
