<?php

namespace App\Controllers\Nilai;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Nilai\M_UploadNilai;


class C_UploadNilai extends BaseController
{
    public function  index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if ($this->request->getPost('id_siswa')) {
            $id_siswa = $this->request->getPost('id_siswa');
        } else {
            //$config = null;
            $session = \Config\Services::session();
            $id_siswa = $session->getflashdata('id_siswa');
        }

        if (isset($id_siswa) || $id_siswa !== null) {
            $menu = new M_Menu();
            $datamenu = $menu->listing();


            ###### Buat Show Modal Pilih Siswa #########
            $modelSiswa = new M_UploadNilai();
            $datasiswa = $modelSiswa->dataSiswa(); //buat combo pertama
            $detilsiswa = $modelSiswa->detail2($id_siswa);

            $dataNilai = $modelSiswa->detail($id_siswa);
            $dataListNilai = $modelSiswa->listing($id_siswa);
            $periode = $modelSiswa->periode();
            $newdata = [
                'id_siswa'  => $id_siswa,
            ];
            $config = null;
            $session = \Config\Services::session($config);
            $session->set($newdata);

            $data = array(
                'title'        => 'Data Menu',
                'periode' => $periode,
                'DataSiswa' => $datasiswa,
                'DetilSiswa' => $detilsiswa,
                'DataNilai' => $dataNilai,
                'dataListNilai' => $dataListNilai,
                'menu'   =>  $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip,
                'session' => $session,
            );

            return view('Nilai/V_UploadNilai', $data);
        } else {
            $menu = new M_Menu();
            $datamenu = $menu->listing();
            $modelSiswa = new M_UploadNilai();
            $datasiswa = $modelSiswa->dataSiswa();
            $newdata = [
                'start_date'  => date('Y-m-d'),
                'end_date'     => date('Y-m-d'),
            ];
            $config = null;
            $session = \Config\Services::session($config);
            $session->set($newdata);
            $data = array(
                'title'        => 'Data Menu',
                'DataSiswa'    => $datasiswa,
                'menu'   =>  $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip,
                'session' => $session
            );
            //dd($data);
            return view('Nilai/V_UploadNilai', $data);
        }
    }
    public function tambah($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $session = \Config\Services::session();
        $validated =  $this->validate([
            'id_siswa' => 'required',
            'id_periode' => 'required',
        ]);
        if ($validated) {
            $model = new M_UploadNilai();
            if ($_FILES["image"]["tmp_name"]) {
                $fileImage = base64_encode(file_get_contents(addslashes($_FILES["image"]["tmp_name"])));
            } else {
                $fileImage = "";
            }
            $data = array(
                'id_siswa'    => $this->request->getVar('id_siswa'),
                'id_periode' => $this->request->getVar('id_periode'),
                'keterangan' => $this->request->getVar('keterangan'),
                'mime' => 'pdf',
                'image'       => $fileImage
            );
            
            $model->tambah($data);
            $session->setFlashdata('msg', 'Data telah ditambah');
            $session->setFlashdata('id_siswa', $this->request->getVar('id_siswa'));
            return redirect()->to(base_url('index.php/Nilai/index/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        } else {
            $session->setFlashdata('error', 'Data gagal ditambah');
            $session->setFlashdata('id_siswa', $this->request->getVar('id_siswa'));
            return redirect()->to(base_url('index.php/Nilai/index/' . $menuAktip . '/' . $moduleAktip));
        }
    }
}
