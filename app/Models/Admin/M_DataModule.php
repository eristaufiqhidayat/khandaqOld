<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class M_DataModule extends Model
{
	protected $table 		= 'tbl_module';
	protected $primaryKey 	= 'id_module';
	protected $allowedFields = ['id_module', 'nama_module', 'icon'];


	// Listing
	public function listing()
	{
		$this->select('*');
		$query = $this->get();
		return $query->getResultArray();

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
		$this->where('id_module', $data['id_module']);
		$this->replace($data);
	}

	// Delete
	public function hapus($data)
	{
		$this->where('id_module', $data['id_module']);
		$this->delete();
	}
}
