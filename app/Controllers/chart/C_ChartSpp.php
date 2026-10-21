<?php

namespace App\Controllers\chart;

use App\Controllers\BaseController;
use App\Models\Chart\M_Chart;
use App\Models\M_Menu;

class C_ChartSpp extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        if (!user()->username) {
            return redirect()->to(site_url('/login'));
        }
        helper('text');
        $menu = new M_Menu();
        $datamenu = $menu->listing();

        $periode = periodeaktif();
        $tahunAjaran = (int) tahunajaran();
        // Bulan tagihan berjalan, sama dengan TIMESTAMPDIFF(MONTH, 'tahun-05-30', NOW()) lama, maksimal 12
        $selisih = (new \DateTime($tahunAjaran . '-05-30'))->diff(new \DateTime());
        $bulan = $selisih->invert ? 0 : min(12, $selisih->y * 12 + $selisih->m);

        $model = new M_Chart();
        $rekap = $model->rekapSppPerKelas($periode['id_periode'] ?? '', $tahunAjaran . '-06-30', $bulan);

        $data = array(
            'title'        => 'Rekap SPP per Kelas',
            'kelas' => $rekap['kelas'],
            'total' => $rekap['total'],
            'bulan' => $bulan,
            'tahunAjaran' => $periode['tahun_ajaran'] ?? $tahunAjaran,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip
        );
        return view('chart/V_ChartSpp.php', $data);
    }
    public function login2()
    {
        helper('text');

        //return view('Home/V_Login');
        return redirect()->to(site_url('C_Home/index'));
    }
}
