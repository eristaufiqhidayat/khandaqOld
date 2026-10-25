<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
#$routes->get('/', 'Home::index');
$routes->resource('API/C_TabunganSiswa');

$routes->get('/', 'C_Home::index');
$routes->get('/dashboard/(:any)/(:any)', 'C_Home::index/$1/$2');
$routes->get('/chart/Spp/(:any)/(:any)', 'chart\C_ChartSpp::index/$1/$2');

$routes->add('/transaksi/KasBankTabungan/index/(:any)/(:any)', 'Transaksi\C_KasBankTabungan::index/$1/$2');
$routes->post('/transaksi/KasBankTabungan/insert/(:any)/(:any)', 'Transaksi\C_KasBankTabungan::insert/$1/$2');
$routes->post('/transaksi/KasBankTabungan/update/(:any)/(:any)', 'Transaksi\C_KasBankTabungan::update/$1/$2');
$routes->post('/transaksi/KasBankTabungan/delete/(:any)/(:any)', 'Transaksi\C_KasBankTabungan::delete/$1/$2');

$routes->get('/datasiswa/index/(:any)/(:any)', 'C_DataSiswa::index/$1/$2');
$routes->post('/datasiswa/edit/(:any)/(:any)', 'C_DataSiswa::edit/$1/$2');
$routes->post('/datasiswa/tambah/(:any)/(:any)', 'C_DataSiswa::tambah/$1/$2');
$routes->post('/datasiswa/hapus/(:any)/(:any)', 'C_DataSiswa::hapus/$1/$2');
$routes->add('/datasiswa/JSON/', 'C_DataSiswa::JSON/');

$routes->add('/ReportEks/INF/(:any)/(:any)', 'Report\C_Report::indexINF/$1/$2');
$routes->add('/ReportEks/DU/(:any)/(:any)', 'Report\C_Report::indexEksDU/$1/$2');
$routes->add('/ReportEks/DSB/(:any)/(:any)', 'Report\C_Report::indexDSB/$1/$2');
$routes->add('/ReportEks/Formulir/(:any)/(:any)', 'Report\C_Report::indexFormulir/$1/$2');
$routes->add('/Report/DSB/(:any)/(:any)', 'Report\C_Report::indexDSB2/$1/$2');
$routes->add('/Report/PAS/(:any)/(:any)', 'Report\C_Report::indexPAS/$1/$2');
$routes->add('/Report/Spp/(:any)/(:any)', 'Report\C_Report::index/$1/$2');
$routes->add('/Report/DU/(:any)/(:any)', 'Report\C_Report::indexDU/$1/$2');
$routes->add('/Report/SALDOTABSAN/(:any)/(:any)', 'Report\C_Report::indexSALDOTABSAN/$1/$2');

$routes->add('/Report/Tabungan/(:any)/(:any)', 'Report\C_Report::indexTabungan/$1/$2');
$routes->add('/ReportEks/pengeluaranSPP/(:any)/(:any)', 'Report\C_Report::indexEks/$1/$2');
$routes->get('/ReportEks/pengeluaranSPP/JSON', 'Report\C_Report::JSONEKSDETILDSB');
$routes->get('/ReportEks/detilDSB_all/JSON', 'Report\C_Report::JSONEKSDETILDSB_all');
$routes->get('/ReportEks/pengeluaranDSB/JSON', 'Report\C_Report::JSONEKSDETILPENGELUARANDSB');
$routes->get('/ReportEks/pengeluaranFormulir/JSON', 'Report\C_Report::JSONEKSDETILFORMULIR');

$routes->add('/TataUsaha/Beasiswa/index/(:any)/(:any)', 'TataUsaha\C_Beasiswa::index/$1/$2');
$routes->post('/TataUsaha/Beasiswa/updateBeasiswa/(:any)/(:any)', 'TataUsaha\C_Beasiswa::updateBeasiswa/$1/$2');

