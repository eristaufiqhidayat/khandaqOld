<?php
# Nama Program  : Data Guru
# Edit terakhir : 13 Agustus 2023

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Guru\MGuru;
use App\Models\Guru\MJadwalMataPelajaran;

class CGuru extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $modelmenu = new M_Menu();
        $datamenu = $modelmenu->listing();
        $model = new MGuru();
        $dataModel = $model->findAll();
        $idjadwal = $this->request->getVar('idjadwal');
        $idguru = $this->request->getVar('idguru');
        if ($idjadwal) {
            $model->deletejadwal($idjadwal);
        }
        $data = array(
            'title'        => 'Data Module',
            'DataModel'    => $dataModel,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'idjadwal' => $idjadwal,
            'idguru' => $idguru,
        );

        return view('Guru/VGuru', $data);
    }
    public function PROFILE($menuAktip = '', $moduleAktip = '')
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $modelmenu = new M_Menu();
        $datamenu = $modelmenu->listing();
        $model = new MGuru();
        $dataModel = $model->findAll();

        $data = array(
            'title'        => 'Data Module',
            'DataModel'    => $dataModel,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );

        return view('Guru/VProfileGuru', $data);
    }
    public function JSON()
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $model = new MGuru();
        //$dataModel = $model->findAll();
        $dataModel = $model->where('locked', 'no')->findAll();
        $data = array(
            'DataModule'    => $dataModel,
        );
        return $this->response->setJSON($data);
    }
    public function JSONWALIKELAS($id_guru)
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $model = new MGuru();
        $dataModel = $model->JSONWALIKELAS($id_guru);
        $data = array(
            'DataModule'    => $dataModel,
        );
        return $this->response->setJSON($data);
    }
    public function JSONJADWALNGAJAR()
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $model = new MGuru();
        $dataModel = $model->JSONJADWAL($this->request->getVar('id_kelas'));
        $data = array(
            'DataModule'    => $dataModel,
        );
        return $this->response->setJSON($data);
    }
    public function JSONJADWALNGAJARPERGURU()
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $model = new MGuru();
        $dataModel = $model->JSONJADWALPERGURU($this->request->getVar('id_guru'));
        $data = array(
            'DataModule'    => $dataModel,
        );
        return $this->response->setJSON($data);
    }
    public function VWALIKELAS($menuAktip = '', $moduleAktip = '')
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $modelmenu = new M_Menu();
        $datamenu = $modelmenu->listing();
        $model = new MGuru();
        $dataModel = $model->JSONJADWAL($this->request->getVar('id_kelas'));
        $data = array(
            'DataModule'    => $dataModel,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'id_kelas' => $this->request->getVar('id_kelas')
        );
        return view('Guru/VJadwalMataPelajaran', $data);
    }
    public function VWALIKELASGURU($menuAktip = '', $moduleAktip = '')
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $modelmenu = new M_Menu();
        $datamenu = $modelmenu->listing();
        $model = new MGuru();
        $dataModel = $model->JSONJADWAL($this->request->getVar('id_kelas'));
        $data = array(
            'DataModule'    => $dataModel,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'id_kelas' => $this->request->getVar('id_kelas')
        );
        return view('Guru/VJadwalMataPelajaranGuru', $data);
    }
    public function tambah()
    {
        $modulemodel = new MGuru();
        $module           = new \App\Entities\EGuru();
        $module->nama_guru = $this->request->getPost('nama_guru');
        $module->nip = $this->request->getPost('nip');
        $module->kelamin = $this->request->getPost('kelamin');
        $module->alamat_guru = $this->request->getPost('alamat_guru');
        $module->telpon_guru = $this->request->getPost('telpon_guru');
        $module->username = $this->request->getPost('username');
        $module->password = $this->request->getPost('password');
        $module->locked = $this->request->getPost('locked');
        $module->gelar = $this->request->getPost('gelar');
        $module->tempat_lahir = $this->request->getPost('tempat_lahir');
        $module->tanggal_lahir = $this->request->getPost('tanggal_lahir');
        $module->agama = $this->request->getPost('agama');
        $module->email = $this->request->getPost('email');
        $module->photo = $this->request->getPost('photo');
        $module->nama_rek = $this->request->getPost('nama_rek');
        $module->bank_rek = $this->request->getPost('bank_rek');
        $module->no_rek = $this->request->getPost('no_rek');
        $modulemodel->insert($module);
        return redirect()->back()->with('messege', lang('Auth.newdata'));
    }
    public function tambahjadwal()
    {
        $modulemodel = new MJadwalMataPelajaran();
        $periode = periodeaktif();
        $module           = new \App\Entities\EJadwalMataPelajaran();
        $module->id_guru = $this->request->getPost('id_guru');
        $module->id_matapelajaran = $this->request->getPost('id_matapelajaran');
        $module->id_kelas = $this->request->getPost('id_kelas');
        $module->id_ruangkelas = $this->request->getPost('id_ruangkelas');
        $module->hari = $this->request->getPost('hari');
        $module->jam = $this->request->getPost('jam');
        $module->id_periode =  $periode['id_periode'];
        $modulemodel->insert($module);
        return redirect()->back()->with('messege', lang('Auth.newdata'));
    }
    public function edit()
    {
        $menumodel = new MGuru();
        $menumodel->update(
            $this->request->getPost('id_guru'),
            [
                "nama_guru" => $this->request->getPost('nama_guru'),
                "nip" => $this->request->getPost('nip'),
                "kelamin" => $this->request->getPost('kelamin'),
                "alamat_guru" => $this->request->getPost('alamat_guru'),
                "telpon_guru" => $this->request->getPost('telpon_guru'),
                "username" => $this->request->getPost('username'),
                "password" => $this->request->getPost('password'),
                "locked" => $this->request->getPost('locked'),
                "gelar" => $this->request->getPost('gelar'),
                "tempat_lahir" => $this->request->getPost('tempat_lahir'),
                "tanggal_lahir" => $this->request->getPost('tanggal_lahir'),
                "agama" => $this->request->getPost('agama'),
                "email" => $this->request->getPost('email'),
                "photo" => $this->request->getPost('photo'),
                "nama_rek" => $this->request->getPost('nama_rek'),
                "bank_rek" => $this->request->getPost('bank_rek'),
                "no_rek" => $this->request->getPost('no_rek'),
            ]
        );

        return redirect()->back()->with('messege', lang('Auth.updatedata'));
    }
    public function delete()
    {
        $menumodel = new MGuru();
        $menumodel->where('id_guru', $this->request->getPost('id_guru'));
        $menumodel->delete();
        return redirect()->back()->with('messege', lang('Auth.deletedata'));
    }
    public function deletejadwal($id_jadwal)
    {
        $menumodel = new MGuru();
        $menumodel->deletejadwal($id_jadwal);
    }
}
