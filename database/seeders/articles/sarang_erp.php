<?php

return [
    // ══════════════════════════════════════════════
    // KATEGORI: LOGIN ISSUES
    // ══════════════════════════════════════════════

    [
        'app_id'         => 2,
        'title'          => 'Tidak Bisa Login — Password Salah atau Lupa Password',
        'content'        => "Jika Anda mengalami kesulitan login ke Sarang ERP karena password salah atau lupa password, ikuti langkah berikut:\n\n1. Klik tombol **\"Lupa Password\"** pada halaman login.\n2. Masukkan alamat email yang terdaftar di sistem.\n3. Cek kotak masuk email Anda (termasuk folder Spam/Promosi) untuk tautan reset password.\n4. Klik tautan tersebut dan buat password baru minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, dan angka.\n5. Setelah reset berhasil, kembali ke halaman login dan masuk dengan password baru.\n\n**Penyebab Umum:**\n- Caps Lock aktif saat mengetik password.\n- Akun dinonaktifkan oleh admin karena tidak aktif selama 90 hari.\n- Browser menyimpan password lama (coba bersihkan cache browser atau gunakan mode incognito).\n\nJika masih tidak bisa login setelah reset, hubungi administrator sistem Anda.",
        'tags' => json_encode(['login', 'password', 'lupa password', 'reset', 'autentikasi']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Sesi Login Kadaluarsa atau Otomatis Logout',
        'content'        => "Sarang ERP memiliki fitur keamanan yang akan mengeluarkan pengguna secara otomatis setelah periode tidak aktif tertentu.\n\n**Waktu Sesi Default:**\n- **30 menit** tidak aktif → sesi kadaluarsa (logout otomatis).\n- **8 jam** sejak login → sesi maksimum tercapai (harus login ulang).\n\n**Cara Mengatasi:**\n\n1. Jika sering terlogout saat mengerjakan entri data panjang, gunakan fitur **\"Simpan Draft\"** sebelum jeda.\n2. Jangan membuka Sarang ERP di lebih dari 3 tab secara bersamaan karena dapat menyebabkan konflik sesi.\n3. Pastikan koneksi internet stabil — putusnya koneksi dapat menyebabkan sesi terdeteksi sebagai tidak aktif.\n4. Jika menggunakan VPN perusahaan, pastikan VPN tidak melakukan rotasi IP yang terlalu sering.\n\n**Untuk Admin:** Durasi sesi dapat disesuaikan di menu **Pengaturan > Keamanan > Durasi Sesi**.",
        'tags' => json_encode(['login', 'sesi', 'logout', 'timeout', 'keamanan']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Akun Terkunci Setelah Beberapa Kali Percobaan Login Gagal',
        'content'        => "Sistem Sarang ERP mengunci akun secara otomatis setelah **5 kali percobaan login gagal** dalam waktu 15 menit.\n\n**Apa yang Terjadi Saat Akun Terkunci:**\n- Akun terkunci selama **30 menit** secara otomatis.\n- Semua sesi aktif akan dihentikan.\n- Anda akan melihat pesan \"Akun Anda telah dikunci. Silakan coba lagi nanti.\"\n\n**Cara Mengatasi:**\n\n1. **Tunggu 30 menit** — akun akan terbuka otomatis.\n2. Jika mendesak, hubungi admin untuk membuka akun secara manual melalui menu **Pengguna > Kelola Akun > Buka Kunci**.\n3. Sebelum mencoba login kembali, pastikan Anda menggunakan password yang benar. Gunakan fitur \"Lupa Password\" jika ragu.\n\n**Pencegahan:**\n- Catat password Anda di password manager yang aman.\n- Jangan berbagi akun dengan rekan kerja — setiap pengguna harus memiliki akun sendiri.",
        'tags' => json_encode(['login', 'akun terkunci', 'keamanan', 'gagal login']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    // ══════════════════════════════════════════════
    // KATEGORI: NAVIGATION
    // ══════════════════════════════════════════════

    [
        'app_id'         => 2,
        'title'          => 'Cara Navigasi Menu Utama Sarang ERP',
        'content'        => "Sarang ERP memiliki beberapa modul utama yang dapat diakses melalui sidebar kiri. Berikut panduan navigasi dasarnya:\n\n**Modul Utama:**\n\n| Modul | Fungsi |\n|---|---|\n| **Dashboard** | Ringkasan keuangan, stok, penjualan harian |\n| **Akuntansi** | Jurnal, buku besar, laporan keuangan |\n| **Inventori** | Manajemen stok, gudang, mutasi barang |\n| **Pembelian** | Purchase order, penerimaan barang, hutang |\n| **Penjualan** | Sales order, faktur, piutang |\n| **Laporan** | Semua laporan terpadu |\n| **Pengaturan** | Kelola pengguna, hak akses, konfigurasi |\n\n**Navigasi Cepat:**\n- Gunakan **Ctrl+K** (Windows) atau **Cmd+K** (Mac) untuk membuka pencarian cepat.\n- Klik ikon **★** di samping menu untuk menandai halaman favorit.\n- Gunakan tombol **Back** pada browser untuk kembali ke halaman sebelumnya — sistem menyimpan state form Anda.\n\n**Tip:** Dashboard dapat dikustomisasi dengan widget yang relevan dengan peran Anda (tanya admin untuk penyesuaian).",
        'tags' => json_encode(['navigasi', 'menu', 'dashboard', 'modul', 'pemula']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Tidak Menemukan Menu atau Fitur Tertentu di Dashboard',
        'content'        => "Jika Anda tidak dapat menemukan menu atau fitur tertentu di Sarang ERP, kemungkinan penyebabnya adalah:\n\n**1. Hak Akses Terbatas**\nSetiap peran (role) memiliki akses yang berbeda. Staf gudang mungkin tidak melihat menu Akuntansi, sementara staf keuangan tidak melihat menu Inventori.\n\n**2. Fitur Belum Diaktifkan**\nBeberapa fitur perlu diaktifkan oleh admin melalui **Pengaturan > Modul > Aktivasi Fitur**.\n\n**3. Menu Tersembunyi**\nBeberapa menu mungkin tersembunyi di dalam sub-menu. Coba gunakan **Ctrl+K** untuk mencari nama halaman.\n\n**Cara Mengecek Hak Akses Anda:**\n1. Buka menu **Profil** (pojok kanan atas).\n2. Pilih **Hak Akses Saya**.\n3. Lihat daftar modul yang tersedia untuk peran Anda.\n\nJika Anda yakin seharusnya memiliki akses tetapi menu tidak muncul, minta admin untuk memeriksa pengaturan peran Anda di **Pengaturan > Pengguna > Kelola Peran**.",
        'tags' => json_encode(['navigasi', 'hak akses', 'role', 'menu', 'permission']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Error 404 — Halaman Tidak Ditemukan Saat Navigasi',
        'content'        => "Error 404 muncul ketika halaman yang Anda tuju tidak tersedia. Di Sarang ERP, ini biasanya terjadi karena:\n\n**Penyebab & Solusi:**\n\n1. **URL Kedaluwarsa dari Bookmark**\n   - Anda mungkin menyimpan bookmark halaman yang sudah diubah atau dihapus. Hapus bookmark lama dan navigasi ulang dari menu utama.\n\n2. **Akses Modul yang Dinonaktifkan**\n   - Admin mungkin menonaktifkan modul tertentu. Tanyakan ke admin apakah modul tersebut masih aktif.\n\n3. **Cache Browser**\n   - Cache browser mungkin menyimpan rute lama. Bersihkan cache dengan **Ctrl+Shift+Del** lalu pilih \"Cached images and files\" dan refresh.\n\n4. **Link Internal Rusak**\n   - Jika error muncul saat mengklik link di dalam aplikasi, laporkan ke tim IT dengan menyertakan screenshot halaman dan URL yang error.\n\n**404 pada Halaman Laporan:**\nBeberapa laporan di-generate secara dinamis. Jika Anda membuka laporan yang sudah sangat lama (lebih dari 90 hari), file mungkin sudah dihapus oleh sistem pembersihan otomatis.",
        'tags' => json_encode(['error', '404', 'navigasi', 'halaman tidak ditemukan', 'troubleshooting']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    // ══════════════════════════════════════════════
    // KATEGORI: DATA ENTRY
    // ══════════════════════════════════════════════

    [
        'app_id'         => 2,
        'title'          => 'Panduan Entri Jurnal Akuntansi Manual',
        'content'        => "Untuk mencatat transaksi keuangan yang tidak otomatis (misalnya penyesuaian, koreksi), gunakan fitur Jurnal Manual.\n\n**Langkah-langkah:**\n\n1. Buka menu **Akuntansi > Jurnal Umum > Buat Jurnal Baru**.\n2. Pilih **Tanggal Transaksi** (perhatikan periode akuntansi yang sedang aktif).\n3. Pilih **Tipe Jurnal:**\n   - **Jurnal Umum (JU):** Transaksi umum.\n   - **Jurnal Penyesuaian (JP):** Penyesuaian akhir periode.\n   - **Jurnal Koreksi (JK):** Koreksi kesalahan entri.\n4. Isi **Deskripsi** — wajib diisi minimal 10 karakter, jelas dan informatif (contoh: \"Penyesuaian penyusutan kendaraan bulan Juli\").\n5. Tambahkan **Detail Jurnal** (minimal 2 baris — debit dan kredit):\n   - Pilih kode akun dari dropdown.\n   - Masukkan jumlah (format: 1000000 tanpa titik/koma).\n   - Pilih D (Debit) atau K (Kredit).\n6. Pastikan **Total Debit = Total Kredit** (indikator di bagian bawah akan berwarna hijau jika seimbang).\n7. Klik **Simpan** atau **Simpan & Posting** jika ingin langsung memposting ke buku besar.\n\n**Perhatian:** Jurnal yang sudah diposting tidak dapat diedit. Gunakan Jurnal Koreksi jika ada kesalahan.",
        'tags' => json_encode(['data entry', 'akuntansi', 'jurnal', 'debit', 'kredit']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Cara Input Data Barang Baru ke Inventori',
        'content'        => "Untuk menambahkan barang baru ke database inventori Sarang ERP:\n\n**Langkah-langkah:**\n\n1. Buka **Inventori > Data Barang > Tambah Barang**.\n2. Isi field wajib:\n   - **Kode Barang:** Maksimal 20 karakter, unik. Format standar: [KATEGORI]-[TAHUN]-[URUTAN] (contoh: RM-2025-001).\n   - **Nama Barang:** Nama lengkap dan spesifik (contoh: \"Besi Hollow 40×60 Galvanis\").\n   - **Kategori:** Pilih dari dropdown. Jika belum ada, admin harus menambahkannya di Pengaturan.\n   - **Satuan:** Pcs, Kg, Meter, Liter, Box, dll.\n3. Isi field opsional yang disarankan:\n   - **Harga Beli Rata-rata:** Untuk perhitungan HPP.\n   - **Harga Jual Default:** Harga yang muncul otomatis di faktur penjualan.\n   - **Stok Minimum:** Sistem akan memberi notifikasi jika stok di bawah angka ini.\n   - **Lokasi Gudang:** Jika multi-gudang, pilih gudang default.\n4. Klik **Simpan**.\n\n**Catatan:** Barang baru akan memiliki stok awal 0. Gunakan menu **Inventori > Penyesuaian Stok** untuk menambahkan stok awal setelah barang dibuat.",
        'tags' => json_encode(['data entry', 'inventori', 'barang', 'stok', 'gudang']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Membuat Purchase Order (PO) untuk Pembelian Barang',
        'content'        => "Purchase Order (PO) adalah dokumen resmi pemesanan barang ke supplier. Berikut cara membuatnya di Sarang ERP:\n\n**Langkah-langkah:**\n\n1. Buka **Pembelian > Purchase Order > Buat PO Baru**.\n2. Pilih **Supplier** dari dropdown. Pastikan data supplier sudah lengkap (alamat, NPWP, kontak).\n3. Pilih **Tanggal PO** dan **Tanggal Kirim yang Diharapkan**.\n4. Isi **Nomor Referensi** (opsional) — bisa nomor quotation atau permintaan internal.\n5. Tambahkan **Detail Barang:**\n   - Klik **Tambah Baris**.\n   - Pilih barang dari database (ketik nama/kode untuk mencari).\n   - Masukkan **Jumlah** dan **Harga per Satuan**.\n   - Sistem otomatis menghitung subtotal.\n6. Tambahkan **PPN** jika berlaku (centang \"Termasuk PPN 11%\").\n7. Isi **Catatan** (opsional) — misalnya instruksi pengiriman khusus.\n8. Klik **Simpan sebagai Draft** untuk review, atau **Kirim & Konfirmasi** untuk finalisasi.\n\n**Status PO:**\n- **Draft:** Belum dikirim ke supplier, masih bisa diedit.\n- **Terkirim:** Sudah dikirim ke supplier, menunggu penerimaan.\n- **Selesai:** Semua barang sudah diterima.\n- **Dibatalkan:** PO dibatalkan.",
        'tags' => json_encode(['data entry', 'pembelian', 'purchase order', 'PO', 'supplier']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Membuat Sales Order (SO) dan Faktur Penjualan',
        'content'        => "Untuk mencatat pesanan penjualan dan menerbitkan faktur di Sarang ERP:\n\n**A. Membuat Sales Order (SO):**\n\n1. Buka **Penjualan > Sales Order > Buat SO Baru**.\n2. Pilih **Pelanggan** dari database. Jika pelanggan baru, klik \"Tambah Pelanggan\" dan isi data lengkap.\n3. Pilih **Tanggal Pesanan** dan **Tanggal Jatuh Tempo**.\n4. Tambahkan **Detail Barang:**\n   - Cari barang, masukkan jumlah, harga akan terisi otomatis dari harga jual default.\n   - Harga bisa diubah manual per transaksi (jika ada diskon khusus).\n5. **Diskon:** Pilih diskon per item (%) atau diskon total faktur.\n6. Pilih **Metode Pembayaran:** Tunai, Transfer, atau Kredit.\n7. Klik **Simpan** — status awal: \"Draft\".\n\n**B. Konversi SO ke Faktur:**\n\n1. Buka SO yang sudah dikonfirmasi.\n2. Klik **Buat Faktur**.\n3. Sistem akan membuat faktur dengan data dari SO.\n4. Periksa kembali data, lalu klik **Kirim Faktur**.\n5. Faktur akan memiliki nomor otomatis (format: INV/[TAHUN]/[BULAN]/[URUTAN]).\n\n**Catatan:** Untuk pembayaran kredit, faktur akan tercatat sebagai piutang dan muncul di laporan aging piutang.",
        'tags' => json_encode(['data entry', 'penjualan', 'sales order', 'faktur', 'invoice']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Mencatat Penerimaan Barang dari Supplier (Goods Receipt)',
        'content'        => "Setelah supplier mengirim barang sesuai PO, Anda harus mencatat penerimaan barang (Goods Receipt) di Sarang ERP.\n\n**Langkah-langkah:**\n\n1. Buka **Pembelian > Penerimaan Barang > Buat Penerimaan**.\n2. Pilih **Nomor PO** yang terkait — barang yang dipesan di PO akan muncul otomatis.\n3. Untuk setiap item, masukkan **Jumlah Diterima:**\n   - Jika sesuai pesanan, biarkan angka default (sama dengan jumlah PO).\n   - Jika kurang (partial delivery), masukkan jumlah aktual yang diterima.\n   - Jika lebih, masukkan jumlah aktual dan catat alasan di kolom catatan.\n4. Isi **Nomor Surat Jalan** dari supplier.\n5. Isi **Kondisi Barang:** Baik / Rusak / Kurang. Jika ada yang rusak, sebutkan di catatan.\n6. Pilih **Lokasi Gudang** tempat barang akan disimpan.\n7. Klik **Simpan & Konfirmasi**.\n\n**Yang Terjadi Setelah Konfirmasi:**\n- Stok barang di gudang bertambah otomatis.\n- Status PO diperbarui (selesai jika semua diterima).\n- Hutang ke supplier dicatat (jika PO bersifat kredit).\n\n**Peringatan:** Penerimaan yang sudah dikonfirmasi tidak bisa diedit. Gunakan Retur Pembelian jika ada kesalahan.",
        'tags' => json_encode(['data entry', 'pembelian', 'penerimaan', 'goods receipt', 'gudang']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    // ══════════════════════════════════════════════
    // KATEGORI: ERROR MESSAGES
    // ══════════════════════════════════════════════

    [
        'app_id'         => 2,
        'title'          => 'Error: "Total Debit dan Kredit Tidak Seimbang" Saat Entri Jurnal',
        'content'        => "Pesan error ini muncul saat Anda mencoba menyimpan jurnal yang total nilai debitnya tidak sama dengan total nilai kreditnya.\n\n**Prinsip Dasar Akuntansi:** Setiap transaksi harus seimbang — total debit = total kredit.\n\n**Cara Mengatasi:**\n\n1. Periksa kembali setiap baris detail jurnal.\n2. Lihat indikator **Total Debit** dan **Total Kredit** di bagian bawah form.\n3. Jika selisihnya kecil, kemungkinan ada kesalahan ketik (misalnya 100000 vs 1000000).\n4. Gunakan kalkulator internal (ikon kalkulator di pojok form) untuk membantu perhitungan.\n\n**Penyebab Umum Ketidakseimbangan:**\n- Salah satu baris tidak dipilih D atau K.\n- Nilai desimal yang tidak konsisten (gunakan 2 angka di belakang koma).\n- Copy-paste baris tanpa mengubah jumlahnya.\n\n**Contoh Jurnal Seimbang:**\n```\nAkun Kas (D): Rp 500.000\nAkun Pendapatan (K): Rp 500.000\nTotal Debit: Rp 500.000 = Total Kredit: Rp 500.000 ✓\n```\n\nJika Anda yakin jurnal sudah benar tetapi error tetap muncul, simpan sebagai draft dan hubungi admin.",
        'tags' => json_encode(['error', 'akuntansi', 'jurnal', 'debit kredit', 'tidak seimbang']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Error: "Stok Tidak Mencukupi" Saat Membuat Faktur Penjualan',
        'content'        => "Pesan error \"Stok Tidak Mencukupi\" muncul saat jumlah barang yang dijual melebihi stok yang tersedia di gudang.\n\n**Penyebab:**\n- Barang benar-benar habis atau stoknya kurang.\n- Barang ada di gudang lain yang tidak dipilih (jika multi-gudang).\n- Ada transaksi lain yang belum diproses yang menggunakan stok yang sama (booking sistem).\n\n**Cara Mengatasi:**\n\n1. **Cek Stok Aktual:** Buka **Inventori > Stok Barang**, cari barang tersebut, lihat stok per gudang.\n2. **Pindah Gudang:** Jika barang ada di gudang lain, lakukan transfer antar gudang terlebih dahulu.\n3. **Gunakan Stok Negatif (jika diizinkan):** Beberapa perusahaan mengizinkan penjualan dengan stok negatif (backorder). Admin bisa mengaktifkan ini di **Pengaturan > Inventori > Izinkan Stok Negatif**.\n4. **Pesan ke Supplier:** Jika stok memang habis, buat PO ke supplier dan informasikan ke pelanggan tentang estimasi ketersediaan.\n\n**Pencegahan:**\n- Atur **Stok Minimum** untuk setiap barang agar sistem memberi notifikasi sebelum stok habis.\n- Gunakan laporan **Stok Hampir Habis** di dashboard untuk monitoring rutin.",
        'tags' => json_encode(['error', 'inventori', 'stok', 'penjualan', 'stok habis']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Error 500 — Internal Server Error Saat Memproses Transaksi',
        'content'        => "Error 500 (Internal Server Error) adalah kesalahan dari sisi server yang dapat disebabkan oleh berbagai faktor.\n\n**Yang Harus Anda Lakukan:**\n\n1. **Jangan panik** — data Anda biasanya aman.\n2. **Refresh halaman** (F5). Jika error terjadi saat submit form, data draft mungkin sudah tersimpan.\n3. **Coba lagi dalam 2-3 menit** — server mungkin sedang sibuk memproses batch job.\n4. **Cek koneksi internet** Anda.\n5. **Gunakan browser berbeda** atau mode incognito untuk mengesampingkan masalah cache/cookie.\n\n**Penyebab Umum di Sarang ERP:**\n- **Data terlalu besar:** Upload file lampiran lebih dari 10MB.\n- **Periode akuntansi terkunci:** Mencoba posting jurnal ke periode yang sudah ditutup.\n- **Referensi data yang dihapus:** Misalnya barang yang sudah dihapus tetapi masih direferensi di transaksi lama.\n- **Server maintenance:** Cek apakah ada pemberitahuan maintenance dari tim IT.\n\n**Jika Error Berlanjut:**\n- Catat waktu kejadian, halaman yang diakses, dan screenshot error.\n- Laporkan ke helpdesk atau kirim email ke support@sarang-erp.com dengan detail tersebut.",
        'tags' => json_encode(['error', '500', 'server error', 'troubleshooting', 'maintenance']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Error: "Data Tidak Dapat Dihapus Karena Masih Digunakan"',
        'content'        => "Pesan ini muncul ketika Anda mencoba menghapus data master yang masih terhubung dengan transaksi.\n\n**Penyebab:** Sarang ERP menjaga integritas referensial — data yang sudah digunakan dalam transaksi tidak bisa dihapus begitu saja.\n\n**Situasi Umum:**\n\n| Data yang Ingin Dihapus | Data yang Menghalangi | Solusi |\n|---|---|---|\n| Barang | Transaksi penjualan/pembelian | Nonaktifkan barang (set status \"Tidak Aktif\") |\n| Pelanggan | Faktur atau pembayaran | Nonaktifkan pelanggan |\n| Supplier | PO atau penerimaan | Nonaktifkan supplier |\n| Akun | Jurnal yang sudah diposting | Nonaktifkan akun |\n| Kategori | Barang dalam kategori | Pindahkan barang ke kategori lain dahulu |\n\n**Cara Menonaktifkan Data (Alternatif Penghapusan):**\n\n1. Buka data yang ingin dihapus (Barang, Pelanggan, Supplier, dll).\n2. Klik **Edit**.\n3. Ubah **Status** menjadi **\"Tidak Aktif\"**.\n4. Simpan.\n\nData yang dinonaktifkan:\n- Tidak muncul di dropdown/pencarian form baru.\n- Tidak bisa dipilih untuk transaksi baru.\n- Tetap muncul di laporan historis (ini penting untuk audit).\n\n**Untuk Admin:** Jika benar-benar harus menghapus, lakukan soft delete melalui database dengan tetap menjaga integritas data historis.",
        'tags' => json_encode(['error', 'hapus data', 'integritas data', 'referensi', 'nonaktif']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    // ══════════════════════════════════════════════
    // KATEGORI: REPORTS
    // ══════════════════════════════════════════════

    [
        'app_id'         => 2,
        'title'          => 'Cara Membuka Laporan Laba Rugi (Income Statement)',
        'content'        => "Laporan Laba Rugi menampilkan pendapatan dan beban dalam periode tertentu untuk menghitung laba/rugi bersih.\n\n**Cara Membuka:**\n\n1. Buka **Laporan > Keuangan > Laba Rugi**.\n2. Pilih **Periode:**\n   - Bulanan: Pilih bulan dan tahun.\n   - Triwulanan: Q1 (Jan-Mar), Q2 (Apr-Jun), Q3 (Jul-Sep), Q4 (Okt-Des).\n   - Tahunan: Pilih tahun.\n   - Kustom: Pilih rentang tanggal manual.\n3. Pilih **Metode:**\n   - **Single Step:** Pendapatan - Beban langsung.\n   - **Multi Step:** Menampilkan laba kotor, laba operasional, laba bersih (lebih detail).\n4. Klik **Tampilkan**.\n\n**Membaca Laporan:**\n```\nPENDAPATAN\n- Pendapatan Penjualan           xxx\n- Pendapatan Lain-lain           xxx\nTOTAL PENDAPATAN                 xxx\n\nBEBAN POKOK PENJUALAN (HPP)\n- HPP                            xxx\nLABA KOTOR                       xxx\n\nBEBAN OPERASIONAL\n- Beban Gaji                     xxx\n- Beban Sewa                     xxx\n- Beban Listrik & Air            xxx\nLABA BERSIH                      xxx\n```\n\n**Export:** Klik **Download** untuk mengunduh dalam format PDF atau Excel.\n\n**Catatan:** Pastikan semua jurnal sudah diposting sebelum menjalankan laporan agar data akurat.",
        'tags' => json_encode(['laporan', 'keuangan', 'laba rugi', 'income statement', 'akuntansi']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Laporan Stok Barang — Monitoring Persediaan Real-Time',
        'content'        => "Laporan Stok Barang adalah tools utama untuk memonitor ketersediaan barang di gudang.\n\n**Cara Mengakses:**\n1. Buka **Laporan > Inventori > Stok Barang**.\n2. Gunakan filter yang tersedia:\n   - **Kategori:** Filter per kategori barang.\n   - **Gudang:** Jika multi-gudang, pilih gudang spesifik atau \"Semua\".\n   - **Status:** Semua, Aktif, Tidak Aktif.\n   - **Stok:** Semua, Tersedia (stok > 0), Hampir Habis (stok ≤ minimum), Habis (stok = 0).\n3. Klik **Tampilkan**.\n\n**Kolom Laporan:**\n\n| Kolom | Keterangan |\n|---|---|\n| Kode | Kode unik barang |\n| Nama Barang | Nama lengkap |\n| Kategori | Kategori barang |\n| Gudang | Lokasi penyimpanan |\n| Stok Tersedia | Jumlah fisik di gudang saat ini |\n| Stok Minimum | Batas minimum (muncul notifikasi jika di bawah) |\n| Satuan | Pcs, Kg, Meter, dll |\n| Harga Rata-rata | Harga beli rata-rata (untuk HPP) |\n| Nilai Stok | Stok × Harga Rata-rata |\n\n**Fitur Tambahan:**\n- **Klik nama barang** untuk melihat kartu stok (history mutasi).\n- **Export Excel** untuk analisis lebih lanjut.\n- **Print Barcode** untuk barang tertentu.\n\n**Jadwal Monitoring:** Disarankan menjalankan laporan ini minimal seminggu sekali untuk memastikan tidak ada barang yang hampir habis.",
        'tags' => json_encode(['laporan', 'inventori', 'stok', 'gudang', 'persediaan']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Laporan Piutang Pelanggan (Aging Receivables)',
        'content'        => "Laporan Aging Piutang membantu Anda melacak pembayaran pelanggan yang belum lunas berdasarkan umur faktur.\n\n**Cara Membuka:**\n1. Buka **Laporan > Keuangan > Aging Piutang**.\n2. Pilih **Per Tanggal** (biasanya akhir bulan).\n3. Pilih **Pelanggan** (\"Semua\" atau spesifik).\n4. Klik **Tampilkan**.\n\n**Struktur Laporan:**\n\n| Pelanggan | Total | Belum Jatuh Tempo | 1-30 Hari | 31-60 Hari | 61-90 Hari | >90 Hari |\n|---|---|---|---|---|---|---|\n| PT. ABC | Rp 50.000.000 | 30.000.000 | 20.000.000 | 0 | 0 | 0 |\n| CV. XYZ | Rp 15.000.000 | 0 | 5.000.000 | 5.000.000 | 5.000.000 | 0 |\n\n**Warna Indikator:**\n- 🟢 **Hijau:** Belum jatuh tempo (aman).\n- 🟡 **Kuning:** Jatuh tempo 1-30 hari (perlu follow-up ringan).\n- 🟠 **Orange:** Jatuh tempo 31-60 hari (follow-up intensif).\n- 🔴 **Merah:** Jatuh tempo >60 hari (risiko kredit tinggi).\n\n**Tindakan yang Disarankan:**\n- Untuk piutang kuning: Kirim pengingat via WhatsApp/email.\n- Untuk piutang orange: Telepon pelanggan.\n- Untuk piutang merah: Pertimbangkan tindakan hukum atau penghapusan piutang (dengan persetujuan manajemen).\n\n**Export:** Download PDF untuk laporan ke manajemen, atau Excel untuk analisis lanjutan.",
        'tags' => json_encode(['laporan', 'keuangan', 'piutang', 'aging', 'pelanggan']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    // ══════════════════════════════════════════════
    // KATEGORI: SETTINGS
    // ══════════════════════════════════════════════

    [
        'app_id'         => 2,
        'title'          => 'Mengatur Periode Akuntansi dan Tutup Buku',
        'content'        => "Periode akuntansi adalah rentang waktu di mana transaksi keuangan dicatat dan dilaporkan. Menutup periode mencegah perubahan data setelah laporan difinalisasi.\n\n**Membuka Periode Baru:**\n\n1. Buka **Pengaturan > Akuntansi > Periode Akuntansi**.\n2. Klik **Buka Periode Baru**.\n3. Isi:\n   - **Tahun:** Tahun fiskal.\n   - **Bulan:** Bulan periode (Januari s.d. Desember).\n   - **Tanggal Mulai & Selesai:** Otomatis terisi (bisa disesuaikan jika tahun fiskal tidak Jan-Des).\n4. Klik **Simpan**.\n\n**Menutup Periode (Tutup Buku):**\n\n1. Pastikan:\n   - Semua jurnal sudah diposting.\n   - Rekonsiliasi bank selesai.\n   - Laporan keuangan sudah direview.\n2. Buka **Pengaturan > Akuntansi > Periode Akuntansi**.\n3. Pilih periode yang akan ditutup.\n4. Klik **Tutup Periode**.\n5. Konfirmasi — sistem akan memindahkan saldo laba/rugi ke laba ditahan.\n\n**PERHATIAN — Tutup buku bersifat permanen:**\n- Transaksi baru tidak bisa diposting ke periode yang sudah ditutup.\n- Jurnal yang sudah diposting tidak bisa diedit.\n- Hanya user dengan role \"Admin\" atau \"Manajer Keuangan\" yang bisa menutup periode.\n\n**Jika Ada Kesalahan Setelah Tutup Buku:**\n- Gunakan Jurnal Koreksi di periode aktif berikutnya.\n- Cantumkan penjelasan bahwa koreksi terkait periode sebelumnya.",
        'tags' => json_encode(['pengaturan', 'akuntansi', 'tutup buku', 'periode', 'fiskal']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Menambah Pengguna Baru dan Mengatur Hak Akses (Role)',
        'content'        => "Hanya **Admin** yang dapat menambah pengguna baru dan mengatur hak akses di Sarang ERP.\n\n**Menambah Pengguna Baru:**\n\n1. Buka **Pengaturan > Pengguna > Tambah Pengguna**.\n2. Isi data wajib:\n   - **Nama Lengkap:** Nama karyawan.\n   - **Email:** Email perusahaan (digunakan untuk login).\n   - **Password:** Minimal 8 karakter (pengguna akan diminta ganti saat login pertama).\n   - **Role/Peran:** Pilih dari daftar yang tersedia.\n3. Klik **Simpan** — pengguna akan menerima email verifikasi.\n\n**Role Bawaan Sarang ERP:**\n\n| Role | Hak Akses Utama |\n|---|---|\n| **Super Admin** | Semua akses, termasuk pengaturan sistem |\n| **Admin** | Semua modul kecuali pengaturan sistem kritis |\n| **Manajer Keuangan** | Akuntansi, laporan keuangan, tutup buku |\n| **Staf Keuangan** | Entri jurnal, pembayaran, piutang/hutang |\n| **Manajer Gudang** | Inventori, penerimaan, transfer, stok opname |\n| **Staf Gudang** | Entri stok, penerimaan, pengiriman |\n| **Manajer Penjualan** | SO, faktur, laporan penjualan |\n| **Staf Penjualan** | Entri SO dan faktur (tanpa akses laporan) |\n| **Purchasing** | PO, penerimaan, negosiasi harga |\n| **Viewer** | Hanya lihat (read-only) semua laporan |\n\n**Mengedit Hak Akses:**\n1. Buka **Pengaturan > Pengguna > Kelola Peran**.\n2. Pilih role yang akan diedit.\n3. Centang/hilangkan centang pada modul yang diizinkan.\n4. Simpan.\n\n**Peringatan:** Jangan memberikan akses Super Admin ke pengguna biasa. Setiap perubahan role akan langsung berlaku setelah disimpan.",
        'tags' => json_encode(['pengaturan', 'pengguna', 'role', 'hak akses', 'admin']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Mengatur Pajak PPN 11% dan PPh pada Transaksi',
        'content'        => "Sarang ERP mendukung perhitungan pajak otomatis pada transaksi pembelian dan penjualan. Berikut cara mengaturnya:\n\n**Mengaktifkan PPN (Pajak Pertambahan Nilai) 11%:**\n\n1. Buka **Pengaturan > Pajak > Konfigurasi Pajak**.\n2. Klik **Tambah Pajak**.\n3. Isi:\n   - **Nama Pajak:** \"PPN 11%\"\n   - **Persentase:** 11\n   - **Tipe:** PPN Masukan (pembelian) atau PPN Keluaran (penjualan).\n   - **Akun Pajak:** Pilih akun yang sesuai (biasanya \"PPN Masukan\" atau \"PPN Keluaran\" di chart of accounts).\n4. Aktifkan **\"Terapkan Otomatis\"** agar setiap transaksi otomatis menghitung PPN.\n5. Klik **Simpan**.\n\n**Mengaktifkan PPh (Pajak Penghasilan) Pasal 23:**\n\n1. Di menu yang sama, klik **Tambah Pajak**.\n2. Isi:\n   - **Nama Pajak:** \"PPh 23\"\n   - **Persentase:** 2 (untuk jasa) atau 15 (untuk dividen/bunga — konsultasikan dengan akuntan).\n   - **Tipe:** Pemotongan.\n3. Simpan.\n\n**Cara Penggunaan di Transaksi:**\n- Saat membuat PO atau faktur, centang **\"Termasuk PPN\"** — sistem otomatis menambah 11%.\n- Untuk supplier yang tidak PKP (non-PKP), kosongkan centang PPN.\n- Pajak akan muncul di laporan PPN dan bisa diekspor untuk pelaporan SPT.\n\n**Peringatan:** Tarif pajak dapat berubah sesuai regulasi pemerintah. Selalu konsultasikan dengan konsultan pajak Anda dan perbarui pengaturan jika ada perubahan tarif.",
        'tags' => json_encode(['pengaturan', 'pajak', 'PPN', 'PPh', 'konfigurasi']),
        'source_manual'  => true,
        'is_published'   => true,
    ],

    [
        'app_id'         => 2,
        'title'          => 'Backup Data dan Pengaturan Ekspor Database',
        'content'        => "Melakukan backup data secara rutin sangat penting untuk mencegah kehilangan data. Sarang ERP menyediakan fitur backup otomatis dan manual.\n\n**Backup Otomatis:**\n\n1. Buka **Pengaturan > Sistem > Backup**.\n2. Aktifkan **Backup Otomatis**.\n3. Atur jadwal:\n   - **Harian:** Jam 02:00 dini hari.\n   - **Mingguan:** Setiap hari Minggu jam 02:00.\n4. Pilih **Lokasi Penyimpanan:**\n   - Server lokal.\n   - Google Drive (perlu otorisasi).\n   - FTP/SFTP eksternal.\n5. Pilih **Retensi:** Jumlah backup yang disimpan (default: 7 backup terakhir).\n\n**Backup Manual:**\n\n1. Buka **Pengaturan > Sistem > Backup**.\n2. Klik **Buat Backup Sekarang**.\n3. Pilih data yang akan dibackup:\n   - Database penuh (transaksi + master data).\n   - Lampiran/file upload.\n   - Konfigurasi sistem.\n4. Klik **Mulai Backup**.\n5. Setelah selesai, klik **Download** untuk menyimpan file backup ke komputer lokal.\n\n**Ekspor Data untuk Pelaporan Eksternal:**\n\n1. Buka **Pengaturan > Sistem > Ekspor Data**.\n2. Pilih modul data yang ingin diekspor (Transaksi, Master Barang, Pelanggan, dll).\n3. Pilih format: Excel (.xlsx) atau CSV.\n4. Pilih rentang tanggal jika diperlukan.\n5. Klik **Ekspor** dan download file.\n\n**Rekomendasi:**\n- Backup harian untuk database.\n- Backup mingguan untuk lampiran.\n- Simpan minimal 1 backup di lokasi berbeda dari server utama (cloud/drive eksternal).",
        'tags' => json_encode(['pengaturan', 'backup', 'ekspor', 'database', 'keamanan']),
        'source_manual'  => true,
        'is_published'   => true,
    ],
];