$routes->add('/TataUsaha/Formulir/index/(:any)/(:any)', 'TataUsaha\C_Formulir::index/$1/$2');
$routes->add('/TataUsaha/Formulir/readjson/(:any)/(:any)', 'TataUsaha\C_Formulir::readjson/$1/$2');
$routes->add('/TataUsaha/Formulir/editjson/(:any)/(:any)', 'TataUsaha\C_Formulir::editjson/$1/$2');
$routes->post('/TataUsaha/Formulir/insertPengeluaran/(:any)/(:any)', 'TataUsaha\C_Formulir::insertPengeluaran/$1/$2');
$routes->post('/TataUsaha/Formulir/updatePengeluaran/(:any)/(:any)', 'TataUsaha\C_Formulir::updatePengeluaran/$1/$2');
$routes->post('/TataUsaha/Formulir/deletePengeluaran/(:any)/(:any)', 'TataUsaha\C_Formulir::deletePengeluaran/$1/$2');

$routes->add('/TataUsaha/Periode/index/(:any)/(:any)', 'TataUsaha\C_Periode::index/$1/$2');
$routes->post('/TataUsaha/Periode/insert/(:any)/(:any)', 'TataUsaha\C_Periode::insert/$1/$2');
$routes->post('/TataUsaha/Periode/aktifkan/(:any)/(:any)', 'TataUsaha\C_Periode::aktifkan/$1/$2');
$routes->post('/TataUsaha/Periode/delete/(:any)/(:any)', 'TataUsaha\C_Periode::delete/$1/$2');
$routes->post('/TataUsaha/Periode/prosesRuang/(:any)/(:any)', 'TataUsaha\C_Periode::prosesRuang/$1/$2');

$routes->add('/TataUsaha/KalenderAkademik/index/(:any)/(:any)', 'TataUsaha\C_KalenderAkademik::index/$1/$2');
$routes->post('/TataUsaha/KalenderAkademik/insert/(:any)/(:any)', 'TataUsaha\C_KalenderAkademik::insert/$1/$2');
$routes->post('/TataUsaha/KalenderAkademik/update/(:any)/(:any)', 'TataUsaha\C_KalenderAkademik::update/$1/$2');
$routes->post('/TataUsaha/KalenderAkademik/delete/(:any)/(:any)', 'TataUsaha\C_KalenderAkademik::delete/$1/$2');

$routes->add('/TataUsaha/TarifSpp/index/(:any)/(:any)', 'TataUsaha\C_TarifSpp::index/$1/$2');
$routes->post('/TataUsaha/TarifSpp/simpan/(:any)/(:any)', 'TataUsaha\C_TarifSpp::simpan/$1/$2');

$routes->add('/TataUsaha/Kelas/index/(:any)/(:any)', 'TataUsaha\C_Kelas::index/$1/$2');
$routes->post('/TataUsaha/Kelas/update/(:any)/(:any)', 'TataUsaha\C_Kelas::update/$1/$2');

$routes->add('/Nilai/index/(:any)/(:any)', 'Nilai\C_UploadNilai::index/$1/$2');
$routes->post('/Nilai/tambah/(:any)/(:any)', 'Nilai\C_UploadNilai::tambah/$1/$2');

$routes->post('/TataUsaha/UserOrtu/aksesSiswaDo/(:any)/(:any)', 'TataUsaha\C_UserOrtu::aksesSiswaDo/$1/$2');
$routes->add('/TataUsaha/UserOrtu/aksesSiswa/(:any)/(:any)', 'TataUsaha\C_UserOrtu::aksesSiswa/$1/$2');
$routes->post('/TataUsaha/UserOrtu/editDataSiswa/(:any)/(:any)', 'TataUsaha\C_UserOrtu::editDataSiswa/$1/$2');
$routes->add('/TataUsaha/UserOrtu/index/(:any)/(:any)', 'TataUsaha\C_UserOrtu::index/$1/$2');
$routes->post('/TataUsaha/UserOrtu/tambah/(:any)/(:any)', 'TataUsaha\C_UserOrtu::tambah/$1/$2');
$routes->post('/TataUsaha/UserOrtu/edit/(:any)/(:any)', 'TataUsaha\C_UserOrtu::edit/$1/$2');
$routes->post('/TataUsaha/UserOrtu/delete/(:any)/(:any)', 'TataUsaha\C_UserOrtu::delete/$1/$2');

