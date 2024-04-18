<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tentang Aplikasi

Aplikasi POS atau point of sales adalah aplikasi yang digunakan untuk mengelola transaksi pada sebuah toko. Aplikasi ini dibuat menggunakan Laravel v10.11.0 dan minimal PHP v8.1. Apabila pada saat proses instalasi atau penggunaan terdapat error atau bug, hal tersebut dikarenakan versi dari PHP yang tidak support.

### Beberapa Fitur yang tersedia:
- Manajemen Kategori Produk
- Manajemen Gudang
- Manajemen Produk
- Manajemen Supplier
- Transaksi Pembelian
- Transaksi Penjualan
- Custom Tipe Nota
  - Nota Besar
  - Nota Kecil / Thermal Nota
- Manajemen User dan Profil
- Pengaturan Toko
  - Identitas
  - Setting Diskon 
- User (Administrator, Kasir)
- Grafik ChartJS pada Dashboard

## Instalasi
### Via Git
```bash
git clone https://github.com/andyanamafaza4/Logistyx.git 
```
### Via GitHub CLI
```bash
gh repo clone andyanamafaza4/Logistyx
```
### Download ZIP
[Link](https://github.com/andyanamafaza4/Logistyx/archive/refs/heads/master.zip)

### Setup Aplikasi
Jalankan perintah 
```bash
composer update
```
atau:
```bash
composer install
```
Copy file .env dari .env.example
```bash
cp .env.example .env
```
Konfigurasi file .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=logistyx
DB_USERNAME=root
DB_PASSWORD=
```
Opsional
```bash
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:pJKCUTVDN+rm8tRBxE96G7nslRhDjtaWmY2kX+ZyvfY=
APP_DEBUG=true
APP_URL=http://localhost
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
