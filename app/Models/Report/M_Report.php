<?php
//from ftp
namespace App\Models\Report;

use CodeIgniter\Model;

class M_Report extends Model
{

    public function kelasPeriodeBeforeGroupByIdKelas($id_kelas, $start_date, $end_date)
    {
        $db = db_connect('arafah');

        $sql = "
    SELECT
        a.id_kelas,
        a.nama_kelas,
        COUNT(DISTINCT a.id_siswa) AS jml_siswa,

        SUM(CASE WHEN MONTH(t.tanggal)=7  THEN t.rp ELSE 0 END) AS Jul,
        SUM(CASE WHEN MONTH(t.tanggal)=8  THEN t.rp ELSE 0 END) AS Aug,
        SUM(CASE WHEN MONTH(t.tanggal)=9  THEN t.rp ELSE 0 END) AS Sep,
        SUM(CASE WHEN MONTH(t.tanggal)=10 THEN t.rp ELSE 0 END) AS Oct,
        SUM(CASE WHEN MONTH(t.tanggal)=11 THEN t.rp ELSE 0 END) AS Nov,
        SUM(CASE WHEN MONTH(t.tanggal)=12 THEN t.rp ELSE 0 END) AS Des,
        SUM(CASE WHEN MONTH(t.tanggal)=1  THEN t.rp ELSE 0 END) AS Jan,
        SUM(CASE WHEN MONTH(t.tanggal)=2  THEN t.rp ELSE 0 END) AS Feb,
        SUM(CASE WHEN MONTH(t.tanggal)=3  THEN t.rp ELSE 0 END) AS Mar,
        SUM(CASE WHEN MONTH(t.tanggal)=4  THEN t.rp ELSE 0 END) AS Apr,
        SUM(CASE WHEN MONTH(t.tanggal)=5  THEN t.rp ELSE 0 END) AS Mei,
        SUM(CASE WHEN MONTH(t.tanggal)=6  THEN t.rp ELSE 0 END) AS Jun,

        SUM(t.rp) AS jml

    FROM tbl_ruangan_$start_date a

    LEFT JOIN tbl_tabungan_siswa s
        ON a.id_siswa = s.kode_siswa

    LEFT JOIN tbl_tabungan_transaksi t
        ON s.kode_tab = t.kode_tab_trans
        AND t.kodetransaksi = 'TDSPP'
        AND t.tanggal BETWEEN '{$start_date}-07-01'
                          AND '{$end_date}-06-30'

    WHERE a.id_kelas LIKE '{$id_kelas}%'

    GROUP BY
        a.id_kelas,
        a.nama_kelas

    ORDER BY a.id_kelas
    ";
        //print($sql);

        $query = $db->query($sql);

        return $query->getResultArray();
    }

