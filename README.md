# My-Course

**Platform E-Learning Berbasis Laravel 12**

"Platform e-learning berbasis Laravel 12 ini memberikan solusi lengkap untuk pengelolaan kursus online. Pengguna dapat membuat materi pembelajaran, mengatur jadwal kursus, menambahkan kuis dan penilaian, serta memantau kemajuan peserta. Website ini dirancang responsif dan mudah digunakan, memberikan pengalaman belajar yang interaktif dan efisien bagi pengajar maupun siswa."

---

## Fitur Utama

-   **Manajemen Kursus**: Membuat, mengedit, dan menghapus kursus online.
-   **Materi Pembelajaran**: Menambahkan materi berupa teks, gambar, atau video.
-   **Kuis & Penilaian**: Membuat kuis dan menilai peserta secara otomatis atau manual.
-   **Manajemen Pengguna**: Registrasi peserta, login, profil, dan monitoring progres belajar.
-   **Responsif & Modern**: Menggunakan Tailwind CSS untuk antarmuka yang bersih dan mudah digunakan di desktop maupun mobile.
-   **Admin Panel**: Menggunakan Filament sebagai admin dashboard untuk pengelolaan kursus dan pengguna secara efisien.
-   **Keamanan & Otentikasi**: Login dan hak akses berbasis peran (Admin, Pengajar, Peserta).

---

## Teknologi

-   **Backend**: Laravel 12
-   **Frontend**: Tailwind CSS, Blade Template
-   **Database**: MySQL
-   **Dependency Management**: Composer & NPM

---

## Instalasi

1. Clone repository ini:

```bash
git clone https://github.com/yogisepdu/my-course.git
cd my-course
Install dependency PHP:
```

```bash
composer install
Install dependency frontend:
```

```bash
npm install
npm run dev
```

Salin file environment dan atur konfigurasi database:

```bash
cp .env.example .env
php artisan key:generate
Jalankan migrasi database:
```

```bash
php artisan migrate
Jalankan server lokal:
```

```bash
php artisan serve
Website akan tersedia di http://localhost:8000.
```

## Struktur Folder

php
app/ # Logika backend (Models, Controllers)
database/ # Migration dan seeder database
resources/ # Blade templates, CSS, JS
routes/ # File routing Laravel
public/ # Assets publik (gambar, CSS, JS)

## Lisensi

Proyek ini dilisensikan di bawah MIT License.

Catatan
Pastikan PHP >= 8.1

MySQL / SQLite sudah tersedia dan dikonfigurasi di .env

Tailwind CSS digunakan untuk desain modern dan responsif
