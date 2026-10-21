<?php

namespace App\Controllers\chart;

use App\Controllers\BaseController;
use App\Models\Chart\M_Chart;
use App\Models\M_Menu;

class C_ChartSpp extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        if (user()->username) {
            helper('text');
            $menu = new M_Menu();
            $datamenu = $menu->listing();
            $dataM = new M_Chart();
            $data = $dataM->jmlsiswa();
            $sum_blmbayar_perkelas = $dataM->sum_blmbayar_perkelas();
            $beasiswa = $dataM->beasiswa2();
            $data = array(
                'title'        => 'Java Web Media - Spesialis Kursus Codeigniter',
                'content'    => 'home/index',
                'data' => $data,
                'sumBelumbayar_perkelas' => $sum_blmbayar_perkelas,
                'beasiswa' => $beasiswa,
                'menu'   =>  $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip
            );
        } else {
            return redirect()->to(site_url('/login'));
        }

        return view('chart/V_ChartSpp.php', $data);
    }
    public function login2()
    {
        helper('text');

        //return view('Home/V_Login');
        return redirect()->to(site_url('C_Home/index'));
    }
}
