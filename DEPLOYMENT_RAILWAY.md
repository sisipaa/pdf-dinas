# Deployment Guide - Railway + Supabase

## Perbaikan yang Sudah Dilakukan

### 1. Force HTTPS di Production
**File:** `app/Providers/AppServiceProvider.php`
- Menambahkan `URL::forceScheme('https')` untuk production environment
- Menghilangkan warning "form is not secure" di browser

### 2. Trust Proxies untuk Railway
**File:** `bootstrap/app.php`
- Menambahkan `$middleware->trustProxies(at: '*')` untuk mempercayai proxy Railway

### 3. Perbaikan Browsershot untuk PDF
**File:** `app/Http/Controllers/TripController.php`
- Menambahkan Chromium arguments tambahan: `--ignore-certificate-errors`, `--disable-web-security`
- Menambahkan `setIncludePath()` dan `noSandbox()` untuk Railway
- Menambahkan error handling dan logging untuk debugging

### 4. Update .env.example
**File:** `.env.example`
- Default ke production settings (APP_ENV=production, APP_DEBUG=false)

---

## Konfigurasi Environment di Railway

### WAJIB - Update Variabel Berikut:

```env
# App Configuration
APP_NAME="E-Surat Dinas"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://dinas.up.railway.app

# Database - Supabase PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres.oeovodmldkhhvmbfwgdt
DB_PASSWORD=<your_password>
DB_SSLMODE=require

# ATAU gunakan DATABASE_URL (pilih salah satu):
DATABASE_URL=postgresql://postgres.oeovodmldkhhvmbfwgdt:<password>@aws-0-ap-southeast-1.pooler.supabase.com:6543/postgres?sslmode=require

# Session & Cache (gunakan database)
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true

CACHE_STORE=file
QUEUE_CONNECTION=sync

# Logging
LOG_CHANNEL=stderr
LOG_LEVEL=debug

# Puppeteer/Chromium
PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true
CHROME_BIN=/usr/bin/chromium
```

### ⚠️ PENTING - Password Database

Jika masih error "Tenant or user not found":

1. Buka **Supabase Dashboard** → **Database Settings**
2. Klik **Reset Database Password**
3. Copy password baru
4. Update `DB_PASSWORD` di Railway
5. Redeploy aplikasi

---

## Langkah Deploy

### 1. Push Perubahan ke GitHub
```bash
git add .
git commit -m "fix: HTTPS force + PDF generation error handling"
git push origin main
```

### 2. Update Environment Variables di Railway

Hapus variabel lama dan ganti dengan yang baru.

### 3. Jalankan Migrate Ulang

Di Railway, tambahkan start command:
```bash
php artisan migrate --force && php artisan serve --host 0.0.0.0 --port $PORT
```

### 4. Jika PDF Masih Error 500

Cek log Railway untuk error detail. Error handling sudah ditambahkan untuk menampilkan pesan error yang lebih jelas.

---

## Troubleshooting

### Error: "Tenant or user not found"
- Pastikan username: `postgres.oeovodmldkhhvmbfwgdt` (dengan project ID)
- Reset password database di Supabase Dashboard
- Gunakan DATABASE_URL lengkap jika variabel terpisah tidak work

### Error: 500 saat generate PDF
- Cek log Railway untuk error detail
- Pastikan storage directory writable
- Verify Chromium terinstall di Railway

### Warning: "Form is not secure"
- Pastikan `APP_URL` menggunakan `https://`
- Pastikan `SESSION_SECURE_COOKIE=true`
- Clear browser cache dan cookies

### Error: "Connection refused" ke 127.0.0.1:5432
- Laravel fallback ke localhost karena gagal konek ke Supabase
- Periksa kembali credential database
- Pastikan pooler enabled di Supabase

---

## Testing Lokal (Opsional)

Test connection string dengan psql:
```bash
psql "postgresql://postgres.oeovodmldkhhvmbfwgdt:password@aws-0-ap-southeast-1.pooler.supabase.com:6543/postgres?sslmode=require"
```
