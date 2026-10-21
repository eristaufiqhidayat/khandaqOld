<?php

namespace App\Controllers\Nilai;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Nilai\MKelompokMataPelajaran;

class CKelompokMataPelajaran extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('text');

        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $model = new MKelompokMataPelajaran();
        $dataModel = $model->findAll();
        //$datamenu2 = $model->jointmodule();

        $data = array(
            'title'        => 'Data Module',
            'DataModule'    => $dataModel,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip
        );
        return view('Nilai/VKelompokMataPelajaran', $data);
    }
    public function tambah()
    {
        $modulemodel = new MKelompokMataPelajaran();
        $module           = new \App\Entities\EKelompokMataPelajaran();
        $module->nama_kelompok = $this->request->getPost('nama_kelompok');
        $modulemodel->insert($module);
        return redirect()->back()->with('message', lang('Auth.newdata'));
    }
    public function edit()
    {
        $menumodel = new MKelompokMataPelajaran();
        $menumodel->update(
            $this->request->getPost('id_kelompok'),
            [
                "nama_kelompok" => $this->request->getPost('nama_kelompok')
            ]
        );

        return redirect()->back()->with('message', lang('Auth.updatedata'));
    }
    public function delete()
    {
        $menumodel = new MKelompokMataPelajaran();
        $menumodel->where('id_kelompok', $this->request->getPost('id_kelompok'));
        $menumodel->delete();
        return redirect()->back()->with('message', lang('Auth.deletedata'));
    }
}
