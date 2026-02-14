# 🚀 MNC Future Leaders Scholarship - API Documentation

Dokumentasi ini berisi informasi mengenai endpoint API yang tersedia untuk aplikasi MFLS. Semua endpoint diawali dengan base URL `/api`.

---

## 🔐 Autentikasi

Beberapa endpoint memerlukan autentikasi menggunakan **Laravel Sanctum**. Kirimkan token dalam header `Authorization` sebagai `Bearer Token`.

`Authorization: Bearer <your_token>`

---

## 🌐 Public Endpoints

### 1. Login
Digunakan untuk mendapatkan token akses.

- **URL:** `/api/login`
- **Method:** `POST`
- **Request Body:**
  ```json
  {
    "email": "user@example.com",
    "password": "password123",
    "device_name": "mobile_android"
  }
  ```
- **Success Response (200):**
  ```json
  {
    "status": "success",
    "token": "1|abc123token...",
    "user": {
      "nama": "John Doe",
      "email": "user@example.com",
      "role": "pendaftar"
    }
  }
  ```

### 2. Cek Hasil Pengumuman
Mengecek status kelulusan beasiswa berdasarkan NISN.

- **URL:** `/api/cek-pengumuman`
- **Method:** `POST`
- **Request Body:**
  ```json
  {
    "nisn": "1234567890"
  }
  ```
- **Response (Success - Lolos):**
  ```json
  {
    "status": "success",
    "nama": "John Doe",
    "jalur": "BEASISWA PRESTASI",
    "message": "Selamat! Anda dinyatakan lolos seleksi beasiswa.",
    "hasil_beasiswa": "50%"
  }
  ```
- **Response (Pending/Belum Lolos):**
  ```json
  {
    "status": "pending",
    "nama": "John Doe",
    "message": "Hasil seleksi Anda belum tersedia atau masih dalam proses peninjauan."
  }
  ```

---

## 🛡️ Protected Endpoints (Perlu Token)

### 3. Get User Profile
Mendapatkan data akun yang sedang login.

- **URL:** `/api/user`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer <token>`
- **Response (200):** Objek user lengkap dari database.

### 4. Logout
Menghapus token akses saat ini.

- **URL:** `/api/logout`
- **Method:** `POST`
- **Headers:** `Authorization: Bearer <token>`
- **Response (200):**
  ```json
  {
    "message": "Logged out successfully"
  }
  ```

---

## 📝 Endpoint Ujian (CBT)

### 5. Daftar Ujian Tersedia
Mendapatkan daftar jenis ujian yang tersedia.

- **URL:** `/api/ujians`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer <token>`
- **Response (200):**
  ```json
  {
    "status": "success",
    "data": [
      { "id": 1, "nama": "Ujian Akademik" },
      { "id": 2, "nama": "Ujian Psikotes" }
    ]
  }
  ```

### 6. Ambil Soal Ujian
Mendapatkan daftar soal berdasarkan ID Ujian. Soal akan diacak secara otomatis.

- **URL:** `/api/soal?ujian_id={id}`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer <token>`
- **Response (200):**
  ```json
  {
    "status": "success",
    "ujian": "Ujian Akademik",
    "data": [
      {
        "id": 10,
        "ujian_id": 1,
        "pertanyaan": "Apa itu MFLS?",
        "gambar": null,
        "opsi_a": "Beasiswa MNC",
        "opsi_b": "Program Kerja",
        "opsi_c": "Lomba",
        "opsi_d": "Seminar",
        "bobot": 5
      }
    ]
  }
  ```

### 7. Submit Jawaban Ujian
Mengirimkan seluruh jawaban peserta dan mendapatkan skor secara langsung.

- **URL:** `/api/soal/submit`
- **Method:** `POST`
- **Headers:** `Authorization: Bearer <token>`
- **Request Body:**
  ```json
  {
    "ujian_id": 1,
    "answers": {
      "10": "a",
      "11": "b",
      "12": "c"
    }
  }
  ```
  *Catatan: Object `answers` berisi `soal_id` sebagai key dan `opsi` (a,b,c,d) sebagai value.*

- **Response (Success - 200):**
  ```json
  {
    "status": "success",
    "message": "Jawaban berhasil disimpan.",
    "results": {
      "earned_raw_score": 85,
      "max_raw_score": 100,
      "score": 85.0,
      "correct_answers": 17,
      "total_questions": 20
    }
  }
  ```
- **Error (400 - Sudah Mengerjakan):**
  ```json
  {
    "status": "error",
    "message": "Anda sudah mengerjakan ujian ini sebelumnya.",
    "score": 85
  }
  ```
