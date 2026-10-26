<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

/**
 * Query untuk halaman Tabungan Siswa. Semua memakai query builder/binding.
 *
 * Transaksi tabungan (tbl_tabungan_transaksi) terhubung ke siswa lewat
 * kode_tab_trans = tbl_tabungan_siswa.kode_tab, dan tbl_tabungan_siswa.kode_siswa
 * = data_siswa.id_siswa. Jenis K (kredit/masuk) dan D (debet/keluar) diambil dari
 * tbl_kode_transaksi.kode_tran.
 */
class M_Tabungan extends Model
{
    protected $DBGroup = 'arafah';

    private function db()
    {
        return db_connect($this->DBGroup);
    }

    /** Data siswa untuk kartu di atas halaman (tanpa foto/blob). */
    public function siswa(int $id): ?array
    {
        return $this->db()->table('data_siswa s')
            ->select('s.id_siswa, s.nama_siswa, s.nis, s.locked, k.nama_kelas')
            ->join('(SELECT id_siswa, MAX(id_kelas) id_kelas FROM tbl_ruangan GROUP BY id_siswa) r', 'r.id_siswa = s.id_siswa', 'left', false)
            ->join('setup_kelas k', 'k.id_kelas = r.id_kelas', 'left')
            ->where('s.id_siswa', $id)
            ->get()->getRowArray();
    }

    /** Kode tabungan siswa (yang pertama dibuat), atau null bila belum punya. */
    public function kodeTabungan(int $id): ?string
    {
        $row = $this->db()->table('tbl_tabungan_siswa')->select('kode_tab')
            ->where('kode_siswa', $id)->orderBy('kode_tab')->get()->getRowArray();

        return $row['kode_tab'] ?? null;
    }

    public function pesertaLaundry(int $id): bool
    {
        $db = $this->db();
        if (! $db->tableExists('tbl_peserta_loundry')) {
            return false;
        }

        return (bool) $db->table('tbl_peserta_loundry')->where('id_siswa', $id)->where('peserta', 'yes')->countAllResults();
    }

    /** Cari siswa untuk pemilih siswa: nama, NIS, atau kode tabungan. */
    public function cariSiswa(string $q, int $batas = 20): array
    {
        return $this->db()->table('data_siswa s')
            ->select('s.id_siswa, s.nama_siswa, s.nis, k.nama_kelas, MIN(t.kode_tab) AS kode_tab', false)
            ->join('(SELECT id_siswa, MAX(id_kelas) id_kelas FROM tbl_ruangan GROUP BY id_siswa) r', 'r.id_siswa = s.id_siswa', 'left', false)
            ->join('setup_kelas k', 'k.id_kelas = r.id_kelas', 'left')
            ->join('tbl_tabungan_siswa t', 't.kode_siswa = s.id_siswa', 'left')
            ->groupStart()->like('s.nama_siswa', $q)->orLike('s.nis', $q)->orLike('t.kode_tab', $q)->groupEnd()
            ->whereIn('s.locked', ['no', 'baru'])
            ->groupBy('s.id_siswa, s.nama_siswa, s.nis, k.nama_kelas')
            ->orderBy('s.nama_siswa')
            ->limit($batas)
            ->get()->getResultArray();
    }

    /** Query dasar transaksi milik seorang siswa. */
    private function queryTransaksi(int $id)
    {
        return $this->db()->table('tbl_tabungan_transaksi tr')
            ->join('tbl_tabungan_siswa ts', 'ts.kode_tab = tr.kode_tab_trans')
            ->join('tbl_kode_transaksi kd', 'kd.kode = tr.kodetransaksi', 'left')
            ->where('ts.kode_siswa', $id);
    }

    /**
     * Transaksi seorang siswa dalam rentang tanggal (null = tanpa batas), urut lama ke baru.
     */
    public function riwayat(int $id, ?string $mulai, ?string $sampai): array
    {
        $b = $this->queryTransaksi($id)
            ->select('tr.notransaksi, tr.kode_tab_trans, tr.kodetransaksi, DATE(tr.tanggal) AS tanggal, tr.rp, tr.keterangan_trans, tr.buktitransfer, kd.kode_tran, kd.keterangan_kode', false);
        if ($mulai !== null) {
            $b->where('tr.tanggal >=', $mulai . ' 00:00:00');
        }
        if ($sampai !== null) {
            $b->where('tr.tanggal <=', $sampai . ' 23:59:59');
        }

        return $b->orderBy('tr.tanggal', 'ASC')->orderBy('tr.notransaksi', 'ASC')->get()->getResultArray();
    }

    /** Saldo (masuk - keluar) dari semua transaksi sebelum tanggal $sebelum (null = semua). */
    public function saldo(int $id, ?string $sebelum = null): float
    {
        $b = $this->queryTransaksi($id)
            ->select("SUM(CASE WHEN kd.kode_tran = 'K' THEN tr.rp ELSE 0 END) - SUM(CASE WHEN kd.kode_tran = 'D' THEN tr.rp ELSE 0 END) AS saldo", false);
        if ($sebelum !== null) {
            $b->where('tr.tanggal <', $sebelum . ' 00:00:00');
        }

        return (float) ($b->get()->getRow()->saldo ?? 0);
    }

    /** Jumlah rupiah per kode transaksi dalam rentang tanggal. */
    public function jumlahPerKode(int $id, string $mulai, string $sampai, array $kode): array
    {
        $hasil = array_fill_keys($kode, 0.0);
        $rows  = $this->queryTransaksi($id)
            ->select('tr.kodetransaksi, SUM(tr.rp) AS jml, COUNT(*) AS n', false)
            ->whereIn('tr.kodetransaksi', $kode)
            ->where('tr.tanggal >=', $mulai . ' 00:00:00')
            ->where('tr.tanggal <=', $sampai . ' 23:59:59')
            ->groupBy('tr.kodetransaksi')
            ->get()->getResultArray();
        foreach ($rows as $r) {
            $hasil[$r['kodetransaksi']] = (float) $r['jml'];
            $hasil[$r['kodetransaksi'] . '_n'] = (int) $r['n'];
        }

        return $hasil;
    }

    /** Tahun ajaran (tahun mulainya) transaksi paling awal siswa ini, atau null. */
    public function tahunPertama(int $id): ?int
    {
        $row = $this->queryTransaksi($id)->select('MIN(tr.tanggal) AS awal', false)->get()->getRowArray();
        if (empty($row['awal']) || (int) substr($row['awal'], 0, 4) < 2000) {
            return null;
        }
        $tahun = (int) substr($row['awal'], 0, 4);

        return (int) substr($row['awal'], 5, 2) >= 7 ? $tahun : $tahun - 1;
    }

    /** Satu transaksi beserta siswa pemiliknya. */
    public function transaksi(int $no): ?array
    {
        return $this->db()->table('tbl_tabungan_transaksi tr')
            ->select('tr.*, DATE(tr.tanggal) AS tgl, ts.kode_siswa, kd.kode_tran, kd.keterangan_kode', false)
            ->join('tbl_tabungan_siswa ts', 'ts.kode_tab = tr.kode_tab_trans', 'left')
            ->join('tbl_kode_transaksi kd', 'kd.kode = tr.kodetransaksi', 'left')
            ->where('tr.notransaksi', $no)
            ->get()->getRowArray();
    }
}
