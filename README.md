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

### Persiapan Server

1. Pastikan server memenuhi persyaratan sistem:
   - PHP >= 8.1
   - Composer
   - MySQL/MariaDB
   - Node.js & NPM
   - Web Server (Nginx/Apache)

2. Install dependencies PHP untuk production
```bash
composer install --optimize-autoloader --no-dev
```

3. Build assets untuk production
```bash
npm install
npm run build
```

4. Optimize Laravel
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize class loader
php artisan optimize
```

5. Set environment variables di file .env
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Set session dan cache driver ke file
SESSION_DRIVER=file
CACHE_DRIVER=file
```

6. Set permission yang benar
```bash
# Set ownership
sudo chown -R www-data:www-data /path/to/your/app

# Set permissions
sudo chmod -R 755 /path/to/your/app
sudo chmod -R 775 /path/to/your/app/storage
sudo chmod -R 775 /path/to/your/app/bootstrap/cache
```

### Konfigurasi Web Server

#### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/your/app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Apache (.htaccess)
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### Setup Database

1. Buat database baru
```sql
CREATE DATABASE your_database;
```

2. Import struktur database
```bash
php artisan migrate
```

3. Import data awal (opsional)
```bash
php artisan db:seed
```

### Setup SSL (Opsional tapi Direkomendasikan)

1. Install Certbot
```bash
sudo apt-get update
sudo apt-get install certbot python3-certbot-nginx
```

2. Setup SSL
```bash
sudo certbot --nginx -d your-domain.com
```

### Monitoring & Maintenance

1. Setup log rotation
```bash
sudo nano /etc/logrotate.d/laravel
```

2. Isi dengan konfigurasi berikut:
```
/path/to/your/app/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
}
```

3. Setup backup database (crontab)
```bash
0 0 * * * mysqldump -u your_username -p your_password your_database > /path/to/backup/backup-$(date +\%Y\%m\%d).sql
```

### Troubleshooting

1. Cek log Laravel
```bash
tail -f storage/logs/laravel.log
```

2. Cek permission
```bash
ls -la storage/
ls -la bootstrap/cache/
```

3. Clear cache jika ada masalah
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Lisensi

[MIT License](LICENSE)
