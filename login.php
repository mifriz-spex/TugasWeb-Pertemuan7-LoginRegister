<?php
session_start();

// BONUS: Mengecek Cookie "Remember Me"
// Jika session kosong tapi ada cookie remember_email, kita bantu login otomatis
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_email'])) {
    $file_json = 'data/users.json';
    if (file_exists($file_json)) {
        $users = json_decode(file_get_contents($file_json), true) ?? [];
        foreach ($users as $user) {
            if (isset($user['email']) && $user['email'] === $_COOKIE['remember_email']) {
                // Set session dan arahkan ke dashboard
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

$error = ''; // Inisialisasi variabel pesan error

// Menangani form saat tombol submit ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    // Mengecek apakah checkbox remember me dicentang
    $remember = isset($_POST['remember']); 

    if (empty($email) || empty($password)) {
        $error = 'Email dan kata sandi wajib diisi!';
    } else {
        $file_json = 'data/users.json';
        $login_berhasil = false;

        // Buka file JSON dan cari datanya[cite: 1]
        if (file_exists($file_json)) {
            $json_data = file_get_contents($file_json);
            $users = json_decode($json_data, true) ?? [];

            foreach ($users as $user) {
                // Jika email cocok
                if (isset($user['email']) && $user['email'] === $email) {
                    // Validasi kecocokan password_hash dengan password yang diinput
                    if (password_verify($password, $user['password'])) {
                        $login_berhasil = true;
                        
                        // Sistem login dengan session[cite: 1]
                        $_SESSION['user'] = [
                            'nama' => $user['nama'],
                            'email' => $user['email']
                        ];

                        // BONUS: Set cookie jika "Remember Me" dicentang[cite: 1]
                        if ($remember) {
                            // Cookie disimpan selama 7 hari (7 * 24 * 60 * 60 detik)
                            setcookie('remember_email', $user['email'], time() + (7 * 24 * 60 * 60), "/");
                        }

                        // Redirect ke dashboard
                        header("Location: dashboard.php");
                        exit;
                    }
                }
            }
        }

        // Pesan error jika loop selesai tapi $login_berhasil masih false[cite: 1]
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
    <title>Masuk - Tugas Rutin 7</title>
    <!-- Tampilan CSS yang rapi[cite: 1] -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white h-screen flex items-center justify-center font-sans">
    
    <div class="bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-700 w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Masuk ke Akun</h2>

        <!-- Area Pesan Error yang Jelas[cite: 1] -->
        <?php if ($error): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-400 p-3 rounded-lg mb-4 text-sm">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-sm text-gray-400 mb-1">Alamat Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div>
                <label for="password" class="block text-sm text-gray-400 mb-1">Kata Sandi</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white">
            </div>

            <!-- Bonus: "Remember Me" -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                <label for="remember" class="ml-2 text-sm text-gray-400">Ingat Saya (Remember Me)</label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200 mt-2">
                Masuk
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-400">
            Belum punya akun? <a href="register.php" class="text-blue-400 hover:underline">Daftar sekarang</a>
        </p>
    </div>

</body>
</html>