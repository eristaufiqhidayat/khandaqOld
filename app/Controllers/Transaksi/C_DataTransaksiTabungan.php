<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\Transaksi\M_DataTransaksiTabungan;
use App\Models\Transaksi\M_DataKodeTransaksi;
use App\Models\Transaksi\M_DataPembayaran;
use App\Models\Transaksi\M_Tabungan;
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
    // ------------------------------------------------------------------
    // Halaman Tabungan Siswa (tampilan baru)
    // ------------------------------------------------------------------

    /**
     * Tarif dan potongan yang dipakai saat menyimpan setoran SPP. Harus sama dengan
     * helper debetloundry(), debetkes() dan debetadm() di cekdata_helper.php.
     */
    public const TARIF_LAUNDRY   = 100000;
    public const TARIF_KESEHATAN = 50000;
    public const POTONGAN_INFAK  = 15000;
    /** Setoran yang tidak dipotong infak (lihat saveKredit). */
    public const TANPA_INFAK = ['TKKOR', 'TKPTS', 'TKPAS'];
    /** Penarikan yang tidak boleh melebihi saldo. */
    public const CEK_SALDO = ['TDTNI', 'TDPRE'];

    /** Nama jenis transaksi yang mudah dibaca, per kode. */
    public const NAMA_JENIS = [
        'TKSPP' => 'Setoran SPP & uang saku', 'TKTRF' => 'Setoran transfer', 'TKTAB' => 'Transfer tabungan',
        'TKTNI' => 'Setoran tunai', 'TKPTS' => 'Pembayaran PTS', 'TKPAS' => 'Pembayaran PAS', 'TKKOR' => 'Koreksi admin',
        'TDSPP' => 'Bayar SPP', 'TDLDR' => 'Bayar laundry', 'TDKES' => 'Bayar kesehatan', 'TDADM' => 'Biaya administrasi',
        'TDINF' => 'Infak', 'TDTNI' => 'Penarikan tunai', 'TDPTS' => 'Bayar PTS', 'TDPAS' => 'Bayar PAS',
        'TDPRE' => 'Pengembalian dana',
    ];
    public const KET_JENIS = [
        'TKSPP' => 'Bayar SPP, laundry & kesehatan sekaligus', 'TKTRF' => 'Semua masuk saldo', 'TKTAB' => 'Pindahan dari tabungan lain',
        'TKTNI' => 'Uang diterima di kantor', 'TKPTS' => 'Biaya ujian tengah semester', 'TKPAS' => 'Biaya ujian akhir semester',
        'TKKOR' => 'Membetulkan salah catat', 'TDTNI' => 'Uang saku diambil siswa', 'TDINF' => 'Infak / sedekah',
        'TDPTS' => 'Ujian tengah semester', 'TDPAS' => 'Ujian akhir semester', 'TDADM' => 'Daftar ulang, cicilan',
        'TDPRE' => 'Saldo dikembalikan ke orang tua', 'TDSPP' => 'Potongan SPP manual', 'TDLDR' => 'Potongan laundry manual',
        'TDKES' => 'Potongan kesehatan manual',
    ];

    public function indexTabungan($menuAktip = '', $moduleAktip = '')
    {
        $session = session();
        $model   = new M_Tabungan();

        $q         = trim((string) $this->request->getGet('q'));
        $hasilCari = $q !== '' ? $model->cariSiswa($q) : [];
        $id        = (int) ($this->request->getGet('siswa') ?: $this->request->getPost('id_siswa') ?: 0);
        if (! $id && count($hasilCari) === 1) {
            $id = (int) $hasilCari[0]['id_siswa'];
        }
        if (! $id && $q === '') {
            $id = (int) $session->get('id_siswa');
        }
        $siswa = $id ? $model->siswa($id) : null;

        $data = [
            'menu'        => (new M_Menu())->listing(),
            'menuAktip'   => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'q'           => $q,
            'hasilCari'   => $hasilCari,
            'siswa'       => $siswa,
        ];
        if (! $siswa) {
            return view('Transaksi/tabungan/V_Tabungan', $data);
        }
        $session->set('id_siswa', $id);

        $kode    = $model->kodeTabungan($id);
        $taAktif = (int) tahunajaran();
        $taPilih = (string) $this->request->getGet('ta');
        $semua   = $taPilih === 'semua';
        $ta      = $semua ? $taAktif : ((int) $taPilih ?: $taAktif);
        $mulai   = $semua ? null : $ta . '-07-01';
        $sampai  = $semua ? null : ($ta + 1) . '-06-30';
        $jenis   = in_array($this->request->getGet('jenis'), ['masuk', 'keluar'], true) ? $this->request->getGet('jenis') : '';

        // Riwayat dengan saldo berjalan, lalu dibalik (terbaru di atas) dan dikelompokkan per bulan
        $rows       = $kode ? $model->riwayat($id, $mulai, $sampai) : [];
        $saldoAwal  = ($kode && $mulai) ? $model->saldo($id, $mulai) : 0.0;
        $saldoJalan = $saldoAwal;
        $masuk      = 0.0;
        $keluar     = 0.0;
        foreach ($rows as &$r) {
            $rp = (float) $r['rp'];
            if ($r['kode_tran'] === 'K') {
                $saldoJalan += $rp;
                $masuk += $rp;
            } elseif ($r['kode_tran'] === 'D') {
                $saldoJalan -= $rp;
                $keluar += $rp;
            }
            $r['saldo'] = $saldoJalan;
            $r['nama']  = self::NAMA_JENIS[$r['kodetransaksi']] ?? ($r['keterangan_kode'] ?: $r['kodetransaksi']);
        }
        unset($r);
        $jumlahSemua = count($rows);
        $rows = array_reverse(array_values(array_filter($rows, static function ($r) use ($jenis) {
            return $jenis === '' || ($jenis === 'masuk' ? $r['kode_tran'] === 'K' : $r['kode_tran'] === 'D');
        })));

        // Pembayaran bulanan tahun ajaran aktif (jumlah bulan lunas dari total potongan, mulai Juli)
        $bayar    = $kode ? $model->jumlahPerKode($id, $taAktif . '-07-01', ($taAktif + 1) . '-06-30', ['TDSPP', 'TDLDR', 'TDKES']) : ['TDSPP' => 0, 'TDLDR' => 0, 'TDKES' => 0];
        $tarifSpp = (float) sppkelas($id);
        $bulanIni = (int) date('n');
        $saku     = $kode ? $model->jumlahPerKode($id, date('Y-m-01'), date('Y-m-t'), ['TDTNI']) : [];

        $data += [
            'kode'        => $kode,
            'taAktif'     => $taAktif,
            'ta'          => $semua ? 'semua' : $ta,
            'taPilihan'   => range($taAktif, min($taAktif, $kode ? ($model->tahunPertama($id) ?? $taAktif) : $taAktif)),
            'jenis'       => $jenis,
            'riwayat'     => $rows,
            'jumlahSemua' => $jumlahSemua,
            'saldoAwal'   => $saldoAwal,
            'masuk'       => $masuk,
            'keluar'      => $keluar,
            'saldo'       => $kode ? $model->saldo($id) : 0.0,
            'saku'        => (float) ($saku['TDTNI'] ?? 0),
            'sakuN'       => (int) ($saku['TDTNI_n'] ?? 0),
            'laundry'     => $model->pesertaLaundry($id),
            'tagihan'     => [
                ['SPP', $tarifSpp, $tarifSpp > 0 ? min(12, (int) floor($bayar['TDSPP'] / $tarifSpp)) : null],
                ['Laundry', self::TARIF_LAUNDRY, min(12, (int) floor($bayar['TDLDR'] / self::TARIF_LAUNDRY))],
                ['Kesehatan', self::TARIF_KESEHATAN, min(12, (int) floor($bayar['TDKES'] / self::TARIF_KESEHATAN))],
            ],
            // Posisi bulan berjalan di tahun ajaran (0 = Juli)
            'posBulan'    => $bulanIni >= 7 ? $bulanIni - 7 : $bulanIni + 5,
        ];

        return view('Transaksi/tabungan/V_Tabungan', $data);
    }

    /** Form setor (kredit). Disimpan oleh saveKredit dengan isian yang sama seperti form lama. */
    public function formSetor($menuAktip = '', $moduleAktip = '')
    {
        $dasar = $this->dataForm($menuAktip, $moduleAktip, 'K');
        if (! is_array($dasar)) {
            return $dasar;
        }
        $id = (int) $dasar['siswa']['id_siswa'];
        [$tarifSpp, $lunasSpp] = $this->statusSpp($id);

        return view('Transaksi/tabungan/V_Setor', $dasar + [
            'taAktif'   => (int) tahunajaran(),
            'tarifSpp'  => $tarifSpp,
            'lunasSpp'  => $lunasSpp,
        ]);
    }

    /** Form tarik / bayar (debet). Disimpan oleh saveDebet. */
    public function formTarik($menuAktip = '', $moduleAktip = '')
    {
        $dasar = $this->dataForm($menuAktip, $moduleAktip, 'D');
        if (! is_array($dasar)) {
            return $dasar;
        }
        $id   = (int) $dasar['siswa']['id_siswa'];
        $saku = array_values(array_filter((new M_Tabungan())->riwayat($id, date('Y-m-01'), date('Y-m-t')), static function ($r) {
            return $r['kodetransaksi'] === 'TDTNI';
        }));

        return view('Transaksi/tabungan/V_Tarik', $dasar + ['sakuBulanIni' => $saku]);
    }

    /** Form ubah satu transaksi. Disimpan oleh edit() dengan kembali=tabungan. */
    public function formUbah($menuAktip = '', $moduleAktip = '', $notransaksi = 0)
    {
        $trx = (new M_Tabungan())->transaksi((int) $notransaksi);
        if (! $trx || ! $trx['kode_siswa']) {
            return redirect()->to(base_url('index.php/transaksi/indexTabungan/' . $menuAktip . '/' . $moduleAktip))->with('peringatan', 'Transaksi tidak ditemukan.');
        }
        session()->set('id_siswa', (int) $trx['kode_siswa']);
        $dasar = $this->dataForm($menuAktip, $moduleAktip, $trx['kode_tran'] === 'D' ? 'D' : 'K');
        if (! is_array($dasar)) {
            return $dasar;
        }

        return view('Transaksi/tabungan/V_Ubah', $dasar + ['trx' => $trx]);
    }

    /**
     * Tarif SPP siswa dan jumlah bulan SPP yang sudah lunas di tahun ajaran aktif
     * (total potongan TDSPP dibagi tarif, dihitung mulai Juli).
     */
    private function statusSpp(int $id): array
    {
        $taAktif  = (int) tahunajaran();
        $tarifSpp = (float) sppkelas($id);
        $bayar    = (new M_Tabungan())->jumlahPerKode($id, $taAktif . '-07-01', ($taAktif + 1) . '-06-30', ['TDSPP']);

        return [$tarifSpp, $tarifSpp > 0 ? min(12, (int) floor($bayar['TDSPP'] / $tarifSpp)) : 0];
    }

    /** Data bersama form setor/tarik/ubah; atau redirect bila siswa/kode tabungan belum ada. */
    private function dataForm($menuAktip, $moduleAktip, string $jenis)
    {
        $model = new M_Tabungan();
        $id    = (int) ($this->request->getGet('siswa') ?: session('id_siswa'));
        $siswa = $id ? $model->siswa($id) : null;
        $kode  = $siswa ? $model->kodeTabungan($id) : null;
        if ($siswa) {
            session()->set('id_siswa', $id);
        }
        if (! $siswa || ! $kode) {
            return redirect()->to(base_url('index.php/transaksi/indexTabungan/' . $menuAktip . '/' . $moduleAktip))
                ->with('peringatan', $siswa ? 'Siswa ini belum punya kode tabungan.' : 'Pilih siswa dulu.');
        }
        $menu = new M_Menu();
        $user = $menu->cekUsers();

        return [
            'menu'        => $menu->listing(),
            'menuAktip'   => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'siswa'       => $siswa,
            'kode'        => $kode,
            'saldo'       => $model->saldo($id),
            'laundry'     => $model->pesertaLaundry($id),
            'kodeList'    => (new M_DataKodeTransaksi())->listing($jenis, $user['name'] ?? ''),
        ];
    }

    /**
     * Cek isian setor/tarik sebelum disimpan. Helper simpan lama memakai isian ini
     * langsung di SQL, jadi bentuknya dibatasi ketat di sini.
     *
     * @return string|null pesan kesalahan, atau null bila aman
     */
    private function cekIsianTabungan(string $jenis): ?string
    {
        $id      = $this->request->getPost('id_siswa');
        $kodeTab = (string) $this->request->getPost('kode_tab_trans');
        $kode    = (string) $this->request->getPost('NKKodeTransaksi');
        $tanggal = (string) $this->request->getPost('tanggal');
        $rp      = (string) $this->request->getPost('rp');

        if (! ctype_digit((string) $id) || (int) $id <= 0) {
            return 'Siswa tidak valid.';
        }
        if (! preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})\z/', $tanggal, $t) || ! checkdate((int) $t[2], (int) $t[3], (int) $t[1])) {
            return 'Tanggal tidak valid.';
        }
        if (! preg_match('/^[0-9]+\z/', $rp) || (int) $rp <= 0) {
            return 'Jumlah harus angka lebih dari 0.';
        }
        $user    = (new M_Menu())->cekUsers();
        $boleh   = array_column((new M_DataKodeTransaksi())->listing($jenis, $user['name'] ?? ''), 'kode');
        if (! in_array($kode, $boleh, true)) {
            return 'Jenis transaksi tidak valid.';
        }
        $model = new M_Tabungan();
        $milik = db_connect('arafah')->table('tbl_tabungan_siswa')->where('kode_siswa', (int) $id)->where('kode_tab', $kodeTab)->countAllResults();
        if (! $milik) {
            return 'Kode tabungan tidak cocok dengan siswa.';
        }
        if ($jenis === 'D' && in_array($kode, self::CEK_SALDO, true) && (int) $rp > $model->saldo((int) $id)) {
            return 'Saldo tidak cukup untuk transaksi ini.';
        }
        if ($kode === 'TKSPP') {
            // Helper SPP butuh minimal satu bulan dan tarif kelas; bulan harus berurutan
            // mulai bulan pertama yang belum lunas (status lunas dihitung dari jumlah bulan).
            [$tarif, $lunas] = $this->statusSpp((int) $id);
            if ($tarif <= 0) {
                return 'Tarif SPP kelas siswa ini belum diatur. Pilih jenis setoran lain atau atur tarif SPP dulu.';
            }
            $bulan = [];
            for ($x = 1; $x <= 12; $x++) {
                if ($this->request->getPost('sppbulan' . $x) !== null) {
                    $bulan[] = $x;
                }
            }
            if (! $bulan) {
                return 'Setoran SPP harus memilih minimal satu bulan SPP. Untuk setoran uang saku saja, pilih "Setoran transfer" atau "Setoran tunai".';
            }
            if ($bulan !== range($lunas + 1, $lunas + count($bulan))) {
                return 'Bulan SPP harus berurutan mulai bulan pertama yang belum lunas.';
            }
        }

        return null;
    }

    private function kembaliKeTabungan($menuAktip, $moduleAktip)
    {
        return redirect()->to(base_url('index.php/transaksi/indexTabungan/' . $menuAktip . '/' . $moduleAktip));
    }

    public function saveKredit($menuAktip = '', $moduleAktip = '')
    {
        $galat = $this->cekIsianTabungan('K');
        if ($galat !== null) {
            return redirect()->back()->withInput()->with('peringatan', $galat);
        }
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

            $image = simpan_gambar_upload($file, FCPATH . 'uploads/tabungan', 'Bukti');
            if ($image === false) {
                return redirect()->back()->with('peringatan', PESAN_GAMBAR_DITOLAK);
            }
            $dataTambah = array(
                'notransaksi'    => null, // selalu transaksi baru
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
            $session->setFlashdata('sukses', 'Setoran tersimpan.');
            $session->set('id_siswa', $this->request->getPost('id_siswa'));
            $session->set('id_siswa', (int) $this->request->getPost('id_siswa'));
            return redirect()->to(base_url('index.php/transaksi/indexTabungan/' . $menuAktip . '/' . $moduleAktip . '?siswa=' . (int) $this->request->getPost('id_siswa')));
        } else {
            $session->setFlashdata('error', 'Data Gagal di simpan');
            $session->set('id_siswa', $this->request->getPost('id_siswa'));
            return redirect()->back()->withInput();
        }
    }
    public function saveDebet($menuAktip = '', $moduleAktip = '')
    {
        $galat = $this->cekIsianTabungan('D');
        if ($galat !== null) {
            return redirect()->back()->withInput()->with('peringatan', $galat);
        }
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

            $image = simpan_gambar_upload($file, FCPATH . 'uploads/tabungan', 'Bukti');
            if ($image === false) {
                return redirect()->back()->with('peringatan', PESAN_GAMBAR_DITOLAK);
            }
            $dataTambah = array(
                'notransaksi'    => null, // selalu transaksi baru
                'kode_tab_trans'    => $this->request->getVar('kode_tab_trans'),
                'kodetransaksi'    => $this->request->getVar('NKKodeTransaksi'),
                'tanggal'    => $this->request->getVar('tanggal'),
                'rp'    => $this->request->getVar('rp'),
                'keterangan_trans'    => $this->request->getVar('keterangan_trans'),
                'spp'    => $this->request->getVar('spp'),
                'buktitransfer'    => $image,
                'tahunajaran'    => tahunajaran(),
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
            $session->setFlashdata('sukses', 'Transaksi tersimpan.');
            //return view('Transaksi/V_DataTabunganSiswa', $data);
            $session->set('id_siswa', (int) $this->request->getPost('id_siswa'));
            return redirect()->to(base_url('index.php/transaksi/indexTabungan/' . $menuAktip . '/' . $moduleAktip . '?siswa=' . (int) $this->request->getPost('id_siswa')));
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
        if ($validated && $this->request->getPost('kembali') === 'tabungan') {
            // Dari halaman Tabungan Siswa: hanya tanggal, jenis, jumlah dan keterangan
            // yang boleh diubah; kolom lain diambil dari data yang tersimpan.
            $trx   = (new M_Tabungan())->transaksi((int) $this->request->getPost('notransaksi'));
            $user  = $menu->cekUsers();
            $boleh = $trx ? array_column((new M_DataKodeTransaksi())->listing($trx['kode_tran'] === 'D' ? 'D' : 'K', $user['name'] ?? ''), 'kode') : [];
            if ($trx) {
                $boleh[] = $trx['kodetransaksi']; // jenis lama boleh dipertahankan
            }
            $kode  = (string) $this->request->getPost('kodetransaksi');
            $tgl   = (string) $this->request->getPost('tanggal');
            $rp    = (string) $this->request->getPost('rp');
            if (! $trx || ! in_array($kode, $boleh, true) || ! preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})\z/', $tgl, $tt) || ! checkdate((int) $tt[2], (int) $tt[3], (int) $tt[1]) || ! preg_match('/^[0-9]+(\.[0-9]+)?\z/', $rp)) {
                return redirect()->back()->withInput()->with('peringatan', 'Perubahan tidak valid. Periksa tanggal, jenis, dan jumlah.');
            }
            (new M_DataTransaksiTabungan())->edit([
                'notransaksi'      => $trx['notransaksi'],
                'kode_tab_trans'   => $trx['kode_tab_trans'],
                'kodetransaksi'    => $kode,
                'tanggal'          => $tgl,
                'rp'               => $rp,
                'keterangan_trans' => trim((string) $this->request->getPost('keterangan_trans')),
                'spp'              => $trx['spp'],
                'buktitransfer'    => $trx['buktitransfer'],
                'tahunajaran'      => $trx['tahunajaran'],
            ]);

            return $this->kembaliKeTabungan($menuAktip, $moduleAktip)->with('sukses', 'Transaksi #' . $trx['notransaksi'] . ' diubah.');
        }
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
            if ($this->request->getPost('kembali') === 'tabungan') {
                return $this->kembaliKeTabungan($menuAktip, $moduleAktip)->with('sukses', 'Transaksi #' . (int) $this->request->getVar('notransaksi') . ' dihapus.');
            }

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
        $session->set('id_siswa', (int) $this->request->getPost('id_siswa'));
        return redirect()->to(base_url('index.php/transaksi/indexTabungan/' . $menuAktip . '/' . $moduleAktip . '?siswa=' . (int) $this->request->getPost('id_siswa')));
    }
}
