# TP7DPBO2026 - Course Management System (Sistem Manajemen Kursus)

Project ini dibuat untuk memenuhi Tugas Praktikum Modul 8 Mata Kuliah **Desain dan Pemrograman Berorientasi Objek (DPBO)**. Aplikasi berbasis web ini dibangun menggunakan **PHP Native dengan pendekatan Object-Oriented Programming (OOP)**, **PDO Prepared Statements**, dan struktur antarmuka **GUI modular**.

---

## 🙏 JANJI
Saya Irsyad Afif Musyaffa dengan NIM 2508023 mengerjakan Tugas Praktikum 7 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

---

## 📌 Penjelasan Tema Website
Sistem Manajemen Kursus (*Course Management System*) adalah aplikasi web yang dirancang untuk mengelola data operasional platform edukasi/kursus. Sistem ini memungkinkan administrator untuk mengelola data instruktur, data mahasiswa/siswa, katalog kursus, serta pendaftaran (*enrollment*) siswa ke kursus tertentu.

---

## 🗄️ Penjelasan Database (`db_course.sql`)
Database aplikasi terdiri dari 4 entitas (tabel) yang terorganisir dan berelasi menggunakan *Foreign Key*:

1. **`instructors`**: Menyimpan data instruktur/pengajar kursus.
   - `id` (PK), `name`, `email`, `expertise`
2. **`students`**: Menyimpan data siswa/peserta kursus.
   - `id` (PK), `name`, `email`, `phone`
3. **`courses`**: Menyimpan katalog kursus.
   - `id` (PK), `title`, `description`, `instructor_id` (FK -> `instructors.id`)
4. **`enrollments`**: Menyimpan data pendaftaran siswa ke kursus tertentu.
   - `id` (PK), `student_id` (FK -> `students.id`), `course_id` (FK -> `courses.id`), `enrollment_date`

---

## 🏗️ Struktur Project & Fungsi Direktori
Struktur direktori proyek disusun secara modular sesuai dengan prinsip OOP dan instruksi modul:

```text
TP7DPBO2526C/
├── class/                  # Menyimpan Class OOP untuk setiap entitas
│   ├── Course.php
│   ├── Enrollment.php
│   ├── Instructor.php
│   └── Student.php
├── config/                 # Konfigurasi aplikasi dan koneksi DB
│   └── db.php
├── database/               # File SQL skema dan data awal database
│   └── db_course.sql
├── view/                   # Antarmuka (GUI) dan elemen modular HTML
│   ├── header.php
│   ├── footer.php
│   ├── courses.php
│   ├── enrollments.php
│   ├── instructors.php
│   └── students.php
├── index.php               # Entry point aplikasi
├── style.css               # Styling tampilan (GUI)
└── README.md               # Dokumentasi project
```

---

## 🔄 Alur & Flow Kode Program
Aplikasi ini menerapkan **HTTP Request-Response Cycle** standar dengan abstraksi PDO:

1. **Client Request**: Pengguna membuka halaman atau mengirimkan *form action* (Create, Update, Delete) pada file antarmuka di direktori `view/`.
2. **Controller/Class Delegation**: File `view` memanggil metode (*method*) dari *object class* yang sesuai di dalam direktori `class/` (contoh: `Instructor::create()`, `Course::read()`).
3. **PDO Prepared Statements**: Seluruh operasi database diproses menggunakan **Prepared Statements** (`$db->prepare()`) untuk menjamin keamanan dari ancaman SQL Injection (tidak menggunakan *query* mentah langsung).
4. **Response**: Data hasil eksekusi dari database dikembalikan dalam bentuk array PHP oleh *Class*, kemudian dirender kembali oleh GUI `view/` untuk ditampilkan kepada pengguna.

---

## 📹 Dokumentasi Demonstrasi Aplikasi
*(Silakan lampirkan link video/screen record atau format GIF uji coba fitur CRUD semua tabel di sini)*

- **Screen Record Demo**: `[Link Screen Record / GIF]`

---
*Dibuat untuk Tugas Praktikum DPBO - UPI 2026*
