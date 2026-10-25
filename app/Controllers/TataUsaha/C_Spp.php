<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\Transaksi\M_DataTransaksiTabungan;
use App\Models\Transaksi\M_DataKodeTransaksi;
use App\Models\Transaksi\M_DataPembayaran;
use App\Models\M_DataSiswa;
use App\Models\TataUsaha\M_DSB;
use App\Models\TataUsaha\M_DU;
use App\Models\M_Menu;

class C_Spp extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if ($this->request->getPost('id_siswa')) {
            $id_siswa = $this->request->getPost('id_siswa');
        } else {
            //$config = null;
            $session = \Config\Services::session();
            $id_siswa = $session->getflashdata('id_siswa');
        }

        if (isset($id_siswa) || $id_siswa !== null) {
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
            $rowDSB = rowDSB($id_siswa);
            $rowDU = rowDU($id_siswa);

            ###### Buat Select Combo ########
            $modelKodeTransaksi = new M_DataKodeTransaksi();
            $dataKodeTransaksiDebet = $modelKodeTransaksi->listing2("'TDSPP', 'TDLDR', 'TDKES'");

            ###### Buat Show Modal Pilih Siswa #########
            $modelSiswa = new M_DataSiswa();
            $datasiswa = $modelSiswa->listing3('%'); //buat combo pertama
            $detilsiswa = $modelSiswa->detail2($id_siswa);
            $kodeTabunganSiswa = $modelSiswa->listingDataTabungan($id_siswa);

            ###### Buat id kode tabungan ###########
            $model = new M_DataTransaksiTabungan();
            $dataTabungan = $model->detailSppSiswa($id_siswa);

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
                'rowDSB' => $rowDSB,
                'rowDU' => $rowDU
            );

            return view('TataUsaha/V_Spp', $data);
        } else {
            $menu = new M_Menu();
            $datamenu = $menu->listing();
            $modelSiswa = new M_DataSiswa();
            $datasiswa = $modelSiswa->listing3('%');
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
            return view('TataUsaha/V_Spp', $data);
        }
    }

    public function saveDebet($menuAktip = '', $moduleAktip = '')
    {

        helper('form');
        helper('cookie');

        $config = null;
        $session = \Config\Services::session($config);
        $config = null;
        $validated =  $this->validate([
            'kode_tab_trans'     => 'required',
            'tanggal'     => 'required',
            'rp'     => 'required',
        ]);
        if ($validated) {
            $model = new M_DataTransaksiTabungan();
            $sppbln = sppbulan();
            $image = simpan_gambar_upload($this->request->getFile('buktitransfer'), WRITEPATH . 'uploads', 'Bukti');
            if ($image === false) {
                return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))
                    ->with('id_siswa', $this->request->getPost('id_siswa'))
                    ->with('peringatan', PESAN_GAMBAR_DITOLAK);
            }
            $dataTambah = array(
                'notransaksi'    => $this->request->getVar('notransaksi'),
                'kode_tab_trans'    => $this->request->getVar('kode_tab_trans'),
                'kodetransaksi'    => $this->request->getVar('NKKodeTransaksi'),
                'tanggal'    => $this->request->getVar('tanggal'),
                'rp'    => $this->request->getVar('rp'),
                'keterangan_trans'    => $this->request->getVar('keterangan_trans'),
                'spp'    => $sppbln,
                'buktitransfer'    => $image,
                'tahunajaran'    => tahunajaran(),
            );
            $model->tambah($dataTambah);
            $modelSiswa = new M_DataSiswa();
            $detilsiswa = $modelSiswa->detail2($this->request->getPost('id_siswa'));

            $session->setFlashdata('sukses', 'Data Berhasil ditambah');
            return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $detilsiswa['id_siswa']);
        } else {
            echo "eroor";
        }
    }
    public function saveDSB($menuAktip = '', $moduleAktip = '')
    {

        helper('form');
        helper('cookie');
        $config = null;
        $session = \Config\Services::session($config);
        $config = null;
        $model = new M_DSB();
        $sppbln = sppbulan();
        $image = simpan_gambar_upload($this->request->getFile('buktitransfer'), WRITEPATH . 'uploads', 'Bukti');
        if ($image === false) {
            return $this->response->setStatusCode(400)->setBody(PESAN_GAMBAR_DITOLAK);
        }
        $dataTambah = array(
            'id_siswa'    => $this->request->getVar('id_siswa'),
            'tanggal'    => $this->request->getVar('tanggal'),
            'rp'    => $this->request->getVar('rp'),
            'keterangan'    => $this->request->getVar('keterangan_trans'),
            'bukti'    => $image,
            'tahunajaran'    => tahunajaran(),
        );
        $model->tambah($dataTambah);
        $session->setFlashdata('id_siswa', $this->request->getVar('id_siswa'));
        return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function saveDU($menuAktip = '', $moduleAktip = '')
    {

        helper('form');
        helper('cookie');
        $config = null;
        $session = \Config\Services::session($config);
        $config = null;
        $model = new M_DU();
        $sppbln = sppbulan();
        $image = simpan_gambar_upload($this->request->getFile('buktitransfer'), WRITEPATH . 'uploads', 'Bukti');
        if ($image === false) {
            return $this->response->setStatusCode(400)->setBody(PESAN_GAMBAR_DITOLAK);
        }
        $dataTambah = array(
            'id_siswa'    => $this->request->getVar('id_siswa'),
            'tanggal'    => $this->request->getVar('tanggal'),
            'rp'    => $this->request->getVar('rp'),
            'keterangan'    => $this->request->getVar('keterangan_trans'),
            'bukti'    => $image,
            'tahunajaran'    => tahunajaran(),
        );
        $model->tambah($dataTambah);
        $session->setFlashdata('id_siswa', $this->request->getVar('id_siswa'));
        //redirect('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip, 'refresh');
        return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function deleteDSB($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $data = array(
            "no" => $this->request->getVar('no'),
            "id_siswa" => $this->request->getVar('id_siswa')
        );
        $config = null;
        $session = \Config\Services::session($config);
        $model = new M_DSB();
        $model->hapus($this->request->getVar('no'));

        $session->setFlashdata('id_siswa', $this->request->getVar('id_siswa'));
        return json_encode($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function readjsonDSB($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $config = null;
        $session = \Config\Services::session($config);
        $model = new M_DSB();
        $dataModel = $model->readjsonDSB($this->request->getVar('id_siswa'));
        $data = array("dataModule" => $dataModel);
        $session->setFlashdata('id_siswa', $this->request->getVar('id_siswa'));
        return $this->response->setJSON($dataModel);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function deleteDU($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $data = array(
            "no" => $this->request->getVar('no'),
            "id_siswa" => $this->request->getVar('id_siswa')
        );
        $config = null;
        $session = \Config\Services::session($config);
        $model = new M_DU();
        $model->hapus($this->request->getVar('no'));

        $session->setFlashdata('id_siswa', $this->request->getVar('id_siswa'));
        return json_encode($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function readjsonDU($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $config = null;
        $session = \Config\Services::session($config);
        $model = new M_DU();
        $dataModel = $model->readjsonDU($this->request->getVar('id_siswa'));
        $data = array("dataModule" => $dataModel);
        $session->setFlashdata('id_siswa', $this->request->getVar('id_siswa'));
        return $this->response->setJSON($dataModel);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
}