$routes->add('/TataUsaha/Spp/index/(:any)/(:any)', 'TataUsaha\C_Spp::index/$1/$2');
$routes->add('/TataUsaha/Spp/readjsonDSB/(:any)/(:any)', 'TataUsaha\C_Spp::readjsonDSB/$1/$2');
$routes->add('/TataUsaha/Spp/readjsonDU/(:any)/(:any)', 'TataUsaha\C_Spp::readjsonDU/$1/$2');
$routes->post('/TataUsaha/Spp/saveDebet/(:any)/(:any)', 'TataUsaha\C_Spp::saveDebet/$1/$2');
$routes->post('/TataUsaha/Spp/saveDSB/(:any)/(:any)', 'TataUsaha\C_Spp::saveDSB/$1/$2');
$routes->post('/TataUsaha/Spp/deleteDSB/(:any)/(:any)', 'TataUsaha\C_Spp::deleteDSB/$1/$2');
$routes->post('/TataUsaha/Spp/deleteDU/(:any)/(:any)', 'TataUsaha\C_Spp::deleteDU/$1/$2');
$routes->post('/TataUsaha/Spp/saveDU/(:any)/(:any)', 'TataUsaha\C_Spp::saveDU/$1/$2');

$routes->get('/TataUsaha/Daftar/index/(:any)/(:any)', 'TataUsaha\C_Daftar::index/$1/$2');
$routes->add('/TataUsaha/readjsonDaftar/(:any)/(:any)', 'TataUsaha\C_Daftar::readjson/$1/$2');
$routes->get('/TataUsaha/get_Daftar', 'TataUsaha\C_Daftar::get_Daftar');
$routes->post('/TataUsaha/Daftar/edit', 'TataUsaha\C_Daftar::edit');

$routes->get('/TataUsaha/Youtube/index/(:any)/(:any)', 'TataUsaha\C_Youtube::index/$1/$2');
$routes->add('/TataUsaha/readjsonYoutube/(:any)/(:any)', 'TataUsaha\C_Youtube::readjson/$1/$2');
$routes->get('/TataUsaha/get_Youtube', 'TataUsaha\C_Youtube::get_youtube');
$routes->post('/TataUsaha/Youtube/add', 'TataUsaha\C_Youtube::tambah');
$routes->post('/TataUsaha/Youtube/delete', 'TataUsaha\C_Youtube::delete');
$routes->post('/TataUsaha/Youtube/edit', 'TataUsaha\C_Youtube::edit');

$routes->add('/siswa/index/(:any)/(:any)', 'orangtua\C_Ortu::index/$1/$2');
$routes->add('/siswa/raport/(:any)/(:any)', 'orangtua\C_Ortu::raport/$1/$2');

$routes->add('/mutasi/index/(:any)/(:any)', 'Transaksi\C_MutasiTabungan::index/$1/$2');
$routes->add('/transaksi/indexTabungan/(:any)/(:any)', 'Transaksi\C_DataTransaksiTabungan::indexTabungan/$1/$2');
$routes->add('/transaksi/index/(:any)/(:any)', 'Transaksi\C_DataTransaksiTabungan::index/$1/$2');
$routes->post('/transaksi/readjson/(:any)/(:any)', 'Transaksi\C_DataTransaksiTabungan::readjson/$1/$2');
$routes->post('/transaksi/delete/(:any)/(:any)', 'Transaksi\C_DataTransaksiTabungan::delete/$1/$2');
$routes->post('/transaksi/edit/(:any)/(:any)', 'Transaksi\C_DataTransaksiTabungan::edit/$1/$2');
$routes->post('/transaksi/saveKredit/(:any)/(:any)', 'Transaksi\C_DataTransaksiTabungan::saveKredit/$1/$2');
$routes->post('/transaksi/saveDebet/(:any)/(:any)', 'Transaksi\C_DataTransaksiTabungan::saveDebet/$1/$2');
$routes->post('/transaksi/saveNewDataTabungan/(:any)/(:any)', 'Transaksi\C_DataTransaksiTabungan::saveNewDataTabungan/$1/$2');

