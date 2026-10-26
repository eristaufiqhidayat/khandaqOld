<?php

namespace App\Controllers;

use App\Models\M_DataSiswa;
use App\Models\M_Menu;

class C_DataSiswa extends BaseController
{
    private const PER_HALAMAN = 25;

    /** Detail siswa (JSON), masih dipakai halaman lain. */
    public function JSON()
    {
        $auth = service('authentication');
        if (!$auth->check()) {
            session()->set('redirect_url', current_url());
            return redirect()->route('login');
        }
        $dataHelper = cekDetilSiswa($this->request->getvar('id_siswa'));
        return $this->response->setJSON($dataHelper);
    }

    // ------------------------------------------------------------------
    // Daftar siswa
    // ------------------------------------------------------------------

    public function index($menuAktip = '', $moduleAktip = '')
    {
        $model  = new M_DataSiswa();
        $filter = $this->filter();
        $hitung = $model->hitungPerStatus($filter);
        $total  = $filter['status'] === '' ? $hitung['semua'] : $hitung[$filter['status']];

        $jmlHalaman = max(1, (int) ceil($total / self::PER_HALAMAN));
        $halaman    = min(max(1, (int) $this->request->getGet('hal')), $jmlHalaman);

        $siswa = $model->cariSiswa($filter, self::PER_HALAMAN, ($halaman - 1) * self::PER_HALAMAN);
        foreach ($siswa as &$s) {
            $s['kelengkapan'] = M_DataSiswa::kelengkapan($s);
        }
        unset($s);

        return view('datasiswa/V_DaftarSiswa', [
            'menu'         => (new M_Menu())->listing(),
            'menuAktip'    => $menuAktip,
            'moduleAktip'  => $moduleAktip,
            'siswa'        => $siswa,
            'filter'       => $filter,
            'hitung'       => $hitung,
            'total'        => $total,
            'halaman'      => $halaman,
            'jmlHalaman'   => $jmlHalaman,
            'perHalaman'   => self::PER_HALAMAN,
            'kelas'        => $model->daftarKelas(),
            'periodeAktif' => periodeaktif(),
        ]);
    }

    /** Unduh daftar siswa (sesuai filter yang sedang dipakai) sebagai CSV untuk Excel. */
    public function ekspor($menuAktip = '', $moduleAktip = '')
    {
        $rows = (new M_DataSiswa())->semuaSiswa($this->filter());

        $f = fopen('php://temp', 'w+');
        fwrite($f, "\xEF\xBB\xBF"); // BOM supaya Excel membaca UTF-8
        fputcsv($f, ['Nama siswa', 'NIS', 'NISN', 'L/P', 'Kelas', 'Status', 'Tempat lahir', 'Tanggal lahir',
            'Nama orang tua', 'No. HP', 'Email', 'Alamat', 'Tanggal masuk', 'Keterangan'], ';');
        foreach ($rows as $r) {
            $baris = [
                $r['nama_siswa'], $r['nis'], $r['nisn'], M_DataSiswa::kodeKelamin($r['kelamin']) ?: $r['kelamin'],
                $r['nama_kelas'], M_DataSiswa::STATUS[$r['locked']] ?? $r['locked'], $r['tempat_lahir'],
                $r['tanggal_lahir'], $r['nama_ortu'], $r['telpon_siswa'], $r['email'], $r['alamat_siswa'],
                $r['tanggal_masuk'], $r['keterangan'],
            ];
            // Cegah isi sel dibaca Excel sebagai rumus
            $baris = array_map(static function ($v) {
                $v = (string) $v;
                return ($v !== '' && strpos('=+-@', $v[0]) !== false) ? "'" . $v : $v;
            }, $baris);
            fputcsv($f, $baris, ';');
        }
        rewind($f);
        $csv = stream_get_contents($f);
        fclose($f);

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="data-siswa-' . date('Ymd') . '.csv"')
            ->setBody($csv);
    }

    /** Foto siswa (disimpan base64 di data_siswa.image). */
    public function foto($id_siswa = 0)
    {
        $b64 = (new M_DataSiswa())->fotoSiswa((int) $id_siswa);
        $bin = $b64 !== null ? base64_decode($b64, true) : false;
        if ($bin === false || $bin === '') {
            return $this->response->setStatusCode(404);
        }
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($bin);
        if (! in_array($mime, ['image/jpeg', 'image/png', 'image/webp', 'image/gif'], true)) {
            return $this->response->setStatusCode(404);
        }

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('X-Content-Type-Options', 'nosniff')
            ->setHeader('Cache-Control', 'private, max-age=600')
            ->setBody($bin);
    }

