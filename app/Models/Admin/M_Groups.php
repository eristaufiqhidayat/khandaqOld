<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class M_Groups extends Model
{
    protected $table            = "auth_groups";
    protected $returnType       = \App\Entities\EGroups::class;
    protected $primaryKey       = "id";
    protected $allowedFields    = ['id', 'name', 'description'];

    // Daftar group beserta jumlah user-nya
    public function listing()
    {
        return $this->db->table('auth_groups g')
            ->select('g.id, g.name, g.description, COUNT(gu.user_id) as jml_user')
            ->join('auth_groups_users gu', 'gu.group_id = g.id', 'left')
            ->groupBy('g.id, g.name, g.description')
            ->orderBy('g.description')
            ->get()->getResultArray();
    }

    // id modul yang boleh dibuka group (permission_id = id_module)
    public function modulGroup($group_id)
    {
        $rows = $this->db->table('auth_groups_permissions')
            ->select('permission_id')
            ->where('group_id', $group_id)
            ->get()->getResultArray();
        return array_map('intval', array_column($rows, 'permission_id'));
    }

    // Simpan hak akses satu group saja. Permission yang belum ada dibuat dulu
    // karena auth_permissions.id selalu sama dengan tbl_module.id_module.
    public function simpanModulGroup($group_id, array $modul)
    {
        $modulAda = $this->db->table('tbl_module')->select('id_module, nama_module')
            ->whereIn('id_module', $modul ?: [0])
            ->get()->getResultArray();

        $this->db->transStart();
        $permission = new M_DataModule();
        foreach ($modulAda as $m) {
            $permission->pastikanPermission($m['id_module'], $m['nama_module']);
        }
        $this->db->table('auth_groups_permissions')->where('group_id', $group_id)->delete();
        foreach ($modulAda as $m) {
            $this->db->table('auth_groups_permissions')->insert([
                'group_id'      => $group_id,
                'permission_id' => $m['id_module'],
            ]);
        }
        $this->db->transComplete();
        return $this->db->transStatus();
    }

    public function jumlahUser($group_id)
    {
        return $this->db->table('auth_groups_users')->where('group_id', $group_id)->countAllResults();
    }

    // Hapus group beserta hak aksesnya. Group yang masih punya user tidak boleh dihapus.
    public function hapusGroup($group_id)
    {
        $this->db->transStart();
        $this->db->table('auth_groups_permissions')->where('group_id', $group_id)->delete();
        $this->db->table('auth_groups')->where('id', $group_id)->delete();
        $this->db->transComplete();
        return $this->db->transStatus();
    }
}