$routes->add('/transaksi/pengeluaranDU/index/(:any)/(:any)', 'Transaksi\C_DataPengeluaranDU::index/$1/$2');
$routes->post('/transaksi/pengeluaranDU/insertPengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranDU::insertPengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaranDU/updatePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranDU::updatePengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaranDU/deletePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranDU::deletePengeluaran/$1/$2');

$routes->add('/transaksi/pengeluaranDSB/index/(:any)/(:any)', 'Transaksi\C_DataPengeluaranDSB::index/$1/$2');
$routes->post('/transaksi/pengeluaranDSB/insertPengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranDSB::insertPengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaranDSB/updatePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranDSB::updatePengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaranDSB/deletePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranDSB::deletePengeluaran/$1/$2');

$routes->add('/transaksi/pengeluaran/index/(:any)/(:any)', 'Transaksi\C_DataPengeluaran::index/$1/$2');
$routes->post('/transaksi/pengeluaran/insertPengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaran::insertPengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaran/updatePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaran::updatePengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaran/deletePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaran::deletePengeluaran/$1/$2');

$routes->add('/transaksi/pengeluaranUAS/index/(:any)/(:any)', 'Transaksi\C_DataPengeluaranUAS::index/$1/$2');
$routes->post('/transaksi/pengeluaranUAS/insertPengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranUAS::insertPengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaranUAS/updatePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranUAS::updatePengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaranUAS/deletePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranUAS::deletePengeluaran/$1/$2');

$routes->add('/transaksi/pengeluaranUTS/index/(:any)/(:any)', 'Transaksi\C_DataPengeluaranUTS::index/$1/$2');
$routes->post('/transaksi/pengeluaranUTS/insertPengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranUTS::insertPengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaranUTS/updatePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranUTS::updatePengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaranUTS/deletePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranUTS::deletePengeluaran/$1/$2');

$routes->add('/transaksi/pengeluaranFormulir/index/(:any)/(:any)', 'Transaksi\C_DataPengeluaranFormulir::index/$1/$2');
$routes->post('/transaksi/pengeluaranFormulir/insertPengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranFormulir::insertPengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaranFormulir/updatePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranFormulir::updatePengeluaran/$1/$2');
$routes->post('/transaksi/pengeluaranFormulir/deletePengeluaran/(:any)/(:any)', 'Transaksi\C_DataPengeluaranFormulir::deletePengeluaran/$1/$2');

// ---- Admin: Pengguna, Group & Hak Akses, Menu & Modul (hanya group admin/superadmin) ----
$admin = ['filter' => 'role:admin,superadmin'];
$routes->add('/users/groupjson/(:any)/(:any)', 'Admin\C_Users::groupjson/$1/$2'); // dipakai halaman Formulir TU
$routes->get('/users/index/(:any)/(:any)', 'Admin\C_Users::index/$1/$2', $admin);
$routes->post('/users/tambah/(:any)/(:any)', 'Admin\C_Users::tambah/$1/$2', $admin);
$routes->post('/users/edit/(:any)/(:any)', 'Admin\C_Users::edit/$1/$2', $admin);
$routes->post('/users/reset/(:any)/(:any)', 'Admin\C_Users::resetPassword/$1/$2', $admin);
$routes->post('/users/delete/(:any)/(:any)', 'Admin\C_Users::hapus/$1/$2', $admin);
// Ganti password akun sendiri, untuk semua user yang login
$routes->get('/users/cpass/(:any)/(:any)', 'Admin\C_Users::CPass/$1/$2');
$routes->post('/users/cpassdo/(:any)/(:any)', 'Admin\C_Users::CPassDo/$1/$2');

