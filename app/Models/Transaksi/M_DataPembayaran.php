<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class M_DataPembayaran extends Model
{

    public function listingCrostab($id_siswa, $tanggalAwal, $tanggalAkhir)
    {
        $db = db_connect('arafah');
        $sql = "select a.nama_siswa,
        SUM( IF( MONTH(b.tanggal) =7, b.rp, 0 ) ) AS '1',
        SUM( IF( MONTH(b.tanggal) =8, b.rp, 0 ) ) AS '2',
        SUM( IF( MONTH(b.tanggal) =9, b.rp, 0 ) ) AS '3',
        SUM( IF( MONTH(b.tanggal) =10, b.rp, 0 ) ) AS '4',
        SUM( IF( MONTH(b.tanggal) =11, b.rp, 0 ) ) AS '5',
        SUM( IF( MONTH(b.tanggal) =12, b.rp, 0 ) ) AS '6',
        SUM( IF( MONTH(b.tanggal) =1, b.rp, 0 ) ) AS '7',
        SUM( IF( MONTH(b.tanggal) =2, b.rp, 0 ) ) AS '8',
        SUM( IF( MONTH(b.tanggal) =3, b.rp, 0 ) ) AS '9',
        SUM( IF( MONTH(b.tanggal) =4, b.rp, 0 ) ) AS '10',
        SUM( IF( MONTH(b.tanggal) =5, b.rp, 0 ) ) AS '11',
        SUM( IF( MONTH(b.tanggal) =6, b.rp, 0 ) ) AS '12'
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
        where b.tanggal between '$tanggalAwal' and '$tanggalAkhir' and b.kodetransaksi = 'TDSPP'
        and a.id_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function sumsppPeriode($id_siswa, $tanggalAwal, $tanggalAkhir)
    {
        $db = db_connect('arafah');
        $sql = "select a.id_siswa,sum(b.rp) as spp
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
        left join setup_periode g on e.periode = g.id_periode
        where b.tanggal between '$tanggalAwal' and '$tanggalAkhir' and b.kodetransaksi = 'TDSPP' and
        g.status_aktif = 'yes'
        and a.id_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumldrPeriode($id_siswa, $tanggalAwal, $tanggalAkhir)
    {
        $db = db_connect('arafah');
        $sql = "select a.id_siswa,sum(b.rp) as ldr
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
        left join setup_periode g on e.periode = g.id_periode
        where b.tanggal between '$tanggalAwal' and '$tanggalAkhir' and b.kodetransaksi = 'TDLDR' and
        g.status_aktif = 'yes'
        and a.id_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function sumkesPeriode($id_siswa, $tanggalAwal, $tanggalAkhir)
    {
        $db = db_connect('arafah');
        $sql = "select a.id_siswa,sum(b.rp) as kes
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
        left join setup_periode g on e.periode = g.id_periode
        where b.tanggal between '$tanggalAwal' and '$tanggalAkhir' and b.kodetransaksi = 'TDKES' and
        g.status_aktif = 'yes'
        and a.id_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
}
