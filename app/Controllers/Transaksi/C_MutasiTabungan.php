<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\Transaksi\M_DataTransaksiTabungan;
use App\Models\Transaksi\M_DataKodeTransaksi;
use App\Models\M_Menu;

class C_MutasiTabungan extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $modelKodeTransaksi = new M_DataKodeTransaksi();
        $dataKodeTransaksi = $modelKodeTransaksi->listing('D');

        if ($this->request->getPost('start_date') && $this->request->getPost('end_date')) {
            $menu = new M_Menu();
            $datamenu = $menu->listing();
            $model = new M_DataTransaksiTabungan();
            $newdata = [
                'start_date'  => $this->request->getPost('start_date'),
                'end_date'     => $this->request->getPost('end_date'),
            ];
            $config = null;
            $session = \Config\Services::session($config);
            $session->set($newdata);
            $datamenu2 = $model->listingMutasi(
                $this->request->getPost('start_date'),
                $this->request->getPost('end_date'),
                $this->request->getPost('KodeTransaksi')
            );
            $data = array(
                'title'        => 'Data Menu',
                'dataKodeTransaksi' => $dataKodeTransaksi,
                'DataTransaksiTabungan'    => $datamenu2,
                'menu'   =>  $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip,
                'getKodeTransaksi' => $this->request->getPost('KodeTransaksi'),
                'session' => $session
            );
            //var_dump($data);
            return view('Transaksi/V_MutasiTabungan', $data);
        } else {
            $start_date =  date('Y-m-d');
            $end_date = date('Y-m-d');
            $menu = new M_Menu();
            $menu = $menu->listing();
            $model = new M_DataTransaksiTabungan();
            $datamenu2 = $model->listingMutasi($start_date, $end_date, 'TDTNI');

            $newdata = [
                'start_date'  => date('Y-m-d'),
                'end_date'     => date('Y-m-d'),
            ];

            $config = null;
            $session = \Config\Services::session($config);
            $session->set($newdata);
            $data = array(
                'title'        => 'Data Menu',
                'dataKodeTransaksi' => $dataKodeTransaksi,
                'DataTransaksiTabungan'    => $datamenu2,
                'menu'   =>  $menu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip,
                'session' => $session
            );
            return view('Transaksi/V_MutasiTabungan', $data);
        }
    }
}
