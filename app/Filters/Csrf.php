<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Security\Exceptions\SecurityException;

/**
 * Cek token CSRF untuk semua request POST/PUT/PATCH/DELETE.
 *
 * Token dikirim otomatis oleh skrip yang disisipkan filter CsrfSisip ke setiap
 * halaman, jadi form dan AJAX yang sudah ada tidak perlu diubah satu per satu.
 * Bedanya dengan filter CSRF bawaan: pesan gagalnya bisa dibaca user.
 */
class Csrf implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! $request instanceof IncomingRequest) {
            return;
        }

        try {
            service('security')->verify($request);
        } catch (SecurityException $e) {
            $pesan = 'Halaman sudah terlalu lama dibuka atau sesi berganti. Muat ulang halaman lalu coba lagi.';
            log_message('notice', 'CSRF gagal: {uri}', ['uri' => (string) $request->getUri()->getPath()]);

            if ($request->isAJAX() || strpos($request->getHeaderLine('Accept'), 'json') !== false) {
                return service('response')->setStatusCode(403)->setJSON(['status' => 'error', 'message' => $pesan]);
            }

            return redirect()->back()->with('peringatan', $pesan);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
