# Invoice App

Aplikasi manajemen invoice berbasis Laravel dengan Filament admin panel.

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk asset compilation)

## Instalasi

1. Clone repository
```bash
git clone [repository-url]
cd invoice-app
```

2. Install dependencies PHP
```bash
composer install
```

3. Install dependencies Node.js
```bash
npm install
npm run build
```

4. Salin file .env
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Konfigurasi database di file .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invoice_app
DB_USERNAME=root
DB_PASSWORD=
```

7. Jalankan migrasi dan seeder
```bash
php artisan migrate:fresh --seed
```

8. Jalankan server development
```bash
php artisan serve
```

## Akses Aplikasi

1. Buka browser dan akses `http://localhost:8000`
2. Login dengan kredensial default:
   - Email: admin@email.com
   - Password: password

## Fitur

- Manajemen Klien
  - Tambah, edit, hapus data klien
  - Informasi lengkap klien (nama, email, telepon, alamat, dll)

- Manajemen Invoice
  - Pembuatan invoice dengan nomor otomatis
  - Penambahan item dengan kalkulasi otomatis
  - Cetak invoice
  - Riwayat invoice

- Dashboard
  - Ringkasan invoice
  - Statistik pembayaran
  - Grafik performa

## Struktur Database

### Tabel Users
- id
- name
- email
- password
- created_at
- updated_at

### Tabel Clients
- id
- name
- email
- phone
- address
- company_name
- tax_number
- created_at
- updated_at

### Tabel Invoices
- id
- client_id
- invoice_number
- invoice_date
- due_date
- total_amount
- items (JSON)
- created_at
- updated_at

## Pengembangan

1. Jalankan server development
```bash
php artisan serve
```

2. Jalankan watcher untuk asset compilation
```bash
npm run dev
```

## Testing

```bash
php artisan test
```

## Deployment

1. Optimize autoloader
```bash
composer install --optimize-autoloader --no-dev
```

2. Optimize configuration
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Build assets untuk production
```bash
npm run build
```

## Lisensi

[MIT License](LICENSE)
