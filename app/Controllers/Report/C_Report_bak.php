<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Models\Report\M_Report;
use App\Models\Transaksi\M_DataPengeluaran;
use App\Models\Transaksi\M_DataPengeluaranDSB;
use App\Models\Transaksi\M_DataPengeluaranDU;
use App\Models\M_Menu;

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
}
