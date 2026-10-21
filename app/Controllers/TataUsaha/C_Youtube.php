<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_Youtube;

class C_Youtube extends BaseController
{
    public function readjson($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Youtube();
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
        $data = new M_Youtube();
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
        return view('TataUsaha/V_Youtube', $data);
    }
    public function get_Youtube()
    {
        $model = new M_Youtube();
        $datamodel = $model->get_Youtube($this->request->getVar('no'));
        return $this->response->setJSON($datamodel);
    }
    public function tambah()
    {
        $menumodel = new M_Youtube();
        $data           = new \App\Entities\EYoutube();
        $data->alamat    = $this->request->getPost('alamat');
        $data->descripsi    = $this->request->getPost('descripsi');
        $data->id_siswa    = $this->request->getPost('id_siswa');

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
        $model = new M_Youtube();
        $model->delete($data);
        $session->setFlashdata('sukses', 'Data telah dihapus');
        echo json_encode('sukses');
    }
    public function edit()
    {

        $menumodel = new M_Youtube();
        $menumodel->update(
            $this->request->getPost('no'),
            [
                'alamat' => $this->request->getPost('alamat'),
                'descripsi' => $this->request->getPost('descripsi'),
                'id_siswa' => $this->request->getPost('id_siswa')
            ]
        );
        echo json_encode('sukses');
    }
}
