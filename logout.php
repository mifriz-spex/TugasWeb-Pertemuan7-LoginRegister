<?php
// Mulai session agar kita bisa mengakses dan menghapusnya
session_start();

// Hapus semua data yang ada di dalam session
session_unset();

// Hancurkan session sepenuhnya
session_destroy();

// BONUS: Hapus cookie "Remember Me" jika ada
// Caranya adalah dengan mengatur ulang cookie yang sama, tapi dengan waktu kedaluwarsa di masa lalu (misal: time() - 3600)
if (isset($_COOKIE['remember_email'])) {
    setcookie('remember_email', '', time() - 3600, "/");
}

// Arahkan pengguna kembali ke halaman utama (index.php) atau halaman login
header("Location: index.php");
exit;
