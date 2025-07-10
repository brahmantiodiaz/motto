<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/brahmantiodiaz/motto/refs/heads/main/motto-view.jpg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tentang Aplikasi

MOTTO adalah aplikasi yang digunakan untuk QC Bootcamp.

### Beberapa Fitur yang tersedia:
- Board Assignment

## Instalasi
#### Via Git
```bash
git clone https://gitlab.com/brahmantiodiaz28/motto.git
```

### Download ZIP
[Link](https://gitlab.com/brahmantiodiaz28/motto/-/archive/main/motto-main.zip)

### Setup Aplikasi
Jalankan perintah 
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
DB_DATABASE=motto
DB_USERNAME=root
DB_PASSWORD=
```
Opsional
```bash
APP_NAME=MOTTO
APP_ENV=local
APP_KEY=base64:E+FRbV0own3uiBA4WzheASkAkE5Q6++gASFDlbn7Ogc=
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
Menjalankan aplikasi
```bash
php artisan serve
```

## License

[MIT license](https://opensource.org/licenses/MIT)
