<?php

namespace App\Filters;

use App\Models\M_Menu;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Membatasi akses halaman sesuai hak akses group (Admin > Group & Hak Akses).
 *
 * Sebelumnya menu yang tidak dimiliki hanya disembunyikan dari sidebar, tetapi
 * URL-nya tetap bisa dibuka oleh siapa saja yang sudah login (termasuk akun orang
 * tua). Filter ini mengecek controller yang dituju: user boleh membuka semua aksi
 * sebuah controller (index, readjson, simpan, hapus, ...) kalau minimal satu menu
 * miliknya mengarah ke controller itu.
 *
 * Group admin dan superadmin boleh membuka semuanya.
 */
class AksesMenu implements FilterInterface
{
    private const NS = 'App\\Controllers\\';

    /** Controller atau Controller::method yang boleh dibuka semua user yang sudah login. */
    private const UNTUK_SEMUA = [
        'C_Home',
        'Home',
        'Admin\\C_Users::CPass',
        'Admin\\C_Users::CPassDo',
    ];

    /**
     * Endpoint milik controller lain yang dipanggil dari dalam halaman sebuah menu.
     * Kunci: controller halaman; isi: Controller::method yang ikut diizinkan.
     */
    private const IKUT_HALAMAN = [
        // Pilihan group di form Data Formulir
        'TataUsaha\\C_Formulir' => ['Admin\\C_Users::groupjson'],
        // Tombol "Jadwal mengajar" di halaman Nilai Siswa
        'Nilai\\CNilaiSiswa' => [
            'Guru\\CGuru::VWALIKELAS',
            'Guru\\CGuru::JSONWALIKELAS',
            'Guru\\CGuru::JSONJADWALNGAJAR',
            'Guru\\CGuru::JSONJADWALNGAJARPERGURU',
        ],
        // Link detail tabungan di Report Saldo Tabungan (hanya tampilan)
        'Report\\C_Report' => ['Transaksi\\C_DataTransaksiTabungan::indexTabungan'],
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $router     = service('router');
        $controller = $router->controllerName();
        if (! is_string($controller)) {
            return; // closure
        }
        $controller = ltrim($controller, '\\');
        if (strpos($controller, self::NS) !== 0) {
            return; // controller bawaan Myth\Auth (login, logout, dll)
        }
        if (! function_exists('logged_in') || ! logged_in()) {
            return; // ditangani filter login
        }
        if (in_groups(['admin', 'superadmin'])) {
            return;
        }

        $controller = substr($controller, strlen(self::NS));
        $tujuan     = $controller . '::' . $router->methodName();

        $izin = array_merge(self::UNTUK_SEMUA, $this->izinUser());
        if (in_array($controller, $izin, true) || in_array($tujuan, $izin, true)) {
            return;
        }

        log_message('notice', 'Akses ditolak: user {user} ke {tujuan}', [
            'user'   => user()->username ?? '?',
            'tujuan' => $tujuan,
        ]);

        return $this->tolak($request);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

    /**
     * Daftar controller (dan Controller::method tambahan) yang boleh dibuka user ini,
     * diturunkan dari path menu miliknya.
     */
    private function izinUser(): array
    {
        static $hasil = null;
        if ($hasil !== null) {
            return $hasil;
        }

        $routes = service('routes')->getRoutes('get');
        $hasil  = [];
        foreach ((new M_Menu())->listing() as $menu) {
            $path = $this->rapikanPath((string) ($menu['path'] ?? ''));
            if ($path === '') {
                continue;
            }
            // Sidebar menambahkan /id_menu/id_module di belakang path
            $controller = $this->controllerDariPath($routes, $path . '/0/0')
                ?? $this->controllerDariPath($routes, $path);
            if ($controller === null) {
                continue;
            }
            $hasil[] = $controller;
            foreach (self::IKUT_HALAMAN[$controller] ?? [] as $ikut) {
                $hasil[] = $ikut;
            }
        }

        return $hasil = array_values(array_unique($hasil));
    }

    private function rapikanPath(string $path): string
    {
        $path = preg_replace('~[?#].*$~', '', trim($path));
        $path = preg_replace('~^(https?://[^/]+)?/*(index\.php/*)?~i', '', $path);

        return trim($path, '/');
    }

    /** Cari controller tujuan sebuah path dengan aturan route yang sama seperti router. */
    private function controllerDariPath(array $routes, string $path): ?string
    {
        foreach ($routes as $kunci => $handler) {
            if (! is_string($handler)) {
                continue;
            }
            $kunci = $kunci === '/' ? $kunci : ltrim($kunci, '/ ');
            if (preg_match('#^' . $kunci . '$#u', $path)) {
                $controller = ltrim(explode('::', $handler)[0], '\\');

                return strpos($controller, self::NS) === 0 ? substr($controller, strlen(self::NS)) : $controller;
            }
        }

        return null;
    }

    private function tolak(RequestInterface $request)
    {
        $pesan    = 'Anda tidak punya hak akses ke halaman ini. Hubungi admin bila seharusnya bisa.';
        $response = service('response')->setStatusCode(403);

        if ($request->isAJAX() || strpos($request->getHeaderLine('Accept'), 'json') !== false) {
            return $response->setJSON(['status' => 'error', 'message' => $pesan]);
        }

        return $response->setBody(view('errors/akses_ditolak', ['pesan' => $pesan]));
    }
}
