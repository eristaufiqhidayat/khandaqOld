<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_Daftar;

class C_Daftar extends BaseController
{
    public function readjson($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Daftar();
        $dataModel = $model->findAll();
        $data = array(
            "data" => $dataModel
        );
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
        $data = new M_Daftar();
        $dataFormulir = $data->findAll();
        $newdata = [
            'action' => 'Tambah',
            'monthyear'  => $monthyear,
            'dataFormulir'    => $dataFormulir,
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $data = array(
            'title'        => 'Data Menu',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'dataFormulir'    => $dataFormulir,
            'monthyear'    => $monthyear,
            'menu'   =>  $datamenu,
            'session' => $session
        );
        return view('TataUsaha/V_Daftar', $data);
    }
    public function get_Daftar()
    {
        $model = new M_Daftar();
        $datamodel = $model->get_Daftar($this->request->getVar('no'));
        return $this->response->setJSON($datamodel);
    }
    public function edit()
    {
        $menumodel = new M_Daftar();
        $menumodel->update(
            $this->request->getPost('no'),
            [
                'proses' => $this->request->getPost('proses'),
                //'proses' => 'test',
            ]
        );
        echo json_encode('sukses');
    }
}
