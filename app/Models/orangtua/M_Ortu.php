<?php

namespace App\Models\orangtua;

use CodeIgniter\Model;

class M_Ortu extends Model
{
    protected $DBGroup      = 'arafah';
    protected $table         = 'data_orangtua';
    protected $primaryKey     = 'id_orangtua';
    protected $allowedFields = [
        'id_orangtua', 'nama_orangtua', 'kelamin', 'status_keluarga', 'pekerjaan',
        'alamat_orangtua', 'telpon_orangtua', 'email', 'username', 'password', 'photo'
    ];
    // Listing sub query
    public function index()
    {
        $db = db_connect('arafah');
        $sql = "SELECT a.*,c.nama_siswa,c.id_siswa FROM `data_orangtua` a 
        left join tbl_akses_ortu b on a.id_orangtua = b.id_orangtua
        left join data_siswa c on c.id_siswa = b.id_siswa
        ";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function rubah($id_orangtua, $data)
    {
        $this->where('id_orangtua', $id_orangtua);
        return $this->update($id_orangtua, $data);
    }
    public function tambah($data)
    {
        return $this->insert($data);
    }
    public function hapus($id_orangtua, $data)
    {
        $this->where('id_orangtua', $id_orangtua);
        return $this->delete($data);
    }
    public function detilOrtu($id_ortu)
    {
        $db = db_connect('arafah');
        $sql = "SELECT a.*,c.nama_siswa,c.id_siswa FROM `data_orangtua` a 
        left join tbl_akses_ortu b on a.id_orangtua = b.id_orangtua
        left join data_siswa c on c.id_siswa = b.id_siswa
        where a.username = '$id_ortu'
        ";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function cekusernameOrtu($id_ortu)
    {
        $db = db_connect();
        $sql = "SELECT * FROM `users` a 
        WHERE a.username = '$id_ortu' and ortu ='1'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function listing($id_ortu)
    {
        $db = db_connect('arafah');
        $sql = "SELECT * FROM `data_orangtua` a 
        left join tbl_akses_ortu b on a.id_orangtua = b.id_orangtua
        left join data_siswa c on c.id_siswa = b.id_siswa
        WHERE a.username = '$id_ortu'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
    public function detailTransaksi($id_siswa)
    {
        $db = db_connect('arafah');
        $sql = "SELECT 
				tbl_tabungan_siswa.kode_siswa,
				tbl_tabungan_transaksi.notransaksi,
				tbl_tabungan_transaksi.kode_tab_trans,
				tbl_tabungan_transaksi.kodetransaksi,
				date(tbl_tabungan_transaksi.tanggal) as tanggal,
                IF(tbl_tabungan_transaksi.kodetransaksi = 'TDSPP',tbl_tabungan_transaksi.rp+100000+50000,tbl_tabungan_transaksi.rp) AS rp,

				tbl_tabungan_transaksi.keterangan_trans,
				tbl_tabungan_transaksi.spp,
				tbl_tabungan_transaksi.buktitransfer,
				tbl_tabungan_transaksi.tahunajaran,
				tbl_kode_transaksi.kode_tran
				FROM tbl_tabungan_transaksi 
			    left join tbl_tabungan_siswa on tbl_tabungan_transaksi.kode_tab_trans = tbl_tabungan_siswa.kode_tab
				left join tbl_kode_transaksi on tbl_tabungan_transaksi.kodetransaksi = tbl_kode_transaksi.kode
				where tbl_tabungan_siswa.kode_siswa = '$id_siswa' and tbl_tabungan_transaksi.kodetransaksi not in ('TDLDR','TDKES')
				order by tanggal,tbl_tabungan_transaksi.tanggal,tbl_tabungan_transaksi.notransaksi asc 
				";
        //echo $sql;
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function nilai_akhir($id_siswa)
    {
        $db = db_connect('arafah');
        $sql = "SELECT id_nilai,image,keterangan FROM `tbl_nilai_akhir` WHERE id_siswa = '$id_siswa'";
        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function aksesSiswaDo($id_siswa, $id_orangtua)
    {
        $db = db_connect('arafah');
        $query = "Update tbl_akses_ortu set
                  `id_siswa` = '$id_siswa'
                  where id_orangtua = '$id_orangtua'
                   ";
        $query = $db->query($query);
    }
    public function aksesSiswaDoNew($id_siswa, $id_orangtua)
    {
        $db = db_connect('arafah');
        $query = "INSERT INTO `tbl_akses_ortu` (`id_akses`, `id_orangtua`, `id_siswa`) VALUES (NULL, '$id_orangtua', '$id_siswa')";
        //echo $query;
        $query = $db->query($query);
    }
    public function cekAkses($id_orangtua)
    {
        $db = db_connect('arafah');
        $sql = "SELECT * FROM tbl_akses_ortu where id_orangtua = '$id_orangtua'";
        $query = $db->query($sql);
        return $query->getRowArray();
    }
}
