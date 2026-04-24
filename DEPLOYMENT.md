# Deployment Guide - E-Surat Dinas dengan Browsershot

## Overview
Project ini menggunakan **Spatie Browsershot** untuk generate PDF dengan kualitas tinggi yang presisi sesuai template perusahaan.

## Konfigurasi Railway

### 1. Buildpack Chrome
Railway sudah dikonfigurasi dengan **Nixpacks** yang include Chromium. File konfigurasi:

**nixpacks.toml:**
```toml
[phases.setup]
nixPkgs = ["php", "phpExtensions.pdo_mysql", "composer", "nginx", "chromium"]
```

### 2. Environment Variables
Pastikan environment variables berikut di-set di Railway Dashboard:

```bash
CHROME_BIN=/usr/bin/chromium
PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true
RAILWAY_ENVIRONMENT=true
```

### 3. Cara Deploy ke Railway

1. **Connect Repository**
   - Buka Railway.app
   - Connect GitHub repository ini

2. **Add Buildpack (Otomatis via nixpacks.toml)**
   - Chromium sudah include di nixpacks.toml
   - Tidak perlu add buildpack manual

3. **Set Environment Variables**
   - Pergi ke Settings > Variables
   - Add variables yang disebutkan di atas

4. **Deploy**
   - Railway akan otomatis deploy saat push ke main branch

### 4. Troubleshooting

**PDF tidak ter-generate / Error Chrome:**
```bash
# Cek log Railway
railway logs

# Pastikan Chrome path benar
echo $CHROME_BIN  # Harus: /usr/bin/chromium
```

**Permission Error:**
```bash
# Pastikan storage folder writable
chmod -R 775 storage/
chown -R www-data:www-data storage/
```

## Struktur File PDF

### Config Uang Harian
- **File:** `config/uang-harian.php`
- **Sumber:** PMK 32 Tahun 2025
- **Update:** Edit file ini untuk update nilai uang harian

### Template PDF
- **Dalam Negeri:** `resources/views/trips/dalam-negeri/pdf.blade.php`
- **Luar Negeri:** `resources/views/trips/luar-negeri/pdf.blade.php`

### Controller
- **File:** `app/Http/Controllers/TripController.php`
- **Method:**
  - `generatePdfDalamNegeri()` - Generate PDF dalam negeri
  - `generatePdfLuarNegeri()` - Generate PDF luar negeri

## Local Development

### Install Dependencies
```bash
composer install
npm install
```

### Run Locally
```bash
php artisan serve
```

### Generate PDF Locally
Browsershot akan menggunakan Chrome/Chromium lokal. Pastikan Chrome terinstall:
- **Windows:** Chrome default path
- **macOS:** `/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome`
- **Linux:** `/usr/bin/google-chrome`

## API Endpoint

### Get Uang Harian
```
GET /api/uang-harian?type=dalam_negeri
GET /api/uang-harian?type=luar_negeri
GET /api/uang-harian?type=dalam_negeri&tujuan=Jakarta
```

Response:
```json
{
  "success": true,
  "data": { "Jakarta": 550000, "Bandung": 509000, ... }
}
```

## Catatan Penting

1. **Storage Link:** Pastikan storage link sudah dibuat:
   ```bash
   php artisan storage:link
   ```

2. **PDF Storage:** PDF disimpan di `storage/app/public/pdfs/`

3. **Cache:** Clear cache setelah update config:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```
