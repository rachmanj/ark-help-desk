<?php

/**
 * KB Articles Seeder — ArkFleet (app_id=3), VASIA POS (app_id=4), Pratasaba Resort (app_id=5)
 *
 * Returns an associative array keyed by app_id, each containing an array of KB articles.
 * Structure per article: [title, content, tags (JSON array), source_manual, is_published]
 *
 * ~18 realistic Bahasa Indonesia articles per app (~54 total).
 */

return [

    // =========================================================================
    // APP 3: ArkFleet — Vehicle Tracking, Fuel Management, Driver Management,
    //         SAP B1 Integration
    // =========================================================================
    3 => [
        // ── Vehicle Tracking ──
        [
            'title'          => 'Cara Melacak Posisi Kendaraan Secara Real-Time',
            'content'        => "Untuk melacak posisi kendaraan secara real-time:\n\n"
                . "1. Buka menu **Vehicle Tracking** di dashboard ArkFleet.\n"
                . "2. Pilih kendaraan dari daftar atau gunakan kolom pencarian berdasarkan nomor polisi.\n"
                . "3. Klik tombol **Live Track**. Peta akan menampilkan posisi terkini kendaraan dengan interval refresh setiap 10 detik.\n"
                . "4. Informasi yang ditampilkan meliputi: koordinat GPS, kecepatan, arah, status mesin (ON/OFF), dan alamat terdekat.\n"
                . "5. Gunakan fitur **History Trail** untuk melihat jejak perjalanan dalam rentang waktu tertentu.\n\n"
                . "**Tips:** Pastikan perangkat GPS pada kendaraan aktif dan terhubung ke jaringan seluler. Jika posisi tidak muncul, periksa indikator sinyal di pojok kanan bawah peta.",
            'tags'           => json_encode(['tracking', 'GPS', 'real-time', 'peta']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Mengatur Geofence dan Alert Zona',
            'content'        => "Geofence adalah batas wilayah virtual yang memicu notifikasi saat kendaraan masuk atau keluar area.\n\n"
                . "**Cara membuat geofence:**\n"
                . "1. Buka menu **Geofence** → **Buat Zona Baru**.\n"
                . "2. Beri nama zona (contoh: 'Area Tambang Site A').\n"
                . "3. Gambar poligon pada peta atau masukkan koordinat manual.\n"
                . "4. Pilih tipe alert: **Masuk Zona**, **Keluar Zona**, atau keduanya.\n"
                . "5. Tentukan kendaraan atau grup kendaraan yang dipantau.\n"
                . "6. Klik **Simpan**.\n\n"
                . "Notifikasi akan dikirim via Telegram atau email saat alert terpicu. Anda dapat melihat riwayat pelanggaran geofence di menu **Reports → Geofence Alerts**.",
            'tags'           => json_encode(['geofence', 'alert', 'zona', 'notifikasi']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Laporan Riwayat Perjalanan Kendaraan',
            'content'        => "Laporan riwayat perjalanan mencatat seluruh aktivitas kendaraan dalam periode tertentu.\n\n"
                . "**Cara mengakses:**\n"
                . "1. Buka menu **Reports → Trip History**.\n"
                . "2. Pilih kendaraan (satu atau beberapa) dan rentang tanggal.\n"
                . "3. Klik **Generate**.\n\n"
                . "Laporan menampilkan:\n"
                . "- Waktu mulai dan selesai perjalanan\n"
                . "- Jarak tempuh (km)\n"
                . "- Durasi perjalanan dan waktu berhenti\n"
                . "- Kecepatan rata-rata dan maksimum\n"
                . "- Rute yang dilalui (dapat dilihat di peta)\n\n"
                . "Laporan dapat diekspor dalam format PDF atau Excel. Gunakan filter untuk melihat perjalanan di luar jam kerja atau rute tidak wajar.",
            'tags'           => json_encode(['laporan', 'riwayat', 'perjalanan', 'trip']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Monitoring Kecepatan dan Safety Driving',
            'content'        => "ArkFleet menyediakan fitur monitoring kecepatan untuk mendorong keselamatan berkendara.\n\n"
                . "**Konfigurasi batas kecepatan:**\n"
                . "1. Buka **Settings → Speed Limits**.\n"
                . "2. Tetapkan batas kecepatan per tipe kendaraan (contoh: truk 80 km/jam, light vehicle 100 km/jam).\n"
                . "3. Aktifkan **Over-Speed Alert**.\n\n"
                . "**Dashboard Safety Driving** menampilkan:\n"
                . "- Skor keselamatan per driver (0-100)\n"
                . "- Kejadian over-speed, hard braking, dan hard acceleration\n"
                . "- Tren mingguan dan bulanan\n"
                . "- Ranking driver teraman\n\n"
                . "Gunakan data ini untuk coaching driver dan reward program keselamatan.",
            'tags'           => json_encode(['kecepatan', 'safety', 'driver', 'monitoring']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Fuel Management ──
        [
            'title'          => 'Pencatatan BBM dan Konsumsi Bahan Bakar',
            'content'        => "Manajemen BBM mencatat setiap pengisian dan konsumsi bahan bakar untuk kontrol biaya operasional.\n\n"
                . "**Input pengisian BBM:**\n"
                . "1. Buka menu **Fuel → Catat Pengisian**.\n"
                . "2. Pilih kendaraan dan masukkan: jumlah liter, harga per liter, total biaya, odometer saat ini, dan lokasi SPBU.\n"
                . "3. Upload foto struk sebagai bukti (opsional).\n"
                . "4. Klik **Simpan**.\n\n"
                . "Sistem otomatis menghitung:\n"
                . "- Konsumsi BBM (km/liter) berdasarkan selisih odometer\n"
                . "- Biaya per kilometer\n"
                . "- Perbandingan dengan rata-rata armada\n\n"
                . "Anomali seperti konsumsi berlebih akan ditandai untuk investigasi.",
            'tags'           => json_encode(['bbm', 'bahan bakar', 'pencatatan', 'konsumsi']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Integrasi Sensor BBM dengan Dashboard',
            'content'        => "ArkFleet mendukung integrasi sensor BBM elektronik untuk pencatatan otomatis.\n\n"
                . "**Jenis sensor yang didukung:**\n"
                . "- Ultrasonic fuel level sensor (RS-232/RS-485)\n"
                . "- Capacitive fuel sensor\n"
                . "- CAN bus fuel reader\n\n"
                . "**Proses integrasi:**\n"
                . "1. Pastikan sensor terpasang dan terhubung ke GPS tracker.\n"
                . "2. Di ArkFleet, buka **Settings → Devices → Tambah Sensor**.\n"
                . "3. Pilih tipe sensor dan masukkan parameter konfigurasi (port, baud rate, kalibrasi).\n"
                . "4. Kalibrasi sensor dengan tangki penuh dan kosong.\n"
                . "5. Dashboard akan menampilkan level BBM real-time, grafik pengisian/pengurasan, dan alert jika terjadi penurunan drastis (indikasi pencurian).\n\n"
                . "Hubungi tim support jika membutuhkan bantuan kalibrasi sensor.",
            'tags'           => json_encode(['sensor', 'bbm', 'integrasi', 'kalibrasi']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Laporan Efisiensi Bahan Bakar Bulanan',
            'content'        => "Laporan efisiensi BBM bulanan membantu mengidentifikasi kendaraan dan driver dengan konsumsi paling hemat atau boros.\n\n"
                . "**Cara generate:**\n"
                . "1. Buka **Reports → Fuel Efficiency**.\n"
                . "2. Pilih bulan dan tahun.\n"
                . "3. Filter per kendaraan, grup, atau driver.\n"
                . "4. Klik **Generate Report**.\n\n"
                . "**Isi laporan:**\n"
                . "- Total BBM dibeli vs digunakan\n"
                . "- Km/liter per kendaraan (actual vs target)\n"
                . "- Biaya BBM total dan per-km\n"
                . "- Selisih/penyimpangan (>10% dari target)\n"
                . "- Grafik tren 6 bulan terakhir\n\n"
                . "Gunakan laporan ini untuk evaluasi vendor BBM, rotasi kendaraan, dan coaching driver.",
            'tags'           => json_encode(['laporan', 'efisiensi', 'bbm', 'bulanan']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Driver Management ──
        [
            'title'          => 'Cara Menambahkan Driver Baru',
            'content'        => "Menambahkan driver baru ke sistem ArkFleet dilakukan melalui menu Driver Management.\n\n"
                . "**Langkah-langkah:**\n"
                . "1. Buka **Drivers → Tambah Driver**.\n"
                . "2. Isi data wajib: nama lengkap, NIK, nomor SIM (tipe dan masa berlaku), nomor telepon.\n"
                . "3. Upload dokumen: foto KTP, SIM, dan pas foto.\n"
                . "4. Atur **Shift** kerja default (pagi/siang/malam).\n"
                . "5. Pilih kendaraan yang di-assign secara default (opsional).\n"
                . "6. Klik **Simpan**. Driver akan muncul di daftar dengan status **Aktif**.\n\n"
                . "**Tips:** Gunakan fitur **Import CSV** untuk menambahkan banyak driver sekaligus. Template CSV dapat diunduh dari halaman Tambah Driver.",
            'tags'           => json_encode(['driver', 'tambah', 'data', 'sopir']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Penjadwalan dan Assignment Driver ke Kendaraan',
            'content'        => "Penjadwalan driver memastikan setiap kendaraan memiliki operator yang bertanggung jawab.\n\n"
                . "**Membuat jadwal:**\n"
                . "1. Buka **Drivers → Scheduler**.\n"
                . "2. Pilih tampilan kalender mingguan atau bulanan.\n"
                . "3. Drag & drop driver ke slot kendaraan pada tanggal yang diinginkan.\n"
                . "4. Sistem akan memvalidasi: driver tidak double-booked, SIM masih berlaku, dan driver tidak melebihi jam kerja maksimum.\n\n"
                . "**Assignment mendadak:**\n"
                . "Gunakan **Quick Assign** untuk menugaskan driver ke kendaraan saat ini. Pilih driver dari daftar yang tersedia (tidak sedang bertugas) dan klik **Assign Now**.\n\n"
                . "Perubahan assignment akan tercatat di log untuk audit.",
            'tags'           => json_encode(['penjadwalan', 'assignment', 'driver', 'shift']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Monitoring Kinerja Driver',
            'content'        => "Dashboard kinerja driver memberikan gambaran menyeluruh performa setiap pengemudi.\n\n"
                . "**Metrik yang dipantau:**\n"
                . "- Total jarak tempuh (km/bulan)\n"
                . "- Jam kerja efektif\n"
                . "- Konsumsi BBM (km/liter)\n"
                . "- Skor keselamatan (safety score)\n"
                . "- Jumlah pelanggaran (over-speed, geofence, dll.)\n"
                . "- Rating dari customer (jika aplikasi customer tersedia)\n\n"
                . "**Cara akses:**\n"
                . "1. Buka **Drivers → Performance**.\n"
                . "2. Pilih driver dari daftar atau gunakan search.\n"
                . "3. Dashboard menampilkan KPI card, grafik tren, dan perbandingan dengan rata-rata armada.\n"
                . "4. Klik **Export** untuk mengunduh laporan kinerja individu.\n\n"
                . "Data ini dapat digunakan sebagai dasar pemberian insentif dan evaluasi berkala.",
            'tags'           => json_encode(['kinerja', 'driver', 'KPI', 'evaluasi']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── SAP B1 Integration ──
        [
            'title'          => 'Integrasi SAP B1 dengan ArkFleet',
            'content'        => "ArkFleet terintegrasi dengan SAP Business One (SAP B1) untuk sinkronisasi data keuangan dan operasional.\n\n"
                . "**Data yang disinkronkan:**\n"
                . "- Data kendaraan sebagai **Fixed Asset** di SAP B1\n"
                . "- Biaya BBM → **Purchase Invoice**\n"
                . "- Biaya maintenance → **Service PO**\n"
                . "- Biaya operasional → **Journal Entry**\n\n"
                . "**Prasyarat integrasi:**\n"
                . "1. SAP B1 Service Layer telah diaktifkan (versi 9.3+).\n"
                . "2. Kredensial Service Layer (URL, username, password) telah dikonfigurasi di ArkFleet **Settings → Integrations → SAP B1**.\n"
                . "3. Chart of Account dan Business Partner telah disiapkan untuk mapping.\n"
                . "4. Test koneksi berhasil (tombol **Test Connection**).\n\n"
                . "Hubungi tim IT jika koneksi gagal atau membutuhkan bantuan mapping data.",
            'tags'           => json_encode(['SAP B1', 'integrasi', 'sinkronisasi', 'keuangan']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Sinkronisasi Data Keuangan ke SAP B1',
            'content'        => "Data biaya operasional armada otomatis tersinkronisasi ke SAP B1 untuk pencatatan akuntansi.\n\n"
                . "**Proses sinkronisasi:**\n"
                . "1. ArkFleet menjalankan sinkronisasi otomatis setiap jam via background job.\n"
                . "2. Data BBM, maintenance, dan biaya lainnya dikelompokkan per cost center.\n"
                . "3. SAP B1 menerima data sebagai Journal Entry atau Purchase Invoice sesuai mapping.\n\n"
                . "**Cek status sinkronisasi:**\n"
                . "Buka **Settings → Integrations → Sync Log**. Log menampilkan:\n"
                . "- Waktu sinkronisasi terakhir\n"
                . "- Jumlah record berhasil/gagal\n"
                . "- Error detail untuk record gagal\n\n"
                . "**Re-sync manual:**\n"
                . "Untuk record yang gagal, klik **Retry** pada baris yang bermasalah. Jika error berulang, periksa mapping data atau hubungi support.",
            'tags'           => json_encode(['SAP B1', 'sinkronisasi', 'keuangan', 'journal']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Maintenance ──
        [
            'title'          => 'Mengelola Data Service dan Maintenance Kendaraan',
            'content'        => "Catat setiap aktivitas perawatan kendaraan agar riwayat service tercatat rapi.\n\n"
                . "**Cara mencatat service:**\n"
                . "1. Buka **Maintenance → Catat Service**.\n"
                . "2. Pilih kendaraan dan jenis service (rutin/berkala, perbaikan, ganti komponen).\n"
                . "3. Masukkan: bengkel, deskripsi pekerjaan, biaya, km saat service, dan tanggal.\n"
                . "4. Upload foto/invoice sebagai lampiran.\n"
                . "5. Klik **Simpan**.\n\n"
                . "**Riwayat maintenance:**\n"
                . "Buka **Maintenance → History** untuk melihat seluruh riwayat per kendaraan: tanggal, km, jenis service, biaya, dan bengkel.\n\n"
                . "Riwayat ini membantu menghitung TCO (Total Cost of Ownership) dan menentukan waktu ganti kendaraan.",
            'tags'           => json_encode(['maintenance', 'service', 'riwayat', 'bengkel']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Pengingat Maintenance Berkala',
            'content'        => "ArkFleet mengirimkan pengingat otomatis untuk perawatan berkala berdasarkan km atau waktu.\n\n"
                . "**Mengatur interval maintenance:**\n"
                . "1. Buka **Settings → Maintenance Schedule**.\n"
                . "2. Untuk setiap tipe kendaraan, tentukan interval:\n"
                . "   - Ganti oli: setiap 5.000 km atau 3 bulan\n"
                . "   - Service besar: setiap 20.000 km atau 6 bulan\n"
                . "   - Ganti ban: setiap 40.000 km\n"
                . "   - Dan seterusnya.\n"
                . "3. Aktifkan notifikasi via Telegram/email.\n\n"
                . "Sistem akan mengirimkan alert **3 hari sebelum** dan **pada hari H** jatuh tempo. Dashboard Maintenance menampilkan status warna:\n"
                . "- 🟢 Hijau: masih aman\n"
                . "- 🟡 Kuning: mendekati jatuh tempo\n"
                . "- 🔴 Merah: terlambat",
            'tags'           => json_encode(['maintenance', 'pengingat', 'berkala', 'notifikasi']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Notifikasi Kendaraan Bermasalah dan Breakdown',
            'content'        => "Ketika kendaraan mengalami masalah di lapangan, driver dapat mengirimkan laporan darurat.\n\n"
                . "**Prosedur pelaporan breakdown:**\n"
                . "1. Driver membuka aplikasi mobile ArkFleet dan menekan tombol **SOS/Breakdown**.\n"
                . "2. Isi jenis masalah: mesin mati, ban kempes, kecelakaan, atau lainnya.\n"
                . "3. Sistem otomatis mengambil lokasi GPS terkini.\n"
                . "4. Notifikasi dikirim ke supervisor dan tim mekanik.\n\n"
                . "**Response workflow:**\n"
                . "- Supervisor menerima notifikasi dan dapat langsung menugaskan tim mekanik\n"
                . "- Status perbaikan dapat dipantau di dashboard (Reported → In Progress → Resolved)\n"
                . "- Setelah selesai, mekanik mengisi laporan perbaikan\n\n"
                . "Riwayat breakdown tersimpan untuk analisis keandalan kendaraan.",
            'tags'           => json_encode(['breakdown', 'notifikasi', 'darurat', 'SOS']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Reports & Export ──
        [
            'title'          => 'Cara Generate Laporan Operasional',
            'content'        => "ArkFleet menyediakan berbagai laporan operasional siap pakai.\n\n"
                . "**Jenis laporan yang tersedia:**\n"
                . "- **Trip Report** — detail perjalanan per kendaraan\n"
                . "- **Fuel Report** — konsumsi dan biaya BBM\n"
                . "- **Driver Performance** — KPI driver\n"
                . "- **Maintenance Cost** — biaya perawatan\n"
                . "- **Geofence Violation** — pelanggaran zona\n"
                . "- **Operational Summary** — ringkasan semua metrik\n\n"
                . "**Cara generate:**\n"
                . "1. Buka **Reports** dan pilih jenis laporan.\n"
                . "2. Atur filter: tanggal, kendaraan, driver, grup.\n"
                . "3. Pilih format output: PDF, Excel, atau CSV.\n"
                . "4. Klik **Generate**. Laporan dapat langsung diunduh atau dijadwalkan pengiriman otomatis via email setiap minggu/bulan.",
            'tags'           => json_encode(['laporan', 'operasional', 'PDF', 'Excel']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Ekspor Data ke Excel dan PDF',
            'content'        => "Semua data di ArkFleet dapat diekspor untuk analisis lebih lanjut atau pelaporan eksternal.\n\n"
                . "**Opsi ekspor:**\n"
                . "- **Excel (.xlsx):** Data mentah dengan format tabel — cocok untuk pivot table dan analisis lanjutan.\n"
                . "- **PDF:** Laporan terformat dengan header, logo perusahaan, dan ringkasan — cocok untuk presentasi ke manajemen.\n"
                . "- **CSV:** Format ringan untuk import ke sistem lain.\n\n"
                . "**Cara ekspor dari tabel mana pun:**\n"
                . "1. Di halaman data (misalnya daftar kendaraan), klik tombol **Export** di pojok kanan atas.\n"
                . "2. Pilih format dan centang kolom yang ingin disertakan.\n"
                . "3. Untuk PDF, pilih template laporan.\n"
                . "4. Klik **Download**.\n\n"
                . "**Auto-export:** Beberapa laporan dapat dijadwalkan pengiriman otomatis via email di menu **Settings → Scheduled Reports**.",
            'tags'           => json_encode(['ekspor', 'Excel', 'PDF', 'download']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Troubleshooting GPS Tidak Akurat',
            'content'        => "Jika posisi kendaraan di peta tidak akurat atau tidak muncul, lakukan langkah berikut:\n\n"
                . "**Penyebab umum:**\n"
                . "1. **Sinyal GPS lemah** — kendaraan di area tertutup (basement, terowongan, hutan lebat). Tunggu hingga kendaraan ke area terbuka.\n"
                . "2. **GPS tracker offline** — cek indikator LED pada perangkat. Jika mati, periksa koneksi daya.\n"
                . "3. **Kartu SIM tidak aktif/habis pulsa** — hubungi provider seluler.\n"
                . "4. **Antena GPS rusak** — perlu penggantian, hubungi vendor GPS.\n\n"
                . "**Cek di ArkFleet:**\n"
                . "- **Settings → Devices:** periksa status koneksi dan Last Seen.\n"
                . "- **Live Track:** jika Last Seen > 1 jam, perangkat kemungkinan offline.\n"
                . "- **Raw Data:** periksa data mentah GPS apakah koordinat bernilai 0,0 (indikasi GPS belum lock).\n\n"
                . "Jika semua sudah diperiksa dan posisi tetap tidak akurat, hubungi support dengan menyertakan nomor IMEI tracker.",
            'tags'           => json_encode(['troubleshooting', 'GPS', 'akurat', 'tracker']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
    ],

    // =========================================================================
    // APP 4: VASIA POS — Cashier, Products, Sales Reports, Inventory
    // =========================================================================
    4 => [
        // ── Cashier ──
        [
            'title'          => 'Cara Membuka dan Menutup Shift Kasir',
            'content'        => "Setiap kasir wajib membuka shift saat mulai bertugas dan menutup shift saat selesai.\n\n"
                . "**Membuka shift:**\n"
                . "1. Login ke VASIA POS dengan akun kasir Anda.\n"
                . "2. Pada halaman utama, klik tombol **Buka Shift**.\n"
                . "3. Masukkan jumlah saldo awal kas (cash float), misalnya Rp 500.000.\n"
                . "4. Klik **Mulai Shift**. Status shift akan berubah menjadi **Aktif**.\n\n"
                . "**Menutup shift:**\n"
                . "1. Klik tombol **Tutup Shift** di pojok kanan atas.\n"
                . "2. Sistem menampilkan ringkasan shift: total transaksi, total tunai, total non-tunai, dan selisih kas.\n"
                . "3. Hitung fisik uang di laci dan masukkan jumlah aktual.\n"
                . "4. Jika ada selisih, catat alasannya di kolom keterangan.\n"
                . "5. Klik **Tutup Shift**. Laporan shift akan tercetak otomatis.\n\n"
                . "Shift tidak dapat ditutup jika masih ada transaksi tertunda (pending).",
            'tags'           => json_encode(['kasir', 'shift', 'buka', 'tutup']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Panduan Transaksi Penjualan Cepat',
            'content'        => "Berikut langkah-langkah melakukan transaksi penjualan di VASIA POS:\n\n"
                . "1. **Cari produk:** Gunakan barcode scanner atau ketik nama/kode produk di kolom pencarian.\n"
                . "2. **Tambah ke keranjang:** Klik produk atau tekan Enter. Sesuaikan quantity jika perlu.\n"
                . "3. **Terapkan diskon (opsional):** Klik ikon diskon di baris produk, pilih tipe (persentase/nominal), masukkan nilai.\n"
                . "4. **Pilih pelanggan (opsional):** Klik **Tambah Pelanggan** untuk mencatat transaksi atas nama pelanggan tertentu.\n"
                . "5. **Proses pembayaran:** Klik tombol **Bayar**. Pilih metode: Tunai, Debit, Kredit, QRIS, atau Transfer.\n"
                . "6. **Untuk tunai:** Masukkan jumlah yang diterima, sistem otomatis menghitung kembalian.\n"
                . "7. Klik **Selesaikan**. Struk akan tercetak dan stok otomatis berkurang.\n\n"
                . "**Shortcut keyboard:** F2 (cari), F4 (bayar), F8 (tahan transaksi), Esc (batal).",
            'tags'           => json_encode(['transaksi', 'penjualan', 'kasir', 'pembayaran']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Proses Refund dan Retur Barang',
            'content'        => "Retur dan refund dapat dilakukan jika pelanggan mengembalikan barang sesuai kebijakan toko.\n\n"
                . "**Syarat retur:**\n"
                . "- Barang dalam kondisi baik dan belum digunakan\n"
                . "- Struk asli tersedia\n"
                . "- Dalam periode retur (default 7 hari, dapat diubah di Settings)\n\n"
                . "**Langkah-langkah:**\n"
                . "1. Buka **Transaksi → Retur/Refund**.\n"
                . "2. Cari transaksi asli dengan scan barcode struk atau masukkan nomor invoice.\n"
                . "3. Pilih item yang diretur dan jumlahnya.\n"
                . "4. Pilih aksi: **Refund penuh** (uang kembali), **Tukar barang**, atau **Store credit**.\n"
                . "5. Klik **Proses**. Sistem akan:\n"
                . "   - Mengembalikan stok barang\n"
                . "   - Mencatat retur di laporan\n"
                . "   - Mencetak nota retur\n\n"
                . "Perhatian: Akses retur biasanya dibatasi untuk supervisor atau admin.",
            'tags'           => json_encode(['refund', 'retur', 'pengembalian', 'barang']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Diskon dan Voucher Belanja',
            'content'        => "VASIA POS mendukung berbagai jenis diskon dan voucher.\n\n"
                . "**Jenis diskon yang tersedia:**\n"
                . "- **Diskon per item:** diterapkan langsung di keranjang pada produk tertentu\n"
                . "- **Diskon total transaksi:** persentase atau nominal dari total belanja\n"
                . "- **Diskon otomatis:** berdasarkan quantity (beli 2 gratis 1), member, atau periode promo\n\n"
                . "**Membuat voucher:**\n"
                . "1. Buka **Produk → Voucher**.\n"
                . "2. Klik **Buat Voucher Baru**.\n"
                . "3. Isi: kode voucher, tipe diskon (persen/nominal), nilai, minimal pembelian, maksimal diskon, periode berlaku, dan kuota.\n"
                . "4. Klik **Simpan**. Voucher siap digunakan.\n\n"
                . "**Menggunakan voucher:**\n"
                . "Di halaman pembayaran, masukkan kode voucher di kolom **Kode Promo** dan klik **Terapkan**.",
            'tags'           => json_encode(['diskon', 'voucher', 'promo', 'potongan']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Products ──
        [
            'title'          => 'Menambahkan Produk Baru ke Katalog',
            'content'        => "Tambah produk baru dengan mudah melalui menu manajemen produk.\n\n"
                . "**Langkah-langkah:**\n"
                . "1. Buka **Produk → Tambah Produk**.\n"
                . "2. Isi data wajib:\n"
                . "   - **Kode/SKU:** Otomatis atau masukkan manual (harus unik)\n"
                . "   - **Nama produk:** Nama lengkap yang akan muncul di struk\n"
                . "   - **Kategori:** Pilih dari daftar atau buat baru\n"
                . "   - **Harga jual:** Harga eceran\n"
                . "   - **Harga beli:** Harga modal (untuk perhitungan margin)\n"
                . "   - **Stok awal:** Jumlah stok saat ini\n"
                . "3. Data opsional: barcode, satuan (pcs/kg/liter), harga grosir (minimal quantity), supplier, gambar produk, dan catatan.\n"
                . "4. Klik **Simpan**. Produk langsung tersedia di kasir.\n\n"
                . "**Import massal:** Gunakan **Produk → Import CSV** untuk menambahkan banyak produk. Unduh template CSV dari halaman tersebut.",
            'tags'           => json_encode(['produk', 'katalog', 'tambah', 'SKU']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Mengelola Kategori dan Grup Produk',
            'content'        => "Kategori membantu mengorganisir produk agar mudah dicari dan dilaporkan.\n\n"
                . "**Membuat kategori:**\n"
                . "1. Buka **Produk → Kategori**.\n"
                . "2. Klik **Tambah Kategori**.\n"
                . "3. Isi nama kategori (contoh: Makanan, Minuman, ATK, Elektronik).\n"
                . "4. Pilih kategori induk jika ingin membuat sub-kategori (contoh: Minuman → Minuman Dingin, Minuman Panas).\n"
                . "5. Klik **Simpan**.\n\n"
                . "**Grup produk (opsional):**\n"
                . "Grup produk berguna untuk:\n"
                . "- Menu combo/paket hemat\n"
                . "- Produk dengan variasi (ukuran, warna)\n"
                . "- Bundling produk\n\n"
                . "Produk yang belum dikategorikan akan masuk ke **Uncategorized**. Disarankan untuk segera mengkategorikan semua produk.",
            'tags'           => json_encode(['kategori', 'produk', 'grup', 'organisir']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Mengatur Harga Grosir dan Harga Eceran',
            'content'        => "VASIA POS mendukung multi-tier pricing: harga eceran, grosir, dan harga khusus pelanggan.\n\n"
                . "**Mengatur harga grosir:**\n"
                . "1. Buka **Produk** dan pilih produk yang ingin diatur.\n"
                . "2. Klik tab **Harga**.\n"
                . "3. Di bagian **Harga Grosir**, klik **Tambah Tier**.\n"
                . "4. Masukkan:\n"
                . "   - Minimal quantity (contoh: 10 pcs)\n"
                . "   - Harga per unit\n"
                . "   - Nama tier (contoh: Grosir Kecil, Grosir Besar)\n"
                . "5. Anda dapat menambahkan beberapa tier untuk quantity berbeda.\n"
                . "6. Klik **Simpan**.\n\n"
                . "Saat transaksi di kasir, jika quantity memenuhi syarat tier grosir, harga otomatis menyesuaikan.\n\n"
                . "**Harga khusus pelanggan:** Untuk pelanggan tertentu, tetapkan harga khusus di menu **Pelanggan → Detail → Harga Khusus**.",
            'tags'           => json_encode(['harga', 'grosir', 'eceran', 'tier']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Inventory ──
        [
            'title'          => 'Stok Opname dan Penyesuaian Inventory',
            'content'        => "Stok opname (stocktake) adalah proses penghitungan fisik stok untuk memastikan kesesuaian antara sistem dan lapangan.\n\n"
                . "**Prosedur stok opname:**\n"
                . "1. Buka **Inventory → Stok Opname**.\n"
                . "2. Klik **Buat Sesi Opname**. Beri nama dan pilih kategori/gudang yang akan dihitung.\n"
                . "3. Sistem membekukan pergerakan stok untuk produk yang sedang di-opname.\n"
                . "4. Tim gudang menghitung fisik stok dan memasukkan jumlah aktual ke dalam form.\n"
                . "5. Sistem menampilkan selisih (fisik vs sistem).\n"
                . "6. Supervisor mereview selisih dan klik **Approve & Adjust** untuk memperbarui stok sistem.\n\n"
                . "**Catatan:** Sesi opname hanya bisa di-approve oleh user dengan role supervisor atau admin. Seluruh penyesuaian tercatat di log audit.",
            'tags'           => json_encode(['stok opname', 'inventory', 'stocktake', 'penyesuaian']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Alert Stok Menipis dan Reorder Point',
            'content'        => "VASIA POS memberikan notifikasi otomatis saat stok produk mendekati habis.\n\n"
                . "**Mengatur reorder point:**\n"
                . "1. Buka **Produk** dan pilih produk.\n"
                . "2. Di tab **Inventory**, masukkan:\n"
                . "   - **Stok Minimum:** Level stok yang memicu alert (contoh: 10 pcs)\n"
                . "   - **Reorder Quantity:** Jumlah yang disarankan saat restock (contoh: 50 pcs)\n"
                . "3. Klik **Simpan**.\n\n"
                . "**Dashboard alert stok:**\n"
                . "1. Buka **Inventory → Alert Stok**.\n"
                . "2. Tampilan menunjukkan produk dalam status:\n"
                . "   - 🔴 Kritis (stok 0 atau di bawah minimum)\n"
                . "   - 🟡 Peringatan (stok mendekati minimum)\n"
                . "3. Klik **Buat PO** langsung dari halaman alert untuk membuat purchase order ke supplier.\n\n"
                . "Notifikasi juga dapat dikirim via Telegram ke admin setiap pagi.",
            'tags'           => json_encode(['alert', 'stok', 'reorder', 'notifikasi']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Transfer Stok Antar Cabang atau Gudang',
            'content'        => "Untuk bisnis multi-cabang, VASIA POS mendukung transfer stok antar lokasi.\n\n"
                . "**Membuat transfer stok:**\n"
                . "1. Buka **Inventory → Transfer Stok**.\n"
                . "2. Klik **Transfer Baru**.\n"
                . "3. Pilih:\n"
                . "   - Gudang/Cabang asal\n"
                . "   - Gudang/Cabang tujuan\n"
                . "   - Produk dan jumlah yang ditransfer\n"
                . "4. Klik **Kirim**. Status transfer: **Dalam Perjalanan**.\n\n"
                . "**Menerima transfer:**\n"
                . "1. Cabang tujuan membuka **Inventory → Transfer Masuk**.\n"
                . "2. Pilih transfer yang sedang dalam perjalanan.\n"
                . "3. Verifikasi fisik barang, masukkan jumlah diterima (jika ada selisih, catat alasan).\n"
                . "4. Klik **Terima**. Stok cabang tujuan bertambah, stok cabang asal berkurang.\n\n"
                . "Seluruh riwayat transfer tercatat untuk audit.",
            'tags'           => json_encode(['transfer', 'stok', 'cabang', 'gudang']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Sales Reports ──
        [
            'title'          => 'Laporan Penjualan Harian',
            'content'        => "Laporan penjualan harian merangkum performa toko dalam satu hari.\n\n"
                . "**Cara akses:**\n"
                . "1. Buka **Laporan → Penjualan Harian**.\n"
                . "2. Pilih tanggal. Default menampilkan hari ini.\n"
                . "3. Klik **Tampilkan**.\n\n"
                . "**Isi laporan:**\n"
                . "- Total transaksi dan total pendapatan\n"
                . "- Breakdown per metode pembayaran (tunai, debit, kredit, QRIS)\n"
                . "- Jumlah item terjual\n"
                . "- Rata-rata nilai transaksi\n"
                . "- Shift summary (per kasir)\n"
                . "- Grafik penjualan per jam\n\n"
                . "Laporan dapat dicetak atau diekspor ke Excel. Gunakan fitur **Rekap Mingguan** untuk melihat tren 7 hari terakhir.",
            'tags'           => json_encode(['laporan', 'penjualan', 'harian', 'rekap']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Laporan Penjualan Bulanan dan Tahunan',
            'content'        => "Laporan periode panjang digunakan untuk analisis tren dan pelaporan ke manajemen.\n\n"
                . "**Laporan bulanan:**\n"
                . "1. Buka **Laporan → Penjualan Bulanan**.\n"
                . "2. Pilih bulan dan tahun.\n"
                . "3. Filter per cabang (jika multi-cabang).\n"
                . "4. Tampilan meliputi: total pendapatan, total transaksi, perbandingan bulan ini vs bulan lalu (growth %), dan top 10 produk terlaris.\n\n"
                . "**Laporan tahunan:**\n"
                . "Menampilkan grafik 12 bulan dalam satu layar untuk melihat siklus musiman, peak season, dan slow season.\n\n"
                . "**Fitur perbandingan:**\n"
                . "Gunakan **Compare Mode** untuk membandingkan bulan atau tahun yang berbeda secara side-by-side. Ini membantu evaluasi pertumbuhan dan efektivitas promosi.",
            'tags'           => json_encode(['laporan', 'penjualan', 'bulanan', 'tahunan']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Laporan Produk Terlaris dan Analisis Penjualan',
            'content'        => "Identifikasi produk mana yang paling laku dan paling menguntungkan.\n\n"
                . "**Laporan Produk Terlaris:**\n"
                . "1. Buka **Laporan → Produk Terlaris**.\n"
                . "2. Pilih periode (hari ini, mingguan, bulanan, kustom).\n"
                . "3. Urutkan berdasarkan: quantity terjual, pendapatan, atau margin keuntungan.\n\n"
                . "**Analisis lanjutan:**\n"
                . "- **ABC Analysis:** Klasifikasi produk A (top 20% kontribusi), B (30%), C (50% bawah)\n"
                . "- **Product Affinity:** Produk yang sering dibeli bersamaan (market basket analysis)\n"
                . "- **Slow Moving:** Produk yang jarang terjual dalam 30 hari terakhir\n\n"
                . "Gunakan insight ini untuk: optimalisasi stok, keputusan diskon, dan perencanaan purchase order.",
            'tags'           => json_encode(['laporan', 'terlaris', 'analisis', 'produk']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Analisis Margin dan Keuntungan',
            'content'        => "VASIA POS menghitung margin keuntungan secara real-time untuk setiap produk dan transaksi.\n\n"
                . "**Melihat margin:**\n"
                . "1. **Per produk:** Harga jual dikurangi harga beli. Margin % = (Harga Jual - Harga Beli) / Harga Jual × 100%.\n"
                . "2. **Per transaksi:** Total penjualan dikurangi total harga beli semua item.\n"
                . "3. **Per periode:** Buka **Laporan → Margin Analysis**.\n\n"
                . "**Dashboard profit:**\n"
                . "Buka **Dashboard → Profit** untuk melihat:\n"
                . "- Gross profit harian, mingguan, bulanan\n"
                . "- Margin rata-rata per kategori\n"
                . "- Produk dengan margin tertinggi dan terendah\n"
                . "- Trend profitabilitas\n\n"
                . "**Tips:** Pastikan harga beli (harga modal) selalu diperbarui saat ada perubahan harga dari supplier agar kalkulasi margin akurat.",
            'tags'           => json_encode(['margin', 'keuntungan', 'profit', 'analisis']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Manajemen Supplier dan Purchase Order',
            'content'        => "Kelola data supplier dan proses pembelian stok dengan fitur purchase order.\n\n"
                . "**Menambahkan supplier:**\n"
                . "1. Buka **Supplier → Tambah Supplier**.\n"
                . "2. Isi: nama perusahaan, kontak person, telepon, alamat, NPWP, dan payment terms.\n"
                . "3. Tetapkan produk yang disuplai oleh supplier ini.\n\n"
                . "**Membuat purchase order (PO):**\n"
                . "1. Buka **Inventory → Purchase Order**.\n"
                . "2. Klik **Buat PO Baru**.\n"
                . "3. Pilih supplier, tambahkan produk dan quantity (bisa dari alert stok menipis).\n"
                . "4. Konfirmasi harga dan total.\n"
                . "5. Klik **Kirim PO** — status menjadi **Menunggu Pengiriman**.\n\n"
                . "**Menerima barang:**\n"
                . "Saat barang datang, buka PO tersebut dan klik **Terima Barang**. Verifikasi quantity dan klik **Konfirmasi**. Stok otomatis bertambah.",
            'tags'           => json_encode(['supplier', 'purchase order', 'PO', 'pembelian']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Payment & Security ──
        [
            'title'          => 'Integrasi dengan Payment Gateway',
            'content'        => "VASIA POS mendukung integrasi dengan berbagai payment gateway untuk pembayaran non-tunai.\n\n"
                . "**Payment gateway yang didukung:**\n"
                . "- Midtrans (Snap & Core API)\n"
                . "- Xendit\n"
                . "- DOKU\n"
                . "- QRIS (via Midtrans/Xendit)\n\n"
                . "**Aktivasi payment gateway:**\n"
                . "1. Buka **Settings → Pembayaran → Payment Gateway**.\n"
                . "2. Pilih provider dan klik **Aktifkan**.\n"
                . "3. Masukkan API Key/Server Key dari dashboard provider.\n"
                . "4. Klik **Test Koneksi** untuk verifikasi.\n"
                . "5. Simpan.\n\n"
                . "**Penggunaan di kasir:**\n"
                . "Saat pembayaran, pilih metode non-tunai. Untuk QRIS, sistem menampilkan QR code yang bisa discan pelanggan. Status pembayaran terpantau real-time.",
            'tags'           => json_encode(['payment gateway', 'Midtrans', 'QRIS', 'integrasi']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Cetak Struk, Faktur, dan Nota',
            'content'        => "VASIA POS mendukung berbagai format cetakan sesuai kebutuhan bisnis.\n\n"
                . "**Jenis cetakan:**\n"
                . "- **Struk thermal (58mm/80mm):** Untuk printer thermal standar — ringkas, cocok untuk retail.\n"
                . "- **Faktur A4:** Untuk pelanggan bisnis yang membutuhkan faktur pajak.\n"
                . "- **Nota kontan:** Format sederhana dengan kop toko.\n\n"
                . "**Konfigurasi printer:**\n"
                . "1. Buka **Settings → Hardware → Printer**.\n"
                . "2. Pilih tipe printer: Thermal USB, Thermal Bluetooth, atau Printer A4.\n"
                . "3. Atur ukuran kertas, margin, dan logo toko.\n"
                . "4. Klik **Test Print** untuk memastikan.\n\n"
                . "**Cetak ulang:**\n"
                . "Untuk mencetak ulang struk transaksi lama, buka **Transaksi → Riwayat**, cari transaksi, dan klik **Cetak Ulang**.",
            'tags'           => json_encode(['struk', 'faktur', 'cetak', 'printer']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Backup Data dan Keamanan Sistem',
            'content'        => "Keamanan data adalah prioritas. VASIA POS menyediakan fitur backup dan proteksi akses.\n\n"
                . "**Backup otomatis:**\n"
                . "1. Buka **Settings → System → Backup**.\n"
                . "2. Aktifkan **Auto Backup** dan atur frekuensi: setiap jam, harian, atau mingguan.\n"
                . "3. Pilih penyimpanan: lokal, cloud (Google Drive), atau server FTP.\n"
                . "4. Sistem akan otomatis membuat backup database.\n\n"
                . "**Backup manual:**\n"
                . "Klik **Backup Sekarang** untuk membuat backup instan kapan saja.\n\n"
                . "**Keamanan akses:**\n"
                . "- **Role-based access:** Kasir hanya bisa transaksi, Supervisor bisa retur dan stok opname, Admin akses penuh.\n"
                . "- **Audit log:** Semua aktivitas user tercatat di **Settings → Audit Log**.\n"
                . "- **2FA:** Aktifkan Two-Factor Authentication di **Settings → Keamanan**.\n\n"
                . "**Jika data hilang:** Gunakan fitur **Restore** dari file backup terbaru.",
            'tags'           => json_encode(['backup', 'keamanan', 'restore', 'audit']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
    ],

    // =========================================================================
    // APP 5: Pratasaba Resort — Room Booking, Guest Management, Billing,
    //         Housekeeping
    // =========================================================================
    5 => [
        // ── Room Booking ──
        [
            'title'          => 'Cara Membuat Reservasi Kamar',
            'content'        => "Reservasi dapat dibuat melalui front desk atau online booking engine.\n\n"
                . "**Dari front desk:**\n"
                . "1. Buka menu **Reservasi → Buat Reservasi**.\n"
                . "2. Pilih tipe kamar (Standard, Deluxe, Suite, dll.) dan jumlah tamu.\n"
                . "3. Pilih tanggal check-in dan check-out.\n"
                . "4. Sistem otomatis menampilkan kamar yang tersedia. Pilih nomor kamar atau biarkan sistem memilihkan (auto-assign).\n"
                . "5. Isi data tamu: nama, nomor identitas (KTP/paspor), nomor telepon, email.\n"
                . "6. Pilih payment terms: full payment, deposit, atau pay at check-in.\n"
                . "7. Klik **Simpan Reservasi**. Status: **Confirmed**.\n\n"
                . "**Konfirmasi ke tamu:**\n"
                . "Klik **Kirim Konfirmasi** untuk mengirim email/WhatsApp berisi detail reservasi dan booking ID.",
            'tags'           => json_encode(['reservasi', 'booking', 'kamar', 'check-in']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Proses Check-In dan Check-Out Tamu',
            'content'        => "Prosedur check-in dan check-out yang lancar meningkatkan kepuasan tamu.\n\n"
                . "**Check-in:**\n"
                . "1. Di dashboard, klik **Check-In** atau cari reservasi berdasarkan nama/booking ID.\n"
                . "2. Verifikasi identitas tamu (KTP/paspor).\n"
                . "3. Lengkapi data jika ada yang kurang:plat kendaraan, jumlah tamu aktual.\n"
                . "4. Klik **Check-In**. Status reservasi berubah menjadi **In-House**.\n"
                . "5. Kunci kamar (jika terintegrasi keycard) otomatis diaktifkan.\n\n"
                . "**Check-out:**\n"
                . "1. Buka **Front Desk → Check-Out**.\n"
                . "2. Cari tamu berdasarkan nomor kamar atau nama.\n"
                . "3. Review tagihan: room charge, room service, laundry, minibar, dll.\n"
                . "4. Selesaikan pembayaran jika masih ada tagihan.\n"
                . "5. Klik **Check-Out**. Status berubah menjadi **Checked Out**.\n"
                . "6. Kamar otomatis masuk ke status **Dirty** untuk housekeeping.",
            'tags'           => json_encode(['check-in', 'check-out', 'tamu', 'front desk']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Mengelola Ketersediaan Kamar dan Room Inventory',
            'content'        => "Dashboard ketersediaan kamar memberikan gambaran real-time okupansi hotel.\n\n"
                . "**Melihat ketersediaan:**\n"
                . "Buka **Front Desk → Room Plan**. Tampilan grid warna:\n"
                . "- 🟢 Hijau: Tersedia\n"
                . "- 🔵 Biru: Dipesan (reserved)\n"
                . "- 🟠 Oranye: Terisi (occupied)\n"
                . "- 🔴 Merah: Kotor/Maintenance\n\n"
                . "**Out of Order / Out of Service:**\n"
                . "Jika kamar tidak bisa digunakan, klik kanan pada kamar dan pilih **Set Out of Order**. Masukkan alasan dan perkiraan durasi. Kamar tidak akan muncul di hasil pencarian reservasi.\n\n"
                . "**Overbooking protection:**\n"
                . "Sistem mencegah double-booking. Jika tipe kamar habis, akan muncul peringatan dan saran tipe kamar alternatif.",
            'tags'           => json_encode(['ketersediaan', 'kamar', 'room plan', 'okupansi']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Room Rate dan Seasonal Pricing',
            'content'        => "Atur harga kamar fleksibel berdasarkan musim, hari, atau event khusus.\n\n"
                . "**Membuat rate plan:**\n"
                . "1. Buka **Settings → Rate Plan**.\n"
                . "2. Klik **Tambah Rate Plan**.\n"
                . "3. Pilih tipe kamar dan tentukan:\n"
                . "   - **Base Rate:** Harga dasar per malam\n"
                . "   - **Weekend Rate:** Harga khusus Jumat-Minggu\n"
                . "   - **Seasonal Rates:** Harga musim liburan, Lebaran, Natal/Tahun Baru\n"
                . "   - **Promo Rate:** Harga diskon untuk periode promo tertentu\n"
                . "4. Atur tanggal berlaku untuk setiap rate.\n"
                . "5. Klik **Simpan**.\n\n"
                . "**Derived rates:**\n"
                . "Gunakan fitur **Derived Rate** untuk otomatis menghitung harga berdasarkan base rate + persentase (contoh: single occupancy = base, double = base + 30%).",
            'tags'           => json_encode(['harga', 'kamar', 'seasonal', 'rate plan']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Guest Management ──
        [
            'title'          => 'Manajemen Data Tamu dan Profil',
            'content'        => "Pratasaba Resort menyimpan profil tamu lengkap untuk pengalaman yang lebih personal.\n\n"
                . "**Data yang disimpan:**\n"
                . "- Informasi dasar: nama, alamat, telepon, email, tanggal lahir\n"
                . "- Dokumen identitas: KTP/paspor (nomor, masa berlaku, kewarganegaraan)\n"
                . "- Preferensi: tipe kamar favorit, lantai, alergi makanan, smoking/non-smoking\n"
                . "- Riwayat menginap: kunjungan sebelumnya, total spending\n"
                . "- Membership tier (jika ada program loyalitas)\n\n"
                . "**Mengakses profil tamu:**\n"
                . "1. Buka **Tamu → Daftar Tamu**.\n"
                . "2. Gunakan kolom pencarian (nama, email, nomor telepon).\n"
                . "3. Klik nama tamu untuk membuka profil lengkap.\n"
                . "4. Tab **Riwayat** menampilkan seluruh kunjungan sebelumnya.\n\n"
                . "Profil tamu terintegrasi dengan modul reservasi — saat tamu return dipilih, data otomatis terisi.",
            'tags'           => json_encode(['tamu', 'profil', 'data', 'preferensi']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Booking Online via Website',
            'content'        => "Booking engine online memungkinkan tamu memesan kamar langsung dari website resort.\n\n"
                . "**Setup booking engine:**\n"
                . "1. Buka **Settings → Booking Engine**.\n"
                . "2. Aktifkan **Enable Online Booking**.\n"
                . "3. Konfigurasi:\n"
                . "   - Ketersediaan yang ditampilkan (semua tipe atau pilihan)\n"
                . "   - Minimum/Maximum malam menginap\n"
                . "   - Advance booking window (maksimal berapa hari ke depan bisa dipesan)\n"
                . "   - Payment gateway untuk deposit online\n"
                . "4. Salin embed code atau link booking engine ke website Anda.\n\n"
                . "**Cara kerja:**\n"
                . "1. Tamu memilih tanggal, jumlah orang, dan tipe kamar di website.\n"
                . "2. Sistem menampilkan ketersediaan real-time dan harga.\n"
                . "3. Tamu mengisi data diri dan melakukan pembayaran deposit (jika diwajibkan).\n"
                . "4. Reservasi otomatis masuk ke dashboard Pratasaba Resort dengan status **Confirmed**.",
            'tags'           => json_encode(['booking', 'online', 'website', 'engine']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Pembatalan dan Refund Reservasi',
            'content'        => "Kebijakan pembatalan jelas melindungi revenue sekaligus menjaga hubungan dengan tamu.\n\n"
                . "**Mengatur cancellation policy:**\n"
                . "1. Buka **Settings → Cancellation Policy**.\n"
                . "2. Tentukan aturan:\n"
                . "   - Free cancellation hingga H-3 sebelum check-in\n"
                . "   - Cancellation H-2 s/d H-1: charge 50% dari total\n"
                . "   - No-show atau cancel hari H: charge 100%\n"
                . "3. Atur kebijakan refund deposit (full/partial/no refund).\n\n"
                . "**Memproses pembatalan:**\n"
                . "1. Buka reservasi yang akan dibatalkan.\n"
                . "2. Klik **Cancel Reservation**.\n"
                . "3. Pilih alasan pembatalan (guest request, force majeure, dll.).\n"
                . "4. Sistem otomatis menghitung cancellation fee berdasarkan policy.\n"
                . "5. Jika tamu berhak refund, klik **Proses Refund** untuk mengembalikan deposit.\n"
                . "6. Kamar kembali tersedia untuk dipesan.",
            'tags'           => json_encode(['pembatalan', 'refund', 'cancel', 'kebijakan']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Billing ──
        [
            'title'          => 'Pembayaran dan Billing Tamu',
            'content'        => "Modul billing mencatat semua tagihan tamu selama menginap.\n\n"
                . "**Komponen tagihan:**\n"
                . "- Room charge (otomatis setiap malam)\n"
                . "- Extra bed / additional person\n"
                . "- Room service dan minibar\n"
                . "- Laundry\n"
                . "- Spa dan fasilitas lainnya\n"
                . "- Pajak dan service charge\n\n"
                . "**Posting tagihan:**\n"
                . "1. Buka **Front Desk → Billing**.\n"
                . "2. Pilih nomor kamar atau nama tamu.\n"
                . "3. Klik **Post Charge**, pilih jenis tagihan, masukkan jumlah dan deskripsi.\n"
                . "4. Tagihan langsung muncul di folio tamu.\n\n"
                . "**Split bill:**\n"
                . "Jika tamu ingin bill terpisah (contoh: room A bayar, room B perusahaan), gunakan fitur **Split Folio** untuk memisahkan tagihan.",
            'tags'           => json_encode(['billing', 'pembayaran', 'tagihan', 'folio']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Invoice dan Laporan Keuangan',
            'content'        => "Pratasaba Resort menghasilkan invoice profesional untuk tamu dan laporan keuangan untuk manajemen.\n\n"
                . "**Membuat invoice:**\n"
                . "1. Saat check-out atau kapan saja, buka **Billing → Generate Invoice**.\n"
                . "2. Pilih format: invoice tamu (guest), invoice perusahaan (company), atau faktur pajak.\n"
                . "3. Tambahkan NPWP/NIK tamu jika diperlukan untuk faktur pajak.\n"
                . "4. Klik **Cetak** atau **Kirim via Email**.\n\n"
                . "**Laporan keuangan:**\n"
                . "- **Daily Revenue Report:** Ringkasan pendapatan harian\n"
                . "- **Occupancy & ADR:** Occupancy rate dan Average Daily Rate\n"
                . "- **Revenue by Department:** Breakdown per kamar, F&B, laundry, dll.\n"
                . "- **AR Aging:** Piutang yang belum dibayar (untuk corporate guest)\n"
                . "- **Tax Report:** Rekap pajak untuk pelaporan bulanan",
            'tags'           => json_encode(['invoice', 'laporan', 'keuangan', 'revenue']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Deposit dan Down Payment',
            'content'        => "Deposit adalah pembayaran di muka untuk menjamin reservasi. Berikut cara mengelolanya.\n\n"
                . "**Jenis deposit:**\n"
                . "- **Fixed amount:** Nominal tetap per reservasi (contoh: Rp 500.000)\n"
                . "- **Percentage:** Persentase dari total biaya menginap (contoh: 50%)\n"
                . "- **First night:** Biaya malam pertama\n\n"
                . "**Menerima deposit:**\n"
                . "1. Saat membuat reservasi, sistem menampilkan jumlah deposit sesuai policy.\n"
                . "2. Pilih metode pembayaran deposit: bank transfer, virtual account, atau payment gateway.\n"
                . "3. Setelah pembayaran diterima, klik **Konfirmasi Deposit**. Status deposit: **Paid**.\n\n"
                . "**Saat check-out:**\n"
                . "Deposit otomatis mengurangi total tagihan. Jika total tagihan lebih kecil dari deposit, selisih akan dikembalikan (refund).\n\n"
                . "**Deposit report:**\n"
                . "Buka **Laporan → Deposit** untuk melihat daftar deposit pending, paid, dan forfeited.",
            'tags'           => json_encode(['deposit', 'down payment', 'dp', 'pembayaran']),
            'source_manual'  => true,
            'is_published'   => true,
        ],

        // ── Housekeeping ──
        [
            'title'          => 'Housekeeping Checklist dan Prosedur',
            'content'        => "Housekeeping checklist memastikan setiap kamar dibersihkan dengan standar yang konsisten.\n\n"
                . "**Task assignment:**\n"
                . "1. Supervisor housekeeping membuka **Housekeeping → Assignment**.\n"
                . "2. Drag room attendant ke kamar yang ditugaskan (rata-rata 12-15 kamar per attendant).\n"
                . "3. Attendant menerima daftar tugas di aplikasi mobile/handheld.\n\n"
                . "**Checklist standar (per kamar):**\n"
                . "- Ganti linen (sprei, sarung bantal, duvet cover)\n"
                . "- Bersihkan kamar mandi (toilet, shower, wastafel)\n"
                . "- Vacuum/mop lantai\n"
                . "- Isi ulang amenities (sabun, shampoo, kopi, teh, air minum)\n"
                . "- Periksa dan catat minibar\n"
                . "- Periksa fungsi AC, TV, lampu, dan keran\n"
                . "- Laporkan kerusakan jika ada\n\n"
                . "Setelah selesai, attendant menekan **Complete** dan supervisor melakukan inspeksi sebelum status kamar berubah menjadi **Clean**.",
            'tags'           => json_encode(['housekeeping', 'checklist', 'kebersihan', 'kamar']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Status Kamar dan Room Turnover',
            'content'        => "Status kamar dikelola secara real-time agar front desk selalu memiliki informasi akurat.\n\n"
                . "**Siklus status kamar:**\n"
                . "**Clean** → Tamu check-in → **Occupied** → Tamu check-out → **Dirty** → Housekeeping membersihkan → **Inspected** (opsional) → **Clean**\n\n"
                . "**Status khusus:**\n"
                . "- **Out of Order (OOO):** Kamar tidak dapat digunakan (renovasi, kerusakan berat)\n"
                . "- **Out of Service (OOS):** Kamar sementara tidak tersedia (perbaikan ringan)\n"
                . "- **Do Not Disturb (DND):** Tamu tidak ingin diganggu\n"
                . "- **Sleep Out:** Tamu tidak menginap malam itu\n\n"
                . "**Memperbarui status:**\n"
                . "Housekeeping staff memperbarui status melalui aplikasi mobile setelah membersihkan. Front desk menerima notifikasi ketika kamar siap untuk check-in berikutnya.",
            'tags'           => json_encode(['status', 'kamar', 'room turnover', 'housekeeping']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Maintenance Kamar dan Fasilitas',
            'content'        => "Sistem maintenance ticket terintegrasi untuk pelaporan dan perbaikan kerusakan.\n\n"
                . "**Membuat maintenance request:**\n"
                . "1. Staff (housekeeping/front desk) melaporkan kerusakan via **Maintenance → Buat Tiket**.\n"
                . "2. Isi: nomor kamar/area, deskripsi masalah, tingkat urgensi (Low/Medium/High/Critical), dan foto.\n"
                . "3. Klik **Submit**. Status: **Reported**.\n\n"
                . "**Response workflow:**\n"
                . "- **Reported:** Tiket masuk ke dashboard maintenance\n"
                . "- **In Progress:** Teknisi menerima tiket dan mulai perbaikan\n"
                . "- **Resolved:** Perbaikan selesai, teknisi update tiket dengan deskripsi pekerjaan\n"
                . "- **Verified:** Supervisor memverifikasi perbaikan\n\n"
                . "Jika kerusakan menyebabkan kamar tidak bisa digunakan, sistem otomatis mengubah status kamar menjadi **Out of Service** hingga perbaikan selesai.",
            'tags'           => json_encode(['maintenance', 'perbaikan', 'kerusakan', 'tiket']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Room Service dan Pesanan Tamu',
            'content'        => "Modul room service memungkinkan tamu memesan makanan, minuman, atau layanan langsung dari kamar.\n\n"
                . "**Membuat pesanan room service:**\n"
                . "1. Buka **Front Desk → Room Service** atau gunakan aplikasi mobile.\n"
                . "2. Pilih nomor kamar tamu.\n"
                . "3. Browse menu (makanan, minuman, snack) — menu dikelola di **Settings → Room Service Menu**.\n"
                . "4. Tambahkan item ke pesanan, sesuaikan quantity.\n"
                . "5. Klik **Order**. Pesanan dikirim ke dapur/bar.\n"
                . "6. Setelah diantar, klik **Delivered**.\n\n"
                . "**Tagihan otomatis:**\n"
                . "Setiap pesanan room service otomatis diposting ke folio tamu. Pelunasan saat check-out.\n\n"
                . "**Pesanan khusus:**\n"
                . "Extra bed, extra towel, iron & board, dll. dapat dipesan melalui menu **Guest Requests**.",
            'tags'           => json_encode(['room service', 'pesanan', 'makanan', 'tamu']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Paket Promo dan Special Offer',
            'content'        => "Tingkatkan okupansi dengan membuat paket promo dan special offer yang menarik.\n\n"
                . "**Jenis paket:**\n"
                . "- **Stay & Dine:** Menginap + makan malam romantis\n"
                . "- **Early Bird:** Diskon untuk booking jauh-jauh hari\n"
                . "- **Last Minute:** Harga spesial untuk booking H-1\n"
                . "- **Long Stay:** Harga lebih murah untuk menginap 5 malam+\n"
                . "- **Honeymoon Package:** Dekorasi kamar, bunga, cake, spa\n"
                . "- **Corporate Rate:** Harga khusus untuk perusahaan rekanan\n\n"
                . "**Membuat paket:**\n"
                . "1. Buka **Promo → Buat Paket**.\n"
                . "2. Isi nama paket, deskripsi, harga, periode berlaku, minimal malam.\n"
                . "3. Pilih tipe kamar yang termasuk dalam paket.\n"
                . "4. Tambahkan benefit/inclusion (breakfast, spa, welcome drink, dll.).\n"
                . "5. Upload foto banner untuk booking engine.\n"
                . "6. Klik **Publish**.",
            'tags'           => json_encode(['promo', 'paket', 'special offer', 'diskon']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Laporan Okupansi dan Revenue',
            'content'        => "Laporan okupansi dan revenue adalah dashboard utama untuk analisis performa resort.\n\n"
                . "**Metrik kunci:**\n"
                . "- **Occupancy Rate:** % kamar terisi dari total tersedia\n"
                . "- **ADR (Average Daily Rate):** Rata-rata harga kamar per malam\n"
                . "- **RevPAR (Revenue Per Available Room):** Pendapatan per kamar tersedia\n"
                . "- **GOPPAR (Gross Operating Profit Per Available Room)**\n\n"
                . "**Cara akses:**\n"
                . "1. Buka **Laporan → Occupancy & Revenue**.\n"
                . "2. Pilih periode (hari ini, mingguan, bulanan, tahunan).\n"
                . "3. Grafik menampilkan:\n"
                . "   - Tren okupansi dan revenue\n"
                . "   - Perbandingan dengan periode sebelumnya\n"
                . "   - Breakdown per tipe kamar\n"
                . "   - Forecast 30 hari ke depan\n\n"
                . "**Export:** Semua laporan dapat diekspor ke Excel untuk analisis lanjutan.",
            'tags'           => json_encode(['okupansi', 'revenue', 'ADR', 'RevPAR', 'laporan']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Integrasi Channel Manager',
            'content'        => "Channel manager menghubungkan Pratasaba Resort dengan OTA (Online Travel Agent) dan mendistribusikan ketersediaan kamar secara real-time.\n\n"
                . "**OTA yang didukung:**\n"
                . "- Booking.com, Agoda, Expedia, Traveloka, Tiket.com\n\n"
                . "**Setup channel manager:**\n"
                . "1. Buka **Settings → Channel Manager**.\n"
                . "2. Pilih provider channel manager (contoh: SiteMinder, D-EDGE).\n"
                . "3. Masukkan kredensial API.\n"
                . "4. Mapping tipe kamar (Pratasaba ↔ OTA).\n"
                . "5. Aktifkan sinkronisasi.\n\n"
                . "**Manfaat:**\n"
                . "- Ketersediaan kamar otomatis update di semua OTA — mencegah double booking.\n"
                . "- Harga dapat diatur per channel (rate parity atau differentiated).\n"
                . "- Reservasi dari OTA otomatis masuk ke Pratasaba Resort dashboard.\n\n"
                . "**Monitoring:** Buka **Channel Manager → Booking Log** untuk melihat reservasi yang masuk dari masing-masing OTA.",
            'tags'           => json_encode(['channel manager', 'OTA', 'integrasi', 'distribusi']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
        [
            'title'          => 'Manajemen Grup Booking dan Event',
            'content'        => "Untuk reservasi grup (wedding, corporate event, family gathering), Pratasaba Resort menyediakan modul khusus.\n\n"
                . "**Membuat grup booking:**\n"
                . "1. Buka **Reservasi → Grup Booking**.\n"
                . "2. Klik **Buat Grup Baru**.\n"
                . "3. Isi: nama grup, company/organizer, kontak person, jumlah kamar, tipe kamar, tanggal.\n"
                . "4. Sistem membuat **Master Folio** yang menampung seluruh tagihan grup.\n"
                . "5. Tambahkan individual room assignment di bawah master.\n\n"
                . "**Fitur grup:**\n"
                . "- **Billing:** Pilih master bill (semua ke master) atau individual bill per kamar\n"
                . "- **Rooming List:** Upload daftar nama peserta\n"
                . "- **Event Order:** Catat kebutuhan meeting room, banquet, AV equipment\n"
                . "- **Cut-off Date:** Batas akhir pembatalan tanpa penalty\n\n"
                . "Setelah check-out, sistem menghasilkan consolidated invoice untuk seluruh grup.",
            'tags'           => json_encode(['grup', 'booking', 'event', 'rombongan']),
            'source_manual'  => true,
            'is_published'   => true,
        ],
    ],

];
