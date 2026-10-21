<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class M_DataMenu extends Model
{
	//protected $DBGroup      = 'arafah';
	protected $table 		= 'tbl_menu';
	protected $primaryKey 	= 'id_menu';
	protected $allowedFields = ['id_menu', 'id_module', 'path', 'menu', 'icon'];


	// Listing sub query
	public function listing()
	{
		$db = db_connect();
		$query = $db->query('SELECT tbl_module.id_module,
									tbl_module.nama_module,
									tbl_menu.id_menu,
									tbl_menu.path,
									tbl_menu.menu,
									tbl_menu.icon 
                            FROM `tbl_module` 
							left join tbl_menu on tbl_module.id_module = tbl_menu.id_module');
		return $query->getResult('array');
	}

	// Detail
	public function detail($id_menu)
	{
		$this->select('*');
		$this->where(array('id_menu'	=> $id_menu));
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
		//$this->table = 'tbl_menu';
		$this->where('id_menu', $data['id_menu']);
		$this->replace($data);
	}

	// Delete
	public function hapus($id_menu)
	{
		$this->where('id_menu', $id_menu);
		$this->delete();
	}
}
