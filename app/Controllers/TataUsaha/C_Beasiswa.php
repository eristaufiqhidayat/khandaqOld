<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_Beasiswa;


class C_Beasiswa extends BaseController
{
    public function  index($menuAktip = '', $moduleAktip = '')
    {
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_Beasiswa();
        $dataList = $data->dataSiswa();
        $dataBeasiswa = $data->listing();
        $newdata = [
            'Beasiswa'  => 'Index'
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $data = array(
            'title'        => 'Data Beasiswa',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'menu'   =>  $datamenu,
            'dataList'    => $dataList,
            'dataBeasiswa'    => $dataBeasiswa,

        );
        return view('TataUsaha/V_Beasiswa', $data);
    }
    public function  updateBeasiswa($menuAktip = '', $moduleAktip = '')
    {
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_Beasiswa();
        $dataList = $data->dataSiswa();
        $data->kosongkantable();
        foreach ($dataList as $k => $v) {
            if (isset($this->request->getVar('peserta')[$v['id_siswa']])) {
                $peserta = 'yes';
            } else {
                $peserta = 'no';
            }
            if (isset($this->request->getVar('persen')[$v['id_siswa']])) {
                $persen = $this->request->getVar('persen')[$v['id_siswa']];
                if ($this->request->getVar('persen')[$v['id_siswa']] == "") $persen = 0;
            } else {
                $persen = 0;
            }
            if (isset($this->request->getVar('rp')[$v['id_siswa']])) {
                $rp = $this->request->getVar('rp')[$v['id_siswa']];
                if ($this->request->getVar('rp')[$v['id_siswa']] == "") $rp = 0;
            } else {
                $rp = 0;
            }
            if (isset($this->request->getVar('id_siswa')[$v['id_siswa']])) {
                $id_siswa = $this->request->getVar('id_siswa')[$v['id_siswa']];
                $id_beasiswa = $this->request->getVar('id_beasiswa')[$v['id_siswa']];
            } else {
                $id_siswa = $v['id_siswa'];
                $id_beasiswa = "";
            }
            $dataupdate = array(
                'id_siswa' => $id_siswa,
                'peserta' => $peserta,
                'persen' => $persen,
                'rp' => $rp,
            );


            //cek data untuk edit klo enggga ada insert [belum jalan ngaco]
            /*
            $cek = $data->cekdataBeasiswa($v['id_siswa']);
            if ($cek) $data->edit($dataupdate);
            else $data->tambah($dataupdate);
            */

            //delete semua dan insert baru
            $data->tambah($dataupdate);
        }
        $dataBeasiswa = $data->listing();
        //dd($dataBeasiswa);
        $newdata = [
            'Beasiswa'  => 'Index'
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $data = array(
            'title'        => 'Data Beasiswa',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'menu'   =>  $datamenu,
            'dataList'    => $dataList,
            'dataBeasiswa'    => $dataBeasiswa,

        );
        return view('TataUsaha/V_Beasiswa', $data);
    }
}
