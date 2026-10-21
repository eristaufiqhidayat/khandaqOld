<?php

namespace App\Controllers\Nilai;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Nilai\MNilaiSiswa;

class CNilaiSiswa extends BaseController
{
    public function indexguru($menuAktip = '', $moduleAktip = '')
    {
        $modelmenu = new M_Menu();
        $datamenu = $modelmenu->listing();

        # Setelah tambah data nilai nampung session
        (session('id_kelas')) ? $id_kelas = session('id_kelas') : $id_kelas = $this->request->getVar("id_kelas");
        (session('id_matapelajaran')) ? $id_matapelajaran = session('id_matapelajaran') : $id_matapelajaran = $this->request->getVar("id_matapelajaran");

        $data = array(
            'title'        => 'Data Module',
            //'DataModule'    => $dataModel,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'id_kelas' =>  $id_kelas,
            'id_matapelajaran' => $id_matapelajaran,
            'id_nilai' => $this->request->getVar("id_nilai"),
            'id_siswa' => $this->request->getVar("id_siswa")
        );
        #di hapus supaya kembali ke index awal
        $session = \Config\Services::session();
        $session->remove('id_kelas');
        $session->remove('id_matapelajaran');
        return view('Nilai/VNilaiSiswaGuru', $data);
    }
    public function index($menuAktip = '', $moduleAktip = '')
    {
        $modelmenu = new M_Menu();
        $datamenu = $modelmenu->listing();

        # Setelah tambah data nilai nampung session
        (session('id_kelas')) ? $id_kelas = session('id_kelas') : $id_kelas = $this->request->getVar("id_kelas");
        (session('id_matapelajaran')) ? $id_matapelajaran = session('id_matapelajaran') : $id_matapelajaran = $this->request->getVar("id_matapelajaran");

        $data = array(
            'title'        => 'Data Module',
            //'DataModule'    => $dataModel,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'id_kelas' =>  $id_kelas,
            'id_matapelajaran' => $id_matapelajaran,
            'id_nilai' => $this->request->getVar("id_nilai"),
            'id_siswa' => $this->request->getVar("id_siswa")
        );
        #di hapus supaya kembali ke index awal
        $session = \Config\Services::session();
        $session->remove('id_kelas');
        $session->remove('id_matapelajaran');
        return view('Nilai/VNilaiSiswa', $data);
    }
    public function JSON()
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $model = new MNilaiSiswa();
        $dataModel = $model->listing($this->request->getvar('id_kelas'), $this->request->getvar('id_matapelajaran'));
        $data = array(
            'DataModule'    => $dataModel,
        );
        return $this->response->setJSON($data);
    }
    public function JSONCEKGURU()
    {
        $auth = service('authentication');
        $id_periode = periodeaktif()['id_periode'];
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $dataHelper = cekDataGuruNilai($this->request->getvar('id_matapelajaran'), $id_periode);
        return $this->response->setJSON($dataHelper);
    }
    public function JSONCEKNILAI()
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }

        $dataHelper = cekDataNilai($this->request->getvar('id_nilai'));
        return $this->response->setJSON($dataHelper);
    }
    public function JSONCEKKELAS()
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $dataHelper = cekDataKelasNilai($this->request->getvar('id_siswa'));
        return $this->response->setJSON($dataHelper);
    }
    public function edit()
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $menumodel = new MNilaiSiswa();

        (!$this->request->getPost('H1') && $this->request->getPost('H1') == 0) ? $H1 = null : $H1 = $this->request->getPost('H1');
        (!$this->request->getPost('H2') && $this->request->getPost('H2') == 0) ? $H2 = null : $H2 = $this->request->getPost('H2');
        (!$this->request->getPost('H3') && $this->request->getPost('H3') == 0) ? $H3 = null : $H3 = $this->request->getPost('H3');
        (!$this->request->getPost('H4') && $this->request->getPost('H4') == 0) ? $H4 = null : $H4 = $this->request->getPost('H4');
        (!$this->request->getPost('H5') && $this->request->getPost('H5') == 0) ? $H5 = null : $H5 = $this->request->getPost('H5');
        (!$this->request->getPost('H6') && $this->request->getPost('H6') == 0) ? $H6 = null : $H6 = $this->request->getPost('H6');
        (!$this->request->getPost('H7') && $this->request->getPost('H7') == 0) ? $H7 = null : $H7 = $this->request->getPost('H7');
        (!$this->request->getPost('H8') && $this->request->getPost('H8') == 0) ? $H8 = null : $H8 = $this->request->getPost('H8');
        (!$this->request->getPost('K1') && $this->request->getPost('K1') == 0) ? $K1 = null : $K1 = $this->request->getPost('K1');
        (!$this->request->getPost('K2') && $this->request->getPost('K2') == 0) ? $K2 = null : $K2 = $this->request->getPost('K2');
        (!$this->request->getPost('K3') && $this->request->getPost('K3') == 0) ? $K3 = null : $K3 = $this->request->getPost('K3');
        (!$this->request->getPost('K4') && $this->request->getPost('K4') == 0) ? $K4 = null : $K4 = $this->request->getPost('K4');
        (!$this->request->getPost('K5') && $this->request->getPost('K5') == 0) ? $K5 = null : $K5 = $this->request->getPost('K5');
        (!$this->request->getPost('K6') && $this->request->getPost('K6') == 0) ? $K6 = null : $K6 = $this->request->getPost('K6');
        (!$this->request->getPost('K7') && $this->request->getPost('K7') == 0) ? $K7 = null : $K7 = $this->request->getPost('K7');
        (!$this->request->getPost('K8') && $this->request->getPost('K8') == 0) ? $K8 = null : $K8 = $this->request->getPost('K8');
        (!$this->request->getPost('HUTS') && $this->request->getPost('HUTS') == 0) ? $HUTS = null : $HUTS = $this->request->getPost('HUTS');
        (!$this->request->getPost('HUAS') && $this->request->getPost('HUAS') == 0) ? $HUAS = null : $HUAS = $this->request->getPost('HUAS');
        (!$this->request->getPost('HPKTS') && $this->request->getPost('HPKTS') == 0) ? $HPKTS = null : $HPKTS = $this->request->getPost('HPKTS');
        (!$this->request->getPost('HPKAS') && $this->request->getPost('HPKAS') == 0) ? $HPKAS = null : $HPKAS = $this->request->getPost('HPKAS');

        $menumodel->update(
            $this->request->getPost('id_nilai'),
            [
                "H1" => $H1,
                "H2" => $H2,
                "H3" => $H3,
                "H4" => $H4,
                "H5" => $H5,
                "H6" => $H6,
                "H7" => $H7,
                "H8" => $H8,
                "K1" => $K1,
                "K2" => $K2,
                "K3" => $K3,
                "K4" => $K4,
                "K5" => $K5,
                "K6" => $K6,
                "K7" => $K7,
                "K8" => $K8,
                "nilai_uts" => $HUTS,
                "nilai_uas" => $HUAS,
                "HPKTS" => $HPKTS,
                "HPKAS" => $HPKAS,

            ]
        );
        $session = \Config\Services::session();
        $session->set('id_kelas', $this->request->getPost('id_kelas'));
        $session->set('id_matapelajaran', $this->request->getPost('id_matapelajaran'));
        return redirect()->back()->with('messege', lang('Auth.updatedata'));
    }
    public function tambah()
    {
        $id_periode = periodeaktif()['id_periode'];
        (!$this->request->getPost('H1') && $this->request->getPost('H1') == 0) ? $H1 = null : $H1 = $this->request->getPost('H1');
        (!$this->request->getPost('H2') && $this->request->getPost('H2') == 0) ? $H2 = null : $H2 = $this->request->getPost('H2');
        (!$this->request->getPost('H3') && $this->request->getPost('H3') == 0) ? $H3 = null : $H3 = $this->request->getPost('H3');
        (!$this->request->getPost('H4') && $this->request->getPost('H4') == 0) ? $H4 = null : $H4 = $this->request->getPost('H4');
        (!$this->request->getPost('H5') && $this->request->getPost('H5') == 0) ? $H5 = null : $H5 = $this->request->getPost('H5');
        (!$this->request->getPost('H6') && $this->request->getPost('H6') == 0) ? $H6 = null : $H6 = $this->request->getPost('H6');
        (!$this->request->getPost('H7') && $this->request->getPost('H7') == 0) ? $H7 = null : $H7 = $this->request->getPost('H7');
        (!$this->request->getPost('H8') && $this->request->getPost('H8') == 0) ? $H8 = null : $H8 = $this->request->getPost('H8');
        (!$this->request->getPost('K1') && $this->request->getPost('K1') == 0) ? $K1 = null : $K1 = $this->request->getPost('K1');
        (!$this->request->getPost('K2') && $this->request->getPost('K2') == 0) ? $K2 = null : $K2 = $this->request->getPost('K2');
        (!$this->request->getPost('K3') && $this->request->getPost('K3') == 0) ? $K3 = null : $K3 = $this->request->getPost('K3');
        (!$this->request->getPost('K4') && $this->request->getPost('K4') == 0) ? $K4 = null : $K4 = $this->request->getPost('K4');
        (!$this->request->getPost('K5') && $this->request->getPost('K5') == 0) ? $K5 = null : $K5 = $this->request->getPost('K5');
        (!$this->request->getPost('K6') && $this->request->getPost('K6') == 0) ? $K6 = null : $K6 = $this->request->getPost('K6');
        (!$this->request->getPost('K7') && $this->request->getPost('K7') == 0) ? $K7 = null : $K7 = $this->request->getPost('K7');
        (!$this->request->getPost('K8') && $this->request->getPost('K8') == 0) ? $K8 = null : $K8 = $this->request->getPost('K8');
        (!$this->request->getPost('HUTS') && $this->request->getPost('HUTS') == 0) ? $HUTS = null : $HUTS = $this->request->getPost('HUTS');
        (!$this->request->getPost('HUAS') && $this->request->getPost('HUAS') == 0) ? $HUAS = null : $HUAS = $this->request->getPost('HUAS');
        (!$this->request->getPost('HPKTS') && $this->request->getPost('HPKTS') == 0) ? $HPKTS = null : $HPKTS = $this->request->getPost('HPKTS');
        (!$this->request->getPost('HPKAS') && $this->request->getPost('HPKAS') == 0) ? $HPKAS = null : $HPKAS = $this->request->getPost('HPKAS');
        $perhitungan_nilai = cekPerhitunganNilaiActive()["id"];
        $modulemodel = new MNilaiSiswa();
        $module           = new \App\Entities\ENilaiSiswa();
        $module->id_guru = $this->request->getPost('id_guru');
        $module->id_matapelajaran = $this->request->getPost('id_matapelajaran');
        $module->id_kelas = $this->request->getPost('id_kelas');
        $module->id_siswa = $this->request->getPost('id_siswa');
        $module->H1 = $H1;
        $module->H2 = $H2;
        $module->H3 = $H3;
        $module->H4 = $H4;
        $module->H5 = $H5;
        $module->H6 = $H6;
        $module->H7 = $H7;
        $module->H8 = $H8;
        $module->K1 = $K1;
        $module->K2 = $K2;
        $module->K3 = $K3;
        $module->K4 = $K4;
        $module->K5 = $K5;
        $module->K6 = $K6;
        $module->K7 = $K7;
        $module->K8 = $K8;
        $module->id_periode = $id_periode;
        $module->nilai_uts = $HUTS;
        $module->nilai_uas = $HUAS;
        $module->HPKAS = $HPKAS;
        $module->HPKTS = $HPKTS;
        $module->perhitungan_nilai = $perhitungan_nilai;

        $session = \Config\Services::session();
        $session->set('id_kelas', $this->request->getPost('id_kelas'));
        $session->set('id_matapelajaran', $this->request->getPost('id_matapelajaran'));


        $cek = cekDataNilaiTambah($this->request->getPost('id_siswa'), $this->request->getPost('id_guru'), $this->request->getPost('id_matapelajaran'), $id_periode);
        if (!isset($module->id_guru) || !isset($module->id_matapelajaran) || !isset($module->id_siswa)) return redirect()->back()->with('error', lang('Error !!! Data Guru dan Data Pelajaran tidak di pilih'));
        if (!isset($cek)) {
            $modulemodel->insert($module);
            return redirect()->back()->with('messege', lang('Auth.newdata'));
        } else {
            return redirect()->back()->with('error', lang('Data Sudah ada'));
        }
    }
}
