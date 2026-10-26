<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  /* Tampilan halaman Data Siswa (daftar + form). Semua aturan di bawah .ds supaya
     tidak mengubah halaman lain yang memakai AdminLTE. */
  .ds { background: #EEF2F6; color: #0F172A; font-family: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', sans-serif; }
  .ds a { color: #0F766E; }
  .ds a:hover { color: #115E59; }
  .ds-wadah { max-width: 1080px; margin: 0 auto; padding: 28px 24px 40px; display: flex; flex-direction: column; gap: 20px; }
  .ds h1 { margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -.01em; }
  .ds h2 { margin: 0; font-size: 18px; font-weight: 700; }
  .ds-sub { margin: 0; font-size: 15px; color: #475569; }
  .ds-kepala { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 16px; }
  .ds-judul { display: flex; flex-direction: column; gap: 6px; }
  .ds-baris { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
  .ds-kartu { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; }
  .ds-pil { font-size: 13px; color: #334155; background: #FFFFFF; border: 1px solid #CBD5E1; border-radius: 999px; padding: 6px 12px; }

  /* Tombol */
  .ds-tombol { height: 44px; box-sizing: border-box; padding: 0 18px; border-radius: 8px; font: inherit; font-size: 15px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; text-decoration: none !important; border: 1px solid transparent; white-space: nowrap; }
  .ds-tombol-utama { background: #0F766E; color: #FFFFFF !important; }
  .ds-tombol-utama:hover { background: #115E59; }
  .ds-tombol-garis { background: #FFFFFF; color: #0F766E !important; border-color: #0F766E; }
  .ds-tombol-netral { background: #FFFFFF; color: #0F172A !important; border-color: #CBD5E1; font-weight: 600; }
  .ds-tombol-kecil { height: 36px; padding: 0 12px; font-size: 13px; font-weight: 600; }
  .ds :focus-visible { outline: 2px solid #0F766E; outline-offset: 2px; }

  /* Isian */
  .ds-isian { width: 100%; box-sizing: border-box; height: 44px; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0 12px; font: inherit; font-size: 15px; color: #0F172A; background: #FFFFFF; }
  textarea.ds-isian { height: auto; padding: 10px 12px; resize: vertical; }
  .ds-isian::placeholder { color: #64748B; }
  .ds-isian:focus { outline: none; border-color: #0F766E; box-shadow: 0 0 0 3px rgba(15,118,110,.18); }
  .ds-isian.ds-salah { border-color: #B42318; }
  .ds-label { font-size: 13px; font-weight: 600; margin: 0; }
  .ds-wajib { color: #B42318; }
  .ds-bantu { font-size: 12px; color: #475569; }
  .ds-galat { font-size: 12px; color: #B42318; font-weight: 600; }
  .ds-kolom { display: flex; flex-direction: column; gap: 6px; min-width: 0; }
  .ds-grid2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px 20px; }
  .ds-penuh { grid-column: 1 / -1; }
  .ds-tersembunyi { position: absolute !important; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }

  /* Daftar */
  .ds-alat { padding: 16px 20px; border-bottom: 1px solid #E2E8F0; display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
  .ds-tab { display: flex; gap: 4px; background: #F1F5F9; border-radius: 10px; padding: 4px; flex-wrap: wrap; }
  .ds-tab a { height: 36px; padding: 0 14px; border-radius: 8px; color: #475569; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 8px; text-decoration: none; }
  .ds-tab a[aria-current="page"] { background: #FFFFFF; color: #0F172A; box-shadow: 0 1px 2px rgba(15,23,42,.12); }
  .ds-hitung { font-size: 12px; font-weight: 700; color: #334155; background: #E2E8F0; border-radius: 999px; padding: 1px 8px; }
  .ds-cari { position: relative; flex: 1 1 200px; max-width: 360px; }
  .ds-cari svg { position: absolute; left: 12px; top: 13px; }
  .ds-cari .ds-isian { padding-left: 38px; }
  .ds-tabel-wadah { overflow-x: auto; }
  .ds-tabel { width: 100%; border-collapse: collapse; font-size: 14px; min-width: 860px; }
  .ds-tabel th { text-align: left; color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: .05em; padding: 12px; font-weight: 700; }
  .ds-tabel td { padding: 12px; border-top: 1px solid #E2E8F0; vertical-align: middle; }
  .ds-tabel tr > :first-child { padding-left: 20px; }
  .ds-tabel tr > :last-child { padding-right: 20px; text-align: right; white-space: nowrap; }
  .ds-tabel tbody tr:hover { background: #F8FAFC; }
  .ds-avatar { flex: 0 0 auto; width: 40px; height: 40px; border-radius: 999px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; object-fit: cover; }
  .ds-nama { font-weight: 700; color: #0F172A !important; text-decoration: none; }
  .ds-kecil { font-size: 12px; color: #475569; }
  .ds-lencana { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
  .ds-st-baru { background: #DBEAFE; color: #1E40AF; }
  .ds-st-no { background: #DCFCE7; color: #166534; }
  .ds-st-yes { background: #E2E8F0; color: #334155; }
  .ds-bar { height: 6px; border-radius: 999px; background: #E2E8F0; overflow: hidden; width: 120px; }
  .ds-bar > div { height: 6px; }
  .ds-menu { position: relative; display: inline-block; margin-left: 6px; vertical-align: middle; }
  .ds-menu > summary { list-style: none; width: 36px; height: 36px; border: 1px solid #CBD5E1; border-radius: 8px; background: #FFFFFF; cursor: pointer; display: flex; align-items: center; justify-content: center; }
  .ds-menu > summary::-webkit-details-marker { display: none; }
  .ds-menu-isi { position: absolute; right: 0; top: 42px; z-index: 20; min-width: 180px; background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; box-shadow: 0 8px 24px rgba(15,23,42,.14); padding: 6px; text-align: left; }
  .ds-menu-isi a, .ds-menu-isi button { display: block; width: 100%; text-align: left; padding: 10px 12px; border: 0; background: none; border-radius: 6px; font: inherit; font-size: 14px; color: #0F172A !important; text-decoration: none; cursor: pointer; }
  .ds-menu-isi a:hover, .ds-menu-isi button:hover { background: #F1F5F9; }
  .ds-menu-isi .ds-bahaya { color: #B42318 !important; }
  .ds-kaki { padding: 14px 20px; border-top: 1px solid #E2E8F0; display: flex; flex-wrap: wrap; gap: 12px; justify-content: space-between; align-items: center; font-size: 14px; color: #475569; }
  .ds-halaman { display: flex; gap: 6px; flex-wrap: wrap; }
  .ds-halaman a, .ds-halaman span { min-width: 36px; height: 36px; box-sizing: border-box; padding: 0 12px; border: 1px solid #E2E8F0; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; text-decoration: none; color: #0F172A; background: #FFFFFF; }
  .ds-halaman [aria-current="page"] { background: #0F766E; border-color: #0F766E; color: #FFFFFF; font-weight: 700; }
  .ds-halaman .ds-mati { background: #F8FAFC; color: #64748B; }
  .ds-kosong { padding: 40px 20px; text-align: center; display: flex; flex-direction: column; gap: 8px; align-items: center; }
  .ds-pesan { border-radius: 10px; padding: 12px 16px; font-size: 14px; font-weight: 600; }
  .ds-pesan-ok { background: #DCFCE7; color: #14532D; border: 1px solid #86EFAC; }
  .ds-pesan-salah { background: #FEF3F2; color: #912018; border: 1px solid #FDA29B; }

  /* Form */
  .ds-isi { display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-start; }
  .ds-utama { flex: 999 1 520px; min-width: 0; display: flex; flex-direction: column; gap: 20px; }
  .ds-samping { flex: 1 1 280px; min-width: 0; display: flex; flex-direction: column; gap: 20px; }
  .ds-bagian { padding: 24px; display: flex; flex-direction: column; gap: 20px; }
  .ds-bagian-kepala { display: flex; align-items: center; gap: 12px; }
  .ds-nomor { width: 28px; height: 28px; border-radius: 999px; background: #CCFBF1; color: #115E59; font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: center; }
  .ds-pilih { display: grid; gap: 8px; }
  .ds-pilih2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .ds-pilih3 { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
  .ds-pilih input { position: absolute; opacity: 0; width: 1px; height: 1px; }
  .ds-segmen { height: 44px; margin: 0; border-radius: 8px; border: 1px solid #CBD5E1; background: #FFFFFF; font-size: 15px; font-weight: 600; display: flex; align-items: center; justify-content: center; cursor: pointer; }
  .ds-pilih input:checked + .ds-segmen { background: #0F766E; border-color: #0F766E; color: #FFFFFF; }
  .ds-kartu-pilih { margin: 0; padding: 14px; border-radius: 10px; border: 2px solid #E2E8F0; background: #FFFFFF; cursor: pointer; display: flex; gap: 10px; align-items: flex-start; font-weight: 400; }
  .ds-kartu-pilih .ds-bulat { flex: 0 0 auto; width: 18px; height: 18px; margin-top: 1px; box-sizing: border-box; border-radius: 999px; border: 2px solid #94A3B8; background: #FFFFFF; }
  .ds-pilih input:checked + .ds-kartu-pilih { border-color: #0F766E; background: #F0FDFA; }
  .ds-pilih input:checked + .ds-kartu-pilih .ds-bulat { border: 5px solid #0F766E; }
  .ds-pilih input:focus-visible + label { outline: 2px solid #0F766E; outline-offset: 2px; }
  .ds-awalan { display: flex; }
  .ds-awalan span { height: 44px; box-sizing: border-box; padding: 0 12px; display: flex; align-items: center; border: 1px solid #CBD5E1; border-right: 0; border-radius: 8px 0 0 8px; background: #F1F5F9; font-size: 15px; color: #334155; }
  .ds-awalan .ds-isian { border-radius: 0 8px 8px 0; }
  .ds-unggah { cursor: pointer; border: 2px dashed #94A3B8; border-radius: 12px; background: #F8FAFC; padding: 24px 16px; display: flex; flex-direction: column; align-items: center; gap: 10px; text-align: center; margin: 0; font-weight: 400; }
  .ds-unggah:focus-within { outline: 2px solid #0F766E; outline-offset: 2px; }
  .ds-pratinjau { width: 120px; height: 120px; border-radius: 999px; background: #E2E8F0; display: flex; align-items: center; justify-content: center; overflow: hidden; }
  .ds-pratinjau img { width: 100%; height: 100%; object-fit: cover; }
  .ds-cek { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 8px; }
  .ds-cek li { display: flex; align-items: center; gap: 10px; font-size: 14px; color: #475569; }
  .ds-cek li span { width: 20px; height: 20px; border-radius: 999px; box-sizing: border-box; border: 2px solid #94A3B8; display: flex; align-items: center; justify-content: center; color: #FFFFFF; font-size: 12px; font-weight: 800; }
  .ds-cek li.ok { color: #0F172A; }
  .ds-cek li.ok span { border: 0; background: #0F766E; }
  .ds-aksi { position: sticky; bottom: 0; z-index: 10; background: #FFFFFF; border-top: 1px solid #E2E8F0; box-shadow: 0 -4px 16px rgba(15,23,42,.06); }
  .ds-aksi > div { max-width: 1080px; margin: 0 auto; padding: 14px 24px; display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: flex-end; }
  .ds-aksi .ds-batal { margin-right: auto; font-size: 14px; font-weight: 600; text-decoration: none; padding: 12px 4px; }

  @media (max-width: 640px) {
    .ds-wadah { padding: 20px 16px 32px; }
    .ds-grid2, .ds-pilih3 { grid-template-columns: minmax(0, 1fr); }
    .ds-cari { max-width: none; }
  }
</style>