    // ------------------------------------------------------------------
    // Form tambah / ubah
    // ------------------------------------------------------------------

    public function tambahForm($menuAktip = '', $moduleAktip = '')
    {
        $periodeAktif = periodeaktif();
        $siswa = array_fill_keys(M_DataSiswa::KOLOM_FORM, '');
        $siswa['id_siswa']      = '';
        $siswa['locked']        = 'baru';
        $siswa['id_periode']    = $periodeAktif['id_periode'] ?? '';
        $siswa['tanggal_masuk'] = date('Y-m-d');
        $siswa['ada_foto']      = 0;

        return $this->tampilForm($menuAktip, $moduleAktip, $siswa, true);
    }

    public function ubahForm($menuAktip = '', $moduleAktip = '', $id_siswa = 0)
    {
        $siswa = (new M_DataSiswa())->dataForm((int) $id_siswa);
        if (! $siswa) {
            return redirect()->to($this->urlDaftar($menuAktip, $moduleAktip))->with('peringatan', 'Data siswa tidak ditemukan.');
        }
        $siswa['kelamin'] = M_DataSiswa::kodeKelamin($siswa['kelamin']);

        return $this->tampilForm($menuAktip, $moduleAktip, $siswa, false);
    }

    public function tambah($menuAktip = '', $moduleAktip = '')
    {
        if (! $this->validate($this->aturan())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $foto = baca_gambar_upload($this->request->getFile('image'));
        if ($foto === false) {
            return redirect()->back()->withInput()->with('errors', ['image' => PESAN_GAMBAR_DITOLAK]);
        }

        $data          = $this->dataDariForm();
        $data['image'] = $foto;
        (new M_DataSiswa())->insert($data);

        $pesan = 'Data ' . $data['nama_siswa'] . ' tersimpan.';
        if ($this->request->getPost('lanjut')) {
            return redirect()->to(base_url('index.php/datasiswa/tambah/' . $menuAktip . '/' . $moduleAktip))
                ->with('sukses', $pesan . ' Silakan isi siswa berikutnya.');
        }

        return redirect()->to($this->urlDaftar($menuAktip, $moduleAktip, ['q' => $data['nama_siswa']]))->with('sukses', $pesan);
    }

    public function edit($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_DataSiswa();
        $id    = (int) $this->request->getPost('id_siswa');
        if ($id <= 0 || ! $model->dataForm($id)) {
            return redirect()->to($this->urlDaftar($menuAktip, $moduleAktip))->with('peringatan', 'Data siswa tidak ditemukan.');
        }
        // Isian lama yang tidak diubah tidak dicek ulang, supaya data lama yang
        // formatnya tidak baku (NISN "-", email "-", dsb.) tidak menghalangi simpan.
        $lama   = $model->dataForm($id);
        $aturan = $this->aturan();
        foreach (['nis', 'nisn', 'email', 'telpon_siswa', 'id_periode', 'tanggal_lahir', 'tanggal_masuk'] as $kolom) {
            $isian = trim((string) $this->request->getPost($kolom));
            if ($isian === trim((string) $lama[$kolom]) || ($kolom === 'telpon_siswa' && $this->rapikanHp($isian) === trim((string) $lama[$kolom]))) {
                unset($aturan[$kolom]);
            }
        }
        if (! $this->validate($aturan)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $foto = baca_gambar_upload($this->request->getFile('image'));
        if ($foto === false) {
            return redirect()->back()->withInput()->with('errors', ['image' => PESAN_GAMBAR_DITOLAK]);
        }

        $data = $this->dataDariForm();
        if ($foto !== '') {
            $data['image'] = $foto;
        } elseif ($this->request->getPost('hapus_foto')) {
            $data['image'] = '';
        }
        $model->update($id, $data);

        return redirect()->to($this->urlDaftar($menuAktip, $moduleAktip, ['q' => $data['nama_siswa']]))
            ->with('sukses', 'Perubahan data ' . $data['nama_siswa'] . ' tersimpan.');
    }

    public function hapus($menuAktip = '', $moduleAktip = '')
    {
        $id   = (int) $this->request->getPost('id_siswa');
        $nama = (string) $this->request->getPost('nama_siswa');
        if ($id <= 0) {
            return redirect()->to($this->urlDaftar($menuAktip, $moduleAktip))->with('peringatan', 'Data siswa tidak ditemukan.');
        }
        (new M_DataSiswa())->hapus(['id_siswa' => $id]);

        return redirect()->to($this->urlDaftar($menuAktip, $moduleAktip))->with('sukses', 'Data ' . $nama . ' telah dihapus.');
    }

    // ------------------------------------------------------------------

    private function tampilForm($menuAktip, $moduleAktip, array $siswa, bool $baru)
    {
        $model = new M_DataSiswa();

        return view('datasiswa/V_FormSiswa', [
            'menu'         => (new M_Menu())->listing(),
            'menuAktip'    => $menuAktip,
            'moduleAktip'  => $moduleAktip,
            'siswa'        => $siswa,
            'baru'         => $baru,
            'periode'      => $model->daftarPeriode(),
            'periodeAktif' => periodeaktif(),
            'errors'       => session('errors') ?? [],
        ]);
    }

    private function filter(): array
    {
        $status = (string) $this->request->getGet('status');

        return [
            'q'      => trim((string) $this->request->getGet('q')),
            'kelas'  => (int) $this->request->getGet('kelas'),
            'status' => isset(M_DataSiswa::STATUS[$status]) ? $status : '',
        ];
    }

    private function urlDaftar($menuAktip, $moduleAktip, array $query = []): string
    {
        $url   = base_url('index.php/datasiswa/index/' . $menuAktip . '/' . $moduleAktip);
        $query = array_filter($query, static function ($v) {
            return $v !== '' && $v !== null && $v !== 0;
        });

        return $query ? $url . '?' . http_build_query($query) : $url;
    }

    private function aturan(): array
    {
        return [
            'nama_siswa' => [
                'rules'  => 'required|max_length[100]',
                'errors' => ['required' => 'Nama lengkap wajib diisi.', 'max_length' => 'Nama terlalu panjang (maks. 100 huruf).'],
            ],
            'kelamin' => [
                'rules'  => 'required|in_list[L,P]',
                'errors' => ['required' => 'Pilih jenis kelamin.', 'in_list' => 'Pilih jenis kelamin.'],
            ],
            'locked' => [
                'rules'  => 'required|in_list[baru,no,yes]',
                'errors' => ['required' => 'Pilih status siswa.', 'in_list' => 'Pilih status siswa.'],
            ],
            'nisn' => [
                'rules'  => 'permit_empty|numeric|exact_length[10]',
                'errors' => ['numeric' => 'NISN hanya berisi angka.', 'exact_length' => 'NISN harus 10 digit.'],
            ],
            'nis' => [
                'rules'  => 'permit_empty|max_length[30]',
                'errors' => ['max_length' => 'NIS terlalu panjang.'],
            ],
            'email' => [
                'rules'  => 'permit_empty|valid_email',
                'errors' => ['valid_email' => 'Format email tidak benar, contoh: nama@contoh.com.'],
            ],
            'telpon_siswa' => [
                'rules'  => 'permit_empty|max_length[50]',
                'errors' => ['max_length' => 'No. HP terlalu panjang.'],
            ],
            'tanggal_lahir' => [
                'rules'  => 'permit_empty|regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]',
                'errors' => ['regex_match' => 'Tanggal lahir tidak valid.'],
            ],
            'tanggal_masuk' => [
                'rules'  => 'permit_empty|regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]',
                'errors' => ['regex_match' => 'Tanggal masuk tidak valid.'],
            ],
            'id_periode' => [
                'rules'  => 'permit_empty|is_natural',
                'errors' => ['is_natural' => 'Pilih periode dari daftar.'],
            ],
        ];
    }

    private function dataDariForm(): array
    {
        $data = [];
        foreach (M_DataSiswa::KOLOM_FORM as $kolom) {
            $data[$kolom] = trim((string) $this->request->getPost($kolom));
        }
        $data['telpon_siswa'] = $this->rapikanHp($data['telpon_siswa']);

        return $data;
    }

    /**
     * Nomor seluler disimpan dengan awalan 0 (0812...), dari isian "812 ...",
     * "0812-..." atau "+62 812...". Isian lain (telepon rumah, dua nomor, ada
     * catatan) disimpan apa adanya supaya tidak berubah tanpa disadari.
     */
    private function rapikanHp(string $hp): string
    {
        $hp = trim($hp);
        if (preg_match('/^(?:\+?62|0)?(8[0-9]{7,12})$/', preg_replace('/[\s\-.]/', '', $hp), $m)) {
            return '0' . $m[1];
        }

        return $hp;
    }
}
