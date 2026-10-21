<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_Kelas;

class C_Kelas extends BaseController
{

    public function  index($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_Kelas();
        $id_kelas = (string) $this->request->getVar('id_kelas');
        if ($id_kelas !== '-' && $id_kelas !== '' && !$model->kelasAda($id_kelas)) $id_kelas = '';
        $menu = new M_Menu();
        $data = array(
            'title'        => 'Data Kelas Siswa',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'dataSiswa'    => $model->dataSiswa($id_kelas),
            'dataKelas' => $model->dataKelas(),
            'jmlTanpaKelas' => $model->jumlahTanpaKelas(),
            'dataPeriodeAktif' => $model->dataPeriodeAktif(),
            'menu'   =>  $menu->listing(),
            'id_kelas' => $id_kelas,
            'session' => session()
        );
        return view('TataUsaha/VKelas', $data);
    }

    public function  update($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_Kelas();
        $session = session();
        $id_kelas = (string) $this->request->getPost('id_kelas');
        $id_kelasnew = (string) $this->request->getPost('id_kelasnew');
        $kembali = redirect()->to(base_url('index.php/TataUsaha/Kelas/index/' . $menuAktip . '/' . $moduleAktip . '?id_kelas=' . urlencode($id_kelas)));

        $periode = $model->dataPeriodeAktif();
        if (!$periode) {
            $session->setFlashdata('gagal', 'Belum ada periode aktif. Aktifkan periode dulu di menu Periode.');
            return $kembali;
        }
        if ($id_kelas === '' || !$model->kelasAda($id_kelasnew) || $id_kelasnew === $id_kelas) {
            $session->setFlashdata('gagal', 'Pilih kelas asal dan kelas tujuan yang berbeda.');
            return $kembali;
        }
        // Hanya siswa yang memang ada di kelas asal yang boleh dipindah
        $dipilih = array_map('strval', (array) $this->request->getPost('id_siswa'));
        $diKelas = array_column($model->dataSiswa($id_kelas), 'id_siswa');
        $idSiswa = array_values(array_intersect(array_map('strval', $diKelas), $dipilih));
        if (!$idSiswa) {
            $session->setFlashdata('gagal', 'Belum ada siswa yang dipilih.');
            return $kembali;
        }

        $jumlah = $model->pindahKelas($idSiswa, $id_kelasnew, $periode['id_periode']);
        if ($jumlah === false) {
            $session->setFlashdata('gagal', 'Gagal menyimpan, tidak ada data yang berubah.');
        } else {
            $session->setFlashdata('sukses', $jumlah . ' siswa berhasil dipindahkan.');
        }
        return $kembali;
    }
}
