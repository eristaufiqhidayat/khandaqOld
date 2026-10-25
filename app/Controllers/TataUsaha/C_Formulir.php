<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_Formulir;

class C_Formulir extends BaseController
{
    public function readjson($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getVar('monthyear');
        }
        $model = new M_Formulir();
        $dataModel = $model->listing($monthyear);
        $data = array(
            "data" => $dataModel
        );
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function editjson($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Formulir();
        $dataModel = $model->detail($this->request->getVar('no'));
        return $this->response->setJSON($dataModel);
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
        $data = new M_Formulir();
        $dataFormulir = $data->listing($monthyear);
        $newdata = [
            'action' => 'Taambah',
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
        return view('TataUsaha/V_Formulir2', $data);
    }
    public function  insertPengeluaran($menuAktip = '', $moduleAktip = '')
    {
        helper('form');


        $data = new M_Formulir();

        $config = null;
        $session = \Config\Services::session($config);
        $validated =  $this->validate([
            'nama_siswa'     => 'required',
            'telp'     => 'required',
            'tanggal'     => 'required',
            'nama_ortu'     => 'required',
            'rp'     => 'required',
        ]);
        if ($validated) {
            $image = $this->uploadFoto();
            if ($image === false) {
                return $this->response->setStatusCode(400)->setJSON('File bukti transfer harus berupa gambar (jpg, jpeg, png)');
            }
            $dataTambah = array(
                'nama_siswa'    => $this->request->getVar('nama_siswa'),
                'alamat'    => $this->request->getVar('alamat'),
                'telp'    => $this->request->getVar('telp'),
                'tanggal'    => $this->request->getVar('tanggal'),
                'nama_ortu'    => $this->request->getVar('nama_ortu'),
                'rp'    => $this->request->getVar('rp'),
                'keterangan'    => $this->request->getVar('keterangan'),
                'foto' => $image
            );
            $data->tambah($dataTambah);
            echo json_encode('sukses');
            //$session->setFlashdata('sukses', 'Data Berhasil');
            //return redirect()->back()->with('success', 'Data Berhasi disimpan');
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
    public function  updatePengeluaran($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $data = new M_Formulir();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);

        $validated =  $this->validate([
            'no'     => 'required',
            'nama_siswa'     => 'required',
            'alamat'     => 'required',
            'telp'     => 'required',
            'tanggal'     => 'required',
            'nama_ortu'     => 'required',
            'rp'     => 'required',
            'keterangan'     => 'required',
        ]);
        if ($validated) {
            $image = $this->uploadFoto();
            if ($image === false) {
                return $this->response->setStatusCode(400)->setJSON('File bukti transfer harus berupa gambar (jpg, jpeg, png)');
            }
            $dataUpdate = array(
                'no'    => $this->request->getVar('no'),
                'nama_siswa'    => $this->request->getVar('nama_siswa'),
                'alamat'    => $this->request->getVar('alamat'),
                'telp'    => $this->request->getVar('telp'),
                'tanggal'    => $this->request->getVar('tanggal'),
                'nama_ortu'    => $this->request->getVar('nama_ortu'),
                'rp'    => $this->request->getVar('rp'),
                'keterangan'    => $this->request->getVar('keterangan'),
                'foto' => $image
            );
            $data->edit($dataUpdate);
            echo json_encode('sukses');
            //$session->setFlashdata('sukses', 'Data Berhasil di Edit');
            //return redirect()->to(base_url('index.php/TataUsaha/Formulir/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
    public function  deletePengeluaran($menuAktip = '', $moduleAktip = '')
    {

        $data = new M_Formulir();
        $validated =  $this->validate([
            'no'     => 'required',
        ]);
        if ($validated) {
            $datadelete = array(
                'no'    => $this->request->getVar('no'),
            );
            $data->delete($datadelete);
            echo json_encode('sukses');
            //return redirect()->to(base_url('index.php/TataUsaha/Formulir/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
    // Simpan file bukti transfer; "" jika tidak ada file, false jika bukan gambar
    private function uploadFoto()
    {
        return simpan_gambar_upload($this->request->getFile('foto'), FCPATH . 'uploads/formulir', 'Formulir');
    }
}
