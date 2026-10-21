<?php

use App\Models\M_Helper;
use App\Models\orangtua\M_Ortu;

function rowUsers()
{
    $cek = new M_Helper();
    $cek = $cek->rowUsers();
    return $cek;
}
function selectModule()
{
    $select = new M_Helper();
    $dataselect = $select->selectModule();
    return $dataselect;
}
function icons($kicon = "")
{
    $listicons = array(
        "fas fa-user-graduate", "far fa-list-alt", "fas fa-key", "fa fa-users", "fas fa-restroom", "fas fa-cash-register", "fas fa-address-card", "fas fa-address-card", "far fa-money-bill-alt", "fas fa-key",
        "fas fa-chart-pie", "fa fa-print", "fas fa-cart-plus", "fab fa-free-code-camp", "fab fa-firstdraft", "fas fa-user-friends"
    );
    foreach ($listicons as $icon) {
        ($kicon == $icon) ? $checked = "checked" : $checked = "";
        echo "<div class=row><input type=\"radio\" name=icon value=\"$icon\"  $checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <i class=\"$icon\"></i>
        $icon</div>";
    }
}
function namaSiswa($username_ortu)
{
    $cek = new M_Ortu();
    $cek = $cek->listing($username_ortu);
    return $cek;
}
function cekusernameOrtu($username_ortu)
{
    $cek = new M_Ortu();
    $cek = $cek->cekusernameOrtu($username_ortu);
    return $cek;
}
function jumlahSiswaBlmBayar($array)
{
    return array_sum($array);
}
function list_siswa_blmbayar_perkelas($id_kelas)
{
    $cek = new M_Helper();
    $cek = $cek->sum_blmbayar_perkelas_list($id_kelas);
    return $cek;
}
function list_siswa_blmbayar_sum($id_kelas)
{
    $cek = new M_Helper();
    $cek = $cek->sum_blmbayar_perkelas_sum($id_kelas);
    return $cek;
}
function sumtransaksiperbulan($tahunbulan, $kodetransaksi)
{
    $cek = new M_Helper();
    $cek = $cek->sumtransaksiperbulan($tahunbulan, $kodetransaksi);
    return $cek;
}
function sumtransaksiperbulanPeriodeBefore($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->sumtransaksiperbulanPeriodeBefore($tahunbulan);
    return $cek;
}
function sumDSBperbulan($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->sumDSBperbulan($tahunbulan);
    return $cek;
}
function sumDUperbulan($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->sumDUperbulan($tahunbulan);
    return $cek;
}
function sumDSBpertahunajaran($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->sumDSBpertahunajaran($tahunbulan);
    return $cek;
}
function sumFormulirpertahunajaran($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->sumFormulirpertahunajaran($tahunbulan);
    return $cek;
}
function sumDUpertahunajaran($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->sumDUpertahunajaran($tahunbulan);
    return $cek;
}
function rowDSBpertahunajaran($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->rowDSBpertahunajaran($tahunbulan);
    return $cek;
}
function rowDSBpertahunajaran_all($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->rowDSBpertahunajaran_all($tahunbulan);
    return $cek;
}
function rowDSBpengeluaranpertahunajaran($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->rowDSBpengeluaranpertahunajaran($tahunbulan);
    return $cek;
}
function rowFormulirpertahunajaran($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->rowFormulirpertahunajaran($tahunbulan);
    return $cek;
}
function rowDUpertahunajaran($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->rowDUpertahunajaran($tahunbulan);
    return $cek;
}
function sumPengeluaranDSBpertahunajaran($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->sumPengeluaranDSBpertahunajaran($tahunbulan);
    return $cek;
}
function sumPengeluaranFormulirpertahunajaran($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->sumPengeluaranFormulirpertahunajaran($tahunbulan);
    return $cek;
}
function sumPengeluaranDUpertahunajaran($tahunbulan)
{
    $cek = new M_Helper();
    $cek = $cek->sumPengeluaranDUpertahunajaran($tahunbulan);
    return $cek;
}
function sumbulanberjalan()
{
    $start = new Datetime(tahunajaran() . '-06-01');
    $end = new Datetime(date('Y-m-d'));
    $diff = $start->diff($end);

    $yearsInMonths = $diff->format('%r%y') * 12;
    $months = $diff->format('%r%m');
    $totalMonths = $yearsInMonths + $months;

    return $totalMonths;
}
function sumsiswakelas($id_kelas, $tahunajaran)
{
    $cek = new M_Helper();
    $cek = $cek->sumsiswakelas($id_kelas, $tahunajaran);
    return $cek;
}
function sumbeasiswakelas($id_kelas)
{
    $cek = new M_Helper();
    $cek = $cek->sumbeasiswakelas($id_kelas);
    return $cek;
}
function sumpengeluaransppbulan($bulan, $tahun)
{
    $cek = new M_Helper();
    $cek = $cek->sumpengeluaransppbulan($bulan, $tahun);
    return $cek;
}
function dataakun()
{
    $cek = new M_Helper();
    $cek = $cek->dataakun();
    return $cek;
}
function rowDSB($id_siswa)
{
    $cek = new M_Helper();
    $cek = $cek->rowDSB($id_siswa);
    return $cek;
}
function rowDU($id_siswa)
{
    $cek = new M_Helper();
    $cek = $cek->rowDU($id_siswa);
    return $cek;
}
function sumdebitsppsiswa($id_siswa, $start_date, $end_date)
{
    $cek = new M_Helper();
    $cek = $cek->sumdebitsppsiswa($id_siswa, $start_date, $end_date);
    return $cek;
}
function sumdebitldrsiswa($id_siswa, $start_date, $end_date)
{
    $cek = new M_Helper();
    $cek = $cek->sumdebitldrsiswa($id_siswa, $start_date, $end_date);
    return $cek;
}
function sumdebitkessiswa($id_siswa, $start_date, $end_date)
{
    $cek = new M_Helper();
    $cek = $cek->sumdebitkessiswa($id_siswa, $start_date, $end_date);
    return $cek;
}
function rowdebitsppsiswa($id_siswa, $start_date, $end_date)
{
    $cek = new M_Helper();
    $cek = $cek->rowdebitsppsiswa($id_siswa, $start_date, $end_date, "TDSPP");
    return $cek;
}
function rowdebitldrsiswa($id_siswa, $start_date, $end_date)
{
    $cek = new M_Helper();
    $cek = $cek->rowdebitsppsiswa($id_siswa, $start_date, $end_date, "TDLDR");
    return $cek;
}
function rowdebitkessiswa($id_siswa, $start_date, $end_date)
{
    $cek = new M_Helper();
    $cek = $cek->rowdebitsppsiswa($id_siswa, $start_date, $end_date, "TDKES");
    return $cek;
}
function countmonth($start_date, $end_date)
{
    $cek = new M_Helper();
    $cek = $cek->countmonth($start_date, $end_date);
    return $cek;
}
function datapengusul()
{
    $cek = new M_Helper();
    $cek = $cek->datapengusul();
    return $cek;
}
function ceksppArray($id_siswa)
{
    $cekspp = new M_Helper();
    $periode = $cekspp->periodetahunajaran();
    $tahunajaran = explode("/", $periode['tahun_ajaran']);
    $tahunajaran['awal'] = $tahunajaran[0];
    $tahunajaran['akhir'] = $tahunajaran[1];
    $cekspp = $cekspp->cekspp($id_siswa, $tahunajaran['awal']);
    return $cekspp;
}
function cekbayarspp($id_siswa)
{
    $cekspp = new M_Helper();
    $periode = $cekspp->periodetahunajaran();
    $tahunajaran = explode("/", $periode['tahun_ajaran']);
    $cekbayarspp = $cekspp->cekbayarspp($id_siswa, $tahunajaran[0]);
    return $cekbayarspp;
}
function tahunajaran()
{
    $cekspp = new M_Helper();
    $periode = $cekspp->periodetahunajaran();
    // Belum ada periode aktif atau format salah: pakai tahun ajaran dari tanggal (mulai Juli)
    if (!$periode || !preg_match('/^(\d{4})\//', (string) $periode['tahun_ajaran'], $m)) {
        return (string) ((int) date('n') >= 7 ? date('Y') : date('Y') - 1);
    }
    return $m[1];
}
function cekloundry($id_siswa)
{
    $cekloundry = new M_Helper();
    $cekdataloundry = $cekloundry->cekpesertaloundry($id_siswa);
    return $cekdataloundry;
}
function cekbeasiswa($id_siswa)
{
    $cekbeasiswa = new M_Helper();
    $cekbeasiswa = $cekbeasiswa->cekbeasiswa($id_siswa);
    return $cekbeasiswa;
}
function ceksaldotabungan($id_siswa)
{
    $cek = new M_Helper();
    $cek = $cek->saldotabungan($id_siswa);
    return $cek;
}
function cekkredittabungan($id_siswa)
{
    $cek = new M_Helper();
    $cek = $cek->kredittabungan($id_siswa);
    return $cek;
}
function cekdebettabungan($id_siswa)
{
    $cek = new M_Helper();
    $cek = $cek->debettabungan($id_siswa);
    return $cek;
}
function sppxbulan()
{
    $xspp = 0;
    for ($x = 1; $x <= 12; $x++) {
        $sppbulan = "sppbulan" . $x;
        if (isset($_REQUEST[$sppbulan])) $xspp = $xspp + 1;
    }
    return $xspp;
}
function sppbulan()
{
    $queryrp2 = "";
    for ($x = 1; $x <= 12; $x++) {
        $sppbulan = "sppbulan" . $x;
        if (isset($_REQUEST[$sppbulan][$x])) $queryrp = "$x,";
        else $queryrp = "";
        $queryrp2 = $queryrp . $queryrp2;
    }
    $queryrp2 = substr($queryrp2, 0, -1);
    return $queryrp2;
}
function convertbulan($bulanquery)
{
    $arraybulan = array("1" => "7", "2" => "8", "3" => "9", "4" => "10", "5" => "11", "6" => "12", "7" => "1", "8" => "2", "9" => "3", "10" => "4", "11" => "5", "12" => "6");
    return $arraybulan[$bulanquery];
}

