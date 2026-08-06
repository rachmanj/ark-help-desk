<?php

return [
    // ========================
    // LOGIN ISSUES (3 articles)
    // ========================

    [
        'app_id' => 1,
        'title' => 'Lupa Password Akun MineOps — Cara Reset Mandiri',
        'content' => "Jika Anda lupa password untuk login ke MineOps, Anda dapat melakukan reset password secara mandiri melalui halaman login tanpa perlu menghubungi admin.\n\n"
            . "Langkah-langkah reset password:\n\n"
            . "1. Buka halaman login MineOps di browser Anda.\n"
            . "2. Klik tautan 'Lupa Password?' yang terletak di bawah tombol Login.\n"
            . "3. Masukkan alamat email yang terdaftar pada akun MineOps Anda, lalu klik tombol 'Kirim Link Reset'.\n"
            . "4. Periksa kotak masuk email Anda (termasuk folder spam/promosi) untuk email berisi tautan reset password.\n"
            . "5. Klik tautan tersebut dan masukkan password baru. Pastikan password minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, dan angka.\n"
            . "6. Setelah berhasil mengganti password, kembali ke halaman login dan gunakan password baru Anda.\n\n"
            . "Jika email reset tidak kunjung diterima dalam waktu 10 menit, periksa kembali alamat email yang dimasukkan atau hubungi admin melalui menu Bantuan. Reset link berlaku selama 30 menit sejak dikirimkan.",
        'tags' => json_encode(['login', 'password', 'reset', 'akun']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Akun Terkunci — Mengatasi Akun yang Terblokir Setelah Gagal Login',
        'content' => "Sistem keamanan MineOps akan mengunci akun secara otomatis setelah 5 kali percobaan login gagal dalam waktu 15 menit. Fitur ini melindungi akun Anda dari upaya akses yang tidak sah.\n\n"
            . "Jika akun Anda terkunci, ikuti langkah berikut:\n\n"
            . "1. Tunggu selama 15 menit — akun akan terbuka kembali secara otomatis setelah masa tunggu berakhir.\n"
            . "2. Sebelum mencoba login kembali, pastikan Anda menggunakan password yang benar. Aktifkan opsi 'Tampilkan Password' (ikon mata) untuk memastikan tidak ada kesalahan ketik.\n"
            . "3. Jika Anda tidak yakin dengan password, gunakan fitur 'Lupa Password?' untuk melakukan reset.\n"
            . "4. Apabila akun tidak terbuka meski sudah menunggu lebih dari 30 menit, segera hubungi administrator MineOps melalui email atau WhatsApp resmi perusahaan.\n\n"
            . "Untuk menghindari penguncian di masa mendatang, simpan password dengan aman menggunakan password manager dan hindari berbagi kredensial akun dengan rekan kerja. Setiap pengguna wajib memiliki akun dan password masing-masing.",
        'tags' => json_encode(['login', 'akun terkunci', 'keamanan', 'gagal login']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Tidak Bisa Login Setelah Update Aplikasi — Solusi Cache dan Cookie',
        'content' => "Setelah pembaruan (update) aplikasi MineOps, beberapa pengguna mungkin mengalami kendala login seperti halaman berputar terus (loading loop), tombol login tidak merespons, atau error 'Invalid Session'. Masalah ini umumnya disebabkan oleh cache browser yang masih menyimpan versi lama aplikasi.\n\n"
            . "Lakukan langkah pembersihan berikut untuk mengatasinya:\n\n"
            . "1. Buka pengaturan browser Anda, cari menu 'Privacy & Security' atau 'Keamanan & Privasi'.\n"
            . "2. Pilih 'Clear Browsing Data' atau 'Hapus Data Penjelajahan', centang opsi 'Cached Images and Files' serta 'Cookies and Site Data'.\n"
            . "3. Pastikan rentang waktu yang dipilih adalah 'All Time' atau 'Sepanjang Waktu', lalu klik 'Clear Data'.\n"
            . "4. Tutup browser sepenuhnya, lalu buka kembali dan akses halaman login MineOps.\n"
            . "5. Jika masih belum berhasil, coba akses menggunakan mode Incognito/Private Window (Ctrl+Shift+N di Chrome, Ctrl+Shift+P di Firefox).\n\n"
            . "Apabila masalah tetap berlanjut setelah semua langkah di atas, kemungkinan ada kendala dari sisi server. Hubungi tim IT support dengan menyertakan tangkapan layar (screenshot) error yang muncul dan browser yang Anda gunakan.",
        'tags' => json_encode(['login', 'update', 'cache', 'cookie', 'browser']),
        'source_manual' => true,
        'is_published' => true,
    ],

    // ========================
    // NAVIGATION (3 articles)
    // ========================

    [
        'app_id' => 1,
        'title' => 'Panduan Navigasi Dashboard Utama MineOps',
        'content' => "Dashboard utama MineOps adalah pusat kendali yang menampilkan ringkasan operasional tambang secara real-time. Saat pertama kali login, Anda akan langsung diarahkan ke halaman ini.\n\n"
            . "Berikut penjelasan area-area utama di dashboard:\n\n"
            . "1. Sidebar kiri — berisi menu navigasi utama: Dashboard, Fleet Management, Production Tracking, Equipment Maintenance, Reports, Settings, dan Help. Klik ikon menu (☰) untuk menampilkan teks label jika sidebar dalam keadaan diciutkan.\n"
            . "2. Bar atas — menampilkan notifikasi (ikon lonceng), profil pengguna, dan tombol logout. Klik ikon lonceng untuk melihat alert terbaru seperti peringatan maintenance atau status kendaraan.\n"
            . "3. Kartu ringkasan (KPI Cards) — empat kartu di bagian atas menampilkan total unit aktif, produksi hari ini, jumlah kendaraan dalam maintenance, dan utilisasi rata-rata.\n"
            . "4. Grafik produksi real-time — panel tengah menampilkan tren produksi per jam yang diperbarui otomatis.\n"
            . "5. Quick Access — panel sisi kanan berisi pintasan ke fungsi yang sering digunakan: input data produksi, cek status unit, dan laporan harian.\n\n"
            . "Anda dapat menyesuaikan tampilan dashboard dengan klik 'Customize' di pojok kanan atas untuk memilih widget mana yang ingin ditampilkan.",
        'tags' => json_encode(['navigasi', 'dashboard', 'menu', 'tampilan']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Cara Mencari Data Kendaraan Berdasarkan Nomor Lambung',
        'content' => "Nomor lambung (unit ID) adalah identitas unik setiap kendaraan dan alat berat di MineOps. Pencarian berdasarkan nomor lambung adalah cara tercepat untuk mengakses data lengkap sebuah unit.\n\n"
            . "Ikuti langkah-langkah berikut untuk mencari kendaraan:\n\n"
            . "1. Dari sidebar kiri, klik menu 'Fleet Management' lalu pilih sub-menu 'Daftar Unit'.\n"
            . "2. Di halaman Daftar Unit, Anda akan melihat tabel berisi seluruh kendaraan. Gunakan kotak pencarian (search box) di bagian atas tabel.\n"
            . "3. Ketik nomor lambung kendaraan (contoh: 'DT-045' untuk dump truck nomor 45, atau 'EX-112' untuk excavator nomor 112).\n"
            . "4. Hasil pencarian akan muncul secara otomatis saat Anda mengetik. Klik baris hasil untuk membuka halaman detail kendaraan.\n"
            . "5. Di halaman detail, tersedia tab-tab informasi: Spesifikasi, Riwayat Produksi, Jadwal Maintenance, Riwayat Perbaikan, dan Konsumsi BBM.\n\n"
            . "Jika pencarian tidak membuahkan hasil, periksa kembali format nomor lambung. Format standar MineOps adalah [Kode Jenis]-[Nomor], misalnya DT untuk Dump Truck, EX untuk Excavator, BD untuk Bulldozer, GD untuk Grader, dan WT untuk Water Truck.",
        'tags' => json_encode(['navigasi', 'pencarian', 'kendaraan', 'nomor lambung', 'fleet']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Navigasi Menu Equipment Maintenance — Memahami Sub-Menu dan Fungsinya',
        'content' => "Menu Equipment Maintenance di MineOps adalah pusat pengelolaan seluruh aktivitas perawatan dan perbaikan alat berat. Memahami struktur sub-menunya akan mempercepat pekerjaan Anda sehari-hari.\n\n"
            . "Struktur menu Equipment Maintenance terdiri dari:\n\n"
            . "1. Dashboard Maintenance — ringkasan status seluruh unit: jumlah unit dalam perawatan, unit yang akan jatuh tempo, dan riwayat kerusakan bulan ini.\n"
            . "2. Jadwal Maintenance — kalender dan daftar unit yang dijadwalkan untuk perawatan rutin (preventive maintenance). Filter berdasarkan rentang tanggal, jenis unit, atau status jadwal.\n"
            . "3. Riwayat Service — log lengkap setiap aktivitas perawatan yang telah dilakukan. Gunakan fitur pencarian untuk menemukan riwayat unit tertentu.\n"
            . "4. Spare Parts — inventaris suku cadang beserta stok tersedia, minimum stok, dan harga. Sistem akan memberikan peringatan jika stok mendekati batas minimum.\n"
            . "5. Work Order — daftar perintah kerja untuk mekanik. Setiap work order memiliki status: Menunggu, Dalam Pengerjaan, Selesai, atau Dibatalkan.\n"
            . "6. Laporan Maintenance — template laporan perawatan yang dapat diekspor ke format PDF atau Excel.\n\n"
            . "Untuk mempercepat akses, Anda dapat menandai sub-menu favorit dengan mengklik ikon bintang (★) di samping nama sub-menu. Sub-menu yang ditandai akan muncul di panel Quick Access dashboard.",
        'tags' => json_encode(['navigasi', 'maintenance', 'perawatan', 'menu', 'sub-menu']),
        'source_manual' => true,
        'is_published' => true,
    ],

    // ========================
    // DATA ENTRY (3 articles)
    // ========================

    [
        'app_id' => 1,
        'title' => 'Panduan Input Data Produksi Harian di MineOps',
        'content' => "Input data produksi harian adalah aktivitas rutin yang mencatat hasil produksi setiap unit kendaraan dan alat berat. Data ini menjadi dasar untuk laporan kinerja dan evaluasi operasional.\n\n"
            . "Berikut langkah-langkah input data produksi harian:\n\n"
            . "1. Dari sidebar, klik 'Production Tracking' lalu pilih 'Input Produksi Harian'.\n"
            . "2. Pilih tanggal produksi yang akan diinput. Default adalah tanggal hari ini.\n"
            . "3. Pilih lokasi (PIT/area tambang) dari dropdown yang tersedia, misalnya PIT A, PIT B, atau Stockpile.\n"
            . "4. Tabel input akan muncul berisi daftar unit yang aktif di lokasi tersebut. Untuk setiap unit, isi kolom-kolom berikut:\n"
            . "   - Ritase/Trip: jumlah perjalanan bolak-balik yang dilakukan unit.\n"
            . "   - Volume (BCM/Ton): total material yang dipindahkan, dalam satuan BCM (Bank Cubic Meter) atau Ton.\n"
            . "   - Jam Operasional: total jam kerja efektif unit pada hari tersebut.\n"
            . "   - Jarak Angkut (km): jarak rata-rata tempuh per trip (khusus dump truck).\n"
            . "5. Setelah semua data terisi, klik tombol 'Simpan' di bagian bawah halaman. Sistem akan memvalidasi data dan menampilkan notifikasi jika ada field yang belum lengkap.\n\n"
            . "Data yang sudah disimpan tidak dapat diedit langsung oleh operator. Jika ada kesalahan input, hubungi supervisor untuk melakukan koreksi melalui menu 'Koreksi Data Produksi'.",
        'tags' => json_encode(['data entry', 'produksi', 'input', 'harian', 'ritase']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Cara Input Data Penggunaan Bahan Bakar (Fuel Consumption)',
        'content' => "Pencatatan konsumsi bahan bakar (fuel consumption) di MineOps penting untuk memantau efisiensi operasional dan mengendalikan biaya. Setiap pengisian bahan bakar harus dicatat melalui menu Fuel Management.\n\n"
            . "Langkah-langkah input data penggunaan BBM:\n\n"
            . "1. Dari sidebar, pilih 'Fleet Management' lalu klik sub-menu 'Fuel Management'.\n"
            . "2. Klik tombol 'Tambah Catatan BBM' di pojok kanan atas halaman.\n"
            . "3. Pilih nomor lambung unit yang akan dicatat dari dropdown pencarian.\n"
            . "4. Isi data pengisian:\n"
            . "   - Tanggal dan jam pengisian — default adalah waktu saat ini.\n"
            . "   - Lokasi pengisian — pilih dari daftar fuel station yang tersedia.\n"
            . "   - Jumlah BBM (liter) — masukkan volume bahan bakar yang diisi.\n"
            . "   - Odometer/HM (Hour Meter) — catat jam operasional unit saat pengisian.\n"
            . "   - Tipe BBM — pilih solar, bensin, atau jenis lainnya.\n"
            . "5. Klik 'Simpan'. Sistem akan otomatis menghitung rasio konsumsi (liter per jam) dan menampilkannya di ringkasan.\n\n"
            . "Pastikan untuk selalu mencatat pengisian BBM pada hari yang sama. Data yang konsisten akan menghasilkan analisis fuel ratio yang akurat untuk evaluasi efisiensi operasional setiap unit.",
        'tags' => json_encode(['data entry', 'bahan bakar', 'fuel', 'konsumsi', 'BBM']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Mencatat Jam Operasional dan Downtime Alat Berat',
        'content' => "Pencatatan jam operasional (operating hours) dan downtime alat berat sangat kritis untuk menghitung utilisasi dan produktivitas. MineOps menyediakan form khusus untuk mencatat kedua metrik ini setiap hari.\n\n"
            . "Ikuti langkah-langkah berikut:\n\n"
            . "1. Buka menu 'Equipment Maintenance' lalu pilih sub-menu 'Jam Operasional'.\n"
            . "2. Klik tombol 'Input Jam Operasional' dan pilih tanggal pencatatan.\n"
            . "3. Tabel akan menampilkan seluruh unit alat berat (excavator, bulldozer, grader, dll). Untuk setiap unit, isi:\n"
            . "   - HM Awal (Hour Meter awal shift) — baca dari panel instrumen unit.\n"
            . "   - HM Akhir (Hour Meter akhir shift) — baca di akhir shift.\n"
            . "   - Jam kerja efektif akan dihitung otomatis dari selisih HM.\n"
            . "4. Untuk mencatat downtime, pilih tab 'Downtime' dan isi:\n"
            . "   - Waktu mulai dan selesai downtime.\n"
            . "   - Kategori downtime: Maintenance (perawatan terjadwal), Breakdown (kerusakan), Standby (menunggu), Cuaca, atau Operasional (tunggu muatan, antrean).\n"
            . "   - Keterangan singkat penyebab downtime.\n"
            . "5. Klik 'Simpan' setelah semua data diisi.\n\n"
            . "Data jam operasional dan downtime akan langsung mempengaruhi laporan utilisasi dan menjadi dasar perhitungan availability unit (PA — Physical Availability). Pastikan data diinput setiap akhir shift untuk akurasi pelaporan.",
        'tags' => json_encode(['data entry', 'jam operasional', 'downtime', 'utilisasi', 'alat berat', 'HM']),
        'source_manual' => true,
        'is_published' => true,
    ],

    // ========================
    // ERROR MESSAGES (3 articles)
    // ========================

    [
        'app_id' => 1,
        'title' => 'Mengatasi Error "Data Tidak Tersimpan — Validation Failed" Saat Input Produksi',
        'content' => "Error 'Data Tidak Tersimpan — Validation Failed' muncul saat sistem mendeteksi data input yang tidak sesuai dengan aturan validasi MineOps. Error ini umum terjadi saat mengisi form produksi harian dan dapat diselesaikan dengan memeriksa ulang isian.\n\n"
            . "Penyebab umum dan cara mengatasinya:\n\n"
            . "1. Kolom wajib kosong — periksa kembali apakah ada field yang ditandai dengan bintang merah (*) yang belum diisi. Field seperti tanggal, lokasi, dan nomor unit wajib diisi.\n"
            . "2. Format angka salah — pastikan kolom numerik seperti volume (BCM/Ton) dan jarak (km) hanya berisi angka. Gunakan titik (.) sebagai pemisah desimal, bukan koma. Contoh: 45.5 bukan 45,5.\n"
            . "3. Volume melebihi batas maksimal — MineOps memiliki batas atas volume per ritase sesuai tipe unit. Misalnya, dump truck DT-045 memiliki kapasitas maksimal 35 BCM per trip. Periksa kapasitas unit di halaman spesifikasi.\n"
            . "4. Duplikasi data — Anda mungkin mencoba menginput data untuk unit dan tanggal yang sudah ada. Periksa kembali apakah data untuk unit tersebut pada tanggal itu sudah diinput sebelumnya.\n"
            . "5. Koneksi terputus — jika input berlangsung lama, sesi mungkin kedaluwarsa. Simpan secara berkala atau refresh halaman sebelum melanjutkan input.\n\n"
            . "Apabila semua langkah di atas sudah dilakukan dan error masih muncul, catat pesan error lengkap yang ditampilkan (termasuk field yang gagal validasi) dan laporkan ke IT support.",
        'tags' => json_encode(['error', 'validasi', 'data tidak tersimpan', 'input', 'produksi']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Error Sinkronisasi Data — Data Dari Lapangan Tidak Muncul di Server',
        'content' => "MineOps memiliki fitur sinkronisasi yang memungkinkan data dari perangkat lapangan (tablet/smartphone) dikirim ke server pusat. Error sinkronisasi biasanya ditandai dengan pesan 'Sync Failed' atau data yang sudah diinput di lapangan tidak muncul di dashboard web.\n\n"
            . "Lakukan pengecekan bertahap berikut:\n\n"
            . "1. Periksa koneksi internet pada perangkat lapangan. MineOps memerlukan koneksi minimal 3G/HSPA untuk sinkronisasi. Buka aplikasi browser di perangkat dan akses situs lain untuk memastikan internet berfungsi.\n"
            . "2. Buka menu 'Sync Status' (ikon awan di pojok kanan atas aplikasi mobile) untuk melihat antrean data yang belum tersinkronisasi. Jika ada data tertunda, klik 'Retry Sync'.\n"
            . "3. Periksa apakah versi aplikasi mobile Anda sudah yang terbaru. Versi lama mungkin tidak kompatibel dengan server setelah pembaruan. Buka Play Store (Android) dan periksa ketersediaan update.\n"
            . "4. Logout dari aplikasi mobile, tutup aplikasi sepenuhnya (force close), lalu buka kembali dan login. Coba sinkronisasi ulang.\n"
            . "5. Jika data masih belum muncul, laporkan ke IT support dengan menyertakan: nama user, perangkat yang digunakan (tipe HP/tablet), waktu sinkronisasi, dan jumlah data yang tertunda.\n\n"
            . "Sebagai langkah pencegahan, biasakan untuk melakukan sinkronisasi setiap selesai input data dan jangan menunda terlalu lama karena perangkat memiliki kapasitas penyimpanan antrean terbatas.",
        'tags' => json_encode(['error', 'sinkronisasi', 'sync', 'lapangan', 'data', 'koneksi']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Error "Unit Tidak Ditemukan" Saat Mencari Kendaraan — Penyebab dan Solusi',
        'content' => "Pesan error 'Unit Tidak Ditemukan' muncul ketika sistem tidak dapat menemukan kendaraan dengan nomor lambung yang Anda cari. Ini bisa terjadi karena beberapa alasan yang berbeda-beda.\n\n"
            . "Berikut penyebab dan cara mengatasinya:\n\n"
            . "1. Format nomor lambung salah — pastikan Anda menggunakan format yang benar: [Kode Jenis]-[Nomor]. Contoh: 'DT-088' (bukan 'DT088' tanpa strip, atau 'dt-088' huruf kecil).\n"
            . "2. Unit sudah tidak aktif — kendaraan yang sudah dinonaktifkan (status 'Retired' atau 'Disposal') tidak muncul di pencarian default. Aktifkan opsi 'Tampilkan Unit Non-Aktif' di filter pencarian untuk melihat unit yang sudah tidak beroperasi.\n"
            . "3. Unit belum terdaftar — jika unit baru saja didatangkan, kemungkinan data belum diinput oleh admin. Buka menu 'Settings' > 'Daftar Unit' untuk memeriksa apakah unit sudah terdaftar.\n"
            . "4. Salah memilih site/lokasi — jika MineOps Anda mengelola beberapa site tambang, pastikan Anda berada di site yang benar. Pilih site yang sesuai dari dropdown di pojok kiri atas sebelum melakukan pencarian.\n"
            . "5. Cache browser — bersihkan cache browser dan refresh halaman, lalu ulangi pencarian.\n\n"
            . "Jika unit seharusnya ada tapi tetap tidak ditemukan, hubungi admin MineOps untuk memverifikasi status unit di database. Admin dapat memeriksa log aktivasi/nonaktivasi unit melalui panel administrasi.",
        'tags' => json_encode(['error', 'unit tidak ditemukan', 'pencarian', 'kendaraan', 'fleet']),
        'source_manual' => true,
        'is_published' => true,
    ],

    // ========================
    // REPORTS (3 articles)
    // ========================

    [
        'app_id' => 1,
        'title' => 'Panduan Generate Laporan Produksi Bulanan',
        'content' => "Laporan produksi bulanan merangkum seluruh aktivitas produksi selama satu bulan penuh. Laporan ini digunakan untuk evaluasi kinerja, rapat bulanan, dan pelaporan ke manajemen.\n\n"
            . "Cara generate laporan produksi bulanan:\n\n"
            . "1. Dari sidebar, klik menu 'Reports' lalu pilih 'Laporan Produksi'.\n"
            . "2. Pilih tipe laporan 'Bulanan' dari dropdown periode.\n"
            . "3. Pilih bulan dan tahun yang diinginkan melalui date picker.\n"
            . "4. Pilih parameter laporan yang ingin ditampilkan:\n"
            . "   - Per Lokasi (PIT): menampilkan total produksi per area tambang.\n"
            . "   - Per Unit: rincian produksi setiap kendaraan/alat berat.\n"
            . "   - Per Shift: distribusi produksi per shift (pagi, siang, malam).\n"
            . "   - Per Material: tonase per jenis material (overburden, ore, coal).\n"
            . "5. Klik tombol 'Generate'. Sistem akan memproses data dan menampilkan laporan dalam bentuk tabel dan grafik.\n"
            . "6. Untuk menyimpan atau mencetak, klik tombol 'Export' dan pilih format: PDF (cocok untuk cetak/lampiran email) atau Excel/CSV (untuk analisis lanjutan).\n\n"
            . "Laporan produksi bulanan biasanya siap diakses pada tanggal 1 setiap bulannya. Namun data dapat di-generate kapan saja dan akan mencakup data hingga hari terakhir yang sudah diinput.",
        'tags' => json_encode(['laporan', 'produksi', 'bulanan', 'export', 'PDF', 'Excel']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Membuat Laporan Utilisasi dan Ketersediaan Alat Berat (PA/UA)',
        'content' => "Laporan utilisasi dan ketersediaan (Availability) adalah indikator kinerja utama (KPI) dalam manajemen alat berat. MineOps menyediakan modul laporan khusus untuk menghitung Physical Availability (PA) dan Utilization of Availability (UA) secara otomatis.\n\n"
            . "Langkah-langkah membuat laporan PA/UA:\n\n"
            . "1. Dari menu 'Reports', pilih 'Laporan Utilisasi & Availability'.\n"
            . "2. Pilih rentang tanggal yang diinginkan — bisa harian, mingguan, atau bulanan.\n"
            . "3. Pilih jenis alat berat yang ingin dilaporkan (Excavator, Bulldozer, Dump Truck, Grader, dll) atau pilih 'Semua Unit' untuk laporan menyeluruh.\n"
            . "4. Centang metrik yang ingin ditampilkan:\n"
            . "   - PA (Physical Availability): persentase waktu unit tersedia secara fisik dibanding total waktu.\n"
            . "   - UA (Utilization of Availability): persentase jam kerja efektif terhadap jam tersedia.\n"
            . "   - EU (Effective Utilization): persentase jam kerja efektif terhadap total waktu.\n"
            . "   - Downtime Breakdown: rincian penyebab downtime per kategori.\n"
            . "5. Klik 'Generate'. Laporan akan menampilkan tabel per unit beserta grafik tren.\n"
            . "6. Gunakan fitur 'Target vs Actual' untuk membandingkan performa unit terhadap target yang sudah ditetapkan (default target PA ≥ 85%, UA ≥ 80%).\n\n"
            . "Laporan ini sangat berguna untuk mengidentifikasi unit yang sering mengalami downtime dan perlu perhatian khusus, baik dari sisi perawatan maupun operasional.",
        'tags' => json_encode(['laporan', 'utilisasi', 'availability', 'PA', 'UA', 'alat berat']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Export Laporan Maintenance dan Biaya Perawatan Kendaraan',
        'content' => "Laporan maintenance mencatat seluruh aktivitas perawatan, perbaikan, dan biaya yang dikeluarkan untuk setiap unit. Laporan ini penting untuk analisis biaya operasional dan perencanaan anggaran maintenance.\n\n"
            . "Cara membuat dan mengekspor laporan maintenance:\n\n"
            . "1. Buka menu 'Reports' lalu pilih 'Laporan Maintenance & Biaya'.\n"
            . "2. Pilih rentang periode laporan. Tersedia pilihan: Mingguan, Bulanan, Triwulan, atau Kustom (pilih tanggal mulai dan selesai manual).\n"
            . "3. Filter berdasarkan:\n"
            . "   - Tipe Maintenance: Preventive (terjadwal), Corrective (perbaikan), atau Breakdown (darurat).\n"
            . "   - Unit: pilih unit spesifik atau 'Semua Unit'.\n"
            . "   - Komponen Biaya: Spare Parts, Tenaga Kerja, Subkontrak, atau Semua.\n"
            . "4. Klik 'Generate' untuk melihat ringkasan laporan yang mencakup:\n"
            . "   - Jumlah work order selesai, dalam proses, dan pending.\n"
            . "   - Total biaya suku cadang dan tenaga kerja.\n"
            . "   - Downtime total per unit (dalam jam).\n"
            . "   - MTBF (Mean Time Between Failures) dan MTTR (Mean Time To Repair).\n"
            . "5. Untuk mengekspor, klik 'Export' dan pilih format. Gunakan PDF untuk presentasi dan Excel untuk analisis data lebih lanjut.\n\n"
            . "Disarankan untuk menyimpan laporan maintenance setiap akhir bulan ke dalam folder arsip digital perusahaan sebagai dokumentasi audit dan referensi perencanaan anggaran periode berikutnya.",
        'tags' => json_encode(['laporan', 'maintenance', 'biaya', 'perawatan', 'export', 'MTBF', 'MTTR']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Laporan Harian Produksi — Cek Ringkasan Cepat per Shift',
        'content' => "Laporan harian produksi memberikan ringkasan capaian produksi per shift (pagi, siang, malam) untuk pemantauan operasional sehari-hari dan pengambilan keputusan cepat di lapangan.\n\n"
            . "Cara mengakses dan membaca laporan harian:\n\n"
            . "1. Dari dashboard utama, klik kartu 'Produksi Hari Ini' atau buka menu 'Reports' > 'Laporan Harian'.\n"
            . "2. Secara default, laporan menampilkan data hari ini. Gunakan date picker untuk melihat data hari sebelumnya.\n"
            . "3. Laporan terbagi menjadi tiga panel:\n"
            . "   - Ringkasan per Shift: tabel menampilkan volume per shift, target, dan persentase pencapaian. Shift malam (00:00-08:00), Shift Pagi (08:00-16:00), Shift Siang (16:00-00:00).\n"
            . "   - Grafik progres: diagram batang real-time membandingkan aktual vs rencana produksi.\n"
            . "   - Top 5 Unit: lima unit dengan produktivitas tertinggi pada hari tersebut.\n"
            . "4. Untuk melihat detail per unit, klik tab 'Detail per Unit' yang menampilkan tabel lengkap seluruh unit beserta volume, jumlah ritase, dan jam operasional.\n"
            . "5. Gunakan tombol 'Cetak' di pojok kanan atas untuk mencetak laporan fisik yang bisa ditempel di papan informasi.\n\n"
            . "Laporan harian secara otomatis terkirim melalui email ke supervisor dan kepala teknik setiap pukul 06:00 pagi (ringkasan hari sebelumnya), asalkan notifikasi email sudah diaktifkan di menu Settings.",
        'tags' => json_encode(['laporan', 'harian', 'shift', 'ringkasan', 'produksi']),
        'source_manual' => true,
        'is_published' => true,
    ],

    // ========================
    // SETTINGS (4 articles)
    // ========================

    [
        'app_id' => 1,
        'title' => 'Mengatur Notifikasi Jadwal Maintenance — Peringatan Otomatis ke Mekanik',
        'content' => "Fitur notifikasi jadwal maintenance membantu memastikan tidak ada unit yang terlewat perawatan rutinnya. Notifikasi dapat dikirim melalui dalam aplikasi, email, atau WhatsApp.\n\n"
            . "Cara mengonfigurasi notifikasi maintenance:\n\n"
            . "1. Buka menu 'Settings' lalu pilih tab 'Notifications'.\n"
            . "2. Cari bagian 'Maintenance Reminder' dan aktifkan toggle 'Enable Notifications'.\n"
            . "3. Atur waktu pengiriman notifikasi:\n"
            . "   - Sebelum jatuh tempo: kirim peringatan H-7, H-3, dan H-1 sebelum jadwal maintenance.\n"
            . "   - Overdue alert: kirim peringatan jika unit melewati jadwal tanpa perawatan.\n"
            . "   - Pengingat harian: ringkasan unit yang akan jatuh tempo minggu ini.\n"
            . "4. Pilih metode pengiriman: In-App Notification (lonceng di dashboard), Email (masukkan alamat email penerima), atau WhatsApp (masukkan nomor HP dengan format 62xxx).\n"
            . "5. Daftarkan penerima notifikasi dengan klik 'Tambah Penerima', pilih user dari daftar, dan tentukan tipe notifikasi yang mereka terima.\n"
            . "6. Klik 'Simpan Konfigurasi'. Lakukan uji coba dengan klik 'Kirim Notifikasi Uji' untuk memastikan pengaturan berfungsi.\n\n"
            . "Disarankan untuk mengaktifkan minimal notifikasi H-3 dan H-1 agar mekanik memiliki waktu persiapan. Overdue alert wajib diaktifkan untuk menghindari unit beroperasi tanpa perawatan yang dapat menyebabkan kerusakan serius.",
        'tags' => json_encode(['settings', 'notifikasi', 'maintenance', 'jadwal', 'mekanik']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Cara Menambah dan Mengelola Pengguna Baru di MineOps',
        'content' => "Setiap personel yang memerlukan akses ke MineOps harus didaftarkan sebagai pengguna (user) dengan role dan izin yang sesuai. Hanya admin yang memiliki wewenang untuk menambah, mengedit, atau menonaktifkan pengguna.\n\n"
            . "Langkah-langkah menambah pengguna baru:\n\n"
            . "1. Buka menu 'Settings' lalu pilih tab 'User Management'.\n"
            . "2. Klik tombol 'Tambah Pengguna'. Form pendaftaran akan terbuka.\n"
            . "3. Isi data pengguna:\n"
            . "   - Nama lengkap — sesuai KTP/ID card.\n"
            . "   - Email — akan digunakan untuk login dan notifikasi. Pastikan email valid dan aktif.\n"
            . "   - Nomor HP (opsional) — untuk notifikasi WhatsApp, format 62xxx.\n"
            . "   - Role — pilih salah satu: Admin (akses penuh), Supervisor (akses data & laporan), Operator (input data lapangan), Mekanik (akses maintenance), atau Viewer (hanya lihat data).\n"
            . "   - Site — tentukan lokasi tambang tempat pengguna bekerja.\n"
            . "4. Klik 'Simpan'. Sistem akan otomatis mengirim email berisi tautan aktivasi akun ke alamat email yang didaftarkan.\n"
            . "5. Pengguna baru harus mengklik tautan aktivasi dan membuat password dalam waktu 48 jam sebelum tautan kedaluwarsa.\n\n"
            . "Untuk menonaktifkan pengguna (misalnya karyawan yang sudah resign), buka daftar pengguna, klik ikon edit (pensil) pada pengguna yang dituju, lalu ubah status dari 'Active' menjadi 'Inactive'. Akun yang dinonaktifkan tidak dapat login tetapi riwayat datanya tetap tersimpan.",
        'tags' => json_encode(['settings', 'pengguna', 'user', 'role', 'admin', 'akses']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Konfigurasi Unit Tambang dan Lokasi — Menambah PIT Baru dan Kendaraan',
        'content' => "Saat terjadi penambahan area tambang (PIT baru) atau pengadaan unit kendaraan baru, admin perlu memperbarui konfigurasi di MineOps agar unit dan lokasi tersebut tersedia di seluruh modul.\n\n"
            . "Panduan konfigurasi lokasi dan unit:\n\n"
            . "A. Menambah Lokasi/PIT Baru:\n"
            . "1. Buka 'Settings' > 'Site Configuration' > tab 'Lokasi'.\n"
            . "2. Klik 'Tambah Lokasi', lalu isi: nama lokasi (contoh: PIT C, Stockpile Selatan), tipe lokasi (Loading Point, Dumping Point, Stockpile, atau Workshop), dan koordinat (opsional, untuk integrasi peta).\n"
            . "3. Klik 'Simpan'. Lokasi baru akan muncul di dropdown pilihan di form input produksi.\n\n"
            . "B. Menambah Unit Kendaraan/Alat Berat Baru:\n"
            . "1. Buka 'Settings' > 'Site Configuration' > tab 'Unit & Armada'.\n"
            . "2. Klik 'Tambah Unit', isi data unit:\n"
            . "   - Nomor Lambung — gunakan format standar [Kode]-[Nomor], contoh: DT-052.\n"
            . "   - Tipe Unit — pilih dari daftar: Dump Truck, Excavator, Bulldozer, Grader, Water Truck, dll.\n"
            . "   - Merk dan Model — contoh: Komatsu HD785, Caterpillar 320D.\n"
            . "   - Kapasitas (BCM/Ton) — kapasitas maksimum unit.\n"
            . "   - Tahun Pembuatan.\n"
            . "   - Lokasi Assignment — PIT tempat unit ditugaskan.\n"
            . "3. Klik 'Simpan'. Unit akan muncul di daftar unit dan siap digunakan di seluruh modul.\n\n"
            . "Perubahan konfigurasi ini berlaku seketika (real-time) dan tidak memerlukan restart aplikasi.",
        'tags' => json_encode(['settings', 'konfigurasi', 'unit', 'PIT', 'lokasi', 'kendaraan']),
        'source_manual' => true,
        'is_published' => true,
    ],

    [
        'app_id' => 1,
        'title' => 'Konfigurasi Target dan KPI Produksi — Menetapkan Target Harian dan Bulanan',
        'content' => "MineOps memungkinkan supervisor menetapkan target produksi yang akan digunakan sebagai tolok ukur capaian di seluruh laporan. Target ditetapkan per lokasi, per material, dan per periode.\n\n"
            . "Langkah-langkah mengatur target produksi:\n\n"
            . "1. Buka menu 'Settings' lalu pilih tab 'Target & KPI'.\n"
            . "2. Pilih periode target: Harian atau Bulanan.\n"
            . "3. Pilih lokasi (PIT) yang akan ditetapkan targetnya dari dropdown.\n"
            . "4. Untuk setiap jenis material, masukkan angka target:\n"
            . "   - Overburden (OB) — dalam satuan BCM.\n"
            . "   - Ore/Mineral — dalam satuan Ton.\n"
            . "   - Batubara (Coal) — dalam satuan Ton (untuk tambang batubara).\n"
            . "5. Tentukan target per unit (opsional) jika ingin menetapkan target spesifik untuk tiap kendaraan atau alat berat. Centang 'Setel Target per Unit' dan isi tabel target.\n"
            . "6. Klik 'Simpan Target'. Sistem akan langsung menggunakan target ini untuk perhitungan persentase pencapaian di dashboard dan laporan.\n\n"
            . "Target produksi dapat diubah sewaktu-waktu, tetapi perubahan hanya berlaku untuk periode ke depan (tidak retroaktif). Riwayat perubahan target dicatat di log sistem untuk keperluan audit. Anda juga dapat mengatur target utilisasi (PA dan UA) di tab terpisah dalam menu yang sama.",
        'tags' => json_encode(['settings', 'target', 'KPI', 'produksi', 'konfigurasi']),
        'source_manual' => true,
        'is_published' => true,
    ],
];
