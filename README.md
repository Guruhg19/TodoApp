# TodoApp

TodoApp adalah aplikasi web berbasis Laravel 11 yang memungkinkan pengguna untuk membuat dan mengelola daftar tugas (to-do list). Aplikasi ini dilengkapi dengan fitur registrasi dan login untuk menjaga privasi dan keamanan data pengguna.

## Fitur Utama
- **Menambah, Mengedit, dan Menghapus To-Do List**: Pengguna dapat menambahkan, mengedit, dan menghapus daftar tugas yang akan dikerjakan.
- **Fitur Registrasi dan Login**: Pengguna harus mendaftar dan login untuk menggunakan aplikasi ini. Setiap akun pengguna akan memiliki daftar tugas tersendiri yang terpisah dari akun lain.
- **User Authentication**: Implementasi autentikasi untuk menjaga keamanan data pengguna.



## Installation

1. Clone repository ini ke dalam direktori lokal Anda:
   ```bash
   git clone https://github.com/Guruhg19/TodoApp

2. Masuk ke direktori projek anda :
    ```bash
   cd TodoApp

3. Instal dependencies yang dibutuhkan :
    ```bash
   composer install
   npm install
   npm run dev

4. Buat file .env dari contoh file .env.example dan sesuaikan dengan pengaturan database anda :
    ```bash
   cp .env.example .env

5. Migrasi database :
    ```bash
   php artisan migrate

5. Jalankan aplikasi :
    ```bash
   php artisan serve

Aplikasi dapat diakses di http://localhost:8000.


## Teknologi yang digunakan

 - Laravel 11: Framework PHP yang digunakan untuk membangun aplikasi ini.
 - MySQL: Digunakan untuk manajemen database.
 - Blade Templating: Untuk membuat tampilan antarmuka pengguna.
 - Bootstrap: CSS framework untuk styling yang responsif.
 - JavaScript & jQuery: Untuk interaktivitas pada sisi client.


