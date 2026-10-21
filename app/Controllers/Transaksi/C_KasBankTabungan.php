<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Transaksi\M_KasBankTabungan;

class C_KasBankTabungan extends BaseController
{

    public function  index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_KasBankTabungan();
        $dataKasBankTabungan = $data->listing();
        $newdata = [
            'kasBank'  => 'Entri Kas Bank'
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $data = array(
            'title'        => 'Data Menu',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'dataKasBankTabungan'    => $dataKasBankTabungan,
            'menu'   =>  $datamenu
        );
        return view('Transaksi/V_KasBankTabungan', $data);
    }
    public function  insert($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $data = new M_KasBankTabungan();
        $newdata = [
            'kasBank'  => 'Insert Kas Bank'
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'tanggal'     => 'required',
            'rp'     => 'required',
        ]);
        if ($validated) {
            $dataTambah = array(
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
    public function  update($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $data = new M_KasBankTabungan();
        $newdata = [
            'kasBank'  => 'Update Kas Bank'
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'tanggal'     => 'required',
            'rp'     => 'required',
        ]);
        if ($validated) {
            $dataUpdate = array(
                'no'    => $this->request->getVar('no'),
                'tanggal'    => $this->request->getVar('tanggal'),
                'rp'    => $this->request->getVar('rp'),
                'keterangan'    => $this->request->getVar('keterangan'),
            );
            $data->edit($dataUpdate);
            $session->setFlashdata('sukses', 'Data Berhasil di Edit');
            return redirect()->to(base_url('index.php/transaksi/KasBankTabungan/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
    public function  delete($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $data = new M_KasBankTabungan();
        $newdata = [
            'kasBank'  => 'Delete Kas Bank'
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
            return redirect()->to(base_url('index.php/transaksi/KasBankTabungan/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
}
