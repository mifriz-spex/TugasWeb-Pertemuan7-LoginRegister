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
    <title>Tugas Rutin 7 - Autentikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white h-screen flex items-center justify-center font-sans">
    
    <div class="bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-700 w-full max-w-sm text-center">
        <h1 class="text-3xl font-bold mb-2 text-rose-500">Tugas Rutin 7</h1>
        <p class="text-gray-400 mb-8 text-sm">Sistem Login & Register (PHP Native + JSON)</p>

        <div class="flex flex-col space-y-4">
            <a href="login.php" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                Masuk (Login)
            </a>
            <a href="register.php" class="w-full bg-gray-700 hover:bg-gray-600 text-gray-200 font-semibold py-2.5 rounded-lg transition duration-200 border border-gray-600">
                Daftar Akun Baru
            </a>
        </div>
    </div>

</body>
</html>