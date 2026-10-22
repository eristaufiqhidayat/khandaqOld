<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

// tbl_module = kategori menu. Setiap modul punya pasangan di auth_permissions
// dengan id yang sama; pasangan itu yang dicentang di halaman Group & Hak Akses.
class M_DataModule extends Model
{
	protected $table 		= 'tbl_module';
	protected $primaryKey 	= 'id_module';
	protected $allowedFields = ['id_module', 'nama_module', 'icon'];

	public function listing()
	{
		return $this->db->table('tbl_module')->orderBy('id_module')->get()->getResultArray();
	}

	// Modul beserta menu di dalamnya
	public function listingDenganMenu()
	{
		$modul = [];
		foreach ($this->listing() as $m) {
			$m['menus'] = [];
			$modul[$m['id_module']] = $m;
		}
		$menus = $this->db->table('tbl_menu')->orderBy('menu')->get()->getResultArray();
		foreach ($menus as $menu) {
			if (isset($modul[$menu['id_module']])) {
				$modul[$menu['id_module']]['menus'][] = $menu;
			}
		}
		return $modul;
	}

	public function pastikanPermission($id_module, $nama_module)
	{
		$tbl = $this->db->table('auth_permissions');
		if ($tbl->where('id', $id_module)->countAllResults() > 0) {
			$this->db->table('auth_permissions')->where('id', $id_module)
				->update(['name' => $nama_module, 'description' => $nama_module]);
		} else {
			$this->db->table('auth_permissions')->insert([
				'id'          => $id_module,
				'name'        => $nama_module,
				'description' => $nama_module,
			]);
		}
	}

	// Tambah modul + permission-nya, dan langsung beri akses ke group admin
	public function tambahModul($nama_module, $icon)
	{
		$this->db->transStart();
		$this->db->table('tbl_module')->insert(['nama_module' => $nama_module, 'icon' => $icon]);
		$id = $this->db->insertID();
		$this->pastikanPermission($id, $nama_module);
		$admin = $this->db->table('auth_groups')->select('id')->where('name', 'admin')->get()->getRowArray();
		if ($admin) {
			$this->db->table('auth_groups_permissions')->insert(['group_id' => $admin['id'], 'permission_id' => $id]);
		}
		$this->db->transComplete();
		return $this->db->transStatus();
	}

	public function ubahModul($id_module, $nama_module, $icon)
	{
		$this->db->transStart();
		$this->db->table('tbl_module')->where('id_module', $id_module)
			->update(['nama_module' => $nama_module, 'icon' => $icon]);
		$this->pastikanPermission($id_module, $nama_module);
		$this->db->transComplete();
		return $this->db->transStatus();
	}

	// Hapus modul beserta menu dan hak aksesnya
	public function hapusModul($id_module)
	{
		$this->db->transStart();
		$this->db->table('tbl_menu')->where('id_module', $id_module)->delete();
		$this->db->table('auth_groups_permissions')->where('permission_id', $id_module)->delete();
		if ($this->db->tableExists('auth_users_permissions')) {
			$this->db->table('auth_users_permissions')->where('permission_id', $id_module)->delete();
		}
		$this->db->table('auth_permissions')->where('id', $id_module)->delete();
		$this->db->table('tbl_module')->where('id_module', $id_module)->delete();
		$this->db->transComplete();
		return $this->db->transStatus();
	}
}
