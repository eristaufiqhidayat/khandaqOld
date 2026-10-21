<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_KalenderAkademik;

class C_KalenderAkademik extends BaseController
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
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_KalenderAkademik();
        $dataKalenderAkademik = $data->listing();
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
            'dataKalenderAkademik'    => $dataKalenderAkademik,
            'monthyear' => $monthyear,
            'menu'   =>  $datamenu,

            'session' => $session
        );
        return view('TataUsaha/V_KalenderAkademik', $data);
    }
    public function  insert($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $data = new M_KalenderAkademik();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'tanggal'     => 'required',
            'kegiatan'     => 'required',
        ]);
        if ($validated) {
            $dataTambah = array(
                'tanggal'    => $this->request->getVar('tanggal'),
                'kegiatan'    => $this->request->getVar('kegiatan'),
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

        $data = new M_KalenderAkademik();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'no'     => 'required',
            'tanggal'     => 'required',
            'kegiatan'     => 'required',
        ]);
        if ($validated) {
            $dataUpdate = array(
                'no'    => $this->request->getVar('no'),
                'tanggal'    => $this->request->getVar('tanggal'),
                'kegiatan'    => $this->request->getVar('kegiatan'),
            );
            $data->edit($dataUpdate);
            $session->setFlashdata('sukses', 'Data Berhasil di Edit');
            return redirect()->to(base_url('index.php/TataUsaha/KalenderAkademik/index/' . $menuAktip . "/" . $moduleAktip));
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

        $data = new M_KalenderAkademik();
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
            return redirect()->to(base_url('index.php/TataUsaha/KalenderAkademik/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
}
