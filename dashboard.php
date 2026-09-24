<?php
session_start();

// Cek apakah session user tersedia. Jika tidak ada, redirect ke login.php
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit; // Pastikan script berhenti dieksekusi setelah redirect
}

// Mengambil data user dari session yang kita set di login.php
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tugas Rutin 7</title>
    <!-- Bonus: Tampilan CSS yang rapi[cite: 1] -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white h-screen flex items-center justify-center font-sans">
    
    <div class="bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-700 w-full max-w-md text-center">
        
        <!-- Avatar Inisial Sederhana -->
        <div class="w-20 h-20 bg-blue-600 rounded-full mx-auto flex items-center justify-center text-3xl font-bold mb-4 shadow-lg text-white">
            <?= strtoupper(substr($user['nama'], 0, 1)) ?>
        </div>
        
        <h2 class="text-2xl font-bold mb-1">Selamat datang, <?= htmlspecialchars($user['nama']) ?>!</h2>
        <p class="text-gray-400 text-sm mb-6"><?= htmlspecialchars($user['email']) ?></p>

        <div class="bg-gray-700 rounded-lg p-4 mb-6 text-left border border-gray-600">
            <h3 class="text-sm font-semibold text-rose-400 mb-2">📌 Status Keamanan</h3>
            <p class="text-sm text-gray-300">Ini adalah halaman dashboard yang diproteksi. Hanya pengguna terautentikasi yang dapat melihat konten ini.</p>
        </div>

        <a href="logout.php" class="inline-block w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg transition duration-200">
            Keluar (Logout)
        </a>
    </div>

</body>
</html>