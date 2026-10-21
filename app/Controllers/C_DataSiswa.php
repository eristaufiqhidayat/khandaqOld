<?php

namespace App\Controllers;

use App\Models\M_DataSiswa;
use App\Models\M_Menu;

class C_DataSiswa extends BaseController
{
    public function JSON()
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $dataHelper = cekDetilSiswa($this->request->getvar('id_siswa'));
        return $this->response->setJSON($dataHelper);
    }
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('text');

        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $model = new M_DataSiswa();
        if ($this->request->getVar('nama_siswa') || $this->request->getVar('siswa_baru')) {
            $datasiswa = $model->listing2($this->request->getVar('nama_siswa'), $this->request->getVar('siswa_baru'));
        } else {
            $session = \Config\Services::session();
            $datasiswa = $model->listing2($session->getFlashdata('nama_siswa'));
            //$datasiswa = $model->listing();
        }
        $data = array(
            'title'        => 'Lembah Arafah',
            'DataSiswa'    => $datasiswa,
            'nama_siswa' => $this->request->getVar('nama_siswa'),
            'content'    => 'home/index',
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip
        );
        return view('datasiswa/V_DataSiswa', $data);
    }

    public function edit($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $session = \Config\Services::session();
        $validated =  $this->validate([
            'id_siswa'     => 'required',
            'nama_siswa' => 'required'
        ]);
        if ($validated) {
            if ($_FILES["image"]["tmp_name"]) {
                $fileImage = base64_encode(file_get_contents(addslashes($_FILES["image"]["tmp_name"])));
                $data = array(
                    'id_siswa'        => $this->request->getVar('id_siswa'),
                    'nama_siswa'    => $this->request->getVar('nama_siswa'),
                    'nis'            => $this->request->getVar('nis'),
                    'kelamin'        => $this->request->getVar('kelamin'),
                    'alamat_siswa'    => $this->request->getVar('alamat_siswa'),
                    'telpon_siswa'    => $this->request->getVar('telpon_siswa'),
                    'email'            => $this->request->getVar('email'),
                    'username'        => $this->request->getVar('username'),
                    'password'        => $this->request->getVar('password'),
                    'locked'        => $this->request->getVar('locked'),
                    'id_periode'    => $this->request->getVar('id_periode'),
                    'photo'            => $this->request->getVar('photo'),
                    'tanggal_masuk'    => $this->request->getVar('tanggal_masuk'),
                    'tempat_lahir'    => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir'    => $this->request->getVar('tanggal_lahir'),
                    'nama_ortu'        => $this->request->getVar('nama_ortu'),
                    'nisn'            => $this->request->getVar('nisn'),
                    'keterangan'    => $this->request->getVar('keterangan'),
                    'unik'            => $this->request->getVar('unik'),
                    'image'            => $fileImage
                );
            } else {
                $data = array(
                    'id_siswa'        => $this->request->getVar('id_siswa'),
                    'nama_siswa'    => $this->request->getVar('nama_siswa'),
                    'nis'            => $this->request->getVar('nis'),
                    'kelamin'        => $this->request->getVar('kelamin'),
                    'alamat_siswa'    => $this->request->getVar('alamat_siswa'),
                    'telpon_siswa'    => $this->request->getVar('telpon_siswa'),
                    'email'            => $this->request->getVar('email'),
                    'username'        => $this->request->getVar('username'),
                    'password'        => $this->request->getVar('password'),
                    'locked'        => $this->request->getVar('locked'),
                    'id_periode'    => $this->request->getVar('id_periode'),
                    'photo'            => $this->request->getVar('photo'),
                    'tanggal_masuk'    => $this->request->getVar('tanggal_masuk'),
                    'tempat_lahir'    => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir'    => $this->request->getVar('tanggal_lahir'),
                    'nama_ortu'        => $this->request->getVar('nama_ortu'),
                    'nisn'            => $this->request->getVar('nisn'),
                    'keterangan'    => $this->request->getVar('keterangan'),
                    'unik'            => $this->request->getVar('unik'),
                );
            }
            $model = new M_DataSiswa();
            $model->edit($data);
            $datasiswa = $model->listing();
            $data = array(
                'title'        => 'Lembah Arafah',
                'DataSiswa'    => $datasiswa,
                'content'    => 'home/index',
                'menu'   =>  $datamenu
            );
            $session->setFlashdata('sukses', 'Data telah diedit');
            $session->setFlashdata('nama_siswa', $this->request->getVar('nama_siswa'));
            return redirect()->to(base_url('index.php/datasiswa/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        }
    }
    public function tambah($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $session = \Config\Services::session();
        $validated =  $this->validate([
            'nama_siswa' => 'required'
        ]);
        if ($validated) {
            if ($_FILES["image"]["tmp_name"]) {
                $fileImage = base64_encode(file_get_contents(addslashes($_FILES["image"]["tmp_name"])));
            } else {
                $fileImage = "";
            }
            $data = array(
                'nama_siswa'    => $this->request->getVar('nama_siswa'),
                'nis'            => $this->request->getVar('nis'),
                'kelamin'        => $this->request->getVar('kelamin'),
                'alamat_siswa'    => $this->request->getVar('alamat_siswa'),
                'telpon_siswa'    => $this->request->getVar('telpon_siswa'),
                'email'            => $this->request->getVar('email'),
                'username'        => $this->request->getVar('username'),
                'password'        => $this->request->getVar('password'),
                'locked'        => $this->request->getVar('locked'),
                'id_periode'    => $this->request->getVar('id_periode'),
                'photo'            => $this->request->getVar('photo'),
                'tanggal_masuk'    => $this->request->getVar('tanggal_masuk'),
                'tempat_lahir'    => $this->request->getVar('tempat_lahir'),
                'tanggal_lahir'    => $this->request->getVar('tanggal_lahir'),
                'nama_ortu'        => $this->request->getVar('nama_ortu'),
                'nisn'            => $this->request->getVar('nisn'),
                'keterangan'    => $this->request->getVar('keterangan'),
                'unik'            => $this->request->getVar('unik'),
                'image'            => $fileImage
            );
            $model = new M_DataSiswa();
            $model->tambah($data);
            $session->setFlashdata('msg', 'Data telah ditambah');
            $session->setFlashdata('nama_siswa', $this->request->getVar('nama_siswa'));
            return redirect()->to(base_url('index.php/datasiswa/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        } else {
            $session->setFlashdata('error', 'Data gagal ditambah');
            return redirect()->to(base_url('index.php/datasiswa/index/' . $menuAktip . '/' . $moduleAktip));
        }
    }
    public function hapus($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $session = \Config\Services::session();
        $validated =  $this->validate([
            'id_siswa'     => 'required',
            'nama_siswa' => 'required'
        ]);
        if ($validated) {
            $data = array(
                'id_siswa'        => $this->request->getVar('id_siswa'),
                'nama_siswa'    => $this->request->getVar('nama_siswa')
            );
            $model = new M_DataSiswa();
            $model->hapus($data);
            $session->setFlashdata('msg', 'Data telah dihapus');
            return redirect()->to(base_url('index.php/datasiswa/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        } else {
            $session->setFlashdata('error', 'Data gagal dihapus');
            return redirect()->to(base_url('index.php/datasiswa/index/' . $menuAktip . '/' . $moduleAktip));
        }
    }
}
