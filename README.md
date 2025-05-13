# SKAVEN PORTAL

Aplikasi web yang dirancang untuk mengelola berbagai aspek kehidupan akademik di **skaven-portal**. Anda dapat mengelola **siswa**, **guru**, **kelas**, **ujian**, **jadwal**, **nilai**, dan banyak lagi secara efisien dan mudah.

💻 **Aplikasi ini dibangun dengan teknologi Laravel & Vue.js, dengan antarmuka yang responsif dan modern!**

---

## 🚀 **Fitur Utama**

- **Manajemen Siswa**: Kelola data siswa, termasuk detail pribadi, nilai, dan penugasan kelas.
- **Manajemen Guru**: Pantau informasi guru, penugasan, jadwal, dan mata pelajaran yang diampu.
- **Manajemen Kelas**: Atur dan kelola kelas, termasuk jadwal, guru pengajar, dan mata pelajaran.
- **Manajemen Ujian**: Buat dan kelola ujian untuk siswa serta penilaian hasil ujian.
- **Manajemen Jadwal**: Tentukan dan kelola jadwal kegiatan sekolah, ujian, dan pengajaran.
- **Manajemen Inventaris**: Melacak barang-barang dan aset sekolah.
- **Laporan & Analisis**: Menghasilkan laporan terkait kinerja siswa, kegiatan guru, dan hasil ujian.
- **Autentikasi Pengguna**: Sistem login yang aman untuk guru, siswa, dan admin.
- **Kontrol Akses Berdasarkan Peran**: Pengaturan hak akses berdasarkan peran (admin, guru, siswa).

---

## 📦 **Persyaratan Sistem**

Sebelum memulai, pastikan Anda telah menginstal perangkat lunak berikut:

- **PHP >= 8.2**  
- **Composer** (untuk mengelola dependensi backend)
- **Laravel 11**  
- **Node.js & npm** (untuk mengelola dependensi frontend)
- **MySQL** 
---

## 🛠️ **Cara Menginstal Aplikasi**

Langkah-langkah untuk menjalankan aplikasi ini di mesin lokal Anda:

### 1. **Clone repository**

```bash
git clone https://github.com/al-kawsar/skaven-portal.git
cd skaven
```

### 2. **Instal dependensi backend**

```bash
composer install
```

### 3. **Instal dependensi frontend**

```bash
npm install
```

### 4. **Konfigurasi file .env**

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

### 5. **Jalankan migrasi database**


```bash
php artisan migrate
```

### 6. **Isi database**

```bash
php artisan db:seed
```

### 7. **Jalankan aplikasi**

Untuk menjalankan aplikasi di server lokal, gunakan perintah ini:

```bash
composer run dev
```

Akses aplikasi di browser melalui [http://localhost:8000](http://localhost:8000).

### 8. **Build Aset Frontend untuk Produksi**

Untuk membangun aset frontend untuk lingkungan produksi, jalankan:

```bash
npm run build
```

---

## 🛣️ **API Rute Utama**

Aplikasi ini menyediakan beberapa API endpoint utama, di antaranya:

- **GET** `/api/classes` – Mendapatkan daftar semua kelas.
- **GET** `/api/exams` – Mendapatkan daftar ujian yang tersedia.
- **GET** `/api/students` – Mendapatkan daftar semua siswa.
- **GET** `/api/teachers` – Mendapatkan daftar semua guru.
- **POST** `/api/classes` – Membuat kelas baru.
- **POST** `/api/exams` – Membuat ujian baru.
- **POST** `/api/students` – Menambah siswa baru.
- **POST** `/api/teachers` – Menambah guru baru.

Lihat dokumentasi API untuk informasi lebih lanjut.

---

## ⚙️ **Teknologi yang Digunakan**

Aplikasi ini dibangun dengan teknologi terkini, seperti:

- **Vue.js 3**: Framework JavaScript untuk membangun antarmuka pengguna yang interaktif.
- **Tailwind CSS**: Framework CSS utilitas untuk desain responsif yang cepat.
- **PrimeVue**: Kumpulan komponen UI premium untuk Vue.js.
- **Vite**: Alat pengembangan frontend yang cepat dan efisien.

---

## 🕹️ **Manajemen Jadwal dan Laporan**

Aplikasi ini dilengkapi dengan modul untuk mengelola **jadwal sekolah** dan menghasilkan **laporan** yang bermanfaat, seperti:

- **Jadwal Kelas**: Kelola jadwal kelas harian, mingguan, atau bulanan.
- **Jadwal Ujian**: Tentukan waktu ujian dan pantau pelaksanaannya.
- **Laporan Nilai**: Analisis performa siswa berdasarkan hasil ujian dan penilaian lainnya.

---

## 🔑 **Autentikasi dan Peran Pengguna**

SKAVEN mendukung sistem autentikasi dengan peran pengguna sebagai berikut:

- **Admin**: Akses penuh ke semua fitur dan pengaturan aplikasi.
- **Guru**: Akses untuk mengelola kelas, siswa, ujian, dan nilai.
- **Siswa**: Akses untuk melihat nilai, jadwal, dan hasil ujian mereka.

---

## 📝 **Lisensi**

Proyek ini dilisensikan di bawah **MIT License** – lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

---

## 💡 **Kontribusi**

Kami sangat menghargai kontribusi dari Anda! Jika Anda memiliki ide atau perbaikan untuk proyek ini, Anda dapat mengikuti langkah-langkah berikut:

1. Fork repository ini.
2. Buat cabang baru (`git checkout -b fitur-baru`).
3. Lakukan perubahan yang diperlukan dan commit (`git commit -am 'Menambahkan fitur baru'`).
4. Push perubahan ke fork Anda (`git push origin fitur-baru`).
5. Kirim pull request untuk cabang fitur-baru ke repository utama.

---

## 📬 **Kontak**

Jika Anda memiliki pertanyaan atau saran, jangan ragu untuk menghubungi tim pengembang kami:

**Email**: [contact@smkn7makassar.sch.id](mailto:contact@smkn7makassar.sch.id)
