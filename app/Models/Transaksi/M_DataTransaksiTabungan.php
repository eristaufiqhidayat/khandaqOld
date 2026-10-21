<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class M_DataTransaksiTabungan extends Model
{
	protected $DBGroup      = 'arafah';
	protected $table 		= 'tbl_tabungan_transaksi';
	protected $primaryKey 	= 'notransaksi';
	protected $allowedFields = [
		'notransaksi', 'kode_tab_trans', 'kodetransaksi', 'tanggal', 'rp', 'keterangan_trans', 'spp', 'buktitransfer', 'tahunajaran'
	];

	// Listing sub query
	// Query transaksi + nama siswa & kelas. Join beasiswa/tarif dibuang karena
	// kolomnya tidak dipakai dan membuat setiap transaksi muncul berkali-kali.
	private function builderLengkap($start_date, $end_date, $id_siswa = "")
	{
		$builder = db_connect('arafah')->table('tbl_tabungan_transaksi a')
			->select('a.notransaksi, a.kode_tab_trans, a.kodetransaksi, a.tanggal, a.rp, a.keterangan_trans, a.spp, a.buktitransfer, a.tahunajaran, e.nama_kelas, c.nama_siswa')
			->join('tbl_tabungan_siswa b', 'a.kode_tab_trans = b.kode_tab', 'left')
			->join('data_siswa c', 'b.kode_siswa = c.id_siswa', 'left')
			->join('tbl_ruangan d', 'c.id_siswa = d.id_siswa', 'left')
			->join('setup_kelas e', 'd.id_kelas = e.id_kelas', 'left')
			->where('a.tanggal >=', $start_date)
			->where('a.tanggal <', date('Y-m-d', strtotime($end_date . ' +1 day')));
		if ($id_siswa) $builder->where('c.id_siswa', $id_siswa);
		return $builder;
	}
	public function listingLengkap($start_date, $end_date, $id_siswa = "")
	{
		return $this->builderLengkap($start_date, $end_date, $id_siswa)->get()->getResultArray();
	}
	// Satu halaman data untuk DataTables server-side
	public function listingServerSide($start_date, $end_date, $id_siswa, $search, $orderColumn, $orderDir, $offset, $limit)
	{
		$recordsTotal = $this->builderLengkap($start_date, $end_date, $id_siswa)->countAllResults();
		$builder = $this->builderLengkap($start_date, $end_date, $id_siswa);
		if ($search !== '') {
			$builder->groupStart()
				->like('a.notransaksi', $search)
				->orLike('a.kode_tab_trans', $search)
				->orLike('a.kodetransaksi', $search)
				->orLike('a.keterangan_trans', $search)
				->orLike('e.nama_kelas', $search)
				->orLike('c.nama_siswa', $search)
				->groupEnd();
		}
		$recordsFiltered = $builder->countAllResults(false);
		$data = $builder->orderBy($orderColumn, $orderDir)->limit($limit, $offset)->get()->getResultArray();
		return [
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		];
	}
	public function listing($start_date, $end_date)
	{
		$db = db_connect('arafah');
		$sql = "SELECT
				notransaksi,kode_tab_trans,kodetransaksi,date(tanggal) as tanggal,rp,
				keterangan_trans,spp,buktitransfer,tahunajaran
				FROM " . $this->table .
			" WHERE tanggal BETWEEN " .
			"'$start_date' and '$end_date'";
		$query = $db->query($sql);
		return $query->getResultArray();
	}
	public function listingMutasi($start_date, $end_date, $kodetransaksi)
	{
		$db = db_connect('arafah');
		$sql = "SELECT
		a.notransaksi, a.kode_tab_trans,
		a.kodetransaksi, a.tanggal,
		a.rp, a.keterangan_trans, a.spp,a.buktitransfer,a.tahunajaran,
		e.nama_kelas,c.nama_siswa
        FROM tbl_tabungan_transaksi a
LEFT JOIN tbl_tabungan_siswa b
    ON a.kode_tab_trans = b.kode_tab
LEFT JOIN data_siswa c
    ON b.kode_siswa = c.id_siswa
LEFT JOIN tbl_ruangan d
    ON c.id_siswa = d.id_siswa
LEFT JOIN setup_kelas e
    ON d.id_kelas = e.id_kelas
WHERE DATE(a.tanggal) BETWEEN " .
			"'$start_date' and '$end_date' and a.kodetransaksi = '$kodetransaksi'";
			//echo $sql;
		$query = $db->query($sql);
		return $query->getResultArray();
	}
	// Detail
	public function detail($notransaksi)
	{
		$this->select('*');
		$this->where(array('notransaksi'	=> $notransaksi));
		$query = $this->get();
		return $query->getRowArray();
	}
	public function detailSppSiswa($id_siswa)
	{
		$db = db_connect('arafah');
		$sql = "SELECT
				tbl_tabungan_siswa.kode_siswa,
				tbl_tabungan_transaksi.notransaksi,
				tbl_tabungan_transaksi.kode_tab_trans,
				tbl_tabungan_transaksi.kodetransaksi,
				date(tbl_tabungan_transaksi.tanggal) as tanggal,
				tbl_tabungan_transaksi.rp,
				tbl_tabungan_transaksi.keterangan_trans,
				tbl_tabungan_transaksi.spp,
				tbl_tabungan_transaksi.buktitransfer,
				tbl_tabungan_transaksi.tahunajaran,
				tbl_kode_transaksi.kode_tran
				FROM tbl_tabungan_transaksi
			    left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
				left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
				where tbl_tabungan_siswa.kode_siswa = '$id_siswa'
				and tbl_tabungan_transaksi.kodetransaksi = 'TDSPP'
				order by tanggal,tbl_tabungan_transaksi.tanggal asc
				";
		$query = $db->query($sql);
		return $query->getResultArray();
	}
	public function detailTabunganSiswa($id_siswa)
	{
		$db = db_connect('arafah');
		$sql = "SELECT
				tbl_tabungan_siswa.kode_siswa,
				tbl_tabungan_transaksi.notransaksi,
				tbl_tabungan_transaksi.kode_tab_trans,
				tbl_tabungan_transaksi.kodetransaksi,
				date(tbl_tabungan_transaksi.tanggal) as tanggal,
				tbl_tabungan_transaksi.rp,
				tbl_tabungan_transaksi.keterangan_trans,
				tbl_tabungan_transaksi.spp,
				tbl_tabungan_transaksi.buktitransfer,
				tbl_tabungan_transaksi.tahunajaran,
				tbl_kode_transaksi.kode_tran
				FROM tbl_tabungan_transaksi
			    left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
				left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
				where tbl_tabungan_siswa.kode_siswa = '$id_siswa' order by tanggal,tbl_tabungan_transaksi.notransaksi asc
				";
		$query = $db->query($sql);
		return $query->getResultArray();
	}
	// Detail
	public function login($username, $password)
	{
		$this->select('*');
		$this->where([
			'username'	=> $username,
			'password'	=> sha1($password)
		]);
		$query = $this->get();
		return $query->getRowArray();
	}

	// Insert
	public function tambah($data)
	{
		$this->save($data);
	}

	// Edit
	public function edit($data)
	{
		//var_dump($data);
		$this->where('notransaksi', $data['notransaksi']);
		$this->replace($data);
	}

	// Delete
	public function hapus($notransaksi)
	{
		$this->where('notransaksi', $notransaksi);
		$this->delete();
	}
}
