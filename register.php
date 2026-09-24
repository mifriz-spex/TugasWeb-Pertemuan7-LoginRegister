<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = htmlspecialchars(trim($_POST['nama'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? ''; 

    if (empty($nama) || empty($email) || empty($password)) {
        $error = 'Semua kolom wajib diisi!';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } else {
        $file_json = 'data/users.json';
        $users = [];

        if (!is_dir('data')) {
            mkdir('data', 0777, true);
        }

        if (file_exists($file_json)) {
            $json_data = file_get_contents($file_json);
            $users = json_decode($json_data, true) ?? [];
        }

        $email_exist = false;
        foreach ($users as $user) {
            if (isset($user['email']) && $user['email'] === $email) {
                $email_exist = true;
                break;
            }
        }

        if ($email_exist) {
            $error = 'Email sudah terdaftar. Silakan gunakan email lain atau masuk.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $users[] = [
                'nama' => $nama,
                'email' => $email,
                'password' => $hashed_password
            ];

            if (file_put_contents($file_json, json_encode($users, JSON_PRETTY_PRINT))) {
                $success = 'Registrasi berhasil! Silakan Masuk (Login).';
            } else {
                $error = 'Sistem gagal menyimpan data.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MediCare System</title>
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
<body class="bg-gray-950 text-white min-h-screen font-sans flex items-center justify-center p-4">
    
    <div class="bg-gray-900 w-full max-w-6xl rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row-reverse border border-gray-800">
        
        <!-- Panel Kanan (Form Registrasi diletakkan di sebelah kanan agar sedikit berbeda dari login) -->
        <div class="w-full md:w-1/2 p-10 md:p-14 flex flex-col justify-center bg-gray-950">
            
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-green-900/50 rounded-lg flex items-center justify-center border border-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-green-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Medi<span class="text-green-500">Care</span></h1>
            </div>

            <h2 class="text-3xl font-extrabold mb-2 text-white">Buat Akun Baru</h2>
            <p class="text-gray-400 mb-8">Daftarkan kredensial Anda untuk mengakses sistem.</p>

            <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500 text-red-400 p-4 rounded-lg mb-6 text-sm">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-500/10 border border-green-500 text-green-400 p-4 rounded-lg mb-6 text-sm">
                    <?= $success ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-5">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="w-full px-5 py-3 bg-gray-800 border border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-white placeholder-gray-500" placeholder="Nama Lengkap" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" class="w-full px-5 py-3 bg-gray-800 border border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-white placeholder-gray-500" placeholder="nama@medicare.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="w-full px-5 py-3 bg-gray-800 border border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-white placeholder-gray-500" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-magang-green-primary hover:bg-green-700 text-white font-bold py-4 rounded-xl transition duration-200 text-lg mt-4">
                    Daftar Akun
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-400">
                Sudah memiliki akun? <a href="login.php" class="text-green-500 hover:text-green-400 font-medium">Masuk di sini</a>
            </p>
        </div>

        <!-- Panel Kiri: Grafis & Deskripsi -->
        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-end bg-magang-green-dark relative">
            <div class="absolute inset-0 p-10 flex items-center justify-center opacity-10">
                <!-- Ikon Shield Medis Dekoratif -->
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-2/3 h-2/3 text-green-300" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    <path d="M9 12h6"></path>
                    <path d="M12 9v6"></path>
                </svg>
            </div>
            
            <div class="relative z-10">
                <h3 class="text-3xl font-bold mb-4 text-white">Bergabung dengan Tim Medis</h3>
                <p class="text-gray-300 text-lg leading-relaxed">
                    Daftarkan diri Anda untuk mendapatkan akses ke dalam ekosistem pengelolaan pasien yang terstruktur dan aman. Pastikan data yang dimasukkan valid untuk verifikasi administrator.
                </p>
            </div>
        </div>

    </div>

</body>
</html>