<?= view('datasiswa/_gaya') ?>
<style>
  /* Tambahan khusus halaman Tabungan Siswa (melengkapi gaya .ds dari Data Siswa) */
  .tb-kpi { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
  .tb-kpi > div { border-radius: 12px; padding: 18px 20px; display: flex; flex-direction: column; gap: 6px; background: #FFFFFF; border: 1px solid #E2E8F0; }
  .tb-kpi .tb-utama { background: #0B2545; border-color: #0B2545; color: #FFFFFF; }
  .tb-kpi .tb-judul { font-size: 13px; font-weight: 600; color: #475569; }
  .tb-kpi .tb-utama .tb-judul, .tb-kpi .tb-utama .tb-ket { color: #CBD5E1; }
  .tb-kpi .tb-angka { font-size: 22px; font-weight: 800; }
  .tb-kpi .tb-utama .tb-angka { font-size: 26px; }
  .tb-kpi .tb-ket { font-size: 12px; color: #475569; }
  .tb-masuk { color: #166534; }
  .tb-keluar { color: #9A3412; }
  .tb-bulan { width: 100%; min-width: 760px; border-collapse: separate; border-spacing: 4px; font-size: 13px; }
  .tb-bulan th { color: #475569; font-weight: 700; padding: 4px 0; text-align: center; }
  .tb-bulan th[scope="row"] { text-align: left; padding: 4px 8px; color: #0F172A; font-weight: 600; width: 150px; }
  .tb-bulan td { height: 34px; border-radius: 6px; text-align: center; font-weight: 700; }
  .tb-lunas { background: #0F766E; color: #FFFFFF; }
  .tb-kini { background: #FFFFFF; border: 2px solid #D97706; color: #92400E; }
  .tb-nanti { background: #E2E8F0; color: #334155; }
  .tb-tabel { width: 100%; min-width: 860px; border-collapse: collapse; font-size: 14px; }
  .tb-tabel th { text-align: left; color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: .05em; padding: 12px; font-weight: 700; }
  .tb-tabel td { padding: 12px; border-top: 1px solid #E2E8F0; vertical-align: middle; }
  .tb-tabel tr > :first-child { padding-left: 20px; }
  .tb-tabel tr > :last-child { padding-right: 20px; }
  .tb-tabel .tb-rp { text-align: right; white-space: nowrap; }
  .tb-tabel tr.tb-kepala td { background: #F8FAFC; font-size: 13px; font-weight: 700; color: #334155; padding-top: 8px; padding-bottom: 8px; }
  .tb-tabel tbody tr.tb-isi:hover { background: #F8FAFC; }
  .tb-jenis { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
  .tb-j-masuk { background: #DCFCE7; color: #166534; }
  .tb-j-bayar { background: #FFEDD5; color: #9A3412; }
  .tb-j-tunai { background: #FEF3C7; color: #92400E; }
  .tb-j-lain { background: #E2E8F0; color: #334155; }
  .tb-pilih-jenis { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
  .tb-pilih-jenis input { position: absolute; opacity: 0; width: 1px; height: 1px; }
  .tb-pilih-jenis label { margin: 0; padding: 12px 14px; border-radius: 10px; border: 2px solid #E2E8F0; background: #FFFFFF; cursor: pointer; display: flex; gap: 10px; align-items: flex-start; font-weight: 400; }
  .tb-pilih-jenis label .ds-bulat { flex: 0 0 auto; width: 18px; height: 18px; margin-top: 2px; box-sizing: border-box; border-radius: 999px; border: 2px solid #94A3B8; background: #FFFFFF; }
  .tb-pilih-jenis input:checked + label { border-color: var(--tb-aksen, #0F766E); background: var(--tb-latar, #F0FDFA); }
  .tb-pilih-jenis input:checked + label .ds-bulat { border: 5px solid var(--tb-aksen, #0F766E); }
  .tb-pilih-jenis input:focus-visible + label { outline: 2px solid #0F766E; outline-offset: 2px; }
  .tb-bln { display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 6px; }
  .tb-bln input { position: absolute; opacity: 0; width: 1px; height: 1px; }
  .tb-bln label { margin: 0; height: 44px; border-radius: 8px; border: 1px solid #CBD5E1; background: #FFFFFF; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer; }
  .tb-bln input:checked + label { background: #0F766E; border-color: #0F766E; color: #FFFFFF; }
  .tb-bln input:disabled + label { background: #F1F5F9; border-color: #E2E8F0; color: #64748B; cursor: not-allowed; }
  .tb-bln input:focus-visible + label { outline: 2px solid #0F766E; outline-offset: 2px; }
  .tb-rp-isian { display: flex; }
  .tb-rp-isian span { height: 44px; box-sizing: border-box; padding: 0 12px; display: flex; align-items: center; border: 1px solid #CBD5E1; border-right: 0; border-radius: 8px 0 0 8px; background: #F1F5F9; font-weight: 700; color: #334155; }
  .tb-rp-isian .ds-isian { border-radius: 0 8px 8px 0; font-size: 18px; font-weight: 700; }
  .tb-ringkas { padding: 20px; display: flex; flex-direction: column; gap: 12px; }
  .tb-ringkas .tb-brs { display: flex; justify-content: space-between; gap: 12px; font-size: 14px; }
  .tb-ringkas .tb-garis { border-top: 1px dashed #CBD5E1; padding-top: 12px; }
  .tb-ringkas .tb-brs > :last-child { white-space: nowrap; text-align: right; }
  @media (max-width: 900px) { .tb-kpi { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
  @media (max-width: 640px) { .tb-kpi, .tb-pilih-jenis { grid-template-columns: minmax(0, 1fr); } .tb-bln { grid-template-columns: repeat(6, minmax(0, 1fr)); } }
</style>