//Meng update data ke tbl_spp -> table ceklist spp
function insertspp()
{
    $cek = new M_Helper();
    $request = service('request');
    $queryrp2 = "";
    $tanggal1 = $request->getPost('tanggal');
    $tanggal = date_create($request->getPost('tanggal'));
    $bulan = convertbulan(date_format($tanggal, 'n'));
    $id_siswa = $request->getPost('id_siswa');
    $sppkelas = sppkelas($id_siswa);
    $sppxbulan = sppxbulan(); //kali berapa bulan bayar spp
    $totalspp = $sppkelas * $sppxbulan;
    $tahunajaranaktip = tahunajaran();
    for ($x = 1; $x <= 12; $x++) {
        if ($x == "$bulan") $rp = $totalspp;
        else  $rp = "1";
        $sppbulan = "sppbulan" . $x;
        if (isset($_REQUEST[$sppbulan])) $queryrp = "rp" . $x . " = $rp,tanggal" . $x . " = '$tanggal1',";
        else $queryrp = "";
        $queryrp2 = $queryrp . $queryrp2;
    }
    $queryrp2 = substr($queryrp2, 0, -1);
    $cek = $cek->inserttblspp($id_siswa, $queryrp2, $tahunajaranaktip);
}
function sppkelas($id_siswa)
{
    $cek = new M_Helper();
    $row = $cek->msppkelas($id_siswa);
    $tarifspp = rowdatatarifspp2(); //Dari table tarif spp
    // Siswa tanpa kelas atau kelas yang belum punya tarif: SPP 0, bukan error
    if (!isset($row["id_kelas"])) return 0;
    $tarif = (float) ($tarifspp[$row["id_kelas"]] ?? 0);
    $persen = cekbeasiswa($id_siswa);
    if (isset($persen)) {
        if (!empty($persen['rp'])) {
            $diskon = $tarif - $persen['rp'];
        } else {
            $diskon = ($persen['persen'] / 100) * $tarif;
        }
    } else {
        $diskon = 0;
    }
    return $tarif - $diskon;
}
function rowdatatarifspp()
{
    $cek = new M_Helper();
    $row = $cek->mrowtarifspp();
    return $row;
}
function rowdatatarifspp2()
{
    $data = rowdatatarifspp();
    $row = [];
    foreach ($data as $x => $val) {
        $row[$val["id_kelas"]] = $val["tarif"];
    }
    return $row;
}
function debetspp()
{
    $cek = new M_Helper();
    $request = service('request');
    $tahunajaranaktip = tahunajaran();
    $id_siswa = $request->getPost('id_siswa');
    $kode_tab = $request->getPost('kode_tab_trans');
    //$kode_transaksi = $request->getPost('kode_transaksi');
    //$rp = $request->getPost('rp');
    $tanggal = $request->getPost('tanggal');
    $sppkelas = sppkelas($id_siswa);
    $sppxbulan = sppxbulan();
    $sppbulan = sppbulan();
    $totalspp = $sppkelas * $sppxbulan;
    $keterangan = "Debit SPP";
    $cek = $cek->debetspp($kode_tab, $tanggal, $totalspp, $keterangan, $sppbulan, $tahunajaranaktip);
}
function debetloundry()
{
    $cek = new M_Helper();
    $request = service('request');
    $kode_tab = $request->getPost('kode_tab_trans');
    $rploundry = 100000;
    $tanggal = $request->getPost('tanggal');
    $sppxbulan = sppxbulan();
    $sppbulan = sppbulan();
    $rptotal = $rploundry * $sppxbulan;
    $cek = $cek->debetloundry($kode_tab, $tanggal, $rptotal, $sppbulan);
}
function debetkes()
{
    $cek = new M_Helper();
    $request = service('request');
    $kode_tab = $request->getPost('kode_tab_trans');
    $rploundry = 50000;
    $tanggal = $request->getPost('tanggal');
    $sppxbulan = sppxbulan();
    $sppbulan = sppbulan();
    echo $sppbulan;
    $rptotal = $rploundry * $sppxbulan;
    $cek = $cek->debetkes($kode_tab, $tanggal, $rptotal, $sppbulan);
}
function debetadm()
{
    # Administrasi 15 ribu per kredit
    $cek = new M_Helper();
    $request = service('request');
    $rpadm = 15000;
    $kode_tab = $request->getPost('kode_tab_trans');
    $tanggal = $request->getPost('tanggal');
    $keterangan = "Debit Infak";
    $cek = $cek->debetadm($kode_tab, $tanggal, $rpadm, $keterangan);
}
function listmodule()
{
    $cek = new M_Helper();
    $cek = $cek->listingmodule();
    return $cek;
}
function kelompokMataPelajaran($id_kelompok = "")
{
    $cek = new M_Helper();
    $cek = $cek->kelompokMataPelajaran($id_kelompok);
    return $cek;
}
function MataPelajaran($id_matapelajaran = "")
{
    $cek = new M_Helper();
    $cek = $cek->MataPelajaran($id_matapelajaran);
    return $cek;
}
function MataPelajaranNilaiGuru($id_guru, $id_periode)
{
    $cek = new M_Helper();
    $cek = $cek->MataPelajaranNilaiGuru($id_guru, $id_periode);
    return $cek;
}
function rowkelas($id_kelas = "")
{
    $cek = new M_Helper();
    $cek = $cek->rowkelas($id_kelas);
    return $cek;
}
function rowkelasNilaiGuru($id_guru)
{
    $cek = new M_Helper();
    $cek = $cek->rowkelasNilaiGuru($id_guru);
    return $cek;
}
function rowruangkelas($id_ruang_kelas = "")
{
    $cek = new M_Helper();
    $cek = $cek->rowruangkelas($id_ruang_kelas);
    return $cek;
}
function periodeaktif()
{
    $cekspp = new M_Helper();
    $periode = $cekspp->periodeaktif();
    return $periode;
}
function comboDataSiswa()
{
    $model = new M_Helper();
    $datamodel = $model->dropdowDataSiswa();
    return $datamodel;
}
function comboDataSiswaGuru($id_guru)
{
    $model = new M_Helper();
    $datamodel = $model->dropdowDataSiswaGuru($id_guru);
    return $datamodel;
}
function comboDataPelajaran()
{
    $model = new M_Helper();
    $datamodel = $model->dropdowDataPelajaran();
    return $datamodel;
}
function comboDataGuru()
{
    $model = new M_Helper();
    $datamodel = $model->dropdowDataGuru();
    return $datamodel;
}
function cekDataSiswa($id_siswa)
{
    $model = new M_Helper();
    $datamodel = $model->cekDataSiswa($id_siswa);
    return $datamodel;
}
function cekDataGuru($id_guru = "")
{
    $model = new M_Helper();
    $datamodel = $model->cekDataGuru($id_guru = "");
    return $datamodel;
}
function cekDataGuruNilai($id_matapelajaran, $id_periode)
{
    $model = new M_Helper();
    $datamodel = $model->cekDataGuruNilai($id_matapelajaran, $id_periode);
    return $datamodel;
}
function cekDataKelasNilai($id_siswa)
{
    $model = new M_Helper();
    $datamodel = $model->cekDataKelasNilai($id_siswa);
    return $datamodel;
}
function cekDetilSiswa($id_siswa)
{
    $model = new M_Helper();
    $datamodel = $model->cekDetilSiswa($id_siswa);
    return $datamodel;
}
function cekDataNilai($id_nilai)
{
    $model = new M_Helper();
    $datamodel = $model->cekDataNilai($id_nilai);
    return $datamodel;
}
function cekPerhitunganNilaiActive()
{
    $model = new M_Helper();
    $datamodel = $model->cekPerhitunganNilaiActive();
    return $datamodel;
}
function listProfileDataGuru($username)
{
    $model = new M_Helper();
    $datamodel = $model->listProfileDataGuru($username);
    return $datamodel;
}
function cekDataNilaiTambah($id_siswa, $id_guru, $id_matapelajaran, $id_periode)
{
    $model = new M_Helper();
    $datamodel = $model->cekDataNilaiTambah($id_siswa, $id_guru, $id_matapelajaran, $id_periode);
    return $datamodel;
}
function selecttahunajaran()
{
    $cekspp = new M_Helper();
    $periode = $cekspp->periode();
    return $periode;
}
function trimtahunajaran($tahunAjaran)
{
    $tahunajaran = explode("/", $tahunAjaran);
    $tahunajaran['awal'] = $tahunajaran[0];
    return $tahunajaran['awal'];
}
function cekDataTabungan($id_siswa)
{
    $model = new M_Helper();
    $datamodel = $model->cekDataTabungan($id_siswa);
    return $datamodel;
}
function saveNewDataTabungan($id_siswa, $kode_tab, $tanggal)
{
    $model = new M_Helper();
    $datamodel = $model->saveTabunganSiswa($id_siswa, $kode_tab, $tanggal);
    return $datamodel;
}
function tarifspp($kelas)
{
    $model = new M_Helper();
    $datamodel = $model->tarifspp($kelas);
    return $datamodel;
}
function id_kelas($kelas)
{
    $model = new M_Helper();
    $datamodel = $model->id_kelas($kelas);
    return $datamodel;
}
function cekbulanperiode($bulanperiode)
{
    $periode = array("01" => 1, "02" => 1, "03" => 1, "04" => 1, "05" => 1, "06" => 1, "07" => 1, "08" => 0, "09" => 0, "10" => 0, "11" => 0, "12" => 0);
    if ($periode[$bulanperiode] == 1) {
        return -1;
    } else {
        return 0;
    }
}
function wa1($to, $message, $appkey, $authkey, $file)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://app.ngirimwa.com/api/create-message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'appkey' => $appkey,
            'authkey' => $authkey,
            'to' => $to,
            'message' => $message,
            'file' => $file,
            'sandbox' => 'false'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
}

