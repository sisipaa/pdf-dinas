# Panduan Deploy ke Railway - Step by Step

## Prerequisites
Sebelum mulai, pastikan Anda sudah punya:
- [x] Akun GitHub
- [x] Akun Railway (daftar di https://railway.app)
- [x] Repository GitHub dengan code project ini

---

## Step 1: Persiapan Code

### 1.1 Pastikan semua file konfigurasi sudah ada

Cek file-file ini ada di project Anda:

```
├── nixpacks.toml          ← WAJIB (config Chromium)
├── railway.json           ← WAJIB (config Railway)
├── .env.example           ← WAJIB (template environment)
├── composer.json          ← WAJIB (dependencies PHP)
├── package.json           ← WAJIB (dependencies Node)
└── DEPLOYMENT.md          ← Dokumentasi
```

### 1.2 Update `.env` untuk Production

Buat file `.env` (jika belum ada) dan pastikan setting database untuk Railway:

```bash
# .env
APP_NAME="E-Surat Dinas"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

CHROME_BIN=/usr/bin/chromium
RAILWAY_ENVIRONMENT=true
```

> **Catatan:** `${{...}}` adalah syntax Railway untuk inject variables otomatis

### 1.3 Commit dan Push ke GitHub

```bash
git add .
git commit -m "Prepare for Railway deployment with Browsershot"
git push origin main
```

---

## Step 2: Buat Project di Railway

### 2.1 Login ke Railway
1. Buka https://railway.app
2. Klik **"Login"** → pilih **"Login with GitHub"**

### 2.2 Create New Project
1. Klik **"New Project"**
2. Pilih **"Deploy from GitHub repo"**
3. Pilih repository `dinas` Anda
4. Klik **"Deploy Now"**

---

## Step 3: Konfigurasi Service

### 3.1 Tambahkan Database MySQL

1. Di project Railway Anda, klik **"+ New"**
2. Pilih **"Database"** → **"Add MySQL"**
3. Tunggu hingga MySQL selesai deploy
4. Railway akan otomatis generate variables:
   - `MYSQL_HOST`
   - `MYSQL_PORT`
   - `MYSQL_DATABASE`
   - `MYSQL_USER`
   - `MYSQL_PASSWORD`
   - `DATABASE_URL`

### 3.2 Set Environment Variables

1. Klik service utama Anda (biasanya bernama `dinas` atau `laravel`)
2. Pilih tab **"Variables"**
3. Klik **"Add Variable"** dan tambahkan:

```
APP_NAME="E-Surat Dinas"
APP_ENV=production
APP_DEBUG=false
APP_KEY=
```

4. Generate APP_KEY dengan command di local:
   ```bash
   php artisan key:generate --show
   ```
5. Copy key yang muncul dan paste ke variable `APP_KEY`

6. Tambahkan variables untuk Browsershot:
```
CHROME_BIN=/usr/bin/chromium
RAILWAY_ENVIRONMENT=true
PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true
```

---

## Step 4: Konfigurasi Build

### 4.1 Pastikan nixpacks.toml Sudah Benar

File `nixpacks.toml` harus seperti ini:

```toml
[phases.setup]
nixPkgs = ["php", "phpExtensions.pdo_mysql", "composer", "nginx", "chromium"]

[phases.install]
cmds = [
    "composer install --no-dev --optimize-autoloader",
    "npm install",
    "npm run build"
]

[phases.build]
cmds = [
    "cp .env.example .env || true",
    "php artisan key:generate --force || true",
    "php artisan config:cache",
    "php artisan route:cache",
    "php artisan view:cache"
]

[start]
cmd = "php artisan migrate --force && php artisan serve --host 0.0.0.0 --port $PORT"

[environment]
CHROME_BIN = "/usr/bin/chromium"
PUPPETEER_SKIP_CHROMIUM_DOWNLOAD = "true"
RAILWAY_ENVIRONMENT = "true"
```

### 4.2 Root Directory (Jika Perlu)

Jika project Anda di subfolder, set **Root Directory** di Railway:
1. Klik service → **"Settings"**
2. Scroll ke **"Root Directory"**
3. Kosongkan jika project di root, atau isi nama folder jika di subfolder

---

## Step 5: Deploy

### 5.1 Trigger Deploy Manual

1. Di Railway dashboard, klik service Anda
2. Pilih tab **"Deployments"**
3. Klik **"Deploy"** untuk trigger deploy manual
4. Tunggu proses build selesai (~2-5 menit)

### 5.2 Monitor Build Log

Klik **"View Logs"** untuk melihat progress:
- Nix packages install (termasuk Chromium ~200MB)
- Composer install
- NPM install & build
- Laravel cache build

---

## Step 6: Setup Domain

### 6.1 Generate Domain Railway

1. Klik service → **"Settings"**
2. Scroll ke **"Domains"**
3. Klik **"Generate Domain"**
4. Railway akan buat domain seperti: `your-app-production.up.railway.app`

### 6.2 (Optional) Custom Domain

Jika punya domain:
1. Klik **"Add Custom Domain"**
2. Masukkan domain Anda
3. Update DNS records sesuai instruksi Railway

---

## Step 7: Run Migrations

### 7.1 Open Railway Shell

1. Klik service → **"Settings"**
2. Scroll ke **"Shell"**
3. Klik **"Start Shell"**

### 7.2 Run Migrations Manual

Di shell, jalankan:

```bash
php artisan migrate --force
php artisan db:seed --force
```

### 7.3 Create Storage Link

```bash
php artisan storage:link
```

### 7.4 Create User/Admin

Jika perlu create user manual:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123'),
]);
```

---

## Step 8: Test PDF Generation

### 8.1 Akses Aplikasi

Buka browser dan akses domain Railway Anda:
```
https://your-app-production.up.railway.app
```

### 8.2 Login dan Test

1. Login dengan user yang sudah dibuat
2. Buat surat perjalanan dinas baru
3. Pilih tujuan → pastikan uang harian otomatis terisi
4. Submit dan download PDF

### 8.3 Cek PDF Storage

Di Railway Shell:
```bash
ls -la storage/app/public/pdfs/
```

---

## Troubleshooting

### Error: Chrome tidak ditemukan

**Gejala:** PDF tidak generate, error "Chrome not found"

**Solusi:**
1. Pastikan `nixpacks.toml` ada `chromium` di `nixPkgs`
2. Pastikan variable `CHROME_BIN=/usr/bin/chromium`
3. Restart deployment

```bash
# Di Railway Shell, cek Chrome
which chromium
# Output: /usr/bin/chromium
```

### Error: Permission denied

**Gejala:** Cannot write to storage folder

**Solusi:**
```bash
# Di Railway Shell
chmod -R 775 storage/
chown -R www-data:www-data storage/
```

### Error: Migration gagal

**Gejala:** Migration timeout atau gagal

**Solusi:**
1. Pastikan MySQL sudah terconnect
2. Check DATABASE_URL variable
3. Run migration manual di Shell

### Build Timeout

**Gejala:** Build gagal karena timeout (>30 menit)

**Solusi:**
1. Optimize composer: `composer install --no-dev`
2. Reduce NPM packages
3. Contact Railway support untuk increase timeout

---

## Monitoring & Logs

### View Real-time Logs

```bash
# Via Railway CLI
railway logs

