<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

// Permission sekarang dibuat otomatis dari modul (id permission = id modul).
// Halaman lama dialihkan ke Menu & Modul.
class CPermission extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        return redirect()->to(base_url('index.php/menu/index/' . (int) $menuAktip . '/' . (int) $moduleAktip));
    }
}
