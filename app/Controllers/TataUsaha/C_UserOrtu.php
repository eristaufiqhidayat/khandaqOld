<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Admin\M_Users;
use App\Models\M_DataSiswa;
use App\Models\orangtua\M_Ortu;


class C_UserOrtu extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('text');

        $menu = new M_Menu();
        $datamenu = $menu->listing();
        //$model = new M_Users();
        //$datamenu2 = $model->listingOrtu();
        $dataOrtu = new M_Ortu();
        $datamenu2 = $dataOrtu->index();
        $modelSiswa = new M_DataSiswa();
        $datasiswa = $modelSiswa->listing3('%');
        $data = array(
            'title'        => 'Data Menu',
            'DataSiswa' => $datasiswa,
            'DataMenu'    => $datamenu2,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip
        );
        return view('TataUsaha/V_UserOrtu', $data);
    }
    public function aksesSiswa($menuAktip = '', $moduleAktip = '')
    {
        helper('text');
        if ($this->request->getVar('username')) {

            $menu = new M_Menu();
            $datamenu = $menu->listing();
            $dataOrtu = new M_Ortu();
            $datamenu2 = $dataOrtu->detilOrtu($this->request->getVar('username'));
            $modelSiswa = new M_DataSiswa();
            $datasiswa = $modelSiswa->listing3('%');
            $data = array(
                'title'        => 'Data Menu',
                'DataSiswa' => $datasiswa,
                'DataMenu'    => $datamenu2,
                'menu'   =>  $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip
            );
            return view('TataUsaha/V_AksesSiswa_Ortu', $data);
        } else {
            echo "error";
        }
    }
    public function aksesSiswaDo($menuAktip = '', $moduleAktip = '')
    {
        helper('text');
        if ($this->request->getPost('id_orangtua') && $this->request->getPost('cid_siswa')) {
            $dataOrtu = new M_Ortu();
            $cek = $dataOrtu->cekAkses($this->request->getPost('id_orangtua'));
            //echo $cek['id_siswa'];
            if ($cek) $dataOrtu->aksesSiswaDo($this->request->getPost('cid_siswa'), $this->request->getPost('id_orangtua'));
            else $dataOrtu->aksesSiswaDoNew($this->request->getPost('cid_siswa'), $this->request->getPost('id_orangtua'));
            $session = \Config\Services::session();
            $session->setFlashdata('msg', 'Data sukses disimpan');
            return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
        } else {
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'Data gagal disimpan id siswa tidak di cek');
            return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
        }
    }
    public function tambah_old($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $session = \Config\Services::session();

        $validated =  $this->validate([
            'username'     => 'required',
            'password_hash'     => 'required',

        ]);
        if ($validated) {
            $data = array(
                'username'    => $this->request->getVar('username'),
                'password_hash'    => password_hash(base64_encode(hash('sha384', $this->request->getVar('password_hash'), true)), PASSWORD_DEFAULT),
                'email'    => $this->request->getVar('email'),
                'active' => '1',
                'force_pass_reset' => '0',
                'ortu' => '1'
            );
            $model = new M_Users();
            $model->tambah($data);
            $model = new M_Users();
            $Cekuserid = $model->getidUser($this->request->getVar('username'));
            $model->insertGroupUser('5',  $Cekuserid['id']);
            $session->setFlashdata('sukses', 'Data telah ditambah');
            return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        }
    }
    public function editDataSiswa($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $session = \Config\Services::session();
        $validated =  $this->validate([
            'username'     => 'required',
            'password_hash'     => 'required',
        ]);
        if ($validated) {
            $data = array(
                'username'    => $this->request->getVar('username'),

            );
            $model = new M_Users();
            $model->editDataSiswa($data);
            $session->setFlashdata('msg', 'Data telah ditambah');
            return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        }
    }
    public function delete($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $session = \Config\Services::session();

        $validated =  $this->validate([
            'username'     => 'required',
            'id_orangtua' => 'required'
        ]);
        if ($validated) {
            $data = array(
                'username'    => $this->request->getVar('username'),
            );
            $data2 = array(
                'username'    => $this->request->getVar('username'),
                'id_orangtua' => $this->request->getVar('id_orangtua')
            );
            $model = new M_Users();
            $mOrangtua = new M_Ortu();
            if ($mOrangtua->hapus($this->request->getVar('id_orangtua'), $data2)) {
                $model->delete($data);
                $session->setFlashdata('msg', 'Data telah dihapus');
                return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
            } else {
                $session->setFlashdata('error', 'Data gagal dihapus');
                return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
            }
            // End masuk database
        } else {
            $session->setFlashdata('error', 'Data gagal dihapus');
            return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
        }
    }
    public function edit($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $session = \Config\Services::session();
        if ($this->request->getPost('password_hash') !== null) $pass_hass = $this->request->getPost('password_hash');
        $validated =  $this->validate([
            'username'     => 'required'
        ]);
        if ($validated) {
            $image = simpan_gambar_upload($this->request->getFile('photo'), FCPATH . 'uploads/photoortu', 'FotoOrtu');
            if ($image === false) {
                return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip))
                    ->with('peringatan', PESAN_GAMBAR_DITOLAK);
            }

            $data = array(
                'id_orangtua' => $this->request->getPost('id_orangtua'),
                'nama_orangtua' => $this->request->getPost('nama_orangtua'),
                'kelamin' => $this->request->getPost('kelamin'),
                'status_keluarga' => $this->request->getPost('status_keluarga'),
                'pekerjaan' => $this->request->getPost('pekerjaan'),
                'alamat_orangtua' => $this->request->getPost('alamat_orangtua'),
                'telpon_orangtua' => $this->request->getPost('telpon_orangtua'),
                'email' => $this->request->getPost('email'),
                'photo' => $image,
                'username'    => $this->request->getPost('username'),
                'password'    => password_hash(base64_encode(hash('sha384', $pass_hass, true)), PASSWORD_DEFAULT),
            );
            $data2 = array(
                'username'    => $this->request->getPost('username'),
                'password_hash'    => password_hash(base64_encode(hash('sha384', $pass_hass, true)), PASSWORD_DEFAULT),
                'email'    => $this->request->getPost('email'),
                'active' => '1',
                'force_pass_reset' => '0',
                'ortu' => '1'
            );
            if ($image === '') {
                unset($data['photo']); // tidak upload foto baru: foto lama tetap dipakai
            }
            $model = new M_Ortu();
            if ($model->rubah($this->request->getPost('id_orangtua'), $data)) {
                $model = new M_Users();
                $Cekuserid = $model->getidUser($this->request->getVar('username'));
                if (!$Cekuserid) {
                    $model->tambah($data2);
                    $Cekuserid = $model->getidUser($this->request->getVar('username'));
                    $model->insertGroupUser('5',  $Cekuserid['id']);
                } else {
                    $model->CPass($data2);
                    if (!$model->cekGroupUsers($Cekuserid['id'])) $model->insertGroupUser('5',  $Cekuserid['id']);
                }
                $cekuser = "";
                if (isset($Cekuserid['id'])) $cekuser = $Cekuserid['id'];
                $session->setFlashdata('msg', 'Data telah diedit' . $cekuser);
            } else {
                $session->setFlashdata('error', 'Data Gagal');
            }
            return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        } else {
            $session->setFlashdata('error', 'Data Gagal validasi');
            return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
        }
    }
    public function tambah($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $session = \Config\Services::session();
        if ($this->request->getPost('password_hash') !== null) $pass_hass = $this->request->getPost('password_hash');
        $validated =  $this->validate([
            'username'     => 'required'
        ]);
        if ($validated) {
            $image = simpan_gambar_upload($this->request->getFile('photo'), FCPATH . 'uploads/photoortu', 'FotoOrtu');
            if ($image === false) {
                return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip))
                    ->with('peringatan', PESAN_GAMBAR_DITOLAK);
            }
            $data = array(
                'id_orangtua' => $this->request->getPost('id_orangtua'),
                'nama_orangtua' => $this->request->getPost('nama_orangtua'),
                'kelamin' => $this->request->getPost('kelamin'),
                'status_keluarga' => $this->request->getPost('status_keluarga'),
                'pekerjaan' => $this->request->getPost('pekerjaan'),
                'alamat_orangtua' => $this->request->getPost('alamat_orangtua'),
                'telpon_orangtua' => $this->request->getPost('telpon_orangtua'),
                'email' => $this->request->getPost('email'),
                'photo' => $image,
                'username'    => $this->request->getPost('username'),
                'password'    => password_hash(base64_encode(hash('sha384', $pass_hass, true)), PASSWORD_DEFAULT),
            );
            $data2 = array(
                'username'    => $this->request->getPost('username'),
                'password_hash'    => password_hash(base64_encode(hash('sha384', $pass_hass, true)), PASSWORD_DEFAULT),
                'email'    => $this->request->getPost('email'),
                'active' => '1',
                'force_pass_reset' => '0',
                'ortu' => '1'
            );
            $model = new M_Ortu();
            if ($model->tambah($data)) {
                $model = new M_Users();
                $Cekuserid = $model->getidUser($this->request->getVar('username'));
                if (!$Cekuserid) {
                    $model->tambah($data2);
                    $Cekuserid = $model->getidUser($this->request->getVar('username'));
                    $model->insertGroupUser('5',  $Cekuserid['id']);
                } else {
                    $model->edit($data2);
                    if (!$model->cekGroupUsers($Cekuserid['id'])) $model->insertGroupUser('5',  $Cekuserid['id']);
                }
                $cekuser = "";
                if (isset($Cekuserid['id'])) $cekuser = $Cekuserid['id'];
                $session->setFlashdata('msg', 'Data telah diedit' . $cekuser);
            } else {
                $session->setFlashdata('error', 'Data Gagal');
            }
            return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        } else {
            $session->setFlashdata('error', 'Data Gagal validasi');
            return redirect()->to(base_url('index.php/TataUsaha/UserOrtu/index/' . $menuAktip . '/' . $moduleAktip));
        }
    }
}
