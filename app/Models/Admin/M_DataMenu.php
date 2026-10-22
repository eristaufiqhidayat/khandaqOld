<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class M_DataMenu extends Model
{
	protected $table 		= 'tbl_menu';
	protected $primaryKey 	= 'id_menu';
	protected $allowedFields = ['id_module', 'path', 'menu', 'icon'];

	public function tambah($data)
	{
		return $this->insert($data);
	}

	public function ubah($id_menu, $data)
	{
		return $this->update($id_menu, $data);
	}

	public function hapus($id_menu)
	{
		return $this->delete($id_menu);
	}
}
