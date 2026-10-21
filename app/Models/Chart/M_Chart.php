<?php

namespace App\Models\Chart;

use CodeIgniter\Model;

class M_Chart extends Model
{
    protected $DBGroup      = 'arafah';
    public function jmlsiswa()
    {
        $db = db_connect('arafah');
        $query = "select setup_kelas.nama_kelas kelas,count(data_siswa.id_siswa) jml from data_siswa
        left join tbl_ruangan on data_siswa.id_siswa = tbl_ruangan.id_siswa
        left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
        where data_siswa.locked = 'no'
        group by setup_kelas.id_kelas
        order by setup_kelas.nama_kelas
        ";
        $query = $db->query($query);
        return $query->getResultArray();
    }
    public function beasiswa()
    {
        $db = db_connect('arafah');
        $query = "SELECT setup_kelas.nama_kelas kelas,count(`setup_kelas`.`id_kelas`) jml FROM `tbl_beasiswa` 
        inner join tbl_ruangan on tbl_beasiswa.id_siswa = tbl_ruangan.id_siswa
        inner join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
        inner join data_siswa on tbl_beasiswa.id_siswa = data_siswa.id_siswa
        where `tbl_beasiswa`.`peserta` = 'yes' and data_siswa.locked = 'no'
        group by `setup_kelas`.`id_kelas`,`tbl_beasiswa`.`persen`";
        $query = $db->query($query);
        return $query->getResultArray();
    }
    public function beasiswa2()
    {
        $db = db_connect('arafah');
        $query = "SELECT sum(if(f.peserta = 'yes',1,0)) jml,e.nama_kelas,e.id_kelas,a.id_siswa FROM `data_siswa` a 
        left join tbl_ruangan d on a.id_siswa = d.id_siswa 
        left join setup_kelas e on d.id_kelas = e.id_kelas 
        left join tbl_beasiswa f on a.id_siswa = f.id_siswa 
        where a.locked = 'no' group by e.id_kelas order by e.nama_kelas";
        $query = $db->query($query);
        return $query->getResultArray();
    }
    public function sum_blmbayar_perkelas()
    {
        $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $db = db_connect('arafah');
        $query = "
        SELECT sum(belumbayarCount) jml,nama_kelas,id_kelas,id_siswa from
        (
            SELECT 
                    sum(a.rp)-(TIMESTAMPDIFF(MONTH, '$tahunAjaran-05-30', NOW())*g.tarif) selish,
                    if((sum(a.rp)-(TIMESTAMPDIFF(MONTH, '$tahunAjaran-05-30', NOW())*g.tarif))<0,1,0) belumbayarCount,
                    e.nama_kelas,e.id_kelas,c.id_siswa
                    FROM `data_siswa` c
                    left join tbl_tabungan_siswa b on b.kode_siswa = c.id_siswa 
                    left join tbl_tabungan_transaksi a on a.kode_tab_trans = b.kode_tab
                    left join tbl_ruangan d on c.id_siswa = d.id_siswa
                    left join setup_kelas e on d.id_kelas = e.id_kelas 
                    left join tbl_tarif_spp g on e.id_kelas = g.id_kelas
                    left join setup_periode h on g.periode = h.id_periode
                    where 
                    a.kodetransaksi = 'TDSPP' AND 
                    a.TANGGAL > '$tahunAjaran-06-30' and 
                    c.locked = 'no' and
                    h.status_aktif = 'yes'
                    group by c.id_siswa
                    order by e.nama_kelas
        ) a GROUP by a.id_kelas;
        ";
        //echo $query;

        $query = $db->query($query);
        return $query->getResultArray();
    }
    // Satu baris per siswa aktif: kelas, tarif periode aktif, persen beasiswa dan SPP yang sudah dibayar.
    // Siswa yang belum pernah bayar tetap muncul (dibayar = 0).
    public function rekapSppSiswa($id_periode, $tanggalMulai)
    {
        $db = db_connect('arafah');
        $query = "SELECT c.id_siswa, c.nama_siswa, e.id_kelas, e.nama_kelas,
            COALESCE(g.tarif, 0) tarif,
            f.id_siswa IS NOT NULL beasiswa,
            COALESCE(f.persen, 0) persen,
            COALESCE(p.dibayar, 0) dibayar
        FROM data_siswa c
        LEFT JOIN tbl_ruangan d ON c.id_siswa = d.id_siswa
        LEFT JOIN setup_kelas e ON d.id_kelas = e.id_kelas
        LEFT JOIN tbl_tarif_spp g ON g.id_kelas = e.id_kelas AND g.periode = ?
        LEFT JOIN (
            SELECT id_siswa, MAX(persen) persen FROM tbl_beasiswa
            WHERE peserta = 'yes' GROUP BY id_siswa
        ) f ON f.id_siswa = c.id_siswa
        LEFT JOIN (
            SELECT b.kode_siswa, SUM(a.rp) dibayar
            FROM tbl_tabungan_transaksi a
            JOIN tbl_tabungan_siswa b ON a.kode_tab_trans = b.kode_tab
            WHERE a.kodetransaksi = 'TDSPP' AND a.tanggal > ?
            GROUP BY b.kode_siswa
        ) p ON p.kode_siswa = c.id_siswa
        WHERE c.locked = 'no'
        ORDER BY e.nama_kelas, c.nama_siswa";
        $query = $db->query($query, [$id_periode, $tanggalMulai]);
        return $query->getResultArray();
    }
    // Rekap per kelas (jumlah siswa, beasiswa, kurang bayar, tunggakan) plus daftar siswanya
    public function rekapSppPerKelas($id_periode, $tanggalMulai, $bulan)
    {
        $rows = $this->rekapSppSiswa($id_periode, $tanggalMulai);

        $kelas = [];
        $total = ['siswa' => 0, 'beasiswa' => 0, 'kurang' => 0, 'lunas' => 0, 'beasiswaPenuh' => 0, 'tunggakan' => 0];
        foreach ($rows as $row) {
            $persen = $row['beasiswa'] ? min(100, max(0, (float) $row['persen'])) : 0;
            $harus = $bulan * (float) $row['tarif'] * (1 - $persen / 100);
            $row['persen'] = $persen;
            $row['harus'] = $harus;
            $row['selisih'] = (float) $row['dibayar'] - $harus;
            if ($row['beasiswa'] && $persen >= 100) {
                $row['status'] = 'beasiswaPenuh';
            } elseif ($row['selisih'] < 0) {
                $row['status'] = 'kurang';
            } else {
                $row['status'] = 'lunas';
            }

            $nama = $row['nama_kelas'] ?? 'Tanpa kelas';
            if (!isset($kelas[$nama])) {
                $kelas[$nama] = ['nama' => $nama, 'siswa' => 0, 'beasiswa' => 0, 'kurang' => 0, 'lunas' => 0, 'beasiswaPenuh' => 0, 'tunggakan' => 0, 'daftar' => []];
            }
            $k = &$kelas[$nama];
            $k['siswa']++;
            $k[$row['status']]++;
            if ($row['beasiswa']) $k['beasiswa']++;
            if ($row['selisih'] < 0) $k['tunggakan'] -= $row['selisih'];
            $k['daftar'][] = $row;
            unset($k);
        }
        foreach ($kelas as &$k) {
            usort($k['daftar'], fn ($a, $b) => $a['selisih'] <=> $b['selisih']);
            foreach (['siswa', 'beasiswa', 'kurang', 'lunas', 'beasiswaPenuh', 'tunggakan'] as $f) {
                $total[$f] += $k[$f];
            }
        }
        unset($k);
        return ['kelas' => array_values($kelas), 'total' => $total];
    }
}
