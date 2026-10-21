<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\M_DataMenu;
use App\Models\Admin\M_DataModule;
use App\Models\M_Menu;

class C_Menu extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('text');

        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $model = new M_DataMenu();
        $datamenu2 = $model->listing();
        $mdatamodule = new M_DataModule();
        $datamodule = $mdatamodule->listing();
        $data = array(
            'title'        => 'Data Menu',
            'DataMenu'    => $datamenu2,
            'DataModule'    => $datamodule,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip
        );
        return view('Admin/V_DataMenu', $data);
    }
    public function tambah($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $session = \Config\Services::session();

        $validated =  $this->validate([
            'id_module'     => 'required'
        ]);
        if ($validated) {
            $data = array(
                'id_module'        => $this->request->getVar('id_module'),
                'icon'    => $this->request->getVar('icon'),
                'menu'    => $this->request->getVar('menu'),
                'path'    => $this->request->getVar('path')
            );
            $model = new M_DataMenu();
            $model->tambah($data);
            $session->setFlashdata('sukses', 'Data telah ditambah');
            return redirect()->to(base_url('index.php/menu/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        }
    }
    public function edit($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        //$menu = new M_Menu();
        //$datamenu = $menu->listing();  
        $session = \Config\Services::session();

        $validated =  $this->validate([
            'id_menu'     => 'required'
        ]);
        if ($validated) {
            $data = array(
                'id_menu'    => $this->request->getVar('id_menu'),
                'id_module'    => $this->request->getVar('id_module'),
                'menu'    => $this->request->getVar('menu'),
                'path'    => $this->request->getVar('path'),
                'icon'    => $this->request->getVar('icon')
            );
            $model = new M_DataMenu();
            $model->edit($data);
            $session->setFlashdata('sukses', 'Data telah diedit');
            return redirect()->to(base_url('index.php/menu/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        }
    }
    public function delete($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        //$menu = new M_Menu();
        //$datamenu = $menu->listing();  
        $session = \Config\Services::session();
        $validated =  $this->validate([
            'id_menu'     => 'required'
        ]);
        if ($validated) {
            $data = array(
                'id_menu'    => $this->request->getVar('id_menu'),
            );
            $model = new M_DataMenu();
            $model->delete($data);
            $session->setFlashdata('sukses', 'Data telah dihapus');
            return redirect()->to(base_url('index.php/menu/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        }
    }
}
