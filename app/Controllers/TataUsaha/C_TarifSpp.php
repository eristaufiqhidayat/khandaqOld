<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_TarifSpp;

class C_TarifSpp extends BaseController
{
    private $tarifMaks = 100000000;

    public function  index($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_TarifSpp();
        $menu = new M_Menu();
        $dataPeriode = $model->dataPeriode();
        $petaTarif = $model->petaTarif();
        $ids = array_column($dataPeriode, 'id_periode');

        // Periode yang diisi: dari pilihan, default periode aktif
        $id_periode = $this->request->getGet('periode');
        if (!in_array($id_periode, $ids)) {
            $aktif = periodeaktif();
            $id_periode = $aktif['id_periode'] ?? ($ids[0] ?? null);
        }
        // Sumber salinan default: periode sebelumnya yang sudah punya tarif
        // (daftar terbaru di atas, jadi "sebelumnya" = sesudahnya di daftar), kalau tidak ada pakai periode lain mana saja
        $posisi = (int) array_search($id_periode, $ids);
        $punyaTarif = array_filter($dataPeriode, function ($p) use ($id_periode) {
            return $p['id_periode'] != $id_periode && $p['jml_tarif'] > 0;
        });
        $sebelumnya = array_filter($punyaTarif, function ($i) use ($posisi) {
            return $i > $posisi;
        }, ARRAY_FILTER_USE_KEY);
        $sumber = $sebelumnya ? array_key_first($sebelumnya) : ($punyaTarif ? array_key_first($punyaTarif) : null);

        $data = array(
            'title'        => 'Tarif SPP',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'dataPeriode' => $dataPeriode,
            'dataKelas' => $model->dataKelas(),
            'petaTarif' => $petaTarif,
            'id_periode' => $id_periode,
            'sumber' => $sumber === null ? null : $dataPeriode[$sumber]['id_periode'],
            'kelasGanda' => $id_periode ? $model->kelasGanda($id_periode) : [],
            'menu'   =>  $menu->listing(),
        );
        return view('TataUsaha/V_TarifSpp', $data);
    }

    // Simpan tarif semua kelas untuk satu periode. Input kosong = hapus tarif kelas itu.
    public function  simpan($menuAktip = '', $moduleAktip = '')
    {
        $model = new M_TarifSpp();
        $id_periode = $this->request->getPost('id_periode');
        $kembali = redirect()->to(base_url('index.php/TataUsaha/TarifSpp/index/' . $menuAktip . '/' . $moduleAktip) . '?periode=' . urlencode((string) $id_periode));
        if (!$model->periodeAda($id_periode)) {
            session()->setFlashdata('error', 'Periode tidak ditemukan.');
            return $kembali;
        }
        $input = (array) $this->request->getPost('tarif');
        $tarif = [];
        foreach ($model->dataKelas() as $k) {
            if (!array_key_exists($k['id_kelas'], $input)) continue;
            // Titik ribuan boleh: "150.000" => 150000
            $angka = preg_replace('/[^0-9]/', '', (string) $input[$k['id_kelas']]);
            if ($angka !== '' && (int) $angka > $this->tarifMaks) {
                session()->setFlashdata('error', 'Tarif ' . $k['nama_kelas'] . ' terlalu besar. Tidak ada yang disimpan.');
                return $kembali;
            }
            $tarif[$k['id_kelas']] = $angka === '' ? null : (int) $angka;
        }
        $hasil = $model->simpanPeriode($id_periode, $tarif);
        if ($hasil === false) {
            session()->setFlashdata('error', 'Gagal menyimpan tarif, tidak ada data yang berubah.');
        } else {
            session()->setFlashdata('success', $hasil ? "Tarif $hasil kelas disimpan." : 'Tidak ada perubahan tarif.');
        }
        return $kembali;
    }
}