# Via Dashboard
Service → Logs tab
```

### Check PDF Generation

```bash
# Via Railway Shell
cd storage/app/public/pdfs
ls -la
```

### Database Check

```bash
# Via Railway Shell
php artisan tinker
```

```php
\App\Models\Trip::count();
\App\Models\Trip::latest()->first();
```

---

## Update Code (Setelah Deploy)

Setiap kali ada perubahan code:

```bash
# 1. Commit perubahan
git add .
git commit -m "Fix something"
git push origin main

# 2. Railway akan auto-deploy
# Monitor di Dashboard → Deployments tab

# 3. Jika perlu clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## Cost Estimate

Railway Free Plan:
- $5 credit/month
- ~500 hours compute time
- Cukup untuk development/small production

Railway Pro Plan ($20/month):
- Unlimited hours
- Priority support
- More resources

---

## Checklist Final

Sebelum go-live, pastikan:

- [ ] APP_DEBUG = false
- [ ] APP_KEY sudah di-set
- [ ] Database MySQL connected
- [ ] Migrations sudah run
- [ ] Storage link sudah dibuat
- [ ] Environment variables lengkap
- [ ] Domain sudah di-generate
- [ ] Test PDF generation berhasil
- [ ] Test login/register berhasil
- [ ] Backup database configured

---

## Kontak Support

Jika ada masalah:
- Railway Docs: https://docs.railway.app
- Railway Discord: https://discord.gg/railway
- GitHub Issues: https://github.com/your-repo/issues