$routes->get('/groups/index/(:any)/(:any)', 'Admin\C_Groups::index/$1/$2', $admin);
$routes->post('/groups/simpan/(:any)/(:any)', 'Admin\C_Groups::simpan/$1/$2', $admin);
$routes->post('/groups/delete/(:any)/(:any)', 'Admin\C_Groups::delete/$1/$2', $admin);
$routes->post('/groups/akses/(:any)/(:any)', 'Admin\C_Groups::simpanAkses/$1/$2', $admin);

$routes->get('/menu/index/(:any)/(:any)', 'Admin\C_Menu::index/$1/$2', $admin);
$routes->post('/menu/simpan/(:any)/(:any)', 'Admin\C_Menu::simpan/$1/$2', $admin);
$routes->post('/menu/delete/(:any)/(:any)', 'Admin\C_Menu::delete/$1/$2', $admin);
$routes->post('/module/simpan/(:any)/(:any)', 'Admin\C_Module::simpan/$1/$2', $admin);
$routes->post('/module/delete/(:any)/(:any)', 'Admin\C_Module::delete/$1/$2', $admin);

// Halaman lama, dialihkan ke halaman baru
$routes->get('/groupsUsers/index/(:any)/(:any)', 'Admin\C_Groups::indexGroupsUsers/$1/$2', $admin);
$routes->get('/permissionGroups/index/(:any)/(:any)', 'Admin\C_Groups::indexPermissionGroups/$1/$2', $admin);
$routes->get('/module/index/(:any)/(:any)', 'Admin\C_Module::index/$1/$2', $admin);
$routes->get('/permission/index/(:any)/(:any)', 'Admin\CPermission::index/$1/$2', $admin);

$routes->get('/kelompokmatapelajaran/index/(:any)/(:any)', 'Nilai\CKelompokMataPelajaran::index/$1/$2');
$routes->post('/kelompokmatapelajaran/tambah/(:any)/(:any)', 'Nilai\CKelompokMataPelajaran::tambah/$1/$2');
$routes->post('/kelompokmatapelajaran/edit/(:any)/(:any)', 'Nilai\CKelompokMataPelajaran::edit/$1/$2');
$routes->post('/kelompokmatapelajaran/delete/(:any)/(:any)', 'Nilai\CKelompokMataPelajaran::delete/$1/$2');

$routes->add('/matapelajaran/index/(:any)/(:any)', 'Nilai\CMataPelajaran::index/$1/$2');
$routes->post('/matapelajaran/tambah/(:any)/(:any)', 'Nilai\CMataPelajaran::tambah/$1/$2');
$routes->post('/matapelajaran/edit/(:any)/(:any)', 'Nilai\CMataPelajaran::edit/$1/$2');
$routes->post('/matapelajaran/delete/(:any)/(:any)', 'Nilai\CMataPelajaran::delete/$1/$2');
$routes->get('/matapelajaran/json/(:any)', 'Nilai\CMataPelajaran::JSONmatapelajaran/$1');

$routes->add('/guru/index/(:any)/(:any)', 'Guru\CGuru::index/$1/$2');
$routes->post('/guru/tambah/(:any)/(:any)', 'Guru\CGuru::tambah/$1/$2');
$routes->post('/guru/edit/(:any)/(:any)', 'Guru\CGuru::edit/$1/$2');
$routes->post('/guru/delete/(:any)/(:any)', 'Guru\CGuru::delete/$1/$2');
$routes->get('/guru/json/(:any)', 'Guru\CGuru::JSON/$1');
$routes->get('/guru/walikelas/json/(:any)', 'Guru\CGuru::JSONWALIKELAS/$1');
$routes->get('/guru/walikelas/jsonjadwal/', 'Guru\CGuru::JSONJADWALNGAJAR');
$routes->get('/guru/walikelas/jsonjadwalperguru/', 'Guru\CGuru::JSONJADWALNGAJARPERGURU');
$routes->post('/guru/tambahjadwal/', 'Guru\CGuru::tambahjadwal');
$routes->get('/guru/jadwalmengajar/(:any)/(:any)', 'Guru\CGuru::VWALIKELAS/$1/$2');
$routes->get('/guru/jadwalmengajarguru/(:any)/(:any)', 'Guru\CGuru::VWALIKELASGURU/$1/$2');
$routes->get('/guru/profile/(:any)/(:any)', 'Guru\CGuru::PROFILE/$1/$2');

