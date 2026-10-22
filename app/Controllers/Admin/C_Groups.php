<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Admin\M_DataModule;
use App\Models\Admin\M_Groups;

// Halaman Group & Hak Akses: menggantikan halaman Groups dan Permission Groups.
class C_Groups extends BaseController
{
    // Nama group yang dipakai langsung di kode (filter role, M_KodeTransaksi); tidak boleh diganti/dihapus
    public const TERKUNCI = ['admin', 'superadmin', 'admintabungan'];

    public function index($menuAktip = '', $moduleAktip = '')
    {
        $menu = new M_Menu();
        $groups = new M_Groups();
        $modul = new M_DataModule();
        $daftarGroup = $groups->listing();

        $dipilih = (int) $this->request->getGet('g');
        $ids = array_map('intval', array_column($daftarGroup, 'id'));
        if (!in_array($dipilih, $ids, true)) {
            $dipilih = $ids[0] ?? 0;
        }

        $data = array(
            'title'       => 'Group & Hak Akses',
            'terkunci'    => self::TERKUNCI,
            'menu'        => $menu->listing(),
            'groups'      => $daftarGroup,
            'dipilih'     => $dipilih,
            'modul'       => $modul->listingDenganMenu(),
            'modulGroup'  => $dipilih ? $groups->modulGroup($dipilih) : [],
            'menuAktip'   => (int) $menuAktip,
            'moduleAktip' => (int) $moduleAktip,
        );
        return view('Admin/V_GroupAkses', $data);
    }

    // Halaman lama, dialihkan
    public function indexGroupsUsers($menuAktip = '', $moduleAktip = '')
    {
        return redirect()->to(base_url('index.php/users/index/' . (int) $menuAktip . '/' . (int) $moduleAktip));
    }

    public function indexPermissionGroups($menuAktip = '', $moduleAktip = '')
    {
        return redirect()->to(base_url('index.php/groups/index/' . (int) $menuAktip . '/' . (int) $moduleAktip));
    }

    public function simpanAkses($menuAktip = '', $moduleAktip = '')
    {
        $groupId = (int) $this->request->getPost('group_id');
        $groups = new M_Groups();
        $group = $groups->find($groupId);
        if (!$group) {
            return $this->kembali($menuAktip, $moduleAktip, 0, 'error', 'Group tidak ditemukan');
        }
        $modul = array_map('intval', (array) ($this->request->getPost('modul') ?? []));
        if (!$groups->simpanModulGroup($groupId, $modul)) {
            return $this->kembali($menuAktip, $moduleAktip, $groupId, 'error', 'Hak akses gagal disimpan');
        }
        return $this->kembali($menuAktip, $moduleAktip, $groupId, 'msg', 'Hak akses ' . $group->description . ' disimpan');
    }

    // Form tambah dan ubah memakai satu modal; id kosong berarti tambah
    public function simpan($menuAktip = '', $moduleAktip = '')
    {
        return $this->request->getPost('id') ? $this->edit($menuAktip, $moduleAktip) : $this->tambah($menuAktip, $moduleAktip);
    }

    public function tambah($menuAktip = '', $moduleAktip = '')
    {
        $rules = [
            'name'        => 'required|max_length[100]|regex_match[/^[a-z0-9_]+$/]|is_unique[auth_groups.name]',
            'description' => 'required|max_length[255]',
        ];
        if (!$this->validate($rules)) {
            return $this->kembali($menuAktip, $moduleAktip, 0, 'error', implode(' ', $this->validator->getErrors()));
        }
        $groups = new M_Groups();
        $groups->insert([
            'name'        => $this->request->getPost('name'),
            'description' => trim($this->request->getPost('description')),
        ]);
        return $this->kembali($menuAktip, $moduleAktip, (int) $groups->getInsertID(), 'msg', 'Group ditambah');
    }

    public function edit($menuAktip = '', $moduleAktip = '')
    {
        $id = (int) $this->request->getPost('id');
        $rules = [
            'id'          => 'required|is_natural_no_zero',
            'name'        => "required|max_length[100]|regex_match[/^[a-z0-9_]+$/]|is_unique[auth_groups.name,id,{$id}]",
            'description' => 'required|max_length[255]',
        ];
        if (!$this->validate($rules)) {
            return $this->kembali($menuAktip, $moduleAktip, $id, 'error', implode(' ', $this->validator->getErrors()));
        }
        $groups = new M_Groups();
        $group = $groups->find($id);
        if (!$group) {
            return $this->kembali($menuAktip, $moduleAktip, 0, 'error', 'Group tidak ditemukan');
        }
        $name = in_array($group->name, self::TERKUNCI, true) ? $group->name : $this->request->getPost('name');
        $groups->update($id, ['name' => $name, 'description' => trim($this->request->getPost('description'))]);
        return $this->kembali($menuAktip, $moduleAktip, $id, 'msg', 'Group diubah');
    }

    public function delete($menuAktip = '', $moduleAktip = '')
    {
        $id = (int) $this->request->getPost('id');
        $groups = new M_Groups();
        $group = $groups->find($id);
        if (!$group) {
            return $this->kembali($menuAktip, $moduleAktip, 0, 'error', 'Group tidak ditemukan');
        }
        if (in_array($group->name, self::TERKUNCI, true)) {
            return $this->kembali($menuAktip, $moduleAktip, $id, 'error', 'Group ' . $group->name . ' dipakai sistem dan tidak bisa dihapus');
        }
        $jumlah = $groups->jumlahUser($id);
        if ($jumlah > 0) {
            return $this->kembali($menuAktip, $moduleAktip, $id, 'error', "Masih ada {$jumlah} pengguna di group ini. Pindahkan dulu di halaman Pengguna.");
        }
        $groups->hapusGroup($id);
        return $this->kembali($menuAktip, $moduleAktip, 0, 'msg', 'Group dihapus');
    }

    private function kembali($menuAktip, $moduleAktip, $groupId, $jenis, $pesan)
    {
        $url = 'index.php/groups/index/' . (int) $menuAktip . '/' . (int) $moduleAktip . ($groupId ? '?g=' . (int) $groupId : '');
        return redirect()->to(base_url($url))->with($jenis, $pesan);
    }
}
