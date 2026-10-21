<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class M_Groups extends Model
{
    protected $table            = "auth_groups";
    protected $returnType       = \App\Entities\EGroups::class;
    protected $primaryKey       = "id";
    protected $allowedFields    = ['id', 'name', 'description'];
    public function listing()
    {
        $db = db_connect();
        $query = $db->query('SELECT id, name,description FROM `' . $this->table . '`');
        return $query->getResult('array');
    }
    public function listingGroupsUsers()
    {
        $db = db_connect();
        $query = $db->query('SELECT * 
                            FROM auth_groups_users
                            left join auth_groups on auth_groups.id = auth_groups_users.group_id
                            left join users on users.id = auth_groups_users.user_id 
                            ');
        return $query->getResult('array');
    }
    public function listingGroups()
    {
        $db = db_connect();
        $query = $db->query('SELECT * 
                            FROM auth_groups
                            ');
        return $query->getResult('array');
    }
    public function listingPermissionGroups()
    {
        $db = db_connect();
        $query = $db->query('SELECT 
                             auth_permissions.id as auth_permissions_id, 
                             auth_permissions.name as auth_permissions_name, 
                             auth_permissions.description as auth_permissions_description, 
                             group_id, 
                             permission_id, 
                             auth_groups.id as auth_groups_id, 
                             auth_groups.name auth_groups_name, 
                             auth_groups.description auth_groups_description 
                             FROM `auth_groups_permissions`
                             left join auth_permissions on auth_groups_permissions.permission_id = auth_permissions.id
                             left join auth_groups on auth_groups_permissions.group_id = auth_groups.id
                            ');
        return $query->getResult('array');
    }
    public function listingPermissions()
    {
        $db = db_connect();
        $query = $db->query('SELECT * FROM `auth_permissions`');
        return $query->getResult('array');
    }
    public function listingPermissionGroups2()
    {
        $db = db_connect();
        $query = $db->query('SELECT * FROM `auth_groups_permissions`');
        return $query->getResult('array');
    }
    public function tambah($data)
    {
        $this->insert($data);
    }
    public function listingPermissionGroupsAdd($data)
    {
        $db = db_connect();
        $db->table('auth_groups_permissions')->insert($data);
    }
    public function listingPermissionGroupsTrunc()
    {
        $db = db_connect();
        $db->query('DELETE FROM auth_groups_permissions');
    }
    public function cekGroupUser($user_id)
    {
        $db = db_connect();
        $sql = "select user_id from auth_groups_users where user_id = '$user_id'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function rubahGroupUser($group_id, $user_id)
    {
        $db = db_connect();
        $sql = "update auth_groups_users set group_id = '$group_id' where user_id = '$user_id'";
        return $db->query($sql);
    }
    public function addGroupUser($group_id, $user_id)
    {
        $db = db_connect();
        $sql = "insert into auth_groups_users (group_id,user_id) values('$group_id','$user_id')";
        return $db->query($sql);
    }
}
