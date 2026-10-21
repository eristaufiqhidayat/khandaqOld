<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Admin\MPermission;

class CPermission extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('text');

        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $model = new MPermission();
        $datapermission = $model->findAll();
        $data = array(
            'title'        => 'Data Menu',
            'menu'   =>  $datamenu,
            'permission' => $datapermission,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip
        );
        return view('Admin/VPermission', $data);
    }
    public function tambah()
    {
        # not use this function because Constraint between tbl_menu and auth_permission
        // $authorize = service('authorization');
        // $authorize->createPermission($this->request->getPost('name'), $this->request->getPost('description'));
        $permission           = new \App\Entities\EPermission();
        $module = explode("|", $this->request->getPost('id'));
        $permission->id = $module[1];
        $permission->name = $module[0];
        $permission->description = $this->request->getPost('description');
        $permissions = new MPermission();
        $permissions->insert($permission);
        return redirect()->back()->with('message', lang('Auth.userupdate'));
    }
    public function rubah()
    {
        // $authorize = service('authorization');
        // $authorize->updatePermission($this->request->getPost('id'), $this->request->getPost('name'), $this->request->getPost('description'));
        $permissions = new MPermission();
        $permission = $permissions->find($this->request->getPost('id'));
        $permission->name = $this->request->getPost('name');
        $permission->description = $this->request->getPost('description');
        if (!$permissions->save($permission)) {
            return redirect()->back()->with('message', lang('Auth.userupdate'));
        }

        return redirect()->back()->with('message', lang('Auth.userupdate'));
    }
    public function hapus()
    {
        $authorize = service('authorization');
        $authorize->deletePermission($this->request->getPost('id'));
        return redirect()->back()->with('message', lang('Auth.userupdate'));
    }
}
