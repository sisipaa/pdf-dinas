# Deployment Guide untuk Railway

## Masalah yang Diperbaiki

Error sebelumnya:
```json
{
  "error": "Failed to generate PDF",
  "message": "An error occurred while generating the PDF"
}
```

Penyebab: **Browsershot memerlukan Puppeteer/Chrome** yang tidak tersedia di lingkungan Railway.

## Solusi yang Diterapkan

1. **Menghapus dependency Browsershot** - Diganti dengan DomPDF murni
2. **Konfigurasi DomPDF yang optimal** untuk production
3. **Font Times New Roman** sebagai default untuk kompatibilitas maksimal

## Langkah Deployment di Railway

### 1. Connect Repository
```bash
# Pastikan semua perubahan sudah di-commit dan push
git add .
git commit -m "fix: ganti Browsershot ke DomPDF untuk generate PDF"
git push origin main
```

### 2. Environment Variables di Railway

Pastikan environment variables berikut sudah dikonfigurasi:

```env
APP_NAME="E-Surat Dinas"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=<supabase-host>
DB_PORT=<supabase-port>
DB_DATABASE=<database-name>
DB_USERNAME=<username>
DB_PASSWORD=<password>

SESSION_DRIVER=cookie
SESSION_SECURE_COOKIE=true

LOG_CHANNEL=stderr
```

### 3. Build & Deploy Commands

Railway akan otomatis mendeteksi Laravel project. Jika perlu manual setup:

**Setup Phase:**
```bash
composer install --no-dev --optimize-autoloader
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

**Start Command:**
```bash
vendor/bin/heroku-php-apache2 public/
```

### 4. Izin Direktori

Pastikan direktori berikut writable:

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

Railway biasanya sudah menghandle ini otomatis.

### 5. Testing

Setelah deploy, test PDF generation dengan:

1. Login ke aplikasi
2. Buat surat perjalanan dinas baru
3. Pilih tujuan (uang harian akan otomatis terisi)
4. Submit form
5. PDF akan digenerate dan ditampilkan

## Troubleshooting

### Jika masih ada error PDF:

1. **Check logs di Railway:**
   ```bash
   railway logs
   ```

2. **Clear cache Laravel:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

3. **Pastikan storage link:**
   ```bash
   php artisan storage:link
   ```

4. **Verify DomPDF config:**
   ```bash
   php artisan config:cache
   ```

## Fitur yang Diimplementasikan

1. ✅ **Uang Harian otomatis** - Terpilih sesuai kota tujuan
2. ✅ **Perhitungan otomatis** - Uang Harian × Jumlah Hari
3. ✅ **Template presisi** - Mengikuti format template perusahaan
4. ✅ **Compatible dengan Railway** - Tidak memerlukan Chrome/Puppeteer
5. ✅ **Font Times New Roman** - Standar untuk dokumen resmi

## Catatan Penting

- DomPDF tidak memerlukan Chrome atau Puppeteer
- Semua proses berjalan di PHP murni
- Font subsetting diaktifkan untuk mengurangi ukuran file
- Remote resource diaktifkan jika diperlukan

## Update dari Versi Sebelumnya

| Sebelum | Sesudah |
|---------|---------|
| Browsershot + Puppeteer | DomPDF murni |
| Memerlukan Chrome | Tidak memerlukan eksternal |
| Error di Railway | Compatible dengan Railway |
| Ukuran besar | Ringan dan portable |
