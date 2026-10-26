<?php

namespace App\Models;

use CodeIgniter\Model;

class M_DataSiswa extends Model
{
	protected $DBGroup      = 'arafah';
	protected $table 		= 'data_siswa';
	protected $primaryKey 	= 'id_siswa';
	protected $allowedFields = [
		'id_siswa', 'nama_siswa', 'nis', 'kelamin', 'alamat_siswa', 'telpon_siswa', 'email',
		'username', 'password', 'locked', 'id_periode', 'photo', 'tanggal_masuk', 'tempat_lahir',
		'tanggal_lahir', 'nama_ortu', 'nisn', 'keterangan', 'unik', 'image'
	];


	// Listing
	public function listing()
	{
		//$db = db_connect('arafah');
		$this->select('*');
		$query = $this->getWhere(['locked' => 'no']);
		return $query->getResultArray();

		//return 'Ini adalah Method getData didalam ProductModel';
	}
	public function listing2($nama_siswa, $locked = "")
	{
		$db = db_connect('arafah');
		if ($locked) {
			$qlocked = "locked in('$locked')";
			$nama_siswa = "%";
		} else {
			$qlocked = "locked in( 'no','baru')";
			if (!$nama_siswa) $nama_siswa = "%";
		}
		$sql = "SELECT 	
		password,username,data_siswa.id_siswa,nama_siswa,nis,kelamin,alamat_siswa,tanggal_lahir,nisn,
		locked,id_periode,photo,tanggal_masuk,tempat_lahir,telpon_siswa,email,unik,nama_ortu,
		setup_kelas.nama_kelas,data_siswa.keterangan
		from data_siswa 
		left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
		left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
		where nama_siswa like '" . $nama_siswa . "' and $qlocked";
		//echo $sql;
		$query = $db->query($sql);
		return $query->getResult('array');
		//return 'Ini adalah Method getData didalam ProductModel';
	}
	public function listing3($nama_siswa, $locked = "")
	{
		$db = db_connect('arafah');
		if ($locked) {
			$qlocked = "locked in('$locked')";
			$nama_siswa = "%";
		} else {
			$qlocked = "locked in( 'no','baru')";
		}
		$sql = "SELECT 	
		password,username,data_siswa.id_siswa,nama_siswa,nis,kelamin,alamat_siswa,tanggal_lahir,nisn,
		locked,id_periode,photo,tanggal_masuk,tempat_lahir,telpon_siswa,email,unik,nama_ortu,
		setup_kelas.nama_kelas,data_siswa.keterangan
		from data_siswa 
		left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
		left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
		where nama_siswa like '" . $nama_siswa . "' and $qlocked";
		$query = $db->query($sql);
		return $query->getResult('array');
		//return 'Ini adalah Method getData didalam ProductModel';
	}
	public function listingDataTabungan($id_siswa)
	{
		$db = db_connect('arafah');
		$query = "SELECT 	
					id_siswa,kode_tab,nama_siswa,nis,kelamin,alamat_siswa,telpon_siswa,email,unik	
					from data_siswa 
					left join tbl_tabungan_siswa on data_siswa.id_siswa = tbl_tabungan_siswa.kode_siswa
					where id_siswa = '" . $id_siswa . "' and locked in('no','baru')";
		$query = $db->query($query);
		return $query->getRowArray();
		//return 'Ini adalah Method getData didalam ProductModel';
	}
	// Detail
	public function detail($id_siswa)
	{
		$this->select('*');
		$this->where(array('id_siswa'	=> $id_siswa));
		$query = $this->get();
		return $query->getRowArray();
	}
	public function detail2($id_siswa)
	{
		$db = db_connect('arafah');
		$sql = "select `data_siswa`.`id_siswa`, `nama_siswa`, `nis`, `kelamin`, `alamat_siswa`, 
		`telpon_siswa`, `email`, `username`, `password`, `locked`, `id_periode`, `photo`, 
		`tanggal_masuk`, `tempat_lahir`, `tanggal_lahir`, `nama_ortu`, `nisn`, `keterangan`, 
		`unik`, `image`,`setup_kelas`.`nama_kelas`,`tbl_ruangan`.`id_kelas`  
		from data_siswa
		left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
		left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
		where data_siswa.locked  in('no','baru') and data_siswa.id_siswa = '$id_siswa'";
		$query = $db->query($sql);
		return $query->getRowArray();
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
		$this->save($data);
	}

	// Delete
	public function hapus($data)
	{
		$this->where('id_siswa', $data['id_siswa']);
		$this->delete();
	}

	// ------------------------------------------------------------------
	// Halaman Data Siswa (daftar + form). Semua query memakai binding.
	// ------------------------------------------------------------------

	/** Kolom yang diisi lewat form Tambah/Ubah Data Siswa. */
	public const KOLOM_FORM = [
		'nama_siswa', 'nis', 'nisn', 'unik', 'kelamin', 'tempat_lahir', 'tanggal_lahir',
		'nama_ortu', 'telpon_siswa', 'email', 'alamat_siswa', 'locked', 'id_periode',
		'tanggal_masuk', 'photo', 'keterangan',
	];

	/** Status siswa: nilai kolom locked => label. */
	public const STATUS = ['baru' => 'Siswa baru', 'no' => 'Aktif', 'yes' => 'Tidak aktif'];

