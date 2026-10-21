<?php

namespace App\Controllers\orangtua;

use App\Controllers\BaseController;
use App\Models\Transaksi\M_DataKodeTransaksi;
use App\Models\Transaksi\M_DataPembayaran;
use App\Models\M_DataSiswa;
use App\Models\orangtua\M_Ortu;
use App\Models\M_Menu;


class C_Ortu extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $Mdataortu = new M_Ortu();
        $dataortu = $Mdataortu->listing(user()->username);

        $id_siswa = null;

        if ($dataortu && isset($dataortu['id_siswa'])) {
            $id_siswa = $dataortu['id_siswa'];
        }
        if ($id_siswa) {
            $menu = new M_Menu();
            $datamenu = $menu->listing();
            ####### Cek Total Pembayaran dari tbl_tabungan_transaksi ##############
            #  Sum tbl_tabungan_transaksi dari kode TDSPP / Tarif SPP = Bulan Bayar
            #  ldr = loundry kes = kesehatan
            $tahunNow = date("Y-m-d");
            $tahunAjaran = tahunajaran();
            $tahunAjaran2 = $tahunAjaran + 1;
            $dataBayar = new M_DataPembayaran();
            $sumspp = $dataBayar->sumsppPeriode($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
            $sumldr = $dataBayar->sumldrPeriode($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
            $sumkes = $dataBayar->sumkesPeriode($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");

            $tarifspp = sppkelas($id_siswa);
            $tarifldr = 100000;
            $tarifkes = 50000;
            if ($tarifspp > 0) {
                $bulanbayar = floor($sumspp['spp'] / $tarifspp);
            } else {
                $bulanbayar = 12;
            }
            $bulanbayarldr = floor($sumldr['ldr'] / $tarifldr);
            $bulanbayarkes = floor($sumkes['kes'] / $tarifkes);

            ###### cek dari helper ##############
            $datacekspp = ceksppArray($id_siswa);
            $datacekloundry = cekloundry($id_siswa);
            $datacekbeasiswa = cekbeasiswa($id_siswa);
            $dataDebitSpp = rowdebitsppsiswa($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
            $dataDebitLdr = rowdebitldrsiswa($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
            $dataDebitKes = rowdebitkessiswa($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
            $countMonth = countmonth($tahunAjaran . "-07-01", $tahunNow);
            $sumDebitSpp = sumdebitsppsiswa($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
            $sumDebitLdr = sumdebitldrsiswa($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
            $sumDebitKes = sumdebitkessiswa($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");

            ###### Buat Select Combo ########
            $modelKodeTransaksi = new M_DataKodeTransaksi();
            $dataKodeTransaksiDebet = $modelKodeTransaksi->listing2("'TDSPP', 'TDLDR', 'TDKES'");

            ###### Buat Show Modal Pilih Siswa #########
            $modelSiswa = new M_DataSiswa();
            $datasiswa = $modelSiswa->listing2('%'); //buat combo pertama
            $detilsiswa = $modelSiswa->detail2($id_siswa);
            $kodeTabunganSiswa = $modelSiswa->listingDataTabungan($id_siswa);

            ###### Buat id kode tabungan ###########
            $dataTabungan = $Mdataortu->detailTransaksi($id_siswa);

            $newdata = [
                'id_siswa'  => $id_siswa,
            ];
            $config = null;
            $session = \Config\Services::session($config);
            $session->set($newdata);

            $data = array(
                'title'        => 'Data Menu',
                'DataSiswa' => $datasiswa,
                'DetilSiswa' => $detilsiswa,
                'kodeTabungan' => $kodeTabunganSiswa,
                'DataTabunganSiswa'    => $dataTabungan,
                'dataKodeTransaksiDebet'    => $dataKodeTransaksiDebet,
                'menu'   =>  $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip,
                'session' => $session,
                'cekspp' => $datacekspp,
                'cekloundry' => $datacekloundry,
                'cekbeasiswa' => $datacekbeasiswa,
                'bulanbayar' => $bulanbayar,
                'bulanbayarldr' => $bulanbayarldr,
                'bulanbayarkes' => $bulanbayarkes,
                'dataDebitSpp' => $dataDebitSpp,
                'dataDebitLdr' => $dataDebitLdr,
                'dataDebitKes' => $dataDebitKes,
                'sumDebitSpp' => $sumDebitSpp,
                'sumDebitLdr' => $sumDebitLdr,
                'sumDebitKes' => $sumDebitKes,
                'countMonth' => $countMonth,
                'tarifspp' => $tarifspp,
                'tarifldr' => $tarifldr,
                'tarifkes' => $tarifkes,
                'tahunAjaran' => $tahunAjaran,
            );

            return view('orangtua/V_Ortu', $data);
        } else {
            $menu = new M_Menu();
            $datamenu = $menu->listing();
            $modelSiswa = new M_DataSiswa();
            $datasiswa = $modelSiswa->listing2('%');
            $newdata = [
                'start_date'  => date('Y-m-d'),
                'end_date'     => date('Y-m-d'),
            ];
            $config = null;
            $session = \Config\Services::session($config);
            $session->set($newdata);
            $data = array(
                'title'        => 'Data Menu',
                'DataSiswa'    => $datasiswa,
                'menu'   =>  $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip,
                'session' => $session
            );
            //dd($data);
            return view('orangtua/V_Ortu', $data);
        }
    }

    public function raport($menuAktip = '', $moduleAktip = '')
    {
        $menu = new M_Menu();
        $datamenu = $menu->listing();

        $Mdataortu = new M_Ortu();
        $dataortu = $Mdataortu->listing(user()->username);

        $id_siswa = null;

        if ($dataortu && isset($dataortu['id_siswa'])) {
            $id_siswa = $dataortu['id_siswa'];
        }
        $dataNilai = $Mdataortu->nilai_akhir($id_siswa);

        $config = null;
        $newdata = [
            'id_siswa'  => $id_siswa,
        ];
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $data = array(
            'title'        => 'Data Menu',
            'dataNilai'    => $dataNilai,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'session' => $session
        );
        //dd($data);
        return view('orangtua/V_NilaiSiswa', $data);
    }
}
