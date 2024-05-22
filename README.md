

Kelompok 2 - P1 ADS
| NIM | Nama | Role |
| --- | --- | --- |
| G6401211004 | Adrian Muhammad Abimanyu | Project Manager |
| G6401211021 | Faizussabiq Khoiri | UI & UX |
| G6401211072 | Dwi Fitriani Azhari | BackEnd |
| G6401211087 | Rayyan Baihaqi | FrontEnd & BackEnd|

## Tentang Aplikasi

Aplikasi ini adalah aplikasi yang digunakan untuk mengelola barang dan transaksi pada sebuah gudang atau toko untuk memudahkan proses manajemen yang dilakukan berbagai perusahaan dalam mengelola keluar masuknya barang pada gudang ataupun toko mereka.

### Fitur utama Aplikasi:
- Grafik ChartJS untuk penjualan pada Dashboard (Admin)
- Manajemen Gudang
- Manajemen Kategori Produk
- Manajemen Produk
- Manajemen Supplier
- Transaksi Pembelian (Admin)
- Transaksi Penjualan (Kasir)
- Manajemen User (Admin) dan Profil
- Pengaturan Toko
- User (Admin, Kasir)


## Instalasi
### Via Git
```bash
git clone https://github.com/rayyanb572/StockTrack.git
```
atau:
### Via Download
https://github.com/rayyanb572/StockTrack/archive/refs/heads/main.zip

### Setup Aplikasi
Jalankan perintah pada terminal
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
Seeder table User dan Pengaturan
```bash
php artisan db:seed
```
Install npm
```bash
npm install
```
Running vite
```bash
npm run dev
```
Running vite
```bash
npm run build
```
Run aplikasi via server Laravel
```bash
php artisan serve
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