	/**
	 * Query dasar daftar siswa + kelas terakhir. Filter: q (nama/NIS/NISN),
	 * kelas (id_kelas), status (baru/no/yes).
	 */
	private function queryDaftar(array $filter, bool $pakaiStatus = true)
	{
		$db = db_connect($this->DBGroup);
		$builder = $db->table('data_siswa s')
			->join('(SELECT id_siswa, MAX(id_kelas) id_kelas FROM tbl_ruangan GROUP BY id_siswa) r', 'r.id_siswa = s.id_siswa', 'left', false)
			->join('setup_kelas k', 'k.id_kelas = r.id_kelas', 'left');

		$q = trim((string) ($filter['q'] ?? ''));
		if ($q !== '') {
			$builder->groupStart()
				->like('s.nama_siswa', $q)
				->orLike('s.nis', $q)
				->orLike('s.nisn', $q)
				->groupEnd();
		}
		if (! empty($filter['kelas'])) {
			$builder->where('r.id_kelas', (int) $filter['kelas']);
		}
		if ($pakaiStatus && isset(self::STATUS[$filter['status'] ?? ''])) {
			$builder->where('s.locked', $filter['status']);
		}

		return $builder;
	}

	/** Satu halaman daftar siswa (tanpa isi foto, hanya penanda ada/tidak). */
	public function cariSiswa(array $filter, int $limit, int $offset): array
	{
		return $this->queryDaftar($filter)
			->select("s.id_siswa, s.nama_siswa, s.nis, s.nisn, s.kelamin, s.tanggal_lahir, s.nama_ortu,
				s.telpon_siswa, s.email, s.alamat_siswa, s.locked, s.tempat_lahir, s.tanggal_masuk,
				s.keterangan, k.nama_kelas, CASE WHEN s.image IS NULL OR s.image = '' THEN 0 ELSE 1 END AS ada_foto", false)
			->orderBy('s.nama_siswa', 'ASC')
			->limit($limit, $offset)
			->get()->getResultArray();
	}

	/** Jumlah siswa per status untuk tab filter (mengikuti pencarian & kelas). */
	public function hitungPerStatus(array $filter): array
	{
		$hasil = ['semua' => 0, 'baru' => 0, 'no' => 0, 'yes' => 0];
		$rows = $this->queryDaftar($filter, false)
			->select('s.locked, COUNT(*) AS jml', false)
			->groupBy('s.locked')
			->get()->getResultArray();
		foreach ($rows as $r) {
			$hasil['semua'] += (int) $r['jml'];
			if (isset($hasil[$r['locked']])) {
				$hasil[$r['locked']] += (int) $r['jml'];
			}
		}

		return $hasil;
	}

	/** Semua baris sesuai filter, untuk ekspor. */
	public function semuaSiswa(array $filter): array
	{
		return $this->cariSiswa($filter, 100000, 0);
	}

	/** Data satu siswa untuk form Ubah (tanpa isi foto). */
	public function dataForm($id_siswa): ?array
	{
		$db = db_connect($this->DBGroup);

		return $db->table('data_siswa')
			->select(implode(', ', array_merge(['id_siswa'], self::KOLOM_FORM)) . ", CASE WHEN image IS NULL OR image = '' THEN 0 ELSE 1 END AS ada_foto", false)
			->where('id_siswa', $id_siswa)
			->get()->getRowArray();
	}

	/** Isi foto (base64) satu siswa, atau null. */
	public function fotoSiswa($id_siswa): ?string
	{
		$db = db_connect($this->DBGroup);
		$row = $db->table('data_siswa')->select('image')->where('id_siswa', $id_siswa)->get()->getRowArray();

		return ($row && $row['image'] !== null && $row['image'] !== '') ? $row['image'] : null;
	}

	public function daftarKelas(): array
	{
		return db_connect($this->DBGroup)->table('setup_kelas')
			->select('id_kelas, nama_kelas')->orderBy('nama_kelas')->get()->getResultArray();
	}

	public function daftarPeriode(): array
	{
		return db_connect($this->DBGroup)->table('setup_periode')
			->select('id_periode, tahun_ajaran, semester, status_aktif')
			->orderBy('id_periode', 'DESC')->get()->getResultArray();
	}

	/**
	 * Kelengkapan data siswa: daftar [label, terisi] yang sama dengan panel di form.
	 */
	public static function kelengkapan(array $s): array
	{
		$isi = static function ($v) {
			return trim((string) $v) !== '' && $v !== '0000-00-00';
		};

		return [
			['Nama lengkap', $isi($s['nama_siswa'] ?? '')],
			['Jenis kelamin', $isi($s['kelamin'] ?? '')],
			['Tanggal lahir', $isi($s['tanggal_lahir'] ?? '')],
			['NISN', $isi($s['nisn'] ?? '')],
			['Nama orang tua', $isi($s['nama_ortu'] ?? '')],
			['No. HP / WhatsApp', $isi($s['telpon_siswa'] ?? '')],
			['Foto siswa', ! empty($s['ada_foto'])],
		];
	}

	/** 'L' / 'P' dari isian lama yang bentuknya bermacam-macam (L, l, Laki-laki, Perempuan, ...). */
	public static function kodeKelamin($kelamin): string
	{
		$k = strtoupper(substr(trim((string) $kelamin), 0, 1));

		return in_array($k, ['L', 'P'], true) ? $k : '';
	}
}
