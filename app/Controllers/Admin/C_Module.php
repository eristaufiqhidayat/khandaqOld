<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\M_DataModule;

// Aksi modul (kategori menu). Tampilannya ada di halaman Menu & Modul (C_Menu).
class C_Module extends BaseController
{
    private $rules = [
        'nama_module' => 'required|max_length[100]',
        'icon'        => 'permit_empty|max_length[100]|regex_match[/^[A-Za-z0-9 \-]+$/]',
    ];

    // Halaman lama, sekarang digabung ke Menu & Modul
    public function index($menuAktip = '', $moduleAktip = '')
    {
        return redirect()->to(base_url('index.php/menu/index/' . (int) $menuAktip . '/' . (int) $moduleAktip));
    }

    // Form tambah dan ubah memakai satu modal; id_module kosong berarti tambah
    public function simpan($menuAktip = '', $moduleAktip = '')
    {
        return $this->request->getPost('id_module') ? $this->edit($menuAktip, $moduleAktip) : $this->tambah($menuAktip, $moduleAktip);
    }

    public function tambah($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->validate($this->rules)) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', implode(' ', $this->validator->getErrors()));
        }
        $model = new M_DataModule();
        if (!$model->tambahModul(trim($this->request->getPost('nama_module')), $this->icon())) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', 'Modul gagal ditambah');
        }
        return $this->kembali($menuAktip, $moduleAktip, 'msg', 'Modul ditambah');
    }

    public function edit($menuAktip = '', $moduleAktip = '')
    {
        $rules = $this->rules + ['id_module' => 'required|is_natural_no_zero'];
        if (!$this->validate($rules)) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', implode(' ', $this->validator->getErrors()));
        }
        $model = new M_DataModule();
        if (!$model->ubahModul((int) $this->request->getPost('id_module'), trim($this->request->getPost('nama_module')), $this->icon())) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', 'Modul gagal diubah');
        }
        return $this->kembali($menuAktip, $moduleAktip, 'msg', 'Modul diubah');
    }

    public function delete($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->validate(['id_module' => 'required|is_natural_no_zero'])) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', 'Modul tidak ditemukan');
        }
        $model = new M_DataModule();
        if (!$model->hapusModul((int) $this->request->getPost('id_module'))) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', 'Modul gagal dihapus');
        }
        return $this->kembali($menuAktip, $moduleAktip, 'msg', 'Modul beserta menu dan hak aksesnya dihapus');
    }

    private function icon()
    {
        return trim($this->request->getPost('icon') ?? '') ?: 'fas fa-folder';
    }

    private function kembali($menuAktip, $moduleAktip, $jenis, $pesan)
    {
        return redirect()->to(base_url('index.php/menu/index/' . (int) $menuAktip . '/' . (int) $moduleAktip))->with($jenis, $pesan);
    }
}
