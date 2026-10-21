<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_Kelas;

class C_Kelas extends BaseController
{

    public function  index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getVar('monthyear')) {
            $monthyear = "";
            #$monthyear = date('Y-m') ;
        } else {
            $monthyear = $this->request->getVar('monthyear');
        }
        if (!$this->request->getVar('id_kelas')) {
            $id_kelas = "";
        } else {
            $id_kelas =  $this->request->getVar('id_kelas');
        }
        if (!$this->request->getVar('id_periode')) {
            $id_periode = "%";
        } else {
            $id_periode =  $this->request->getVar('id_periode');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_Kelas();
        $dataSiswa = $data->dataSiswa($id_kelas);
        $dataKelas = $data->dataKelas();
        $dataPeriode = $data->dataPeriode();
        $dataPeriodeAktif = $data->dataPeriodeAktif();
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
            'dataSiswa'    => $dataSiswa,
            'dataKelas' => $dataKelas,
            'dataPeriode' => $dataPeriode,
            'dataPeriodeAktif' => $dataPeriodeAktif,
            'monthyear' => $monthyear,
            'menu'   =>  $datamenu,
            'id_kelas' => $id_kelas,
            'id_periode' => $id_periode,
            'session' => $session
        );
        return view('TataUsaha/VKelas', $data);
    }

    public function  update($menuAktip = '', $moduleAktip = '')
    {
        $id_kelas = $this->request->getVar('id_kelas');
        $id_kelasnew = $this->request->getVar('id_kelasnew');
        $data = new M_Kelas();
        $id_periode = $data->dataPeriodeAktif();
        $config = null;
        $session = \Config\Services::session($config);
        foreach ($this->request->getVar('id_siswa') as $id_siswa => $val) {
            $cek = $data->cekKelasPeriode($id_siswa,  $id_periode['id_periode']);
            if ($cek) $data->updateKelasPeriode($id_siswa, $id_kelasnew, $id_periode['id_periode']);
            else $data->insertKelasPeriode($id_siswa, $id_kelasnew, $id_periode['id_periode']);
            $cek2 = $data->cekKelas($id_siswa);
            if ($cek2) $data->updateKelasRuangan($id_siswa, $id_kelasnew);
            else $data->insertKelasRuangan($id_siswa, $id_kelasnew);
            $data->updateKelasRuangan($id_siswa, $id_kelasnew);
        }
        $session->setFlashdata('sukses', 'Data Berhasil di Edit');
        return redirect()->to(base_url('index.php/TataUsaha/Kelas/index/' . $menuAktip . "/" . $moduleAktip));
        // helper('form');
        // if (!$this->request->getPost('monthyear')) {
        //     $monthyear = date('Y-m');
        // } else {
        //     $monthyear = $this->request->getPost('monthyear');
        // }
        // $id_siswa = $this->request->getVar('id_siswa');
        // $id_kelas = $this->request->getVar('id_kelas');
        // $data = new M_Kelas();
        // $id_periode = $data->dataPeriodeAktif();
        // $newdata = [
        //     'monthyear'  => $monthyear
        // ];
        // $config = null;
        // $session = \Config\Services::session($config);
        // $session->set($newdata);
        // $validated =  $this->validate([
        //     'id_siswa'     => 'required',
        //     'id_kelas'     => 'required',
        //     'id_periode'     => 'required',
        // ]);
        // if ($validated) {
        //     $cek = $data->cekKelasPeriode($id_siswa,  $id_periode['id_periode']);
        //     if ($cek) $data->updateKelasPeriode($id_siswa, $id_kelas, $id_periode['id_periode']);
        //     else $data->insertKelasPeriode($id_siswa, $id_kelas, $id_periode['id_periode']);
        //     $data->updateKelasRuangan($id_siswa, $id_kelas);
        //     $session->setFlashdata('sukses', 'Data Berhasil di Edit');
        //     return redirect()->to(base_url('index.php/TataUsaha/Kelas/index/' . $menuAktip . "/" . $moduleAktip));
        // } else {
        //     echo "error";
        // }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
}
