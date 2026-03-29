# 🚀 Laravel Project Setup

<p align="center">
  <a href="#" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/tests-passing-brightgreen" alt="Build Status">
  <img src="https://img.shields.io/badge/downloads-510M-blue" alt="Total Downloads">
  <img src="https://img.shields.io/badge/version-v1.0.0-orange" alt="Version">
  <img src="https://img.shields.io/badge/license-MIT-green" alt="License">
</p>

---

#### Pastikan versi PHP di atas 8.2.0

---

### 1. Clone Repository
```bash
git clone https://github.com/username/project-name.git
cd project-name
```

---

### 2. Install Dependency Laravel
```bash
composer install
```

---

### 3. Install Dependency Frontend
```bash
npm install
```

---

### 4. Copy dan Setup Environment File
```bash
cp .env.example .env
```

---

## Buat Database di phpMyAdmin, lalu atur konfigurasi database di file `.env`:
```env
DB_DATABASE=msstracking_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

### 5. Generate App Key
```bash
php artisan key:generate
```

---

### 6. Migrasi Database
```bash
php artisan migrate
```

---

### 7. Storage Link
```bash
php artisan storage:link
```

---

### 8. Install Library PDF
```bash
composer require barryvdh/laravel-dompdf
```

---

### 9. Install Realtime (Pusher Backend)
```bash
composer require pusher/pusher-php-server
```

---

### 10. Install Realtime Frontend
```bash
npm install --save-dev laravel-echo pusher-js
```

---

### 11. Jalankan Project

#### Terminal 1 (Laravel)
```bash
php artisan serve
```

#### Terminal 2 (Frontend / Vite)
```bash
npm run dev
```

---

### 12. Jalankan Seeder (Optional)
```bash
php artisan db:seed
```

---

### ⚠️ Konfigurasi Tambahan (Jika menggunakan Realtime)
Tambahkan di file `.env`:

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_id
PUSHER_APP_KEY=your_key
PUSHER_APP_SECRET=your_secret
PUSHER_APP_CLUSTER=mt1
```

---

### 🧪 Troubleshooting
Jika terjadi error jalankan:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

### 📌 Catatan
- Pastikan database sudah dibuat sebelum migrate
- Pastikan semua dependency sudah terinstall
- Gunakan versi PHP sesuai requirement

---

### 👨‍💻 Author
Developed by **Sahrul Maulidi, Rafi Imanullah, Heri Ahmad Fauzi**

---

### 📄 License
This project is licensed under the MIT License.
