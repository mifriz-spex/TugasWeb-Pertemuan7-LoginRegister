<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MediCare System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'magang-green-dark': '#0d1f1b',
                        'magang-green-primary': '#166534', 
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-950 text-white min-h-screen font-sans p-6 flex items-start justify-center pt-20">
    
    <div class="bg-gray-900 w-full max-w-4xl rounded-2xl shadow-2xl border border-gray-800 overflow-hidden">
        
        <!-- Header Dashboard -->
        <div class="bg-magang-green-dark border-b border-gray-800 px-8 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-900/50 rounded-lg flex items-center justify-center border border-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-green-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Medi<span class="text-green-500">Care</span></h2>
                    <p class="text-xs text-gray-400">Panel Staf Medis</p>
                </div>
            </div>
            
            <a href="logout.php" class="bg-red-950/30 hover:bg-red-900/50 text-red-400 border border-red-900/50 px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                Keluar (Logout)
            </a>
        </div>

        <!-- Area Konten Utama -->
        <div class="p-8">
            <div class="mb-8 border-b border-gray-800 pb-6">
                <h3 class="text-2xl font-bold text-white mb-1">Selamat bertugas, <?= htmlspecialchars($user['nama']) ?>!</h3>
                <p class="text-gray-400 text-sm">Masuk sebagai: <span class="text-green-400"><?= htmlspecialchars($user['email']) ?></span></p>
            </div>

            <!-- Grid Menu Minimalis -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div class="bg-gray-950 border border-gray-800 p-5 rounded-xl hover:border-green-700 transition duration-200 group cursor-pointer">
                    <h4 class="text-lg font-semibold text-gray-200 mb-2 group-hover:text-green-400">Entitas Pasien</h4>
                    <p class="text-sm text-gray-500">Kelola pendaftaran rekam medis dan data personal pasien rawat inap.</p>
                </div>

                <div class="bg-gray-950 border border-gray-800 p-5 rounded-xl hover:border-green-700 transition duration-200 group cursor-pointer">
                    <h4 class="text-lg font-semibold text-gray-200 mb-2 group-hover:text-green-400">Alokasi Kamar</h4>
                    <p class="text-sm text-gray-500">Pantau relasi kamar, status ketersediaan bangsal, dan mutasi ruangan.</p>
                </div>

                <div class="bg-gray-950 border border-gray-800 p-5 rounded-xl hover:border-green-700 transition duration-200 group cursor-pointer">
                    <h4 class="text-lg font-semibold text-gray-200 mb-2 group-hover:text-green-400">Jadwal Dokter</h4>
                    <p class="text-sm text-gray-500">Penugasan tenaga medis terintegrasi berdasarkan spesialisasi.</p>
                </div>

                <div class="bg-gray-950 border border-gray-800 p-5 rounded-xl hover:border-green-700 transition duration-200 group cursor-pointer">
                    <h4 class="text-lg font-semibold text-gray-200 mb-2 group-hover:text-green-400">Log Evaluasi</h4>
                    <p class="text-sm text-gray-500">Tinjau laporan *trigger* sistem dan riwayat tindakan medis (ERD).</p>
                </div>

            </div>
        </div>

    </div>

</body>
</html>