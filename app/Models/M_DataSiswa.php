<?php

namespace App\Models;

use CodeIgniter\Model;

class M_DataSiswa extends Model
{
	protected $DBGroup      = 'arafah';
	protected $table 		= 'data_siswa';
	protected $primaryKey 	= 'id_siswa';
	protected $allowedFields = [
		'id_siswa', 'nama_siswa', 'nis', 'kelamin', 'alamat_siswa', 'telpon_siswa', 'email',
		'username', 'password', 'locked', 'id_periode', 'photo', 'tanggal_masuk', 'tempat_lahir',
		'tanggal_lahir', 'nama_ortu', 'nisn', 'keterangan', 'unik', 'image'
	];


	// Listing
	public function listing()
	{
		//$db = db_connect('arafah');
		$this->select('*');
		$query = $this->getWhere(['locked' => 'no']);
		return $query->getResultArray();

		//return 'Ini adalah Method getData didalam ProductModel';
	}
	public function listing2($nama_siswa, $locked = "")
	{
		$db = db_connect('arafah');
		if ($locked) {
			$qlocked = "locked in('$locked')";
			$nama_siswa = "%";
		} else {
			$qlocked = "locked in( 'no','baru')";
			if (!$nama_siswa) $nama_siswa = "%";
		}
		$sql = "SELECT 	
		password,username,data_siswa.id_siswa,nama_siswa,nis,kelamin,alamat_siswa,tanggal_lahir,nisn,
		locked,id_periode,photo,tanggal_masuk,tempat_lahir,telpon_siswa,email,unik,nama_ortu,
		setup_kelas.nama_kelas,data_siswa.keterangan
		from data_siswa 
		left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
		left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
		where nama_siswa like '" . $nama_siswa . "' and $qlocked";
		//echo $sql;
		$query = $db->query($sql);
		return $query->getResult('array');
		//return 'Ini adalah Method getData didalam ProductModel';
	}
	public function listing3($nama_siswa, $locked = "")
	{
		$db = db_connect('arafah');
		if ($locked) {
			$qlocked = "locked in('$locked')";
			$nama_siswa = "%";
		} else {
			$qlocked = "locked in( 'no','baru')";
		}
		$sql = "SELECT 	
		password,username,data_siswa.id_siswa,nama_siswa,nis,kelamin,alamat_siswa,tanggal_lahir,nisn,
		locked,id_periode,photo,tanggal_masuk,tempat_lahir,telpon_siswa,email,unik,nama_ortu,
		setup_kelas.nama_kelas,data_siswa.keterangan
		from data_siswa 
		left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
		left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
		where nama_siswa like '" . $nama_siswa . "' and $qlocked";
		$query = $db->query($sql);
		return $query->getResult('array');
		//return 'Ini adalah Method getData didalam ProductModel';
	}
	public function listingDataTabungan($id_siswa)
	{
		$db = db_connect('arafah');
		$query = "SELECT 	
					id_siswa,kode_tab,nama_siswa,nis,kelamin,alamat_siswa,telpon_siswa,email,unik	
					from data_siswa 
					left join tbl_tabungan_siswa on data_siswa.id_siswa = tbl_tabungan_siswa.kode_siswa
					where id_siswa = '" . $id_siswa . "' and locked in('no','baru')";
		$query = $db->query($query);
		return $query->getRowArray();
		//return 'Ini adalah Method getData didalam ProductModel';
	}
	// Detail
	public function detail($id_siswa)
	{
		$this->select('*');
		$this->where(array('id_siswa'	=> $id_siswa));
		$query = $this->get();
		return $query->getRowArray();
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
	public function login($username, $password)
	{
		$this->select('*');
		$this->where([
			'username'	=> $username,
			'password'	=> sha1($password)
		]);
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
		$this->save($data);
	}

	// Delete
	public function hapus($data)
	{
		$this->where('id_siswa', $data['id_siswa']);
		$this->delete();
	}
}
