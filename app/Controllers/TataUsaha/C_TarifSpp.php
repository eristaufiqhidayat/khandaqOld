<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_TarifSpp;

class C_TarifSpp extends BaseController
{

    public function  index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = "";
            #$monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        if (!$this->request->getPost('id_kelas')) {
            $id_kelas = "%";
        } else {
            $id_kelas =  $this->request->getPost('id_kelas');
        }
        if (!$this->request->getPost('id_periode')) {
            $id_periode = "%";
        } else {
            $id_periode =  $this->request->getPost('id_periode');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_TarifSpp();
        $dataTarifSpp = $data->listing($id_periode);
        $dataKelas = $data->dataKelas();
        $dataPeriode = $data->dataPeriode();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $data = array(
            'title'        => 'Data Menu',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'dataTarifSpp'    => $dataTarifSpp,
            'dataKelas' => $dataKelas,
            'dataPeriode' => $dataPeriode,
            'monthyear' => $monthyear,
            'menu'   =>  $datamenu,
            'id_kelas' => $id_kelas,
            'id_periode' => $id_periode,
            'session' => $session
        );
        return view('TataUsaha/V_TarifSpp', $data);
    }
    public function  insert($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $data = new M_TarifSpp();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'id_kelas'     => 'required',
            'tarif'     => 'required',
            'periode'     => 'required',
            'tanggal'     => 'required',
        ]);
        if ($validated) {
            $dataTambah = array(
                'id_kelas'    => $this->request->getVar('id_kelas'),
                'tarif'    => $this->request->getVar('tarif'),
                'periode'    => $this->request->getVar('periode'),
                'tanggal'    => $this->request->getVar('tanggal'),
            );
            $data->tambah($dataTambah);
            $session->setFlashdata('sukses', 'Data Berhasil');
            return redirect()->back()->with('success', 'Data Berhasi disimpan');
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
    public function  update($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $data = new M_TarifSpp();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'no'     => 'required',
        ]);
        if ($validated) {
            $dataUpdate = array(
                'no'    => $this->request->getVar('no'),
                'id_kelas'    => $this->request->getVar('id_kelas'),
                'tarif'    => $this->request->getVar('tarif'),
                'periode'    => $this->request->getVar('periode'),
                'tanggal'    => $this->request->getVar('tanggal'),
            );
            $data->edit($dataUpdate);
            $session->setFlashdata('sukses', 'Data Berhasil di Edit');
            return redirect()->to(base_url('index.php/TataUsaha/TarifSpp/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
    public function  delete($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $data = new M_TarifSpp();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'no'     => 'required',
        ]);
        if ($validated) {
            $datadelete = array(
                'no'    => $this->request->getVar('no'),
            );
            $data->hapus($datadelete);
            $session->setFlashdata('sukses', 'Data Berhasil di Delete');
            return redirect()->to(base_url('index.php/TataUsaha/TarifSpp/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
}
