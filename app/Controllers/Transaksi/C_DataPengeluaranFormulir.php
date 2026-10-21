<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Transaksi\M_DataPengeluaranFormulir;

class C_DataPengeluaranFormulir extends BaseController
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
        $data = new M_DataPengeluaranFormulir();
        $datapengeluaran = $data->listing($monthyear);
        $totalAll = $data->totalAll($monthyear);
        $totalRutin = $data->totalRutin($monthyear);
        $totalNonRutin = $data->totalNonRutin($monthyear);
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
            'dataPengeluaran'    => $datapengeluaran,
            'totalAll' => $totalAll,
            'totalRutin' => $totalRutin,
            'totalNonRutin' => $totalNonRutin,
            'monthyear' => $monthyear,
            'menu'   =>  $datamenu,

            'session' => $session
        );
        return view('Transaksi/V_DataPengeluaranFormulir', $data);
    }
    public function  insertPengeluaran($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $data = new M_DataPengeluaranFormulir();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'kode_akun'     => 'required',
            'kode_pengusul'     => 'required',
            'rutin'     => 'required',
            'tanggal'     => 'required',
            'rp'     => 'required',
        ]);
        if ($validated) {
            $dataTambah = array(
                'kode_akun'    => $this->request->getVar('kode_akun'),
                'kode_pengusul'    => $this->request->getVar('kode_pengusul'),
                'rutin'    => $this->request->getVar('rutin'),
                'tanggal'    => $this->request->getVar('tanggal'),
                'rp'    => $this->request->getVar('rp'),
                'keterangan'    => $this->request->getVar('keterangan'),
            );
            $data->tambah($dataTambah);
            $session->setFlashdata('sukses', 'Data Berhasil');
            return redirect()->back()->with('success', 'Data Berhasi disimpan');
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

        $data = new M_DataPengeluaranFormulir();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'kode_akun'     => 'required',
            'kode_pengusul'     => 'required',
            'rutin'     => 'required',
            'tanggal'     => 'required',
            'rp'     => 'required',
        ]);
        if ($validated) {
            $dataUpdate = array(
                'no'    => $this->request->getVar('no'),
                'kode_akun'    => $this->request->getVar('kode_akun'),
                'kode_pengusul'    => $this->request->getVar('kode_pengusul'),
                'rutin'    => $this->request->getVar('rutin'),
                'tanggal'    => $this->request->getVar('tanggal'),
                'rp'    => $this->request->getVar('rp'),
                'keterangan'    => $this->request->getVar('keterangan'),
            );
            $data->edit($dataUpdate);
            $session->setFlashdata('sukses', 'Data Berhasil di Edit');
            return redirect()->to(base_url('index.php/transaksi/pengeluaranFormulir/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
    public function  deletePengeluaran($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $data = new M_DataPengeluaranFormulir();
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
            $data->delete($datadelete);
            $session->setFlashdata('sukses', 'Data Berhasil di Delete');
            return redirect()->to(base_url('index.php/transaksi/pengeluaranFormulir/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
}
