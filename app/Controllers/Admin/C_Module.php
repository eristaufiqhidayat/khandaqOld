<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\M_DataModule;
use App\Models\M_Menu;

class C_Module extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('text');

        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $model = new M_DataModule();
        $datamodule = $model->listing();

        $data = array(
            'title'        => 'Data Module',
            'DataModule'    => $datamodule,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip
        );
        return view('Admin/V_DataModule', $data);
    }

    public function edit($menuAktip = '', $moduleAktip = '')
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
                'nama_module'    => $this->request->getVar('nama_module'),
                'icon'    => $this->request->getVar('icon')
            );
            $model = new M_DataModule();
            $model->edit($data);
            $datamodule = $model->listing();
            $data = array(
                'title'        => 'Java Web Media - Spesialis Kursus Codeigniter',
                'DataModule'    => $datamodule,
                'content'    => 'home/index',
                'menu'   =>  $datamenu
            );
            $session->setFlashdata('sukses', 'Data telah diedit');
            return redirect()->to(base_url('index.php/module/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        }
    }

    public function tambah($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $session = \Config\Services::session();
        $validated =  $this->validate([
            'nama_module'     => 'required'
        ]);
        if ($validated) {
            $data = array(
                'nama_module'    => $this->request->getVar('nama_module'),
                'icon'    => $this->request->getVar('icon')
            );
            $model = new M_DataModule();
            if ($model->tambah($data)) {
                $session->setFlashdata('error', 'Data gagal ditambah');
            } else {
                $session->setFlashdata('msg', 'Data sukses ditambah');
            }

            return redirect()->to(base_url('index.php/module/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        } else {
            $session->setFlashdata('error', 'Data Gagal disimpan Validasi Error');
            return redirect()->to(base_url('index.php/module/index/' . $menuAktip . '/' . $moduleAktip));
        }
    }
    public function delete($menuAktip = '', $moduleAktip = '')
    {
        helper('form');

        $session = \Config\Services::session();
        $validated =  $this->validate([
            'id_module'     => 'required',
            'nama_module'     => 'required'
        ]);
        if ($validated) {
            $data = array(
                'id_module'        => $this->request->getVar('id_module'),
                'nama_module'    => $this->request->getVar('nama_module'),
                'icon'    => $this->request->getVar('icon')
            );
            $model = new M_DataModule();
            if ($model->hapus($data)) {
                $session->setFlashdata('error', 'Data gagal dihapus');
            } else {
                $session->setFlashdata('msg', 'Data sukses dihapus');
            }

            return redirect()->to(base_url('index.php/module/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        } else {
            $session->setFlashdata('error', 'Data Gagal disimpan Validasi Error');
            return redirect()->to(base_url('index.php/module/index/' . $menuAktip . '/' . $moduleAktip));
        }
    }
}
