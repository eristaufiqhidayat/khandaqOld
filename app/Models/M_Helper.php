<?php
//
namespace App\Models;

use CodeIgniter\Model;

class M_Helper extends Model
{
    protected $DBGroup      = 'arafah';
    public function rowUsers()
    {
        $db = db_connect();
        $sql = "SELECT username,id,email FROM users";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function selectModule()
    {
        $db = db_connect();
        $sql = "SELECT id_module,nama_module FROM tbl_module";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function rowDSB($id_siswa)
    {
        $db = db_connect('arafah');
        $sql = "SELECT *
				FROM tbl_dsb
			     WHERE id_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function rowDU($id_siswa)
    {
        $db = db_connect('arafah');
        $sql = "SELECT *
				FROM tbl_daftar_ulang2
			     WHERE id_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function sumsiswakelas($id_kelas, $tahunajaran)
    {
        $db = db_connect('arafah');
        $tahunAjaran = tahunajaran();
        $snapshot = 'tbl_ruangan_' . (int) $tahunajaran;
        if ((int) $tahunAjaran !== (int) $tahunajaran && $db->tableExists($snapshot)) {
            // Tahun lalu: jumlah siswa dari salinan tbl_ruangan tahun itu
            $query = "SELECT COUNT(*) AS jml FROM `$snapshot` WHERE id_kelas = ?";
        } else {
            $query = "SELECT
                COUNT(*) AS jml
            FROM tbl_ruangan r
            INNER JOIN data_siswa s
                ON s.id_siswa = r.id_siswa
            WHERE s.locked = 'no'
            AND r.id_kelas = ?";
        }
        $query = $db->query($query, [$id_kelas]);
        return $query->getRowArray();
    }
    public function sumpengeluaransppbulan($bulan, $tahun)
    {
        $db = db_connect('arafah');
        $sql = "select sum(rp) as total from tbl_pengeluaran where month(tanggal) = '$bulan' and year(tanggal) = '$tahun'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function countmonth($start_date, $end_date)
    {
        $db = db_connect('arafah');
        $sql = "SELECT TIMESTAMPDIFF(MONTH, '$start_date', '$end_date') MONTH";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumdebitsppsiswa($id_siswa, $start_date, $end_date)
    {
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_tabungan_transaksi.rp) TOTALSPP
				FROM tbl_tabungan_transaksi
			    left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
				left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
			     WHERE tbl_tabungan_transaksi.tanggal BETWEEN " .
            "'$start_date' and '$end_date'
                and tbl_tabungan_transaksi.kodetransaksi = 'TDSPP'
                and tbl_tabungan_siswa.kode_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumdebitldrsiswa($id_siswa, $start_date, $end_date)
    {
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_tabungan_transaksi.rp) TOTALLDR
				FROM tbl_tabungan_transaksi
			    left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
				left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
			     WHERE tbl_tabungan_transaksi.tanggal BETWEEN " .
            "'$start_date' and '$end_date'
                and tbl_tabungan_transaksi.kodetransaksi = 'TDLDR'
                and tbl_tabungan_siswa.kode_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumdebitkessiswa($id_siswa, $start_date, $end_date)
    {
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_tabungan_transaksi.rp) TOTALKES
				FROM tbl_tabungan_transaksi
			    left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
				left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
			     WHERE tbl_tabungan_transaksi.tanggal BETWEEN " .
            "'$start_date' and '$end_date'
                and tbl_tabungan_transaksi.kodetransaksi = 'TDKES'
                and tbl_tabungan_siswa.kode_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumtransaksiperbulan($tahunbulan, $kodetransaksi)
    {
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_tabungan_transaksi.rp) total
				FROM tbl_tabungan_transaksi
			    left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
				left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
			     WHERE DATE_FORMAT(tbl_tabungan_transaksi.tanggal, '%Y-%m') = '$tahunbulan'
                and tbl_tabungan_transaksi.kodetransaksi = '$kodetransaksi'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumtransaksiperbulanPeriodeBefore($tahunbulan)
    {
        $tahunAjaran = tahunajaran();
        $tahunpost = substr($tahunbulan, 0, 4);
        $bulanpost = substr($tahunbulan, 5, 2);
        $cekbulan = cekbulanperiode($bulanpost);
        $tahunpost = $tahunpost + $cekbulan;
        if ($tahunAjaran == $tahunpost) {
            $sql = "SELECT sum(tbl_tabungan_transaksi.rp) total
            FROM tbl_tabungan_transaksi
            left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
            left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
             WHERE DATE_FORMAT(tbl_tabungan_transaksi.tanggal, '%Y-%m') = '$tahunbulan'
            and tbl_tabungan_transaksi.kodetransaksi = 'TDSPP'";
        } else {
            $sql = "SELECT sum(b.rp) total
            FROM tbl_ruangan_$tahunpost a
            left join
            ( select tbl_tabungan_transaksi.tanggal,kodetransaksi,kode_siswa,tbl_tabungan_transaksi.rp from `tbl_tabungan_siswa`
            left join `tbl_tabungan_transaksi`  on tbl_tabungan_siswa.kode_tab = tbl_tabungan_transaksi.kode_tab_trans
            ) b on a.id_siswa = b.kode_siswa
            where DATE_FORMAT(b.tanggal, '%Y-%m') = '$tahunbulan' and b.kodetransaksi = 'TDSPP'";
        }
        $db = db_connect('arafah');

        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumDSBperbulan($tahunbulan)
    {
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_dsb.rp) total
				FROM tbl_dsb
			     WHERE DATE_FORMAT(tbl_dsb.tanggal, '%Y-%m') = '$tahunbulan'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumDUperbulan($tahunbulan)
    {
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_daftar_ulang2.rp) total
				FROM tbl_daftar_ulang2
			     WHERE DATE_FORMAT(tbl_daftar_ulang2.tanggal, '%Y-%m') = '$tahunbulan'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumDSBpertahunajaran($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        // $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $db = db_connect('arafah');
        $sql = "SELECT sum(a.rp) total
				FROM tbl_dsb a left join data_siswa b on a.id_siswa = b.id_siswa
			     WHERE a.tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumFormulirpertahunajaran($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        // $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_formulir.rp) total
				FROM tbl_formulir
			     WHERE tbl_formulir.tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumDUpertahunajaran($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_daftar_ulang2.rp) total
				FROM tbl_daftar_ulang2
			     WHERE tbl_daftar_ulang2.jenis ='du' and tbl_daftar_ulang2.tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function rowDSBpertahunajaran($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $tahunAjaran3 = $tahunAjaran - 1;
        $db = db_connect('arafah');
        // $sql = "SELECT @rownum := @rownum + 1 AS row_num,a.id_siswa,b.nama_siswa,sum(a.rp) sum,a.rp,a.tanggal,b.locked FROM `tbl_dsb` a
        // left join data_siswa b on a.id_siswa = b.id_siswa,
        // (SELECT @rownum := 0) r
        // WHERE b.locked = 'baru' and b.id_periode = '$tahunAjaran' group by a.id_siswa;";
        $sql = "SELECT @rownum := @rownum + 1 AS row_num, a.id_siswa, b.nama_siswa,
        SUM(a.rp) AS sum, MAX(a.rp) AS rp,  MAX(a.tanggal) AS tanggal,
        b.locked FROM `tbl_dsb` a LEFT JOIN data_siswa b ON a.id_siswa = b.id_siswa,
        (SELECT @rownum := 0) r WHERE b.locked = 'baru' GROUP BY a.id_siswa LIMIT 0, 25;";
        //echo $sql;
        // $sql = "SELECT a.*,b.nama_siswa,d.nama_kelas
        // 		FROM tbl_dsb a
        //         left join data_siswa b on b.id_siswa = a.id_siswa
        //         left join tbl_ruangan c on c.id_siswa = b.id_siswa
        //         left join setup_kelas d on d.id_kelas = c.id_kelas
        // 	     WHERE a.tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30' group by b.id_siswa";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function rowDSBpertahunajaran_all($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $tahunAjaran3 = $tahunAjaran - 1;
        $db = db_connect('arafah');
        // $sql = "SELECT @rownum := @rownum + 1 AS row_num,a.id_siswa,b.nama_siswa,sum(a.rp) sum,a.rp,a.tanggal,b.locked FROM `tbl_dsb` a
        // left join data_siswa b on a.id_siswa = b.id_siswa,
        // (SELECT @rownum := 0) r
        // WHERE b.locked = 'baru' and b.id_periode = '$tahunAjaran' group by a.id_siswa;";
        $sql = "SELECT @rownum := @rownum + 1 AS row_num,a.id_siswa,b.nama_siswa,sum(a.rp) sum,a.rp,a.tanggal,b.locked FROM `tbl_dsb` a
                left join data_siswa b on a.id_siswa = b.id_siswa,
                (SELECT @rownum := 0) r
                WHERE a.tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30' group by a.id_siswa;";
        // $sql = "SELECT a.*,b.nama_siswa,d.nama_kelas
        // 		FROM tbl_dsb a
        //         left join data_siswa b on b.id_siswa = a.id_siswa
        //         left join tbl_ruangan c on c.id_siswa = b.id_siswa
        //         left join setup_kelas d on d.id_kelas = c.id_kelas
        // 	     WHERE a.tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30' group by b.id_siswa";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function rowDSBpengeluaranpertahunajaran($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $tahunAjaran3 = $tahunAjaran - 1;
        $db = db_connect('arafah');
        $sql = "SELECT
                no, tanggal, tbl_akun.kode_akun, tbl_akun.nama_akun,kode_pengusul, rutin, rp, keterangan
				FROM tbl_pengeluaran_dsb left join tbl_akun on tbl_pengeluaran_dsb.kode_akun = tbl_akun.kode_akun
                where tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30'";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function rowFormulirpertahunajaran($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $tahunAjaran3 = $tahunAjaran - 1;
        $db = db_connect('arafah');
        //$sql = "SELECT @rownum := @rownum + 1 AS row_num,a.nama_siswa,a.rp sum,a.rp,a.tanggal
        //from tbl_formulir a, (SELECT @rownum := 0) r where a.tanggal between '$tahunAjaran-08-01' and '$tahunAjaran2-07-30'";
        $sql = "SELECT @rownum := @rownum + 1 AS row_num,a.nama_siswa,a.rp sum,a.rp,a.tanggal
                from tbl_formulir a, (SELECT @rownum := 0) r where DATE_FORMAT(a.tanggal, '%Y-%m') ='$tahunbulan' ";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function rowDUpertahunajaran($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $db = db_connect('arafah');
        $sql = "SELECT a.*,b.nama_siswa,d.nama_kelas
				FROM tbl_daftar_ulang2 a
                left join data_siswa b on b.id_siswa = a.id_siswa
                left join tbl_ruangan c on c.id_siswa = b.id_siswa
                left join setup_kelas d on d.id_kelas = c.id_kelas
			     WHERE a.jenis = 'du' and a.tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30'";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function sumPengeluaranDSBpertahunajaran($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_pengeluaran_dsb.rp) total
				FROM tbl_pengeluaran_dsb
			     WHERE tbl_pengeluaran_dsb.tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumPengeluaranFormulirpertahunajaran($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_pengeluaran_formulir.rp) total
				FROM tbl_pengeluaran_formulir
			     WHERE tbl_pengeluaran_formulir.tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumPengeluaranDUpertahunajaran($tahunbulan)
    {
        if (substr($tahunbulan, 5, 2) < 7 && substr($tahunbulan, 5, 2) >= 1) $tahunAjaran = substr($tahunbulan, 0, 4) - 1;
        else $tahunAjaran = tahunajaran();
        $tahunAjaran2 = $tahunAjaran + 1;
        $db = db_connect('arafah');
        $sql = "SELECT sum(tbl_pengeluaran_du.rp) total
				FROM tbl_pengeluaran_du
			     WHERE tbl_pengeluaran_du.tanggal between '$tahunAjaran-07-01' and '$tahunAjaran2-06-30'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function rowdebitsppsiswa($id_siswa, $start_date, $end_date, $kodetransaksi)
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
			     WHERE tbl_tabungan_transaksi.tanggal BETWEEN " .
            "'$start_date' and '$end_date'
                and tbl_tabungan_transaksi.kodetransaksi = '$kodetransaksi'
                and tbl_tabungan_siswa.kode_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function datapengusul()
    {
        $db = db_connect('arafah');
        $query = "SELECT * FROM `tbl_pengusul`";
        $query = $db->query($query);
        return $query->getResultArray();
    }
    public function dataakun()
    {
        $db = db_connect('arafah');
        $query = "SELECT * FROM `tbl_akun`";
        $query = $db->query($query);
        return $query->getResultArray();
    }
    public function cekspp($id_siswa, $tahunajaran)
    {
        $db = db_connect('arafah');
        $query = "select * from tbl_spp where nis = '$id_siswa' and tahunajaran = '" . $tahunajaran . "'";
        $query = $db->query($query);
        return $query->getRowArray();
        //return $query->getResult('array');
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function cekbayarspp($id_siswa, $tahunajaran)
    {
        $db = db_connect('arafah');
        $query = "select
        spp,tahunajaran
        from `tbl_tabungan_siswa`
        left join `tbl_tabungan_transaksi`
        on tbl_tabungan_siswa.kode_tab = tbl_tabungan_transaksi.kode_tab_trans
        where kode_siswa = '$id_siswa' and tahunajaran = '$tahunajaran' and kodetransaksi = 'TDSPP'";
        echo $query;
        $query = $db->query($query);
        return $query->getResultArray();
        //return $query->getResult('array');
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function periodetahunajaran()
    {
        $db = db_connect('arafah');
        $query = "SELECT * FROM `setup_periode` where status_aktif = 'yes' ORDER BY id_periode DESC LIMIT 1";
        $query = $db->query($query);
        return $query->getRowArray();
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function periode()
    {
        $db = db_connect('arafah');
        $query = "SELECT SUBSTRING(tahun_ajaran,1,4) AS tahun
FROM setup_periode
ORDER BY id_periode DESC
LIMIT 2";
        $query = $db->query($query);
        return $query->getResultArray();
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function cekpesertaloundry($id_siswa)
    {
        $db = db_connect('arafah');
        $query = "select * from VSISWAKELAS a left join setup_kelas b on a.id_kelas= b.id_kelas
        LEFT join tbl_peserta_loundry c on a.id_siswa = c.id_siswa
        left join tbl_spp d on a.id_siswa = d.nis where c.peserta = 'yes' and a.id_siswa = '$id_siswa'";
        $query = $db->query($query);
        return $query->getRowArray();
        //return 'Ini adalah Method getData didalam ProductModel';
    }
    public function cekbeasiswa($id_siswa)
    {
        $db = db_connect('arafah');
        $query = "SELECT * FROM `tbl_beasiswa` where `tbl_beasiswa`.`peserta` = 'yes'
                      and `tbl_beasiswa`.`id_siswa` = '$id_siswa'";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function sumbeasiswakelas($id_kelas)
    {
        $db = db_connect('arafah');
        $tahunAjaran = tahunajaran();
        // Nama tabel snapshot hanya dari angka tahun, dan hanya kalau tabelnya ada
        $tahunPilih = (int) service('request')->getVar('tahunajaranselect');
        $snapshot = 'tbl_ruangan_' . $tahunPilih;
        if ($tahunPilih && $tahunPilih !== (int) $tahunAjaran && $db->tableExists($snapshot))
            $query = "SELECT count(`id_kelas`) jml,`persen` FROM `$snapshot`
                where id_kelas = ? and peserta = 'yes'";
        else
            $query = "SELECT count(`setup_kelas`.`id_kelas`) jml,`tbl_beasiswa`.`persen` FROM `tbl_beasiswa`
        		left join tbl_ruangan on tbl_beasiswa.id_siswa = tbl_ruangan.id_siswa
                left join setup_kelas on tbl_ruangan.id_kelas = setup_kelas.id_kelas
                where `tbl_beasiswa`.`peserta` = 'yes'
                and `setup_kelas`.`id_kelas` = ?
                group by `setup_kelas`.`id_kelas`,`tbl_beasiswa`.`persen`";

        $query = $db->query($query, [$id_kelas]);
        return $query->getRowArray();
    }
    public function saldotabungan($id_siswa)
    {
        $db = db_connect('arafah');
        $query = "SELECT sum(if(tbl_kode_transaksi.kode_tran = 'K',tbl_tabungan_transaksi.rp,0))-sum(if(tbl_kode_transaksi.kode_tran = 'D',tbl_tabungan_transaksi.rp,0)) as SALDO
        FROM tbl_tabungan_transaksi
        left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
        left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
        where tbl_tabungan_siswa.kode_siswa = '$id_siswa'
        ORDER BY `tbl_tabungan_siswa`.`rp` DESC
				";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function kredittabungan($id_siswa)
    {
        $db = db_connect('arafah');
        $query = "SELECT sum(if(tbl_kode_transaksi.kode_tran = 'K',tbl_tabungan_transaksi.rp,0)) as KREDIT
        FROM tbl_tabungan_transaksi
        left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
        left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
        where tbl_tabungan_siswa.kode_siswa = '$id_siswa'
        ORDER BY `tbl_tabungan_siswa`.`rp` DESC
				";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function debettabungan($id_siswa)
    {
        $db = db_connect('arafah');
        $query = "SELECT sum(if(tbl_kode_transaksi.kode_tran = 'D',tbl_tabungan_transaksi.rp,0)) as DEBET
        FROM tbl_tabungan_transaksi
        left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
        left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
        where tbl_tabungan_siswa.kode_siswa = '$id_siswa'
        ORDER BY `tbl_tabungan_siswa`.`rp` DESC
				";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function insertLoundry($id_siswa)
    {
        $db = db_connect('arafah');
        $query = "SELECT FORMAT(sum(if(tbl_kode_transaksi.kode_tran = 'D',tbl_tabungan_transaksi.rp,0)),0) as DEBET
        FROM tbl_tabungan_transaksi
        left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
        left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
        where tbl_tabungan_siswa.kode_siswa = '$id_siswa'
        ORDER BY `tbl_tabungan_siswa`.`rp` DESC
				";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function inserttblspp($id_siswa, $queryrp2, $tahunajaranaktip)
    {
        $db = db_connect('arafah');
        $query = "Update tbl_spp set
                  $queryrp2
                  where nis = '$id_siswa' and tahunajaran = '$tahunajaranaktip'
                   ";
        $query = $db->query($query);
    }
    public function msppkelas($id_siswa)
    {
        $db = db_connect('arafah');
        $query = "SELECT * FROM `tbl_ruangan` LEFT join `setup_kelas` on `tbl_ruangan`.`id_kelas` = `setup_kelas`.`id_kelas`
        where `tbl_ruangan`.`id_siswa` = '$id_siswa'";
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function mrowtarifspp()
    {
        $db = db_connect('arafah');
        $query = "select * from tbl_tarif_spp a
        left join setup_periode b on a.periode = b.id_periode
        where b.id_periode = (SELECT id_periode FROM setup_periode WHERE status_aktif = 'yes' ORDER BY id_periode DESC LIMIT 1)
        ";
        $query = $db->query($query);
        return $query->getResult('array');
    }
    public function debetspp($kode_tab, $tanggal, $totalspp, $keterangan, $sppbulan, $tahunajaranaktip)
    {
        $db = db_connect('arafah');
        $query = "INSERT INTO `tbl_tabungan_transaksi`
        (`notransaksi`, `kode_tab_trans`, `kodetransaksi`, `tanggal`, `rp`, `keterangan_trans`,`spp`,`tahunajaran`)
        VALUES (NULL, '$kode_tab', 'TDSPP', '$tanggal', '$totalspp', '$keterangan','$sppbulan','$tahunajaranaktip')
              ";
        $query = $db->query($query);
    }
    public function debetloundry($kode_tab, $tanggal, $rptotal, $sppbulan)
    {
        $db = db_connect('arafah');
        $query = "INSERT INTO `tbl_tabungan_transaksi`
        (`notransaksi`, `kode_tab_trans`, `kodetransaksi`, `tanggal`, `rp`, `keterangan_trans`,`spp`)
        VALUES (NULL, '$kode_tab', 'TDLDR', '$tanggal', '$rptotal', 'Debit Uang Loundry','$sppbulan')
              ";
        $query = $db->query($query);
    }
    public function debetkes($kode_tab, $tanggal, $rptotal, $sppbulan)
    {
        $db = db_connect('arafah');
        $query = "INSERT INTO `tbl_tabungan_transaksi`
        (`notransaksi`, `kode_tab_trans`, `kodetransaksi`, `tanggal`, `rp`, `keterangan_trans`,`spp`)
        VALUES (NULL, '$kode_tab', 'TDKES', '$tanggal', '$rptotal', 'Debit Uang Kesehatan','$sppbulan')
              ";
        $query = $db->query($query);
    }
    public function debetadm($kode_tab, $tanggal, $rpadm, $keterangan)
    {
        $db = db_connect('arafah');
        $query = "INSERT INTO `tbl_tabungan_transaksi` (`notransaksi`, `kode_tab_trans`, `kodetransaksi`, `tanggal`, `rp`, `keterangan_trans`)
        VALUES (NULL, '$kode_tab', 'TDINF', '$tanggal', '$rpadm', '$keterangan')";
        $query = $db->query($query);
    }
    //
    public function sum_blmbayar_perkelas_list($id_kelas)
    {
        $tahunAjaran = tahunajaran();
        $db = db_connect('arafah');
        $query = "SELECT
        sum(a.rp) jmldibayar,(TIMESTAMPDIFF(MONTH, '$tahunAjaran-05-30', NOW())*g.tarif) jmlharusbayar,f.peserta,e.nama_kelas,e.id_kelas,c.id_siswa,c.nama_siswa,g.tarif-(f.persen*g.tarif/100) rppersen
        FROM `tbl_tabungan_transaksi` a
        left join tbl_tabungan_siswa b on a.kode_tab_trans = b.kode_tab
        left join data_siswa c on b.kode_siswa = c.id_siswa
        left join tbl_ruangan d on c.id_siswa = d.id_siswa
        left join setup_kelas e on d.id_kelas = e.id_kelas
        left join tbl_beasiswa f on c.id_siswa = f.id_siswa
        left join tbl_tarif_spp g on e.id_kelas = g.id_kelas
        left join setup_periode h on g.periode = h.id_periode
        where
        a.kodetransaksi = 'TDSPP' and
        a.TANGGAL > '$tahunAjaran-06-30' and
        c.locked = 'no' and
        e.nama_kelas = '$id_kelas' and
        h.id_periode = (SELECT id_periode FROM setup_periode WHERE status_aktif = 'yes' ORDER BY id_periode DESC LIMIT 1)
        group by c.id_siswa
        order by e.nama_kelas
        ";
        //echo $query;
        $query = $db->query($query);
        return $query->getResultArray();
    }
    public function sum_blmbayar_perkelas_sum($id_kelas)
    {
        $tahunAjaran = tahunajaran();
        $db = db_connect('arafah');
        $query = "SELECT
        count(if(sum(a.rp)-((month(now())-month('$tahunAjaran-06-30'))*g.tarif) < 0,1,0)) jmlharusbayar,f.peserta,e.nama_kelas,e.id_kelas,c.id_siswa,c.nama_siswa,g.tarif-(f.persen*g.tarif/100) rppersen
        FROM `tbl_tabungan_transaksi` a
        left join tbl_tabungan_siswa b on a.kode_tab_trans = b.kode_tab
        left join data_siswa c on b.kode_siswa = c.id_siswa
        left join tbl_ruangan d on c.id_siswa = d.id_siswa
        left join setup_kelas e on d.id_kelas = e.id_kelas
        left join tbl_beasiswa f on c.id_siswa = f.id_siswa
        left join tbl_tarif_spp g on e.id_kelas = g.id_kelas
        left join setup_periode h on g.periode = h.id_periode
        where
        a.kodetransaksi = 'TDSPP' and
        a.TANGGAL > '$tahunAjaran-06-30' and
        c.locked = 'no' and
        e.nama_kelas = '$id_kelas' and
        h.id_periode = (SELECT id_periode FROM setup_periode WHERE status_aktif = 'yes' ORDER BY id_periode DESC LIMIT 1)
        group by d.id_kelas
        order by e.nama_kelas
        ";
        //echo $query;
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function listingmodule()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM tbl_module ");
        return $query->getResult('array');
    }
    public function kelompokMataPelajaran($id_kelompok = "")
    {
        (isset($id_kelompok) && $id_kelompok !== "") ? $where = "where id_kelompok = '$id_kelompok'" : $where = "";
        $db = db_connect('arafah');
        $sql = "SELECT * FROM setup_kelompok_matpel $where";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function MataPelajaran($id_matapelajaran = "")
    {
        (isset($id_matapelajaran) && $id_matapelajaran !== "") ? $where = "where id_matapelajaran = '$id_matapelajaran'" : $where = "";
        $db = db_connect('arafah');
        $sql = "SELECT * FROM setup_matapelajaran $where";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function MataPelajaranNilaiGuru($id_guru, $id_periode)
    {

        $db = db_connect('arafah');
        $sql = "SELECT a.id_matapelajaran,a.nama_matapelajaran FROM setup_matapelajaran a
        left join tbl_jadwal_mengajar b on a.id_matapelajaran = b.id_matapelajaran
        where b.id_guru = '$id_guru' and b.id_periode = '$id_periode' group by a.id_matapelajaran";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function rowkelas($id_kelas = "")
    {
        (isset($id_kelas) && $id_kelas !== "") ? $where = "where id_kelas = '$id_kelas'" : $where = "";
        $db = db_connect('arafah');
        $sql = "SELECT * FROM setup_kelas $where";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function rowkelasNilaiGuru($id_guru)
    {
        $db = db_connect('arafah');
        $sql = "SELECT a.id_kelas,a.nama_kelas FROM setup_kelas a
        left join tbl_jadwal_mengajar b on a.id_kelas = b.id_kelas
        where b.id_guru = '$id_guru' group by b.id_kelas;";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function rowruangkelas($id_ruang_kelas = "")
    {
        (isset($id_ruang_kelas) && $id_ruang_kelas !== "") ? $where = "where id_ruang_kelas = '$id_ruang_kelas'" : $where = "";
        $db = db_connect('arafah');
        $sql = "SELECT * FROM setup_ruang_kelas $where";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function periodeaktif()
    {
        $db = db_connect('arafah');
        $sql = "SELECT * FROM setup_periode where status_aktif = 'yes' ORDER BY id_periode DESC LIMIT 1";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function dropdowDataSiswa()
    {
        $db = db_connect('arafah');
        $sql = "SELECT id_siswa,nama_siswa FROM data_siswa where locked = 'no'";
        $query = $db->query($sql);
        return $query->getResultArray();
    }

    public function dropdowDataSiswaGuru($id_guru)
    {
        $db = db_connect('arafah');
        $sql = "SELECT b.id_siswa,nama_siswa FROM data_siswa b
        left join tbl_ruangan c on b.id_siswa = c.id_siswa
        left join setup_kelas d on c.id_kelas = d.id_kelas
        left join tbl_jadwal_mengajar e on d.id_kelas = e.id_kelas
        left join data_guru f on e.id_guru = f.id_guru
        where b.locked = 'no' and e.id_guru = '$id_guru' group by b.id_siswa";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function dropdowDataPelajaran()
    {
        $db = db_connect('arafah');
        $sql = "SELECT id_matapelajaran,nama_matapelajaran FROM setup_matapelajaran";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function dropdowDataGuru()
    {
        $db = db_connect('arafah');
        $sql = "SELECT id_guru,nama_guru FROM data_guru";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function cekDataSiswa($id_siswa)
    {
        $db = db_connect('arafah');
        $sql = "SELECT * FROM data_siswa where id_siswa='$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }

    public function cekDataGuru($id_guru = "")
    {
        $db = db_connect('arafah');
        $sql = "SELECT * FROM data_guru where id_guru='$id_guru'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function cekDataGuruNilai($id_matapelajaran, $id_periode)
    {
        $db = db_connect('arafah');
        $sql = "SELECT b.id_guru,b.nama_guru FROM
        tbl_jadwal_mengajar a
        left join data_guru b on a.id_guru = b.id_guru
        left join setup_kelas c on a.id_kelas = c.id_kelas
        where a.id_matapelajaran='$id_matapelajaran' and a.id_periode = '$id_periode'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function cekDataKelasNilai($id_siswa)
    {
        $db = db_connect('arafah');
        $sql = "SELECT a.id_kelas,b.nama_kelas FROM
        tbl_ruangan a
        left join setup_kelas b on a.id_kelas = b.id_kelas
        where a.id_siswa='$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function cekDetilSiswa($id_siswa)
    {
        $db = db_connect('arafah');
        $sql = "SELECT
		password,username,id_siswa,nama_siswa,nis,kelamin,alamat_siswa,tanggal_lahir,nisn,
		locked,id_periode,photo,tanggal_masuk,tempat_lahir,telpon_siswa,email,unik,nama_ortu,keterangan,image
         FROM data_siswa
        where id_siswa='$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function cekDataNilai($id_nilai)
    {
        $db = db_connect('arafah');
        (isset($id_nilai) && $id_nilai !== "") ? $where = "where id_nilai = '$id_nilai' " : $where = "";
        $db = db_connect('arafah');
        $sql = "SELECT f.nama_guru,a.id_nilai,a.id_siswa,e.nama_matapelajaran,d.id_kelas,d.nama_kelas,
        b.nama_siswa, a.id_matapelajaran, a.id_guru, `nilai_tugas`, `nilai_uts`, `nilai_uas`,
        `kunci`, a.id_periode, `H1`, `H2`, `H3`, `H4`, `H5`, `H6`, `H7`, `H8`, `K1`, `K2`,
        `K3`, `K4`, `K5`, `K6`, `K7`, `K8`,`HPKTS`,`HPKAS` FROM `tbl_nilai` a
        left join data_siswa b on a.id_siswa = b.id_siswa
        left join tbl_ruangan c on a.id_siswa = c.id_siswa
        left join setup_kelas d on c.id_kelas = d.id_kelas
        left join setup_matapelajaran e on a.id_matapelajaran = e.id_matapelajaran
        left join data_guru f on a.id_guru = f.id_guru
         $where";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function cekPerhitunganNilaiActive()
    {
        $db = db_connect('arafah');
        $db = db_connect('arafah');
        $sql = "SELECT * from tbl_perhitungan_nilai where active='yes'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function listProfileDataGuru($username)
    {
        $db = db_connect('arafah');
        $sql = "SELECT * FROM data_guru where username='$username'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function cekDataNilaiTambah($id_siswa, $id_guru, $id_matapelajaran, $id_periode)
    {
        $db = db_connect('arafah');
        $sql = "SELECT * FROM tbl_nilai where id_siswa='$id_siswa' and id_guru = '$id_guru'
        and id_matapelajaran = '$id_matapelajaran' and id_periode = '$id_periode' ";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function cekDataTabungan($id_siswa)
    {
        $db = db_connect('arafah');
        $sql = "SELECT * FROM tbl_tabungan_siswa where kode_siswa='$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function saveTabunganSiswa($id_siswa, $kode_tab, $tanggal)
    {
        $db = db_connect('arafah');
        $sql = "INSERT INTO `tbl_tabungan_siswa` ( `kode_siswa`, `kode_tab`, `tanggal`)
        VALUES ('$id_siswa', '$kode_tab', '$tanggal')";
        return $db->query($sql);
    }
    public function id_kelas($kelas)
    {
        $db = db_connect('arafah');
        $query = "select id_kelas from setup_kelas where nama_kelas = '$kelas'";
        //echo $query;
        $query = $db->query($query);
        return $query->getRowArray();
    }
    public function tarifspp($id_kelas)
    {
        $db = db_connect('arafah');
        $periode = periodeaktif();
        $periode = $periode['id_periode'];
        $query = "select tarif from tbl_tarif_spp where periode = '$periode' and id_kelas = '$id_kelas'";
        //echo $query;
        $query = $db->query($query);
        return $query->getRowArray();
    }

    // Status langkah pergantian periode untuk peringatan admin (lihat peringatanPeriode()).
    // $semester: 'ganjil' / 'genap' (kolom enum setup_periode.semester)
    public function statusPergantianPeriode($tahunAjaran, $semester, $tahunLalu)
    {
        $db = db_connect('arafah');
        $periode = $db->query("SELECT * FROM setup_periode
            WHERE tahun_ajaran = ? AND semester = ?
            ORDER BY status_aktif = 'yes' DESC, id_periode DESC LIMIT 1",
            [$tahunAjaran, $semester])->getRowArray();
        $hasil = [
            'periode'     => $periode,
            'jmlKelas'    => (int) $db->query("SELECT COUNT(*) n FROM setup_kelas")->getRow()->n,
            'jmlSiswa'    => (int) $db->query("SELECT COUNT(*) n FROM data_siswa WHERE locked = 'no'")->getRow()->n,
            'kelasTarif'  => 0,
            'siswaRuang'  => 0,
            'siswaBanding' => 0,
            'siswaSama'   => 0,
        ];
        if ($periode) {
            $hasil['kelasTarif'] = (int) $db->query("SELECT COUNT(DISTINCT id_kelas) n FROM tbl_tarif_spp WHERE periode = ?", [$periode['id_periode']])->getRow()->n;
            $hasil['siswaRuang'] = (int) $db->query("SELECT COUNT(DISTINCT r.id_siswa) n FROM tbl_ruangan_periode r
                JOIN data_siswa s ON s.id_siswa = r.id_siswa AND s.locked = 'no' WHERE r.id_periode = ?", [$periode['id_periode']])->getRow()->n;
        }
        // Naik kelas: bandingkan kelas sekarang dengan kelas di periode terakhir tahun ajaran lalu
        $lalu = $db->query("SELECT id_periode FROM setup_periode WHERE tahun_ajaran = ? ORDER BY id_periode DESC LIMIT 1", [$tahunLalu])->getRowArray();
        if ($lalu) {
            $row = $db->query("SELECT COUNT(*) n, SUM(CASE WHEN r.id_kelas = p.id_kelas THEN 1 ELSE 0 END) sama
                FROM (SELECT id_siswa, MAX(id_kelas) id_kelas FROM tbl_ruangan GROUP BY id_siswa) r
                JOIN data_siswa s ON s.id_siswa = r.id_siswa AND s.locked = 'no'
                JOIN tbl_ruangan_periode p ON p.id_siswa = r.id_siswa AND p.id_periode = ?", [$lalu['id_periode']])->getRow();
            $hasil['siswaBanding'] = (int) $row->n;
            $hasil['siswaSama'] = (int) $row->sama;
        }
        return $hasil;
    }
}
