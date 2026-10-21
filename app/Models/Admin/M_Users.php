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
        $db = db_connect();
        $query = $db->query('SELECT id,username,email,password_hash,activate_hash,active FROM `users` 	');
        return $query->getResult('array');
    }
    public function listingOrtu()
    {
        $db = db_connect();
        $sql = "SELECT id,username,email,password_hash,activate_hash,active FROM `users` where ortu ='1'";
        $query = $db->query($sql);
        return $query->getResult('array');
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
        $db = db_connect();
        $query = "INSERT INTO `auth_groups_users` (`group_id`, `user_id`)
        VALUES ('$group_id', '$user_id')";
        $query = $db->query($query);
    }
    public function getidUser($username)
    {
        $db = db_connect();
        $query = "select id from users where username = '$username'";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function cekGroupUsers($user_id)
    {
        $db = db_connect();
        $query = "select user_id from `auth_groups_users` where user_id = '$user_id'";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function cekGroupUsersAll($user_id)
    {
        $db = db_connect();
        $query = "select a.id,a.email,a.username,b.group_id,c.name,c.description from users a 
        LEFT JOIN auth_groups_users b on a.id = b.user_id 
        left join auth_groups c on b.group_id = c.id   
        where a.id = '$user_id'";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function listGroup()
    {
        $db = db_connect();
        $query = "select id, description as text from `auth_groups`";
        $query = $db->query($query);
        return $query->getResult('array');
    }
    public function deleteGroupUser($user_id)
    {
        $db = db_connect();
        $query = "delete from `auth_groups_users` where user_id = '$user_id'";
        $query = $db->query($query);
    }
    public function CPass($data)
    {
        $username = $data['username'];
        $password = $data['password_hash'];
        $db = db_connect();
        $query = "UPDATE `users` SET 
        `password_hash` = '$password' 
        WHERE `users`.`username` = '$username'";
        //echo $query;
        $query = $db->query($query);
    }
}
