<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_Periode;

class C_Periode extends BaseController
{
    // Pilihan form => isi kolom setup_periode (semester enum('genap','ganjil'))
    private $semester = [
        'Ganjil' => ['semester' => 'ganjil', 'nama_semester' => 'Semester 1'],
        'Genap'  => ['semester' => 'genap', 'nama_semester' => 'Semester 2'],
    ];

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
        $baru = ['tahun_ajaran' => $tahunAjaran] + $this->semester[$namaSemester] + ['status_aktif' => 'no'];
        if ($model->sudahAda($tahunAjaran, $baru['semester'])) {
            session()->setFlashdata('error', 'Periode ' . labelPeriode($baru) . ' sudah ada.');
            return $this->kembali($menuAktip, $moduleAktip);
        }
        $model->tambah($baru);
        session()->setFlashdata('success', 'Periode ' . labelPeriode($baru) . ' ditambahkan (belum aktif).');
        return $this->kembali($menuAktip, $moduleAktip);
    }

    public function  aktifkan($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_Periode();
        $periode = $model->detail($this->request->getPost('id_periode'));
        if (!$periode) {
            session()->setFlashdata('error', 'Periode tidak ditemukan.');
        } elseif ($model->aktifkan($periode['id_periode'])) {
            session()->setFlashdata('success', labelPeriode($periode) . ' sekarang periode aktif. Lanjutkan dengan Proses ruang.');
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
            session()->setFlashdata('success', 'Periode ' . labelPeriode($periode) . ' dihapus.');
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
        session()->setFlashdata('success', "$jumlah siswa disalin ke " . labelPeriode($periode)
            . '. Siswa yang sudah tercatat (misalnya dari Naik Kelas) tidak diubah.');
        return $this->kembali($menuAktip, $moduleAktip);
    }
}
