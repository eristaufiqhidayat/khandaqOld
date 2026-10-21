<?php

namespace App\Controllers\TataUsaha;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\TataUsaha\M_Periode;

class C_Periode extends BaseController
{

    public function  index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = "";
            #$monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_Periode();
        $dataperiode = $data->listing();
        $db = db_connect('arafah');
        foreach ($dataperiode as &$row) {
            $row['jml_ruang'] = $db->table('tbl_ruangan_periode')
                ->where('id_periode', $row['id_periode'])
                ->countAllResults();
        }
        unset($row);
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $data = array(
            'title'        => 'Data Menu',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'dataperiode'    => $dataperiode,
            'monthyear' => $monthyear,
            'menu'   =>  $datamenu,

            'session' => $session
        );
        return view('TataUsaha/V_Periode', $data);
    }
    public function cekPeriode($id_periode)
    {
        $db = db_connect('arafah');

        $jumlah = $db->table('tbl_ruangan_periode')
            ->where('id_periode', $id_periode)
            ->countAllResults();

        if ($jumlah > 0) {
            session()->setFlashdata(
                'success',
                "Periode {$id_periode} sudah memiliki {$jumlah} data ruang."
            );
        } else {
            session()->setFlashdata(
                'error',
                "Periode {$id_periode} BELUM memiliki data ruang."
            );
        }

        return redirect()->back();
    }
    public function  insert($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $data = new M_Periode();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'nama_semester'     => 'required',
            'tahun_ajaran'     => 'required',
            'semester'     => 'required',
            'status_aktif'     => 'required',
        ]);
        if ($validated) {
            $dataTambah = array(
                'id_periode'    => $this->request->getVar('id_periode'),
                'nama_semester'    => $this->request->getVar('nama_semester'),
                'tahun_ajaran'    => $this->request->getVar('tahun_ajaran'),
                'semester'    => $this->request->getVar('semester'),
                'status_aktif'    => $this->request->getVar('status_aktif'),
            );
            $data->tambah($dataTambah);
            $session->setFlashdata('sukses', 'Data Berhasil');
            return redirect()->back()->with('success', 'Data Berhasi disimpan');
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
    public function  update($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $data = new M_Periode();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'id_periode'     => 'required',
        ]);
        if ($validated) {
            $dataUpdate = array(
                'id_periode'    => $this->request->getVar('id_periode'),
                'nama_semester'    => $this->request->getVar('nama_semester'),
                'tahun_ajaran'    => $this->request->getVar('tahun_ajaran'),
                'semester'    => $this->request->getVar('semester'),
                'status_aktif'    => $this->request->getVar('status_aktif'),
            );
            $data->edit($dataUpdate);
            $session->setFlashdata('sukses', 'Data Berhasil di Edit');
            return redirect()->to(base_url('index.php/TataUsaha/Periode/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
    public function  delete($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $data = new M_Periode();
        $newdata = [
            'monthyear'  => $monthyear
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $validated =  $this->validate([
            'id_periode'     => 'required',
        ]);
        if ($validated) {
            $datadelete = array(
                'id_periode'    => $this->request->getVar('id_periode'),
            );
            $data->hapus($datadelete);
            $session->setFlashdata('sukses', 'Data Berhasil di Delete');
            return redirect()->to(base_url('index.php/TataUsaha/Periode/index/' . $menuAktip . "/" . $moduleAktip));
        } else {
            echo "error";
        }
        //return view('Transaksi/V_DataPengeluaran', $data);
    }
    public function prosesRuang($id_periode)
    {
        $db = db_connect('arafah');

        // Cek apakah periode sudah diproses
        $cek = $db->table('tbl_ruangan_periode')
            ->where('id_periode', $id_periode)
            ->countAllResults();

        if ($cek > 0) {
            session()->setFlashdata(
                'error',
                "Periode {$id_periode} sudah memiliki data ruang."
            );

            return redirect()->back();
        }

        $sql = "
            INSERT INTO tbl_ruangan_periode
            (
                id_siswa,
                id_kelas,
                id_periode
            )
            SELECT
                r.id_siswa,
                r.id_kelas,
                ?
            FROM tbl_ruangan r
            INNER JOIN data_siswa s
                ON s.id_siswa = r.id_siswa
            WHERE s.locked = 'no'
            ";


        $db->query($sql, [$id_periode]);

        $jumlah = $db->affectedRows();

        session()->setFlashdata(
            'success',
            "{$jumlah} data ruang berhasil dibuat untuk periode {$id_periode}."
        );

        return redirect()->back();
    }
}
