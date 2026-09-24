<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare System - Portal Medis</title>
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
<body class="bg-gray-950 text-white min-h-screen font-sans flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Dekorasi Latar Belakang -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-green-900/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-magang-green-dark rounded-full blur-3xl"></div>

    <div class="bg-gray-900/80 backdrop-blur-md p-10 rounded-2xl shadow-2xl border border-gray-800 w-full max-w-md text-center relative z-10">
        
        <!-- Logo -->
        <div class="w-16 h-16 bg-green-900/50 rounded-2xl flex items-center justify-center border border-green-700 mx-auto mb-6 shadow-lg shadow-green-900/20">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-green-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </div>
        
        <h1 class="text-3xl font-extrabold mb-2 text-white">Medi<span class="text-green-500">Care</span></h1>
        <p class="text-gray-400 mb-8 text-sm leading-relaxed">Portal Informasi Manajemen Rawat Inap & Alokasi Penugasan Medis.</p>

        <div class="flex flex-col space-y-4">
            <a href="login.php" class="w-full bg-magang-green-primary hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition duration-200 shadow-lg shadow-green-900/30">
                Masuk (Login)
            </a>
            <a href="register.php" class="w-full bg-transparent hover:bg-gray-800 text-gray-300 font-semibold py-3.5 rounded-xl transition duration-200 border border-gray-700 hover:border-gray-600">
                Daftar Akun Baru
            </a>
        </div>
    </div>

</body>
</html>