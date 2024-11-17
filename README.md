# Aplikasi Kriptografi  

Aplikasi ini menyediakan berbagai fitur terkait keamanan data seperti autentikasi, enkripsi teks dan file, serta steganografi (menyembunyikan pesan dalam gambar). Dibangun dengan Laravel, aplikasi ini dirancang untuk memenuhi kebutuhan keamanan digital dengan pendekatan modern.

## Fitur  

### 1. **Autentikasi Login dan Register**  
- Fitur login dan register dengan hashing password menggunakan algoritma hashing yang aman (bcrypt).  
- Password disimpan dalam bentuk hash untuk meningkatkan keamanan data.  

### 2. **Enkripsi dan Dekripsi Teks**  
- **Enkripsi teks** menggunakan dua lapisan algoritma:  
  - **AES-128**  
  - **Caesar Cipher**  
- **Proses:**  
  - User memasukkan teks, key (16 karakter), dan IV (16 karakter).  
  - Sistem menghasilkan teks terenkripsi dan menyimpannya dalam database untuk keperluan history.  
- **Dekripsi:**  
  - User memasukkan teks terenkripsi, key, dan IV untuk mendapatkan teks asli.  
- Tersedia fitur **history** yang mencatat proses enkripsi/dekripsi dengan opsi untuk mengunduh key yang digunakan.  

### 3. **Enkripsi dan Dekripsi File**  
- **Enkripsi File:**  
  - User mengunggah file, dan sistem mengenkripsi file dengan **AES-256** menggunakan key yang digenerate otomatis.  
  - File terenkripsi berisi metadata, instruksi mendapatkan key, dan konten enkripsi.  
  - File terenkripsi akan diunduh secara otomatis oleh user.  
- **Dekripsi File:**  
  - User mengunggah file terenkripsi dan memasukkan key untuk mendekripsi.  
  - File asli akan diunduh secara otomatis.  
- Riwayat enkripsi/dekripsi file juga tersimpan dalam database.  

### 4. **Steganografi: Menyembunyikan Pesan dalam Gambar**  
- **Enkripsi Pesan:**  
  - User mengunggah file gambar dan teks pesan yang akan disembunyikan.  
  - Sistem menghasilkan file gambar yang berisi pesan tersembunyi dan otomatis mengunduhnya.  
- **Dekripsi Pesan:**  
  - User mengunggah gambar dengan pesan tersembunyi untuk mengekstrak pesan asli.  

### 5. **Riwayat Aktivitas**  
- Riwayat enkripsi/dekripsi teks dan file tersedia dalam bentuk tabel.  
- Fitur **download key** tersedia untuk setiap aktivitas yang tercatat.  

---

## Cara Install  

Ikuti langkah-langkah berikut untuk menginstal proyek ini:  

### 1. Clone Repository  
```bash  
git clone <URL_REPO_INI>  
cd <NAMA_FOLDER_REPO>  
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Copy env dan sesuaikan dengan konfig database
```bash
cp .env.example .env  
```

### 4. jalankan perintah berikut
```bash
php artisan migrate  
php artisan key:generate  
composer run dev
```
