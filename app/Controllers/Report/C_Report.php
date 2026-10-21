<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Models\Report\M_Report;
use App\Models\Transaksi\M_DataPengeluaran;
use App\Models\Transaksi\M_DataPengeluaranDSB;
use App\Models\Transaksi\M_DataPengeluaranDU;
use App\Models\M_Menu;
use App\Models\Transaksi\M_DataPengeluaranFormulir;

class C_Report extends BaseController
{
    public function index($menuAktip = '', $moduleAktip = '')
    {
        $menu = new M_Menu();
        $datamenu = $menu->listing();

        $tahunAjaran = tahunajaran();

        $data = new M_Report();
        if ($this->request->getVar('tahunajaranselect')) {
            if ($this->request->getVar('tahunajaranselect') !== $tahunAjaran) {
                $tahunAjaran = $this->request->getVar('tahunajaranselect');
                $tahunAjaran2 = $tahunAjaran + 1;
                $dataCrostab = $data->kelasPeriodeBeforeGroupByIdKelas("", $tahunAjaran, $tahunAjaran2);
                $dataCrostab2 = $data->kelasPeriodeBeforeGroupByIdSiswa($tahunAjaran, $tahunAjaran2);
            } else {
                $tahunAjaran2 = $tahunAjaran + 1;
                $dataCrostab = $data->listing("", $tahunAjaran, $tahunAjaran2);
                $dataCrostab2 = $data->listing2($tahunAjaran, $tahunAjaran2);
            }
        } else {
            $tahunAjaran2 = $tahunAjaran + 1;
            $dataCrostab = $data->listing("", $tahunAjaran, $tahunAjaran2);
            $dataCrostab2 = $data->listing2($tahunAjaran, $tahunAjaran2);
        }


        $data = array(
            'dataCrosstab' => $dataCrostab,
            'dataCrosstab2' => $dataCrostab2,
            'tahunAjaran' => $tahunAjaran,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );
        return view('Report/VReport', $data);
    }
    public function indexEks($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $data = new M_DataPengeluaran();
        $dataPengeluaran = $data->listing($monthyear);
        $totalAll = $data->totalAll($monthyear);
        $totalRutin = $data->totalRutin($monthyear);
        $totalNonRutin = $data->totalNonRutin($monthyear);

        $data = array(
            'monthyear' => $monthyear,
            'dataPengeluaran' => $dataPengeluaran,
            'totalAll' => $totalAll,
            'totalRutin' => $totalRutin,
            'totalNonRutin' => $totalNonRutin,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );
        return view('Report/V_ReportEksSpp', $data);
    }
    public function indexTabungan($menuAktip = '', $moduleAktip = '')
    {
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $tahunAjaran = tahunajaran();
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        $data = new M_Report();
        $dataCrostab = $data->tabunganSumMont($monthyear);
        $datakas = $data->tabunganKasMont($monthyear);
        $data = array(
            'dataCrostab' => $dataCrostab,
            'dataKas' => $datakas,
            'tahunAjaran' => $tahunAjaran,
            'monthyear' => $monthyear,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );
        return view('Report/V_ReportTabungan', $data);
    }
    public function indexFormulir($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_DataPengeluaranFormulir();
        $dataPengeluaran = $data->listing($monthyear);
        $totalAll = $data->totalAll($monthyear);
        $totalRutin = $data->totalRutin($monthyear);
        $totalNonRutin = $data->totalNonRutin($monthyear);

        $data = array(
            'monthyear' => $monthyear,
            'dataPengeluaran' => $dataPengeluaran,
            'totalAll' => $totalAll,
            'totalRutin' => $totalRutin,
            'totalNonRutin' => $totalNonRutin,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );

        return view('Report/V_ReportEksFormulir', $data);
    }
    public function indexDSB($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_DataPengeluaranDSB();
        $dataPengeluaran = $data->listing($monthyear);
        $totalAll = $data->totalAll($monthyear);
        $totalRutin = $data->totalRutin($monthyear);
        $totalNonRutin = $data->totalNonRutin($monthyear);

        $data = array(
            'monthyear' => $monthyear,
            'dataPengeluaran' => $dataPengeluaran,
            'totalAll' => $totalAll,
            'totalRutin' => $totalRutin,
            'totalNonRutin' => $totalNonRutin,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );
        return view('Report/V_ReportEksDSB', $data);
    }
    public function indexDSB2($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_DataPengeluaranDSB();
        $dataPengeluaran = $data->listing($monthyear);
        $totalAll = $data->totalAll($monthyear);
        $totalRutin = $data->totalRutin($monthyear);
        $totalNonRutin = $data->totalNonRutin($monthyear);

        $data = array(
            'monthyear' => $monthyear,
            'dataPengeluaran' => $dataPengeluaran,
            'totalAll' => $totalAll,
            'totalRutin' => $totalRutin,
            'totalNonRutin' => $totalNonRutin,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );
        return view('Report/VReportDSB', $data);
    }
    public function indexEksDU($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_DataPengeluaranDU();
        $dataPengeluaran = $data->listing($monthyear);
        $totalAll = $data->totalAll($monthyear);
        $totalRutin = $data->totalRutin($monthyear);
        $totalNonRutin = $data->totalNonRutin($monthyear);

        $data = array(
            'monthyear' => $monthyear,
            'dataPengeluaran' => $dataPengeluaran,
            'totalAll' => $totalAll,
            'totalRutin' => $totalRutin,
            'totalNonRutin' => $totalNonRutin,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );
        return view('Report/V_ReportEksDU', $data);
    }
    public function indexDU($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_DataPengeluaranDU();
        $dataPengeluaran = $data->listing($monthyear);
        $totalAll = $data->totalAll($monthyear);
        $totalRutin = $data->totalRutin($monthyear);
        $totalNonRutin = $data->totalNonRutin($monthyear);

        $data = array(
            'monthyear' => $monthyear,
            'dataPengeluaran' => $dataPengeluaran,
            'totalAll' => $totalAll,
            'totalRutin' => $totalRutin,
            'totalNonRutin' => $totalNonRutin,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );
        return view('Report/V_ReportDU', $data);
    }
    public function indexINF($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_Report();
        $dataInf = $data->INFSumBetween($monthyear);
        $rowdataInf = "";
        //if ($this->request->getVar('detil'))
        $rowdataInf = $data->INFrowdata($monthyear);

        $data = array(
            'monthyear' => $monthyear,
            'dataInf' => $dataInf,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'rowdataInf' => $rowdataInf
        );
        return view('Report/V_ReportEksINF.php', $data);
    }
    public function indexBUKU($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_Report();
        $dataInf = $data->INFSumBetween($monthyear);

        $data = array(
            'monthyear' => $monthyear,
            'dataInf' => $dataInf,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );
        return view('Report/V_ReportEksINF', $data);
    }
    public function indexPAS($menuAktip = '', $moduleAktip = '')
    {
        $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $tahunAjar = $tahunAjaran . "/" . $tahunAjaran2;
        $data = new M_Report();
        $dataPAS = $data->listingPAS($tahunAjaran, $tahunAjaran2);
        $sumPAS = $data->sumPAS($tahunAjaran, $tahunAjaran2);
        $sumpengeluaranPAS = $data->sumpengeluaranPAS($tahunAjaran, $tahunAjaran2);
        $menu = new M_Menu();
        $datamenu = $menu->listing();

        $data = array(
            'tahunAjar' => $tahunAjar,
            'dataPAS' => $dataPAS,
            'sumPAS' => $sumPAS,
            'sumpengeluaranPAS' => $sumpengeluaranPAS,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
        );
        return view('Report/V_ReportPAS', $data);
    }
    public function JSONEKSDETILDSB()
    {
        if (!$this->request->getVar('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getVar('monthyear');
        }
        $data = rowDSBpertahunajaran($monthyear);
        return $this->response->setJSON($data);
    }
    public function JSONEKSDETILDSB_all()
    {
        if (!$this->request->getVar('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getVar('monthyear');
        }
        $data = rowDSBpertahunajaran_all($monthyear);
        return $this->response->setJSON($data);
    }
    public function JSONEKSDETILPENGELUARANDSB()
    {
        if (!$this->request->getVar('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getVar('monthyear');
        }
        $data = rowDSBpengeluaranpertahunajaran($monthyear);
        return $this->response->setJSON($data);
    }
    public function JSONEKSDETILFORMULIR()
    {
        if (!$this->request->getVar('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getVar('monthyear');
        }
        $data = rowFormulirpertahunajaran($monthyear);
        return $this->response->setJSON($data);
    }
    public function indexSALDOTABSAN($menuAktip = '', $moduleAktip = '')
    {
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getPost('monthyear');
        }

        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $tahunNow = date('Y');
        $db = db_connect('arafah');

        //     $query = $db->query("
        //     SELECT
        //         s.id_siswa,
        //         s.nama_siswa,

        //         SUM(
        //             CASE
        //                 WHEN LEFT(t.kodetransaksi, 2) = 'TK'
        //                 THEN t.rp
        //                 ELSE 0
        //             END
        //         ) AS jumlah_kredit,

        //         SUM(
        //             CASE
        //                 WHEN LEFT(t.kodetransaksi, 2) = 'TD'
        //                 THEN t.rp
        //                 ELSE 0
        //             END
        //         ) AS jumlah_debet,

        //         (
        //             SUM(
        //                 CASE
        //                     WHEN LEFT(t.kodetransaksi, 2) = 'TK'
        //                     THEN t.rp
        //                     ELSE 0
        //                 END
        //             )
        //             -
        //             SUM(
        //                 CASE
        //                     WHEN LEFT(t.kodetransaksi, 2) = 'TD'
        //                     THEN t.rp
        //                     ELSE 0
        //                 END
        //             )
        //         ) AS saldo

        //     FROM tbl_tabungan_transaksi t

        //     JOIN data_siswa s
        //         ON s.id_siswa = CAST(
        //             SUBSTRING_INDEX(
        //                 SUBSTRING(t.kode_tab_trans, 2),
        //                 '-',
        //                 1
        //             ) AS UNSIGNED
        //         )

        //     WHERE s.locked = 'no'

        //     GROUP BY
        //         s.id_siswa,
        //         s.nama_siswa

        //     ORDER BY s.nama_siswa ASC
        // ");
        $query = $db->query("
            SELECT
                s.id_siswa,
                s.nama_siswa,

                SUM(
                    CASE
                        WHEN t.kodetransaksi LIKE 'TK%'
                        THEN t.rp ELSE 0
                    END
                ) AS jumlah_kredit,

                SUM(
                    CASE
                        WHEN t.kodetransaksi LIKE 'TD%'
                        THEN t.rp ELSE 0
                    END
                ) AS jumlah_debet,

                SUM(
                    CASE
                        WHEN t.kodetransaksi LIKE 'TK%'
                        THEN t.rp
                        ELSE -t.rp
                    END
                ) AS saldo

            FROM data_siswa s

            LEFT JOIN tbl_tabungan_transaksi t
                ON t.id_siswa = s.id_siswa

            WHERE s.locked = 'no'

            GROUP BY s.id_siswa

            ORDER BY s.nama_siswa ASC
        ");
    //     $query2 = $db->query("
    //     SELECT
    //     t.kodetransaksi,
    //     SUM(t.rp) AS total
    //     FROM tbl_tabungan_transaksi t
    //     JOIN data_siswa s
    //         ON s.id_siswa = CAST(
    //             SUBSTRING_INDEX(
    //                 SUBSTRING(t.kode_tab_trans, 2),
    //                 '-',
    //                 1
    //             ) AS UNSIGNED
    //         )
    //     WHERE
    //         s.locked = 'no'
    //     GROUP BY
    //         t.kodetransaksi;
    // ");
    $query2 = $db->query("
    SELECT
        kodetransaksi,
        SUM(rp) AS total
    FROM tbl_tabungan_transaksi
    GROUP BY kodetransaksi
");
        $kodetransaksi = $this->request->getPost('kodetransaksi');
    //     $query3 = $db->query("
    //     SELECT
    //         t.tanggal,
    //         t.kodetransaksi,
    //         t.kode_tab_trans,
    //         t.rp,
    //         s.id_siswa,
    //         s.nama_siswa
    //     FROM tbl_tabungan_transaksi t

    //     JOIN data_siswa s
    //         ON s.id_siswa = CAST(
    //             SUBSTRING_INDEX(
    //                 SUBSTRING(t.kode_tab_trans, 2),
    //                 '-',
    //                 1
    //             ) AS UNSIGNED
    //         )

    //     WHERE
    //         s.locked = 'no'
    //         AND t.kodetransaksi = ?

    //     ORDER BY t.tanggal DESC

    //     LIMIT 500
    // ", [$kodetransaksi]);
$query3 = $db->query("
    SELECT
        t.tanggal,
        t.kodetransaksi,
        t.kode_tab_trans,
        t.rp,
        s.id_siswa,
        s.nama_siswa

    FROM tbl_tabungan_transaksi t

    JOIN data_siswa s
        ON s.id_siswa = t.id_siswa

    WHERE
        s.locked = 'no'
        AND t.kodetransaksi = ?

    ORDER BY t.tanggal DESC

    LIMIT 500
", [$kodetransaksi]);
        $saldoTapsan = $query->getResult();
        $saldoTapsan2 = $query2->getResult();
        $detailTapsan = $query3->getResult();

        $data = array(
            'monthyear'     => $monthyear,
            'saldoTapsan'   => $saldoTapsan,
            'saldoTapsan2'  => $saldoTapsan2,
            'detailTapsan'  => $detailTapsan,
            'menu'          => $datamenu,
            'menuAktip'     => $menuAktip,
            'moduleAktip'   => $moduleAktip,
        );

        return view('Report/V_ReportSALDOTABSAN', $data);
    }
}
