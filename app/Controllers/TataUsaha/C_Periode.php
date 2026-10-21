<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_Periode;

class C_Periode extends BaseController
{
    private $semester = ['Ganjil' => '1', 'Genap' => '2'];

    public function  index($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_Periode();
        $menu = new M_Menu();
        $data = array(
            'title'        => 'Periode Akademik',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'dataperiode'    => $model->listing(),
            'jmlSiswaAktif' => $model->jumlahSiswaAktif(),
            'tahunSekarang' => (int) tahunajaran(),
            'menu'   =>  $menu->listing(),
        );
        return view('TataUsaha/V_Periode', $data);
    }

    private function kembali($menuAktip, $moduleAktip)
    {
        return redirect()->to(base_url('index.php/TataUsaha/Periode/index/' . $menuAktip . '/' . $moduleAktip));
    }

    public function  insert($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_Periode();
        $tahun = (int) $this->request->getPost('tahun');
        $namaSemester = (string) $this->request->getPost('nama_semester');
        if ($tahun < 2000 || $tahun > 2100 || !isset($this->semester[$namaSemester])) {
            session()->setFlashdata('error', 'Pilih tahun ajaran dan semester.');
            return $this->kembali($menuAktip, $moduleAktip);
        }
        $tahunAjaran = $tahun . '/' . ($tahun + 1);
        if ($model->sudahAda($tahunAjaran, $namaSemester)) {
            session()->setFlashdata('error', "Periode $tahunAjaran $namaSemester sudah ada.");
            return $this->kembali($menuAktip, $moduleAktip);
        }
        $model->tambah([
            'tahun_ajaran'  => $tahunAjaran,
            'nama_semester' => $namaSemester,
            'semester'      => $this->semester[$namaSemester],
            'status_aktif'  => 'no',
        ]);
        session()->setFlashdata('success', "Periode $tahunAjaran $namaSemester ditambahkan (belum aktif).");
        return $this->kembali($menuAktip, $moduleAktip);
    }

    public function  aktifkan($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_Periode();
        $periode = $model->detail($this->request->getPost('id_periode'));
        if (!$periode) {
            session()->setFlashdata('error', 'Periode tidak ditemukan.');
        } elseif ($model->aktifkan($periode['id_periode'])) {
            session()->setFlashdata('success', $periode['tahun_ajaran'] . ' ' . $periode['nama_semester'] . ' sekarang periode aktif. Lanjutkan dengan Proses ruang.');
        } else {
            session()->setFlashdata('error', 'Gagal mengganti periode aktif, tidak ada data yang berubah.');
        }
        return $this->kembali($menuAktip, $moduleAktip);
    }

    public function  delete($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_Periode();
        $periode = $model->detail($this->request->getPost('id_periode'));
        if (!$periode) {
            session()->setFlashdata('error', 'Periode tidak ditemukan.');
        } elseif ($periode['status_aktif'] === 'yes') {
            session()->setFlashdata('error', 'Periode aktif tidak bisa dihapus.');
        } elseif ($model->jumlahTerkait($periode['id_periode']) > 0) {
            session()->setFlashdata('error', 'Periode masih punya data tarif, ruang, jadwal, nilai, atau siswa, jadi tidak bisa dihapus.');
        } else {
            $model->hapus($periode['id_periode']);
            session()->setFlashdata('success', 'Periode ' . $periode['tahun_ajaran'] . ' ' . $periode['nama_semester'] . ' dihapus.');
        }
        return $this->kembali($menuAktip, $moduleAktip);
    }

    public function prosesRuang($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_Periode();
        $periode = $model->detail($this->request->getPost('id_periode'));
        if (!$periode || $periode['status_aktif'] !== 'yes') {
            session()->setFlashdata('error', 'Proses ruang hanya untuk periode aktif.');
            return $this->kembali($menuAktip, $moduleAktip);
        }
        $jumlah = $model->prosesRuang($periode['id_periode']);
        session()->setFlashdata('success', "$jumlah siswa disalin ke " . $periode['tahun_ajaran'] . ' ' . $periode['nama_semester']
            . '. Siswa yang sudah tercatat (misalnya dari Naik Kelas) tidak diubah.');
        return $this->kembali($menuAktip, $moduleAktip);
    }
}
