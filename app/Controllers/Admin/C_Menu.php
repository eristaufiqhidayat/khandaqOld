<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\M_DataMenu;
use App\Models\Admin\M_DataModule;
use App\Models\M_Menu;

// Halaman Menu & Modul: menggantikan halaman Module, Menu dan Permission.
class C_Menu extends BaseController
{
    private $rules = [
        'id_module' => 'required|is_natural_no_zero',
        'menu'      => 'required|max_length[100]',
        'path'      => 'required|max_length[150]|regex_match[/^[A-Za-z0-9_\/\-]+$/]',
        'icon'      => 'permit_empty|max_length[100]|regex_match[/^[A-Za-z0-9 \-]+$/]',
    ];

    public function index($menuAktip = '', $moduleAktip = '')
    {
        $menu = new M_Menu();
        $model = new M_DataModule();
        $data = array(
            'title'       => 'Menu & Modul',
            'menu'        => $menu->listing(),
            'modul'       => $model->listingDenganMenu(),
            'menuAktip'   => (int) $menuAktip,
            'moduleAktip' => (int) $moduleAktip,
        );
        return view('Admin/V_MenuModul', $data);
    }

    // Form tambah dan ubah memakai satu modal; id_menu kosong berarti tambah
    public function simpan($menuAktip = '', $moduleAktip = '')
    {
        return $this->request->getPost('id_menu') ? $this->edit($menuAktip, $moduleAktip) : $this->tambah($menuAktip, $moduleAktip);
    }

    public function tambah($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->validate($this->rules)) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', implode(' ', $this->validator->getErrors()));
        }
        $model = new M_DataMenu();
        $model->tambah($this->dataForm());
        return $this->kembali($menuAktip, $moduleAktip, 'msg', 'Menu ditambah');
    }

    public function edit($menuAktip = '', $moduleAktip = '')
    {
        $rules = $this->rules + ['id_menu' => 'required|is_natural_no_zero'];
        if (!$this->validate($rules)) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', implode(' ', $this->validator->getErrors()));
        }
        $model = new M_DataMenu();
        $model->ubah((int) $this->request->getPost('id_menu'), $this->dataForm());
        return $this->kembali($menuAktip, $moduleAktip, 'msg', 'Menu diubah');
    }

    public function delete($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->validate(['id_menu' => 'required|is_natural_no_zero'])) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', 'Menu tidak ditemukan');
        }
        $model = new M_DataMenu();
        $model->hapus((int) $this->request->getPost('id_menu'));
        return $this->kembali($menuAktip, $moduleAktip, 'msg', 'Menu dihapus');
    }

    private function dataForm()
    {
        return array(
            'id_module' => (int) $this->request->getPost('id_module'),
            'menu'      => trim($this->request->getPost('menu')),
            'path'      => trim($this->request->getPost('path'), " /"),
            'icon'      => trim($this->request->getPost('icon') ?? '') ?: 'far fa-circle',
        );
    }

    private function kembali($menuAktip, $moduleAktip, $jenis, $pesan)
    {
        return redirect()->to(base_url('index.php/menu/index/' . (int) $menuAktip . '/' . (int) $moduleAktip))->with($jenis, $pesan);
    }
}
