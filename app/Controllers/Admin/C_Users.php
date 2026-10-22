<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Admin\M_Groups;
use App\Models\Admin\M_Users;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

// Halaman Pengguna: menggantikan halaman Users dan Groups Users.
class C_Users extends BaseController
{
    // Dipakai halaman Formulir TU untuk pilihan group
    public function groupjson($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_Users();
        return $this->response->setJSON($model->listGroup());
    }

    public function index($menuAktip = '', $moduleAktip = '')
    {
        $menu = new M_Menu();
        $users = new M_Users();
        $groups = new M_Groups();
        $data = array(
            'title'       => 'Pengguna',
            'menu'        => $menu->listing(),
            'users'       => $users->listingWithGroup(),
            'groups'      => $groups->listing(),
            'menuAktip'   => (int) $menuAktip,
            'moduleAktip' => (int) $moduleAktip,
        );
        return view('Admin/V_Pengguna', $data);
    }

    public function tambah($menuAktip = '', $moduleAktip = '')
    {
        $rules = [
            'username'     => 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'group_id'     => 'required|is_natural_no_zero',
            'password'     => 'required|min_length[8]',
            'pass_confirm' => 'required|matches[password]',
        ];
        if (!$this->validate($rules)) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', implode(' ', $this->validator->getErrors()));
        }

        $users = model(UserModel::class);
        $user = new User([
            'username' => trim($this->request->getPost('username')),
            'email'    => trim($this->request->getPost('email')),
            'password' => $this->request->getPost('password'),
        ]);
        $user->activate();
        if (!$users->save($user)) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', implode(' ', $users->errors()));
        }
        (new M_Users())->setGroupUser($users->getInsertID(), (int) $this->request->getPost('group_id'));
        return $this->kembali($menuAktip, $moduleAktip, 'msg', 'Pengguna ditambah');
    }

    public function edit($menuAktip = '', $moduleAktip = '')
    {
        $id = (int) $this->request->getPost('id');
        $rules = [
            'id'       => 'required|is_natural_no_zero',
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
            'group_id' => 'required|is_natural_no_zero',
            'active'   => 'permit_empty|in_list[0,1]',
        ];
        if (!$this->validate($rules)) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', implode(' ', $this->validator->getErrors()));
        }
        $active = $this->request->getPost('active') === '1' ? 1 : 0;
        $groupId = (int) $this->request->getPost('group_id');
        if ($id === (int) user_id() && (!$active || !$this->groupAdmin($groupId))) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', 'Akun Anda sendiri tidak bisa dinonaktifkan atau dikeluarkan dari group admin');
        }

        $users = new M_Users();
        $users->update($id, ['email' => trim($this->request->getPost('email')), 'active' => $active]);
        $users->setGroupUser($id, $groupId);
        return $this->kembali($menuAktip, $moduleAktip, 'msg', 'Pengguna diubah');
    }

    // Admin mengganti password user lain
    public function resetPassword($menuAktip = '', $moduleAktip = '')
    {
        $rules = [
            'id'           => 'required|is_natural_no_zero',
            'password'     => 'required|min_length[8]',
            'pass_confirm' => 'required|matches[password]',
        ];
        if (!$this->validate($rules)) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', implode(' ', $this->validator->getErrors()));
        }
        $users = model(UserModel::class);
        $user = $users->find((int) $this->request->getPost('id'));
        if (!$user) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', 'Pengguna tidak ditemukan');
        }
        $user->password = $this->request->getPost('password');
        $users->skipValidation(true)->save($user);
        return $this->kembali($menuAktip, $moduleAktip, 'msg', 'Password ' . $user->username . ' direset');
    }

    public function hapus($menuAktip = '', $moduleAktip = '')
    {
        $id = (int) $this->request->getPost('id');
        if ($id < 1) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', 'Pengguna tidak ditemukan');
        }
        if ($id === (int) user_id()) {
            return $this->kembali($menuAktip, $moduleAktip, 'error', 'Akun Anda sendiri tidak bisa dihapus');
        }
        $users = model(UserModel::class);
        (new M_Users())->deleteGroupUser($id);
        $users->delete($id, true);
        return $this->kembali($menuAktip, $moduleAktip, 'msg', 'Pengguna dihapus');
    }

    // Ganti password akun sendiri (semua user)
    public function CPass($menuAktip = '', $moduleAktip = '')
    {
        $menu = new M_Menu();
        $data = array(
            'menu'        => $menu->listing(),
            'menuAktip'   => (int) $menuAktip,
            'moduleAktip' => (int) $moduleAktip,
        );
        return view('Admin/V_CPass', $data);
    }

    public function CPassDo($menuAktip = '', $moduleAktip = '')
    {
        $validated = $this->validate([
            'password_hash' => 'required',
            'pass_confirm'  => 'required|matches[password_hash]',
        ]);
        if (!$validated) {
            return redirect()->back()->with('error', implode(' ', $this->validator->getErrors()));
        }
        $users = model(UserModel::class);
        $user = $users->find((int) user_id());
        $user->password = $this->request->getPost('password_hash');
        $users->skipValidation(true)->save($user);
        session()->setFlashdata('sukses', 'Password Sudah dirubah');
        return redirect()->to(base_url('index.php/dashboard/' . (int) $menuAktip . '/' . (int) $moduleAktip));
    }

    private function groupAdmin($groupId)
    {
        $group = (new M_Groups())->find($groupId);
        return $group && in_array($group->name, ['admin', 'superadmin'], true);
    }

    private function kembali($menuAktip, $moduleAktip, $jenis, $pesan)
    {
        return redirect()->to(base_url('index.php/users/index/' . (int) $menuAktip . '/' . (int) $moduleAktip))->with($jenis, $pesan);
    }
}
