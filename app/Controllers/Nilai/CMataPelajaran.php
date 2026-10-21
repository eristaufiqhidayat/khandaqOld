<?php

namespace App\Controllers\Nilai;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Nilai\MMataPelajaran;

class CMataPelajaran extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        $modelmenu = new M_Menu();
        $datamenu = $modelmenu->listing();
        $model = new MMataPelajaran();
        $dataModel = $model->searchByidkelompok($this->request->getVar('id_kelompok'));
        $data = array(
            'title'        => 'Data Module',
            'DataModule'    => $dataModel,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip
        );

        return view('Nilai/VMataPelajaran', $data);
    }
    public function tambah()
    {
        $modulemodel = new MMataPelajaran();
        $module           = new \App\Entities\EMataPelajaran();
        $module->nama_matapelajaran = $this->request->getPost('nama_matapelajaran');
        $module->id_kelompok = $this->request->getPost('id_kelompok');
        $module->kode_matapelajaran = $this->request->getPost('kode_matapelajaran');
        $modulemodel->insert($module);
        return redirect()->back()->with('messege', lang('Auth.newdata'));
    }
    public function edit()
    {
        $menumodel = new MMataPelajaran();
        $menumodel->update(
            $this->request->getPost('id_matapelajaran'),
            [
                "id_kelompok" => $this->request->getPost('id_kelompok'),
                "nama_matapelajaran" => $this->request->getPost('nama_matapelajaran'),
                "kode_matapelajaran" => $this->request->getPost('kode_matapelajaran')
            ]
        );

        return redirect()->back()->with('messege', lang('Auth.updatedata'));
    }
    public function delete()
    {
        $menumodel = new MMataPelajaran();
        $menumodel->where('id_matapelajaran', $this->request->getPost('id_matapelajaran'));
        $menumodel->delete();
        return redirect()->back()->with('messege', lang('Auth.deletedata'));
    }
    public function JSONmatapelajaran($id_kelompok)
    {
        $model = new MMataPelajaran();
        $dataModel = $model->searchByidkelompok($id_kelompok);
        $data = array(
            'DataModule'    => $dataModel,
        );
        return $this->response->setJSON($data);
    }
}