$routes->get('/guru/payroll/index/(:any)/(:any)', 'Guru\C_PayrollGuru::index/$1/$2');
$routes->get('/guru/payroll/jsonpayrollguru', 'Guru\C_PayrollGuru::readjson');
$routes->get('/guru/payroll/get_PayrollGuru', 'Guru\C_PayrollGuru::get_PayrollGuru');
$routes->post('/guru/payroll/delete', 'Guru\C_PayrollGuru::delete');
$routes->post('/guru/payroll/add', 'Guru\C_PayrollGuru::tambah');
$routes->post('/guru/payroll/edit', 'Guru\C_PayrollGuru::edit');
$routes->get('/guru/payroll/getGuru', 'Guru\C_PayrollGuru::readGuru');
$routes->post('/guru/payroll/getSelectedGuru', 'Guru\C_PayrollGuru::get_DataGuru');
$routes->post('/guru/payroll/copybulan', 'Guru\C_PayrollGuru::copybulan');
$routes->get('/guru/payroll/expcsv', 'Guru\C_PayrollGuru::exptocsv');

$routes->add('/nilaisiswa/index/(:any)/(:any)', 'Nilai\CNilaiSiswa::index/$1/$2');
$routes->add('/nilaisiswa/json/', 'Nilai\CNilaiSiswa::JSON');
$routes->get('/nilaisiswa/jsonCekGuru/', 'Nilai\CNilaiSiswa::JSONCEKGURU');
$routes->get('/nilaisiswa/jsonCekKelas/', 'Nilai\CNilaiSiswa::JSONCEKKELAS');
$routes->get('/nilaisiswa/jsonCekNilai/', 'Nilai\CNilaiSiswa::JSONCEKNILAI');
$routes->post('/nilaisiswa/tambah/', 'Nilai\CNilaiSiswa::tambah');
$routes->post('/nilaisiswa/edit/', 'Nilai\CNilaiSiswa::edit');
$routes->add('/nilaisiswa/indexguru/(:any)/(:any)', 'Nilai\CNilaiSiswa::indexguru/$1/$2');


$routes->get('/Whatsapp/Myapp/index/(:any)/(:any)', 'Whatsapp\C_Myapp::index/$1/$2');
$routes->add('/Whatsapp/Myapp/readjsonMyapp/(:any)/(:any)', 'Whatsapp\C_Myapp::readjson/$1/$2');
$routes->add('/Whatsapp/Myapp/get_Myapp', 'Whatsapp\C_Myapp::get_Myapp');
$routes->post('/Whatsapp/Myapp/add', 'Whatsapp\C_Myapp::tambah');
$routes->post('/Whatsapp/Myapp/delete', 'Whatsapp\C_Myapp::delete');
$routes->post('/Whatsapp/Myapp/edit', 'Whatsapp\C_Myapp::edit');

$routes->get('/Whatsapp/Message/index/(:any)/(:any)', 'Whatsapp\C_Message::index/$1/$2');
$routes->add('/Whatsapp/Message/readjsonMessage/(:any)/(:any)', 'Whatsapp\C_Message::readjson/$1/$2');
$routes->add('/Whatsapp/Message/get_Message', 'Whatsapp\C_Message::get_Message');
$routes->post('/Whatsapp/Message/add', 'Whatsapp\C_Message::tambah');
$routes->post('/Whatsapp/Message/delete', 'Whatsapp\C_Message::delete');
$routes->post('/Whatsapp/Message/edit', 'Whatsapp\C_Message::edit');

