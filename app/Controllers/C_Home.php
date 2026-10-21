<?php

namespace App\Controllers;

use App\Models\Chart\M_Chart;
use App\Models\M_Menu;

class C_Home extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        if (isset(user()->username)) {
            helper('text');
            #$json_berita = file_get_contents('https://restapi.lembaharafah.com/public/index.php/BERITA/553da6a93aa6c69f0363048aa677efee');
            $json_berita = '';//file_get_contents('https://restapi.lembaharafah.com/public/index.php/BERITA/553da6a93aa6c69f0363048aa677efee');
            #$json_kalender = file_get_contents('https://restapi.lembaharafah.com/public/index.php/KALENDER/553da6a93aa6c69f0363048aa677efee');
            $json_kalender = '';//file_get_contents('https://restapi.lembaharafah.com/public/index.php/KALENDER/553da6a93aa6c69f0363048aa677efee');
            $dataBerita = json_decode($json_berita, true);
            $dataKalender = json_decode($json_kalender, true);
            $menu = new M_Menu();
            $datamenu = $menu->listing();
            $data = new M_Chart();
            $data = $data->beasiswa();
            $data = array(
                'title'        => '',
                'content'    => 'home/index',
                'data' => $data,
                'dataBerita' => $dataBerita,
                'dataKalender' => $dataKalender,
                'menu'   =>  $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip
            );
        } else {
            return redirect()->to(site_url('/login'));
        }

        return view('Home/V_Dasboard', $data);
    }
    public function login2()
    {
        helper('text');

        //return view('Home/V_Login');
        return redirect()->to(site_url('C_Home/index'));
    }
}
