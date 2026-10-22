<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class M_Users extends Model
{
    protected $DBGroup          = 'default';
    protected $table = "users";
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\EUser::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['id', 'username', 'password_hash', 'email', 'active', 'force_pass_reset', 'ortu'];

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

    public function listing()
    {
        return $this->db->table('users')
            ->select('id, username, email, active')
            ->get()->getResultArray();
    }
    // Daftar user beserta group-nya (satu user satu group)
    public function listingWithGroup()
    {
        return $this->db->table('users u')
            ->select('u.id, u.username, u.email, u.active, g.id as group_id, g.name as group_name, g.description as group_desc')
            ->join('auth_groups_users gu', 'gu.user_id = u.id', 'left')
            ->join('auth_groups g', 'g.id = gu.group_id', 'left')
            ->orderBy('u.username')
            ->get()->getResultArray();
    }
    public function listingOrtu()
    {
        return $this->db->table('users')
            ->select('id, username, email, active')
            ->where('ortu', '1')
            ->get()->getResultArray();
    }
    public function tambah($data)
    {
        $this->insert($data);
    }
    public function edit($data)
    {
        $this->update($this->primaryKey, $data);
    }
    public function insertGroupUser($group_id, $user_id)
    {
        $this->db->table('auth_groups_users')->insert([
            'group_id' => $group_id,
            'user_id'  => $user_id,
        ]);
    }
    public function getidUser($username)
    {
        return $this->db->table('users')->select('id')
            ->where('username', $username)
            ->get()->getRowArray();
    }
    public function cekGroupUsers($user_id)
    {
        return $this->db->table('auth_groups_users')->select('user_id')
            ->where('user_id', $user_id)
            ->get()->getRowArray();
    }
    public function listGroup()
    {
        return $this->db->table('auth_groups')
            ->select('id, description as text')
            ->get()->getResultArray();
    }
    public function deleteGroupUser($user_id)
    {
        $this->db->table('auth_groups_users')->where('user_id', $user_id)->delete();
    }
    // Ganti group user: hapus semua group lama lalu pasang yang baru
    public function setGroupUser($user_id, $group_id)
    {
        $this->db->transStart();
        $this->deleteGroupUser($user_id);
        if ($group_id) {
            $this->insertGroupUser($group_id, $user_id);
        }
        $this->db->transComplete();
        return $this->db->transStatus();
    }
    public function CPass($data)
    {
        $this->db->table('users')
            ->where('username', $data['username'])
            ->update(['password_hash' => $data['password_hash']]);
    }
}