// Peringatan untuk admin kalau periode aktif tidak sesuai bulan berjalan.
// Tahun ajaran mulai Juli: Juli–Desember = Ganjil, Januari–Juni = Genap.
// Mengembalikan teks peringatan, atau null kalau sudah sesuai / bukan admin.
function peringatanPeriode()
{
    if (!function_exists('in_groups') || !in_groups(['admin', 'superadmin'])) return null;
    $bulan = (int) date('n');
    $tahunMulai = $bulan >= 7 ? (int) date('Y') : (int) date('Y') - 1;
    $harusTahun = $tahunMulai . '/' . ($tahunMulai + 1);
    $harusSemester = $bulan >= 7 ? 'Ganjil' : 'Genap';
    $harus = $harusTahun . ' ' . $harusSemester;

    $periode = (new M_Helper())->periodeaktif();
    if (!$periode) {
        return "Belum ada periode aktif. Seharusnya periode $harus diaktifkan.";
    }
    $aktif = trim($periode['tahun_ajaran'] . ' ' . $periode['nama_semester']);
    if (trim($periode['tahun_ajaran']) !== $harusTahun) {
        return "Periode aktif masih $aktif, padahal bulan ini sudah masuk tahun ajaran $harusTahun ($harusSemester).";
    }
    // Semester dicek dari nama_semester (Ganjil/Genap) atau kolom semester (1/2); format lain dilewati
    $nama = strtolower(trim((string) $periode['nama_semester']));
    $nomor = trim((string) $periode['semester']);
    $semesterAktif = null;
    if (strpos($nama, 'ganjil') !== false || $nomor === '1') $semesterAktif = 'Ganjil';
    elseif (strpos($nama, 'genap') !== false || $nomor === '2') $semesterAktif = 'Genap';
    if ($semesterAktif !== null && $semesterAktif !== $harusSemester) {
        return "Periode aktif masih $aktif, padahal bulan ini sudah semester $harusSemester ($harus).";
    }
    return null;
}
