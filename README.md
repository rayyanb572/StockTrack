<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Kelompok 2 - P1 ADS
| NIM | Nama | Role |
| --- | --- | --- |
| G6401211004 | Adrian Muhammad Abimanyu | Project Manager |
| G6401211021 | Faizussabiq Khoiri | UI & UX |
| G6401211072 | Dwi Fitriani Azhari | BackEnd |
| G6401211087 | Rayyan Baihaqi | FrontEnd |

## Tentang Aplikasi

Aplikasi ini adalah aplikasi yang digunakan untuk mengelola barang dan transaksi pada sebuah gudang atau toko untuk memudahkan proses manajemen yang dilakukan berbagai perusahaan dalam mengelola keluar masuknya barang pada gudang ataupun toko mereka. Aplikasi ini dibuat menggunakan Laravel v10.11.0 dan minimal PHP v8.1. 

### Beberapa Fitur utama:
- Grafik ChartJS pada Dashboard
- Manajemen Kategori Produk
- Manajemen Gudang
- Manajemen Produk
- Manajemen Supplier
- Transaksi Pembelian
- Transaksi Penjualan
- Manajemen User dan Profil
- Pengaturan Toko
  - Identitas
  - Setting Diskon 
- User (Administrator, Kasir)


## Instalasi
### Via Git
```bash
git clone https://github.com/rayyanb572/StockTrack.git
```
atau:
### Via Download
https://github.com/rayyanb572/StockTrack/archive/refs/heads/main.zip

### Setup Aplikasi
Jalankan perintah 
```bash
composer update
```
atau:
```bash
composer install
```
Copy file .env.example dan rubah ke format .env
```bash
cp .env.example .env
```
Konfigurasi file .env (DB_DATABASE samakan dengan nama Database yang digunakan)
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stocktrack
DB_USERNAME=root
DB_PASSWORD=
```
Generate key
```bash
php artisan key:generate
```
Migrate database
```bash
php artisan migrate
```
Seeder table User, Pengaturan
```bash
php artisan db:seed
```
install npm
```bash
npm install
```
running vite
```bash
npm run dev
```
running vite
```bash
npm run build
```
Menjalankan aplikasi
```bash
php artisan serve
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
