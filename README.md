# Instruksi Cara Menjalankan Aplikasi
## Sistem Booking Servis AHASS (Honda)

Panduan langkah demi langkah untuk menjalankan aplikasi Sistem Booking Servis AHASS pada lingkungan lokal (*Local Development Environment*).

---

### Prasyarat Sistem
Sebelum menjalankan aplikasi, pastikan sistem Anda telah memenuhi prasyarat berikut:
* **PHP:** Versi 7.4 – 8.1+ (dengan ekstensi `mysqli`, `json`, dan `session` aktif).
* **Database Server:** MySQL (v5.7 / v8.0) atau MariaDB setara.
* **Web Server:** Apache dengan modul `mod_rewrite` aktif.
* **Lingkungan yang Disarankan:** **Laragon** (direkomendasikan) atau **XAMPP**.

---

### Langkah 1: Penempatan Berkas Proyek
Tempatkan direktori proyek `ahass` ke dalam folder *root web server* lokal Anda:

* **Opsi Laragon:**
  Letakkan berkas proyek pada direktori:
  ```text
  C:\laragon\www\ahass
  ```
* **Opsi XAMPP:**
  Letakkan berkas proyek pada direktori:
  ```text
  C:\xampp\htdocs\ahass
  ```

---

### Langkah 2: Impor Basis Data (`schema.sql`)
Impor skema dan data awal (*seeder*) menggunakan berkas [`schema.sql`](schema.sql) yang tersedia di *root* direktori proyek:

* **Opsi CLI (Command Line Interface / Terminal):**
  Buka terminal/command prompt pada direktori proyek, lalu jalankan:
  ```bash
  mysql -u root -p < schema.sql
  ```
  *(Tekan Enter jika akun MySQL Anda tidak menggunakan password).*

* **Opsi GUI (phpMyAdmin / HeidiSQL / DBeaver):**
  1. Buka aplikasi pengelola basis data Anda.
  2. Buat basis data baru dengan nama `ahass_booking` (atau biarkan skrip membuatnya otomatis).
  3. Buka menu **Import** / **Run SQL File**.
  4. Pilih berkas `schema.sql` lalu klik **Execute** / **Go**.
  5. Skrip akan otomatis menginisialisasi tabel `paket_servis` (beserta data master) dan tabel `bookings`.

---

### Langkah 3: Konfigurasi Koneksi Database
Buka berkas konfigurasi database yang terletak di:
```text
application/config/database.php
```

Sesuaikan kredensial koneksi MySQL dengan konfigurasi lingkungan lokal Anda:

```php
$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'root',            // Sesuaikan username MySQL lokal Anda
    'password' => '',                // Sesuaikan password MySQL lokal Anda (default Laragon/XAMPP kosong)
    'database' => 'ahass_booking',   // Nama database hasil impor schema.sql
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    ...
);
```

---

### Langkah 4: Konfigurasi `base_url`
Buka berkas konfigurasi aplikasi yang terletak di:
```text
application/config/config.php
```

Sesuaikan nilai `$config['base_url']` (pada baris ~26) sesuai dengan *web server* yang Anda gunakan:

* **Jika Menggunakan Laragon (Virtual Host Otomatis):**
  ```php
  $config['base_url'] = 'http://ahass.test/';
  ```

* **Jika Menggunakan XAMPP / Localhost Biasa:**
  ```php
  $config['base_url'] = 'http://localhost/ahass/';
  ```

---

### Langkah 5: Akses Aplikasi via Peramban (*Web Browser*)
1. Pastikan layanan Apache dan MySQL sudah berjalan (*Running*) pada panel Laragon / XAMPP.
2. Buka peramban web (*Google Chrome, Mozilla Firefox, Microsoft Edge, dll.*).
3. Akses URL berikut pada bilah alamat:
   * **Untuk Pengguna Laragon:**
     ```text
     http://ahass.test/
     ```
   * **Untuk Pengguna XAMPP:**
     ```text
     http://localhost/ahass/
     ```
4. Aplikasi **Sistem Booking Servis AHASS** siap digunakan untuk pengujian.