$routes->get('/Whatsapp/Notelp/index/(:any)/(:any)', 'Whatsapp\C_Notelp::index/$1/$2');
$routes->add('/Whatsapp/Notelp/readjsonNotelp/(:any)/(:any)', 'Whatsapp\C_Notelp::readjson/$1/$2');
$routes->add('/Whatsapp/Notelp/get_Notelp', 'Whatsapp\C_Notelp::get_Notelp');
$routes->post('/Whatsapp/Notelp/add', 'Whatsapp\C_Notelp::tambah');
$routes->post('/Whatsapp/Notelp/delete', 'Whatsapp\C_Notelp::delete');
$routes->post('/Whatsapp/Notelp/edit', 'Whatsapp\C_Notelp::edit');
$routes->add('/Whatsapp/Notelp/get_Groupwa', 'Whatsapp\C_Notelp::readjsongroupwa');

$routes->get('/Whatsapp/Groupwa/index/(:any)/(:any)', 'Whatsapp\C_Groupwa::index/$1/$2');
$routes->add('/Whatsapp/Groupwa/readjsonGroupwa/(:any)/(:any)', 'Whatsapp\C_Groupwa::readjson/$1/$2');
$routes->add('/Whatsapp/Groupwa/get_Groupwa', 'Whatsapp\C_Groupwa::get_Groupwa');
$routes->post('/Whatsapp/Groupwa/add', 'Whatsapp\C_Groupwa::tambah');
$routes->post('/Whatsapp/Groupwa/delete', 'Whatsapp\C_Groupwa::delete');
$routes->post('/Whatsapp/Groupwa/edit', 'Whatsapp\C_Groupwa::edit');

$routes->get('/Whatsapp/sendwa/index/(:any)/(:any)', 'Whatsapp\C_Sendwa::index/$1/$2');
$routes->get('/Whatsapp/sendwa/readjsonAPIServer/(:any)/(:any)', 'Whatsapp\C_Sendwa::readjsonAPIServer/$1/$2');
$routes->get('/Whatsapp/sendwa/readjsonMessage/(:any)/(:any)', 'Whatsapp\C_Sendwa::readjsonMessage/$1/$2');
$routes->get('/Whatsapp/sendwa/readjsonMessagebyno/', 'Whatsapp\C_Sendwa::readjsonMessagebyno');
$routes->get('/Whatsapp/sendwa/readjsonGroupwa/(:any)/(:any)', 'Whatsapp\C_Sendwa::readjsonGroupwa/$1/$2');
$routes->post('/Whatsapp/sendwa/send', 'Whatsapp\C_Sendwa::submitwa');
$routes->get('/Whatsapp/sendwa/groupwa', 'Whatsapp\C_Sendwa::groupwa');
$routes->get('/Whatsapp/sendwa/apiserver', 'Whatsapp\C_Sendwa::apiserver');
$routes->get('/Whatsapp/sendwa/readjsonlog', 'Whatsapp\C_Sendwa::readjsonLogstatus');
$routes->get('/Whatsapp/sendwa/readjsontemplate', 'Whatsapp\C_Sendwa::readjsontemplate');

$routes->get('/Whatsapp/Template/index/(:any)/(:any)', 'Whatsapp\C_Template::index/$1/$2');
$routes->add('/Whatsapp/Template/readjsonTemplate/(:any)/(:any)', 'Whatsapp\C_Template::readjson/$1/$2');
$routes->add('/Whatsapp/Template/get_Template', 'Whatsapp\C_Template::get_Template');
$routes->post('/Whatsapp/Template/add', 'Whatsapp\C_Template::tambah');
$routes->post('/Whatsapp/Template/delete', 'Whatsapp\C_Template::delete');
$routes->post('/Whatsapp/Template/edit', 'Whatsapp\C_Template::edit');

$routes->group('', ['filter' => 'login'], function ($routes) {
    $routes->get('/', 'Home::index');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
