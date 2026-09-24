<?php
session_start();

// BONUS: Mengecek Cookie "Remember Me"[cite: 1]
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_email'])) {
    $file_json = 'data/users.json';
    if (file_exists($file_json)) {
        $users = json_decode(file_get_contents($file_json), true) ?? [];
        foreach ($users as $user) {
            if (isset($user['email']) && $user['email'] === $_COOKIE['remember_email']) {
                $_SESSION['user'] = [
                    'nama' => $user['nama'],
                    'email' => $user['email']
                ];
                header("Location: dashboard.php");
                exit;
            }
        }
    }
}

// Jika sudah memiliki session login, langsung arahkan ke dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']); 

    if (empty($email) || empty($password)) {
        $error = 'Email dan kata sandi wajib diisi!';
    } else {
        $file_json = 'data/users.json';
        $login_berhasil = false;

        if (file_exists($file_json)) {
            $json_data = file_get_contents($file_json);
            $users = json_decode($json_data, true) ?? [];

            foreach ($users as $user) {
                if (isset($user['email']) && $user['email'] === $email) {
                    if (password_verify($password, $user['password'])) {
                        $login_berhasil = true;
                        
                        $_SESSION['user'] = [
                            'nama' => $user['nama'],
                            'email' => $user['email']
                        ];

                        if ($remember) {
                            setcookie('remember_email', $user['email'], time() + (7 * 24 * 60 * 60), "/");
                        }

                        header("Location: dashboard.php");
                        exit;
                    }
                }
            }
        }

        if (!$login_berhasil) {
            $error = 'Email atau kata sandi salah!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - MediCare System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { 'magang-green-dark': '#0d1f1b', 'magang-green-primary': '#166534', } } } }
    </script>
</head>
<body class="bg-gray-950 text-white min-h-screen font-sans flex items-center justify-center p-4">
    
    <div class="bg-gray-900 w-full max-w-6xl rounded-2xl shadow-2xl overflow-hidden flex flex-col lg:flex-row border border-gray-800">
        
        <!-- Panel Kiri: Form Login (Responsive Padding) -->
        <div class="w-full lg:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center bg-gray-950">
            
            <div class="flex items-center gap-3 mb-8 lg:mb-10">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-green-900/50 rounded-xl flex items-center justify-center border border-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 lg:w-8 lg:h-8 text-green-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-white">Medi<span class="text-green-500">Care</span></h1>
                    <p class="text-gray-400 text-xs lg:text-sm">Sistem Informasi Medis</p>
                </div>
            </div>

            <h2 class="text-3xl lg:text-4xl font-extrabold mb-2 text-white">Selamat Datang</h2>
            <p class="text-gray-400 mb-8 lg:mb-10 text-sm lg:text-base">Silakan masuk menggunakan email terdaftar.</p>

            <!-- Area Pesan Error (Ambil dari PHP) -->
            <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500 text-red-400 p-4 rounded-lg mb-6 text-sm">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-5 lg:space-y-6">
                <!-- Form input biarkan sama seperti sebelumnya -->
                <div class="relative">
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-white placeholder-gray-500" placeholder="nama@medicare.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div class="relative">
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-gray-300">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-white placeholder-gray-500" placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 lg:w-5 lg:h-5 text-green-600 bg-gray-800 border-gray-700 rounded-lg focus:ring-green-500 focus:ring-offset-gray-950">
                    <label for="remember" class="ml-3 text-sm text-gray-300">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="w-full bg-magang-green-primary hover:bg-green-700 text-white font-bold py-3.5 lg:py-4 rounded-xl transition duration-200 text-base lg:text-lg">
                    Masuk
                </button>
            </form>

            <p class="mt-8 lg:mt-12 text-center text-sm text-gray-400">
                Belum punya akun? <a href="register.php" class="text-green-500 hover:text-green-400 font-medium">Buat akun baru</a>
            </p>
        </div>

        <!-- Panel Kanan: Sembunyikan di HP (hidden), tampilkan di laptop (lg:flex) -->
        <div class="hidden lg:flex w-full lg:w-1/2 p-16 flex-col justify-end bg-magang-green-dark relative">
            <div class="absolute inset-0 p-10 flex items-center justify-center opacity-10">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-green-300">
                    <path fill="none" stroke="currentColor" stroke-width="4" d="M20,100 L60,100 L80,50 L120,150 L140,100 L180,100" />
                </svg>
            </div>
            
            <div class="relative z-10">
                <h3 class="text-3xl font-bold mb-4 text-white">Manajemen Data Rawat Inap Terintegrasi</h3>
                <p class="text-gray-300 text-lg leading-relaxed">
                    Akses cepat ke rekam medis pasien, penjadwalan dokter, dan manajemen ketersediaan kamar dalam satu sistem yang aman dan terpusat.
                </p>
            </div>
        </div>

    </div>

</body>
</html>