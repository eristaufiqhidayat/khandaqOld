<?php

namespace App\Controllers\Whatsapp;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Whatsapp\M_Notelp;
use App\Models\Whatsapp\M_Groupwa;

class C_Notelp extends BaseController
{
    public function readjson($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Notelp();
        $dataModel = $model->listing();
        $data = array(
            "data" => $dataModel
        );
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function readjsongroupwa()
    {
        helper('form');
        helper('cookie');
        $model = new M_Groupwa();
        $dataModel = $model->findAll();
        foreach ($dataModel as $group) {
            $data[] = array(
                'id' => $group->no,
                'text' => $group->no . "::" . $group->nama
            );
        }
        $data = array(
            "results" => $data
        );
        //echo json_encode($data);
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function  index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getVar('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_Notelp();
        $dataMyapp = $data->listing();
        $newdata = [
            'action' => 'Tambah',
            'monthyear'  => $monthyear,
            'dataFormulir'    => $dataMyapp,
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $data = array(
            'title'        => 'Data Menu',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'dataMyapp'    => $dataMyapp,
            'monthyear'    => $monthyear,
            'menu'   =>  $datamenu,
            'session' => $session
        );
        return view('Whatsapp/V_Notelp', $data);
    }
    public function get_Notelp()
    {
        $model = new M_Notelp();
        $datamodel = $model->get_Notelp($this->request->getVar('no'));
        return $this->response->setJSON($datamodel);
    }
    public function tambah()
    {
        $menumodel = new M_Notelp();
        $data           = new \App\Entities\EMyapp();
        $data->nama    = $this->request->getPost('nama');
        $data->nohp    = $this->request->getPost('nohp');
        $data->group    = $this->request->getPost('group');

        $menumodel->save($data);
        echo json_encode('sukses');
    }
    public function delete()
    {
        helper('form');
        $session = \Config\Services::session();
        $data = array(
            'no'    => $this->request->getVar('no'),
        );
        $model = new M_Notelp();
        $model->delete($data);
        $session->setFlashdata('sukses', 'Data telah dihapus');
        echo json_encode('sukses');
    }
    public function edit()
    {

        $menumodel = new M_Notelp();
        $menumodel->update(
            $this->request->getPost('no'),
            [
                'nama' => $this->request->getPost('nama'),
                'nohp' => $this->request->getPost('nohp'),
                'group' => $this->request->getPost('group')
            ]
        );
        echo json_encode('sukses');
    }
}
