<?php

namespace App\Controllers\Whatsapp;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Whatsapp\M_Message;

class C_Message extends BaseController
{
    public function readjson($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Message();
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
        $data = new M_Message();
        $dataMyapp = $data->findAll();
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
        return view('Whatsapp/V_Message', $data);
    }
    public function get_Message()
    {
        $model = new M_Message();
        $datamodel = $model->get_Message($this->request->getVar('no'));
        return $this->response->setJSON($datamodel);
    }
    public function tambah()
    {
        $menumodel = new M_Message();
        $data           = new \App\Entities\EMyapp();
        $data->message    = $this->request->getPost('message');
        $data->device    = $this->request->getPost('device');

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
        $model = new M_Message();
        $model->delete($data);
        $session->setFlashdata('sukses', 'Data telah dihapus');
        echo json_encode('sukses');
    }
    public function edit()
    {

        $menumodel = new M_Message();
        $menumodel->update(
            $this->request->getPost('no'),
            [
                'message' => $this->request->getPost('message'),
                'device' => $this->request->getPost('device')
            ]
        );
        echo json_encode('sukses');
    }
}
