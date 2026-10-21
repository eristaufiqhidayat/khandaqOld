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
}
