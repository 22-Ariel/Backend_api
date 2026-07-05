# Spesifikasi Backend & REST API Portal Alumni UNUHA

Dokumen ini berisi rancangan arsitektur Backend, struktur Database (RDBMS), dan daftar *Endpoint* API yang dibutuhkan untuk membuat Backend yang berfungsi penuh melayani Frontend React yang telah dibuat.

---

## 1. Rekomendasi Tech Stack
- **Bahasa / Framework**: Laravel (PHP) atau Node.js (Express/NestJS)
- **Database**: MySQL atau PostgreSQL
- **Otentikasi**: JSON Web Token (JWT) atau Laravel Sanctum
- **Penyimpanan File**: AWS S3 atau *Local Storage* (Public Folder) untuk foto profil dan banner.

---

## 2. Struktur Database (Entity Relationship)

Berikut adalah tabel-tabel krusial yang wajib ada di database:

### A. Tabel `users` (Otentikasi & Akun)
Menyimpan kredensial login. Dipisah dari data profil.
- `id_users` (Primary Key, UUID/BigInt)
- `email` (String, Unique)
- `password` (String, Hashed)
- `role` (Enum: `'admin'`, `'alumni'`)
- `created_at`, `updated_at`

### B. Tabel `alumni_profiles` (Data Diri Mahasiswa)
- `id_alumni_profiles` (Primary Key)
- `user_id` (Foreign Key -> `users.id`)
- `nama_lengkap` (String)
- `nim` (String, Unique)
- `fakultas` (String)
- `program_studi` (String)
- `tahun_lulus` (Year/Int)
- `status_karir` (Enum: `'Bekerja'`, `'Lanjut Studi'`, `'Wirausaha'`, `'Belum Bekerja'`)
- `avatar_url` (String, Nullable)
- `telepon` (String, Nullable)
- `alamat_lengkap`, `provinsi`, `kota` (String, Nullable)
- `created_at`, `updated_at`

### C. Tabel `jobs` (Lowongan Pekerjaan)
- `id_jobs` (Primary Key)
- `posisi` (String)
- `perusahaan` (String)
- `tipe_pekerjaan` (Enum: `'Penuh Waktu'`, `'Paruh Waktu'`, `'Magang'`, `'Kontrak'`)
- `lokasi` (String)
- `gaji` (String, Nullable)
- `deskripsi` (Text)
- `persyaratan` (Text)
- `batas_waktu` (Date)
- `status` (Enum: `'Aktif'`, `'Tutup'`)
- `created_at`, `updated_at`

### D. Tabel `news` (Berita Kampus)
- `id_news` (Primary Key)
- `judul` (String)
- `slug` (String, Unique)
- `kategori` (Enum: `'Akademik'`, `'Karir'`, `'Acara'`)
- `konten` (Text)
- `gambar_url` (String, Nullable)
- `status` (Enum: `'Diterbitkan'`, `'Draf'`)
- `published_at` (Timestamp)

### E. Tabel `campus_info` (Info Kampus)
- `id_campus_info` (Primary Key)
- `judul` (String)
- `tipe` (Enum: `'Pengumuman'`, `'Panduan'`, `'Informasi'`)
- `konten` (Text)
- `status` (Enum: `'Aktif'`, `'Tidak Aktif'`)

### F. Tabel `web_settings` (Konten Web Dinamis)
Menyimpan pengaturan teks/gambar beranda (Hero Section).
- `key` (String, Unique) -> cth: `'hero_title'`, `'hero_desc'`, `'hero_image'`
- `value` (Text)

---

## 3. Daftar Endpoint REST API

Semua endpoint yang memerlukan login harus dilindungi oleh *Middleware Auth* (Validasi JWT/Token). Endpoint Admin harus divalidasi dengan *Middleware Role Admin*.

### 🔐 Otentikasi (Public)
| Method | Endpoint | Deskripsi | Request Body |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/auth/register` | Pendaftaran akun alumni baru | `email, password, password_confirmation` |
| `POST` | `/api/auth/login` | Login admin/alumni (Mengembalikan Token JWT) | `email, password` |
| `POST` | `/api/auth/logout` | Menghapus sesi/token aktif | (Header: Authorization) |
| `POST` | `/api/auth/forgot-password` | Request link reset sandi | `email` |

### 🎓 Endpoint Alumni (Membutuhkan Token: Role Alumni)
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/alumni/profile` | Mengambil data profil alumni yang sedang login |
| `PUT` | `/api/alumni/profile` | Memperbarui data profil (Nama, Alamat, Status Karir) |
| `POST` | `/api/alumni/avatar` | Mengunggah foto profil (Multipart Form Data) |
| `PUT` | `/api/settings/password` | Mengubah kata sandi |
| `GET` | `/api/notifications` | Mengambil daftar riwayat notifikasi alumni |

### 👔 Endpoint Publik (Data untuk Alumni yang Login)
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/jobs` | Mengambil daftar lowongan (Bisa difilter: `?search=x&type=y`) |
| `GET` | `/api/jobs/{id}` | Mengambil detail spesifik 1 lowongan |
| `GET` | `/api/news` | Mengambil daftar berita kampus (Bisa difilter) |
| `GET` | `/api/news/{id}` | Mengambil detail 1 berita |
| `GET` | `/api/info` | Mengambil info kampus / panduan |
| `GET` | `/api/web-settings` | Mengambil data Hero Banner (Judul, Teks, Gambar) |

### 🛠️ Endpoint Admin (Membutuhkan Token: Role Admin)
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/admin/dashboard/stats` | Mengambil rangkuman data (Total alumni, total lowongan) |
| `GET` | `/api/admin/alumni` | Mendapatkan semua data alumni (Tabel Admin) |
| `GET` | `/api/admin/alumni/{id}` | Melihat detail 1 alumni |
| `PUT` | `/api/admin/alumni/{id}` | Admin mengedit/mengoreksi data profil alumni |
| `DELETE` | `/api/admin/alumni/{id}` | Menghapus akun dan profil alumni |
| `POST` | `/api/admin/jobs` | Membuat lowongan baru |
| `PUT` | `/api/admin/jobs/{id}` | Mengedit data lowongan |
| `DELETE` | `/api/admin/jobs/{id}` | Menghapus lowongan |
| `POST` | `/api/admin/news` | Menambah berita baru |
| `PUT` | `/api/admin/news/{id}` | Mengedit berita |
| `DELETE` | `/api/admin/news/{id}` | Menghapus berita |
| `POST` | `/api/admin/info` | Menambah info kampus |
| `PUT` | `/api/admin/info/{id}` | Mengedit info kampus |
| `DELETE` | `/api/admin/info/{id}` | Menghapus info kampus |
| `PUT` | `/api/admin/web-settings` | Menyimpan perubahan Teks/Gambar halaman utama |

---

## 4. Panduan Integrasi ke Frontend
Setelah backend ini selesai dibuat, pengembang (*developer*) hanya perlu masuk ke Frontend React yang sudah kita buat, kemudian:
1. Membuat *file* `.env` dan mengisi `VITE_API_URL=http://localhost:8000/api`
2. Mengganti semua data statis (*dummy data* di dalam state `useState`) dengan pemanggilan `fetch` atau `axios` ke *Endpoint API* yang sesuai.
3. Menyimpan Token JWT di `localStorage` atau `cookies` saat berhasil Login, lalu menyertakannya di *Header Authorization* `Bearer <token>` pada setiap *request*.