    public function kelasPeriodeBeforeGroupByIdSiswa($start_date, $end_date)
    {
        $db = db_connect('arafah');

        $sql = "
    SELECT
        a.id_siswa,
        a.nama_siswa,
        a.nama_kelas,
        a.id_kelas,
        SUM(CASE WHEN MONTH(t.tanggal)=7  THEN t.rp ELSE 0 END) AS Jul,
        SUM(CASE WHEN MONTH(t.tanggal)=8  THEN t.rp ELSE 0 END) AS Aug,
        SUM(CASE WHEN MONTH(t.tanggal)=9  THEN t.rp ELSE 0 END) AS Sep,
        SUM(CASE WHEN MONTH(t.tanggal)=10 THEN t.rp ELSE 0 END) AS Oct,
        SUM(CASE WHEN MONTH(t.tanggal)=11 THEN t.rp ELSE 0 END) AS Nov,
        SUM(CASE WHEN MONTH(t.tanggal)=12 THEN t.rp ELSE 0 END) AS Des,
        SUM(CASE WHEN MONTH(t.tanggal)=1  THEN t.rp ELSE 0 END) AS Jan,
        SUM(CASE WHEN MONTH(t.tanggal)=2  THEN t.rp ELSE 0 END) AS Feb,
        SUM(CASE WHEN MONTH(t.tanggal)=3  THEN t.rp ELSE 0 END) AS Mar,
        SUM(CASE WHEN MONTH(t.tanggal)=4  THEN t.rp ELSE 0 END) AS Apr,
        SUM(CASE WHEN MONTH(t.tanggal)=5  THEN t.rp ELSE 0 END) AS Mei,
        SUM(CASE WHEN MONTH(t.tanggal)=6  THEN t.rp ELSE 0 END) AS Jun,

        SUM(t.rp) AS jml

    FROM tbl_ruangan_$start_date a

    LEFT JOIN tbl_tabungan_siswa s
        ON a.id_siswa = s.kode_siswa

    LEFT JOIN tbl_tabungan_transaksi t
        ON s.kode_tab = t.kode_tab_trans
        AND t.kodetransaksi = 'TDSPP'
        AND t.tanggal BETWEEN '{$start_date}-07-01'
                          AND '{$end_date}-06-30'

    GROUP BY
        a.id_siswa,
        a.nama_siswa,
        a.nama_kelas,
        a.id_kelas

    ORDER BY
        a.nama_kelas,
        a.nama_siswa
    ";
        $query = $db->query($sql);

        return $query->getResultArray();
    }
    public function kelasPeriode($id_kelas, $start_date, $end_date)
    {
        $db = db_connect('arafah');
        $sql = "select
        a.nama_siswa,d.nama_kelas,d.id_kelas,
        SUM( IF( MONTH(b.tanggal) =7, b.rp, 0 ) ) AS Jul,
        SUM( IF( MONTH(b.tanggal) =8, b.rp, 0 ) ) AS Aug,
        SUM( IF( MONTH(b.tanggal) =9, b.rp, 0 ) ) AS Sep,
        SUM( IF( MONTH(b.tanggal) =10, b.rp, 0 ) ) AS Oct,
        SUM( IF( MONTH(b.tanggal) =11, b.rp, 0 ) ) AS Nov,
        SUM( IF( MONTH(b.tanggal) =12, b.rp, 0 ) ) AS Des,
        SUM( IF( MONTH(b.tanggal) =1, b.rp, 0 ) ) AS Jan,
        SUM( IF( MONTH(b.tanggal) =2, b.rp, 0 ) ) AS Feb,
        SUM( IF( MONTH(b.tanggal) =3, b.rp, 0 ) ) AS Mar,
        SUM( IF( MONTH(b.tanggal) =4, b.rp, 0 ) ) AS Apr,
        SUM( IF( MONTH(b.tanggal) =5, b.rp, 0 ) ) AS Mei,
        SUM( IF( MONTH(b.tanggal) =6, b.rp, 0 ) ) AS Jun,
        SUM(b.rp) as jml
        FROM `data_siswa` a
        left join
        ( select tbl_tabungan_transaksi.tanggal,kodetransaksi,kode_siswa,tbl_tabungan_transaksi.rp from `tbl_tabungan_siswa`
          left join `tbl_tabungan_transaksi`  on tbl_tabungan_siswa.kode_tab = tbl_tabungan_transaksi.kode_tab_trans
        ) b on a.id_siswa = b.kode_siswa
        left join tbl_ruangan c on a.id_siswa = c.id_siswa
        left join setup_kelas d on c.id_kelas = d.id_kelas
        left join tbl_tarif_spp e on d.id_kelas = e.id_kelas
        left join setup_periode g on e.periode = g.id_periode
        left join tbl_beasiswa f on a.id_siswa = f.id_siswa
        where b.tanggal between '" . $start_date . "-07-01' and '" . $end_date . "-06-30' and b.kodetransaksi = 'TDSPP'
        and g.status_aktif = 'yes'
        group by d.id_kelas order by d.nama_kelas";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResult('array');
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function listing($id_kelas, $start_date, $end_date)
    {
        $db = db_connect('arafah');

        $sql = "
    SELECT
        d.nama_kelas,
        d.id_kelas,

        SUM(CASE WHEN MONTH(t.tanggal)=7 THEN t.rp ELSE 0 END) AS Jul,
        SUM(CASE WHEN MONTH(t.tanggal)=8 THEN t.rp ELSE 0 END) AS Aug,
        SUM(CASE WHEN MONTH(t.tanggal)=9 THEN t.rp ELSE 0 END) AS Sep,
        SUM(CASE WHEN MONTH(t.tanggal)=10 THEN t.rp ELSE 0 END) AS Oct,
        SUM(CASE WHEN MONTH(t.tanggal)=11 THEN t.rp ELSE 0 END) AS Nov,
        SUM(CASE WHEN MONTH(t.tanggal)=12 THEN t.rp ELSE 0 END) AS Des,
        SUM(CASE WHEN MONTH(t.tanggal)=1 THEN t.rp ELSE 0 END) AS Jan,
        SUM(CASE WHEN MONTH(t.tanggal)=2 THEN t.rp ELSE 0 END) AS Feb,
        SUM(CASE WHEN MONTH(t.tanggal)=3 THEN t.rp ELSE 0 END) AS Mar,
        SUM(CASE WHEN MONTH(t.tanggal)=4 THEN t.rp ELSE 0 END) AS Apr,
        SUM(CASE WHEN MONTH(t.tanggal)=5 THEN t.rp ELSE 0 END) AS Mei,
        SUM(CASE WHEN MONTH(t.tanggal)=6 THEN t.rp ELSE 0 END) AS Jun,

        SUM(t.rp) AS jml

    FROM data_siswa a

    JOIN tbl_ruangan c
        ON a.id_siswa = c.id_siswa

    JOIN setup_kelas d
        ON c.id_kelas = d.id_kelas

    JOIN tbl_tarif_spp e
        ON d.id_kelas = e.id_kelas

    JOIN setup_periode g
        ON e.periode = g.id_periode
        AND g.status_aktif = 'yes'

    LEFT JOIN tbl_tabungan_siswa s
        ON a.id_siswa = s.kode_siswa

    LEFT JOIN tbl_tabungan_transaksi t
        ON s.kode_tab = t.kode_tab_trans
        AND t.kodetransaksi = 'TDSPP'
        AND t.tanggal BETWEEN '" . $start_date . "-07-01'
                           AND '" . $end_date . "-06-30'

    WHERE
        d.id_kelas LIKE '" . $id_kelas . "%'
        AND a.locked = 'no'

    GROUP BY
        d.id_kelas,
        d.nama_kelas

    ORDER BY d.nama_kelas
    ";

        $query = $db->query($sql);

        return $query->getResultArray();
    }

    public function listing2($start_date, $end_date)
    {
        $db = db_connect('arafah');

        $sql = "
    SELECT
        a.nama_siswa,
        d.nama_kelas,
        d.id_kelas,

        SUM(CASE WHEN MONTH(t.tanggal)=7 THEN t.rp ELSE 0 END) AS Jul,
        SUM(CASE WHEN MONTH(t.tanggal)=8 THEN t.rp ELSE 0 END) AS Aug,
        SUM(CASE WHEN MONTH(t.tanggal)=9 THEN t.rp ELSE 0 END) AS Sep,
        SUM(CASE WHEN MONTH(t.tanggal)=10 THEN t.rp ELSE 0 END) AS Oct,
        SUM(CASE WHEN MONTH(t.tanggal)=11 THEN t.rp ELSE 0 END) AS Nov,
        SUM(CASE WHEN MONTH(t.tanggal)=12 THEN t.rp ELSE 0 END) AS Des,
        SUM(CASE WHEN MONTH(t.tanggal)=1 THEN t.rp ELSE 0 END) AS Jan,
        SUM(CASE WHEN MONTH(t.tanggal)=2 THEN t.rp ELSE 0 END) AS Feb,
        SUM(CASE WHEN MONTH(t.tanggal)=3 THEN t.rp ELSE 0 END) AS Mar,
        SUM(CASE WHEN MONTH(t.tanggal)=4 THEN t.rp ELSE 0 END) AS Apr,
        SUM(CASE WHEN MONTH(t.tanggal)=5 THEN t.rp ELSE 0 END) AS Mei,
        SUM(CASE WHEN MONTH(t.tanggal)=6 THEN t.rp ELSE 0 END) AS Jun,

        SUM(t.rp) AS jml

    FROM data_siswa a

    JOIN tbl_ruangan c
        ON a.id_siswa = c.id_siswa

    JOIN setup_kelas d
        ON c.id_kelas = d.id_kelas

    JOIN tbl_tarif_spp e
        ON d.id_kelas = e.id_kelas

    JOIN setup_periode g
        ON e.periode = g.id_periode
        AND g.status_aktif = 'yes'

    LEFT JOIN tbl_tabungan_siswa s
        ON a.id_siswa = s.kode_siswa

    LEFT JOIN tbl_tabungan_transaksi t
        ON s.kode_tab = t.kode_tab_trans
        AND t.kodetransaksi = 'TDSPP'
        AND t.tanggal BETWEEN '" . $start_date . "-07-01'
                           AND '" . $end_date . "-06-30'

    WHERE
        a.locked = 'no'

    GROUP BY
        a.id_siswa,
        a.nama_siswa,
        d.id_kelas,
        d.nama_kelas

    ORDER BY
        a.nama_siswa
    ";

        $query = $db->query($sql);

        return $query->getResultArray();
    }
    public function tabunganSumBetween($start_date, $end_date)
    {
        $db = db_connect('arafah');
        $sql = "select SUM(b.rp) as jml
        FROM `data_siswa` a
        left join
        ( select notransaksi,kode_tab_trans,kodetransaksi,tbl_tabungan_transaksi.tanggal,tbl_tabungan_transaksi.rp,tbl_tabungan_transaksi.keterangan_trans,tbl_tabungan_transaksi.spp,
           tbl_tabungan_transaksi.buktitransfer,tbl_tabungan_transaksi.tahunajaran,kode_siswa
           from `tbl_tabungan_siswa` left join `tbl_tabungan_transaksi`  on tbl_tabungan_siswa.kode_tab = tbl_tabungan_transaksi.kode_tab_trans
        ) b on a.id_siswa = b.kode_siswa
        left join tbl_ruangan c on a.id_siswa = c.id_siswa
        left join setup_kelas d on c.id_kelas = d.id_kelas
        left join tbl_tarif_spp e on d.id_kelas = e.id_kelas
        left join tbl_beasiswa f on a.id_siswa = f.id_siswa
        where b.tanggal between '" . $start_date . "' and '" . $end_date . "' and b.kodetransaksi = 'TDTNI'
        and a.locked = 'no'
        group by b.tanggal";
        $query = $db->query($sql);
        return $query->getResult('array');
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function tabunganSumMont($monthyear)
    {
        $db = db_connect('arafah');
        $sql = "select SUM(b.rp) as jml
        FROM `data_siswa` a
        left join
        ( select notransaksi,kode_tab_trans,kodetransaksi,tbl_tabungan_transaksi.tanggal,tbl_tabungan_transaksi.rp,tbl_tabungan_transaksi.keterangan_trans,tbl_tabungan_transaksi.spp,
           tbl_tabungan_transaksi.buktitransfer,tbl_tabungan_transaksi.tahunajaran,kode_siswa
           from `tbl_tabungan_siswa` left join `tbl_tabungan_transaksi`  on tbl_tabungan_siswa.kode_tab = tbl_tabungan_transaksi.kode_tab_trans
        ) b on a.id_siswa = b.kode_siswa
        left join tbl_ruangan c on a.id_siswa = c.id_siswa
        left join setup_kelas d on c.id_kelas = d.id_kelas
        left join tbl_tarif_spp e on d.id_kelas = e.id_kelas
        left join tbl_beasiswa f on a.id_siswa = f.id_siswa
        where b.kodetransaksi = 'TDTNI' and a.locked = 'no'
        and  DATE_FORMAT(b.tanggal, '%Y-%m') = '$monthyear'";
        $query = $db->query($sql);
        return $query->getRowArray();
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function tabunganKasMont($monthyear)
    {
        $db = db_connect('arafah');
        $sql = "select `no`, `jenis`, `tanggal`,  `rp`, `keterangan`
        FROM `tbl_tabungan_kasbank`
        where DATE_FORMAT(tanggal, '%Y-%m') = '$monthyear'";
        $query = $db->query($sql);
        return $query->getResult('array');
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function INFSumBetween($monthyear)
    {
        $db = db_connect('arafah');
        $tahunAjaran = tahunajaran();
        $tahunpost = substr($monthyear, 0, 4);
        $mothpost = substr($monthyear, 5, 2);
        //$tahunAjaranA = "01/06/$tahunAjaran";
        //$tahunAjaranB = '01/' . $mothpost . '/' . $tahunpost;
        $tahunAjaranJun = mktime(0, 0, 0, "06", "01", $tahunAjaran);
        $monthyearDate = mktime(0, 0, 0, $mothpost, "01", $tahunpost);
        $tahunbulan = $tahunpost . $mothpost;
        //echo $tahunAjaranJun . "====" . $monthyearDate;

        if ($monthyearDate  <= $tahunAjaranJun) {
            $sql = "select rp as jml,rpbayar,tglbayar
            FROM tbl_infak_sum where tahunbulan = '$tahunbulan'";
        } else {
            //$sql = "select count(a.id_siswa) as jml,'0' as rpbayar,'' as tglbayar
            $sql = "select sum(b.rp) as jml,'0' as rpbayar,'' as tglbayar
            FROM `data_siswa` a
            left join
            ( select notransaksi,kode_tab_trans,kodetransaksi,tbl_tabungan_transaksi.tanggal,tbl_tabungan_transaksi.rp,tbl_tabungan_transaksi.keterangan_trans,tbl_tabungan_transaksi.spp,
               tbl_tabungan_transaksi.buktitransfer,tbl_tabungan_transaksi.tahunajaran,kode_siswa
               from `tbl_tabungan_siswa` left join `tbl_tabungan_transaksi`  on tbl_tabungan_siswa.kode_tab = tbl_tabungan_transaksi.kode_tab_trans
            ) b on a.id_siswa = b.kode_siswa
            where DATE_FORMAT(b.tanggal, '%Y-%m') = '$monthyear' and b.kodetransaksi = 'TDINF'
            and a.locked = 'no'";
        }
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResult('array');
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function INFrowdata($monthyear)
    {
        $db = db_connect('arafah');
        $tahunAjaran = tahunajaran();
        $tahunpost = substr($monthyear, 0, 4);
        $mothpost = substr($monthyear, 5, 2);
        //$tahunAjaranA = "01/06/$tahunAjaran";
        //$tahunAjaranB = '01/' . $mothpost . '/' . $tahunpost;
        $tahunAjaranJun = mktime(0, 0, 0, "06", "01", $tahunAjaran);
        $monthyearDate = mktime(0, 0, 0, $mothpost, "01", $tahunpost);
        $tahunbulan = $tahunpost . $mothpost;

        if ($monthyearDate  <= $tahunAjaranJun) {
            $tahunpost = $tahunAjaran - 1;
            $sql = "select a.nama_siswa,b.rp,b.tanggal
            FROM `tbl_ruangan_$tahunpost` a
            left join
            ( select notransaksi,kode_tab_trans,kodetransaksi,tbl_tabungan_transaksi.tanggal,tbl_tabungan_transaksi.rp,tbl_tabungan_transaksi.keterangan_trans,tbl_tabungan_transaksi.spp,
               tbl_tabungan_transaksi.buktitransfer,tbl_tabungan_transaksi.tahunajaran,kode_siswa
               from `tbl_tabungan_siswa` left join `tbl_tabungan_transaksi`  on tbl_tabungan_siswa.kode_tab = tbl_tabungan_transaksi.kode_tab_trans
            ) b on a.id_siswa = b.kode_siswa
            where DATE_FORMAT(b.tanggal, '%Y-%m') = '$monthyear' and b.kodetransaksi = 'TDINF'";
        } else {
            $sql = "select a.nama_siswa,b.rp,b.tanggal
            FROM `data_siswa` a
            left join
            ( select notransaksi,kode_tab_trans,kodetransaksi,tbl_tabungan_transaksi.tanggal,tbl_tabungan_transaksi.rp,tbl_tabungan_transaksi.keterangan_trans,tbl_tabungan_transaksi.spp,
               tbl_tabungan_transaksi.buktitransfer,tbl_tabungan_transaksi.tahunajaran,kode_siswa
               from `tbl_tabungan_siswa` left join `tbl_tabungan_transaksi`  on tbl_tabungan_siswa.kode_tab = tbl_tabungan_transaksi.kode_tab_trans
            ) b on a.id_siswa = b.kode_siswa
            where DATE_FORMAT(b.tanggal, '%Y-%m') = '$monthyear' and b.kodetransaksi = 'TDINF'
            and a.locked = 'no'";
        }
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResult('array');
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function listingPAS($start_date, $end_date)
    {
        $db = db_connect('arafah');
        $sql = "select
        a.nama_siswa,d.nama_kelas,d.id_kelas,
        SUM( IF( MONTH(b.tanggal) =7, b.rp, 0 ) ) AS Jul,
        SUM( IF( MONTH(b.tanggal) =8, b.rp, 0 ) ) AS Aug,
        SUM( IF( MONTH(b.tanggal) =9, b.rp, 0 ) ) AS Sep,
        SUM( IF( MONTH(b.tanggal) =10, b.rp, 0 ) ) AS Oct,
        SUM( IF( MONTH(b.tanggal) =11, b.rp, 0 ) ) AS Nov,
        SUM( IF( MONTH(b.tanggal) =12, b.rp, 0 ) ) AS Des,
        SUM( IF( MONTH(b.tanggal) =1, b.rp, 0 ) ) AS Jan,
        SUM( IF( MONTH(b.tanggal) =2, b.rp, 0 ) ) AS Feb,
        SUM( IF( MONTH(b.tanggal) =3, b.rp, 0 ) ) AS Mar,
        SUM( IF( MONTH(b.tanggal) =4, b.rp, 0 ) ) AS Apr,
        SUM( IF( MONTH(b.tanggal) =5, b.rp, 0 ) ) AS Mei,
        SUM( IF( MONTH(b.tanggal) =6, b.rp, 0 ) ) AS Jun,
        SUM(b.rp) as jml
        FROM `data_siswa` a
        left join
        ( select notransaksi,kode_tab_trans,kodetransaksi,tbl_tabungan_transaksi.tanggal,tbl_tabungan_transaksi.rp,tbl_tabungan_transaksi.keterangan_trans,tbl_tabungan_transaksi.spp,
           tbl_tabungan_transaksi.buktitransfer,tbl_tabungan_transaksi.tahunajaran,kode_siswa
           from `tbl_tabungan_siswa` left join `tbl_tabungan_transaksi`  on tbl_tabungan_siswa.kode_tab = tbl_tabungan_transaksi.kode_tab_trans
        ) b on a.id_siswa = b.kode_siswa
        left join tbl_ruangan c on a.id_siswa = c.id_siswa
        left join setup_kelas d on c.id_kelas = d.id_kelas
        left join tbl_tarif_spp e on d.id_kelas = e.id_kelas
        left join tbl_beasiswa f on a.id_siswa = f.id_siswa
        where b.tanggal between '" . $start_date . "-07-01' and '" . $end_date . "-06-31' and b.kodetransaksi = 'TDPAS'
        and a.locked = 'no'
        group by b.kode_siswa, a.nama_siswa, d.nama_kelas, d.id_kelas";
        $query = $db->query($sql);
        return $query->getResult('array');
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function sumPAS($start_date, $end_date)
    {
        $db = db_connect('arafah');
        $sql = "select  SUM(b.rp) as jml
        FROM `data_siswa` a
        left join
        ( select notransaksi,kode_tab_trans,kodetransaksi,tbl_tabungan_transaksi.tanggal,tbl_tabungan_transaksi.rp,tbl_tabungan_transaksi.keterangan_trans,tbl_tabungan_transaksi.spp,
           tbl_tabungan_transaksi.buktitransfer,tbl_tabungan_transaksi.tahunajaran,kode_siswa
           from `tbl_tabungan_siswa` left join `tbl_tabungan_transaksi`  on tbl_tabungan_siswa.kode_tab = tbl_tabungan_transaksi.kode_tab_trans
        ) b on a.id_siswa = b.kode_siswa
        left join tbl_ruangan c on a.id_siswa = c.id_siswa
        left join setup_kelas d on c.id_kelas = d.id_kelas
        left join tbl_tarif_spp e on d.id_kelas = e.id_kelas
        left join tbl_beasiswa f on a.id_siswa = f.id_siswa
        where b.tanggal between '" . $start_date . "-07-01' and '" . $end_date . "-06-31' and b.kodetransaksi = 'TDPAS'
        and a.locked = 'no'";
        $query = $db->query($sql);
        return $query->getResult('array');
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function sumpengeluaranPAS($start_date, $end_date)
    {
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_pengeluaran_pas.rp) as jml
        FROM tbl_pengeluaran_pas left join tbl_akun on tbl_pengeluaran_pas.kode_akun = tbl_akun.kode_akun
        where tbl_pengeluaran_pas.tanggal between '" . $start_date . "-07-01' and '" . $end_date . "-06-31'
        ";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResult('array');
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    // Report SPP satu tahun ajaran (Juli $tahun s.d. Juni $tahun+1), semua dihitung dari 3 query:
    // daftar siswa + tarif + beasiswa, transaksi TDSPP, dan pengeluaran. Bulan disusun di PHP.
    public function reportSpp($tahun, $tahunAktif, $bulanBerjalan)
    {
        $db = db_connect('arafah');
        $tahun = (int) $tahun;
        $mulai = $tahun . '-07-01';
        $sampai = ($tahun + 1) . '-07-01';
        $periode = $db->query("SELECT id_periode FROM setup_periode WHERE tahun_ajaran LIKE ? ORDER BY id_periode DESC LIMIT 1", [$tahun . '/%'])->getRowArray();
        $idPeriode = $periode['id_periode'] ?? '';

        $snapshot = 'tbl_ruangan_' . $tahun;
        if ($tahun !== (int) $tahunAktif && $db->tableExists($snapshot)) {
            // Tahun lalu: kelas dan beasiswa diambil dari salinan tbl_ruangan tahun itu
            $sqlSiswa = "SELECT a.id_siswa, a.nama_siswa, a.id_kelas, a.nama_kelas,
                    COALESCE(g.tarif, 0) tarif,
                    CASE WHEN a.peserta = 'yes' THEN 1 ELSE 0 END beasiswa,
                    CASE WHEN a.peserta = 'yes' THEN COALESCE(a.persen, 0) ELSE 0 END persen
                FROM `$snapshot` a
                LEFT JOIN tbl_tarif_spp g ON g.id_kelas = a.id_kelas AND g.periode = ?
                ORDER BY a.nama_kelas, a.nama_siswa";
        } else {
            $sqlSiswa = "SELECT c.id_siswa, c.nama_siswa, e.id_kelas, e.nama_kelas,
                    COALESCE(g.tarif, 0) tarif,
                    CASE WHEN f.id_siswa IS NULL THEN 0 ELSE 1 END beasiswa,
                    COALESCE(f.persen, 0) persen
                FROM data_siswa c
                JOIN tbl_ruangan d ON c.id_siswa = d.id_siswa
                JOIN setup_kelas e ON d.id_kelas = e.id_kelas
                LEFT JOIN tbl_tarif_spp g ON g.id_kelas = e.id_kelas AND g.periode = ?
                LEFT JOIN (
                    SELECT id_siswa, MAX(persen) persen FROM tbl_beasiswa
                    WHERE peserta = 'yes' GROUP BY id_siswa
                ) f ON f.id_siswa = c.id_siswa
                WHERE c.locked = 'no'
                ORDER BY e.nama_kelas, c.nama_siswa";
        }
        $siswaRows = $db->query($sqlSiswa, [$idPeriode])->getResultArray();

        $bayarRows = $db->query("SELECT b.kode_siswa, a.tanggal, a.rp
            FROM tbl_tabungan_transaksi a
            JOIN tbl_tabungan_siswa b ON a.kode_tab_trans = b.kode_tab
            WHERE a.kodetransaksi = 'TDSPP' AND a.tanggal >= ? AND a.tanggal < ?", [$mulai, $sampai])->getResultArray();

        $keluarRows = $db->query("SELECT tanggal, rp FROM tbl_pengeluaran
            WHERE tanggal >= ? AND tanggal < ?", [$mulai, $sampai])->getResultArray();

        // Indeks bulan 0..11 = Juli..Juni
        $idxBulan = function ($tanggal) {
            return ((int) substr($tanggal, 5, 2) + 5) % 12;
        };
        $kosong = array_fill(0, 12, 0);

        $bayarSiswa = [];
        foreach ($bayarRows as $r) {
            $id = $r['kode_siswa'];
            if (!isset($bayarSiswa[$id])) $bayarSiswa[$id] = $kosong;
            $bayarSiswa[$id][$idxBulan($r['tanggal'])] += (float) $r['rp'];
        }

        $kelas = [];
        $siswa = [];
        foreach ($siswaRows as $r) {
            $persen = $r['beasiswa'] ? min(100, max(0, (float) $r['persen'])) : 0;
            $bulan = $bayarSiswa[$r['id_siswa']] ?? $kosong;
            $s = [
                'nama_siswa' => $r['nama_siswa'],
                'nama_kelas' => $r['nama_kelas'],
                'bulan' => $bulan,
                'total' => array_sum($bulan),
            ];
            $siswa[] = $s;

            $nama = $r['nama_kelas'];
            if (!isset($kelas[$nama])) {
                $kelas[$nama] = ['nama' => $nama, 'siswa' => 0, 'beasiswa' => 0, 'target' => 0, 'bulan' => $kosong, 'total' => 0];
            }
            $kelas[$nama]['siswa']++;
            if ($r['beasiswa']) $kelas[$nama]['beasiswa']++;
            $kelas[$nama]['target'] += (float) $r['tarif'] * (1 - $persen / 100);
            foreach ($bulan as $i => $v) $kelas[$nama]['bulan'][$i] += $v;
            $kelas[$nama]['total'] += $s['total'];
        }

        $masuk = $kosong;
        $target = 0;
        foreach ($kelas as $k) {
            foreach ($k['bulan'] as $i => $v) $masuk[$i] += $v;
            $target += $k['target'];
        }
        $keluar = $kosong;
        foreach ($keluarRows as $r) {
            $keluar[$idxBulan($r['tanggal'])] += (float) $r['rp'];
        }

        return [
            'kelas' => array_values($kelas),
            'siswa' => $siswa,
            'masuk' => $masuk,
            'keluar' => $keluar,
            'targetBulan' => $target,
            'totalMasuk' => array_sum($masuk),
            'totalKeluar' => array_sum($keluar),
            'targetBerjalan' => $target * $bulanBerjalan,
        ];
    }
}
