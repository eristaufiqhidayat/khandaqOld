<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\Transaksi\M_DataTransaksiTabungan;
use App\Models\Transaksi\M_DataKodeTransaksi;
use App\Models\Transaksi\M_DataPembayaran;
use App\Models\M_DataSiswa;
use App\Models\M_Menu;

class C_DataTransaksiTabungan extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $config = null;
        $session = \Config\Services::session($config);
        // Data tabel diambil per halaman lewat readjson, di sini hanya simpan filter
        if ($this->request->getPost('start_date') && $this->request->getPost('end_date')) {
            $newdata = [
                'start_date'  => $this->request->getPost('start_date'),
                'end_date'     => $this->request->getPost('end_date'),
                'id_siswa_transaksi' => (string) $this->request->getPost('id_siswa'),
            ];
        } else {
            $newdata = [
                'start_date'  => date('Y-m-d'),
                'end_date'     => date('Y-m-d'),
                'id_siswa_transaksi' => '',
            ];
        }
        $session->set($newdata);
        $data = array(
            'title'        => 'Data Menu',
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'session' => $session
        );
        return view('Transaksi/V_DataTransaksiTabungan', $data);
    }
    public function readjson($menuAktip = '', $moduleAktip = '')
    {
        $start_date = (string) $this->request->getPost('start_date');
        $end_date = (string) $this->request->getPost('end_date');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $start_date)) $start_date = date('Y-m-d');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $end_date)) $end_date = date('Y-m-d');

        // Urutan kolom sama dengan urutan <th> di view
        $columns = [null, 'a.notransaksi', 'a.kode_tab_trans', 'a.kodetransaksi', 'a.tanggal', 'a.rp', 'a.keterangan_trans', 'a.spp', 'a.buktitransfer', 'e.nama_kelas', 'c.nama_siswa'];
        $order = $this->request->getPost('order');
        $orderIndex = isset($order[0]['column']) ? (int) $order[0]['column'] : 1;
        $orderColumn = $columns[$orderIndex] ?? 'a.notransaksi';
        if ($orderColumn === null) $orderColumn = 'a.notransaksi';
        $orderDir = (isset($order[0]['dir']) && $order[0]['dir'] === 'desc') ? 'desc' : 'asc';
        $search = $this->request->getPost('search');
        $search = isset($search['value']) ? trim($search['value']) : '';
        $offset = max(0, (int) $this->request->getPost('start'));
        $limit = (int) $this->request->getPost('length');
        if ($limit <= 0 || $limit > 500) $limit = 50;

        $model = new M_DataTransaksiTabungan();
        $result = $model->listingServerSide($start_date, $end_date, (string) $this->request->getPost('id_siswa'), $search, $orderColumn, $orderDir, $offset, $limit);
        $result['draw'] = (int) $this->request->getPost('draw');
        return $this->response->setJSON($result);
    }
    public function indexTabungan($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if ($this->request->getPost('id_siswa')) {
            $id_siswa = $this->request->getPost('id_siswa');
        } else {
            $config = null;
            $session = \Config\Services::session();
            $id_siswa = $session->get('id_siswa');
            //dd($id_siswa);
        }
        if (isset($id_siswa)) {
            $menu = new M_Menu();
            $datamenu = $menu->listing();
            $dataUser = $menu->cekUsers();
            ####### Cek Total Pembayaran dari tbl_tabungan_transaksi ##############
            #  Sum tbl_tabungan_transaksi dari kode TDSPP / Tarif SPP = Bulan Bayar
            #  ldr = loundry kes = kesehatan
            $tahunAjaran = tahunajaran();
            $tahunAjaran2 = $tahunAjaran + 1;
            $dataBayar = new M_DataPembayaran();
            $sumspp = $dataBayar->sumsppPeriode($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
            $sumldr = $dataBayar->sumldrPeriode($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
            $sumkes = $dataBayar->sumkesPeriode($id_siswa, $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");

            $tarifspp = sppkelas($id_siswa);
            $tarifldr = 100000;
            $tarifkes = 100000;
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

            ###### Buat Select Combo ########
            $modelKodeTransaksi = new M_DataKodeTransaksi();
            $dataKodeTransaksiKredit = $modelKodeTransaksi->listing('K', $dataUser["name"]); //buat select di new data
            $dataKodeTransaksiDebet = $modelKodeTransaksi->listing('D', $dataUser["name"]);

            ###### Buat Show Modal Pilih Siswa #########
            $modelSiswa = new M_DataSiswa();
            $datasiswa = $modelSiswa->listing3('%'); //buat combo pertama
            $detilsiswa = $modelSiswa->detail2($id_siswa);
            $kodeTabunganSiswa = $modelSiswa->listingDataTabungan($id_siswa);

            ###### Buat id kode tabungan ###########
            $model = new M_DataTransaksiTabungan();
            $dataTabungan = $model->detailTabunganSiswa($id_siswa);

            $newdata = [
                'id_siswa'  => $id_siswa,
            ];
            $config = null;
            $session = \Config\Services::session($config);
            $session->set($newdata);

            $data = array(
                'title'        => 'Data Menu',
                'DataSiswa' => $datasiswa,
                'DataUser' => $dataUser,
                'DetilSiswa' => $detilsiswa,
                'kodeTabungan' => $kodeTabunganSiswa,
                'DataTabunganSiswa'    => $dataTabungan,
                'dataKodeTransaksiKredit'    => $dataKodeTransaksiKredit,
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
                'tarifspp' => $tarifspp,
                'tarifldr' => $tarifldr,
                'tarifkes' => $tarifkes,
            );

            return view('Transaksi/V_DataTabunganSiswa', $data);
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
            return view('Transaksi/V_DataTabunganSiswa', $data);
        }
    }
    public function saveKredit($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $menu = new M_Menu();
        $datamenu = $menu->listing();

        $modelKodeTransaksi = new M_DataKodeTransaksi();
        $dataKodeTransaksiKredit = $modelKodeTransaksi->listing('K');
        $dataKodeTransaksiDebet = $modelKodeTransaksi->listing('D');
        ####### Cek Total Pembayaran dari tbl_tabungan_transaksi ##############
        #  Sum tbl_tabungan_transaksi dari kode TDSPP / Tarif SPP = Bulan Bayar
        #  ldr = loundry kes = kesehatan
        $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $dataBayar = new M_DataPembayaran();
        $sumspp = $dataBayar->sumsppPeriode($this->request->getPost('id_siswa'), $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
        $sumldr = $dataBayar->sumldrPeriode($this->request->getPost('id_siswa'), $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");
        $sumkes = $dataBayar->sumkesPeriode($this->request->getPost('id_siswa'), $tahunAjaran . "-07-01", $tahunAjaran2 . "-06-31");

        $tarifspp = sppkelas($this->request->getPost('id_siswa'));
        $tarifldr = 100000;
        $tarifkes = 100000;
        if ($tarifspp > 0) {
            $bulanbayar = floor($sumspp['spp'] / $tarifspp);
        } else {
            $bulanbayar = 12;
        }
        $bulanbayarldr = floor($sumldr['ldr'] / $tarifldr);
        $bulanbayarkes = floor($sumkes['kes'] / $tarifkes);

        ###### cek dari helper ##############
        $datacekspp = ceksppArray($this->request->getPost('id_siswa'));
        $datacekloundry = cekloundry($this->request->getPost('id_siswa'));
        $datacekbeasiswa = cekbeasiswa($this->request->getPost('id_siswa'));
        $file = $this->request->getFile('buktitransfer');

        $config = null;
        $session = \Config\Services::session($config);
        $validated =  $this->validate([
            'kode_tab_trans'     => 'required',
            'tanggal'     => 'required',
            'rp'     => 'required',
        ]);
        if ($validated) {
            $model = new M_DataTransaksiTabungan();
            $sppbln = sppbulan();

            if ($file && $file->isValid() && !$file->hasMoved()) {

                $ext = $file->getExtension();
                $image = 'Bukti' . time() . '.' . $ext;

                $file->move(FCPATH . 'uploads/tabungan', $image);
            } else {
                $image = '';
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
            if ($this->request->getVar('NKKodeTransaksi') == 'TKSPP') {
                $model->tambah($dataTambah);
                debetadm();
                insertspp(); //insert ke tbl_spp
                debetspp(); //memasukan TDSPP setelah TKSPP berhasil
                debetloundry();
                debetkes();
            } elseif ($this->request->getVar('NKKodeTransaksi') == 'TKKOR') {
                $model->tambah($dataTambah);
            } elseif ($this->request->getVar('NKKodeTransaksi') == 'TKPTS') {
                $model->tambah($dataTambah);
            } elseif ($this->request->getVar('NKKodeTransaksi') == 'TKPAS') {
                $model->tambah($dataTambah);
            } else {
                $model->tambah($dataTambah);
                debetadm();
            }
            //$dataTambah = ""; //engga bisa di refresh
            $modelSiswa = new M_DataSiswa();
            $detilsiswa = $modelSiswa->detail2($this->request->getPost('id_siswa'));
            $dataTabungan = $model->detailTabunganSiswa($this->request->getPost('id_siswa'));
            $kodeTabunganSiswa = $modelSiswa->listingDataTabungan($this->request->getPost('id_siswa'));
            $data = array(
                'notransaksi'    => $this->request->getVar('notransaksi'),
                'DetilSiswa' => $detilsiswa,
                'DataTabunganSiswa'    => $dataTabungan,
                'dataKodeTransaksiKredit'    => $dataKodeTransaksiKredit,
                'dataKodeTransaksiDebet'    => $dataKodeTransaksiDebet,
                'kodeTabungan' => $kodeTabunganSiswa,
                'menu'    => $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip,
                'session' => $session,
                'cekspp' => $datacekspp,
                'cekloundry' => $datacekloundry,
                'cekbeasiswa' => $datacekbeasiswa,
                'bulanbayar' => $bulanbayar,
                'bulanbayarldr' => $bulanbayarldr,
                'bulanbayarkes' => $bulanbayarkes,
                'tarifspp' => $tarifspp,
                'tarifldr' => $tarifldr,
                'tarifkes' => $tarifkes,
            );
            $session->setFlashdata('msg', 'Data Berhasil ditambah id_siswa = ' . $detilsiswa['id_siswa'] . ' nama_siswa = ' . $detilsiswa['nama_siswa']);
            $session->set('id_siswa', $this->request->getPost('id_siswa'));
            return redirect()->to(base_url('index.php/transaksi/indexTabungan/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $detilsiswa['id_siswa']);
        } else {
            $session->setFlashdata('error', 'Data Gagal di simpan');
            $session->set('id_siswa', $this->request->getPost('id_siswa'));
            return redirect()->back()->withInput();
        }
    }
    public function saveDebet($menuAktip = '', $moduleAktip = '')
    {
        $datacekspp = ceksppArray($this->request->getPost('id_siswa'));
        $datacekloundry = cekloundry($this->request->getPost('id_siswa'));
        $datacekbeasiswa = cekbeasiswa($this->request->getPost('id_siswa'));

        $modelKodeTransaksi = new M_DataKodeTransaksi();
        $dataKodeTransaksiKredit = $modelKodeTransaksi->listing('K');
        $dataKodeTransaksiDebet = $modelKodeTransaksi->listing('D');
        $file = $this->request->getFile('buktitransfer');
        helper('form');
        helper('cookie');
        $menu = new M_Menu();
        $datamenu = $menu->listing();

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

            if ($file && $file->isValid() && !$file->hasMoved()) {

                $ext = $file->getExtension();
                $image = 'Bukti' . time() . '.' . $ext;

                $file->move(FCPATH . 'uploads/tabungan', $image);
            } else {
                $image = '';
            }
            $dataTambah = array(
                'notransaksi'    => $this->request->getVar('notransaksi'),
                'kode_tab_trans'    => $this->request->getVar('kode_tab_trans'),
                'kodetransaksi'    => $this->request->getVar('NKKodeTransaksi'),
                'tanggal'    => $this->request->getVar('tanggal'),
                'rp'    => $this->request->getVar('rp'),
                'keterangan_trans'    => $this->request->getVar('keterangan_trans'),
                'spp'    => $this->request->getVar('spp'),
                'buktitransfer'    => $image,
                'tahunajaran'    => '2022',
            );


            $model->tambah($dataTambah);
            $modelSiswa = new M_DataSiswa();
            $detilsiswa = $modelSiswa->detail2($this->request->getPost('id_siswa'));
            $dataTabungan = $model->detailTabunganSiswa($this->request->getPost('id_siswa'));
            $kodeTabunganSiswa = $modelSiswa->listingDataTabungan($this->request->getPost('id_siswa'));
            $data = array(
                'notransaksi'    => $this->request->getVar('notransaksi'),
                'DetilSiswa' => $detilsiswa,
                'DataTabunganSiswa'    => $dataTabungan,
                'dataKodeTransaksiKredit'    => $dataKodeTransaksiKredit,
                'dataKodeTransaksiDebet'    => $dataKodeTransaksiDebet,
                'kodeTabungan' => $kodeTabunganSiswa,
                'menu'    => $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip,
                'session' => $session,
                'cekspp' => $datacekspp,
                'cekloundry' => $datacekloundry,
                'cekbeasiswa' => $datacekbeasiswa,
            );
            $session->setFlashdata('sukses', 'Data Berhasil ditambah');
            //return view('Transaksi/V_DataTabunganSiswa', $data);
            return redirect()->to(base_url('index.php/transaksi/indexTabungan/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $detilsiswa['id_siswa']);
            //return redirect()->to(base_url('index.php/transaksi/indexTabungan/'.$menuAktip.'/'.$moduleAktip));
            // End masuk database
        } else {
            echo "eroor";
        }
    }
    public function edit($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        //set_cookie('start_date', $this->request->getPost('start_date'));
        //set_cookie('end_date', $this->request->getPost('start_date'));
        $config = null;
        $session = \Config\Services::session($config);

        $validated =  $this->validate([
            'notransaksi'     => 'required'
        ]);
        if ($validated) {
            $model = new M_DataTransaksiTabungan();

            //Data di edit sesuai no transaksi
            $dataEdit = array(
                'notransaksi'    => $this->request->getVar('notransaksi'),
                'kode_tab_trans'    => $this->request->getVar('kode_tab_trans'),
                'kodetransaksi'    => $this->request->getVar('kodetransaksi'),
                'tanggal'    => $this->request->getVar('tanggal'),
                'rp'    => $this->request->getVar('rp'),
                'keterangan_trans'    => $this->request->getVar('keterangan_trans'),
                'spp'    => $this->request->getVar('spp'),
                'buktitransfer'    => $this->request->getVar('buktitransfer'),
                'tahunajaran'    => $this->request->getVar('tahunajaran'),
            );
            $model->edit($dataEdit);

            $data = array(
                'notransaksi'    => $this->request->getVar('notransaksi'),
                'menu'    => $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip,
                'session' => $session
            );
            $newdata = [
                'start_date'  => $this->request->getPost('start_date'),
                'end_date'     => $this->request->getPost('end_date'),
                'id_siswa_transaksi' => '',
            ];
            $session->set($newdata);
            $session->setFlashdata('sukses', 'Data telah diedit transaksi no ' . $this->request->getVar('notransaksi'));
            return view('Transaksi/V_DataTransaksiTabungan', $data);
            //return redirect()->to(base_url('index.php/transaksi/index/'.$menuAktip.'/'.$moduleAktip));
            // End masuk database
        }
    }
    public function delete($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        //set_cookie('start_date', $this->request->getPost('start_date'));
        //set_cookie('end_date', $this->request->getPost('start_date'));
        $config = null;
        $session = \Config\Services::session($config);
        $config = null;
        $validated =  $this->validate([
            'notransaksi'     => 'required'
        ]);
        if ($validated) {
            $model = new M_DataTransaksiTabungan();

            //Data di delete sesuai no transaksi
            $dataDelete = array(
                'notransaksi'    => $this->request->getVar('notransaksi'),
            );
            $model->delete($dataDelete);

            $data = array(
                'notransaksi'    => $this->request->getVar('notransaksi'),
                'menu'    => $datamenu,
                'menuAktip' => $menuAktip,
                'moduleAktip' => $moduleAktip,
                'session' => $session
            );
            $newdata = [
                'start_date'  => $this->request->getPost('start_date'),
                'end_date'     => $this->request->getPost('end_date'),
                'id_siswa_transaksi' => '',
            ];
            $session->set($newdata);
            $session->setFlashdata('sukses', 'Data telah dihapus transaksi no ' . $this->request->getVar('notransaksi'));
            return view('Transaksi/V_DataTransaksiTabungan', $data);
            //return redirect()->to(base_url('index.php/transaksi/index/'.$menuAktip.'/'.$moduleAktip));
            // End masuk database
        }
    }
    public function saveNewDataTabungan($menuAktip = '', $moduleAktip = '')
    {
        $tanggal = date('Y-m-d');
        $config = null;
        saveNewDataTabungan($this->request->getPost('id_siswa'), $this->request->getPost('kode_tab'), $tanggal);
        $session = \Config\Services::session($config);
        $session->setFlashdata('id_siswa', $this->request->getPost('id_siswa'));
        return redirect()->back()->with('id_siswa', $this->request->getPost('id_siswa'));
    }
}
